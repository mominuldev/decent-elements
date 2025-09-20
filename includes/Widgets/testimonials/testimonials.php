<?php
namespace GpTheme\GenesisCore\Widgets;

use Elementor\{Controls_Manager,
	Group_Control_Background,
	Group_Control_Box_Shadow,
	Widget_Base,
	Group_Control_Typography,
	Repeater,
	Utils
};

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Testimonial
 * @package GpTheme\GenesisCore\Widgets
 */
class Testimonial extends Widget_Base {

	public function get_name() {
		return 'de-testimonial';
	}

	public function get_title() {
		return esc_html__( 'Testimonial', 'genesis-core' );
	}

	public function get_icon() {
		return 'eicon-testimonial gpt-element';
	}

	public function get_categories() {
		return [ 'pps-elements' ];
	}

	protected function register_controls() {
		// Testimonial
		//=========================
		$this->start_controls_section( 'section_tab_style', [
			'label' => esc_html__( 'Testimonial', 'genesis-core' ),
		] );

		$this->add_control( 'layout', [
			'label'   => esc_html__( 'Layout', 'genesis-core' ),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				'one' => esc_html__( 'Layout 1', 'genesis-core' ),
				'two' => esc_html__( 'Layout 2', 'genesis-core' ),
			],
			'default' => 'one',
		] );

		// Quote Icon
		$this->add_control( 'quote_icon', [
			'label'       => __( 'Quote Icon', 'genesis-core' ),
			'type'        => Controls_Manager::ICONS,
			'default'     => [
				'value'   => 'fas fa-quote-left',
				'library' => 'fa-solid',
			],
			'label_block' => true,
			'condition'   => [
				'layout' => 'one'
			]
		] );


		$repeater = new Repeater();


		$repeater->add_control( 'image', [
			'label'   => __( 'Author Image', 'genesis-core' ),
			'type'    => Controls_Manager::MEDIA,
			'default' => [
				'url' => Utils::get_placeholder_image_src(),
			]
		] );

