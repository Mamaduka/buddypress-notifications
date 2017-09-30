<?php

namespace Mamaduka\BpNotifications\Tests\Unit\Messages;

use Brain\Monkey\Functions;
use Mamaduka\BpNotifications\Messages\AtMentionMessage as Testee;
use Mamaduka\BpNotifications\Tests\TestCase;

/**
 * @coversDefaultClass Mamaduka\BpNotifications\Messages\AtMentionMessage
 */
class AtMentionMessageTest extends TestCase {

	/**
	 * @covers ::message
	 */
	public function test_message_single_mention() {
		Functions\expect('bp_core_get_user_displayname')
			->with(1)
			->andReturn('Rick Sanchez');

		$data = $this->mockData();

		$this->assertSame( 'Rick Sanchez mentioned you', ( new Testee( $data ) )->message() );
	}

	/**
	 * @covers ::message
	 */
	public function test_message_multiple_mention() {
		$data = $this->mockData(['total' => 3 ]);

		$this->assertSame( 'You have 3 new mentions', ( new Testee( $data ) )->message() );
	}

	/**
	 * @covers ::url
	 */
	public function test_url() {
		Functions\expect('bp_loggedin_user_domain')
			->withNoArgs()
			->andReturn('https://example.com/members/rick/');

		Functions\expect('bp_get_activity_slug')
			->withNoArgs()
			->andReturn('activity');

		$this->assertSame( 'https://example.com/members/rick/activity/mentions/', ( new Testee() )->url() );
	}

	/**
	 * @covers ::toArray
	 */
	public function test_toArray() {
		Functions\expect('bp_core_get_user_displayname')
			->with(1)
			->andReturn('Rick Sanchez');

		Functions\expect('bp_loggedin_user_domain')
			->withNoArgs()
			->andReturn('https://example.com/members/rick/');

		Functions\expect('bp_get_activity_slug')
			->withNoArgs()
			->andReturn('activity');

		$this->assertEquals([
			'text' => 'Rick Sanchez mentioned you',
			'link' => 'https://example.com/members/rick/activity/mentions/'
		], ( new Testee( $this->mockData() ) )->toArray() );
	}

	/**
	 * @covers ::toHtml
	 */
	public function test_toHtml() {
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

		$this->assertSame(
			'<a href="https://example.com/members/rick/activity/mentions/">Rick Sanchez mentioned you</a>',
			( new Testee( $this->mockData() ) )->toHtml()
		);
	}
}