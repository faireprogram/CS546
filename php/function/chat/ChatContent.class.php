<?php

class ChatContent {
	
	/**
	 * @var $sender
	 */
	public $format;
	
	/**
	 * @var $content
	 */
	public $content;
	
	/**
	 * @function:  __construct 
	 */
	function __construct($format, $content) {
		$this->format = $format;
		$this->content = $content;
	}
}

?>