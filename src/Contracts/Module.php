<?php
/**
 * Module value object.
 *
 * @package Decent_Elements
 * @since   1.2.0
 */

namespace Decent_Elements\Contracts;

defined( 'ABSPATH' ) || exit;

/**
 * Describes one toggleable feature — a widget or an extension.
 *
 * Widgets and extensions were previously managed by two classes with ~410 lines
 * of near-identical registry, settings and toggle logic. They differ only in how
 * they attach to Elementor: a widget registers with the widgets manager, an
 * extension hooks the control system. Everything else — an id, a title, a
 * default state, owned assets — is common, so it is modelled once here.
 *
 * This is a descriptor, not a base class. The widget and extension files remain
 * plain classes loaded by require_once; forcing them to implement an interface
 * is Phase 3 work. Describing them from outside lets the manager, the asset
 * registry and the REST API share one source of truth today.
 *
 * @since 1.2.0
 */
final class Module {

	/**
	 * Module type: an Elementor widget.
	 */
	const TYPE_WIDGET = 'widget';

	/**
	 * Module type: an Elementor extension.
	 */
	const TYPE_EXTENSION = 'extension';

	/**
	 * Bare id, unique within the type. E.g. `heading`.
	 *
	 * @var string
	 */
	private $id;

	/**
	 * Module type, one of the TYPE_* constants.
	 *
	 * @var string
	 */
	private $type;

	/**
	 * Human-readable title.
	 *
	 * @var string
	 */
	private $title;

	/**
	 * Fully-qualified class name implementing the module.
	 *
	 * @var string
	 */
	private $class;

	/**
	 * Path to the module file, relative to the plugin root.
	 *
	 * @var string
	 */
	private $file;

	/**
	 * Whether the module is enabled on a fresh install.
	 *
	 * @var bool
	 */
	private $default_enabled;

	/**
	 * Owned assets, as `['css' => [paths], 'js' => [paths]]`.
	 *
	 * Paths are relative to the plugin root. This is the single source of truth
	 * consumed by the asset registry and the optimizer, which previously each
	 * guessed paths from the module id using different conventions — the cause
	 * of issues C2 and C6 in docs/ARCHITECTURE-AUDIT.md.
	 *
	 * @var array{css: array<int, string>, js: array<int, string>}
	 */
	private $assets;

	/**
	 * Handles this module's assets depend on.
	 *
	 * @var array{css: array<int, string>, js: array<int, string>}
	 */
	private $deps;

	/**
	 * Presentation metadata for the admin panel.
	 *
	 * The admin app used to read this from a hand-maintained widgets.json that
	 * drifted out of sync with the PHP registry — 42 of its 47 entries had no
	 * backing module, and two real widgets were missing from it entirely.
	 * Keeping it beside the module definition is what stops that recurring.
	 *
	 * @var array<string, string>
	 */
	private $meta;

	/**
	 * Constructor.
	 *
	 * @param string                                                   $id              Bare id.
	 * @param string                                                   $type            One of the TYPE_* constants.
	 * @param string                                                   $title           Human-readable title.
	 * @param string                                                   $class_name      Implementing class name.
	 * @param string                                                   $file            Path relative to the plugin root.
	 * @param bool                                                     $default_enabled Default state.
	 * @param array{css?: array<int, string>, js?: array<int, string>} $assets      Owned assets.
	 * @param array<string, string>                                    $meta        Presentation metadata.
	 */
	public function __construct( $id, $type, $title, $class_name, $file, $default_enabled, array $assets = array(), array $meta = array() ) {
		$this->id              = $id;
		$this->type            = $type;
		$this->title           = $title;
		$this->class           = $class_name;
		$this->file            = $file;
		$this->default_enabled = (bool) $default_enabled;
		$this->assets          = array(
			'css' => isset( $assets['css'] ) ? $assets['css'] : array(),
			'js'  => isset( $assets['js'] ) ? $assets['js'] : array(),
		);
		$this->deps            = array(
			'css' => isset( $assets['deps']['css'] ) ? $assets['deps']['css'] : array(),
			'js'  => isset( $assets['deps']['js'] ) ? $assets['deps']['js'] : array( 'jquery' ),
		);
		$this->meta            = wp_parse_args(
			$meta,
			array(
				'category' => 'core',
				'icon'     => '',
				'status'   => 'normal',
				'demo_url' => '',
				'docs_url' => '',
			)
		);
	}

	/**
	 * Presentation metadata for the admin panel.
	 *
	 * @return array<string, string>
	 */
	public function meta() {
		return $this->meta;
	}

	/**
	 * Handles this module's stylesheet depends on.
	 *
	 * @return array<int, string>
	 */
	public function style_deps() {
		return $this->deps['css'];
	}

	/**
	 * Handles this module's script depends on.
	 *
	 * @return array<int, string>
	 */
	public function script_deps() {
		return $this->deps['js'];
	}

	/**
	 * Bare id, unique within the type.
	 *
	 * @return string
	 */
	public function id() {
		return $this->id;
	}

	/**
	 * Namespaced id, unique across all modules.
	 *
	 * Widgets and extensions have colliding bare ids — `custom-cursor` exists as
	 * an extension while `custom-cursor.css` sits in the widget asset tree — so
	 * stored settings key off this, never the bare id.
	 *
	 * @return string
	 */
	public function key() {
		return $this->type . ':' . $this->id;
	}

	/**
	 * Module type.
	 *
	 * @return string
	 */
	public function type() {
		return $this->type;
	}

	/**
	 * Human-readable title.
	 *
	 * @return string
	 */
	public function title() {
		return $this->title;
	}

	/**
	 * Implementing class name.
	 *
	 * @return string
	 */
	public function class_name() {
		return $this->class;
	}

	/**
	 * Absolute path to the module file, or null when it is autoloadable.
	 *
	 * Modules migrated to PSR-4 (namespaced, filename matching the class) are
	 * found by Composer and declare no file. Legacy global-class modules still
	 * declare one and are loaded with require_once.
	 *
	 * @return string|null
	 */
	public function path() {
		return '' === $this->file ? null : DECENT_ELEMENTS_PATH . $this->file;
	}

	/**
	 * Whether this module is loaded by the autoloader rather than a require.
	 *
	 * @return bool
	 */
	public function is_autoloadable() {
		return '' === $this->file;
	}

	/**
	 * Whether the module is enabled on a fresh install.
	 *
	 * @return bool
	 */
	public function is_default_enabled() {
		return $this->default_enabled;
	}

	/**
	 * The WordPress asset handle for this module.
	 *
	 * @return string
	 */
	public function handle() {
		return 'de-' . $this->id;
	}

	/**
	 * Stylesheet paths, relative to the plugin root.
	 *
	 * @return array<int, string>
	 */
	public function styles() {
		return $this->assets['css'];
	}

	/**
	 * Script paths, relative to the plugin root.
	 *
	 * @return array<int, string>
	 */
	public function scripts() {
		return $this->assets['js'];
	}
}
