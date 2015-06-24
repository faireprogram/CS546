<?php

include_once dirname(__FILE__).'/lib/databaseClassMySQLi.php';

include_once dirname(__FILE__).'/constances.php';

// Fast Template
include_once dirname(__FILE__).'/lib/class.FastTemplate.php';

// Utils method
include_once  dirname(__FILE__).'/utils/SqlHelper.php' ;
include_once  dirname(__FILE__).'/utils/StringHelper.php' ;
include_once  dirname(__FILE__).'/utils/CmdHelper.php';

/*
 * Need To check it works?
 */
//make sure data/img exist
if(!file_exists("../data/img exist")) {
	mkdir("../data/img exist", 0777, true);
}

