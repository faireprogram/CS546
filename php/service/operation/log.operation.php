<?php

	include_once '../security.php';

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
		if($cmd["type"] == MSG_TYPE::ADD_FRIEND) {
			_log_addfriend($cmd);
		}
		if($cmd["type"] == MSG_TYPE::RE_ADD_FRIEND) {
			_log_readdfriend($cmd);
		}
		if($cmd["type"] == MSG_TYPE::DELETE_FRIEND) {
			_log_delfriend($cmd);
		}
		if($cmd["type"] == MSG_TYPE::RE_DELETE_FRIEND) {
			_log_redelfriend($cmd);
		}
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
		writeMessage($senderid, $receiverid, $cmd["time"], pc(json_encode($logmsgsent)));
	}
	
	function _log_addfriend($cmd) {
		$message = pc(json_encode($cmd));
		_log_operation($cmd["content"]["invitor"]["id"], $cmd["content"]["receiver"]["id"] , $message);
	}
	
	function _log_readdfriend($cmd) {
		$message = pc(json_encode($cmd));
		_log_operation($cmd["content"]["invitor"]["id"], $cmd["content"]["receiver"]["id"] , $message);
	}
	
	function _log_delfriend($cmd) {
		$message = pc(json_encode($cmd));
		_log_operation($cmd["content"]["deletor"]["id"], $cmd["content"]["delete"]["id"] , $message);
	}
	
	function _log_redelfriend($cmd) {
		$message = pc(json_encode($cmd));
		_log_operation($cmd["content"]["deletor"]["id"], $cmd["content"]["delete"]["id"] , $message);
	}
	
	function _log_operation($aid, $bid, $message) {
		_log_operationimp($aid, $message);
		_log_operationimp($bid, $message);
	}
	
	function _log_operationimp($id, $message) {
		global $mysqldi;
		$selectSql = "select * from `operation` where user_id = '%d';";
		$updatetSql = "update `operation` set `operations` = '%s' where user_id = '%d';";
		$insertSql = "INSERT INTO `operation` (`user_id`, `operations`) VALUES ('%d', '%s')";
		$mysqldi->send_sql(sprintf($selectSql, $id));
		$row = $mysqldi->next_row();
		$newOperation = $message;
		if($row) {
			$newOperation = $newOperation.PHP_EOL.pc($row["operations"]);
		} else {
			$newOperation = $newOperation.PHP_EOL;
		}
		
		if($row) {
			$mysqldi->send_sql(sprintf($updatetSql, $newOperation, $id));
		} else {
			$mysqldi->send_sql(sprintf($insertSql, $id, $newOperation));
		}
	}
	
	function writeMessage($senderid, $receiverid, $timestamp , $logmsgsent) {
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