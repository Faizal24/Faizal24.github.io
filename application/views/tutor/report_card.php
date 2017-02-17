<div class="max1280 padding">
	<h1 class="thin">Report Card</h1>
</div>

<div class="grey-bg">
<div class="max1024 padding min-height-600">




	<?php foreach ($sessions as $session): ?>
		<?php
			$user = $this->user->email($session->request_from);
			$request_data = json_decode($session->request_data);
		?>
		
		<div class="job-request">
			<div class="job-request-action">
				
				<span style="font-size: 20pt;"><?php echo date('l', strtotime($session->date)); ?></span><br />
				<span style="font-size: 12pt"><?php echo date('F j', strtotime($session->date)); ?></span>
				<hr />
				<span style="font-size: 12pt;"><?php echo date('g:i A',strtotime($session->time)); ?></span>
				<div class="padding">
				<?php if ($session->session_status == 'Completed'): ?>
					<?php if (!$session->assessment): ?>
						<a href="tutor/assessment/<?php echo $session->session_id; ?>" class="btn">Write Assessment</a>
					<?php else: ?>
						<a href="tutor/assessment/<?php echo $session->session_id; ?>" class="btn">View Assessment</a>					
					<?php endif; ?>
				<?php endif; ?>
				</div>
			</div>
			<div class="large-profile-photo" style="background-image: url('uploads/profile/<?php echo $user->photo; ?>')"></div>
			<h2><?php echo $user->firstname; ?> <?php echo $user->lastname; ?> <?php if (!$session->assessment_seen) echo '<span class="new">New</span>'; ?></h2>
			<p>
				<?php echo $request_data->subject; ?> &mdash; <?php echo $request_data->grade; ?>
				<br /><small class="grey">STUDENT</small> <br /><?php echo $request_data->student_name; ?>
				<br /><small class="grey">DURATION</small> <br /><?php echo $request_data->hours; ?>
				<br /><small class="grey">LOCATION</small> <br />
					<?php echo $request_data->address1; ?>
					<?php echo $request_data->address2 ? ', '. $request_data->address2 :  ''; ?>
					<?php echo ', '. $request_data->city; ?>
			</p>
			
			
		</div>
	<?php endforeach; ?>
	

	<?php if (!count($sessions)): ?>
	<i>No tutor sessions.</i>
	<?php endif; ?>
	
	<hr />
	<br />
	
</div>