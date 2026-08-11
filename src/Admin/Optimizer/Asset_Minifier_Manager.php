<?php
/**
 * Asset optimizer.
 *
 * @package Decent_Elements
 * @since   1.0.0
 */

namespace Decent_Elements\Admin\Optimizer;

use Decent_Elements\Core\Asset_Registry;
use Decent_Elements\Core\Settings_Repository;
use MatthiasMullie\Minify;

defined( 'ABSPATH' ) || exit;

/**
 * Combines and minifies the assets owned by enabled modules.
 *
 * This class used to derive asset paths itself, guessing them from module ids
 * (`assets/widgets/css/<id>.css`). That guess disagreed with what the registrar
 * actually served: the real testimonials stylesheet lives in `assets/css/` at
 * 12 KB, while `assets/widgets/css/` holds a zero-byte placeholder of the same
 * name. The optimizer bundled the placeholder and then dequeued the handle
 * carrying the real file, stripping 12 KB of CSS from every page it touched.
 *
 * It now reads paths from Asset_Registry — the same source the registrar uses —
 * so the two cannot disagree.
 *
 * @since 1.0.0
 */
final class Asset_Minifier_Manager {

	/**
	 * Directory beneath the uploads folder where bundles are written.
	 */
	const OUTPUT_DIR = 'decent-elements/minified';

	/**
	 * Asset source of truth.
	 *
	 * @var Asset_Registry
	 */
	private $assets;

	/**
	 * Settings storage.
	 *
	 * @var Settings_Repository
	 */
	private $settings;

	/**
	 * Constructor.
	 *
	 * @param Asset_Registry      $assets   Asset source of truth.
	 * @param Settings_Repository $settings Settings storage.
	 */
	public function __construct( Asset_Registry $assets, Settings_Repository $settings ) {
		$this->assets   = $assets;
		$this->settings = $settings;
	}

