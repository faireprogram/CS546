<?php 

include '../security.php';

$newToken = v4().v4().v4().v4().v4();


logLogin($ID, $newToken, $LOGIN_IP, $LOGIN_DEVICE);

$result = array(
	"token" => $newToken, 
	"id" => $ID,
);

echo json_encode($result);
?>