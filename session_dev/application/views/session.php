<?php
	if ($_SERVER['SERVER_ADDR'] == '::1'){
		$base = 'http://localhost:3000';
	} else {
		$base = 'http://' . $_SERVER['SERVER_ADDR'] . ':3000';
	}
?>
<!DOCTYPE html>
<html>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="css/session.css?abc" />
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.event.drag-2.0.js"></script>
	<script type="text/javascript" src="js/latest-v2.js"></script>
	<script src="<?php echo $base; ?>/socket.io/socket.io.js"></script>
	<script type="text/javascript" src="js/scripts.js"></script>
	<script type="text/javascript">

		var server = '<?php echo $base; ?>';
		document.ontouchstart = function(e){ 
	    	e.preventDefault(); 
		}		
		
	</script>
	<head>
		<title>Tutoring Session</title>
	</head>
	<body>
		<form id="createRoom" style="display: none">
            <input id="sessionInput" value="127389ahfs094ksoifiotsess"/>
            <button disabled type="submit">Create it!</button>
        </form>
		<div id="container">
			<div id="header">
				<h1>teach:me</h1>
			</div>			
			<div id="sidebar">
				

				<div class="videoContainer">
					<meter id="localVolume" style="position: absolute; z-index: 100; width: 100%" class="volume" min="-45" max="-20" high="-25" low="-40"></meter>
					<video id="localVideo" style="width: 100%;" oncontextmenu="return false;"></video>

				</div>
				<div class="controls">
					<button class="button"><i class="fa fa-video-camera"></i></button>
					<button class="button"><i class="fa fa-microphone"></i></button>
					<button class="button" id="screenShareButton"></button>
				</div>
				
		        <div id="localScreenContainer" class="videoContainer">
		        </div>
		        <div style="width: 100%; border-top: 1px solid #ddd; min-height: 200px; border-bottom: 1px solid #ddd" id="remotes"></div>
		        <div class="chat" style="position: fixed; top: 458px; bottom: 0; left: 0; width: 350px;">
			        <div class="chat-container" style="padding-bottom: 80px">
				        Chat Started
			        </div>
					<div class="chat-input" style="position: absolute; bottom: 0; width: 350px; height: 80px; border-top: 1px solid #ddd">
						<textarea id="chat-input"></textarea>
					</div>
		        </div>

			</div>
			
			<div id="main">
				<div class="toolbar">
					<a class="color-toolbar color-white" rel="white">x</a>
					<a class="color-toolbar color-black" rel="black">x</a>
					<a class="color-toolbar color-red" rel="red">x</a>
					<a class="color-toolbar color-blue" rel="blue">x</a>
					<a class="color-toolbar color-purple" rel="purple">x</a>
					<a class="color-toolbar color-green" rel="green">x</a>
					<a class="color-toolbar color-orange" rel="orange">x</a>
					<a class="color-toolbar color-yellow" rel="yellow">x</a>
					<a style="color: white" class="btn-clear">Clear</a>
		
				</div>
				<article style="overflow: scroll"><!-- our canvas will be inserted here--></article>
			</div>
		</div>
		
		
		<script>
			
			$(document).ready(function(){
				$('#createRoom').submit();
			})
            // grab the room from the URL
            var room = location.search && location.search.split('?')[1];

            // create our webrtc connection
            var webrtc = new SimpleWebRTC({
                // the id/element dom element that will hold "our" video
                localVideoEl: 'localVideo',
                // the id/element dom element that will hold remote videos
                remoteVideosEl: '',
                // immediately ask for camera access
                autoRequestMedia: true,
                debug: false,
                detectSpeakingEvents: true,
                autoAdjustMic: false
            });

            // when it's ready, join if we got a room from the URL
            webrtc.on('readyToCall', function () {
                // you can name it anything
                if (room) webrtc.joinRoom(room);
            });

            function showVolume(el, volume) {
                if (!el) return;
                if (volume < -45) volume = -45; // -45 to -20 is
                if (volume > -20) volume = -20; // a good range
                el.value = volume;
            }

            // we got access to the camera
            webrtc.on('localStream', function (stream) {
                var button = document.querySelector('form>button');
                if (button) button.removeAttribute('disabled');
                $('#localVolume').show();
            });
            // we did not get access to the camera
            webrtc.on('localMediaError', function (err) {
            });

            // local screen obtained
            webrtc.on('localScreenAdded', function (video) {
                video.onclick = function () {
                    video.style.width = video.videoWidth + 'px';
                    video.style.height = video.videoHeight + 'px';
                };
                document.getElementById('localScreenContainer').appendChild(video);
                $('#localScreenContainer').show();
            });
            // local screen removed
            webrtc.on('localScreenRemoved', function (video) {
                document.getElementById('localScreenContainer').removeChild(video);
                $('#localScreenContainer').hide();
            });

            // a peer video has been added
            webrtc.on('videoAdded', function (video, peer) {
                console.log('video added', peer);
                var remotes = document.getElementById('remotes');
                if (remotes) {
                    var container = document.createElement('div');
                    container.className = 'videoContainer';
                    container.id = 'container_' + webrtc.getDomId(peer);
                    container.appendChild(video);

                    // suppress contextmenu
                    video.oncontextmenu = function () { return false; };

                    // resize the video on click
                    video.onclick = function () {
                        container.style.width = video.videoWidth + 'px';
                        container.style.height = video.videoHeight + 'px';
                    };

                    // show the remote volume
                    var vol = document.createElement('meter');
                    vol.id = 'volume_' + peer.id;
                    vol.className = 'volume';
                    vol.min = -45;
                    vol.max = -20;
                    vol.low = -40;
                    vol.high = -25;
                    container.appendChild(vol);

                    // show the ice connection state
                    if (peer && peer.pc) {
                        var connstate = document.createElement('div');
                        connstate.className = 'connectionstate';
                        container.appendChild(connstate);
                        peer.pc.on('iceConnectionStateChange', function (event) {
                            switch (peer.pc.iceConnectionState) {
                            case 'checking':
                                connstate.innerText = 'Connecting to peer...';
                                break;
                            case 'connected':
                            case 'completed': // on caller side
                                $(vol).show();
                                connstate.innerText = 'Connection established.';
                                break;
                            case 'disconnected':
                                connstate.innerText = 'Disconnected.';
                                break;
                            case 'failed':
                                connstate.innerText = 'Connection failed.';
                                break;
                            case 'closed':
                                connstate.innerText = 'Connection closed.';
                                break;
                            }
                        });
                    }
                    remotes.appendChild(container);
                }
            });
            // a peer was removed
            webrtc.on('videoRemoved', function (video, peer) {
                console.log('video removed ', peer);
                var remotes = document.getElementById('remotes');
                var el = document.getElementById(peer ? 'container_' + webrtc.getDomId(peer) : 'localScreenContainer');
                if (remotes && el) {
                    remotes.removeChild(el);
                }
            });

            // local volume has changed
            webrtc.on('volumeChange', function (volume, treshold) {
                showVolume(document.getElementById('localVolume'), volume);
            });
            // remote volume has changed
            webrtc.on('remoteVolumeChange', function (peer, volume) {
                showVolume(document.getElementById('volume_' + peer.id), volume);
            });

            // local p2p/ice failure
            webrtc.on('iceFailed', function (peer) {
                var connstate = document.querySelector('#container_' + webrtc.getDomId(peer) + ' .connectionstate');
                console.log('local fail', connstate);
                if (connstate) {
                    connstate.innerText = 'Connection failed.';
                    fileinput.disabled = 'disabled';
                }
            });

            // remote p2p/ice failure
            webrtc.on('connectivityError', function (peer) {
                var connstate = document.querySelector('#container_' + webrtc.getDomId(peer) + ' .connectionstate');
                console.log('remote fail', connstate);
                if (connstate) {
                    connstate.innerText = 'Connection failed.';
                    fileinput.disabled = 'disabled';
                }
            });

            // Since we use this twice we put it here
            function setRoom(name) {
                document.querySelector('form').remove();
                $('body').addClass('active');
            }

            if (room) {
                setRoom(room);
            } else {
                $('form').submit(function () {
                    var val = $('#sessionInput').val().toLowerCase().replace(/\s/g, '-').replace(/[^A-Za-z0-9_\-]/g, '');
                    webrtc.createRoom(val, function (err, name) {
                        console.log(' create room cb', arguments);

                        var newUrl = location.pathname + '?' + name;
                        if (!err) {
                            history.replaceState({foo: 'bar'}, null, newUrl);
                            setRoom(name);
                        } else {
                            console.log(err);
                        }
                    });
                    return false;
                });
            }

            var button = document.getElementById('screenShareButton'),
                setButton = function (bool) {
                    button.innerText = bool ? 'Share Screen' : 'Stop Sharing';
                };
            if (!webrtc.capabilities.screenSharing) {
                button.disabled = 'disabled';
            }
            webrtc.on('localScreenRemoved', function () {
                setButton(true);
            });

            setButton(true);

            button.onclick = function () {
                if (webrtc.getLocalScreen()) {
                    webrtc.stopScreenShare();
                    setButton(true);
                } else {
                    webrtc.shareScreen(function (err) {
                        if (err) {
                            setButton(true);
                        } else {
                            setButton(false);
                        }
                    });

                }
            };
        </script>
	</body>
</html>