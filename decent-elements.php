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