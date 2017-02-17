<?php
	$me = $this->user->data();
?>

<script type="text/javascript">

var pp = <?php echo $me->photo ? '1' : '0'; ?>;

$(document).ready(function(){
	$('select.hours').change(function(){
		var rate = parseFloat($('.tutor-rate').text());
		var hours = parseFloat($(this).val());
		var subtotal = rate * hours;
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
<div class="max1024 padding">
	
	
	
	<div class="tutor-profile-photo" style="background-image: url('uploads/profile/<?php echo $tutor->photo; ?>')"></div>
	<div class="tutor-details">
		<h2>Suggest <?php echo $tutor->firstname; ?> <?php echo $tutor->lastname; ?> <i class="icon-<?php echo strtolower($tutor->gender); ?>"></i> to friends</h2>
		<div>
			<div class="primary">
			<i class="fa fa-star"></i>
			<i class="fa fa-star"></i>
			<i class="fa fa-star"></i>
			<i class="fa fa-star"></i>
			<i class="fa fa-star"></i>
			</div>
			<small>(15 reviews)</small>
		</div>
		
		<div class="spacer"></div>
		<h3 class="primary">Qualification</h3>
		<p><?php echo $tutor->qualification; ?><br />
		<?php echo $tutor->institution; ?></p>
		
		<div class="spacer"></div>

		<hr />
		
		<form method="post">
			<p>Enter your friends email address(es)</p>
			<textarea name="emails" placeholder="One email address per line" class="textarea"></textarea>
			
			<p>Recommendation</p>
			<textarea name="recommendation" placeholder="Include some reasons why do you think this tutor is worth recommending to yours friends"  class="textarea"></textarea>

			<br /><br />
			<input type="submit" class="btn btn-primary" value="Submit" />
		</form>
		
		
		<div class="spacer"></div>
		<div class="spacer"></div>
		
	</div>

	
					
</div>
