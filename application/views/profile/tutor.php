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
	<div style="padding-left: 180px; width: 800px">
		<p>
			<label>Email</label><br />
			<strong><?php echo $me->email; ?></strong>
		</p>
		<p>
			<label>Firstname</label><br />
			<strong><?php echo $me->firstname; ?></strong>
		</p>
		<p>
			<label>Lastname</label><br />
			<strong><?php echo $me->lastname; ?></strong>
		</p>
		<p>
			<label>Mobile</label><br />
			<input value="<?php echo $me->mobile; ?>" type="text" class="text w50" name="mobile" />
		</p>
		
		<p>
			<label>Address<br />
			<input value="<?php echo $tutor->address1; ?>" type="text" placeholder="Address 1" name="address1" class="text w50" value="" /><br />
			<input value="<?php echo $tutor->address2; ?>" type="text" placeholder="Address 2 (Optional)" name="address2" class="text w50" value="" /><br />
			<input value="<?php echo $tutor->zipcode; ?>" type="text" placeholder="Zipcode" name="zipcode" class="text w24" value="" style="margin-right: 16px; margin-bottom: 8px" /> 
			<input value="<?php echo $tutor->city; ?>" type="text" placeholder="City" name="city" class="text w24" value="" /><br />
			<?php echo form_dropdown('state',$this->system->get_states(true), $tutor->state, 'class="dropdown w24" style="margin-right: 16px;"'); ?>
			<?php echo form_dropdown('country',$this->system->get_countries(true), $tutor->country ? $tutor->country : 'Malaysia', 'class="dropdown w24"'); ?>
			</label>
		</p>

		<p>
			<label>Occupation<br />
			<input value="<?php echo $tutor->occupation; ?>" type="text" name="occupation" class="text w50" value="" />
			</label>
		</p>
		
		<p>
			<label>Banking information <br />
			<input value="<?php echo $tutor->bank_account_number; ?>" type="text" name="bank_account_no" placeholder="Bank Account Number" class="text w50" value="" />
			<input value="<?php echo $tutor->bank_name; ?>" type="text" name="bank_name" placeholder="Bank Name" class="text w50" value="" />
			</label>
		</p>
		
		<br /><br />
		<h2>Totoring locations</h2>
		<p>Please enter the city location you are willing to travel for tutoring.</p>
		<hr />

			<input style="width: 350px" cb="addcity" name="a" id="cities-autocomplete" type="text" class="text" placeholder="Enter city" />
			<ul class="city-list">
				<?php foreach (explode(',', $tutor->locations) as $location): ?>
				<li><i onclick="$(this).parents('li').remove()" class="fa fa-trash"></i> <input style="display:none" type="hidden" name="locations[]" value="<?php echo $location; ?>" /> <?php echo $location; ?></li>
				<?php endforeach; ?>
			</ul>
			<script type="text/javascript">
				
				function addcity(city){
					$('#cities-autocomplete').focus().val('');
					$('.city-list').append('<li><i onclick="$(this).parents(\'li\').remove()" class="fa fa-trash"></i> <input style="display:none" type="hidden" name="locations[]" value="'+city+'" />'+city+' </li>');
				}
				$(document).ready(function(){
					
				})				
			</script>
		<hr />
		<br /><br />
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
