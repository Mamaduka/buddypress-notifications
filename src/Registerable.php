<?php

namespace Mamaduka\BpNotifications;

/**
 * Interface Registerable.
 *
 * An object that can be `register()`ed.
 */
interface Registerable {

	/**
	 * Register the current Registerable.
	 *
	 * @return void
	 */
	public function register();
}
