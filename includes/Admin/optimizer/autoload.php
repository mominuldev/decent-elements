<?php
/**
 * Autoloader for Decent Elements Optimizer
 */

if (!defined('ABSPATH')) {
    exit;
}

// Check if composer autoloader exists
$composer_autoload = __DIR__ . '/vendor/autoload.php';

if (file_exists($composer_autoload)) {
    require_once $composer_autoload;
} else {
    // Fallback: include minify library manually if composer not available
    $minify_path = __DIR__ . '/vendor/matthiasmullie/minify/src/';

    if (is_dir($minify_path)) {
        require_once $minify_path . 'Minify.php';
        require_once $minify_path . 'CSS.php';
        require_once $minify_path . 'JS.php';
        require_once $minify_path . 'Exception.php';
    }
}
