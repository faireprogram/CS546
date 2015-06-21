<?php

	function isGoodCMD($cmd) {
		if(!$cmd) {
			return false;
		}
		
		if(!is_array($cmd)) {
			return false;
		}
		if(!isset($cmd["type"])) {
			return false;
		}
		if(!_in_messagetype($cmd["type"])) {
			return false;
		}
		if(!isset($cmd["content"]) || !is_array($cmd["content"])) {
			return false;
		}
		if(!isset($cmd["time"])) {
			return false;
		}
		return true;
	}
	
	function _in_messagetype($string) {
		if(!$string) {
			return false;
		}
		$is = false;
		if($string == MSG_TYPE::ADD_FRIEND)	{
			$is = true;
		}
		if($string == MSG_TYPE::DELETE_FRIEND)	{
			$is = true;
		}
		if($string == MSG_TYPE::RE_ADD_FRIEND)	{
			$is = true;
		}
		if($string == MSG_TYPE::RE_DELETE_FRIEND)	{
			$is = true;
		}
		if($string == MSG_TYPE::RE_SEND_MSG)	{
			$is = true;
		}
		if($string == MSG_TYPE::SEND_MSG)	{
			$is = true;
		}
		if($string == MSG_TYPE::CHAT_HISTORY)	{
			$is = true;
		}
		if($string == MSG_TYPE::EXECUTE)	{
			$is = true;
		}
		return $is;
	}
	
	function writemailbox($id, $message) {
		global $mysqldi;
		$selectSQL = "SELECT * FROM `cmd` where `user_id` = '%d';";
		$insertSQL = "INSERT INTO `cmd` (`user_id`, `cmd`) VALUES('%d', '%s');";
		$updateSQL = "UPDATE `cmd` SET `cmd` = '%s' where `user_id` = '%d';";
		$mysqldi->send_sql(sprintf($selectSQL, $id));
		$row = $mysqldi->next_row();
	
		$newcmd = "";
		if($row) {
			$currentcmd = $row["cmd"];
			$newcmd = $currentcmd.PHP_EOL.$message;
		} else {
			$newcmd = $message;
		}
	
		if($row) {
			$mysqldi->send_sql(sprintf($updateSQL, $newcmd ,$id));
		} else {
			$mysqldi->send_sql(sprintf($insertSQL, $id, $newcmd));
		}
	}

?>