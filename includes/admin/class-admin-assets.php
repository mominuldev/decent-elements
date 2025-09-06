<?php

/**
 * Handle backend scripts
 *
 * @since     1.0.0
 */

defined('ABSPATH') || exit;

class Admin_Assets
{
	public function __construct()
	{
		add_action('admin_enqueue_scripts', array(__CLASS__, 'admin_enqueue_scripts'), 10, 1);
	}

//    function admin_enqueue_scripts($hook) {
//
//    }

	/**
	 * Enqueue Backend Scripts
	 *
	 * @since 1.0.0
	 */
	public static function admin_enqueue_scripts()
	{
		$currentScreen = get_current_screen();
		$screenID = $currentScreen->id;

		if ($screenID === "toplevel_page_decent_elements") {
			$apiNonce = wp_create_nonce('wp_rest');
			$root = rest_url(DECENT_ELEMENTS_REST_API_ROUTE . '/');
			$baseUrl = DECENT_ELEMENTS_URL; // can be used for assets

			if (defined('DECENT_ELEMENTS_DEV') && DECENT_ELEMENTS_DEV) {
				wp_enqueue_script_module('vite-plugin-react', 'http://localhost:5178/src/main.js', array(), time());

				?>
<script>
window.decentElements = {
	nonce: '<?php echo $apiNonce; ?>',
	apiUrl: '<?php echo $root; ?>',
	baseUrl: '<?php echo $baseUrl; ?>',
}
</script>
<script type="module">
import RefreshRuntime from "http://localhost:5178/@react-refresh"
RefreshRuntime.injectIntoGlobalHook(window)
window.$RefreshReg$ = () => {}
window.$RefreshSig$ = () => (type) => type
window.__vite_plugin_react_preamble_installed__ = true
</script>
<script type="module" src="http://localhost:5178/@vite/client"></script>
<script type="module" src="http://localhost:5178/src/main.jsx"></script>
<?php
			} else {
				wp_enqueue_script('decent-elements-backend', DECENT_ELEMENTS_URL . 'includes/admin/assets/js/index.js', array('wp-i18n'), DECENT_ELEMENTS_VERSION, true);
				wp_localize_script(
					'decent-elements-backend',
					'decentElements',
					array(
						'nonce'     => $apiNonce,
						'apiUrl'    => $root,
						'baseUrl'   => $baseUrl,
					)
				);
			}
		}

		// if (defined('DECENT_ELEMENTS_DEV') && !DECENT_ELEMENTS_DEV) {
			wp_enqueue_style('decent-elements-admin', DECENT_ELEMENTS_URL . 'assets/css/admin.css', array(), DECENT_ELEMENTS_VERSION);
		// }
	}
}

new Admin_Assets();