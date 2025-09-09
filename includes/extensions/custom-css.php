<?php
/**
 * Custom CSS Extension
 *
 * @since     1.0.0
 */

defined('ABSPATH') || exit;

class Decent_Elements_Custom_CSS_Extension
{
    /**
     * Constructor
     * @since 1.0.0
     */
    public function __construct()
    {
        add_action('wp_head', [$this, 'add_custom_css']);
        add_action('elementor/editor/before_enqueue_scripts', [$this, 'add_editor_css']);
    }

    /**
     * Add custom CSS to frontend
     * @since 1.0.0
     */
    public function add_custom_css()
    {
        $custom_css = get_option('decent_elements_custom_css', '');
        if (!empty($custom_css)) {
            echo '<style id="decent-elements-custom-css">' . wp_strip_all_tags($custom_css) . '</style>';
        }
    }

    /**
     * Add custom CSS to Elementor editor
     * @since 1.0.0
     */
    public function add_editor_css()
    {
        $custom_css = get_option('decent_elements_custom_css', '');
        if (!empty($custom_css)) {
            echo '<style id="decent-elements-custom-css-editor">' . wp_strip_all_tags($custom_css) . '</style>';
        }
    }
}
