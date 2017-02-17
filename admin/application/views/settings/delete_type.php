<a href="settings/permissions" class="link btn btn-primary float-right btn-large"><i class="fa fa-arrow-left"></i> Back</a>

<h1 class="main-separator-blue-tint">Settings &raquo; Delete User Type</h1>


<form method="post" class="submit" action="settings/delete_type/<?php echo $type->id; ?>/do">
	<input type="hidden" name="post" value="1" />
	
	<p>Are you sure you want to delete user type '<strong><?php echo $type->name; ?></strong>'?</p>
	
	<div class="row pt-15">
		<div class="col-1-2 pr-15">
			<label class="inline-block">To continue, please select a new permission to replace with.</label>
			<p>
			<?php foreach ($user_types as $user_type): ?>
				<?php if ($type->name != $user_type->name): ?>
					<br />
					<input type="radio" name="new_user_type" value="<?php echo $user_type->name; ?>" /> <?php echo $user_type->name; ?>
				<?php endif; ?>
			<?php endforeach; ?>
			</p>
			
			<?php if ($error['new_user_type']): ?>
			<small class="red"><?php echo $error['new_user_type']; ?></small>
			<?php endif; ?>
		</div>
	</div>
	<hr />
	<div class="align-right">
		<a href="settings/permissions" class="link btn">Cancel</a>
		<input type="submit" name="submit" class="btn btn-primary" value="Confirm" />
	</div>
	
</form>

