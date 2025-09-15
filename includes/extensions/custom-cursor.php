<?php
/**
 * Custom Cursor Extension for Decent Elements
 * Adds GSAP-powered custom cursor with text, icon, SVG, and image support for Elementor sections, containers, and global.
 */


class Decent_Elements_Custom_Cursor_Extension
{

	private $plugin_url;
	private $plugin_version;
	private $assets_url;

	public function __construct()
	{
		// Set plugin paths correctly
		$this->plugin_url = plugin_dir_url(dirname(dirname(__FILE__))); // Go up two levels to plugin root
		$this->assets_url = $this->plugin_url.'assets/';
		$this->plugin_version = defined('DECENT_ELEMENTS_VERSION') ? DECENT_ELEMENTS_VERSION : '1.0.0';

		// Enqueue scripts/styles in Elementor editor and frontend
		add_action('elementor/editor/after_enqueue_scripts', [$this, 'enqueue_assets']);
		add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);

		// Register controls for different elements
		add_action('elementor/element/section/section_layout/after_section_end', [$this, 'register_controls'], 10);
		add_action('elementor/element/column/section_advanced/after_section_end', [$this, 'register_controls'], 10);
		add_action('elementor/element/common/_section_style/after_section_end', [$this, 'register_controls'], 10);
		add_action('elementor/element/container/section_layout/after_section_end', [$this, 'register_controls'], 10);

		// Render cursor markup
		add_action('wp_footer', [$this, 'render_cursor_markup']);

		// Add frontend rendering
		add_action('elementor/frontend/element/before_render', [$this, 'before_render_element']);
	}

	public function enqueue_assets()
	{
		// Don't load in admin or during AJAX
		if (is_admin() || wp_doing_ajax()) {
			return;
		}

		// Only load on pages built with Elementor
		if (!class_exists('\Elementor\Plugin') || !\Elementor\Plugin::$instance->db->is_built_with_elementor(get_the_ID())) {
			return;
		}

		// GSAP CDN
		wp_enqueue_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', [], '3.12.5', true);

		// Custom cursor script
		wp_enqueue_script(
			'de-custom-cursor',
			$this->assets_url.'js/custom-cursor.js',
			['gsap'],
			$this->plugin_version,
			true
		);

		// Custom cursor styles
		wp_enqueue_style(
			'de-custom-cursor',
			$this->assets_url.'css/custom-cursor.css',
			[],
			$this->plugin_version
		);
	}

	public function register_controls($element)
	{
		$element->start_controls_section(
			'de_custom_cursor_section',
			[
				'label' => __('Custom Cursor', 'decent-elements'),
				'tab'   => \Elementor\Controls_Manager::TAB_ADVANCED,
			]
		);

		$element->add_control(
			'de_custom_cursor_enable',
			[
				'label'        => __('Enable Custom Cursor', 'decent-elements'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$element->add_control(
			'de_custom_cursor_type',
			[
				'label'     => __('Cursor Type', 'decent-elements'),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => [
					'text'  => __('Text', 'decent-elements'),
					'icon'  => __('Icon', 'decent-elements'),
					'svg'   => __('SVG', 'decent-elements'),
					'image' => __('Image', 'decent-elements'),
				],
				'default'   => 'text',
				'condition' => [
					'de_custom_cursor_enable' => 'yes',
				],
			]
		);

		$element->add_control(
			'de_custom_cursor_text',
			[
				'label'     => __('Cursor Text', 'decent-elements'),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => __('Drag', 'decent-elements'),
				'condition' => [
					'de_custom_cursor_enable' => 'yes',
					'de_custom_cursor_type'   => 'text',
				],
			]
		);

		$element->add_control(
			'de_custom_cursor_icon',
			[
				'label'     => __('Cursor Icon', 'decent-elements'),
				'type'      => \Elementor\Controls_Manager::ICONS,
				'condition' => [
					'de_custom_cursor_enable' => 'yes',
					'de_custom_cursor_type'   => 'icon',
				],
			]
		);

		$element->add_control(
			'de_custom_cursor_svg',
			[
				'label'       => __('Cursor SVG', 'decent-elements'),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'description' => __('Paste SVG code here.', 'decent-elements'),
				'condition'   => [
					'de_custom_cursor_enable' => 'yes',
					'de_custom_cursor_type'   => 'svg',
				],
			]
		);

		$element->add_control(
			'de_custom_cursor_image',
			[
				'label'     => __('Cursor Image', 'decent-elements'),
				'type'      => \Elementor\Controls_Manager::MEDIA,
				'condition' => [
					'de_custom_cursor_enable' => 'yes',
					'de_custom_cursor_type'   => 'image',
				],
			]
		);

		$element->end_controls_section();
	}

	public function before_render_element($element)
	{
		$settings = $element->get_settings_for_display();

		if (!empty($settings['de_custom_cursor_enable']) && 'yes' === $settings['de_custom_cursor_enable']) {
			$element->add_render_attribute('_wrapper', 'data-cursor-enabled', 'true');
			$element->add_render_attribute('_wrapper', 'data-cursor-type', $settings['de_custom_cursor_type']);

			switch ($settings['de_custom_cursor_type']) {
				case 'text':
					if (!empty($settings['de_custom_cursor_text'])) {
						$element->add_render_attribute('_wrapper', 'data-cursor-text', esc_attr($settings['de_custom_cursor_text']));
					}
					break;

				case 'icon':
					if (!empty($settings['de_custom_cursor_icon']['value'])) {
						$icon_value = $settings['de_custom_cursor_icon']['value'];

						// Handle different icon types
						if (is_string($icon_value)) {
							// Font Awesome or other font icons
							$element->add_render_attribute('_wrapper', 'data-cursor-icon', esc_attr($icon_value));
						} elseif (isset($icon_value['url'])) {
							// SVG icon
							$element->add_render_attribute('_wrapper', 'data-cursor-icon-svg', esc_url($icon_value['url']));
						}

						// Also add the library info if available
						if (!empty($settings['de_custom_cursor_icon']['library'])) {
							$element->add_render_attribute('_wrapper', 'data-cursor-icon-library',
								esc_attr($settings['de_custom_cursor_icon']['library']));
						}
					}
					break;

				case 'svg':
					if (!empty($settings['de_custom_cursor_svg'])) {
						$element->add_render_attribute('_wrapper', 'data-cursor-svg', esc_attr($settings['de_custom_cursor_svg']));
					}
					break;

				case 'image':
					if (!empty($settings['de_custom_cursor_image']['url'])) {
						$element->add_render_attribute('_wrapper', 'data-cursor-image', esc_url($settings['de_custom_cursor_image']['url']));
					}
					break;
			}
		}
	}


	public function render_cursor_markup()
	{
		// Always render cursor markup on frontend pages with Elementor content
		if (is_admin() || wp_doing_ajax()) {
			return;
		}

		// Check if Elementor is active on this page
		if (!class_exists('\Elementor\Plugin') || !\Elementor\Plugin::$instance->db->is_built_with_elementor(get_the_ID())) {
			return;
		}


		echo '<div id="de-custom-cursor" class="de-cursor-wrapper" style="display: none;">
                <div class="de-cursor-dot"></div>
                <div class="de-cursor-content">
                    <span class="de-cursor-text"></span>
                    <div class="de-cursor-icon"></div>
                    <div class="de-cursor-svg"></div>
                    <img class="de-cursor-image" src="" alt="">
                </div>
            </div>';
	}
}

