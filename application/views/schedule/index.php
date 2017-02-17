<div class="max1280 padding">
	<h1 class="thin">Schedule</h1>
	<p>Below are upcoming tutoring sessions.</p>
</div>

<div class="grey-bg">
<div class="max1024 padding min-height-600">
<?php 
	$schedule = $this->job->get_schedule();
	foreach ($schedule as $session){
		if (strtotime(date('Y-m-d')) == strtotime($session->date)){
			$today[] = $session;
		} else {
			$upcoming[] = $session;
		}
	}
?>

	<h3 class="thin">Today</h3>
	
	<?php foreach ($today as $session): ?>
		<?php
			$user = $this->user->email($session->request_to);
			$request_data = json_decode($session->request_data);
		?>

		<div class="job-request">
			<div class="job-request-action">
				
				<span style="font-size: 20pt;"><?php echo date('l', strtotime($session->date)); ?></span><br />
				<span style="font-size: 12pt"><?php echo date('F j', strtotime($session->date)); ?></span>
				<hr />
				<span style="font-size: 12pt;"><?php echo date('g:i A',strtotime($session->time)); ?></span>
			</div>
			<div class="large-profile-photo" style="background-image: url('uploads/profile/<?php echo $user->photo; ?>')"></div>
			<h2><?php echo $user->firstname; ?> <?php echo $user->lastname; ?> </h2>
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
	
	<?php if (!count($today)): ?>
	<i>No sessions today</i>
	<?php endif; ?>
	
	<hr />
	<br />
	
	<h3 class="thin">Upcoming</h3>

	<?php foreach ($upcoming as $session): ?>
		<?php
			$user = $this->user->email($session->request_to);
			$request_data = json_decode($session->request_data);
		?>

		<div class="job-request">
			<div class="job-request-action">
				
				<span style="font-size: 20pt;"><?php echo date('l', strtotime($session->date)); ?></span><br />
				<span style="font-size: 12pt"><?php echo date('F j', strtotime($session->date)); ?></span>
				<hr />
				<span style="font-size: 12pt;"><?php echo date('g:i A',strtotime($session->time)); ?></span>
			</div>
			<div class="large-profile-photo" style="background-image: url('uploads/profile/<?php echo $user->photo; ?>')"></div>
			<h2><?php echo $user->firstname; ?> <?php echo $user->lastname; ?> </h2>
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
	<?php if (!count($upcoming)): ?>
	<i>No upcoming sessions</i>
	<?php endif; ?>

</div>