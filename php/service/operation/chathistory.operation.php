<?php

	include_once '../commons.php';
	include_once 'log.operation.php';
	
	function chathistorycmd_execute($cmd) {
		if(!_validate_chatcmd($cmd)) {
			return false;
		}
		global $mysqldi;
		$selectSql = "SELECT  * FROM `message` where `abuser` = '%s';";
		$receiver = $cmd["content"]["receiver"]["id"];
		$sender = $cmd["content"]["sender"]["id"];
		$compositeID = getABuserID($receiver, $sender);
	
		$mysqldi->send_sql(sprintf($selectSql, $compositeID));
		$row = $mysqldi->next_row();
		$newlog = "";
		if($row) {
			echo $row["log"];
		}
	}
	
	
	function _validate_chatcmd($cmd) {
		if(!$cmd["content"]["sender"] || !is_array($cmd["content"]["sender"])) {
			return false;
		}
		if(!$cmd["content"]["sender"]["id"]) {
			return false;
		}
		if(!$cmd["content"]["sender"]["name"]) {
			return false;
		}
		if(!$cmd["content"]["receiver"] || !is_array($cmd["content"]["receiver"])) {
			return false;
		}
		if(!$cmd["content"]["receiver"]["id"]) {
			return false;
		}
		if(!$cmd["content"]["receiver"]["name"]) {
			return false;
		}
		return true;
	}
?>