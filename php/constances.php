<?php

define("DATA_DIR", dirname(__FILE__)."\data");
//CHAT BASE
define("DATA_CHAT_DIR", dirname(__FILE__)."\data\chat");
define("DATA_CHAT_DIR_MAILBOX", dirname(__FILE__)."\data\chat\mailbox");
define("DATA_CHAT_DIR_HISTORY", dirname(__FILE__)."\data\chat\history");

define("WAITING_TIME", 30);

define("DEBUG", TRUE);

echo DATA_CHAT_DIR_MAILBOX;

abstract class FILE_OP_STATE {
	 const SUCCESS = 1;
	 const LOCKED = 2; // locked by others
	 const NOEXIST = 3; // non exist
	 const OTHER = 4; // other problems
}

?>