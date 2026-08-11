<?php
/**
 * Asset optimization REST endpoints.
 *
 * @package Decent_Elements
 * @since   1.4.0
 */

namespace Decent_Elements\Admin\Rest;

use Decent_Elements\Admin\Optimizer\Asset_Minifier_Manager;

defined( 'ABSPATH' ) || exit;

/**
 * Reads and writes the asset optimizer's settings, and drives its actions.
 *
 * @since 1.4.0
 */
final class Optimization_Controller extends Abstract_Controller {

	/**
	 * Asset optimizer.
	 *
	 * @var Asset_Minifier_Manager
	 */
	private $optimizer;

	/**
	 * Constructor.
	 *
	 * @param Asset_Minifier_Manager $optimizer Asset optimizer.
	 */
	public function __construct( Asset_Minifier_Manager $optimizer ) {
		$this->optimizer = $optimizer;
	}

	/**
	 * Register routes.
	 *
	 * @return void
	 */
	public function register_routes() {
		$this->register(
			'/settings/optimization',
			array(
				array(
					'methods'  => \WP_REST_Server::READABLE,
					'callback' => array( $this, 'get_settings' ),
				),
				array(
					'methods'  => \WP_REST_Server::CREATABLE,
					'callback' => array( $this, 'set_settings' ),
					'args'     => array(
						'enabled' => array(
							'type'        => 'boolean',
							'required'    => true,
							'description' => __( 'Whether asset optimization is enabled.', 'decent-elements' ),
						),
					),
				),
			)
		);

		$this->register(
			'/optimization/stats',
			array(
				'methods'  => \WP_REST_Server::READABLE,
				'callback' => array( $this, 'get_stats' ),
			)
		);

		$this->register(
			'/optimization/generate',
			array(
				'methods'  => \WP_REST_Server::CREATABLE,
				'callback' => array( $this, 'generate' ),
			)
		);

		$this->register(
			'/optimization/clear',
			array(
				'methods'  => \WP_REST_Server::CREATABLE,
				'callback' => array( $this, 'clear' ),
			)
		);
	}

	/**
	 * Read the optimization setting.
	 *
	 * @return \WP_REST_Response
	 */
	public function get_settings() {
		return $this->ok( array( 'enabled' => $this->optimizer->is_optimization_enabled() ) );
	}

	/**
	 * Write the optimization setting.
	 *
	 * @param \WP_REST_Request $request Request.
	 * @return \WP_REST_Response
	 */
	public function set_settings( \WP_REST_Request $request ) {
		$enabled = (bool) $request->get_param( 'enabled' );

		$this->optimizer->set_optimization_enabled( $enabled );

		return $this->ok(
			array( 'enabled' => $enabled ),
			__( 'Optimization settings saved successfully', 'decent-elements' )
		);
	}

	/**
	 * Optimization statistics.
	 *
	 * @return \WP_REST_Response
	 */
	public function get_stats() {
		return $this->ok( $this->optimizer->get_optimization_stats() );
	}

	/**
	 * Build the optimized bundles.
	 *
	 * @return \WP_REST_Response
	 */
	public function generate() {
		if ( ! $this->optimizer->generate_minified_assets() ) {
			return $this->fail(
				__( 'Failed to generate optimized assets. Please check the error log.', 'decent-elements' ),
				500
			);
		}

		return $this->ok( null, __( 'Optimized assets generated successfully', 'decent-elements' ) );
	}

	/**
	 * Delete the optimized bundles.
	 *
	 * @return \WP_REST_Response
	 */
	public function clear() {
		$this->optimizer->clear_optimized_assets();

		return $this->ok( null, __( 'Optimized assets cleared successfully', 'decent-elements' ) );
	}
}
