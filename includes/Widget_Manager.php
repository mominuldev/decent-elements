<?php
/**
 * Widget Manager
 *
 * @since     1.0.0
 */
namespace Decent_Elements;

defined('ABSPATH') || exit;

class Widget_Manager
{
    /**
     * @var object
     * @access private
     * @since 1.0.0
     */
    private static $_instance = null;

    /**
     * Available widgets
     * @var array
     */
    private $widgets = [
        'heading' => [
            'name' => 'Heading',
            'class' => 'Decent_Elements_Heading_Widget',
            'file' => 'heading.php',
            'default' => true
        ],
        'dual-color-heading' => [
            'name' => 'Dual Color Heading',
            'class' => 'Decent_Elements_Dual_Color_Heading_Widget',
            'file' => 'dual-color-heading.php',
            'default' => true
        ],
        'image-box' => [
            'name' => 'Image Box',
            'class' => 'Decent_Elements_Image_Box_Widget',
            'file' => 'image-box.php',
            'default' => true
        ],
        'icon-box' => [
            'name' => 'Icon Box',
            'class' => 'Decent_Elements_Icon_Box_Widget',
            'file' => 'icon-box.php',
            'default' => true
        ],
        'button' => [
            'name' => 'Button',
            'class' => 'Decent_Elements_Button_Widget',
            'file' => 'button.php',
            'default' => true
        ],
        'animated-testimonials' => [
            'name' => 'Animated Testimonials',
            'class' => 'Decent_Animated_Testimonials_Widget',
            'file' => 'animated-testimonials.php',
            'default' => true
        ]
    ];

    /**
     * Constructor function.
     * @since 1.0.0
     */
    public function __construct()
    {
        add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets']);
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
     * Get widget settings from database
     * @since 1.0.0
     */
    public function get_widget_settings()
    {
        $default_settings = [];
        foreach ($this->widgets as $widget_id => $widget_data) {
            $default_settings[$widget_id] = $widget_data['default'];
        }

        $saved_settings = get_option('decent_elements_widget_settings', $default_settings);
        return wp_parse_args($saved_settings, $default_settings);
    }

    /**
     * Update widget settings in database
     * @since 1.0.0
     */
    public function update_widget_settings($settings)
    {
        return update_option('decent_elements_widget_settings', $settings);
    }

    /**
     * Check if widget is enabled
     * @since 1.0.0
     */
    public function is_widget_enabled($widget_id)
    {
        $settings = $this->get_widget_settings();
        return isset($settings[$widget_id]) ? (bool) $settings[$widget_id] : false;
    }

    /**
     * Register widgets with Elementor
     * @since 1.0.0
     */
    public function register_widgets($widgets_manager)
    {
        $settings = $this->get_widget_settings();

        foreach ($this->widgets as $widget_id => $widget_data) {
            // Only register if widget is enabled
            if ($this->is_widget_enabled($widget_id)) {
                $widget_file = DECENT_ELEMENTS_ABSPATH . 'includes/widgets/' . $widget_data['file'];
                
                if (file_exists($widget_file)) {
                    require_once $widget_file;
                    
                    if (class_exists($widget_data['class'])) {
                        $widgets_manager->register_widget_type(new $widget_data['class']());
                    }
                }
            }
        }
    }

    /**
     * Get all available widgets
     * @since 1.0.0
     */
    public function get_available_widgets()
    {
        return $this->widgets;
    }

    /**
     * Cloning is forbidden.
     * @since 1.0.0
     */
    public function __clone()
    {
        _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?'), DECENT_ELEMENTS_VERSION);
    }
}