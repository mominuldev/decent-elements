<?php
/**
 * Module registry.
 *
 * @package Decent_Elements
 * @since   1.2.0
 */

namespace Decent_Elements\Core;

use Decent_Elements\Contracts\Module;

defined( 'ABSPATH' ) || exit;

/**
 * The single registry of every toggleable feature in the plugin.
 *
 * Replaces the two hardcoded arrays in Widget_Manager and Extension_Manager,
 * and the third copy of the same data in the admin app's widgets.json. Adding a
 * widget previously meant editing three files that could — and did — drift out
 * of sync.
 *
 * The definitions below are still hardcoded. That is deliberate for this
 * release: class-based discovery needs the widget files to declare their own
 * metadata, which is Phase 3. What changes now is that there is exactly ONE
 * copy of the data, and it is filterable, so a Pro add-on or a theme can extend
 * it without patching the plugin.
 *
 * @since 1.2.0
 */
final class Module_Manager {

	/**
	 * Settings storage.
	 *
	 * @var Settings_Repository
	 */
	private $settings;

	/**
	 * Resolved module list, keyed by namespaced key.
	 *
	 * @var array<string, Module>|null
	 */
	private $modules = null;

	/**
	 * Constructor.
	 *
	 * @param Settings_Repository $settings Settings storage.
	 */
	public function __construct( Settings_Repository $settings ) {
		$this->settings = $settings;
	}

	/**
	 * Every registered module, keyed by namespaced key.
	 *
	 * @return array<string, Module>
	 */
	public function all() {
		if ( null !== $this->modules ) {
			return $this->modules;
		}

		$modules = array();

		foreach ( array_merge( $this->widget_definitions(), $this->extension_definitions() ) as $module ) {
			$modules[ $module->key() ] = $module;
		}

		/**
		 * Filters the registered modules.
		 *
		 * The extension point for add-ons: a Pro plugin registers its widgets by
		 * appending Module objects here rather than by patching this class.
		 *
		 * @since 1.2.0
		 * @param array<string, Module> $modules Modules keyed by namespaced key.
		 */
		$modules = apply_filters( 'decent_elements/modules', $modules );

		$this->modules = array_filter(
			$modules,
			static function ( $module ) {
				return $module instanceof Module;
			}
		);

		return $this->modules;
	}

	/**
	 * Modules of one type.
	 *
	 * @param string $type One of the Module::TYPE_* constants.
	 * @return array<string, Module>
	 */
	public function of_type( $type ) {
		return array_filter(
			$this->all(),
			static function ( $module ) use ( $type ) {
				return $module->type() === $type;
			}
		);
	}

	/**
	 * Enabled modules, optionally restricted to one type.
	 *
	 * @param string|null $type One of the Module::TYPE_* constants, or null for all.
	 * @return array<string, Module>
	 */
	public function enabled( $type = null ) {
		$modules = null === $type ? $this->all() : $this->of_type( $type );

		return array_filter(
			$modules,
			array( $this, 'is_enabled' )
		);
	}

	/**
	 * Whether a module is enabled.
	 *
	 * @param Module $module Module to check.
	 * @return bool
	 */
	public function is_enabled( Module $module ) {
		return $this->settings->is_module_enabled( $module->key(), $module->is_default_enabled() );
	}

	/**
	 * Look a module up by its namespaced key.
	 *
	 * @param string $key Namespaced key, e.g. `widget:heading`.
	 * @return Module|null
	 */
	public function get( $key ) {
		$modules = $this->all();

		return isset( $modules[ $key ] ) ? $modules[ $key ] : null;
	}

	/**
	 * Persist enabled states.
	 *
	 * Unknown keys are dropped rather than stored, so a malformed request
	 * cannot pollute the settings row.
	 *
	 * @param array<string, bool> $states Namespaced key => enabled.
	 * @return bool
	 */
	public function set_enabled( array $states ) {
		$known = $this->all();
		$clean = array();

		foreach ( $states as $key => $enabled ) {
			if ( isset( $known[ $key ] ) ) {
				$clean[ $key ] = (bool) $enabled;
			}
		}

		if ( array() === $clean ) {
			return false;
		}

		return $this->settings->set_modules( $clean );
	}

	/**
	 * Module descriptors suitable for the migration routine.
	 *
	 * @return array<int, array{id: string, default: bool}>
	 */
	public function migration_descriptors() {
		$out = array();

		foreach ( $this->all() as $module ) {
			$out[] = array(
				'id'      => $module->key(),
				'default' => $module->is_default_enabled(),
			);
		}

		return $out;
	}

