<?php

include '../security.php';

$template = new FastTemplate("../../public/html/template/operations");

$template->define(array(
		"main" => "main.html",
		"table" => "table.html",
		"tr" => "tr.html"
));

$template->assign("BODY", "no operations");

if(isset($_GET["id"]) && !empty($_GET["id"])) {
	$id = pc($_GET["id"]);
	$person = getPersonById($id);
	$template->assign("USER_NAME", $person["name"]);
	$selectSql = "select * from `operation` where user_id = '%d';";
	$mysqldi->send_sql(sprintf($selectSql, $id));
	$row = $mysqldi->next_row();
	if($row) {
		$jsonMessage = $row["operations"];
		$jsonarrs = preg_split("/\r?\n/i", $jsonMessage);
		foreach($jsonarrs as $value) {
			$jsonObject = json_decode($value, true);
			if(empty($jsonObject)) {
				continue;
			}
			if($jsonObject["type"] == MSG_TYPE::ADD_FRIEND) {
				_deal_addfriend($jsonObject, $id);
			}
			if($jsonObject["type"] == MSG_TYPE::RE_ADD_FRIEND) {
				_deal_reAddfriend($jsonObject, $id);
			}
			if($jsonObject["type"] == MSG_TYPE::DELETE_FRIEND) {
				_deal_delfriend($jsonObject, $id);
			}
			if($jsonObject["type"] == MSG_TYPE::RE_DELETE_FRIEND) {
				_deal_reDelfriend($jsonObject, $id);
			}
		}
		$template->parse("BODY", "table");
	} 
	$template->parse("BODY", "main");
	$template->FastPrint();

} else {
	exit("No valid Id here!");
}


function _deal_addfriend($cmd, $selfid) {
	global $template;
	if(intval($cmd["content"]["invitor"]["id"]) == intval($selfid)) {
		_format_time($cmd, $template);
		$template->assign("OPERATION", "you want to add ".$cmd["content"]["receiver"]["name"]." as friend!");
		$template->parse("TR", ".tr");
		
	} else {
		_format_time($cmd, $template);
		$template->assign("OPERATION", $cmd["content"]["invitor"]["name"]. " want to add you as friend!");
		$template->parse("TR", ".tr");
	}
}

function _deal_reAddfriend($cmd, $selfid) {
	global $template;
	if(intval($cmd["content"]["receiver"]["id"]) == intval($selfid)) {
		_format_time($cmd, $template);
		$template->assign("OPERATION", "you confirmed to add ".$cmd["content"]["invitor"]["name"]." as friend!");
		$template->parse("TR", ".tr");

	} else {
		_format_time($cmd, $template);
		$template->assign("OPERATION", $cmd["content"]["receiver"]["name"]." confirmed to add you as friend!");
		$template->parse("TR", ".tr");
	}
}


function _deal_delfriend($cmd, $selfid) {
	global $template;
	if(intval($cmd["content"]["deletor"]["id"]) == intval($selfid)) {
		_format_time($cmd, $template);
		$template->assign("OPERATION", "you want to delete ".$cmd["content"]["delete"]["name"]." from friend list!");
		$template->parse("TR", ".tr");

	} else {
		_format_time($cmd, $template);
		$template->assign("OPERATION", $cmd["content"]["deletor"]["name"]. " want to delete you from friend list!");
		$template->parse("TR", ".tr");
	}
}

function _deal_reDelfriend($cmd, $selfid) {
	global $template;
	if(intval($cmd["content"]["delete"]["id"]) == intval($selfid)) {
		_format_time($cmd, $template);
		$template->assign("OPERATION", "you confirmed to delete ".$cmd["content"]["deletor"]["name"]." from friend list!");
		$template->parse("TR", ".tr");

	} else {
		_format_time($cmd, $template);
		$template->assign("OPERATION", $cmd["content"]["delete"]["name"]. " confirmed to delete you from friend list!");
		$template->parse("TR", ".tr");
	}
}

function _format_time($cmd, $template) {
	date_default_timezone_set("America/New_York");
	$template->assign("TIME", date("Y-m-d H:i:s", intval(pc($cmd["time"]))));
	$template->assign("TYPE", $cmd["type"]);
}


?>