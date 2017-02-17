<a href="settings/users" class="link btn btn-primary float-right btn-large"><i class="fa fa-arrow-left"></i> Back</a>

<h1 class="main-separator-blue-tint">Settings &raquo; Delete User</h1>


<form method="post" class="submit" action="settings/delete/<?php echo $user->id; ?>/do">
	<input type="hidden" name="post" value="1" />
	
	<p>Are you sure you want to delete user '<strong><?php echo $user->name; ?></strong>'?</p>
	
	<hr />
	<div class="align-right">
		<a href="settings/users" class="link btn">Cancel</a>
		<input type="submit" name="submit" class="btn btn-primary" value="Confirm" />
	</div>
	
</form>

