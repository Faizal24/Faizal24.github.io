<a href="settings/permissions" class="link btn btn-primary float-right btn-large"><i class="fa fa-arrow-left"></i> Back</a>

<h1 class="main-separator-blue-tint">Settings &raquo; Add User Type</h1>

<?php if ($flag == 'success'): ?>
<p class="alert darkblue">User type has been added.</p>
<?php endif; ?>

<form method="post" class="submit" action="settings/add_type/do">
	<input type="hidden" name="post" value="1" />
	<div class="row pt-15">
		<div class="col-1-2 pr-15">
			<label class="w-150px inline-block">Name <span class="red">*</span></label>
			<input value="<?php echo $this->input->post('name'); ?>" class="text fw mandatory" type="text" name="name" class="text" />
			<?php if ($error['name']): ?>
			<small class="red"><?php echo $error['name']; ?></small>
			<?php endif; ?>
		</div>
	</div>
	<div class="row pt-15">
		<div class="col-1-2 pr-15">
			<label class="w-150px inline-block">Permissions <span class="red">*</span></label>
			<h3>System</h3>
			<input type="checkbox" name="permission[access_settings]" /> Access Settings<br />
			<input type="checkbox" name="permission[manage_system]" /> Manage System<br />
			<input type="checkbox" name="permission[manage_user]" /> Manage User<br />
			<hr />
			
			<h3>Entry</h3>
			<input type="checkbox" name="permission[tutor]" /> Tutor<br />

			<hr />
			<h3>Delete</h3>
			
		</div>
	</div>
	<hr />
	<div class="align-right">
		<input type="submit" name="submit" class="btn btn-primary" value="Save" />
	</div>
	
</form>

