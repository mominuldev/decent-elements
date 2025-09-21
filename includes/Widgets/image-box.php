<?php
/**
 * Image Box Widget
 *
 * @since 1.0.0
 */

defined('ABSPATH') || exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;

class Decent_Elements_Image_Box_Widget extends Widget_Base
{
    /**
     * Get widget name.
     */
    public function get_name()
    {
        return 'de-image-box';
    }

    /**
     * Get widget title.
     */
    public function get_title()
    {
        return __('Image Box', 'decent-elements');
    }

    /**
     * Get widget icon.
     */
    public function get_icon()
    {
        return 'eicon-image-box';
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
            'image',
            [
                'label' => __('Choose Image', 'decent-elements'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image_size',
                'default' => 'large',
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'decent-elements'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Image Box Title', 'decent-elements'),
                'placeholder' => __('Enter your title', 'decent-elements'),
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __('Description', 'decent-elements'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('Your description text goes here. You can edit this text from the Content section of this element.', 'decent-elements'),
                'placeholder' => __('Enter your description', 'decent-elements'),
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
            'position',
            [
                'label' => __('Image Position', 'decent-elements'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'top' => [
                        'title' => __('Top', 'decent-elements'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'left' => [
                        'title' => __('Left', 'decent-elements'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => __('Right', 'decent-elements'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'top',
                'prefix_class' => 'elementor-position-',
            ]
        );

        $this->end_controls_section();

        // Image Style
        $this->start_controls_section(
            'image_style',
            [
                'label' => __('Image', 'decent-elements'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_width',
            [
                'label' => __('Width', 'decent-elements'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .de-image-box .image-box-img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'selector' => '{{WRAPPER}} .de-image-box .image-box-img img',
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label' => __('Border Radius', 'decent-elements'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .de-image-box .image-box-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Title Style
        $this->start_controls_section(
            'title_style',
            [
                'label' => __('Title', 'decent-elements'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Color', 'decent-elements'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .de-image-box .image-box-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .de-image-box .image-box-title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => __('Margin', 'decent-elements'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .de-image-box .image-box-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Description Style
        $this->start_controls_section(
            'description_style',
            [
                'label' => __('Description', 'decent-elements'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => __('Color', 'decent-elements'),
                'type' => Controls_Manager::COLOR,
                'default' => '#666666',
                'selectors' => [
                    '{{WRAPPER}} .de-image-box .image-box-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .de-image-box .image-box-description',
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
            $this->add_link_attributes('link', $link);
        }

        ?>
        <div class="de-image-box">
            <?php if ($has_link) : ?>
                <a <?php echo $this->get_render_attribute_string('link'); ?>>
            <?php endif; ?>
            
            <div class="image-box-img">
                <?php echo Group_Control_Image_Size::get_attachment_image_html($settings, 'image_size', 'image'); ?>
            </div>
            
            <div class="image-box-content">
                <?php if (!empty($settings['title'])) : ?>
                    <h3 class="image-box-title"><?php echo esc_html($settings['title']); ?></h3>
                <?php endif; ?>
                
                <?php if (!empty($settings['description'])) : ?>
                    <p class="image-box-description"><?php echo esc_html($settings['description']); ?></p>
                <?php endif; ?>
            </div>
            
            <?php if ($has_link) : ?>
                </a>
            <?php endif; ?>
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
        var image = {
            id: settings.image.id,
            url: settings.image.url,
            size: settings.image_size_size,
            dimension: settings.image_size_custom_dimension,
            model: view.getEditModel()
        };
        var image_url = elementor.imagesManager.getImageUrl( image );
        var hasLink = settings.link.url;
        #>
        <div class="de-image-box">
            <# if ( hasLink ) { #>
                <a href="{{ settings.link.url }}">
            <# } #>
            
            <div class="image-box-img">
                <# if ( image_url ) { #>
                    <img src="{{ image_url }}" alt="" />
                <# } #>
            </div>
            
            <div class="image-box-content">
                <# if ( settings.title ) { #>
                    <h3 class="image-box-title">{{{ settings.title }}}</h3>
                <# } #>
                
                <# if ( settings.description ) { #>
                    <p class="image-box-description">{{{ settings.description }}}</p>
                <# } #>
            </div>
            
            <# if ( hasLink ) { #>
                </a>
            <# } #>
        </div>
        <?php
    }
}
