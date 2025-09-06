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

defined('ABSPATH') || exit;

final class Decent_Elements
{
	private static $instance;

	private $version = '1.0.0';

	private function __construct()
	{
		$this->define_constants();
		$this->includes();
	}

	private function includes()
	{
		if (is_admin()) {
			require_once(DECENT_ELEMENTS_ABSPATH . 'includes/admin/class-admin-menu.php');
			require_once(DECENT_ELEMENTS_ABSPATH . 'includes/admin/class-admin-assets.php');
		}
		require_once(DECENT_ELEMENTS_ABSPATH . 'includes/admin/class-admin-api.php');
		require_once(DECENT_ELEMENTS_ABSPATH . 'includes/class-widget-manager.php');

		// Initialize Elementor widgets
		add_action('plugins_loaded', [$this, 'init_elementor']);
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
		Decent_Elements_Widget_Manager::instance();
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