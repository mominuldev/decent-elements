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
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('elementor/element/common/_section_style/after_section_end', [$this, 'add_animation_controls']);
    }

    /**
     * Enqueue scripts for advanced animations
     * @since 1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script(
            'decent-elements-advanced-animations',
            plugin_dir_url(__FILE__) . '../assets/js/advanced-animations.js',
            ['jquery'],
            '1.0.0',
            true
        );

        wp_enqueue_style(
            'decent-elements-advanced-animations',
            plugin_dir_url(__FILE__) . '../assets/css/advanced-animations.css',
            [],
            '1.0.0'
        );
    }

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