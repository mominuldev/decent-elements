<?php

/**
 * Fancy Heading Widget
 *
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit; // Abort, if called directly.

use Elementor\{
    Group_Control_Text_Shadow,
    Group_Control_Text_Stroke,
    Utils,
    Widget_Base,
    Controls_Manager,
    Group_Control_Typography};

class Fancy_Heading extends Widget_Base {

	public function get_name() {
		return 'de-fancy-heading';
	}

	public function get_title() {
		return esc_html__( 'Fancy Heading', 'decent-elements' );
	}

    public function get_categories() {
        return [ 'decent-elements' ];
    }

    public function get_icon() {
        return 'eicon-t-letter de-elements-icon';
    }

    public function get_keywords() {
        return [ 'heading', 'title', 'animated', 'highlight', 'fancy' ];
    }

    // Dependency Scripts
    public function get_script_depends() {
        return [ 'gsap', 'ScrollTrigger', 'ScrollTrigger' ];
    }

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __( 'Content', 'decent-elements' ),
            ]
        );

        $this->add_control(
            'title',
            [
                'label'       => esc_html__( 'Title', 'decent-elements' ),
                'type'        => Controls_Manager::TEXTAREA,
                'ai'          => [
                    'type' => 'text',
                ],
                'dynamic'     => [
                    'active' => true,
                ],
                'placeholder' => esc_html__( 'Enter your title', 'decent-elements' ),
                'default'     => esc_html__( 'Add Your Heading [Highlight] Here', 'decent-elements' ),
                'description' => 'To [Highlight] specific text, enclose it in [brackets], e.g., [Text].',
            ]
        );

        $this->add_control(
            'show_before_icon',
            [
                'label'        => esc_html__( 'Show Before Icon', 'decent-elements' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'decent-elements' ),
                'label_off'    => esc_html__( 'Hide', 'decent-elements' ),
                'return_value' => 'yes',
				'default'      => 'no',
            ]
        );

        $this->add_control(
			'before_icon',
			[
				'label'     => esc_html__( 'Before Icon', 'decent-elements' ),
				'type'      => Controls_Manager::ICONS,
				'condition' => [
					'show_before_icon' => 'yes',
				],
			]
		);

        $this->add_control(
            'header_size',
            [
                'label'   => esc_html__( 'HTML Tag', 'decent-elements' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'h1'   => 'H1',
                    'h2'   => 'H2',
                    'h3'   => 'H3',
                    'h4'   => 'H4',
                    'h5'   => 'H5',
                    'h6'   => 'H6',
                    'div'  => 'div',
                    'span' => 'span',
                    'p'    => 'p',
                ],
                'default' => 'h2',
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label'     => esc_html__( 'Alignment', 'decent-elements' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'    => [
                        'title' => esc_html__( 'Left', 'decent-elements' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center'  => [
                        'title' => esc_html__( 'Center', 'decent-elements' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'   => [
                        'title' => esc_html__( 'Right', 'decent-elements' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Justified', 'decent-elements' ),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                ],
                'default'   => '',
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .pps-fancy-heading' => 'text-align: {{VALUE}};',
                ],
            ]
        );

		// Spacer Margin Bottom
	    $this->add_responsive_control(
		    'spacer_margin_bottom',
		    [
			    'label'      => __('Spacer Margin Bottom', 'decent-elements'),
			    'type'       => Controls_Manager::SLIDER,
			    'size_units' => ['px', 'em', '%'],
			    'range'      => [
				    'px' => [
					    'min' => 0,
					    'max' => 100,
				    ],
				    'em' => [
					    'min' => 0,
					    'max' => 10,
				    ],
				    '%'  => [
					    'min' => 0,
					    'max' => 100,
				    ],
			    ],
				'default'    => [
					'size' => 0,
					'unit' => 'px',
				],
			    'selectors'  => [
				    '{{WRAPPER}} .pps-fancy-heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
			    ],
		    ]
	    );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => __( 'Title', 'decent-elements' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__( 'Text Color', 'decent-elements' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pps-fancy-heading' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'typography',
                'selector' => '{{WRAPPER}} .pps-fancy-heading',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Stroke::get_type(),
            [
                'name'     => 'text_stroke',
                'selector' => '{{WRAPPER}} .pps-fancy-heading',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'text_shadow',
                'selector' => '{{WRAPPER}} .pps-fancy-heading',
            ]
        );

        $this->add_control(
            'blend_mode',
            [
                'label'     => esc_html__( 'Blend Mode', 'decent-elements' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    ''            => esc_html__( 'Normal', 'decent-elements' ),
                    'multiply'    => 'Multiply',
                    'screen'      => 'Screen',
                    'overlay'     => 'Overlay',
                    'darken'      => 'Darken',
                    'lighten'     => 'Lighten',
                    'color-dodge' => 'Color Dodge',
                    'saturation'  => 'Saturation',
                    'color'       => 'Color',
                    'difference'  => 'Difference',
                    'exclusion'   => 'Exclusion',
                    'hue'         => 'Hue',
                    'luminosity'  => 'Luminosity',
                ],
                'selectors' => [
                    '{{WRAPPER}} .pps-fancy-heading' => 'mix-blend-mode: {{VALUE}}',
                ],
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'highlight',
            [
                'label'     => esc_html__( 'Highlight', 'decent-elements' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'highlight_color',
            [
                'label'     => esc_html__( 'Color', 'decent-elements' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#C9F31D',
                'selectors' => [
                    '{{WRAPPER}} .pps-fancy-heading .highlight' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'highlight_typography',
                'selector' => '{{WRAPPER}} .pps-fancy-heading .highlight',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Stroke::get_type(),
            [
                'name'     => 'highlight_stroke',
                'selector' => '{{WRAPPER}} .pps-fancy-heading .highlight',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'highlight_shadow',
                'selector' => '{{WRAPPER}} .pps-fancy-heading .highlight',
            ]
        );

        $this->add_control(
            'highlight_blend_mode',
            [
                'label'     => esc_html__( 'Blend Mode', 'decent-elements' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    ''            => esc_html__( 'Normal', 'decent-elements' ),
                    'multiply'    => 'Multiply',
                    'screen'      => 'Screen',
                    'overlay'     => 'Overlay',
                    'darken'      => 'Darken',
                    'lighten'     => 'Lighten',
                    'color-dodge' => 'Color Dodge',
                    'saturation'  => 'Saturation',
                    'color'       => 'Color',
                    'difference'  => 'Difference',
                    'exclusion'   => 'Exclusion',
                    'hue'         => 'Hue',
                    'luminosity'  => 'Luminosity',
                ],
                'selectors' => [
                    '{{WRAPPER}} .pps-fancy-heading .highlight' => 'mix-blend-mode: {{VALUE}}',
                ],
                'separator' => 'none',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title_prefix_style',
            [
                'label' => __( 'Prefix', 'decent-elements' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition'   => [ 'show_title_prefix' => 'yes' ]
            ]
        );

        $this->add_control(
            'title_prefix_color',
            [
                'label'     => esc_html__( 'Color', 'decent-elements' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pps-fancy-heading.prefix_on_normal:before, {{WRAPPER}} .pps-fancy-heading.prefix_on_hover:before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_prefix_w',
            [
                'label'     => esc_html__( 'Width', 'decent-elements' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 1,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pps-fancy-heading.prefix_on_normal:before, {{WRAPPER}} .pps-fancy-heading.prefix_on_hover:before' => '--prefix-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_prefix_h',
            [
                'label'     => esc_html__( 'Height', 'decent-elements' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pps-fancy-heading.prefix_on_normal:before, {{WRAPPER}} .pps-fancy-heading.prefix_on_hover:before' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_prefix_gap',
            [
                'label'     => esc_html__( 'Gap', 'decent-elements' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pps-fancy-heading.prefix_on_normal:before, {{WRAPPER}} .pps-fancy-heading.prefix_on_hover:before' => ' --prefix-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control( 'title_prefix_v_alignment',
            [
                'label'     => esc_html__( 'Vertical Alignment', 'decent-elements' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'top'    => [
                        'title' => esc_html__( 'Top', 'decent-elements' ),
                        'icon'  => 'eicon-v-align-top',
                    ],
                    'middle' => [
                        'title' => esc_html__( 'Center', 'decent-elements' ),
                        'icon'  => 'eicon-v-align-middle',
                    ],
                    'bottom' => [
                        'title' => esc_html__( 'Bottom', 'decent-elements' ),
                        'icon'  => 'eicon-v-align-bottom',
                    ],
                ],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .pps-fancy-heading.prefix_on_normal:before, {{WRAPPER}} .pps-fancy-heading.prefix_on_hover:before' => 'vertical-align: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        if ( '' === $settings['title'] ) {
            return;
        }

        $title = $settings['title'];



        preg_match_all( '/\[([^\]]*)\]/', $title, $matches );
        foreach ( $matches[0] as $key => $value ) {
            $title = str_replace( $value, '<span class="highlight">' . $matches[1][ $key ] . '</span>', $title, );
        }

        if ( ! empty( $settings['show_title_prefix'] ) ) {
            $this->add_render_attribute( 'title', 'class', $settings['title_prefix_use'] );
        }

        $this->add_render_attribute( 'title', 'class', 'pps-fancy-heading' );


//        $this->add_render_attribute( 'title', 'data-bg-color', $settings['title_bg_color'] );

//        $this->add_render_attribute( 'title', 'data-fg-color', $settings['title_color'] );



		if ( ! empty( $settings['show_before_icon'] ) && ! empty( $settings['before_icon']['value'] ) ) {
			echo '<span class="before-icon">';
			\Elementor\Icons_Manager::render_icon( $settings['before_icon'], [ 'aria-hidden' => 'true' ] );
			echo '</span>';
		}

		// PHPCS - the variable $title_html holds safe data.
        $title_html = sprintf( '<%1$s %2$s>%3$s</%1$s>', Utils::validate_html_tag( $settings['header_size'] ), $this->get_render_attribute_string( 'title' ), $title );

        // PHPCS - the variable $title_html holds safe data.
        echo $title_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}
