<?php
include '../../lib/databaseClassMySQLi.php';
include '../../config_sql.php';
// include 'php/constances.php';

function db() {
	global $mysqldi;
	global $SERVER_NAME;
	global $USER_NAME;
	global $PASSWORD;
	global $DATABASE;
	
	if(empty($mysqldi)) {
		$mysqldi = new database();
		$mysqldi->setup($USER_NAME, $PASSWORD, $SERVER_NAME, $DATABASE);
	}
}

?>