<?php

namespace Elementor\Core\Base;

/**
 * Base Object
 *
 * Base class that provides basic settings handling functionality.
 *
 * @since 2.3.0
 */
class Base_Object
{
    /**
     * Get Settings.
     *
     * @since 2.3.0
     * @access public
     *
     * @param string $setting Optional. The key of the requested setting. Default is null.
     *
     * @return mixed An array of all settings, or a single value if `$setting` was specified.
     */
    final public function get_settings($setting = null)
    {
    }
    /**
     * Set settings.
     *
     * @since 2.3.0
     * @access public
     *
     * @param array|string $key   If key is an array, the settings are overwritten by that array. Otherwise, the
     *                            settings of the key will be set to the given `$value` param.
     *
     * @param mixed        $value Optional. Default is null.
     */
    final public function set_settings($key, $value = null)
    {
    }
    /**
     * Delete setting.
     *
     * Deletes the settings array or a specific key of the settings array if `$key` is specified.
     *
     * @since 2.3.0
     * @access public
     *
     * @param string $key Optional. Default is null.
     */
    public function delete_setting($key = null)
    {
    }
    final public function merge_properties(array $default_props, array $custom_props, array $allowed_props_keys = [])
    {
    }
    /**
     * Get items.
     *
     * Utility method that receives an array with a needle and returns all the
     * items that match the needle. If needle is not defined the entire haystack
     * will be returned.
     *
     * @since 2.3.0
     * @access protected
     * @static
     *
     * @param array  $haystack An array of items.
     * @param string $needle   Optional. Needle. Default is null.
     *
     * @return mixed The whole haystack or the needle from the haystack when requested.
     */
    final protected static function get_items(array $haystack, $needle = null)
    {
    }
    /**
     * Get init settings.
     *
     * Used to define the default/initial settings of the object. Inheriting classes may implement this method to define
     * their own default/initial settings.
     *
     * @since 2.3.0
     * @access protected
     *
     * @return array
     */
    protected function get_init_settings()
    {
    }
    /**
     * Has Own Method
     *
     * Used for check whether the method passed as a parameter was declared in the current instance or inherited.
     * If a base_class_name is passed, it checks whether the method was declared in that class. If the method's
     * declaring class is the class passed as $base_class_name, it returns false. Otherwise (method was NOT declared
     * in $base_class_name), it returns true.
     *
     * Example #1 - only $method_name is passed:
     * The initial declaration of `register_controls()` happens in the `Controls_Stack` class. However, all
     * widgets which have their own controls declare this function as well, overriding the original
     * declaration. If `has_own_method()` would be called by a Widget's class which implements `register_controls()`,
     * with 'register_controls' passed as the first parameter - `has_own_method()` will return true. If the Widget
     * does not declare `register_controls()`, `has_own_method()` will return false.
     *
     * Example #2 - both $method_name and $base_class_name are passed
     * In this example, the widget class inherits from a base class `Widget_Base`, and the base implements
     * `register_controls()` to add certain controls to all widgets inheriting from it. `has_own_method()` is called by
     * the widget, with the string 'register_controls' passed as the first parameter, and 'Elementor\Widget_Base' (its full name
     * including the namespace) passed as the second parameter. If the widget class implements `register_controls()`,
     * `has_own_method` will return true. If the widget class DOESN'T implement `register_controls()`, it will return
     * false (because `Widget_Base` is the declaring class for `register_controls()`, and not the class that called
     * `has_own_method()`).
     *
     * @since 3.1.0
     *
     * @param string $method_name
     * @param string $base_class_name
     *
     * @return bool True if the method was declared by the current instance, False if it was inherited.
     */
    public function has_own_method($method_name, $base_class_name = null)
    {
    }
}
namespace Elementor;

/**
 * Elementor controls stack.
 *
 * An abstract class that provides the needed properties and methods to
 * manage and handle controls in the editor panel to inheriting classes.
 *
 * @since 1.4.0
 * @abstract
 */
abstract class Controls_Stack extends \Elementor\Core\Base\Base_Object
{
    /**
     * Responsive 'desktop' device name.
     *
     * @deprecated 3.4.0
     */
    const RESPONSIVE_DESKTOP = 'desktop';
    /**
     * Responsive 'tablet' device name.
     *
     * @deprecated 3.4.0
     */
    const RESPONSIVE_TABLET = 'tablet';
    /**
     * Responsive 'mobile' device name.
     *
     * @deprecated 3.4.0
     */
    const RESPONSIVE_MOBILE = 'mobile';
    /**
     * Get element name.
     *
     * Retrieve the element name.
     *
     * @since 1.4.0
     * @access public
     * @abstract
     *
     * @return string The name.
     */
    abstract public function get_name();
    /**
     * Get unique name.
     *
     * Some classes need to use unique names, this method allows you to create
     * them. By default it retrieves the regular name.
     *
     * @since 1.6.0
     * @access public
     *
     * @return string Unique name.
     */
    public function get_unique_name()
    {
    }
    /**
     * Get element ID.
     *
     * Retrieve the element generic ID.
     *
     * @since 1.4.0
     * @access public
     *
     * @return string The ID.
     */
    public function get_id()
    {
    }
    /**
     * Get element ID.
     *
     * Retrieve the element generic ID as integer.
     *
     * @since 1.8.0
     * @access public
     *
     * @return string The converted ID.
     */
    public function get_id_int()
    {
    }
    /**
     * Get widget number.
     *
     * Get the first three numbers of the element converted ID.
     *
     * @since 3.16
     * @access public
     *
     * @return string The widget number.
     */
    public function get_widget_number(): string
    {
    }
    /**
     * Get the type.
     *
     * Retrieve the type, e.g. 'stack', 'section', 'widget' etc.
     *
     * @since 1.4.0
     * @access public
     * @static
     *
     * @return string The type.
     */
    public static function get_type()
    {
    }
    /**
     * @since 2.9.0
     * @access public
     *
     * @return bool
     */
    public function is_editable()
    {
    }
    /**
     * Get current section.
     *
     * When inserting new controls, this method will retrieve the current section.
     *
     * @since 1.7.1
     * @access public
     *
     * @return null|array Current section.
     */
    public function get_current_section()
    {
    }
    /**
     * Get current tab.
     *
     * When inserting new controls, this method will retrieve the current tab.
     *
     * @since 1.7.1
     * @access public
     *
     * @return null|array Current tab.
     */
    public function get_current_tab()
    {
    }
    /**
     * Get controls.
     *
     * Retrieve all the controls or, when requested, a specific control.
     *
     * @since 1.4.0
     * @access public
     *
     * @param string $control_id The ID of the requested control. Optional field,
     *                           when set it will return a specific control.
     *                           Default is null.
     *
     * @return mixed Controls list.
     */
    public function get_controls($control_id = null)
    {
    }
    /**
     * Get active controls.
     *
     * Retrieve an array of active controls that meet the condition field.
     *
     * If specific controls was given as a parameter, retrieve active controls
     * from that list, otherwise check for all the controls available.
     *
     * @since 1.4.0
     * @since 2.0.9 Added the `controls` and the `settings` parameters.
     * @access public
     * @deprecated 3.0.0
     *
     * @param array $controls Optional. An array of controls. Default is null.
     * @param array $settings Optional. Controls settings. Default is null.
     *
     * @return array Active controls.
     */
    public function get_active_controls(?array $controls = null, ?array $settings = null)
    {
    }
    /**
     * Get controls settings.
     *
     * Retrieve the settings for all the controls that represent them.
     *
     * @since 1.5.0
     * @access public
     *
     * @return array Controls settings.
     */
    public function get_controls_settings()
    {
    }
    /**
     * Add new control to stack.
     *
     * Register a single control to allow the user to set/update data.
     *
     * This method should be used inside `register_controls()`.
     *
     * @since 1.4.0
     * @access public
     *
     * @param string $id      Control ID.
     * @param array  $args    Control arguments.
     * @param array  $options Optional. Control options. Default is an empty array.
     *
     * @return bool True if control added, False otherwise.
     */
    public function add_control($id, array $args, $options = [])
    {
    }
    /**
     * Remove control from stack.
     *
     * Unregister an existing control and remove it from the stack.
     *
     * @since 1.4.0
     * @access public
     *
     * @param string $control_id Control ID.
     *
     * @return bool|\WP_Error
     */
    public function remove_control($control_id)
    {
    }
    /**
     * Update control in stack.
     *
     * Change the value of an existing control in the stack. When you add new
     * control you set the `$args` parameter, this method allows you to update
     * the arguments by passing new data.
     *
     * @since 1.4.0
     * @since 1.8.1 New `$options` parameter added.
     *
     * @access public
     *
     * @param string $control_id Control ID.
     * @param array  $args       Control arguments. Only the new fields you want
     *                           to update.
     * @param array  $options    Optional. Some additional options. Default is
     *                           an empty array.
     *
     * @return bool
     */
    public function update_control($control_id, array $args, array $options = [])
    {
    }
    /**
     * Get stack.
     *
     * Retrieve the stack of controls.
     *
     * @since 1.9.2
     * @access public
     *
     * @return array Stack of controls.
     */
    public function get_stack()
    {
    }
    /**
     * Get position information.
     *
     * Retrieve the position while injecting data, based on the element type.
     *
     * @since 1.7.0
     * @access public
     *
     * @param array $position {
     *     The injection position.
     *
     *     @type string $type     Injection type, either `control` or `section`.
     *                            Default is `control`.
     *     @type string $at       Where to inject. If `$type` is `control` accepts
     *                            `before` and `after`. If `$type` is `section`
     *                            accepts `start` and `end`. Default values based on
     *                            the `type`.
     *     @type string $of       Control/Section ID.
     *     @type array  $fallback Fallback injection position. When the position is
     *                            not found it will try to fetch the fallback
     *                            position.
     * }
     *
     * @return bool|array Position info.
     */
    final public function get_position_info(array $position)
    {
    }
    /**
     * Get control key.
     *
     * Retrieve the key of the control based on a given index of the control.
     *
     * @since 1.9.2
     * @access public
     *
     * @param string $control_index Control index.
     *
     * @return int Control key.
     */
    final public function get_control_key($control_index)
    {
    }
    /**
     * Get control index.
     *
     * Retrieve the index of the control based on a given key of the control.
     *
     * @since 1.7.6
     * @access public
     *
     * @param string $control_key Control key.
     *
     * @return false|int Control index.
     */
    final public function get_control_index($control_key)
    {
    }
    /**
     * Get section controls.
     *
     * Retrieve all controls under a specific section.
     *
     * @since 1.7.6
     * @access public
     *
     * @param string $section_id Section ID.
     *
     * @return array Section controls
     */
    final public function get_section_controls($section_id)
    {
    }
    /**
     * Add new group control to stack.
     *
     * Register a set of related controls grouped together as a single unified
     * control. For example grouping together like typography controls into a
     * single, easy-to-use control.
     *
     * @since 1.4.0
     * @access public
     *
     * @param string $group_name Group control name.
     * @param array  $args       Group control arguments. Default is an empty array.
     * @param array  $options    Optional. Group control options. Default is an
     *                           empty array.
     */
    final public function add_group_control($group_name, array $args = [], array $options = [])
    {
    }
    /**
     * Get style controls.
     *
     * Retrieve style controls for all active controls or, when requested, from
     * a specific set of controls.
     *
     * @since 1.4.0
     * @since 2.0.9 Added the `settings` parameter.
     * @access public
     * @deprecated 3.0.0
     *
     * @param array $controls Optional. Controls list. Default is null.
     * @param array $settings Optional. Controls settings. Default is null.
     *
     * @return array Style controls.
     */
    final public function get_style_controls(?array $controls = null, ?array $settings = null)
    {
    }
    /**
     * Get tabs controls.
     *
     * Retrieve all the tabs assigned to the control.
     *
     * @since 1.4.0
     * @access public
     *
     * @return array Tabs controls.
     */
    final public function get_tabs_controls()
    {
    }
    /**
     * Add new responsive control to stack.
     *
     * Register a set of controls to allow editing based on user screen size.
     * This method registers one or more controls per screen size/device, depending on the current Responsive Control
     * Duplication Mode. There are 3 control duplication modes:
     * * 'off' - Only a single control is generated. In the Editor, this control is duplicated in JS.
     * * 'on' - Multiple controls are generated, one control per enabled device/breakpoint + a default/desktop control.
     * * 'dynamic' - If the control includes the `'dynamic' => 'active' => true` property - the control is duplicated,
     *               once for each device/breakpoint + default/desktop.
     *               If the control doesn't include the `'dynamic' => 'active' => true` property - the control is not duplicated.
     *
     * @since 1.4.0
     * @access public
     *
     * @param string $id      Responsive control ID.
     * @param array  $args    Responsive control arguments.
     * @param array  $options Optional. Responsive control options. Default is
     *                        an empty array.
     */
    final public function add_responsive_control($id, array $args, $options = [])
    {
    }
    /**
     * Update responsive control in stack.
     *
     * Change the value of an existing responsive control in the stack. When you
     * add new control you set the `$args` parameter, this method allows you to
     * update the arguments by passing new data.
     *
     * @since 1.4.0
     * @access public
     *
     * @param string $id      Responsive control ID.
     * @param array  $args    Responsive control arguments.
     * @param array  $options Optional. Additional options.
     */
    final public function update_responsive_control($id, array $args, array $options = [])
    {
    }
    /**
     * Remove responsive control from stack.
     *
     * Unregister an existing responsive control and remove it from the stack.
     *
     * @since 1.4.0
     * @access public
     *
     * @param string $id Responsive control ID.
     */
    final public function remove_responsive_control($id)
    {
    }
    /**
     * Get class name.
     *
     * Retrieve the name of the current class.
     *
     * @since 1.4.0
     * @access public
     *
     * @return string Class name.
     */
    final public function get_class_name()
    {
    }
    /**
     * Get the config.
     *
     * Retrieve the config or, if non set, use the initial config.
     *
     * @since 1.4.0
     * @access public
     *
     * @return array|null The config.
     */
    final public function get_config()
    {
    }
    /**
     * Set a config property.
     *
     * Set a specific property of the config list for this controls-stack.
     *
     * @param string $key
     * @param string $value
     * @since 3.5.0
     * @access public
     */
    public function set_config($key, $value)
    {
    }
    /**
     * Get frontend settings keys.
     *
     * Retrieve settings keys for all frontend controls.
     *
     * @since 1.6.0
     * @access public
     *
     * @return array Settings keys for each control.
     */
    final public function get_frontend_settings_keys()
    {
    }
    /**
     * Get controls pointer index.
     *
     * Retrieve pointer index where the next control should be added.
     *
     * While using injection point, it will return the injection point index.
     * Otherwise index of the last control plus one.
     *
     * @since 1.9.2
     * @access public
     *
     * @return int Controls pointer index.
     */
    public function get_pointer_index()
    {
    }
    /**
     * Get the raw data.
     *
     * Retrieve all the items or, when requested, a specific item.
     *
     * @since 1.4.0
     * @access public
     *
     * @param string $item Optional. The requested item. Default is null.
     *
     * @return mixed The raw data.
     */
    public function get_data($item = null)
    {
    }
    /**
     * @param null $setting
     * @param null $settings
     * @return array|mixed|null
     * @since 2.0.14
     * @access public
     */
    public function get_parsed_dynamic_settings($setting = null, $settings = null)
    {
    }
    /**
     * Get active settings.
     *
     * Retrieve the settings from all the active controls.
     *
     * @param array|null $settings Optional. Controls settings. Default is null.
     * @param array|null $controls Optional. An array of controls. Default is null.
     *
     * @return array Active settings.
     * @since 2.1.0 Added the `controls` and the `settings` parameters.
     * @access public
     *
     * @since 1.4.0
     */
    public function get_active_settings($settings = null, $controls = null)
    {
    }
    /**
     * Get settings for display.
     *
     * Retrieve all the settings or, when requested, a specific setting for display.
     *
     * Unlike `get_settings()` method, this method retrieves only active settings
     * that passed all the conditions, rendered all the shortcodes and all the dynamic
     * tags.
     *
     * @since 2.0.0
     * @access public
     *
     * @param string $setting_key Optional. The key of the requested setting.
     *                            Default is null.
     *
     * @return mixed The settings.
     */
    public function get_settings_for_display($setting_key = null)
    {
    }
    /**
     * Parse dynamic settings.
     *
     * Retrieve the settings with rendered dynamic tags.
     *
     * @since 2.0.0
     * @access public
     *
     * @param array $settings     Optional. The requested setting. Default is null.
     * @param array $controls     Optional. The controls array. Default is null.
     * @param array $all_settings Optional. All the settings. Default is null.
     *
     * @return array The settings with rendered dynamic tags.
     */
    public function parse_dynamic_settings($settings, $controls = null, $all_settings = null)
    {
    }
    /**
     * Get frontend settings.
     *
     * Retrieve the settings for all frontend controls.
     *
     * @since 1.6.0
     * @access public
     *
     * @return array Frontend settings.
     */
    public function get_frontend_settings()
    {
    }
    /**
     * Filter controls settings.
     *
     * Receives controls, settings and a callback function to filter the settings by
     * and returns filtered settings.
     *
     * @since 1.5.0
     * @access public
     *
     * @param callable $callback The callback function.
     * @param array    $settings Optional. Control settings. Default is an empty
     *                           array.
     * @param array    $controls Optional. Controls list. Default is an empty
     *                           array.
     *
     * @return array Filtered settings.
     */
    public function filter_controls_settings(callable $callback, array $settings = [], array $controls = [])
    {
    }
    /**
     * Get Responsive Control Device Suffix
     *
     * @deprecated 3.7.6 Use `Elementor\Controls_Manager::get_responsive_control_device_suffix()` instead.
     * @param array $control
     * @return string $device suffix
     */
    protected function get_responsive_control_device_suffix($control)
    {
    }
    /**
     * Whether the control is visible or not.
     *
     * Used to determine whether the control is visible or not.
     *
     * @param array $control The control.
     * @param null  $values Optional. Condition values. Default is null.
     * @param null  $controls
     * @return bool Whether the control is visible.
     * @since 1.4.0
     * @access public
     */
    public function is_control_visible($control, $values = null, $controls = null)
    {
    }
    /**
     * Start controls section.
     *
     * Used to add a new section of controls. When you use this method, all the
     * registered controls from this point will be assigned to this section,
     * until you close the section using `end_controls_section()` method.
     *
     * This method should be used inside `register_controls()`.
     *
     * @since 1.4.0
     * @access public
     *
     * @param string $section_id Section ID.
     * @param array  $args       Section arguments Optional.
     */
    public function start_controls_section($section_id, array $args = [])
    {
    }
    /**
     * End controls section.
     *
     * Used to close an existing open controls section. When you use this method
     * it stops adding new controls to this section.
     *
     * This method should be used inside `register_controls()`.
     *
     * @since 1.4.0
     * @access public
     */
    public function end_controls_section()
    {
    }
    /**
     * Start controls tabs.
     *
     * Used to add a new set of tabs inside a section. You should use this
     * method before adding new individual tabs using `start_controls_tab()`.
     * Each tab added after this point will be assigned to this group of tabs,
     * until you close it using `end_controls_tabs()` method.
     *
     * This method should be used inside `register_controls()`.
     *
     * @since 1.4.0
     * @access public
     *
     * @param string $tabs_id Tabs ID.
     * @param array  $args    Tabs arguments.
     */
    public function start_controls_tabs($tabs_id, array $args = [])
    {
    }
    /**
     * End controls tabs.
     *
     * Used to close an existing open controls tabs. When you use this method it
     * stops adding new controls to this tabs.
     *
     * This method should be used inside `register_controls()`.
     *
     * @since 1.4.0
     * @access public
     */
    public function end_controls_tabs()
    {
    }
    /**
     * Start controls tab.
     *
     * Used to add a new tab inside a group of tabs. Use this method before
     * adding new individual tabs using `start_controls_tab()`.
     * Each tab added after this point will be assigned to this group of tabs,
     * until you close it using `end_controls_tab()` method.
     *
     * This method should be used inside `register_controls()`.
     *
     * @since 1.4.0
     * @access public
     *
     * @param string $tab_id Tab ID.
     * @param array  $args   Tab arguments.
     */
    public function start_controls_tab($tab_id, $args)
    {
    }
    /**
     * End controls tab.
     *
     * Used to close an existing open controls tab. When you use this method it
     * stops adding new controls to this tab.
     *
     * This method should be used inside `register_controls()`.
     *
     * @since 1.4.0
     * @access public
     */
    public function end_controls_tab()
    {
    }
    /**
     * Start popover.
     *
     * Used to add a new set of controls in a popover. When you use this method,
     * all the registered controls from this point will be assigned to this
     * popover, until you close the popover using `end_popover()` method.
     *
     * This method should be used inside `register_controls()`.
     *
     * @since 1.9.0
     * @access public
     */
    final public function start_popover()
    {
    }
    /**
     * End popover.
     *
     * Used to close an existing open popover. When you use this method it stops
     * adding new controls to this popover.
     *
     * This method should be used inside `register_controls()`.
     *
     * @since 1.9.0
     * @access public
     */
    final public function end_popover()
    {
    }
    /**
     * Add render attribute.
     *
     * Used to add attributes to a specific HTML element.
     *
     * The HTML tag is represented by the element parameter, then you need to
     * define the attribute key and the attribute key. The final result will be:
     * `<element attribute_key="attribute_value">`.
     *
     * Example usage:
     *
     * `$this->add_render_attribute( 'wrapper', 'class', 'custom-widget-wrapper-class' );`
     * `$this->add_render_attribute( 'widget', 'id', 'custom-widget-id' );`
     * `$this->add_render_attribute( 'button', [ 'class' => 'custom-button-class', 'id' => 'custom-button-id' ] );`
     *
     * @since 1.0.0
     * @access public
     *
     * @param array|string $element   The HTML element.
     * @param array|string $key       Optional. Attribute key. Default is null.
     * @param array|string $value     Optional. Attribute value. Default is null.
     * @param bool         $overwrite Optional. Whether to overwrite existing
     *                                attribute. Default is false, not to overwrite.
     *
     * @return self Current instance of the element.
     */
    public function add_render_attribute($element, $key = null, $value = null, $overwrite = false)
    {
    }
    /**
     * Get Render Attributes
     *
     * Used to retrieve render attribute.
     *
     * The returned array is either all elements and their attributes if no `$element` is specified, an array of all
     * attributes of a specific element or a specific attribute properties if `$key` is specified.
     *
     * Returns null if one of the requested parameters isn't set.
     *
     * @since 2.2.6
     * @access public
     * @param string $element
     * @param string $key
     *
     * @return array
     */
    public function get_render_attributes($element = '', $key = '')
    {
    }
    /**
     * Set render attribute.
     *
     * Used to set the value of the HTML element render attribute or to update
     * an existing render attribute.
     *
     * @since 1.0.0
     * @access public
     *
     * @param array|string $element The HTML element.
     * @param array|string $key     Optional. Attribute key. Default is null.
     * @param array|string $value   Optional. Attribute value. Default is null.
     *
     * @return self Current instance of the element.
     */
    public function set_render_attribute($element, $key = null, $value = null)
    {
    }
    /**
     * Remove render attribute.
     *
     * Used to remove an element (with its keys and their values), key (with its values),
     * or value/s from an HTML element's render attribute.
     *
     * @since 2.7.0
     * @access public
     *
     * @param string       $element       The HTML element.
     * @param string       $key           Optional. Attribute key. Default is null.
     * @param array|string $values   Optional. Attribute value/s. Default is null.
     */
    public function remove_render_attribute($element, $key = null, $values = null)
    {
    }
    /**
     * Get render attribute string.
     *
     * Used to retrieve the value of the render attribute.
     *
     * @since 1.0.0
     * @access public
     *
     * @param string $element The element.
     *
     * @return string Render attribute string, or an empty string if the attribute
     *                is empty or not exist.
     */
    public function get_render_attribute_string($element)
    {
    }
    /**
     * Print render attribute string.
     *
     * Used to output the rendered attribute.
     *
     * @since 2.0.0
     * @access public
     *
     * @param array|string $element The element.
     */
    public function print_render_attribute_string($element)
    {
    }
    /**
     * Print element template.
     *
     * Used to generate the element template on the editor.
     *
     * @since 2.0.0
     * @access public
     */
    public function print_template()
    {
    }
    /**
     * On import update dynamic content (e.g. post and term IDs).
     *
     * @since 3.8.0
     *
     * @param array      $config   The config of the passed element.
     * @param array      $data     The data that requires updating/replacement when imported.
     * @param array|null $controls The available controls.
     *
     * @return array Element data.
     */
    public static function on_import_update_dynamic_content(array $config, array $data, $controls = null): array
    {
    }
    /**
     * Start injection.
     *
     * Used to inject controls and sections to a specific position in the stack.
     *
     * When you use this method, all the registered controls and sections will
     * be injected to a specific position in the stack, until you stop the
     * injection using `end_injection()` method.
     *
     * @since 1.7.1
     * @access public
     *
     * @param array $position {
     *     The position where to start the injection.
     *
     *     @type string $type Injection type, either `control` or `section`.
     *                        Default is `control`.
     *     @type string $at   Where to inject. If `$type` is `control` accepts
     *                        `before` and `after`. If `$type` is `section`
     *                        accepts `start` and `end`. Default values based on
     *                        the `type`.
     *     @type string $of   Control/Section ID.
     * }
     */
    final public function start_injection(array $position)
    {
    }
    /**
     * End injection.
     *
     * Used to close an existing opened injection point.
     *
     * When you use this method it stops adding new controls and sections to
     * this point and continue to add controls to the regular position in the
     * stack.
     *
     * @since 1.7.1
     * @access public
     */
    final public function end_injection()
    {
    }
    /**
     * Get injection point.
     *
     * Retrieve the injection point in the stack where new controls and sections
     * will be inserted.
     *
     * @since 1.9.2
     * @access public
     *
     * @return array|null An array when an injection point is defined, null
     *                    otherwise.
     */
    final public function get_injection_point()
    {
    }
    /**
     * Register controls.
     *
     * Used to add new controls to any element type. For example, external
     * developers use this method to register controls in a widget.
     *
     * Should be inherited and register new controls using `add_control()`,
     * `add_responsive_control()` and `add_group_control()`, inside control
     * wrappers like `start_controls_section()`, `start_controls_tabs()` and
     * `start_controls_tab()`.
     *
     * @since 1.4.0
     * @access protected
     * @deprecated 3.1.0 Use `register_controls()` method instead.
     */
    protected function _register_controls()
    {
    }
    /**
     * Register controls.
     *
     * Used to add new controls to any element type. For example, external
     * developers use this method to register controls in a widget.
     *
     * Should be inherited and register new controls using `add_control()`,
     * `add_responsive_control()` and `add_group_control()`, inside control
     * wrappers like `start_controls_section()`, `start_controls_tabs()` and
     * `start_controls_tab()`.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    /**
     * Get default data.
     *
     * Retrieve the default data. Used to reset the data on initialization.
     *
     * @since 1.4.0
     * @access protected
     *
     * @return array Default data.
     */
    protected function get_default_data()
    {
    }
    /**
     * @since 2.3.0
     * @access protected
     */
    protected function get_init_settings()
    {
    }
    /**
     * Get initial config.
     *
     * Retrieve the current element initial configuration - controls list and
     * the tabs assigned to the control.
     *
     * @since 2.9.0
     * @access protected
     *
     * @return array The initial config.
     */
    protected function get_initial_config()
    {
    }
    /**
     * Get initial config.
     *
     * Retrieve the current element initial configuration - controls list and
     * the tabs assigned to the control.
     *
     * @since 1.4.0
     * @deprecated 2.9.0 Use `get_initial_config()` method instead.
     * @access protected
     *
     * @return array The initial config.
     */
    protected function _get_initial_config()
    {
    }
    /**
     * Get section arguments.
     *
     * Retrieve the section arguments based on section ID.
     *
     * @since 1.4.0
     * @access protected
     *
     * @param string $section_id Section ID.
     *
     * @return array Section arguments.
     */
    protected function get_section_args($section_id)
    {
    }
    /**
     * Render element.
     *
     * Generates the final HTML on the frontend.
     *
     * @since 2.0.0
     * @access protected
     */
    protected function render()
    {
    }
    /**
     * Render element in static mode.
     *
     * If not inherent will call the base render.
     */
    protected function render_static()
    {
    }
    /**
     * Determine the render logic.
     */
    protected function render_by_mode()
    {
    }
    /**
     * Print content template.
     *
     * Used to generate the content template on the editor, using a
     * Backbone JavaScript template.
     *
     * @access protected
     * @since 2.0.0
     *
     * @param string $template_content Template content.
     */
    protected function print_template_content($template_content)
    {
    }
    /**
     * Render element output in the editor.
     *
     * Used to generate the live preview, using a Backbone JavaScript template.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template()
    {
    }
    /**
     * Render element output in the editor.
     *
     * Used to generate the live preview, using a Backbone JavaScript template.
     *
     * @since 2.0.0
     * @deprecated 2.9.0 Use `content_template()` method instead.
     * @access protected
     */
    protected function _content_template()
    {
    }
    /**
     * Initialize controls.
     *
     * Register the all controls added by `register_controls()`.
     *
     * @since 2.0.0
     * @access protected
     */
    protected function init_controls()
    {
    }
    protected function handle_control_position(array $args, $control_id, $overwrite)
    {
    }
    /**
     * Initialize the class.
     *
     * Set the raw data, the ID and the parsed settings.
     *
     * @since 2.9.0
     * @access protected
     *
     * @param array $data Initial data.
     */
    protected function init($data)
    {
    }
    /**
     * Initialize the class.
     *
     * Set the raw data, the ID and the parsed settings.
     *
     * @since 1.4.0
     * @deprecated 2.9.0 Use `init()` method instead.
     * @access protected
     *
     * @param array $data Initial data.
     */
    protected function _init($data)
    {
    }
    /**
     * Controls stack constructor.
     *
     * Initializing the control stack class using `$data`. The `$data` is required
     * for a normal instance. It is optional only for internal `type instance`.
     *
     * @since 1.4.0
     * @access public
     *
     * @param array $data Optional. Control stack data. Default is an empty array.
     */
    public function __construct(array $data = [])
    {
    }
}
/**
 * Elementor element base.
 *
 * An abstract class to register new Elementor elements. It extended the
 * `Controls_Stack` class to inherit its properties.
 *
 * This abstract class must be extended in order to register new elements.
 *
 * @since 1.0.0
 * @abstract
 */
