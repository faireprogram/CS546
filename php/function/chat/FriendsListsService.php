<?php

include_once 'operation/Executor.php';
/*
 * Initialize Global DataBase;
*/
db();

if(isset($_POST["action"])) {
	if($_POST["action"] == "read") {
		
		if(isset($_POST["id"]) && !empty($_POST["id"])) {
			$result = getGroupsExposed(pc($_POST["id"]));
			echo json_encode($result);
		}

	}
	if($_POST["action"] == "save") {
		
		if(isset($_POST["id"]) && !empty($_POST["id"])) {
 			if(isset($_POST["friends"]) && !empty($_POST["friends"]) && !empty(json_decode($_POST["friends"]))) {
 				saveChangesExposed(pc($_POST["id"]), $_POST["friends"]);
 				echo "ok";
 			}
			
		}
	}
}




?>