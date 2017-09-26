<?php

namespace Mamaduka\BpNotifications\Messages;

class AtMentionMessage implements Message {

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
			return sprintf( 'You have %1$d new mentions', (int) $this->data['total'] );
		}

		return sprintf( '%1$s mentioned you', bp_core_get_user_displayname( $this->data['user_id' ] ) );
	}

	/**
	 * Get message URL.
	 *
	 * @return string
	 */
	public function url() {
		return bp_loggedin_user_domain() . bp_get_activity_slug() . '/mentions/';
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
