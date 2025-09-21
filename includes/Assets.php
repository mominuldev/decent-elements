<?php
/**
 * Assets
 *
 * @since     1.0.0
 */
namespace Decent_Elements;

defined('ABSPATH') || exit;

class Assets
{
	/**
	 * @var object
	 * @access private
	 * @since 1.0.0
	 */
	private static $_instance = null;

	/**
	 * Get singleton instance
	 * @return object
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
	 * Constructor method
	 * @since 1.0.0
	 */
	public function __construct()
	{
		add_action('wp_enqueue_scripts', [$this, 'frontend_scripts']);
		add_action('admin_enqueue_scripts', [$this, 'admin_scripts']);
	}

	/**
	 * Enqueue frontend scripts and styles
	 * @since 1.0.0
	 */
	public function frontend_scripts()
	{

		$widgets = [
			'fancy-heading' => [
				['gsap', 'vendors/gsap/gsap.min.js', '3.11.4'],
				['scrollTrigger', 'vendors/gsap/ScrollTrigger.min.js', '3.11.4'],
				['split-text', 'vendor/js/splitText.min.js', null],
			],
			'testimonial' => ['swiper', 'vendor/js/swiper.min.js', null],
		];

		foreach ($widgets as $widget => $scripts) {
			if ($this->is_widget_enabled($widget)) {
				if (is_array($scripts[0])) {
					foreach ($scripts as $script) {
						wp_register_script($script[0], BDTEP_ASSETS_URL . $script[1], ['jquery'], $script[2], true);
					}
				} else {
					wp_register_script($scripts[0], strpos($scripts[1], 'http') === 0 ? $scripts[1] : BDTEP_ASSETS_URL . $scripts[1], ['jquery'], $scripts[2], true);
				}
			}
		}
	}

	/**
	 * Enqueue admin scripts and styles
	 * @since 1.0.0
	 */
	public function admin_scripts() {
		wp_enqueue_style('decent-elements-admin', plugins_url('/assets/css/decent-elements-admin.css', __FILE__), [], '1.0.0');
		wp_enqueue_script('decent-elements-admin', plugins_url('/assets/js/decent-elements-admin.js', __FILE__), ['jquery'], '1.0.0', true);
	}

	public static function get_instance()
	{
		if (null === self::$_instance) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

}
