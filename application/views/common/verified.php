<div class="login-bg">
			<div id="login-form">
				<form method="post" action="login/auth">

					<h1>Login</h1>
					<div class="success">Your account is now verified!</div>
					
					<p>Login with <a href="#">Facebook</a> or <a href="#">Google</a></p>
					
					<?php if ($error == 1): ?>
					<p class="error">Incorrect username or password</p>
					<?php endif; ?>
					
					<div class="input"><input type="text" name="email" placeholder="Email" class="block text w100" /></div>
					<div class="input"><input type="password" name="password" placeholder="Password" class="block text w100" /></div>

					<div class="input">
						<a href="password_recovery">Forgot your password? </a>
					</div>
					<div class="spacer"></div>
					
					<input type="submit" class="btn btn-primary" value="Go" />
				</form>
			</div>
			
			<div class="spacer"></div>
			<div class="spacer"></div>
			<div class="spacer"></div>
			<div class="spacer"></div>
			<div class="spacer"></div>
			<div class="spacer"></div>
			<div class="spacer"></div>
			<div class="spacer"></div>
			<div class="spacer"></div>
			
</div>