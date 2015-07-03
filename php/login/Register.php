<?php 
include '../commons.php';
include 'RegisterVerify.php';
$template = new FastTemplate("../../public/html/template/register");
$template->define(array(
		"main" => "main.html",
		"ol" => "ol.html",
		"li" => "li.html",
		"success" => "success.html",
		"option" => "option.html"
));
$template->assign("USER_NAME", "");
$template->assign("EMAIL", "");
$template->assign("CELLPHONE", "");
$template->assign("ADDRESS", "");
$template->assign("BYEAR_SELECTED", "");
$template->assign("CHECKED1", "");
$template->assign("CHECKED2", "");
$template->assign("MESSAGE", "");
$template->parse("CONTENT", "main");
if (isset ( $_POST ['formsubmitted'] )) {
	verifyandinsert();
}
for($i=date("Y"); $i>=date("Y")-100; $i--){
	if(isset($_POST["byear"]) && $_POST["byear"] == $i){
		$template->assign("BYEAR_SELECTED", "SELECTED");
	}
	$template->assign("byear", $i);
	$template->parse("BYEAR", ".option");
	$template->assign("BYEAR_SELECTED", "");
}
$template->parse("CONTENT", "main");
$template->FastPrint();
?>