<?php 

include_once '../commons.php';
		
include 'LoginVerify.php';

function v4() {
	return sprintf('%04x', mt_rand(0, 0xffff));
}

$template = new FastTemplate("../../public/html/template/login");

$template->define(array(
		"main" => "login.html",
		"ol" => "ol.html",
		"li" => "li.html"
));

$template->assign("ERROR_MESSAGE", "");
$template->assign("USER", "");
$template->parse("CONTENT", "main");

if(isset($_POST["hiddensubmit"])) {
	verifyLogin();
}

$template->FastPrint();

?>