<script type="text/javascript">
	
	$(document).ready(function(){
		var n = 0;
		$('.btn-next').click(function(e){
			e.preventDefault();
			
			if ($(this).parents('.hiw-form').find('input').length >= 1){
				if ($(this).parents('.hiw-form').find('input.ra').prop('checked')){
					n++;
					$(this).parents('.hiw-form').hide();
					var rel = $(this).parents('.hiw-form').attr('rel');
					$('li.'+rel+' span').remove();
					$('li.'+rel+'').prepend('<span><i class="green fa fa-check"></i></span> ');
					
					
					$('.hiw-form[n='+n+']').removeClass('none');
					var rel = $('.hiw-form[n='+n+']').attr('rel');
					$('li.'+rel+' span').remove();
					$('li.'+rel+'').prepend('<span><i class="blue fa fa-arrow-circle-right"></i></span> ');
				} else {
					$('div.notice').remove();
					$(this).parents('.hiw-form').prepend('<div class="notice">Whoops, please review this information and try the question again.</div>');
				}
			} else {
				n++;
				$(this).parents('.hiw-form').hide();
				$('.hiw-form[n='+n+']').removeClass('none');
				var rel = $('.hiw-form[n='+n+']').attr('rel');

				$('li.'+rel+' span').remove();
				$('li.'+rel+'').prepend('<span><i class="blue fa fa-arrow-circle-right"></i></span> ');
			}
		})
		
		$('.btn-primary').click(function(e){
			e.preventDefault();
			if ($(this).parents('.hiw-form').find('input.ra').prop('checked')){
				$(this).parents('form').submit();
			} else {
				alert('To continue, please tick the checkbox and confirm.')
			}
		})
	})
	
</script>

<div class="max1280 padding">
	<h1 class="thin">Complete Tutor Signup Steps</h1>
	<div class="tutor-signup-steps">
		<div class="tutor-signup-step tutor-signup-completed-step">
			<strong>1</strong> Select teaching subjects
		</div>
		<div class="tutor-signup-step tutor-signup-current-step">
			<strong>Step 2</strong> How MyTutor works
		</div>
		<div class="tutor-signup-step">
			<strong>3</strong> Your basic information
		</div>
		<div class="tutor-signup-step">
			<strong>4</strong> Personalize profile
		</div>
		<div class="tutor-signup-step">
			<strong>5</strong> Terms for tutoring with us
		</div>
		<div class="tutor-signup-step">
			<strong>6</strong> Confirm your email
		</div>
		
	</div>
</div>


