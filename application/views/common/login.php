<div class="login-bg">
			<div id="login-form">
				<form method="post" action="login/auth">

					<h1>Login</h1>
					<p>Login with <a href="#">Facebook</a> or <a href="#">Google</a></p>
					
					<?php if ($error == 1): ?>
					<p class="error">Incorrect username or password</p>
					<?php endif; ?>
					
					<div class="input"><input type="text" name="email" placeholder="Email" class="block text w100" /></div>
					<div class="input"><input type="password" name="password" placeholder="Password" class="block text w100" /></div>

					<div class="input">
						<a href="password_reset/forgot_password">Forgot your password? </a>
					</div>
					<div class="spacer"></div>
					
					<input type="submit" class="btn btn-primary" style="width:20px;" value="Go" />
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