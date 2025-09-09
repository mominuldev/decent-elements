<?php
/**
 * Admin API
 *
 * @since     1.0.0
 */
namespace Decent_Elements\Admin;

use Decent_Elements\Widget_Manager;

defined('ABSPATH') || exit;

class Admin_Panel_API
{
	/**
	 * @var    object
	 * @access  private
	 * @since    1.0.0
	 */
	private static $_instance = null;

	/**
	 * Constructor function.
	 * @since 1.0.0
	 */
	public function __construct()
	{

		add_action('rest_api_init', function () {
			// Settings
			register_rest_route(DECENT_ELEMENTS_REST_API_ROUTE, '/settings/', array(
				'methods'             => 'GET',
				'callback'            => array($this, 'get_settings'),
				'permission_callback' => array($this, 'get_permission')
			));
			register_rest_route(DECENT_ELEMENTS_REST_API_ROUTE, '/settings/', array(
				'methods'             => 'POST',
				'callback'            => array($this, 'set_settings'),
				'permission_callback' => array($this, 'get_permission')
			));

			// Widget Settings
			register_rest_route(DECENT_ELEMENTS_REST_API_ROUTE, '/widgets/', array(
				'methods'             => 'GET',
				'callback'            => array($this, 'get_widget_settings'),
				'permission_callback' => array($this, 'get_permission')
			));
			register_rest_route(DECENT_ELEMENTS_REST_API_ROUTE, '/widgets/', array(
				'methods'             => 'POST',
				'callback'            => array($this, 'set_widget_settings'),
				'permission_callback' => array($this, 'get_permission')
			));

			// Extension Settings
			register_rest_route(DECENT_ELEMENTS_REST_API_ROUTE, '/extensions/', array(
				'methods'             => 'GET',
				'callback'            => array($this, 'get_extension_settings'),
				'permission_callback' => array($this, 'get_permission')
			));
			register_rest_route(DECENT_ELEMENTS_REST_API_ROUTE, '/extensions/', array(
				'methods'             => 'POST',
				'callback'            => array($this, 'set_extension_settings'),
				'permission_callback' => array($this, 'get_permission')
			));

		});
	}

