<?php

require_once '../../commons.php';



echo "chat file!!!!!!"."</BR>";

$a = array ('a' => 'apple', 'b' => 'banana', 'c' => array ('x', 'y', 'z'));
print_r ($a);

        $handle = popen("ping 127.0.0.1", "r");

        $level = ob_get_level();
        if (ob_get_level() == 0) 
            ob_start();
        $level = ob_get_level();
        while(!feof($handle)) {

            $buffer = fgets($handle);
            debug($buffer);
            
            sleep(1);
        }

        pclose($handle);
        echo "zzzzzzzzzzzzzz"."</BR>";
        ob_end_flush();
        $level = ob_get_level();
       
?>