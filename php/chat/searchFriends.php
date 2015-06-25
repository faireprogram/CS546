<?php

include '../security.php';

include 'searchHelper.php';

$template = new FastTemplate("../../public/html/template/friends");

$template->define(array(
		"main" => "main.html",
		"table" => "table.html",
		"tr" => "tr.html",
		"ol" => "ol.html",
		"li" => "li.html"
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
$template->assign("RESULT", "Nothing Show!");
for($i=0; $i<=100; $i++){
	$template->assign("SA", "<option value = \"$i\">$i</option>");
	$template->assign("EA", "<option value = \"$i\">$i</option>");
}
if(isset($_POST["submit"])) {
	search();
}

$template->parse("CONTENT", "main");
$template->FastPrint();

?>