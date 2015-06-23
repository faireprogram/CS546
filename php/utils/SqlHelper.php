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


/**
 * @function:  getPersonById
 */
function getPersonById($personId) {
	global $mysqldi;
	$personId = pc($personId);
	$sql = "select * from user where user_id = '%d'";
	$mysqldi->send_sql(sprintf($sql, $personId));
	$result = $mysqldi->next_row();
	if(!empty($result)) {
		$person = array(
				"id" => $result["user_id"] ,
				"name" => $result["user_name"]
		);
		return $person;
	} else {
		return null;
	}
}



function getGroups($personId) {
	global $mysqldi;
	$personId = pc($personId);
	$sql = "select * from user where user_id = '%d';";
	$mysqldi->send_sql(sprintf($sql, $personId));
	$result = $mysqldi->next_row();
	if($result) {
		$groups = retrieveChatGroups($result["friends"]);
		return $groups;
	}
}

function getPersonFromGroup($selfId, $personId) {
	$groups = getGroups($selfId);
	foreach($groups as $group => $chatpersons) {
		if($group == "attributes") {
			continue;
		}
		foreach ($chatpersons as $chatPersonId => $chatPerson) {
			if($personId === $chatPersonId) {
				return $chatPerson;
			}
		}
	}
}

function getPersonInfo($personId) {
	global $mysqldi;
	$personId = pc($personId);
	$sql = "select * from user where user_id = '%d';";
	$mysqldi->send_sql(sprintf($sql, $personId));
	$result = $mysqldi->next_row();
	return $result;
}

function getGroupByNameArr($groups, $grpname) {
	return $groups[$grpname];
}


function getGroupByNameId($personId, $grpname) {
	global $mysqldi;
	$personId = pc($personId);
	$sql = "select * from user where user_id = '%d';";
	$mysqldi->send_sql(sprintf($sql, $personId));
	$result = $mysqldi->next_row();
	if($result) {
		$groups = retrieveChatGroups($result["friends"]);
		foreach($groups as $gpindex => $gpvalue) {
			if($gpindex == $grpname) {
				return $gpvalue;
			}
		}
	} else {
		return null;
	}
}

?>