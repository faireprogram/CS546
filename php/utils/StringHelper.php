<?php

function pc($s) {
	return addslashes(trim($s));
}

function v4() {
	return sprintf('%04x', mt_rand(0, 0xffff));
}
?>