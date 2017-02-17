<style>

.red-bg {
	background: red;
}

.green-bg {
	background: #0da342;
}
	
</style>

<script type="text/javascript">
	
$(document).ready(function(){
	$('ul.tabs a').click(function(){
		$('div.tab-content').hide();
		var rel = $(this).attr('rel');
		$('div.tab-content[rel='+rel+']').show();
	})
	
	$('.update-account-status').click(function(){
		base.showLoading();
		var email = '<?php echo $tutor->email; ?>';

		$.ajax({
			url: 'tutors/ajax/update_account_status',
			type: 'post',
			data: {
				email: email,
				status: $('select[name=status]').val()
			},
			success: function(res){
				base.alert('Account status has been updated.');
			}
		})
	});
	
	$('.update-interview-status').click(function(){
		base.showLoading();
		var email = '<?php echo $tutor->email; ?>';

		$.ajax({
			url: 'tutors/ajax/update_interview_status',
			type: 'post',
			data: {
				email: email,
				status: $('select[name=interview_status]').val()
			},
			success: function(res){
				base.alert('Interview status has been updated.');
			}
		})
	})
	
	$('.update-assessment-status').click(function(){
		base.showLoading();
		var email = '<?php echo $tutor->email; ?>';

		$.ajax({
			url: 'tutors/ajax/update_assessment_status',
			type: 'post',
			data: {
				email: email,
				status: $('select[name=passed_assessment]').val()
			},
			success: function(res){
				base.alert('Assessment status has been updated.');
			}
		})
	})
})

</script>
<a href="tutors" class="link btn btn-primary float-right btn-large"><i class="fa fa-arrow-left"></i> Back</a>

<h1 class="main-separator-blue-tint">
	Tutors &raquo; <div class="profile-photo" style="background-image: url('../uploads/profile/<?php echo $tutor->photo; ?>')"></div> <?php echo $tutor->firstname; ?> <?php echo $tutor->lastname; ?>
	<!--
	<div>
		<a class="link btn" href="tutors/edit/<?php echo $tutor->id; ?>"><i class="fa fa-pencil"></i> <i class="separator"></i> Edit</a>
	</div>
	-->
</h1>



