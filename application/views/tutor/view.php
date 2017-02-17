<?php
	$me = $this->user->data();
?>

<script type="text/javascript">

var pp = <?php echo $me->photo ? '1' : '0'; ?>;

$(document).ready(function(){
	
	$('select[name=subject_grade]').change(function(){
		$('select.hours').change();
	})
	
	$('select.hours').change(function(){
		var sub_grade = $('select[name=subject_grade]').val();
		var sub_grade_array = sub_grade.split('|');
		var sessions = parseInt($('select[name=sessions]').val());
		var rate = parseFloat(sub_grade_array[2]) / 100;
		var hours = parseFloat($(this).val());
		var subtotal = rate * hours * sessions;
		var gst = subtotal * (6 / 100);
		var total = subtotal + gst;

		$('.tutor-rate').html(rate);
		$('.val-subtotal').text(subtotal.toFixed(2));
		$('.val-gst').text(gst.toFixed(2));
		$('.val-total').text(total.toFixed(2));
	})
	
	$('select[name=sessions]').change(function(){
		$('.session-count').html($(this).val());
		$('select.hours').change();
	})
	
	$('select.hours').change();
	
	$('.request-lesson').click(function(e){
		e.preventDefault();
		$('.request-step-1').show();
		
		var sub_grade = $('select[name=subject_grade]').val();
		var hours = $('select[name=hours]').val();
		var sessions = $('select[name=sessions]').val();
		
		var sub_grade_array = sub_grade.split('|');
		$('input.request_grade').val(sub_grade_array[0]);
		$('input.request_subject').val(sub_grade_array[1]);
		$('input.request_rate').val(sub_grade_array[2]);
		$('input.request_hours').val(hours);
		$('input.request_sessions').val(sessions)
	})
	
	$('#request-step-1 .btn-primary').click(function(e){
		e.preventDefault();
		$('.request-step-1').hide();
		if (pp == 1){
			$('.request-step-3').show();					
		} else {
			$('.request-step-2').show();		
		}
	})
	
	$('#request-step-2 .btn-done').click(function(e){
		e.preventDefault();
		$('.request-step-2').hide();
		$('.request-step-3').show();
	})
	
	
	$('#request-completed .btn-primary').click(function(e){
		e.preventDefault();
		location.href = 'mytutor'
	})
})
	
</script>

