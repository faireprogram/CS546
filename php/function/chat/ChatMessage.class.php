<?php

/**
 * @author faire_000
 *
 */
class ChatMessage {
	
	/**
	 * @var $sender
	 */
	public $sender;
	
	/**
	 * @var $chat_content
	 */
	public $chat_content;
	
	/**
	 * @var $time
	 */
	public $time;
	
	/**
	 * @function:  __construct 
	 */
	function __construct($sender, $chat_content, $time) {
		$this->sender = $sender;
		$this->chat_content = $chat_content;
		$this->time = $time;
	}
}

?>