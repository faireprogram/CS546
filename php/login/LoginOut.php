<?php 
include '../security.php';

session_start();
if(isset($_SESSION["login_id"])) {
	unset($_SESSION["login_id"]);
	unset($_SESSION["login_name"]);
	unset($_SESSION["login_email"]);
	header("Location: /cs546");
}

?>