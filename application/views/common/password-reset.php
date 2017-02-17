<div class="max1280 padding">
	<h1 class="thin">Password Reset</h1>
</div>

<div class="grey-bg">
<div class="max1024 padding min-height-600">
	
	
<?php if (isset($error)): ?>
	<?php if ($error == 1): ?>
	<div class="error">Password must be at least 6 characters long.</div>
	<?php elseif ($error == 2): ?>
	<div class="error">Password entered does not match.</div>
	<?php endif; ?>
<?php endif; ?>

<form method="post">
	<p>Enter your new password to complete the password reset</p>
	<div>
		<label style="display: inline-block; width: 200px">New Password</label>
		<input class="text" type="password" name="password" />
	</div>
	<div>
		<label style="display: inline-block; width: 200px">Retype Password</label>
		<input class="text" type="password" name="rpassword" />
	</div>
	<hr />
	<p class="align-right">
		<input class="btn btn-primary" type="submit" name="submit" value="Reset" />
	</p>
</form>


</div>
</div>