abstract class Element_Base extends \Elementor\Controls_Stack
{
    /**
     * Add script depends.
     *
     * Register new script to enqueue by the handler.
     *
     * @since 1.9.0
     * @access public
     *
     * @param string $handler Depend script handler.
     */
    public function add_script_depends($handler)
    {
    }
    /**
     * Add style depends.
     *
     * Register new style to enqueue by the handler.
     *
     * @since 1.9.0
     * @access public
     *
     * @param string $handler Depend style handler.
     */
    public function add_style_depends($handler)
    {
    }
    /**
     * Get script dependencies.
     *
     * Retrieve the list of script dependencies the element requires.
     *
     * @since 1.3.0
     * @access public
     *
     * @return array Element scripts dependencies.
     */
    public function get_script_depends()
    {
    }
    public function get_global_scripts()
    {
    }
    /**
     * Enqueue scripts.
     *
     * Registers all the scripts defined as element dependencies and enqueues
     * them. Use `get_script_depends()` method to add custom script dependencies.
     *
     * @since 1.3.0
     * @access public
     */
    final public function enqueue_scripts()
    {
    }
    public function register_frontend_handlers()
    {
    }
    /**
     * Get style dependencies.
     *
     * Retrieve the list of style dependencies the element requires.
     *
     * @since 1.9.0
     * @access public
     *
     * @return array Element styles dependencies.
     */
    public function get_style_depends()
    {
    }
    /**
     * Enqueue styles.
     *
     * Registers all the styles defined as element dependencies and enqueues
     * them. Use `get_style_depends()` method to add custom style dependencies.
     *
     * @since 1.9.0
     * @access public
     */
    final public function enqueue_styles()
    {
    }
    /**
     * @since 1.0.0
     * @deprecated 2.6.0
     * @access public
     * @static
     */
    final public static function add_edit_tool()
    {
    }
    /**
     * @since 2.2.0
     * @deprecated 2.6.0
     * @access public
     * @static
     */
    final public static function is_edit_buttons_enabled()
    {
    }
    /**
     * Get default child type.
     *
     * Retrieve the default child type based on element data.
     *
     * Note that not all elements support children.
     *
     * @since 1.0.0
     * @access protected
     * @abstract
     *
     * @param array $element_data Element data.
     *
     * @return Element_Base
     */
    abstract protected function _get_default_child_type(array $element_data);
    /**
     * Before element rendering.
     *
     * Used to add stuff before the element.
     *
     * @since 1.0.0
     * @access public
     */
    public function before_render()
    {
    }
    /**
     * After element rendering.
     *
     * Used to add stuff after the element.
     *
     * @since 1.0.0
     * @access public
     */
    public function after_render()
    {
    }
    /**
     * Get element title.
     *
     * Retrieve the element title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Element title.
     */
    public function get_title()
    {
    }
    /**
     * Get element icon.
     *
     * Retrieve the element icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Element icon.
     */
    public function get_icon()
    {
    }
    public function get_help_url()
    {
    }
    public function get_custom_help_url()
    {
    }
    /**
     * Whether the reload preview is required.
     *
     * Used to determine whether the reload preview is required or not.
     *
     * @since 1.0.0
     * @access public
     *
     * @return bool Whether the reload preview is required.
     */
    public function is_reload_preview_required()
    {
    }
    /**
     * @since 2.3.1
     * @access protected
     */
    protected function should_print_empty()
    {
    }
    /**
     * Whether the element returns dynamic content.
     *
     * Set to determine whether to cache the element output or not.
     *
     * @since 3.22.0
     * @access protected
     *
     * @return bool Whether to cache the element output.
     */
    protected function is_dynamic_content(): bool
    {
    }
    /**
     * Get child elements.
     *
     * Retrieve all the child elements of this element.
     *
     * @since 1.0.0
     * @access public
     *
     * @return Element_Base[] Child elements.
     */
    public function get_children()
    {
    }
    /**
     * Get default arguments.
     *
     * Retrieve the element default arguments. Used to return all the default
     * arguments or a specific default argument, if one is set.
     *
     * @since 1.0.0
     * @access public
     *
     * @param array $item Optional. Default is null.
     *
     * @return array Default argument(s).
     */
    public function get_default_args($item = null)
    {
    }
    /**
     * Get panel presets.
     *
     * Used for displaying the widget in the panel multiple times, but with different defaults values,
     * icon, title etc.
     *
     * @since 3.16.0
     * @access public
     *
     * @return array
     */
    public function get_panel_presets()
    {
    }
    /**
     * Add new child element.
     *
     * Register new child element to allow hierarchy.
     *
     * @since 1.0.0
     * @access public
     * @param array $child_data Child element data.
     * @param array $child_args Child element arguments.
     *
     * @return Element_Base|false Child element instance, or false if failed.
     */
    public function add_child(array $child_data, array $child_args = [])
    {
    }
    /**
     * Add link render attributes.
     *
     * Used to add link tag attributes to a specific HTML element.
     *
     * The HTML link tag is represented by the element parameter. The `url_control` parameter
     * needs to be an array of link settings in the same format they are set by Elementor's URL control.
     *
     * Example usage:
     *
     * `$this->add_link_attributes( 'button', $settings['link'] );`
     *
     * @since 2.8.0
     * @access public
     *
     * @param array|string $element   The HTML element.
     * @param array        $url_control      Array of link settings.
     * @param bool         $overwrite         Optional. Whether to overwrite existing
     *                                        attribute. Default is false, not to overwrite.
     *
     * @return Element_Base Current instance of the element.
     */
    public function add_link_attributes($element, array $url_control, $overwrite = false)
    {
    }
    /**
     * Print element.
     *
     * Used to generate the element final HTML on the frontend and the editor.
     *
     * @since 1.0.0
     * @access public
     */
    public function print_element()
    {
    }
    protected function should_render_shortcode()
    {
    }
    /**
     * Get the element raw data.
     *
     * Retrieve the raw element data, including the id, type, settings, child
     * elements and whether it is an inner element.
     *
     * The data with the HTML used always to display the data, but the Elementor
     * editor uses the raw data without the HTML in order not to render the data
     * again.
     *
     * @since 1.0.0
     * @access public
     *
     * @param bool $with_html_content Optional. Whether to return the data with
     *                                HTML content or without. Used for caching.
     *                                Default is false, without HTML.
     *
     * @return array Element raw data.
     */
    public function get_raw_data($with_html_content = false)
    {
    }
    public function get_data_for_save()
    {
    }
    /**
     * Get unique selector.
     *
     * Retrieve the unique selector of the element. Used to set a unique HTML
     * class for each HTML element. This way Elementor can set custom styles for
     * each element.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Unique selector.
     */
    public function get_unique_selector()
    {
    }
    /**
     * Is type instance.
     *
     * Used to determine whether the element is an instance of that type or not.
     *
     * @since 1.0.0
     * @access public
     *
     * @return bool Whether the element is an instance of that type.
     */
    public function is_type_instance()
    {
    }
    /**
     * On import update dynamic content (e.g. post and term IDs).
     *
     * @since 3.8.0
     *
     * @param array      $config   The config of the passed element.
     * @param array      $data     The data that requires updating/replacement when imported.
     * @param array|null $controls The available controls.
     *
     * @return array Element data.
     */
    public static function on_import_update_dynamic_content(array $config, array $data, $controls = null): array
    {
    }
    /**
     * Add render attributes.
     *
     * Used to add attributes to the current element wrapper HTML tag.
     *
     * @since 1.3.0
     * @access protected
     * @deprecated 3.1.0 Use `add_render_attribute()` method instead.
     */
    protected function _add_render_attributes()
    {
    }
    /**
     * Add render attributes.
     *
     * Used to add attributes to the current element wrapper HTML tag.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function add_render_attributes()
    {
    }
    /**
     * Register the Transform controls in the advanced tab of the element.
     *
     * Previously registered under the Widget_Common class, but registered a more fundamental level now to enable access from other widgets.
     *
     * @param string $element_selector
     * @param string $transform_selector_class
     * @return void
     * @since 3.9.0
     * @access protected
     */
    protected function register_transform_section($element_selector = '', $transform_selector_class = ' > .elementor-widget-container')
    {
    }
    /**
     * Add Hidden Device Controls
     *
     * Adds controls for hiding elements within certain devices' viewport widths. Adds a control for each active device.
     *
     * @since 3.4.0
     * @access protected
     */
    protected function add_hidden_device_controls()
    {
    }
    /**
     * Get default data.
     *
     * Retrieve the default element data. Used to reset the data on initialization.
     *
     * @since 1.0.0
     * @access protected
     *
     * @return array Default data.
     */
    protected function get_default_data()
    {
    }
    /**
     * Print element content.
     *
     * Output the element final HTML on the frontend.
     *
     * @since 1.0.0
     * @access protected
     * @deprecated 3.1.0 Use `print_content()` method instead.
     */
    protected function _print_content()
    {
    }
    /**
     * Print element content.
     *
     * Output the element final HTML on the frontend.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function print_content()
    {
    }
    /**
     * Get initial config.
     *
     * Retrieve the current element initial configuration.
     *
     * Adds more configuration on top of the controls list and the tabs assigned
     * to the control. This method also adds element name, type, icon and more.
     *
     * @since 2.9.0
     * @access protected
     *
     * @return array The initial config.
     */
    protected function get_initial_config()
    {
    }
    /**
     * A Base method for sanitizing the settings before save.
     * This method is meant to be overridden by the element.
     *
     * @param array $settings
     * @return array
     */
    protected function on_save(array $settings)
    {
    }
    public function has_widget_inner_wrapper(): bool
    {
    }
    /**
     * Element base constructor.
     *
     * Initializing the element base class using `$data` and `$args`.
     *
     * The `$data` parameter is required for a normal instance because of the
     * way Elementor renders data when initializing elements.
     *
     * @since 1.0.0
     * @access public
     *
     * @param array      $data Optional. Element data. Default is an empty array.
     * @param array|null $args Optional. Element default arguments. Default is null.
     **/
    public function __construct(array $data = [], ?array $args = null)
    {
    }
}
/**
 * Elementor sub controls stack.
 *
 * An abstract class that can be used to divide a large ControlsStack into small parts.
 *
 * @abstract
 */
abstract class Sub_Controls_Stack
{
    /**
     * @var Controls_Stack
     */
    protected $parent;
    /**
     * Get self ID.
     *
     * Retrieve the self ID.
     *
     * @access public
     * @abstract
     */
    abstract public function get_id();
    /**
     * Get self title.
     *
     * Retrieve the self title.
     *
     * @access public
     * @abstract
     */
    abstract public function get_title();
    /**
     * Constructor.
     *
     * Initializing the base class by setting parent stack.
     *
     * @access public
     * @param Controls_Stack $element_parent
     */
    public function __construct($element_parent)
    {
    }
    /**
     * Get control ID.
     *
     * Retrieve the control ID. Note that the sub controls stack may have a special prefix
     * to distinguish them from regular controls, and from controls in other
     * sub stack.
     *
     * By default do nothing, and return the original id.
     *
     * @access protected
     *
     * @param string $control_base_id Control base ID.
     *
     * @return string Control ID.
     */
    protected function get_control_id($control_base_id)
    {
    }
    /**
     * Add new control.
     *
     * Register a single control to allow the user to set/update data.
     *
     * @access public
     *
     * @param string $id   Control ID.
     * @param array  $args Control arguments.
     * @param array  $options
     *
     * @return bool True if added, False otherwise.
     */
    public function add_control($id, $args, $options = [])
    {
    }
    /**
     * Update control.
     *
     * Change the value of an existing control.
     *
     * @access public
     *
     * @param string $id      Control ID.
     * @param array  $args    Control arguments. Only the new fields you want to update.
     * @param array  $options Optional. Some additional options.
     */
    public function update_control($id, $args, array $options = [])
    {
    }
    /**
     * Remove control.
     *
     * Unregister an existing control.
     *
     * @access public
     *
     * @param string $id Control ID.
     */
    public function remove_control($id)
    {
    }
    /**
     * Add new group control.
     *
     * Register a set of related controls grouped together as a single unified
     * control.
     *
     * @access public
     *
     * @param string $group_name Group control name.
     * @param array  $args       Group control arguments. Default is an empty array.
     * @param array  $options
     */
    public function add_group_control($group_name, $args, $options = [])
    {
    }
    /**
     * Add new responsive control.
     *
     * Register a set of controls to allow editing based on user screen size.
     *
     * @access public
     *
     * @param string $id   Responsive control ID.
     * @param array  $args Responsive control arguments.
     * @param array  $options
     */
    public function add_responsive_control($id, $args, $options = [])
    {
    }
    /**
     * Update responsive control.
     *
     * Change the value of an existing responsive control.
     *
     * @access public
     *
     * @param string $id   Responsive control ID.
     * @param array  $args Responsive control arguments.
     */
    public function update_responsive_control($id, $args)
    {
    }
    /**
     * Remove responsive control.
     *
     * Unregister an existing responsive control.
     *
     * @access public
     *
     * @param string $id Responsive control ID.
     */
    public function remove_responsive_control($id)
    {
    }
    /**
     * Start controls section.
     *
     * Used to add a new section of controls to the stack.
     *
     * @access public
     *
     * @param string $id   Section ID.
     * @param array  $args Section arguments.
     */
    public function start_controls_section($id, $args = [])
    {
    }
    /**
     * End controls section.
     *
     * Used to close an existing open controls section.
     *
     * @access public
     */
    public function end_controls_section()
    {
    }
    /**
     * Start controls tabs.
     *
     * Used to add a new set of tabs inside a section.
     *
     * @access public
     *
     * @param string $id Control ID.
     */
    public function start_controls_tabs($id)
    {
    }
    public function start_controls_tab($id, $args)
    {
    }
    /**
     * End controls tabs.
     *
     * Used to close an existing open controls tabs.
     *
     * @access public
     */
    public function end_controls_tab()
    {
    }
    /**
     * End controls tabs.
     *
     * Used to close an existing open controls tabs.
     *
     * @access public
     */
    public function end_controls_tabs()
    {
    }
}
/**
 * Elementor skin base.
 *
 * An abstract class to register new skins for Elementor widgets. Skins allows
 * you to add new templates, set custom controls and more.
 *
 * To register new skins for your widget use the `add_skin()` method inside the
 * widget's `register_skins()` method.
 *
 * @since 1.0.0
 * @abstract
 */
abstract class Skin_Base extends \Elementor\Sub_Controls_Stack
{
    /**
     * Parent widget.
     *
     * Holds the parent widget of the skin. Default value is null, no parent widget.
     *
     * @access protected
     *
     * @var Widget_Base|null
     */
    protected $parent = null;
    /**
     * Skin base constructor.
     *
     * Initializing the skin base class by setting parent widget and registering
     * controls actions.
     *
     * @since 1.0.0
     * @access public
     * @param Widget_Base $element_parent
     */
    public function __construct(\Elementor\Widget_Base $element_parent)
    {
    }
    /**
     * Render skin.
     *
     * Generates the final HTML on the frontend.
     *
     * @since 1.0.0
     * @access public
     * @abstract
     */
    abstract public function render();
    /**
     * Render element in static mode.
     *
     * If not inherent will call the base render.
     */
    public function render_static()
    {
    }
    /**
     * Determine the render logic.
     */
    public function render_by_mode()
    {
    }
    /**
     * Register skin controls actions.
     *
     * Run on init and used to register new skins to be injected to the widget.
     * This method is used to register new actions that specify the location of
     * the skin in the widget.
     *
     * Example usage:
     * `add_action( 'elementor/element/{widget_id}/{section_id}/before_section_end', [ $this, 'register_controls' ] );`
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls_actions()
    {
    }
    /**
     * Get skin control ID.
     *
     * Retrieve the skin control ID. Note that skin controls have special prefix
     * to distinguish them from regular controls, and from controls in other
     * skins.
     *
     * @since 1.0.0
     * @access protected
     *
     * @param string $control_base_id Control base ID.
     *
     * @return string Control ID.
     */
    protected function get_control_id($control_base_id)
    {
    }
    /**
     * Get skin settings.
     *
     * Retrieve all the skin settings or, when requested, a specific setting.
     *
     * @since 1.0.0
     * @TODO: rename to get_setting() and create backward compatibility.
     *
     * @access public
     *
     * @param string $control_base_id Control base ID.
     *
     * @return mixed
     */
    public function get_instance_value($control_base_id)
    {
    }
    /**
     * Start skin controls section.
     *
     * Used to add a new section of controls to the skin.
     *
     * @since 1.3.0
     * @access public
     *
     * @param string $id   Section ID.
     * @param array  $args Section arguments.
     */
    public function start_controls_section($id, $args = [])
    {
    }
    /**
     * Add new skin control.
     *
     * Register a single control to the allow the user to set/update skin data.
     *
     * @param string $id   Control ID.
     * @param array  $args Control arguments.
     * @param array  $options
     *
     * @return bool True if skin added, False otherwise.
     * @since 3.0.0 New `$options` parameter added.
     * @access public
     */
    public function add_control($id, $args = [], $options = [])
    {
    }
    /**
     * Update skin control.
     *
     * Change the value of an existing skin control.
     *
     * @since 1.3.0
     * @since 1.8.1 New `$options` parameter added.
     *
     * @access public
     *
     * @param string $id      Control ID.
     * @param array  $args    Control arguments. Only the new fields you want to update.
     * @param array  $options Optional. Some additional options.
     */
    public function update_control($id, $args, array $options = [])
    {
    }
    /**
     * Add new responsive skin control.
     *
     * Register a set of controls to allow editing based on user screen size.
     *
     * @param string $id   Responsive control ID.
     * @param array  $args Responsive control arguments.
     * @param array  $options
     *
     * @since  1.0.5
     * @access public
     */
    public function add_responsive_control($id, $args, $options = [])
    {
    }
    /**
     * Start skin controls tab.
     *
     * Used to add a new tab inside a group of tabs.
     *
     * @since 1.5.0
     * @access public
     *
     * @param string $id   Control ID.
     * @param array  $args Control arguments.
     */
    public function start_controls_tab($id, $args)
    {
    }
    /**
     * Start skin controls tabs.
     *
     * Used to add a new set of tabs inside a section.
     *
     * @since 1.5.0
     * @access public
     *
     * @param string $id Control ID.
     */
    public function start_controls_tabs($id)
    {
    }
    /**
     * Add new group control.
     *
     * Register a set of related controls grouped together as a single unified
     * control.
     *
     * @param string $group_name Group control name.
     * @param array  $args       Group control arguments. Default is an empty array.
     * @param array  $options
     *
     * @since  1.0.0
     * @access public
     */
    final public function add_group_control($group_name, $args = [], $options = [])
    {
    }
    /**
     * Set parent widget.
     *
     * Used to define the parent widget of the skin.
     *
     * @since 1.0.0
     * @access public
     *
     * @param Widget_Base $element_parent Parent widget.
     */
    public function set_parent($element_parent)
    {
    }
}
/**
 * Elementor widget base.
 *
 * An abstract class to register new Elementor widgets. It extended the
 * `Element_Base` class to inherit its properties.
 *
 * This abstract class must be extended in order to register new widgets.
 *
 * @since 1.0.0
 * @abstract
 */
abstract class Widget_Base extends \Elementor\Element_Base
{
    /**
     * Whether the widget has content.
     *
     * Used in cases where the widget has no content. When widgets uses only
     * skins to display dynamic content generated on the server. For example the
     * posts widget in Elementor Pro. Default is true, the widget has content
     * template.
     *
     * @access protected
     *
     * @var bool
     */
    protected $_has_template_content = true;
    /**
     * Registered Runtime Widgets.
     *
     * Registering in runtime all widgets that are being used on the page.
     *
     * @since 3.3.0
     * @access public
     * @static
     *
     * @var array
     */
    public static $registered_runtime_widgets = [];
    /**
     * Get element type.
     *
     * Retrieve the element type, in this case `widget`.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @return string The type.
     */
    public static function get_type()
    {
    }
    /**
     * Get widget icon.
     *
     * Retrieve the widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the widget keywords.
     *
     * @since 1.0.10
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
    }
    /**
     * Get widget categories.
     *
     * Retrieve the widget categories.
     *
     * @since 1.0.10
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
    }
    /**
     * Get widget upsale data.
     *
     * Retrieve the widget promotion data.
     *
     * @since 3.18.0
     * @access protected
     *
     * @return array|null Widget promotion data.
     */
    protected function get_upsale_data()
    {
    }
    /**
     * Widget base constructor.
     *
     * Initializing the widget base class.
     *
     * @since 1.0.0
     * @access public
     *
     * @throws \Exception If arguments are missing when initializing a full widget
     *                   instance.
     *
     * @param array      $data Widget data. Default is an empty array.
     * @param array|null $args Optional. Widget default arguments. Default is null.
     */
    public function __construct($data = [], $args = null)
    {
    }
    /**
     * Get stack.
     *
     * Retrieve the widget stack of controls.
     *
     * @since 1.9.2
     * @access public
     *
     * @param bool $with_common_controls Optional. Whether to include the common controls. Default is true.
     *
     * @return array Widget stack of controls.
     */
    public function get_stack($with_common_controls = true)
    {
    }
    /**
     * Get widget controls pointer index.
     *
     * Retrieve widget pointer index where the next control should be added.
     *
     * While using injection point, it will return the injection point index. Otherwise index of the last control of the
     * current widget itself without the common controls, plus one.
     *
     * @since 1.9.2
     * @access public
     *
     * @return int Widget controls pointer index.
     */
    public function get_pointer_index()
    {
    }
    /**
     * Show in panel.
     *
     * Whether to show the widget in the panel or not. By default returns true.
     *
     * @since 1.0.0
     * @access public
     *
     * @return bool Whether to show the widget in the panel or not.
     */
    public function show_in_panel()
    {
    }
    /**
     * Hide on search.
     *
     * Whether to hide the widget on search in the panel or not. By default returns false.
     *
     * @access public
     *
     * @return bool Whether to hide the widget when searching for widget or not.
     */
    public function hide_on_search()
    {
    }
    /**
     * Start widget controls section.
     *
     * Used to add a new section of controls to the widget. Regular controls and
     * skin controls.
     *
     * Note that when you add new controls to widgets they must be wrapped by
     * `start_controls_section()` and `end_controls_section()`.
     *
     * @since 1.0.0
     * @access public
     *
     * @param string $section_id Section ID.
     * @param array  $args       Section arguments Optional.
     */
    public function start_controls_section($section_id, array $args = [])
    {
    }
    /**
     * Register widget skins - deprecated prefixed method
     *
     * @since 1.7.12
     * @access protected
     * @deprecated 3.1.0 Use `register_skins()` method instead.
     */
    protected function _register_skins()
    {
    }
    /**
     * Register widget skins.
     *
     * This method is activated while initializing the widget base class. It is
     * used to assign skins to widgets with `add_skin()` method.
     *
     * Usage:
     *
     *    protected function register_skins() {
     *        $this->add_skin( new Skin_Classic( $this ) );
     *    }
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_skins()
    {
    }
    /**
     * Get initial config.
     *
     * Retrieve the current widget initial configuration.
     *
     * Adds more configuration on top of the controls list, the tabs assigned to
     * the control, element name, type, icon and more. This method also adds
     * widget type, keywords and categories.
     *
     * @since 2.9.0
     * @access protected
     *
     * @return array The initial widget config.
     */
    protected function get_initial_config()
    {
    }
    /**
     * @since 2.3.1
     * @access protected
     */
    protected function should_print_empty()
    {
    }
    /**
     * Print widget content template.
     *
     * Used to generate the widget content template on the editor, using a
     * Backbone JavaScript template.
     *
     * @since 2.0.0
     * @access protected
     *
     * @param string $template_content Template content.
     */
    protected function print_template_content($template_content)
    {
    }
    /**
     * Parse text editor.
     *
     * Parses the content from rich text editor with shortcodes, oEmbed and
     * filtered data.
     *
     * @since 1.0.0
     * @access protected
     *
     * @param string $content Text editor content.
     *
     * @return string Parsed content.
     */
    protected function parse_text_editor($content)
    {
    }
    /**
     * Safe print parsed text editor.
     *
     * @uses static::parse_text_editor.
     *
     * @access protected
     *
     * @param string $content Text editor content.
     */
    final protected function print_text_editor($content)
    {
    }
    /**
     * Get HTML wrapper class.
     *
     * Retrieve the widget container class. Can be used to override the
     * container class for specific widgets.
     *
     * @since 2.0.9
     * @access protected
     */
    protected function get_html_wrapper_class()
    {
    }
    /**
     * Add widget render attributes.
     *
     * Used to add attributes to the current widget wrapper HTML tag.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function add_render_attributes()
    {
    }
    /**
     * Add lightbox data to image link.
     *
     * Used to add lightbox data attributes to image link HTML.
     *
     * @since 2.9.1
     * @access public
     *
     * @param string $link_html Image link HTML.
     * @param string $id Attachment id.
     *
     * @return string Image link HTML with lightbox data attributes.
     */
    public function add_lightbox_data_to_image_link($link_html, $id)
    {
    }
    /**
     * Add Light-Box attributes.
     *
     * Used to add Light-Box-related data attributes to links that open media files.
     *
     * @param array|string $element         The link HTML element.
     * @param int          $id                       The ID of the image.
     * @param string       $lightbox_setting_key  The setting key that dictates whether to open the image in a lightbox.
     * @param string       $group_id              Unique ID for a group of lightbox images.
     * @param bool         $overwrite               Optional. Whether to overwrite existing
     *                                              attribute. Default is false, not to overwrite.
     *
     * @return Widget_Base Current instance of the widget.
     * @since 2.9.0
     * @access public
     */
    public function add_lightbox_data_attributes($element, $id = null, $lightbox_setting_key = null, $group_id = null, $overwrite = false)
    {
    }
    /**
     * Render widget output on the frontend.
     *
     * Used to generate the final HTML displayed on the frontend.
     *
     * Note that if skin is selected, it will be rendered by the skin itself,
     * not the widget.
     *
     * @since 1.0.0
     * @access public
     */
    public function render_content()
    {
    }
    protected function is_widget_first_render($widget_name)
    {
    }
    /**
     * Render widget plain content.
     *
     * Elementor saves the page content in a unique way, but it's not the way
     * WordPress saves data. This method is used to save generated HTML to the
     * database as plain content the WordPress way.
     *
     * When rendering plain content, it allows other WordPress plugins to
     * interact with the content - to search, check SEO and other purposes. It
     * also allows the site to keep working even if Elementor is deactivated.
     *
     * Note that if the widget uses shortcodes to display the data, the best
     * practice is to return the shortcode itself.
     *
     * Also note that if the widget don't display any content it should return
     * an empty string. For example Elementor Pro Form Widget uses this method
     * to return an empty string because there is no content to return. This way
     * if Elementor Pro will be deactivated there won't be any form to display.
     *
     * @since 1.0.0
     * @access public
     */
    public function render_plain_content()
    {
    }
    /**
     * Before widget rendering.
     *
     * Used to add stuff before the widget `_wrapper` element.
     *
     * @since 1.0.0
     * @access public
     */
    public function before_render()
    {
    }
    /**
     * After widget rendering.
     *
     * Used to add stuff after the widget `_wrapper` element.
     *
     * @since 1.0.0
     * @access public
     */
    public function after_render()
    {
    }
    /**
     * Get the element raw data.
     *
     * Retrieve the raw element data, including the id, type, settings, child
     * elements and whether it is an inner element.
     *
     * The data with the HTML used always to display the data, but the Elementor
     * editor uses the raw data without the HTML in order not to render the data
     * again.
     *
     * @since 1.0.0
     * @access public
     *
     * @param bool $with_html_content Optional. Whether to return the data with
     *                                HTML content or without. Used for caching.
     *                                Default is false, without HTML.
     *
     * @return array Element raw data.
     */
    public function get_raw_data($with_html_content = false)
    {
    }
    /**
     * Print widget content.
     *
     * Output the widget final HTML on the frontend.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function print_content()
    {
    }
    /**
     * Print a setting content without escaping.
     *
     * Script tags are allowed on frontend according to the WP theme securing policy.
     *
     * @param string $setting
     * @param null   $repeater_name
     * @param null   $index
     */
    final public function print_unescaped_setting($setting, $repeater_name = null, $index = null)
    {
    }
    /**
     * Get default data.
     *
     * Retrieve the default widget data. Used to reset the data on initialization.
     *
     * @since 1.0.0
     * @access protected
     *
     * @return array Default data.
     */
    protected function get_default_data()
    {
    }
    /**
     * Get default child type.
     *
     * Retrieve the widget child type based on element data.
     *
     * @since 1.0.0
     * @access protected
     *
     * @param array $element_data Widget ID.
     *
     * @return array|false Child type or false if it's not a valid widget.
     */
    protected function _get_default_child_type(array $element_data)
    {
    }
    /**
     * Get repeater setting key.
     *
     * Retrieve the unique setting key for the current repeater item. Used to connect the current element in the
     * repeater to it's settings model and it's control in the panel.
     *
     * PHP usage (inside `Widget_Base::render()` method):
     *
     *    $tabs = $this->get_settings( 'tabs' );
     *    foreach ( $tabs as $index => $item ) {
     *        $tab_title_setting_key = $this->get_repeater_setting_key( 'tab_title', 'tabs', $index );
     *        $this->add_inline_editing_attributes( $tab_title_setting_key, 'none' );
     *        echo '<div ' . $this->get_render_attribute_string( $tab_title_setting_key ) . '>' . $item['tab_title'] . '</div>';
     *    }
     *
     * @since 1.8.0
     * @access protected
     *
     * @param string $setting_key      The current setting key inside the repeater item (e.g. `tab_title`).
     * @param string $repeater_key     The repeater key containing the array of all the items in the repeater (e.g. `tabs`).
     * @param int    $repeater_item_index The current item index in the repeater array (e.g. `3`).
     *
     * @return string The repeater setting key (e.g. `tabs.3.tab_title`).
     */
    protected function get_repeater_setting_key($setting_key, $repeater_key, $repeater_item_index)
    {
    }
    /**
     * Add inline editing attributes.
     *
     * Define specific area in the element to be editable inline. The element can have several areas, with this method
     * you can set the area inside the element that can be edited inline. You can also define the type of toolbar the
     * user will see, whether it will be a basic toolbar or an advanced one.
     *
     * Note: When you use wysiwyg control use the advanced toolbar, with textarea control use the basic toolbar. Text
     * control should not have toolbar.
     *
     * PHP usage (inside `Widget_Base::render()` method):
     *
     *    $this->add_inline_editing_attributes( 'text', 'advanced' );
     *    echo '<div ' . $this->get_render_attribute_string( 'text' ) . '>' . $this->get_settings( 'text' ) . '</div>';
     *
     * @since 1.8.0
     * @access protected
     *
     * @param string $key     Element key.
     * @param string $toolbar Optional. Toolbar type. Accepted values are `advanced`, `basic` or `none`. Default is
     *                        `basic`.
     */
    protected function add_inline_editing_attributes($key, $toolbar = 'basic')
    {
    }
    /**
     * Add new skin.
     *
     * Register new widget skin to allow the user to set custom designs. Must be
     * called inside the `register_skins()` method.
     *
     * @since 1.0.0
     * @access public
     *
     * @param Skin_Base $skin Skin instance.
     */
    public function add_skin(\Elementor\Skin_Base $skin)
    {
    }
    /**
     * Get single skin.
     *
     * Retrieve a single skin based on skin ID, from all the skin assigned to
     * the widget. If the skin does not exist or not assigned to the widget,
     * return false.
     *
     * @since 1.0.0
     * @access public
     *
     * @param string $skin_id Skin ID.
     *
     * @return string|false Single skin, or false.
     */
    public function get_skin($skin_id)
    {
    }
    /**
     * Get current skin ID.
     *
     * Retrieve the ID of the current skin.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Current skin.
     */
    public function get_current_skin_id()
    {
    }
    /**
     * Get current skin.
     *
     * Retrieve the current skin, or if non exist return false.
     *
     * @since 1.0.0
     * @access public
     *
     * @return Skin_Base|false Current skin or false.
     */
    public function get_current_skin()
    {
    }
    /**
     * Remove widget skin.
     *
     * Unregister an existing skin and remove it from the widget.
     *
     * @since 1.0.0
     * @access public
     *
     * @param string $skin_id Skin ID.
     *
     * @return \WP_Error|true Whether the skin was removed successfully from the widget.
     */
    public function remove_skin($skin_id)
    {
    }
    /**
     * Get widget skins.
     *
     * Retrieve all the skin assigned to the widget.
     *
     * @since 1.0.0
     * @access public
     *
     * @return Skin_Base[]
     */
    public function get_skins()
    {
    }
    /**
     * Get group name.
     *
     * Some widgets need to use group names, this method allows you to create them.
     * By default it retrieves the regular name.
     *
     * @since 3.3.0
     * @access public
     *
     * @return string Unique name.
     */
    public function get_group_name()
    {
    }
    /**
     * @param string $plugin_title  Plugin's title.
     * @param string $since         Plugin version widget was deprecated.
     * @param string $last          Plugin version in which the widget will be removed.
     * @param string $replacement   Widget replacement.
     */
    protected function deprecated_notice($plugin_title, $since, $last = '', $replacement = '')
    {
    }
    /**
     * Init controls.
     *
     * Reset the `is_first_section` flag to true, so when the Stacks are cleared
     * all the controls will be registered again with their skins and settings.
     *
     * @since 3.14.0
     * @access protected
     */
    protected function init_controls()
    {
    }
    public function register_runtime_widget($widget_name)
    {
    }
    /**
     * Mark widget as deprecated.
     *
     * Use `get_deprecation_message()` method to print the message control at specific location in register_controls().
     *
     * @param string $version            The version of Elementor that deprecated the widget.
     * @param string $message          A message regarding the deprecation.
     * @param string $replacement    The widget that should be used instead.
     */
    protected function add_deprecation_message($version, $message, $replacement)
    {
    }
}
/**
 * Elementor base control.
 *
 * An abstract class for creating new controls in the panel.
 *
 * @since 1.0.0
 * @abstract
 */
abstract class Base_Control extends \Elementor\Core\Base\Base_Object
{
    /**
     * Get features.
     *
     * Retrieve the list of all the available features. Currently Elementor uses only
     * the `UI` feature.
     *
     * @since 1.5.0
     * @access public
     * @static
     *
     * @return array Features array.
     */
    public static function get_features()
    {
    }
    /**
     * Get control type.
     *
     * Retrieve the control type.
     *
     * @since 1.5.0
     * @access public
     * @abstract
     */
    abstract public function get_type();
    /**
     * Control base constructor.
     *
     * Initializing the control base class.
     *
     * @since 1.5.0
     * @access public
     */
    public function __construct()
    {
    }
    /**
     * Enqueue control scripts and styles.
     *
     * Used to register and enqueue custom scripts and styles used by the control.
     *
     * @since 1.5.0
     * @access public
     */
    public function enqueue()
    {
    }
    /**
     * Control content template.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * Note that the content template is wrapped by Base_Control::print_template().
     *
     * @since 1.5.0
     * @access public
     * @abstract
     */
    abstract public function content_template();
    /**
     * Print control template.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.5.0
     * @access public
     */
    final public function print_template()
    {
    }
    /**
     * Get default control settings.
     *
     * Retrieve the default settings of the control. Used to return the default
     * settings while initializing the control.
     *
     * @since 1.5.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
    public static function get_assets($setting)
    {
    }
    /**
     * Update value of control that needs to be updated after import.
     *
     * @param mixed $value
     * @param array $control_args
     * @param array $config
     *
     * @return mixed
     */
    public function on_import_update_settings($value, array $control_args, array $config)
    {
    }
}
/**
 * Elementor base UI control.
 *
 * An abstract class for creating new UI controls in the panel.
 *
 * @abstract
 */
abstract class Base_UI_Control extends \Elementor\Base_Control
{
    /**
     * Get features.
     *
     * Retrieve the list of all the available features.
     *
     * @since 1.5.0
     * @access public
     * @static
     *
     * @return array Features array.
     */
    public static function get_features()
    {
    }
}
/**
 * Elementor alert control.
 *
 * A base control for creating alerts in the Editor panels.
 *
 * @since 3.19.0
 */
