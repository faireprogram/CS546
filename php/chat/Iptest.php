<?php

include '../commons.php';


if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	$ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
	$ip = $_SERVER['REMOTE_ADDR'];
}

$ip = pc($ip);
$device = pc($_SERVER['HTTP_USER_AGENT']);
$token = "zzzzzzzzzzzzzzdzz";
$id = "0000000008";

// logLogin($id, $token, $ip, $device);
// logLogout($id, $token);

// echo getVariable($id, "USER_NAME");
?>