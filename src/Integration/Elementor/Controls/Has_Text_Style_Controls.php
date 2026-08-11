<?php
/**
 * Reusable text styling controls.
 *
 * @package Decent_Elements
 * @since   1.3.0
 */

namespace Decent_Elements\Integration\Elementor\Controls;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;

defined( 'ABSPATH' ) || exit;

/**
 * Adds the colour + typography + text-shadow trio that styles a text element.
 *
 * Typography groups alone appear 26 times across the widget set, almost always
 * paired with a colour control against the same selector. Control ids are
 * derived from a caller-supplied prefix so each widget keeps the exact ids it
 * already shipped — `heading_color`, `heading_typography`,
 * `heading_text_shadow`, and so on.
 *
 * @since 1.3.0
 */
trait Has_Text_Style_Controls {

	/**
	 * Register colour, typography and text-shadow controls for one element.
	 *
	 * @param string      $prefix         Control id prefix, e.g. `heading`.
	 * @param string      $selector       CSS selector the styles apply to.
	 * @param string|null $default_color  Default colour, or null for none.
	 * @param bool        $with_shadow    Whether to include the text-shadow group.
	 * @return void
	 */
	protected function add_text_style_controls( $prefix, $selector, $default_color = null, $with_shadow = true ) {
		$color_args = array(
			'label'     => __( 'Color', 'decent-elements' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				$selector => 'color: {{VALUE}};',
			),
		);

		if ( null !== $default_color ) {
			// Position matters only for readability; Elementor keys on the id.
			$color_args = array_merge(
				array(
					'label'   => $color_args['label'],
					'type'    => $color_args['type'],
					'default' => $default_color,
				),
				array( 'selectors' => $color_args['selectors'] )
			);
		}

		$this->add_control( $prefix . '_color', $color_args );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => $prefix . '_typography',
				'selector' => $selector,
			)
		);

		if ( $with_shadow ) {
			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				array(
					'name'     => $prefix . '_text_shadow',
					'selector' => $selector,
				)
			);
		}
	}
}
