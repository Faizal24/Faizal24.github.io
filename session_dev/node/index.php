<?php
	if ($_SERVER['SERVER_ADDR'] == '::1'){
		$base = 'http://localhost:3000';
	} else {
		$base = 'http://' . $_SERVER['SERVER_ADDR'] . ':3000';
	}
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.event.drag-2.0.js"></script>
	<script src="<?php echo $base; ?>/socket.io/socket.io.js"></script>
	<script type="text/javascript" src="scripts.js"></script>
	<script type="text/javascript">

		var server = '<?php echo $base; ?>';
		document.ontouchstart = function(e){ 
	    	e.preventDefault(); 
		}		
		
	</script>
	<link rel="stylesheet" href="style.css" />
	<meta name="viewport" content = "width=device-width,initial-scale=1,user-scalable=no">
	<title>TEACHME</title>
	
</head>
<body>
	<div style="position: fixed; top: 0; padding: 10px; z-index: 100; right: 0; left: 0; background: #000">
		<a style="color: white" class="btn-clear">Clear</a>
		
	</div>
	<article style="overflow: scroll"><!-- our canvas will be inserted here--></article>
	

</body>

