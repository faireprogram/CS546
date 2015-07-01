<?php

include '../security.php';

include 'searchHelper.php';

$template = new FastTemplate("../../public/html/template/friends");

$template->define(array(
		"main" => "main.html",
		"table" => "table.html",
		"tr" => "tr.html",
		"ol" => "ol.html",
		"li" => "li.html",
		"option_sa" => "option_sa.html",
		"option_ea" => "option_ea.html"
));

$template->assign("USER_ID", $ID);
$template->assign("USER_TOKEN", $TOKEN);
$template->assign("ERRORMESSAGE", "");
$template->assign("KEYWORD", "");
$template->assign("SELECTED1", "");
$template->assign("SELECTED2", "");
$template->assign("SELECTED3", "");
$template->assign("SELECTED4", "");
$template->assign("SELECTED5", "");
$template->assign("SELECTED6", "");
$template->assign("GENDER_CHECKED1", "");
$template->assign("GENDER_CHECKED2", "");
$template->assign("GENDER_CHECKED3", "");
$template->assign("DISABLED", "");
$template->assign("ADD_STATUS", "Add");

$template->assign("SA_SELECTED", "");
$template->assign("EA_SELECTED", "");
$template->assign("TR", "");
$template->assign("RESULT", "Nothing Show!");
for($i=0; $i<=100; $i++){
	if(isset($_POST["sa"]) && $_POST["sa"] == $i) {
		$template->assign("SA_SELECTED", "selected");
	}
	$template->assign("num", $i);
	$template->parse("SA", ".option_sa");
	$template->assign("SA_SELECTED", "");
}
for($i=0; $i<=100; $i++){
	if(isset($_POST["ea"]) && $_POST["ea"] == $i) {
		$template->assign("EA_SELECTED", "selected");
	}
	$template->assign("num", $i);
	$template->parse("EA", ".option_ea");
	$template->assign("EA_SELECTED", "");
}

if(isset($_POST["gender"])) {
	if($_POST["gender"] == "m") {
		$template->assign("GENDER_CHECKED1", "checked");
	}
	if($_POST["gender"] == "f") {
		$template->assign("GENDER_CHECKED2", "checked");
	}
}

if(isset($_POST["submit"])) {
	search();
}

$template->parse("CONTENT", "main");
$template->FastPrint();

?>