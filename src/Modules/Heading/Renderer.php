<?php
/**
 * Heading render logic.
 *
 * @package Decent_Elements
 * @since   1.3.0
 */

namespace Decent_Elements\Modules\Heading;

defined( 'ABSPATH' ) || exit;

/**
 * Turns raw widget settings into the values the view needs.
 *
 * Kept separate from the widget class because `Widget_Base` cannot be
 * instantiated outside Elementor. A plain class that takes an array and returns
 * an array is unit-testable without WordPress, which matters most for exactly
 * this layer — the one where escaping bugs live.
 *
 * @since 1.3.0
 */
final class Renderer {

	/**
	 * HTML tags this widget is allowed to render.
	 *
	 * The tag control is a SELECT, but Elementor returns whatever is stored in
	 * the database, which a previous import or a hand-edited revision could set
	 * to anything. Escaping a tag name with esc_attr() does not help — the value
	 * lands in tag position, where `script` is as valid a string as `h2`. An
	 * allowlist is the only correct treatment.
	 *
	 * @var array<int, string>
	 */
	const ALLOWED_TAGS = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'span', 'p' );

	/**
	 * Default tag when the stored value is missing or not allowed.
	 */
	const DEFAULT_TAG = 'h2';

	/**
	 * Build view data from widget settings.
	 *
	 * @param array<string, mixed> $settings Settings from get_settings_for_display().
	 * @return array<string, string>|null Null when there is nothing to render.
	 */
	public function prepare( array $settings ) {
		$text = isset( $settings['heading_text'] ) ? $settings['heading_text'] : '';

		if ( '' === trim( (string) $text ) ) {
			return null;
		}

		return array(
			'tag'  => $this->resolve_tag( isset( $settings['heading_tag'] ) ? $settings['heading_tag'] : '' ),
			'text' => (string) $text,
		);
	}

	/**
	 * Resolve a stored tag value to one this widget is allowed to render.
	 *
	 * @param mixed $tag Stored tag value.
	 * @return string
	 */
	public function resolve_tag( $tag ) {
		$tag = is_string( $tag ) ? strtolower( trim( $tag ) ) : '';

		return in_array( $tag, self::ALLOWED_TAGS, true ) ? $tag : self::DEFAULT_TAG;
	}
}
