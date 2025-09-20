<?php
/**
 * Asset Minifier Manager for Decent Elements
 * Based on Element Pack's optimization system
 *
 * @since 1.0.0
 */

namespace Decent_Elements\Admin\Optimizer;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('MatthiasMullie\Minify\Minify')) {
    require_once __DIR__ . '/autoload.php';
}

use MatthiasMullie\Minify;

class Asset_Minifier_Manager
{
    /**
     * @var Asset_Minifier_Manager
     */
    private static $_instance = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        add_action('init', [$this, 'init']);
    }

    /**
     * Initialize the optimizer
     */
    public function init()
    {
        // Only run if optimization is enabled
        if ($this->is_optimization_enabled()) {
            add_action('wp_enqueue_scripts', [$this, 'enqueue_optimized_assets'], 999);
            add_action('admin_init', [$this, 'maybe_regenerate_assets']);

            // Hook into Elementor to disable individual widget assets when optimization is enabled
            add_action('elementor/frontend/after_register_scripts', [$this, 'maybe_dequeue_individual_assets'], 999);
        }
    }

    /**
     * Check if optimization is enabled
     */
    public function is_optimization_enabled()
    {
        return get_option('decent_elements_enable_asset_optimization', false);
    }

    /**
     * Get active widget IDs
     */
    public function get_widget_ids()
    {
        $widget_manager = \Decent_Elements\Widget_Manager::instance();
        $available_widgets = $widget_manager->get_available_widgets();
        $current_settings = $widget_manager->get_widget_settings();

        $active_widgets = [];
        foreach ($available_widgets as $widget_id => $widget_data) {
            $is_enabled = isset($current_settings[$widget_id]) ?
                (bool) $current_settings[$widget_id] :
                $widget_data['default'];

            if ($is_enabled) {
                $active_widgets[] = $widget_id;
            }
        }

        return $active_widgets;
    }

	// Get Single Id
	public function is_widget_enabled($widget_name) {
		$widget_manager = \Decent_Elements\Widget_Manager::instance();
		$available_widgets = $widget_manager->get_available_widgets();
		$current_settings = $widget_manager->get_widget_settings();

		foreach ($available_widgets as $widget_id => $widget_data) {
			if($widget_data['name'] === $widget_name) {
				$is_enabled = isset($current_settings[$widget_id]) ?
					(bool) $current_settings[$widget_id] :
					$widget_data['default'];

				if ($is_enabled) {
					return $widget_id;
				}
			}
		}
		return null;
	}

    /**
     * Get active extension IDs
     */
    public function get_extension_ids()
    {
        // Check if extension manager exists
        if (!class_exists('\Decent_Elements\Decent_Elements_Extension_Manager')) {
            return [];
        }

        $extension_manager = \Decent_Elements\Decent_Elements_Extension_Manager::instance();
        $available_extensions = $extension_manager->get_available_extensions();
        $current_settings = $extension_manager->get_extension_settings();

        $active_extensions = [];
        foreach ($available_extensions as $extension_id => $extension_data) {
            $is_enabled = isset($current_settings[$extension_id]) ?
                (bool) $current_settings[$extension_id] :
                $extension_data['default'];

            if ($is_enabled) {
                $active_extensions[] = $extension_id;
            }
        }

        return $active_extensions;
    }

    /**
     * Get assets for active components
     */
    public function get_assets()
    {
        $widgets = $this->get_widget_ids();
        $extensions = $this->get_extension_ids();
        $scripts = [];
        $direction = is_rtl() ? '.rtl' : '';

        // Widget assets - check actual file paths in assets/widgets folder
        foreach ($widgets as $widget) {
            $js_path = DECENT_ELEMENTS_PATH . 'assets/widgets/js/' . $widget . '.js';
            $css_path = DECENT_ELEMENTS_PATH . 'assets/widgets/css/' . $widget . $direction . '.css';

            $script = [];
            if (file_exists($js_path)) {
                $script['js'] = $js_path;
            }

            if (file_exists($css_path)) {
                $script['css'] = $css_path;
            }

            if ($script) {
                $scripts[] = $script;
            }
        }

        // Extension assets - check in assets/extensions folder
        foreach ($extensions as $extension) {
            $js_path = DECENT_ELEMENTS_PATH . 'assets/extensions/js/' . $extension . '.js';
            $css_path = DECENT_ELEMENTS_PATH . 'assets/extensions/css/' . $extension . $direction . '.css';

            $script = [];
            if (file_exists($js_path)) {
                $script['js'] = $js_path;
            }

            if (file_exists($css_path)) {
                $script['css'] = $css_path;
            }

            if ($script) {
                $scripts[] = $script;
            }
        }

        return $scripts;
    }

    /**
     * Get JavaScript file paths
     */
    protected function get_js_paths()
    {
        return array_reduce($this->get_assets(), function ($results, $item) {
            if (isset($item['js'])) {
                $results[] = $item['js'];
            }
            return $results;
        }, []);
    }

    /**
     * Get CSS file paths
     */
    public function get_css_paths()
    {
        return array_reduce($this->get_assets(), function ($results, $item) {
            if (isset($item['css'])) {
                $results[] = $item['css'];
            }

            return $results;
        }, []);
    }

    /**
     * Minify JavaScript files
     */
    public function minify_js()
    {
        $scripts = $this->get_js_paths();
        $scripts = apply_filters('decent_elements/optimization/assets/scripts', $scripts);

        if (empty($scripts)) {
            return true;
        }

        $uploads_dir = trailingslashit(wp_upload_dir()['basedir']) . 'decent-elements/minified/js';
        wp_mkdir_p($uploads_dir);
        $minified_path = $uploads_dir . "/de-scripts.js";

        try {
            if (class_exists('MatthiasMullie\Minify\JS')) {
                $minifier = new \MatthiasMullie\Minify\JS();
                foreach ($scripts as $item) {
                    if (file_exists($item)) {
                        $minifier->add($item);
                    }
                }
                $minifier->minify($minified_path);
            } else {
                // Fallback: simple concatenation
                $combined_content = '';
                foreach ($scripts as $item) {
                    if (file_exists($item)) {
                        $combined_content .= file_get_contents($item) . "\n";
                    }
                }
                file_put_contents($minified_path, $combined_content);
            }

            update_option('decent_elements_minified_js_generated', time());
            return true;
        } catch (\Exception $e) {
            error_log('Decent Elements JS Minification Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Minify CSS files
     */
    public function minify_css()
    {
        $styles = $this->get_css_paths();
        $styles = apply_filters('decent_elements/optimization/assets/styles', $styles);

        if (empty($styles)) {
            return true;
        }

        $uploads_dir = trailingslashit(wp_upload_dir()['basedir']) . 'decent-elements/minified/css';
        wp_mkdir_p($uploads_dir);
        $minified_path = $uploads_dir . "/de-styles.css";

        try {
            if (class_exists('MatthiasMullie\Minify\CSS')) {
                $minifier = new \MatthiasMullie\Minify\CSS();
                foreach ($styles as $item) {
                    if (file_exists($item)) {
                        $minifier->add($item);
                    }
                }
                $minifier->minify($minified_path);
            } else {
                // Fallback: simple concatenation
                $combined_content = '';
                foreach ($styles as $item) {
                    if (file_exists($item)) {
                        $combined_content .= file_get_contents($item) . "\n";
                    }
                }
                file_put_contents($minified_path, $combined_content);
            }

            update_option('decent_elements_minified_css_generated', time());
            return true;
        } catch (\Exception $e) {
            error_log('Decent Elements CSS Minification Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Generate minified assets
     */
    public function generate_minified_assets()
    {
        $js_result = $this->minify_js();
        $css_result = $this->minify_css();

        if ($js_result && $css_result) {
            update_option('decent_elements_assets_optimized', true);
            update_option('decent_elements_last_optimization', time());
            return true;
        }

        return false;
    }

    /**
     * Check if assets need regeneration
     */
    public function maybe_regenerate_assets()
    {
        if (!$this->is_optimization_enabled()) {
            return;
        }

        // Regenerate if settings changed or files don't exist
        $last_settings_change = get_option('decent_elements_settings_last_updated', 0);
        $last_optimization = get_option('decent_elements_last_optimization', 0);

        $uploads_dir = trailingslashit(wp_upload_dir()['basedir']) . 'decent-elements/minified/';

        $js_file = $uploads_dir . 'js/de-scripts.js';
        $css_file = $uploads_dir . 'css/de-styles.css';

        if ($last_settings_change > $last_optimization ||
            !file_exists($js_file) ||
            !file_exists($css_file)) {
            $this->generate_minified_assets();
        }
    }

    /**
     * Enqueue optimized assets
     */
    public function enqueue_optimized_assets()
    {
        if (!$this->is_optimization_enabled()) {
            return;
        }

        // Check if we should load optimized assets
        if (!$this->should_load_optimized_assets()) {
            return;
        }

        $uploads_url = trailingslashit(wp_upload_dir()['baseurl']) . 'decent-elements/minified/';
        $uploads_dir = trailingslashit(wp_upload_dir()['basedir']) . 'decent-elements/minified/';

        // Enqueue minified CSS
        $css_file = $uploads_dir . 'css/de-styles.css';
        if (file_exists($css_file)) {
            wp_enqueue_style(
                'decent-elements-optimized-styles',
                $uploads_url . 'css/de-styles.css',
                [],
                filemtime($css_file)
            );

            // Mark that we've loaded optimized styles
            add_filter('decent_elements_optimized_styles_loaded', '__return_true');
        }

        // Enqueue minified JS
        $js_file = $uploads_dir . 'js/de-scripts.js';
        if (file_exists($js_file)) {
            wp_enqueue_script(
                'decent-elements-optimized-scripts',
                $uploads_url . 'js/de-scripts.js',
                ['jquery'],
                filemtime($js_file),
                true
            );

            // Mark that we've loaded optimized scripts
            add_filter('decent_elements_optimized_scripts_loaded', '__return_true');
        }
    }

    /**
     * Check if we should load optimized assets
     */
    private function should_load_optimized_assets()
    {
        // Always load if we have Elementor content
        if ($this->is_elementor_page()) {
            return true;
        }

        // Also load for pages that might have Elementor shortcodes or templates
        global $post;
        if ($post && (
            // Check for Elementor shortcodes in content
            has_shortcode($post->post_content, 'elementor-template') ||
            // Check if this is a template page
            is_singular('elementor_library') ||
            // Check for any Elementor-related content
            strpos($post->post_content, 'elementor') !== false
        )) {
            return true;
        }

        // Load on pages where widgets might be used (like archives, home page)
        if (is_home() || is_front_page() || is_archive() || is_search()) {
            return true;
        }

        return false;
    }

    /**
     * Check if current page has Elementor content
     */
    private function is_elementor_page()
    {
        if (!class_exists('\Elementor\Plugin')) {
            return false;
        }

        global $post;
        if (!$post) {
            return false;
        }

        return \Elementor\Plugin::$instance->documents->get($post->ID)->is_built_with_elementor();
    }

    /**
     * Dequeue individual assets when optimization is enabled
     */
    public function maybe_dequeue_individual_assets()
    {
        if (!$this->is_optimization_enabled()) {
            return;
        }

        // Only dequeue if optimized assets are loaded
        if (!apply_filters('decent_elements_optimized_styles_loaded', false) &&
            !apply_filters('decent_elements_optimized_scripts_loaded', false)) {
            return;
        }

        // Dequeue individual widget assets that are included in the optimized bundle
        $widgets = $this->get_widget_ids();
        foreach ($widgets as $widget) {
            // Use correct asset handle format
            wp_dequeue_style('de-' . $widget);
            wp_dequeue_script('de-' . $widget);
            wp_deregister_style('de-' . $widget);
            wp_deregister_script('de-' . $widget);
        }

        $extensions = $this->get_extension_ids();
        foreach ($extensions as $extension) {
            // Use correct asset handle format
            wp_dequeue_style('de-' . $extension);
            wp_dequeue_script('de-' . $extension);
            wp_deregister_style('de-' . $extension);
            wp_deregister_script('de-' . $extension);
        }
    }

    /**
     * Clear optimized assets
     */
    public function clear_optimized_assets()
    {
        $uploads_dir = trailingslashit(wp_upload_dir()['basedir']) . 'decent-elements/minified/';

        if (is_dir($uploads_dir)) {
            $this->delete_directory($uploads_dir);
        }

        delete_option('decent_elements_assets_optimized');
        delete_option('decent_elements_last_optimization');
        delete_option('decent_elements_minified_js_generated');
        delete_option('decent_elements_minified_css_generated');
    }

    /**
     * Recursively delete directory
     */
    private function delete_directory($dir)
    {
        if (!is_dir($dir)) {
            return;
        }

        $files = array_diff(scandir($dir), ['.', '..']);

        foreach ($files as $file) {
            $path = $dir . '/' . $file;
            if (is_dir($path)) {
                $this->delete_directory($path);
            } else {
                unlink($path);
            }
        }

        rmdir($dir);
    }

    /**
     * Get optimization statistics
     */
    public function get_optimization_stats()
    {
        $uploads_dir = trailingslashit(wp_upload_dir()['basedir']) . 'decent-elements/minified/';
        $js_file = $uploads_dir . 'js/de-scripts.js';
        $css_file = $uploads_dir . 'css/de-styles.css';

        $stats = [
            'enabled' => $this->is_optimization_enabled(),
            'last_generated' => get_option('decent_elements_last_optimization', 0),
            'js_file_exists' => file_exists($js_file),
            'css_file_exists' => file_exists($css_file),
            'js_file_size' => file_exists($js_file) ? filesize($js_file) : 0,
            'css_file_size' => file_exists($css_file) ? filesize($css_file) : 0,
            'total_widgets' => count($this->get_widget_ids()),
            'total_extensions' => count($this->get_extension_ids())
        ];

        return $stats;
    }

    /**
     * Debug asset optimization issues
     */
    public function debug_asset_generation()
    {
        $debug_info = [];

        // Check optimization status
        $debug_info['optimization_enabled'] = $this->is_optimization_enabled();

        // Get active widgets and extensions
        $widgets = $this->get_widget_ids();
        $extensions = $this->get_extension_ids();

        $debug_info['active_widgets'] = $widgets;
        $debug_info['active_extensions'] = $extensions;

        // Check asset files existence
        $debug_info['asset_files'] = [];

        // Check widget assets
        foreach ($widgets as $widget) {
            $js_path = DECENT_ELEMENTS_PATH . 'assets/widgets/js/' . $widget . '.js';
            $css_path = DECENT_ELEMENTS_PATH . 'assets/widgets/css/' . $widget . '.css';

            $debug_info['asset_files']['widgets'][$widget] = [
                'js_exists' => file_exists($js_path),
                'js_path' => $js_path,
                'css_exists' => file_exists($css_path),
                'css_path' => $css_path
            ];
        }

        // Check extension assets
        foreach ($extensions as $extension) {
            $js_path = DECENT_ELEMENTS_PATH . 'assets/extensions/js/' . $extension . '.js';
            $css_path = DECENT_ELEMENTS_PATH . 'assets/extensions/css/' . $extension . '.css';

            $debug_info['asset_files']['extensions'][$extension] = [
                'js_exists' => file_exists($js_path),
                'js_path' => $js_path,
                'css_exists' => file_exists($css_path),
                'css_path' => $css_path
            ];
        }

        // Get found assets
        $assets = $this->get_assets();
        $debug_info['found_assets'] = $assets;
        $debug_info['js_paths'] = $this->get_js_paths();
        $debug_info['css_paths'] = $this->get_css_paths();

        // Check minification library
        $debug_info['minify_library_loaded'] = class_exists('MatthiasMullie\Minify\JS');

        // Check upload directory
        $uploads_dir = trailingslashit(wp_upload_dir()['basedir']) . 'decent-elements/minified/';
        $debug_info['uploads_dir'] = $uploads_dir;
        $debug_info['uploads_dir_exists'] = is_dir($uploads_dir);
        $debug_info['uploads_dir_writable'] = is_writable(dirname($uploads_dir));

        // Check generated files
        $js_file = $uploads_dir . 'js/de-scripts.js';
        $css_file = $uploads_dir . 'css/de-styles.css';

        $debug_info['generated_files'] = [
            'js_file' => $js_file,
            'js_exists' => file_exists($js_file),
            'css_file' => $css_file,
            'css_exists' => file_exists($css_file)
        ];

        return $debug_info;
    }

    /**
     * Force regenerate assets for debugging
     */
    public function force_regenerate_assets()
    {
        // Force regeneration regardless of timestamps
        return $this->generate_minified_assets();
    }

    /**
     * Instance
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}
