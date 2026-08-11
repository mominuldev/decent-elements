<?php
/**
 * Plugin composition root.
 *
 * @package Decent_Elements
 * @since   1.1.0
 */

namespace Decent_Elements;

use Decent_Elements\Admin\Admin_Assets;
use Decent_Elements\Admin\Admin_Menu;
use Decent_Elements\Admin\Rest\Modules_Controller;
use Decent_Elements\Admin\Rest\Optimization_Controller;
use Decent_Elements\Admin\Optimizer\Asset_Minifier_Manager;
use Decent_Elements\Core\Asset_Registry;
use Decent_Elements\Core\Container;
use Decent_Elements\Core\Module_Manager;
use Decent_Elements\Core\Requirements;
use Decent_Elements\Core\Settings_Repository;
use Decent_Elements\Integration\Elementor\Category_Registrar;
use Decent_Elements\Integration\Elementor\Extension_Registrar;
use Decent_Elements\Integration\Elementor\Widget_Registrar;

defined( 'ABSPATH' ) || exit;

/**
 * The plugin's single composition root.
 *
 * WordPress gives a plugin nowhere to inject dependencies, so this class is
 * where the object graph is assembled. Everything below it receives what it
 * needs rather than reaching for a singleton — which is what makes the lower
 * layers testable.
 *
 * @since 1.1.0
 */
final class Plugin {

	/**
	 * Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '8.0';

	/**
	 * Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

	/**
	 * Plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * REST API namespace.
	 */
	const REST_NAMESPACE = 'decent-elements/v1';

	/**
	 * Singleton instance.
	 *
	 * @var Plugin|null
	 */
	private static $instance = null;

	/**
	 * Service container.
	 *
	 * @var Container
	 */
	private $container;

	/**
	 * Absolute path to the main plugin file.
	 *
	 * @var string
	 */
	private $file;

	/**
	 * Constructor.
	 *
	 * @param string $file Absolute path to the main plugin file.
	 */
	private function __construct( $file ) {
		$this->file      = $file;
		$this->container = new Container();

		$this->define_constants();
		$this->register_services();
		$this->register_hooks();
	}

	/**
	 * Boot the plugin.
	 *
	 * @param string $file Absolute path to the main plugin file.
	 * @return Plugin
	 */
	public static function boot( $file ) {
		if ( null === self::$instance ) {
			self::$instance = new self( $file );
		}

		return self::$instance;
	}

	/**
	 * Access the booted instance.
	 *
	 * @return Plugin|null
	 */
	public static function instance() {
		return self::$instance;
	}

	/**
	 * Access the service container.
	 *
	 * @return Container
	 */
	public function container() {
		return $this->container;
	}

	/**
	 * Convenience accessor for a container service.
	 *
	 * @param string $id Service identifier.
	 * @return mixed
	 */
	public function get( $id ) {
		return $this->container->get( $id );
	}

	/**
	 * Define the plugin's global constants.
	 *
	 * Kept for backwards compatibility with widget and extension files, which
	 * still reference them directly.
	 *
	 * @return void
	 */
	private function define_constants() {
		$this->define( 'DECENT_ELEMENTS_DEV', false );
		$this->define( 'DECENT_ELEMENTS_REST_API_ROUTE', self::REST_NAMESPACE );
		$this->define( 'DECENT_ELEMENTS_URL', plugin_dir_url( $this->file ) );
		$this->define( 'DECENT_ELEMENTS_PATH', trailingslashit( plugin_dir_path( $this->file ) ) );
		$this->define( 'DECENT_ELEMENTS_ABSPATH', trailingslashit( dirname( $this->file ) ) );
		$this->define( 'DECENT_ELEMENTS_VERSION', self::VERSION );
		$this->define( 'DECENT_ELEMENTS_ASSETS_URL', DECENT_ELEMENTS_URL . 'assets/' );
	}

