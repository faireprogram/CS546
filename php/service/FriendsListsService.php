<?php

include_once 'operation/Executor.php';



if(isset($_POST["action"])) {
	if($_POST["action"] == "read") {
		
		if(isset($ID) && !empty($ID)) {
			$result = getGroupsExposed(pc($ID));
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
	
	if($_POST["action"] == "operation") {
	
		if(isset($_POST["id"]) && !empty($_POST["id"])) {
							
		}
	}
}




?>