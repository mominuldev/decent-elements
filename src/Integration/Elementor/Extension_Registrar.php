<?php
/**
 * Elementor extension loading.
 *
 * @package Decent_Elements
 * @since   1.2.0
 */

namespace Decent_Elements\Integration\Elementor;

use Decent_Elements\Contracts\Module;
use Decent_Elements\Core\Module_Manager;

defined( 'ABSPATH' ) || exit;

/**
 * Loads and boots enabled extension modules.
 *
 * Replaces Decent_Elements_Extension_Manager, which duplicated the widget
 * manager's registry, settings and toggle logic, published itself into
 * $GLOBALS, and declared a global function wrapper — three separate ways to
 * reach one object, two of which never worked because of namespace resolution
 * (found by PHPStan in Phase 1).
 *
 * @since 1.2.0
 */
final class Extension_Registrar {

	/**
	 * Module registry.
	 *
	 * @var Module_Manager
	 */
	private $modules;

	/**
	 * Booted extension instances, keyed by module key.
	 *
	 * @var array<string, object>
	 */
	private $booted = array();

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
		add_action( 'init', array( $this, 'load_extensions' ) );
	}

	/**
	 * Load every enabled extension.
	 *
	 * @return void
	 */
	public function load_extensions() {
		foreach ( $this->modules->enabled( Module::TYPE_EXTENSION ) as $key => $module ) {
			if ( isset( $this->booted[ $key ] ) ) {
				continue;
			}

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

			$this->booted[ $key ] = new $class();
		}
	}
}
