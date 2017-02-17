<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo base_url(); ?>" />
		<link rel="stylesheet" href="css/base.css" />
		<link rel="stylesheet" href="css/TextboxList.css" />
		<link rel="stylesheet" href="css/TextboxList.Autocomplete.css" />
		<link rel="stylesheet" href="css/jquery.datetimepicker.css" />
		<script type="text/javascript">
			// Variables
			
			var base_url = '<?php echo base_url(); ?>';
			var mredir = '';
		</script>
		<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key=AIzaSyC5mRhPydpTCquRcWUG-GxdAA4BmHx1v50" type="text/javascript"></script>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/GrowingInput.js"></script>
		<script type="text/javascript" src="js/TextboxList.js"></script>
		<script type="text/javascript" src="js/TextboxList.Autocomplete.js"></script>
		<script type="text/javascript" src="js/jquery.dateentry.min.js"></script>
		<script type="text/javascript" src="js/jquery.timeentry.min.js"></script>
		<script type="text/javascript" src="js/jquery.datetimepicker.js"></script>
		<script type="text/javascript" src="js/base.js"></script>
		<script type="text/javascript" src="js/places.js"></script>
		<script type="text/javascript" src="js/jsql.js"></script>
		<script type="text/javascript" src="js/Chart.min.js"></script>		
	</head>
	<body>
		<header class="primary">
			<span class="dropdown fit-nav nav-button dark-hover float-right dropdown-anchor-right">
				<div class="dropdown-icon user-photo-placeholder user-photo-placeholder-small">
					<?php $user = $this->user->data(); if ($user->photo): ?>
						<img src="uploads/profile/<?php echo $user->photo; ?>" />					
					<?php else: ?>
						<img src="images/face.png" />
					<?php endif; ?>
				</div>
				<div class="dropdown-label display-none-mobile">
					<?php echo $this->user->data('name'); ?>
				</div>
				<ul class="dropdown-content">
					<li><a class="link" href="profile/edit">My Profile</a></li>
					<li><a href="logout">Logout</a></li>
				</ul>
			</span>
			
			<?php if ($this->user->has_permission('access_settings')): ?>
			<a href="settings" class="float-right link fit-nav dark-hover nav-button">
				<i class="fa white fa-cog icon-mid" aria-hidden="true"></i>
			</a>
			<?php endif; ?>
			
			
			<span class="dropdown nav-button fit-nav dark-hover float-right dropdown-anchor-right">
				<span class="ncount" style="position: absolute; top: 5px; left: 25px; background: red; padding: 2px 5px; border-radius: 5px;">0</span>
				<i style="font-size: 13pt" class="fa white fa-bell icon-mid" aria-hidden="true"></i>
				<ul class="dropdown-content notifications">
					<li><a href="#">There are no notifications.</a></li>
				</ul>
			</span>

			<div class="fit-nav inline-block link" style="margin-left: 10px; margin-right: 10px; font-weight: bold">MyTutor</div>
			<a class="fit-nav white inline-block pl-15 pr-15 dark-hover link" href="main/dashboard">Dashboard</a>

		</header>

		<div id="container">
			
			
			<div id="sidebar">
				<div class="display-block-mobile align-center">
					<i class="fa fa-bars"></i>
				</div>
				<ul class="list sidebar-full">
					<li><a class="link link-icon block dark-hover" href="users"><i class="fa fa-group"></i> Users</a></li>
					<li><a class="link link-icon block dark-hover" href="tutors"><i class="fa fa-graduation-cap"></i> Tutors</a></li>
					<li><a class="link link-icon block dark-hover" href="payments"><i class="fa fa-money"></i> Payments / Refunds</a></li>
					<li><a class="link link-icon block dark-hover" href="matching"><i class="fa fa-exchange"></i> Matching</a></li>
				</ul>
					
			</div>
			<div id="main">
				
				
			</div>
			
		</div>
	</body>
</html>