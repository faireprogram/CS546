<?php
include_once "../commons.php";
function verifyandinsert() {
	global $template;
	global $dbc;
	$error = array (); // Declare An Array to store any error message
	if (!isset($_POST ['uname']) || empty ( $_POST ['uname'] )) { // if no name has been supplied
		$error [] = 'Please Enter a user name '; // add to array "error"
	} else {
		$name = pc($_POST ['uname']); // else assign it a variable
		$template->assign("USER_NAME", $_POST ['uname']);
	}
	
	if (!isset($_POST ['e-mail']) || empty( $_POST ['e-mail'] )) {
		$error [] = 'Please Enter your Email ';
	} else {
		$template->assign("EMAIL", $_POST ['e-mail']);
		if (preg_match ( "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST ['e-mail'] )) {
				// regular expression for email validation
				$Email = pc($_POST ['e-mail']);
		} else {
			$error [] = 'Your EMail Address is invalid  ';
		}
	}
	
	if (!isset($_POST ['pwd']) && empty ( $_POST ['pwd'] )) {
		$error [] = 'Please Enter Your Password ';
	} else {
		$Password = $_POST ['pwd'];
	}
	if (!isset($_POST ['cpwd']) || empty ( $_POST ['cpwd'] )) {
		$error [] = 'Please Confirm Your Password';
	} elseif ($_POST ['cpwd'] != $_POST ['pwd']) {
		$error [] = "Two passwords are not equal";
	}
	if (!isset($_POST ['cell']) || empty ( $_POST ['cell'] )) {
		$error [] = 'Please enter your cellphone number';
	} else {
		$template->assign("CELLPHONE", $_POST ['cell']);
		$cell = pc($_POST ['cell']);
	}
	if (!isset($_POST ['address']) ||empty ( $_POST ['address'] )) {
		$error [] = 'Please enter your address';
	} else {
		$template->assign("ADDRESS", $_POST ['address']);
		$addr = pc($_POST ['address']);
	}
	if (!isset($_POST ['rq1']) || empty ($_POST['rq1'])){
		$error [] = 'Please answer the first question';
	}
	else{
		$template->assign("Q1", $_POST ['rq1']);
		$rq1 = pc($_POST ['rq1']);
	}
	if (!isset($_POST ['rq2']) || empty ($_POST['rq2'])){
		$error [] = 'Please answer the second question';
	}
	else{
		$template->assign("Q2", $_POST ['rq2']);
		$rq2 = pc($_POST ['rq2']);
	}
	if (!isset($_POST ['rq3']) || empty ($_POST['rq3'])){
		$error [] = 'Please answer the third question';
	}
	else{
		$template->assign("Q3", $_POST ['rq3']);
		$rq3 = pc($_POST ['rq3']);
	}
	if(!isset($_POST ['age']) || empty ($_POST['age'] )){
		$error [] = 'Please enter your age';
	}
	else{
		$template->assign("AGE", $_POST ['age']);
		$age = pc($_POST['age']);
	}
	if(!isset($_POST ['gender']) || empty($_POST['gender'])){
		$error [] = 'Please choose your gender';
	}
	else{
		$gender = pc($_POST['gender']);
		if($gender == "male") {
			$template->assign("CHECKED1", "checked");
		}
		if($gender == "femaile") {
			$template->assign("CHECKED2", "checked");
		}
	} 
	if(!isset($_FILES['profileIcon']) && !is_array($_FILES['profileIcon'])) {
		$error [] = 'Please Select your profile image';
	} else {
		$fileName = $_FILES["profileIcon"]["name"];
		$fileTmpLoc =  $_FILES["profileIcon"]["tmp_name"];
		$fileErrorMsg = $_FILES["profileIcon"]["error"];
		$segmentOfName = explode(".", $fileName);
		$fileExt = end($segmentOfName);
		if ($fileErrorMsg == 1) {
			$error [] = "Unknown Error happens when upload profile image!";
		}
		$profileImg = rand(100000000000,999999999999).".".$fileExt;
		$moveResult = move_uploaded_file($fileTmpLoc, "../data/img/$profileImg");
		if($moveResult === false) {
			$error [] = "Unknown Error happens when upload profile image!";
		}
	}
	
	if (empty ( $error )) // send to Database if there's no error '

	{
		$query_verify_email = "SELECT * FROM user  WHERE user_email ='$Email'";
		$result_verify_email = mysqli_query ( $dbc, $query_verify_email );
		if (! $result_verify_email) { // if the Query Failed ,similar to if($result_verify_email==false)
			echo ' Database Error Occured ';
		}
		if (mysqli_num_rows ( $result_verify_email ) == 0) { // IF no previous user is using this email .
		                                                     
			// Create a unique activation code:
			$activation = md5 ( uniqid ( rand (), true ) );
			
			$query_insert_user = "INSERT INTO user ( `user_name`, `user_email`, `user_cellphone`, `user_pwd` , `user_address`, `user_age`, `user_gender`, `retrieve_q1`, `retrieve_q2`, `retrieve_q3`, `image`)".
			"VALUES ( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');";
			
			$result_insert_user = mysqli_query ( $dbc, sprintf($query_insert_user, $name, $Email, $cell, $Password, $addr,$age, $gender, $rq1, $rq2, $rq3, pc($profileImg)) );
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
