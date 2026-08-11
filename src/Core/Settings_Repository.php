<?php
/**
 * Consolidated settings storage.
 *
 * @package Decent_Elements
 * @since   1.2.0
 */

namespace Decent_Elements\Core;

defined( 'ABSPATH' ) || exit;

/**
 * Reads and writes every plugin setting through a single autoloaded option.
 *
 * The plugin previously spread its state across eight separate options, each
 * fetched with its own get_option() call. Consolidating them into one
 * autoloaded row removes those lookups from the per-request path entirely: the
 * row travels in WordPress's alloptions cache, so reading a setting costs
 * nothing after the first hit.
 *
 * Legacy options are still read as a fallback and are NOT deleted. They stay in
 * place for two releases so a rollback cannot strand user data — see §9 of
 * docs/ARCHITECTURE-AUDIT.md.
 *
 * @since 1.2.0
 */
final class Settings_Repository {

	/**
	 * The single option this class owns.
	 */
	const OPTION = 'decent_elements_settings';

	/**
	 * Current settings schema version.
	 */
	const DB_VERSION = 2;

	/**
	 * Legacy option names, kept for dual-read and migration.
	 */
	const LEGACY_WIDGETS       = 'decent_elements_widget_settings';
	const LEGACY_EXTENSIONS    = 'decent_elements_extension_settings';
	const LEGACY_OPTIMIZATION  = 'decent_elements_enable_asset_optimization';
	const LEGACY_UPDATED_AT    = 'decent_elements_settings_last_updated';
	const LEGACY_LAST_RUN      = 'decent_elements_last_optimization';
	const LEGACY_JS_GENERATED  = 'decent_elements_minified_js_generated';
	const LEGACY_CSS_GENERATED = 'decent_elements_minified_css_generated';

	/**
	 * In-request cache of the settings row.
	 *
	 * @var array<string, mixed>|null
	 */
	private $cache = null;

	/**
	 * Read the whole settings row.
	 *
	 * @return array<string, mixed>
	 */
	public function all() {
		if ( null !== $this->cache ) {
			return $this->cache;
		}

		$stored = get_option( self::OPTION, array() );

		if ( ! is_array( $stored ) ) {
			$stored = array();
		}

		$this->cache = $stored + $this->defaults();

		return $this->cache;
	}

	/**
	 * Whether a module is enabled.
	 *
	 * Falls back to the legacy per-type options when the module has no entry in
	 * the consolidated row, so an un-migrated site behaves identically.
	 *
	 * @param string $module_id Namespaced module id, e.g. `widget:heading`.
	 * @param bool   $fallback  Value when nothing is stored anywhere.
	 * @return bool
	 */
	public function is_module_enabled( $module_id, $fallback ) {
		$settings = $this->all();

		if ( isset( $settings['modules'][ $module_id ] ) ) {
			return (bool) $settings['modules'][ $module_id ];
		}

		$legacy = $this->read_legacy_module( $module_id );

		if ( null !== $legacy ) {
			return $legacy;
		}

		return (bool) $fallback;
	}

	/**
	 * Persist the enabled state of a set of modules.
	 *
	 * Writes are merged, so saving only widgets does not clear extensions.
	 *
	 * @param array<string, bool> $states Module id => enabled.
	 * @return bool
	 */
	public function set_modules( array $states ) {
		$settings = $this->all();

		foreach ( $states as $id => $enabled ) {
			$settings['modules'][ $id ] = (bool) $enabled;
		}

		$settings['updated_at'] = time();

		return $this->save( $settings );
	}

	/**
	 * Read an optimization sub-setting.
	 *
	 * @param string $key     Key within the optimization array.
	 * @param mixed  $fallback Fallback value.
	 * @return mixed
	 */
	public function get_optimization( $key, $fallback = null ) {
		$settings = $this->all();

		if ( isset( $settings['optimization'][ $key ] ) ) {
			return $settings['optimization'][ $key ];
		}

		$legacy = $this->read_legacy_optimization( $key );

		return null !== $legacy ? $legacy : $fallback;
	}

