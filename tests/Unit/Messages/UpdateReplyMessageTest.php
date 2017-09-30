<?php

namespace Mamaduka\BpNotifications\Tests\Unit\Messages;

use Brain\Monkey\Functions;
use Mamaduka\BpNotifications\Messages\UpdateReplyMessage as Testee;
use Mamaduka\BpNotifications\Tests\TestCase;

/**
 * @coversDefaultClass Mamaduka\BpNotifications\Messages\UpdateReplyMessage
 */
class UpdateReplyMessageTest extends TestCase {

	/**
	 * @covers ::message
	 */
	public function test_message_single_mention() {
		Functions\expect('bp_core_get_user_displayname')
			->with(1)
			->andReturn('Rick Sanchez');

		$data = $this->mockData();

		$this->assertSame( 'Rick Sanchez commented on one of your updates', ( new Testee( $data ) )->message() );
	}

	/**
	 * @covers ::message
	 */
	public function test_message_multiple_mention() {
		$data = $this->mockData(['total' => 4 ]);

		$this->assertSame( 'You have 4 new replies', ( new Testee( $data ) )->message() );
	}

	/**
	 * @covers ::url
	 */
	public function test_url_single() {
		$url = 'https://example.com/activity/p/1/';
		$data = $this->mockData([
			'id' => 1,
			'activity_id' => 1,
			'total' => 1,
		]);

		Functions\expect('bp_activity_get_permalink')
			->with($data['activity_id'])
			->andReturn('https://example.com/activity/p/1/');

		Functions\expect('add_query_arg')
			->with( 'nid', $data['id'], $url )
			->andReturn( $url . '?nid=1' );

		$this->assertSame( $url . '?nid=1', ( new Testee( $data ) )->url() );
	}

	/**
	 * @covers ::url
	 */
	public function test_url_multiple() {
		$url = 'https://example.com/members/rick/notifications/';
		$data = $this->mockData([
			'action' => 'update_reply',
			'user_id' => 137,
			'total' => 3,
		]);

		Functions\expect('bp_get_notifications_permalink')
			->with($data['user_id'])
			->andReturn('https://example.com/members/rick/notifications/');

		Functions\expect('add_query_arg')
			->with( 'type', $data['action'], $url )
			->andReturn( $url . '?type=update_reply' );

		$this->assertSame( $url . '?type=update_reply', ( new Testee( $data ) )->url() );
	}

	/**
	 * @covers ::toArray
	 */
	public function test_toArray() {
		$url = 'https://example.com/activity/p/1/';
		$data = $this->mockData([
			'id' => 1,
			'activity_id' => 1,
			'user_id' => 137,
			'total' => 1,
		]);

		Functions\expect('bp_core_get_user_displayname')
			->with($data['user_id'])
			->andReturn('Rick Sanchez');

		Functions\expect('bp_activity_get_permalink')
			->with($data['activity_id'])
			->andReturn($url);

		Functions\expect('add_query_arg')
			->with('nid', $data['id'], $url)
			->andReturn($url . '?nid=1');

		$this->assertEquals([
			'text' => 'Rick Sanchez commented on one of your updates',
			'link' => $url . '?nid=1'
		], (new Testee($data))->toArray());
	}

	/**
	 * @covers ::toHtml
	 */
	public function test_toHtml() {
		$url = 'https://example.com/activity/p/1/';
		$data = $this->mockData([
			'id' => 1,
			'activity_id' => 1,
			'user_id' => 137,
			'total' => 1,
		]);

		Functions\expect('bp_core_get_user_displayname')
			->with($data['user_id'])
			->andReturn('Rick Sanchez');

		Functions\expect('bp_activity_get_permalink')
			->with($data['activity_id'])
			->andReturn($url);

		Functions\expect('add_query_arg')
			->with('nid', $data['id'], $url)
			->andReturn($url . '?nid=1');

		Functions\when('esc_url')
			->returnArg();

		Functions\when('esc_html')
			->returnArg();

		$this->assertSame(
			'<a href="https://example.com/activity/p/1/?nid=1">Rick Sanchez commented on one of your updates</a>',
			( new Testee( $data ) )->toHtml()
		);
	}
}