class Control_Alert extends \Elementor\Base_UI_Control
{
    /**
     * Get alert control type.
     *
     * Retrieve the control type, in this case `alert`.
     *
     * @since 3.19.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Render alert control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 3.19.0
     * @access public
     */
    public function content_template()
    {
    }
    /**
     * Get alert control default settings.
     *
     * Retrieve the default settings of the alert control. Used to return the
     * default settings while initializing the alert control.
     *
     * @since 3.19.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
}
/**
 * Elementor base data control.
 *
 * An abstract class for creating new data controls in the panel.
 *
 * @since 1.5.0
 * @abstract
 */
abstract class Base_Data_Control extends \Elementor\Base_Control
{
    public function __construct()
    {
    }
    /**
     * Get data control default value.
     *
     * Retrieve the default value of the data control. Used to return the default
     * values while initializing the data control.
     *
     * @since 1.5.0
     * @access public
     *
     * @return string Control default value.
     */
    public function get_default_value()
    {
    }
    /**
     * Get data control value.
     *
     * Retrieve the value of the data control from a specific Controls_Stack settings.
     *
     * @since 1.5.0
     * @access public
     *
     * @param array $control  Control.
     * @param array $settings Element settings.
     *
     * @return mixed Control values.
     */
    public function get_value($control, $settings)
    {
    }
    /**
     * Parse dynamic tags.
     *
     * Iterates through all the controls and renders all the dynamic tags.
     *
     * @since 2.0.0
     * @access public
     *
     * @param string $dynamic_value    The dynamic tag text.
     * @param array  $dynamic_settings The dynamic tag settings.
     *
     * @return string|string[]|mixed A string or an array of strings with the
     *                               return value from each tag callback function.
     */
    public function parse_tags($dynamic_value, $dynamic_settings)
    {
    }
    /**
     * Get data control style value.
     *
     * Retrieve the style of the control. Used when adding CSS rules to the control
     * while extracting CSS from the `selectors` data argument.
     *
     * @since 1.5.0
     * @since 2.3.3 New `$control_data` parameter added.
     * @access public
     *
     * @param string $css_property  CSS property.
     * @param string $control_value Control value.
     * @param array  $control_data Control Data.
     *
     * @return string Control style value.
     */
    public function get_style_value($css_property, $control_value, array $control_data)
    {
    }
    /**
     * Get data control unique ID.
     *
     * Retrieve the unique ID of the control. Used to set a uniq CSS ID for the
     * element.
     *
     * @since 1.5.0
     * @access protected
     *
     * @param string $input_type Input type. Default is 'default'.
     *
     * @return string Unique ID.
     */
    protected function get_control_uid($input_type = 'default')
    {
    }
    /**
     * Safe Print data control unique ID.
     *
     * Retrieve the unique ID of the control. Used to set a unique CSS ID for the
     * element.
     *
     * @access protected
     *
     * @param string $input_type Input type. Default is 'default'.
     */
    protected function print_control_uid($input_type = 'default')
    {
    }
}
/**
 * Elementor animation control.
 *
 * A base control for creating entrance animation control. Displays a select box
 * with the available entrance animation effects @see Control_Animation::get_animations() .
 *
 * @since 1.0.0
 */
class Control_Animation extends \Elementor\Base_Data_Control
{
    /**
     * Get control type.
     *
     * Retrieve the animation control type.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Retrieve default control settings.
     *
     * Get the default settings of the control. Used to return the default
     * settings while initializing the control.
     *
     * @since 2.5.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
    /**
     * Get animations list.
     *
     * Retrieve the list of all the available animations.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @return array Control type.
     */
    public static function get_animations()
    {
    }
    public static function get_default_animations()
    {
    }
    /**
     * Render animations control template.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template()
    {
    }
    public static function get_assets($setting)
    {
    }
}
abstract class Base_Icon_Font
{
    /**
     * Get Icon type.
     *
     * Retrieve the icon type.
     *
     * @access public
     * @abstract
     */
    abstract public function get_type();
    /**
     * Enqueue Icon scripts and styles.
     *
     * Used to register and enqueue custom scripts and styles used by the Icon.
     *
     * @access public
     */
    abstract public function enqueue();
    abstract public function get_css_prefix();
    abstract public function get_icons();
    public function __construct()
    {
    }
}
/**
 * Elementor control base multiple.
 *
 * An abstract class for creating new controls in the panel that return
 * more than a single value. Each value of the multi-value control will
 * be returned as an item in a `key => value` array.
 *
 * @since 1.0.0
 * @abstract
 */
abstract class Control_Base_Multiple extends \Elementor\Base_Data_Control
{
    /**
     * Get multiple control default value.
     *
     * Retrieve the default value of the multiple control. Used to return the default
     * values while initializing the multiple control.
     *
     * @since 1.0.0
     * @access public
     *
     * @return array Control default value.
     */
    public function get_default_value()
    {
    }
    /**
     * Get multiple control value.
     *
     * Retrieve the value of the multiple control from a specific Controls_Stack settings.
     *
     * @since 1.0.0
     * @access public
     *
     * @param array $control  Control.
     * @param array $settings Settings.
     *
     * @return mixed Control values.
     */
    public function get_value($control, $settings)
    {
    }
    /**
     * Get multiple control style value.
     *
     * Retrieve the style of the control. Used when adding CSS rules to the control
     * while extracting CSS from the `selectors` data argument.
     *
     * @since 1.0.5
     * @since 2.3.3 New `$control_data` parameter added.
     * @access public
     *
     * @param string $css_property  CSS property.
     * @param array  $control_value Control value.
     * @param array  $control_data Control Data.
     *
     * @return array Control style value.
     */
    public function get_style_value($css_property, $control_value, array $control_data)
    {
    }
}
/**
 * Elementor control base units.
 *
 * An abstract class for creating new unit controls in the panel.
 *
 * @since 1.0.0
 * @abstract
 */
abstract class Control_Base_Units extends \Elementor\Control_Base_Multiple
{
    /**
     * Get units control default value.
     *
     * Retrieve the default value of the units control. Used to return the default
     * values while initializing the units control.
     *
     * @since 1.0.0
     * @access public
     *
     * @return array Control default value.
     */
    public function get_default_value()
    {
    }
    /**
     * Get units control default settings.
     *
     * Retrieve the default settings of the units control. Used to return the default
     * settings while initializing the units control.
     *
     * @since 1.0.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
    /**
     * Print units control settings.
     *
     * Used to generate the units control template in the editor.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function print_units_template()
    {
    }
    public function get_style_value($css_property, $control_value, array $control_data)
    {
    }
}
/**
 * Elementor box shadow control.
 *
 * A base control for creating box shadows control. Displays input fields for
 * horizontal shadow, vertical shadow, shadow blur, shadow spread and shadow
 * color.
 *
 * @since 1.0.0
 */
class Control_Box_Shadow extends \Elementor\Control_Base_Multiple
{
    /**
     * Get box shadow control type.
     *
     * Retrieve the control type, in this case `box_shadow`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Get box shadow control default value.
     *
     * Retrieve the default value of the box shadow control. Used to return the
     * default values while initializing the box shadow control.
     *
     * @since 1.0.0
     * @access public
     *
     * @return array Control default value.
     */
    public function get_default_value()
    {
    }
    /**
     * Get box shadow control sliders.
     *
     * Retrieve the sliders of the box shadow control. Sliders are used while
     * rendering the control output in the editor.
     *
     * @since 1.0.0
     * @access public
     *
     * @return array Control sliders.
     */
    public function get_sliders()
    {
    }
    /**
     * Render box shadow control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template()
    {
    }
}
/**
 * Elementor button control.
 *
 * A base control for creating a button control. Displays a button that can
 * trigger an event.
 *
 * @since 1.9.0
 */
class Control_Button extends \Elementor\Base_UI_Control
{
    /**
     * Get button control type.
     *
     * Retrieve the control type, in this case `button`.
     *
     * @since 1.9.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Get button control default settings.
     *
     * Retrieve the default settings of the button control. Used to
     * return the default settings while initializing the button
     * control.
     *
     * @since 1.9.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
    /**
     * Render button control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.9.0
     * @access public
     */
    public function content_template()
    {
    }
}
/**
 * Elementor choose control.
 *
 * A base control for creating choose control. Displays radio buttons styled as
 * groups of buttons with icons for each option.
 *
 * @since 1.0.0
 */
class Control_Choose extends \Elementor\Base_Data_Control
{
    /**
     * Get choose control type.
     *
     * Retrieve the control type, in this case `choose`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Render choose control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template()
    {
    }
    /**
     * Get choose control default settings.
     *
     * Retrieve the default settings of the choose control. Used to return the
     * default settings while initializing the choose control.
     *
     * @since 1.0.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
}
/**
 * Elementor code control.
 *
 * A base control for creating code control. Displays a code editor textarea.
 * Based on Ace editor (@see https://ace.c9.io/).
 *
 * @since 1.0.0
 */
class Control_Code extends \Elementor\Base_Data_Control
{
    /**
     * Get code control type.
     *
     * Retrieve the control type, in this case `code`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Get code control default settings.
     *
     * Retrieve the default settings of the code control. Used to return the default
     * settings while initializing the code control.
     *
     * @since 1.0.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
    /**
     * Render code control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template()
    {
    }
}
/**
 * Elementor color control.
 *
 * A base control for creating color control. Displays a color picker field with
 * an alpha slider. Includes a customizable color palette that can be preset by
 * the user. Accepts a `scheme` argument that allows you to set a value from the
 * active color scheme as the default value returned by the control.
 *
 * @since 1.0.0
 */
class Control_Color extends \Elementor\Base_Data_Control
{
    /**
     * Get color control type.
     *
     * Retrieve the control type, in this case `color`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Render color control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template()
    {
    }
    /**
     * Get color control default settings.
     *
     * Retrieve the default settings of the color control. Used to return the default
     * settings while initializing the color control.
     *
     * @since 1.0.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
}
/**
 * Elementor date/time control.
 *
 * A base control for creating date time control. Displays a date/time picker
 * based on the Flatpickr library @see https://chmln.github.io/flatpickr/ .
 *
 * @since 1.0.0
 */
class Control_Date_Time extends \Elementor\Base_Data_Control
{
    /**
     * Get date time control type.
     *
     * Retrieve the control type, in this case `date_time`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Get date time control default settings.
     *
     * Retrieve the default settings of the date time control. Used to return the
     * default settings while initializing the date time control.
     *
     * @since 1.8.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
    /**
     * Render date time control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template()
    {
    }
}
/**
 * Elementor Deprecated Notice control.
 *
 * A base control specific for creating Deprecation Notices control.
 * Displays a warning notice in the panel.
 *
 * @since 2.6.0
 */
class Control_Deprecated_Notice extends \Elementor\Base_UI_Control
{
    /**
     * Get deprecated-notice control type.
     *
     * Retrieve the control type, in this case `deprecated_notice`.
     *
     * @since 2.6.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Render deprecated notice control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 2.6.0
     * @access public
     */
    public function content_template()
    {
    }
    /**
     * Get deprecated-notice control default settings.
     *
     * Retrieve the default settings of the deprecated notice control. Used to return the
     * default settings while initializing the deprecated notice control.
     *
     * @since 2.6.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
}
/**
 * Elementor dimension control.
 *
 * A base control for creating dimension control. Displays input fields for top,
 * right, bottom, left and the option to link them together.
 *
 * @since 1.0.0
 */
class Control_Dimensions extends \Elementor\Control_Base_Units
{
    /**
     * Get dimensions control type.
     *
     * Retrieve the control type, in this case `dimensions`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Get dimensions control default values.
     *
     * Retrieve the default value of the dimensions control. Used to return the
     * default values while initializing the dimensions control.
     *
     * @since 1.0.0
     * @access public
     *
     * @return array Control default value.
     */
    public function get_default_value()
    {
    }
    public function get_singular_name()
    {
    }
    /**
     * Get dimensions control default settings.
     *
     * Retrieve the default settings of the dimensions control. Used to return the
     * default settings while initializing the dimensions control.
     *
     * @since 1.0.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
    protected function get_dimensions()
    {
    }
    /**
     * Render dimensions control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template()
    {
    }
}
/**
 * Elementor divider control.
 *
 * A base control for creating divider control. Displays horizontal line in
 * the panel.
 *
 * @since 2.0.0
 */
class Control_Divider extends \Elementor\Base_UI_Control
{
    /**
     * Get divider control type.
     *
     * Retrieve the control type, in this case `divider`.
     *
     * @since 2.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Render divider control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 2.0.0
     * @access public
     */
    public function content_template()
    {
    }
}
/**
 * Elementor exit animation control.
 *
 * A control for creating exit animation. Displays a select box
 * with the available exit animation effects @see Control_Exit_Animation::get_animations() .
 *
 * @since 2.5.0
 */
class Control_Exit_Animation extends \Elementor\Control_Animation
{
    /**
     * Get control type.
     *
     * Retrieve the animation control type.
     *
     * @since 2.5.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Get animations list.
     *
     * Retrieve the list of all the available animations.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @return array Control type.
     */
    public static function get_animations()
    {
    }
    public static function get_default_animations(): array
    {
    }
    public static function get_assets($setting)
    {
    }
}
/**
 * Elementor font control.
 *
 * A base control for creating font control. Displays font select box. The
 * control allows you to set a list of fonts.
 *
 * @since 1.0.0
 */
class Control_Font extends \Elementor\Base_Data_Control
{
    /**
     * Get font control type.
     *
     * Retrieve the control type, in this case `font`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Get font control default settings.
     *
     * Retrieve the default settings of the font control. Used to return the default
     * settings while initializing the font control.
     *
     * @since 1.0.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
    /**
     * Render font control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template()
    {
    }
}
/**
 * Elementor gallery control.
 *
 * A base control for creating gallery chooser control. Based on the WordPress
 * media library galleries. Used to select images from the WordPress media library.
 *
 * @since 1.0.0
 */
class Control_Gallery extends \Elementor\Base_Data_Control
{
    /**
     * Get gallery control type.
     *
     * Retrieve the control type, in this case `gallery`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    public function on_export($settings)
    {
    }
    /**
     * Import gallery images.
     *
     * Used to import gallery control files from external sites while importing
     * Elementor template JSON file, and replacing the old data.
     *
     * @since 1.0.0
     * @access public
     *
     * @param array $settings Control settings.
     *
     * @return array Control settings.
     */
    public function on_import($settings)
    {
    }
    /**
     * Render gallery control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template()
    {
    }
    /**
     * Get gallery control default settings.
     *
     * Retrieve the default settings of the gallery control. Used to return the
     * default settings while initializing the gallery control.
     *
     * @since 1.0.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
    /**
     * Get gallery control default values.
     *
     * Retrieve the default value of the gallery control. Used to return the default
     * values while initializing the gallery control.
     *
     * @since 1.0.0
     * @access public
     *
     * @return array Control default value.
     */
    public function get_default_value()
    {
    }
}
/**
 * Elementor gap control.
 *
 * A base control for creating a gap control. Displays input fields for two values,
 * row/column, height/width and the option to link them together.
 *
 * @since 3.13.0
 */
class Control_Gaps extends \Elementor\Control_Dimensions
{
    /**
     * Get gap control type.
     *
     * Retrieve the control type, in this case `gap`.
     *
     * @since 3.13.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Get gap control default values.
     *
     * Retrieve the default value of the gap control. Used to return the default
     * values while initializing the gap control.
     *
     * @since 3.13.0
     * @access public
     *
     * @return array Control default value.
     */
    public function get_default_value()
    {
    }
    public function get_singular_name()
    {
    }
    protected function get_dimensions()
    {
    }
    public function get_value($control, $settings)
    {
    }
}
/**
 * Elementor group control base.
 *
 * An abstract class for creating new group controls in the panel.
 *
 * @since 1.0.0
 * @abstract
 */
abstract class Group_Control_Base implements \Elementor\Group_Control_Interface
{
    /**
     * Get options.
     *
     * Retrieve group control options. If options are not set, it will initialize default options.
     *
     * @since 1.9.0
     * @access public
     *
     * @param array $option Optional. Single option.
     *
     * @return mixed Group control options. If option parameter was not specified, it will
     *               return an array of all the options. If single option specified, it will
     *               return the option value or `null` if option does not exists.
     */
    final public function get_options($option = null)
    {
    }
    /**
     * Add new controls to stack.
     *
     * Register multiple controls to allow the user to set/update data.
     *
     * @since 1.0.0
     * @access public
     *
     * @param Controls_Stack $element   The element stack.
     * @param array          $user_args The control arguments defined by the user.
     * @param array          $options   Optional. The element options. Default is
     *                                  an empty array.
     */
    final public function add_controls(\Elementor\Controls_Stack $element, array $user_args, array $options = [])
    {
    }
    /**
     * Get arguments.
     *
     * Retrieve group control arguments.
     *
     * @since 1.0.0
     * @access public
     *
     * @return array Group control arguments.
     */
    final public function get_args()
    {
    }
    /**
     * Get fields.
     *
     * Retrieve group control fields.
     *
     * @since 1.2.2
     * @access public
     *
     * @return array Control fields.
     */
    final public function get_fields()
    {
    }
    /**
     * Get controls prefix.
     *
     * Retrieve the prefix of the group control, which is `{{ControlName}}_`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control prefix.
     */
    public function get_controls_prefix()
    {
    }
    /**
     * Get group control classes.
     *
     * Retrieve the classes of the group control.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Group control classes.
     */
    public function get_base_group_classes()
    {
    }
    /**
     * Init fields.
     *
     * Initialize group control fields.
     *
     * @abstract
     * @since 1.2.2
     * @access protected
     */
    abstract protected function init_fields();
    /**
     * Get default options.
     *
     * Retrieve the default options of the group control. Used to return the
     * default options while initializing the group control.
     *
     * @since 1.9.0
     * @access protected
     *
     * @return array Default group control options.
     */
    protected function get_default_options()
    {
    }
    /**
     * Get child default arguments.
     *
     * Retrieve the default arguments for all the child controls for a specific group
     * control.
     *
     * @since 1.2.2
     * @access protected
     *
     * @return array Default arguments for all the child controls.
     */
    protected function get_child_default_args()
    {
    }
    /**
     * Filter fields.
     *
     * Filter which controls to display, using `include`, `exclude` and the
     * `condition` arguments.
     *
     * @since 1.2.2
     * @access protected
     *
     * @return array Control fields.
     */
    protected function filter_fields()
    {
    }
    /**
     * Add group arguments to field.
     *
     * Register field arguments to group control.
     *
     * @since 1.2.2
     * @access protected
     *
     * @param string $control_id Group control id.
     * @param array  $field_args Group control field arguments.
     *
     * @return array
     */
    protected function add_group_args_to_field($control_id, $field_args)
    {
    }
    /**
     * Prepare fields.
     *
     * Process group control fields before adding them to `add_control()`.
     *
     * @since 1.2.2
     * @access protected
     *
     * @param array $fields Group control fields.
     *
     * @return array Processed fields.
     */
    protected function prepare_fields($fields)
    {
    }
    /**
     * Init arguments.
     *
     * Initializing group control base class.
     *
     * @since 1.2.2
     * @access protected
     *
     * @param array $args Group control settings value.
     */
    protected function init_args($args)
    {
    }
}
/**
 * Elementor background control.
 *
 * A base control for creating background control. Displays input fields to define
 * the background color, background image, background gradient or background video.
 *
 * @since 1.2.2
 */
class Group_Control_Background extends \Elementor\Group_Control_Base
{
    /**
     * Fields.
     *
     * Holds all the background control fields.
     *
     * @since 1.2.2
     * @access protected
     * @static
     *
     * @var array Background control fields.
     */
    protected static $fields;
    /**
     * Get background control type.
     *
     * Retrieve the control type, in this case `background`.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @return string Control type.
     */
    public static function get_type()
    {
    }
    /**
     * Get background control types.
     *
     * Retrieve available background types.
     *
     * @since 1.2.2
     * @access public
     * @static
     *
     * @return array Available background types.
     */
    public static function get_background_types()
    {
    }
    /**
     * Init fields.
     *
     * Initialize background control fields.
     *
     * @since 1.2.2
     * @access public
     *
     * @return array Control fields.
     */
    public function init_fields()
    {
    }
    /**
     * Get child default args.
     *
     * Retrieve the default arguments for all the child controls for a specific group
     * control.
     *
     * @since 1.2.2
     * @access protected
     *
     * @return array Default arguments for all the child controls.
     */
    protected function get_child_default_args()
    {
    }
    /**
     * Filter fields.
     *
     * Filter which controls to display, using `include`, `exclude`, `condition`
     * and `of_type` arguments.
     *
     * @since 1.2.2
     * @access protected
     *
     * @return array Control fields.
     */
    protected function filter_fields()
    {
    }
    /**
     * Prepare fields.
     *
     * Process background control fields before adding them to `add_control()`.
     *
     * @since 1.2.2
     * @access protected
     *
     * @param array $fields Background control fields.
     *
     * @return array Processed fields.
     */
    protected function prepare_fields($fields)
    {
    }
    /**
     * Get default options.
     *
     * Retrieve the default options of the background control. Used to return the
     * default options while initializing the background control.
     *
     * @since 1.9.0
     * @access protected
     *
     * @return array Default background control options.
     */
    protected function get_default_options()
    {
    }
}
/**
 * Elementor border control.
 *
 * A base control for creating border control. Displays input fields to define
 * border type, border width and border color.
 *
 * @since 1.0.0
 */
class Group_Control_Border extends \Elementor\Group_Control_Base
{
    /**
     * Fields.
     *
     * Holds all the border control fields.
     *
     * @since 1.0.0
     * @access protected
     * @static
     *
     * @var array Border control fields.
     */
    protected static $fields;
    /**
     * Get border control type.
     *
     * Retrieve the control type, in this case `border`.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @return string Control type.
     */
    public static function get_type()
    {
    }
    /**
     * Init fields.
     *
     * Initialize border control fields.
     *
     * @since 1.2.2
     * @access protected
     *
     * @return array Control fields.
     */
    protected function init_fields()
    {
    }
    /**
     * Get default options.
     *
     * Retrieve the default options of the border control. Used to return the
     * default options while initializing the border control.
     *
     * @since 1.9.0
     * @access protected
     *
     * @return array Default border control options.
     */
    protected function get_default_options()
    {
    }
}
/**
 * Elementor box shadow control.
 *
 * A base control for creating box shadow control. Displays input fields to define
 * the box shadow including the horizontal shadow, vertical shadow, shadow blur,
 * shadow spread, shadow color and the position.
 *
 * @since 1.2.2
 */
class Group_Control_Box_Shadow extends \Elementor\Group_Control_Base
{
    /**
     * Fields.
     *
     * Holds all the box shadow control fields.
     *
     * @since 1.2.2
     * @access protected
     * @static
     *
     * @var array Box shadow control fields.
     */
    protected static $fields;
    /**
     * Get box shadow control type.
     *
     * Retrieve the control type, in this case `box-shadow`.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @return string Control type.
     */
    public static function get_type()
    {
    }
    /**
     * Init fields.
     *
     * Initialize box shadow control fields.
     *
     * @since 1.2.2
     * @access protected
     *
     * @return array Control fields.
     */
    protected function init_fields()
    {
    }
    /**
     * Get default options.
     *
     * Retrieve the default options of the box shadow control. Used to return the
     * default options while initializing the box shadow control.
     *
     * @since 1.9.0
     * @access protected
     *
     * @return array Default box shadow control options.
     */
    protected function get_default_options()
    {
    }
}
/**
 * Elementor CSS Filter control.
 *
 * A base control for applying css filters. Displays sliders to define the
 * values of different CSS filters including blur, brightens, contrast,
 * saturation and hue.
 *
 * @since 2.1.0
 */
class Group_Control_Css_Filter extends \Elementor\Group_Control_Base
{
    /**
     * Prepare fields.
     *
     * Process css_filter control fields before adding them to `add_control()`.
     *
     * @since 2.1.0
     * @access protected
     *
     * @var array $fields CSS filter control fields.
     *
     * @return array Processed fields.
     */
    protected static $fields;
    /**
     * Get CSS filter control type.
     *
     * Retrieve the control type, in this case `css-filter`.
     *
     * @since 2.1.0
     * @access public
     * @static
     *
     * @return string Control type.
     */
    public static function get_type()
    {
    }
    /**
     * Init fields.
     *
     * Initialize CSS filter control fields.
     *
     * @since 2.1.0
     * @access protected
     *
     * @return array Control fields.
     */
    protected function init_fields()
    {
    }
    /**
     * Get default options.
     *
     * Retrieve the default options of the CSS filter control. Used to return the
     * default options while initializing the CSS filter control.
     *
     * @since 2.1.0
     * @access protected
     *
     * @return array Default CSS filter control options.
     */
    protected function get_default_options()
    {
    }
}
class Group_Control_Flex_Container extends \Elementor\Group_Control_Base
{
    protected static $fields;
    public static function get_type()
    {
    }
    protected function init_fields()
    {
    }
    protected function get_default_options()
    {
    }
}
class Group_Control_Flex_Item extends \Elementor\Group_Control_Base
{
    protected static $fields;
    public static function get_type()
    {
    }
    protected function init_fields()
    {
    }
    protected function get_default_options()
    {
    }
}
class Group_Control_Grid_Container extends \Elementor\Group_Control_Base
{
    protected static $fields;
    public static function get_type()
    {
    }
    protected function init_fields()
    {
    }
    protected function get_responsive_unit_defaults()
    {
    }
    protected function get_responsive_autoflow_defaults()
    {
    }
    protected function get_default_options()
    {
    }
}
/**
 * Elementor image size control.
 *
 * A base control for creating image size control. Displays input fields to define
 * one of the default image sizes (thumbnail, medium, medium_large, large) or custom
 * image dimensions.
 *
 * @since 1.0.0
 */
class Group_Control_Image_Size extends \Elementor\Group_Control_Base
{
    /**
     * Fields.
     *
     * Holds all the image size control fields.
     *
     * @since 1.2.2
     * @access protected
     * @static
     *
     * @var array Image size control fields.
     */
    protected static $fields;
    /**
     * Get image size control type.
     *
     * Retrieve the control type, in this case `image-size`.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @return string Control type.
     */
    public static function get_type()
    {
    }
    /**
     * Get attachment image HTML.
     *
     * Retrieve the attachment image HTML code.
     *
     * Note that some widgets use the same key for the media control that allows
     * the image selection and for the image size control that allows the user
     * to select the image size, in this case the third parameter should be null
     * or the same as the second parameter. But when the widget uses different
     * keys for the media control and the image size control, when calling this
     * method you should pass the keys.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @param array  $settings       Control settings.
     * @param string $image_size_key Optional. Settings key for image size.
     *                               Default is `image`.
     * @param string $image_key      Optional. Settings key for image. Default
     *                               is null. If not defined uses image size key
     *                               as the image key.
     *
     * @return string Image HTML.
     */
    public static function get_attachment_image_html($settings, $image_size_key = 'image', $image_key = null)
    {
    }
    /**
     * Safe print attachment image HTML.
     *
     * @uses get_attachment_image_html.
     *
     * @access public
     * @static
     *
     * @param array  $settings       Control settings.
     * @param string $image_size_key Optional. Settings key for image size.
     *                               Default is `image`.
     * @param string $image_key      Optional. Settings key for image. Default
     *                               is null. If not defined uses image size key
     *                               as the image key.
     */
    public static function print_attachment_image_html(array $settings, $image_size_key = 'image', $image_key = null)
    {
    }
    /**
     * Get all image sizes.
     *
     * Retrieve available image sizes with data like `width`, `height` and `crop`.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @return array An array of available image sizes.
     */
    public static function get_all_image_sizes()
    {
    }
    /**
     * Get attachment image src.
     *
     * Retrieve the attachment image source URL.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @param string $attachment_id  The attachment ID.
     * @param string $image_size_key Settings key for image size.
     * @param array  $settings       Control settings.
     *
     * @return string Attachment image source URL.
     */
    public static function get_attachment_image_src($attachment_id, $image_size_key, array $settings)
    {
    }
    /**
     * Get child default arguments.
     *
     * Retrieve the default arguments for all the child controls for a specific group
     * control.
     *
     * @since 1.2.2
     * @access protected
     *
     * @return array Default arguments for all the child controls.
     */
    protected function get_child_default_args()
    {
    }
    /**
     * Init fields.
     *
     * Initialize image size control fields.
     *
     * @since 1.2.2
     * @access protected
     *
     * @return array Control fields.
     */
    protected function init_fields()
    {
    }
    /**
     * Prepare fields.
     *
     * Process image size control fields before adding them to `add_control()`.
     *
     * @since 1.2.2
     * @access protected
     *
     * @param array $fields Image size control fields.
     *
     * @return array Processed fields.
     */
    protected function prepare_fields($fields)
    {
    }
    /**
     * Get default options.
     *
     * Retrieve the default options of the image size control. Used to return the
     * default options while initializing the image size control.
     *
     * @since 1.9.0
     * @access protected
     *
     * @return array Default image size control options.
     */
    protected function get_default_options()
    {
    }
}
/**
 * Elementor text shadow control.
 *
 * A base control for creating text shadow control. Displays input fields to define
 * the text shadow including the horizontal shadow, vertical shadow, shadow blur and
 * shadow color.
 *
 * @since 1.6.0
 */
class Group_Control_Text_Shadow extends \Elementor\Group_Control_Base
{
    /**
     * Fields.
     *
     * Holds all the text shadow control fields.
     *
     * @since 1.6.0
     * @access protected
     * @static
     *
     * @var array Text shadow control fields.
     */
    protected static $fields;
    /**
     * Get text shadow control type.
     *
     * Retrieve the control type, in this case `text-shadow`.
     *
     * @since 1.6.0
     * @access public
     * @static
     *
     * @return string Control type.
     */
    public static function get_type()
    {
    }
    /**
     * Init fields.
     *
     * Initialize text shadow control fields.
     *
     * @since 1.6.0
     * @access protected
     *
     * @return array Control fields.
     */
    protected function init_fields()
    {
    }
    /**
     * Get default options.
     *
     * Retrieve the default options of the text shadow control. Used to return the
     * default options while initializing the text shadow control.
     *
     * @since 1.9.0
     * @access protected
     *
     * @return array Default text shadow control options.
     */
    protected function get_default_options()
    {
    }
}
/**
 * Elementor text stroke control.
 *
 * A group control for creating a stroke effect on text. Displays input fields to define
 * the text stroke and color stroke.
 *
 * @since 3.5.0
 */
class Group_Control_Text_Stroke extends \Elementor\Group_Control_Base
{
    /**
     * Fields.
     *
     * Holds all the text stroke control fields.
     *
     * @since 3.5.0
     * @access protected
     * @static
     *
     * @var array Text Stroke control fields.
     */
    protected static $fields;
    /**
     * Get text stroke control type.
     *
     * Retrieve the control type, in this case `text-stroke`.
     *
     * @since 3.5.0
     * @access public
     * @static
     *
     * @return string Control type.
     */
    public static function get_type()
    {
    }
    /**
     * Init fields.
     *
     * Initialize text stroke control fields.
     *
     * @since 3.5.0
     * @access protected
     *
     * @return array Control fields.
     */
    protected function init_fields()
    {
    }
    /**
     * Get default options.
     *
     * Retrieve the default options of the text stroke control. Used to return the
     * default options while initializing the text stroke control.
     *
     * @since 3.5.0
     * @access protected
     *
     * @return array Default text stroke control options.
     */
    protected function get_default_options()
    {
    }
}
/**
 * Elementor typography control.
 *
 * A base control for creating typography control. Displays input fields to define
 * the content typography including font size, font family, font weight, text
 * transform, font style, line height and letter spacing.
 *
 * @since 1.0.0
 */
class Group_Control_Typography extends \Elementor\Group_Control_Base
{
    /**
     * Fields.
     *
     * Holds all the typography control fields.
     *
     * @since 1.0.0
     * @access protected
     * @static
     *
     * @var array Typography control fields.
     */
    protected static $fields;
    /**
     * Get scheme fields keys.
     *
     * Retrieve all the available typography control scheme fields keys.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @return array Scheme fields keys.
     */
    public static function get_scheme_fields_keys()
    {
    }
    /**
     * Get typography control type.
     *
     * Retrieve the control type, in this case `typography`.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @return string Control type.
     */
    public static function get_type()
    {
    }
    /**
     * Init fields.
     *
     * Initialize typography control fields.
     *
     * @since 1.2.2
     * @access protected
     *
     * @return array Control fields.
     */
    protected function init_fields()
    {
    }
    public static function get_font_variable_ranges()
    {
    }
    /**
     * Prepare fields.
     *
     * Process typography control fields before adding them to `add_control()`.
     *
     * @since 1.2.3
     * @access protected
     *
     * @param array $fields Typography control fields.
     *
     * @return array Processed fields.
     */
    protected function prepare_fields($fields)
    {
    }
    /**
     * Add group arguments to field.
     *
     * Register field arguments to typography control.
     *
     * @since 1.2.2
     * @access protected
     *
     * @param string $control_id Typography control id.
     * @param array  $field_args Typography control field arguments.
     *
     * @return array Field arguments.
     */
    protected function add_group_args_to_field($control_id, $field_args)
    {
    }
    /**
     * Get default options.
     *
     * Retrieve the default options of the typography control. Used to return the
     * default options while initializing the typography control.
     *
     * @since 1.9.0
     * @access protected
     *
     * @return array Default typography control options.
     */
    protected function get_default_options()
    {
    }
}
/**
 * Elementor heading control.
 *
 * A base control for creating heading control. Displays a text heading between
 * controls in the panel.
 *
 * @since 1.0.0
 */
class Control_Heading extends \Elementor\Base_UI_Control
{
    /**
     * Get heading control type.
     *
     * Retrieve the control type, in this case `heading`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Get heading control default settings.
     *
     * Retrieve the default settings of the heading control. Used to return the
     * default settings while initializing the heading control.
     *
     * @since 1.0.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
    /**
     * Render heading control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template()
    {
    }
}
/**
 * Elementor hidden control.
 *
 * A base control for creating hidden control. Used to save additional data in
 * the database without a visual presentation in the panel.
 *
 * @since 1.0.0
 */
class Control_Hidden extends \Elementor\Base_Data_Control
{
    /**
     * Get hidden control type.
     *
     * Retrieve the control type, in this case `hidden`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Render hidden control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template()
    {
    }
}
/**
 * Elementor hover animation control.
 *
 * A base control for creating hover animation control. Displays a select box
 * with the available hover animation effects @see Control_Hover_Animation::get_animations()
 *
 * @since 1.0.0
 */
class Control_Hover_Animation extends \Elementor\Base_Data_Control
{
    /**
     * Animations.
     *
     * Holds all the available hover animation effects of the control.
     *
     * @access private
     * @static
     *
     * @var array
     */
    protected static $_animations;
    /**
     * Get hover animation control type.
     *
     * Retrieve the control type, in this case `hover_animation`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Get animations.
     *
     * Retrieve the available hover animation effects.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @return array Available hover animation.
     */
    public static function get_animations()
    {
    }
    public static function get_default_animations(): array
    {
    }
    /**
     * Render hover animation control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template()
    {
    }
    /**
     * Get hover animation control default settings.
     *
     * Retrieve the default settings of the hover animation control. Used to return
     * the default settings while initializing the hover animation control.
     *
     * @since 1.0.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
    public static function get_assets($setting)
    {
    }
}
/**
 * Elementor icon control.
 *
 * A base control for creating an icon control. Displays a font icon select box
 * field. The control accepts `include` or `exclude` arguments to set a partial
 * list of icons.
 *
 * @since 1.0.0
 * @deprecated 2.6.0 Use `Control_Icons` class instead.
 */
class Control_Icon extends \Elementor\Base_Data_Control
{
    /**
     * Get icon control type.
     *
     * Retrieve the control type, in this case `icon`.
     *
     * @since 1.0.0
     * @deprecated 2.6.0 Use `Control_Icons` class instead.
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Get icons.
     *
     * Retrieve all the available icons.
     *
     * @since 1.0.0
     * @deprecated 2.6.0 Use `Control_Icons` class instead.
     * @access public
     * @static
     *
     * @return array Available icons.
     */
    public static function get_icons()
    {
    }
    /**
     * Get icons control default settings.
     *
     * Retrieve the default settings of the icons control. Used to return the default
     * settings while initializing the icons control.
     *
     * @since 1.0.0
     * @deprecated 2.6.0 Use `Control_Icons` class instead.
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
    /**
     * Render icons control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @deprecated 2.6.0 Use `Control_Icons` class instead.
     * @access public
     */
    public function content_template()
    {
    }
}
/**
 * Elementor Icons control.
 *
 * A base control for creating a Icons chooser control.
 * Used to select an Icon.
 *
 * Usage: @see https://developers.elementor.com/elementor-controls/icons-control
 *
 * @since 2.6.0
 */
class Control_Icons extends \Elementor\Control_Base_Multiple
{
    /**
     * Get media control type.
     *
     * Retrieve the control type, in this case `media`.
     *
     * @access public
     * @since 2.6.0
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Get Icons control default values.
     *
     * Retrieve the default value of the Icons control. Used to return the default
     * values while initializing the Icons control.
     *
     * @access public
     * @since 2.6.0
     * @return array Control default value.
     */
    public function get_default_value()
    {
    }
    /**
     * Render Icons control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 2.6.0
     * @access public
     */
    public function content_template()
    {
    }
    public function render_media_skin()
    {
    }
    public function render_inline_skin()
    {
    }
    /**
     * Get Icons control default settings.
     *
     * Retrieve the default settings of the Icons control. Used to return the default
     * settings while initializing the Icons control.
     *
     * @since 2.6.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
    /**
     * Support SVG Import
     *
     * @param array $mimes
     * @return array
     * @deprecated 3.5.0
     */
    public function support_svg_import($mimes)
    {
    }
    public function on_import($settings)
    {
    }
}
/**
 * Elementor image dimensions control.
 *
 * A base control for creating image dimension control. Displays image width
 * input, image height input and an apply button.
 *
 * @since 1.0.0
 */
class Control_Image_Dimensions extends \Elementor\Control_Base_Multiple
{
    /**
     * Get image dimensions control type.
     *
     * Retrieve the control type, in this case `image_dimensions`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Get image dimensions control default values.
     *
     * Retrieve the default value of the image dimensions control. Used to return the
     * default values while initializing the image dimensions control.
     *
     * @since 1.0.0
     * @access public
     *
     * @return array Control default value.
     */
    public function get_default_value()
    {
    }
    /**
     * Get image dimensions control default settings.
     *
     * Retrieve the default settings of the image dimensions control. Used to return
     * the default settings while initializing the image dimensions control.
     *
     * @since 1.0.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
    /**
     * Render image dimensions control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template()
    {
    }
}
/**
 * Elementor media control.
 *
 * A base control for creating a media chooser control. Based on the WordPress
 * media library. Used to select an image from the WordPress media library.
 *
 * @since 1.0.0
 */
class Control_Media extends \Elementor\Control_Base_Multiple
{
    /**
     * Get media control type.
     *
     * Retrieve the control type, in this case `media`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Get media control default values.
     *
     * Retrieve the default value of the media control. Used to return the default
     * values while initializing the media control.
     *
     * @since 1.0.0
     * @access public
     *
     * @return array Control default value.
     */
    public function get_default_value()
    {
    }
    public function on_export($settings)
    {
    }
    /**
     * Import media images.
     *
     * Used to import media control files from external sites while importing
     * Elementor template JSON file, and replacing the old data.
     *
     * @since 1.0.0
     * @access public
     *
     * @param array $settings Control settings.
     *
     * @return array Control settings.
     */
    public function on_import($settings)
    {
    }
    /**
     * Support SVG and JSON Import
     *
     * Called by the 'upload_mimes' filter. Adds SVG and JSON mime types to the list of WordPress' allowed mime types.
     *
     * @since 3.4.6
     * @deprecated 3.5.0
     *
     * @param mixed $mimes
     * @return mixed
     */
    public function support_svg_and_json_import($mimes)
    {
    }
    /**
     * Enqueue media control scripts and styles.
     *
     * Used to register and enqueue custom scripts and styles used by the media
     * control.
     *
     * @since 1.0.0
     * @access public
     */
    public function enqueue()
    {
    }
    /**
     * Render media control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template()
    {
    }
    /**
     * Get media control default settings.
     *
     * Retrieve the default settings of the media control. Used to return the default
     * settings while initializing the media control.
     *
     * @since 1.0.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
    /**
     * Get media control image title.
     *
     * Retrieve the `title` of the image selected by the media control.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @param array $attachment Media attachment.
     *
     * @return string Image title.
     */
    public static function get_image_title($attachment)
    {
    }
    /**
     * Get media control image alt.
     *
     * Retrieve the `alt` value of the image selected by the media control.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @param array $instance Media attachment.
     *
     * @return string Image alt.
     */
    public static function get_image_alt($instance)
    {
    }
    public function get_style_value($css_property, $control_value, array $control_data)
    {
    }
    public static function sanitise_text($text)
    {
    }
}
/**
 * Elementor Notice control.
 *
 * A base control specific for creating Notices in the Editor panels.
 *
 * @since 3.19.0
 */
class Control_Notice extends \Elementor\Base_UI_Control
{
    /**
     * Get notice control type.
     *
     * Retrieve the control type, in this case `notice`.
     *
     * @since 3.19.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Render notice control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 3.19.0
     * @access public
     */
    public function content_template()
    {
    }
    /**
     * Get notice control default settings.
     *
     * Retrieve the default settings of the notice control. Used to return the
     * default settings while initializing the notice control.
     *
     * @since 3.19.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
}
/**
 * Elementor number control.
 *
 * A base control for creating a number control. Displays a simple number input.
 *
 * @since 1.0.0
 */
class Control_Number extends \Elementor\Base_Data_Control
{
    /**
     * Get number control type.
     *
     * Retrieve the control type, in this case `number`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Get number control default settings.
     *
     * Retrieve the default settings of the number control. Used to return the
     * default settings while initializing the number control.
     *
     * @since 1.5.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
    /**
     * Render number control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template()
    {
    }
    public function get_value($control, $settings)
    {
    }
    public function get_style_value($css_property, $control_value, array $control_data)
    {
    }
}
/**
 * Elementor popover toggle control.
 *
 * A base control for creating a popover toggle control. By default displays a toggle
 * button to open and close a popover.
 *
 * @since 1.9.0
 */
class Control_Popover_Toggle extends \Elementor\Base_Data_Control
{
    /**
     * Get popover toggle control type.
     *
     * Retrieve the control type, in this case `popover_toggle`.
     *
     * @since 1.9.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Get popover toggle control default settings.
     *
     * Retrieve the default settings of the popover toggle control. Used to
     * return the default settings while initializing the popover toggle
     * control.
     *
     * @since 1.9.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
    /**
     * Render popover toggle control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.9.0
     * @access public
     */
    public function content_template()
    {
    }
}
/**
 * Elementor raw HTML control.
 *
 * A base control for creating raw HTML control. Displays HTML markup between
 * controls in the panel.
 *
 * @since 1.0.0
 */
class Control_Raw_Html extends \Elementor\Base_UI_Control
{
    /**
     * Get raw html control type.
     *
     * Retrieve the control type, in this case `raw_html`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Render raw html control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template()
    {
    }
    /**
     * Get raw html control default settings.
     *
     * Retrieve the default settings of the raw html control. Used to return the
     * default settings while initializing the raw html control.
     *
     * @since 1.0.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
}
/**
 * Elementor repeater control.
 *
 * A base control for creating repeater control. Repeater control allows you to
 * build repeatable blocks of fields. You can create, for example, a set of
 * fields that will contain a title and a WYSIWYG text - the user will then be
 * able to add "rows", and each row will contain a title and a text. The data
 * can be wrapper in custom HTML tags, designed using CSS, and interact using JS
 * or external libraries.
 *
 * @since 1.0.0
 */
class Control_Repeater extends \Elementor\Base_Data_Control implements \Elementor\Has_Validation
{
    /**
     * Get repeater control type.
     *
     * Retrieve the control type, in this case `repeater`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Get repeater control default value.
     *
     * Retrieve the default value of the data control. Used to return the default
     * values while initializing the repeater control.
     *
     * @since 2.0.0
     * @access public
     *
     * @return array Control default value.
     */
    public function get_default_value()
    {
    }
    /**
     * Get repeater control default settings.
     *
     * Retrieve the default settings of the repeater control. Used to return the
     * default settings while initializing the repeater control.
     *
     * @since 1.0.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
    /**
     * Get repeater control value.
     *
     * Retrieve the value of the repeater control from a specific Controls_Stack.
     *
     * @since 1.0.0
     * @access public
     *
     * @param array $control  Control.
     * @param array $settings Controls_Stack settings.
     *
     * @return mixed Control values.
     */
    public function get_value($control, $settings)
    {
    }
    /**
     * Import repeater.
     *
     * Used as a wrapper method for inner controls while importing Elementor
     * template JSON file, and replacing the old data.
     *
     * @since 1.8.0
     * @access public
     *
     * @param array $settings     Control settings.
     * @param array $control_data Optional. Control data. Default is an empty array.
     *
     * @return array Control settings.
     */
    public function on_import($settings, $control_data = [])
    {
    }
    /**
     * Render repeater control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template()
    {
    }
    public function validate(array $control_data): bool
    {
    }
}
/**
 * Elementor section control.
 *
 * A base control for creating section control. Displays a header that
 * functions as a toggle to show or hide a set of controls.
 *
 * Note: Do not use it directly, instead use `$widget->start_controls_section()`
 * and `$widget->end_controls_section()` to wrap a set of controls.
 *
 * @since 1.0.0
 */
class Control_Section extends \Elementor\Base_UI_Control
{
    /**
     * Get section control type.
     *
     * Retrieve the control type, in this case `section`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Render section control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template()
    {
    }
}
/**
 * Elementor select control.
 *
 * A base control for creating select control. Displays a simple select box.
 * It accepts an array in which the `key` is the option value and the `value` is
 * the option name.
 *
 * @since 1.0.0
 */
class Control_Select extends \Elementor\Base_Data_Control
{
    /**
     * Get select control type.
     *
     * Retrieve the control type, in this case `select`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Get select control default settings.
     *
     * Retrieve the default settings of the select control. Used to return the
     * default settings while initializing the select control.
     *
     * @since 2.0.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
    /**
     * Render select control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template()
    {
    }
}
/**
 * Elementor select2 control.
 *
 * A base control for creating select2 control. Displays a select box control
 * based on select2 jQuery plugin @see https://select2.github.io/ .
 * It accepts an array in which the `key` is the value and the `value` is the
 * option name. Set `multiple` to `true` to allow multiple value selection.
 *
 * @since 1.0.0
 */
class Control_Select2 extends \Elementor\Base_Data_Control
{
    /**
     * Get select2 control type.
     *
     * Retrieve the control type, in this case `select2`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Get select2 control default settings.
     *
     * Retrieve the default settings of the select2 control. Used to return the
     * default settings while initializing the select2 control.
     *
     * @since 1.8.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
    /**
     * Render select2 control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template()
    {
    }
}
/**
 * Elementor slider control.
 *
 * A base control for creating slider control. Displays a draggable range slider.
 * The slider control can optionally have a number of unit types (`size_units`)
 * for the user to choose from. The control also accepts a range argument that
 * allows you to set the `min`, `max` and `step` values per unit type.
 *
 * @since 1.0.0
 */
class Control_Slider extends \Elementor\Control_Base_Units
{
    /**
     * Get slider control type.
     *
     * Retrieve the control type, in this case `slider`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Get slider control default values.
     *
     * Retrieve the default value of the slider control. Used to return the default
     * values while initializing the slider control.
     *
     * @since 1.0.0
     * @access public
     *
     * @return array Control default value.
     */
    public function get_default_value()
    {
    }
    /**
     * Get slider control default settings.
     *
     * Retrieve the default settings of the slider control. Used to return the
     * default settings while initializing the slider control.
     *
     * @since 1.0.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
    /**
     * Render slider control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template()
    {
    }
}
/**
 * Elementor structure control.
 *
 * A base control for creating structure control. A private control for section
 * columns structure.
 *
 * @since 1.0.0
 */
class Control_Structure extends \Elementor\Base_Data_Control
{
    /**
     * Get structure control type.
     *
     * Retrieve the control type, in this case `structure`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Render structure control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template()
    {
    }
    /**
     * Get structure control default settings.
     *
     * Retrieve the default settings of the structure control. Used to return the
     * default settings while initializing the structure control.
     *
     * @since 1.0.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
}
/**
 * Elementor switcher control.
 *
 * A base control for creating switcher control. Displays an on/off switcher,
 * basically a fancy UI representation of a checkbox.
 *
 * @since 1.0.0
 */
class Control_Switcher extends \Elementor\Base_Data_Control
{
    /**
     * Get switcher control type.
     *
     * Retrieve the control type, in this case `switcher`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Render switcher control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template()
    {
    }
    /**
     * Get switcher control default settings.
     *
     * Retrieve the default settings of the switcher control. Used to return the
     * default settings while initializing the switcher control.
     *
     * @since 1.0.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
}
/**
 * Elementor tab control.
 *
 * A base control for creating tab control. Displays a tab header for a set of
 * controls.
 *
 * Note: Do not use it directly, instead use: `$widget->start_controls_tab()`
 * and in the end `$widget->end_controls_tab()`.
 *
 * @since 1.0.0
 */
class Control_Tab extends \Elementor\Base_UI_Control
{
    /**
     * Get tab control type.
     *
     * Retrieve the control type, in this case `tab`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Render tab control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template()
    {
    }
}
/**
 * Elementor tabs control.
 *
 * A base control for creating tabs control. Displays a tabs header for `tab`
 * controls.
 *
 * Note: Do not use it directly, instead use: `$widget->start_controls_tabs()`
 * and in the end `$widget->end_controls_tabs()`.
 *
 * @since 1.0.0
 */
class Control_Tabs extends \Elementor\Base_UI_Control
{
    /**
     * Get tabs control type.
     *
     * Retrieve the control type, in this case `tabs`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Render tabs control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template()
    {
    }
}
/**
 * Elementor text shadow control.
 *
 * A base control for creating text shadows control. Displays input fields for
 * horizontal shadow, vertical shadow, shadow blur and shadow color.
 *
 * @since 1.6.0
 */
class Control_Text_Shadow extends \Elementor\Control_Base_Multiple
{
    /**
     * Get text shadow control type.
     *
     * Retrieve the control type, in this case `text_shadow`.
     *
     * @since 1.6.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Get text shadow control default values.
     *
     * Retrieve the default value of the text shadow control. Used to return the
     * default values while initializing the text shadow control.
     *
     * @since 1.6.0
     * @access public
     *
     * @return array Control default value.
     */
    public function get_default_value()
    {
    }
    /**
     * Get text shadow control sliders.
     *
     * Retrieve the sliders of the text shadow control. Sliders are used while
     * rendering the control output in the editor.
     *
     * @since 1.6.0
     * @access public
     *
     * @return array Control sliders.
     */
    public function get_sliders()
    {
    }
    /**
     * Render text shadow control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.6.0
     * @access public
     */
    public function content_template()
    {
    }
}
/**
 * Elementor text control.
 *
 * A base control for creating text control. Displays a simple text input.
 *
 * @since 1.0.0
 */
class Control_Text extends \Elementor\Base_Data_Control
{
    /**
     * Get text control type.
     *
     * Retrieve the control type, in this case `text`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Render text control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template()
    {
    }
    /**
     * Get text control default settings.
     *
     * Retrieve the default settings of the text control. Used to return the
     * default settings while initializing the text control.
     *
     * @since 1.0.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
}
/**
 * Elementor textarea control.
 *
 * A base control for creating textarea control. Displays a classic textarea.
 *
 * @since 1.0.0
 */
class Control_Textarea extends \Elementor\Base_Data_Control
{
    /**
     * Get textarea control type.
     *
     * Retrieve the control type, in this case `textarea`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Get textarea control default settings.
     *
     * Retrieve the default settings of the textarea control. Used to return the
     * default settings while initializing the textarea control.
     *
     * @since 1.0.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
    /**
     * Render textarea control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template()
    {
    }
}
/**
 * Elementor URL control.
 *
 * A base control for creating url control. Displays a URL input with the
 * ability to set the target of the link to `_blank` to open in a new tab.
 *
 * @since 1.0.0
 */
class Control_URL extends \Elementor\Control_Base_Multiple
{
    /**
     * Get url control type.
     *
     * Retrieve the control type, in this case `url`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Get url control default values.
     *
     * Retrieve the default value of the url control. Used to return the default
     * values while initializing the url control.
     *
     * @since 1.0.0
     * @access public
     *
     * @return array Control default value.
     */
    public function get_default_value()
    {
    }
    /**
     * Get url control default settings.
     *
     * Retrieve the default settings of the url control. Used to return the default
     * settings while initializing the url control.
     *
     * @since 1.0.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
    /**
     * Render url control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template()
    {
    }
}
/**
 * Elementor Visual Choice control.
 *
 * This control extends the base Choose control allowing the user to choose between options represented by SVG or Image.
 *
 * @since 3.28.0
 */
class Control_Visual_Choice extends \Elementor\Base_Data_Control
{
    public function get_type()
    {
    }
    public function content_template()
    {
    }
    protected function get_default_settings()
    {
    }
}
/**
 * Elementor WordPress widget control.
 *
 * A base control for creating WordPress widget control. Displays native
 * WordPress widgets. This a private control for internal use.
 *
 * @since 1.0.0
 */
class Control_WP_Widget extends \Elementor\Base_Data_Control
{
    /**
     * Get WordPress widget control type.
     *
     * Retrieve the control type, in this case `wp_widget`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Get WordPress widget control default values.
     *
     * Retrieve the default value of the WordPress widget control. Used to return the
     * default values while initializing the WordPress widget control.
     *
     * @since 1.4.3
     * @access public
     *
     * @return array Control default value.
     */
    public function get_default_value()
    {
    }
    /**
     * Render WordPress widget control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template()
    {
    }
}
/**
 * Elementor WYSIWYG control.
 *
 * A base control for creating WYSIWYG control. Displays a WordPress WYSIWYG
 * (TinyMCE) editor.
 *
 * @since 1.0.0
 */
class Control_Wysiwyg extends \Elementor\Base_Data_Control
{
    /**
     * Get wysiwyg control type.
     *
     * Retrieve the control type, in this case `wysiwyg`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type()
    {
    }
    /**
     * Render wysiwyg control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template()
    {
    }
    /**
     * Retrieve textarea control default settings.
     *
     * Get the default settings of the textarea control. Used to return the
     * default settings while initializing the textarea control.
     *
     * @since 2.0.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings()
    {
    }
}
/**
 * Elementor controls manager.
 *
 * Elementor controls manager handler class is responsible for registering and
 * initializing all the supported controls, both regular controls and the group
 * controls.
 *
 * @since 1.0.0
 */
class Controls_Manager
{
    /**
     * Content tab.
     */
    const TAB_CONTENT = 'content';
    /**
     * Style tab.
     */
    const TAB_STYLE = 'style';
    /**
     * Advanced tab.
     */
    const TAB_ADVANCED = 'advanced';
    /**
     * Responsive tab.
     */
    const TAB_RESPONSIVE = 'responsive';
    /**
     * Layout tab.
     */
    const TAB_LAYOUT = 'layout';
    /**
     * Settings tab.
     */
    const TAB_SETTINGS = 'settings';
    /**
     * Text control.
     */
    const TEXT = 'text';
    /**
     * Number control.
     */
    const NUMBER = 'number';
    /**
     * Textarea control.
     */
    const TEXTAREA = 'textarea';
    /**
     * Select control.
     */
    const SELECT = 'select';
    /**
     * Switcher control.
     */
    const SWITCHER = 'switcher';
    /**
     * Button control.
     */
    const BUTTON = 'button';
    /**
     * Hidden control.
     */
    const HIDDEN = 'hidden';
    /**
     * Heading control.
     */
    const HEADING = 'heading';
    /**
     * Raw HTML control.
     */
    const RAW_HTML = 'raw_html';
    /**
     * Notice control.
     */
    const NOTICE = 'notice';
    /**
     * Deprecated Notice control.
     */
    const DEPRECATED_NOTICE = 'deprecated_notice';
    /**
     * Alert control.
     */
    const ALERT = 'alert';
    /**
     * Popover Toggle control.
     */
    const POPOVER_TOGGLE = 'popover_toggle';
    /**
     * Section control.
     */
    const SECTION = 'section';
    /**
     * Tab control.
     */
    const TAB = 'tab';
    /**
     * Tabs control.
     */
    const TABS = 'tabs';
    /**
     * Divider control.
     */
    const DIVIDER = 'divider';
    /**
     * Color control.
     */
    const COLOR = 'color';
    /**
     * Media control.
     */
    const MEDIA = 'media';
    /**
     * Slider control.
     */
    const SLIDER = 'slider';
    /**
     * Dimensions control.
     */
    const DIMENSIONS = 'dimensions';
    /**
     * Choose control.
     */
    const CHOOSE = 'choose';
    /**
     * Visual_Choice control.
     */
    const VISUAL_CHOICE = 'visual_choice';
    /**
     * WYSIWYG control.
     */
    const WYSIWYG = 'wysiwyg';
    /**
     * Code control.
     */
    const CODE = 'code';
    /**
     * Font control.
     */
    const FONT = 'font';
    /**
     * Image dimensions control.
     */
    const IMAGE_DIMENSIONS = 'image_dimensions';
    /**
     * WordPress widget control.
     */
    const WP_WIDGET = 'wp_widget';
    /**
     * URL control.
     */
    const URL = 'url';
    /**
     * Repeater control.
     */
    const REPEATER = 'repeater';
    /**
     * Icon control.
     */
    const ICON = 'icon';
    /**
     * Icons control.
     */
    const ICONS = 'icons';
    /**
     * Gallery control.
     */
    const GALLERY = 'gallery';
    /**
     * Structure control.
     */
    const STRUCTURE = 'structure';
    /**
     * Select2 control.
     */
    const SELECT2 = 'select2';
    /**
     * Date/Time control.
     */
    const DATE_TIME = 'date_time';
    /**
     * Box shadow control.
     */
    const BOX_SHADOW = 'box_shadow';
    /**
     * Text shadow control.
     */
    const TEXT_SHADOW = 'text_shadow';
    /**
     * Entrance animation control.
     */
    const ANIMATION = 'animation';
    /**
     * Hover animation control.
     */
    const HOVER_ANIMATION = 'hover_animation';
    /**
     * Exit animation control.
     */
    const EXIT_ANIMATION = 'exit_animation';
    /**
     * Gaps control.
     */
    const GAPS = 'gaps';
    /**
     * Get tabs.
     *
     * Retrieve the tabs of the current control.
     *
     * @since 1.6.0
     * @access public
     * @static
     *
     * @return array Control tabs.
     */
    public static function get_tabs()
    {
    }
    /**
     * Add tab.
     *
     * This method adds a new tab to the current control.
     *
     * @since 1.6.0
     * @access public
     * @static
     *
     * @param string $tab_name  Tab name.
     * @param string $tab_label Tab label.
     */
    public static function add_tab($tab_name, $tab_label = '')
    {
    }
    public static function get_groups_names()
    {
    }
    public static function get_controls_names()
    {
    }
    /**
     * Register control.
     *
     * This method adds a new control to the controls list. It adds any given
     * control to any given control instance.
     *
     * @since 1.0.0
     * @access public
     * @deprecated 3.5.0 Use `register()` method instead.
     *
     * @param string       $control_id       Control ID.
     * @param Base_Control $control_instance Control instance, usually the
     *                                       current instance.
     */
    public function register_control($control_id, \Elementor\Base_Control $control_instance)
    {
    }
    /**
     * Register control.
     *
     * This method adds a new control to the controls list. It adds any given
     * control to any given control instance.
     *
     * @since 3.5.0
     * @access public
     *
     * @param Base_Control $control_instance Control instance, usually the current instance.
     * @param string       $control_id       Control ID. Deprecated parameter.
     *
     * @return void
     */
    public function register(\Elementor\Base_Control $control_instance, $control_id = null)
    {
    }
    /**
     * Unregister control.
     *
     * This method removes control from the controls list.
     *
     * @since 1.0.0
     * @access public
     * @deprecated 3.5.0 Use `unregister()` method instead.
     *
     * @param string $control_id Control ID.
     *
     * @return bool True if the control was removed, False otherwise.
     */
    public function unregister_control($control_id)
    {
    }
    /**
     * Unregister control.
     *
     * This method removes control from the controls list.
     *
     * @since 3.5.0
     * @access public
     *
     * @param string $control_id Control ID.
     *
     * @return bool Whether the controls has been unregistered.
     */
    public function unregister($control_id)
    {
    }
    /**
     * Get controls.
     *
     * Retrieve the controls list from the current instance.
     *
     * @since 1.0.0
     * @access public
     *
     * @return Base_Control[] Controls list.
     */
    public function get_controls()
    {
    }
    /**
     * Get control.
     *
     * Retrieve a specific control from the current controls instance.
     *
     * @since 1.0.0
     * @access public
     *
     * @param string $control_id Control ID.
     *
     * @return bool|Base_Control Control instance, or False otherwise.
     */
    public function get_control($control_id)
    {
    }
    /**
     * Get controls data.
     *
     * Retrieve all the registered controls and all the data for each control.
     *
     * @since 1.0.0
     * @access public
     *
     * @return array {
     *    Control data.
     *
     *    @type array $name Control data.
     * }
     */
    public function get_controls_data()
    {
    }
    /**
     * Render controls.
     *
     * Generate the final HTML for all the registered controls using the element
     * template.
     *
     * @since 1.0.0
     * @access public
     */
    public function render_controls()
    {
    }
    /**
     * Get control groups.
     *
     * Retrieve a specific group for a given ID, or a list of all the control
     * groups.
     *
     * If the given group ID is wrong, it will return `null`. When the ID valid,
     * it will return the group control instance. When no ID was given, it will
     * return all the control groups.
     *
     * @since 1.0.10
     * @access public
     *
     * @param string $id Optional. Group ID. Default is null.
     *
     * @return null|Group_Control_Base|Group_Control_Base[]
     */
    public function get_control_groups($id = null)
    {
    }
    /**
     * Add group control.
     *
     * This method adds a new group control to the control groups list. It adds
     * any given group control to any given group control instance.
     *
     * @since 1.0.0
     * @access public
     *
     * @param string             $id       Group control ID.
     * @param Group_Control_Base $instance Group control instance, usually the
     *                                     current instance.
     *
     * @return Group_Control_Base Group control instance.
     */
    public function add_group_control($id, $instance)
    {
    }
    /**
     * Enqueue control scripts and styles.
     *
     * Used to register and enqueue custom scripts and styles used by the control.
     *
     * @since 1.0.0
     * @access public
     */
    public function enqueue_control_scripts()
    {
    }
    /**
     * Open new stack.
     *
     * This method adds a new stack to the control stacks list. It adds any
     * given stack to the current control instance.
     *
     * @since 1.0.0
     * @access public
     *
     * @param Controls_Stack $controls_stack Controls stack.
     */
    public function open_stack(\Elementor\Controls_Stack $controls_stack)
    {
    }
    /**
     * Remove existing stack from the stacks cache
     *
     * Removes the stack of a passed instance from the Controls Manager's stacks cache.
     *
     * @param Controls_Stack $controls_stack
     * @return void
     */
    public function delete_stack(\Elementor\Controls_Stack $controls_stack)
    {
    }
    /**
     * Add control to stack.
     *
     * This method adds a new control to the stack.
     *
     * @since 1.0.0
     * @access public
     *
     * @param Controls_Stack $element      Element stack.
     * @param string         $control_id   Control ID.
     * @param array          $control_data Control data.
     * @param array          $options      Optional. Control additional options.
     *                                     Default is an empty array.
     *
     * @return bool True if control added, False otherwise.
     */
    public function add_control_to_stack(\Elementor\Controls_Stack $element, $control_id, $control_data, $options = [])
    {
    }
    /**
     * Remove control from stack.
     *
     * This method removes a control a the stack.
     *
     * @since 1.0.0
     * @access public
     *
     * @param string       $stack_id   Stack ID.
     * @param array|string $control_id The ID of the control to remove.
     *
     * @return bool|\WP_Error True if the stack was removed, False otherwise.
     */
    public function remove_control_from_stack($stack_id, $control_id)
    {
    }
    /**
     * Has Stacks Cache Been Cleared.
     *
     * @since 3.13.0
     * @access public
     * @return bool True if the CSS requires to clear the controls stack cache, False otherwise.
     */
    public function has_stacks_cache_been_cleared()
    {
    }
    /**
     * Clear stack.
     * This method clears the stack.
     *
     * @since 3.13.0
     * @access public
     */
    public function clear_stack_cache()
    {
    }
    /**
     * Get control from stack.
     *
     * Retrieve a specific control for a given a specific stack.
     *
     * If the given control does not exist in the stack, or the stack does not
     * exist, it will return `WP_Error`. Otherwise, it will retrieve the control
     * from the stack.
     *
     * @since 1.1.0
     * @access public
     *
     * @param string $stack_id   Stack ID.
     * @param string $control_id Control ID.
     *
     * @return array|\WP_Error The control, or an error.
     */
    public function get_control_from_stack($stack_id, $control_id)
    {
    }
    /**
     * Update control in stack.
     *
     * This method updates the control data for a given stack.
     *
     * @since 1.1.0
     * @access public
     *
     * @param Controls_Stack $element      Element stack.
     * @param string         $control_id   Control ID.
     * @param array          $control_data Control data.
     * @param array          $options      Optional. Control additional options.
     *                                     Default is an empty array.
     *
     * @return bool True if control updated, False otherwise.
     */
    public function update_control_in_stack(\Elementor\Controls_Stack $element, $control_id, $control_data, array $options = [])
    {
    }
    /**
     * Get stacks.
     *
     * Retrieve a specific stack for the list of stacks.
     *
     * If the given stack is wrong, it will return `null`. When the stack valid,
     * it will return the the specific stack. When no stack was given, it will
     * return all the stacks.
     *
     * @since 1.7.1
     * @access public
     *
     * @param string $stack_id Optional. stack ID. Default is null.
     *
     * @return null|array A list of stacks.
     */
    public function get_stacks($stack_id = null)
    {
    }
    /**
     * Get element stack.
     *
     * Retrieve a specific stack for the list of stacks from the current instance.
     *
     * @since 1.0.0
     * @access public
     *
     * @param Controls_Stack $controls_stack  Controls stack.
     *
     * @return null|array Stack data if it exists, `null` otherwise.
     */
    public function get_element_stack(\Elementor\Controls_Stack $controls_stack)
    {
    }
    /**
     * Add custom CSS controls.
     *
     * This method adds a new control for the "Custom CSS" feature. The free
     * version of elementor uses this method to display an upgrade message to
     * Elementor Pro.
     *
     * @since 1.0.0
     * @access public
     *
     * @param Controls_Stack $controls_stack .
     * @param string         $tab
     * @param array          $additional_messages
     */
    public function add_custom_css_controls(\Elementor\Controls_Stack $controls_stack, $tab = self::TAB_ADVANCED, $additional_messages = [])
    {
    }
    /**
     * Add Page Transitions controls.
     *
     * This method adds a new control for the "Page Transitions" feature. The Core
     * version of elementor uses this method to display an upgrade message to
     * Elementor Pro.
     *
     * @param Controls_Stack $controls_stack .
     * @param string         $tab
     * @param array          $additional_messages
     *
     * @return void
     */
    public function add_page_transitions_controls(\Elementor\Controls_Stack $controls_stack, $tab = self::TAB_ADVANCED, $additional_messages = [])
    {
    }
    public function get_teaser_template($texts)
    {
    }
    /**
     * Get Responsive Control Device Suffix
     *
     * @param array $control
     * @return string $device suffix
     */
    public static function get_responsive_control_device_suffix(array $control): string
    {
    }
    /**
     * Add custom attributes controls.
     *
     * This method adds a new control for the "Custom Attributes" feature. The free
     * version of elementor uses this method to display an upgrade message to
     * Elementor Pro.
     *
     * @param Controls_Stack $controls_stack .
     * @param string         $tab
     * @since 2.8.3
     * @access public
     */
    public function add_custom_attributes_controls(\Elementor\Controls_Stack $controls_stack, string $tab = self::TAB_ADVANCED)
    {
    }
    public function add_display_conditions_controls(\Elementor\Controls_Stack $controls_stack)
    {
    }
    public function add_motion_effects_promotion_control(\Elementor\Controls_Stack $controls_stack)
    {
    }
}
/**
 * Elementor elements manager.
 *
 * Elementor elements manager handler class is responsible for registering and
 * initializing all the supported elements.
 *
 * @since 1.0.0
 */
class Elements_Manager
{
    const CATEGORY_ATOMIC_ELEMENTS = 'v4-elements';
    const CATEGORY_ATOMIC_FORM = 'atomic-form';
    const CATEGORY_FAVORITES = 'favorites';
    const CATEGORY_ANGIE_WIDGETS = 'angie-widgets';
    /**
     * Elements constructor.
     *
     * Initializing Elementor elements manager.
     *
     * @since 1.0.0
     * @access public
     */
    public function __construct()
    {
    }
    /**
     * Create element instance.
     *
     * This method creates a new element instance for any given element.
     *
     * @since 1.0.0
     * @access public
     *
     * @param array        $element_data Element data.
     * @param array        $element_args Optional. Element arguments. Default is
     *                                   an empty array.
     * @param Element_Base $element_type Optional. Element type. Default is null.
     *
     * @return Element_Base|null Element instance if element created, or null
     *                           otherwise.
     */
    public function create_element_instance(array $element_data, array $element_args = [], ?\Elementor\Element_Base $element_type = null)
    {
    }
    public function get_element(string $el_type, ?string $widget_type = null)
    {
    }
    /**
     * Get element categories.
     *
     * Retrieve the list of categories the element belongs to.
     *
     * @since 1.0.0
     * @access public
     *
     * @return array Element categories.
     */
    public function get_categories()
    {
    }
    /**
     * Add element category.
     *
     * Register new category for the element.
     *
     * @since 1.7.12
     * @access public
     *
     * @param string $category_name       Category name.
     * @param array  $category_properties Category properties.
     */
    public function add_category($category_name, $category_properties)
    {
    }
    /**
     * Register element type.
     *
     * Add new type to the list of registered types.
     *
     * @since 1.0.0
     * @access public
     *
     * @param Element_Base $element Element instance.
     *
     * @return bool Whether the element type was registered.
     */
    public function register_element_type(\Elementor\Element_Base $element)
    {
    }
    /**
     * Unregister element type.
     *
     * Remove element type from the list of registered types.
     *
     * @since 1.0.0
     * @access public
     *
     * @param string $name Element name.
     *
     * @return bool Whether the element type was unregister, or not.
     */
    public function unregister_element_type($name)
    {
    }
    /**
     * Get element types.
     *
     * Retrieve the list of all the element types, or if a specific element name
     * was provided retrieve his element types.
     *
     * @since 1.0.0
     * @access public
     *
     * @param string $element_name Optional. Element name. Default is null.
     *
     * @return null|Element_Base|Element_Base[] Element types, or a list of all the element
     *                             types, or null if element does not exist.
     */
    public function get_element_types($element_name = null)
    {
    }
    /**
     * Get element types config.
     *
     * Retrieve the config of all the element types.
     *
     * @since 1.0.0
     * @access public
     *
     * @return array Element types config.
     */
    public function get_element_types_config()
    {
    }
    /**
     * Render elements content.
     *
     * Used to generate the elements templates on the editor.
     *
     * @since 1.0.0
     * @access public
     */
    public function render_elements_content()
    {
    }
    public function enqueue_elements_styles()
    {
    }
    public function enqueue_elements_scripts()
    {
    }
    public function register_frontend_handlers()
    {
    }
}
/**
 * Elementor icons manager.
 *
 * Elementor icons manager handler class
 *
 * @since 2.4.0
 */
class Icons_Manager
{
    const NEEDS_UPDATE_OPTION = 'icon_manager_needs_update';
    const FONT_ICON_SVG_CLASS_NAME = 'e-font-icon-svg';
    const LOAD_FA4_SHIM_OPTION_KEY = 'elementor_load_fa4_shim';
    const ELEMENTOR_ICONS_VERSION = '5.48.0';
    /**
     * @param array  $icon
     * @param array  $attributes
     * @param string $tag
     * @return bool|mixed|string
     */
    public static function try_get_icon_html($icon, $attributes = [], $tag = 'i')
    {
    }
    /**
     * Register styles
     *
     * Used to register all icon types stylesheets so they could be enqueued later by widgets
     */
    public function register_styles()
    {
    }
    /**
     * Get Icon Manager Tabs
     *
     * @return array
     */
    public static function get_icon_manager_tabs()
    {
    }
    public static function enqueue_shim()
    {
    }
    public static function get_icon_manager_tabs_config()
    {
    }
    /**
     * @deprecated 3.8.0
     */
    public static function render_svg_symbols()
    {
    }
    public static function get_icon_svg_data($icon)
    {
    }
    /**
     * Get font awesome svg.
     *
     * @param $icon array [ 'value' => string, 'library' => string ]
     *
     * @return bool|mixed|string
     */
    public static function get_font_icon_svg($icon, $attributes = [])
    {
    }
    public static function render_uploaded_svg_icon($value)
    {
    }
    public static function render_font_icon($icon, $attributes = [], $tag = 'i')
    {
    }
    /**
     * Render Icon
     *
     * Used to render Icon for \Elementor\Controls_Manager::ICONS
     *
     * @param array  $icon             Icon Type, Icon value.
     * @param array  $attributes       Icon HTML Attributes.
     * @param string $tag             Icon HTML tag, defaults to <i>.
     *
     * @return mixed|string
     */
    public static function render_icon($icon, $attributes = [], $tag = 'i')
    {
    }
    /**
     * Font Awesome 4 to font Awesome 5 Value Migration
     *
     * Used to convert string value of Icon control to array value of Icons control
     * ex: 'fa fa-star' => [ 'value' => 'fas fa-star', 'library' => 'fa-solid' ]
     *
     * @param $value
     *
     * @return array
     */
    public static function fa4_to_fa5_value_migration($value)
    {
    }
    /**
     * On_import_migration
     *
     * @param array  $element        settings array.
     * @param string $old_control   old control id.
     * @param string $new_control   new control id.
     * @param bool   $remove_old      boolean whether to remove old control or not.
     *
     * @return array
     */
    public static function on_import_migration(array $element, $old_control = '', $new_control = '', $remove_old = false)
    {
    }
    public static function is_migration_allowed()
    {
    }
    /**
     * Register_Admin Settings
     *
     * Adds Font Awesome migration / update admin settings
     *
     * @param Settings $settings
     */
    public function register_admin_settings(\Elementor\Settings $settings)
    {
    }
    public function register_admin_tools_settings(\Elementor\Tools $settings)
    {
    }
    /**
     * Get redirect URL when upgrading font awesome.
     *
     * @return string
     */
    public function get_upgrade_redirect_url()
    {
    }
    /**
     * Ajax Upgrade to FontAwesome 5
     */
    public function ajax_upgrade_to_fa5()
    {
    }
    /**
     * Add Update Needed Flag
     *
     * @param array $settings
     *
     * @return array;
     */
    public function add_update_needed_flag($settings)
    {
    }
    public function enqueue_fontawesome_css()
    {
    }
    /**
     * @deprecated 3.1.0
     */
    public function add_admin_strings()
    {
    }
    /**
     * Icons Manager constructor
     */
    public function __construct()
    {
    }
}
/**
 * Elementor images manager.
 *
 * Elementor images manager handler class is responsible for retrieving image
 * details.
 *
 * @since 1.0.0
 */
class Images_Manager
{
    /**
     * Get images details.
     *
     * Retrieve details for all the images.
     *
     * Fired by `wp_ajax_elementor_get_images_details` action.
     *
     * @since 1.0.0
     * @access public
     */
    public function get_images_details()
    {
    }
    /**
     * Get image details.
     *
     * Retrieve single image details.
     *
     * Fired by `wp_ajax_elementor_get_image_details` action.
     *
     * @since 1.0.0
     * @access public
     *
     * @param string       $id            Image attachment ID.
     * @param string|array $size          Image size. Accepts any valid image
     *                                    size, or an array of width and height
     *                                    values in pixels (in that order).
     * @param string       $is_first_time Set 'true' string to force reloading
     *                                    all image sizes.
     *
     * @return array URLs with different image sizes.
     */
    public function get_details($id, $size, $is_first_time)
    {
    }
    /**
     * Get Light-Box Image Attributes
     *
     * Used to retrieve an array of image attributes to be used for displaying an image in Elementor's Light Box module.
     *
     * @param int $id       The ID of the image.
     *
     * @return array An array of image attributes including `title` and `description`.
     * @since 2.9.0
     * @access public
     */
    public function get_lightbox_image_attributes($id)
    {
    }
    /**
     * Images manager constructor.
     *
     * Initializing Elementor images manager.
     *
     * @since 1.0.0
     * @access public
     */
    public function __construct()
    {
    }
}
/**
 * Elementor skins manager.
 *
 * Elementor skins manager handler class is responsible for registering and
 * initializing all the supported skins.
 *
 * @since 1.0.0
 */
class Skins_Manager
{
    /**
     * Add new skin.
     *
     * Register a single new skin for a widget.
     *
     * @since 1.0.0
     * @access public
     *
     * @param Widget_Base $widget Elementor widget.
     * @param Skin_Base   $skin   Elementor skin.
     *
     * @return true True if skin added.
     */
    public function add_skin(\Elementor\Widget_Base $widget, \Elementor\Skin_Base $skin)
    {
    }
    /**
     * Remove a skin.
     *
     * Unregister an existing skin from a widget.
     *
     * @since 1.0.0
     * @access public
     *
     * @param Widget_Base $widget  Elementor widget.
     * @param string      $skin_id Elementor skin ID.
     *
     * @return true|\WP_Error True if skin removed, `WP_Error` otherwise.
     */
    public function remove_skin(\Elementor\Widget_Base $widget, $skin_id)
    {
    }
    /**
     * Get skins.
     *
     * Retrieve all the skins assigned for a specific widget.
     *
     * @since 1.0.0
     * @access public
     *
     * @param Widget_Base $widget Elementor widget.
     *
     * @return false|array Skins if the widget has skins, False otherwise.
     */
    public function get_skins(\Elementor\Widget_Base $widget)
    {
    }
    /**
     * Skins manager constructor.
     *
     * Initializing Elementor skins manager by requiring the skin base class.
     *
     * @since 1.0.0
     * @access public
     */
    public function __construct()
    {
    }
}
/**
 * Elementor widgets manager.
 *
 * Elementor widgets manager handler class is responsible for registering and
 * initializing all the supported Elementor widgets.
 *
 * @since 1.0.0
 */
class Widgets_Manager
{
    /**
     * Register widget type.
     *
     * Add a new widget type to the list of registered widget types.
     *
     * @since 1.0.0
     * @access public
     * @deprecated 3.5.0 Use `register()` method instead.
     *
     * @param Widget_Base $widget Elementor widget.
     *
     * @return true True if the widget was registered.
     */
    public function register_widget_type(\Elementor\Widget_Base $widget)
    {
    }
    /**
     * Register a new widget type.
     *
     * @param \Elementor\Widget_Base $widget_instance Elementor Widget.
     *
     * @return bool True if the widget was registered.
     * @since 3.5.0
     * @access public
     */
    public function register(\Elementor\Widget_Base $widget_instance)
    {
    }
    /**
     * Unregister widget type.
     *
     * Removes widget type from the list of registered widget types.
     *
     * @since 1.0.0
     * @access public
     * @deprecated 3.5.0 Use `unregister()` method instead.
     *
     * @param string $name Widget name.
     *
     * @return true True if the widget was unregistered, False otherwise.
     */
    public function unregister_widget_type($name)
    {
    }
    /**
     * Unregister widget type.
     *
     * Removes widget type from the list of registered widget types.
     *
     * @since 3.5.0
     * @access public
     *
     * @param string $name Widget name.
     *
     * @return boolean Whether the widget was unregistered.
     */
    public function unregister($name)
    {
    }
    /**
     * Get widget types.
     *
     * Retrieve the registered widget types list.
     *
     * @since 1.0.0
     * @access public
     *
     * @param string $widget_name Optional. Widget name. Default is null.
     *
     * @return Widget_Base|Widget_Base[]|null Registered widget types.
     */
    public function get_widget_types($widget_name = null)
    {
    }
    /**
     * Get widget types config.
     *
     * Retrieve all the registered widgets with config for each widgets.
     *
     * @since 1.0.0
     * @access public
     *
     * @return array Registered widget types with each widget config.
     */
    public function get_widget_types_config()
    {
    }
    /**
     * @throws \Exception If current user don't have permissions to edit the post.
     */
    public function ajax_get_widget_types_controls_config(array $data)
    {
    }
    public function ajax_get_widgets_default_value_translations(array $data = [])
    {
    }
    /**
     * Ajax render widget.
     *
     * Ajax handler for Elementor render_widget.
     *
     * Fired by `wp_ajax_elementor_render_widget` action.
     *
     * @since 1.0.0
     * @access public
     *
     * @throws \Exception If current user don't have permissions to edit the post.
     *
     * @param array $request Ajax request.
     *
     * @return array {
     *     Rendered widget.
     *
     *     @type string $render The rendered HTML.
     * }
     */
    public function ajax_render_widget($request)
    {
    }
    /**
     * Ajax get WordPress widget form.
     *
     * Ajax handler for Elementor editor get_wp_widget_form.
     *
     * Fired by `wp_ajax_elementor_editor_get_wp_widget_form` action.
     *
     * @since 1.0.0
     * @access public
     *
     * @param array $request Ajax request.
     *
     * @return bool|string Rendered widget form.
     * @throws \Exception If current user don't have permissions to edit the post.
     */
    public function ajax_get_wp_widget_form($request)
    {
    }
    /**
     * Render widgets content.
     *
     * Used to generate the widget templates on the editor using Underscore JS
     * template, for all the registered widget types.
     *
     * @since 1.0.0
     * @access public
     */
    public function render_widgets_content()
    {
    }
    /**
     * Get widgets frontend settings keys.
     *
     * Retrieve frontend controls settings keys for all the registered widget
     * types.
     *
     * @since 1.3.0
     * @access public
     *
     * @return array Registered widget types with settings keys for each widget.
     */
    public function get_widgets_frontend_settings_keys()
    {
    }
    /**
     * Widgets with styles.
     *
     * This method returns the list of all the widgets in the `/includes/`
     * folder that have styles.
     *
     * @since 3.24.0
     * @access public
     *
     * @return array The names of the widgets that have styles.
     */
    public function widgets_with_styles(): array
    {
    }
    /**
     * Widgets with responsive styles.
     *
     * This method returns the list of all the widgets in the `/includes/`
     * folder that have responsive styles.
     *
     * @since 3.24.0
     * @access public
     *
     * @return array The names of the widgets that have responsive styles.
     */
    public function widgets_with_responsive_styles(): array
    {
    }
    /**
     * Enqueue widgets scripts.
     *
     * Enqueue all the scripts defined as a dependency for each widget.
     *
     * @since 1.3.0
     * @access public
     */
    public function enqueue_widgets_scripts()
    {
    }
    public function register_frontend_handlers()
    {
    }
    /**
     * Enqueue widgets styles
     *
     * Enqueue all the styles defined as a dependency for each widget
     *
     * @access public
     */
    public function enqueue_widgets_styles()
    {
    }
    /**
     * Retrieve inline editing configuration.
     *
     * Returns general inline editing configurations like toolbar types etc.
     *
     * @access public
     * @since 1.8.0
     *
     * @return array {
     *     Inline editing configuration.
     *
     *     @type array $toolbar {
     *         Toolbar types and the actions each toolbar includes.
     *         Note: Wysiwyg controls uses the advanced toolbar, textarea controls
     *         uses the basic toolbar and text controls has no toolbar.
     *
     *         @type array $basic    Basic actions included in the edit tool.
     *         @type array $advanced Advanced actions included in the edit tool.
     *     }
     * }
     */
    public function get_inline_editing_config()
    {
    }
    /**
     * Widgets manager constructor.
     *
     * Initializing Elementor widgets manager.
     *
     * @since 1.0.0
     * @access public
     */
    public function __construct()
    {
    }
    /**
     * Register ajax actions.
     *
     * Add new actions to handle data after an ajax requests returned.
     *
     * @since 2.0.0
     * @access public
     *
     * @param \Elementor\Core\Common\Modules\Ajax\Module $ajax_manager
     */
    public function register_ajax_actions(\Elementor\Core\Common\Modules\Ajax\Module $ajax_manager)
    {
    }
    /**
     * @param string $experiment_name
     * @param array  $classes
     * @return void
     */
    public function register_promoted_active_widgets(string $experiment_name, array $classes): void
    {
    }
}
/**
 * Elementor WordPress widgets manager.
 *
 * Elementor WordPress widgets manager handler class is responsible for
 * registering and initializing all the supported controls, both regular
 * controls and the group controls.
 *
 * @since 1.5.0
 */
class WordPress_Widgets_Manager
{
    /**
     * WordPress widgets manager constructor.
     *
     * Initializing the WordPress widgets manager in Elementor editor.
     *
     * @since 1.5.0
     * @access public
     */
    public function __construct()
    {
    }
    /**
     * Before enqueue scripts.
     *
     * Prints custom scripts required to run WordPress widgets in Elementor
     * editor.
     *
     * Fired by `elementor/editor/before_enqueue_scripts` action.
     *
     * @since 1.5.0
     * @access public
     */
    public function before_enqueue_scripts()
    {
    }
    /**
     * WordPress widgets footer.
     *
     * Prints WordPress widgets scripts in Elementor editor footer.
     *
     * Fired by `elementor/editor/footer` action.
     *
     * @since 1.5.0
     * @access public
     */
    public function footer()
    {
    }
}
/**
 * Elementor accordion widget.
 *
 * Elementor widget that displays a collapsible display of content in an
 * accordion style, showing only one item at a time.
 *
 * @since 1.0.0
 */
class Widget_Accordion extends \Elementor\Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve accordion widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
    }
    /**
     * Get widget title.
     *
     * Retrieve accordion widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
    }
    /**
     * Get widget icon.
     *
     * Retrieve accordion widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
    }
    protected function is_dynamic_content(): bool
    {
    }
    /**
     * Get style dependencies.
     *
     * Retrieve the list of style dependencies the widget requires.
     *
     * @since 3.24.0
     * @access public
     *
     * @return array Widget style dependencies.
     */
    public function get_style_depends(): array
    {
    }
    /**
     * Hide widget from panel.
     *
     * Hide the toggle widget from the panel if nested-accordion experiment is active.
     *
     * @since 3.15.0
     * @return bool
     */
    public function show_in_panel(): bool
    {
    }
    public function has_widget_inner_wrapper(): bool
    {
    }
    /**
     * Register accordion widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    /**
     * Render accordion widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
    }
    /**
     * Render accordion widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template()
    {
    }
}
/**
 * Elementor alert widget.
 *
 * Elementor widget that displays a collapsible display of content in an toggle
 * style, allowing the user to open multiple items.
 *
 * @since 1.0.0
 */
class Widget_Alert extends \Elementor\Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve alert widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
    }
    /**
     * Get widget title.
     *
     * Retrieve alert widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
    }
    /**
     * Get widget icon.
     *
     * Retrieve alert widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
    }
    protected function is_dynamic_content(): bool
    {
    }
    /**
     * Get style dependencies.
     *
     * Retrieve the list of style dependencies the widget requires.
     *
     * @since 3.24.0
     * @access public
     *
     * @return array Widget style dependencies.
     */
    public function get_style_depends(): array
    {
    }
    public function has_widget_inner_wrapper(): bool
    {
    }
    /**
     * Register alert widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    /**
     * Render alert widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
    }
    /**
     * Render alert widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template()
    {
    }
}
/**
 * Elementor audio widget.
 *
 * Elementor widget that displays an audio player.
 *
 * @since 1.0.0
 */
class Widget_Audio extends \Elementor\Widget_Base
{
    /**
     * Current instance.
     *
     * @access protected
     *
     * @var array
     */
    protected $_current_instance = [];
    /**
     * Get widget name.
     *
     * Retrieve audio widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
    }
    /**
     * Get widget title.
     *
     * Retrieve audio widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
    }
    /**
     * Get widget icon.
     *
     * Retrieve audio widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
    }
    protected function is_dynamic_content(): bool
    {
    }
    public function has_widget_inner_wrapper(): bool
    {
    }
    /**
     * Register audio widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    /**
     * Render audio widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
    }
    /**
     * Filter audio widget oEmbed results.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access public
     *
     * @param string $html The HTML returned by the oEmbed provider.
     *
     * @return string Filtered audio widget oEmbed HTML.
     */
    public function filter_oembed_result($html)
    {
    }
    /**
     * Render audio widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template()
    {
    }
}
namespace Elementor\Includes\Widgets\Traits;

trait Button_Trait
{
    /**
     * Get button sizes.
     *
     * Retrieve an array of button sizes for the button widget.
     *
     * @since 3.4.0
     * @access public
     * @static
     *
     * @return array An array containing button sizes.
     */
    public static function get_button_sizes()
    {
    }
    /**
     * @since 3.4.0
     *
     * @param array $args {
     *     An array of values for the button adjustments.
     *
     *     @type array  $section_condition  Set of conditions to hide the controls.
     *     @type string $button_text  Text contained in button.
     *     @type string $text_control_label  Name for the label of the text control.
     *     @type array $icon_exclude_inline_options  Set of icon types to exclude from icon controls.
     * }
     */
    protected function register_button_content_controls($args = [])
    {
    }
    /**
     * @since 3.4.0
     *
     * @param array $args {
     *     An array of values for the button adjustments.
     *
     *     @type array  $section_condition  Set of conditions to hide the controls.
     *     @type string $alignment_default  Default position for the button.
     *     @type string $alignment_control_prefix_class  Prefix class name for the button position control.
     *     @type string $content_alignment_default  Default alignment for the button content.
     * }
     */
    protected function register_button_style_controls($args = [])
    {
    }
    /**
     * Render button widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @param \Elementor\Widget_Base|null $instance
     *
     * @since  3.4.0
     * @access protected
     */
    protected function render_button(?\Elementor\Widget_Base $instance = null)
    {
    }
    /**
     * Render button widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since  3.4.0
     * @access protected
     */
    protected function content_template()
    {
    }
    /**
     * Render button text.
     *
     * Render button widget text.
     *
     * @param \Elementor\Widget_Base|null $instance
     *
     * @since  3.4.0
     * @access protected
     */
    protected function render_text(?\Elementor\Widget_Base $instance = null)
    {
    }
    public function on_import($element)
    {
    }
}
namespace Elementor;

/**
 * Elementor button widget.
 *
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class Widget_Button extends \Elementor\Widget_Base
{
    use \Elementor\Includes\Widgets\Traits\Button_Trait;
    /**
     * Get widget name.
     *
     * Retrieve button widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
    }
    /**
     * Get widget title.
     *
     * Retrieve button widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
    }
    /**
     * Get widget icon.
     *
     * Retrieve button widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
    }
    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the button widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @since 2.0.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
    }
    protected function is_dynamic_content(): bool
    {
    }
    public function has_widget_inner_wrapper(): bool
    {
    }
    /**
     * Get widget upsale data.
     *
     * Retrieve the widget promotion data.
     *
     * @since 3.19.0
     * @access protected
     *
     * @return array Widget promotion data.
     */
    protected function get_upsale_data()
    {
    }
    protected function register_controls()
    {
    }
    /**
     * Render button widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
    }
}
/**
 * Elementor common widget.
 *
 * Elementor base widget that gives you all the advanced options of the basic
 * widget.
 *
 * @since 1.0.0
 */
class Widget_Common_Base extends \Elementor\Widget_Base
{
    const WRAPPER_SELECTOR = '{{WRAPPER}} .elementor-widget-container';
    const WRAPPER_SELECTOR_CHILD = '{{WRAPPER}} > .elementor-widget-container';
    const WRAPPER_SELECTOR_HOVER = '{{WRAPPER}}:hover .elementor-widget-container';
    const WRAPPER_SELECTOR_HOVER_CHILD = '{{WRAPPER}}:hover > .elementor-widget-container';
    const MASK_SELECTOR_DEFAULT = '{{WRAPPER}}:not( .elementor-widget-image ) .elementor-widget-container';
    const MASK_SELECTOR_IMG = '{{WRAPPER}}.elementor-widget-image .elementor-widget-container img';
    const TRANSFORM_SELECTOR_CLASS = ' > .elementor-widget-container';
    const MARGIN = 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};';
    /**
     * Get widget name.
     *
     * Retrieve common widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
    }
    /**
     * Show in panel.
     *
     * Whether to show the common widget in the panel or not.
     *
     * @since 1.0.0
     * @access public
     *
     * @return bool Whether to show the widget in the panel.
     */
    public function show_in_panel()
    {
    }
    /**
     * Get Responsive Device Args
     *
     * Receives an array of device args, and duplicates it for each active breakpoint.
     * Returns an array of device args.
     *
     * @since 3.4.7
     * @deprecated 3.7.0 Not needed anymore because responsive conditioning in the Editor was fixed in v3.7.0.
     * @access protected
     *
     * @param array $args arguments to duplicate per breakpoint.
     * @param array $devices_to_exclude
     *
     * @return array responsive device args
     */
    protected function get_responsive_device_args(array $args, array $devices_to_exclude = [])
    {
    }
    /**
     * Register common widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
}
class Widget_Common_Optimized extends \Elementor\Widget_Common_Base
{
    const WRAPPER_SELECTOR = '{{WRAPPER}}';
    const WRAPPER_SELECTOR_CHILD = '{{WRAPPER}}';
    const WRAPPER_SELECTOR_HOVER = '{{WRAPPER}}:hover';
    const WRAPPER_SELECTOR_HOVER_CHILD = '{{WRAPPER}}:hover';
    const MASK_SELECTOR_DEFAULT = '{{WRAPPER}}:not( .elementor-widget-image )';
    const MASK_SELECTOR_IMG = '{{WRAPPER}}.elementor-widget-image img';
    const TRANSFORM_SELECTOR_CLASS = '';
    const MARGIN = 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} calc(var(--kit-widget-spacing, 0px) + {{BOTTOM}}{{UNIT}}) {{LEFT}}{{UNIT}};';
    public function get_name()
    {
    }
}
class Widget_Common extends \Elementor\Widget_Common_Base
{
    public function get_name()
    {
    }
}
/**
 * Elementor counter widget.
 *
 * Elementor widget that displays stats and numbers in an escalating manner.
 *
 * @since 1.0.0
 */
class Widget_Counter extends \Elementor\Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve counter widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
    }
    /**
     * Get widget title.
     *
     * Retrieve counter widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
    }
    /**
     * Get widget icon.
     *
     * Retrieve counter widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
    }
    /**
     * Retrieve the list of scripts the counter widget depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @since 1.3.0
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_script_depends()
    {
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
    }
    protected function is_dynamic_content(): bool
    {
    }
    /**
     * Get style dependencies.
     *
     * Retrieve the list of style dependencies the widget requires.
     *
     * @since 3.24.0
     * @access public
     *
     * @return array Widget style dependencies.
     */
    public function get_style_depends(): array
    {
    }
    public function has_widget_inner_wrapper(): bool
    {
    }
    /**
     * Register counter widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    /**
     * Render counter widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template()
    {
    }
    /**
     * Render counter widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
    }
}
/**
 * Elementor divider widget.
 *
 * Elementor widget that displays a line that divides different elements in the
 * page.
 *
 * @since 1.0.0
 */
class Widget_Divider extends \Elementor\Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve divider widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
    }
    /**
     * Get widget title.
     *
     * Retrieve divider widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
    }
    /**
     * Get widget icon.
     *
     * Retrieve divider widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
    }
    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the divider widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @since 2.0.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
    }
    protected function is_dynamic_content(): bool
    {
    }
    public function has_widget_inner_wrapper(): bool
    {
    }
    /**
     * Get style dependencies.
     *
     * Retrieve the list of style dependencies the widget requires.
     *
     * @since 3.24.0
     * @access public
     *
     * @return array Widget style dependencies.
     */
    public function get_style_depends(): array
    {
    }
    /**
     * Register divider widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    public function svg_to_data_uri($svg)
    {
    }
    /**
     * Render divider widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
    }
}
/**
 * Elementor google maps widget.
 *
 * Elementor widget that displays an embedded google map.
 *
 * @since 1.0.0
 */
class Widget_Google_Maps extends \Elementor\Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve google maps widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
    }
    /**
     * Get widget title.
     *
     * Retrieve google maps widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
    }
    /**
     * Get widget icon.
     *
     * Retrieve google maps widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
    }
    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the google maps widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @since 2.0.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
    }
    protected function is_dynamic_content(): bool
    {
    }
    /**
     * Get style dependencies.
     *
     * Retrieve the list of style dependencies the widget requires.
     *
     * @since 3.24.0
     * @access public
     *
     * @return array Widget style dependencies.
     */
    public function get_style_depends(): array
    {
    }
    public function has_widget_inner_wrapper(): bool
    {
    }
    /**
     * Register google maps widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    /**
     * Render google maps widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
    }
    /**
     * Render google maps widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template()
    {
    }
}
/**
 * Elementor heading widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 1.0.0
 */
class Widget_Heading extends \Elementor\Widget_Base implements \Elementor\Modules\ContentSanitizer\Interfaces\Sanitizable
{
    /**
     * Get widget name.
     *
     * Retrieve heading widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
    }
    /**
     * Get widget title.
     *
     * Retrieve heading widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
    }
    /**
     * Get widget icon.
     *
     * Retrieve heading widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
    }
    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the heading widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @since 2.0.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
    }
    protected function is_dynamic_content(): bool
    {
    }
    /**
     * Get style dependencies.
     *
     * Retrieve the list of style dependencies the widget requires.
     *
     * @since 3.24.0
     * @access public
     *
     * @return array Widget style dependencies.
     */
    public function get_style_depends(): array
    {
    }
    public function has_widget_inner_wrapper(): bool
    {
    }
    /**
     * Remove data attributes from the html.
     *
     * @param string $content Heading title.
     * @return string
     */
    public function sanitize($content): string
    {
    }
    /**
     * Get widget upsale data.
     *
     * Retrieve the widget promotion data.
     *
     * @since 3.18.0
     * @access protected
     *
     * @return array Widget promotion data.
     */
    protected function get_upsale_data()
    {
    }
    /**
     * Register heading widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    /**
     * Render heading widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
    }
    public function maybe_add_ally_heading_hint()
    {
    }
    /**
     * Render heading widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template()
    {
    }
}
/**
 * Elementor HTML widget.
 *
 * Elementor widget that insert a custom HTML code into the page.
 *
 * @since 1.0.0
 */
class Widget_Html extends \Elementor\Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve HTML widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
    }
    /**
     * Get widget title.
     *
     * Retrieve HTML widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
    }
    /**
     * Get widget icon.
     *
     * Retrieve HTML widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
    }
    protected function is_dynamic_content(): bool
    {
    }
    public function show_in_panel()
    {
    }
    public function has_widget_inner_wrapper(): bool
    {
    }
    /**
     * Register HTML widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    /**
     * Render HTML widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
    }
    /**
     * Render HTML widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template()
    {
    }
}
/**
 * Elementor icon box widget.
 *
 * Elementor widget that displays an icon, a headline and a text.
 *
 * @since 1.0.0
 */
class Widget_Icon_Box extends \Elementor\Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve icon box widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
    }
    /**
     * Get widget title.
     *
     * Retrieve icon box widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
    }
    /**
     * Get widget icon.
     *
     * Retrieve icon box widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
    }
    protected function is_dynamic_content(): bool
    {
    }
    public function has_widget_inner_wrapper(): bool
    {
    }
    /**
     * Get style dependencies.
     *
     * Retrieve the list of style dependencies the widget requires.
     *
     * @since 3.24.0
     * @access public
     *
     * @return array Widget style dependencies.
     */
    public function get_style_depends(): array
    {
    }
    /**
     * Register icon box widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    /**
     * Render icon box widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
    }
    /**
     * Render icon box widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template()
    {
    }
    public function on_import($element)
    {
    }
}
/**
 * Elementor icon list widget.
 *
 * Elementor widget that displays a bullet list with any chosen icons and texts.
 *
 * @since 1.0.0
 */
class Widget_Icon_List extends \Elementor\Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve icon list widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
    }
    /**
     * Get widget title.
     *
     * Retrieve icon list widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
    }
    /**
     * Get widget icon.
     *
     * Retrieve icon list widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
    }
    protected function is_dynamic_content(): bool
    {
    }
    public function has_widget_inner_wrapper(): bool
    {
    }
    /**
     * Get style dependencies.
     *
     * Retrieve the list of style dependencies the widget requires.
     *
     * @since 3.24.0
     * @access public
     *
     * @return array Widget style dependencies.
     */
    public function get_style_depends(): array
    {
    }
    /**
     * Register icon list widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    /**
     * Render icon list widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
    }
    /**
     * Render icon list widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template()
    {
    }
    public function on_import($element)
    {
    }
}
/**
 * Elementor icon widget.
 *
 * Elementor widget that displays an icon from over 600+ icons.
 *
 * @since 1.0.0
 */
class Widget_Icon extends \Elementor\Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve icon widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
    }
    /**
     * Get widget title.
     *
     * Retrieve icon widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
    }
    /**
     * Get widget icon.
     *
     * Retrieve icon widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
    }
    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the icon widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @since 2.0.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
    }
    public function has_widget_inner_wrapper(): bool
    {
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
    }
    protected function is_dynamic_content(): bool
    {
    }
    /**
     * Register icon widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    /**
     * Render icon widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
    }
    /**
     * Render icon widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template()
    {
    }
}
/**
 * Elementor image box widget.
 *
 * Elementor widget that displays an image, a headline and a text.
 *
 * @since 1.0.0
 */
class Widget_Image_Box extends \Elementor\Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve image box widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
    }
    /**
     * Get widget title.
     *
     * Retrieve image box widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
    }
    /**
     * Get widget icon.
     *
     * Retrieve image box widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
    }
    protected function is_dynamic_content(): bool
    {
    }
    /**
     * Get style dependencies.
     *
     * Retrieve the list of style dependencies the widget requires.
     *
     * @since 3.24.0
     * @access public
     *
     * @return array Widget style dependencies.
     */
    public function get_style_depends(): array
    {
    }
    public function has_widget_inner_wrapper(): bool
    {
    }
    /**
     * Register image box widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    /**
     * Render image box widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
    }
    /**
     * Render image box widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template()
    {
    }
}
/**
 * Elementor image carousel widget.
 *
 * Elementor widget that displays a set of images in a rotating carousel or
 * slider.
 *
 * @since 1.0.0
 */
class Widget_Image_Carousel extends \Elementor\Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve image carousel widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
    }
    /**
     * Get widget title.
     *
     * Retrieve image carousel widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
    }
    /**
     * Get widget icon.
     *
     * Retrieve image carousel widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
    }
    protected function is_dynamic_content(): bool
    {
    }
    /**
     * Get style dependencies.
     *
     * Retrieve the list of style dependencies the widget requires.
     *
     * @since 3.24.0
     * @access public
     *
     * @return array Widget style dependencies.
     */
    public function get_style_depends(): array
    {
    }
    /**
     * Get script dependencies.
     *
     * Retrieve the list of script dependencies the widget requires.
     *
     * @since 3.27.0
     * @access public
     *
     * @return array Widget script dependencies.
     */
    public function get_script_depends(): array
    {
    }
    public function has_widget_inner_wrapper(): bool
    {
    }
    /**
     * Get widget upsale data.
     *
     * Retrieve the widget promotion data.
     *
     * @since 3.18.0
     * @access protected
     *
     * @return array Widget promotion data.
     */
    protected function get_upsale_data()
    {
    }
    /**
     * Register image carousel widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    /**
     * Render image carousel widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
    }
}
/**
 * Elementor image gallery widget.
 *
 * Elementor widget that displays a set of images in an aligned grid.
 *
 * @since 1.0.0
 */
class Widget_Image_Gallery extends \Elementor\Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve image gallery widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
    }
    /**
     * Get widget title.
     *
     * Retrieve image gallery widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
    }
    /**
     * Get widget icon.
     *
     * Retrieve image gallery widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
    }
    protected function is_dynamic_content(): bool
    {
    }
    /**
     * Get style dependencies.
     *
     * Retrieve the list of style dependencies the widget requires.
     *
     * @since 3.24.0
     * @access public
     *
     * @return array Widget style dependencies.
     */
    public function get_style_depends(): array
    {
    }
    /**
     * Get widget upsale data.
     *
     * Retrieve the widget promotion data.
     *
     * @since 3.18.0
     * @access protected
     *
     * @return array Widget promotion data.
     */
    protected function get_upsale_data()
    {
    }
    public function has_widget_inner_wrapper(): bool
    {
    }
    /**
     * Register image gallery widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    /**
     * Render image gallery widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
    }
}
/**
 * Elementor image widget.
 *
 * Elementor widget that displays an image into the page.
 *
 * @since 1.0.0
 */
class Widget_Image extends \Elementor\Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve image widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
    }
    /**
     * Get widget title.
     *
     * Retrieve image widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
    }
    /**
     * Get widget icon.
     *
     * Retrieve image widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
    }
    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the image widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @since 2.0.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
    }
    protected function is_dynamic_content(): bool
    {
    }
    /**
     * Get style dependencies.
     *
     * Retrieve the list of style dependencies the widget requires.
     *
     * @since 3.24.0
     * @access public
     *
     * @return array Widget style dependencies.
     */
    public function get_style_depends(): array
    {
    }
    public function has_widget_inner_wrapper(): bool
    {
    }
    /**
     * Register image widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    /**
     * Render image widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
    }
    /**
     * Render image widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template()
    {
    }
    /**
     * Retrieve image widget link URL.
     *
     * @since 3.11.0
     * @access protected
     *
     * @param array $settings
     *
     * @return array|string|false An array/string containing the link URL, or false if no link.
     */
    protected function get_link_url($settings)
    {
    }
}
/**
 * Elementor Inner Section widget.
 *
 * Elementor widget that creates nested columns within a section.
 *
 * @since 3.5.0
 */
class Widget_Inner_Section extends \Elementor\Widget_Base
{
    /**
     * @inheritDoc
     */
    public static function get_type()
    {
    }
    /**
     * @inheritDoc
     */
    public function get_name()
    {
    }
    /**
     * @inheritDoc
     */
    public function get_title()
    {
    }
    /**
     * @inheritDoc
     */
    public function get_icon()
    {
    }
    /**
     * @inheritDoc
     */
    public function get_categories()
    {
    }
    /**
     * @inheritDoc
     */
    public function get_keywords()
    {
    }
    protected function is_dynamic_content(): bool
    {
    }
}
/**
 * Elementor menu anchor widget.
 *
 * Elementor widget that allows to link and menu to a specific position on the
 * page.
 *
 * @since 1.0.0
 */
class Widget_Menu_Anchor extends \Elementor\Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve menu anchor widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
    }
    /**
     * Get widget title.
     *
     * Retrieve menu anchor widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
    }
    /**
     * Get widget icon.
     *
     * Retrieve menu anchor widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
    }
    protected function is_dynamic_content(): bool
    {
    }
    /**
     * Get style dependencies.
     *
     * Retrieve the list of style dependencies the widget requires.
     *
     * @since 3.24.0
     * @access public
     *
     * @return array Widget style dependencies.
     */
    public function get_style_depends(): array
    {
    }
    public function has_widget_inner_wrapper(): bool
    {
    }
    /**
     * Register menu anchor widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    /**
     * Render menu anchor widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
    }
    /**
     * Render menu anchor widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template()
    {
    }
    protected function on_save(array $settings)
    {
    }
}
/**
 * Elementor progress widget.
 *
 * Elementor widget that displays an escalating progress bar.
 *
 * @since 1.0.0
 */
class Widget_Progress extends \Elementor\Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve progress widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
    }
    /**
     * Get widget title.
     *
     * Retrieve progress widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
    }
    /**
     * Get widget icon.
     *
     * Retrieve progress widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
    }
    protected function is_dynamic_content(): bool
    {
    }
    /**
     * Get style dependencies.
     *
     * Retrieve the list of style dependencies the widget requires.
     *
     * @since 3.24.0
     * @access public
     *
     * @return array Widget style dependencies.
     */
    public function get_style_depends(): array
    {
    }
    public function has_widget_inner_wrapper(): bool
    {
    }
    /**
     * Register progress widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    /**
     * Render progress widget output on the frontend.
     * Make sure value does no exceed 100%.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
    }
    /**
     * Render progress widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template()
    {
    }
}
/**
 * Elementor (new) rating widget.
 *
 * @since 3.17.0
 */
class Widget_Rating extends \Elementor\Widget_Base
{
    public function get_name()
    {
    }
    public function get_title()
    {
    }
    public function get_icon()
    {
    }
    public function get_keywords()
    {
    }
    protected function is_dynamic_content(): bool
    {
    }
    public function get_style_depends(): array
    {
    }
    public function has_widget_inner_wrapper(): bool
    {
    }
    protected function register_controls()
    {
    }
    protected function get_rating_value(): float
    {
    }
    protected function get_rating_scale(): int
    {
    }
    protected function get_icon_marked_width($icon_index): string
    {
    }
    protected function get_icon_markup(): string
    {
    }
    protected function render()
    {
    }
}
/**
 * Elementor HTML widget.
 *
 * Elementor widget that insert a custom HTML code into the page.
 */
class Widget_Read_More extends \Elementor\Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve Read More widget name.
     *
     * @since 2.4.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
    }
    /**
     * Get widget title.
     *
     * Retrieve Read More widget title.
     *
     * @since 2.4.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
    }
    /**
     * Get widget icon.
     *
     * Retrieve Read More widget icon.
     *
     * @since 2.4.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.4.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
    }
    protected function is_dynamic_content(): bool
    {
    }
    public function has_widget_inner_wrapper(): bool
    {
    }
    /**
     * Register HTML widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    /**
     * Render Read More widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @access protected
     */
    protected function render()
    {
    }
    /**
     * Render Read More widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template()
    {
    }
}
/**
 * Elementor shortcode widget.
 *
 * Elementor widget that insert any shortcodes into the page.
 *
 * @since 1.0.0
 */
class Widget_Shortcode extends \Elementor\Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve shortcode widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
    }
    /**
     * Get widget title.
     *
     * Retrieve shortcode widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
    }
    /**
     * Get widget icon.
     *
     * Retrieve shortcode widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
    }
    /**
     * Whether the reload preview is required or not.
     *
     * Used to determine whether the reload preview is required.
     *
     * @since 1.0.0
     * @access public
     *
     * @return bool Whether the reload preview is required.
     */
    public function is_reload_preview_required()
    {
    }
    public function has_widget_inner_wrapper(): bool
    {
    }
    /**
     * Register shortcode widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    /**
     * Render shortcode widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
    }
    /**
     * Render shortcode widget as plain content.
     *
     * Override the default behavior by printing the shortcode instead of rendering it.
     *
     * @since 1.0.0
     * @access public
     */
    public function render_plain_content()
    {
    }
    /**
     * Render shortcode widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template()
    {
    }
}
/**
 * Elementor sidebar widget.
 *
 * Elementor widget that insert any sidebar into the page.
 *
 * @since 1.0.0
 */
class Widget_Sidebar extends \Elementor\Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve sidebar widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
    }
    /**
     * Get widget title.
     *
     * Retrieve sidebar widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
    }
    /**
     * Get widget icon.
     *
     * Retrieve sidebar widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
    }
    public function has_widget_inner_wrapper(): bool
    {
    }
    /**
     * Register sidebar widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    /**
     * Render sidebar widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
    }
    /**
     * Render sidebar widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template()
    {
    }
    /**
     * Render sidebar widget as plain content.
     *
     * Override the default render behavior, don't render sidebar content.
     *
     * @since 1.0.0
     * @access public
     */
    public function render_plain_content()
    {
    }
}
/**
 * Elementor social icons widget.
 *
 * Elementor widget that displays icons to social pages like Facebook and Twitter.
 *
 * @since 1.0.0
 */
class Widget_Social_Icons extends \Elementor\Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve social icons widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
    }
    /**
     * Get widget title.
     *
     * Retrieve social icons widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
    }
    /**
     * Get widget icon.
     *
     * Retrieve social icons widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
    }
    protected function is_dynamic_content(): bool
    {
    }
    /**
     * Get style dependencies.
     *
     * Retrieve the list of style dependencies the widget requires.
     *
     * @since 3.24.0
     * @access public
     *
     * @return array Widget style dependencies.
     */
    public function get_style_depends(): array
    {
    }
    public function has_widget_inner_wrapper(): bool
    {
    }
    /**
     * Register social icons widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    /**
     * Render social icons widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
    }
    /**
     * Render social icons widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template()
    {
    }
}
/**
 * Elementor spacer widget.
 *
 * Elementor widget that inserts a space that divides various elements.
 *
 * @since 1.0.0
 */
class Widget_Spacer extends \Elementor\Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve spacer widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
    }
    /**
     * Get widget title.
     *
     * Retrieve spacer widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
    }
    /**
     * Get widget icon.
     *
     * Retrieve spacer widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
    }
    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the spacer widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @since 1.0.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
    }
    protected function is_dynamic_content(): bool
    {
    }
    /**
     * Get style dependencies.
     *
     * Retrieve the list of style dependencies the widget requires.
     *
     * @since 3.24.0
     * @access public
     *
     * @return array Widget style dependencies.
     */
    public function get_style_depends(): array
    {
    }
    public function has_widget_inner_wrapper(): bool
    {
    }
    /**
     * Register spacer widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    /**
     * Render spacer widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
    }
    /**
     * Render spacer widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template()
    {
    }
}
/**
 * Elementor star rating widget.
 *
 * Elementor widget that displays star rating.
 *
 * @since 2.3.0
 */
class Widget_Star_Rating extends \Elementor\Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve star rating widget name.
     *
     * @since 2.3.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
    }
    /**
     * Get widget title.
     *
     * Retrieve star rating widget title.
     *
     * @since 2.3.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
    }
    /**
     * Get widget icon.
     *
     * Retrieve star rating widget icon.
     *
     * @since 2.3.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.3.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
    }
    protected function is_dynamic_content(): bool
    {
    }
    /**
     * Get style dependencies.
     *
     * Retrieve the list of style dependencies the widget requires.
     *
     * @since 3.24.0
     * @access public
     *
     * @return array Widget style dependencies.
     */
    public function get_style_depends(): array
    {
    }
    /**
     * Hide widget from panel.
     *
     * Hide the star rating widget from the panel.
     *
     * @since 3.17.0
     * @return bool
     */
    public function show_in_panel(): bool
    {
    }
    public function has_widget_inner_wrapper(): bool
    {
    }
    /**
     * Register star rating widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    /**
     * @since 2.3.0
     * @access protected
     */
    protected function get_rating()
    {
    }
    /**
     * Print the actual stars and calculate their filling.
     *
     * Rating type is float to allow stars-count to be a fraction.
     * Floored-rating type is int, to represent the rounded-down stars count.
     * In the `for` loop, the index type is float to allow comparing with the rating value.
     *
     * @since 2.3.0
     * @access protected
     */
    protected function render_stars($icon)
    {
    }
    /**
     * @since 2.3.0
     * @access protected
     */
    protected function render()
    {
    }
    /**
     * @since 2.9.0
     * @access protected
     */
    protected function content_template()
    {
    }
}
/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Widget_Tabs extends \Elementor\Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve tabs widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
    }
    /**
     * Get widget title.
     *
     * Retrieve tabs widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
    }
    /**
     * Get widget icon.
     *
     * Retrieve tabs widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
    }
    protected function is_dynamic_content(): bool
    {
    }
    /**
     * Get style dependencies.
     *
     * Retrieve the list of style dependencies the widget requires.
     *
     * @since 3.24.0
     * @access public
     *
     * @return array Widget style dependencies.
     */
    public function get_style_depends(): array
    {
    }
    public function show_in_panel(): bool
    {
    }
    public function has_widget_inner_wrapper(): bool
    {
    }
    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    /**
     * Render tabs widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
    }
    /**
     * Render tabs widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template()
    {
    }
}
/**
 * Elementor testimonial widget.
 *
 * Elementor widget that displays customer testimonials that show social proof.
 *
 * @since 1.0.0
 */
class Widget_Testimonial extends \Elementor\Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve testimonial widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
    }
    /**
     * Get widget title.
     *
     * Retrieve testimonial widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
    }
    /**
     * Get widget icon.
     *
     * Retrieve testimonial widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
    }
    protected function is_dynamic_content(): bool
    {
    }
    /**
     * Get style dependencies.
     *
     * Retrieve the list of style dependencies the widget requires.
     *
     * @since 3.24.0
     * @access public
     *
     * @return array Widget style dependencies.
     */
    public function get_style_depends(): array
    {
    }
    public function has_widget_inner_wrapper(): bool
    {
    }
    /**
     * Get widget upsale data.
     *
     * Retrieve the widget promotion data.
     *
     * @since 3.18.0
     * @access protected
     *
     * @return array Widget promotion data.
     */
    protected function get_upsale_data()
    {
    }
    /**
     * Register testimonial widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    /**
     * Render testimonial widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
    }
    /**
     * Render testimonial widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template()
    {
    }
    protected function render_testimonial_description()
    {
    }
}
/**
 * Elementor text editor widget.
 *
 * Elementor widget that displays a WYSIWYG text editor, just like the WordPress
 * editor.
 *
 * @since 1.0.0
 */
class Widget_Text_Editor extends \Elementor\Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve text editor widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
    }
    /**
     * Get widget title.
     *
     * Retrieve text editor widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
    }
    /**
     * Get widget icon.
     *
     * Retrieve text editor widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
    }
    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the text editor widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @since 2.0.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
    }
    /**
     * Get style dependencies.
     *
     * Retrieve the list of style dependencies the widget requires.
     *
     * The 'widget-text-editor' style is required only when the drop cap is used.
     * Therefor, style should not be loaded on the widget level, rather only on
     * control level when the drop cap is active.
     *
     * Only in the Editor, these style should be loaded on the widget level.
     *
     * @since 3.24.0
     * @access public
     *
     * @return array Widget style dependencies.
     */
    public function get_style_depends(): array
    {
    }
    public function has_widget_inner_wrapper(): bool
    {
    }
    /**
     * Register text editor widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    /**
     * Render text editor widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
    }
    /**
     * Render text editor widget as plain content.
     *
     * Override the default behavior by printing the content without rendering it.
     *
     * @since 1.0.0
     * @access public
     */
    public function render_plain_content()
    {
    }
    /**
     * Render text editor widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template()
    {
    }
}
/**
 * Elementor toggle widget.
 *
 * Elementor widget that displays a collapsible display of content in an toggle
 * style, allowing the user to open multiple items.
 *
 * @since 1.0.0
 */
class Widget_Toggle extends \Elementor\Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve toggle widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
    }
    /**
     * Get widget title.
     *
     * Retrieve toggle widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
    }
    /**
     * Get widget icon.
     *
     * Retrieve toggle widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
    }
    protected function is_dynamic_content(): bool
    {
    }
    /**
     * Get style dependencies.
     *
     * Retrieve the list of style dependencies the widget requires.
     *
     * @since 3.24.0
     * @access public
     *
     * @return array Widget style dependencies.
     */
    public function get_style_depends(): array
    {
    }
    /**
     * Hide widget from panel.
     *
     * Hide the toggle widget from the panel if nested-accordion experiment is active.
     *
     * @since 3.15.0
     * @return bool
     */
    public function show_in_panel(): bool
    {
    }
    public function has_widget_inner_wrapper(): bool
    {
    }
    /**
     * Register toggle widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    /**
     * Render toggle widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
    }
    /**
     * Render toggle widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template()
    {
    }
}
/**
 * Elementor video widget.
 *
 * Elementor widget that displays a video player.
 *
 * @since 1.0.0
 */
class Widget_Video extends \Elementor\Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve video widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
    }
    /**
     * Get widget title.
     *
     * Retrieve video widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
    }
    /**
     * Get widget icon.
     *
     * Retrieve video widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
    }
    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the video widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @since 2.0.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
    }
    protected function is_dynamic_content(): bool
    {
    }
    /**
     * Get style dependencies.
     *
     * Retrieve the list of style dependencies the widget requires.
     *
     * @since 3.24.0
     * @access public
     *
     * @return array Widget style dependencies.
     */
    public function get_style_depends(): array
    {
    }
    public function has_widget_inner_wrapper(): bool
    {
    }
    /**
     * Register video widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.19.0
     * @access protected
     *
     * @return array Widget promotion data.
     */
    protected function get_upsale_data()
    {
    }
    /**
     * Register video widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    public function print_a11y_text($image_overlay)
    {
    }
    /**
     * Render video widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
    }
    /**
     * Render video widget as plain content.
     *
     * Override the default behavior, by printing the video URL instead of rendering it.
     *
     * @since 1.4.5
     * @access public
     */
    public function render_plain_content()
    {
    }
    /**
     * Get embed params.
     *
     * Retrieve video widget embed parameters.
     *
     * @since 1.5.0
     * @access public
     *
     * @return array Video embed parameters.
     */
    public function get_embed_params()
    {
    }
    /**
     * Whether the video widget has an overlay image or not.
     *
     * Used to determine whether an overlay image was set for the video.
     *
     * @since 1.0.0
     * @access protected
     *
     * @return bool Whether an image overlay was set for the video.
     */
    protected function has_image_overlay()
    {
    }
}
/**
 * Elementor WordPress widget.
 *
 * Elementor widget that displays all the WordPress widgets.
 *
 * @since 1.0.0
 */
class Widget_WordPress extends \Elementor\Widget_Base
{
    public function hide_on_search()
    {
    }
    /**
     * Get widget name.
     *
     * Retrieve WordPress widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
    }
    /**
     * Get widget title.
     *
     * Retrieve WordPress widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
    }
    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the WordPress widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @since 1.0.0
     * @access public
     *
     * @return array Widget categories. Returns either a WordPress category.
     */
    public function get_categories()
    {
    }
    /**
     * Get widget icon.
     *
     * Retrieve WordPress widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon. Returns either a WordPress icon.
     */
    public function get_icon()
    {
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
    }
    /**
     * Get style dependencies.
     *
     * Retrieve the list of style dependencies the widget requires.
     *
     * @since 3.26.0
     * @access public
     *
     * @return array Widget style dependencies.
     */
    public function get_style_depends(): array
    {
    }
    /**
     * Get script dependencies.
     *
     * Retrieve the list of script dependencies the widget requires.
     *
     * @since 3.27.0
     * @access public
     *
     * @return array Widget script dependencies.
     */
    public function get_script_depends(): array
    {
    }
    public function get_help_url()
    {
    }
    /**
     * Whether the reload preview is required or not.
     *
     * Used to determine whether the reload preview is required.
     *
     * @since 1.0.0
     * @access public
     *
     * @return bool Whether the reload preview is required.
     */
    public function is_reload_preview_required()
    {
    }
    /**
     * Retrieve WordPress widget form.
     *
     * Returns the WordPress widget form, to be used in Elementor.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget form.
     */
    public function get_form()
    {
    }
    /**
     * Retrieve WordPress widget instance.
     *
     * Returns an instance of WordPress widget, to be used in Elementor.
     *
     * @since 1.0.0
     * @access public
     *
     * @return \WP_Widget
     */
    public function get_widget_instance()
    {
    }
    /**
     * Retrieve WordPress widget parsed settings.
     *
     * Returns the WordPress widget settings, to be used in Elementor.
     *
     * @access protected
     * @since 2.3.0
     *
     * @return array Parsed settings.
     */
    protected function get_init_settings()
    {
    }
    /**
     * Register WordPress widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    /**
     * Render WordPress widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
    }
    /**
     * Render WordPress widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template()
    {
    }
    /**
     * WordPress widget constructor.
     *
     * Used to run WordPress widget constructor.
     *
     * @since 1.0.0
     * @access public
     *
     * @param array $data Widget data. Default is an empty array.
     * @param array $args Widget arguments. Default is null.
     */
    public function __construct($data = [], $args = null)
    {
    }
    /**
     * Render WordPress widget as plain content.
     *
     * Override the default render behavior, don't render widget content.
     *
     * @since 1.0.0
     * @access public
     *
     * @param array $instance Widget instance. Default is empty array.
     */
    public function render_plain_content($instance = [])
    {
    }
}
/**
 * Elementor column element.
 *
 * Elementor column handler class is responsible for initializing the column
 * element.
 *
 * @since 1.0.0
 */
class Element_Column extends \Elementor\Element_Base
{
    /**
     * Get column name.
     *
     * Retrieve the column name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Column name.
     */
    public function get_name()
    {
    }
    /**
     * Get element type.
     *
     * Retrieve the element type, in this case `column`.
     *
     * @since 2.1.0
     * @access public
     * @static
     *
     * @return string The type.
     */
    public static function get_type()
    {
    }
    /**
     * Get column title.
     *
     * Retrieve the column title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Column title.
     */
    public function get_title()
    {
    }
    /**
     * Get column icon.
     *
     * Retrieve the column icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Column icon.
     */
    public function get_icon()
    {
    }
    protected function is_dynamic_content(): bool
    {
    }
    /**
     * Get initial config.
     *
     * Retrieve the current section initial configuration.
     *
     * Adds more configuration on top of the controls list, the tabs assigned to
     * the control, element name, type, icon and more. This method also adds
     * section presets.
     *
     * @since 2.9.0
     * @access protected
     *
     * @return array The initial config.
     */
    protected function get_initial_config()
    {
    }
    /**
     * Register column controls.
     *
     * Used to add new controls to the column element.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    /**
     * Render column output in the editor.
     *
     * Used to generate the live preview, using a Backbone JavaScript template.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template()
    {
    }
    /**
     * Before column rendering.
     *
     * Used to add stuff before the column element.
     *
     * @since 1.0.0
     * @access public
     */
    public function before_render()
    {
    }
    /**
     * After column rendering.
     *
     * Used to add stuff after the column element.
     *
     * @since 1.0.0
     * @access public
     */
    public function after_render()
    {
    }
    /**
     * Add column render attributes.
     *
     * Used to add attributes to the current column wrapper HTML tag.
     *
     * @since 1.3.0
     * @access protected
     */
    protected function add_render_attributes()
    {
    }
    /**
     * Get default child type.
     *
     * Retrieve the column child type based on element data.
     *
     * @since 1.0.0
     * @access protected
     *
     * @param array $element_data Element ID.
     *
     * @return Element_Base|false Column default child type.
     */
    protected function _get_default_child_type(array $element_data)
    {
    }
}
namespace Elementor\Includes\Elements;

class Container extends \Elementor\Element_Base
{
    protected function is_dynamic_content(): bool
    {
    }
    /**
     * Container constructor.
     *
     * @param array      $data
     * @param array|null $args
     *
     * @return void
     */
    public function __construct(array $data = [], ?array $args = null)
    {
    }
    /**
     * Get the element type.
     *
     * @return string
     */
    public static function get_type()
    {
    }
    /**
     * Get the element name.
     *
     * @return string
     */
    public function get_name()
    {
    }
    /**
     * Get the element display name.
     *
     * @return string
     */
    public function get_title()
    {
    }
    /**
     * Get the element display icon.
     *
     * @return string
     */
    public function get_icon()
    {
    }
    public function get_keywords()
    {
    }
    public function get_panel_presets()
    {
    }
    /**
     * Override the render attributes to add a custom wrapper class.
     *
     * @return void
     */
    protected function add_render_attributes()
    {
    }
    /**
     * Override the initial element config to display the Container in the panel.
     *
     * @return array
     */
    protected function get_initial_config()
    {
    }
    /**
     * Render the element JS template.
     *
     * @return void
     */
    protected function content_template()
    {
    }
    /**
     * Render the video background markup.
     *
     * @return void
     */
    protected function render_video_background()
    {
    }
    /**
     * Render the Container's shape divider.
     * TODO: Copied from `section.php`.
     *
     * Used to generate the shape dividers HTML.
     *
     * @param string $side - Shape divider side, used to set the shape key.
     *
     * @return void
     */
    protected function render_shape_divider($side)
    {
    }
    /**
     * Print safe HTML tag for the element based on the element settings.
     *
     * @return void
     */
    protected function print_html_tag()
    {
    }
    /**
     * Before rendering the container content. (Print the opening tag, etc.)
     *
     * @return void
     */
    public function before_render()
    {
    }
    /**
     * After rendering the Container content. (Print the closing tag, etc.)
     *
     * @return void
     */
    public function after_render()
    {
    }
    protected function is_boxed_container(array $settings)
    {
    }
    /**
     * Override the default child type to allow widgets & containers as children.
     *
     * @param array $element_data
     *
     * @return \Elementor\Element_Base|\Elementor\Widget_Base|null
     */
    protected function _get_default_child_type(array $element_data)
    {
    }
    /**
     * Register the Container's layout controls.
     *
     * @return void
     */
    protected function register_container_layout_controls()
    {
    }
    /**
     * Register the Container's items layout controls.
     *
     * @return void
     */
    protected function register_items_layout_controls()
    {
    }
    /**
     * Register the Container's layout tab.
     *
     * @return void
     */
    protected function register_layout_tab()
    {
    }
    /**
     * Register the Container's background controls.
     *
     * @return void
     */
    protected function register_background_controls()
    {
    }
    /**
     * Register the Container's background overlay controls.
     *
     * @return void
     */
    protected function register_background_overlay_controls()
    {
    }
    /**
     * Register the Container's border controls.
     *
     * @return void
     */
    protected function register_border_controls()
    {
    }
    /**
     * Register the Container's shape dividers controls.
     * TODO: Copied from `section.php`.
     *
     * @return void
     */
    protected function register_shape_dividers_controls()
    {
    }
    /**
     * Register the Container's style tab.
     *
     * @return void
     */
    protected function register_style_tab()
    {
    }
    /**
     * Register the Container's advanced style controls.
     *
     * @return void
     */
    protected function register_advanced_controls()
    {
    }
    /**
     * Register the Container's motion effects controls.
     *
     * @return void
     */
    protected function register_motion_effects_controls()
    {
    }
    /**
     * Register the Container's responsive controls.
     *
     * @return void
     */
    protected function register_responsive_controls()
    {
    }
    /**
     * Register the Container's advanced tab.
     *
     * @return void
     */
    protected function register_advanced_tab()
    {
    }
    protected function hook_sticky_notice_into_transform_section()
    {
    }
    /**
     * Register the Container's controls.
     *
     * @return void
     */
    protected function register_controls()
    {
    }
    public function on_import($element)
    {
    }
    /**
     * Convert slider to gaps control for the 3.16 upgrade script
     *
     * @param array $element
     * @return array
     */
    public static function slider_to_gaps_converter($element)
    {
    }
}
namespace Elementor;

/**
 * Elementor repeater element.
 *
 * Elementor repeater handler class is responsible for initializing the repeater.
 *
 * @since 1.0.0
 */
class Repeater extends \Elementor\Element_Base
{
    /**
     * Repeater constructor.
     *
     * Initializing Elementor repeater element.
     *
     * @since 1.0.7
     * @access public
     *
     * @param array      $data Optional. Element data. Default is an empty array.
     * @param array|null $args Optional. Element default arguments. Default is null.
     */
    public function __construct(array $data = [], ?array $args = null)
    {
    }
    /**
     * Get repeater name.
     *
     * Retrieve the repeater name.
     *
     * @since 1.0.7
     * @access public
     *
     * @return string Repeater name.
     */
    public function get_name()
    {
    }
    /**
     * Get repeater type.
     *
     * Retrieve the repeater type.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @return string Repeater type.
     */
    public static function get_type()
    {
    }
    /**
     * Add new repeater control to stack.
     *
     * Register a repeater control to allow the user to set/update data.
     *
     * This method should be used inside `register_controls()`.
     *
     * @since 1.0.0
     * @access public
     *
     * @param string $id      Repeater control ID.
     * @param array  $args    Repeater control arguments.
     * @param array  $options Optional. Repeater control options. Default is an
     *                        empty array.
     *
     * @return bool True if repeater control added, False otherwise.
     */
    public function add_control($id, array $args, $options = [])
    {
    }
    /**
     * Get repeater fields.
     *
     * Retrieve the fields from the current repeater control.
     *
     * @since 1.5.0
     * @deprecated 2.1.0 Use `get_controls()` method instead.
     * @access public
     *
     * @return array Repeater fields.
     */
    public function get_fields()
    {
    }
    /**
     * Get default child type.
     *
     * Retrieve the repeater child type based on element data.
     *
     * Note that repeater does not support children, therefore it returns false.
     *
     * @since 1.0.0
     * @access protected
     *
     * @param array $element_data Element ID.
     *
     * @return false Repeater default child type or False if type not found.
     */
    protected function _get_default_child_type(array $element_data)
    {
    }
    protected function handle_control_position(array $args, $control_id, $overwrite)
    {
    }
}
/**
 * Elementor section element.
 *
 * Elementor section handler class is responsible for initializing the section
 * element.
 *
 * @since 1.0.0
 */
class Element_Section extends \Elementor\Element_Base
{
    /**
     * Get element type.
     *
     * Retrieve the element type, in this case `section`.
     *
     * @since 2.1.0
     * @access public
     * @static
     *
     * @return string The type.
     */
    public static function get_type()
    {
    }
    /**
     * Get section name.
     *
     * Retrieve the section name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Section name.
     */
    public function get_name()
    {
    }
    /**
     * Get section title.
     *
     * Retrieve the section title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Section title.
     */
    public function get_title()
    {
    }
    /**
     * Get section icon.
     *
     * Retrieve the section icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Section icon.
     */
    public function get_icon()
    {
    }
    protected function is_dynamic_content(): bool
    {
    }
    /**
     * Get presets.
     *
     * Retrieve a specific preset columns for a given columns count, or a list
     * of all the preset if no parameters passed.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @param int $columns_count Optional. Columns count. Default is null.
     * @param int $preset_index  Optional. Preset index. Default is null.
     *
     * @return array Section presets.
     */
    public static function get_presets($columns_count = null, $preset_index = null)
    {
    }
    /**
     * Initialize presets.
     *
     * Initializing the section presets and set the number of columns the
     * section can have by default. For example a column can have two columns
     * 50% width each one, or three columns 33.33% each one.
     *
     * Note that Elementor sections have default section presets but the user
     * can set custom number of columns and define custom sizes for each column.
     * @since 1.0.0
     * @access public
     * @static
     */
    public static function init_presets()
    {
    }
    /**
     * Get initial config.
     *
     * Retrieve the current section initial configuration.
     *
     * Adds more configuration on top of the controls list, the tabs assigned to
     * the control, element name, type, icon and more. This method also adds
     * section presets.
     *
     * @since 2.9.0
     * @access protected
     *
     * @return array The initial config.
     */
    protected function get_initial_config()
    {
    }
    /**
     * Register section controls.
     *
     * Used to add new controls to the section element.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    /**
     * Render section output in the editor.
     *
     * Used to generate the live preview, using a Backbone JavaScript template.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template()
    {
    }
    /**
     * Before section rendering.
     *
     * Used to add stuff before the section element.
     *
     * @since 1.0.0
     * @access public
     */
    public function before_render()
    {
    }
    /**
     * After section rendering.
     *
     * Used to add stuff after the section element.
     *
     * @since 1.0.0
     * @access public
     */
    public function after_render()
    {
    }
    /**
     * Add section render attributes.
     *
     * Used to add attributes to the current section wrapper HTML tag.
     *
     * @since 1.3.0
     * @access protected
     */
    protected function add_render_attributes()
    {
    }
    /**
     * Get default child type.
     *
     * Retrieve the section child type based on element data.
     *
     * @since 1.0.0
     * @access protected
     *
     * @param array $element_data Element ID.
     *
     * @return Element_Base Section default child type.
     */
    protected function _get_default_child_type(array $element_data)
    {
    }
    /**
     * Get HTML tag.
     *
     * Retrieve the section element HTML tag.
     *
     * @since 1.5.3
     * @access private
     *
     * @return string Section HTML tag.
     */
    protected function get_html_tag()
    {
    }
    /**
     * Print section shape divider.
     *
     * Used to generate the shape dividers HTML.
     *
     * @since 1.3.0
     * @access private
     *
     * @param string $side Shape divider side, used to set the shape key.
     */
    protected function print_shape_divider($side)
    {
    }
}
namespace Elementor\Core\Base;

/**
 * Elementor module.
 *
 * An abstract class that provides the needed properties and methods to
 * manage and handle modules in inheriting classes.
 *
 * @since 1.7.0
 * @abstract
 */
abstract class Module extends \Elementor\Core\Base\Base_Object
{
    /**
     * Module instance.
     *
     * Holds the module instance.
     *
     * @since 1.7.0
     * @access protected
     *
     * @var Module
     */
    protected static $_instances = [];
    /**
     * Get module name.
     *
     * Retrieve the module name.
     *
     * @since 1.7.0
     * @access public
     * @abstract
     *
     * @return string Module name.
     */
    abstract public function get_name();
    /**
     * Instance.
     *
     * Ensures only one instance of the module class is loaded or can be loaded.
     *
     * @since 1.7.0
     * @access public
     * @static
     *
     * @return $this An instance of the class.
     */
    public static function instance()
    {
    }
    /**
     * @since 2.0.0
     * @access public
     * @static
     */
    public static function is_active()
    {
    }
    /**
     * Class name.
     *
     * Retrieve the name of the class.
     *
     * @since 1.7.0
     * @access public
     * @static
     */
    public static function class_name()
    {
    }
    public static function get_experimental_data()
    {
    }
    /**
     * Clone.
     *
     * Disable class cloning and throw an error on object clone.
     *
     * The whole idea of the singleton design pattern is that there is a single
     * object. Therefore, we don't want the object to be cloned.
     *
     * @since 1.7.0
     * @access public
     */
    public function __clone()
    {
    }
    /**
     * Wakeup.
     *
     * Disable unserializing of the class.
     *
     * @since 1.7.0
     * @access public
     */
    public function __wakeup()
    {
    }
    /**
     * @since 2.0.0
     * @access public
     */
    public function get_reflection()
    {
    }
    /**
     * Add module component.
     *
     * Add new component to the current module.
     *
     * @since 1.7.0
     * @access public
     *
     * @param string $id       Component ID.
     * @param mixed  $instance An instance of the component.
     */
    public function add_component($id, $instance)
    {
    }
    /**
     * @since 2.3.0
     * @access public
     * @return Module[]
     */
    public function get_components()
    {
    }
    /**
     * Get module component.
     *
     * Retrieve the module component.
     *
     * @since 1.7.0
     * @access public
     *
     * @param string $id Component ID.
     *
     * @return mixed An instance of the component, or `false` if the component
     *               doesn't exist.
     */
    public function get_component($id)
    {
    }
    /**
     * Get assets url.
     *
     * @since 2.3.0
     * @access protected
     *
     * @param string $file_name
     * @param string $file_extension
     * @param string $relative_url Optional. Default is null.
     * @param string $add_min_suffix Optional. Default is 'default'.
     *
     * @return string
     */
    final protected function get_assets_url($file_name, $file_extension, $relative_url = null, $add_min_suffix = 'default')
    {
    }
    /**
     * Get js assets url
     *
     * @since 2.3.0
     * @access protected
     *
     * @param string $file_name
     * @param string $relative_url Optional. Default is null.
     * @param string $add_min_suffix Optional. Default is 'default'.
     *
     * @return string
     */
    final protected function get_js_assets_url($file_name, $relative_url = null, $add_min_suffix = 'default')
    {
    }
    /**
     * Get css assets url
     *
     * @since 2.3.0
     * @access protected
     *
     * @param string $file_name
     * @param string $relative_url         Optional. Default is null.
     * @param string $add_min_suffix       Optional. Default is 'default'.
     * @param bool   $add_direction_suffix Optional. Default is `false`.
     *
     * @return string
     */
    final protected function get_css_assets_url($file_name, $relative_url = null, $add_min_suffix = 'default', $add_direction_suffix = false)
    {
    }
    /**
     * Get Frontend File URL
     *
     * Returns the URL for the CSS file to be loaded in the front end. If requested via the second parameter, a custom
     * file is generated based on a passed template file name. Otherwise, the URL for the default CSS file is returned.
     *
     * @since 3.24.0
     *
     * @access public
     *
     * @param string  $file_name
     * @param boolean $has_custom_breakpoints
     *
     * @return string frontend file URL
     */
    public function get_frontend_file_url($file_name, $has_custom_breakpoints)
    {
    }
    /**
     * Get assets base url
     *
     * @since 2.6.0
     * @access protected
     *
     * @return string
     */
    protected function get_assets_base_url()
    {
    }
    /**
     * Get assets relative url
     *
     * @since 2.3.0
     * @access protected
     *
     * @return string
     */
    protected function get_assets_relative_url()
    {
    }
    /**
     * Get the module's associated widgets.
     *
     * @return string[]
     */
    protected function get_widgets()
    {
    }
    /**
     * Initialize the module related widgets.
     */
    public function init_widgets()
    {
    }
    public function __construct()
    {
    }
}
/**
 * Base App
 *
 * Base app utility class that provides shared functionality of apps.
 *
 * @since 2.3.0
 */
abstract class App extends \Elementor\Core\Base\Module
{
    /**
     * Print config.
     *
     * Used to print the app and its components settings as a JavaScript object.
     *
     * @param string $handle Optional
     *
     * @since 2.3.0
     * @since 2.6.0 added the `$handle` parameter
     * @access protected
     */
    final protected function print_config($handle = null)
    {
    }
}
namespace Elementor\Core\Base\BackgroundProcess;

/**
 * Link https://github.com/A5hleyRich/wp-background-processing GPL v2.0
 *
 * WP Async Request
 *
 * @package WP-Background-Processing
 */
/**
 * Abstract WP_Async_Request class.
 *
 * @abstract
 */
abstract class WP_Async_Request
{
    /**
     * Prefix
     *
     * (default value: 'wp')
     *
     * @var string
     * @access protected
     */
    protected $prefix = 'wp';
    /**
     * Action
     *
     * (default value: 'async_request')
     *
     * @var string
     * @access protected
     */
    protected $action = 'async_request';
    /**
     * Identifier
     *
     * @var mixed
     * @access protected
     */
    protected $identifier;
    /**
     * Data
     *
     * (default value: [])
     *
     * @var array
     * @access protected
     */
    protected $data = [];
    /**
     * Initiate new async request
     */
    public function __construct()
    {
    }
    /**
     * Set data used during the request
     *
     * @param array $data Data.
     *
     * @return $this
     */
    public function data($data)
    {
    }
    /**
     * Dispatch the async request
     *
     * @return array|\WP_Error
     */
    public function dispatch()
    {
    }
    /**
     * Get query args
     *
     * @return array
     */
    protected function get_query_args()
    {
    }
    /**
     * Get query URL
     *
     * @return string
     */
    protected function get_query_url()
    {
    }
    /**
     * Get post args
     *
     * @return array
     */
    protected function get_post_args()
    {
    }
    /**
     * Maybe handle
     *
     * Check for correct nonce and pass to handler.
     */
    public function maybe_handle()
    {
    }
    /**
     * Handle
     *
     * Override this method to perform any actions required
     * during the async request.
     */
    abstract protected function handle();
}
/**
 * Link https://github.com/A5hleyRich/wp-background-processing GPL v2.0.
 *
 * WP Background Process
 *
 * @package WP-Background-Processing
 */
/**
 * Abstract WP_Background_Process class.
 *
 * @abstract
 * @extends WP_Async_Request
 */
abstract class WP_Background_Process extends \Elementor\Core\Base\BackgroundProcess\WP_Async_Request
{
    /**
     * Action
     *
     * (default value: 'background_process')
     *
     * @var string
     * @access protected
     */
    protected $action = 'background_process';
    /**
     * Start time of current process.
     *
     * (default value: 0)
     *
     * @var int
     * @access protected
     */
    protected $start_time = 0;
    /**
     * Cron_hook_identifier
     *
     * @var mixed
     * @access protected
     */
    protected $cron_hook_identifier;
    /**
     * Cron_interval_identifier
     *
     * @var mixed
     * @access protected
     */
    protected $cron_interval_identifier;
    /**
     * Initiate new background process
     */
    public function __construct()
    {
    }
    /**
     * Dispatch
     *
     * @access public
     * @return array|\WP_Error
     */
    public function dispatch()
    {
    }
    /**
     * Maybe handle on shutdown
     *
     * Fallback handler for when HTTP loopback requests are blocked.
     * Flushes output to browser first, then processes the queue directly.
     *
     * @access public
     */
    public function maybe_handle_on_shutdown()
    {
    }
    /**
     * Push to queue
     *
     * @param mixed $data Data.
     *
     * @return $this
     */
    public function push_to_queue($data)
    {
    }
    /**
     * Save queue
     *
     * @return $this
     */
    public function save()
    {
    }
    /**
     * Update queue
     *
     * @param string $key Key.
     * @param array  $data Data.
     *
     * @return $this
     */
    public function update($key, $data)
    {
    }
    /**
     * Delete queue
     *
     * @param string $key Key.
     *
     * @return $this
     */
    public function delete($key)
    {
    }
    /**
     * Generate key
     *
     * Generates a unique key based on microtime. Queue items are
     * given a unique key so that they can be merged upon save.
     *
     * @param int $length Length.
     *
     * @return string
     */
    protected function generate_key($length = 64)
    {
    }
    /**
     * Maybe process queue
     *
     * Checks whether data exists within the queue and that
     * the process is not already running.
     */
    public function maybe_handle()
    {
    }
    /**
     * Is queue empty
     *
     * @return bool
     */
    protected function is_queue_empty()
    {
    }
    /**
     * Is process running
     *
     * Check whether the current process is already running
     * in a background process.
     */
    protected function is_process_running()
    {
    }
    /**
     * Lock process
     *
     * Lock the process so that multiple instances can't run simultaneously.
     * Override if applicable, but the duration should be greater than that
     * defined in the time_exceeded() method.
     */
    protected function lock_process()
    {
    }
    /**
     * Unlock process
     *
     * Unlock the process so that other instances can spawn.
     *
     * @return $this
     */
    protected function unlock_process()
    {
    }
    /**
     * Get batch
     *
     * @return \stdClass Return the first batch from the queue
     */
    protected function get_batch()
    {
    }
    /**
     * Handle
     *
     * Pass each queue item to the task handler, while remaining
     * within server memory and time limit constraints.
     */
    protected function handle()
    {
    }
    /**
     * Memory exceeded
     *
     * Ensures the batch process never exceeds 90%
     * of the maximum WordPress memory.
     *
     * @return bool
     */
    protected function memory_exceeded()
    {
    }
    /**
     * Get memory limit
     *
     * @return int
     */
    protected function get_memory_limit()
    {
    }
    /**
     * Time exceeded.
     *
     * Ensures the batch never exceeds a sensible time limit.
     * A timeout limit of 30s is common on shared hosting.
     *
     * @return bool
     */
    protected function time_exceeded()
    {
    }
    /**
     * Complete.
     *
     * Override if applicable, but ensure that the below actions are
     * performed, or, call parent::complete().
     */
    protected function complete()
    {
    }
    /**
     * Schedule cron healthcheck
     *
     * @access public
     * @param mixed $schedules Schedules.
     * @return mixed
     */
    public function schedule_cron_healthcheck($schedules)
    {
    }
    /**
     * Handle cron healthcheck
     *
     * Restart the background process if not already running
     * and data exists in the queue.
     */
    public function handle_cron_healthcheck()
    {
    }
    /**
     * Schedule event
     */
    protected function schedule_event()
    {
    }
    /**
     * Clear scheduled event
     */
    protected function clear_scheduled_event()
    {
    }
    /**
     * Cancel Process
     *
     * Stop processing queue items, clear cronjob and delete batch.
     */
    public function cancel_process()
    {
    }
    /**
     * Task
     *
     * Override this method to perform any actions required on each
     * queue item. Return the modified item for further processing
     * in the next pass through. Or, return false to remove the
     * item from the queue.
     *
     * @param mixed $item Queue item to iterate over.
     *
     * @return mixed
     */
    abstract protected function task($item);
}
namespace Elementor\Core\Base;

abstract class Background_Task_Manager extends \Elementor\Core\Base\Module
{
    /**
     * @var Background_Task
     */
    protected $task_runner;
    abstract public function get_action();
    abstract public function get_plugin_name();
    abstract public function get_plugin_label();
    abstract public function get_task_runner_class();
    abstract public function get_query_limit();
    abstract protected function start_run();
    public function on_runner_start()
    {
    }
    public function on_runner_complete($did_tasks = false)
    {
    }
    public function get_task_runner()
    {
    }
    /**
     * @param $flag
     * @return void
     * // TODO: Replace with a db settings system.
     */
    protected function add_flag($flag)
    {
    }
    protected function get_flag($flag)
    {
    }
    protected function delete_flag($flag)
    {
    }
    protected function get_start_action_url()
    {
    }
    protected function get_continue_action_url()
    {
    }
    public function __construct()
    {
    }
}
/**
 * WC_Background_Process class.
 */
abstract class Background_Task extends \Elementor\Core\Base\BackgroundProcess\WP_Background_Process
{
    protected $current_item;
    /**
     * Dispatch updater.
     *
     * Updater will still run via cron job if this fails for any reason.
     */
    public function dispatch()
    {
    }
    public function query_col($sql)
    {
    }
    public function should_run_again($updated_rows)
    {
    }
    public function get_current_offset()
    {
    }
    public function get_limit()
    {
    }
    public function set_total()
    {
    }
    /**
     * Complete
     *
     * Override if applicable, but ensure that the below actions are
     * performed, or, call parent::complete().
     */
    protected function complete()
    {
    }
    public function continue_run()
    {
    }
    /**
     * @return mixed
     */
    public function get_current_item()
    {
    }
    /**
     * Get batch.
     *
     * @return \stdClass Return the first batch from the queue.
     */
    protected function get_batch()
    {
    }
    /**
     * Handle cron healthcheck
     *
     * Restart the background process if not already running
     * and data exists in the queue.
     */
    public function handle_cron_healthcheck()
    {
    }
    /**
     * Schedule fallback event.
     */
    protected function schedule_event()
    {
    }
    /**
     * Is the updater running?
     *
     * @return boolean
     */
    public function is_running()
    {
    }
    /**
     * See if the batch limit has been exceeded.
     *
     * @return bool
     */
    protected function batch_limit_exceeded()
    {
    }
    /**
     * Handle.
     *
     * Pass each queue item to the task handler, while remaining
     * within server memory and time limit constraints.
     */
    protected function handle()
    {
    }
    /**
     * Use the protected `is_process_running` method as a public method.
     *
     * @return bool
     */
    public function is_process_locked()
    {
    }
    public function handle_immediately($callbacks)
    {
    }
    /**
     * Task
     *
     * Override this method to perform any actions required on each
     * queue item. Return the modified item for further processing
     * in the next pass through. Or, return false to remove the
     * item from the queue.
     *
     * @param array $item
     *
     * @return array|bool
     */
    protected function task($item)
    {
    }
    /**
     * Schedule cron healthcheck.
     *
     * @param array $schedules Schedules.
     * @return array
     */
    public function schedule_cron_healthcheck($schedules)
    {
    }
    /**
     * See if the batch limit has been exceeded.
     *
     * @return bool
     */
    public function is_memory_exceeded()
    {
    }
    /**
     * Delete all batches.
     *
     * @return self
     */
    public function delete_all_batches()
    {
    }
    /**
     * Kill process.
     *
     * Stop processing queue items, clear cronjob and delete all batches.
     */
    public function kill_process()
    {
    }
    public function set_current_item($item)
    {
    }
    protected function format_callback_log($item)
    {
    }
    /**
     * @var \Elementor\Core\Base\Background_Task_Manager
     */
    protected $manager;
    public function __construct($manager)
    {
    }
}
abstract class DB_Upgrades_Manager extends \Elementor\Core\Base\Background_Task_Manager
{
    protected $current_version = null;
    protected $query_limit = 100;
    abstract public function get_new_version();
    abstract public function get_version_option_name();
    abstract public function get_upgrades_class();
    abstract public function get_updater_label();
    public function get_task_runner_class()
    {
    }
    public function get_query_limit()
    {
    }
    public function set_query_limit($limit)
    {
    }
    public function get_current_version()
    {
    }
    public function should_upgrade()
    {
    }
    public function on_runner_start()
    {
    }
    public function on_runner_complete($did_tasks = false)
    {
    }
    protected function clear_cache()
    {
    }
    public function admin_notice_start_upgrade()
    {
    }
    public function admin_notice_upgrade_is_running()
    {
    }
    public function admin_notice_upgrade_is_completed()
    {
    }
    /**
     * @access protected
     */
    protected function start_run()
    {
    }
    protected function update_db_version()
    {
    }
    public function get_upgrade_callbacks()
    {
    }
    public function __construct()
    {
    }
}
/**
 * Elementor document.
 *
 * An abstract class that provides the needed properties and methods to
 * manage and handle documents in inheriting classes.
 *
 * @since 2.0.0
 * @abstract
 */
abstract class Document extends \Elementor\Controls_Stack
{
    /**
     * Document type meta key.
     */
    const TYPE_META_KEY = '_elementor_template_type';
    const PAGE_META_KEY = '_elementor_page_settings';
    const ELEMENTOR_DATA_META_KEY = '_elementor_data';
    const BUILT_WITH_ELEMENTOR_META_KEY = '_elementor_edit_mode';
    const CACHE_META_KEY = '_elementor_element_cache';
    /**
     * Document publish status.
     */
    const STATUS_PUBLISH = 'publish';
    /**
     * Document draft status.
     */
    const STATUS_DRAFT = 'draft';
    /**
     * Document private status.
     */
    const STATUS_PRIVATE = 'private';
    /**
     * Document autosave status.
     */
    const STATUS_AUTOSAVE = 'autosave';
    /**
     * Document pending status.
     */
    const STATUS_PENDING = 'pending';
    /**
     * Document post data.
     *
     * Holds the document post data.
     *
     * @since 2.0.0
     * @access protected
     *
     * @var \WP_Post WordPress post data.
     */
    protected $post;
    /**
     * @since 2.1.0
     * @access protected
     * @static
     */
    protected static function get_editor_panel_categories()
    {
    }
    /**
     * Get properties.
     *
     * Retrieve the document properties.
     *
     * @since 2.0.0
     * @access public
     * @static
     *
     * @return array Document properties.
     */
    public static function get_properties()
    {
    }
    /**
     * @since 2.1.0
     * @access public
     * @static
     */
    public static function get_editor_panel_config()
    {
    }
    public static function get_filtered_editor_panel_categories(): array
    {
    }
    /**
     * Get element title.
     *
     * Retrieve the element title.
     *
     * @since 2.0.0
     * @access public
     * @static
     *
     * @return string Element title.
     */
    public static function get_title()
    {
    }
    public static function get_plural_title()
    {
    }
    public static function get_add_new_title()
    {
    }
    /**
     * Get property.
     *
     * Retrieve the document property.
     *
     * @since 2.0.0
     * @access public
     * @static
     *
     * @param string $key The property key.
     *
     * @return mixed The property value.
     */
    public static function get_property($key)
    {
    }
    /**
     * @since 2.0.0
     * @access public
     * @static
     */
    public static function get_class_full_name()
    {
    }
    public static function get_create_url()
    {
    }
    public function get_name()
    {
    }
    /**
     * @since 2.0.0
     * @access public
     */
    public function get_unique_name()
    {
    }
    /**
     * @since 2.3.0
     * @access public
     */
    public function get_post_type_title()
    {
    }
    /**
     * @since 2.0.0
     * @access public
     */
    public function get_main_id()
    {
    }
    /**
     * @return null|\Elementor\Core\Behaviors\Interfaces\Lock_Behavior
     */
    public static function get_lock_behavior_v2()
    {
    }
    /**
     * @since 2.0.0
     * @access public
     *
     * @param $data
     *
     * @throws \Exception If the widget was not found.
     *
     * @return string
     */
    public function render_element($data)
    {
    }
    /**
     * @since 2.0.0
     * @access public
     */
    public function get_main_post()
    {
    }
    public function get_container_attributes()
    {
    }
    /**
     * @since 2.0.0
     * @access public
     */
    public function get_wp_preview_url()
    {
    }
    /**
     * @since 2.0.0
     * @access public
     */
    public function get_exit_to_dashboard_url()
    {
    }
    /**
     * Get All Post Type URL
     *
     * Get url of the page which display all the posts of the current active document's post type.
     *
     * @since 3.7.0
     *
     * @return string $url
     */
    public function get_all_post_type_url()
    {
    }
    /**
     * Get Main WP dashboard URL.
     *
     * @since 3.7.0
     *
     * @return string $url
     */
    protected function get_main_dashboard_url()
    {
    }
    /**
     * Get auto-saved post revision.
     *
     * Retrieve the auto-saved post revision that is newer than current post.
     *
     * @since 2.0.0
     * @access public
     *
     * @return bool|Document
     */
    public function get_newer_autosave()
    {
    }
    /**
     * @since 2.0.0
     * @access public
     */
    public function is_autosave()
    {
    }
    /**
     * Check if the current document is a 'revision'
     *
     * @return bool
     */
    public function is_revision()
    {
    }
    /**
     * Checks if the current document status is 'trash'.
     *
     * @return bool
     */
    public function is_trash()
    {
    }
    /**
     * @since 2.0.0
     * @access public
     *
     * @param int  $user_id
     * @param bool $create
     *
     * @return bool|Document
     */
    public function get_autosave($user_id = 0, $create = false)
    {
    }
    /**
     * Add/Remove edit link in dashboard.
     *
     * Add or remove an edit link to the post/page action links on the post/pages list table.
     *
     * Fired by `post_row_actions` and `page_row_actions` filters.
     *
     * @access public
     *
     * @param array $actions An array of row action links.
     *
     * @return array An updated array of row action links.
     */
    public function filter_admin_row_actions($actions)
    {
    }
    /**
     * @since 2.0.0
     * @access public
     */
    public function is_editable_by_current_user()
    {
    }
    /**
     * @since 2.9.0
     * @access protected
     */
    protected function get_initial_config()
    {
    }
    /**
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls()
    {
    }
    /**
     * @since 2.0.0
     * @access public
     *
     * @param $data
     *
     * @return bool
     */
    public function save($data)
    {
    }
    public function refresh_post()
    {
    }
    /**
     * @param array $new_settings
     *
     * @return static
     */
    public function update_settings(array $new_settings)
    {
    }
    /**
     * Is built with Elementor.
     *
     * Check whether the post was built with Elementor.
     *
     * @since 2.0.0
     * @access public
     *
     * @return bool Whether the post was built with Elementor.
     */
    public function is_built_with_elementor()
    {
    }
    /**
     * Mark the post as "built with elementor" or not.
     *
     * @param bool $is_built_with_elementor
     *
     * @return $this
     */
    public function set_is_built_with_elementor($is_built_with_elementor)
    {
    }
    /**
     * @since 2.0.0
     * @access public
     * @static
     *
     * @return mixed
     */
    public function get_edit_url()
    {
    }
    /**
     * @since 2.0.0
     * @access public
     */
    public function get_preview_url()
    {
    }
    /**
     * @since 2.0.0
     * @access public
     *
     * @param string $key
     *
     * @return array
     */
    public function get_json_meta($key)
    {
    }
    public function update_json_meta($key, $value)
    {
    }
    /**
     * @since 2.0.0
     * @access public
     *
     * @param null $data
     * @param bool $with_html_content
     *
     * @return array
     *
     * @throws \Exception If elements retrieval fails or data processing errors occur.
     */
    public function get_elements_raw_data($data = null, $with_html_content = false)
    {
    }
    /**
     * @since 2.0.0
     * @access public
     *
     * @param string $status
     *
     * @return array
     */
    public function get_elements_data($status = self::STATUS_PUBLISH)
    {
    }
    /**
     * Get document setting from DB.
     *
     * @return array
     */
    public function get_db_document_settings()
    {
    }
    /**
     * @since 2.3.0
     * @access public
     */
    public function convert_to_elementor()
    {
    }
    /**
     * @since 2.1.3
     * @access public
     */
    public function print_elements_with_wrapper($elements_data = null)
    {
    }
    /**
     * @since 2.0.0
     * @access public
     */
    public function get_css_wrapper_selector()
    {
    }
    /**
     * @since 2.0.0
     * @access public
     */
    public function get_panel_page_settings()
    {
    }
    /**
     * @since 2.0.0
     * @access public
     */
    public function get_post()
    {
    }
    /**
     * @since 2.0.0
     * @access public
     */
    public function get_permalink()
    {
    }
    /**
     * @since 2.0.8
     * @access public
     */
    public function get_content($with_css = false)
    {
    }
    /**
     * @since 2.0.0
     * @access public
     */
    public function delete()
    {
    }
    public function force_delete()
    {
    }
    /**
     * On import update dynamic content (e.g. post and term IDs).
     *
     * @since 3.8.0
     *
     * @param array      $config   The config of the passed element.
     * @param array      $data     The data that requires updating/replacement when imported.
     * @param array|null $controls The available controls.
     *
     * @return array Element data.
     */
    public static function on_import_update_dynamic_content(array $config, array $data, $controls = null): array
    {
    }
    /**
     * Update dynamic settings in the document for import.
     *
     * @param array $settings The settings of the document.
     * @param array $config Import config to update the settings.
     *
     * @return array
     */
    public function on_import_update_settings(array $settings, array $config): array
    {
    }
    /**
     * Save editor elements.
     *
     * Save data from the editor to the database.
     *
     * @since 2.0.0
     * @access protected
     *
     * @param array $elements
     */
    protected function save_elements($elements)
    {
    }
    /**
     * @since 2.0.0
     * @access public
     *
     * @param int $user_id Optional. User ID. Default value is `0`.
     *
     * @return bool|int
     */
    public function get_autosave_id($user_id = 0)
    {
    }
    public function save_version()
    {
    }
    /**
     * @since 2.3.0
     * @access public
     */
    public function save_template_type()
    {
    }
    /**
     * @since 2.3.0
     * @access public
     */
    public function get_template_type()
    {
    }
    /**
     * @since 2.0.0
     * @access public
     *
     * @param string $key Meta data key.
     *
     * @return mixed
     */
    public function get_main_meta($key)
    {
    }
    /**
     * @since 2.0.4
     * @access public
     *
     * @param string $key   Meta data key.
     * @param mixed  $value Meta data value.
     *
     * @return bool|int
     */
    public function update_main_meta($key, $value)
    {
    }
    /**
     * @since 2.0.4
     * @access public
     *
     * @param string $key   Meta data key.
     * @param string $value Optional. Meta data value. Default is an empty string.
     *
     * @return bool
     */
    public function delete_main_meta($key, $value = '')
    {
    }
    /**
     * @since 2.0.0
     * @access public
     *
     * @param string $key Meta data key.
     *
     * @return mixed
     */
    public function get_meta($key)
    {
    }
    /**
     * @since 2.0.0
     * @access public
     *
     * @param string $key   Meta data key.
     * @param mixed  $value Meta data value.
     *
     * @return bool|int
     */
    public function update_meta($key, $value)
    {
    }
    /**
     * @since 2.0.3
     * @access public
     *
     * @param string $key   Meta data key.
     * @param string $value Meta data value.
     *
     * @return bool
     */
    public function delete_meta($key, $value = '')
    {
    }
    /**
     * @since 2.0.0
     * @access public
     */
    public function get_last_edited()
    {
    }
    /**
     * @return bool
     */
    public function is_saving()
    {
    }
    /**
     * @param $is_saving
     *
     * @return $this
     */
    public function set_is_saving($is_saving)
    {
    }
    /**
     * @since 2.0.0
     * @access public
     *
     * @param array $data
     *
     * @throws \Exception If the post does not exist.
     */
    public function __construct(array $data = [])
    {
    }
    /**
     * Get Export Data
     *
     * Filters a document's data on export
     *
     * @since 3.2.0
     * @access public
     *
     * @return array The data to export
     */
    public function get_export_data()
    {
    }
    public function get_export_summary()
    {
    }
    /**
     * Get Import Data
     *
     * Filters a document's data on import
     *
     * @since 3.2.0
     * @access public
     *
     * @return array The data to import
     */
    public function get_import_data(array $data)
    {
    }
    /**
     * Import
     *
     * Allows to import an external data to a document
     *
     * @since 3.2.0
     * @access public
     *
     * @param array $data
     */
    public function import(array $data)
    {
    }
    public function process_element_import_export(\Elementor\Controls_Stack $element, $method, $element_data = null)
    {
    }
    protected function get_export_metadata()
    {
    }
    protected function get_remote_library_config()
    {
    }
    /**
     * @since 2.0.4
     * @access protected
     *
     * @param $settings
     */
    protected function save_settings($settings)
    {
    }
    /**
     * @since 2.1.3
     * @access public
     */
    public function print_elements($elements_data)
    {
    }
    protected function do_print_elements($elements_data)
    {
    }
    public function update_runtime_elements($elements_data = null)
    {
    }
    public function set_document_cache($value)
    {
    }
    protected function delete_cache()
    {
    }
    protected function register_document_controls()
    {
    }
    protected function get_post_statuses()
    {
    }
    protected function get_have_a_look_url()
    {
    }
    public function handle_revisions_changed($post_has_changed, $last_revision, $post)
    {
    }
    public function get_elementor_version()
    {
    }
}
namespace Elementor\Core\Base\Elements_Iteration_Actions;

abstract class Base
{
    /**
     * The current document that the Base class instance was created from.
     *
     * @var \Elementor\Core\Document
     */
    protected $document;
    /**
     * Indicates if the methods are being triggered on page save or at render time (value will be either 'save' or 'render').
     *
     * @var string
     */
    protected $mode = '';
    /**
     * Is Action Needed.
     *
     * Runs only at runtime and used as a flag to determine if all methods should run on page render.
     * If returns false, all methods will run only on page save.
     * If returns true, all methods will run on both page render and on save.
     *
     * @since 3.3.0
     * @access public
     *
     * @return bool
     */
    abstract public function is_action_needed();
    /**
     * Unique Element Action.
     *
     * Will be triggered for each unique page element - section / column / widget unique type (heading, icon etc.).
     *
     * @since 3.3.0
     * @access public
     *
     * @return void
     */
    public function unique_element_action(\Elementor\Element_Base $element_data)
    {
    }
    /**
     * Element Action.
     *
     * Will be triggered for each page element - section / column / widget.
     *
     * @since 3.3.0
     * @access public
     *
     * @return void
     */
    public function element_action(\Elementor\Element_Base $element_data)
    {
    }
    /**
     * After Elements Iteration.
     *
     * Will be triggered after all page elements iteration has ended.
     *
     * @since 3.3.0
     * @access public
     *
     * @return void
     */
    public function after_elements_iteration()
    {
    }
    public function set_mode($mode)
    {
    }
    public function __construct($document)
    {
    }
}
class Assets extends \Elementor\Core\Base\Elements_Iteration_Actions\Base
{
    const ASSETS_META_KEY = '_elementor_page_assets';
    public function element_action(\Elementor\Element_Base $element_data)
    {
    }
    public function is_action_needed()
    {
    }
    public function after_elements_iteration()
    {
    }
    public function __construct($document)
    {
    }
}
namespace Elementor\Core\Base\Providers;

class Social_Network_Provider
{
    public const FACEBOOK = 'Facebook';
    public const TWITTER = 'X (Twitter)';
    public const INSTAGRAM = 'Instagram';
    public const LINKEDIN = 'LinkedIn';
    public const PINTEREST = 'Pinterest';
    public const YOUTUBE = 'YouTube';
    public const TIKTOK = 'TikTok';
    public const WHATSAPP = 'WhatsApp';
    public const APPLEMUSIC = 'Apple Music';
    public const SPOTIFY = 'Spotify';
    public const SOUNDCLOUD = 'SoundCloud';
    public const BEHANCE = 'Behance';
    public const DRIBBBLE = 'Dribbble';
    public const VIMEO = 'Vimeo';
    public const WAZE = 'Waze';
    public const MESSENGER = 'Messenger';
    public const TELEPHONE = 'Telephone';
    public const EMAIL = 'Email';
    public const URL = 'Url';
    public const FILE_DOWNLOAD = 'File Download';
    public const SMS = 'SMS';
    public const VIBER = 'VIBER';
    public const SKYPE = 'Skype';
    public const VCF = 'Save contact (vCard)';
    public static function get_social_networks_icons(): array
    {
    }
    public static function get_icon_mapping(string $platform): string
    {
    }
    public static function get_name_mapping(string $platform): string
    {
    }
    public static function get_text_mapping(string $platform): string
    {
    }
    public static function get_social_networks_text($providers = []): array
    {
    }
    public static function build_messenger_link(string $username)
    {
    }
    public static function build_email_link(array $data, string $prefix)
    {
    }
    public static function build_viber_link(string $action, string $number)
    {
    }
}
namespace Elementor\Core\Base\Traits;

trait Shared_Widget_Controls_Trait
{
    protected $border_width_range = ['min' => 0, 'max' => 10, 'step' => 1];
    protected function add_html_tag_control(string $control_name, string $default_tag = 'h2'): void
    {
    }
    /**
     * Remove any child arrays where all properties are empty
     */
    protected function clean_array($input_array = [])
    {
    }
    protected function get_link_attributes($link = [], $other_attributes = [])
    {
    }
    protected function add_icons_per_row_control(string $name = 'icons_per_row', $options = ['2' => '2', '3' => '3'], string $default_value = '3', $label = '', $selector_custom_property = '--e-link-in-bio-icon-columns'): void
    {
    }
    protected function add_slider_control(string $name, array $args = []): void
    {
    }
    protected function add_borders_control(string $prefix, array $show_border_args = [], array $border_width_args = [], array $border_color_args = []): void
    {
    }
    protected function get_shape_divider($side = 'bottom')
    {
    }
    protected function print_shape_divider($side = 'bottom')
    {
    }
    protected function get_configured_breakpoints($add_desktop = 'true')
    {
    }
    protected function add_hover_animation_control(string $name, array $args = []): void
    {
    }
}
namespace Elementor;

/**
 * Elementor utils.
 *
 * Elementor utils handler class is responsible for different utility methods
 * used by Elementor.
 *
 * @since 1.0.0
 */
class Utils
{
    const DEPRECATION_RANGE = 0.4;
    const EDITOR_BREAK_LINES_OPTION_KEY = 'elementor_editor_break_lines';
    /**
     * A list of safe tags for `validate_html_tag` method.
     */
    const ALLOWED_HTML_WRAPPER_TAGS = ['a', 'article', 'aside', 'button', 'form', 'div', 'footer', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'header', 'main', 'nav', 'p', 'section', 'span'];
    const EXTENDED_ALLOWED_HTML_TAGS = ['iframe' => ['iframe' => ['allow' => true, 'allowfullscreen' => true, 'frameborder' => true, 'height' => true, 'loading' => true, 'name' => true, 'referrerpolicy' => true, 'sandbox' => true, 'src' => true, 'width' => true]], 'svg' => ['svg' => ['aria-hidden' => true, 'aria-labelledby' => true, 'class' => true, 'height' => true, 'role' => true, 'viewbox' => true, 'width' => true, 'xmlns' => true], 'g' => ['fill' => true], 'title' => ['title' => true], 'path' => ['d' => true, 'fill' => true]], 'image' => ['img' => ['srcset' => true, 'sizes' => true]]];
    /**
     * Variables for free to pro upsale modal promotions
     */
    const ANIMATED_HEADLINE = 'animated_headline';
    const CTA = 'cta';
    const VIDEO_PLAYLIST = 'video_playlist';
    const TESTIMONIAL_WIDGET = 'testimonial_widget';
    const IMAGE_CAROUSEL = 'image_carousel';
    /**
     * Whether WordPress CLI mode is enabled or not.
     *
     * @access public
     * @static
     *
     * @return bool
     */
    public static function is_wp_cli()
    {
    }
    /**
     * Whether script debug is enabled or not.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @return bool
     */
    public static function is_script_debug()
    {
    }
    /**
     * Whether Elementor debug is enabled or not.
     *
     * @access public
     * @static
     *
     * @return bool
     */
    public static function is_elementor_debug()
    {
    }
    /**
     * Whether Elementor test mode is enabled or not.
     *
     * @access public
     * @static
     *
     * @return bool
     */
    public static function is_elementor_tests()
    {
    }
    /**
     * Get pro link.
     *
     * Retrieve the link to Elementor Pro.
     *
     * @since 1.7.0
     * @access public
     * @static
     *
     * @param string $link URL to Elementor pro.
     *
     * @return string Elementor pro link.
     */
    public static function get_pro_link($link)
    {
    }
    /**
     * Replace URLs.
     *
     * Replace old URLs to new URLs. This method also updates all the Elementor data.
     *
     * @since 2.1.0
     * @static
     * @access public
     *
     * @param string $from
     * @param string $to
     *
     * @return string
     * @throws \Exception If URLs are missing or invalid URLs provided.
     */
    public static function replace_urls($from, $to)
    {
    }
    /**
     * Is post supports Elementor.
     *
     * Whether the post supports editing with Elementor.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @param int $post_id Optional. Post ID. Default is `0`.
     *
     * @return string True if post supports editing with Elementor, false otherwise.
     */
    public static function is_post_support($post_id = 0)
    {
    }
    /**
     * Is post type supports Elementor.
     *
     * Whether the post type supports editing with Elementor.
     *
     * @since 2.2.0
     * @access public
     * @static
     *
     * @param string $post_type Post Type.
     *
     * @return string True if post type supports editing with Elementor, false otherwise.
     */
    public static function is_post_type_support($post_type)
    {
    }
    /**
     * Get placeholder image source.
     *
     * Retrieve the source of the placeholder image.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @return string The source of the default placeholder image used by Elementor.
     */
    public static function get_placeholder_image_src()
    {
    }
    /**
     * Generate random string.
     *
     * Returns a string containing a hexadecimal representation of random number.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @return string Random string.
     */
    public static function generate_random_string()
    {
    }
    /**
     * Do not cache.
     *
     * Tell WordPress cache plugins not to cache this request.
     *
     * @since 1.0.0
     * @access public
     * @static
     */
    public static function do_not_cache()
    {
    }
    /**
     * Get timezone string.
     *
     * Retrieve timezone string from the WordPress database.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @return string Timezone string.
     */
    public static function get_timezone_string()
    {
    }
    /**
     * Get create new post URL.
     *
     * Retrieve a custom URL for creating a new post/page using Elementor.
     *
     * @since 1.9.0
     * @access public
     * @deprecated 3.3.0 Use `Plugin::$instance->documents->get_create_new_post_url()` instead.
     * @static
     *
     * @param string      $post_type Optional. Post type slug. Default is 'page'.
     * @param string|null $template_type Optional. Query arg 'template_type'. Default is null.
     *
     * @return string A URL for creating new post using Elementor.
     */
    public static function get_create_new_post_url($post_type = 'page', $template_type = null)
    {
    }
    /**
     * Get post autosave.
     *
     * Retrieve an autosave for any given post.
     *
     * @since 1.9.2
     * @access public
     * @static
     *
     * @param int $post_id Post ID.
     * @param int $user_id Optional. User ID. Default is `0`.
     *
     * @return \WP_Post|false Post autosave or false.
     */
    public static function get_post_autosave($post_id, $user_id = 0)
    {
    }
    /**
     * Is CPT supports custom templates.
     *
     * Whether the Custom Post Type supports templates.
     *
     * @since 2.0.0
     * @access public
     * @static
     *
     * @return bool True is templates are supported, False otherwise.
     */
    public static function is_cpt_custom_templates_supported()
    {
    }
    /**
     * @since 2.1.2
     * @access public
     * @static
     */
    public static function array_inject($base_array, $key, $insert)
    {
    }
    /**
     * Render html attributes
     *
     * @access public
     * @static
     * @param array $attributes
     *
     * @return string
     */
    public static function render_html_attributes(array $attributes)
    {
    }
    /**
     * Safe print html attributes
     *
     * @access public
     * @static
     * @param array $attributes
     */
    public static function print_html_attributes(array $attributes)
    {
    }
    public static function get_meta_viewport($context = '')
    {
    }
    /**
     * Add Elementor Config js vars to the relevant script handle,
     * WP will wrap it with <script> tag.
     * To make sure this script runs thru the `script_loader_tag` hook, use a known handle value.
     *
     * @param string $handle
     * @param string $js_var
     * @param mixed  $config
     */
    public static function print_js_config($handle, $js_var, $config)
    {
    }
    public static function handle_deprecation($item, $version, $replacement = null)
    {
    }
    /**
     * Checks a control value for being empty, including a string of '0' not covered by PHP's empty().
     *
     * @param mixed       $source
     * @param bool|string $key
     *
     * @return bool
     */
    public static function is_empty($source, $key = false)
    {
    }
    public static function has_pro()
    {
    }
    public static function is_pro_installed_and_not_active(): bool
    {
    }
    /**
     * Convert HTMLEntities to UTF-8 characters
     *
     * @param string $html_string
     * @return string
     */
    public static function urlencode_html_entities($html_string)
    {
    }
    /**
     * Parse attributes that come as a string of comma-delimited key|value pairs.
     * Removes Javascript events and unescaped `href` attributes.
     *
     * @param string $attributes_string
     *
     * @param string $delimiter Default comma `,`.
     *
     * @return array
     */
    public static function parse_custom_attributes($attributes_string, $delimiter = ',')
    {
    }
    public static function find_element_recursive($elements, $id)
    {
    }
    /**
     * Change Submenu First Item Label
     *
     * Overwrite the label of the first submenu item of an admin menu item.
     *
     * Fired by `admin_menu` action.
     *
     * @since 3.1.0
     *
     * @param string $menu_slug
     * @param string $new_label
     * @access public
     */
    public static function change_submenu_first_item_label($menu_slug, $new_label)
    {
    }
    /**
     * Validate an HTML tag against a safe allowed list.
     *
     * @param string $tag
     *
     * @return string
     */
    public static function validate_html_tag($tag)
    {
    }
    /**
     * Safe print a validated HTML tag.
     *
     * @param string $tag
     */
    public static function print_validated_html_tag($tag)
    {
    }
    /**
     * Print internal content (not user input) without escaping.
     */
    public static function print_unescaped_internal_string($internal_string)
    {
    }
    /**
     * Get recently edited posts query.
     *
     * Returns `WP_Query` of the recent edited posts.
     * By default max posts ( $args['posts_per_page'] ) is 3.
     *
     * @param array $args
     *
     * @return \WP_Query
     */
    public static function get_recently_edited_posts_query($args = [])
    {
    }
    public static function print_wp_kses_extended($text, array $tags)
    {
    }
    public static function is_elementor_path($path)
    {
    }
    /**
     * @param string $file
     * @param mixed  ...$args
     * @return false|string
     */
    public static function file_get_contents($file, ...$args)
    {
    }
    public static function get_super_global_value($super_global, $key)
    {
    }
    /**
     * Return specific object property value if exist from array of keys.
     *
     * @param array $base_array
     * @param array $keys
     * @return mixed|null
     */
    public static function get_array_value_by_keys($base_array, $keys)
    {
    }
    public static function get_cached_callback($callback, $cache_key, $cache_time = 24 * HOUR_IN_SECONDS)
    {
    }
    public static function is_sale_time(): bool
    {
    }
    public static function safe_throw(string $message)
    {
    }
    public static function has_invalid_post_permissions($post): bool
    {
    }
    public static function is_custom_kit_applied()
    {
    }
    public static function decode_string(string $encoded_string, ?string $fallback = '')
    {
    }
    public static function encode_string(string $decoded_string): string
    {
    }
}
/**
 * Elementor plugin.
 *
 * The main plugin handler class is responsible for initializing Elementor. The
 * class registers and all the components required to run the plugin.
 *
 * @since 1.0.0
 */
class Plugin
{
    const ELEMENTOR_DEFAULT_POST_TYPES = ['page', 'post'];
    /**
     * Instance.
     *
     * Holds the plugin instance.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @var Plugin
     */
    public static $instance = null;
    /**
     * Database.
     *
     * Holds the plugin database handler which is responsible for communicating
     * with the database.
     *
     * @since 1.0.0
     * @access public
     *
     * @var DB
     */
    public $db;
    /**
     * Controls manager.
     *
     * Holds the plugin controls manager handler is responsible for registering
     * and initializing controls.
     *
     * @since 1.0.0
     * @access public
     *
     * @var Controls_Manager
     */
    public $controls_manager;
    /**
     * Documents manager.
     *
     * Holds the documents manager.
     *
     * @since 2.0.0
     * @access public
     *
     * @var \Elementor\Core\Documents_Manager
     */
    public $documents;
    /**
     * Elements manager.
     *
     * Holds the plugin elements manager.
     *
     * @since 1.0.0
     * @access public
     *
     * @var Elements_Manager
     */
    public $elements_manager;
    /**
     * Widgets manager.
     *
     * Holds the plugin widgets manager which is responsible for registering and
     * initializing widgets.
     *
     * @since 1.0.0
     * @access public
     *
     * @var Widgets_Manager
     */
    public $widgets_manager;
    /**
     * Revisions manager.
     *
     * Holds the plugin revisions manager which handles history and revisions
     * functionality.
     *
     * @since 1.0.0
     * @access public
     *
     * @var \Elementor\Modules\History\Revisions_Manager
     */
    public $revisions_manager;
    /**
     * Images manager.
     *
     * Holds the plugin images manager which is responsible for retrieving image
     * details.
     *
     * @since 2.9.0
     * @access public
     *
     * @var Images_Manager
     */
    public $images_manager;
    /**
     * Maintenance mode.
     *
     * Holds the maintenance mode manager responsible for the "Maintenance Mode"
     * and the "Coming Soon" features.
     *
     * @since 1.0.0
     * @access public
     *
     * @var Maintenance_Mode
     */
    public $maintenance_mode;
    /**
     * Page settings manager.
     *
     * Holds the page settings manager.
     *
     * @since 1.0.0
     * @access public
     *
     * @var \Elementor\Core\Settings\Page\Manager
     */
    public $page_settings_manager;
    /**
     * Dynamic tags manager.
     *
     * Holds the dynamic tags manager.
     *
     * @since 1.0.0
     * @access public
     *
     * @var \Elementor\Core\DynamicTags\Manager
     */
    public $dynamic_tags;
    /**
     * Settings.
     *
     * Holds the plugin settings.
     *
     * @since 1.0.0
     * @access public
     *
     * @var Settings
     */
    public $settings;
    /**
     * Role Manager.
     *
     * Holds the plugin role manager.
     *
     * @since 2.0.0
     * @access public
     *
     * @var Core\RoleManager\Role_Manager
     */
    public $role_manager;
    /**
     * Admin.
     *
     * Holds the plugin admin.
     *
     * @since 1.0.0
     * @access public
     *
     * @var \Elementor\Core\Admin\Admin
     */
    public $admin;
    /**
     * Tools.
     *
     * Holds the plugin tools.
     *
     * @since 1.0.0
     * @access public
     *
     * @var Tools
     */
    public $tools;
    /**
     * Preview.
     *
     * Holds the plugin preview.
     *
     * @since 1.0.0
     * @access public
     *
     * @var Preview
     */
    public $preview;
    /**
     * Editor.
     *
     * Holds the plugin editor.
     *
     * @since 1.0.0
     * @access public
     *
     * @var \Elementor\Core\Editor\Editor
     */
    public $editor;
    /**
     * Frontend.
     *
     * Holds the plugin frontend.
     *
     * @since 1.0.0
     * @access public
     *
     * @var Frontend
     */
    public $frontend;
    /**
     * Heartbeat.
     *
     * Holds the plugin heartbeat.
     *
     * @since 1.0.0
     * @access public
     *
     * @var Heartbeat
     */
    public $heartbeat;
    /**
     * System info.
     *
     * Holds the system info data.
     *
     * @since 1.0.0
     * @access public
     *
     * @var \Elementor\Modules\System_Info\Module
     */
    public $system_info;
    /**
     * Template library manager.
     *
     * Holds the template library manager.
     *
     * @since 1.0.0
     * @access public
     *
     * @var TemplateLibrary\Manager
     */
    public $templates_manager;
    /**
     * Skins manager.
     *
     * Holds the skins manager.
     *
     * @since 1.0.0
     * @access public
     *
     * @var Skins_Manager
     */
    public $skins_manager;
    /**
     * Files manager.
     *
     * Holds the plugin files manager.
     *
     * @since 2.1.0
     * @access public
     *
     * @var \Elementor\Core\Files\Manager
     */
    public $files_manager;
    /**
     * Assets manager.
     *
     * Holds the plugin assets manager.
     *
     * @since 2.6.0
     * @access public
     *
     * @var \Elementor\Core\Files\Assets\Manager
     */
    public $assets_manager;
    /**
     * Icons Manager.
     *
     * Holds the plugin icons manager.
     *
     * @access public
     *
     * @var Icons_Manager
     */
    public $icons_manager;
    /**
     * WordPress widgets manager.
     *
     * Holds the WordPress widgets manager.
     *
     * @since 1.0.0
     * @access public
     *
     * @var WordPress_Widgets_Manager
     */
    public $wordpress_widgets_manager;
    /**
     * Modules manager.
     *
     * Holds the plugin modules manager.
     *
     * @since 1.0.0
     * @access public
     *
     * @var \Elementor\Core\Modules_Manager
     */
    public $modules_manager;
    /**
     * Beta testers.
     *
     * Holds the plugin beta testers.
     *
     * @since 1.0.0
     * @access public
     *
     * @var Beta_Testers
     */
    public $beta_testers;
    /**
     * Inspector.
     *
     * Holds the plugin inspector data.
     *
     * @since 2.1.2
     * @access public
     *
     * @var \Elementor\Core\Debug\Inspector
     */
    public $inspector;
    /**
     * @var \Elementor\Core\Admin\Menu\Admin_Menu_Manager
     */
    public $admin_menu_manager;
    /**
     * Common functionality.
     *
     * Holds the plugin common functionality.
     *
     * @since 2.3.0
     * @access public
     *
     * @var \Elementor\Core\Common\App
     */
    public $common;
    /**
     * Log manager.
     *
     * Holds the plugin log manager.
     *
     * @access public
     *
     * @var \Elementor\Core\Logger\Manager
     */
    public $logger;
    /**
     * Upgrade manager.
     *
     * Holds the plugin upgrade manager.
     *
     * @access public
     *
     * @var Core\Upgrade\Manager
     */
    public $upgrade;
    /**
     * Tasks manager.
     *
     * Holds the plugin tasks manager.
     *
     * @var Core\Upgrade\Custom_Tasks_Manager
     */
    public $custom_tasks;
    /**
     * Kits manager.
     *
     * Holds the plugin kits manager.
     *
     * @access public
     *
     * @var Core\Kits\Manager
     */
    public $kits_manager;
    /**
     * @var \Elementor\Data\V2\Manager
     */
    public $data_manager_v2;
    /**
     * Legacy mode.
     *
     * Holds the plugin legacy mode data.
     *
     * @access public
     *
     * @var array
     */
    public $legacy_mode;
    /**
     * App.
     *
     * Holds the plugin app data.
     *
     * @since 3.0.0
     * @access public
     *
     * @var App\App
     */
    public $app;
    /**
     * WordPress API.
     *
     * Holds the methods that interact with WordPress Core API.
     *
     * @since 3.0.0
     * @access public
     *
     * @var \Elementor\Core\Wp_Api
     */
    public $wp;
    /**
     * Experiments manager.
     *
     * Holds the plugin experiments manager.
     *
     * @since 3.1.0
     * @access public
     *
     * @var \Elementor\Core\Experiments\Manager
     */
    public $experiments;
    /**
     * Uploads manager.
     *
     * Holds the plugin uploads manager responsible for handling file uploads
     * that are not done with WordPress Media.
     *
     * @since 3.3.0
     * @access public
     *
     * @var \Elementor\Core\Files\Uploads_Manager
     */
    public $uploads_manager;
    /**
     * Breakpoints manager.
     *
     * Holds the plugin breakpoints manager.
     *
     * @since 3.2.0
     * @access public
     *
     * @var \Elementor\Core\Breakpoints\Manager
     */
    public $breakpoints;
    /**
     * Assets loader.
     *
     * Holds the plugin assets loader responsible for conditionally enqueuing
     * styles and script assets that were pre-enabled.
     *
     * @since 3.3.0
     * @access public
     *
     * @var \Elementor\Core\Page_Assets\Loader
     */
    public $assets_loader;
    /**
     * Clone.
     *
     * Disable class cloning and throw an error on object clone.
     *
     * The whole idea of the singleton design pattern is that there is a single
     * object. Therefore, we don't want the object to be cloned.
     *
     * @access public
     * @since 1.0.0
     */
    public function __clone()
    {
    }
    /**
     * Wakeup.
     *
     * Disable unserializing of the class.
     *
     * @access public
     * @since 1.0.0
     */
    public function __wakeup()
    {
    }
    /**
     * Instance.
     *
     * Ensures only one instance of the plugin class is loaded or can be loaded.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @return Plugin An instance of the class.
     */
    public static function instance()
    {
    }
    /**
     * Init.
     *
     * Initialize Elementor Plugin. Register Elementor support for all the
     * supported post types and initialize Elementor components.
     *
     * @since 1.0.0
     * @access public
     */
    public function init()
    {
    }
    /**
     * Get install time.
     *
     * Retrieve the time when Elementor was installed.
     *
     * @since 2.6.0
     * @access public
     * @static
     *
     * @return int Unix timestamp when Elementor was installed.
     */
    public function get_install_time()
    {
    }
    /**
     * @since 2.3.0
     * @access public
     */
    public function on_rest_api_init()
    {
    }
    /**
     * @since 2.3.0
     * @access public
     */
    public function init_common()
    {
    }
    /**
     * Magic getter for accessing certain properties.
     *
     * @since 3.1.0
     * @access public
     *
     * @param string $property The property name.
     * @return mixed The property value or null if not found.
     * @throws \Exception If trying to access a private property.
     */
    public function __get($property)
    {
    }
    final public static function get_title()
    {
    }
    public function sanitize_post_data($post, \WP_REST_Request $request)
    {
    }
}
namespace Elementor\Core;

/**
 * Elementor documents manager.
 *
 * Elementor documents manager handler class is responsible for registering and
 * managing Elementor documents.
 *
 * @since 2.0.0
 */
class Documents_Manager
{
    /**
     * Registered types.
     *
     * Holds the list of all the registered types.
     *
     * @since 2.0.0
     * @access protected
     *
     * @var \Elementor\Core\Base\Document[]
     */
    protected $types = [];
    /**
     * Registered documents.
     *
     * Holds the list of all the registered documents.
     *
     * @since 2.0.0
     * @access protected
     *
     * @var \Elementor\Core\Base\Document[]
     */
    protected $documents = [];
    /**
     * Current document.
     *
     * Holds the current document.
     *
     * @since 2.0.0
     * @access protected
     *
     * @var \Elementor\Core\Base\Document
     */
    protected $current_doc;
    /**
     * Switched data.
     *
     * Holds the current document when changing to the requested post.
     *
     * @since 2.0.0
     * @access protected
     *
     * @var array
     */
    protected $switched_data = [];
    protected $cpt = [];
    /**
     * Documents manager constructor.
     *
     * Initializing the Elementor documents manager.
     *
     * @since 2.0.0
     * @access public
     */
    public function __construct()
    {
    }
    /**
     * Register ajax actions.
     *
     * Process ajax action handles when saving data and discarding changes.
     *
     * Fired by `elementor/ajax/register_actions` action.
     *
     * @since 2.0.0
     * @access public
     *
     * @param \Elementor\Core\Common\Modules\Ajax\Module $ajax_manager An instance of the ajax manager.
     */
    public function register_ajax_actions($ajax_manager)
    {
    }
    /**
     * Register default types.
     *
     * Registers the default document types.
     *
     * @since 2.0.0
     * @access public
     */
    public function register_default_types()
    {
    }
    /**
     * Register document type.
     *
     * Registers a single document.
     *
     * @since 2.0.0
     * @access public
     *
     * @param string $type       Document type name.
     * @param string $class_name The name of the class that registers the document type.
     *                           Full name with the namespace.
     *
     * @return Documents_Manager The updated document manager instance.
     */
    public function register_document_type($type, $class_name)
    {
    }
    /**
     * Get document.
     *
     * Retrieve the document data based on a post ID.
     *
     * @since 2.0.0
     * @access public
     *
     * @param int  $post_id    Post ID.
     * @param bool $from_cache Optional. Whether to retrieve cached data. Default is true.
     *
     * @return false|\Elementor\Core\Base\Document Document data or false if post ID was not entered.
     */
    public function get($post_id, $from_cache = true)
    {
    }
    /**
     * Retrieve a document after checking it exist and allowed to edit.
     *
     * @param string $id
     * @return \Elementor\Core\Base\Document
     * @throws \Exception If the document is not found or the current user is not allowed to edit it.
     * @since 3.13.0
     */
    public function get_with_permissions($id): \Elementor\Core\Base\Document
    {
    }
    /**
     * A `void` version for `get_with_permissions`.
     *
     * @param string $id
     * @return void
     * @throws \Exception If the document is not found or the current user is not allowed to edit it.
     */
    public function check_permissions($id)
    {
    }
    /**
     * Get document or autosave.
     *
     * Retrieve either the document or the autosave.
     *
     * @since 2.0.0
     * @access public
     *
     * @param int $id      Optional. Post ID. Default is `0`.
     * @param int $user_id Optional. User ID. Default is `0`.
     *
     * @return false|\Elementor\Core\Base\Document The document if it exist, False otherwise.
     */
    public function get_doc_or_auto_save($id, $user_id = 0)
    {
    }
    /**
     * Get document for frontend.
     *
     * Retrieve the document for frontend use.
     *
     * @since 2.0.0
     * @access public
     *
     * @param int $post_id Optional. Post ID. Default is `0`.
     *
     * @return false|\Elementor\Core\Base\Document The document if it exist, False otherwise.
     */
    public function get_doc_for_frontend($post_id)
    {
    }
    /**
     * Get document type.
     *
     * Retrieve the type of any given document.
     *
     * @since  2.0.0
     * @access public
     *
     * @param string $type
     *
     * @param string $fallback
     *
     * @return \Elementor\Core\Base\Document|bool The type of the document.
     */
    public function get_document_type($type, $fallback = 'post')
    {
    }
    /**
     * Get document types.
     *
     * Retrieve the all the registered document types.
     *
     * @since  2.0.0
     * @access public
     *
     * @param array  $args      Optional. An array of key => value arguments to match against
     *                                the properties. Default is empty array.
     * @param string $operator Optional. The logical operation to perform. 'or' means only one
     *                               element from the array needs to match; 'and' means all elements
     *                               must match; 'not' means no elements may match. Default 'and'.
     *
     * @return \Elementor\Core\Base\Document[] All the registered document types.
     */
    public function get_document_types($args = [], $operator = 'and')
    {
    }
    /**
     * Get document types with their properties.
     *
     * @return array A list of properties arrays indexed by the type.
     */
    public function get_types_properties()
    {
    }
    /**
     * Create a document.
     *
     * Create a new document using any given parameters.
     *
     * @since 2.0.0
     * @access public
     *
     * @param string $type      Document type.
     * @param array  $post_data An array containing the post data.
     * @param array  $meta_data An array containing the post meta data.
     *
     * @return \Elementor\Core\Base\Document The type of the document.
     */
    public function create($type, $post_data = [], $meta_data = [])
    {
    }
    /**
     * Remove user edit capabilities if document is not editable.
     *
     * Filters the user capabilities to disable editing in admin.
     *
     * @param array $allcaps An array of all the user's capabilities.
     * @param array $caps    Actual capabilities for meta capability.
     * @param array $args    Optional parameters passed to has_cap(), typically object ID.
     *
     * @return array
     */
    public function remove_user_edit_cap($allcaps, $caps, $args)
    {
    }
    /**
     * Filter Post Row Actions.
     *
     * Let the Document to filter the array of row action links on the Posts list table.
     *
     * @param array    $actions
     * @param \WP_Post $post
     *
     * @return array
     */
    public function filter_post_row_actions($actions, $post)
    {
    }
    /**
     * Save document data using ajax.
     *
     * Save the document on the builder using ajax, when saving the changes, and refresh the editor.
     *
     * @since 2.0.0
     * @access public
     *
     * @param array $request Post ID.
     *
     * @throws \Exception If current user don't have permissions to edit the post or the post is not using Elementor.
     *
     * @return array The document data after saving.
     */
    public function ajax_save($request)
    {
    }
    /**
     * Ajax discard changes.
     *
     * Load the document data from an autosave, deleting unsaved changes.
     *
     * @param array $request
     *
     * @return bool True if changes discarded, False otherwise.
     * @throws \Exception If current user don't have permissions to edit the post or the post is not using Elementor.
     *
     * @since 2.0.0
     * @access public
     */
    public function ajax_discard_changes($request)
    {
    }
    public function ajax_get_document_config($request)
    {
    }
    /**
     * Switch to document.
     *
     * Change the document to any new given document type.
     *
     * @since 2.0.0
     * @access public
     *
     * @param \Elementor\Core\Base\Document $document The document to switch to.
     */
    public function switch_to_document($document)
    {
    }
    /**
     * Restore document.
     *
     * Rollback to the original document.
     *
     * @since 2.0.0
     * @access public
     */
    public function restore_document()
    {
    }
    /**
     * Get current document.
     *
     * Retrieve the current document.
     *
     * @since 2.0.0
     * @access public
     *
     * @return \Elementor\Core\Base\Document The current document.
     */
    public function get_current()
    {
    }
    public function localize_settings($settings)
    {
    }
    /**
     * Get create new post URL.
     *
     * Retrieve a custom URL for creating a new post/page using Elementor.
     *
     * @param string      $post_type Optional. Post type slug. Default is 'page'.
     * @param string|null $template_type Optional. Query arg 'template_type'. Default is null.
     *
     * @return string A URL for creating new post using Elementor.
     */
    public static function get_create_new_post_url($post_type = 'page', $template_type = null)
    {
    }
    public function register_rest_routes()
    {
    }
}