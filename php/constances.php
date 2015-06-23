<?php

// -------------------   Data Base Confiugre ----------------------

DEFINE('DATABASE_USER', 'www');
DEFINE('DATABASE_PASSWORD', 'zw198787');
DEFINE('DATABASE_HOST', 'localhost');
DEFINE('DATABASE_NAME', 'cs546');


// -----------------------------------------------------------------
define("DEFAULT_GROUPNAME", "DefaultGroup");
define("UNKNOWN_GROUPNAME", "Unknown Person");
define("DFAULTIMG", "img.jpg");
define("DEBUG", "true");
define("SUCCESS", "ok");

//This is the address that will appear coming from ( Sender )
define('EMAIL', 'email@gmail.com');

/*Define the root url where the script will be found such as
 http://website.com or http://website.com/Folder/ */
DEFINE('WEBSITE_URL', 'http://localhost');

// ----------------------   Enum ------------------------------------
abstract class PEMISSION_ERROR {
	 const NOT_YOUR_FRIEND = "NOT_YOUR_FRIEND";
	 const NOT_YOUR_RESOURCE = "NOT_YOUR_RESOURCE"; // locked by others
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

// ----------------------------- Set Time Zone -------------------
date_default_timezone_set('UTC');


?>