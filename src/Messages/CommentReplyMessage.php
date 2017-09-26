<?php

namespace Mamaduka\BpNotifications\Messages;

class CommentReplyMessage extends UpdateReplyMessage {

	/**
	 * Create a new message instance.
	 *
	 * @param array $data
	 * @return void
	 */
	public function __construct( array $data = [] ) {
		parent::__construct( $data );
	}

	/**
	 * Get message text.
	 *
	 * @return string
	 */
	public function message() {
		if ( $this->data['total'] > 1 ) {
			return sprintf( 'You have %1$d new comment replies', (int) $this->data['total'] );
		}

		return sprintf( '%1$s replied to one your activity comments', bp_core_get_user_displayname( $this->data['user_id' ] ) );
	}
}