	/**
	 * Register WordPress hooks.
	 *
	 * @return void
	 */
	public function register_hooks() {
		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * Attach frontend hooks when optimization is switched on.
	 *
	 * @return void
	 */
	public function init() {
		if ( ! $this->is_optimization_enabled() ) {
			return;
		}

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_optimized_assets' ), 999 );
		add_action( 'admin_init', array( $this, 'maybe_regenerate_assets' ) );
		add_action( 'elementor/frontend/after_register_scripts', array( $this, 'maybe_dequeue_individual_assets' ), 999 );
	}

	/**
	 * Whether optimization is enabled.
	 *
	 * @return bool
	 */
	public function is_optimization_enabled() {
		return (bool) $this->settings->get_optimization( 'enabled', false );
	}

	/**
	 * Turn optimization on or off.
	 *
	 * @param bool $enabled Desired state.
	 * @return bool
	 */
	public function set_optimization_enabled( $enabled ) {
		return $this->settings->set_optimization( 'enabled', (bool) $enabled );
	}

	/**
	 * Stylesheet paths that would be bundled.
	 *
	 * @return array<int, string>
	 */
	public function get_css_paths() {
		/**
		 * Filters the stylesheets included in the optimized bundle.
		 *
		 * @since 1.0.0
		 * @param array<int, string> $paths Absolute paths.
		 */
		return apply_filters( 'decent_elements/optimization/assets/styles', $this->assets->enabled_style_paths() );
	}

	/**
	 * Script paths that would be bundled.
	 *
	 * @return array<int, string>
	 */
	public function get_js_paths() {
		/**
		 * Filters the scripts included in the optimized bundle.
		 *
		 * @since 1.0.0
		 * @param array<int, string> $paths Absolute paths.
		 */
		return apply_filters( 'decent_elements/optimization/assets/scripts', $this->assets->enabled_script_paths() );
	}

	/**
	 * Build both bundles.
	 *
	 * @return bool
	 */
	public function generate_minified_assets() {
		$js  = $this->minify( $this->get_js_paths(), 'js', 'de-scripts.js' );
		$css = $this->minify( $this->get_css_paths(), 'css', 'de-styles.css' );

		if ( ! $js || ! $css ) {
			return false;
		}

		$this->settings->set_optimization( 'last_run', time() );

		return true;
	}

	/**
	 * Rebuild bundles when settings changed or output is missing.
	 *
	 * @return void
	 */
	public function maybe_regenerate_assets() {
		if ( ! $this->is_optimization_enabled() ) {
			return;
		}

		$stale = $this->settings->updated_at() > (int) $this->settings->get_optimization( 'last_run', 0 );

		if ( $stale || ! file_exists( $this->output_path( 'js', 'de-scripts.js' ) ) || ! file_exists( $this->output_path( 'css', 'de-styles.css' ) ) ) {
			$this->generate_minified_assets();
		}
	}

	/**
	 * Enqueue the bundles.
	 *
	 * @return void
	 */
	public function enqueue_optimized_assets() {
		if ( ! $this->is_optimization_enabled() || ! $this->should_load_optimized_assets() ) {
			return;
		}

		$uploads_url = trailingslashit( wp_upload_dir()['baseurl'] ) . self::OUTPUT_DIR . '/';

		$css = $this->output_path( 'css', 'de-styles.css' );

		if ( file_exists( $css ) && filesize( $css ) > 0 ) {
			wp_enqueue_style( 'decent-elements-optimized-styles', $uploads_url . 'css/de-styles.css', array(), (string) filemtime( $css ) );
			add_filter( 'decent_elements_optimized_styles_loaded', '__return_true' );
		}

		$js = $this->output_path( 'js', 'de-scripts.js' );

		if ( file_exists( $js ) && filesize( $js ) > 0 ) {
			wp_enqueue_script( 'decent-elements-optimized-scripts', $uploads_url . 'js/de-scripts.js', array( 'jquery' ), (string) filemtime( $js ), true );
			add_filter( 'decent_elements_optimized_scripts_loaded', '__return_true' );
		}
	}

	/**
	 * Drop individual handles now covered by the bundle.
	 *
	 * Only handles whose files actually made it into the bundle are dropped. The
	 * previous implementation dequeued a handle per enabled module regardless of
	 * whether its bytes were included, which is how the real stylesheet went
	 * missing.
	 *
	 * @return void
	 */
	public function maybe_dequeue_individual_assets() {
		if ( ! $this->is_optimization_enabled() ) {
			return;
		}

		$styles_bundled  = (bool) apply_filters( 'decent_elements_optimized_styles_loaded', false );
		$scripts_bundled = (bool) apply_filters( 'decent_elements_optimized_scripts_loaded', false );

		if ( ! $styles_bundled && ! $scripts_bundled ) {
			return;
		}

		foreach ( $this->assets->enabled_handles() as $handle ) {
			if ( $styles_bundled ) {
				wp_dequeue_style( $handle );
				wp_deregister_style( $handle );
			}

			if ( $scripts_bundled ) {
				wp_dequeue_script( $handle );
				wp_deregister_script( $handle );
			}
		}
	}

	/**
	 * Delete generated bundles and reset their bookkeeping.
	 *
	 * @return void
	 */
	public function clear_optimized_assets() {
		$dir = $this->output_dir();

		if ( is_dir( $dir ) ) {
			$this->delete_directory( $dir );
		}

		$this->settings->set_optimization( 'last_run', 0 );
	}

	/**
	 * Statistics for the admin panel.
	 *
	 * @return array<string, mixed>
	 */
	public function get_optimization_stats() {
		$js  = $this->output_path( 'js', 'de-scripts.js' );
		$css = $this->output_path( 'css', 'de-styles.css' );

		return array(
			'enabled'          => $this->is_optimization_enabled(),
			'last_generated'   => (int) $this->settings->get_optimization( 'last_run', 0 ),
			'js_file_exists'   => file_exists( $js ),
			'css_file_exists'  => file_exists( $css ),
			'js_file_size'     => file_exists( $js ) ? filesize( $js ) : 0,
			'css_file_size'    => file_exists( $css ) ? filesize( $css ) : 0,
			'total_widgets'    => count( $this->assets->enabled_handles() ),
			'total_extensions' => 0,
			'source_js_files'  => count( $this->get_js_paths() ),
			'source_css_files' => count( $this->get_css_paths() ),
		);
	}

	/**
	 * Minify a set of files into one bundle.
	 *
	 * @param array<int, string> $paths     Absolute source paths.
	 * @param string             $type      Either `js` or `css`.
	 * @param string             $file_name Output file name.
	 * @return bool
	 */
	private function minify( array $paths, $type, $file_name ) {
		$output = $this->output_path( $type, $file_name );

		if ( array() === $paths ) {
			// Nothing to bundle. Remove any stale output so the enqueue step
			// does not serve yesterday's bytes.
			if ( file_exists( $output ) ) {
				wp_delete_file( $output );
			}

			return true;
		}

		if ( ! wp_mkdir_p( dirname( $output ) ) ) {
			self::log( 'could not create ' . dirname( $output ) );
			return false;
		}

		try {
			$minifier = 'js' === $type ? new Minify\JS() : new Minify\CSS();

			foreach ( $paths as $path ) {
				if ( file_exists( $path ) ) {
					$minifier->add( $path );
				}
			}

			$minifier->minify( $output );

			$this->settings->set_optimization( $type . '_generated', time() );

			return true;
		} catch ( \Exception $e ) {
			self::log( strtoupper( $type ) . ' minification failed: ' . $e->getMessage() );
			return false;
		}
	}

	/**
	 * Absolute path to the bundle output directory.
	 *
	 * @return string
	 */
	private function output_dir() {
		return trailingslashit( wp_upload_dir()['basedir'] ) . self::OUTPUT_DIR . '/';
	}

	/**
	 * Absolute path to one bundle file.
	 *
	 * @param string $type      Either `js` or `css`.
	 * @param string $file_name Output file name.
	 * @return string
	 */
	private function output_path( $type, $file_name ) {
		return $this->output_dir() . $type . '/' . $file_name;
	}

	/**
	 * Whether the bundles should load on this request.
	 *
	 * @return bool
	 */
	private function should_load_optimized_assets() {
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
	 * Recursively delete a directory beneath the uploads folder.
	 *
	 * The realpath containment check keeps a malformed option value from ever
	 * pointing this at a directory outside uploads.
	 *
	 * @param string $dir Directory to remove.
	 * @return void
	 */
	private function delete_directory( $dir ) {
		$base = realpath( wp_upload_dir()['basedir'] );
		$real = realpath( $dir );

		if ( ! $base || ! $real || 0 !== strpos( $real, $base ) ) {
			self::log( 'refused to delete outside the uploads directory: ' . $dir );
			return;
		}

		$entries = array_diff( (array) scandir( $real ), array( '.', '..' ) );

		foreach ( $entries as $entry ) {
			$path = $real . '/' . $entry;

			if ( is_dir( $path ) ) {
				$this->delete_directory( $path );
			} else {
				wp_delete_file( $path );
			}
		}

		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_rmdir -- WP_Filesystem is not loaded on the frontend; the path is containment-checked above.
		@rmdir( $real );
	}

	/**
	 * Write a diagnostic message to the PHP error log.
	 *
	 * Silent unless WP_DEBUG is on, so production logs stay clean.
	 *
	 * @param string $message Message to log.
	 * @return void
	 */
	private static function log( $message ) {
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log -- Gated on WP_DEBUG.
			error_log( 'Decent Elements: ' . $message );
		}
	}
}
