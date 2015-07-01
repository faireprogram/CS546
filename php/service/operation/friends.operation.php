<?php

include_once '../security.php';


function friendcmd_excutor($cmd) {
	if(!_validate_friendcmd($cmd)) {
		return;
	}
	if($cmd["type"] == MSG_TYPE::ADD_FRIEND) {
		addfriendcmd_excute($cmd);
	}
	if($cmd["type"] == MSG_TYPE::RE_ADD_FRIEND) {
		readdfriendcmd_excute($cmd);
	}
	if($cmd["type"] == MSG_TYPE::DELETE_FRIEND) {
		delfriendcmd_excute($cmd);
	}
	if($cmd["type"] == MSG_TYPE::RE_DELETE_FRIEND) {
		redelfriendcmd_excute($cmd);
	}
}

/*
 * add friend implementation
 */

function addfriendcmd_excute($cmd) {
	$invitor = $cmd["content"]["invitor"]["id"];
	$receiver = $cmd["content"]["receiver"]["id"];
	$group =  $cmd["content"]["group"];
	addFriendToDB($invitor, $receiver, $group, ADD_STATE::INVITE);
	
	/*
	 * force to re-add command
	 */
	$newcmd = $cmd;
	$newcmd["type"] = MSG_TYPE::RE_ADD_FRIEND;
	$newcmd["content"]["group"] = UNKNOWN_GROUPNAME;
	writemailbox($receiver, pc(json_encode($newcmd)));
	
	/*
	 * log its operation!
	 */
	logaction($cmd);
	
	echo SUCCESS;
}

function readdfriendcmd_excute($cmd) {
	$invitor = $cmd["content"]["invitor"]["id"];
	$receiver = $cmd["content"]["receiver"]["id"];
	$group =  $cmd["content"]["group"];
	addFriendToDB($receiver, $invitor, $group, ADD_STATE::RECEIVE);
	
	/*
	 * log its operation!
	*/
	logaction($cmd);
	echo json_encode($cmd).PHP_EOL;
}

/*
 * delete friend implementation 
 */

function delfriendcmd_excute($cmd) {
	$deletor = $cmd["content"]["deletor"]["id"];
	$delete = $cmd["content"]["delete"]["id"];
	deleteFriendFromDb($deletor, $delete);
	
	/*
	 * force to re-del command
	*/
	$newcmd = $cmd;
	$newcmd["type"] = MSG_TYPE::RE_DELETE_FRIEND;
	writemailbox($delete, pc(json_encode($newcmd)));
	
	/*
	 * Clear History log
	 */
	clearlog($cmd);
	
	/*
	 * log its operation!
	*/
	logaction($cmd);
	
	echo SUCCESS;
}

function redelfriendcmd_excute($cmd) {
	$deletor = $cmd["content"]["deletor"]["id"];
	$delete = $cmd["content"]["delete"]["id"];
	deleteFriendFromDb($delete, $deletor);
	
	/*
	 * log its operation!
	*/
	logaction($cmd);
	echo json_encode($cmd).PHP_EOL;
	
}

/*
 * ------------------------ Friends Cmd Validation -----------------------------------------------------------------
*/


function _validate_friendcmd($cmd) {
	if($cmd["type"] == MSG_TYPE::ADD_FRIEND || $cmd["type"] == MSG_TYPE::RE_ADD_FRIEND) {
		if(!isset($cmd["content"]["invitor"]) || !is_array($cmd["content"]["invitor"])) {
			return false;
		}
		if(!isset($cmd["content"]["invitor"]["id"])) {
			return false;
		}
		if(!isset($cmd["content"]["invitor"]["name"])) {
			return false;
		}
		if(!isset($cmd["content"]["receiver"]) || !is_array($cmd["content"]["receiver"])) {
			return false;
		}
		if(!isset($cmd["content"]["receiver"]["id"])) {
			return false;
		}
		if(!isset($cmd["content"]["receiver"]["name"])) {
			return false;
		}
		if(!isset($cmd["content"]["group"])) {
			return false;
		}
		return true;
	} else if($cmd["type"] == MSG_TYPE::DELETE_FRIEND || $cmd["type"] == MSG_TYPE::RE_DELETE_FRIEND) {
		if(!isset($cmd["content"]["deletor"]) || !is_array($cmd["content"]["deletor"])) {
			return false;
		}
		if(!isset($cmd["content"]["deletor"]["id"])) {
			return false;
		}
		if(!isset($cmd["content"]["deletor"]["name"])) {
			return false;
		}
		if(!isset($cmd["content"]["delete"]) || !is_array($cmd["content"]["delete"])) {
			return false;
		}
		if(!isset($cmd["content"]["delete"]["id"])) {
			return false;
		}
		if(!isset($cmd["content"]["delete"]["name"])) {
			return false;
		}
		return true;
	}
	return true;
}


