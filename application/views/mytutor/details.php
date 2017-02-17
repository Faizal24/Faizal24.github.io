

<?php
	$me = $this->user->data();
?>


<div class="spacer"></div>
<div class="spacer"></div>
<div class="max1024 padding min-height-600">
	<div class="tutor-request-action-box">
		<p class="align-center"><strong>Status: <span class="status status-<?php echo class_name(strtolower($request->status)); ?>"><?php echo $request->status; ?></span></strong></p>
		
		
		<?php if ($request->status == 'Pending Payment'): ?>
			<a href="mytutor/checkout/<?php echo $request->id; ?>" class="btn mb-5 align-center btn-block btn-green">Checkout</a>
		<?php endif; ?>
		
		


		<ul class="list-action">
			<?php if ($request->status == 'Hired'): ?>
				<li><a href="messenger/chat_with_user/<?php echo $tutor->id; ?>"><i class="fa fa-envelope"></i>  Message tutor</a></li>
				<li><a href="mytutor/review/<?php echo $tutor->id; ?>/<?php echo $request->id; ?>"><i class="fa fa-star-half-o"></i> 
					<?php if ($this->user->has_been_reviewed($tutor->email)): ?>
						My Review				
					<?php else: ?>
						Write a review
					<?php endif; ?>
					
				</a></li>			
			<?php else: ?>
				<li><i class="fa fa-lock"></i> <i class="fa fa-envelope"></i> Message tutor</li>
				<li><i class="fa fa-lock"></i> <i class="fa fa-star-half-o"></i> Write a review</li>

			<?php endif; ?>
			<li><a href="mytutor/suggest_to_friends/<?php echo $tutor->id; ?>"><i class="fa fa-bullhorn"></i> Suggest to friends</a></li>
		</ul>
	
	</div>
	
	<div class="tutor-profile-photo tutor-pp-<?php echo class_name(strtolower($request->status)); ?>" style="background-image: url('uploads/profile/<?php echo $tutor->photo; ?>')"></div>
	<div class="tutor-details">
		<h2>Hi, I'm <?php echo $tutor->firstname; ?> <?php echo $tutor->lastname; ?> <i class="icon-<?php echo strtolower($tutor->gender); ?>"></i></h2>
		<h3 class="thin">I'm your <?php echo $request_data->subject; ?> Tutor</h3>
		
		
		<p>
			<strong class="primary">Student Name</strong><br />
			<?php echo $request_data->student_name; ?>, <?php echo $request_data->student_age; ?> 
			<i class="icon-<?php echo strtolower($request_data->student_gender); ?>"></i>

		</p>	
		

		<p>
			<strong class="primary">Grade</strong><br />
			<?php echo $request_data->grade; ?><br /><br />
		</p>
		

		<p>
			<strong class="primary">Address</strong><br />
			<?php echo $request_data->address1; ?><br />
			<?php echo $request_data->address2; ?><br />
			<?php echo $request_data->city; ?><br />
		</p>
		
		<div class="spacer"></div>


		
		<div class="booked-session">

			<?php if (count($sessions)): ?>				
			<span class="booked-session-count">0/<?php echo $request_data->sessions; ?></span>
		<?php else: ?>
			<span class="booked-session-count">0/<?php echo $request_data->sessions; ?> <i class="fa fa-lock"></i></span>				
		<?php endif; ?>
				
		<h3 class="primary">Booked Session</h3>

				<?php if (count($sessions)): ?>
				
				
				<table class="booked-session booked-<?php echo class_name(strtolower($request->status)); ?>">

					<tr>
						<?php foreach ($sessions as $session): ?>
						<td class="outline outline-<?php echo class_name(strtolower($session->status)); ?>"><?php echo date('j/n', strtotime($session->date)); ?></td>
						<?php endforeach; ?>
					</tr>
					<tr>
						<?php foreach ($sessions as $session): ?>
						<td class="not-booked outline-<?php echo class_name(strtolower($session->status)); ?>"><?php echo date('D', strtotime($session->date)); ?></td>
						<?php endforeach; ?>
					</tr>
					<tr>
						<?php foreach ($sessions as $session): ?>
						<td class="outline outline-<?php echo class_name(strtolower($session->status)); ?>"><?php echo date('g:i A', strtotime($session->time)); ?></td>
						<?php endforeach; ?>
					</tr>
				</table>
				<?php else: ?>
				
				<table class="booked-session">
					<tr>
						<?php for ($i = 0; $i < $request_data->sessions; $i++): ?>
						<td class="outline">Date</td>
						<?php endfor; ?>
					</tr>
					<tr>
						<?php for ($i = 0; $i < $request_data->sessions; $i++): ?>
						<td class="not-booked">Day</td>
						<?php endfor; ?>
					</tr>
					<tr>
						<?php for ($i = 0; $i < $request_data->sessions; $i++): ?>
						<td class="outline">Time</td>
						<?php endfor; ?>
					</tr>
				</table>
				<?php endif; ?>
			</div>

		
	</div>

	
					
