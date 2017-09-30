<?php

namespace Mamaduka\BpNotifications\Tests\Unit;

use Brain\Monkey\Functions;
use Mamaduka\BpNotifications\MessagesService as Testee;
use Mamaduka\BpNotifications\Tests\TestCase;

/**
 * @coversDefaultClass Mamaduka\BpNotifications\MessagesService
 */
class MessagesServiceTest extends TestCase {

	/**
	 * @covers ::register
	 */
	public function test_register() {
		( new Testee() )->register();

		$this->assertTrue(
			has_filter('bp_activity_notification_callback'),
			'function ( $callback )'
		);
	}

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
	public function test_callback_string_format() {
		$data = $this->mockData(['action' => 'new_at_mention']);

		Functions\expect('bp_core_get_user_displayname')
		->with(1)
		->andReturn('Rick Sanchez');

		Functions\expect('bp_loggedin_user_domain')
			->withNoArgs()
			->andReturn('https://example.com/members/rick/');

		Functions\expect('bp_get_activity_slug')
			->withNoArgs()
			->andReturn('activity');

		Functions\when('esc_url')
			->returnArg();

		Functions\when('esc_html')
			->returnArg();

		$message = ( new Testee() )->callback(
			$data['action'],
			$data['activity_id'],
			$data['user_id'],
			$data['total'],
			'string',
			$data['id']
		);

		$this->assertSame(
			'<a href="https://example.com/members/rick/activity/mentions/">Rick Sanchez mentioned you</a>',
			$message
		);
	}

	/**
	 * @covers ::callback
	 */
	public function test_callback_array_format() {
		$data = $this->mockData(['action' => 'new_at_mention']);

		Functions\expect('bp_core_get_user_displayname')
			->with(1)
			->andReturn('Rick Sanchez');

		Functions\expect('bp_loggedin_user_domain')
			->withNoArgs()
			->andReturn('https://example.com/members/rick/');

		Functions\expect('bp_get_activity_slug')
			->withNoArgs()
			->andReturn('activity');

		$message = ( new Testee() )->callback(
			$data['action'],
			$data['activity_id'],
			$data['user_id'],
			$data['total'],
			'array',
			$data['id']
		);

		$this->assertEquals([
			'text' => 'Rick Sanchez mentioned you',
			'link' => 'https://example.com/members/rick/activity/mentions/'
		], $message );
	}
}