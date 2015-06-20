<?php

$file_path = "../../public/html/_searchFriends.html";
$handle = @fopen($file_path, "rb");
if($handle === FALSE) {
	exit ("Some fatal Errors Happens !");
}

echo stream_get_contents($handle);

?>