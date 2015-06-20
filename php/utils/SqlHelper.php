<?php
include_once '../lib/databaseClassMySQLi.php';

//------------------------------- Data Base ----------------------
$mysqldi;
$dbc;

function db() {
	global $mysqldi;
	global $dbc;
	
	if(empty($mysqldi)) {
		$mysqldi = new database();
		$mysqldi->setup(DATABASE_USER, DATABASE_PASSWORD, DATABASE_HOST, DATABASE_NAME);
		$dbc = $mysqldi->mysqli;
	}
}

/*
 * Start DB
 */
db();
?>