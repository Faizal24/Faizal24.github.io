<?php
	$me = $this->user->data();
?>

<div class="max1280 padding">
	<a class="btn float-right" href="tutor/clients" style="margin-top: 15px">Back</a>
	<h1 class="thin">Client Details</h1>

	<hr />
	

</div>

<div class="spacer"></div>
<div class="spacer"></div>
<div class="max1024 padding min-height-600">
	
	

	
	<div class="spacer"></div>

	
	<div class="tutor-request-action-box">
		<ul class="list-action">
			<?php if ($request->status == 'Hired'): ?>
				<li><a href="messenger/chat_with_user/<?php echo $user->id; ?>"><i class="fa fa-envelope"></i>  Message client</a></li>
			<?php else: ?>
				<li><a href="messenger/chat_with_user/<?php echo $user->id; ?>"><i class="fa fa-envelope"></i>  Message client</a></li>

			<?php endif; ?>

		</ul>
	
	</div>
	
	<div class="tutor-profile-photo" style="background-image: url('uploads/profile/<?php echo $user->photo; ?>')"></div>
	<div class="tutor-details">
		<h2><?php echo $user->firstname; ?> <?php echo $user->lastname; ?> </h2>
		Mobile: <?php echo $user->mobile; ?>
		
		<div class="spacer"></div>
		<hr />
					
		<h3 class="primary">Booked Lessons</h3>
		
		<?php foreach ($requests as $request): ?>
			<?php
				$user = $this->user->email($request->request_from);
				$request_data = json_decode($request->request_data);
			?>
			<div class="job-request" style="padding: 10px">
				<div class="job-request-action">
					

					<a href="tutor/lesson_details/<?php echo $request->id; ?>/<?php echo $user->id; ?>" class="btn mb-5 btn-block btn-green">View Details</a>
				</div>
				<h3><?php echo $request_data->subject; ?> &mdash; <?php echo $request_data->grade; ?></h3>
				<p>

					<br /><small class="grey">STUDENT</small> <br /><?php echo $request_data->student_name; ?>
					<br /><small class="grey">DURATION</small> <br /><?php echo $request_data->hours; ?> hour(s)
					<br /><small class="grey">LOCATION</small> <br />
						<?php echo $request_data->address1; ?>
						<?php echo $request_data->address2 ? ', '. $request_data->address2 :  ''; ?>
						<?php echo ', '. $request_data->city; ?>
				</p>
				
				
				
			</div>
		
		<?php endforeach; ?>
		<?php if (!count($requests)): ?>
		<p><i>There are no lesson requests so far.</i></p>
		<?php endif; ?>
		

			

		
	</div>

	
					
</div>
