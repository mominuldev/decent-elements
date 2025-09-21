<?php

/**
 * PostQuery Trait
 * @package BizzCraveCore
 */

namespace Decent_Elements\Traits;

use Elementor\Controls_Manager;
use \WP_Query;

if (!defined('ABSPATH')) {
	exit;
} // Exit if accessed directly

trait Posts_Query
{

	public static function get_public_post_types($args = [])
	{
		$post_type_args = [
			// Default is the value $public.
			'show_in_nav_menus' => true,
		];

		// Keep for backwards compatibility
		if (!empty($args['post_type'])) {
			$post_type_args['name'] = $args['post_type'];
			unset($args['post_type']);
		}

		$post_type_args = wp_parse_args($post_type_args, $args);

		$_post_types = get_post_types($post_type_args, 'objects');

		$post_types = [];

		$skip_post_type = ['bizzcrave_footer', 'bc-header', 'page'];
		// Skip specific Post Types
		foreach ($skip_post_type as $post_type) {
		    unset($_post_types[$post_type]);
		}

		foreach ($_post_types as $post_type => $object) {
			$post_types[$post_type] = $object->label;
		}

		return $post_types;
	}

	/**
	 * Get taxonomy terms for dropdown
	 */
	protected function get_taxonomy_terms($taxonomy)
	{
		$terms = get_terms([
			'taxonomy'   => $taxonomy,
			'hide_empty' => false,
		]);

		$options = [];
		if (!is_wp_error($terms)) {
			foreach ($terms as $term) {
				$options[$term->name] = $term->name;
			}
		}

		return $options;
	}

