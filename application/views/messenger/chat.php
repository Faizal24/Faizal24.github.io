<script type="text/javascript">

var chat_id 	= '<?php echo $chat_id; ?>';
var prev 		= '';
var last_id, first_id;
var msgs		= [];
var load_more 	= false;
var first_time	= true;		

$(document).ready(function(){

	scroll_bottom = true;

	$('.cb-send').click(function(){
		var msg = $('.cb-input').val();
		scroll_bottom = true;
		$.ajax({
			url: 'ajax/general/send_user_chat/',
			type: 'post',
			data: 'uid='+<?php echo $uid; ?>+'&msg='+encodeURIComponent(msg)+'&eid='+<?php echo $eid ? $eid : "''"; ?>,
			success: function (res){
				scroll_bottom = true;
			}
		});
		
		$('.cb-input').val('').focus();
		
	});
	
	$('.cb-input').keypress(function(e){
		if (e.keyCode == 13){
			$('.cb-send').click();
		}
	})
	
	$(window).resize();
	
	refresh();
	
	$('.cbx').scroll(function(){
		if ($(this)[0].scrollTop == 0 && load_more){
			loadPreviousChat();
			load_more = false;
		}
		if ($(this)[0].scrollTop > 50){
			load_more = true;
		}
	})
	
	$('.cbx').on('mouseenter','.chatmsg',function(){
		var name = $(this).attr('name');
		$('span.'+name).show();
	});

	$('.cbx').on('mouseleave','.chatmsg',function(){
		var name = $(this).attr('name');
		$('span.'+name).hide();
	});

})



function loadPreviousChat(){
	$.ajax({
		url: 'ajax/general/get_chat_by_chat_id/',
		type: 'post',
		data: 'cid='+chat_id+'&last_id='+first_id,
		dataType: 'json',
		success: function (chat_data){
			processChat(chat_data, true);	
		}
	});
	
}


function refresh(){
	
	$.ajax({
		url: 'ajax/general/get_chat_by_chat_id/',
		type: 'post',
		data: 'cid='+chat_id,
		dataType: 'json',
		success: function (chat_data){

			
			processChat(chat_data);
			timeout = setTimeout(function(){
				refresh();
			}, 1000);
		}
	});
}



function processChat(chat_data, prepend){
	var its_me, me;
	var html = '';
	var show_pic = true;
	var name, form_email, to_email, event_id, sponsor_id, message, datetime, seen, seen_time, chat_id, id, chatter;
	
	if (prepend){
		var scroll_to = first_id;
	}
	
	
	try {
		if (!chat_data.event) chat_data.event = false;
	} catch (e){
		chat_data.event = false;
	}

	for (var i in chat_data.chat){
	
		name 		= chat_data.chat[i].name;
		from_email 	= chat_data.chat[i].from_email;
		to_email	= chat_data.chat[i].to_email;
		event_id	= chat_data.chat[i].event_id;
		sponsor_id	= chat_data.chat[i].sponsor_id;
		message		= chat_data.chat[i].message;
		datetime	= chat_data.chat[i].datetime;
		seen		= chat_data.chat[i].seen;
		seen_time	= chat_data.chat[i].seen_time;
		chat_id		= chat_data.chat[i].chat_id;
		id			= chat_data.chat[i].id;
		
		
		if (!msgs[id]){
		
			msgs[id] = true;
		
			if (i == 0) first_id = id;
			
			if (from_email == chat_data.me){
				its_me = 'chat-msg-me hint--left ' + (seen ? 'chat-msg-seen' : '');
				show_pic = true;
				me = false;
			} else {
				its_me = 'hint--right';
				me = true;
			}
			
			var dt = new Date(strtotime(datetime)*1000);
			var ago = timeSince(dt);

			if (seen_time && me){
				var dt_seen = new Date(strtotime(seen_time)*1000);
				var ago_seen = timeSince(dt_seen);
			} else {
				var ago_seen = '';
			}

			
			html += '<div name="chatmsg'+id+'" data-hint="'+ago+(ago_seen ? '. Seen ' + ago_seen : '')+'" class="'+(event_id?'chat-event-msg':'')+' chat-msg hint--rounded hint--bounce chatmsg'+id+' '+its_me+' ">';
			
			if (its_me == 'hint--right' && show_pic){
				html += '<div class="float-left" style="height: 40px; margin-left: -53px; position: absolute; width: 40px; margin-top: -9px; ">';
				html += chat_data.user[from_email].pi_html;
				html += '</div>';
				
				show_pic = false;
			}
			
			html += '<div class="thin">'+message+'</div>';
			html += '</div>';
			html += '<div class="clear"></div>';
	
		}	
	}
	
	
	if (prepend){
		$('.cbx').prepend(html);
		$('.cbx').scrollTo('.chatmsg'+scroll_to, 0);
	} else {
		if (msgs.length == 0){
			var event_info = chat_data.event ? ' about <strong>'+chat_data.event+'</strong>' : '';
			
			$('.cbx').html('<p class="align-center thin">You are now chatting with <strong>' + chat_data.chatter + '</strong>'+event_info+'</p>');
		} else {
			if (html){
				if (first_time){
					first_time = false;				
				} else {
					beep();					
				}

				setTimeout(function(){
					$('.cbx').append(html);
					
					if (last_id != id){
						var sh = $('div.cbx')[0].scrollHeight;
						$('div.cbx').scrollTop(sh);	
					}
					last_id = id;

				},400);
			}
		}
	}

}

</script>

	<div class="cbx" style="padding: 10px 10px 10px 10px; overflow-y: scroll;">
	
	</div>

	<div class="chat-input" style="position: absolute; bottom: 0; left: 0; right: 0; background: #fff; padding: 5px;">
		<a style="float: right; " class="btn btn-mid btn-grey cb-send">Send</a>
		<input style="width: 500px; margin-bottom: 0;" type="text" name="cb-input" class="text cb-input" />

	</div>
	
	
	