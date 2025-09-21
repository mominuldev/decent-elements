<?php
/**
 * Button Widget
 *
 * @since 1.0.0
 */

defined('ABSPATH') || exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

class Decent_Elements_Button_Widget extends Widget_Base
{
    /**
     * Get widget name.
     */
    public function get_name()
    {
        return 'de-button';
    }

    /**
     * Get widget title.
     */
    public function get_title()
    {
        return __('Decent Button', 'decent-elements');
    }

    /**
     * Get widget icon.
     */
    public function get_icon()
    {
        return 'eicon-button';
    }

    /**
     * Get widget categories.
     */
    public function get_categories()
    {
        return ['decent-elements'];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'decent-elements'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __('Button Text', 'decent-elements'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Click Here', 'decent-elements'),
                'placeholder' => __('Enter button text', 'decent-elements'),
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => __('Link', 'decent-elements'),
                'type' => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'decent-elements'),
                'default' => [
                    'url' => '',
                ],
            ]
        );

        $this->add_control(
            'size',
            [
                'label' => __('Size', 'decent-elements'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'xs' => __('Extra Small', 'decent-elements'),
                    'sm' => __('Small', 'decent-elements'),
                    'md' => __('Medium', 'decent-elements'),
                    'lg' => __('Large', 'decent-elements'),
                    'xl' => __('Extra Large', 'decent-elements'),
                ],
                'default' => 'md',
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => __('Icon', 'decent-elements'),
                'type' => Controls_Manager::ICONS,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'icon_align',
            [
                'label' => __('Icon Position', 'decent-elements'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'left' => __('Before', 'decent-elements'),
                    'right' => __('After', 'decent-elements'),
                ],
                'default' => 'left',
                'condition' => [
                    'icon[value]!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => __('Alignment', 'decent-elements'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'decent-elements'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'decent-elements'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'decent-elements'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => __('Justified', 'decent-elements'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'default' => 'left',
                'prefix_class' => 'elementor-align%s-',
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Button', 'decent-elements'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .de-button',
            ]
        );

        $this->start_controls_tabs('button_tabs');

        $this->start_controls_tab(
            'button_normal',
            [
                'label' => __('Normal', 'decent-elements'),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => __('Text Color', 'decent-elements'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .de-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'button_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .de-button',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .de-button',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .de-button',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_hover',
            [
                'label' => __('Hover', 'decent-elements'),
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label' => __('Text Color', 'decent-elements'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .de-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'button_background_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .de-button:hover',
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label' => __('Border Color', 'decent-elements'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .de-button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_hover_box_shadow',
                'selector' => '{{WRAPPER}} .de-button:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'button_border_radius',
            [
                'label' => __('Border Radius', 'decent-elements'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .de-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => __('Padding', 'decent-elements'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .de-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        
        $link = $settings['link'];
        $has_link = !empty($link['url']);
        
        if ($has_link) {
            $this->add_link_attributes('button', $link);
        }

        $this->add_render_attribute('button', 'class', 'de-button');
        $this->add_render_attribute('button', 'class', 'size-' . $settings['size']);

        $button_tag = $has_link ? 'a' : 'button';

        ?>
        <div class="de-button-wrapper">
            <<?php echo esc_attr($button_tag); ?> <?php echo $this->get_render_attribute_string('button'); ?>>
                <?php if (!empty($settings['icon']['value']) && $settings['icon_align'] === 'left') : ?>
                    <span class="button-icon align-left">
                        <?php \Elementor\Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true']); ?>
                    </span>
                <?php endif; ?>
                
                <span class="button-text"><?php echo esc_html($settings['button_text']); ?></span>
                
                <?php if (!empty($settings['icon']['value']) && $settings['icon_align'] === 'right') : ?>
                    <span class="button-icon align-right">
                        <?php \Elementor\Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true']); ?>
                    </span>
                <?php endif; ?>
            </<?php echo esc_attr($button_tag); ?>>
        </div>
        <?php
    }

    /**
     * Render widget output in the editor.
     */
    protected function content_template()
    {
        ?>
        <#
        var buttonTag = settings.link.url ? 'a' : 'button';
        var iconHTML = elementor.helpers.renderIcon( view, settings.icon, { 'aria-hidden': true }, 'i' , 'object' );
        #>
        <div class="de-button-wrapper">
            <{{{ buttonTag }}} class="de-button size-{{ settings.size }}" href="{{ settings.link.url }}">
                <# if ( settings.icon.value && settings.icon_align === 'left' ) { #>
                    <span class="button-icon align-left">
                        {{{ iconHTML.value }}}
                    </span>
                <# } #>
                
                <span class="button-text">{{{ settings.button_text }}}</span>
                
                <# if ( settings.icon.value && settings.icon_align === 'right' ) { #>
                    <span class="button-icon align-right">
                        {{{ iconHTML.value }}}
                    </span>
                <# } #>
            </{{{ buttonTag }}}>
        </div>
        <?php
    }
}
