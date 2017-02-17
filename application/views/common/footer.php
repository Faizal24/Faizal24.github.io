		<footer class="footer">
			<div class="row">
				<div style="position:center;padding-left:150px;"class="col-lg-12">
					<div class="col-sm-3">
						<h2 style="color:white;"><b>TeachMe</b></h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div style="position:center;padding-left:150px;"class="col-lg-12">
					<div class="col-sm-3"><br>
						<p style="color:white;font-family:Open Sans">Address</p>
						<p style="color:white;">+6012 345 6789</p>
						<p style="color:white;">support@teachme.com</p>
					</div>
					<div class="col-sm-3"><br>
						<p style="color:white;"><b>Company</b></p>
						<a href="about" style="text-decoration:none"><p style="color:white;">About</p></a>
						<a href="about" style="text-decoration:none"><p style="color:white;">Careers</p></a>
						<a href="about" style="text-decoration:none"><p style="color:white;">Help</p></a>
						<a href="about" style="text-decoration:none"><p style="color:white;">Terms of service</p></a>
						<a href="about" style="text-decoration:none"><p style="color:white;">Privacy Policy</p></a>
					</div>
					<div class="col-sm-3"><br>
						<p style="color:white;"><b>Discover</b></p>
						<a href="about" style="text-decoration:none"><p style="color:white;">Search for a tutor</p></a>
						<a href="about" style="text-decoration:none"><p style="color:white;">Become a tutor</p></a>
					</div>
				</div>
				<div class="spacer"></div>
				<hr class="white" />
				<div class="spacer"></div>
			</div>
		</footer>
<!--
		<footer>
			<div class="max1280">

				<h1 class="white">TeachMe</h1>
				<div class="g">
					<div class="sm-1-2 md-1-2 lg-1-4 thin">
						<p>
							Address
						</p>
						<p>
							+6012 345 6789<br />
							support@teachme.com
						</p>
					</div>
					<div class="sm-1-2 md-1-2 lg-1-4">
						<p>
							<strong>Company</strong>
							<ul class="thin no-bullet">
								<li><a href="about">About</a></li>
								<li><a href="careers">Careers</a></li>
								<li><a href="help">Help</a></li>
								<li><a href="tos">Terms of Service</a></li>
								<li><a href="privacy">Privacy Policy</a></li>
							</ul>
						</p>
					</div>
					<div class="sm-1-2 md-1-2 lg-1-4">
						<p>
							<strong>Discover</strong>
							<ul class="thin no-bullet">
								<li><a href="search">Search for a tutor</a></li>
								<li><a href="tutor/sign_up">Become a tutor</a></li>
							</ul>
						</p>
					</div>
				</div>
				<div class="spacer"></div>
				<hr class="white" />
				<div class="spacer"></div>
			</div>
		</footer>
		-->
		<div class="overlay">
			
		</div>
		<div class="sign-up overlay-form">
			<div id="sign-up-form">
				<form method="post">
					<a class="close-sign-up close-form">&times;</a>
					<h1 class="sign-up-header">Sign up</h1>
					<p>Sign up with <a href="#">Facebook</a> or <a href="#">Google</a></p>
					
					<div class="input"><input type="text" name="firstname" placeholder="First name" class="block text w100" /></div>
					<div class="input"><input type="text" name="lastname" placeholder="Last name" class="block text w100" /></div>
					<div class="input none field-gender"><?php echo form_dropdown('gender', array(''=>'Select Gender','Male'=>'Male','Female'=>'Female'), '', 'class="block w100"'); ?></div>
					<div class="input"><input type="text" name="email" placeholder="Email" class="block text w100" /></div>
					<div class="input"><input type="password" name="password" placeholder="Password" class="block text w100" /></div>
					<div class="input"><input type="password" name="rpassword" placeholder="Retype password" class="block text w100" /></div>

					<div class="tnc">
						<input type="checkbox" name="tnc" value="1" class="agree" /> I agree to the <a href="tos">Terms of Service</a> and <a href="privacy">Privacy Policy</a><br />
						<input type="hidden" name="psuedotnc" />
					</div>
					<input type="submit" class="btn btn-primary" style="width:290px;" value="Sign up" />
				</form>
			</div>
		</div>
		
		<div class="mobile-confirm overlay-form">
			<div id="mobile-confirm-form">

				<form method="post">
					<h3>Confirm your mobile number</h3>
					<p>This is so your tutor can contact you, and so MyTutor knows how to reach you.</p>
					<input type="hidden" name="h" />
					<input type="hidden" name="i" />
					<div class="input align-center">
						<i class="fa fa-mobile" style="font-size: 130px"></i><br />
						<input type="text" name="mobile" placeholder="012-345 6789" class="text tel w100" />
					</div>
					<div class="spacer"></div>
					<div class="spacer"></div>
					<input type="submit" class="btn btn-primary" value="Confirm phone number" />
				</form>
			</div>
		</div>
		
		<div class="mobile-auth overlay-form">
			<div id="mobile-auth-form">

				<form method="post">
					<h3>Enter 4-digit code</h3>
					<p>We've sent an SMS to <span class="mobile-no-auth"></span>. Enter that code here.</p>
					<input type="hidden" name="h" />
					<input type="hidden" name="i" />
					<div class="input align-center">
						<i class="fa fa-mobile" style="font-size: 130px"></i><br />
						<input type="text" name="code" placeholder="xxxx" class="text code w100" />
						<p>
							<a href="#" id="mobile-auth-change-number">Change my number</a> &middot;
							<a href="#" id="mobile-auth-resend">Send code again</a>
						</p>
					</div>
					<div class="spacer"></div>
				</form>
			</div>
		</div>
		
		<div class="login">
			<div id="login-form">
				<form method="post" action="login/auth">
					<a class="close-login close-form">&times;</a>
					<h1>Login</h1>
					<p>Login with <a href="#">Facebook</a> or <a href="#">Google</a></p>
					
					<div class="input"><input type="text" name="email" placeholder="Email" class="block text w100" /></div>
					<div class="input"><input type="password" name="password" placeholder="Password" class="block text w100" /></div>

					<div class="input">
						<a href="password_reset/forgot_password">Forgot your password? </a>
					</div>
					<div class="spacer"></div>
					
					<input type="submit" class="btn btn-primary" style="width:290px;" value="Go" />
				</form>
			</div>

		</div>
		
		<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key=AIzaSyC5mRhPydpTCquRcWUG-GxdAA4BmHx1v50" type="text/javascript"></script>
		<script type="text/javascript" src="js/places.js"></script>

	</body>
</html>
