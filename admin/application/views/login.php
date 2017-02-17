<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<base href="<?php echo base_url(); ?>" />
		<title></title>
		<link rel="stylesheet" href="css/base.css" />
	</head>
	<body>
		<div class="login-container">
			<div class="login">
				<h3 style="text-align: center">MyTutor Administration</h3>
				<?php if ($flag == 'error'): ?>
				<div class="alert error">Incorrect username or password.</div>
				<?php endif; ?>
				<form method="post" action="login/auth">
					<p><input class="text" type="text" name="email" placeholder="Email" /></p>
					<p><input class="text" type="password" name="password" placeholder="Password" /></p>
					<!-- <p class="align-center"><a href="password">Forgot your password?</a></p> -->
					<p><input type="submit" class="btn btn-primary" value="Login" /></p>
				</form>
			</div>		
			
		</div>
	
	
	</body>
	
</html>