<div class="project-content pt-15">
	<ul class="tabs mt-10">
		<li><a class="tab-current" rel="profile">Profile</a></li>
		<li><a rel="subjects">Subjects</a></li>
		<li><a rel="availability">Availability</a></li>
		<li><a rel="requests">Requests</a></li>	
		<li><a rel="sessions">Sessions</a></li>
		<li><a rel="payout">Payout</a></li>
		<li><a rel="notes">Notes</a></li>
	</ul>
	
	
	
	<div class="tab-content" style="padding: 20px" rel="notes">
		
		
	</div>
	
	<div class="tab-content" style="padding: 20px" rel="availability">
		
		
		<?php
			$availabilities = explode(',', $tutor->availability);
			$day = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
			$day_s = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun']; 
			$time = ["8AM","9AM","10AM","11AM","12PM","1PM","2PM","3PM","4PM","5PM","6PM","7PM","8PM","9PM","10PM","11PM"];
			$time_m = array(
				"8AM"=>'Morning',
				"9AM"=>'Morning',
				"10AM"=>'Morning',
				"11AM"=>'Morning',
				"12PM"=>'Afternoon',
				"1PM"=>'Afternoon',
				"2PM"=>'Afternoon',
				"3PM"=>'Afternoon',
				"4PM"=>'Afternoon',
				"5PM"=>'Afternoon',
				"6PM"=>'Evening',
				"7PM"=>'Evening',
				"8PM"=>'Evening',
				"9PM"=>'Evening',
				"10PM"=>'Evening',
				"11PM"=>'Evening'
			);
			
		?>
		<table style="width: 100%" class="grid availability-grid table-spaced <?php echo $tutor->enable_availability ? '' : 'semi-transparent'; ?>">
			<?php for ($i = 0; $i < 7; $i++): ?>
			<tr>
				<th><?php echo $day[$i]; ?></th>
				<?php for ($j = 0; $j < 16; $j++): ?>
				<?php
					$rel = 	$day_s[$i] . ' - '. $time_m[$time[$j]] . ' - ' . $time[$j];				
					if ($req_id = $blocked[$day_s[$i]][$j+8]) $blocked_class = 'red-bg';
					else $blocked_class = '';
				?>

				<td href="tutor/lesson_details/<?php echo $req_id; ?>" class="time-select <?php if (in_array($rel, $availabilities) && !$blocked_class) echo 'green-bg'; ?> <?php echo $blocked_class; ?>" style="width: 50px" rel="<?php echo $rel; ?>"></td>
				<?php endfor; ?>
			<tr>
			<?php endfor; ?>
			<tr>
				<th></th>
				<?php for ($j = 0; $j < 16; $j++): ?>
				<th style="text-align: center"><?php echo $time[$j]; ?></th>
				<?php endfor; ?>
				
			</tr>
		</table>
		
		
		
	</div>
	
	<div class="tab-content" style="padding: 20px" rel="requests">
		
		<table class="grid fw table-spaced">
			<thead>
				<tr>
					<th>JRID</th>
					<th>Parent Email</th>
					<th>Student Name</th>
					<th>Subject</th>
					<th>Date/Time</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($requests as $request): ?>
				<?php $request_data = json_decode($request->request_data); ?>
				<tr>
					<td><?php echo $request->id; ?></td>
					<td><?php echo $request->request_from; ?></td>
					<td><?php echo $request_data->student_name; ?></td>
					<td><?php echo $request_data->subject; ?> (<?php echo $request_data->grade; ?>)</td>
					<td><?php echo date('d/m/Y h:iA', strtotime($request->datetime)); ?></td>
					<td style="text-align: center">
						<span class="status-<?php echo classname($request->status); ?>"><?php echo $request->status; ?></span>
					</td>
				</tr>
				<?php endforeach; ?>
				<?php if (!count($requests)): ?>
				<tr>
					<td colspan="4"><i>No sessions.</i></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
		
	</div>

	<div class="tab-content" style="padding: 20px" rel="sessions">
		
		<table class="grid fw table-spaced">
			<thead>
				<tr>
					<th>JRID</th>
					<th>Student Name</th>
					<th>Subject</th>
					<th>Date/Time</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($sessions as $session): ?>
				<?php $request_data = json_decode($request->request_data); ?>
				<tr>
					<td><?php echo $session->job_request_id; ?></td>
					<td><?php echo $request_data->student_name; ?></td>
					<td><?php echo $request_data->subject; ?> (<?php echo $request_data->grade; ?>)</td>
					<td><?php echo date('d/m/Y', strtotime($session->date)); ?> <?php echo date('h:iA', strtotime($session->time)); ?></td>
					<td style="text-align: center">
						<span class="status-<?php echo classname($session->session_status); ?>"><?php echo $session->session_status; ?></span>
					</td>
				</tr>
				<?php endforeach; ?>
				<?php if (!count($sessions)): ?>
				<tr>
					<td colspan="5"><i>No sessions.</i></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
		
	</div>
	
	<div class="tab-content" style="padding: 20px" rel="payout">
		
		<table class="grid fw table-spaced">
			<thead>
				<tr>
					<th>JOID</th>
					<th>Date/Time</th>
					<th>Amount</th>
					<th>MyTutor Commission</th>
					<th>Payable</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($payouts as $payout): ?>
				<tr>
					<td><?php echo $payout->id; ?></td>
					<td><?php echo date('d/m/Y h:iA', strtotime($payout->datetime)); ?></td>
					<td><?php echo number_format($payout->amount_payable,2); ?></td>
					<td><?php echo number_format($payout->amount_commission,2); ?></td>
					<td><?php echo number_format($payout->amount_payable - $amount->amount_commission,2); ?></td>
				</tr>
				<?php endforeach; ?>
				<?php if (!count($payouts)): ?>
				<tr>
					<td colspan="5"><i>No payout.</i></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
		
	</div>
	
	
	<div class="tab-content" style="padding: 20px" rel="subjects">
		<ul class="list">	
			<?php foreach ($tutor->subjects as $subject): ?>
			<li><?php echo $subject->grade; ?> &mdash; <?php echo $subject->subject; ?></li>
			<?php endforeach; ?>
		</ul>
	</div>		
	
	<div class="tab-content tab-current" style="padding: 20px" rel="profile">
		<div class="spacer"></div>
		
		<div class="group">
			
			<div class="u-1 md-1-3 pb-15">
				<label class="grey uppercase small block">Account Status</label>
				<?php echo form_dropdown('status', array('Verified'=>'Verified','Unverified'=>'Unverified'), $tutor->status); ?>
				<a class="btn update-account-status">Update</a>
			</div>

			<div class="u-1 md-1-3 pb-15">
				<label class="grey uppercase small block">Assessment Status</label>
				<?php echo form_dropdown('passed_assessment', array(''=>'Not Taken','Passed Assessment'=>'Passed Assessment','Failed Assessment'=>'Failed Assessment'), $tutor->passed_assessment); ?>
				<a class="btn update-assessment-status">Update</a>
			</div>

			<div class="u-1 md-1-3 pb-15">
				<label class="grey uppercase small block">Interview Status</label>
				<?php echo form_dropdown('interview_status', array(''=>'Pending','Interviewed'=>'Interviewed'), $tutor->interview_status); ?>
				<a class="btn update-interview-status">Update</a>
			</div>

			
		</div>
		
		<div class="group">
			
			<div class="u-1 md-1-3 pb-15">
				<label class="grey uppercase small block">First name</label>
				<?php echo $tutor->firstname; ?>
			</div>

			<div class="u-1 md-1-3 pb-15">
				<label class="grey uppercase small block">Last name</label>
				<?php echo $tutor->lastname; ?>
			</div>

			<div class="u-1 md-1-3 pb-15">
				<label class="grey uppercase small block">Gender</label>
				<?php echo $tutor->gender; ?>
			</div>
			
		</div>
		
		<div class="group">
			

			<div class="u-1 md-1-3 pb-15">
				<label class="grey uppercase small block">Address</label>
				<?php echo $tutor->address1; ?><br />
				<?php echo $tutor->address2; ?><br />
				<?php echo $tutor->zipcode; ?><br />
				<?php echo $tutor->state; ?><br />				
				<?php echo $tutor->country; ?><br />				
			</div>
			
			<div class="u-1 md-1-3 pb-15">
				<label class="grey uppercase small block">NRIC</label>
				<?php echo $tutor->nric; ?>
			</div>

			
		</div>
		
		<div class="group">
			<div class="u-1 md-1-3 pb-15">
				<label class="grey uppercase small block">Email</label>
				<?php echo $tutor->email; ?>
			</div>
			
			<div class="u-1 md-1-3 pb-15">
				<label class="grey uppercase small block">Mobile</label>
				<?php echo $tutor->mobile; ?>
			</div>
			
			
		</div>
		
		<div class="spacer"></div>
		<hr />
		<div class="spacer"></div>
		
		<div class="group">
			
			<div class="u-1 md-1-3 pb-15">
				<label class="grey uppercase small block">About</label>
				<?php echo nl2br($tutor->about); ?>
			</div>

			<div class="u-1 md-1-3 pb-15">
				<label class="grey uppercase small block">Qualification</label>
				<?php echo nl2br($tutor->qualification); ?>
			</div>

			<div class="u-1 md-1-3 pb-15">
				<label class="grey uppercase small block">Institution</label>
				<?php echo nl2br($tutor->institution); ?>
			</div>
			
		</div>
		

		
	</div>
	
	
	
</div>