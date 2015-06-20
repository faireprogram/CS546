<?php

define("DATA_DIR", dirname(__FILE__)."\data");
//CHAT BASE
define("DATA_CHAT_DIR", dirname(__FILE__)."\data\chat");
define("DATA_CHAT_DIR_MAILBOX", dirname(__FILE__)."\data\chat\mailbox");
define("DATA_CHAT_DIR_UNREADMAILS", dirname(__FILE__)."\data\chat\unreadmails");
define("DATA_CHAT_DIR_HISTORY", dirname(__FILE__)."\data\chat\history");

define("DEFAULT_GROUPNAME", "DefaultGroup");
	
define("UNKNOWN_GROUPNAME", "Unknown Person");
define("DFAULTIMG", "img.jpg");

define("DEBUG", "true");

abstract class FILE_OP_STATE {
	 const SUCCESS = 1;
	 const LOCKED = 2; // locked by others
	 const NOEXIST = 3; // non exist
	 const OTHER = 4; // other problems
}


abstract class ADD_STATE {
	const INVITE = 1;
	const RECEIVE = 2; 
}

abstract class MSG_TYPE {
	const SEND_MSG = "SEND_MSG";
	const RE_SEND_MSG = "RE_SEND_MSG";
	const ADD_FRIEND = "ADD_FRIEND";
	const RE_ADD_FRIEND = "RE_ADD_FRIEND";
	const DELETE_FRIEND = "DELETE_FRIEND";
	const RE_DELETE_FRIEND = "RE_DELETE_FRIEND";
	const EXECUTE = "EXECUTE";
	const CHAT_HISTORY = "CHAT_HISTORY";
}
/*
 * DataBase Instance, Global Object
 */
$mysqldi;

?>