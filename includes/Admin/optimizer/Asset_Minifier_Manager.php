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
	    error_log($this->is_optimization_enabled());
        if ($this->is_optimization_enabled()) {
            add_action('wp_enqueue_scripts', [$this, 'enqueue_optimized_assets'], 999);
            add_action('admin_init', [$this, 'maybe_regenerate_assets']);
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

    /**
     * Get active extension IDs
     */
    public function get_extension_ids()
    {
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

        // Widget assets
        foreach ($widgets as $widget) {
            $js_path = DECENT_ELEMENTS_PATH . 'assets/widgets/js/de-' . $widget . '.js';
            $css_path = DECENT_ELEMENTS_PATH . 'assets/widgets/css/de-' . $widget . $direction . '.css';

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

        // Extension assets
        foreach ($extensions as $extension) {
            $js_path = DECENT_ELEMENTS_PATH . 'assets/js/extensions/de-' . $extension . '.js';
            $css_path = DECENT_ELEMENTS_PATH . 'assets/css/extensions/de-' . $extension . $direction . '.css';

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
        // Load autoloader if available
        $this->load_minify_library();

        $scripts = array_merge($this->get_js_paths());

        $scripts = apply_filters('decent_elements/optimization/assets/scripts', $scripts);

        if (empty($scripts)) {
            return true;
        }

        $uploads_dir = trailingslashit(wp_upload_dir()['basedir']) . 'decent-elements/minified/js';
        if (!wp_mkdir_p($uploads_dir)) {
            return false;
        }

        $minified_path = $uploads_dir . "/de-scripts.js";

        try {
            if (class_exists('MatthiasMullie\Minify\JS')) {
                // Use proper minification if library is available
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
        } catch (Exception $e) {
            error_log('Decent Elements JS Minification Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Minify CSS files
     */
    public function minify_css()
    {
        // Load autoloader if available
        $this->load_minify_library();

        $styles = $this->get_css_paths();

        $styles = apply_filters('decent_elements/optimization/assets/styles', $styles);

        if (empty($styles)) {
            return true;
        }

        $uploads_dir = trailingslashit(wp_upload_dir()['basedir']) . 'decent-elements/minified/css';
        if (!wp_mkdir_p($uploads_dir)) {
            return false;
        }

        $minified_path = $uploads_dir . "/de-styles.css";

        try {
            if (class_exists('MatthiasMullie\Minify\CSS')) {
                // Use proper minification if library is available
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
        } catch (Exception $e) {
            error_log('Decent Elements CSS Minification Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Load minify library
     */
    private function load_minify_library()
    {
        // Try to load the autoloader
        $autoload_file = __DIR__ . '/autoload.php';
        if (file_exists($autoload_file)) {
            require_once $autoload_file;
        }

        // Try composer autoloader
        $composer_autoload = __DIR__ . '/vendor/autoload.php';
        if (file_exists($composer_autoload)) {
            require_once $composer_autoload;
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

// Initialize the Asset Minifier Manager
Asset_Minifier_Manager::instance();

$uploads_url = trailingslashit(wp_upload_dir()['baseurl']) . 'decent-elements/minified/';

error_log($uploads_url);