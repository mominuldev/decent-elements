# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

A WordPress plugin providing Elementor widgets and extensions. The repo root is the plugin folder itself, living inside a full WordPress install (`/Volumes/Development/Sites/decent-elements/`), served locally (browser-sync proxies `https://bizzcrave.test/`). There are no automated tests.

There are two separate build systems with their own `package.json`:

## Commands

**Frontend assets (gulp, run from plugin root):**
- `npm run dev` — watch + browser-sync; compiles `src/sass/*.scss` → `assets/frontend/css` and `src/js` → `assets/frontend/js`
- `npm run build` — production build (`gulp build --prod`)
- `npm run zip` — build pot file + package plugin zip into `build/`
- Note: the root `package.json` metadata (name `bizzcrave-core`, textdomain, prefixes) is inherited from a ThemeCrave boilerplate and does not match this plugin — don't trust it for naming; the real textdomain is `decent-elements`.

**React admin app (Vite, run from `includes/Admin/backend/`):**
- `npm run dev` — Vite dev server on port **5178** (hardcoded in both `vite.config.js` and `includes/Admin/Admin_Assets.php`)
- `npm run build` — bundles to a single IIFE (`index.js`) output to `includes/Admin/assets/js/`
- `npm run lint` — ESLint

To develop the admin app with HMR, set the `DECENT_ELEMENTS_DEV` constant to `true` in `decent-elements.php` — it switches `Admin_Assets.php` from enqueueing the built bundle to loading from the Vite dev server. Set it back to `false` for production.

## Architecture

**Bootstrap:** `decent-elements.php` is the entry point — a `Decent_Elements` singleton that defines constants (`DECENT_ELEMENTS_URL`, `DECENT_ELEMENTS_PATH`, `DECENT_ELEMENTS_REST_API_ROUTE = 'decent-elements/v1'`, etc.), and wires everything up. `autoloader.php` maps the `Decent_Elements\` namespace to `includes/` (PSR-4 style, namespace path = directory path). Widget and extension classes are NOT namespaced/autoloaded — they are plain global classes loaded via `require_once` by their managers.

**Widget system:** `includes/Widget_Manager.php` holds a hardcoded registry array (`$widgets`) mapping widget id → name, class, file, default-enabled flag. On `elementor/widgets/widgets_registered` it loads each enabled widget file from `includes/Widgets/` and registers the class with Elementor. Enable/disable state is stored in the `decent_elements_widget_settings` option. Widget classes extend `\Elementor\Widget_Base` and go in `includes/Widgets/<name>.php`. To add a widget: create the file, add a registry entry in `Widget_Manager`, and add it to the admin UI data in `includes/Admin/backend/src/data/widgets.json`. Widgets register under the `decent-elements` Elementor category (prepended to the category list in the bootstrap file).

**Extension system:** `includes/Extension_Manager.php` (class `Decent_Elements_Extension_Manager`, manually required in bootstrap) mirrors the widget system: registry array, files in `includes/extensions/`, state in the `decent_elements_extension_settings` option, enabled extensions loaded on `init`. Documented in `EXTENSIONS.md` (some file paths in it are outdated).

**Admin panel:** React 19 + Vite + Tailwind 4 + Radix/shadcn-style components (`components.json`) SPA at `includes/Admin/backend/`, mounted on the `toplevel_page_decent_elements` admin page (`Admin_Menu.php` / `Admin_Assets.php`). PHP injects a `window.decentElements` global (`nonce`, `apiUrl`, `baseUrl`); the app talks to the REST API in `includes/Admin/Admin_Panel_API.php`, which registers routes under `decent-elements/v1` for settings, widgets, extensions, features, and asset optimization. Pages live in `src/Pages/` (Widgets, Extensions, Optimizer, Settings, etc.), with `@` aliased to `src/`.

**Asset optimizer:** `includes/Admin/optimizer/Asset_Minifier_Manager.php` (singleton), controlled through the `/optimization/*` REST endpoints and the Optimizer admin page.

**Frontend/widget assets:** registered in the bootstrap file on `elementor/frontend/after_register_scripts` with `de-` handle prefixes, from `assets/widgets/{css,js}/` and `assets/{css,js}/`; enqueued only when the current post is built with Elementor.

## Gotchas

- Path casing is inconsistent: directories are `includes/Widgets`, `includes/Admin`, but several `require`/enqueue paths use lowercase (`includes/widgets/`, `includes/admin/assets/js/index.js`). This works on macOS's case-insensitive filesystem but would break on Linux — match existing casing carefully and prefer the actual directory casing in new code.
- The Vite build outputs IIFE format deliberately (ES module globals would clash with WordPress globals) — don't change `format` or the no-hash output filenames in `vite.config.js`.
- `node_modules/` at the plugin root is partially tracked in git history (recent commits removed `includes/Admin/backend/node_modules` from tracking); avoid committing anything under `node_modules/`.
