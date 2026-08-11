<?php
/**
 * Elementor widget registration.
 *
 * @package Decent_Elements
 * @since   1.2.0
 */

namespace Decent_Elements\Integration\Elementor;

use Decent_Elements\Contracts\Module;
use Decent_Elements\Core\Module_Manager;

defined( 'ABSPATH' ) || exit;

/**
 * Registers enabled widget modules with Elementor.
 *
 * Uses the modern API — the `elementor/widgets/register` action and
 * `$manager->register()`. The plugin previously used
 * `elementor/widgets/widgets_registered` and `register_widget_type()`, both
 * deprecated. They still function on Elementor 4.0.2, but this is the surface
 * most likely to be removed, and it is cheap to get right.
 *
 * A fallback to the legacy hook is kept for Elementor installations older than
 * 3.5, which is where `register()` was introduced.
 *
 * @since 1.2.0
 */
final class Widget_Registrar {

	/**
	 * Elementor version that introduced the modern registration API.
	 */
	const MODERN_API_VERSION = '3.5.0';

	/**
	 * Module registry.
	 *
	 * @var Module_Manager
	 */
	private $modules;

	/**
	 * Constructor.
	 *
	 * @param Module_Manager $modules Module registry.
	 */
	public function __construct( Module_Manager $modules ) {
		$this->modules = $modules;
	}

	/**
	 * Register WordPress hooks.
	 *
	 * @return void
	 */
	public function register_hooks() {
		if ( $this->supports_modern_api() ) {
			add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
			return;
		}

		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets_legacy' ) );
	}

	/**
	 * Register widgets using the modern API.
	 *
	 * @param \Elementor\Widgets_Manager $widgets_manager Elementor's manager.
	 * @return void
	 */
	public function register_widgets( $widgets_manager ) {
		foreach ( $this->instantiate_enabled_widgets() as $widget ) {
			$widgets_manager->register( $widget );
		}
	}

	/**
	 * Register widgets on Elementor releases predating register().
	 *
	 * @param \Elementor\Widgets_Manager $widgets_manager Elementor's manager.
	 * @return void
	 */
	public function register_widgets_legacy( $widgets_manager ) {
		foreach ( $this->instantiate_enabled_widgets() as $widget ) {
			$widgets_manager->register_widget_type( $widget );
		}
	}

	/**
	 * Load and instantiate every enabled widget.
	 *
	 * Widget files are plain global classes loaded by require_once — they are
	 * not autoloadable until Phase 3 namespaces them.
	 *
	 * @return array<int, \Elementor\Widget_Base>
	 */
	private function instantiate_enabled_widgets() {
		$widgets = array();

		foreach ( $this->modules->enabled( Module::TYPE_WIDGET ) as $module ) {
			$path = $module->path();

			if ( null !== $path ) {
				if ( ! file_exists( $path ) ) {
					continue;
				}

				require_once $path;
			}

			$class = $module->class_name();

			if ( ! class_exists( $class ) ) {
				continue;
			}

			$widget = new $class();

			if ( $widget instanceof \Elementor\Widget_Base ) {
				$widgets[] = $widget;
			}
		}

		return $widgets;
	}

	/**
	 * Whether the installed Elementor supports register().
	 *
	 * @return bool
	 */
	private function supports_modern_api() {
		return defined( 'ELEMENTOR_VERSION' )
			&& version_compare( ELEMENTOR_VERSION, self::MODERN_API_VERSION, '>=' );
	}
}
