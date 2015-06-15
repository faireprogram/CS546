<?php
include "./php/utils/connHelper.php";
$db = new database ();
$db->setup ( "ZDing", "19930920Ding", "localhost", "mydb" );
if (isset ( $_POST ['formsubmitted'] )) {
	$error = array (); // Declare An Array to store any error message
	if (empty ( $_POST ['uname'] )) { // if no name has been supplied
		$error [] = 'Please Enter a user name '; // add to array "error"
	} else {
		$name = $_POST ['uname']; // else assign it a variable
	}
	
	if (empty ( $_POST ['e-mail'] )) {
		$error [] = 'Please Enter your Email ';
	} else {
		
		if (preg_match ( "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST ['e-mail'] )) {
			// regular expression for email validation
			$Email = $_POST ['e-mail'];
		} else {
			$error [] = 'Your EMail Address is invalid  ';
		}
	}
	
	if (empty ( $_POST ['pwd'] )) {
		$error [] = 'Please Enter Your Password ';
	} else {
		$Password = $_POST ['pwd'];
	}
	if (empty ( $_POST ['cpwd'] )) {
		$error [] = 'Please Confirm Your Password';
	} elseif ($_POST ['cpwd'] != $_POST ['pwd']) {
		$error [] = "Two passwords are not equal";
	}
	if (empty ( $_POST ['cell'] )) {
		$error [] = 'Please enter your cellphone number';
	} else {
		$cell = $_POST ['cell'];
	}
	if (empty ( $_POST ['address'] )) {
		$error [] = 'Please enter your address';
	} else {
		$addr = $_POST ['address'];
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
			
			$query_insert_user = "INSERT INTO user ( 'user_name', 'user_email', 'user_cellphone', 'user_address') VALUES ( '$name', '$Email', $cell, '$addr')";
			$query_insert_ua = "INSERT INTO user_authentication ('user_id', 'user_pwd') VALUES('$name', '$Password')";
			$result_insert_user = mysqli_query ( $dbc, $query_insert_user );
			$result_insert_ua = mysqli_query($dbc, $query_insert_ua);
			if (! $result_insert_user || !$result_insert_ua) {
				echo 'Query Failed ';
			}
			if (mysqli_affected_rows ( $dbc ) == 1) { // If the Insert Query was successfull.
				echo "Thank you for registering! A confirmation email has been sent to " . $Email;
			} else { // If it did not run OK.
				echo "You could not be registered due to a system error. We apologize for any inconvenience.";
			}
		} else { // The email address is not available.
			echo "That email address has already been registered.";
		}
	} else { // If the "error" array contains error msg , display them
		
		echo '<ol>';
		foreach ( $error as $key => $values ) {
			
			echo '	<li>' . $values . '</li>';
		}
		echo '</ol>';
	}
	mysqli_close ( $dbc ); // Close the DB Connection
} // End of the main Submit conditional.
