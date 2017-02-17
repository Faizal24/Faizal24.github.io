<a href="settings/permissions" class="link btn btn-primary float-right btn-large"><i class="fa fa-arrow-left"></i> Back</a>

<h1 class="main-separator-blue-tint">Settings &raquo; Edit User Type</h1>

<?php if ($flag == 'success'): ?>
<p class="alert darkblue">User type has been updated.</p>
<?php endif; ?>

<form method="post" class="submit" action="settings/edit_type/<?php echo $user_type->id; ?>/do">
	<input type="hidden" name="post" value="1" />
	<div class="row pt-15">
		<div class="col-1-2 pr-15">
			<label class="w-150px inline-block">Name <span class="red">*</span></label>
			<input value="<?php echo $this->input->post('name') ? $this->input->post('name') : $user_type->name; ?>" class="text fw mandatory" type="text" name="name" class="text" />
			<?php if ($error['name']): ?>
			<small class="red"><?php echo $error['name']; ?></small>
			<?php endif; ?>
		</div>
	</div>
	<div class="row pt-15">
		<?php 
			$perm = json_decode($user_type->permission,true);
		?>
		<div class="col-1-2 pr-15">
			<label class="w-150px inline-block">Permissions <span class="red">*</span></label>
			<h3>System</h3>
			<input <?php if ($perm['access_settings']) echo 'checked'; ?> type="checkbox" name="permission[access_settings]" /> Access Settings<br />
			<input <?php if ($perm['manage_system']) echo 'checked'; ?> type="checkbox" name="permission[manage_system]" /> Manage System<br />
			<input <?php if ($perm['manage_user']) echo 'checked'; ?> type="checkbox" name="permission[manage_user]" /> Manage User<br />

			<hr />
			
			<h3>Entry</h3>
			<input <?php if ($perm['comments']) echo 'checked'; ?> type="checkbox" name="permission[tutors]" /> Tutors<br />
			
			<hr />
			<h3>Delete</h3>
			
		</div>
	</div>
	<hr />
	<div class="align-right">
		<input type="submit" name="submit" class="btn btn-primary" value="Save" />
	</div>
	
</form>

