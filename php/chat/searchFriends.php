<?php

include '../commons.php';

include 'searchHelper.php';

$template = new FastTemplate("../../public/html/template/friends");

$template->define(array(
		"main" => "main.html",
		"table" => "table.html",
		"tr" => "tr.html",
		"ol" => "ol.html",
		"li" => "li.html"
));

$template->assign("ERRORMESSAGE", "");
$template->assign("KEYWORD", "");
$template->assign("SELECTED1", "");
$template->assign("SELECTED2", "");
$template->assign("SELECTED3", "");
$template->assign("SELECTED4", "");
$template->assign("RESULT", "Nothing Show!");
if(isset($_POST["submit"])) {
	search();
}

$template->parse("CONTENT", "main");
$template->FastPrint();

?>