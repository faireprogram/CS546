<?php 

include '../security.php';

function v4() {
	return sprintf('%04x', mt_rand(0, 0xffff));
}

$newToken = v4().v4().v4().v4().v4();


logLogin($ID, $newToken, $LOGIN_IP, $LOGIN_DEVICE);

$result = array(
	"token" => $newToken, 
	"id" => $ID,
);

echo json_encode($result);
?>