<?php
/**
 * Sticky Column Extension
 *
 * @since     1.0.0
 */

defined('ABSPATH') || exit;

class Decent_Elements_Sticky_Column_Extension
{
    /**
     * Constructor
     * @since 1.0.0
     */
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('elementor/element/column/section_advanced/after_section_end', [$this, 'add_sticky_controls']);
    }

    /**
     * Enqueue scripts for sticky column
     * @since 1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script(
            'decent-elements-sticky-column',
            plugin_dir_url(__FILE__) . '../assets/js/sticky-column.js',
            ['jquery'],
            '1.0.0',
            true
        );
    }

    /**
     * Add sticky controls to Elementor column
     * @since 1.0.0
     */
    public function add_sticky_controls($element)
    {
        $element->start_controls_section(
            'decent_sticky_section',
            [
                'label' => __('Decent Sticky', 'decent-elements'),
                'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
            ]
        );

        $element->add_control(
            'decent_sticky_enable',
            [
                'label' => __('Enable Sticky', 'decent-elements'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'return_value' => 'yes',
            ]
        );

        $element->end_controls_section();
    }
}
