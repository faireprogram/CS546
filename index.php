<?php

include 'php/security.php';


$template = new FastTemplate("public/html/template/chatroom");

$template->define(array(
		"main" => "main.html",
));


$template->assign("USER_NAME", getVariable($ID, "LOGIN_NAME"));
$template->assign("USER_ID", $ID);
$template->assign("USER_TOKEN", $TOKEN);
$template->parse("CONTENT", "main");
$template->FastPrint();


?>