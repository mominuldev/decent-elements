<?php
/**
 * Extension Manager
 *
 * @since     1.0.0
 */

namespace Decent_Elements;

defined('ABSPATH') || exit;

class Decent_Elements_Extension_Manager
{
    /**
     * @var object
     * @access private
     * @since 1.0.0
     */
    private static $_instance = null;

    /**
     * Available extensions
     * @var array
     */
    private $extensions = [
        'custom-css' => [
            'name' => 'Custom CSS',
            'class' => 'Decent_Elements_Custom_CSS_Extension',
            'file' => 'custom-css.php',
            'default' => false
        ],
        'sticky-column' => [
            'name' => 'Sticky Column',
            'class' => 'Decent_Elements_Sticky_Column_Extension',
            'file' => 'sticky-column.php',
            'default' => false
        ],
        'wrapper-link' => [
            'name' => 'Wrapper Link',
            'class' => 'Decent_Elements_Wrapper_Link_Extension',
            'file' => 'wrapper-link.php',
            'default' => false
        ],
        'decent-elements-mouse-effects' => [
            'name' => 'Mouse Effects',
            'class' => 'Decent_Elements_Mouse_Effects_Extension',
            'file' => 'mouse-effects.php',
            'default' => true
        ],
        'decent-elements-scroll-effects' => [
            'name' => 'Scroll Effects',
            'class' => 'Decent_Elements_Scroll_Effects_Extension',
            'file' => 'scroll-effects.php',
            'default' => true
        ],
        'decent-elements-advanced-animations' => [
            'name' => 'Advanced Animations',
            'class' => 'Decent_Elements_Advanced_Animations_Extension',
            'file' => 'advanced-animations.php',
            'default' => false
        ],
        'custom-cursor' => [
	        'name' => 'Custom Cursor',
	        'class' => 'Decent_Elements_Custom_Cursor_Extension',
	        'file' => 'custom-cursor.php',
	        'default' => false
        ],
    ];

    /**
     * Constructor function.
     * @since 1.0.0
     */
    public function __construct()
    {
        add_action('init', [$this, 'init_extensions']);
    }

    /**
     * Ensures only one instance is loaded or can be loaded.
     * @since 1.0.0
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Initialize extensions
     * @since 1.0.0
     */
    public function init_extensions()
    {
        $enabled_extensions = $this->get_enabled_extensions();
        
        foreach ($enabled_extensions as $extension_id) {
            if (isset($this->extensions[$extension_id])) {
                $this->load_extension($extension_id);
            }
        }
    }

    /**
     * Load an extension
     * @since 1.0.0
     */
    private function load_extension($extension_id)
    {
        $extension = $this->extensions[$extension_id];
        $extension_file = DECENT_ELEMENTS_PATH . 'includes/extensions/' . $extension['file'];
        
        if (file_exists($extension_file)) {
            require_once $extension_file;
            
            if (class_exists($extension['class'])) {
                new $extension['class']();
            }
        }
    }

    /**
     * Get available extensions
     * @since 1.0.0
     */
    public function get_available_extensions()
    {
        return $this->extensions;
    }

    /**
     * Get enabled extensions
     * @since 1.0.0
     */
    public function get_enabled_extensions()
    {
        $settings = $this->get_extension_settings();
        $enabled = [];
        
        foreach ($this->extensions as $extension_id => $extension_data) {
            $is_enabled = isset($settings[$extension_id]) ? $settings[$extension_id] : $extension_data['default'];
            if ($is_enabled) {
                $enabled[] = $extension_id;
            }
        }
        
        return $enabled;
    }

    /**
     * Get extension settings from database
     * @since 1.0.0
     */
    public function get_extension_settings()
    {
        return get_option('decent_elements_extension_settings', []);
    }

    /**
     * Update extension settings
     * @since 1.0.0
     */
    public function update_extension_settings($settings)
    {
        return update_option('decent_elements_extension_settings', $settings);
    }

    /**
     * Check if extension is enabled
     * @since 1.0.0
     */
    public function is_extension_enabled($extension_id)
    {
        $settings = $this->get_extension_settings();
        return isset($settings[$extension_id]) ? $settings[$extension_id] : 
               (isset($this->extensions[$extension_id]) ? $this->extensions[$extension_id]['default'] : false);
    }

    /**
     * Enable extension
     * @since 1.0.0
     */
    public function enable_extension($extension_id)
    {
        $settings = $this->get_extension_settings();
        $settings[$extension_id] = true;
        return $this->update_extension_settings($settings);
    }

    /**
     * Disable extension
     * @since 1.0.0
     */
    public function disable_extension($extension_id)
    {
        $settings = $this->get_extension_settings();
        $settings[$extension_id] = false;
        return $this->update_extension_settings($settings);
    }

    /**
     * Get extension data by ID
     * @since 1.0.0
     */
    public function get_extension($extension_id)
    {
        return isset($this->extensions[$extension_id]) ? $this->extensions[$extension_id] : null;
    }

    /**
     * Cloning is forbidden.
     * @since 1.0.0
     */
    public function __clone()
    {
        _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?'), DECENT_ELEMENTS_VERSION);
    }

    /**
     * Unserializing instances of this class is forbidden.
     * @since 1.0.0
     */
    public function __wakeup()
    {
        _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?'), DECENT_ELEMENTS_VERSION);
    }
}

// Initialize the Extension Manager
function Decent_Elements_Extension_Manager()
{
    return Decent_Elements_Extension_Manager::instance();
}

// Global for backwards compatibility.
$GLOBALS['decent_elements_extension_manager'] = Decent_Elements_Extension_Manager();