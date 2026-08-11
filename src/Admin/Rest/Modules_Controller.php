<?php
/**
 * Module REST endpoints.
 *
 * @package Decent_Elements
 * @since   1.4.0
 */

namespace Decent_Elements\Admin\Rest;

use Decent_Elements\Contracts\Module;
use Decent_Elements\Core\Module_Manager;

defined( 'ABSPATH' ) || exit;

/**
 * Serves the module registry and persists enabled states.
 *
 * The admin panel previously rendered its widget list from a checked-in
 * `widgets.json`. That file listed 47 widgets while the plugin implements 7, so
 * 42 toggles wrote ids the API discarded — silently, behind a success toast —
 * and two real widgets (`dual-color-heading`, `animated-testimonials`) were
 * missing from the file and therefore un-toggleable.
 *
 * The registry is the source of truth now. Presentation metadata travels with
 * each module, so adding a widget means editing one place.
 *
 * @since 1.4.0
 */
final class Modules_Controller extends Abstract_Controller {

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
	 * Register routes.
	 *
	 * @return void
	 */
	public function register_routes() {
		$toggle_args = array(
			'modules' => array(
				'type'        => 'object',
				'required'    => true,
				'description' => __( 'Map of module id to enabled state.', 'decent-elements' ),
			),
		);

		$this->register(
			'/widgets',
			array(
				array(
					'methods'  => \WP_REST_Server::READABLE,
					'callback' => array( $this, 'get_widgets' ),
				),
				array(
					'methods'  => \WP_REST_Server::CREATABLE,
					'callback' => array( $this, 'set_widgets' ),
				),
			)
		);

		$this->register(
			'/extensions',
			array(
				array(
					'methods'  => \WP_REST_Server::READABLE,
					'callback' => array( $this, 'get_extensions' ),
				),
				array(
					'methods'  => \WP_REST_Server::CREATABLE,
					'callback' => array( $this, 'set_extensions' ),
				),
			)
		);

		// Everything the admin panel needs to render, in one request.
		$this->register(
			'/registry',
			array(
				'methods'  => \WP_REST_Server::READABLE,
				'callback' => array( $this, 'get_registry' ),
			)
		);

		unset( $toggle_args );
	}

	/**
	 * The whole registry: categories, widgets and extensions.
	 *
	 * @return \WP_REST_Response
	 */
	public function get_registry() {
		return $this->ok(
			array(
				'categories' => $this->modules->categories(),
				'widgets'    => array_values( $this->collect( Module::TYPE_WIDGET ) ),
				'extensions' => array_values( $this->collect( Module::TYPE_EXTENSION ) ),
			)
		);
	}

	/**
	 * Widgets keyed by bare id.
	 *
	 * Shape preserved from the previous implementation so existing admin code
	 * keeps working during the frontend migration.
	 *
	 * @return \WP_REST_Response
	 */
	public function get_widgets() {
		return new \WP_REST_Response( $this->collect( Module::TYPE_WIDGET ), 200 );
	}

	/**
	 * Extensions keyed by bare id.
	 *
	 * @return \WP_REST_Response
	 */
	public function get_extensions() {
		return new \WP_REST_Response( $this->collect( Module::TYPE_EXTENSION ), 200 );
	}

	/**
	 * Persist widget enabled states.
	 *
	 * @param \WP_REST_Request $request Request.
	 * @return \WP_REST_Response
	 */
	public function set_widgets( \WP_REST_Request $request ) {
		return $this->persist(
			Module::TYPE_WIDGET,
			$request->get_params(),
			__( 'Widget settings saved successfully', 'decent-elements' )
		);
	}

	/**
	 * Persist extension enabled states.
	 *
	 * @param \WP_REST_Request $request Request.
	 * @return \WP_REST_Response
	 */
	public function set_extensions( \WP_REST_Request $request ) {
		return $this->persist(
			Module::TYPE_EXTENSION,
			$request->get_params(),
			__( 'Extension settings saved successfully', 'decent-elements' )
		);
	}

	/**
	 * Build the payload for one module type, keyed by bare id.
	 *
	 * @param string $type One of the Module::TYPE_* constants.
	 * @return array<string, array<string, mixed>>
	 */
	private function collect( $type ) {
		$out = array();

		foreach ( $this->modules->of_type( $type ) as $module ) {
			$meta = $module->meta();

			$out[ $module->id() ] = array(
				'id'       => $module->id(),
				'name'     => $module->title(),
				'enabled'  => $this->modules->is_enabled( $module ),
				'default'  => $module->is_default_enabled(),
				'category' => $meta['category'],
				'icon'     => $meta['icon'],
				'status'   => $meta['status'],
				'demoLink' => $meta['demo_url'],
				'docsLink' => $meta['docs_url'],
			);
		}

		return $out;
	}

	/**
	 * Persist enabled states submitted as bare ids.
	 *
	 * Ids the registry does not recognise are reported back rather than being
	 * silently dropped — that silence is what let the admin panel show a success
	 * toast for 42 toggles that did nothing.
	 *
	 * @param string               $type    One of the Module::TYPE_* constants.
	 * @param array<string, mixed> $params  Request parameters.
	 * @param string               $message Success message.
	 * @return \WP_REST_Response
	 */
	private function persist( $type, array $params, $message ) {
		$known   = $this->modules->of_type( $type );
		$by_id   = array();
		$states  = array();
		$unknown = array();

		foreach ( $known as $key => $module ) {
			$by_id[ $module->id() ] = $key;
		}

		foreach ( $params as $id => $enabled ) {
			// WP_REST_Request exposes route/system params too; skip non-scalars.
			if ( is_array( $enabled ) || is_object( $enabled ) ) {
				continue;
			}

			if ( isset( $by_id[ $id ] ) ) {
				$states[ $by_id[ $id ] ] = (bool) rest_sanitize_boolean( $enabled );
			} else {
				$unknown[] = $id;
			}
		}

		if ( array() === $states ) {
			return $this->fail( __( 'No recognised modules were submitted.', 'decent-elements' ) );
		}

		$this->modules->set_enabled( $states );

		$data = array();

		foreach ( $states as $key => $enabled ) {
			$module = $this->modules->get( $key );

			if ( $module ) {
				$data[ $module->id() ] = $enabled;
			}
		}

		$body = array(
			'success' => true,
			'message' => $message,
			'data'    => $data,
		);

		if ( array() !== $unknown ) {
			$body['ignored'] = array_values( $unknown );
		}

		return new \WP_REST_Response( $body, 200 );
	}
}
