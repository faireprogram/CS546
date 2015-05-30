<?php

require_once './constances.php';

$before = microtime(true);
$current_folder = dirname(__FILE__)."/test";

if( !file_exists($current_folder) ) {
	// if not exit, then create a new file
	mkdir($current_folder,0700);
}

function create_file($name, $folder) {
	$handle = fopen($folder."/".$name, "w");
	fwrite($handle, $name);
	fclose($handle);
}

echo file_exists($current_folder."/name91309txt")."</BR>";

$now = microtime(true);


echo $now - $before."</BR>";

echo DATA_DIR;

// $count = 100000;

// while($count > 0) {
// 	create_file("name".$count."txt", $current_folder);
// 	$count--;	
// }



?>