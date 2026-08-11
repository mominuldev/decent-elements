<?php
/**
 * Environment requirement checks.
 *
 * @package Decent_Elements
 * @since   1.1.0
 */

namespace Decent_Elements\Core;

defined( 'ABSPATH' ) || exit;

/**
 * Checks the environment the plugin needs, and renders the admin notices for
 * whatever is missing.
 *
 * Previously this logic lived in the main plugin file as four near-identical
 * notice methods plus inline version_compare() calls, with the required
 * versions duplicated between the check and its message. Here each requirement
 * is declared once and the message is derived from it.
 *
 * @since 1.1.0
 */
final class Requirements {

	/**
	 * Minimum PHP version.
	 *
	 * @var string
	 */
	private $min_php;

	/**
	 * Minimum Elementor version.
	 *
	 * @var string
	 */
	private $min_elementor;

	/**
	 * Constructor.
	 *
	 * @param string $min_php       Minimum PHP version.
	 * @param string $min_elementor Minimum Elementor version.
	 */
	public function __construct( $min_php, $min_elementor ) {
		$this->min_php       = $min_php;
		$this->min_elementor = $min_elementor;
	}

	/**
	 * Collect every unmet requirement.
	 *
	 * @return array<int, string> Human-readable, already-escaped messages.
	 */
	public function get_failures() {
		$failures = array();

		if ( version_compare( PHP_VERSION, $this->min_php, '<' ) ) {
			$failures[] = $this->format_version_notice(
				esc_html__( 'PHP', 'decent-elements' ),
				$this->min_php
			);
		}

		if ( ! did_action( 'elementor/loaded' ) ) {
			$failures[] = sprintf(
				/* translators: 1: plugin name, 2: Elementor */
				esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'decent-elements' ),
				'<strong>' . esc_html__( 'Decent Elements', 'decent-elements' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 'decent-elements' ) . '</strong>'
			);

			// No point version-checking something that is not loaded.
			return $failures;
		}

		if ( ! version_compare( ELEMENTOR_VERSION, $this->min_elementor, '>=' ) ) {
			$failures[] = $this->format_version_notice(
				esc_html__( 'Elementor', 'decent-elements' ),
				$this->min_elementor
			);
		}

		return $failures;
	}

	/**
	 * Whether every requirement is met.
	 *
	 * @return bool
	 */
	public function are_met() {
		return array() === $this->get_failures();
	}

	/**
	 * Hook the failure notices into the admin.
	 *
	 * @param array<int, string> $failures Messages from get_failures().
	 * @return void
	 */
	public function render_notices( array $failures ) {
		if ( array() === $failures ) {
			return;
		}

		add_action(
			'admin_notices',
			static function () use ( $failures ) {
				foreach ( $failures as $message ) {
					printf(
						'<div class="notice notice-warning is-dismissible"><p>%s</p></div>',
						wp_kses( $message, array( 'strong' => array() ) )
					);
				}
			}
		);
	}

	/**
	 * Build a "requires X version Y or greater" message.
	 *
	 * @param string $dependency Already-escaped dependency name.
	 * @param string $version    Required version.
	 * @return string
	 */
	private function format_version_notice( $dependency, $version ) {
		return sprintf(
			/* translators: 1: plugin name, 2: dependency name, 3: version number */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'decent-elements' ),
			'<strong>' . esc_html__( 'Decent Elements', 'decent-elements' ) . '</strong>',
			'<strong>' . $dependency . '</strong>',
			esc_html( $version )
		);
	}
}