/*
 * ------------------------ Friends Operation -----------------------------------------------------------------
 */



/*
 * ----------------------   Change From Class Style to Object Style    ----------------------------------------
*/

function _EmptyObject($personInfo) {
	if(!$personInfo) {
		return;
	}
	$data = array(
		DEFAULT_GROUPNAME => array(
			"attributes" => array(
			"editable"=> false,
			"defaultgroup" => true
			)
		),
		UNKNOWN_GROUPNAME => array(
			"attributes" => array(
			"editable"=> false,
			"unknowngroup" => true
			)
		),
		"attributes" => array(
				"id" => $personInfo["user_id"],
				"name" => $personInfo["user_name"],
		)
	);
	return $data;
}

function retrieveJSON($personId) {
	$groups = getGroups(1);
	$data = array();
// 	foreach($groups as $grpindex in ) 
	
}

/*
 * ----------------------         DB    ----------------------------------------
 */

function getGroupsExposed($personId) {
	$groups = getGroups($personId);
	if($groups) {
		return $groups;
	} else {
		return _EmptyObject(getPersonInfo($personId));
	}
}


function removePersonFromGroup($selfId, $personId) {
	$groups = getGroups($selfId);
	foreach($groups as $group => $chatpersons) {
		if($group == "attributes") {
			continue;
		}
		$find = false;
		foreach ($chatpersons as $chatPersonId => $chatPerson) {
			if($personId === $chatPersonId) {
				$find = true;
				break;
			}
		}
		if($find) {
			unset($groups[$group][$personId]);
			break;
		}
	}
	return $groups;
}


function _invite_init_add(&$groups, $chatPerson, $self) {
	$groups[DEFAULT_GROUPNAME] = array(
			$chatPerson["id"] => $chatPerson,
			"attributes" => array(
				"defaultgroup" => true,
				"editable" => false
			)
	);
	$groups[UNKNOWN_GROUPNAME] = array(
			"attributes" => array(
				"unknowngroup" => true,
				"editable" => false
			)
	);
	$groups["attributes"] = array(
		"id" => $self["id"],
		"name" => $self["name"]
	);
	
}

function _receive_init_add(&$groups, $chatPerson, $self) {
	$groups[DEFAULT_GROUPNAME] = array(
			"attributes" => array(
				"defaultgroup" => true,
				"editable" => false
			)
	);
	$groups[UNKNOWN_GROUPNAME] = array(
			$chatPerson["id"] => $chatPerson,
			"attributes" => array(
				"unknowngroup" => true,
				"editable" => false
			)
	);
	$groups["attributes"] = array(
			"id" => $self["id"],
			"name" => $self["name"]
	);
}

function add_to_group($person,$grpname, &$groups) {
	$groups[$grpname][$person["id"]] = $person;
}

function add_to_unknown($person, &$groups) {
	$groups[UNKNOWN_GROUPNAME][$person["id"]] = $person;
}

function addFriendToDB($selfId, $personId, $grp, $mode = ADD_STATE::INVITE) {
	global $mysqldi;
	$personId = pc($personId);
	$selfId = pc($selfId);
	$chatPerson = getPersonById($personId);
	$self = getPersonById($selfId);
	$groups = getGroups($selfId);
	$updateSql = "UPDATE user SET `friends` = '%s' WHERE `user_id` = '%d' ;";
	if(!empty($chatPerson)) {
		$seri_val = "";
		if(!$groups) {
			$groups = array();
			if($mode == ADD_STATE::INVITE) {
				_invite_init_add($groups, $chatPerson, $self);
			}
			if($mode == ADD_STATE::RECEIVE) {
				_receive_init_add($groups, $chatPerson, $self);
			}
			$seri_val = json_encode($groups);
			
			
			$mysqldi->send_sql(sprintf($updateSql, $seri_val, $selfId));
			
			
		} else {
			$group = getGroupByNameArr($groups, $grp);
			if($group) {
				add_to_group($chatPerson,$grp, $groups);
			} else {
				add_to_unknown($chatPerson, $groups);
			}
			$seri_val = json_encode($groups);
			
			$mysqldi->send_sql(sprintf($updateSql, $seri_val, $selfId));
		}

	}
}


function deleteFriendFromDb($selfId, $personId) {
	$selfId = pc($selfId);
	$personId = pc($personId);
	$deletedGroup = removePersonFromGroup($selfId, $personId);
	saveChangesExposed($selfId, pc(json_encode($deletedGroup)));
}

function saveChangesExposed($id, $friends) {
	global $mysqldi;
	$sql = "UPDATE user SET `friends` = '%s'  WHERE `user_id` = '%d' ;";
	$mysqldi->send_sql(sprintf($sql, $friends, $id));
}


?>