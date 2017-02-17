<script type="text/javascript">
	$(document).ready(function(){
		initializeCitiesAutocomplete();
	})
</script>

<a href="tutors" class="link btn btn-primary float-right btn-large"><i class="fa fa-arrow-left"></i> Back</a>

<h1 class="main-separator-blue-tint">Tutors &raquo; New Tutor</h1>


<div style="width: 300px">
	<form method="post" callback="uploadDone()" target="postframe" enctype="multipart/form-data" action="profile/upload_photo">

		<p>
			<div class="image" style="width: 56px; height: 56px; margin-right: 10px; border: 1px solid #ddd; border-radius: 5px; float: left; background: url('uploads/profile/<?php echo $tutor->photo; ?>') no-repeat; background-size: cover;  background-position: center center;">
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


<form method="post" class="submit" action="tutors/add">
	
	<input class="photo" type="hidden" name="photo" value="<?php echo $tutor->photo; ?>" />
	<input type="hidden" name="submit" value="1" />
	
	<h3 class="form-subheading">Account Information</h3>
	<hr />
	
	<div class="row pt-15">
		<div class="col-1-2 pr-15">
			<label class="grey uppercase small w-150px inline-block">First name <span class="red">*</span></label>
			<input value="<?php echo $tutor->firstname ? $this->input->post('firstname') : $tutor->firstname; ?>" class="text fw mandatory" type="text" name="firstname" class="text" />
			<?php if ($error['firstname']): ?>
			<small class="red"><?php echo $error['firstname']; ?></small>
			<?php endif; ?>

		</div>
		<div class="col-1-2 pl-15">
			<label class="grey uppercase small w-150px inline-block">Last name</label>
			<input value="<?php echo $tutor->lastname ? $this->input->post('lastname') : $tutor->lastname; ?>" class="text fw" type="text" name="lastname" />	
		</div>
	</div>
	<div class="row pt-15">
		<div class="col-1-2 pr-15">
			<label class="grey uppercase small w-150px inline-block">Email <span class="red">*</span></label>
			<input value="<?php echo $tutor->email ? $this->input->post('email') : $tutor->email; ?>" class="text fw mandatory" type="text" name="email" />	
			<?php if ($error['email']): ?>
			<small class="red"><?php echo $error['email']; ?></small>
			<?php endif; ?>

		</div>
		<div class="col-1-2 pl-15">
			<label class="grey uppercase small inline-block">Password <span class="red">*</span></label>
			<input class="text fw mandatory" type="password" name="password" class="text" />
			<?php if ($error['password']): ?>
			<small class="red"><?php echo $error['password']; ?></small>
			<?php endif; ?>
		</div>
	</div>
	<div class="row pt-15">
		<div class="col-1-2 pr-15">
			<label class="grey uppercase small w-150px inline-block">Mobile</label>
			<input value="<?php echo $tutor->mobile ? $this->input->post('mobile') : $tutor->mobile; ?>" class="text fw" type="text" name="mobile" />	
		</div>
	</div>
	
	<div class="spacer"></div>
	
	<h3 class="form-subheading">Personal Details</h3>
	<hr />
	<div class="row pt-15">
		<div class="col-1-2 pr-15">
			<label class="grey uppercase small w-150px inline-block">Gender</label>
			<?php echo form_dropdown('gender', array('Select','Male'=>'Male','Female'=>'Female'), $tutor->gender ? $this->input->post('gender') : $tutor->gender,'class="fw"'); ?>
		</div>
	</div>
	<div class="row pt-15">
		<div class="col-1-2 pr-15">
			<label class="grey uppercase small w-150px inline-block">NRIC / Passport <span class="red">*</span></label>
			<input value="<?php echo $tutor->nric ? $this->input->post('nric') : $tutor->nric; ?>" class="text fw mandatory" type="text" name="nric" />	
		</div>
	</div>
	<div class="row pt-15">
		<div class="col-1-2 pr-15">
			<label class="grey uppercase small w-150px inline-block">Address 1</label>
			<input value="<?php echo $tutor->address1 ? $this->input->post('address1') : $tutor->address1; ?>" class="text fw" type="text" name="address1" />	
		</div>
	</div>
	<div class="row pt-15">
		<div class="col-1-2 pr-15">
			<label class="grey uppercase small w-150px inline-block">Address 2</label>
			<input value="<?php echo $tutor->address2 ? $this->input->post('address2') : $tutor->address2; ?>" class="text fw" type="text" name="address2" />	
		</div>

	</div>
	<div class="row pt-15">
		<div class="col-1-2 pr-15">
			<label class="grey uppercase small w-150px inline-block">City</label>
			<input id="cities-autocomplete" value="<?php echo $tutor->city ? $this->input->post('city') : $tutor->city; ?>" class="text fw" type="text" name="city" />	
		</div>
	</div>
	<div class="row pt-15">
		<div class="col-1-2 pr-15">
			<label class="uppercase grey small inline-block">State / Province</label>
			<?php echo form_dropdown('state', $this->system->dropdown_states('Select'), $tutor->state ? $this->input->post('state') : $tutor->state,'class="fw" id="state-autocomplete"'); ?>
		</div>		
	</div>
	<div class="row pt-15">
		<div class="col-1-2 pr-15">
			<label class="uppercase grey small inline-block">Country</label>
			<?php echo form_dropdown('country', array('Malaysia'=>'Malaysia'), $tutor->country ? $this->input->post('country') : $tutor->country,'class="fw" id="country-autocomplete"'); ?>
		</div>
	</div>

	<div class="spacer"></div>
	
	<h3 class="form-subheading">Tutor Profile</h3>
	<hr />
	<div class="row pt-15">
		<div class="col-1-2 pr-15">
			<label class="grey uppercase small w-150px inline-block">About Tutor</label>
			<textarea class="text fw h100" name="about"><?php echo $tutor->about ? $this->input->post('about') : $tutor->about; ?></textarea>	
		</div>
		<div class="col-1-2 pl-15">
			<label class="grey uppercase small w-150px inline-block">Qualification(s)</label>
			<textarea class="text fw h100" name="qualification"><?php echo $tutor->qualification ? $this->input->post('qualification') : $tutor->qualification; ?></textarea>	
		</div>
	</div>
	<div class="row pt-15">
		<div class="col-1-2 pr-15">
			<label class="grey uppercase small w-150px inline-block">Institution(s)</label>
			<textarea class="text fw h100" name="institution"><?php echo $tutor->institution ? $this->input->post('institution') : $tutor->institution; ?></textarea>	
		</div>
		<div class="col-1-2 pl-15">
			<label class="grey uppercase small w-150px inline-block">Rate per hour</label>
			<input value="<?php echo $this->input->post('rate')? $this->input->post('rate') : $tutor->rate; ?>" class="text fw" type="text" name="rate" />	
		</div>
	</div>
	<div class="row pt-15">
		<div class="col-1-2 pr-15">
			<label class="grey uppercase small w-150px inline-block">Subject(s)</label><br />
			<?php foreach ($this->system->get_subjects() as $subject): ?>
			<div class="pt-5"><label><input name="subject[]" type="checkbox" value="<?php echo $subject->value; ?>|<?php echo $subject->grade; ?>"> <?php echo $subject->value; ?></label></div>
			<?php endforeach; ?>
		</div>

	</div>

	
	<br /><br />
	<hr />

	<div class="align-right">
		<input type="submit" class="btn btn-primary" value="Save" />
	</div>
	
	<div class="spacer"></div>
	<div class="spacer"></div>
	
</form>