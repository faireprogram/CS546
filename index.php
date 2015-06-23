<?php

include 'php/lib/class.FastTemplate.php';

session_start();

if (!isset($_SESSION["login_id"]) || empty($_SESSION["login_id"])) {
	header('Location: /cs546/php/login/Login.php');
}

$template = new FastTemplate("public/html/template/chatroom");

$template->define(array(
		"main" => "main.html",
));

$template->assign("USER_NAME", $_SESSION["login_name"]);
$template->assign("USER_ID", $_SESSION["login_id"]);
$template->parse("CONTENT", "main");
$template->FastPrint();


?>