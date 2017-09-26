<?php

namespace Mamaduka\BpNotifications;

use InvalidArgumentException;

/**
 * Messages service.
 */
class MessagesService implements Service {

	/**
	 * Register the current Registerable.
	 *
	 * @return void
	 */
	public function register() {
		add_filter( 'bp_activity_notification_callback', function ( $callback ) {
			return [ $this, 'callback' ];
		} );
	}

	/**
	 * Filter Activity notifications description.
	 *
	 * @return mixed
	 */
	public function callback( $action, $activity_id, $user_id, $total, $format = 'string', $id ) {
		$data = [
			'id'          => $id,
			'action'      => $action,
			'activity_id' => $activity_id,
			'user_id'     => $user_id,
			'total'       => $total,
			'format'      => $format,
		];

		$messages = $this->getMessages();

		$message = $this->instantiateMessage( $data, $messages );

		if ( $format === 'string' ) {
			return $message->toHtml();
		}

		return $message->toArray();
	}

	/**
	 * Instantiate message.
	 *
	 * @param array $data
	 * @param array $messages
	 * 
	 * @return Messages\Message
	 * @throws InvalidArgumentException
	 */
	protected function instantiateMessage( array $data, array $messages ) {
		$action = $data['action'];

		if ( ! array_key_exists( $action, $messages ) ) {
			throw new InvalidArgumentException( sprintf(
				'Message class for %s action does not exist',
				$action
			) );
		}

		$message = new $messages[ $action ]( $data );

		if ( ! $message instanceof Messages\Message ) {
			throw new InvalidArgumentException( sprintf(
				'The message "%s" is not recognized and cannot be rendered',
				is_object( $message ) ? get_class( $message ) : (string) $message
			) );
		}

		return $message;
	}

	/**
	 * Get list of notification messages.
	 *
	 * @return array
	 */
	protected function getMessages() {
		return [
			'new_at_mention' => Messages\AtMentionMessage::class,
			'update_reply'   => Messages\UpdateReplyMessage::class,
			'comment_reply'  => Messages\CommentReplyMessage::class,
		];
	}
}