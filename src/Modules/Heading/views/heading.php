<?php
/**
 * Heading view.
 *
 * @package Decent_Elements
 * @since   1.3.0
 *
 * @var string $tag  Tag name, already validated against an allowlist by Renderer.
 * @var string $text Heading text, escaped here.
 */

defined( 'ABSPATH' ) || exit;

?>
<<?php echo esc_attr( $tag ); ?> class="de-heading"><?php echo esc_html( $text ); ?></<?php echo esc_attr( $tag ); ?>>
