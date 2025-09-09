<?php
/**
 * Wrapper Link Extension
 *
 * @since     1.0.0
 */

defined('ABSPATH') || exit;

class Decent_Elements_Wrapper_Link_Extension
{
    /**
     * Constructor
     * @since 1.0.0
     */
    public function __construct()
    {
        add_action('elementor/element/section/section_advanced/after_section_end', [$this, 'add_wrapper_link_controls']);
        add_action('elementor/element/column/section_advanced/after_section_end', [$this, 'add_wrapper_link_controls']);
        add_action('elementor/frontend/section/before_render', [$this, 'before_render']);
        add_action('elementor/frontend/column/before_render', [$this, 'before_render']);
    }

    /**
     * Add wrapper link controls
     * @since 1.0.0
     */
    public function add_wrapper_link_controls($element)
    {
        $element->start_controls_section(
            'decent_wrapper_link_section',
            [
                'label' => __('Decent Wrapper Link', 'decent-elements'),
                'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
            ]
        );

        $element->add_control(
            'decent_wrapper_link',
            [
                'label' => __('Link', 'decent-elements'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'decent-elements'),
            ]
        );

        $element->end_controls_section();
    }

    /**
     * Before render wrapper link
     * @since 1.0.0
     */
    public function before_render($element)
    {
        $settings = $element->get_settings();
        
        if (!empty($settings['decent_wrapper_link']['url'])) {
            $link = $settings['decent_wrapper_link'];
            $element->add_render_attribute('_wrapper', 'onclick', "window.open('{$link['url']}', '_blank')");
            $element->add_render_attribute('_wrapper', 'style', 'cursor: pointer');
        }
    }
}
