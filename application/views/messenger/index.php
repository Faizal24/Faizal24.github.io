<script type="text/javascript">

var timeout 	= null;
<?php if ($eid): ?>
var eid			= '<?php echo $eid; ?>';
var uid			= '<?php echo $uid; ?>';
<?php elseif ($uid): ?>
var uid			= '<?php echo $uid; ?>';
var eid;
<?php else: ?>
var eid, uid;
<?php endif; ?>

$(document).ready(function(){

	$('#footer').remove();
	
	$('input.search').keypress(function(e){
		if (e.keyCode == 13){
			search();
		}
	})
	
	$('button.search').click(function(){
		search();
	})
	
	$('#messenger-main,#messenger-sidebar').on('click','.send-message',function(){
		var uid = $(this).attr('uid');
		var eid = $(this).attr('eid');
		$('#messenger-main').html('<div class="padding">Loading conversation...</div>');
		
		if (!eid){
			eid = '';
		}
		
		try {
			clearTimeout(timeout);			
		} catch (e) {
			// do nothing
		}
		
		

		$.ajax({
			url: 'messenger/ajax/get_conversation',
			type: 'post',
			data: 'uid='+uid+'&eid='+eid,
			success: function (res){
				$('#messenger-main').html(res);
			}
		})
		
	})

	if (eid){
	
		$('#messenger-main').html('<div class="padding">Loading conversation...</div>');
		
		$.ajax({
			url: 'messenger/ajax/get_conversation',
			type: 'post',
			data: 'uid='+uid+'&eid='+eid,
			success: function (res){
				$('#messenger-main').html(res);
			}
		})
	}
	
	if (uid){

		$('#messenger-main').html('<div class="padding">Loading conversation...</div>');
		
		$.ajax({
			url: 'messenger/ajax/get_conversation',
			type: 'post',
			data: 'uid='+uid,
			success: function (res){
				$('#messenger-main').html(res);
			}
		})
		
	}
	
	$(window).resize(function(){
		var h = $(window).height() - 180;
		$('#messenger-main').css('height',h);
		$('#messenger-sidebar').css('height',h);
		$('.cbx').css('height',h-75);
	});
	
	$(window).resize();
	
	loadChatList();
	
	setInterval(function(){
		loadChatList();
	}, 3000);
	
})

function loadChatList(){
	$.ajax({
		url: 'ajax/general/get_chat_list',
		dataType: 'json',
		success: function (list_data){
			processList(list_data);
		}
	})
}

function processList(list_data){
	var html = '';
	var seen_class;
	if (list_data.list.length == 0){
		$('#messenger-sidebar').html('<div class="padding">No conversations yet.</div>');
	} else {
		for (var i in list_data.list){
			
			var name 		= list_data.list[i].firstname + ' ' + list_data.list[i].lastname;
			var from_email 	= list_data.list[i].from_email;
			var from_name	= list_data.list[i].from_name;
			var to_email	= list_data.list[i].to_email;
			var to_name		= list_data.list[i].to_name;
			var event_id	= list_data.list[i].event_id;
			var sponsor_id	= list_data.list[i].sponsor_id;
			var message		= list_data.list[i].message;
			var datetime	= list_data.list[i].datetime;
			var seen		= list_data.list[i].seen;
			var seen_time	= list_data.list[i].seen_time;
			var cid			= list_data.list[i].chat_id;
			var id			= list_data.list[i].id;
			var img			= list_data.list[i].img;
			var event		= list_data.list[i].event
			
			
			
			if (seen){
				console.log('a'+seen+'a');
				seen_class = '';
			} else {
				console.log('a'+seen+'a');
				seen_class = 'chat-conversation-unseen';
			}
			
			var dt = new Date(strtotime(datetime)*1000);
			var ago = timeSince(dt);
			
			var ids 	= cid.split('-');
			var uid 	= ids[0] == list_data.my_id ? ids[1] : ids[0];
			
			html += '<div class="chat-conversation send-message '+seen_class+'" uid="'+uid+'" eid="'+event_id+'">';	
			
			if (from_email == list_data.me){
				html += '<div class="chat-conversation-user"><div style="height: 40px; width: 40px; float:left; margin-right: 10px">'+img+'</div>'+(event ? event + ' &middot; ':'')+to_name+'</div>';
			} else {
				html += '<div class="chat-conversation-user"><div style="height: 40px; width: 40px; float: left; margin-right: 10px">'+img+'</div>'+(event ? event + ' &middot; ':'')+from_name+'</div>';
			}
			html += '<div class="chat-conversation-excerpt"><span class="light-grey ml10 float-right">'+ago+'</span>'+message+'</div>';
			html += '</div>';
		
		}
		
		$('#messenger-sidebar').html(html);
	}
}

function search(){
	var q =  $('input.search').val();
	$('#messenger-main').html('<div class="padding">Searching...</div>');
	$.ajax({
		url: 'messenger/ajax/search',
		type: 'post',
		data: 'q='+encodeURIComponent(q),
		success: function (res){
		

			$('#messenger-main').html(res);
			
		
		}
	})
}

</script>
	
	
<div class="max1280">
	<h1 class="thin">Messages</h1>
	
	<div id="messenger-container">
		<div id="messenger-sidebar">
			<div class="padding">No conversations yet.</div>
		</div>
		
		<div id="messenger-main" style="position:relative">
		
		
		</div>
	
	</div>
	<div class="spacer"></div>
</div>