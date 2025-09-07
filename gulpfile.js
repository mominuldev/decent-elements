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
const argv = yargs.argv || {};
const PRODUCTION = argv.prod;
const NOSOURCE = argv.nosours;

const paths = {
    styles: {
        src: ['src/sass/*.scss'],
        dest: `assets/frontend/css`
    },
    scripts: {
        src: 'src/js/**/*.js',
        dest: 'assets/frontend/js'
    },
    package: {
        src: [
            '**/*', '!.vscode', '!node_modules{,/**}', '!build{,/**}',
            '!assets{,/css/app.css.map}', '!src{,/**}','!.gitignore',
            '!gulpfile.js', '!woocommerce.css', '!woocommerce.css.map','!package.json', '!package-lock.json'
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

const styles = () => {
    return gulp.src(paths.styles.src)
        .pipe(gulpif(!PRODUCTION, sourcemaps.init())) // For map
        .pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError))
        // .pipe(autoprefixer({
        //     overrideBrowserslist: ['last 2 versions'],
        //     cascade: false
        // }))
        // .pipe(cleanCSS({ compatibility: 'ie11' })) //Enable to minify
        .pipe(gulpif(PRODUCTION && !NOSOURCE, cleanCSS({ compatibility: 'ie11' }))) //Enable to minify
        // .pipe(rename({
        //     suffix: '.min'
        // }))
        // .pipe(gulpif(PRODUCTION, rename({
        //     suffix: '.min'
        // })))

        // .pipe(rename({ dirname: '' })) // Remove folder structure
        .pipe(gulpif(!PRODUCTION, sourcemaps.write('.'))) // For map
        .pipe(gulp.dest(paths.styles.dest))
        .pipe(browserSync.stream());
}

const scripts = () => {
    return gulp.src(paths.scripts.src, { base: 'src' })
        // .pipe(rename({
        //     suffix: '.min'
        // }))
        .pipe(gulpif(PRODUCTION, rename({
            suffix: '.min'
        })))
        .pipe(rename({ dirname: '' })) // Remove folder structure
        // .pipe(uglify())
        .pipe(gulpif(PRODUCTION && !NOSOURCE, uglify())) //Enable to minify
        .pipe(gulp.dest(paths.scripts.dest));
}

const watch = () => {
    gulp.watch('src/sass/**/*.scss', styles);
    gulp.watch('src/js/**/*.js', gulp.series(scripts, reload)); // Watch JS files
    gulp.watch('**/*.php', reload);
}

const clean = () => del([paths.package.dest, paths.scripts.dest]);

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

const dev = gulp.series(clean, gulp.parallel(styles, scripts), watch);
const bundle = gulp.series(clean, compress);
module.exports = {
    dev,
    bundle,
    compress,
    default: dev
};

