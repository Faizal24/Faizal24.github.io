
<div class="max1280 padding">
	<h1 class="thin">Complete Tutor Signup Steps</h1>
	<div class="tutor-signup-steps">
		<div class="tutor-signup-step tutor-signup-completed-step">
			<strong>1</strong> Select teaching subjects
		</div>
		<div class="tutor-signup-step tutor-signup-completed-step">
			<strong>2</strong> How MyTutor works
		</div>
		<div class="tutor-signup-step tutor-signup-completed-step">
			<strong>3</strong> Your basic information
		</div>
		<div class="tutor-signup-step tutor-signup-current-step">
			<strong>Step 4</strong> Personalize profile
		</div>
		<div class="tutor-signup-step">
			<strong>5</strong> Terms for tutoring with us
		</div>
		<div class="tutor-signup-step">
			<strong>6</strong> Confirm your email
		</div>
		
	</div>
</div>


<div class="max1024 padding min-height-600">

		<h2>Personalize your profile</h2>
		<p>Tell us about yourself! This is your chance to stand out. Students and parents will see this information on your profile page. Need inspiration? See an example of a great tutor profile and free response.</p>

		
		<h3>1. Upload Photo</h3>
		
		<form style="height: 120px" method="post" id="formGallery" callback="uploadImageDone()" target="postframe" enctype="multipart/form-data" action="ajax/upload_image">
	
			<p>
				<div class="image" style="width: 100px; height: 100px; margin-right: 10px; border: 1px solid #ddd; border-radius: 5px; float: left;">
					<div style="text-align: center; padding-top: 40px">
						<i class="fa fa-image"></i>
					</div>
				</div>
				<label class="w-150px inline-block">Upload Image</label><br />
				<a onclick="$('.file').click()" class="btn btn-primary">Select Image</a>
				<input type="file" class="file change-submit" name="file" style="display: none;" />
				
			</p>
		</form>
		
		
		
<script type="text/javascript">


function uploadImageDone(){
	var filename = _response.filename;
						
	$('div.image').css('background','url("uploads/profile/'+filename+'") no-repeat');
	$('div.image').css('background-size','cover');
	$('div.image').css('background-position','center center');
	$('div.image i').hide();
	$('input.image').val(filename);

}
	
</script>
		
	<form method="post" action="tutor/submit_complete_signup/4">
		<input type="hidden" name="image" class="image" />
		<h3>2. About Me</h3>
		<textarea class="textarea" name="about"></textarea>
		
		<h3>3. Rates</h3>
		
		<table class="grid table-spaced">
			<thead>
				<tr>
					<th>Subject</th>
					<th style="width: 100px">Grade</th>
					<th style="width: 150px">Rate (RM)</th>
				</tr>
			</thead>
			<tbody>
				

		<?php foreach ($this->user->Tutor_subjects($this->user->data()) as $subject): ?>

			<tr>
				<td><?php echo $subject->subject; ?></td>
				<td class="align-center"><?php echo $subject->grade; ?></td>
				<td><input style="width: 140xp" type="text" class="text" name="rate[<?php echo $subject->id; ?>]" /></td>
			</tr>
		<?php endforeach; ?>
			</tbody>
		</table>
		
		<hr />
		<p class="align-right"> 
			<button class="btn btn-primary">Next Step</button>
		</p>


	</form>
</div>
