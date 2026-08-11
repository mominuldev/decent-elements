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
        add_action('elementor/element/column/section_advanced/after_section_end', [$this, 'add_sticky_controls']);
    }

    /**
     * Asset loading is handled by Core\Asset_Registry from this extension's
     * module definition. The previous enqueue here built its URL as
     * plugin_dir_url(__FILE__) . '../assets/...', which resolves inside src/
     * and 404'd on every page load.
     */

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
