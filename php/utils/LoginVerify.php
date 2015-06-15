<?php
include "databaseClassMySQLi.php";
$db = new database();
$db->setup ( "ZDing", "19930920Ding", "localhost", "mydb" );
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
		$sql = "select user_id, user_pwd from user_authentication where user_id ='$uname'
		and user_pwd = '$pwd'";
		if(!$res = $db->send_sql($sql)){
			echo "DB error"."</br>\n";
		}
		else{
			$nums = mysqli_num_rows($res);
			if($nums > 0){
				echo "You have successfully logged in!"."</br>\n";
			}
			else{
				echo "This user id is not registered!" . "</br>\n";
				echo "Click" . "<a href=\"./html/register.html\">"."here"."</a>" ."to register";
			}
		}
	}
}