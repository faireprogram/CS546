<?php

include_once '../commons.php';

if(isset($_GET["id"]) && is_numeric($_GET["id"])) {
	$selectSql = "select image from user where user_id = '%s'";
	$id = pc($_GET["id"]);
	$mysqldi->send_sql(sprintf($selectSql, $id));
	$row = $mysqldi->next_row();
	if($row) {
		$imageName = $row["image"];
		$content = file_get_contents( "../data/img/$imageName");
		$boom = explode(".", $imageName);
		$ext = strtolower(end($boom));
		$contentType = 'image/jpeg';
		if($ext == "jpeg" || $ext == "jpg") {
			$contentType = 'image/jpeg';
		}
		if($ext == "gif") {
			$contentType = 'image/gif';
		}
		if($ext == "png") {
			$contentType = 'image/png';
		}
 		header('Content-Type: '.$contentType);
		echo $content;
	}
}
?>