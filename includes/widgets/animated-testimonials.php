<?php
/**
 * Animated Testimonials Widget
 */

defined('ABSPATH') || exit;

class Decent_Animated_Testimonials_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'decent-animated-testimonials';
    }

    public function get_title()
    {
        return esc_html__('Animated Testimonials', 'decent-elements');
    }

    public function get_icon()
    {
        return 'eicon-testimonial';
    }

    public function get_categories()
    {
        return ['decent-elements'];
    }

    public function get_keywords()
    {
        return ['testimonials', 'reviews', 'slider', 'animated', 'carousel'];
    }

    public function get_style_depends()
    {
        return ['decent-animated-testimonials'];
    }

    public function get_script_depends()
    {
        return ['decent-animated-testimonials'];
    }

    protected function register_controls()
    {
        // Content Section
        $this->start_controls_section(
            'section_testimonials',
            [
                'label' => esc_html__('Testimonials', 'decent-elements'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'testimonial_quote',
            [
                'label' => esc_html__('Quote', 'decent-elements'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('This is an amazing product that has transformed our workflow completely.', 'decent-elements'),
                'placeholder' => esc_html__('Enter testimonial quote', 'decent-elements'),
                'rows' => 4,
            ]
        );

        $repeater->add_control(
            'testimonial_name',
            [
                'label' => esc_html__('Name', 'decent-elements'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('John Doe', 'decent-elements'),
                'placeholder' => esc_html__('Enter name', 'decent-elements'),
            ]
        );

        $repeater->add_control(
            'testimonial_designation',
            [
                'label' => esc_html__('Designation', 'decent-elements'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('CEO at Company', 'decent-elements'),
                'placeholder' => esc_html__('Enter designation', 'decent-elements'),
            ]
        );

        $repeater->add_control(
            'testimonial_image',
            [
                'label' => esc_html__('Image', 'decent-elements'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'testimonials_list',
            [
                'label' => esc_html__('Testimonials', 'decent-elements'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'testimonial_quote' => 'The attention to detail and innovative features have completely transformed our workflow. This is exactly what we\'ve been looking for.',
                        'testimonial_name' => 'Sarah Chen',
                        'testimonial_designation' => 'Product Manager at TechFlow',
                        'testimonial_image' => ['url' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?q=80&w=400&auto=format&fit=crop'],
                    ],
                    [
                        'testimonial_quote' => 'Implementation was seamless and the results exceeded our expectations. The platform\'s flexibility is remarkable.',
                        'testimonial_name' => 'Michael Rodriguez',
                        'testimonial_designation' => 'CTO at InnovateSphere',
                        'testimonial_image' => ['url' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=400&auto=format&fit=crop'],
                    ],
                    [
                        'testimonial_quote' => 'This solution has significantly improved our team\'s productivity. The intuitive interface makes complex tasks simple.',
                        'testimonial_name' => 'Emily Watson',
                        'testimonial_designation' => 'Operations Director at CloudScale',
                        'testimonial_image' => ['url' => 'https://images.unsplash.com/photo-1623582854588-d60de57fa33f?q=80&w=400&auto=format&fit=crop'],
                    ],
                ],
                'title_field' => '{{{ testimonial_name }}}',
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__('Autoplay', 'decent-elements'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'decent-elements'),
                'label_off' => esc_html__('No', 'decent-elements'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' => esc_html__('Autoplay Speed (ms)', 'decent-elements'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5000,
                'min' => 1000,
                'max' => 10000,
                'step' => 100,
                'condition' => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('General', 'decent-elements'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'container_padding',
            [
                'label' => esc_html__('Container Padding', 'decent-elements'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .decent-animated-testimonials' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Quote Style
        $this->start_controls_section(
            'section_quote_style',
            [
                'label' => esc_html__('Quote', 'decent-elements'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'quote_typography',
                'selector' => '{{WRAPPER}} .testimonial-quote',
            ]
        );

        $this->add_control(
            'quote_color',
            [
                'label' => esc_html__('Color', 'decent-elements'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .testimonial-quote' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        // Name Style
        $this->start_controls_section(
            'section_name_style',
            [
                'label' => esc_html__('Name', 'decent-elements'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'name_typography',
                'selector' => '{{WRAPPER}} .testimonial-name',
            ]
        );

        $this->add_control(
            'name_color',
            [
                'label' => esc_html__('Color', 'decent-elements'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .testimonial-name' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        // Designation Style
        $this->start_controls_section(
            'section_designation_style',
            [
                'label' => esc_html__('Designation', 'decent-elements'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'designation_typography',
                'selector' => '{{WRAPPER}} .testimonial-designation',
            ]
        );

        $this->add_control(
            'designation_color',
            [
                'label' => esc_html__('Color', 'decent-elements'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .testimonial-designation' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $testimonials = $settings['testimonials_list'];

        if (empty($testimonials)) {
            return;
        }

        $autoplay = $settings['autoplay'] === 'yes';
        $autoplay_speed = $settings['autoplay_speed'] ?? 5000;
        ?>
<div class="decent-animated-testimonials" data-autoplay="<?php echo esc_attr($autoplay ? 'true' : 'false'); ?>"
	data-autoplay-speed="<?php echo esc_attr($autoplay_speed); ?>">
	<div class="testimonials-container">
		<div class="testimonials-images">
			<?php foreach ($testimonials as $index => $testimonial): ?>
			<div class="testimonial-image <?php echo $index === 0 ? 'active' : ''; ?>"
				data-index="<?php echo esc_attr($index); ?>">
				<img src="<?php echo esc_url($testimonial['testimonial_image']['url']); ?>"
					alt="<?php echo esc_attr($testimonial['testimonial_name']); ?>" draggable="false">
			</div>
			<?php endforeach; ?>
		</div>

		<div class="testimonials-content">
			<div class="testimonial-text">
				<?php foreach ($testimonials as $index => $testimonial): ?>
				<div class="testimonial-item <?php echo $index === 0 ? 'active' : ''; ?>"
					data-index="<?php echo esc_attr($index); ?>">
					<h3 class="testimonial-name"><?php echo esc_html($testimonial['testimonial_name']); ?></h3>
					<p class="testimonial-designation"><?php echo esc_html($testimonial['testimonial_designation']); ?>
					</p>
					<p class="testimonial-quote"><?php echo esc_html($testimonial['testimonial_quote']); ?></p>
				</div>
				<?php endforeach; ?>
			</div>

			<div class="testimonials-navigation">
				<button class="nav-btn prev-btn" aria-label="Previous testimonial">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
						<path d="M19 12H5M12 19l-7-7 7-7" />
					</svg>
				</button>
				<button class="nav-btn next-btn" aria-label="Next testimonial">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
						<path d="M5 12h14M12 5l7 7-7 7" />
					</svg>
				</button>
			</div>
		</div>
	</div>
</div>
<?php
    }
}