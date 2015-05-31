<?php

/**
 * @function:  current_autoloader 
 */
function current_autoloader($class) {
	include $class.'.class.php';
}

/**
 * auto load php files!
 */
spl_autoload_register('current_autoloader');

?>