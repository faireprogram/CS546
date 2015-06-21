<?php
	include_once 'operation/Executor.php';
	
// 	if(isset($_POST["cmd"]) && $_POST["cmd"] != null) {
// 		$cmd = $_POST["cmd"];
// 		if(isGoodCMD($cmd)) {
// 			excute($cmd);
// 		}
// 	}
	
	
// 	$cmd1 = array(
// 		"type" => "SEND_MSG",
// 		"content" => array(
// 			"sender" => array(
// 				"id" => "0000000001",
// 				"name" => "sdd"
// 			),
// 			"receiver" => array(
// 				"id" => "0000000004",
// 				"name" => "asss"
// 			),
// 			"message" => "This is a TEST!!!``````MVLJLWJ@#$%@&%&%@& 87384738*~>>"
// // 				"message" => "This is a TEST!!"
// 		),
// 		"time" => "TIME"	
// 	);
	
// 	$cmd2 = array(
// 			"type" => "EXECUTE",
// 			"content" => array(
// 					"self" => array(
// 							"id" => "0000000004",
// 							"name" => "sdd"
// 					),
// 			),
// 			"time" => "TIME"
// 	);
	
	$cmd3 = array(
			"type" => "CHAT_HISTORY",
			"content" => array(
					"sender" => array(
							"id" => "0000000015",
							"name" => "sdd"
					),
					"receiver" => array(
							"id" => "0000000006",
							"name" => "asss"
					),
					"index" => array(
						"start" => 0,
						"length" => 10
					)
			),
			"time" => "TIME"
	);
	excute($cmd3);
?>