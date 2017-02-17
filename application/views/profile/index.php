<?php
$me = $this->user->data();	
?>

<div class="max1280 padding">
	<h1 class="thin">My Profile</h1>
</div>

<div class="grey-bg">
<div class="max1024 padding min-height-600">
	
	<?php if ($this->session->flashdata('profile_updated')): ?>
	<p class="success">Profile has been updated.</p>
	<?php endif; ?>
	
	<div style="width: 130px; float: left;">
		<form method="post" action="profile/upload_photo"  method="post" target="postframe" enctype="multipart/form-data">
			<input class="none photo" type="file" name="file" />			
			<div class="align-center">
				<div class="general-profile-photo upload-photo" style="height: 130px; width: 130px; border-radius:0 !important; background-image: url('uploads/profile/<?php echo $me->photo ? $me->photo : 'default.jpg'; ?>')">
					<button style="float: right; margin-top: 10px; margin-right: 10px" class="btn upload-photo"><i class="fa fa-upload"></i></button>
				</div>
			</div>
			<div class="spacer"></div>

		</form>
	</div>
	<form method="post" action="profile/update">
	<div style="padding-left: 180px; width: 500px">
		<p>
			<label>Email</label><br />
			<strong><?php echo $me->email; ?></strong>
		</p>
		<p>
			<label>Firstname</label><br />
			<input value="<?php echo $me->firstname; ?>" type="text" class="text fw" name="firstname" />
		</p>
		<p>
			<label>Lastname</label><br />
			<input value="<?php echo $me->lastname; ?>" type="text" class="text fw" name="lastname" />
		</p>
		<p>
			<label>Mobile</label><br />
			<input value="<?php echo $me->mobile; ?>" type="text" class="text fw" name="mobile" />
		</p>
		<hr />
		<h3>Change Password</h3>
		<p>
			<label>Enter old password</label><br />
			<input value="" type="password" class="text fw" name="old_password" />
		</p>
		<p>
			<label>Enter new password</label><br />
			<input value="" type="password" class="text fw" name="new_password" />
		</p>
		<p>
			<label>Repeat new password</label><br />
			<input value="" type="password" class="text fw" name="repeat_password" />
		</p>
			
		<p class="align-right">
			<input type="submit" class="btn btn-primary" name="submit" value="Update Profile" />
		</p>

	</div>
	</form>
</div>


<script type="text/javascript">

$(document).ready(function(){
	$('button.upload-photo').click(function(e){
		e.preventDefault();
		$('input.photo').click();
	})
	
	$('input.photo').change(function(){
		$('button.upload-photo').text('Uploading...');
		$(this).parents('form').submit();
	})
})

function formSubmitted(status, data){
	if (status == 1){
		$('div.upload-photo').css('background-image','url('+data.filename+')');
		
	} else {
		
	}
}
	
</script>
