<?php
/**
 * Elementor widget category registration.
 *
 * @package Decent_Elements
 * @since   1.2.0
 */

namespace Decent_Elements\Integration\Elementor;

defined( 'ABSPATH' ) || exit;

/**
 * Registers the plugin's widget category with Elementor.
 *
 * Registration itself goes through the public `add_category()` API, so the
 * category always appears even if everything else here stops working.
 *
 * Ordering is the awkward part. Elementor's `add_category()` only appends, and
 * `Elements_Manager::$categories` is private with no filter over the final
 * array — verified against Elementor 4.0.2. The plugin's category has always
 * appeared at the top of the panel, so simply appending is a visible
 * regression for existing users.
 *
 * The compromise: register through the supported API, then attempt to move the
 * category to the front as a clearly-isolated, fully-guarded best effort. If a
 * future Elementor release changes or seals that property, the guard fails
 * closed and the only consequence is that the category sits lower in the panel
 * — never a fatal. That is a much better failure mode than the previous
 * unguarded `Closure::call()` write.
 *
 * @since 1.2.0
 */
final class Category_Registrar {

	/**
	 * Category slug.
	 */
	const CATEGORY = 'decent-elements';

	/**
	 * Register WordPress hooks.
	 *
	 * @return void
	 */
	public function register_hooks() {
		add_action( 'elementor/elements/categories_registered', array( $this, 'register_category' ) );
	}

	/**
	 * Register the category and try to place it first.
	 *
	 * @param \Elementor\Elements_Manager $elements_manager Elementor's manager.
	 * @return void
	 */
	public function register_category( $elements_manager ) {
		$elements_manager->add_category(
			self::CATEGORY,
			array(
				/* translators: %s: bolded brand name. */
				'title' => sprintf( __( '%s Elements', 'decent-elements' ), '<strong>Decent</strong>' ),
				'icon'  => 'fa fa-plug',
			)
		);

		$this->try_move_to_front( $elements_manager );
	}

	/**
	 * Best-effort reorder so the category leads the panel.
	 *
	 * @param \Elementor\Elements_Manager $elements_manager Elementor's manager.
	 * @return void
	 */
	private function try_move_to_front( $elements_manager ) {
		try {
			$property = new \ReflectionProperty( $elements_manager, 'categories' );
		} catch ( \ReflectionException $e ) {
			// Property gone in this Elementor release; ordering is cosmetic.
			return;
		}

		$property->setAccessible( true );

		$categories = $property->getValue( $elements_manager );

		if ( ! is_array( $categories ) || ! isset( $categories[ self::CATEGORY ] ) ) {
			return;
		}

		$ours = array( self::CATEGORY => $categories[ self::CATEGORY ] );

		unset( $categories[ self::CATEGORY ] );

		$property->setValue( $elements_manager, array_merge( $ours, $categories ) );
	}
}
