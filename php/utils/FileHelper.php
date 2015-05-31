<?php


/**
 * @function:  write_contents 
 * @param $file_name
 * @param $content_buf
 * 
 * write $content_buf to $file_name
 */
function write_contents($file_path, $content_buf, $mode="ab") {
	$return_code = FILE_OP_STATE::SUCCESS;
	
	$handle = fopen($file_path, $mode);
	if (flock($handle, LOCK_EX)) {  // acquire an exclusive lock
// 		ftruncate($handle, 0);      // truncate file
		fwrite($handle,  $content_buf);
		fflush($handle);            // flush output before releasing the lock
		flock($handle, LOCK_UN);    // release the lock
	}
	
	fclose($handle);
	
	return $return_code;
}

/**
 * @function:  read_contents 
 * @param $file_path
 * 
 * read
 */
function read_contents($file_path) {
	$msg_arrs = array();
	
	$return_code = FILE_OP_STATE::SUCCESS;
	$handle = fopen($file_path, "r");
	if (flock($handle, LOCK_EX)) {
		while(!feof($handle)) {
			$line = fgets($handle);
			if(empty($line)) {
				break;
			}
			$chat_message = unserialize($line);
			/*
			 * if person not exist, create a new one
			 */
			if(!isset($msg_arrs[$chat_message->sender])) {
				$msg_arrs[$chat_message->sender] = array();
			}
			array_push($msg_arrs[$chat_message->sender], $chat_message);
			
// 			$msg_arrs[$chat_message->sender][] = $chat_message->chat_content->content;
			//$chat_message->
		}
// 		ftruncate($handle, 0);
	} 
	
	pclose($handle);
	return $msg_arrs;
}

?>