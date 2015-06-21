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
		$start = $cmd["content"]["index"]["start"];
		$length = $cmd["content"]["index"]["length"];
		
		
		$compositeID = getABuserID($receiver, $sender);
		
		$mysqldi->send_sql(sprintf($selectSql, $compositeID));
		$row = $mysqldi->next_row();
		if(!empty($row["log"])) {
			_readfrom($start, $length, $row["log"]);
		}
		
	}
	
	function _readfrom($start, $length, $rawlog) {
		$logs = preg_split("/\r?\n/", $rawlog);
		$varstart = 0;
		foreach ($logs as $value) {
			if($varstart < $start) {
				$varstart++;
				continue;
			}
			if($varstart >= ($start + $length)) {
				break;
			}
			echo $value.PHP_EOL;
			
			$varstart++;
		}
	}
	
	
	function _validate_chatcmd($cmd) {
		if(!isset($cmd["content"]["sender"]) || !is_array($cmd["content"]["sender"])) {
			return false;
		}
		if(!isset($cmd["content"]["sender"]["id"])) {
			return false;
		}
		if(!isset($cmd["content"]["sender"]["name"])) {
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
		if(!isset($cmd["content"]["receiver"]["id"])) {
			return false;
		}
		if(!isset($cmd["content"]["receiver"]["name"])) {
			return false;
		}
		if(!isset($cmd["content"]["index"]) || !is_array($cmd["content"]["index"])) {
			return false;
		}
		if(!isset($cmd["content"]["index"]["start"]) ) {
			return false;
		}
		if(!isset($cmd["content"]["index"]["length"]) ) {
			return false;
		}
		return true;
	}
?>