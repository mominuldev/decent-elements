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
    }

    /**
     * Asset loading is handled by Core\Asset_Registry from this extension's
     * module definition. The previous enqueue here built its URL as
     * plugin_dir_url(__FILE__) . '../assets/...', which resolves inside src/
     * and 404'd on every page load.
     */
}