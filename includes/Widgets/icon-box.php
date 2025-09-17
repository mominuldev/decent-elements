<?php
/**
 * Icon Box Widget
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

class Decent_Elements_Icon_Box_Widget extends Widget_Base
{
    /**
     * Get widget name.
     */
    public function get_name()
    {
        return 'de-icon-box';
    }

    /**
     * Get widget title.
     */
    public function get_title()
    {
        return __('Icon Box', 'decent-elements');
    }

    /**
     * Get widget icon.
     */
    public function get_icon()
    {
        return 'eicon-icon-box';
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
            'icon',
            [
                'label' => __('Icon', 'decent-elements'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'decent-elements'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Icon Box Title', 'decent-elements'),
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
                'label' => __('Icon Position', 'decent-elements'),
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

        // Icon Style
        $this->start_controls_section(
            'icon_style',
            [
                'label' => __('Icon', 'decent-elements'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __('Color', 'decent-elements'),
                'type' => Controls_Manager::COLOR,
                'default' => '#007cba',
                'selectors' => [
                    '{{WRAPPER}} .de-icon-box .icon-box-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .de-icon-box .icon-box-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => __('Size', 'decent-elements'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'default' => [
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .de-icon-box .icon-box-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .de-icon-box .icon-box-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'icon_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .de-icon-box .icon-box-icon',
            ]
        );

        $this->add_responsive_control(
            'icon_padding',
            [
                'label' => __('Padding', 'decent-elements'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .de-icon-box .icon-box-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'icon_border',
                'selector' => '{{WRAPPER}} .de-icon-box .icon-box-icon',
            ]
        );

        $this->add_responsive_control(
            'icon_border_radius',
            [
                'label' => __('Border Radius', 'decent-elements'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .de-icon-box .icon-box-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .de-icon-box .icon-box-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .de-icon-box .icon-box-title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => __('Margin', 'decent-elements'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .de-icon-box .icon-box-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .de-icon-box .icon-box-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .de-icon-box .icon-box-description',
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
<div class="de-icon-box">
	<?php if ($has_link) : ?>
	<a <?php echo $this->get_render_attribute_string('link'); ?>>
		<?php endif; ?>

		<div class="icon-box-icon">
			<?php \Elementor\Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true']); ?>
		</div>

		<div class="icon-box-content">
			<?php if (!empty($settings['title'])) : ?>
			<h3 class="icon-box-title"><?php echo esc_html($settings['title']); ?></h3>
			<?php endif; ?>

			<?php if (!empty($settings['description'])) : ?>
			<p class="icon-box-description"><?php echo esc_html($settings['description']); ?></p>
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
<# var iconHTML=elementor.helpers.renderIcon( view, settings.icon, { 'aria-hidden' : true }, 'i' , 'object' ); var
	hasLink=settings.link.url; #>
	<div class="de-icon-box">
		<# if ( hasLink ) { #>
			<a href="{{ settings.link.url }}">
				<# } #>

					<div class="icon-box-icon">
						{{{ iconHTML.value }}}
					</div>

					<div class="icon-box-content">
						<# if ( settings.title ) { #>
							<h3 class="icon-box-title">{{{ settings.title }}}</h3>
							<# } #>

								<# if ( settings.description ) { #>
									<p class="icon-box-description">{{{ settings.description }}}</p>
									<# } #>
					</div>

					<# if ( hasLink ) { #>
			</a>
			<# } #>
	</div>
	<?php
    }
}