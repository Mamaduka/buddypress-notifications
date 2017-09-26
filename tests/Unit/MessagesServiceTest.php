<?php

namespace Mamaduka\BpNotifications\Tests\Unit;

use Mamaduka\BpNotifications\MessagesService as Testee;
use Mamaduka\BpNotifications\Tests\TestCase;

/**
 * @coversDefaultClass Mamaduka\BpNotifications\MessagesService
 */
class MessagesServiceTest extends TestCase {

	/**
	 * @covers ::callback
	 * @expectedException InvalidArgumentException
	 */
	public function test_invalid_action_in_callback() {
		$data = $this->mockData(['action' => 'favorited']);

		( new Testee() )->callback(
			$data['action'],
			$data['activity_id'],
			$data['user_id'],
			$data['total'],
			'string',
			$data['id']
		);
	}

	/**
	 * @covers ::callback
	 */
	public function test_callback_array_format() {
		
	}
}