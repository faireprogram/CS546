<?php
include_once "../commons.php";

function search() {
	global $template;
	global $dbc;
	
	$error = array ();
	if (!isset($_POST ["kw"]) || empty ( $_POST ["kw"] )) {
		$error [] = "Please input a searching key word";
	} else {
		$kw = $_POST ["kw"];
		$template->assign("KEYWORD", $_POST ["kw"]);
	}
	if (!isset($_POST ["sc"]) || empty ( $_POST ["sc"] )) {
		$error [] = "Please select one searching condition";
	} else {
		$sc = $_POST ["sc"];
		if($_POST ["sc"] == "Search by User's Name") {
			$template->assign("SELECTED1", $_POST ["sc"]);
		}
		if($_POST ["sc"] == "Search by User's Email") {
			$template->assign("SELECTED2", $_POST ["sc"]);
		}
		if($_POST ["sc"] == "Search by User's Cellphone") {
			$template->assign("SELECTED3", $_POST ["sc"]);
		}
		if($_POST ["sc"] == "Search by User's Address") {
			$template->assign("SELECTED4", $_POST ["sc"]);
		}
	}
	if (empty ( $error )) {
		if ($_POST ["sc"] == "Search by User's Name") {
			$sql = "select * from user where user_name like '%$kw%'";
			$res = mysqli_query ( $dbc, $sql );
			if (! $res) {
				$template->assign("ERRORMESSAGE", "Query Failed");
			} else {
				if (isset ( $res )) {
					while ( $row = mysqli_fetch_assoc ( $res ) ) {
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
		elseif ($_POST["sc"] == "Search by User's Email"){
			$sql = "select * from user where user_email like '%$kw%'";
			$res = mysqli_query ( $dbc, $sql );
			if (! $res) {
				$template->assign("ERRORMESSAGE", "Query Failed");
			} else {
				if (isset ( $res )) {
					while ( $row = mysqli_fetch_assoc ( $res ) ) {
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
		elseif ($_POST["sc"] == "Search by User's Cellphone"){
			$sql = "select * from user where user_cellphone like '%$kw%'";
			$res = mysqli_query ( $dbc, $sql );
			if (! $res) {
				$template->assign("ERRORMESSAGE", "Query Failed");
			} else {
				if (isset ( $res )) {
					while ( $row = mysqli_fetch_assoc ( $res ) ) {
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
		else{
			$sql = "select * from user where user_address like '%$kw%'";
			$res = mysqli_query ( $dbc, $sql );
			if (! $res) {
				$template->assign("ERRORMESSAGE", "Query Failed");
			} else {
				if (isset ( $res )) {
					while ( $row = mysqli_fetch_assoc ( $res ) ) {
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
