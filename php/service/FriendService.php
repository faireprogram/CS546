<?php
	include_once 'operation/Executor.php';

/*
 * start DB
 */
db();

	$cmd1 = array(
		"type" => "ADD_FRIEND",
		"content" => array(
			"invitor" => array(
				"id" => "0000000008",
				"name" => "sdd"
			),
			"receiver" => array(
				"id" => "0000000012",
				"name" => "asss"
			),
			"group" => "DefaultGroup",
// 				"message" => "This is a TEST!!"
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
	
	excute($cmd2);

?>