	/**
	 * Write an optimization sub-setting.
	 *
	 * @param string $key   Key within the optimization array.
	 * @param mixed  $value Value to store.
	 * @return bool
	 */
	public function set_optimization( $key, $value ) {
		$settings = $this->all();

		$settings['optimization'][ $key ] = $value;
		$settings['updated_at']           = time();

		return $this->save( $settings );
	}

	/**
	 * Timestamp of the last settings change.
	 *
	 * @return int
	 */
	public function updated_at() {
		$settings = $this->all();

		if ( ! empty( $settings['updated_at'] ) ) {
			return (int) $settings['updated_at'];
		}

		return (int) get_option( self::LEGACY_UPDATED_AT, 0 );
	}

	/**
	 * Run the one-time migration from the legacy option set.
	 *
	 * Hooked on `plugins_loaded` rather than plugin activation, because
	 * activation hooks do not fire when a plugin is updated in place.
	 *
	 * @param array<int, array{id: string, default: bool}> $known_modules Modules to seed.
	 * @return void
	 */
	public function maybe_migrate( array $known_modules ) {
		$settings = $this->all();

		if ( isset( $settings['db_version'] ) && (int) $settings['db_version'] >= self::DB_VERSION ) {
			return;
		}

		foreach ( $known_modules as $module ) {
			if ( isset( $settings['modules'][ $module['id'] ] ) ) {
				continue;
			}

			$legacy = $this->read_legacy_module( $module['id'] );

			$settings['modules'][ $module['id'] ] = null !== $legacy ? $legacy : (bool) $module['default'];
		}

		$optimization = array(
			'enabled'       => (bool) get_option( self::LEGACY_OPTIMIZATION, false ),
			'last_run'      => (int) get_option( self::LEGACY_LAST_RUN, 0 ),
			'js_generated'  => (int) get_option( self::LEGACY_JS_GENERATED, 0 ),
			'css_generated' => (int) get_option( self::LEGACY_CSS_GENERATED, 0 ),
		);

		$settings['optimization'] = $optimization + ( isset( $settings['optimization'] ) ? $settings['optimization'] : array() );
		$settings['updated_at']   = (int) get_option( self::LEGACY_UPDATED_AT, time() );
		$settings['db_version']   = self::DB_VERSION;

		$this->save( $settings );
	}

	/**
	 * Default shape of the settings row.
	 *
	 * @return array<string, mixed>
	 */
	private function defaults() {
		return array(
			'db_version'   => 0,
			'modules'      => array(),
			'optimization' => array(),
			'updated_at'   => 0,
		);
	}

	/**
	 * Persist the settings row and refresh the in-request cache.
	 *
	 * @param array<string, mixed> $settings Full settings row.
	 * @return bool
	 */
	private function save( array $settings ) {
		$this->cache = $settings;

		// Third argument forces autoload, keeping reads off the query path.
		return update_option( self::OPTION, $settings, true );
	}

	/**
	 * Look a module up in the legacy per-type options.
	 *
	 * @param string $module_id Namespaced module id.
	 * @return bool|null Null when the legacy options have no opinion.
	 */
	private function read_legacy_module( $module_id ) {
		$parts = explode( ':', $module_id, 2 );

		if ( 2 !== count( $parts ) ) {
			return null;
		}

		list( $type, $bare_id ) = $parts;

		$option = 'widget' === $type ? self::LEGACY_WIDGETS : self::LEGACY_EXTENSIONS;
		$stored = get_option( $option, array() );

		if ( ! is_array( $stored ) || ! array_key_exists( $bare_id, $stored ) ) {
			return null;
		}

		return (bool) $stored[ $bare_id ];
	}

	/**
	 * Look an optimization key up in the legacy options.
	 *
	 * @param string $key Optimization key.
	 * @return mixed|null Null when the legacy options have no opinion.
	 */
	private function read_legacy_optimization( $key ) {
		$map = array(
			'enabled'       => self::LEGACY_OPTIMIZATION,
			'last_run'      => self::LEGACY_LAST_RUN,
			'js_generated'  => self::LEGACY_JS_GENERATED,
			'css_generated' => self::LEGACY_CSS_GENERATED,
		);

		if ( ! isset( $map[ $key ] ) ) {
			return null;
		}

		$value = get_option( $map[ $key ], null );

		if ( null === $value ) {
			return null;
		}

		return 'enabled' === $key ? (bool) $value : $value;
	}
}
