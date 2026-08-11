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
        add_action('elementor/frontend/after_register_scripts', [$this, 'register_elementor_scripts']);
    }

    /**
     * Asset loading is handled by Core\Asset_Registry from this extension's
     * module definition. The previous enqueue here built its URL as
     * plugin_dir_url(__FILE__) . '../assets/...', which resolves inside src/
     * and 404'd on every page load.
     */

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
