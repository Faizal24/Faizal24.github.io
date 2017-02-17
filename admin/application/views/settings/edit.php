<a href="settings/users" class="link btn btn-primary float-right btn-large"><i class="fa fa-arrow-left"></i> Back</a>

<h1 class="main-separator-blue-tint">Settings &raquo; Edit User</h1>

<?php if ($flag == 'success'): ?>
<p class="alert darkblue">User has been updated.</p>
<?php endif; ?>


<form method="post" class="submit" action="settings/edit/<?php echo $user->id; ?>/do">
	<input type="hidden" name="post" value="1" />
	<div class="row pt-15">
		<div class="col-1-2 pr-15">
			<label class="w-150px inline-block">Username</label>
			<p><strong><?php echo $user->email; ?></strong></p>
		</div>
		<div class="col-1-2 pl-15">
			<label class="w-150px inline-block">Name <span class="red">*</span></label>
			<input  value="<?php echo $user->name; ?>" class="text fw mandatory" type="text" name="name" class="text" />
			<?php if ($error['name']): ?>
			<small class="red"><?php echo $error['name']; ?></small>
			<?php endif; ?>

		</div>
	</div>
	<div class="row pt-15">
		<div class="col-1-2 pr-15">
			<label class="w-150px inline-block">Change Password</label>
			<input class="text fw" type="password" name="password" />			
			<?php if ($error['password']): ?>
			<small class="red"><?php echo $error['password']; ?></small>
			<?php endif; ?>

		</div>
		<div class="col-1-2 pl-15">
			<label class="w-150px inline-block">Type <span class="red">*</span></label>
			<?php echo form_dropdown('type',$this->user->user_types_dropdown(),$user->type,'class="fw"'); ?>
			<?php if ($error['type']): ?>
			<small class="red"><?php echo $error['type']; ?></small>
			<?php endif; ?>

		</div>

	</div>
	<hr />
	<div class="align-right">
		<input type="submit" class="btn btn-primary" value="Save" />
	</div>
	
</form>

