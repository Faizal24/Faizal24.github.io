function getRandomIntInclusive(min, max) {
  min = Math.ceil(min);
  max = Math.floor(max);
  return Math.floor(Math.random() * (max - min + 1)) + min;
}
var user = 'User' + getRandomIntInclusive(100, 999);

(function() {

	
	var App, startX, startY;
	App = {};
	App.init = function() {
		App.canvas = document.createElement('canvas');
		App.canvas.height = 2500;
		App.canvas.width = 2500;
		document.getElementsByTagName('article')[0].appendChild(App.canvas);
		App.ctx = App.canvas.getContext("2d");
		App.ctx.fillStyle = "solid";
		App.ctx.strokeStyle = "#ECD018";
		App.ctx.lineWidth = 3;
		App.ctx.lineCap = "round";
		App.socket = io.connect(server);
		App.socket.on('draw', function(data) {
			return App.draw(data.x, data.y, data.type);
		});
		App.socket.on('clear', function(data) {
			return App.clear();
		});
		App.clear = function(){
			App.ctx.clearRect(0, 0, App.canvas.width, App.canvas.height);	
		};
		App.draw = function(x, y, type) {
			if (type === "dragstart" || type === "touchstart") {
				App.ctx.beginPath();
				return App.ctx.moveTo(x, y);
			} else if (type === "drag" || type === "touchmove") {
				App.ctx.lineTo(x, y);
				return App.ctx.stroke();
			} else {
				return App.ctx.closePath();
			}
		};
		App.appendMessage = function(session, user,message){
			
		}
		
		App.startChat = function(){
			App.socket.emit('startChart', {
				data.username: user
			})
		}
		

	};
	
	$('canvas').live('drag dragstart dragend', function(e) {
		var offset, type, x, y;
		type = e.handleObj.type;

		x = e.pageX + $('article').scrollLeft() - 351;
		y = e.pageY + $('article').scrollTop() - 92;
		

		App.draw(x, y, type);
		App.socket.emit('drawClick', {
			x: x,
			y: y,
			type: type
		});
	});
	
	$('.btn-clear').live('click touchend',function(){
		App.clear();
		App.socket.emit('clearCanvas',{});
	})
  
	$('canvas').live('touchstart touchmove touchend', function(e) {
		
		var offset, type, x, y;
		type = e.type;
		
		if (e.originalEvent.touches.length == 2){
			
			if (type == 'touchstart'){
				console.log(e);
				startX = e.layerX;
				startY = e.layerY;
			}
			
			if (type == 'touchmove'){
				var deltaX = e.layerX - startX;
				var deltaY = e.layerY - startY;
				

				$('article').scrollLeft($('article').scrollLeft() - deltaX);
				$('article').scrollTop($('article').scrollTop() - deltaY);
				
			}
			
		} else {
  

			x = e.pageX + $('article').scrollLeft();
			y = e.pageY + $('article').scrollTop();
			
			App.draw(x, y, type);
			App.socket.emit('drawClick', {
				x: x,
				y: y,
				type: type
			});
		}
	});
	
	$('#chat-input').onkeydown(function(e){
		if (e.keyCode == 16) $(this).addClass('shifted');
	});
	
	$('#chat-input').onkeyup(function(e){
		if (e.keyCode == 16) $(this).removeClass('shifted');
	})
	
	$('#chat-input').onkeypress(function(e){
		shifted = e.shiftKey;
		if (e.keyCode == 13){
			if ($(this).hasClass('shifted')){
				e.preventDefault();
				App.
			} else {
				
			}
		}
	})
  
	$(function() {
		return App.init();
	});
}).call(this);
