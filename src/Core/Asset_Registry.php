<?php
/**
 * Asset registration driven by module declarations.
 *
 * @package Decent_Elements
 * @since   1.2.0
 */

namespace Decent_Elements\Core;

use Decent_Elements\Contracts\Module;

defined( 'ABSPATH' ) || exit;

/**
 * Registers module-owned assets with WordPress, and answers "what files does
 * this module own?" for anything else that needs to know.
 *
 * Before this class, three components computed asset paths independently: the
 * bootstrap's inline wp_register_* calls, each extension's own enqueue method,
 * and the optimizer's path guessing. They used three different conventions, so
 * they disagreed — the optimizer bundled zero-byte placeholder files while the
 * registrar served the real stylesheets from a different directory, and
 * enabling optimization stripped 12 KB of CSS from the page.
 *
 * Everything now reads from the Module definitions, so disagreement is not
 * expressible.
 *
 * @since 1.2.0
 */
final class Asset_Registry {

	/**
	 * Module registry.
	 *
	 * @var Module_Manager
	 */
	private $modules;

	/**
	 * Plugin version, used for cache busting.
	 *
	 * @var string
	 */
	private $version;

	/**
	 * Constructor.
	 *
	 * @param Module_Manager $modules Module registry.
	 * @param string         $version Plugin version.
	 */
	public function __construct( Module_Manager $modules, $version ) {
		$this->modules = $modules;
		$this->version = $version;
	}

	/**
	 * Register WordPress hooks.
	 *
	 * @return void
	 */
	public function register_hooks() {
		// Registered on both hooks: Elementor resolves widget get_*_depends()
		// during its own pass, while extension assets are enqueued on the normal
		// WordPress pass. wp_register_* is a no-op for an already-registered
		// handle, so running twice is harmless.
		add_action( 'elementor/frontend/after_register_scripts', array( $this, 'register_assets' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ), 5 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_extension_assets' ), 20 );
	}

	/**
	 * Enqueue assets owned by enabled extensions.
	 *
	 * Extensions have no widget through which to declare dependencies, so their
	 * assets are enqueued directly — but only on pages built with Elementor.
	 *
	 * Extensions used to enqueue their own files from inside their classes,
	 * building URLs by hand. Four of the seven pointed at paths that never
	 * existed (`plugin_dir_url(__FILE__) . '../assets/...'` resolves inside
	 * src/, and `mouse-effects` referenced files that were never created), so
	 * they emitted 404s on every page load. Ownership now sits with the module
	 * definitions, and a handle that was never registered is simply skipped.
	 *
	 * @return void
	 */
	public function enqueue_extension_assets() {
		if ( ! $this->is_built_with_elementor() ) {
			return;
		}

		foreach ( $this->modules->enabled( Module::TYPE_EXTENSION ) as $module ) {
			$handle = $module->handle();

			if ( wp_style_is( $handle, 'registered' ) ) {
				wp_enqueue_style( $handle );
			}

			if ( wp_script_is( $handle, 'registered' ) ) {
				wp_enqueue_script( $handle );
			}
		}
	}

	/**
	 * Whether the current post is built with Elementor.
	 *
	 * @return bool
	 */
	private function is_built_with_elementor() {
		if ( ! class_exists( '\Elementor\Plugin' ) ) {
			return false;
		}

		global $post;

		if ( ! $post instanceof \WP_Post ) {
			return false;
		}

		$document = \Elementor\Plugin::$instance->documents->get( $post->ID );

		return $document && $document->is_built_with_elementor();
	}

	/**
	 * Register every enabled module's assets.
	 *
	 * Widgets pull these handles in through get_style_depends()/get_script_depends(),
	 * so Elementor enqueues them only on pages where the widget is actually
	 * used. Nothing is enqueued unconditionally here.
	 *
	 * @return void
	 */
	public function register_assets() {
		$this->register_vendor_assets();

		foreach ( $this->modules->enabled() as $module ) {
			$this->register_module( $module );
		}
	}

	/**
	 * Register bundled third-party libraries.
	 *
	 * GSAP ships with the plugin under assets/vendors/. It was previously pulled
	 * from cdnjs at runtime, which adds a third-party request with no SRI and
	 * breaks on air-gapped or privacy-restricted installs — while an identical
	 * local copy sat unused in the repository.
	 *
	 * @return void
	 */
	private function register_vendor_assets() {
		$vendors = array(
			'gsap'                => 'assets/vendors/gsap/gsap.min.js',
			'gsap-scroll-trigger' => 'assets/vendors/gsap/ScrollTrigger.min.js',
		);

		foreach ( $vendors as $handle => $relative ) {
			if ( wp_script_is( $handle, 'registered' ) || ! file_exists( DECENT_ELEMENTS_PATH . $relative ) ) {
				continue;
			}

			wp_register_script( $handle, DECENT_ELEMENTS_URL . $relative, array(), $this->version, true );
		}
	}

	/**
	 * Register one module's assets.
	 *
	 * @param Module $module Module to register.
	 * @return void
	 */
	private function register_module( Module $module ) {
		$styles = $this->existing( $module->styles() );

		if ( array() !== $styles ) {
			wp_register_style(
				$module->handle(),
				DECENT_ELEMENTS_URL . $styles[0],
				$module->style_deps(),
				$this->version
			);
		}

		$scripts = $this->existing( $module->scripts() );

		if ( array() !== $scripts ) {
			wp_register_script(
				$module->handle(),
				DECENT_ELEMENTS_URL . $scripts[0],
				$module->script_deps(),
				$this->version,
				true
			);
		}
	}

	/**
	 * Absolute paths to every stylesheet owned by enabled modules.
	 *
	 * Consumed by the optimizer so that what gets bundled is exactly what would
	 * otherwise be served.
	 *
	 * @return array<int, string>
	 */
	public function enabled_style_paths() {
		return $this->collect_paths( 'styles' );
	}

	/**
	 * Absolute paths to every script owned by enabled modules.
	 *
	 * @return array<int, string>
	 */
	public function enabled_script_paths() {
		return $this->collect_paths( 'scripts' );
	}

	/**
	 * Handles registered for enabled modules.
	 *
	 * @return array<int, string>
	 */
	public function enabled_handles() {
		$handles = array();

		foreach ( $this->modules->enabled() as $module ) {
			$handles[] = $module->handle();
		}

		return $handles;
	}

	/**
	 * Gather absolute paths from every enabled module.
	 *
	 * @param string $method Either `styles` or `scripts`.
	 * @return array<int, string>
	 */
	private function collect_paths( $method ) {
		$paths = array();

		foreach ( $this->modules->enabled() as $module ) {
			foreach ( $this->existing( $module->{$method}() ) as $relative ) {
				$paths[] = DECENT_ELEMENTS_PATH . $relative;
			}
		}

		return $paths;
	}

	/**
	 * Filter a path list down to files that exist and have content.
	 *
	 * Zero-byte files are skipped deliberately. The plugin ships several empty
	 * placeholders; registering them would cost a real HTTP request per widget
	 * for no bytes, and bundling them is what made the optimizer's output
	 * meaningless. A placeholder that later gains content starts working with
	 * no code change.
	 *
	 * @param array<int, string> $relative_paths Paths relative to the plugin root.
	 * @return array<int, string>
	 */
	private function existing( array $relative_paths ) {
		$found = array();

		foreach ( $relative_paths as $relative ) {
			$absolute = DECENT_ELEMENTS_PATH . $relative;

			if ( file_exists( $absolute ) && filesize( $absolute ) > 0 ) {
				$found[] = $relative;
			}
		}

		return $found;
	}
}
