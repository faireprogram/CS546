<?php

include_once '../commons.php';

	function msgcmd_execute($cmd) {
		if(!_validate_msgcmd($cmd)) {
			return;
		}
		if($cmd["type"] == MSG_TYPE::SEND_MSG) {
			_sendmsgcmd_execute($cmd);
		}
		if($cmd["type"] == MSG_TYPE::RE_SEND_MSG) {
			_resendmsgcmd_execute($cmd);
		}
		
	}
	
	/*
	 * A -> CMD -> Server, 
	 * Server -> Excute CMD,
	 * Caculate Step:
	 * 1: anaylize CMD, find receiver mailbox id, write the msg to maibox
	 */
	function _sendmsgcmd_execute($cmd) {
		$sender = $cmd["content"]["sender"];
		$receiver = $cmd["content"]["receiver"];
		$newcmd = $cmd;
		$newcmd["type"] = MSG_TYPE::RE_SEND_MSG;
		$cmdstring = json_encode($newcmd);
		writemailbox($receiver["id"], addslashes($cmdstring));
		
		/*log current send cmd*/
		logaction($cmd);
	}
	
   /**
	* A -> excute -> Server -> dispatch command  -> executor,
	* 
	* Caculate Step:
	* simply echo the command
	*/
	function _resendmsgcmd_execute($cmd) {
		echo json_encode($cmd).PHP_EOL;
	}
	
	function _validate_msgcmd($cmd) {
		if(!isset($cmd["content"]["sender"]) || !is_array($cmd["content"]["sender"])) {
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
		if(!isset($cmd["content"]["sender"]["id"])) {
			return false;
		}
		if(!isset($cmd["content"]["sender"]["name"])) {
			return false;
		}
		if(!isset($cmd["content"]["message"])) {
			return false;
		}
		return true;
	}
	

?>