<?php

require_once '../../commons.php';


if(isset($_POST["connecter"])) {
	$connecter = $_POST["connecter"];
}

if(isset($connecter) && !empty($connecter)) {
	$file_name = DATA_CHAT_DIR_MAILBOX."/".$connecter;
	if(!file_exists($file_name)) {
		write_contents($file_name, "");
	}
	//
	$msg_arrs = read_contents($file_name);
	foreach ($msg_arrs as $key => $value_arr) {
		foreach ($value_arr  as $msg_key => $msg_value) {
// 			echo json_encode($value_arr);
// 			echo "From: ".$key."<BR/>\n".$msg_value->chat_content->content."<BR/>\n";
		}
	}
	echo json_encode($msg_arrs);
	
}


?>