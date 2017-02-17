
<div class="max1280 padding">
	<h1 class="thin">My Tutors</h1>
</div>

<div class="grey-bg">
<div class="max1024 padding min-height-600">
	
	
	
	<?php foreach ($requests as $request): ?>
		<?php
			$user = $this->user->email($request->request_to);
			$tutor = $this->user->tutor($user->id);
			$request_data = json_decode($request->request_data);
		?>
		<div class="job-request">
			<div class="job-request-action">
				
				<?php if ($request->status == 'Pending Payment'): ?>
				<a href="mytutor/checkout/<?php echo $request->id; ?>" class="btn mb-5 btn-block btn-green">Checkout</a>
				<?php endif; ?>


				<a href="mytutor/details/<?php echo $request->id; ?>" class="btn btn-block btn-primary">View Details</a>
				
				
				<span class="status status-<?php echo class_name(strtolower($request->status)); ?>"><?php echo $request->status; ?></span>
			</div>
			<div class="large-profile-photo" style="background-image: url('uploads/profile/<?php echo $tutor->photo; ?>')"></div>
			<h2><a href="mytutor/details/<?php echo $request->id; ?>"><?php echo $tutor->firstname; ?> <?php echo $tutor->lastname; ?> <i class="icon-<?php echo strtolower($tutor->gender); ?>"></i></a></h2>
			<p>
				<?php echo $request_data->subject; ?> &mdash; <?php echo $request_data->grade; ?>
				<br />Student: <?php echo $request_data->student_name; ?>
			</p>
			
			<div class="booked-session" style="width: 400px">

				<span class="booked-session-count">0/<?php echo $request_data->sessions; ?>
					<?php if ($request->status != 'Hired'): ?>
					<i class="fa fa-lock"></i>
					<?php endif; ?>
				</span>
				Booked sessions
				<table class="booked-session booked-<?php echo class_name(strtolower($request->status)); ?>">
					<tr>
						<?php for ($i = 0; $i <$request_data->sessions; $i++): ?>
						<td class="not-booked"></td>
						<?php endfor; ?>
					</tr>
				</table>
			</div>
			
		</div>
	
	<?php endforeach; ?>
	<?php if (!count($requests)): ?>
	<p><i>There are no lesson requests so far.</i></p>
	<?php endif; ?>
	
</div>
</div>