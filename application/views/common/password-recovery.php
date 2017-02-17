<div class="max1280 padding">
	<h1 class="thin">Password Recovery</h1>
</div>

<div class="grey-bg">
<div class="max1024 padding min-height-600">


<?php if ($successful): ?>
	<p>
		Password reset request successful! Please check your email address for instructions to reset your password.
	</p>
	<div>
		<a class="btn" href="<?php echo base_url(); ?>login">Login</a> or <a href="<?php echo base_url(); ?>">go back to homepage</a>
	</div>

<?php else: ?>
<form method="post">
	<?php if ($error): ?>
	<p class="error"><?php echo $error; ?></p>
	<?php endif; ?>
	<p>
		Enter your email address associated with your MaiTutor account to request for password reset.
	</p>
	<div>
		<input placeholder="Email" class="text" type="email" name="email" />
		<input class="btn" type="submit" name="submit" value="Request Password Reset" />
	</div>

</form>

<?php endif; ?>


</div>
