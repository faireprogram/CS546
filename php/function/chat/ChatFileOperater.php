<?php

require_once '../../commons.php';

// if directory not exist, create a new one
if(!file_exists(DATA_CHAT_DIR_MAILBOX)) {
	mkdir(DATA_CHAT_DIR_MAILBOX, 755, TRUE);
}

if(isset($_POST["sender"])) {
	$sender = $_POST["sender"];
}

if(isset($_POST["receiver"])) {
	$receiver = $_POST["receiver"];
}

if(isset($_POST["msg"])) {
	$msg = $_POST["msg"];
}

if(isset($sender) && isset($receiver) && isset($msg)) {
	$chat_content = new ChatContent("TXT:", $msg);
	$chatmessage = new ChatMessage($sender, $chat_content, time());
	
	//$file_name = "wzhang32";
	$file_name = $receiver;
	write_contents(DATA_CHAT_DIR_MAILBOX."/".$file_name, serialize($chatmessage)."\r\n");
}


// echo "chat file!!!!!!"."</BR>";

// $a = array ('a' => 'apple', 'b' => 'banana', 'c' => array ('x', 'y', 'z'));
// print_r ($a);

//         $handle = popen("ping 127.0.0.1", "r");

//         $level = ob_get_level();
//         if (ob_get_level() == 0) 
//             ob_start();
//         $level = ob_get_level();
//         while(!feof($handle)) {

//             $buffer = fgets($handle);
//             debug($buffer);
            
//             sleep(1);
//         }

//         pclose($handle);
//         echo "zzzzzzzzzzzzzz"."</BR>";
//         ob_end_flush();
//         $level = ob_get_level();
       
?>