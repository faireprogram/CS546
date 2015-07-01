<?php
function contains($personId, $selfId) {
	$person = getPersonFromGroup($selfId, $personId);
	if($person) {
		return true;
	} else {
		return false;
	}
}

function search() {
	global $ID;
	global $template;
	global $dbc;
	
	$error = array ();
	$isinput = false;
	if (isset($_POST ["sc"]) && !empty ( $_POST ["sc"]) && isset($_POST ["kw"]) && !empty ( $_POST ["kw"])) {
		$isinput = true;
		$sc = pc($_POST ["sc"]);
		if($_POST ["sc"] == "Search by User's Name") {
			$kw = pc($_POST ["kw"]);
			$template->assign("KEYWORD", $_POST ["kw"]);
			$template->assign("SELECTED1", "selected");
		}
		if($_POST ["sc"] == "Search by User's Email") {
			$kw = pc($_POST ["kw"]);
			$template->assign("KEYWORD", $_POST ["kw"]);
			$template->assign("SELECTED2", "selected");
		}
		if($_POST ["sc"] == "Search by User's Cellphone") {
			$kw = pc($_POST ["kw"]);
			$template->assign("KEYWORD", $_POST ["kw"]);
			$template->assign("SELECTED3", "selected");
		}
		if($_POST ["sc"] == "Search by User's Address") {
			$kw = pc($_POST ["kw"]);
			$template->assign("KEYWORD", $_POST ["kw"]);
			$template->assign("SELECTED4", "selected");
		}
// 		if($_POST ["sc"] == "Search by User's Gender"){
// 			$template->assign("SELECTED5", "selected");
// 		}
// 		if($_POST ["sc"] == "Search by User's Age Range"){
// 			else{
// 				$sa = $_POST["sa"];
// 				$ea = $_POST["ea"];
// 			}
// 			$template->assign("SELECTED6", $_POST ["sc"]);
// 		}
	}
	
	if(isset($_POST["gender"]) && !empty($_POST["gender"])){
		$isinput = true;
	}
	
	if(isset($_POST["sa"]) && isset($_POST["ea"]) ){
		if($_POST["sa"] != 0 || $_POST["ea"] != 0) {
			$isinput = true;
			if(!(preg_match("/^\d+$/i", $_POST["sa"]) && preg_match("/^\d+$/i", $_POST["ea"]))) {
				$error[] = "Age must be number!";
			} else {
				$sa = pc($_POST["sa"]);
				$ea = pc($_POST["ea"]);
			}
		}
	}
	
	if(!$isinput){
		$error[] = "Please choose one search condition!";
	}
	
	if (empty ( $error )) {
		
		$verify_sql = "select friends from user where user_id = '$ID'";
		$condition1 = "";
		if (isset($_POST["sc"]) && $_POST["sc"] == "Search by User's Name" && isset($_POST["kw"]) && !empty($_POST["kw"])) {
			$condition1 = "user_name like '%$kw%'";
		}
		if (isset($_POST["sc"]) && $_POST["sc"] == "Search by User's Email" && isset($_POST["kw"]) && !empty($_POST["kw"])){
			$condition1 = "user_email like '%$kw%'";
		}
		if (isset($_POST["sc"]) && $_POST["sc"] == "Search by User's Cellphone" && isset($_POST["kw"]) && !empty($_POST["kw"])){
			$condition1 = "user_cellphone like '%$kw%'";
		}
		if (isset($_POST["sc"]) && $_POST["sc"] == "Search by User's Address" && isset($_POST["kw"]) && !empty($_POST["kw"])){
			$condition1 = "user_address like '%$kw%'";
		}
		$condition2 = "";
		
		
		if(isset($_POST["gender"]) && $_POST["gender"] == "f"){
			$condition2 =  "user_gender = 'f'";
		}
		if(isset($_POST["gender"]) && $_POST["gender"] == "m"){
			$condition2 = "user_gender = 'm'";
		}

		$condition3 = "";
		if(isset($sa) && isset($ea) && !($sa == 0 && $ea == 0)){
			$condition3 = "user_age between '$sa' and '$ea'";
		}
		
		$condition = "";
		if(!empty($condition1)) {
			$condition = $condition1;
		}
		
		if(!empty($condition2) && !empty($condition)) {
			$condition = $condition." and ".$condition2;
		} 
		if(!empty($condition2) && empty($condition)) {
			$condition = $condition2;
		}
		
		if(!empty($condition3) && !empty($condition)) {
			$condition = $condition." and ".$condition3;
		} 
		if(!empty($condition3) && empty($condition)) {
			$condition = $condition3;
		}
		
		$sql = "select * from user";
		if(!empty($condition)) {
			$sql = $sql. " where ".$condition;
			$res = mysqli_query ( $dbc, $sql );
			if (! $res) {
				$template->assign("ERRORMESSAGE", "Query Failed");
			} else {
				if (isset ( $res )) {
					while ( $row = mysqli_fetch_assoc ( $res ) ) {
						if($row["user_id"] == $ID) continue;
						elseif (contains($row["user_id"], $ID)) {
							$template->assign("DISABLED", "disabled");
							$template->assign("ADD_STATUS", "Added");
						}
						$template->assign("ID", $row ["user_id"]);
						$template->assign("USERNAME", $row ["user_name"]);
						$template->assign("EMAIL", $row ["user_email"]);
						$template->assign("CELL", $row ["user_cellphone"]);
						$template->assign("ADDRESS", $row ["user_address"]);
						$template->parse("TR", ".tr");
					}
					$template->parse("RESULT", "table");
				}
			}
		}
	}
	else{
		foreach ( $error as $key => $values ) {
			$template->assign("LI", $values);
			$template->parse("OL", ".li");
		}
		$template->parse("ERRORMESSAGE", "ol");
	}
}

?>
