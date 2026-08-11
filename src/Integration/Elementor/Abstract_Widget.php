<?php
/**
 * Base class for plugin widgets.
 *
 * @package Decent_Elements
 * @since   1.3.0
 */

namespace Decent_Elements\Integration\Elementor;

use Elementor\Widget_Base;

defined( 'ABSPATH' ) || exit;

/**
 * Common behaviour for every Decent Elements widget.
 *
 * Each widget previously restated its category and asset handles by hand, which
 * is how `heading` ended up declaring the handle `heading` while registering as
 * `de-heading` — its stylesheet never loaded. Deriving both from one place makes
 * that class of mismatch unexpressible.
 *
 * `get_name()` is intentionally NOT implemented here. It is the identifier
 * Elementor stores in `_elementor_data`; every subclass must state it
 * explicitly, and its value must never change once shipped.
 *
 * @since 1.3.0
 */
abstract class Abstract_Widget extends Widget_Base {

	/**
	 * Asset handle prefix, matching Contracts\Module::handle().
	 */
	const HANDLE_PREFIX = 'de-';

	/**
	 * The module id this widget belongs to.
	 *
	 * Used to derive the asset handle. Defaults to the widget name with the
	 * `de-` prefix stripped, which is correct for every widget whose module id
	 * matches its Elementor name.
	 *
	 * @return string
	 */
	protected function get_module_id() {
		$name = $this->get_name();

		return 0 === strpos( $name, self::HANDLE_PREFIX )
			? substr( $name, strlen( self::HANDLE_PREFIX ) )
			: $name;
	}

	/**
	 * Asset handle registered for this widget by Core\Asset_Registry.
	 *
	 * @return string
	 */
	protected function get_asset_handle() {
		return self::HANDLE_PREFIX . $this->get_module_id();
	}

	/**
	 * Elementor categories this widget appears in.
	 *
	 * @return array<int, string>
	 */
	public function get_categories() {
		return array( Category_Registrar::CATEGORY );
	}

	/**
	 * Stylesheets this widget needs.
	 *
	 * Elementor enqueues these only on pages where the widget is rendered.
	 * Handles that were never registered — because the module declares no
	 * stylesheet, or the file is empty — are silently ignored by WordPress.
	 *
	 * @return array<int, string>
	 */
	public function get_style_depends() {
		return array( $this->get_asset_handle() );
	}

	/**
	 * Scripts this widget needs.
	 *
	 * @return array<int, string>
	 */
	public function get_script_depends() {
		return array( $this->get_asset_handle() );
	}

	/**
	 * Render a view file with the given data.
	 *
	 * Views receive already-prepared, already-escaped values. Keeping markup in
	 * a template rather than inline echo statements is what makes the escaping
	 * auditable — PHPCS can see the output, and there is one place to check.
	 *
	 * @param string               $view Path to the view file, relative to the widget's views/ directory.
	 * @param array<string, mixed> $data Variables extracted into the view's scope.
	 * @return void
	 */
	protected function render_view( $view, array $data = array() ) {
		$path = $this->get_views_path() . $view . '.php';

		if ( ! file_exists( $path ) ) {
			return;
		}

		// phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- View data is built by the widget itself, never user input keys.
		extract( $data, EXTR_SKIP );

		include $path;
	}

	/**
	 * Directory holding this widget's view files.
	 *
	 * @return string
	 */
	protected function get_views_path() {
		$reflection = new \ReflectionClass( $this );

		return dirname( $reflection->getFileName() ) . '/views/';
	}
}
