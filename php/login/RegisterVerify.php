<?php

function verifyandinsert() {
	global $template;
	global $dbc;
	$error = array (); // Declare An Array to store any error message
	if (!isset($_POST ['uname']) || empty ( $_POST ['uname'] )) { // if no name has been supplied
		$error [] = 'Please Enter a user name '; // add to array "error"
	}elseif(strlen($_POST['uname']) > 40){ 
		$error [] = 'Your user name is too long';
	}else {
		$name = pc(strip_tags($_POST ['uname'])); // else assign it a variable
		$template->assign("USER_NAME", $_POST ['uname']);
	}
	
	if (!isset($_POST ['e-mail']) || empty( $_POST ['e-mail'] )) {
		$error [] = 'Please Enter your Email ';
	}
	elseif(strlen($_POST['e-mail']) > 40){
		$error [] = 'Your e-mail is too long';
	}else {
		$template->assign("EMAIL", $_POST ['e-mail']);
		if (preg_match ( "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST ['e-mail'] )) {
				// regular expression for email validation
				$Email = pc(strip_tags($_POST ['e-mail']));
		} else {
			$error [] = 'Your EMail Address is invalid  ';
		}
	}
	
	if (!isset($_POST ['pwd']) && empty ( $_POST ['pwd'] )) {
		$error [] = 'Please Enter Your Password ';
	}
	elseif(strlen($_POST['pwd']) > 30){
		$error [] = 'Your password is too long ';
	} else {
		$Password = pc($_POST ['pwd']);
	}
	if (!isset($_POST ['cpwd']) || empty ( $_POST ['cpwd'] )) {
		$error [] = 'Please Confirm Your Password';
	} elseif ($_POST ['cpwd'] != $_POST ['pwd']) {
		$error [] = "Two passwords are not equal";
	}
	if (!isset($_POST ['cell']) || empty ( $_POST ['cell'] )) {
		$error [] = 'Please enter your cellphone number';
	}
	elseif (strlen($_POST['cell']) > 20){
		$error [] = 'Your cellphone number is too longer, please check again';
	}else {
		$template->assign("CELLPHONE", $_POST ['cell']);
		$cell = pc($_POST ['cell']);
	}
	
	if (!isset($_POST ['address']) ||empty ( $_POST ['address'] )) {
		$error [] = 'Please enter your address';
	}
	elseif (strlen($_POST['address']) > 90){
		$error [] = 'Your address is too long';
	}
	else {
		$template->assign("ADDRESS", $_POST ['address']);
		$addr = pc(strip_tags($_POST ['address']));
	}
	if(!isset($_POST ['byear']) || empty ($_POST['byear'] )){
		$error [] = 'Please enter your birth year';
	}
	else{
		$template->assign("BYEAR", $_POST ['byear']);
		$byear = pc($_POST['byear']);
	}
	if(!isset($_POST ['gender']) || empty($_POST['gender'])){
		$error [] = 'Please choose your gender';
	}
	else{
		$gender = pc($_POST['gender']);
		if($gender == "m") {
			$template->assign("CHECKED1", "checked");
		}
		if($gender == "f") {
			$template->assign("CHECKED2", "checked");
		}
	}
	$profileImg = "avatar.jpg";
	if(isset($_FILES['profileIcon']) && is_array($_FILES['profileIcon'])) {
		$fileName = $_FILES["profileIcon"]["name"];
		$fileTmpLoc =  $_FILES["profileIcon"]["tmp_name"];
		$fileErrorMsg = $_FILES["profileIcon"]["error"];
		$segmentOfName = explode(".", $fileName);
		$fileExt = end($segmentOfName);
		$extensionArr = array("jpeg", "jpg", "png", "gif");
		if ($fileErrorMsg === 0) {
			if(in_array(strtolower($fileExt), $extensionArr)) {
				$profileImg = rand(100000000000,999999999999).".".$fileExt;
				$moveResult = move_uploaded_file($fileTmpLoc, "../data/img/$profileImg");
				if($moveResult === false) {
					$error [] = "Unknown Error happens when upload profile image!";
				}
			} else {
				$error [] = "Unknown Profile Image Extension! ".$fileExt;
			}
		} 
	}
	
	if (empty ( $error )) // send to Database if there's no error '

	{
		$query_verify_email = "SELECT * FROM user  WHERE user_email ='$Email'";
		$query_verify_cell = "SElECT * FROM user WHERE user_cellphone = '$cell'";
		$result_verify_email = mysqli_query ( $dbc, $query_verify_email );
		$result_verify_cellphone = mysqli_query( $dbc, $query_verify_cell);
		if (! $result_verify_email) { // if the Query Failed ,similar to if($result_verify_email==false)
			echo ' Database Error Occured ';
		}
		if (mysqli_num_rows ( $result_verify_email ) == 0) { // IF no previous user is using this email .
			if(mysqli_num_rows ($result_verify_cellphone) == 0){
				// Create a unique activation code:
					
				$query_insert_user = "INSERT INTO user ( `user_name`, `user_email`, `user_cellphone`, `user_pwd` , `user_address`, `user_byear`, `user_gender`, `image`)".
						"VALUES ( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');";
					
				$result_insert_user = mysqli_query ( $dbc, sprintf($query_insert_user, $name, $Email, $cell, password_hash($Password, PASSWORD_DEFAULT), $addr, $byear, $gender, pc($profileImg)) );
				if (! $result_insert_user) {
					$template->assign("MESSAGE", 'Query Failed ') ;
					$template->parse("CONTENT", "main");
				}
				if (mysqli_affected_rows ( $dbc ) == 1) { // If the Insert Query was successfull.
					$template->assign("SUCC_MESSAGE", "Thank you for registering! A confirmation email has been sent to " . $Email);
					$template->parse("CONTENT", "success");
				} else { // If it did not run OK.
					$template->assign("You could not be registered due to a system error. We apologize for any inconvenience.", 'Query Failed ') ;
					$template->parse("CONTENT", "main");
				}
			}
			else{
				$template->assign("MESSAGE", 'That cellphone has already been registered.');
				$template->parse("CONTENT", "main");
			}                                                
		} else { // The email address is not available.
			$template->assign("MESSAGE", 'That email address has already been registered.') ;
			$template->parse("CONTENT", "main");
		}
	} else { // If the "error" array contains error msg , display them
		
		foreach ( $error as $key => $values ) {
			$template->assign("LI", $values);
			$template->parse("OL", ".li");
		}
		$template->parse("MESSAGE", "ol");
		$template->parse("CONTENT", "main");
	}
// 	mysqli_close ( $dbc ); // Close the DB Connection
} // End of the main Submit conditional.
