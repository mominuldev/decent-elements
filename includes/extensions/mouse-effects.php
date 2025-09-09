<?php
/**
 * Mouse Effects Extension
 *
 * @since     1.0.0
 */

defined('ABSPATH') || exit;

class Decent_Elements_Mouse_Effects_Extension
{
    /**
     * Constructor
     * @since 1.0.0
     */
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('elementor/frontend/after_register_scripts', [$this, 'register_elementor_scripts']);
    }

    /**
     * Enqueue scripts for mouse effects
     * @since 1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script(
            'decent-elements-mouse-effects',
            DECENT_ELEMENTS_ASSETS_URL . 'js/mouse-effects.js',
            ['jquery'],
            DECENT_ELEMENTS_VERSION,
            true
        );

        wp_enqueue_style(
            'decent-elements-mouse-effects',
            DECENT_ELEMENTS_ASSETS_URL . 'css/mouse-effects.css',
            [],
            DECENT_ELEMENTS_VERSION
        );
    }

    /**
     * Register scripts for Elementor
     * @since 1.0.0
     */
    public function register_elementor_scripts()
    {
        wp_register_script(
            'decent-elements-mouse-effects',
            DECENT_ELEMENTS_ASSETS_URL . 'js/mouse-effects.js',
            ['jquery'],
            DECENT_ELEMENTS_VERSION,
            true
        );
    }
}