	/**
	 * Admin-panel categories.
	 *
	 * Moved out of the admin app's widgets.json so the category list and the
	 * modules that reference it cannot drift apart.
	 *
	 * @return array<int, array<string, string>>
	 */
	public function categories() {
		$categories = array(
			array(
				'id'   => 'all',
				'name' => __( 'All Widgets', 'decent-elements' ),
				'icon' => "\u{26A1}",
			),
			array(
				'id'   => 'core',
				'name' => __( 'Core UI / Content', 'decent-elements' ),
				'icon' => "\u{1F3AF}",
			),
			array(
				'id'   => 'creative',
				'name' => __( 'Creative', 'decent-elements' ),
				'icon' => "\u{1F3A8}",
			),
			array(
				'id'   => 'content-display',
				'name' => __( 'Content Display', 'decent-elements' ),
				'icon' => "\u{1F4C4}",
			),
			array(
				'id'   => 'navigation',
				'name' => __( 'Navigation', 'decent-elements' ),
				'icon' => "\u{1F9ED}",
			),
			array(
				'id'   => 'woocommerce',
				'name' => __( 'WooCommerce', 'decent-elements' ),
				'icon' => "\u{1F6D2}",
			),
			array(
				'id'   => 'marketing',
				'name' => __( 'Marketing', 'decent-elements' ),
				'icon' => "\u{1F4C8}",
			),
			array(
				'id'   => 'media-content',
				'name' => __( 'Media Content', 'decent-elements' ),
				'icon' => "\u{1F4F8}",
			),
		);

		/**
		 * Filters the admin-panel category list.
		 *
		 * @since 1.4.0
		 * @param array<int, array<string, string>> $categories Categories.
		 */
		return apply_filters( 'decent_elements/categories', $categories );
	}

	/**
	 * Widget definitions.
	 *
	 * Asset paths point at the file that actually holds the content. The plugin
	 * ships zero-byte placeholders under assets/widgets/ that shadow the real
	 * stylesheets in assets/ — the optimizer read the placeholders and served an
	 * empty bundle (see the Phase 1 notes in docs/ARCHITECTURE-AUDIT.md). The
	 * asset registry skips empty files, so listing a placeholder is harmless,
	 * but the real path must be the one declared.
	 *
	 * @return array<int, Module>
	 */
	private function widget_definitions() {
		return array(
			new Module(
				'heading',
				Module::TYPE_WIDGET,
				__( 'Heading', 'decent-elements' ),
				\Decent_Elements\Modules\Heading\Heading_Widget::class,
				'',
				true,
				array(
					'css' => array( 'assets/widgets/css/heading.css' ),
					'js'  => array( 'assets/widgets/js/heading.js' ),
				),
				array(
					'category' => 'core',
					'icon'     => "\u{1F4DD}",
					'status'   => 'new',
					'demo_url' => 'https://decentelements.com/heading-widget/',
					'docs_url' => 'https://decentelements.com/docs/heading-widget/',
				)
			),
			new Module(
				'dual-color-heading',
				Module::TYPE_WIDGET,
				__( 'Dual Color Heading', 'decent-elements' ),
				'Decent_Elements_Dual_Color_Heading_Widget',
				'src/Widgets/dual-color-heading.php',
				true,
				array(
					'css' => array( 'assets/widgets/css/dual-color-heading.css' ),
				),
				array(
					'category' => 'core',
					'icon'     => "\u{2728}",
					'status'   => 'update',
					'demo_url' => 'https://decentelements.com/fancy-heading/',
					'docs_url' => 'https://decentelements.com/docs/fancy-heading/',
				)
			),
			new Module(
				'image-box',
				Module::TYPE_WIDGET,
				__( 'Image Box', 'decent-elements' ),
				'Decent_Elements_Image_Box_Widget',
				'src/Widgets/image-box.php',
				true,
				array(
					'css' => array( 'assets/widgets/css/image-box.css' ),
				),
				array(
					'category' => 'core',
					'icon'     => "\u{1F5BC}",
					'status'   => 'normal',
					'demo_url' => 'https://decentelements.com/image-box-widget/',
					'docs_url' => 'https://decentelements.com/docs/image-box-widget/',
				)
			),
			new Module(
				'icon-box',
				Module::TYPE_WIDGET,
				__( 'Icon Box', 'decent-elements' ),
				'Decent_Elements_Icon_Box_Widget',
				'src/Widgets/icon-box.php',
				true,
				array(
					'css' => array( 'assets/widgets/css/icon-box.css' ),
					'js'  => array( 'assets/widgets/js/icon-box.js' ),
				),
				array(
					'category' => 'core',
					'icon'     => "\u{1F3AF}",
					'status'   => 'normal',
					'demo_url' => 'https://decentelements.com/icon-box-widget/',
					'docs_url' => 'https://decentelements.com/docs/icon-box-widget/',
				)
			),
			new Module(
				'button',
				Module::TYPE_WIDGET,
				__( 'Button', 'decent-elements' ),
				'Decent_Elements_Button_Widget',
				'src/Widgets/button.php',
				true,
				array(
					'css' => array( 'assets/widgets/css/button.css' ),
					'js'  => array( 'assets/widgets/js/button.js' ),
				),
				array(
					'category' => 'core',
					'icon'     => "\u{1F518}",
					'status'   => 'new',
					'demo_url' => 'https://decentelements.com/button-widget/',
					'docs_url' => 'https://decentelements.com/docs/button-widget/',
				)
			),
			new Module(
				'animated-testimonials',
				Module::TYPE_WIDGET,
				__( 'Testimonials', 'decent-elements' ),
				'Decent_Animated_Testimonials_Widget',
				'src/Widgets/animated-testimonials.php',
				true,
				array(
					'css' => array( 'assets/widgets/css/animated-testimonials.css' ),
					'js'  => array( 'assets/widgets/js/animated-testimonials.js' ),
				),
				array(
					'category' => 'content-display',
					'icon'     => "\u{1F4AC}",
					'status'   => 'new',
					'demo_url' => 'https://decentelements.com/testimonials-widget/',
					'docs_url' => 'https://decentelements.com/docs/testimonials-widget/',
				)
			),
			new Module(
				'posts',
				Module::TYPE_WIDGET,
				__( 'Posts', 'decent-elements' ),
				'Decent_Elements_Post_Widget',
				'src/Widgets/posts.php',
				true,
				array(),
				array(
					'category' => 'core',
					'icon'     => "\u{1F4F0}",
					'status'   => 'normal',
					'demo_url' => 'https://decentelements.com/posts-widget/',
					'docs_url' => 'https://decentelements.com/docs/posts-widget/',
				)
			),
		);
	}

