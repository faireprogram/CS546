<?php

/**
 * @function:  current_autoloader 
 */
function class_autoloader($class) {
	include 'php/function/chat/class/'.$class.'.class.php';
}

/**
 * auto load php files!
 */
spl_autoload_register('class_autoloader');

?>