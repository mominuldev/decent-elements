const gulp = require('gulp');
const yargs = require('yargs');
const sass = require('gulp-sass')(require('sass'));
const sourcemaps = require('gulp-sourcemaps');
const del = require('del');
const browserSync = require('browser-sync').create();
const gulpif = require('gulp-if');
const zip = require('gulp-zip');
const replace = require('gulp-replace');
const rename = require('gulp-rename');
const uglify = require('gulp-uglify');
const cleanCSS = require('gulp-clean-css');
const info = require('./package.json');

// Read the flags straight from process.argv rather than via `yargs.argv`.
// yargs v18 no longer exposes a synchronous `.argv` getter on the module export
// — it evaluates to undefined — so PRODUCTION was silently always false and
// `gulp build --prod` shipped unminified CSS with sourcemaps.
const PRODUCTION = process.argv.includes('--prod');
const NOSOURCE = process.argv.includes('--nosours') || process.argv.includes('--nosource');

/**
 * Frontend asset groups.
 *
 * Sources live in `src-assets/`; compiled output goes to `assets/`, which is
 * what ships and what Core\Asset_Registry reads.
 *
 * Each widget and extension gets its OWN output file rather than a bundle,
 * because Elementor enqueues them per widget via get_style_depends() — bundling
 * would defeat the conditional loading. That file-to-file shape is why this
 * pipeline stays on gulp rather than moving to Vite: Vite is a bundler, and the
 * admin SPA (which genuinely wants bundling) already uses it.
 *
 * Output paths are deliberately uniform — widgets under assets/widgets/,
 * extensions under assets/extensions/. The plugin previously kept some widget
 * assets in assets/ and zero-byte duplicates in assets/widgets/, which is how
 * the optimizer ended up bundling empty files.
 */
const STYLE_GROUPS = [
    { src: 'src-assets/scss/widgets/*.scss', dest: 'assets/widgets/css' },
    { src: 'src-assets/scss/extensions/*.scss', dest: 'assets/extensions/css' },
    { src: 'src-assets/scss/global/*.scss', dest: 'assets/css' }
];

const SCRIPT_GROUPS = [
    { src: 'src-assets/js/widgets/*.js', dest: 'assets/widgets/js' },
    { src: 'src-assets/js/extensions/*.js', dest: 'assets/extensions/js' }
];

const paths = {
    styles: {
        watch: 'src-assets/scss/**/*.scss'
    },
    scripts: {
        watch: 'src-assets/js/**/*.js'
    },
    package: {
        // NOTE: `src/` is the plugin's PHP source (PSR-4 root) since the Phase 1
        // restructure — it MUST ship. It used to be an empty gulp asset folder,
        // and the old '!src{,/**}' exclusion would now omit every PHP file from
        // the built zip. Frontend asset sources live in `src-assets/`.
        //
        // `vendor/` MUST ship too: Composer provides the autoloader and the
        // minify library at runtime. Run `composer install --no-dev -o` before
        // packaging so dev tooling is not bundled.
        src: [
            '**/*',
            // Build + dependency noise
            '!node_modules{,/**}', '!build{,/**}', '!.vite{,/**}',
            // Frontend asset sources (compiled output under assets/ does ship)
            '!src-assets{,/**}',
            // Admin app sources (built bundle under src/Admin/assets/ does ship)
            '!src/Admin/backend{,/**}',
            // Developer tooling — never shipped
            '!composer.json', '!composer.lock', '!package.json', '!package-lock.json',
            '!gulpfile.js', '!phpcs.xml.dist', '!phpstan.neon.dist', '!phpstan.neon',
            '!stubs{,/**}', '!tools{,/**}', '!docs{,/**}', '!.github{,/**}',
            '!.vscode{,/**}', '!.gitignore', '!.gitattributes', '!CLAUDE.md',
            // Stray artefacts
            '!assets/css/app.css.map', '!woocommerce.css', '!woocommerce.css.map'
        ],
        dest: 'build'
    }
};

