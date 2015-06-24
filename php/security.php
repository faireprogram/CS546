<?php
include_once 'commons.php';

/*
 * Judge Resource has the right to do something;
*/
$ID;
$TOKEN;
$LOGIN_DEVICE;
$LOGIN_IP;
if(isset($_POST["id"]) && !empty($_POST["id"])) {
	$ID = pc($_POST["id"]);
}
if(isset($_GET["id"]) && !empty($_GET["id"])) {
	$ID = pc($_GET["id"]);
}

if(isset($_POST["token"]) && !empty($_POST["token"])) {
	$TOKEN = pc($_POST["token"]);
}
if(isset($_GET["token"]) && !empty($_GET["token"])) {
	$TOKEN = pc($_GET["token"]);
}

if(empty($ID) || empty($TOKEN)) {
	if(isset($_POST["m"]) || isset($_GET["m"])) {
		redirect("ajax");
	} else {
		redirect();
	}
}

if(!isValidLogin($ID, $TOKEN)) {
	if(isset($_POST["m"]) || isset($_GET["m"])) {
		redirect("ajax");
	} else {
		redirect();
	}
}

$LOGIN_DEVICE = pc($_SERVER['HTTP_USER_AGENT']);
$LOGIN_IP = pc($_SERVER['REMOTE_ADDR']);

function redirect($method) {
	global $ID;
	if(!empty($method) && $method == "ajax") {
		$logininfo = getLoginInfoById($ID);
		if(!$logininfo) {
			$id = "";
			$device = "";
			$ip = "";
			$time = "";
		} else {
			$id = $logininfo["user_id_cur"];
			$device = $logininfo["login_device"];
			$ip = $logininfo["login_ip"];
// 			$time = strtotime($logininfo["login_time"]);
			$time = $logininfo["login_time"];
		}
		
		$error = array(
			"type" => PEMISSION_ERROR::NOT_YOUR_RESOURCE,
			 "content" => array(
				"id" => $id,
			 	"device" => $device,
			 	"ip" => $ip,
			),
			"time" => $time
		);
		$string = json_encode($error);
		exit($string);
	} else {
		header("Location: /cs546/php/login/login.php");
	}
}
?>