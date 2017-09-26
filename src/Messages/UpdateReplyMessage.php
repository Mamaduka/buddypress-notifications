<?php

namespace Mamaduka\BpNotifications\Messages;

class UpdateReplyMessage implements Message {

	/**
	 * Notification message data.
	 *
	 * @var array
	 */
	protected $data;

	/**
	 * Create a new message instance.
	 *
	 * @param array $data
	 * @return void
	 */
	public function __construct( array $data = [] ) {
		$this->data = $data;
	}

	/**
	 * Get message text.
	 *
	 * @return string
	 */
	public function message() {
		if ( $this->data['total'] > 1 ) {
			return sprintf( 'You have %d new replies', (int) $this->data['total'] );
		}

		return sprintf( '%s commented on one of your updates', bp_core_get_user_displayname( $this->data['user_id' ] ) );
	}

	/**
	 * Get message URL.
	 *
	 * @return string
	 */
	public function url() {
		if ( $this->data['total'] > 1 ) {
			return add_query_arg(
				'type',
				$this->data['action'],
				bp_get_notifications_permalink( $this->data['user_id'] ) );
		}

		return add_query_arg(
			'nid',
			$this->data['id'],
			bp_activity_get_permalink( $this->data['activity_id'] )
		);
	}

	/**
	 * Get the array representation of the message.
	 *
	 * @return array
	 */
	public function toArray() {
		return [
			'text' => $this->message(),
			'link' => $this->url(),
		];
	}

	/**
	 * Get the HTML representation of the message.
	 *
	 * @return string
	 */
	public function toHtml() {
		return sprintf(
			'<a href="%1$s">%2$s</a>',
			esc_url( $this->url() ),
			esc_html( $this->message() )
		);
	}
}
