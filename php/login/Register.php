<?php 

include '../commons.php';
include 'RegisterVerify.php';

$template = new FastTemplate("../../public/html/template/register");

$template->define(array(
		"main" => "main.html",
		"ol" => "ol.html",
		"li" => "li.html",
		"success" => "success.html"
));

$template->assign("USER_NAME", "");
$template->assign("EMAIL", "");
$template->assign("CELLPHONE", "");
$template->assign("ADDRESS", "");
$template->assign("AGE", "");
$template->assign("CHECKED1", "");
$template->assign("CHECKED2", "");
$template->assign("MESSAGE", "");
$template->assign("Q1", "");
$template->assign("Q2", "");
$template->assign("Q3", "");

$template->parse("CONTENT", "main");

if (isset ( $_POST ['formsubmitted'] )) {
	verifyandinsert();
}
$template->FastPrint();
?>