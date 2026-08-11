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
 * Requires PHP: 8.0
 *
 * @package Decent_Elements
 */

defined( 'ABSPATH' ) || exit;

/**
 * Composer autoloader.
 *
 * Guarded because a plugin installed from git rather than from a release zip
 * will not have vendor/ until `composer install` has been run. Failing with a
 * readable notice beats a fatal on a missing file.
 */
if ( ! file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	add_action(
		'admin_notices',
		static function () {
			printf(
				'<div class="notice notice-error"><p>%s</p></div>',
				esc_html__(
					'Decent Elements: dependencies are missing. Run "composer install" in the plugin directory.',
					'decent-elements'
				)
			);
		}
	);

	return;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Boot the plugin.
 *
 * @since 1.0.0
 * @return \Decent_Elements\Plugin
 */
function decent_elements() {
	return \Decent_Elements\Plugin::boot( __FILE__ );
}

decent_elements();
