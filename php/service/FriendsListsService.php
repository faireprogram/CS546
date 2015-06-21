<?php

include_once 'operation/Executor.php';

session_start();

if (!isset($_SESSION["login_id"]) || empty($_SESSION["login_id"])) {
	header('Location: ../login/Login.php');
}

$id = $_SESSION["login_id"];

if(isset($_POST["action"])) {
	if($_POST["action"] == "read") {
		
		if(isset($id) && !empty($id)) {
			$result = getGroupsExposed(pc($id));
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