<div class="spacer"></div>
<div class="spacer"></div>
<div class="max1280 padding">
	<div class="tutor-request-box">
		<h2>RM<span class="tutor-rate"><?php echo $tutor->rate; ?></span>/hour</h2>

			<?php
				foreach ($tutor->subjects as $s){
					$subjects[$s->grade.'|'.$s->subject.'|'.str_replace('.','',$s->rate)] = $s->grade . ' &mdash; ' . $s->subject ;
					
					if ($s->grade.'|'.$s->subject == $search_subject_grade){
						$search_subject_grade = $s->grade.'|'.$s->subject.'|'.str_replace('.','',$s->rate);
					}
				}
				
			?>
			
		<table class="w100">
			<tr>
				<td style="width: 150px">Choose subject/grade</td>
				<td>
					<?php
						list($grade, $subject, $rate) = explode('|', $search_subject_grade);
					?>
					<?php echo $subject; ?> &mdash; <?php echo $grade; ?>
					<?php echo form_dropdown('subject_grade', $subjects, $search_subject_grade,'style="width: 150px; display:none"'); ?>
				</td>
			</tr>
			<tr>
				<td>Choose hours per lesson</td>
				<td><?php echo form_dropdown('hours', array('1 hour'=>'1 Hour','1.5 hours'=>'1.5 Hours','2 hours'=>'2 Hours','2.5 hours'=>'2.5 Hours','3 hours'=>'3 Hours'), $search_hours,'class="hours" style="width: 150px"'); ?></td>
			</tr>
			<tr>
				<td>Choose number of sessions</td>
				<td><?php echo form_dropdown('sessions', array(2=>'2 Sessions',3=>'3 Sessions',4=>'4 Sessions',5=>'5 Sessions'), 5,'class="sessions" style="width: 150px"'); ?></td>					
			</tr>
		</table>
		 
		
		 

		<hr />
				
		<table class="w100">
			<tr>
				<td>RM<span class="tutor-rate"><?php echo $tutor->rate; ?></span> &times; <span></span> hour(s) &times; <span class="session-count">5</span> sessions</td>
				<td class="align-right"><span class="val-subtotal"></span></td>
			</tr>
			<tr>
				<td>GST</td>
				<td class="align-right"><span class="val-gst"></span></td>
			</tr>
			<tr>
				<td><strong>Total</strong></td>
				<td class="align-right"><strong class="val-total"></strong></td>
			</tr>
		</table>
		
		<div class="spacer"></div>
		<div class="tutor-view">
			<a class="btn w100 block border-box align-center btn-primary <?php if ($this->user->is_logged_in()) echo 'request-lesson'; else echo 'signup-btn'; ?>" href="#">Request Lesson</a>
		</div>
	</div>
	
	<div class="tutor-profile-photo" style="background-image: url('uploads/profile/<?php echo $tutor->photo; ?>')"></div>
	<div class="tutor-details">
		<h2>Hi, I'm <?php echo $tutor->firstname; ?> <?php echo $tutor->lastname; ?> <i class="icon-<?php echo strtolower($tutor->gender); ?>"></i></h2>
		<div>
			<div class="primary">
			<?php for ($i = 0; $i < round($tutor->review_rating); $i++): ?>
			<i class="fa fa-star"></i>
			<?php endfor; ?>
			<?php for ($i = 0; $i < 5 - round($tutor->review_rating); $i++): ?>
			<i class="fa fa-star-o"></i>			
			<?php endfor; ?>
			
			&nbsp; <?php echo number_format($tutor->review_rating,1); ?>
			(<?php echo $tutor->review_count == 1 ? $tutor->review_count . ' review' : $tutor->review_count . ' reviews'; ?>)
			</div>

		</div>
		
		
		<h3 class="primary">About Me</h3>
		<p><?php echo nl2br($tutor->about); ?></p>	
		
		<div class="spacer"></div>
		
		<div class="profile-attributes">
			<h3 class="primary">Qualification</h3>
			<div class="attribute-content">
			<?php $q = json_decode($tutor->education); ?>
			<?php for ($i = 0; $i < count($q->institution); $i++): ?>
				<p><?php echo $q->certificate[$i]; ?>, <?php echo $q->institution[$i]; ?> &mdash; <?php echo $q->year[$i]; ?></p>
			<?php endfor; ?>
			</div>
		</div>
		
		<hr />

		<div class="profile-attributes">		
			<h3 class="primary">ID Verification</h3>
			<div class="attribute-content">
				<table style="font-size: 8pt">
					<tr>
						<td style="width: 70px; text-align: center; vertical-align: top">
							<img style="height: 50px" src="images/ver-cert.png" /><br />
							Certificate of Graduation
						</td>
						<td style="width: 70px; text-align: center; vertical-align: top">		
							<img style="height: 50px"  src="images/ver-ic.png" /><br />
							Identity Card (IC)
						</td>
						<td style="width: 70px; text-align: center; vertical-align: top">
							<img style="height: 50px"  src="images/ver-phone.png" /><br />
							Phone number
						</td>
						<td style="width: 70px; text-align: center; vertical-align: top">
							<img style="height: 50px"  src="images/ver-test.png" /><br />
							Passed interview and tests
						</td>
					</tr>
				</table>
			</div>
		</div>
		
		
		<hr />
		
		<div class="profile-attributes">
			<h3 class="primary">Language</h3>
			<div class="attribute-content">
				<p><?php echo str_replace(',', '<br />', $tutor->languages); ?></p>
			</div>
		</div>
		<hr />
		<div class="profile-attributes">
			<h3 class="primary">Policies</h3>
			<div class="attribute-content">
				<p>Lesson Cancellation: 12 hours of notice required. Your first lession with this tutor is backed by our GOOD FIT GUARANTEE</p>
			</div>
		</div>
		
		<hr />
		
		<!--
		<div class="spacer"></div>
		<h3 class="primary">Subjects</h3>
		<ul class="list">	
			<?php foreach ($tutor->subjects as $subject): ?>
			<li><?php echo $subject->grade; ?> &mdash; <?php echo $subject->subject; ?></li>
			<?php endforeach; ?>
		</ul>
		-->
		
		
		<!--
		<div class="spacer"></div>
		<h3 class="primary">Availability</h3>
				<?php 
					$pt = explode(',',$tutor->availability); 
				?>
				<div class=" preferred-time profile-time">
					<table>
						<thead>
						<tr>
							<th></th>
							<th>Sun</th>
							<th>Mon</th>
							<th>Tue</th>
							<th>Wed</th>
							<th>Thu</th>
							<th>Fri</th>
							<th>Sat</th>
																						</tr>
						</thead>
						<tbody>
						<tr>
							<td>8am - 12pm</td>
							<td class="align-center"><span<?php if (in_array('Sun - Morning', $pt)) echo ' class="selected"'; ?>>Sun - Morning</span></td>
							<td class="align-center"><span<?php if (in_array('Mon - Morning', $pt)) echo ' class="selected"'; ?>>Mon - Morning</span></td>
							<td class="align-center"><span<?php if (in_array('Tue - Morning', $pt)) echo ' class="selected"'; ?>>Tue - Morning</span></td>
							<td class="align-center"><span<?php if (in_array('Wed - Morning', $pt)) echo ' class="selected"'; ?>>Wed - Morning</span></td>
							<td class="align-center"><span<?php if (in_array('Thu - Morning', $pt)) echo ' class="selected"'; ?>>Thu - Morning</span></td>
							<td class="align-center"><span<?php if (in_array('Fri - Morning', $pt)) echo ' class="selected"'; ?>>Fri - Morning</span></td>
							<td class="align-center"><span<?php if (in_array('Sat - Morning', $pt)) echo ' class="selected"'; ?>>Sat - Morning</span></td>
						</tr>
						<tr>
							<td>12am - 6pm</td>
							<td class="align-center"><span<?php if (in_array('Sun - Afternoon', $pt)) echo ' class="selected"'; ?>>Sun - Afternoon</span></td>
							<td class="align-center"><span<?php if (in_array('Mon - Afternoon', $pt)) echo ' class="selected"'; ?>>Mon - Afternoon</span></td>
							<td class="align-center"><span<?php if (in_array('Tue - Afternoon', $pt)) echo ' class="selected"'; ?>>Tue - Afternoon</span></td>
							<td class="align-center"><span<?php if (in_array('Wed - Afternoon', $pt)) echo ' class="selected"'; ?>>Wed - Afternoon</span></td>
							<td class="align-center"><span<?php if (in_array('Thu - Afternoon', $pt)) echo ' class="selected"'; ?>>Thu - Afternoon</span></td>
							<td class="align-center"><span<?php if (in_array('Fri - Afternoon', $pt)) echo ' class="selected"'; ?>>Fri - Afternoon</span></td>
							<td class="align-center"><span<?php if (in_array('Sat - Afternoon', $pt)) echo ' class="selected"'; ?>>Sat - Afternoon</span></td>
						</tr>
						<tr>
							<td>6pm - 11pm</td>
							<td class="align-center"><span<?php if (in_array('Sun - Evening', $pt)) echo ' class="selected"'; ?>>Sun - Evening</span></td>
							<td class="align-center"><span<?php if (in_array('Mon - Evening', $pt)) echo ' class="selected"'; ?>>Mon - Evening</span></td>
							<td class="align-center"><span<?php if (in_array('Tue - Evening', $pt)) echo ' class="selected"'; ?>>Tue - Evening</span></td>
							<td class="align-center"><span<?php if (in_array('Wed - Evening', $pt)) echo ' class="selected"'; ?>>Wed - Evening</span></td>
							<td class="align-center"><span<?php if (in_array('Thu - Evening', $pt)) echo ' class="selected"'; ?>>Thu - Evening</span></td>
							<td class="align-center"><span<?php if (in_array('Fri - Evening', $pt)) echo ' class="selected"'; ?>>Fri - Evening</span></td>	
							<td class="align-center"><span<?php if (in_array('Sat - Evening', $pt)) echo ' class="selected"'; ?>>Sat - Evening</span></td>
						</tr>
					
						</tbody>
					</table>
				</div>	
		-->
		
		<div class="spacer"></div>
		<h3 class="primary">Reviews</h3>
		<?php
			$reviews = $this->job->reviews($tutor->email);
		?>
		<?php foreach ($reviews as $review): ?>
			<?php $user = $this->user->email($review->user_email); ?>
			
			<div>
				<div class="tutor-profile-photo" style="width: 50px; height: 50px; float: left; background-image: url('uploads/profile/<?php echo $user->photo; ?>')"></div>	
				<div style="padding-left: 70px; padding-top: 10px;">
					<strong><?php echo $user->firstname; ?> <?php echo $user->lastname; ?></strong>
					<div class="primary" style="padding: 10px 0">
					<?php for ($i = 0; $i < round($review->rating); $i++): ?>
					<i class="fa fa-star"></i>
					<?php endfor; ?>
					<?php for ($i = 0; $i < 5 - round($review->rating); $i++): ?>
					<i class="fa fa-star-o"></i>			
					<?php endfor; ?>
					</div>
					

					
					<p>
						<?php echo nl2br($review->review); ?>
					</p>
									<small>	Posted <?php echo ago(strtotime($review->datetime)); ?></small>
				</div>
				<hr />
			</div>
			
		<?php endforeach; ?>
		
		<?php if (!count($reviews)): ?>
		<p><i>No reviews so far</i></p>
		<?php endif; ?>
		
		<div class="spacer"></div>

		
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
			<input type="hidden" name="request_data[rate]" class="request_rate" />
			<input type="hidden" name="request_data[grade]" class="request_grade" />
			<input type="hidden" name="request_data[hours]" class="request_hours" />
			<input type="hidden" name="request_data[sessions]" class="request_sessions" />
			
			<a class="close-form">&times;</a>
			<h1>One step away!</h1>
					
			<div class="align-center padding">
				Tell us what is your child name and your home address that you wish the lesson to be held.
			</div> 
			
			<div class="input"><input type="text" name="request_data[student_name]" placeholder="Student Name" class="block text w100" /></div>
			<div class="input"><input type="text" name="request_data[student_age]" placeholder="Age" class="block text w100" /></div>
			<div class="input"><?php echo form_dropdown('request_data[student_gender]', array(''=>'Select Gender','Male'=>'Male','Female'=>'Female'), '', 'class="block w100"'); ?></div>
			<div class="input"><input type="text" name="request_data[address1]" placeholder="Home address 1" class="block text w100" /></div>
			<div class="input" style="padding: 5px">
				Location: <?php echo $search_city; ?>
				<input value="<?php echo $search_city; ?>" type="hidden" name="request_data[city]" placeholder="City" class="block text w100" />
			</div>

			
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