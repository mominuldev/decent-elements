<?php
/**
 * Control-tree snapshot tool.
 *
 * Elementor stores a widget's settings in `_elementor_data` keyed by control id.
 * Rename or drop a control id and every existing page silently loses that
 * setting — there is no error, the value simply stops being read. That makes
 * control ids the single most dangerous thing to touch while refactoring a
 * widget, and the thing least likely to be noticed by eye.
 *
 * This tool dumps every registered widget's full control tree to JSON so a
 * refactor can be diffed against a baseline.
 *
 * Usage (from the WordPress root):
 *
 *   wp eval-file wp-content/plugins/decent-elements/tools/control-snapshot.php baseline
 *   # ... refactor ...
 *   wp eval-file wp-content/plugins/decent-elements/tools/control-snapshot.php after
 *   diff -u /tmp/de-snapshot-baseline.json /tmp/de-snapshot-after.json
 *
 * An empty diff means no user data can have been affected.
 *
 * @package Decent_Elements
 */

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	return;
}

$label = isset( $args[0] ) ? preg_replace( '/[^a-z0-9._-]/i', '', $args[0] ) : 'snapshot';

do_action( 'elementor/loaded' );

if ( ! did_action( 'elementor/init' ) ) {
	\Elementor\Plugin::$instance->init();
}

$types    = \Elementor\Plugin::$instance->widgets_manager->get_widget_types();
$snapshot = array();

foreach ( $types as $name => $widget ) {
	if ( 0 !== strpos( $name, 'de-' ) ) {
		continue;
	}

	$controls = array();

	foreach ( $widget->get_controls() as $id => $control ) {
		// Only the fields that affect stored data or rendering. Labels are
		// excluded deliberately: rewording a label is safe, renaming an id is not.
		$controls[ $id ] = array(
			'type'        => isset( $control['type'] ) ? $control['type'] : null,
			'default'     => isset( $control['default'] ) ? $control['default'] : null,
			'tab'         => isset( $control['tab'] ) ? $control['tab'] : null,
			'section'     => isset( $control['section'] ) ? $control['section'] : null,
			'responsive'  => ! empty( $control['responsive'] ),
			'selectors'   => isset( $control['selectors'] ) ? array_values( (array) $control['selectors'] ) : array(),
			'condition'   => isset( $control['condition'] ) ? $control['condition'] : null,
			'return_value' => isset( $control['return_value'] ) ? $control['return_value'] : null,
		);
	}

	ksort( $controls );

	$snapshot[ $name ] = array(
		'name'           => $widget->get_name(),
		'title'          => $widget->get_title(),
		'icon'           => $widget->get_icon(),
		'categories'     => $widget->get_categories(),
		'style_depends'  => $widget->get_style_depends(),
		'script_depends' => $widget->get_script_depends(),
		'control_count'  => count( $controls ),
		'controls'       => $controls,
	);
}

ksort( $snapshot );

$path = sys_get_temp_dir() . '/de-snapshot-' . $label . '.json';

file_put_contents( $path, wp_json_encode( $snapshot, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES ) );

WP_CLI::line( sprintf( 'Wrote %d widgets (%d controls) to %s', count( $snapshot ), array_sum( wp_list_pluck( $snapshot, 'control_count' ) ), $path ) );
