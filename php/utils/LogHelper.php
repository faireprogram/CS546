<?php


/**
 * @function:  debug 
 */
function debug( $data ) {
  if( DEBUG === TRUE) {
  	$data = trim(htmlspecialchars($data));
  	ob_start();
  	if ( is_array( $data ) )
  		$output = "<script>console.log( '[DEBUG]: " . implode( ',', $data) . "' );</script>";
  	else
  		$output = "<script>console.log( '[DEBUG]: " . $data . "' );</script>";
  	
  	echo $output;
  	echo str_pad('', 4096);
  	ob_flush();
  	flush();
  	ob_end_flush();
  }
}


?>