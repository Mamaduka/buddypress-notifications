<?php

namespace Mamaduka\BpNotifications\Tests;

use Brain\Monkey;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

/**
 * Abstract base class for all test case implementations.
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase {

	use MockeryPHPUnitIntegration;

	/**
	 * Prepares the test environment before each test.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function setUp() {

		parent::setUp();
		Monkey\setUp();
	}

	/**
	 * Cleans up the test environment after each test.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function tearDown() {

		Monkey\tearDown();
		parent::tearDown();
	}

	protected function mockData( array $data = [] ) {
		return array_merge([
			'id' => 1,
			'total' => 1,
			'user_id' => 1,
			'activity_id' => 1,
		], $data );
	}
}