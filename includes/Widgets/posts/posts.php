<?php

/* Posts Widget
*
* @since 1.0.0
*/


use Decent_Elements\Traits\Posts_Query;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;


if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

/**
 * Posts
 * Elementor widget for Posts.
 * @since 1.0.0
 */
class Posts extends Widget_Base
{

	use Posts_Query;

	/**
	 * @var \WP_Query
	 */
	protected $query = null;

	/**
	 * Retrieve the widget name.
	 * @return string Widget name.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_name()
	{
		return 'de-posts';
	}

	/**
	 * Retrieve the widget title.
	 * @return string Widget title.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_title()
	{
		return esc_html__('Posts', '_pltdomain');
	}

	/**
	 * Retrieve the widget icon.
	 * @return string Widget icon.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_icon()
	{
		return 'themeclassname-signature eicon-post';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 * Used to determine where to display the widget in the editor.
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 * @return array Widget categories.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_categories()
	{
		return ['tc-elements'];
	}

	/**
	 * Retrieve the list of scripts the widget depended on.
	 * Used to set scripts dependencies required to run the widget.
	 * @return array Widget scripts dependencies.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_script_depends()
	{
		return ['bc-posts', 'post'];
	}

	/**
	 * Requires css files.
	 * @return array
	 */
	public function get_style_depends()
	{
		return array(
			'bc-posts',
		);
	}

