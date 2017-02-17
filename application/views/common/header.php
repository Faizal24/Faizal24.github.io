<?php
	$me = $this->user->data();
?>
<!DOCTYPE html>
<html>
	<head>
		<title></title>
		
		<base href="<?php echo base_url(); ?>" />
		
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">

		<!--Bootstrap-->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
		
		<link rel="stylesheet" href="css/base.css" />
		<link rel="stylesheet" href="css/animate.css" />
		<link rel="stylesheet" href="css/responsiveslides.css" />
		<link rel="stylesheet" href="css/intlTelInput.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />

		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/intlTelInput.js"></script>
		<script type="text/javascript" src="js/responsiveslides.min.js"></script>
		<script type="text/javascript" src="js/app.js"></script>
		<script type="text/javascript">
			var _ut = 'user';
		</script>
		
		
		<?php 
			
			if ($this->user->is_logged_in()){
				$schedule = $this->job->get_schedule();
				foreach ($schedule as $session){
					if (strtotime(date('Y-m-d')) == strtotime($session->date)){
						$scheduled++;
					}
				}
				
				if ($this->user->data('type') == 'user'){
					$assessments_unseen = $this->job->Get_unseen_assessment();
				}
			}
		?>
		<style>
			/* Height for navigation menu */
			.navbar-nav > li > a {padding-top:20px !important; padding-bottom:20px !important;}
			.navbar {min-height:60px !important; height:60px;}

			/* Hover for navigation menu */
			ul.nav a:hover { color: black !important; }

			/* Navigation background color */
			.navbar{
				background-color:#fff;
			}

			/* Navigation vertical divider */
			.navbar .divider-vertical {
				height: 60px;
				margin: 0;
				border-left: 1px solid #f2f2f2;
				border-right: 1px solid #ffffff;
			}

			/* Big image for home page */
			.jumbotron {
				background-image: url('img/header.jpg');
				color: white;
				text-shadow: #444 0 1px 1px;
				width:100%;
				height:680px;
				text-align: center;
				padding-top:13%;
				margin-bottom: 0px;
			}

			.search-input {
				display: inline-block;
			}

			.footer{
				background:maroon;
				min-height:350px;
			}

			header .no-icon a {
				padding-top: 20px !important;
				height: 65px !important;
			}

			.thin-no-bullet{
				text-decoration: none !important
			}

		</style>

	</head>
	<body>
		<?php if ($this->user->data('type') == 'user'): ?>
		
			<header>
				<div class="max1280">
					<a href="<?php echo base_url(); ?>"><h1 class="logo">MyTutor</h1></a>
					<div class="navi">
						<ul class="navi">
							<li class="dropdown-handle messages">
								<a href="messenger"><i class="fa fa-comment"></i></a>
								<ul class="hover-dropdown messages-dropdown">
									<li><a href="#"><i>No messages yet.</i></a></li>
								</ul>
							</li>
							<li class="dropdown-handle notifications">
								<span class="ncount" style="position: absolute; margin-top: 10px; color: #fff; font-size: 9pt; left: 60px; background: red; padding: 2px 5px; height: auto; line-height:10px; border-radius: 5px; display: none">0</span>
								<a href="notifications"><i class="fa fa-bell"></i></a>
								<ul class="hover-dropdown notifications notifications-dropdown">
									<li><a href="#"><i>No notifications yet.</i></a></li>
								</ul>
							</li>
							<li class="dropdown-handle profile">
								<a class="profile" href="profile">
									<div class="small-profile-photo" style="background-image: url('uploads/profile/<?php echo $me->photo ? $me->photo : 'default.jpg'; ?>')"></div>
								</a>
								<ul class="hover-dropdown">
									<li><a href="profile"><i class="fa fa-user"></i> My Profile</a></li>
									<li><a href="help"><i class="fa fa-question"></i> Subject List</a></li>
									<li><a href="logout"><i class="fa fa-sign-out"></i> Logout</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
				<div class="user-nav">
					<div class="max1280">
						<ul>
							<li><a href="mytutor"><i class="icon-mytutor"></i> My Tutor</a></li>
							<li><a style="position: relative" href="schedule">
								<?php if ($scheduled): ?>
								<span style="position: absolute; margin-top: 10px; color: #fff; font-size: 9pt; left: 60px; background: red; padding: 2px 5px; height: auto; line-height:10px; border-radius: 5px;"><?php echo $scheduled; ?></span>
								<?php endif; ?>
								<i class="icon-schedule"></i> Schedule</a>
							</li>
							<li><a style="position: relative" href="report_card">
								<?php if ($assessments_unseen): ?>
								<span style="position: absolute; margin-top: 10px; color: #fff; font-size: 9pt; left: 60px; background: red; padding: 2px 5px; height: auto; line-height:10px; border-radius: 5px;"><?php echo $assessments_unseen; ?></span>
								<?php endif; ?>
								<i class="icon-report"></i> Report Card</a></li>
							<li><a href="payment"><i class="icon-payment"></i> Payment</a></li>
						</ul>
					</div>
				</div>
			</header>
			<div style="height: 115px">
				
			</div>

		
		<?php elseif ($this->user->data('type') == 'tutor'): ?>
				
			<header>
				<div class="max1280">
					<a href="<?php echo base_url(); ?>"><h1 class="logo">MyTutor</h1></a>
					<div class="navi">
						<ul class="navi">
							<li class="dropdown-handle messages">
								<a href="messenger"><i class="fa fa-comment"></i></a>
								<ul class="hover-dropdown messages-dropdown">
									<li><a href="#"><i>No messages yet.</i></a></li>
								</ul>
							</li>
							<li class="dropdown-handle notifications">
								<span class="ncount" style="position: absolute; margin-top: 10px; color: #fff; font-size: 9pt; left: 60px; background: red; padding: 2px 5px; height: auto; line-height:10px; border-radius: 5px; display: none">0</span>
								<a href="notifications"><i class="fa fa-bell"></i></a>
								<ul class="hover-dropdown notifications notifications-dropdown">
									<li><a href="#"><i>No notifications yet.</i></a></li>
								</ul>
							</li>
							<li class="dropdown-handle profile">
								<a class="profile" href="profile">
									<div class="small-profile-photo" style="background-image: url('uploads/profile/<?php echo $me->photo ? $me->photo : 'default.jpg'; ?>')"></div>
								</a>
								<ul class="hover-dropdown">
									<li><a href="profile"><i class="fa fa-user"></i> My Profile</a></li>
									<li><a href="help"><i class="fa fa-question"></i> Subject List</a></li>
									<li><a href="logout"><i class="fa fa-sign-out"></i> Logout</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
				<div class="user-nav">
					<div class="max1280">
						<ul>
							<li><a href="tutor/dashboard"><i class="icon-mytutor"></i> Dashboard</a></li>
							<li><a href="tutor/clients"><i class="icon-mytutor"></i> My Clients</a></li>
							<li><a style="position: relative" href="tutor/schedule">
								<?php if ($scheduled): ?>
								<span style="position: absolute; margin-top: 10px; color: #fff; font-size: 9pt; left: 60px; background: red; padding: 2px 5px; height: auto; line-height:10px; border-radius: 5px;"><?php echo $scheduled; ?></span>
								<?php endif; ?>
								<i class="icon-schedule"></i> Schedule</a>
							</li>
							<li><a style="position: relative" href="tutor/report_card">
								<i class="icon-report"></i> Report Card</a></li>
							<li><a href="payment"><i class="icon-payment"></i> Payment</a></li>
						</ul>
					</div>
				</div>
			</header>
			<div style="height: 110px">
				
			</div>

		
		<?php else: ?>
		
			<header>
				<div class="max1280">
					<a href="<?php echo base_url(); ?>"><h1 class="logo">MyTutor</h1></a>
					<div class="nav" tabindex="-1">
						<div class="bar none md sm"></div>
						<div class="bar none md sm"></div>
						<div class="bar none md sm"></div>
						<ul class="no-icon">
							<li><a class="strong" href="tutor/find">Find a Tutor</a></li>
							<li><a class="strong" href="tutor">Become a Tutor</a></li>
							<li><a href="help">Subject List</a></li>
							<li><a onclick="setTimeout(function(){ $('#sign-up-form input[name=firstname]').focus() }, 10)" class="signup-btn" href="sign_up">Sign Up</a></li>
							<?php if (!$login_page): ?>
							<li><a onclick="setTimeout(function(){ $('#login-form input[name=email]').focus() }, 10)" class="login-btn" href="login">Login</a></li>
							<?php endif; ?>
						</ul>
					</div>
				</div>
			</header>
			<div style="height: 65px">
				
			</div>

		<?php endif; ?>
		
		

	
