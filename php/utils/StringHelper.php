<?php

function pc($s) {
	return addslashes(trim($s));
}

function v4() {
	return sprintf('%04x', mt_rand(0, 0xffff));
}

function isValidYear($a) {
	if(!$a || !preg_match("/\d{4}/i", $a)) {
		return false;
	}
	
	$a = intval($a);
	$minum = date("Y")-100;
	$maxnum = date("Y");
	
	if($a >= $minum &&  $a <= $maxnum) {
		return true;
	} else {
		return false;
	}
}
?>