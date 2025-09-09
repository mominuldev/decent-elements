<?php
/**
 * Scroll Effects Extension
 *
 * @since     1.0.0
 */

defined('ABSPATH') || exit;

class Decent_Elements_Scroll_Effects_Extension
{
    /**
     * Constructor
     * @since 1.0.0
     */
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    /**
     * Enqueue scripts for scroll effects
     * @since 1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script(
            'decent-elements-scroll-effects',
            plugin_dir_url(__FILE__) . '../assets/js/scroll-effects.js',
            ['jquery'],
            '1.0.0',
            true
        );

        wp_enqueue_style(
            'decent-elements-scroll-effects',
            plugin_dir_url(__FILE__) . '../assets/css/scroll-effects.css',
            [],
            '1.0.0'
        );
    }
}