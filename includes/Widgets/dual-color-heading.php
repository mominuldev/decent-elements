<?php
/**
 * Dual Color Heading Widget
 *
 * @since 1.0.0
 */

defined('ABSPATH') || exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;

class Decent_Elements_Dual_Color_Heading_Widget extends Widget_Base
{
    /**
     * Get widget name.
     */
    public function get_name()
    {
        return 'de-dual-color-heading';
    }

    /**
     * Get widget title.
     */
    public function get_title()
    {
        return __('Dual Color Heading', 'decent-elements');
    }

    /**
     * Get widget icon.
     */
    public function get_icon()
    {
        return 'eicon-animated-headline';
    }

    /**
     * Get widget categories.
     */
    public function get_categories()
    {
        return ['decent-elements'];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'decent-elements'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'first_text',
            [
                'label' => __('First Text', 'decent-elements'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Your First', 'decent-elements'),
                'placeholder' => __('Enter first part', 'decent-elements'),
            ]
        );

        $this->add_control(
            'second_text',
            [
                'label' => __('Second Text', 'decent-elements'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Heading', 'decent-elements'),
                'placeholder' => __('Enter second part', 'decent-elements'),
            ]
        );

        $this->add_control(
            'heading_tag',
            [
                'label' => __('HTML Tag', 'decent-elements'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                ],
                'default' => 'h2',
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label' => __('Alignment', 'decent-elements'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'decent-elements'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'decent-elements'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'decent-elements'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .decent-dual-heading' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // First Text Style
        $this->start_controls_section(
            'first_text_style',
            [
                'label' => __('First Text Style', 'decent-elements'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'first_text_color',
            [
                'label' => __('Color', 'decent-elements'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .decent-dual-heading .first-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'first_text_typography',
                'selector' => '{{WRAPPER}} .decent-dual-heading .first-text',
            ]
        );

        $this->end_controls_section();

        // Second Text Style
        $this->start_controls_section(
            'second_text_style',
            [
                'label' => __('Second Text Style', 'decent-elements'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'second_text_color',
            [
                'label' => __('Color', 'decent-elements'),
                'type' => Controls_Manager::COLOR,
                'default' => '#007cba',
                'selectors' => [
                    '{{WRAPPER}} .decent-dual-heading .second-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'second_text_typography',
                'selector' => '{{WRAPPER}} .decent-dual-heading .second-text',
            ]
        );

        $this->end_controls_section();

        // General Style
        $this->start_controls_section(
            'general_style',
            [
                'label' => __('General Style', 'decent-elements'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'heading_text_shadow',
                'selector' => '{{WRAPPER}} .decent-dual-heading',
            ]
        );

        $this->add_responsive_control(
            'heading_margin',
            [
                'label' => __('Margin', 'decent-elements'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .decent-dual-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $heading_tag = $settings['heading_tag'];
        $first_text = $settings['first_text'];
        $second_text = $settings['second_text'];

        if (empty($first_text) && empty($second_text)) {
            return;
        }

        echo sprintf(
            '<%1$s class="decent-dual-heading"><span class="first-text">%2$s</span> <span class="second-text">%3$s</span></%1$s>',
            esc_attr($heading_tag),
            esc_html($first_text),
            esc_html($second_text)
        );
    }

    /**
     * Render widget output in the editor.
     */
    protected function content_template()
    {
        ?>
        <#
        var headingTag = settings.heading_tag;
        var firstText = settings.first_text;
        var secondText = settings.second_text;
        
        if (firstText || secondText) {
            print('<' + headingTag + ' class="decent-dual-heading"><span class="first-text">' + firstText + '</span> <span class="second-text">' + secondText + '</span></' + headingTag + '>');
        }
        #>
        <?php
    }
}
