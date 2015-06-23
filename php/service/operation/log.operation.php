<?php

	include_once '../commons.php';

	/**
	 * @function:  log 
	 * log
	 */
	function logaction($cmd) {
		if($cmd["type"] == MSG_TYPE::SEND_MSG) {
			_log_sendmsg($cmd);
		}
		if($cmd["type"] == MSG_TYPE::RE_SEND_MSG) {
			// no need to do anything
		}
// 		if($cmd["type"] == MSG_TYPE::ADD_FRIEND) {
// 			_log_sendmsg($cmd);
// 		}
	}
	
	function clearlog($cmd) {
		if($cmd["type"] == MSG_TYPE::DELETE_FRIEND) {
			_clearHistoryMessage($cmd);
		}
	}
	
	function _clearHistoryMessage($cmd) {
		global $mysqldi;
		$deletorId = $cmd["content"]["deletor"]["id"];
		$deleteId = $cmd["content"]["delete"]["id"];
		$compositId = getABuserID($deletorId, $deleteId);
		$deleteSql = "delete from message where `abuser` = '%s'";
		$mysqldi->send_sql(sprintf($deleteSql, $compositId));
	}
	
	function _log_sendmsg($cmd) {
		$logmsgsent = array(
			"id"	=> $cmd["content"]["sender"]["id"],
			"name" => $cmd["content"]["sender"]["name"],
			"msg" =>  $cmd["content"]["message"],
			"time" => $cmd["time"]
		);
		
		$receiverid = $cmd["content"]["receiver"]["id"];
		$senderid = $cmd["content"]["sender"]["id"];
		writeMessage($senderid, $receiverid, pc(json_encode($logmsgsent)));
	}
	
	function _log_addfriend($cmd) {
		
	}
	
	function writeMessage($senderid, $receiverid, $logmsgsent) {
		global $mysqldi;
		$compositId = getABuserID($senderid, $receiverid);
		$selectSql = "SELECT  * FROM `message` where `abuser` = '%s';";
		$updateSql = "UPDATE `message` SET `log` = '%s' where `abuser` = '%s';";
		$insertSql = "INSERT INTO `message` (`abuser`, `log`) VALUES ('%s', '%s')";
		$mysqldi->send_sql(sprintf($selectSql, $compositId));
		$row = $mysqldi->next_row();
		$newlog = "";
		if($row) {
			$newlog = $logmsgsent.PHP_EOL.pc($row["log"]);
		} else {
			$newlog = $logmsgsent;
		}
		if($row) {
			$mysqldi->send_sql(sprintf($updateSql, $newlog ,$compositId));
		} else {
			$mysqldi->send_sql(sprintf($insertSql, $compositId, $newlog));
		}
	}
	
	function getABuserID($senderid, $receiverid) {
		$compositId;
		if(strnatcmp("$senderid", "$receiverid") > 0) {
			$compositId = $senderid.$receiverid;
		} else {
			$compositId = $receiverid.$senderid;
		}
		return $compositId;
	}
?>