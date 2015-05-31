/**
 * 
 */

var request_url="http://localhost/cs546/php/function/chat/PollingChat.php?XDEBUG_SESSION_START=ECLIPSE_DBGP&KEY=14330345948792";


(function(global, $) {
	
	var DuckChat = DuckChat || function() {},
		version = "1.0.0";
		
	
	DuckChat.fn = DuckChat.prototype = {
			
			duckchat: version,

			constructor: DuckChat,
			
			pollingtime: 1000, // polling time 1 seconds
			
			
			shortpolling: function() {
				$.ajax(
				{
					url: 	 request_url, 
					type:	 "POST",
					data:	 $($('form')[1]).serialize(),
					success: function(result){
								$("#content").html(result);
							}
				});
			}
	
	
			
	}
	
	global.DuckChat = DuckChat;
	
})(typeof window !== "undefined" ? window : this, jQuery);