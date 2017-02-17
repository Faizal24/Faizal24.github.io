<?php
	$me = $this->user->data();
	
	$subjects = $this->user->tutor_subjects($this->user->email($request->request_to));
	foreach ($subjects as $subject){
		if ($subject->subject == $request_data->subject && $subject->grade == $request_data->grade){
			$rate = $subject->rate;
		}
	}
?>

<script type="text/javascript">

var pp = <?php echo $me->photo ? '1' : '0'; ?>;

function getNextDayOfWeek(date, dayOfWeek) {
    // Code to check that date and dayOfWeek are valid left as an exercise ;)

    var resultDate = new Date(date.getTime());

    resultDate.setDate(date.getDate() + (7 + dayOfWeek - date.getDay()) % 7);

    return resultDate;
}

$(document).ready(function(){
	
	$('select.daytime').change(function(){
		var daytime = $(this).val();
		
		if (!daytime) return;
		var daymtime = daytime.split(' - ');
		var day = daymtime[0];
		var time = daymtime[1];
		
		
		if (day == 'Sun') dayOfWeek = 0;
		if (day == 'Mon') dayOfWeek = 1;
		if (day == 'Tue') dayOfWeek = 2;
		if (day == 'Wed') dayOfWeek = 3;
		if (day == 'Thu') dayOfWeek = 4;
		if (day == 'Fri') dayOfWeek = 5;
		if (day == 'Sat') dayOfWeek = 6;
		
		var today = new Date();
		var timemsecs = today.getTime();
		
		var i = 0;
		var week = 0;
		var session_dates = [];
		
		var tutoring_date = '';
		$('.booked-date').each(function(){

			var new_time = timemsecs + (i * (1000 * 60 * 60 * 24 * 7));
			var nextDate = getNextDayOfWeek(new Date(new_time), dayOfWeek);			
			
			$(this).text(nextDate.getDate() + '/' + (nextDate.getMonth() + 1));
			
			session_dates.push(nextDate.getFullYear() + '-' + (nextDate.getMonth() + 1) + '-' + nextDate.getDate());
			i++;
		});
		
		for (var i = 0; i < 5; i++){
			var new_time = timemsecs + (i * (1000 * 60 * 60 * 24 * 7));
			var nextDate = getNextDayOfWeek(new Date(new_time), dayOfWeek);			
			
			var xday = nextDate.getDate();
			if (xday < 10) var day_zero = '0'
			else var day_zero = '';
			
			var month = (nextDate.getMonth() + 1);
			if (month < 10) var month_zero = '0';
			else var month_zero = ''
			
			var the_date = nextDate.getFullYear() + '-' + month_zero + (nextDate.getMonth() + 1) + '-' + day_zero + xday ;
			var the_date_display = nextDate.getDate() + '/' + (nextDate.getMonth() + 1) + '/' + nextDate.getFullYear();
			tutoring_date += '<option value="'+the_date+'">'+the_date_display+'</option>'
		};
		
		$('.tutoring-date select').html(tutoring_date);
		$('.tutoring-date').show();

		$('input.session_dates').val(session_dates.join(','));
		$('input.session_time').val(time);
		
		$('.booked-time').text(time);
		$('.booked-day').text(day);
	})
	
	$('.start-tutoring-date').change(function(){
		var date = new Date($(this).val());
		var timemsecs = date.getTime();
		
		var i = 0;
		var session_dates = [];
		$('.booked-date').each(function(){

			var new_time = timemsecs + (i * (1000 * 60 * 60 * 24 * 6));
			var nextDate = getNextDayOfWeek(new Date(new_time), dayOfWeek);			
			
			
			$(this).text(nextDate.getDate() + '/' + (nextDate.getMonth() + 1));
			
			session_dates.push(nextDate.getFullYear() + '-' + (nextDate.getMonth() + 1) + '-' + nextDate.getDate());
			i++;
		});
		
		$('input.session_dates').val(session_dates.join(','));
		$('input.session_time').val(time);
		

	})
	
	$('select.hours').change(function(){
		var rate = parseFloat($('.tutor-rate').text());
		var hours = parseFloat($(this).val());
		var subtotal = rate * hours * 5;
		var gst = subtotal * (6 / 100);
		var total = subtotal + gst;
		
		$('.val-subtotal').text(subtotal.toFixed(2));
		$('.val-gst').text(gst.toFixed(2));
		$('.val-total').text(total.toFixed(2));
	})
	
	$('select.hours').change();
	
	$('.request-lesson').click(function(e){
		e.preventDefault();
		$('.request-step-1').show();
		
		var sub_grade = $('select[name=subject_grade]').val();
		var hours = $('select[name=hours]').val();
		
		var sub_grade_array = sub_grade.split('|');
		$('input.request_grade').val(sub_grade_array[0]);
		$('input.request_subject').val(sub_grade_array[1]);
		$('input.request_hours').val(hours);
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
<div class="max1024 padding min-height-600">
	
	<?php if ($error = $this->session->flashdata('checkout_error')): ?>
	<p class="error"><?php echo $error; ?></p>
	<?php endif; ?>
	
	<form method="post" action="mytutor/process_checkout/<?php echo $request->id; ?>">
		<input type="hidden" name="session_dates" class="session_dates" /> 
		<input type="hidden" name="session_time" class="session_time" /> 	
	<div class="tutor-request-box">
		
		<h2 class="thin">Booking Summary</h2>
		<p>
			<strong>Tutor Name</strong><br />
			<?php echo $tutor->firstname; ?> <?php echo $tutor->lastname; ?><br />
		</p>	
		<p>
			<strong>Student Name</strong><br />
			<?php echo $request_data->student_name; ?><br />
		</p>	
		<hr />
		<p>
			<strong>Subject</strong><br />
			<?php echo $request_data->subject; ?>, <?php echo $request_data->grade; ?><br />
		</p>
		<p>
			<strong>Tutoring Duration</strong><br />
			<?php echo $request_data->hours; ?> per session
		</p>		
		<p>
			<strong>Tutoring Address</strong><br />
			<?php echo $request_data->address1; ?><br />
			<?php echo $request_data->city; ?><br />
		</p>
		<p>
			<strong>Your phone number</strong><br />
			<?php echo $me->mobile; ?>
		</p>
		<hr />
		<div class="booked-session">	
			<span class="booked-session-count">0/<?php echo $request_data->sessions; ?></span>
			<h3 class="thin">Booked Session</h3>
			<table class="booked-session">
				<tr>
					<?php for ($i = 0; $i < $request_data->sessions; $i++): ?>
					<td class="outline booked-date">Date</td>
					<?php endfor; ?>
				</tr>
				<tr>
					<?php for ($i = 0; $i < $request_data->sessions; $i++): ?>
					<td class="not-booked booked-day">Day</td>
					<?php endfor; ?>
				</tr>
				<tr>
					<?php for ($i = 0; $i < $request_data->sessions; $i++): ?>
					<td class="outline booked-time">Time</td>
					<?php endfor; ?>
				</tr>
			</table>
		</div>
		<hr />
		<h3 class="thin">Payment Summary</h3>
		<small class="none">Rate: RM<span class="tutor-rate"><?php echo $rate; ?></span>/hour</small>
		<table class="w100">
			<tr>
				<td>RM<?php echo $rate; ?> &times; <span><?php echo $request_data->hours; ?></span> hour(s) &times; 5 sessions</td>
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
	</div>
	
	<div class="tutor-profile-photo" style="background-image: url('uploads/profile/<?php echo $tutor->photo; ?>')"></div>
	<div class="tutor-details">
		<h2><?php echo $tutor->firstname; ?> <?php echo $tutor->lastname; ?> has accepted<br />your tutoring request</h2>
		<h3 class="thin">Complete 3 steps below to confirm hiring <?php echo $tutor->firstname; ?> <?php echo $tutor->lastname; ?> as your tutor.</h3>
		
		
		<div class="spacer"></div>
		
		<h3 class="thin">1. Select Timetable</h3>
		<div>Pick tutoring session that suit you and your child. This will be used as your regular schedule</div>

		<br />
		
		<?php echo form_dropdown('day',$daytimes,'','class="dropdown daytime"'); ?>
		<?php echo form_dropdown('hours', array('1 hour'=>'1 Hour','1.5 hours'=>'1.5 Hours','2 hours'=>'2 Hours','2.5 hours'=>'2.5 Hours','3 hours'=>'3 Hours'), $request_data->hours,'class="hours none"'); ?>
		
		<p class="tutoring-date" style="display: none">
			Start tutoring on<br />
			<?php echo form_dropdown('start','','','style="margin-top: 10px" class="dropdown start-tutoring-date"'); ?>
		</p>
		
		<div class="spacer"></div>
		
		

		<h3 class="thin">2. Message to Tutor</h3>
		<div>Say hello to your tutor and tell them what do you plan to achieve with tutoring.</div>
		<textarea name="message" class="textarea mt-5" placeholder="Write a message"></textarea>

	
		<div class="spacer"></div>
		<div class="spacer"></div>
		
		<h3 class="thin">3. Payment</h3>
		<p>Select payment method</p>
		<input type="radio" name="payment_method" value="test_successful" checked /> Test Successful Payment<br />
		<input type="radio" name="payment_method" value="test_unsuccessful" checked /> Test Unsuccessful Payment<br />
		<input type="radio" name="payment_method" value="billplz" checked /> Billplz
		
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="spacer"></div>
		
		<input type="submit" name="submit" class="btn btn-primary btn-request" value="Proceed to Payment" />
	</div>
	</form>
	<div class="clear"></div>
					
</div>

<div class="spacer"></div>
<div class="spacer"></div>