const serve = (done) => {
    browserSync.init({
        proxy: `${info.server}/`
    });
    done()
}
const reload = (done) => {
    browserSync.reload();
    done();
}

/**
 * Compile one SCSS group.
 *
 * Output filenames match their source, so `heading.scss` becomes `heading.css`
 * and Core\Asset_Registry finds it. No `.min` suffix and no content hash —
 * cache busting is the plugin version on the `?ver=` query arg, which is the
 * same convention the admin app's Vite config follows.
 */
const styleGroup = ({ src, dest }) => {
    const task = () => gulp.src(src, { allowEmpty: true })
        .pipe(gulpif(!PRODUCTION, sourcemaps.init()))
        .pipe(sass({ outputStyle: PRODUCTION ? 'compressed' : 'expanded' }).on('error', sass.logError))
        .pipe(gulpif(PRODUCTION && !NOSOURCE, cleanCSS()))
        .pipe(gulpif(!PRODUCTION, sourcemaps.write('.')))
        .pipe(gulp.dest(dest))
        .pipe(browserSync.stream());

    task.displayName = `styles:${dest}`;
    return task;
};

/** Compile one JS group. */
const scriptGroup = ({ src, dest }) => {
    const task = () => gulp.src(src, { allowEmpty: true })
        .pipe(gulpif(PRODUCTION && !NOSOURCE, uglify()))
        .pipe(gulp.dest(dest));

    task.displayName = `scripts:${dest}`;
    return task;
};

const styles = gulp.parallel(...STYLE_GROUPS.map(styleGroup));
const scripts = gulp.parallel(...SCRIPT_GROUPS.map(scriptGroup));

const watch = () => {
    gulp.watch(paths.styles.watch, styles);
    gulp.watch(paths.scripts.watch, gulp.series(scripts, reload));
    gulp.watch(['**/*.php', '!node_modules/**', '!vendor/**'], reload);
}

// Only the build directory is cleaned. Compiled assets are overwritten in place
// so a stale delete can never leave the plugin without its stylesheets.
const clean = () => del([paths.package.dest]);

const compress = () => {
    return gulp.src(paths.package.src)
        .pipe(replace('_themename', info.themename)) //ThemeName
        .pipe(replace('_pltdomain', info.textdomain))
        .pipe(replace('_CONSTANT', info.constant))
        .pipe(replace('_fprefix_', info.function_prefix))//Same as theme function prefix
        .pipe(replace('_panelsubslug_', info.sub_panel_slug))
        .pipe(replace('themeclassname', info.themeclassname))
        .pipe(replace('_plname', info.elementorplname))
        .pipe(replace('_elplwithoutspacename', info.elplwithoutspacename))
        .pipe(replace('_namespaceel', info.elementornamespace))
        .pipe(replace('_plurl', info.elementorpluginurl))
        .pipe(replace('_plversion', info.elementorpluginversion))
        .pipe(replace('_plauthor', info.elementorplauthor))
        .pipe(replace('_plofauthorurl', info.elementorplauthorurl))
        .pipe(replace('_pllicense', info.elementorpllicence))
        .pipe(zip(`${info.name}.zip`))
        .pipe(gulp.dest(paths.package.dest))
        .on('end', () => {
            console.log(`Zip file created: ${info.name}.zip in ${paths.package.dest}`);
        });
}

// `build` and `prod` are referenced by package.json scripts but were never
// defined as gulp tasks, so `npm run build` and `npm run prod` both failed with
// "Task never defined".
const build = gulp.parallel(styles, scripts);
const dev = gulp.series(build, gulp.parallel(serve, watch));
const bundle = gulp.series(clean, build, compress);

module.exports = {
    build,
    prod: build,
    dev,
    styles,
    scripts,
    bundle,
    compress,
    clean,
    default: dev
};

