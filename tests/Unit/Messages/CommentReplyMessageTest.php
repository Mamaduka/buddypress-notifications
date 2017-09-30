<?php

namespace Mamaduka\BpNotifications\Tests\Unit\Messages;

use Brain\Monkey\Functions;
use Mamaduka\BpNotifications\Messages\CommentReplyMessage as Testee;
use Mamaduka\BpNotifications\Tests\TestCase;

/**
 * @coversDefaultClass Mamaduka\BpNotifications\Messages\CommentReplyMessage
 */
class CommentReplyMessageTest extends TestCase {

	/**
	 * @covers ::message
	 * @covers ::__construct
	 */
	public function test_message_single_mention() {
		Functions\expect('bp_core_get_user_displayname')
			->with(1)
			->andReturn('Rick Sanchez');

		$data = $this->mockData();

		$this->assertSame(
			'Rick Sanchez replied to one your activity comments',
			( new Testee( $data ) )->message()
		);
	}

	/**
	 * @covers ::message
	 */
	public function test_message_multiple_mention() {
		$data = $this->mockData(['total' => 4 ]);

		$this->assertSame('You have 4 new comment replies', ( new Testee( $data ) )->message());
	}
}