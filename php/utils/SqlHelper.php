<?php

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
 * @param retrieveChatGroups $codeString
 * @return mixed
 */
function retrieveChatGroups($codeString) {
	return json_decode($codeString, true);
}

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

/*
 * SINGLE 2 SINGLE login 
 */

function isValidLogin($id, $token) {
	if(!$id || !$token) {
		return false;
	}
	global $mysqldi;
	$id = pc($id);
	$token = pc($token);
	$selectSql = "select * from user_login where user_id_cur = '%d' and token = '%s';";
	
	$mysqldi->send_sql(sprintf($selectSql, $id, $token));
	$row = $mysqldi->next_row(); 
	if($row) {
		return true;
	} else {
		return false;
	}
}


function getLoginInfoById($id) {
	global $mysqldi;
	$id = pc($id);
	$selectSql = "select * from user_login where user_id_cur = '%d';";
	$mysqldi->send_sql(sprintf($selectSql, $id));
	$row = $mysqldi->next_row();
	return $row;
}

function logLogin($id, $token, $ip, $device) {
	global $mysqldi;
	$id = pc($id);
	$token = pc($token);
	$selectSql = "select * from user_login where user_id_cur = '%d';";
	$updateSql = "update `user_login` set token = '%s', login_device = '%s', login_ip = '%s' where user_id_cur = '%d';";
	$insertSql = "insert into `user_login` (`user_id_cur`, `token`, `login_device`, `login_ip`) values ('%d', '%s', '%s', '%s');";
	$mysqldi->send_sql(sprintf($selectSql, $id));
	$row = $mysqldi->next_row();
	if($row) {
		$mysqldi->send_sql(sprintf($updateSql, $token, $device, $ip, $id));
	} else {
		$mysqldi->send_sql(sprintf($insertSql, $id, $token, $device, $ip));
	}
}

function logLogout($id, $token) {
	global $mysqldi;
	$id = pc($id);
	$token = pc($token);
	$deleteSql = "delete from `user_login` where `user_id_cur` = '%d' and `token` = '%s';";
	$mysqldi->send_sql(sprintf($deleteSql, $id, $token));
}

function setVariable($id, $key, $value) {
	global $mysqldi;
	$id = pc($id);
	$selectSql = "select * from `user_login` where `user_id_cur` = '%d';";
	$updateSql = "update `user_login` set scope = '%s' where `user_id_cur` = '%d';";
	$mysqldi->send_sql(sprintf($selectSql, $id));
	$row = $mysqldi->next_row();
	if($row) {
		$scope = $row["scope"];
		$scopeString = "";
		if($scope) {
			$scopeObject = json_decode($scope, true);
			$scopeObject[$key] = $value;
			$scopeString = pc(json_encode($scopeObject));
		} else {
			$scopeObject = array();
			$scopeObject[$key] = $value;
			$scopeString = pc(json_encode($scopeObject));
		}
		$mysqldi->send_sql(sprintf($updateSql, $scopeString, $id));
	}
}

function getVariable($id, $key) {
	global $mysqldi;
	$id = pc($id);
	$selectSql = "select * from `user_login` where `user_id_cur` = '%d';";
	$mysqldi->send_sql(sprintf($selectSql, $id));
	$row = $mysqldi->next_row();
	if($row) {
		$scope = $row["scope"];
		if(!empty($scope)) {
			$scopeObject = json_decode($scope, true);
			return $scopeObject[$key];
		} else {
			return null;
		}
	}
}

?>