	/**
	 * Extension definitions.
	 *
	 * Extension assets are declared here and enqueued by Core\Asset_Registry.
	 * Extensions previously built their own asset URLs by hand and four of the
	 * seven pointed at paths that never existed, emitting 404s on every page.
	 *
	 * Sources live in src-assets/{scss,js}/extensions/ and build to
	 * assets/extensions/{css,js}/. An extension with no source file simply
	 * declares nothing.
	 *
	 * @return array<int, Module>
	 */
	private function extension_definitions() {
		// icon / link previously lived in the admin app's widgets.json; two of the
		// icons there had decayed to U+FFFD replacement characters.
		$definitions = array(
			array( 'custom-css', __( 'Custom CSS', 'decent-elements' ), 'Decent_Elements_Custom_CSS_Extension', 'custom-css.php', false, array(), "\u{1F3A8}" ),
			array( 'sticky-column', __( 'Sticky Column', 'decent-elements' ), 'Decent_Elements_Sticky_Column_Extension', 'sticky-column.php', false, array(), "\u{1F4CC}" ),
			array( 'wrapper-link', __( 'Wrapper Link', 'decent-elements' ), 'Decent_Elements_Wrapper_Link_Extension', 'wrapper-link.php', false, array(), "\u{1F517}" ),
			array( 'decent-elements-mouse-effects', __( 'Mouse Effects', 'decent-elements' ), 'Decent_Elements_Mouse_Effects_Extension', 'mouse-effects.php', true, array(), "\u{1F680}" ),
			array( 'decent-elements-scroll-effects', __( 'Scroll Effects', 'decent-elements' ), 'Decent_Elements_Scroll_Effects_Extension', 'scroll-effects.php', true, array(), "\u{1F300}" ),
			array( 'decent-elements-advanced-animations', __( 'Advanced Animations', 'decent-elements' ), 'Decent_Elements_Advanced_Animations_Extension', 'advanced-animations.php', false, array(), "\u{1F3AC}" ),
			array(
				'custom-cursor',
				__( 'Custom Cursor', 'decent-elements' ),
				'Decent_Elements_Custom_Cursor_Extension',
				'custom-cursor.php',
				false,
				array(
					'css'  => array( 'assets/extensions/css/custom-cursor.css' ),
					'js'   => array( 'assets/extensions/js/custom-cursor.js' ),
					'deps' => array( 'js' => array( 'gsap' ) ),
				),
				"\u{1F5B1}",
			),
		);

		$modules = array();

		foreach ( $definitions as $definition ) {
			list( $id, $title, $class, $file, $default, $assets, $icon ) = $definition;

			$modules[] = new Module(
				$id,
				Module::TYPE_EXTENSION,
				$title,
				$class,
				'src/extensions/' . $file,
				$default,
				$assets,
				array(
					'category' => 'extension',
					'icon'     => $icon,
					'status'   => 'normal',
					'docs_url' => 'https://decentelements.com/' . $id . '/',
				)
			);
		}

		return $modules;
	}
}
