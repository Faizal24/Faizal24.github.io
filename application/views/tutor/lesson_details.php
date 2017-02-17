<?php
	$me = $this->user->data();
?>

<div class="max1280 padding">
	<a class="btn float-right" href="tutor/client_details/<?php echo $user->id; ?>" style="margin-top: 15px">Back</a>
	<h1 class="thin">Client Details &raquo; Request Details</h1>
	
	<hr />
	
	<?php if ($this->session->flashdata('accepted_request')): ?>
	<div class="success">
		You have accepted this request!
	</div>
	<?php endif; ?>
	
	<?php if ($this->session->flashdata('declined_request')): ?>
	<div class="notice">
		You have declined this request.
	</div>
	<?php endif; ?>
</div>

<div class="spacer"></div>
<div class="spacer"></div>
<div class="max1024 padding min-height-600">
	
	

	
	<div class="spacer"></div>

	
	<div class="tutor-request-action-box">
		<p class="align-center"><strong>Status: <span class="status"><?php echo $request->status; ?></span></strong></p>
		<ul class="list-action">
			<?php if ($request->status == 'Hired'): ?>
				<li><a href="messenger/chat_with_user/<?php echo $user->id; ?>"><i class="fa fa-envelope"></i>  Message client</a></li>
			<?php else: ?>
				<li><a href="messenger/chat_with_user/<?php echo $user->id; ?>"><i class="fa fa-envelope"></i>  Message client</a></li>

			<?php endif; ?>

		</ul>
	
	</div>
	
	<div class="tutor-details" style="padding-left: 0; margin-left: 0">
		<h2><?php echo $request_data->subject; ?> &mdash; <?php echo $request_data->grade; ?></h2>
		
		
		<p>
			<strong class="primary">Student Name</strong><br />
			<?php echo $request_data->student_name; ?><br /><br />
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
