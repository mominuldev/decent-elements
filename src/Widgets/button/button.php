<?php
/**
 * Button Widget
 *
 * @since 1.0.0
 */
if (!defined('ABSPATH')) {
	exit;
}

use Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Border;

class Button extends Widget_Base
{

	public function get_name()
	{
		return 'de-button';
	}

	public function get_title()
	{
		return esc_html__('Button', 'decent-elements');
	}

	public function get_icon()
	{
		return 'eicon-button de-elements-icon';
	}

	public function get_categories()
	{
		return ['heading.php'];
	}

	public function get_keywords()
	{
		return ['button', 'link', 'btn', 'advance', 'tc'];
	}

	public static function get_button_sizes()
	{
		return [
			'btn-xs' => __('Extra Small', 'decent-elements'),
			'btn-sm' => __('Small', 'decent-elements'),
			'btn-md' => __('Medium', 'decent-elements'),
			'btn-lg' => __('Large', 'decent-elements'),
			'btn-xl' => __('Extra Large', 'decent-elements'),
		];
	}

	// Script Enqueue
	public function get_script_depends()
	{
		return [
			'button',
		];
	}

	// Style Enqueue
//	public function get_style_depends()
//	{
//		return [
//			'fresco',
//		];
//	}


	/**
	 * Register button widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls()
	{
		$this->start_controls_section(
			'section_button',
			[
				'label' => __('Button', 'decent-elements'),
			]
		);

		$this->add_control(
			'button_type',
			[
				'label'   => __('Button Type', 'decent-elements'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'btn-solid',
				'options' => [
					'btn-solid'        => __('Solid', 'decent-elements'),
					'de-btn-split'     => __('Split', 'decent-elements'),
					'de-btn-fancy'    => __('Fancy', 'decent-elements'),
					'de-btn-liquid'    => __('Liquid', 'decent-elements'),
					'btn-outline'      => __('Outline', 'decent-elements'),
					'de-btn-play'      => __('Play', 'decent-elements'),
					'de-btn-link'      => __('Plain', 'decent-elements'),
					'de-btn-underline' => __('Underline', 'decent-elements'),
				],
			]
		);
		$this->add_control(
			'button_type_style',
			[
				'label'   => __('Button Type', 'decent-elements'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'btn-split-one',
				'options' => [
					'btn-split-one'        => __('Style One', 'decent-elements'),
					'btn-split-two'        => __('Style Two', 'decent-elements'),
				],
			]
		);
		$this->add_control(
			'text',
			[
				'label'       => __('Button Label', 'decent-elements'),
				'type'        => Controls_Manager::TEXT,
				'default'     => __('Learn More', 'decent-elements'),
				'placeholder' => __('Button Text', 'decent-elements'),
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);


		// Link Type
		$this->add_control(
			'link_type',
			[
				'label'   => __('Link Type', 'decent-elements'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'url',
				'options' => [
					'url'          => __('URL', 'decent-elements'),
					'lightbox'     => __('Light Box', 'decent-elements'),
					'local_scroll' => __('Local Scroll', 'decent-elements'),
					//                    'scroll_to_section' => __('Scroll to Section Bellow', 'decent-elements'),
				],
			]
		);


		$this->add_control(
			'link',
			[
				'label'       => __('Link', 'decent-elements'),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'http://your-link.com',
				'default'     => [
					'url' => '#',
				],
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		// Scroll Speed
		$this->add_control(
			'offset',
			[
				'label'     => __('Offset', 'decent-elements'),
				'type'      => Controls_Manager::NUMBER,
				'condition' => [
					'link_type' => 'local_scroll',
				],
			]
		);

		$this->add_control(
			'scroll_speed',
			[
				'label'     => __('Scroll Speed', 'decent-elements'),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 800,
				'condition' => [
					'link_type' => 'local_scroll',
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'        => __('Alignment', 'decent-elements'),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'left'   => [
						'title' => __('Left', 'decent-elements'),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __('Center', 'decent-elements'),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => __('Right', 'decent-elements'),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default'      => '',
			]
		);

		// Responsive Block
		$this->add_control(
			'responsive_block',
			[
				'label'        => __('Responsive Block', 'decent-elements'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('On', 'decent-elements'),
				'label_off'    => __('Off', 'decent-elements'),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [
					'button_type' => ['btn-solid', 'btn-outline', 'de-btn-fancy'],
				]
			]
		);

		$this->add_responsive_control(
			'button_justify_content',
			[
				'label' => esc_html__('Text Justify Content', 'decent-elements'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__('Start', 'decent-elements'),
						'icon' => 'eicon-flex eicon-justify-start-h',
					],
					'center' => [
						'title' => esc_html__('Center', 'decent-elements'),
						'icon' => 'eicon-flex eicon-justify-center-h',
					],
					'flex-end' => [
						'title' => esc_html__('End', 'decent-elements'),
						'icon' => 'eicon-flex eicon-justify-end-h',
					],
					'space-between' => [
						'title' => esc_html__('Space Between', 'decent-elements'),
						'icon' => 'eicon-flex eicon-justify-space-between-h',
					],
					'space-around' => [
						'title' => esc_html__('Space Around', 'decent-elements'),
						'icon' => 'eicon-flex eicon-justify-space-around-h',
					],
					'space-evenly' => [
						'title' => esc_html__('Space Evenly', 'decent-elements'),
						'icon' => 'eicon-flex eicon-justify-space-evenly-h',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .de-btn-content-wrapper' => 'justify-content: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();

		// Button Style Sections
		//======================
		$this->start_controls_section(
			'section_button_shape_style',
			[
				'label' => __('Button Style', 'decent-elements'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'button_fill_color',
			[
				'label'     => __('Fill Color', 'decent-elements'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'btn-default',
				'options'   => [
					'btn-default'  => __('Default', 'decent-elements'),
					'btn-light'    => __('Light', 'decent-elements'),
					'btn-dark'     => __('Dark', 'decent-elements'),
					'btn-gradient' => __('Gradient', 'decent-elements'),
				],
				'condition' => [
					'button_type!' => ['de-btn-link', 'de-btn-underline'],
				],
			]
		);


		$this->add_control(
			'button_shape',
			[
				'label'     => __('Rounded', 'decent-elements'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'btn-round',
				'options'   => [
					'btn-square' => __('Square', 'decent-elements'),
					'btn-round'  => __('Round', 'decent-elements'),
					'btn-circle' => __('Circle', 'decent-elements'),
				],
				'condition' => [
					'button_type!' => ['de-btn-link', 'de-btn-underline'],
				],
			]
		);


		$this->add_control(
			'button_size',
			[
				'label'   => __('Size', 'decent-elements'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'btn-md',
				'options' => $this->get_button_sizes(),
			]
		);

		// Width, auto and full width
		$this->add_control(
			'button_width',
			[
				'label'     => __('Width', 'decent-elements'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'auto',
				'options'   => [
					'auto'           => __('Auto', 'decent-elements'),
					'btn-full-width' => __('Full Width', 'decent-elements'),
				],
				'condition' => [
					'button_type!' => ['de-btn-link', 'de-btn-underline'],
				],
			]
		);

		// Enable Instagram Button Style
		$this->add_control(
			'enable_instagram_style',
			[
				'label'        => __('Enable Instagram Style', 'decent-elements'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('On', 'decent-elements'),
				'label_off'    => __('Off', 'decent-elements'),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [
					'button_type' => 'btn-solid',
				],
			]
		);

		$this->end_controls_section();


		// Button Icon Section
		//======================
		$this->start_controls_section(
			'section_icon',
			[
				'label'     => __('Button Icon', 'decent-elements'),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'selected_icon!' => '',
				],
			]
		);

		// Enable Icon
		$this->add_control(
			'enable_icon',
			[
				'label'        => __('Add Icon', 'decent-elements'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('On', 'decent-elements'),
				'label_off'    => __('Off', 'decent-elements'),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control('selected_icon', [
			'label'            => __('Icon', 'decent-elements'),
			'type'             => Controls_Manager::ICONS,
			'fa4compatibility' => 'icon',
			'label_block'      => true,
			'condition'        => [
				'enable_icon' => 'yes',
			],
			'default'          => [
				'value'   => 'fas fa-arrow-right',
				'library' => 'fa-solid',
			]

		]);

		// Icon Position (Choose Control)
		$this->add_control(
			'icon_position',
			[
				'label'     => __('Icon Position', 'decent-elements'),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'right',
				'options'   => [
					'left'   => [
						'title' => __('Before', 'decent-elements'),
						'icon'  => 'eicon-arrow-left',
					],
					'right'  => [
						'title' => __('After', 'decent-elements'),
						'icon'  => 'eicon-arrow-right',
					],
					'top'    => [
						'title' => __('Top', 'decent-elements'),
						'icon'  => 'eicon-arrow-up',
					],
					'bottom' => [
						'title' => __('Bottom', 'decent-elements'),
						'icon'  => 'eicon-arrow-down',
					],
				],
				'condition' => [
					'enable_icon'    => 'yes',
					'selected_icon!' => '',
					'btn_type!'      => ['de-btn-fancy', 'de-btn-liquid', 'de-btn-play'],
				],
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label'      => __('Icon Spacing', 'decent-elements'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em'],
				'range'      => [
					'px' => [
						'max' => 50,
					],
				],
				'default'    => [
					'size' => 8,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .de-btn-content-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'selected_icon!' => '',
					'enable_icon'    => 'yes',
					'text!'          => '',
					'button_type!'   => ['de-btn-play', 'de-btn-liquid'],
				],
			]
		);

		$this->add_control(
			'icon_width',
			[
				'label'      => __('Icon Width', 'decent-elements'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', '%', 'em', 'rem', 'custom'],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
					'%'  => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => 60,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .bc-split-btn > span.btn-split-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; --icon-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .de-btn-split .de-btn-content-wrapper .de-btn-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; --icon-width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'selected_icon!' => '',
					'enable_icon'    => 'yes',
					'button_type'    => 'de-btn-split',
				],
			]
		);

		// Icon Shape
		$this->add_control(
			'icon_shape_style',
			[
				'label'     => __('Icon Shape Style', 'decent-elements'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'btn-icon-shape-default',
				'options'   => [
					'btn-icon-shape-default' => __('Default', 'decent-elements'),
					'btn-icon-shape-solid'   => __('Solid', 'decent-elements'),
					'btn-icon-shape-outline' => __('Outline', 'decent-elements'),
				],
				'condition' => [
					'enable_icon' => 'yes',
					'button_type!'       => ['de-btn-liquid', 'de-btn-fancy'],
				],
			]
		);

		$this->add_control(
			'icon_shape',
			[
				'label'     => __('Icon Shape', 'decent-elements'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'btn-shape-none',
				'options'   => [
					'btn-shape-none'  => __('Default', 'decent-elements'),
					'btn-icon-square' => __('Square', 'decent-elements'),
					'btn-icon-round'  => __('Round', 'decent-elements'),
					'btn-icon-circle' => __('Circle', 'decent-elements'),
				],
				'condition' => [
					'enable_icon'       => 'yes',
					'icon_shape_style!' => 'btn-icon-shape-default',
					'button_type!'       => ['de-btn-liquid', 'de-btn-fancy'],
				],
			]
		);

		// Play button icon wrapper height/width
		$this->add_control(
			'play_icon_wrapper_size',
			[
				'label'      => __('Play Icon Wrapper Size', 'decent-elements'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 200,
					],
					'%'  => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => 80,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .de-btn-play .de-btn-play-icon-wrapper' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'enable_icon' => 'yes',
					'button_type' => 'de-btn-play',
				],
			]
		);

		// Icon Ripple Effect Enabled
		$this->add_control(
			'icon_ripple_effect',
			[
				'label'        => __('Ripple Effect', 'decent-elements'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('On', 'decent-elements'),
				'label_off'    => __('Off', 'decent-elements'),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [
					'enable_icon'       => 'yes',
					'icon_shape_style!' => 'btn-icon-shape-default',
					'button_type'       => 'plain',
				],
			]
		);

		$this->end_controls_section();

		// Style Section
		//======================

		$this->start_controls_section(
			'section_style',
			[
				'label' => __('Button', 'decent-elements'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography',
				'label'    => __('Typography', 'decent-elements'),
				'selector' => '{{WRAPPER}} .de-btn, {{WRAPPER}} .de-btn-text, {{WRAPPER}} .de-btn-link, {{WRAPPER}} .de-btn-underline, {{WRAPPER}} .de-btn-play .de-btn-text',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label'      => __('Border Radius', 'decent-elements'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} a.de-btn, {{WRAPPER}} .de-btn, {{WRAPPER}} .de-btn-play, {{WRAPPER}} .de-btn-liquid' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'button_type!' => ['de-btn-link', 'de-btn-underline'],
				],
			]
		);

		$this->add_control(
			'btn_padding',
			[
				'label'      => __('Padding', 'decent-elements'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors'  => [
					'{{WRAPPER}} a.de-btn, {{WRAPPER}} .de-btn, {{WRAPPER}} .de-btn-play .de-btn-text, {{WRAPPER}} .de-btn-underline .de-btn-text, {{WRAPPER}} .de-btn-fancy .de-btn-text, {{WRAPPER}} .de-btn-liquid .de-btn-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'button_type!' => ['de-btn-link'],
				],
			]
		);

		// Icon Size
		$this->add_control(
			'icon_size',
			[
				'label'      => __('Icon Size', 'decent-elements'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em'],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
					'em' => [
						'min'  => 0.1,
						'max'  => 10,
						'step' => 0.1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .de-btn-icon'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .de-btn-icon svg' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'selected_icon!' => '',
				],
			]
		);

		// Icon Padding
		$this->add_control(
			'icon_padding',
			[
				'label'      => __('Icon Padding', 'decent-elements'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors'  => [
					'{{WRAPPER}} .de-btn-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'selected_icon!' => '',
				],
			]
		);

		$this->add_control(
			'icon_border_radius',
			[
				'label'      => __('Border Radius', 'decent-elements'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .de-btn-liquid .de-btn-content-wrapper:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'button_type' => ['de-btn-liquid'],
				],
			]
		);

		// Underline Thickness
		$this->add_control(
			'underline_thickness',
			[
				'label'      => __('Underline Thickness', 'decent-elements'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .de-btn-underline .de-btn-text:after' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'button_type' => 'de-btn-underline',
				],
			]
		);

		// Bottom Position
		$this->add_control(
			'underline_bottom_position',
			[
				'label'      => __('Border Bottom Position', 'decent-elements'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min' => -30,
						'max' => 10,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .de-btn-underline .de-btn-text:after' => 'bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'button_type' => 'de-btn-underline',
				],
			]
		);

		$this->start_controls_tabs('tabs_button_style');

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => __('Normal', 'decent-elements'),
			]
		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'button_bg_color',
				'label'    => __('Background', 'decent-elements'),
				'types'    => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .de-btn, {{WRAPPER}} .de-btn-play .de-btn-text, {{WRAPPER}} .de-btn-fancy, {{WRAPPER}} .de-btn-split .de-btn-content-wrapper .de-btn-text, {{WRAPPER}} .de-btn-liquid',
				'condition' => [
					'button_type!' => ['de-btn-link', 'de-btn-underline'],
				],
			]
		);


		$this->add_control(
			'button_text_bg_color',
			[
				'label'     => __('Text BG Color', 'decent-elements'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .de-btn-fancy .de-btn-text, {{WRAPPER}} .de-btn-fancy .de-btn-content-wrapper:before' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'button_type' => ['de-btn-fancy'],
				],
			]
		);


		// Background Backdrop Filter blur
		$this->add_control(
			'button_bg_blur',
			[
				'label'      => __('Background Blur', 'decent-elements'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em'],
				'separator'  => 'before',
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
					'em' => [
						'min' => 0,
						'max' => 5,
					],
				],
				'default'    => [
					'size' => 0,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .de-btn, {{WRAPPER}} .de-btn-play' => 'backdrop-filter: blur({{SIZE}}{{UNIT}});',
				],
				//                'condition' => [
				//                    'button_type!' => ['de-btn-link', 'de-btn-underline'],
				//                    'button_bg_color_type!' => 'normal',
				//                ],
			]
		);

		// Icon wrap background color
		$this->add_control(
			'icon_wrap_background_color',
			[
				'label'     => __('Icon Wrap BG Color', 'decent-elements'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .de-btn-play-icon-wrapper' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'selected_icon!' => '',
					'button_type'    => ['de-btn-play'],
				],
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => __('Text Color', 'decent-elements'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} a.de-btn, {{WRAPPER}} .de-btn-link .de-btn-text, {{WRAPPER}} .de-btn-underline .de-btn-text, {{WRAPPER}} .de-btn-play .de-btn-text, {{WRAPPER}} .de-btn-split .de-btn-content-wrapper .de-btn-text, {{WRAPPER}} .de-btn-fancy .de-btn-text, {{WRAPPER}} .de-btn-fancy:hover i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .de-btn-underline .de-btn-text:after'                                                                                                                                                               => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .de-btn-fancy:hover svg path'                                                                                                                   => 'fill: {{VALUE}};',
					'{{WRAPPER}} .de-btn-liquid'                                                                                                                   => 'fill: {{VALUE}};',

				],
			]
		);

		// Icon Color
		$this->add_control(
			'icon_color',
			[
				'label'     => __('Icon Color', 'decent-elements'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .de-btn-icon i'        => 'color: {{VALUE}};',
					'{{WRAPPER}} .de-btn-icon svg path' => 'fill: {{VALUE}};',

				],
				'condition' => [
					'selected_icon!' => '',
				],
			]
		);

		// Icon Border Color
		$this->add_control(
			'icon_border_color',
			[
				'label'     => __('Icon Border Color', 'decent-elements'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .de-btn-icon' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'selected_icon!' => '',
				],
			]
		);

		// Icon Background Color
		$this->add_control(
			'icon_background_color',
			[
				'label'     => __('Icon BG Color', 'decent-elements'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .de-btn-icon' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'selected_icon!' => '',
					//					'button_type'    => 'de-btn-link',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'border',
				'label'     => __('Border', 'decent-elements'),
				'selector'  => '{{WRAPPER}} .de-btn',
				'condition' => [
					'button_type!' => 'de-btn-link',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'box_shadow',
				'label'     => __('Box Shadow', 'decent-elements'),
				'selector'  => '{{WRAPPER}} .de-btn',
				'condition' => [
					'button_type!' => 'de-btn-link',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => __('Hover', 'decent-elements'),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'background_color_hover',
				'label'     => __('Background', 'decent-elements'),
				'types'     => ['classic', 'image'],
				'selector'  => '{{WRAPPER}} .de-btn:hover, {{WRAPPER}} .de-btn-play:hover .de-btn-text, {{WRAPPER}} .de-btn-split:hover .de-btn-content-wrapper .de-btn-text',
				'condition' => [
					'button_type!' => ['de-btn-link']
				],
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label'     => __('Text Color', 'decent-elements'),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .de-btn:hover, {{WRAPPER}} .de-btn-link:hover .de-btn-text, {{WRAPPER}} .de-btn-underline:hover .de-btn-text,  {{WRAPPER}} .de-btn-outline:hover .de-btn-text, {{WRAPPER}} .de-btn-play:hover .de-btn-text, {{WRAPPER}} .de-btn-split:hover .de-btn-content-wrapper .de-btn-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .de-btn-underline .de-btn-text:hover:after'                                                                                                                                                                                                                                       => 'background-color: {{VALUE}};',
				],
			]
		);


		// Icon Hover Color
		$this->add_control(
			'icon_color_hover',
			[
				'label'     => __('Icon Color', 'decent-elements'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .de-btn:hover .de-btn-icon i, {{WRAPPER}} .de-btn-play:hover .de-btn-icon i, {{WRAPPER}} .de-btn-split:hover .de-btn-icon i'                      => 'color: {{VALUE}};',
					'{{WRAPPER}} .de-btn:hover .de-btn-icon svg path, {{WRAPPER}} .de-btn-play:hover .de-btn-icon svg path, {{WRAPPER}} .de-btn-split:hover .de-btn-icon svg path' => 'fill: {{VALUE}};',
					'{{WRAPPER}} .de-btn-link:hover .de-btn-icon i'                                                                                                                => 'color: {{VALUE}};',
					'{{WRAPPER}} .de-btn-underline:hover .de-btn-icon i'                                                                                                           => 'color: {{VALUE}};',
					'{{WRAPPER}} .de-btn-link:hover .de-btn-icon svg path'                                                                                                         => 'fill: {{VALUE}};',
					'{{WRAPPER}} .de-btn-underline:hover .de-btn-icon svg path'                                                                                                    => 'fill: {{VALUE}};',
				],
				'condition' => [
					'selected_icon!' => '',
				],
			]
		);

		// Icon Hover Background Color
		$this->add_control(
			'icon_background_color_hover',
			[
				'label'     => __('Icon Background Color', 'decent-elements'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .de-btn:hover .de-btn-icon, {{WRAPPER}} .de-btn-play:hover .de-btn-icon, {{WRAPPER}} .de-btn-split:hover .de-btn-iconn' => 'background: {{VALUE}};',
				],
				'condition' => [
					'selected_icon!' => '',
					//					'button_type'    => 'de-btn-link',
				],
			]
		);

		// Icon Border Color
		$this->add_control(
			'icon_border_color_hover',
			[
				'label'     => __('Icon Border Color', 'decent-elements'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .de-btn:hover .de-btn-icon, {{WRAPPER}} .de-btn-play:hover .de-btn-icon, {{WRAPPER}} .de-btn-split:hover .de-btn-icon' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'selected_icon!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'border_hover',
				'label'     => __('Border', 'decent-elements'),
				'selector'  => '{{WRAPPER}} .de-btn:hover',
				'condition' => [
					'button_type!' => 'de-btn-link',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'btn_box_shadow_hover',
				'label'     => __('Box Shadow', 'decent-elements'),
				'selector'  => '{{WRAPPER}} .de-btn:hover',
				'condition' => [
					'button_type!' => 'de-btn-link',
				]
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	/**
	 * Render button widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render()
	{
		$settings = $this->get_settings_for_display();
		$this->add_render_attribute('button', 'class', 'bc-button');
		$this->add_render_attribute('wrapper', 'class', 'de-btn-wrapper');

		if (!empty($settings['link']['url'])) {
			$this->add_render_attribute('button', 'href', $settings['link']['url']);

			if ($settings['link']['is_external']) {
				$this->add_render_attribute('button', 'target', '_blank');
			}

			if ($settings['link']['nofollow']) {
				$this->add_render_attribute('button', 'rel', 'nofollow');
			}
		}

		if ($settings['link_type'] == 'lightbox') {
			$this->add_render_attribute('button', 'class', 'fresco');
		}

		if ('yes' == $settings['responsive_block']) {
			$this->add_render_attribute('button', 'class', 'de-btn-responsive-block');
		}
		// Instagram Button style
		if ('yes' == $settings['enable_instagram_style']) {
			$this->add_render_attribute('button', 'class', 'instagram-btn');
		}

		// Local Scroll
		if ($settings['link_type'] == 'local_scroll') {
			$this->add_render_attribute('button', [
				'class'              => 'de-btn-local-scroll',
				'data-target-offset' => $settings['offset'] ?? 0,
			]);
		}

		if ($settings['button_type'] == 'btn-solid' || $settings['button_type'] == 'btn-outline') {
			$this->add_render_attribute('button', 'class', 'de-btn');
		}
		if ($settings['button_type'] == 'de-btn-split') {
			$this->add_render_attribute('button', 'class', $settings['button_type_style']);
		}

		if (!empty($settings['button_type'])) {
			$this->add_render_attribute('button', 'class', $settings['button_type']);
		}

		if (!empty($settings['button_shape'])) {
			$this->add_render_attribute('button', 'class', $settings['button_shape']);
		}

		if (!empty($settings['button_size'])) {
			$this->add_render_attribute('button', 'class', $settings['button_size']);
		}

		// Button Width
		if (!empty($settings['button_width'])) {
			$this->add_render_attribute('button', 'class', $settings['button_width']);
		}


		// Button Fill Color
		if (!empty($settings['button_fill_color'])) {
			$this->add_render_attribute('button', 'class', $settings['button_fill_color']);
		}

?>

		<a <?php echo $this->get_render_attribute_string('button'); ?>>
			<?php $this->render_text(); ?>
		</a>

	<?php
	}


	protected function content_template()
	{
	?>
		<#
			view.addRenderAttribute( 'text' , 'class' , 'de-btn-text' );
			view.addInlineEditingAttributes( 'text' , 'none' );
			// Data Text Attributes
			view.addRenderAttribute( 'text' , 'data-text' , settings.text );

			var iconHTML=elementor.helpers.renderIcon( view, settings.selected_icon, { 'aria-hidden' : true }, 'i' , 'object' );

			if( settings.button_type=='btn-solid' || settings.button_type=='btn-outline' ) {
			view.addRenderAttribute( 'button' , 'class' , 'de-btn' );
			}

			if( settings.responsive_block ) {
			view.addRenderAttribute( 'button' , 'class' , 'de-btn-responsive-block' );
			}

			// Instagram Style
			if( settings.enable_instagram_style==='yes' ) {
			view.addRenderAttribute( 'button' , 'class' , 'instagram-btn' );
			}

			view.addRenderAttribute( 'button' , 'class' , settings.button_shape );
			view.addRenderAttribute( 'button' , 'class' , settings.button_size );
			view.addRenderAttribute( 'button' , 'class' , settings.button_width );
			view.addRenderAttribute( 'button' , 'class' , settings.button_type );
			view.addRenderAttribute( 'button' , 'class' , settings.button_fill_color );
			// Hover Animation
			view.addRenderAttribute( 'button' , 'class' , 'elementor-animation-' + settings.hover_animation );

			// Link
			view.addRenderAttribute( 'button' , 'href' , settings.link.url );

			// Icon Class

			if( settings.button_type !='de-btn-fancy' || settings.button_type !='de-btn-liquid' ) {
			view.addRenderAttribute( 'icon-align' , 'class' , 'elementor-align-icon-' + settings.icon_position );
			}


			if( settings.icon_position ) {
			view.addRenderAttribute( 'icon-align' , 'class' , 'de-btn-icon' );
			}

			// Icon Shape
			if( settings.icon_shape_style ) {
			view.addRenderAttribute( 'icon-align' , 'class' , settings.icon_shape_style );
			}

			// Icon Shape
			if( settings.icon_shape ) {
			view.addRenderAttribute( 'icon-align' , 'class' , settings.icon_shape );
			}

			// Ripple Effect
			if( settings.icon_ripple_effect==='yes' ) {
			view.addRenderAttribute( 'icon-align' , 'class' , 'ripple-effect' );
			}

			// Button Content wrapper
			view.addRenderAttribute( 'content-wrapper' , 'class' , 'de-btn-content-wrapper' );
			// Icon position top wrapper class
			if( 'top'===settings.icon_position ) {
			view.addRenderAttribute( 'content-wrapper' , 'class' , 'de-btn-icon-top' );
			}

			// Icon position bottom wrapper class
			if( 'bottom'===settings.icon_position ) {
			view.addRenderAttribute( 'content-wrapper' , 'class' , 'de-btn-icon-bottom' );
			}


			#>
			<div class="de-btn-wrapper">
				<a {{{ view.getRenderAttributeString( 'button' ) }}}>
					<span {{{ view.getRenderAttributeString( 'content-wrapper' ) }}}">
						<# if('yes'===settings.enable_icon) { #>
							<# if('de-btn-play'===settings.button_type) { #>
								<span class="de-btn-play-icon-wrapper">
									<# } #>
										<# if( settings.selected_icon && settings.selected_icon.value ) { #>
											<span {{{ view.getRenderAttributeString( 'icon-align' ) }}}>
												{{{ iconHTML.value }}}
											</span>
											<# } #>

												<# if('de-btn-play'===settings.button_type) { #>
								</span>
								<# } #>
									<# } #>

										<span {{{ view.getRenderAttributeString( 'text' ) }}}>
											<span>{{{ settings.text }}}</span>
										</span>

										<# if('yes'===settings.enable_icon && 'de-btn-split'===settings.button_type) { #>
											<# if( settings.selected_icon ) { #>
												<span {{{ view.getRenderAttributeString( 'icon-align' ) }}}>
													{{{ iconHTML.value }}}
												</span>
												<# } #>
													<# } #>
					</span>
				</a>
			</div>
		<?php
	}

	/**
	 * Render button text.
	 * Render button widget text.
	 * @since 1.5.0
	 * @access protected
	 */
	protected function render_text()
	{
		$settings = $this->get_settings();
		$this->add_render_attribute('content-wrapper', 'class', 'de-btn-content-wrapper');


		if ($settings['button_type'] !== 'de-btn-fancy' || $settings['button_type'] !== 'de-btn-liquid') {
			$this->add_render_attribute('icon-align', 'class', 'elementor-align-icon-' . $settings['icon_position']);

			// Icon Position Top wrapper class
			if ('top' === $settings['icon_position']) {
				$this->add_render_attribute('content-wrapper', 'class', 'de-btn-icon-top');
			}

			// Icon Position Bottom wrapper class
			if ('bottom' === $settings['icon_position']) {
				$this->add_render_attribute('content-wrapper', 'class', 'de-btn-icon-bottom');
			}
		}

		$this->add_render_attribute('icon-align', 'class', 'de-btn-icon');
		// Icon Shape Style
		if ($settings['button_type'] !== 'de-btn-fancy') {
			if (!empty($settings['icon_shape_style'])) {
				$this->add_render_attribute('icon-align', 'class', $settings['icon_shape_style']);
			}

			// Icon Shape
			if (!empty($settings['icon_shape'])) {
				$this->add_render_attribute('icon-align', 'class', $settings['icon_shape']);
			}

			// Ripple Effect
			if (!empty($settings['icon_ripple_effect'] === 'yes')) {
				$this->add_render_attribute('icon-align', 'class', 'ripple-effect');
			}
		}

		$this->add_render_attribute('text', 'class', 'de-btn-text');
		// Data Text Attributes
		$this->add_render_attribute('text', 'data-text', $settings['text']);

		// $this->add_inline_editing_attributes( 'text', 'none' );
		?>
			<span <?php echo $this->get_render_attribute_string('content-wrapper'); ?>>
				<?php if ('yes' === $settings['enable_icon']) : ?>
					<?php if (!empty($settings['selected_icon'])) : ?>
						<?php if ('de-btn-play' === $settings['button_type']) : ?>
							<span class="de-btn-play-icon-wrapper">
							<?php endif; ?>

							<span <?php echo $this->get_render_attribute_string('icon-align'); ?>>
								<?php if (!empty($settings['selected_icon'])) : ?>
									<?php \Elementor\Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']); ?>
								<?php endif; ?>
							</span>
							<?php if ('de-btn-play' == $settings['button_type']) : ?>
							</span>
						<?php endif; ?>
					<?php endif; ?>

				<?php endif; ?>
				<span <?php echo $this->get_render_attribute_string('text'); ?>><span><?php echo $settings['text']; ?></span></span>

				<?php if (!empty($settings['selected_icon']) && 'de-btn-split' === $settings['button_type']) : ?>
					<span <?php echo $this->get_render_attribute_string('icon-align'); ?>>
						<?php if (!empty($settings['selected_icon'])) : ?>
							<?php \Elementor\Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']); ?>
						<?php endif; ?>
					</span>
				<?php endif; ?>
			</span>
	<?php
	}
}