	/**
	 * Ensures only one instance is loaded or can be loaded.
	 * @since 1.0.0
	 */
	public static function instance()
	{
		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	/**
	 * Allowed HTML tags for settings fields
	 * @since 1.0.0
	 */
	private function allowed_html_settings()
	{
		return array();
	}

	/**
	 * Registered settings fields
	 * @since 1.0.0
	 */
	private function registered_settings()
	{
		$prefix = 'my_plugin_';
		$options = array(
			$prefix.'disable',
			$prefix.'cookie_time',
			$prefix.'min_ref_order',
			$prefix.'cookie_remove',
			$prefix.'allow_guests',
			$prefix.'hide_no_orders',
			$prefix.'hide_no_orders_text',
			$prefix.'referral_codes',
			$prefix.'subscription',
			$prefix.'subscription_all_coupons',
			$prefix.'subscription_exclude_shipping',
		);
		return $options;
	}

	/**
	 * Fetching settings
	 * @since 1.0.0
	 */
	public function get_settings()
	{
		$result = [];
		foreach ($this->registered_settings() as $key) {
			if ($value = get_option($key)) {
				$result[$key] = $value;
			}
		}

		return new \WP_REST_Response($result, 200);
	}

	/**
	 * Saving settings
	 * @since 1.0.0
	 */
	public function set_settings($data)
	{
		$fields = $this->registered_settings();
		$allowed_html = $this->allowed_html_settings();

		$data = $data->get_params();

		foreach ($data as $key => $value) {
			if (in_array($key, $fields)) {
				$sanitized_data = in_array($key, $allowed_html) ? wp_kses_post($value) : sanitize_text_field($value);
				if (false === get_option($key)) {
					add_option($key, $sanitized_data);
				} else {
					update_option($key, $sanitized_data);
				}
			}
		}

		return new \WP_REST_Response($data, 200);
	}

	/**
	 * Fetching widget settings
	 * @since 1.0.0
	 */
	public function get_widget_settings()
	{
		error_log('Get widget settings API called');
		
		$widget_manager = Widget_Manager::instance();
		$available_widgets = $widget_manager->get_available_widgets();
		$current_settings = $widget_manager->get_widget_settings();

		error_log('Available widgets: ' . print_r($available_widgets, true));
		error_log('Current settings: ' . print_r($current_settings, true));

		$result = [];
		foreach ($available_widgets as $widget_id => $widget_data) {
			$result[$widget_id] = [
				'name' => $widget_data['name'],
				'enabled' => isset($current_settings[$widget_id]) ? (bool) $current_settings[$widget_id] : $widget_data['default'],
				'default' => $widget_data['default']
			];
		}

		error_log('Result: ' . print_r($result, true));
		return new \WP_REST_Response($result, 200);
	}

	/**
	 * Saving widget settings
	 * @since 1.0.0
	 */
	public function set_widget_settings($data)
	{
		error_log('Widget settings API called');
		
		$widget_manager = Widget_Manager::instance();
		$available_widgets = $widget_manager->get_available_widgets();
		
		$request_data = $data->get_params();
		error_log('Request data: ' . print_r($request_data, true));
		
		$settings = [];

		// Validate and sanitize the data
		foreach ($request_data as $widget_id => $enabled) {
			if (array_key_exists($widget_id, $available_widgets)) {
				$settings[$widget_id] = (bool) $enabled;
			}
		}

		error_log('Processed settings: ' . print_r($settings, true));

		// Save the settings
		$success = $widget_manager->update_widget_settings($settings);

		if ($success) {
			return new \WP_REST_Response([
				'success' => true,
				'message' => 'Widget settings saved successfully',
				'data' => $settings
			], 200);
		} else {
			return new \WP_REST_Response([
				'success' => false,
				'message' => 'Failed to save widget settings'
			], 500);
		}
	}

	/**
	 * Getting extension settings
	 * @since 1.0.0
	 */
	public function get_extension_settings()
	{
		error_log('Extension settings API called');
		
		try {
			// Ensure Extension Manager class is loaded
			if (!class_exists('Decent_Elements_Extension_Manager')) {
				$manager_file = DECENT_ELEMENTS_PATH . 'includes/class-extension-manager.php';
				if (file_exists($manager_file)) {
					require_once $manager_file;
				}
			}

			// Get extension manager instance (try global, function, or ::instance())
			$extension_manager = null;
			if (isset($GLOBALS['decent_elements_extension_manager']) && $GLOBALS['decent_elements_extension_manager']) {
				$extension_manager = $GLOBALS['decent_elements_extension_manager'];
			}
			if (!$extension_manager && function_exists('Decent_Elements_Extension_Manager')) {
				$extension_manager = Decent_Elements_Extension_Manager();
			}
			if (!$extension_manager && class_exists('Decent_Elements_Extension_Manager') && method_exists('Decent_Elements_Extension_Manager', 'instance')) {
				$extension_manager = Decent_Elements_Extension_Manager::instance();
			}

			if (!$extension_manager) {
				error_log('Extension Manager instance not available');
				return new \WP_REST_Response(['error' => 'Extension Manager instance not available'], 500);
			}

			$available_extensions = $extension_manager->get_available_extensions();
			$current_settings = $extension_manager->get_extension_settings();

			error_log('Available extensions: ' . print_r($available_extensions, true));
			error_log('Current extension settings: ' . print_r($current_settings, true));

			$result = [];
			foreach ($available_extensions as $extension_id => $extension_data) {
				$result[$extension_id] = [
					'id' => $extension_id,
					'name' => $extension_data['name'],
					'enabled' => isset($current_settings[$extension_id]) ? (bool) $current_settings[$extension_id] : $extension_data['default'],
					'default' => $extension_data['default']
				];
			}

			error_log('Extension result: ' . print_r($result, true));
			return new \WP_REST_Response($result, 200);
		} catch (\Exception $e) {
			error_log('Extension settings API error: ' . $e->getMessage());
			return new \WP_REST_Response(['error' => 'Internal server error: ' . $e->getMessage()], 500);
		}
	}

	/**
	 * Saving extension settings
	 * @since 1.0.0
	 */
	public function set_extension_settings($data)
	{
		error_log('Extension settings save API called');
		
		try {
			// Ensure Extension Manager class is loaded
			if (!class_exists('Decent_Elements_Extension_Manager')) {
				$manager_file = DECENT_ELEMENTS_PATH . 'includes/class-extension-manager.php';
				if (file_exists($manager_file)) {
					require_once $manager_file;
				}
			}

			// Get extension manager instance (try global, function, or ::instance())
			$extension_manager = null;
			if (isset($GLOBALS['decent_elements_extension_manager']) && $GLOBALS['decent_elements_extension_manager']) {
				$extension_manager = $GLOBALS['decent_elements_extension_manager'];
			}
			if (!$extension_manager && function_exists('Decent_Elements_Extension_Manager')) {
				$extension_manager = Decent_Elements_Extension_Manager();
			}
			if (!$extension_manager && class_exists('Decent_Elements_Extension_Manager') && method_exists('Decent_Elements_Extension_Manager', 'instance')) {
				$extension_manager = Decent_Elements_Extension_Manager::instance();
			}

			if (!$extension_manager) {
				error_log('Extension Manager instance not available');
				return new \WP_REST_Response([
					'success' => false,
					'message' => 'Extension Manager instance not available'
				], 500);
			}

			$available_extensions = $extension_manager->get_available_extensions();
			
			$request_data = $data->get_params();
			error_log('Extension request data: ' . print_r($request_data, true));
			
			$settings = [];

			// Validate and sanitize the data
			foreach ($request_data as $extension_id => $enabled) {
				if (array_key_exists($extension_id, $available_extensions)) {
					$settings[$extension_id] = (bool) $enabled;
				}
			}

			error_log('Processed extension settings: ' . print_r($settings, true));

			// Save the settings using extension manager
			$success = $extension_manager->update_extension_settings($settings);

			if ($success !== false) {
				error_log('Extension settings saved successfully');
				return new \WP_REST_Response([
					'success' => true,
					'message' => 'Extension settings saved successfully',
					'data' => $settings
				], 200);
			} else {
				error_log('Failed to save extension settings');
				return new \WP_REST_Response([
					'success' => false,
					'message' => 'Failed to save extension settings'
				], 500);
			}
		} catch (\Exception $e) {
			error_log('Extension settings save API error: ' . $e->getMessage());
			return new \WP_REST_Response([
				'success' => false,
				'message' => 'Internal server error: ' . $e->getMessage()
			], 500);
		}
	}

	/*
		Fetching posts example. You would have this in separate class most probably.
	*/
	public function get_posts($request)
	{
		$params = $request->get_params();
		if (isset($params['page']) && is_numeric($params['page'])) {
			$page = intval($params['page']);
			$args = array(
				'post_type'      => 'post',
				'posts_per_page' => 10,
				'post_status'    => 'publish',
				'paged'          => $page
			);
			$posts = [];
			$query = new \WP_Query($args);
			$total_pages = $query->max_num_pages;
			foreach ($query->posts as $post) {
				$formatted_date = date('M d, Y', strtotime($post->post_date));
				$author_info = get_userdata($post->post_author);

				$posts[] = array(
					'postID'     => $post->ID,
					'postName'   => $post->post_title,
					'postDate'   => $formatted_date,
					'postAuthor' => $author_info ? $author_info->display_name : 'Unknown Author',
					'postStatus' => $post->post_status,
				);
			}
			$response = array('numOfPages' => $total_pages, 'data' => $posts);
			return new \WP_REST_Response($response, 200);
		}
		return new \WP_REST_Response(array('message' => 'Something went wrong!'), 403);
	}

	/*
		License example. You would have this in separate class most probably.
	*/
	function get_license()
	{
		// You would fetch licence key here.
		$response = array("license_key" => "xxxxxx");
		return new \WP_REST_Response($response, 200);
	}

	/**
	 * Permission Callback
	 **/
	public function get_permission()
	{
		$can_access = current_user_can('administrator') || current_user_can('manage_woocommerce');
		error_log('Permission check: ' . ($can_access ? 'ALLOWED' : 'DENIED') . ' for user ID: ' . get_current_user_id());
		return $can_access;
	}

	/**
	 * Cloning is forbidden.
	 * @since 1.0.0
	 */
	public function __clone()
	{
		_doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?'), DECENT_ELEMENTS_VERSION);
	}
}

