<?php

function verifyLogin() {
	global $template;
	global $dbc;
	global $ID;
	$TOKEN = v4().v4().v4().v4().v4();
	$LOGIN_DEVICE =  pc($_SERVER['HTTP_USER_AGENT']);
	$LOGIN_IP = pc($_SERVER['REMOTE_ADDR']);
	if(isset($_POST["uname"]) && isset($_POST["pwd"])){
		$correct = true;
		if(empty(trim($_POST["uname"]))){
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
			$template->assign("USER", trim($_POST["uname"]));
			$template->parse("ERROR_MESSAGE", "ol");
			$template->parse("CONTENT", "main");
		}
		
		$isFind = false;
		if($correct){
			$uname = pc(trim($_POST["uname"]));
			$pwd = pc($_POST["pwd"]);
			$nameVeriSql = "select * from user where  user_name = '$uname'";
			$emailVeriSql = "select * from user where user_email = '$uname'";
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
					if(password_verify($pwd, $row["user_pwd"])){
						$ID = $row["user_id"];
						logLogin($ID, $TOKEN, $LOGIN_IP, $LOGIN_DEVICE);
							
						setVariable($ID, "LOGIN_NAME", $row["user_name"]);
						setVariable($ID, "LOGIN_EMAIL", $row["user_email"]);
						setVariable($ID, "LOGIN_CELLPHONE", $row["user_cellphone"]);
						$param = "id=".$ID."&token=".$TOKEN;
							
						header("Location: /cs546?".$param);
					}
					else{
						$template->assign("ERROR_MESSAGE", "Password is not correct!");
					}
				}
				else {
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
					if(password_verify($pwd, $row["user_pwd"])){
							
						$ID = $row["user_id"];
						logLogin($ID, $TOKEN, $LOGIN_IP, $LOGIN_DEVICE);
							
						setVariable($ID, "LOGIN_NAME", $row["user_name"]);
						setVariable($ID, "LOGIN_EMAIL", $row["user_email"]);
						setVariable($ID, "LOGIN_CELLPHONE", $row["user_cellphone"]);
							
						$param = "id=".$ID."&token=".$TOKEN;
						header("Location: /cs546?".$param);
							
					}
					else{
						$template->assign("ERROR_MESSAGE", "Password is not correct!");
					}
				}
				else {
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