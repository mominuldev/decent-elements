<?php
/**
 * Heading widget.
 *
 * @package Decent_Elements
 * @since   1.0.0
 */

namespace Decent_Elements\Modules\Heading;

use Decent_Elements\Integration\Elementor\Abstract_Widget;
use Decent_Elements\Integration\Elementor\Controls\Has_Alignment_Control;
use Decent_Elements\Integration\Elementor\Controls\Has_Text_Style_Controls;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || exit;

/**
 * Renders a heading with configurable tag, alignment and typography.
 *
 * Migrated from the global class `Decent_Elements_Heading_Widget`. The class
 * name changed; `get_name()` and every control id did not — those are stored in
 * `_elementor_data` and are frozen for the lifetime of the widget.
 *
 * @since 1.0.0
 */
final class Heading_Widget extends Abstract_Widget {

	use Has_Alignment_Control;
	use Has_Text_Style_Controls;

	/**
	 * CSS selector for the heading element.
	 */
	const SELECTOR = '{{WRAPPER}} .de-heading';

	/**
	 * Widget name.
	 *
	 * Frozen. Stored in `_elementor_data` on every page using this widget.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'de-heading';
	}

	/**
	 * Widget title.
	 *
	 * @return string
	 */
	public function get_title() {
		return __( 'Decent Heading', 'decent-elements' );
	}

	/**
	 * Widget icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-heading';
	}

	/**
	 * Register widget controls.
	 *
	 * @return void
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => __( 'Content', 'decent-elements' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'heading_text',
			array(
				'label'       => __( 'Heading Text', 'decent-elements' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Your Heading Text', 'decent-elements' ),
				'placeholder' => __( 'Enter your heading', 'decent-elements' ),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'heading_tag',
			array(
				'label'   => __( 'HTML Tag', 'decent-elements' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
				),
				'default' => 'h2',
			)
		);

		$this->add_alignment_control( 'alignment', self::SELECTOR );

		$this->end_controls_section();

		$this->start_controls_section(
			'style_section',
			array(
				'label' => __( 'Style', 'decent-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_text_style_controls( 'heading', self::SELECTOR, '#333333' );

		$this->add_responsive_control(
			'heading_margin',
			array(
				'label'      => __( 'Margin', 'decent-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					self::SELECTOR => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget on the frontend.
	 *
	 * @return void
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$renderer = new Renderer();

		$data = $renderer->prepare( $settings );

		if ( null === $data ) {
			return;
		}

		$this->render_view( 'heading', $data );
	}

	/**
	 * Render the widget in the editor.
	 *
	 * @return void
	 */
	protected function content_template() {
		?>
		<#
		var headingTag  = elementor.helpers.validateHTMLTag( settings.heading_tag || 'h2' );
		var headingText = settings.heading_text;

		if ( headingText ) {
		#>
			<{{{ headingTag }}} class="de-heading">{{{ headingText }}}</{{{ headingTag }}}>
		<#
		}
		#>
		<?php
	}
}
