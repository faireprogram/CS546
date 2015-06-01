/**
 * DuckChat Initialization
 */

(function(global, $) {
	
	var DuckChat = DuckChat || function() {},
		version = "1.0.0";
	

	var addMessagetoLeft = function(json_message, holder) {
		var article = $('<article class="messagebox clearfix"></article>');
		//header
		var header = $('<header class="left"></header>');
		var profile_icon = $('<img class="profile_icon left " src="../resource/img/avatar.jpg"/>');
		var profile_name = $('<p class="profile_name">' + json_message.sender +'</p>');
		header.append(profile_icon, profile_name);
		//message
		var message = $('<p class="message left">' + json_message.chat_content.content + '</p>');
		article.append(header, message);
		holder.append(article);
	}
	
	var addMessagetoRight = function(json_message, holder) {
		var article = $('<article class="messagebox clearfix"></article>');
		//header
		var header = $('<header class="right"></header>');
		var profile_icon = $('<img class="profile_icon right " src="../resource/img/avatar.jpg"/>');
		var profile_name = $('<p class="profile_name right">' + json_message.sender +'</p>');
		header.append(profile_icon, profile_name);
		//message
		var message = $('<p class="message right">' + json_message.chat_content.content + '</p>');
		article.append(header, message);
		holder.append(article);
	}
	
	var scrollMessageWindow = function(handler) {
		handler.animate({ scrollTop: handler[0].scrollHeight}, 1000);
	}
	
	/*
	 * Duck Chat Object!
	 */
	DuckChat.fn = DuckChat.prototype = {
			
			duckchat: version,

			constructor: DuckChat,
			
			pollingtime: 1000, // polling time 1 seconds
			
			push_data_silencely: function(data, url) {
				$.ajax(
						{
							url: 	 url, 
							type:	 "POST",
							data:	 data,
							success: function(result){
										$("#connect_feedback").text("Successful Connected!!!");
									}
						});
			},
			
			pushDataToScreen: function() {
				var sender = $("#sender_id").val();
				var msg = $("#msg_id").val();
				json_message = {};
				json_message.sender = sender;
				json_message.chat_content = {};
				json_message.chat_content.content = msg;
			   addMessagetoLeft(json_message, $("#chat"));
			   scrollMessageWindow($("#chat").parent());
			},
			
			shortpolling: function() {
				var request_url= $('#connect_form_id').attr('action');
				$.ajax(
				{
					url: 	 request_url, 
					type:	 "POST",
					data:	$('#connect_form_id').serialize(),
					success: function(result){
								var all_messages = $.parseJSON(result);
								for (var sender in all_messages) {
									   var messages = all_messages[sender];
									   for (var key in messages) {
									       console.log(messages[key].chat_content.content);
									       addMessagetoRight(messages[key], $("#chat"));
									       scrollMessageWindow($("#chat").parent());
									   }
								}
							}
				});
			}
	
	
			
	}
	
	global.DuckChat = DuckChat;
	
})(typeof window !== "undefined" ? window : this, jQuery);


