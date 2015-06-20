<?php

/*
 * This is a Excutor to , it's used to Excute the command
*/

	/*
	 * RE_SEND_MSG
	* SEND_MSG
	*
	* ADD_FRIEND
	* RE_ADD_FRIEND
	*
	* DELETE_FRIEND
	* RE_DELETE_FRIEND
	*
	* CHECK_HISTORY
	*/
	

	/*
	 * EXECUTE : {
	* 		type: EXECUTE,
	*		content:
	*				self: {name, id}
	*		time: sendtime
	* 	}
	*/
	
	/*
	 * SEND_MSG : {
	* 		type: SEND_MSG,
	*		content:
	*				sender: {name, id}
	*				receiver {name, id},
	*				message
	*		time: sendtime
	* 	}
	*/
	
	
	/*
	 * RE_SEND_MSG : {
	* 		type: RE_SEND_MSG,
	*		content:
	*				sender, {name, id}
	*				receiver {name, id},
	*				message
	*		time: sendtime
	* 	}
	*/
	
	/*
	 * ADD_FRIEND : {
	* 		type: ADD_FRIEND,
	*		content:
	*				invitor, {name, id}
	*				receiver, {name, id}
	*				group: group
	*		time: sendtime
	* 	}
	*/
	
	/*
	 * RE_ADD_FRIEND : {
	* 		type: RE_ADD_FRIEND,
	*		content:
	*				invitor, {name, id}
	*				receiver, {name, id}
	*				group: unknownlist
	*		time: sendtime
	* 	}
	*/


	/*
	 * DELETE_FRIEND : {
	* 		type: DELETE_FRIEND,
	*		content:
	*				deletor, {name, id}
	*				delete, {name, id}
	*		time: sendtime
	* 	}
	*/

	/*
	 * RE_DELETE_FRIEND : {
	* 		type: RE_DELETE_FRIEND,
	*		content:
	*				deletor, {name, id}
	*				delete, {name, id}
	*		time: sendtime
	* 	}
	*/

	/*
	 * CHAT_HISTORY : {
	* 		type: CHAT_HISTORY,
	*		content:
	*				sender, {name, id}
	*				receiver, {name, id}
	*		time: sendtime
	* 	}
	*/
?>