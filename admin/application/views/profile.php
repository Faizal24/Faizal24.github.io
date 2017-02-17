
<h1 class="main-separator-blue-tint">My Profile</h1>

<?php if ($flag == 'success'): ?>
<p class="alert darkblue">User has been updated.</p>
<?php endif; ?>


<div style="width: 300px">
	<form method="post" callback="uploadDone()" target="postframe" enctype="multipart/form-data" action="profile/upload_photo">

		<p>
			<div class="image" style="width: 56px; height: 56px; margin-right: 10px; border: 1px solid #ddd; border-radius: 5px; float: left; background: url('uploads/profile/<?php echo $user->photo; ?>') no-repeat; background-size: cover;  background-position: center center;">
				<div style="text-align: center; padding-top: 20px">
					<?php if (!$user->photo): ?>
					<i class="fa fa-image"></i>
					<?php endif; ?>
				</div>
			</div>
			<label class="w-150px inline-block">Upload Image</label><br /><br />
			<a onclick="$('.file').click()" class="btn btn-primary">Select Image</a>
			<input type="file" class="file change-submit" name="file" style="display: none;" />
			
		</p>
	</form>
</div>
<script type="text/javascript">


function uploadDone(){
	var filename = _response.filename;
	
	$('div.image').css('background','url("uploads/profile/'+filename+'") no-repeat');
	$('div.image').css('background-size','cover');
	$('div.image').css('background-position','center center');
	$('div.image i').hide();
	$('input.photo').val(filename);

}
</script>


<form method="post" class="submit" action="profile/edit/<?php echo $user->id; ?>/do">
	<input type="hidden" name="post" value="1" />
	<input type="hidden" name="edit_profile" value="1" />
	<input class="photo" type="hidden" name="photo" value="<?php echo $user->photo; ?>" />
	<div class="row pt-15">
		<div class="col-1-2 pr-15">
			<label class="w-150px inline-block">Email</label>
			<p><strong><?php echo $user->email; ?></strong></p>
		</div>
	</div>
	<div class="row pt-15">
		<div class="col-1-2 pr-15">
			<label class="w-150px inline-block">Name <span class="red">*</span></label>
			<input  value="<?php echo $user->firstname; ?>" class="text fw mandatory" type="text" name="firstname" class="text" />
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

	</div>
	<hr />
	<div class="align-right">
		<input type="submit" class="btn btn-primary" value="Update" />
	</div>
	
</form>