	/**
	 * Register every service in the container.
	 *
	 * @return void
	 */
	private function register_services() {
		$this->container->bind(
			Requirements::class,
			static function () {
				return new Requirements( self::MINIMUM_PHP_VERSION, self::MINIMUM_ELEMENTOR_VERSION );
			}
		);

		$this->container->bind(
			Settings_Repository::class,
			static function () {
				return new Settings_Repository();
			}
		);

		$this->container->bind(
			Module_Manager::class,
			static function ( Container $c ) {
				return new Module_Manager( $c->get( Settings_Repository::class ) );
			}
		);

		$this->container->bind(
			Asset_Registry::class,
			static function ( Container $c ) {
				return new Asset_Registry( $c->get( Module_Manager::class ), self::VERSION );
			}
		);

		$this->container->bind(
			Widget_Registrar::class,
			static function ( Container $c ) {
				return new Widget_Registrar( $c->get( Module_Manager::class ) );
			}
		);

		$this->container->bind(
			Extension_Registrar::class,
			static function ( Container $c ) {
				return new Extension_Registrar( $c->get( Module_Manager::class ) );
			}
		);

		$this->container->bind(
			Category_Registrar::class,
			static function () {
				return new Category_Registrar();
			}
		);

		$this->container->bind(
			Admin_Menu::class,
			static function () {
				return new Admin_Menu();
			}
		);

		$this->container->bind(
			Admin_Assets::class,
			static function () {
				return new Admin_Assets();
			}
		);

		$this->container->bind(
			Modules_Controller::class,
			static function ( Container $c ) {
				return new Modules_Controller( $c->get( Module_Manager::class ) );
			}
		);

		$this->container->bind(
			Optimization_Controller::class,
			static function ( Container $c ) {
				return new Optimization_Controller( $c->get( Asset_Minifier_Manager::class ) );
			}
		);

		$this->container->bind(
			Asset_Minifier_Manager::class,
			static function ( Container $c ) {
				return new Asset_Minifier_Manager(
					$c->get( Asset_Registry::class ),
					$c->get( Settings_Repository::class )
				);
			}
		);
	}

	/**
	 * Wire the object graph into WordPress.
	 *
	 * @return void
	 */
	private function register_hooks() {
		add_action( 'init', array( $this, 'load_textdomain' ) );
		add_action( 'plugins_loaded', array( $this, 'migrate_settings' ), 5 );
		add_action( 'plugins_loaded', array( $this, 'init_elementor' ) );

		if ( is_admin() ) {
			$this->container->get( Admin_Menu::class );
			$this->container->get( Admin_Assets::class );
		}

		add_action( 'rest_api_init', array( $this, 'register_rest_routes' ) );

		$this->container->get( Asset_Minifier_Manager::class )->register_hooks();
		$this->container->get( Extension_Registrar::class )->register_hooks();
		$this->container->get( Asset_Registry::class )->register_hooks();
	}

	/**
	 * Register every REST controller's routes.
	 *
	 * @return void
	 */
	public function register_rest_routes() {
		foreach ( array( Modules_Controller::class, Optimization_Controller::class ) as $controller ) {
			$this->container->get( $controller )->register_routes();
		}
	}

	/**
	 * Run the one-time settings migration.
	 *
	 * Hooked on `plugins_loaded` rather than activation, because activation
	 * hooks do not fire when a plugin is updated in place.
	 *
	 * @return void
	 */
	public function migrate_settings() {
		$this->container->get( Settings_Repository::class )->maybe_migrate(
			$this->container->get( Module_Manager::class )->migration_descriptors()
		);
	}

	/**
	 * Load the plugin text domain.
	 *
	 * Must run on `init` or later — WordPress 6.7+ warns when a text domain is
	 * loaded before that point.
	 *
	 * @return void
	 */
	public function load_textdomain() {
		load_plugin_textdomain(
			'decent-elements',
			false,
			dirname( plugin_basename( $this->file ) ) . '/languages'
		);
	}

	/**
	 * Initialise the Elementor integration once requirements are satisfied.
	 *
	 * @return void
	 */
	public function init_elementor() {
		$requirements = $this->container->get( Requirements::class );
		$failures     = $requirements->get_failures();

		if ( array() !== $failures ) {
			$requirements->render_notices( $failures );
			return;
		}

		$this->container->get( Category_Registrar::class )->register_hooks();
		$this->container->get( Widget_Registrar::class )->register_hooks();
	}

	/**
	 * Define a constant if it is not already set.
	 *
	 * @param string $name  Constant name.
	 * @param mixed  $value Constant value.
	 * @return void
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.VariableConstantNameFound -- Every caller passes a DECENT_ELEMENTS_* literal; the sniff cannot see through the variable.
			define( $name, $value );
		}
	}

	/**
	 * Cloning is forbidden.
	 *
	 * @return void
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cloning is forbidden.', 'decent-elements' ), esc_html( self::VERSION ) );
	}

	/**
	 * Unserializing is forbidden.
	 *
	 * @return void
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Unserializing is forbidden.', 'decent-elements' ), esc_html( self::VERSION ) );
	}
}