	/**
	 * Register the widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls()
	{
		//layout
		$this->start_controls_section(
			'section_general',
			[
				'label' => esc_html__('General', '_pltdomain'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'preset_layout',
			[
				'label'   => esc_html__('Style', '_pltdomain'),
				'type'    => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1'  => esc_html__('One', '_pltdomain'),
					'2'  => esc_html__('Two', '_pltdomain'),
					'3'  => esc_html__('Three', '_pltdomain'),
					'4'  => esc_html__('Four', '_pltdomain'),
					'5'  => esc_html__('Five', '_pltdomain'),
					'6'  => esc_html__('Six', '_pltdomain'),
					'7'  => esc_html__('Seven', '_pltdomain'),
					'8'  => esc_html__('Eight', '_pltdomain'),
					'9'  => esc_html__('Nine', '_pltdomain'),
					'10' => esc_html__('Ten', '_pltdomain'),
				],
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'          => esc_html__('Columns', '_pltdomain'),
				'type'           => Controls_Manager::SELECT,
				'render_type'    => 'template',
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'selectors'      => [
					'{{WRAPPER}} .bc-posts-items' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				],
				'condition'      => [
					'preset_layout!' => ['2', '3', '4', '6'],
				]
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label'   => esc_html__('Posts Per Page', '_pltdomain'),
				'type'    => Controls_Manager::NUMBER,
				'default' => 6,
			]
		);

		// Image Position Left/Right
		$this->add_control(
			'image_position',
			[
				'label'     => esc_html__('Image Position', '_pltdomain'),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'left',
				'options'   => [
					'left'  => [
						'title' => esc_html__('Left', '_pltdomain'),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__('Right', '_pltdomain'),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'condition' => [
					'preset_layout' => ['2', '3', '4'],
				],
			]
		);

		// End Section
		$this->end_controls_section();

		//Content
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__('Content', '_pltdomain'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'         => 'thumbnail_size',
				'exclude'      => ['custom'],
				'default'      => 'medium',
				'prefix_class' => 'elementor-portfolio--thumbnail-size-',
			]
		);


		$this->add_control(
			'show_title',
			[
				'label'     => esc_html__('Show Title', '_pltdomain'),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'label_off' => esc_html__('Off', '_pltdomain'),
				'label_on'  => esc_html__('On', '_pltdomain'),
			]
		);

		$this->add_control(
			'title_length',
			[
				'label'     => esc_html__('Title Length (words)', '_pltdomain'),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 5,
				'max'       => 100,
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_length_line',
			[
				'label'     => esc_html__('Title Length (lines)', '_pltdomain'),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1,
				'max'       => 5,
				'default'   => 2,
				'condition' => [
					'show_title' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .bc-post-item .bc-post-item__entry-title a' => '-webkit-line-clamp: {{VALUE}}; white-space: normal; display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden;',
				],
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'     => esc_html__('Title HTML Tag', '_pltdomain'),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				],
				'default'   => 'h3',
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label'     => esc_html__('Show Excerpt', '_pltdomain'),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__('Show', '_pltdomain'),
				'label_off' => esc_html__('Hide', '_pltdomain'),
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'excerpt_length',
			[
				'label'     => esc_html__('Excerpt Length', '_pltdomain'),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 5,
				'max'       => 100,
				'default'   => 14,
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		// End Section
		$this->end_controls_section();

		//Content
		$this->start_controls_section(
			'section_meta',
			[
				'label' => esc_html__('Meta', '_pltdomain'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Meta Style
		$this->add_control(
			'meta_style',
			[
				'label'   => esc_html__('Meta Type', '_pltdomain'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'box',
				'options' => [
					'box'         => esc_html__('Box', '_pltdomain'),
					'inline'      => esc_html__('Inline', '_pltdomain'),
					'inline-icon' => esc_html__('Inline Icon', '_pltdomain'),
				],
			]
		);

		// Icons
		$this->add_control(
			'meta_icon',
			[
				'label'            => esc_html__('Meta Icon', '_pltdomain'),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'skin'             => 'inline',
				'label_block'      => false,
				'condition'        => [
					'meta_style' => 'inline-icon',
				],
			]
		);

		$this->add_control(
			'show_author',
			[
				'label'     => esc_html__('Show Author', '_pltdomain'),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__('Show', '_pltdomain'),
				'label_off' => esc_html__('Hide', '_pltdomain'),
				'default'   => 'no',
			]
		);

		$this->add_control(
			'show_taxonomy',
			[
				'label'     => esc_html__('Show Category', '_pltdomain'),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__('Show', '_pltdomain'),
				'label_off' => esc_html__('Hide', '_pltdomain'),
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'post_taxonomy',
			[
				'label'       => esc_html__('Taxonomy', '_pltdomain'),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'default'     => 'category',
				'options'     => $this->get_taxonomies(),
				'condition'   => [
					'show_taxonomy' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_date',
			[
				'label'     => esc_html__('Show Date', '_pltdomain'),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__('Show', '_pltdomain'),
				'label_off' => esc_html__('Hide', '_pltdomain'),
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'show_date_image',
			[
				'label'     => esc_html__('Show Date On Image', '_pltdomain'),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__('Show', '_pltdomain'),
				'label_off' => esc_html__('Hide', '_pltdomain'),
				'default'   => 'yes',
				'condition' => [
					'preset_layout' => '9'
				]
			]
		);

		// show_read_time
		$this->add_control(
			'show_read_time',
			[
				'label'     => esc_html__('Show Read Time', '_pltdomain'),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__('Show', '_pltdomain'),
				'label_off' => esc_html__('Hide', '_pltdomain'),
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'show_comment',
			[
				'label'     => esc_html__('Show Comment', '_pltdomain'),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__('Show', '_pltdomain'),
				'label_off' => esc_html__('Hide', '_pltdomain'),
				'default'   => 'no',
			]
		);

		// End Section
		$this->end_controls_section();

		//Content
		$this->start_controls_section(
			'section_button',
			[
				'label'     => esc_html__('Button', '_pltdomain'),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'preset_layout!' => ['3'],
				]
			]
		);

		$this->add_control(
			'show_read_more',
			[
				'label'     => esc_html__('Read More', '_pltdomain'),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__('Show', '_pltdomain'),
				'label_off' => esc_html__('Hide', '_pltdomain'),
				'default'   => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'read_more_text',
			[
				'label'       => esc_html__('Read More Text', '_pltdomain'),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => esc_html__('Discover more', '_pltdomain'),
				'condition'   => ['show_read_more' => 'yes'],
				'label_block' => true,
			]
		);

		$this->add_control(
			'selected_icon',
			[
				'label'            => esc_html__('Icon', '_pltdomain'),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'skin'             => 'inline',
				'label_block'      => false,
				'condition'        => ['show_read_more' => 'yes'],
			]
		);

		//		$this->add_control(
		//			'icon_align',
		//			[
		//				'label'     => esc_html__( 'Icon Position', '_pltdomain' ),
		//				'type'      => Controls_Manager::SELECT,
		//				'default'   => 'left',
		//				'options'   => [
		//					'left'  => esc_html__( 'Before', '_pltdomain' ),
		//					'right' => esc_html__( 'After', '_pltdomain' ),
		//				],
		//				'condition' => [ 'show_read_more' => 'yes' ],
		//			]
		//		);

		// Choose Control Icon align
		$this->add_control(
			'icon_align',
			[
				'label'     => esc_html__('Icon Position', '_pltdomain'),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'left',
				'options'   => [
					'left'  => [
						'title' => esc_html__('Before', '_pltdomain'),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__('After', '_pltdomain'),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'condition' => ['show_read_more' => 'yes'],
			]
		);

		$this->add_control(
			'icon_indend',
			[
				'label'     => esc_html__('Icon Spacing', '_pltdomain'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bc-btn-link' => 'gap: {{SIZE}}{{UNIT}};',
				],
				'condition' => ['show_read_more' => 'yes'],
			]
		);

		$this->end_controls_section();

		//query
		$this->register_query_controls();

		//layout style
		$this->register_design_layout_controls();

		//Thumbnail style
		$this->start_controls_section(
			'section_style_post_image',
			[
				'label' => esc_html__('Thumbnail', '_pltdomain'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'thumb_overlay_bg',
				'types'    => ['classic', 'gradient'],
				'exclude'  => ['image'],
				'selector' => '{{WRAPPER}} .bc-post-item .bc-post-item__feature-image a::before {',

			]
		);
		$this->add_responsive_control(
			'thumb_width',
			[
				'label'      => esc_html__('Width', '_pltdomain'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', '%', 'em', 'rem', 'vh', 'custom'],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .bc-post-item__feature-image' => 'flex: 0 0 {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'thumb_height',
			[
				'label'      => esc_html__('Height', '_pltdomain'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', '%', 'em', 'rem', 'vh', 'custom'],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 500,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .bc-post-item__feature-image img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'object-fit',
			[
				'label'     => esc_html__('Object Fit', '_pltdomain'),
				'type'      => Controls_Manager::SELECT,
				'condition' => [
					'thumb_height[size]!' => '',
				],
				'options'   => [
					''        => esc_html__('Default', '_pltdomain'),
					'fill'    => esc_html__('Fill', '_pltdomain'),
					'cover'   => esc_html__('Cover', '_pltdomain'),
					'contain' => esc_html__('Contain', '_pltdomain'),
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .bc-post-item__feature-image img' => 'object-fit: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'object-position',
			[
				'label'     => esc_html__('Object Position', '_pltdomain'),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'center center' => esc_html__('Center Center', '_pltdomain'),
					'center left'   => esc_html__('Center Left', '_pltdomain'),
					'center right'  => esc_html__('Center Right', '_pltdomain'),
					'top center'    => esc_html__('Top Center', '_pltdomain'),
					'top left'      => esc_html__('Top Left', '_pltdomain'),
					'top right'     => esc_html__('Top Right', '_pltdomain'),
					'bottom center' => esc_html__('Bottom Center', '_pltdomain'),
					'bottom left'   => esc_html__('Bottom Left', '_pltdomain'),
					'bottom right'  => esc_html__('Bottom Right', '_pltdomain'),
				],
				'default'   => 'center center',
				'selectors' => [
					'{{WRAPPER}} .bc-post-item__feature-image img' => 'object-position: {{VALUE}};',
				],
				'condition' => [
					'thumb_height[size]!' => '',
					'object-fit'          => 'cover',
				],
			]
		);

		// Border Radius
		$this->add_responsive_control(
			'thumb_border_radius',
			[
				'label'      => esc_html__('Border Radius', '_pltdomain'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em', 'rem'],
				'selectors'  => [
					'{{WRAPPER}} .bc-post-item__feature-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Thumbnail Bottom Spacing
		$this->add_responsive_control(
			'thumb_bottom_spacing',
			[
				'label'      => esc_html__('Bottom Spacing', '_pltdomain'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', '%', 'em', 'rem', 'vh', 'custom'],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
					'vh' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .bc-post-item__feature-image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Content style
		$this->start_controls_section(
			'section_style_post_content',
			[
				'label' => esc_html__('Content Wrapper', '_pltdomain'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'content_background',
				'types'     => ['classic', 'gradient'],
				'exclude'   => ['image'],
				'selector'  => '{{WRAPPER}} .bc-post-item__content',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => esc_html__('Padding', '_pltdomain'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
				'selectors'  => [
					'{{WRAPPER}} .bc-post-item__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Border Radius
		$this->add_responsive_control(
			'content_border_radius',
			[
				'label'      => esc_html__('Border Radius', '_pltdomain'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em', 'rem'],
				'selectors'  => [
					'{{WRAPPER}} .bc-post-item__content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		//Tile
		$this->start_controls_section(
			'section_style_post_title',
			[
				'label'     => esc_html__('Title', '_pltdomain'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__('Title Typography', '_pltdomain'),
				'selector' => '{{WRAPPER}} .bc-post-item__entry-title',
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label'      => esc_html__('Padding', '_pltdomain'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', 'rem', 'custom'],
				'selectors'  => [
					'{{WRAPPER}} .bc-post-item__entry-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'title_border',
				'selector' => '{{WRAPPER}} .bc-post-item__entry-title',
			]
		);

		// Spacing Bottom
		$this->add_responsive_control(
			'title_bottom_spacing',
			[
				'label'      => esc_html__('Bottom Spacing', '_pltdomain'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem', 'custom'],
				'range'      => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .bc-post-item__entry-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs('tabs_title_style');

		$this->start_controls_tab(
			'tab_title_normal',
			[
				'label' => esc_html__('Normal', '_pltdomain'),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__('Title Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bc-post-item__entry-title a' => 'color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_tile_hover',
			[
				'label' => esc_html__('Hover', '_pltdomain'),
			]
		);

		$this->add_control(
			'title_color_hover',
			[
				'label'     => esc_html__('Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bc-post-item__entry-title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();


		//Excerpt
		$this->start_controls_section(
			'section_style_post_excerpt',
			[
				'label'     => esc_html__('Excerpt', '_pltdomain'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'label'     => esc_html__('Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bc-post-item__blog-content-text, {{WRAPPER}} .bc-post-item__blog-content-text p' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'excerpt_typography',
				'selector' => '{{WRAPPER}} .bc-post-item__blog-content-text, {{WRAPPER}} .bc-post-item__blog-content-text p',
			]
		);

		$this->add_responsive_control(
			'excerpt_spacing',
			[
				'label'      => esc_html__('Spacing', '_pltdomain'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem', 'custom'],
				'range'      => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .bc-post-item__blog-content-text' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		//Meta
		$this->start_controls_section(
			'section_style_post_meta',
			[
				'label' => esc_html__('Meta', '_pltdomain'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Meta Wrappper Padding
		$this->add_responsive_control(
			'meta_wrapper_padding',
			[
				'label'      => esc_html__('Wrapper Padding', '_pltdomain'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', 'rem', 'custom'],
				'selectors'  => [
					'{{WRAPPER}} .bc-post-item__feature-image .bc-post-item__meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'preset_layout' => '1',
				],
			]
		);

		// Wrapper BG Color
		$this->add_control(
			'meta_wrapper_bg_color',
			[
				'label'     => esc_html__('Wrapper BG Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bc-post-item__feature-image .bc-post-item__meta, {{WRAPPER}} .bc-post-item__feature-image .bc-post-item__meta:before, {{WRAPPER}} .bc-post-item__feature-image .bc-post-item__meta:after' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'preset_layout' => '1',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'meta_typography',
				'selector' => '{{WRAPPER}} .bc-post-item__meta a, {{WRAPPER}} .bc-post-item__meta span, {{WRAPPER}} .author_views a, {{WRAPPER}} .author_views span.posts_views, {{WRAPPER}} .bc-post-item__date-meta',
			]
		);

		$this->add_responsive_control(
			'meta_padding',
			[
				'label'      => esc_html__('Padding', '_pltdomain'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', 'rem', 'custom'],
				'selectors'  => [
					'{{WRAPPER}} .bc-post-item__meta a, {{WRAPPER}} .bc-post-item__meta span, {{WRAPPER}} .author_views a, {{WRAPPER}} .author_views span.posts_views' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Border Radius
		$this->add_responsive_control(
			'meta_border_radius',
			[
				'label'      => esc_html__('Border Radius', '_pltdomain'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em', 'rem'],
				'selectors'  => [
					'{{WRAPPER}} .bc-post-item__meta a, {{WRAPPER}} .bc-post-item__meta span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Icon Size
		$this->add_responsive_control(
			'meta_icon_size',
			[
				'label'      => esc_html__('Icon Size', '_pltdomain'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem'],
				'range'      => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .bc-post-item__meta--style-inline-icon > div i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bc-post-item__meta--style-inline-icon > div svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'meta_style' => 'inline-icon',
				],
				'separator'  => 'before',
			]
		);

		// Icon Gap
		$this->add_responsive_control(
			'meta_icon_gap',
			[
				'label'      => esc_html__('Icon Gap', '_pltdomain'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem'],
				'range'      => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .bc-post-item__meta--style-inline-icon > div' => 'gap: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'meta_style' => 'inline-icon',
				],
			]
		);

		$this->add_responsive_control(
			'meta_spacing',
			[
				'label'      => esc_html__('Bottom Spacing', '_pltdomain'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem', 'custom'],
				'range'      => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .bc-post-item__meta' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Gap
		$this->add_responsive_control(
			'meta_gap',
			[
				'label'      => esc_html__('Meta Between Gap', '_pltdomain'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem', 'custom'],
				'range'      => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .bc-post-item__meta'                                                         => 'column-gap: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bc-post-item__meta.bc-post-item__meta--style-inline:not(:last-child) > div' => 'padding-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Separator Color
		$this->add_control(
			'meta_separator_color',
			[
				'label'     => esc_html__('Separator BG Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bc-post-item__meta.bc-post-item__meta--style-inline > div:after' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'meta_style' => 'inline',
				]
			]
		);

		// Separator Height
		$this->add_responsive_control(
			'meta_separator_height',
			[
				'label'      => esc_html__('Separator Height', '_pltdomain'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem', 'custom'],
				'range'      => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .bc-post-item__meta.bc-post-item__meta--style-inline > div:after' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'meta_style' => 'inline',
				]
			]
		);

		$this->start_controls_tabs(
			'meta_style_tabs'
		);

		$this->start_controls_tab(
			'meta_normal_tab',
			[
				'label' => esc_html__('Normal', '_pltdomain'),
			]
		);

		$this->add_control(
			'meta_color',
			[
				'label'     => esc_html__('Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bc-post-item__meta a, {{WRAPPER}} .bc-post-item__meta span, {{WRAPPER}} .author_views a, {{WRAPPER}} .author_views span.posts_views, {{WRAPPER}} .bc-post-item__date-meta' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'meta_year_color',
			[
				'label'     => esc_html__('Year Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bc-post-item__date-meta .year' => 'color: {{VALUE}};',
				],
				'condition' => [
					'preset_layout' => '6',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'meta_bg',
				'types'    => ['classic', 'gradient'],
				'exclude'  => ['image'],
				'selector' => '{{WRAPPER}} .bc-post-item__meta a, {{WRAPPER}} .bc-post-item__meta span, {{WRAPPER}} .author_views a, {{WRAPPER}} .author_views span.posts_views',

			]
		);

		// Border
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'meta_border',
				'selector' => '{{WRAPPER}} .bc-post-item__meta a, {{WRAPPER}} .bc-post-item__meta span',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'meta_hover_tab',
			[
				'label' => esc_html__('Hover', '_pltdomain'),
			]
		);

		$this->add_control(
			'meta_h_color',
			[
				'label'     => esc_html__('Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bc-post-item__meta a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'meta_h_bg',
				'types'    => ['classic', 'gradient'],
				'exclude'  => ['image'],
				'selector' => '{{WRAPPER}} .bc-post-item__meta a:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
		//Date Meta
		$this->start_controls_section(
			'section_style_post_date_meta',
			[
				'label'     => esc_html__('Date Meta', '_pltdomain'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'preset_layout' => '9'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'meta_date_typography',
				'selector' => '{{WRAPPER}} .bc-post-item__date-box-meta-number',
			]
		);


		$this->add_control(
			'date_meta_color',
			[
				'label'     => esc_html__('Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bc-post-item__date-box-meta-number' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'date_meta_bg',
				'types'    => ['classic', 'gradient'],
				'exclude'  => ['image'],
				'selector' => '{{WRAPPER}} .bc-post-item__date-box-meta-number',

			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'date_meta_border',
				'selector' => '{{WRAPPER}} .bc-post-item__date-box-meta-number',
			]
		);
		$this->add_responsive_control(
			'date_meta_border_radius',
			[
				'label'      => esc_html__('Border Radius', '_pltdomain'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em', 'rem'],
				'selectors'  => [
					'{{WRAPPER}} .bc-post-item__date-box-meta-number' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'date_meta_padding',
			[
				'label'      => esc_html__('Padding', '_pltdomain'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', 'rem', 'custom'],
				'selectors'  => [
					'{{WRAPPER}} .bc-post-item__date-box-meta-number' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();

		//Author
		$this->start_controls_section(
			'section_style_post_author',
			[
				'label'     => esc_html__('Author', '_pltdomain'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => ['preset_layout' => '4']
			]
		);

		$this->add_control(
			'author_color',
			[
				'label'     => esc_html__('Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .author .author-bio p' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'author_typography',
				'selector' => '{{WRAPPER}} .author .author-bio p',
			]
		);

		$this->add_responsive_control(
			'author_spacing',
			[
				'label'      => esc_html__('Spacing', '_pltdomain'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem', 'custom'],
				'range'      => [
					'px' => [
						'max' => 300,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .author' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'author_name_color',
			[
				'label'     => esc_html__('Name Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .author .author-bio a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'author_name_typography',
				'label'     => esc_html__('Name Typography', '_pltdomain'),
				'selector'  => '{{WRAPPER}} .author .author-bio a',
				'condition' => ['preset_layout' => '4']
			]
		);

		$this->end_controls_section();


		//Read More
		$this->start_controls_section(
			'style_post_read_more',
			[
				'label'     => esc_html__('Read More', '_pltdomain'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_read_more' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'read_more_typography',
				'selector' => '{{WRAPPER}} .bc-btn-link',
			]
		);

		$this->add_responsive_control(
			'read_more_icon_size',
			[
				'label'      => esc_html__('Icon Size', '_pltdomain'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range'      => [
					'px' => [
						'min'  => 1,
						'max'  => 100,
						'step' => 1,
					],
					'%'  => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .bc-btn-link i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bc-btn-link svg' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'read_more_border',
				'selector'  => '{{WRAPPER}} .bc-btn-link',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'read_more_border_radius',
			[
				'label'      => esc_html__('Border Radius', '_pltdomain'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em', 'rem', 'custom'],
				'selectors'  => [
					'{{WRAPPER}} .bc-btn-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'read_more_padding',
			[
				'label'      => esc_html__('Padding', '_pltdomain'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
				'selectors'  => [
					'{{WRAPPER}} .bc-btn-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'read_more_shadow',
				'selector' => '{{WRAPPER}} .bc-btn-link',
			]
		);


		$this->add_responsive_control(
			'read_more_spacing',
			[
				'label'      => esc_html__('Spacing', '_pltdomain'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem', 'custom'],
				'range'      => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .bc-btn-link' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'tabs_read_more_style',
		);

		$this->start_controls_tab(
			'tab_read_more_normal',
			[
				'label' => esc_html__('Normal', '_pltdomain'),
			]
		);

		$this->add_control(
			'read_more_color',
			[
				'label'     => esc_html__('Text Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .bc-btn-link'       => 'color: {{VALUE}};',
					'{{WRAPPER}} .bc-btn-link svg'   => 'fill: {{VALUE}};',
					'{{WRAPPER}} .bc-btn-link:after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'read_more_background',
				'types'    => ['classic', 'gradient'],
				'exclude'  => ['image'],
				'selector' => '{{WRAPPER}} .bc-btn-link',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_read-more_hover',
			[
				'label' => esc_html__('Hover', '_pltdomain'),
			]
		);

		$this->add_control(
			'read_more_text_hover_color',
			[
				'label'     => esc_html__('Text Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bc-btn-link:hover'       => 'color: {{VALUE}};',
					'{{WRAPPER}} .bc-btn-link:hover svg'   => 'fill: {{VALUE}};',
					'{{WRAPPER}} .bc-btn-link:hover:after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'read_more_hover_background',
				'types'    => ['classic', 'gradient'],
				'exclude'  => ['image'],
				'selector' => '{{WRAPPER}} .bc-btn-link:hover',
			]
		);

		$this->add_control(
			'read_more_hover_border_color',
			[
				'label'     => esc_html__('Border Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bc-btn-link:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'read_more_border_border!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		//pagination
		$this->register_pagination_section_controls();
		$this->register_slider_section_controls();

		//hover color
		$this->start_controls_section(
			'section_style_hover_post_content',
			[
				'label' => esc_html__('Hover', '_pltdomain'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		//tile
		$this->add_control(
			'heading_title_hover_style',
			[
				'label'     => esc_html__('Title', '_pltdomain'),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label'     => esc_html__('Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bc-post-item:hover .title, {{WRAPPER}} .bc-post-item:hover .title a' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		//excerpt
		$this->add_control(
			'heading_excerpt_hover_style',
			[
				'label'     => esc_html__('Excerpt', '_pltdomain'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_control(
			'excerpt_hover_color',
			[
				'label'     => esc_html__('Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bc-post-item:hover .bc-blog-item__content, {{WRAPPER}} .bc-post-item:hover .bc-blog-item__content p' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		//taxonomy
		$this->add_control(
			'heading_taxonomy_hover_style',
			[
				'label'     => esc_html__('Taxonomy', '_pltdomain'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'show_taxonomy' => 'yes',
				],
			]
		);

		$this->add_control(
			'taxonomy_hover_color',
			[
				'label'     => esc_html__('Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bc-post-item:hover .bc-categories a' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_taxonomy' => 'yes',
				],
			]
		);

		//meta
		$this->add_control(
			'heading_meta_hover_style',
			[
				'label'     => esc_html__('Meta', '_pltdomain'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'meta_hover_color',
			[
				'label'     => esc_html__('Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bc-post-item:hover .bc-post-item__meta a, {{WRAPPER}} .bc-post-item:hover .bc-post-item__meta span' => 'color: {{VALUE}};',
				],
			]
		);

		//author
		$this->add_control(
			'heading_author_hover_style',
			[
				'label'     => esc_html__('Author', '_pltdomain'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => ['preset_layout' => '4']
			]
		);

		$this->add_control(
			'author_hover_color',
			[
				'label'     => esc_html__('Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bc-post-item:hover .author .author-bio p' => 'color: {{VALUE}};',
				],
				'condition' => ['preset_layout' => '4']
			]
		);

		$this->add_control(
			'author_name_hover_color',
			[
				'label'     => esc_html__('Name Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .bc-post-item:hover .author .author-bio a' => 'color: {{VALUE}};',
				],
				'condition' => ['preset_layout' => '4']
			]
		);

		//read more
		$this->add_control(
			'heading_read_more_hover_style',
			[
				'label'     => esc_html__('Read More', '_pltdomain'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'show_read_more' => 'yes',
				],
			]
		);

		$this->add_control(
			'read_more_hover_text_color',
			[
				'label'     => esc_html__('Text Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bc-post-item:hover .link'       => 'color: {{VALUE}};',
					'{{WRAPPER}} .bc-post-item:hover .link svg'   => 'fill: {{VALUE}};',
					'{{WRAPPER}} .bc-post-item:hover .link:after' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'show_read_more' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'read_more_hover_link_background',
				'types'     => ['classic', 'gradient'],
				'exclude'   => ['image'],
				'selector'  => '{{WRAPPER}} .bc-post-item:hover .link',
				'condition' => [
					'show_read_more' => 'yes',
				],
			]
		);

		$this->add_control(
			'read_more_hover_link_border_color',
			[
				'label'     => esc_html__('Border Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bc-post-item:hover .link' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'read_more_border_border!' => '',
					'show_read_more'           => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_design_layout_controls()
	{
		$this->start_controls_section(
			'section_design_layout',
			[
				'label' => esc_html__('Layout', '_pltdomain'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'column_gap',
			[
				'label'      => esc_html__('Columns Gap', '_pltdomain'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem', 'custom'],
				'default'    => [
					'size' => 30,
				],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .bc-posts-items'                         => 'column-gap: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .bc-posts-wrapper.style-6 .bc-post-item' => 'column-gap: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label'      => esc_html__('Rows Gap', '_pltdomain'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem', 'custom'],
				'default'    => [
					'size' => 35,
				],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .bc-posts-items' => 'row-gap: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'post_border',
				'separator' => 'before',
				'selector'  => '{{WRAPPER}} .bc-post-item',
			]
		);

		$this->add_responsive_control(
			'post_padding',
			[
				'label'      => esc_html__('Padding', '_pltdomain'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em', 'rem', 'custom'],
				'selectors'  => [
					'{{WRAPPER}} .bc-post-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'post_margin',
			[
				'label'      => esc_html__('Margin', '_pltdomain'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em', 'rem', 'custom'],
				'selectors'  => [
					'{{WRAPPER}} .bc-post-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		//hover effect
		$this->add_control(
			'el_hover_effects',
			[
				'label'        => esc_html__('Hover Effect', '_pltdomain'),
				'description'  => esc_html__('This effect will work only on image tags.', '_pltdomain'),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'effect-zoom-in',
				'options'      => [
					''                => esc_html__('None', '_pltdomain'),
					'effect-zoom-in'  => esc_html__('Zoom In', '_pltdomain'),
					'effect-zoom-out' => esc_html__('Zoom Out', '_pltdomain'),
					'left-move'       => esc_html__('Left Move', '_pltdomain'),
					'right-move'      => esc_html__('Right Move', '_pltdomain'),
				],
				'prefix_class' => 'wcf--image-',
			]
		);

		$this->add_control(
			'alignment',
			[
				'label'     => esc_html__('Alignment', '_pltdomain'),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'start'  => [
						'title' => esc_html__('Left', '_pltdomain'),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', '_pltdomain'),
						'icon'  => 'eicon-text-align-center',
					],
					'end'    => [
						'title' => esc_html__('Right', '_pltdomain'),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bc-post-item'                                   => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .content'                                        => 'align-items: {{VALUE}};',
					'{{WRAPPER}} .bc-categories, {{WRAPPER}} .bc-post-item__meta' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	public function register_pagination_section_controls()
	{
		$this->start_controls_section(
			'section_pagination',
			[
				'label' => esc_html__('Pagination', '_pltdomain'),
			]
		);

		$this->add_control(
			'pagination_type',
			[
				'label'   => esc_html__('Pagination', '_pltdomain'),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''                      => esc_html__('None', '_pltdomain'),
					'numbers_and_prev_next' => esc_html__('Numbers', '_pltdomain').' + '.esc_html__('Previous/Next', '_pltdomain'),
					'load_more'             => esc_html__('Load More', '_pltdomain'),
				],
			]
		);

		$this->add_control(
			'pagination_list',
			[
				'label'     => esc_html__('Style', '_pltdomain'),
				'type'      => Controls_Manager::SELECT,
				'default'   => '1',
				'options'   => [
					'1' => esc_html__('One', '_pltdomain'),
					'2' => esc_html__('Two', '_pltdomain'),
				],
				'condition' => [
					'pagination_type' => 'numbers_and_prev_next',
				],
			]
		);

		$this->add_control(
			'pagination_page_limit',
			[
				'label'     => esc_html__('Page Limit', '_pltdomain'),
				'default'   => '5',
				'condition' => [
					'pagination_type' => 'numbers_and_prev_next',
				],
			]
		);

		$this->add_control(
			'pagination_numbers_shorten',
			[
				'label'     => esc_html__('Shorten', '_pltdomain'),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'condition' => [
					'pagination_type' => 'numbers_and_prev_next',
				],
			]
		);

		$this->add_control(
			'navigation_prev_icon',
			[
				'label'            => esc_html__('Previous Arrow Icon', '_pltdomain'),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'skin'             => 'inline',
				'label_block'      => false,
				'skin_settings'    => [
					'inline' => [
						'none' => [
							'label' => 'Default',
							'icon'  => 'eicon-chevron-left',
						],
						'icon' => [
							'icon' => 'eicon-star',
						],
					],
				],
				'recommended'      => [
					'fa-regular' => [
						'arrow-alt-circle-left',
						'caret-square-left',
					],
					'fa-solid'   => [
						'angle-double-left',
						'angle-left',
						'arrow-alt-circle-left',
						'arrow-circle-left',
						'arrow-left',
						'caret-left',
						'caret-square-left',
						'chevron-circle-left',
						'chevron-left',
						'long-arrow-alt-left',
					],
				],
				'condition'        => [
					'pagination_type' => [
						'numbers',
						'numbers_and_prev_next',
					],
				],
			]
		);

		$this->add_control(
			'navigation_next_icon',
			[
				'label'            => esc_html__('Next Arrow Icon', '_pltdomain'),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'skin'             => 'inline',
				'label_block'      => false,
				'skin_settings'    => [
					'inline' => [
						'none' => [
							'label' => 'Default',
							'icon'  => 'eicon-chevron-right',
						],
						'icon' => [
							'icon' => 'eicon-star',
						],
					],
				],
				'recommended'      => [
					'fa-regular' => [
						'arrow-alt-circle-right',
						'caret-square-right',
					],
					'fa-solid'   => [
						'angle-double-right',
						'angle-right',
						'arrow-alt-circle-right',
						'arrow-circle-right',
						'arrow-right',
						'caret-right',
						'caret-square-right',
						'chevron-circle-right',
						'chevron-right',
						'long-arrow-alt-right',
					],
				],
				'condition'        => [
					'pagination_type' => [
						'numbers',
						'numbers_and_prev_next',
					],
				],
			]
		);

		$this->add_control(
			'pagination_align',
			[
				'label'     => esc_html__('Alignment', '_pltdomain'),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__('Left', '_pltdomain'),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', '_pltdomain'),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__('Right', '_pltdomain'),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .post-pagination' => 'justify-content: {{VALUE}};',
					'{{WRAPPER}} .pf-load-more'    => 'justify-content: {{VALUE}};',
				],
				'condition' => [
					'pagination_type!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'pagination_spacing_top',
			[
				'label'      => esc_html__('Spacing Top', '_pltdomain'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem', 'custom'],
				'default'    => [
					'size' => 70,
				],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .post-pagination' => 'margin-top: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .pf-load-more'    => 'margin-top: {{SIZE}}{{UNIT}}',
				],
				'condition'  => [
					'pagination_type!' => '',
				],
			]
		);

		//load more btn
		$this->add_control(
			'heading_load_more_button',
			[
				'label'     => esc_html__('Button', '_pltdomain'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'pagination_type' => 'load_more',
				],
			]
		);

		$this->add_control(
			'load_more_btn_text',
			[
				'label'       => esc_html__('Text', '_pltdomain'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__('Load More Works', '_pltdomain'),
				'placeholder' => esc_html__('Load More', '_pltdomain'),
				'condition'   => [
					'pagination_type' => 'load_more',
				],
			]
		);

		$this->add_control(
			'load_more_btn_icon',
			[
				'label'            => esc_html__('Icon', '_pltdomain'),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default'          => [
					'value'   => 'fas fa-arrow-right',
					'library' => 'fa-solid',
				],
				'condition'        => [
					'pagination_type' => 'load_more',
				],
			]
		);
		//load more

		$this->end_controls_section();

		// Pagination style controls for prev/next and numbers pagination.
		$this->start_controls_section(
			'section_pagination_style',
			[
				'label'     => esc_html__('Pagination', '_pltdomain'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pagination_type' => 'numbers_and_prev_next',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'pagination_typography',
				'selector' => '{{WRAPPER}} .post-pagination .page-numbers',
			]
		);

		$this->start_controls_tabs('pagination_colors');

		$this->start_controls_tab(
			'pagination_color_normal',
			[
				'label' => esc_html__('Normal', '_pltdomain'),
			]
		);

		$this->add_control(
			'pagination_color',
			[
				'label'     => esc_html__('Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .post-pagination .page-numbers:not(.current, .next, .prev, .dots)' => 'color: {{VALUE}}; fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pagination_bg_color',
			[
				'label'     => esc_html__('Background Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .post-pagination .page-numbers:not(.prev, .next, .dots)' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'pagination_list' => '2',
				],
			]
		);
		// Border
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'pagination_border',
				'label'    => esc_html__('Border', '_pltdomain'),
				'selector' => '{{WRAPPER}} .post-pagination .page-numbers:not(.prev, .next, .dots)',
			]
		);
		$this->add_responsive_control(
			'pagination_radius',
			[
				'label'      => esc_html__('Border Radius', '_pltdomain'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors'  => [
					'{{WRAPPER}} .post-pagination .page-numbers:not(.prev, .next, .dots)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		// $this->add_control(
		// 	'pagination_border_color',
		// 	[
		// 		'label'     => esc_html__('Border Color', '_pltdomain'),
		// 		'type'      => Controls_Manager::COLOR,
		// 		'selectors' => [
		// 			'{{WRAPPER}} .post-pagination .page-numbers:not(.prev, .next, .dots)' => 'border-color: {{VALUE}};',
		// 		],
		// 		'condition' => [
		// 			'pagination_list' => '2',
		// 		],
		// 	]
		// );

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pagination_color_hover',
			[
				'label' => esc_html__('Hover', '_pltdomain'),
			]
		);

		$this->add_control(
			'pagination_hover_color',
			[
				'label'     => esc_html__('Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .post-pagination .page-numbers:not(.dots):hover, {{WRAPPER}} .post-pagination .page-numbers.current' => 'color: {{VALUE}}; fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pagination_hover_bg_color',
			[
				'label'     => esc_html__('Background Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .post-pagination .page-numbers.current, {{WRAPPER}} .post-pagination .page-numbers:not(.prev, .next, .dots):hover' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'pagination_list' => '2',
				],
			]
		);

		// Border Color
		$this->add_control(
			'pagination_border_color_hover',
			[
				'label'     => esc_html__('Border Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .post-pagination .page-numbers:not(.prev, .next, .dots):hover, {{WRAPPER}} .post-pagination .page-numbers.current:not(.prev, .next, .dots)' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'pagination_list' => '2',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'pagination_spacing',
			[
				'label'      => esc_html__('Space Between', '_pltdomain'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem', 'custom'],
				'separator'  => 'before',
				'default'    => [
					'size' => 10,
				],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .post-pagination' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Next Previous Icon Style
		$this->add_control(
			'pagination_prev_next_icon_size',
			[
				'label'      => esc_html__('Icon Size', '_pltdomain'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem', 'custom'],
				'default'    => [
					'size' => 16,
				],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .post-pagination .page-numbers.prev i, {{WRAPPER}} .post-pagination .page-numbers.next i'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .post-pagination .page-numbers.prev svg, {{WRAPPER}} .post-pagination .page-numbers.next svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Color for Next Previous Icon
		$this->add_control(
			'pagination_prev_next_icon_color',
			[
				'label'     => esc_html__('Icon Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .post-pagination .page-numbers.prev i, {{WRAPPER}} .post-pagination .page-numbers.next i'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .post-pagination .page-numbers.prev svg, {{WRAPPER}} .post-pagination .page-numbers.next svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
					'pagination_type' => 'numbers_and_prev_next',
				],
			]
		);

		// Hover Color for Next Previous Icon
		$this->add_control(
			'pagination_prev_next_icon_hover_color',
			[
				'label'     => esc_html__('Icon Hover Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .post-pagination .page-numbers.prev:hover i, {{WRAPPER}} .post-pagination .page-numbers.next:hover i'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .post-pagination .page-numbers.prev:hover svg, {{WRAPPER}} .post-pagination .page-numbers.next:hover svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
					'pagination_type' => 'numbers_and_prev_next',
				],
			]
		);

		$this->end_controls_section();

		// Wrapper
		$this->start_controls_section(
			'section_wrapper_style',
			[
				'label' => esc_html__('Wrapper', '_pltdomain'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'wrapper_padding',
			[
				'label'      => esc_html__('Padding', '_pltdomain'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em', 'rem'],
				'selectors'  => [
					'{{WRAPPER}} .bc-post-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'wrapper_border_radius',
			[
				'label'      => esc_html__('Border Radius', '_pltdomain'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em', 'rem'],
				'selectors'  => [
					'{{WRAPPER}} .bc-post-item, {{WRAPPER}} .bc-post-item--style-8 .bc-post-item__feature-image a ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Tab Normal
		$this->start_controls_tabs('tabs_wrapper_style');

		$this->start_controls_tab(
			'tab_wrapper_normal',
			[
				'label' => esc_html__('Normal', '_pltdomain'),
			]
		);

		// Background
		$this->add_control(
			'wrapper_background_color',
			[
				'label'     => esc_html__('Background Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bc-post-item, {{WRAPPER}} .small-post' => 'background-color: {{VALUE}};',
				],
			]
		);

		// Border
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'wrapper_border',
				'selector' => '{{WRAPPER}} .bc-post-item',
			]
		);

		// Box Shadow
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'wrapper_box_shadow',
				'selector' => '{{WRAPPER}} .bc-post-item',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_wrapper_hover',
			[
				'label' => esc_html__('Hover', '_pltdomain'),
			]
		);

		// Background
		$this->add_control(
			'wrapper_background_color_hover',
			[
				'label'     => esc_html__('Background Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bc-post-item:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		// Border Color
		$this->add_control(
			'wrapper_border_color_hover',
			[
				'label'     => esc_html__('Border Color', '_pltdomain'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bc-post-item:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		// Box Shadow
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'box_shadow_hover',
				'selector' => '{{WRAPPER}} .bc-post-item:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	public function register_slider_section_controls()
	{
		$this->start_controls_section(
			'section_slider',
			[
				'label' => esc_html__('Slider Settings', '_pltdomain'),
			]
		);
		$this->add_control(
			'enable_slider',
			[
				'label'        => esc_html__('Enable Slider', '_pltdomain'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', '_pltdomain'),
				'label_off'    => esc_html__('No', '_pltdomain'),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->add_control(
			'slides_per_view',
			[
				'label'     => esc_html__('Slider Per View', '_pltdomain'),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '3',
				'condition' => [
					'enable_slider' => ['yes']
				]
			]
		);

		$this->add_control('navigation', [
			'label'        => esc_html__('Navigation', '_pltdomain'),
			'type'         => Controls_Manager::SWITCHER,
			'label_on'     => esc_html__('Show', '_pltdomain'),
			'label_off'    => esc_html__('Hide', '_pltdomain'),
			'return_value' => 'yes',
			'default'      => 'no',
			'condition'    => [
				'enable_slider' => ['yes']
			]
		]);


		$this->add_control('loop', [
			'label'        => esc_html__('Loop', '_pltdomain'),
			'type'         => Controls_Manager::SWITCHER,
			'label_on'     => esc_html__('On', '_pltdomain'),
			'label_off'    => esc_html__('Off', '_pltdomain'),
			'return_value' => 'yes',
			'default'      => 'yes',
			'condition'    => [
				'enable_slider' => ['yes']
			]
		]);

		$this->add_control('speed', [
			'label'     => __('Speed', '_pltdomain'),
			'type'      => Controls_Manager::NUMBER,
			'default'   => 700,
			'condition' => [
				'enable_slider' => ['yes']
			]
		]);

		$this->add_control('autoplay', [
			'label'        => esc_html__('Autoplay', '_pltdomain'),
			'type'         => Controls_Manager::SWITCHER,
			'label_on'     => esc_html__('On', '_pltdomain'),
			'label_off'    => esc_html__('Off', '_pltdomain'),
			'return_value' => 'yes',
			'default'      => 'yes',
			'condition'    => [
				'enable_slider' => ['yes']
			]
		]);

		$this->add_control('autoplay_time', [
			'label'     => __('Autoplay Time', '_pltdomain'),
			'type'      => Controls_Manager::NUMBER,
			'default'   => 9000,
			'condition' => [
				'enable_slider' => ['yes']
			]
		]);

		// Space Between
		$this->add_control(
			'space_between',
			[
				'label'     => esc_html__('Space Between', '_pltdomain'),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'max'       => 100,
				'step'      => 1,
				'default'   => 48,
				'condition' => [
					'enable_slider' => ['yes']
				]
			]
		);
		$this->add_control(
			'freeMode',
			[
				'label'        => esc_html__('Free Mode', '_pltdomain'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', '_pltdomain'),
				'label_off'    => esc_html__('No', '_pltdomain'),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [
					'enable_slider' => ['yes']
				]
			]
		);

		$this->add_control(
			'responsive',
			[
				'label'        => esc_html__('Responsive', '_pltdomain'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', '_pltdomain'),
				'label_off'    => esc_html__('No', '_pltdomain'),
				'return_value' => 'yes',
				'default'      => 'no',
				'separator'    => 'before',
				'condition'    => [
					'enable_slider' => ['yes']
				]
			]
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'device_width',
			[
				'label'   => __('Max Width', '_pltdomain'),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => 10000,
				'step'    => 1,
				'default' => '',
			]
		);
		$repeater->add_control(
			'slidesPerView',
			[
				'label'       => __('SlidesPerView', '_pltdomain'),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 0,
				'max'         => 200,
				'step'        => 1,
				'default'     => 1,
				'description' => __('Set zero for  auto (or) Set any number which you want to display.', '_pltdomain'),
			]
		);
		$repeater->add_control(
			'slidesPerGroup',
			[
				'label'   => __('Slides To Scroll', '_pltdomain'),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 200,
				'step'    => 1,
				'default' => 1,
			]
		);
		$repeater->add_control(
			'spaceBetween',
			[
				'label'   => __('SpaceBetween', '_pltdomain'),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => 200,
				'step'    => 1,
				'default' => '',
			]
		);
		$repeater->add_control(
			'slidesPerGroupSkip',
			[
				'label'   => __('slidesPerGroupSkip', '_pltdomain'),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 20,
				'step'    => 1,
				'default' => '',
			]
		);

		$repeater->add_control(
			'slidesFreeMode',
			[
				'label'        => esc_html__('FreeMode', '_pltdomain'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', '_pltdomain'),
				'label_off'    => esc_html__('No', '_pltdomain'),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'resposive_settings',
			[
				'label'       => __('Responsive', '_pltdomain'),
				'show_label'  => false,
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'device_width'   => 320,
						'slidesPerView'  => 2,
						'slidesPerGroup' => 1,
						'spaceBetween'   => 20,
					],
					[
						'device_width'   => 480,
						'slidesPerView'  => 3,
						'slidesPerGroup' => 1,
						'spaceBetween'   => 20,
					],
					[
						'device_width'   => 640,
						'slidesPerView'  => 2,
						'slidesPerGroup' => 1,
						'spaceBetween'   => 20,
					],
					[
						'device_width'   => 768,
						'slidesPerView'  => 4,
						'slidesPerGroup' => 1,
						'spaceBetween'   => 40,
					],
					[
						'device_width'   => 1024,
						'slidesPerView'  => 5,
						'slidesPerGroup' => 1,
						'spaceBetween'   => 50,
					],
				],
				'title_field' => 'Breakpoint: {{{ device_width }}}',
				'condition'   => [
					'responsive' => ['yes'],
				],
			]
		);
		$this->add_control(
			'slider_overflow',
			[
				'label'     => esc_html__('Overflow', '_pltdomain'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'hidden',
				'options'   => [
					'hidden'  => esc_html__('Hidden', '_pltdomain'),
					'visible' => esc_html__('Visible', '_pltdomain'),
				],
				'condition' => [
					'enable_slider' => ['yes']
				]
			]
		);

		$this->end_controls_section();
	}

	public function get_current_page()
	{
		if ('' === $this->get_settings_for_display('pagination_type')) {
			return 1;
		}

		return max(1, get_query_var('paged'), get_query_var('page'));
	}

	/**
	 * Render the widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render()
	{
		$settings = $this->get_settings_for_display();

		$query = $this->get_query();

		if (!$query->found_posts) {
			return;
		}

		//wrapper class
		$this->add_render_attribute('wrapper', 'class', [
			'bc-posts-wrapper',
			'bc-post-wrapper-'.$settings['preset_layout']
		]);

		// Article class
		$this->add_render_attribute('article', 'class', array_merge(
			['bc-post-item', 'bc-post-item--style-'.$settings['preset_layout'], 'bc-post-item-image-position-'.$settings['image_position']],

			get_post_class()
		));
		if ($settings['enable_slider'] === 'yes') {
			$slider_options = $this->get_slider_options($settings);
			$this->add_render_attribute('wrapper', [
				'class'         => ["bc-post-slider-enable bc-post-slider-overflow--{$settings['slider_overflow']}"],
				'data-controls' => wp_json_encode($slider_options),
			]);
		}

		?>
        <div <?php $this->print_render_attribute_string('wrapper'); ?>><?php

		$preset_layout = $settings['preset_layout'];
		$this->render_loop_header();

		while ($query->have_posts()) {
			$query->the_post();

			if ($preset_layout == '6') {
				$this->render_preset_layout_six_list($settings);
			} elseif ($preset_layout == '9') {
				$this->render_overlay_post($settings);
			} else {
				$this->render_post($settings);
			}
		}

		$this->render_loop_footer();

		?></div><?php

		wp_reset_postdata();
	}

	protected function render_loop_header()
	{
		$swiper_wrapper = $this->get_settings_for_display('enable_slider') === 'yes' ? 'swiper-container' : '';
		?>
        <div class="<?php echo esc_attr($swiper_wrapper); ?> bc-posts-items column--<?php echo esc_attr($this->get_settings_for_display('columns')); ?> ">
		<?php if ($this->get_settings_for_display('enable_slider') === 'yes') : ?>
        <div class="swiper-wrapper">
	<?php endif; ?>
		<?php
	}

	protected function render_loop_footer()
	{
		?>
		<?php if ($this->get_settings_for_display('enable_slider') === 'yes') : ?>

        </div>
		<?php if ($this->get_settings_for_display('navigation') === 'yes') : ?>
            <div class="bc-post__prev_next">
                <div class="bc-post__prev">
                    <i class="feather-arrow-left"></i>
                </div>
                <div class="bc-post__next">
                    <i class="feather-arrow-right"></i>
                </div>
            </div>
		<?php endif; ?>
	<?php endif; ?>
        </div><?php

		$settings = $this->get_settings_for_display();

		// If the skin has no pagination, there's nothing to render in the loop footer.
		if (!isset($settings['pagination_type'])) {
			return;
		}

		if ('' === $settings['pagination_type']) {
			return;
		}

		//load more
		if ('load_more' === $settings['pagination_type']) {
			$current_page = $this->get_current_page();
			$next_page = intval($current_page) + 1;

			$this->add_render_attribute('load_more_anchor', [
				'data-e-id'      => $this->get_id(),
				'data-page'      => $current_page,
				'data-max-page'  => $this->get_query()->max_num_pages,
				'data-next-page' => $this->next_page_link($next_page),
			]);

			//icon
			if (empty($settings['icon']) && !Icons_Manager::is_migration_allowed()) {
				// add old default
				$settings['icon'] = 'fa fa-arrow-right';
			}

			if (!empty($settings['icon'])) {
				$this->add_render_attribute('icon', 'class', $settings['icon']);
				$this->add_render_attribute('icon', 'aria-hidden', 'true');
			}

			$migrated = isset($settings['__fa4_migrated']['load_more_btn_icon']);
			$is_new = empty($settings['icon']) && Icons_Manager::is_migration_allowed();
			?>
            <div class="load-more-anchor" <?php $this->print_render_attribute_string('load_more_anchor'); ?>></div>

            <div class="pf-load-more">
                <button class="load-more">
					<?php $this->print_unescaped_setting('load_more_btn_text'); ?>
					<?php if ($is_new || $migrated) :
						Icons_Manager::render_icon($settings['load_more_btn_icon'], ['aria-hidden' => 'true']);
					else : ?>
                        <i <?php $this->print_render_attribute_string('icon'); ?>></i>
					<?php endif; ?>
                </button>
            </div>
			<?php
		}

		$page_limit = $this->get_query()->max_num_pages;

		// Page limit control should not effect in load more mode.
		if ('' !== $settings['pagination_page_limit'] && 'load_more' !== $settings['pagination_type']) {
			$page_limit = min($settings['pagination_page_limit'], $page_limit);
		}

		if (2 > $page_limit) {
			return;
		}

		//number and prev next
		if ('numbers_and_prev_next' === $settings['pagination_type']) {
			$paginate_args = [
				'current'            => $this->get_current_page(),
				'total'              => $page_limit,
				'prev_next'          => true,
				'prev_text'          => sprintf('%1$s', $this->render_next_prev_button('prev')),
				'next_text'          => sprintf('%1$s', $this->render_next_prev_button('next')),
				'show_all'           => 'yes' !== $settings['pagination_numbers_shorten'],
				'before_page_number' => '<span class="elementor-screen-only">'.esc_html__('Page', '_pltdomain').'</span>',
			];

			//pagination class
			$this->add_render_attribute('pagination', 'class', [
				'post-pagination',
				'style-'.$settings['pagination_list'],
			]);
			?>
            <nav <?php $this->print_render_attribute_string('pagination'); ?>
                    aria-label="<?php esc_attr_e('Pagination', '_pltdomain'); ?>">
				<?php echo wp_kses_post(paginate_links($paginate_args)); ?>
            </nav>
			<?php
		}
	}

	private function render_next_prev_button($type)
	{
		$direction = 'next' === $type ? 'right' : 'left';
		$icon_settings = $this->get_settings('navigation_'.$type.'_icon');

		if (empty($icon_settings['value'])) {
			$icon_settings = [
				'library' => 'eicons',
				'value'   => 'eicon-chevron-'.$direction,
			];
		}

		$text = '';
		if ('1' === $this->get_settings('pagination_list')) {
			$text = $type;
		}

		if ('next' === $type) {
			return esc_html($text).' '.Icons_Manager::try_get_icon_html($icon_settings, ['aria-hidden' => 'true']);
		} else {
			return Icons_Manager::try_get_icon_html($icon_settings, ['aria-hidden' => 'true']).' '.esc_html($text);
		}
	}

	protected function render_thumbnail($settings)
	{
		$settings['thumbnail_size'] = [
			'id' => get_post_thumbnail_id(),
		];
		// PHPCS - `get_permalink` is safe.
		?>
        <div class="bc-post-item__feature-image">
            <a href="<?php echo esc_url(get_permalink()); ?>" aria-label="<?php the_title(); ?>">
				<?php Group_Control_Image_Size::print_attachment_image_html($settings, 'thumbnail_size'); ?>
            </a>

			<?php if ($settings['show_date'] && in_array($settings['preset_layout'], ['1', '2', '8'])) : ?>
                <div class="bc-post-item__date-box-meta">
                    <span class="day"><?php echo get_the_date('d'); ?></span>
                    <span class="month"><?php echo get_the_date('M'); ?></span>
                </div>
			<?php endif; ?>

			<?php if ($settings['show_date_image'] && in_array($settings['preset_layout'], ['9'])) : ?>
                <div class="bc-post-item__date-box-meta-number">
                    <span class="day"><?php echo get_the_date('d'); ?></span>.
                    <span class="month"><?php echo get_the_date('m'); ?></span>
                </div>
			<?php endif; ?>

        </div>
		<?php
	}

	protected function render_title()
	{
		if (!$this->get_settings('show_title')) {
			return;
		}

		$tag = $this->get_settings('title_tag');
		?>
        <<?php Utils::print_validated_html_tag($tag); ?> class="bc-post-item__entry-title">
        <a href="<?php echo esc_url(get_the_permalink()); ?>">
			<?php
			global $post;
			// Force the manually-generated Excerpt length as well if the user chose to enable 'apply_to_custom_excerpt'.
			if (!empty($post->post_title)) {
				$max_length = (int) $this->get_settings('title_length');
				$title = $this->trim_words(get_the_title(), $max_length);

				echo wp_kses_post($title); // Wrap first 2 words

			} else {
				the_title();
			}
			?>
        </a>
        </<?php Utils::print_validated_html_tag($tag); ?>>
		<?php
	}

	public function filter_excerpt_length()
	{
		return (int) $this->get_settings('excerpt_length');
	}

	public static function trim_words($text, $length)
	{
		if ($length && str_word_count($text) > $length) {
			$text = explode(' ', $text, $length + 1);
			unset($text[$length]);
			$text = implode(' ', $text).'...';
		}

		return $text;
	}

	protected function render_excerpt()
	{
		if (!$this->get_settings('show_excerpt')) {
			return;
		}
		add_filter('excerpt_length', [$this, 'filter_excerpt_length'], 20);
		?>
        <div class="bc-post-item__blog-content-text">
			<?php
			global $post;
			// Force the manually-generated Excerpt length as well if the user chose to enable 'apply_to_custom_excerpt'.
			if (empty($post->post_excerpt)) {
				$max_length = (int) $this->get_settings('excerpt_length');
				$excerpt = apply_filters('the_excerpt', get_the_excerpt());
				$excerpt = $this->trim_words($excerpt, $max_length);
				echo wp_kses_post($excerpt);
			} else {
				the_excerpt();
			}
			?>
        </div>
		<?php
		remove_filter('excerpt_length', [$this, 'filter_excerpt_length'], 20);
	}

	protected function render_date_by_type($type = 'publish')
	{
		if (!$this->get_settings('show_date')) {
			return;
		}
		?>
        <div class="bc-post-item__date-meta">
			<?php if ('inline-icon' === $this->get_settings('meta_style')) : ?>
                <span class="bc-post-item__icon">
					<?php Icons_Manager::render_icon($this->get_settings('meta_icon'), ['aria-hidden' => 'true']); ?>
				</span>
			<?php endif; ?>

            <span>
				<?php
				switch ($type):
					case 'modified':
						$date = get_the_modified_date();
						break;
					default:
						$date = get_the_date();
				endswitch;
				/** This filter is documented in wp-includes/general-template.php */
				// PHPCS - The date is safe.
				echo apply_filters('the_date', $date, get_option('date_format'), '', ''); // phpcs:ignore
				?>
			</span>
        </div>
		<?php
	}

	protected function render_comment()
	{
		if ('yes' !== $this->get_settings('show_comment')) {
			return;
		}
		?>
        <div class="bc-post-item__comment">

			<?php if ('inline-icon' === $this->get_settings('meta_style')) : ?>
                <span class="bc-post-item__icon">
					<?php Icons_Manager::render_icon($this->get_settings('meta_icon'), ['aria-hidden' => 'true']); ?>
				</span>
			<?php endif; ?>

            <span><?php comments_number(); ?></span>
        </div>
		<?php
	}

	protected function render_author()
	{
		if ('yes' !== $this->get_settings('show_author')) {
			return;
		}
		?>

        <div class="bc-post-item__author">

			<?php if ('inline-icon' === $this->get_settings('meta_style')) : ?>
                <span class="bc-post-item__icon">
					<?php Icons_Manager::render_icon($this->get_settings('meta_icon'), ['aria-hidden' => 'true']); ?>
				</span>
			<?php endif; ?>

            <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
				<?php the_author(); ?>
            </a>
        </div>
		<?php
	}

	protected function render_author_avatar()
	{
		if (!$this->get_settings('show_author')) {
			return;
		}

		//		if ('4' !== $this->get_settings('preset_layout')) {
		//			return;
		//		}

		?>
        <div class="author">
            <div class="author-img">
				<?php echo wp_kses_post(get_avatar(get_the_author_meta('ID'), 48)); ?>
            </div>
        </div>
		<?php
	}

	protected function render_post_taxonomy()
	{
		if (!$this->get_settings('show_taxonomy')) {
			return;
		}

		$taxonomy = $this->get_settings('post_taxonomy');

		if (empty($taxonomy) || !taxonomy_exists($taxonomy)) {
			return;
		}

		$terms = get_the_terms(get_the_ID(), $taxonomy);

		if (empty($terms)) {
			return;
		}
		?>

        <div class="bc-post-item__category">

			<?php if ('inline-icon' === $this->get_settings('meta_style')) : ?>
                <span class="bc-post-item__icon">
					<?php Icons_Manager::render_icon($this->get_settings('meta_icon'), ['aria-hidden' => 'true']); ?>
				</span>
			<?php endif; ?>

			<?php
			foreach ($terms as $term) {
				printf(
					'<a href="%1$s">%2$s</a>',
					esc_url(get_term_link($term->slug, $taxonomy)),
					esc_html($term->name)
				);
			}
			?>
        </div>
		<?php
	}

	protected function post_read_time()
	{
		if (!$this->get_settings('show_read_time')) {
			return;
		}

		$post_id = get_the_ID();
		$words = str_word_count(strip_tags(get_post_field('post_content', $post_id)));

		$read_time = ceil($words / 200);
		$read_time = $read_time > 1 ? $read_time.' '.__('min read', '_pltdomain') : $read_time.' '.__('min read', '_pltdomain');

		echo '<span class="post-read-time">'.esc_html($read_time).'</span>';
	}

	protected function render_post_meta()
	{

		$author = $this->get_settings('show_author');
		$taxonomy = $this->get_settings('show_taxonomy');
		$date = $this->get_settings('show_date');
		$comment = $this->get_settings('show_comment');
		$read_time = $this->get_settings('show_read_time');
		$preset_layout = $this->get_settings('preset_layout');

		if ('yes' !== $author && 'yes' !== $taxonomy && 'yes' !== $comment && ('yes' !== $date || '6' !== $preset_layout)) {
			return;
		}
		?>

        <div class="bc-post-item__meta bc-post-item__meta--style-<?php echo esc_attr($this->get_settings('meta_style')); ?>">
			<?php

			if (('4' != $this->get_settings('preset_layout') || '7' != $this->get_settings('preset_layout')) && $this->get_settings('show_author')) {
				$this->render_author();
			}
			$this->render_post_taxonomy();
			if (!in_array($preset_layout, ['1', '2', '3', '4', '5', '8'])) {
				$this->render_date_by_type();
			}

			$this->render_comment();
			?>
        </div>
		<?php
	}

	protected function render_read_more()
	{
		if (!$this->get_settings('show_read_more')) {
			return;
		}

		$read_more = $this->get_settings('read_more_text');
		$aria_label_text = sprintf(
		/* translators: %s: Post title. */
			esc_attr__('Read more about %s', '_pltdomain'),
			get_the_title()
		);
		$migrated = isset($this->get_settings('__fa4_migrated')['selected_icon']);
		$is_new = empty($this->get_settings('icon')) && Icons_Manager::is_migration_allowed();
		?>

        <a class="bc-btn-link link-icon--<?php echo esc_attr($this->get_settings('icon_align')); ?>"
           href="<?php echo esc_url(get_the_permalink()); ?>"
           tabindex="-1">
            <span class="screen-reader-text"><?php echo esc_html($aria_label_text); ?></span>

			<?php if ($is_new || $migrated) : ?>
                <span class="bc-btn-icon">
					<?php Icons_Manager::render_icon($this->get_settings('selected_icon'), ['aria-hidden' => 'true']); ?>
				</span>
			<?php else : ?>
                <span class="bc-btn-icon"><i class="<?php echo esc_attr($this->get_settings('icon')); ?>" aria-hidden="true"></i></span>
			<?php endif; ?>
			<?php echo wp_kses_post($read_more); ?>
        </a>
		<?php
	}

	protected function render_post($settings)
	{
		$preset_layout = $this->get_settings('preset_layout');
		?>
		<?php if ($this->get_settings_for_display('enable_slider') === 'yes') : ?>
        <div class="swiper-slide">
	<?php endif; ?>
        <article <?php $this->print_render_attribute_string('article'); ?>>
			<?php if (has_post_thumbnail()) {
				$this->render_thumbnail($settings);
			} ?>

            <div class="bc-post-item__content">

				<?php if ($settings['preset_layout'] == '7') : ?>
					<?php $this->render_author_avatar(); ?>
				<?php endif; ?>

				<?php
				if ($settings['preset_layout'] != '7') {
					$this->render_post_meta();
				}
				$this->render_title();
				$this->render_excerpt();
				$this->render_read_more();
				?>

                <div class="bc-post-item__footer-meta">
					<?php if ('4' === $preset_layout) : ?>
                        <div class="bc-post-item__author-name">
							<?php $this->render_author(); ?>
                        </div>
					<?php endif; ?>

					<?php if (in_array($preset_layout, ['3', '4', '5', '7'], true)) : ?>
                        <div class="bc-post-item__footer">
							<?php $this->render_date_by_type(); ?>
							<?php $this->post_read_time(); ?>
                        </div>
					<?php endif; ?>
                </div>
            </div>
        </article>
		<?php if ($this->get_settings_for_display('enable_slider') === 'yes') : ?>
        </div>
	<?php endif; ?>
		<?php
	}

	protected function render_overlay_post($settings)
	{
		$preset_layout = $this->get_settings('preset_layout');
		?>
		<?php if ($this->get_settings_for_display('enable_slider') === 'yes') : ?>
        <div class="swiper-slide">
	<?php endif; ?>
        <article <?php $this->print_render_attribute_string('article'); ?>>
			<?php if (has_post_thumbnail()) {
				$this->render_thumbnail($settings);
			} ?>

            <div class="bc-post-item__overlay-content">
				<?php
				if ('1' !== $preset_layout) {
					$this->render_post_meta();
				}
				$this->render_title();
				?>
            </div>
        </article>
		<?php if ($this->get_settings_for_display('enable_slider') === 'yes') : ?>
        </div>
	<?php endif; ?>
		<?php
	}

	// Render preset layout six list
	protected function render_preset_layout_six_list($settings)
	{
		?>
		<?php if ($this->get_settings_for_display('enable_slider') === 'yes') : ?>
        <div class="swiper-slide">
	<?php endif; ?>
        <article <?php $this->print_render_attribute_string('article'); ?>>
			<?php if (has_post_thumbnail()) {
				$this->render_thumbnail($settings);
			} ?>

            <div class="bc-post-item__content">
				<?php
				$day_month = get_the_date('d.m');
				$year = get_the_date('Y');
				?>

                <div class="bc-post-item__date-meta">
                    <span class="day"><?php echo esc_html($day_month); ?></span>
                    <sup class="year"><?php echo esc_html($year); ?></sup>
                </div>

                <div class="bc-post-item__content--right">
					<?php
					$this->render_post_meta();
					$this->render_title();
					$this->render_excerpt();
					$this->render_read_more();
					?>
                </div>
            </div>
        </article>
		<?php if ($this->get_settings_for_display('enable_slider') === 'yes') : ?>
        </div>
	<?php endif; ?>
		<?php
	}

	protected function get_slider_options(array $settings)
	{

		// Loop
		if ($settings['loop'] == 'yes') {
			$slider_options['loop'] = true;
		}

		// Speed
		if (!empty($settings['speed'])) {
			$slider_options['speed'] = $settings['speed'];
		}

		// Space Between
		if (!empty($settings['space_between'])) {
			$slider_options['spaceBetween'] = $settings['space_between'];
		}
		// FreeMode

		if (!empty($settings['freeMode'])) {
			$slider_options['freeMode'] = $settings['freeMode'] === 'yes' ? true : false;
		}


		// Breakpoints

		$enable_responsive = !empty($settings['responsive']) ? $settings['responsive'] : 'no';

		if ('yes' === $enable_responsive) {

			$responsive_points = [];
			$responsive_items = !empty($settings['resposive_settings']) ? $settings['resposive_settings'] : [];
			foreach ($responsive_items as $responsive_item) {
				$responsive_points[$responsive_item['device_width']] = [
					'slidesPerView'  => $responsive_item['slidesPerView'] == 0 ? 'auto' : $responsive_item['slidesPerView'],
					'slidesPerGroup' => $responsive_item['slidesPerGroup'],
					'spaceBetween'   => !empty($responsive_item['spaceBetween']) ? $responsive_item['spaceBetween'] : 0,
					'freeMode'       => !empty($responsive_item['slidesFreeMode']) ? $responsive_item['slidesFreeMode'] == 'yes' ? true : false : false,
				];
			}
			$slider_options['breakpoints'] = $responsive_points;
		} else {
			$slider_options['breakpoints'] = [
				'1360' => [
					'slidesPerView' => $settings['slides_per_view'],
					'spaceBetween'  => $settings['space_between'],
				],
			];
		}

		// Auto Play
		if ($settings['autoplay'] == 'yes') {
			$slider_options['autoplay'] = [
				'delay'                => $settings['autoplay_time'],
				'disableOnInteraction' => false
			];
		} else {
			$slider_options['autoplay'] = [
				'delay' => '99999999999',
			];
		}

		if ($settings['navigation'] == 'yes') {
			$slider_options['navigation'] = [
				'nextEl' => '.bc-post__next',
				'prevEl' => '.bc-post__prev'
			];
		}

		return $slider_options;
	}
}
