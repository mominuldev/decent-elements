<?php

/**
 * Setup Menu Pages
 *
 * @since     1.0.0
 */

defined('ABSPATH') || exit;

class Admin_Menu
{

	public function __construct()
	{
		// Add submenu items
		add_action('admin_menu', array($this, 'register_menu'));
		// Add links under plugin page.
		add_filter('plugin_action_links_wp-react-admin-panel/wp-react-admin-panel.php', array($this, 'add_settings_link'));
		add_filter('plugin_action_links_wp-react-admin-panel/wp-react-admin-panel.php', array($this, 'docs_link'));
	}


	/**
	 * Define Menu
	 *
	 * @since 1.0.0
	 */
	public function register_menu()
	{

		// $menu_logo = '<img src="' . plugin_dir_url(__FILE__) . 'assets/images/menu-logo.png" alt="Decent Elements Logo" style="height: 32px; width: auto; margin-right: 10px;" />';

		add_menu_page(
			__('Decent Elements', 'decent-elements'),
			__('Decent Elements', 'decent-elements'),
			'manage_options',
			'decent_elements',
			array($this, 'display_react_admin_page'),
			DECENT_ELEMENTS_ASSETS_URL . 'images/menu-logo.svg',
			20
		);
	}

	/**
	 * Init the view part.
	 *
	 * @since 1.0.0
	 */
	public function display_react_admin_page()
	{
		echo "<div id='root'></div>";
	}

	/**
	 * Plugin Settings Link on plugin page
	 *
	 * @since 		1.0.0
	 */
	function add_settings_link($links)
	{
		$settings = array(
			'<a href="' . admin_url('admin.php?page=decent-elements') . '">Settings</a>',
		);
		return array_merge($links, $settings);
	}


	/**
	 * Plugin Documentation Link on plugin page
	 *
	 * @since 		1.0.0
	 */
	function docs_link($links)
	{
		$docs = array(
			'<a target="_blank" href="http://example.com/documentation">Documentation</a>',
		);
		return array_merge($links, $docs);
	}
}

new Admin_Menu();