<?php
/**
 * Advanced Animations Extension
 *
 * @since     1.0.0
 */

defined('ABSPATH') || exit;

class Decent_Elements_Advanced_Animations_Extension
{
    /**
     * Constructor
     * @since 1.0.0
     */
    public function __construct()
    {
        add_action('elementor/element/common/_section_style/after_section_end', [$this, 'add_animation_controls']);
    }

    /**
     * Asset loading is handled by Core\Asset_Registry from this extension's
     * module definition. The previous enqueue here built its URL as
     * plugin_dir_url(__FILE__) . '../assets/...', which resolves inside src/
     * and 404'd on every page load.
     */

    /**
     * Add advanced animation controls
     * @since 1.0.0
     */
    public function add_animation_controls($element)
    {
        $element->start_controls_section(
            'decent_advanced_animations_section',
            [
                'label' => __('Decent Advanced Animations', 'decent-elements'),
                'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
            ]
        );

        $element->add_control(
            'decent_advanced_animation',
            [
                'label' => __('Animation Type', 'decent-elements'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '' => __('None', 'decent-elements'),
                    'float' => __('Float', 'decent-elements'),
                    'pulse' => __('Pulse', 'decent-elements'),
                    'bounce' => __('Bounce', 'decent-elements'),
                    'shake' => __('Shake', 'decent-elements'),
                ],
                'default' => '',
            ]
        );

        $element->end_controls_section();
    }
}