</div>
<?php if ($this->user->is_logged_in()): ?>

<iframe name="postframe" id="postframe" class="none"></iframe>
		
<div class="request-step-1 overlay-form">
	<div id="request-step-1">
		<form method="post">
			<a class="close-form">&times;</a>
			<h1>Get ready to hire <br /><?php echo $tutor->firstname; ?> <?php echo $tutor->lastname; ?> as your tutor.</h1>
				
			<div class="align-center">
				<div class="general-profile-photo" style="background-image: url('uploads/profile/<?php echo $tutor->photo; ?>')"></div>
				<i class="fa fa-link large-font"></i>
				<div class="general-profile-photo" style="background-image: url('uploads/profile/<?php echo $me->photo ? $me->photo : 'default.jpg'; ?>')"></div>
			</div>

			<div class="align-center padding">
				Our tutor needs to know a little bit about yourself before they can decide whether to accept your lesson request.
				<br />
				You'll only have to do this once
			</div>
			<input type="submit" class="btn btn-primary" value="Next" />
		</form>
	</div>
</div>

<div class="request-step-2 overlay-form">
	<div id="request-step-2">

		<form method="post" action="profile/upload_photo"  method="post" target="postframe" enctype="multipart/form-data">
			<input class="none photo" type="file" name="file" />
			<a class="close-form">&times;</a>
			<h1>Add your profile photo.</h1>
				
			<div class="align-center padding upload-photo-notice">
				Put a photo to your name so your tutor know it's you
			</div> 
			
			<div class="align-center">
				<div class="general-profile-photo upload-photo" style="background-image: url('uploads/profile/<?php echo $me->photo ? $me->photo : 'default.jpg'; ?>')"></div>
			</div>
			<div class="spacer"></div>
			<button class="btn btn-secondary upload-photo"><i class="fa fa-cloud-upload"></i> Upload Photo</button>
			<button class="btn btn-primary btn-done none">Continue</button>
		</form>
	</div>
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
		$('#request-step-2 h1').text("It looks great!");
		$('#request-step-2 div.upload-photo-notice').text('Thanks for putting a photo.');
		$('button.upload-photo').html('<i class="fa fa-cloud-upload"></i> Change Photo').css('margin-bottom','0');
		$('button.btn-done').removeClass('none');
		
	} else {
		$('#request-step-2 h1').text("Add your profile photo.");
		$('#request-step-2 div.upload-photo-notice').text('Error uploading photo. Please make sure ');
		$('button.upload-photo').html('<i class="fa fa-cloud-upload"></i> Change Photo');
		
	}
}
	
</script>


<div class="request-step-3 overlay-form">
	<div id="request-step-3">
		<form method="post" action="tutor/request" target="postframe">
			<input type="hidden" name="tutor_id" value="<?php echo $tutor->id; ?>" />
			<input type="hidden" name="request_data[subject]" class="request_subject" />
			<input type="hidden" name="request_data[grade]" class="request_grade" />
			<input type="hidden" name="request_data[hours]" class="request_hours" />
			
			<a class="close-form">&times;</a>
			<h1>One step away!</h1>
					
			<div class="align-center padding">
				Tell us what is your child name and your home address that you wish the lesson to be held.
			</div> 
			
			<div class="input"><input type="text" name="request_data[student_name]" placeholder="Student Name" class="block text w100" /></div>
			<div class="input"><input type="text" name="request_data[address1]" placeholder="Home address 1" class="block text w100" /></div>
			<div class="input"><input type="text" name="request_data[address2]" placeholder="Home address 2" class="block text w100" /></div>
			<div class="input"><input type="text" id="cities-autocomplete" name="request_data[city]" placeholder="City" class="block text w100" /></div>

			
			<div class="spacer"></div>

			<input type="submit" class="btn btn-primary btn-request" value="Send Request" />
		</form>
	</div>
</div>

<script type="text/javascript">
	
$(document).ready(function(){
	$('input.btn-request').click(function(e){
		$(this).val('Submitting request...');
	})
})

function requestSubmitted(status, data){
	if (status == 1){
		$('.request-step-3').hide();
		$('.request-completed').show();
	} else {
		
	}
}
	
	
</script>

<div class="request-completed overlay-form">
	<div id="request-completed">
		<form method="post">
			<h1>Lesson Request Sent</h1>
					
			<div class="align-center padding">
				<?php echo $tutor->firstname; ?> <?php echo $tutor->lastname; ?> will respond to your request shortly. You can now view this tutor status at <strong>My Tutor</strong> menu.
			</div> 
			
			<input type="submit" class="btn btn-primary" value="Done" />
		</form>
	</div>
</div>




<?php endif; ?>