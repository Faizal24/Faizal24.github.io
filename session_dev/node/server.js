(function() {
	
	var connectedClients = {};
	var io;
	io = require('socket.io').listen(3000);
	io.sockets.on('connection', function(socket) {
		
		
		socket.on('message', function(data){
			
		})
		
		socket.on('startChat', function(data){
			connectedClients[data.username] = socket.id;			
		})
		
		socket.on('drawClick', function(data) {
			socket.broadcast.emit('draw', {
				x: data.x,
		        y: data.y,
				type: data.type
			});
		});
		
		socket.on('clearCanvas', function(){
			socket.broadcast.emit('clear');
		});
	});
}).call(this);
