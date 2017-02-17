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
		var email = '<?php echo $user->email; ?>';

		$.ajax({
			url: 'users/ajax/update_account_status',
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
	
})

</script>
<a href="users" class="link btn btn-primary float-right btn-large"><i class="fa fa-arrow-left"></i> Back</a>

<h1 class="main-separator-blue-tint">
	Users &raquo; <div class="profile-photo" style="background-image: url('../uploads/profile/<?php echo $user->photo; ?>')"></div> <?php echo $user->firstname; ?> <?php echo $user->lastname; ?>
</h1>



<div class="project-content pt-15">
	<ul class="tabs mt-10">
		<li><a class="tab-current" rel="profile">Profile</a></li>
		<li><a rel="requests">Requests</a></li>	
		<li><a rel="sessions">Sessions</a></li>
		<li><a rel="notes">Notes</a></li>
	</ul>
	
	
	
	<div class="tab-content" style="padding: 20px" rel="notes">
		
		
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
					<td colspan="6"><i>No sessions.</i></td>
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
					<th>Tutor</th>
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
					<td colspan="6"><i>No sessions.</i></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
		
	</div>
	
	
	<div class="tab-content tab-current" style="padding: 20px" rel="profile">
		<div class="spacer"></div>
		
		<div class="group">
			
			<div class="u-1 md-1-3 pb-15">
				<label class="grey uppercase small block">Account Status</label>
				<?php echo form_dropdown('status', array('Verified'=>'Verified','Unverified'=>'Unverified'), $user->status); ?>
				<a class="btn update-account-status">Update</a>
			</div>

			
		</div>
		
		<div class="group">
			
			<div class="u-1 md-1-3 pb-15">
				<label class="grey uppercase small block">First name</label>
				<?php echo $user->firstname; ?>
			</div>

			<div class="u-1 md-1-3 pb-15">
				<label class="grey uppercase small block">Last name</label>
				<?php echo $user->lastname; ?>
			</div>

			
		</div>
		
		<div class="group">
			
		
			<div class="u-1 md-1-3 pb-15">
				<label class="grey uppercase small block">Email</label>
				<?php echo $user->email; ?>
			</div>

			<div class="u-1 md-1-3 pb-15">
				<label class="grey uppercase small block">Mobile</label>
				<?php echo $user->mobile; ?>
			</div>
			
		</div>
		
		
		<div class="spacer"></div>
		<hr />
		<div class="spacer"></div>
		

		
	</div>
	
	
	
</div>