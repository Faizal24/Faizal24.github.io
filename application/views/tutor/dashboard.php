<script type="text/javascript">
	
$(document).ready(function(){
	
	$('.tab li').click(function(){
		$(this).parents('.tab').find('li').removeClass('current');
		$(this).addClass('current');
		var rel = $(this).attr('rel');
		
		$('.tab-content').hide();
		$('.'+rel).show();
		
		window.location.href = '<?php echo base_url(); ?>tutor/dashboard/#' + rel;
	})
	
	var url = window.location.href + '';
	var uri = url.split('#');
	if (uri[1]){
		$('li[rel='+uri[1]+']').click();			
	} else {
		$('li.current').click();	
	}

})
	
</script>

<div class="max1280 padding">
	<h1 class="thin">Tutor Dashboard</h1>
</div>
<div class="dark-bg">
	<div class="max1280 padding">	
		<ul class="horizontal-tabs tab">
			<li rel="summary" class="current">Summary</li>
			<li rel="availability">Availability</li>
			<li rel="subjects">Subjects &amp; Hourly Rates</li>
			<li rel="requests">Requests <span class="request-bubble"><?php echo count($requests); ?></span></li>
		</ul>
	</div>
</div>
<div class="">
<div class="max1280 padding min-height-600">


	
	<div class="tab-content summary">
		<p>
			Account Status: Active
		</p>	
		<hr />
		<div>
			<div class="number-stat-large">
				<span class="number"><?php echo $this->job->hours_tutored(); ?></span>
				<label>Hours Tutored</label>
			</div>
			<div class="number-stat-large">
				<span class="number"><?php echo number_format($this->user->data('review_rating'),2); ?></span>
				<label>Rating</label>
			</div>
			<div class="number-stat-large">
				<span class="number">N/A</span>
				<label>Response Time</label>
			</div>
			<div class="number-stat-large">
				<span class="number">RM0.00</span>
				<label>Total earned with MaiTutor</label>
			</div>
			
			<div class="number-stat-large">
				<span class="number"><?php echo $this->job->accepted_requests(); ?></span>
				<label>Accepted Request</label>
			</div>
			<div class="number-stat-large">
				<span class="number"><?php echo $this->job->declined_requests(); ?></span>
				<label>Declined Request</label>
			</div>
			<div class="number-stat-large">
				<span class="number"><?php echo $this->job->pending_requests(); ?></span>
				<label>Pending Confirmation</label>
			</div>
			<div class="number-stat-large">
				<span class="number"><?php echo $this->job->active_clients(); ?></span>
				<label>Active Clients</label>
			</div>
			<div class="number-stat-large">
				<span class="number"><?php echo $this->job->pending_reports(); ?></span>
				<label>Pending Report</label>
			</div>
		</div>
	</div>

	<div class="tab-content availability">
		<a class="save-availability btn btn-primary float-right" href="#">Save Availability</a>
		<h1 class="thin">Manage Availability
			
			<div style="display: inline-block">
				<div class="onoffswitch">
					<input <?php echo $tutor->enable_availability ? 'checked' : ''; ?> type="checkbox" name="enable_availability" class="onoffswitch-checkbox" id="myonoffswitch">
					<label class="onoffswitch-label" for="myonoffswitch">
						<span class="onoffswitch-inner"></span>
						<span class="onoffswitch-switch"></span>
					</label>
				</div>
			</div>
		</h1>
		
		

		<p>Click on timetable below to mark your available times.</p>
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
		<table class="grid availability-grid table-spaced <?php echo $tutor->enable_availability ? '' : 'semi-transparent'; ?>">
			<?php for ($i = 0; $i < 7; $i++): ?>
			<tr>
				<td><?php echo $day[$i]; ?></td>
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
				<td></td>
				<?php for ($j = 0; $j < 16; $j++): ?>
				<td style="text-align: center"><?php echo $time[$j]; ?></td>
				<?php endfor; ?>
				
			</tr>
		</table>
		
		<p>
			<strong>Legend</strong><br />
			
			<div class="green-bg" style="width: 20px; display: inline-block; height: 16px; margin-right: 10px; border: 1px solid #ccc"></div> Available
			<div style="width: 20px; display: inline-block; height: 16px; margin-right: 10px; margin-left: 20px; border: 1px solid #ccc"></div> Unallocated
			<div class="red-bg" style="width: 20px; display: inline-block; height: 16px; margin-right: 10px; margin-left: 20px; border: 1px solid #ccc"></div> Booked
		</p>
		
		<script type="text/javascript">
			
			$(document).ready(function(){
				$('.time-select').click(function(){
					if ($(this).hasClass('red-bg')){
						window.open($(this).attr('href'), '_blank');
						return;
					}
					if ($('.availability-grid').hasClass('semi-transparent')) return;
					
					
					$(this).toggleClass('green-bg');
				})
				
				$('input[name=enable_availability]').click(function(){
					
					setTimeout(function(){
						var enable = $('input[name=enable_availability]').prop('checked') ? 1 : 0;

						$.ajax({
							url: 'tutor/ajax/toggle_availability',
							type: 'post',
							data: 'enable='+enable,
							success: function(){
								if (enable){
									$('.availability-grid').removeClass('semi-transparent');
								} else {
									$('.availability-grid').addClass('semi-transparent');									
								}
							}
						})
					}, 500)
				})
				
				$('.save-availability').click(function(e){
					e.preventDefault();
					


					var times = [];					
					$('.time-select').each(function(){

						if ($(this).hasClass('green-bg')){
							var rel = $(this).attr('rel');
							times.push(rel);
						}
					})
					$.ajax({
						url: 'tutor/ajax/save_availability',
						type: 'post',
						data: {
							availability: times.join(',')
						},
						success: function(){
							alert('Availability saved successfully');
						}
					})
				})
			})			
			
		</script>
	</div>

	<div class="tab-content requests">
		
		
		
		
	<?php foreach ($requests as $request): ?>
		<?php
			$user = $this->user->email($request->request_from);
			$request_data = json_decode($request->request_data);
		?>
		<div class="job-request">
			<div class="job-request-action">
				
				<a href="tutor/request_details/<?php echo $request->id; ?>" class="btn mb-5 btn-block btn-green">View Details</a>

				<?php if ($request->status == 'Awaiting Confirmation'): ?>
				<a href="tutor/accept_request/<?php echo $request->id; ?>" class="btn btn-block btn-primary">Accept</a>
				<p class="align-center">
					<a href="tutor/decline_request/<?php echo $request->id; ?>" class="red">Decline</a>
				</p>
				<?php endif; ?>
				
				
				<span class="status"><?php echo $request->status; ?></span>
			</div>
			<a href="tutor/request_details/<?php echo $request->id; ?>">
				<div class="large-profile-photo" style="background-image: url('uploads/profile/<?php echo $user->photo; ?>')"></div>
			</a>
			<h2><a href="tutor/request_details/<?php echo $request->id; ?>"><?php echo $user->firstname; ?> <?php echo $user->lastname; ?></a></h2>
			<p>
				<?php echo $request_data->subject; ?> &mdash; <?php echo $request_data->grade; ?>
				<br /><small class="grey">STUDENT</small> <br /><?php echo $request_data->student_name; ?>
				<br /><small class="grey">DURATION</small> <br /><?php echo $request_data->hours; ?> hour(s)
				<br /><small class="grey">LOCATION</small> <br />
					<?php echo hide_chars($request_data->address1); ?>
					<?php echo ', '. $request_data->city; ?>
			</p>
			
			<div class="booked-session" style="width: 400px">
				<span class="booked-session-count">0/<?php echo $request_data->sessions; ?> <i class="fa fa-lock"></i></span>
				Booked sessions
				<table class="booked-session">
					<tr>
						<?php for ($i = 0; $i < $request_data->sessions; $i++): ?>
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

	<div class="tab-content subjects">

		<a style="float: right" href="tutor/add_subject" class="btn btn-primary">Add Subject</a>
		<h1 class="thin">Manage Subjects &amp; Rates</h1>

		<table class="grid table-spaced">	
		<thead>
			<tr>
				<th>Subject</th>
				<th>Rate</th>
				<th style="width: 150px">Status</th>
				<th style="width: 80px"></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($this->user->tutor_subjects($this->user->data()) as $subject): ?>
		<tr>
			<td><?php echo $subject->subject; ?> &mdash; <?php echo $subject->grade; ?></td>
			<td class="align-center">
				<?php echo $subject->active ? 'Active' : 'Pending'; ?>
				<?php if (!$subject->active): ?>
				&nbsp; <a class="btn btn-primary" href="tutor/test/<?php echo $subject->id; ?>">Take Test</a>
				<?php endif; ?>

			</td>
			<td class="align-center"><?php echo $subject->rate ? $subject->rate : '<i>Unset</i>'; ?></td>
			<td class="align-center">
				<a title="Delete" class="btn delete-confirm" href="tutor/delete_subject/<?php echo $subject->id; ?>"><i class="fa fa-trash"></i></a>
				<a title="Edit" class="btn" href="tutor/edit_subject/<?php echo $subject->id; ?>"><i class="fa fa-pencil"></i></a>

			</td>
		</tr>
		<?php endforeach; ?>
		</tbody>
		</table>
	</div>
	

</div>