		$repeater->add_control( 'name', [
			'label'       => __( 'Name', 'genesis-core' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => __( 'Mominul', 'genesis-core' ),
			'label_block' => true,
		] );

		$repeater->add_control( 'designation', [
			'label'       => __( 'Designation', 'genesis-core' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => __( 'Full-Stack Developer', 'genesis-core' ),
			'label_block' => true,
		] );

		$repeater->add_control( 'rating', [
			'label'   => __( 'Rating Number', 'genesis-core' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => '50',
			'options' => [
				'10' => __( '1 Star', 'genesis-core' ),
				'20' => __( '2 Star', 'genesis-core' ),
				'30' => __( '3 Star', 'genesis-core' ),
				'40' => __( '4 Star', 'genesis-core' ),
				'50' => __( '5 Star', 'genesis-core' ),
			],
		] );

		$repeater->add_control( 'review_content', [
			'label'      => __( 'Review Content', 'genesis-core' ),
			'type'       => Controls_Manager::TEXTAREA,
			'show_label' => false,
		] );

		// Logo
		$repeater->add_control( 'logo', [
			'label'       => __( 'Logo', 'genesis-core' ),
			'type'        => Controls_Manager::MEDIA,
//			'default'     => [
//				'url' => Utils::get_placeholder_image_src(),
//			],
			'label_block' => true,
//			'condition'   => [
//				'layout' => 'one'
//			]
		] );


		$this->add_control( 'testimonials', [
			'label'       => __( 'Testimonial Items', 'genesis-core' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => [
				[
					'image'          => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'name'           => __( 'Mateo Daniel', 'genesis-core' ),
					'designation'    => __( 'Traveler', 'genesis-core' ),
					'review_content' => __( '“I cannot express enough how satisfied I am with development service provided by Bookfy. From the initial consultation to the final delivery.”', 'genesis-core' ),
				],
				[
					'image'          => [
						'url' => Utils::get_placeholder_image_src( ),
					],
					'name'           => __( 'Wobern Soba', 'genesis-core' ),
					'designation'    => __( 'Product Designer', 'genesis-core' ),
					'review_content' => __( '“I cannot express enough how satisfied I am with development service provided by Bookfy. From the initial consultation to the final delivery.”', 'genesis-core' ),
				],

				[
					'image'          => [
						'url' => Utils::get_placeholder_image_src( ),
					],
					'name'           => __( 'Jeams Kharlo', 'genesis-core' ),
					'designation'    => __( 'Traveler', 'genesis-core' ),
					'review_content' => __( '“I cannot express enough how satisfied I am with development service provided by Bookfy. From the initial consultation to the final delivery.”', 'genesis-core' ),
				],
			],
			'title_field' => '{{{ name }}}',
		] );

		$this->end_controls_section();

		// Slider Control
		//=====================
		$this->start_controls_section( 'settingd_section', [
			'label' => esc_html__( 'Slider Control', 'genesis-core' ),
		] );

		$this->add_control(
			'slides_per_view',
			[
				'label'   => esc_html__( 'Slider Per View', 'genesis-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '2',
				'options' => [
					'1' => esc_html__( '1', 'genesis-core' ),
					'2' => esc_html__( '2', 'genesis-core' ),
					'3' => esc_html__( '3', 'genesis-core' ),
				],
			]
		);

		$this->add_control( 'navigation', [
			'label'        => esc_html__( 'Navigation', 'genesis-core' ),
			'type'         => Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Show', 'genesis-core' ),
			'label_off'    => esc_html__( 'Hide', 'genesis-core' ),
			'return_value' => 'yes',
			'default'      => 'yes'
		] );

		$this->add_control( 'pagination', [
			'label'        => esc_html__( 'Pagination', 'genesis-core' ),
			'type'         => Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Show', 'genesis-core' ),
			'label_off'    => esc_html__( 'Hide', 'genesis-core' ),
			'return_value' => 'yes',
			'default'      => 'yes'
		] );

		$this->add_control( 'centered_slides', [
			'label'        => esc_html__( 'Center Slide', 'genesis-core' ),
			'type'         => Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Yes', 'genesis-core' ),
			'label_off'    => esc_html__( 'No', 'genesis-core' ),
			'return_value' => 'yes',
			'default'      => 'no'
		] );


		$this->add_control( 'loop', [
			'label'        => esc_html__( 'Loop', 'genesis-core' ),
			'type'         => Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'On', 'genesis-core' ),
			'label_off'    => esc_html__( 'Off', 'genesis-core' ),
			'return_value' => 'yes',
			'default'      => 'yes'
		] );

		$this->add_control( 'speed', [
			'label'   => __( 'Speed', 'genesis-core' ),
			'type'    => Controls_Manager::NUMBER,
			'default' => 700,
		] );

		$this->add_control( 'autoplay', [
			'label'        => esc_html__( 'Autoplay', 'genesis-core' ),
			'type'         => Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'On', 'genesis-core' ),
			'label_off'    => esc_html__( 'Off', 'genesis-core' ),
			'return_value' => 'yes',
			'default'      => 'yes'
		] );

		$this->add_control( 'autoplay_time', [
			'label'     => __( 'Autoplay Time', 'genesis-core' ),
			'type'      => Controls_Manager::NUMBER,
			'default'   => 9000,
			'condition' => [
				'autoplay' => 'yes'
			]
		] );

		// Space Between
		$this->add_control(
			'space_between',
			[
				'label'   => esc_html__( 'Space Between', 'textdomain' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => 100,
				'step'    => 1,
				'default' => 30,
			]
		);

		$this->end_controls_section();


		// Style Sections
		//=====================

		// Avatar Style
		//=====================
		$this->start_controls_section( 'avatar_section', [
			'label'     => __( 'Avatar', 'genesis-core' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'layout' => '2'
			]
		] );

		$this->add_control(
			'avatar_spacing',
			[
				'label'      => esc_html__( 'Spacing (Margin Bottom)', 'genesis-core' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 150,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 40,
				],

				'selectors' => [
					'{{WRAPPER}} .testimonial-fade .avatar' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'avatar_padding',
			[
				'label'      => esc_html__( 'Padding', 'textdomain' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .testimonial-fade .avatar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'avatar_border',
				'selector' => '{{WRAPPER}} .pps-testimonial-wrapper-two .swiper-slide.swiper-slide-active .testimonial-fade .avatar',
			]
		);


		$this->end_controls_section();

		// Name Style
		//=====================
		$this->start_controls_section( 'name_section', [
			'label' => __( 'Name', 'genesis-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'name_typography',
			'label'    => __( 'Typography', 'genesis-core' ),
			'selector' => '{{WRAPPER}} .name',
		] );

		$this->add_control( 'name_color', [
			'label'     => __( 'Color', 'genesis-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .name' => 'color: {{VALUE}}',
			],
		] );

		$this->end_controls_section();

		// Designation Style
		//=====================
		$this->start_controls_section( 'designation_section', [
			'label' => __( 'Designation', 'genesis-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'desi_typography',
			'label'    => __( 'Typography', 'genesis-core' ),
			'selector' => '{{WRAPPER}} .designation',
		] );

		$this->add_control( 'desi_color', [
			'label'     => __( 'Color', 'genesis-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .designation' => 'color: {{VALUE}}',
			],
		] );

		$this->end_controls_section();

		// Separator
		//=====================
		$this->start_controls_section( 'separator_style_section', [
			'label' => __( 'Separator', 'genesis-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

			$this->add_control( 'sep_color', [
				'label'     => __( 'Color', 'genesis-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .testimonial-separator' => 'border-bottom-color: {{VALUE}}',
				],
			] );


		$this->end_controls_section();

		// Style Review Content
		//=========================
		$this->start_controls_section( 'review_section', [
			'label' => __( 'Review Content', 'genesis-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'review_typography',
			'label'    => __( 'Typography', 'genesis-core' ),
			'selector' => '{{WRAPPER}} .testimonial p',
		] );

		$this->add_control( 'review_color', [
			'label'     => __( 'Color', 'genesis-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .testimonial p' => 'color: {{VALUE}}',
			],
		] );

		$this->end_controls_section();

		// Style Slider Control Section
		//================================
		$this->start_controls_section( 'control_section', [
			'label' => __( 'Slider  Control', 'genesis-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );


		$this->add_control(
			'nav_width',
			[
				'label'      => esc_html__( 'Nav Height/Width', 'genesis-core' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 20,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .testimonial-prev, {{WRAPPER}} .testimonial-next' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'nav_font_size',
			[
				'label'      => esc_html__( 'Nav Font Size', 'genesis-core' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .testimonial-prev, {{WRAPPER}} .testimonial-next' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]

		);

		$this->add_control(
			'nav_border_radius',
			[
				'label'      => esc_html__( 'Nav Border Radius', 'genesis-core' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
					'em' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .testimonial-prev, {{WRAPPER}} .testimonial-next' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->start_controls_tabs( 'tabs_nav_style' );
		$this->start_controls_tab(
			'tab_nav_normal',
			[
				'label' => __( 'Normal', 'genesis-core' ),
			]
		);

		$this->add_control( 'slider_nav_color', [
			'label'     => __( 'Color', 'genesis-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .testimonial-prev, {{WRAPPER}} .testimonial-next' => 'color: {{VALUE}}',
			],
		] );

		$this->add_control( 'nav_bg_color', [
			'label'     => __( 'Background Color', 'genesis-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .testimonial-prev, {{WRAPPER}} .testimonial-next' => 'background-color: {{VALUE}}',
			],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'slider_control_border',
				'selector' => '{{WRAPPER}} .testimonial-prev, {{WRAPPER}} .testimonial-next',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'nav_box_shadow',
				'label'    => __( 'Box Shadow', 'genesis-core' ),
				'selector' => '{{WRAPPER}} .testimonial-prev, {{WRAPPER}} .testimonial-next',
			]
		);

		$this->add_control( 'pagination_bg_color', [
			'label'     => __( 'Pagination BG Color', 'genesis-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet:not(.swiper-pagination-bullet-active)' => 'background: {{VALUE}}',
			],
			'separator' => 'before',
		] );

		$this->add_control( 'pagination_active_bg_color', [
			'label'     => __( 'Pagination Active BG Color', 'genesis-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background: {{VALUE}}',
			],
			'separator' => 'before',
		] );

		$this->end_controls_tab();


		$this->start_controls_tab(
			'tab_nav_hover',
			[
				'label' => __( 'Hover', 'genesis-core' ),
			]
		);

		$this->add_control( 'nav_color_hover', [
			'label'     => __( 'Color', 'genesis-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .testimonial-prev:hover, {{WRAPPER}} .testimonial-next:hover' => 'color: {{VALUE}}',
			],
		] );

		$this->add_control( 'nav_color_bg_hover', [
			'label'     => __( 'Background Color', 'genesis-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .testimonial-prev:hover, {{WRAPPER}} .testimonial-next:hover' => 'background-color: {{VALUE}}',
			],
		] );

		$this->add_control( 'nav_control_hover', [
			'label'     => __( 'Border Color', 'genesis-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .testimonial-prev:hover, {{WRAPPER}} .testimonial-next:hover' => 'border-color: {{VALUE}}',
			],
		] );

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'nav_box_shadow_hover',
				'label'    => __( 'Box Shadow', 'genesis-core' ),
				'selector' => '{{WRAPPER}} .testimonial-prev:hover, {{WRAPPER}} .testimonial-next:hover',
			]
		);

		$this->add_control( 'slider_pagination_active_color', [
			'label'     => __( 'Pagination Active BG Color', 'genesis-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet:before' => 'background: {{VALUE}}',
			],
			'separator' => 'before',
		] );

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		// Style Slider Control Section
		//================================
		$this->start_controls_section( 'testimonial_section', [
			'label' => __( 'Testimonial Container', 'genesis-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'testimonial_background',
				'label'    => __( 'Background', 'genesis-core' ),
				'types'    => [ 'classic', 'gradient' ],
				'exclude'  => [ 'image' ],
				'selector' => '{{WRAPPER}} .pps-testimonial',
			]
		);

		$this->add_control(
			'testimonial_padding',
			[
				'label'      => __( 'Padding', 'genesis-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .pps-testimonial' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'testimonial_border_radius',
			[
				'label'      => __( 'Border Radius', 'genesis-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .pps-testimonial' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'testimonial_shadow_hover',
				'label'    => __( 'Box Shadow', 'genesis-core' ),
				'selector' => '{{WRAPPER}} .pps-testimonial',
			]
		);

		// Overflow
//		$this->add_control(
//			'testimonial_overflow',
//			[
//				'label'        => __( 'Overflow', 'genesis-core' ),
//				'type'         => Controls_Manager::SWITCHER,
//				'label_on'     => __( 'Show', 'genesis-core' ),
//				'label_off'    => __( 'Hide', 'genesis-core' ),
//				'return_value' => 'yes',
//				'default'      => 'no',
//				'separator'    => 'before',
//				'selectors'    => [
//					'{{WRAPPER}} .pps-testimonials' => 'overflow: visible !important;',
//				],
//			]
//		);

		$this->end_controls_section();
	}

	protected function render() {

		$settings     = $this->get_settings_for_display();
		$testimonials = $settings['testimonials'];


		$this->add_render_attribute( 'wrapper', 'class', [
			'swiper-container',
			'pps-testimonials',
		] );

		// Testimonial Style
		$this->add_render_attribute( 'testimonial', 'class', 'pps-testimonial' );
		if( ! empty( $settings['layout'] ) ) {
			// Layout
			$this->add_render_attribute( 'wrapper', 'class', 'pps-testimonial--' . $settings['layout'] );
			$this->add_render_attribute( 'testimonial', 'class', 'pps-testimonial--' . $settings['layout'] );
		}

		$slider_options = $this->get_slider_options( $settings );
		$this->add_render_attribute( 'wrapper', 'data-testi', wp_json_encode( $slider_options ) );


		require __DIR__ . '/templates/testimonial/layout-' . $settings['layout'] . '.php';

	}

	protected function get_slider_options( array $settings ) {

		// Loop
		if ( $settings['loop'] == 'yes' ) {
			$slider_options['loop'] = true;
		}

		// Speed
		if ( ! empty( $settings['speed'] ) ) {
			$slider_options['speed'] = $settings['speed'];

		}

		// Centered Slides
		if( $settings['centered_slides'] == 'yes' ) {
			$slider_options['centeredSlides'] = true;
		}

		// Space Between
//        if ( ! empty( $settings['space_between'] ) ) {
//            $slider_options['spaceBetween'] = $settings['space_between'];
//        }


		// Breakpoints
		$slider_options['breakpoints'] = [
			'1024' => [
				'slidesPerView' => $settings['slides_per_view'],
				'spaceBetween'  => $settings['space_between'],
			],
			'991'  => [
				'slidesPerView' => 1,
				'spaceBetween'  => $settings['space_between'],
			],

			'320' => [
				'slidesPerView' => 1,
			],
		];


		// Auto Play
		if ( $settings['autoplay'] == 'yes' ) {
			$slider_options['autoplay'] = [
				'delay'                => $settings['autoplay_time'],
				'disableOnInteraction' => false
			];
		} else {
			$slider_options['autoplay'] = [
				'delay' => '99999999999',
			];
		}

		if ( $settings['navigation'] == 'yes' ) {
			$slider_options['navigation'] = [
				'nextEl' => '.testimonial-next',
				'prevEl' => '.testimonial-prev'
			];
		}

		if ( $settings['pagination'] == 'yes' ) {
			$slider_options['pagination'] = [
				'el'        => '.testimonial-pagination',
				'clickable' => true
			];
		}

		return $slider_options;
	}

}
