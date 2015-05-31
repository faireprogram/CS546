<?php

require_once '../../commons.php';


if(isset($_POST["connecter"])) {
	$connecter = $_POST["connecter"];
}

if(isset($connecter) && !empty($connecter)) {
	$file_name = $connecter;
	$msg_arrs = read_contents(DATA_CHAT_DIR_MAILBOX."/".$file_name);
	foreach ($msg_arrs as $key => $value_arr) {
		foreach ($value_arr  as $msg_key => $msg_value) {
			echo "From: ".$key."<BR/>\n".$msg_value->chat_content->content."<BR/>\n";
		}
	}
}


?>