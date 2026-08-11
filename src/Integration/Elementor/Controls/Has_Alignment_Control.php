<?php
/**
 * Reusable alignment control.
 *
 * @package Decent_Elements
 * @since   1.3.0
 */

namespace Decent_Elements\Integration\Elementor\Controls;

use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || exit;

/**
 * Adds a responsive left/center/right alignment control.
 *
 * This block was duplicated verbatim across five widgets, differing only in the
 * control id and the CSS selector. The control id is a parameter rather than a
 * constant precisely because it must not change: `button` shipped this control
 * as `align` while the others use `alignment`, and renaming either would drop
 * the stored value on every existing page.
 *
 * @since 1.3.0
 */
trait Has_Alignment_Control {

	/**
	 * Register a responsive alignment control.
	 *
	 * @param string               $control_id Control id. MUST match whatever the widget already shipped.
	 * @param string               $selector   CSS selector the alignment applies to.
	 * @param string               $default_value Default alignment.
	 * @param array<string, mixed> $extra      Additional control arguments merged last.
	 * @return void
	 */
	protected function add_alignment_control( $control_id, $selector, $default_value = 'left', array $extra = array() ) {
		$this->add_responsive_control(
			$control_id,
			array_merge(
				array(
					'label'     => __( 'Alignment', 'decent-elements' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => array(
						'left'   => array(
							'title' => __( 'Left', 'decent-elements' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center' => array(
							'title' => __( 'Center', 'decent-elements' ),
							'icon'  => 'eicon-text-align-center',
						),
						'right'  => array(
							'title' => __( 'Right', 'decent-elements' ),
							'icon'  => 'eicon-text-align-right',
						),
					),
					'default'   => $default_value,
					'selectors' => array(
						$selector => 'text-align: {{VALUE}};',
					),
				),
				$extra
			)
		);
	}
}
