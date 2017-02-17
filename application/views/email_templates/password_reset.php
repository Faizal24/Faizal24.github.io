<html>
<head>
	<style>
		body {
			background: #ddd;
			font-family: sans-serif;
			font-weight: 300;
			font-size: 11pt;
			line-height: 150%;
			padding: 20px;
		}
		
		#container {
			width: 500px;
			padding: 20px;
			background: #fff;
			margin: 0 auto;
			border-radius: 10px;
			box-shadow: 0 0 10px rbga(0,0,0,0.5);
		}
		
		h1 {
			font-weight: 300;
		}
		
	</style>
</head>
<body>
	
	<div id="container">
		
		<div style="text-align: center; padding: 10px 10px 30px 10px;">
			<img src="<?php echo base_url(); ?>email/logo.png" style="width: 50%" />
		</div>
		
		
			
			<h1>Password Reset</h1>
			<p>Hi <?php echo $name; ?></p>
			<p>We have received a request to reset your password. To complete the process, <a href="<?php echo $url; ?>">click here</a> or navigate to the link below:</p>
			<p><a href="<?php echo $url; ?>"><?php echo $url; ?></a></p>
			<p>Ignore this email if you did not perform this request. This link will expire in an hour.</p>
			<p>Thank you,<br />
				<strong>MaiTutor Team</strong>
			</p>
		
		
	</div>
</body>
</html>