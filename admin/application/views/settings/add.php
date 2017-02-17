<a href="settings/users" class="link btn btn-primary float-right btn-large"><i class="fa fa-arrow-left"></i> Back</a>

<h1 class="main-separator-blue-tint">Settings &raquo; Add User</h1>

<?php if ($flag == 'success'): ?>
<p class="alert darkblue">User has been added.</p>
<?php endif; ?>

<form method="post" class="submit" action="settings/add/do">
	<input type="hidden" name="post" value="1" />
	<div class="row pt-15">
		<div class="col-1-2 pr-15">
			<label class="w-150px inline-block">Name <span class="red">*</span></label>
			<input value="<?php echo $this->input->post('name'); ?>" class="text fw mandatory" type="text" name="name" class="text" />
			<?php if ($error['name']): ?>
			<small class="red"><?php echo $error['name']; ?></small>
			<?php endif; ?>
		</div>
		<div class="col-1-2 pl-15">
			<label class="w-150px inline-block">Username <span class="red">*</span></label>
			<input value="<?php echo $this->input->post('email'); ?>" class="text fw mandatory" type="text" name="email" />	
			<?php if ($error['email']): ?>
			<small class="red"><?php echo $error['email']; ?></small>
			<?php endif; ?>

		</div>
	</div>
	<div class="row pt-15">
		<div class="col-1-2 pr-15">
			<label class="w-150px inline-block">Password <span class="red">*</span></label>
			<input class="text fw mandatory" type="password" name="password" />	
			<?php if ($error['password']): ?>
			<small class="red"><?php echo $error['password']; ?></small>
			<?php endif; ?>

		</div>
		<div class="col-1-2 pl-15">
			<label class="w-150px inline-block">Type <span class="red">*</span></label>
			<?php echo form_dropdown('type',$this->user->user_types_dropdown(),$this->input->post('type'),'class="fw"'); ?>
			<?php if ($error['type']): ?>
			<small class="red"><?php echo $error['type']; ?></small>
			<?php endif; ?>

		</div>

	</div>
	<hr />
	<div class="align-right">
		<input type="submit" name="submit" class="btn btn-primary" value="Save" />
	</div>
	
</form>

