<?php

namespace Decent_Elements\Admin;

/**
 * Handle backend scripts
 * @since     1.0.0
 */

defined('ABSPATH') || exit;

if (!class_exists('\Decent_Elements\\Admin\\Admin_Assets')) {

	class Admin_Assets
	{
		/**
		 * Screen ID of the plugin's admin page.
		 */
		const SCREEN_ID = 'toplevel_page_decent_elements';

		/**
		 * Vite dev server port. Must match `server.port` in
		 * src/Admin/backend/vite.config.js.
		 */
		const DEV_SERVER_PORT = 5178;

		public function __construct()
		{
			add_action('admin_enqueue_scripts', array(__CLASS__, 'admin_enqueue_scripts'), 10, 1);
		}

		/**
		 * Enqueue Backend Scripts
		 * @since 1.0.0
		 */
		public static function admin_enqueue_scripts()
		{
			$current_screen = get_current_screen();

			if ($current_screen && self::SCREEN_ID === $current_screen->id) {
				if (defined('DECENT_ELEMENTS_DEV') && DECENT_ELEMENTS_DEV) {
					self::enqueue_dev_bundle();
				} else {
					self::enqueue_built_bundle();
				}
			}

			wp_enqueue_style('decent-elements-admin', DECENT_ELEMENTS_URL . 'assets/css/admin.css', array(), DECENT_ELEMENTS_VERSION);
		}

		/**
		 * Data exposed to the admin app as `window.decentElements`.
		 *
		 * @since 1.0.0
		 * @return array
		 */
		private static function get_app_data()
		{
			return array(
				'nonce'   => wp_create_nonce('wp_rest'),
				'apiUrl'  => esc_url_raw(rest_url(DECENT_ELEMENTS_REST_API_ROUTE . '/')),
				'baseUrl' => esc_url_raw(DECENT_ELEMENTS_URL),
			);
		}

		/**
		 * The `window.decentElements` assignment, safely encoded.
		 *
		 * wp_json_encode() escapes for a JavaScript context, which raw echo of
		 * the nonce and URLs did not.
		 *
		 * @since 1.0.0
		 * @return string
		 */
		private static function get_app_data_script()
		{
			return 'window.decentElements = ' . wp_json_encode(self::get_app_data()) . ';';
		}

		/**
		 * Enqueue the production IIFE bundle built by Vite.
		 *
		 * @since 1.0.0
		 */
		private static function enqueue_built_bundle()
		{
			wp_enqueue_script(
				'decent-elements-backend',
				DECENT_ELEMENTS_URL . 'src/Admin/assets/js/index.js',
				array('wp-i18n'),
				DECENT_ELEMENTS_VERSION,
				true
			);

			wp_add_inline_script('decent-elements-backend', self::get_app_data_script(), 'before');
		}

		/**
		 * Load the app from the Vite dev server with React Fast Refresh.
		 *
		 * The module tags are printed directly because WordPress cannot enqueue
		 * cross-origin ES modules from a dev server. Phase 4 of the
		 * modernization plan replaces this with an env-driven loader.
		 *
		 * @since 1.0.0
		 */
		private static function enqueue_dev_bundle()
		{
			$origin = 'http://localhost:' . self::DEV_SERVER_PORT;

			printf(
				'<script>%s</script>',
				self::get_app_data_script()
			);
			?>
			<script type="module">
				import RefreshRuntime from "<?php echo esc_url($origin); ?>/@react-refresh"

				RefreshRuntime.injectIntoGlobalHook(window)
				window.$RefreshReg$ = () => {
				}
				window.$RefreshSig$ = () => (type) => type
				window.__vite_plugin_react_preamble_installed__ = true
			</script>
			<script type="module" src="<?php echo esc_url($origin . '/@vite/client'); ?>"></script>
			<script type="module" src="<?php echo esc_url($origin . '/src/main.jsx'); ?>"></script>
			<?php
		}
	}

}