<div class="max1024 padding min-height-600">
	<form method="post" action="tutor/submit_complete_signup/2">

		
		<div class="hiw-questionnaire-steps" style="float: left; width: 250px; border-right: 1px solid #eee; margin-right: 40px">
			<ul class="no-bullet spaced-list">
				<li class="relationship"><span><i class="blue fa fa-arrow-circle-right"></i></span> Relationship</li>
				<li class="new-students">New Students</li>
				<li class="payment">Payment</li>
				<li class="rules">Important Rules</li>				
			</ul>
			
		</div>
		<div class="hiw-questionaire-questions" style="padding-left: 300px;">
			<div class="hiw-form" rel="relationship" n="0">
				<h3>Your Relationship with MyTutor</h3>
				<p>In MyTutor's marketplace, you're an independent tutor in control of tutoring business. You have full responsbility
					and flexibility for settings up appointments with students and entering the lesson details into the system. You select
					which opportunities to pursue and how much to charge. A straightforward commission structure lets you know exactly how much
					you make from each lesson
				</p>
				<hr />
				<p class="align-right"> 
					<button class="btn btn-next">Next</button>
				</p>

			</div>
			
			<div class="hiw-form none" rel="relationship" n="1">
				
				<h3>What is the relationship between tutors	and MyTutor</h3>
				<p style="padding-left: 50px">
					<input name="q1" type="radio" style="margin-left: -50px; float: left" /> Tutors are volunteers working with MyTutor.
				</p>
				<p style="padding-left: 50px">
					<input name="q1" type="radio" class="ra" style="margin-left: -50px; float: left" /> Tutors are independent. They use MyTutor to find opportunities and manage the lesson logistics: including communication, scheduling and payment.
				</p>
				<p style="padding-left: 50px">
					<input name="q1" type="radio" style="margin-left: -50px; float: left" /> Tutors are employees of MyTutor.
				</p>
				<hr />
				<p class="align-right"> 
					<button class="btn btn-next">Next</button>
				</p>
			</div>
			
			<div class="hiw-form none" rel="new-students" n="2">
				<h3>How to find students</h3>
				<p>Our marketplace is structured to ensure that students can find the best tutors, and that active
					tutors receive student leads with a high match rate. A few things that will improve your match
					rate are your tutoring history, responsiveness and user feedback. This means that your rank will 
					improve by:
				</p>
				<ol>
					<li>Recording more tutoring hours with MyTutor</li>
					<li>Responding to new students within 24 hours</li>
					<li>Receiving high lesson ratings from your students</li>
				</ol>
				<hr />
				<p class="align-right"> 
					<button class="btn btn-next">Next</button>
				</p>

			</div>
			
			
			<div class="hiw-form none" rel="new-students" n="3">
				
				<h3>What factors will affect your match rate with students?</h3>
				<p style="padding-left: 50px">
					<input name="q2" type="radio" style="margin-left: -50px; float: left" /> The number of hours you've tutored through MyTutor.
				</p>
				<p style="padding-left: 50px">
					<input name="q2" type="radio" style="margin-left: -50px; float: left" /> Responding to new students in 24 hours or less.
				</p>
				<p style="padding-left: 50px">
					<input name="q2" type="radio" style="margin-left: -50px; float: left" /> Your average lesson rating.
				</p>
				<p style="padding-left: 50px">
					<input name="q2" type="radio" class="ra" style="margin-left: -50px; float: left" /> All of the above.
				</p>

				<hr />
				<p class="align-right"> 
					<button class="btn btn-next">Next</button>
				</p>
			</div>
			
			
			<div class="hiw-form none" rel="payment" n="4">
				<h3>Payment</h3>
				<p>Lorem ipsum dolor sit amet.</p>

				<hr />
				<p class="align-right"> 
					<button class="btn btn-next">Next</button>
				</p>

			</div>
			
			<div class="hiw-form none" rel="payment" n="5">
				
				<h3>Which of the following things affect MyTutor commission rate?</h3>
				<p style="padding-left: 50px">
					<input name="q3" type="radio" style="margin-left: -50px; float: left" /> Your average lesson rating
				</p>
				<p style="padding-left: 50px">
					<input name="q3" type="radio" style="margin-left: -50px; float: left" /> The number of hours you've tutored through MyTutor
				</p>
				<p style="padding-left: 50px">
					<input name="q3" type="radio" style="margin-left: -50px; float: left" /> The number of testimonials you've received from students
				</p>
				<p style="padding-left: 50px">
					<input name="q3" type="radio" class="ra" style="margin-left: -50px; float: left" /> All of the above.
				</p>

				<hr />
				<p class="align-right"> 
					<button class="btn btn-next">Next</button>
				</p>
			</div>
			
			<div class="hiw-form none" rel="rules" n="6">
				
				<h3>Congratulations, you've passed!</h3>
				<p>Click below to confirm your commitment with MyTutor's rules.</p>
				<p style="padding-left: 50px">
					<input type="checkbox" class="ra" style="margin-left: -50px; float: left" /> I promise to follow the MyTutor marketplace rules and provide great experience for my students.
				</p>

				<hr />
				<p class="align-right"> 
					<button class="btn btn-primary">Next Step</button>
				</p>
			</div>
		</div>
	
	</form>
</div>
