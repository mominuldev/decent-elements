<?php
/**
 * Base REST controller.
 *
 * @package Decent_Elements
 * @since   1.4.0
 */

namespace Decent_Elements\Admin\Rest;

defined( 'ABSPATH' ) || exit;

/**
 * Shared plumbing for the plugin's REST controllers.
 *
 * The permission check lives here so it cannot be forgotten on a new route.
 * Every previous route repeated the same `permission_callback` by hand, and the
 * one thing they all repeated was wrong — a role name (`administrator`) rather
 * than a capability.
 *
 * @since 1.4.0
 */
abstract class Abstract_Controller {

	/**
	 * Capability required for every route in this plugin.
	 */
	const CAPABILITY = 'manage_options';

	/**
	 * Register this controller's routes.
	 *
	 * @return void
	 */
	abstract public function register_routes();

	/**
	 * REST namespace.
	 *
	 * @return string
	 */
	protected function namespace_name() {
		return DECENT_ELEMENTS_REST_API_ROUTE;
	}

	/**
	 * Permission callback shared by every route.
	 *
	 * A capability, not a role: `current_user_can('administrator')` fails for
	 * multisite super admins and for sites with custom roles.
	 *
	 * @return bool
	 */
	public function check_permission() {
		return current_user_can( self::CAPABILITY );
	}

	/**
	 * Register a route with the shared permission callback applied.
	 *
	 * @param string                   $route    Route path, e.g. `/widgets`.
	 * @param array<int|string, mixed> $handlers One handler array, or a list of them.
	 * @return void
	 */
	protected function register( $route, array $handlers ) {
		// Accept either a single handler or a list of them.
		$is_list = isset( $handlers[0] ) && is_array( $handlers[0] );
		$list    = $is_list ? $handlers : array( $handlers );

		foreach ( $list as $index => $handler ) {
			$list[ $index ]['permission_callback'] = array( $this, 'check_permission' );
		}

		register_rest_route( $this->namespace_name(), $route, $is_list ? $list : $list[0] );
	}

	/**
	 * A successful JSON envelope.
	 *
	 * @param mixed       $data    Payload.
	 * @param string|null $message Optional human-readable message.
	 * @return \WP_REST_Response
	 */
	protected function ok( $data = null, $message = null ) {
		$body = array( 'success' => true );

		if ( null !== $message ) {
			$body['message'] = $message;
		}

		if ( null !== $data ) {
			$body['data'] = $data;
		}

		return new \WP_REST_Response( $body, 200 );
	}

	/**
	 * A failure JSON envelope.
	 *
	 * @param string $message Human-readable message.
	 * @param int    $status  HTTP status code.
	 * @return \WP_REST_Response
	 */
	protected function fail( $message, $status = 400 ) {
		return new \WP_REST_Response(
			array(
				'success' => false,
				'message' => $message,
			),
			$status
		);
	}
}
