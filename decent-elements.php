<?php
/**
 * Plugin Name: Decent Elements
 * Description: A collection of Elementor widgets and addons to enhance your website.
 * Version: 1.0.0
 * Author: Decent Elements
 * Author URI: https://decentelements.com
 * Text Domain: decent-elements
 * Domain Path: /languages
 * Requires at least: 5.9
 * Tested up to: 6.1
 * Requires PHP: 7.3
 */

use Decent_Elements\Admin\Admin_Assets;
use Decent_Elements\Admin\Admin_Menu;
use Decent_Elements\Admin\Admin_Panel_API;
use Decent_Elements\Widget_Manager;

defined('ABSPATH') || exit;

/**
 * Defining plugin constants.
 *
 * @since 3.0.0
 */
//define('EAEL_PLUGIN_FILE', __FILE__);
//define('EAEL_PLUGIN_BASENAME', plugin_basename(__FILE__));
define('DECENT_ELEMENTS_PATH', trailingslashit(plugin_dir_path(__FILE__)));
//define('EAEL_PLUGIN_URL', trailingslashit(plugins_url('/', __FILE__)));
//define('EAEL_PLUGIN_VERSION', '6.3.1');
//define('EAEL_ASSET_PATH', wp_upload_dir()['basedir'] . '/essential-addons-elementor');
//define('EAEL_ASSET_URL', wp_upload_dir()['baseurl'] . '/essential-addons-elementor');
/**
 * Including composer autoloader globally.
 *
 * @since 3.0.0
 */
require_once DECENT_ELEMENTS_PATH . 'autoloader.php';

final class Decent_Elements
{
	private static $instance;

	private $version = '1.0.0';

	private function __construct()
	{
		$this->define_constants();
		$this->includes();
	}

	/**
	 * Include required files
	 * @since 1.0
	 */
	private function includes()
	{
		if (is_admin()) {
			new Admin_Menu();
			new Admin_Assets();
		}
		Admin_Panel_API::instance();

		// Initialize Elementor widgets
		add_action('plugins_loaded', [$this, 'init_elementor']);
		
		// Initialize Extension Manager
		require_once DECENT_ELEMENTS_PATH . 'includes/Extension_Manager.php';

		
		// Enqueue frontend assets
		add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_assets']);
		add_action('elementor/frontend/after_register_scripts', [$this, 'register_elementor_assets']);
	}
	/**
	 * Define Plugin Constants.
	 * @since 1.0
	 */
	private function define_constants()
	{
		$this->define('DECENT_ELEMENTS_DEV', true);
		$this->define('DECENT_ELEMENTS_REST_API_ROUTE', 'decent-elements/v1');
		$this->define('DECENT_ELEMENTS_URL', plugin_dir_url(__FILE__));
		$this->define('DECENT_ELEMENTS_PATH', trailingslashit(plugin_dir_path(__FILE__)));
		$this->define('DECENT_ELEMENTS_ABSPATH', dirname(__FILE__) . '/');
		$this->define('DECENT_ELEMENTS_VERSION', $this->get_version());
		// Assets
		$this->define('DECENT_ELEMENTS_ASSETS_URL', DECENT_ELEMENTS_URL . 'assets/');
	}

	/**
	 * Returns Plugin version for global
	 * @since  1.0
	 */
	private function get_version()
	{
		return $this->version;
	}

	/**
	 * Initialize Elementor
	 * @since 1.0.0
	 */
	public function init_elementor()
	{
		// Check if Elementor is installed and activated
		if (!did_action('elementor/loaded')) {
			add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
			return;
		}

		// Check for required Elementor version
		if (!version_compare(ELEMENTOR_VERSION, '3.0.0', '>=')) {
			add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
			return;
		}

		// Check for required PHP version
		if (version_compare(PHP_VERSION, '7.3', '<')) {
			add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
			return;
		}

		// Register widget category
		add_action('elementor/elements/categories_registered', [$this, 'add_elementor_widget_categories']);

		// Initialize widget manager
		Widget_Manager::instance();
	}

	/**
	 * Admin notice for missing Elementor
	 * @since 1.0.0
	 */
	public function admin_notice_missing_main_plugin()
	{
		if (isset($_GET['activate'])) unset($_GET['activate']);

		$message = sprintf(
			esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'decent-elements'),
			'<strong>' . esc_html__('Decent Elements', 'decent-elements') . '</strong>',
			'<strong>' . esc_html__('Elementor', 'decent-elements') . '</strong>'
		);

		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
	}

	/**
	 * Admin notice for minimum Elementor version
	 * @since 1.0.0
	 */
	public function admin_notice_minimum_elementor_version()
	{
		if (isset($_GET['activate'])) unset($_GET['activate']);

		$message = sprintf(
			esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'decent-elements'),
			'<strong>' . esc_html__('Decent Elements', 'decent-elements') . '</strong>',
			'<strong>' . esc_html__('Elementor', 'decent-elements') . '</strong>',
			'3.0.0'
		);

		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
	}

	/**
	 * Admin notice for minimum PHP version
	 * @since 1.0.0
	 */
	public function admin_notice_minimum_php_version()
	{
		if (isset($_GET['activate'])) unset($_GET['activate']);

		$message = sprintf(
			esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'decent-elements'),
			'<strong>' . esc_html__('Decent Elements', 'decent-elements') . '</strong>',
			'<strong>' . esc_html__('PHP', 'decent-elements') . '</strong>',
			'7.3'
		);

		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
	}

	/**
	 * Add Elementor widget categories
	 * @since 1.0.0
	 */
	public function add_elementor_widget_categories($elements_manager)
	{
		$elements_manager->add_category(
			'decent-elements',
			[
				'title' => esc_html__('Decent Elements', 'decent-elements'),
				'icon' => 'fa fa-plug',
			]
		);
	}

	/**
	 * Enqueue frontend assets
	 * @since 1.0.0
	 */
	public function enqueue_frontend_assets()
	{
		// Check if Elementor is active and we have Elementor content
		if (class_exists('\Elementor\Plugin')) {
			global $post;
			if ($post && \Elementor\Plugin::$instance->documents->get($post->ID)->is_built_with_elementor()) {
				$this->enqueue_widget_assets();
			}
		}
	}

	/**
	 * Register assets for Elementor
	 * @since 1.0.0
	 */
	public function register_elementor_assets()
	{
		// Register animated testimonials assets
		wp_register_style(
			'de-animated-testimonials',
			plugin_dir_url(__FILE__) . 'assets/css/animated-testimonials.css',
			[],
			$this->version
		);

		wp_register_script(
			'de-animated-testimonials',
			plugin_dir_url(__FILE__) . 'assets/js/animated-testimonials.js',
			['jquery'],
			$this->version,
			true
		);
	}

	/**
	 * Enqueue widget assets conditionally
	 * @since 1.0.0
	 */
	public function enqueue_widget_assets()
	{
		wp_enqueue_style('de-animated-testimonials');
		wp_enqueue_script('de-animated-testimonials');
	}

	/**
	 * Define constant if not already set.
	 *
	 * @since  1.0
	 * @param  string $name
	 * @param  string|bool $value
	 */
	private function define($name, $value)
	{
		if (!defined($name)) {
			define($name, $value);
		}
	}

	public static function get_instance()
	{
		if (null === self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}

Decent_Elements::get_instance();