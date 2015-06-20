<?php
	/*
	 * Bussiness Operation
	 */
	include_once 'friends.operation.php';
	include_once 'message.operation.php';
	include_once 'chathistory.operation.php';
	
	/*
	 * Log operation
	 */
	include_once 'log.operation.php';
	
	
	
	function excute($cmd) {
		
		$type = $cmd["type"];
		
		if($type == MSG_TYPE::EXECUTE) {
			$resultcmds = _execute($cmd);
			if(!$resultcmds) {
				return;
			}
			foreach ($resultcmds as $cmdval) {
				if($cmdval) {
					excute($cmdval);
				}
			}
		}
		
		if($type == MSG_TYPE::SEND_MSG) {
			msgcmd_execute($cmd);
		}
		
		if($type == MSG_TYPE::RE_SEND_MSG) {
			msgcmd_execute($cmd);
		}
		
		if($type == MSG_TYPE::ADD_FRIEND) {
			friendcmd_excutor($cmd);
		}
		
		if($type == MSG_TYPE::RE_ADD_FRIEND) {
			friendcmd_excutor($cmd);
		}
		
		if($type == MSG_TYPE::DELETE_FRIEND) {
			deletefriend_excutor($cmd);
		}
		
		if($type == MSG_TYPE::RE_DELETE_FRIEND) {
			redeletefriend_excutor($cmd);
		}
		if($type == MSG_TYPE::CHAT_HISTORY) {
			chathistorycmd_execute($cmd);
		}
	}
	
	
	function _validate_execmd($cmd) {
		if(!$cmd["content"]["self"] || !is_array($cmd["content"]["self"])) {
			return false;
		}
		if(!$cmd["content"]["self"]["id"]) {
			return false;
		}
		if(!$cmd["content"]["self"]["name"]) {
			return false;
		}
		return true;
	}
	
	function _execute($cmd) {
		global $mysqldi;
		if(!_validate_execmd($cmd)) {
			return;
		}
		$selectSql = "select * from `cmd` where user_id = '%d'";
		$updateSql = "UPDATE `cmd` SET `cmd` = '%s' WHERE `user_id` = '%d';";
		$sql = "";
		$id = $cmd["content"]["self"]["id"];
		$mysqldi->send_sql(sprintf($selectSql, $id));
		$row = $mysqldi->next_row();
		
		$cmdstrings = "";
		if($row) {
			$cmdstrings = $row["cmd"];
		}
		if($row) {
			$mysqldi->send_sql(sprintf($updateSql, "", $id));
		}
		if($cmdstrings) {
			$cmds = explode(PHP_EOL, $cmdstrings);
			foreach($cmds as $key => $cmdstring) {
				if(!empty($cmdstring)) {
					$cmds[$key] = json_decode($cmdstring, true);
				} else {
					unset($cmds[$key]);
				}
			}
			return $cmds;
		}
	}
	
	function sendmsg_excutor($cmd) {
		msgcmd_execute($cmd);
	}
	
	function resendmsg_excutor($cmd) {
		msgcmd_execute($cmd);
	}
	
	
	function deletefriend_excutor($cmd) {
	
	}
	
	function redeletefriend_excutor($cmd) {
	
	}
?>