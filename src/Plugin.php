<?php

namespace Mamaduka\BpNotifications;

use InvalidArgumentException;

/**
 * Class Plugin.
 *
 * Main plugin controller class that hooks the plugin's functionality into the
 * WordPress request lifecycle.
 */
final class Plugin implements Registerable {

	/**
	 * Register the current Registerable.
	 *
	 * @return void
	 */
	public function register() {
		add_action( 'bp_loaded', [ $this, 'registerServices' ] );
	}

	/**
	 * Register the individual services of this plugin.
	 *
	 * @throws InvalidArgumentException
	 */
	public function registerServices() {
		$services = $this->getServices();
		$services = array_map( [ $this, 'instantiateServices' ], $services );
		
		array_walk( $services, function ( Service $service ) {
			$service->register();
		} );
	}

	/**
	 * Instantiate a single service.
	 *
	 * @param string $class
	 *
	 * @return Service
	 * @throws InvalidArgumentException
	 */
	protected function instantiateServices( $class ) {
		if ( ! class_exists( $class ) ) {
			throw new InvalidArgumentException( sprintf(
				'The service "%s" is not recognized and cannot be registered.',
				is_object( $class ) ? get_class( $class ) : (string) $class
			) );
		}

		$service = new $class();

		if ( ! $service instanceof Service ) {
			throw new InvalidArgumentException( sprintf(
				'The service "%s" is not recognized and cannot be registered.',
				is_object( $service ) ? get_class( $service ) : (string) $service
			) );
		}

		return $service;
	}

	/**
	 * Get list of the services.
	 *
	 * @return array
	 */
	protected function getServices() {
		return [
			MessagesService::class,
		];
	}
}