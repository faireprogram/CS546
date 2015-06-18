<?php
include "./php/utils/connHelper.php";
if(isset($_GET["uname"]) && isset($_GET["pwd"])){
	if($_GET["uname"] == ""){
		echo "Please enter your user name";
	}
	elseif($_GET["pwd"]){
		echo "Please enter your password";
	}
	else{
		$uname = $_GET["uname"];
		$pwd = $_GET["pwd"];
		$sql = "select * from user where user_id ='$uname' or user_name = '$uname' 
		or user_email = '$uname' and user_pwd = '$pwd'";
		if(!$res = mysqli_query($dbc,$sql)){
			echo "DB error"."</br>\n";
		}
		else{
			$nums = mysqli_num_rows($res);
			if($nums > 0){
				echo "You have successfully logged in!"."</br>\n";
			}
			else{
				echo "This user id is not registered!" . "</br>\n";
				echo "Click" . "<a href=\"./php/Register.php\">"."here"."</a>" ."to register";
			}
		}
	}
}