	protected function register_query_controls()
	{
		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__('Query', '_pltdomain'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'query_type',
			[
				'label'   => esc_html__('Query Type', '_pltdomain'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'custom',
				'options' => apply_filters('fc_widget_wp_query_type', [
					'custom'  => esc_html__('Custom', '_pltdomain'),
					'archive' => esc_html__('Archive', '_pltdomain'),
					'related' => esc_html__('Related', '_pltdomain')
				]),
			]
		);

		$this->add_control(
			'post_type',
			[
				'label'     => esc_html__('Source', '_pltdomain'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'post',
				'options'   => $this->get_public_post_types(),
				'condition' => [
					'query_type' =>
						[
							'custom',
							'archive',
							'top_post_week',
							'most_popular',
							'trending_score',
						]
				],
			]
		);

		// Offset
		$this->add_control(
			'posts_offset',
			[
				'label'       => esc_html__('Posts Offset', '_pltdomain'),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__('Number of posts to skip', '_pltdomain'),
			]
		);

		$this->start_controls_tabs(
			'post_in_ex_tabs'
		);

		$this->start_controls_tab(
			'query_include',
			[
				'label'     => esc_html__('Include', '_pltdomain'),
				'condition' => ['query_type' => 'custom'],
			]
		);

		$this->add_control(
			'include',
			[
				'label'       => esc_html__('Include By', '_pltdomain'),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => [
					'terms'   => esc_html__('Term', '_pltdomain'),
					'authors' => esc_html__('Author', '_pltdomain'),
				],
				'condition'   => ['query_type' => 'custom'],
			]
		);

		$this->add_control(
			'include_term_ids',
			[
				'label'       => esc_html__('Term', '_pltdomain'),
				'description' => esc_html__('Add coma separated, terms id', '_pltdomain'),
				'placeholder' => esc_html__('All', '_pltdomain'),
				'label_block' => true,
				'ai'          => [
					'active' => false,
				],
				'condition'   => [
					'include'    => 'terms',
					'query_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'include_authors',
			[
				'label'       => esc_html__('Author', '_pltdomain'),
				'description' => esc_html__('Add separated, authors ID', '_pltdomain'),
				'placeholder' => esc_html__('All', '_pltdomain'),
				'label_block' => true,
				'ai'          => [
					'active' => false,
				],
				'condition'   => [
					'include'    => 'authors',
					'query_type' => 'custom',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'query_exclude',
			[
				'label'     => esc_html__('Exclude', '_pltdomain'),
				'condition' => ['query_type' => 'custom'],
			]
		);

		$this->add_control(
			'exclude',
			[
				'label'       => esc_html__('Exclude By', '_pltdomain'),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => [
					'terms'   => esc_html__('Term', '_pltdomain'),
					'authors' => esc_html__('Author', '_pltdomain'),
				],
				'condition'   => ['query_type' => 'custom'],
			]
		);

		$this->add_control(
			'exclude_term_ids',
			[
				'label'       => esc_html__('Term', '_pltdomain'),
				'description' => esc_html__('Add coma separated, terms id', '_pltdomain'),
				'placeholder' => esc_html__('All', '_pltdomain'),
				'label_block' => true,
				'ai'          => [
					'active' => false,
				],
				'condition'   => [
					'exclude'    => 'terms',
					'query_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'exclude_authors',
			[
				'label'       => esc_html__('Author', '_pltdomain'),
				'description' => esc_html__('Add separated, authors ID', '_pltdomain'),
				'placeholder' => esc_html__('All', '_pltdomain'),
				'label_block' => true,
				'ai'          => [
					'active' => false,
				],
				'condition'   => [
					'exclude'    => 'authors',
					'query_type' => 'custom',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

//		$this->add_control(
//			'post_format',
//			[
//				'label'     => esc_html__( 'Post Format', '_pltdomain' ),
//				'type'      => Controls_Manager::SELECT2,
//				'default'   => [],
//				'multiple'  => true,
//				'options'   => [
//					'post-format-image'   => esc_html__( 'Image', '_pltdomain' ),
//					'post-format-video'   => esc_html__( 'Video', '_pltdomain' ),
//					'post-format-audio'   => esc_html__( 'Audio', '_pltdomain' ),
//					'post-format-gallery' => esc_html__( 'Gallery', '_pltdomain' ),
//				],
//				'condition' => [ 'query_type' => [ 'custom' ] ],
//			]
//		);

		$this->add_control(
			'post_categories',
			[
				'label'     => esc_html__('Post Categories', '_pltdomain'),
				'type'      => Controls_Manager::SELECT2,
				'default'   => [],
				'multiple'  => true,
				'options'   => $this->get_taxonomy_terms('category'), // Fetch categories dynamically
				'condition' => ['post_type' => ['post'], 'include' => 'terms'],
			]
		);

		$this->add_control(
			'post_tags',
			[
				'label'     => esc_html__('Post Tags', '_pltdomain'),
				'type'      => Controls_Manager::SELECT2,
				'default'   => [],
				'multiple'  => true,
				'options'   => $this->get_taxonomy_terms('post_tag'), // Fetch tags dynamically
				'condition' => ['post_type' => ['post'], 'include' => 'terms'],
			]
		);

		$this->add_control(
			'post_date',
			[
				'label'     => esc_html__('Date', '_pltdomain'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'anytime',
				'options'   => [
					'anytime'  => esc_html__('All', '_pltdomain'),
					'-1 day'   => esc_html__('Past Day', '_pltdomain'),
					'-3 day'   => esc_html__('Past 3 Day', '_pltdomain'),
					'-1 week'  => esc_html__('Past Week', '_pltdomain'),
					'-2 week'  => esc_html__('Past Two Weeks', '_pltdomain'),
					'-1 month' => esc_html__('Past Month', '_pltdomain'),
					'-3 month' => esc_html__('Past Quarter', '_pltdomain'),
					'-1 year'  => esc_html__('Past Year', '_pltdomain'),
				],
				'condition' => [
					'query_type' => [
						'custom',
						'most_share_count',
						'trending_score',
						'most_views',
						'most_popular'
					]
				],
			]
		);

		$this->add_control(
			'post_order_by',
			[
				'label'     => esc_html__('Order By', '_pltdomain'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'date',
				'options'   => [
					'date'          => esc_html__('Date', '_pltdomain'),
					'title'         => esc_html__('Title', '_pltdomain'),
					'menu_order'    => esc_html__('Menu Order', '_pltdomain'),
					'modified'      => esc_html__('Last Modified', '_pltdomain'),
					'comment_count' => esc_html__('Comment Count', '_pltdomain'),
					'rand'          => esc_html__('Random', '_pltdomain'),
				],
				'condition' => ['query_type' => 'custom'],
			]
		);

		$this->add_control(
			'post_order',
			[
				'label'     => esc_html__('Order', '_pltdomain'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'desc',
				'options'   => [
					'asc'  => esc_html__('ASC', '_pltdomain'),
					'desc' => esc_html__('DESC', '_pltdomain'),
				],
				'condition' => ['query_type' => 'custom'],
			]
		);

		$this->add_control(
			'post_sticky_ignore',
			[
				'label'        => esc_html__('Ignore Sticky Posts', '_pltdomain'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', '_pltdomain'),
				'label_off'    => esc_html__('No', '_pltdomain'),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => ['query_type' => 'custom'],
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

	protected function query_arg()
	{
		$query_args = [];

		//related post
		if ('related' === $this->get_settings('query_type') && is_singular()) {
			$post_id = get_queried_object_id();
			$related_post_id = is_singular() && (0 !== $post_id) ? $post_id : null;

			$taxonomies = get_object_taxonomies(get_post_type($related_post_id));
			$tax_query_arg = [];

			foreach ($taxonomies as $taxonomy) {

				$terms = get_the_terms($post_id, $taxonomy);

				if (empty($terms)) {
					continue;
				}

				$term_list = wp_list_pluck($terms, 'slug');


				if (!empty($tax_query_arg) && empty($tax_query_arg['relation'])) {
					$tax_query_arg['relation'] = 'OR';
				}

				$tax_query_arg[] = [
					'taxonomy' => $taxonomy,
					'field'    => 'slug',
					'terms'    => $term_list
				];
			}

			$query_args['post_type'] = get_post_type($related_post_id);
			$query_args['posts_per_page'] = $this->get_settings('posts_per_page');
			$query_args['post__not_in'] = [$related_post_id];
			$query_args['orderby'] = 'rand';

			if (!empty($tax_query_arg)) { //backward compatibility if post has no taxonomies
				$query_args['tax_query'] = $tax_query_arg;
			}

			return $query_args;
		}

		$query_args = [
			'post_type'           => $this->get_settings('post_type'),
			'posts_per_page'      => $this->get_settings('posts_per_page'),
			'ignore_sticky_posts' => empty($this->get_settings('post_sticky_ignore')) ? false : true,
			'paged'               => $this->get_current_page(),
			'order'               => $this->get_settings('post_order'),
			'orderby'             => $this->get_settings('post_order_by'),
			'offset'              => !empty($this->get_settings('posts_offset')) ? $this->get_settings('posts_offset') : 0,
			'post_status'         => 'publish',
		];

		if ('anytime' !== $this->get_settings('post_date')) {
			$query_args['date_query'] = ['after' => $this->get_settings('post_date')];
		}

		if (!empty($this->get_settings('include'))) {
			if (in_array('terms', $this->get_settings('include'))) {
				$query_args['tax_query'] = [];

				if (!empty($this->get_settings('include_term_ids'))) {
					$terms = [];

					foreach (explode(',', $this->get_settings('include_term_ids')) as $id) {
						$term_data = get_term_by('term_taxonomy_id', $id);

						if (!$term_data) {
							continue;
						}

						$taxonomy = $term_data->taxonomy;
						$terms[$taxonomy][] = $id;
					}
					foreach ($terms as $taxonomy => $ids) {
						$query = [
							'taxonomy' => $taxonomy,
							'field'    => 'term_taxonomy_id',
							'terms'    => $ids,
						];

						$query_args['tax_query'][] = $query;
					}
				}
				//post_categories
				if (!empty($this->get_settings('post_categories'))) {
					// Add category filter using term names
					$query_args['tax_query'][] = [
						'taxonomy' => 'category',
						'field'    => 'name', // Use 'name' instead of 'term_id'
						'terms'    => $this->get_settings('post_categories')
					];
				}
				if (!empty($this->get_settings('post_tags'))) {
					// Add tag filter using term names
					$query_args['tax_query'][] = [
						'taxonomy' => 'post_tag',
						'field'    => 'name', // Use 'name' instead of 'term_id'
						'terms'    => $this->get_settings('post_tags')
					];
				}

			}

			if (!empty($this->get_settings('include_authors'))) {
				$query_args['author__in'] = explode(',', $this->get_settings('include_authors'));
			}
		}

		if (!empty($this->get_settings('exclude'))) {
			if (in_array('terms', $this->get_settings('exclude'))) {
				$query_args['tax_query']['relation'] = 'AND';

				if (!empty($this->get_settings('exclude_term_ids'))) {
					$terms = [];

					foreach (explode(',', $this->get_settings('exclude_term_ids')) as $id) {
						$term_data = get_term_by('term_taxonomy_id', $id);
						if (!$term_data) {
							continue;
						}

						$taxonomy = $term_data->taxonomy;
						$terms[$taxonomy][] = $id;
					}
					foreach ($terms as $taxonomy => $ids) {
						$query = [
							'taxonomy' => $taxonomy,
							'field'    => 'term_taxonomy_id',
							'terms'    => $ids,
							'operator' => 'NOT IN',
						];

						$query_args['tax_query'][] = $query;
					}
				}
			}

			if (!empty($this->get_settings('exclude_authors'))) {
				$query_args['author__not_in'] = explode(',', $this->get_settings('exclude_authors'));
			}
		}

		if ('top_post_week' === $this->get_settings('query_type')) {
			$query_args['meta_key'] = 'tc_post_views_count';
			$query_args['orderby'] = 'meta_value_num';
			$query_args['order'] = 'DESC';
			$query_args['date_query'] = [
				[
					'after'     => '1 week ago', // Filter posts from the last 7 days
					'inclusive' => true, // Include posts exactly 7 days old
				],
			];
			$query_args['meta_query'] = [
				[
					'key'     => 'tc_post_views_count',
					'value'   => 0, // Optional: Only include posts with at least 1 view
					'compare' => '>',
					'type'    => 'NUMERIC',
				],
			];

			if (isset($query_args['ignore_sticky_posts'])) {
				unset($query_args['ignore_sticky_posts']);
			}
		}

		if ('most_popular' === $this->get_settings('query_type')) {

			$query_args['orderby'] = array(
				'meta_value_num' => 'DESC',
				'comment_count'  => 'DESC',
			);
			$query_args['order'] = 'DESC';
			$query_args['meta_query'] = [
				'relation' => 'OR',
				[
					'key'  => 'tc_post_views_count',
					'type' => 'NUMERIC',
				],
				[
					'key'  => 'aae_post_shares_count',
					'type' => 'NUMERIC',
				],
			];

			if (isset($query_args['ignore_sticky_posts'])) {
				unset($query_args['ignore_sticky_posts']);
			}
		}

		if ('trending_score' === $this->get_settings('query_type')) {

			$query_args['meta_key'] = 'aae_trending_score';
			$query_args['orderby'] = 'meta_value_num';
			$query_args['order'] = 'DESC';

			if (isset($query_args['ignore_sticky_posts'])) {
				unset($query_args['ignore_sticky_posts']);
			}
		}

		if ('most_share_count' === $this->get_settings('query_type')) {

			$query_args['meta_key'] = 'aae_post_shares_count';
			$query_args['orderby'] = 'meta_value_num';
			$query_args['order'] = 'DESC';

			if (isset($query_args['ignore_sticky_posts'])) {
				unset($query_args['ignore_sticky_posts']);

			}

		}

		if ('most_reactions' === $this->get_settings('query_type')) {

			$query_args['meta_key'] = 'aaeaddon_post_total_reactions';
			$query_args['orderby'] = 'meta_value_num';
			$query_args['order'] = 'DESC';

			if (isset($query_args['ignore_sticky_posts'])) {
				unset($query_args['ignore_sticky_posts']);

			}

		}

		if ('most_reactions_love' === $this->get_settings('query_type')) {

			$query_args['meta_key'] = 'aaeaddon_post_reactions_love';
			$query_args['orderby'] = 'meta_value_num';
			$query_args['order'] = 'DESC';

			if (isset($query_args['ignore_sticky_posts'])) {
				unset($query_args['ignore_sticky_posts']);

			}

		}

		if ('most_reactions_like' === $this->get_settings('query_type')) {

			$query_args['meta_key'] = '_like_count';
			$query_args['orderby'] = 'meta_value_num';
			$query_args['order'] = 'DESC';

			if (isset($query_args['ignore_sticky_posts'])) {
				unset($query_args['ignore_sticky_posts']);

			}

		}


		if ($this->get_settings('post_layout') && ($this->get_settings('post_layout') == 'layout-gallery' || $this->get_settings('post_layout') == 'layout-gallery-2')) {
			$query_args['tax_query'][] = [
				'taxonomy' => 'post_format',
				'field'    => 'slug',
				'terms'    => array('post-format-video'),
			];
		}

		if ($this->get_settings('post_layout') && ($this->get_settings('post_layout') == 'layout-audio')) {
			$query_args['tax_query'][] = [
				'taxonomy' => 'post_format',
				'field'    => 'slug',
				'terms'    => array('post-format-audio'),
			];
		}

		if ($this->get_settings('post_format') && is_array($this->get_settings('post_format'))) {

			$query_args['tax_query'][] = [
				'taxonomy' => 'post_format',
				'field'    => 'slug',
				'terms'    => $this->get_settings('post_format'),
			];
		}


		return $query_args;
	}

	public function get_query()
	{
		global $wp_query;

		// Check custom post type archive
		if ('archive' === $this->get_settings('query_type') && !\Elementor\Plugin::$instance->editor->is_edit_mode() && is_tax()) {

			if ($this->get_settings('post_type') != 'post') {
				$query_object = get_queried_object();
				$tax_query = [];
				if (isset($query_object->taxonomy) && isset($query_object->term_id)) {
					$tax_query = [
						[
							'taxonomy' => $query_object->taxonomy,
							'field'    => 'term_id',
							'terms'    => $query_object->term_id,
						],
					];
				}
				// Create a new WP_Query instance
				$GLOBALS['wp_query'] = new \WP_Query([
					'post_type' => $this->get_settings('post_type'),
					'tax_query' => $tax_query,
				]);

				return $GLOBALS['wp_query'];
			}

		}

		if ('archive' === $this->get_settings('query_type') && !\Elementor\Plugin::$instance->editor->is_edit_mode() && ($wp_query->is_archive || $wp_query->is_search)) {
			return $this->query = $wp_query;
		} else {
			return $this->query = new \WP_Query($this->query_arg());
		}
	}

	protected function next_page_link($next_page)
	{
		return get_pagenum_link($next_page);
	}

	protected function get_taxonomies()
	{
		$taxonomies = get_taxonomies(['show_in_nav_menus' => true], 'objects');

		$options = ['' => ''];

		foreach ($taxonomies as $taxonomy) {
			$options[$taxonomy->name] = $taxonomy->label;
		}

		return $options;
	}

}
