
<div class="max1280 padding">
	<h1 class="thin">Congratulations!</h1>
	<p>You have successfully hired a tutor. Go to <a href="mytutor">My Tutor</a></p>	
	<hr />
</div>

<div class="max1024 padding min-height-600">



<div class="tutor-request-action-box">
		<p class="align-center"><strong>Status: <span class="status"><?php echo $request->status; ?></span></strong></p>
		
		
		<?php if ($request->status == 'Pending Payment'): ?>
			<a href="mytutor/checkout/<?php echo $request->id; ?>" class="btn mb-5 align-center btn-block btn-green">Checkout</a>
		<?php endif; ?>


		<ul class="list-action">
			<?php if ($request->status == 'Hired'): ?>
				<li><a href="messenger/chat_with_user/<?php echo $tutor->id; ?>"><i class="fa fa-envelope"></i>  Message tutor</a></li>
				<li><a href="mytutor/review/<?php echo $tutor->id; ?>"><i class="fa fa-star-half-o"></i> Write a review</a></li>			
			<?php else: ?>
				<li><a href="messenger/chat_with_user/<?php echo $tutor->id; ?>"><i class="fa fa-envelope"></i>  Message tutor</a></li>
				<li><i class="fa fa-lock"></i> <i class="fa fa-envelope"></i> Message tutor</li>
				<li><i class="fa fa-lock"></i> <i class="fa fa-star-half-o"></i> Write a review</li>

			<?php endif; ?>
			<li><a href="mytutor/suggest_to_friends/<?php echo $tutor->id; ?>"><i class="fa fa-bullhorn"></i> Suggest to friends</a></li>
		</ul>
	
	</div>
	
	<div class="tutor-profile-photo" style="background-image: url('uploads/profile/<?php echo $tutor->photo; ?>')"></div>
	<div class="tutor-details">
		<h2>Hi, I'm <?php echo $tutor->firstname; ?> <?php echo $tutor->lastname; ?> <i class="gender-<?php echo strtolower($tutor->gender); ?>"></i></h2>
		<h3 class="thin">I'm your <?php echo $request_data->subject; ?> Tutor</h3>
		
		
		<p>
			<strong class="primary">Student Name</strong><br />
			<?php echo $request_data->student_name; ?><br /><br />
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