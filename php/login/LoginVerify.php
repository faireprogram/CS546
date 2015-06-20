<?php
include_once "../commons.php";

function verifyLogin() {
	global $template;
	global $dbc;
	if(isset($_POST["uname"]) && isset($_POST["pwd"])){
		$correct = true;
		if(empty($_POST["uname"])){
			$template->assign("LI", "Please enter your user name");
			$template->parse("OL", "li");
			$correct = false;
		}
		if(empty($_POST["pwd"])){
			$template->assign("LI",  "Please enter your password");
			$template->parse("OL", ".li");
			$correct = false;
		}
		if(!$correct) {
			$template->assign("USER", $_POST["uname"]);
			$template->parse("ERROR_MESSAGE", "ol");
			$template->parse("CONTENT", "main");
		}
		
		$isFind = false;
		if($correct){
			$uname = pc($_POST["uname"]);
			$pwd = pc($_POST["pwd"]);
			$nameVeriSql = "select * from user where  user_name = '$uname' and user_pwd = '$pwd'";
			$emailVeriSql = "select * from user where user_email = '$uname' and user_pwd = '$pwd'";
			/*
			 * NAME VERIFICATION
			*/
			if(!$res = mysqli_query($dbc,$nameVeriSql)){
				$template->assign("ERROR_MESSAGE", "DB error.");
				$template->parse("CONTENT", "main");
				return ;
			}
			else{
				$row = mysqli_fetch_assoc($res);
				if(!empty($row)){
					session_start();
					$_SESSION["login_id"] = $row["user_id"];
					$_SESSION["login_name"] = $row["user_name"];
					$_SESSION["login_email"] = $row["user_email"];
					header("Location: /cs546");
				} else {
					$isFind = false; 
				}
			}
			/*
			 * EMAIL VERIFICATION
			 */
			if(!$res = mysqli_query($dbc,$emailVeriSql)){
				$template->assign("ERROR_MESSAGE", "DB error.");
				$template->parse("CONTENT", "main");
				return ;
			}
			else{
				$row = mysqli_fetch_assoc($res);
				if(!empty($row)){
					session_start();
					$_SESSION["login_id"] = $row["user_id"];
					$_SESSION["login_name"] = $row["user_name"];
					$_SESSION["login_email"] = $row["user_email"];
					header("Location: /cs546");
				} else {
					$isFind = false;
				}
			}
			
			if(!$isFind) {
				$template->assign("ERROR_MESSAGE", "user name doesn't exist!");
				$template->parse("CONTENT", "main");
			}
		}
	}
}