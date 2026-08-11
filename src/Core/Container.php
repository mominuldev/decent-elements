<?php
/**
 * Minimal service container.
 *
 * @package Decent_Elements
 * @since   1.1.0
 */

namespace Decent_Elements\Core;

defined( 'ABSPATH' ) || exit;

/**
 * A deliberately small service container.
 *
 * This does not implement PSR-11. Bundling `psr/container` into a WordPress
 * plugin risks a fatal class-redeclaration when another plugin bundles a
 * different version of the same interface into the same request. The contract
 * here is small enough that the interface buys us nothing.
 *
 * Services are registered as factories and resolved lazily, so nothing is
 * constructed until something asks for it.
 *
 * @since 1.1.0
 */
final class Container {

	/**
	 * Service factories, keyed by service id.
	 *
	 * @var array<string, callable>
	 */
	private $factories = array();

	/**
	 * Resolved singletons, keyed by service id.
	 *
	 * @var array<string, mixed>
	 */
	private $resolved = array();

	/**
	 * Register a lazily-resolved service.
	 *
	 * @param string   $id      Service identifier, conventionally the class name.
	 * @param callable $factory Receives the container, returns the service.
	 * @return void
	 */
	public function bind( $id, callable $factory ) {
		$this->factories[ $id ] = $factory;
		unset( $this->resolved[ $id ] );
	}

	/**
	 * Register an already-constructed service.
	 *
	 * @param string $id       Service identifier.
	 * @param mixed  $instance The service.
	 * @return void
	 */
	public function instance( $id, $instance ) {
		$this->resolved[ $id ] = $instance;
	}

	/**
	 * Whether a service is registered.
	 *
	 * @param string $id Service identifier.
	 * @return bool
	 */
	public function has( $id ) {
		return isset( $this->resolved[ $id ] ) || isset( $this->factories[ $id ] );
	}

	/**
	 * Resolve a service, constructing it on first use.
	 *
	 * @param string $id Service identifier.
	 * @return mixed
	 * @throws \InvalidArgumentException When the service is not registered.
	 */
	public function get( $id ) {
		if ( isset( $this->resolved[ $id ] ) ) {
			return $this->resolved[ $id ];
		}

		if ( ! isset( $this->factories[ $id ] ) ) {
			throw new \InvalidArgumentException(
				sprintf( 'Decent Elements: service "%s" is not registered.', esc_html( $id ) )
			);
		}

		$factory = $this->factories[ $id ];

		$this->resolved[ $id ] = $factory( $this );

		return $this->resolved[ $id ];
	}
}
