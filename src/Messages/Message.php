<?php

namespace Mamaduka\BpNotifications\Messages;

/**
 * Interface Message
 */
interface Message {

	/**
	 * Get message text.
	 *
	 * @return string
	 */
	public function message();

	/**
	 * Get the array representation of the message.
	 *
	 * @return array
	 */
	public function toArray();

	/**
	 * Get the HTML representation of the message.
	 *
	 * @return string
	 */
	public function toHtml();
}