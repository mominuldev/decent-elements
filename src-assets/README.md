# Frontend asset sources

Sources live here. **Never edit files under `assets/` — they are build output and
are overwritten.**

```
src-assets/scss/widgets/<id>.scss      ->  assets/widgets/css/<id>.css
src-assets/scss/extensions/<id>.scss   ->  assets/extensions/css/<id>.css
src-assets/scss/global/<name>.scss     ->  assets/css/<name>.css
src-assets/js/widgets/<id>.js          ->  assets/widgets/js/<id>.js
src-assets/js/extensions/<id>.js       ->  assets/extensions/js/<id>.js
```

`<id>` is the module id from `Core\Module_Manager` — `heading`, `custom-cursor`,
and so on. Matching the id is what lets `Core\Asset_Registry` find the output.

## Commands

| Command | Effect |
|---|---|
| `npm run dev` | Watch + browser-sync. Expanded CSS, sourcemaps. |
| `npm run build` | One-off dev build. |
| `npm run prod` | Minified, no sourcemaps. Run before packaging. |
| `npm run zip` | Production build + plugin zip into `build/`. |

## Adding assets to a module

1. Create `src-assets/scss/widgets/my-widget.scss` (and/or the `js/` equivalent).
2. Declare it on the module in `src/Core/Module_Manager.php`:

   ```php
   array(
       'css' => array( 'assets/widgets/css/my-widget.css' ),
       'js'  => array( 'assets/widgets/js/my-widget.js' ),
       // Optional; scripts default to array( 'jquery' ).
       'deps' => array( 'js' => array( 'gsap' ) ),
   )
   ```
3. Run a build.

Widgets pull their handle in automatically through `Abstract_Widget`, so Elementor
enqueues the file only on pages where the widget is used. Extension assets are
enqueued by `Asset_Registry` on Elementor-built pages.

## Notes

- **Empty output is skipped.** `Asset_Registry` ignores files that are missing or
  zero bytes, so declaring an asset before writing it is harmless. This is also
  the guard against the class of bug where the optimizer bundled empty
  placeholder files and served them in place of the real stylesheets.
- **No content hashing.** Cache busting is the plugin version on `?ver=`, matching
  the convention the admin app's Vite config already follows.
- **Third-party libraries** live in `assets/vendors/` and are not built. They are
  registered by `Asset_Registry::register_vendor_assets()` — `gsap` and
  `gsap-scroll-trigger` today. Declare them via a module's `deps`.
- `global/feature-pages.scss` is currently **orphaned** — it builds, but no module
  declares it and nothing enqueues it. Either wire it to a module or delete it.
