<?php
	include_once 'operation/Executor.php';
	
// 	if(isset($_POST["cmd"]) && $_POST["cmd"] != null) {
// 		$cmd = $_POST["cmd"];
// 		if(isGoodCMD($cmd)) {
// 			excute($cmd);
// 		}
// 	}
	
	
	$cmd1 = array(
		"type" => "RE_DELETE_FRIEND",
		"content" => array(
			"deletor" => array(
				"id" => "0000000008",
				"name" => "sdd"
			),
			"delete" => array(
				"id" => "0000000012",
				"name" => "asss"
			)
		),
		"time" => "TIME"	
	);
	
	$cmd2 = array(
			"type" => "EXECUTE",
			"content" => array(
					"self" => array(
							"id" => "0000000012",
							"name" => "sdd"
					),
			),
			"time" => "TIME"
	);
	
	excute($cmd1);
?>