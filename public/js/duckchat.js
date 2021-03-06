/**
 * DuckChat Initialization
 */

(function(global, $) {
	
	var DuckChat = DuckChat || function() {},
		version = "1.0.0",
		MAXREAD = 8;
	
	
	var initiliaze = function() {
//		this.data = data;  // all data put here!!
		$(".loader").show();
		this.defaultgroup = null; //default group!!
		this.unknowngroup = null; //unknown friends!!
		this.wins = [];
		this.activewin = null;
		
		//HISTORY MAX READ
		duckchat.updateToken();

//		this.shortpolling();
		
		$('body').click(function(e) {
			if(!$(e.target).is(".selectmenu_wrapper") && $(".selectmenu_wrapper").css("display") != "none") {
				$(".selectmenu_wrapper").hide();
			}
		});
//		this.groups = $(".group");
//		bindgroups_event(this.groups);
	}
	
	function _createdelete() {
		return $('<i class="fa fa-trash" title="delete"></i>');
	}
	
	function _createmodify() {
		return $('<i class="fa fa-server" title="modify"></i>');
	}
	
	function _createmove() {
		return $('<i class="fa fa-reply" title="move"></i>');
	}
	
	function _createminus() {
		return $('<i class="fa fa-minus-square"></i>');
	}
	
	function _createwinminus() {
		return $('<i class="fa fa-minus" title="minilize window"></i>');
	}
	
	function _createwinclose() {
		return $('<i class="fa fa-times" title="close window"></i>');
	}
	
	function _createchecked() {
		return $('<i class="fa fa-check-square-o" title="confirm"></i>');
	}
	
	function _closeSelectMenu() {
		$(".selectmenu_wrapper").css("display", "none");
	}
	
	function _getCompositeId(targetId, selfId) {
		var targetId = targetId.toString();
		var selfId = selfId.toString();
		return targetId.localeCompare(selfId) >= 0 ? targetId+selfId : selfId+targetId
	}
	function _allgroups() {
		return $(".group:not(.create)");
	}
	
	function _close_messagebar() {
		$(".messsagebar").removeClass("warn info");
		$(".messsagebar").hide("slow");
	}
	
	function _setwarning_message(txt) {
		var mesagebar = $(".messsagebar");
		$(".messsagebar").addClass("warn");
		$("p", mesagebar).text(txt);
		mesagebar.css("display", "block");
		setTimeout(function(){ _close_messagebar(); }, 3000);
	}
	
	function _setinfo_message(txt) {
		var mesagebar = $(".messsagebar");
		$(".messsagebar").addClass("info");
		$("p", mesagebar).text(txt);
		mesagebar.css("display", "block");
		setTimeout(function(){ _close_messagebar(); }, 3000);
	}
	
	function _disableAllInput() {
		$("input", $(".friendlist")).each(function() {
			$(this).attr("disabled","true");
			var modify = $(".fa-server", $(this).parent());
			var check = $(".fa-check-square-o", $(this).parent());
			var parent = $(this).parent();
			var origin = ""
			if(parent.is("p")) {
				origin = parent.next().data("group");
			}
			if(parent.is("li")) {
				origin = parent.data("name");
			}
			$(this).val(origin);
			modify.css("display", "block");
			check.css("display", "none");
		});
	}
	
	function _disableCreateMode() {
		var group = $(".group.create");
		var title = $("p", group);
		var cancel = $(".fa-times", group);
		var check = $(".fa-check-square-o", group);
		var add =  $(".fa-plus", group);
		var input = $("input", title);
		var span = $("span", title);
		var text = $("<span></span>").text("NewGroup");
		input.remove();
		span.remove();
		title.append(text, cancel, check, add);
		check.css("display", "none");
		cancel.css("display", "none");
		add.css("display", "block");
	}
	
	function _validate_group(origin, txt) {
		var result = {success: true, msg: ""};
		var pattern = /^\w+$/g;
		if(!pattern.test(txt.trim()) || txt.trim().length >12) {
			result.success = false;
			result.msg = "input should be number or letter && length should less than 12 and can't be empty!!"
			return result;
		}
		if(origin == "") {
			for(var index in this.data) {
				if(index.trim() == txt.trim()) {
					result.success = false;
					result.msg = "group name should be unique!!";
					return result;
				}
			}
		}
		if(origin.trim() != txt.trim()) {
			for(var index in this.data) {
				if(index.trim() == txt.trim()) {
					result.success = false;
					result.msg = "group name should be unique!!";
					return result;
				}
			}
		}
		return result;
	}
	
	function _validate_user(txt) {
		var result = {success: true, msg: ""};
		var pattern = /^\w+$/g;
		if(!txt) {
			result.success = false;
			result.msg = "Name shouldn't be Empty!";
			return result;
		}
		if(!pattern.test(txt.trim()) || txt.trim().length > 20) {
			result.success = false;
			result.msg = "Name should be number or letter && length should less than 20 and can't be empty!!"
			return result;
		}
		return result;
	}
	
	function _bindvaluetoli(li, id, name, imgprofile, group) {
		li.data("id", id);
		li.data("name", name);
		li.data("personImag", imgprofile);
		li.data("group", group);
		return li;
	}
	
	function _bindvaluetoul(ul, group, article_dom) {
		ul.data("group", group);
		ul.data("dom_article", article_dom);
		return ul;
	}
	
	function _moveusertogroup_data(li, grpname, data) {
		var id = li.data("id");
		var ligp = li.data("group");
		var newObj;
		for(var gpindex in data) {
			var gp = data[gpindex];
			var find = false;
			for(var userindex in gp) {
				if(gp[userindex].id == id) { //find li in the object
					newObj = $.extend({}, gp[userindex]);
					delete gp[userindex];
					find = true;
					break;
				}
			}
			if(find) {
				break;
			}
		}
		for(var gpindex in data) {
			var gp = data[gpindex];
			if(gpindex.trim() == grpname) {
				gp[newObj.id] = newObj;
				break;
			}
		}
	}
	
	function _changegroupname(origin, changed, ul) {
		var newObject = $.extend({}, this.data[origin]);
		delete this.data[origin];
		this.data[changed] = newObject;
		var li = $("li", ul);
		ul.data("group", changed);
		li.each(function() {
			$(this).data("group",changed);
		});
	}
	
	function _getNameById(targetId) {
		for(var group in this.data) {
			for(var person in this.data[group]) {
				if(targetId == person) {
					return this.data[group][person].name;
				}
			}
		}
	}
	
	function _changeusername(li, newName) {
		var id = li.data("id");
		for(var group in this.data) {
			var find = false;
			for(var userid in this.data[group]) {
				if(userid == id) {
					find = true;
					break;
				}
			}
			if(find) {
				this.data[group][id].name = newName;
				li.data("name", newName);
				break;
			}
		}
	}
	
	function _moveusertogroup(userli, group_name) {
		var uls = $("ul", $(".friendlist"));
		uls.each(function() {
			var article = $(this).data("dom_article");
			var gp_name = $(this).data("group");
				if(group_name.trim() == gp_name.trim()) {
					var ul = $("ul", article);
					userli.data("group", group_name);
					ul.append(userli);
				}
		});
	}
	
	function _clearData(data) {
		for(var index in data) {
			if($.nums(data[index]) == 1) {
				delete data[index];
			}
		}
	}
	
	function _deletegroup(group) {
		var li = $("li", group);
		var group_name = $("span", this.defaultgroup).text();
		var d = this.data;
		li.each(function(){
			_moveusertogroup_data($(this), group_name, d);
			_moveusertogroup($(this), group_name);
		});
		group.remove();
		
		/*
		 * clear data
		 */
		_clearData(this.data);
	}
	function _bindminusclick(ielement, ulelement, toggle) {
		if(toggle) {
			ielement.unbind("click");
			ielement.click(function() {
				return function() {
					ielement.removeClass("fa fa-plus-square");
					ielement.addClass("fa fa-minus-square");
					ulelement.show();
					toggle = false;
					_bindminusclick(ielement, ulelement, toggle);
				}(ulelement, toggle);
			});
		} else {
			ielement.unbind("click");
			ielement.click(function() {
				return function() {
					ielement.removeClass("fa fa-minus-square");
					ielement.addClass("fa fa-plus-square");
					ulelement.hide();
					toggle = true;
					_bindminusclick(ielement,ulelement, toggle);
				}(ulelement, toggle);
			});
		}
	}
	
	function slash (string) {
    	var tagsToReplace = {
    		    '&': '&amp;',
    		    '<': '&lt;',
    		    '>': '&gt;'
		};
    	
    	function replaceTag(tag) {
    	    return tagsToReplace[tag] || tag;
    	}

		var safe_tags_replace = function (str) {
		    return str.replace(/[&<>]/g, replaceTag);
		};
		var str = safe_tags_replace(string);
		return str.replace(/\r?\n/g, '<BR/>');
    }
	
	
	function _retrievegps(current_li) {
		var current_group = current_li.data("group");
		var gps = [];
		for(var index in this.data) {
			if(index == "attributes") continue;
			if(current_group.trim() != index.trim()) {
				gps.push(index);
			}
		}
		return gps;
	}
	
	
	function hiddenAllwindow() {
		if(this.activewin) {
			this.activewin.hide();
		}
	}
	
	function activeWindow(win) {
		if(this.activewin) {
			this.activewin.data("isopen", false);
			this.activewin.hide();
		}
		win.show();
		this.activewin = win;
		this.activewin.data("isopen", true);
	}
	
	function _createPopupforGroups(owner_li, gps) {
		var selectMenu = $(".selectmenu_wrapper");
		var section = $("section", selectMenu);
		var ul = $("ul", selectMenu);
		ul.html("");
		for(var index in gps) {
			var li = $("<li>" + gps[index] + "</li>");
			li.bind("click", {groupname:gps[index], owner:owner_li}, function(event) {
				var groupname = event.data.groupname;
				invoke(this, _moveusertogroup_data, owner_li, groupname, this.data);
				invoke(this, _moveusertogroup, owner_li, groupname);
				_closeSelectMenu();
			}.bind(this));
			ul.append(li);
		}
		section.append(ul);
		return selectMenu;
	}
	
	function _findwinbyid(id) {
		for(var index in this.wins) {
			var winid = this.wins[index].data("id");
			if(winid == id) {
				return this.wins[index];
			}
		}
	}
	
	function _findBottomWinbyid(id) {
		for(var index in this.wins) {
			var bottomid = this.wins[index].data("bottomwin")["id"];
			if(bottomid == id) {
				return this.wins[index].data("bottomwin")["entity"];
			}
		}
	}
	
	function _removewinbyid(id) {
		for(var index in this.wins) {
			var winid = this.wins[index].data("id");
			if(winid == id) {
				delete this.wins[index];
				this.wins.splice(index, 1);
			}
		}
	}
	
	function _destroywin(win) {
		if(!win.length) {
			return;
		}
		if(win) {
			win.hide();
		}
		if(this.activewin && this.activewin.data("id") == win.data("id")) {
			this.activewin = null;
		}
		var bottomwin = win.data("bottomwin")["entity"];
		win.remove();
		bottomwin.remove();
		invoke(this, _removewinbyid, win.data("id"));
	}
	
	function _togglewin(win, isopen) {
		win.data("bottomwin").entity.removeClass('newmessage');
		if(isopen) {
			this.nicelyMinimizeWindow();
		} else {
			this.nicelyShowWindow(win);
			invoke(this, scrollMessageWindow, win.children(".chat_container"));
		}
	}
	
	function _createNewWindow(li) {
		return invoke(this, _createNewWindowByAttributes, li.data("id"), li.data("name"));
	}
	
	function _createNewWindowByAttributes(targetId, targetName) {
		var targetId = targetId;
		var compositeId =  _getCompositeId(this.data["attributes"]["id"], targetId);
		var findresult = invoke(this, _findwinbyid, compositeId);
		if(findresult) {
			return findresult;
		}
		
		var diag_panel = $("<section></section>").addClass("dialog_panel");
		var upbar =  $("<nav></nav>").addClass("upbar");
		var ul = $("<ul></ul>").addClass("item_container clearfix");
		var liminus = $("<li></li>").addClass("item");
		var liclose = $("<li></li>").addClass("item right");
		var ptext = $("<li></li>").addClass("item middle").text(targetName);
		var iminus = _createwinminus();
		var iclose = _createwinclose();
		liminus.append(iminus);
		liclose.append(iclose);
		ul.append(liminus, ptext, liclose);
		upbar.append(ul);
		
		var histbar = $("<div></div>").addClass("showhistory");
		var spanHis = $("<span>show history &#9652;</span>");
		histbar.append(spanHis);
		
		var chat =$("<section></section>").addClass("chat_container").attr("id", compositeId);
		var inputbox = $("<section></section>").addClass("input_container");
		var textArea = $("<textarea></textarea>").addClass("textarea col-3").attr("placeholder", "Input HERE!!!!!!");
		var senddiv = $("<div></div>").addClass("sendbutton col-1");
		var sendButton = _createchecked();
		senddiv.append(sendButton);
		inputbox.append(textArea, senddiv);
		
		diag_panel.append(upbar, histbar,  chat, inputbox);
		
		chat.bind("scroll", {chat:chat, diag:diag_panel}, function(event){
			var chat = event.data.chat;
			var diag = event.data.diag;
			var offset = diag.data("historyoffset");
			var owner = diag.data("owner");
			var self = diag.data("self");
			var timestamp = diag.data("timestamp");
			if(chat.scrollTop() == 0) {
				this.showHistory(offset, MAXREAD, owner, self, diag, 1, timestamp);
			}
		}.bind(this));
		
		histbar.bind("click", {chat:chat, diag:diag_panel}, function(event){
			var chat = event.data.chat;
			var diag = event.data.diag;
			var offset = diag.data("historyoffset");
			var owner = diag.data("owner");
			var self = diag.data("self");
			var timestamp = diag.data("timestamp");
			if(chat.scrollTop() == 0) {
				this.showHistory(offset, MAXREAD, owner, self, diag, 1, timestamp);
			}
		}.bind(this));
		
		liminus.bind("click",{i:iminus, id:compositeId}, function(event) {
			var i = event.data.i;
			var id = event.data.id;
			this.nicelyMinimizeWindow($('#' + id).parent());
		}.bind(this));
		liclose.bind("click",{i:iclose, id:compositeId}, function(event) {
			var i = event.data.i;
			var id = event.data.id;
			this.nicelyCloseWindow($('#' + id).parent());
		}.bind(this));
		sendButton.bind("click",{i:sendButton, id:compositeId, win:diag_panel}, function(event) {
			var i = event.data.i;
			var id = event.data.id;
			var win = event.data.win;
			$(".loader").css("display", "block");
			this.push_data_silencely(i, win.data("self"), win.data("owner"));
		}.bind(this));
		
		// ---------------- create bottom win
		var bottomwinId = $.uid();
		var bottomwin = $("<article></article>").attr("id", bottomwinId);
		var url = "php/chat/getImage.php?id=" + targetId;
		var img = $("<img></img>").attr("src", url);
		bottomwin.append(img);
		
		
		// --------------- bind bottom event
		bottomwin.bind("click", {win:diag_panel}, function(event) {
			var win = event.data.win;
			var open = win.data("isopen");
			invoke(this, _togglewin, win, open);
			
		}.bind(this));
		
		$("#toolbar").append(bottomwin);
		$(".dialog_wrapper").append(diag_panel);
		diag_panel.css("dispaly", "none");
		// ---------------- bind value
		this.wins.push(diag_panel);
		diag_panel.data("timestamp", new Date().getTime()/1000);
		diag_panel.data("id", compositeId);
		diag_panel.data("historyoffset", 0);
		diag_panel.data("owner", {id: targetId, name: targetName});
		diag_panel.data("self", {id: this.data.attributes["id"], name: this.data.attributes["name"]});
		
		// ---------------- bottom win
		bottomwin.data("reference", {entity: diag_panel, id: compositeId});
		bottomwin.data("id", bottomwinId);
		bottomwin.data("owner", {id: targetId, name: targetName});
		diag_panel.data("bottomwin", {entity : bottomwin, id: bottomwinId});
		
		
		return diag_panel;
	}
	
	
	function _bindEventToGroupIcon(gp_modify_icon, gp_checked_icon, gp_delete_icon, grp_txt, grp_article, index) {
		gp_modify_icon.bind("click", {modify:gp_modify_icon, gptxt:grp_txt, check:gp_checked_icon } ,function(event) {
			var check = event.data.check;
			var modify = event.data.modify;
			_disableAllInput();
			_disableCreateMode();
			modify.css("display", "none");
			check.css("display", "block");
			event.data.gptxt.attr("disabled", false);
		});	
		
		gp_checked_icon.bind("click", {modify:gp_modify_icon, gptxt:grp_txt, check:gp_checked_icon } ,function(event) {
			var check = event.data.check;
			var modify = event.data.modify;
			var gptxt = event.data.gptxt;
			
			var ul = modify.parent().next();
			var origin = ul.data("group");
			var changed = gptxt.val().trim();
			
			//verification
			var var_result = invoke(this, _validate_group, origin, gptxt.val());
			if(!var_result.success) {
				_setwarning_message(var_result.msg);
				return false;
			}
			
			modify.css("display", "block");
			check.css("display", "none");
			gptxt.attr("disabled", true);
			
			invoke(this, _changegroupname,origin, changed, ul);
		}.bind(this));	
		
		gp_delete_icon.bind("click", {gp:grp_article, gp_name:index}, function(event) {
			var article = event.data.gp;
			var gp_name = event.data.gp_name;
			
			var successCall = function() {
				invoke(this, _deletegroup, article);
			}
			this.message("Are you sure delte GROUP [ " + gp_name + " ]", successCall);
		}.bind(this));
	}
	
	function _bindMinusFunction(minus_icon, ul) {
		/*
		 * bind minus_icon click way!!
		 */
		minus_icon.bind("click", {icon:minus_icon, ulv:ul } ,function(event) {
				event.data.icon.removeClass("fa fa-minus-square");
				event.data.icon.addClass("fa fa-plus-square");
				event.data.ulv.hide();
				_bindminusclick(event.data.icon, event.data.ulv, true);
		});	
	}
	
	function _rewritegroups(groups, mode) {
		$("#friend_list_id").html("");
		var defaultGroupArticle = null;
		var defaultUnknownArticle = null;
		for(var index in groups) {
			if( index == "attributes") {
				continue;
			}
			var group = groups[index];
			var group_edit = groups[index]["attributes"].editable;
			
			var grp_article = $('<article class="group"></article>');
			var grp = $("<p></p>")
			var minus_icon = _createminus();
			var ul = _bindvaluetoul($("<ul></ul>"), index, grp_article);
			var grp_txt =  $("<span><\span>").text(index);
			if(mode == "edit" && group_edit) {
				grp_txt = $("<input  type=\"text\" disabled=\"disabled\"  onblur=\"javascript:$(this).attr('disabled');\" />").val(index);
				var gp_modify_icon = _createmodify();
				gp_modify_icon.addClass("right");
				var gp_delete_icon = _createdelete();
				gp_delete_icon.addClass("right");
				var gp_checked_icon = _createchecked();
				gp_checked_icon.addClass("right");
				gp_checked_icon.css("display", "none");
				grp.append(gp_delete_icon, gp_modify_icon, gp_checked_icon);
			}
			if(!group_edit) {
				grp.addClass("disable");
			}
			
			grp.append(minus_icon, grp_txt);
			
			for(var userindx in group) {
				if(userindx == "attributes") {
					continue;
				}
				var li = _bindvaluetoli($('<li></li>'), group[userindx].id,  group[userindx].name,  group[userindx].personImag, index);
				var li_txt = $("<span><\span>").text(group[userindx].name);
				if(mode == "edit") { 
					li_txt = $("<input type=\"text\" disabled=\"disabled\"  onblur=\"javascript:$(this).attr('disabled', true);\" />").val(group[userindx].name);
					var li_modify_icon = _createmodify();
					li_modify_icon.addClass("right");
					var li_delete_icon = _createdelete();
					li_delete_icon.addClass("right");
					var li_move_icon = _createmove();
					li_move_icon.addClass("right");
					var li_checked_icon = _createchecked();
					li_checked_icon.addClass("right");
					li_checked_icon.css("display", "none");
					li.append(li_delete_icon, li_move_icon, li_modify_icon, li_checked_icon);
					
					li_modify_icon.bind("click", {modify:li_modify_icon, check:li_checked_icon, litext:li_txt } ,function(event) {
						var check = event.data.check;
						var modify = event.data.modify;
						_disableAllInput();
						_disableCreateMode();
						modify.css("display", "none");
						check.css("display", "block");
						event.data.litext.attr("disabled", false);
					});
					
					li_checked_icon.bind("click", {modify:li_modify_icon, txt:li_txt, check:li_checked_icon } ,function(event) {
						var check = event.data.check;
						var modify = event.data.modify;
						var txt = event.data.txt;
						var li = modify.parent();
						//verification
						var var_result = invoke(this, _validate_user, txt.val());
						if(!var_result.success) {
							_setwarning_message(var_result.msg);
							modify.css("display", "none");
							check.css("display", "block");
							txt.attr("disabled", false);
							txt.focus();
							return false;
						}
						
						modify.css("display", "block");
						check.css("display", "none");
						txt.attr("disabled", true);
						
						invoke(this, _changeusername, li, txt.val());
					}.bind(this));	
					
					var that = this;
					li_delete_icon.bind("click", {current_li:li, data:this.data }, function(event) {
						var li = event.data.current_li;
						var ds = event.data.data;
						var compositeId = _getCompositeId(this.data["attributes"]["id"], li.data("id"));
						that;
						var succFunc = function() {
							this.deleteUser(li.data("id"), li.data("name"));
							var win = $('#' + compositeId).parent();
							if(win.length) {
								this.nicelyCloseWindow(win);
							}
						}
						this.message("Are you sure to <b class=\"warning\">PERMNANENENTY</b> delete user '" + li.data("name") + "'!", succFunc);
					}.bind(this));
					
					li_move_icon.bind("click", {icon:li_move_icon, user_li:li } ,function(event) {
						event.stopPropagation();
						var icon = event.data.icon;
						var li = event.data.user_li;
						
						_disableAllInput();
						_disableCreateMode();
						
						/* -------------------------------------------*/
						var gps = invoke(this, _retrievegps, li);
						/* -------------------------------------------*/
						var selecmenu = invoke(this, _createPopupforGroups, li, gps);
						var offset = icon.offset();
						var offsetli = li.offset();
						// - selecmenu.width() - 1
						selecmenu.css("left", offset.left - selecmenu.width() - 3);
						selecmenu.css("top", offset.top);
						selecmenu.css("display", "block");
					}.bind(this));
				} else {
					li.bind("dblclick", {li:li}, function(event) {
						var li = event.data.li;
						var compositeId =  _getCompositeId(this.data["attributes"]["id"], li.data("id"));
						var findResult = invoke(this, _findwinbyid, compositeId);
						if(findResult && this.activewin && findResult.data("id") != this.activewin.data("id")) {
							this.nicelyMinimizeWindow();
							this.nicelyShowWindow(findResult);
						}
						if(findResult && !this.activewin) {
							this.nicelyMinimizeWindow();
							this.nicelyShowWindow(findResult);
						}
						if(!findResult) {
							this.nicelyMinimizeWindow();
							var win = this.makeNewWindow(li);
							this.nicelyShowWindow(win);
							this.showHistory(win.data("historyoffset"), MAXREAD, win.data("owner"), win.data("self"), win, win.data("timestamp"));
						}
						
					}.bind(this));
				}
				li.append(li_txt);
				ul.append(li);
				
			}
			
			var group_default = groups[index]["attributes"].defaultgroup;
			var group_unkown = groups[index]["attributes"].unknowngroup;
			if(group_default) {
				this.defaultgroup = grp_article;
			} 
			if(group_unkown) {
				this.unknowngroup = grp_article;
			}
			
			grp_article.append(grp, ul);
			if(!(group_default || group_unkown)) {
				$("#friend_list_id").append(grp_article);
			}
			/*
			 * bind minus_icon click way!!
			 */
			
			_bindMinusFunction(minus_icon, ul);
			
			if(mode == "edit" && group_edit) {
				invoke(this, _bindEventToGroupIcon, gp_modify_icon, gp_checked_icon, gp_delete_icon, grp_txt, grp_article, index);
			}
			if(mode && mode == "edit") {
				$("ul.view").hide();
				$("ul.edit").show();
			} else {
				$("ul.edit").hide();
				$("ul.view").show();
			}
		}
		/*
		 * create a new group!!
		 */
		if(mode == 'edit') {
			var create_group = $("<article class=\"group create\"> </article>");
			var create_group_title = $("<p></p>");
			var text = $("<span></span>").text("NewGroup");
			var iconAdd = $("<i class=\"fa fa-plus\"></i>");
			var iconCancel = $("<i class=\"fa fa-times\" style=\"display:none;\"></i>");
			var iconCheck = $("<i class=\"fa fa-check-square-o\" style=\"display:none;\"></i>");
			create_group_title.append(text, iconAdd, iconCheck, iconCancel);
			create_group.append(create_group_title);
			$("#friend_list_id").append(create_group);
			
			iconAdd.bind("click", {title:create_group_title, check:iconCheck, add:iconAdd, cancel:iconCancel} ,function(event) {
				var title = event.data.title;
				var cancel = event.data.cancel;
				var check = event.data.check;
				_disableAllInput();
				var add =  event.data.add;
				var span = $("span", create_group_title);
				var input =$("<input type=\"text\"></input>").attr("placeholder", title.text());
				
				span.remove();
				title.append(input, cancel, check, add);
				check.css("display", "block");
				cancel.css("display", "block");
				add.css("display", "none");
			}.bind(this));
			
			iconCancel.bind("click", {title:create_group_title, check:iconCheck, add:iconAdd, cancel:iconCancel} ,function(event) {
				var title = event.data.title;
				var cancel = event.data.cancel;
				var check = event.data.check;
				var add =  event.data.add;
				var input = $("input", create_group_title);
				var text = $("<span></span>").text("NewGroup");
				input.remove();
				title.append(text, cancel, check, add);
				check.css("display", "none");
				cancel.css("display", "none");
				add.css("display", "block");
			}.bind(this));
			
			iconCheck.bind("click", {title:create_group_title, check:iconCheck, add:iconAdd, cancel:iconCancel} ,function(event) {
				var title = event.data.title;
				var cancel = event.data.cancel;
				var check = event.data.check;
				var add =  event.data.add;
				var input = $("input", create_group_title);
				var new_gpname = input.val().trim();
				var text = $("<span></span>").text("NewGroup");
				var result = invoke(this, _validate_group, "", new_gpname);
				if(!result.success) {
					_setwarning_message(result.msg);
					return false;
				} 
				
				
				var article = invoke(this, _createGroup, new_gpname);
				article.insertBefore(this.unknowngroup);
				input.remove();
				title.append(text, cancel, check, add);
				check.css("display", "none");
				cancel.css("display", "none");
				add.css("display", "block");
			}.bind(this));
		}
		
		$("#friend_list_id").prepend(this.defaultgroup);
		$("#friend_list_id").append(this.unknowngroup);
//		$("#friend_list_id").html(tmp.html());
	}
	
	function _createGroup(grp_name) {
		var newArticle = $("<article class=\"group\"></article>");
		var grp = $("<p></p>");
		var minus_icon = _createminus();	
		var ul = _bindvaluetoul($("<ul></ul>"), grp_name, newArticle);
		grp_txt = $("<input  type=\"text\" disabled=\"disabled\"  onblur=\"javascript:$(this).attr('disabled');\" />").val(grp_name);
		var gp_modify_icon = _createmodify();
		gp_modify_icon.addClass("right");
		var gp_delete_icon = _createdelete();
		gp_delete_icon.addClass("right");
		var gp_checked_icon = _createchecked();
		gp_checked_icon.addClass("right");
		gp_checked_icon.css("display", "none");
		grp.append(gp_delete_icon, gp_modify_icon, gp_checked_icon, minus_icon, grp_txt);
		newArticle.append(grp, ul);
		
		/*bind function to it*/
		_bindMinusFunction(minus_icon, ul);
		invoke(this, _bindEventToGroupIcon, gp_modify_icon, gp_checked_icon, gp_delete_icon, grp_txt, newArticle, grp_name);
		
		this.data[grp_name] = {};
		this.data[grp_name].attributes = {"editable": true};
		ul.data("group", grp_name);
		return newArticle;
		
	}
	
	function _dealReSendMsg(cmd) {
		var receiverId = cmd["content"]["receiver"]["id"];
		var senderId = cmd["content"]["sender"]["id"];
		var msg = cmd["content"]["message"];
		var compositeId = _getCompositeId(receiverId, senderId);
		var win = invoke(this, _findwinbyid, compositeId);
		// if there's a window opeen for this session
		var owner = cmd["content"]["sender"];
		if(senderId == this.data.attributes["id"]) {
			owner = cmd["content"]["receiver"];
		}
		/*
		 * win has been open before
		 */
		var finalwin = null;
		if(win) {
			var chatcontainer = $("#" + compositeId);
			if(senderId == this.data.attributes["id"]) {
				invoke(this, addMessagetoLeft, cmd["content"]["sender"], cmd["time"], msg , chatcontainer);
			} else {
				invoke(this, addMessagetoRight, cmd["content"]["sender"], cmd["time"], msg , chatcontainer);
			}
			if(this.activewin && this.activewin.data("id") != compositeId) {
				// add toolbar notification
				win.data("bottomwin")["entity"].addClass("newmessage");
			} else {
				this.nicelyShowWindow(win);
			}
			finalwin = win;
		} else {
			var newwin = invoke(this, _createNewWindowByAttributes, owner["id"], owner["name"]);
			newwin.hide();
			var chatcontainer = $("#" + compositeId);
			if(senderId == this.data.attributes["id"]) {
				invoke(this, addMessagetoLeft, cmd["content"]["sender"], cmd["time"], msg , chatcontainer);
			} else {
				invoke(this, addMessagetoRight, cmd["content"]["sender"], cmd["time"], msg , chatcontainer);
			}
			if(this.activewin) {
				newwin.data("bottomwin")["entity"].addClass("newmessage");
			} else {
				this.nicelyShowWindow(newwin);
			}
			finalwin = newwin;
		}
		if(parseInt(finalwin.data("timestamp")) > parseInt(cmd["time"])) {
			finalwin.data("historyoffset", parseInt(finalwin.data("historyoffset")) + 1);
		}
		scrollMessageWindow($("#" + compositeId));
	}
	
	function _dealReAddFriend(cmd) {
		this.renewFriendList();
	}
	
	function _dealPermissionError(cmd) {
		var date = cmd["time"];
		var device = cmd["content"]["device"];
		var ip = cmd["content"]["ip"];
		clearInterval(this.interval);
		var succ = function() {
			window.location.href = "/cs546/php/login/login.php";
		}
		this.message("<p>Someone Forced you offline:</p> <p>[IP] " + ip + " </p><p>[device] " + device + " </p> <p>[time] " + date + "</p> <p>Please login Again</p>" , succ, succ);
	}
	
	function _dealReDelFriend(cmd) {
		var compositeId =  _getCompositeId(cmd["content"]["deletor"]["id"], cmd["content"]["delete"]["id"]);
		var win = $('#' + compositeId).parent();
		if(win.length) {
			this.nicelyCloseWindow(win);
		}
		this.renewFriendList();
	}
	
	function _dealMsg(cmd) {
		if(!cmd) {
			return;
		}
		if(cmd["type"] && cmd["type"] == "RE_SEND_MSG") {
			invoke(this, _dealReSendMsg, cmd);
		}
		if(cmd["type"] && cmd["type"] == "RE_ADD_FRIEND") {
			invoke(this, _dealReAddFriend, cmd);
		}
		if(cmd["type"] && cmd["type"] == "RE_DELETE_FRIEND") {
			invoke(this, _dealReDelFriend, cmd);
		}
		if(cmd["type"] && cmd["type"] == "NOT_YOUR_RESOURCE") {
			invoke(this, _dealPermissionError, cmd);
		}
	}
	
	var invoke = function(obj, func) {
		var par = [];
		for(var i=2; i<arguments.length; i++)
		  {
			par.push(arguments[i]);
		  }
		return func.apply(obj, par);
	}
	
	
	var addMessagetoLeft = function(sender, time, message , holder, isscroll) {
		var article = $('<article class="messagebox clearfix"></article>');
		//header
		var header = $('<header class="left"></header>');
		var url = "php/chat/getImage.php?id=" + sender.id;
		var profile_icon = $('<img class="profile_icon left " src=\"'+ url +'\"/>');
		var profile_name = $('<p class="profile_name">' + sender.name +'</p>');
		header.append(profile_icon, profile_name);
		//message
		var message = $('<p class="message left">' + slash(message) + '</p>');
		var time = $("<span></span>").addClass("time").text($.date(time));
		message.prepend(time);
		article.append(header, message);
		if(!isscroll) {
			holder.append(article);
		} else {
			holder.prepend(article);
		}
	}
	
	var addMessagetoRight = function(sender, time, message, holder, isscroll) {
		var article = $('<article class="messagebox clearfix"></article>');
		//header
		var header = $('<header class="right"></header>');
		var url = "php/chat/getImage.php?id=" + sender.id;
		var profile_icon = $('<img class="profile_icon right " src=\"'+ url +'\"/>');
		var profile_name = $('<p class="profile_name right"></p>').text(invoke(this, _getNameById, sender.id));
		header.append(profile_icon, profile_name);
		//message
		var message = $('<p class="message right">' + slash(message) + '</p>');
		var time = $("<span></span>").addClass("time").text($.date(time));
		message.prepend(time);
		article.append(header, message);
		if(!isscroll) {
			holder.append(article);
		} else {
			holder.prepend(article);
		}
	}
	
	var showCancelConfirm = function(element) {
		$(element).parent().css("display", "none");
		$(element).parent().next().css("display", "block");
		invoke(this, _rewritegroups, this.data, "edit");
	}
	
	var openFindFriends = function() {
		var top = window.innerHeight/2 - 200;
		var left = window.innerWidth/2 - 225;
		var str = "top=" + top + ", left=" + left + ", width=450, height=400";
		 window.open("php/chat/searchFriends.php?id=" + this.id + "&token=" + this.token, "FindFriend", str);
	}
	
	var openOperations = function() {
		var top = window.innerHeight/2 - 200;
		var left = window.innerWidth/2 - 225;
		var str = "top=" + top + ", left=" + left + ", width=450, height=400";
		window.open("php/chat/friendsViewer.php?id=" + this.id + "&token=" + this.token, "FriendOperations", str);
	}
	
	var scrollMessageWindow = function(handler, type) {
		if(!type) {
			handler.animate({ scrollTop: handler[0].scrollHeight}, 1000);
		} else {
			handler.animate({ scrollTop: 0}, 1000);
		}
	}
	
	var nicelyCloseWindow = function(target) {
		invoke(this, _destroywin, target);
	}
	
	var nicelyMinimizeWindow = function() {
		if(this.activewin) {
			this.activewin.hide();
			this.activewin.data("isopen", false);
			this.activewin = null;
		}
	}
	
	var nicelyShowWindow = function(target) {
		invoke(this, activeWindow, target);
	}
	
	var expandGroup = function(target) {
		
	}
	
	var message = function(msg, sucCallback, failCallback) {
		var messagebox = $(".popup_wrapper");
		if(sucCallback) {
			this.successCallback = sucCallback;
		}
		if(failCallback) {
			this.cancelCallback = failCallback;
		}
		$("p", messagebox).text("");
		$("p", messagebox).append($.parseHTML(msg));
		var top = $("body").height()/2 - messagebox.height()/2;
		console.log(messagebox.width()/2);
		var left = $("body").width()/2 - messagebox.width()/2;
		messagebox.css("left", left);
		messagebox.css("top", top);
		messagebox.css("display", "block");
	}
	
	var ok = function() {
		if(this.successCallback) {
			this.successCallback();
		}
		$(".popup_wrapper").css("display", "none");
		this.successCallback = null;
	}
	
	var cancel = function() {
		if(this.cancelCallback) {
			this.cancelCallback();
		}
		$(".popup_wrapper").css("display", "none");
		this.cancelCallback = null;
	}
	
	var cancelChanges = function(ul) {
		$(ul).parent().css("display", "none");
		$(ul).parent().prev().css("display", "block");
		this.renewFriendList();
//		invoke(this, _rewritegroups, this.data);
	}
	
	var confirmChanges = function(ul) {
		var dck = this;
		var sucCallback = function() {
			$(ul).css("display", "none");
			$(ul).prev().css("display", "block");
//			setTimeout(function(){dck.saveChanges();}, 0);
			dck.saveChanges();
			invoke(this, _rewritegroups, this.data);
		}.bind(this);
		var cancelCallback = function() {
//			$(ul).parent().css("display", "none");
//			$(ul).parent().prev().css("display", "block");
		}.bind(this);
		this.message("Are you sure to post all the changes?",sucCallback, cancelCallback);
	}
	/*
	 * Duck Chat Object!
	 */
	DuckChat.fn = DuckChat.prototype = {
			
			duckchat: version,

			constructor: DuckChat,
			
			pollingtime: 1000, // polling time 1 seconds
			
			showHistory: function(start, length, sender, receiver, win, iscroll, time) {
				/*
				 * Show History Message
				 */
				$(".loader").show();
				var date = new Date();
				var compositeId =  _getCompositeId(sender["id"], receiver["id"]);
				var url = "php/service/Service.php";
				var dc =this;
				var cmd = {
				 		type : "CHAT_HISTORY",
				 		content	: {
				 			sender	: {
				 				id : sender["id"],
				 				name : sender["name"]
				 			},
				 			receiver : {
				 				id : receiver["id"],
				 				name : receiver["name"]
				 			},
				 			index : {
									start : start,
									length : length
				 			}
				 		},
				 		time : time
					}
				$.ajax(
						{
							url: 	 url, 
							type:	 "POST",
							data:	 {"cmd" : cmd, id:this.id, token:this.token, m:"ajax"},
							success: function(result){
									if(!result) {
										$(".loader").hide();
										return;
									}
									setTimeout(function(){
											var arrays = result.split(/\r?\n/);
											var jsonObjs = []
											for(var index in arrays) {
												if(arrays[index]) {
													jsonObjs.push(JSON.parse(arrays[index]));
												}
											}
											win.data("historyoffset", start + jsonObjs.length); 
											if(jsonObjs.length > 0) {
												if(!iscroll) {
													jsonObjs.reverse();
													for(var index in jsonObjs) {
														var obj = jsonObjs[index];
														if(jsonObjs[index]["id"] == dc.data.attributes["id"]) {
															invoke(dc, addMessagetoLeft, jsonObjs[index], jsonObjs[index]["time"], jsonObjs[index]["msg"], $("#" + compositeId));
														}
														if(jsonObjs[index]["id"] != dc.data.attributes["id"]) {
															invoke(dc, addMessagetoRight, jsonObjs[index], jsonObjs[index]["time"], jsonObjs[index]["msg"], $("#" + compositeId));
														}
													}
													scrollMessageWindow($("#" + compositeId));
													
												} else {
													for(var index in jsonObjs) {
														var obj = jsonObjs[index];
														if(jsonObjs[index]["id"] == dc.data.attributes["id"]) {
															invoke(dc, addMessagetoLeft, jsonObjs[index], jsonObjs[index]["time"], jsonObjs[index]["msg"], $("#" + compositeId), 1);
														}
														if(jsonObjs[index]["id"] != dc.data.attributes["id"]) {
															invoke(dc, addMessagetoRight, jsonObjs[index], jsonObjs[index]["time"], jsonObjs[index]["msg"], $("#" + compositeId), 1);
														}
													}
//													scrollMessageWindow($("#" + compositeId), 1);
												}
												
										}
										$(".loader").hide();
									
									}, 1000);
							}
						});
			},
			
			push_data_silencely: function(itm, sender, receiver) {
				/*
				 * Show Left Message Bar
				 */
				
				var date = new Date();
				var url = "php/service/Service.php";
				var text = $(itm).parent().prev().val() ? $(itm).parent().prev().val().trim() : "";
				 $(itm).parent().prev().val("");
				var compositeId = _getCompositeId(sender["id"], receiver["id"]);
				var time = date.getTime();
				var cmd = {
				 		type : "SEND_MSG",
				 		content	: {
				 			sender	: {
				 				id : sender["id"],
				 				name : sender["name"]
				 			},
				 			receiver : {
				 				id : receiver["id"],
				 				name : receiver["name"]
				 			},
				 			message : text
				 // 				"message" : "This is a TEST!!"
				 		},
				 		time :time/1000	
					}
				$.ajax(
						{
							url: 	 url, 
							type:	 "POST",
							data:	 {"cmd" : cmd, id:this.id, token:this.token, m:"ajax"},
							success: function(result){
								
								if(result.trim() == "ok") {
									var setTimeoutid = setTimeout(function(){
										  addMessagetoLeft(sender, time/1000, text ,$("#" + compositeId));
										  scrollMessageWindow($("#" + compositeId));
										$(".loader").css("display", "none");
									}, 1500);
								} else if(result.trim() == "NOT_YOUR_FRIEND"){
									var setTimeoutid = setTimeout(function(){
										$(".loader").css("display", "none");
										_setwarning_message("You Are not allowed to Speak someone is not your friend");
									}, 1500);
								} else {
									var setTimeoutid = setTimeout(function(){
										$(".loader").css("display", "none");
										_setwarning_message("Failed To send Message!!");
									}, 20000);
								}
								
							}
						});
			},
			
			deleteUser: function(deleteId, deleteName) {
				$(".loader").css("display", "block");
				var date = new Date();
				var url = "php/service/Service.php";
				var time = date.getTime();
				var cmd = {
				 		type : "DELETE_FRIEND",
				 		content	: {
				 			deletor	: {
				 				id : this.data.attributes.id,
				 				name : this.data.attributes.name
				 			},
				 			"delete" : {
				 				id : deleteId,
				 				name : deleteName
				 			}
				 		},
				 		time :time/1000
					}
				var dc = this;
				$.ajax(
						{
							url: 	 url, 
							type:	 "POST",
							data:	 {"cmd" : cmd, id:this.id, token:this.token, m:"ajax"},
							success: function(result){
								
								if(result.trim() == "ok") {
									var setTimeoutid = setTimeout(function(){
										_setinfo_message("Success Delete User " + deleteName);
										$(".loader").css("display", "none");
										dc.renewFriendList();
									}, 2000);
								} else {
									var setTimeoutid = setTimeout(function(){
										$(".loader").css("display", "none");
										_setwarning_message("Failed To send Message!!");
									}, 20000);
								}
								
							}
						});
			}
			,
			
			shortpolling: function() {
				var date = new Date();
				var url = "php/service/Service.php";
				var cmd = { type : "EXECUTE",
								 content :{
									 self : {
							 			id : this.data["attributes"]["id"],
						 				name : this.data["attributes"]["name"]
							 		}
								 },
							 time : date.getTime()/1000
						 };
				var duck = this;
				$.ajax(
				{
					url: 	 url, 
					type:	 "POST",
					data:	{cmd : cmd, id:this.id, token:this.token, m:"ajax"},
					success: function(result){
								if(!result) {
									return;
								}
								var arrays = result.split(/\r?\n/);
								var jsonObjs = []
								for(var index in arrays) {
									if(arrays[index]) {
										jsonObjs.push(JSON.parse(arrays[index]));
									}
								}
								if(jsonObjs.length > 0) {
									for(var index in jsonObjs) {
										var obj = jsonObjs[index];
										invoke(duck, _dealMsg, obj);
									}
								}
							}
				});
			},
			
			retrievebackgroups: function() {
				request_url = "php/service/FriendsListsService.php";
				var dcc= this;
				$.ajax({
							url: 	 request_url, 
							type:	 "POST",
							data:	{action:"read", id:dcc.id, token:dcc.token, "m":"ajax"},
							success: function(result){
										var all_messages = $.parseJSON(result);
										console.log(all_messages);
										dcc.data = all_messages;
										
										invoke(dcc, _rewritegroups, dcc.data);
										dcc.shortpolling();
										$(".loader").hide();
									}
						});
			},
			
			saveChanges: function() {
				$(".loader").show();
				request_url = "php/service/FriendsListsService.php";
				var dcc= this;
				var friends =JSON.stringify(dcc.data);
				$.ajax({
							url: 	 request_url, 
							type:	 "POST",
							data:	{action:"save", id: this.data.attributes["id"], friends: friends, id:this.id, token:this.token, m:"ajax"},
							success: function(result){
								console.log(result);
								if(result == "ok") {
									var setTimeoutid = setTimeout(function(){
										_setinfo_message("Successefull save");
										$(".loader").css("display", "none");
										dcc.renewFriendList();
									}, 2000);
								} else {
									var setTimeoutid = setTimeout(function(){
										_setwarning_message("Some Error happens here!!");
										$(".loader").css("display", "none");
										dcc.renewFriendList();
									}, 2000);
								}
							}
						});
			},
			
			updateToken: function() {
				request_url = "php/login/UpdateToken.php";
				var dcc= this;
				$.ajax({
					url: 	 request_url, 
					type:	 "POST",
					data:	{id: dcc.id, token: dcc.token},
					success: function(result){
						if(!result) {
							return;
						}
						var arra = $.parseJSON(result);
						dcc.id = arra["id"];
						dcc.token = arra["token"];
						
					},
					complete: function() {
						dcc.retrievebackgroups();
						invoke(dcc, _rewritegroups, dcc.data);
						dcc.interval = setInterval(function() {
							dcc.shortpolling();
					 	}, 3000);
					}
				});
			},
			
			makeNewWindow: function(li) {
				
				return invoke(this, _createNewWindow, li);
				
			},
			
			// UI PART
			nicelyCloseWindow: nicelyCloseWindow,
			
			nicelyShowWindow: nicelyShowWindow,
			
			nicelyMinimizeWindow: nicelyMinimizeWindow,
			
			expandGroup: expandGroup,
			
			initiliaze: initiliaze,
			
			showCancelConfirm: showCancelConfirm,
			
			openFindFriends: openFindFriends,
			openOperations: openOperations,
			
			message: message,
			
			ok: ok,
			
			cancel: cancel,
			
			confirmChanges: confirmChanges,
			
			cancelChanges: cancelChanges,
			
			warn: _setwarning_message,
				
			info: _setinfo_message,
			
			renewFriendList: function () {
				this.retrievebackgroups();
				invoke(this, _rewritegroups, this.data);
			},
			
			expand: function(item) {
				var has = $(item).hasClass("fa-plus");
				if(has) {
					$(".friendslist_wrapper").show();
					$(item).removeClass("fa-plus");
					$(item).addClass("fa-minus");
				} else {
					$(".friendslist_wrapper").hide();
					$(item).removeClass("fa-minus");
					$(item).addClass("fa-plus");
				}
			}
	}
	
	global.DuckChat = DuckChat;
	
	/*
	 * JEQUERY PLUGIN
	 */
	$.extend({
	    keys:    function(obj){
	        var a = [];
	        $.each(obj, function(k){ a.push(k) });
	        return a;
	    },
	    nums: function(obj){
	       return this.keys(obj).length;
	    },
	    uid: function() {
	    	var S4 = function () {
	    		return (((1 + Math.random()) * 0x10000) | 0).toString(16).substring(1);
	    	}
    		return S4() + S4() + S4();
	    },
	    date: function (timestamp) {
			 var a = new Date(parseInt(timestamp * 1000));
			 var months = ['01','02','03','04','05','06','07','08','09','10','11','12'];
			 var year = a.getFullYear();
			 var month = months[a.getMonth()];
			 var date = a.getDate();
			 var hour = a.getHours() < 10 ? "0" + a.getHours() : a.getHours();
			 var min = a.getMinutes()< 10 ? "0" + a.getMinutes(): a.getMinutes();
			 var sec = a.getSeconds()< 10 ? "0" + a.getSeconds() : a.getSeconds();
			 var time = month + "/" + date + "/" + year + " " + hour + ':' + min + ':' + sec;
			 return time;
	    }
	})();
	
})(typeof window !== "undefined" ? window : this, jQuery);


