<div class="max1280 padding">
	<h1 class="thin">Complete Tutor Signup Steps</h1>
	<div class="tutor-signup-steps">
		<div class="tutor-signup-step tutor-signup-current-step">
			<strong>Step 1</strong> Select teaching subjects
		</div>
		<div class="tutor-signup-step">
			<strong>2</strong> How MyTutor works
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
	<form method="post" action="<?php echo base_url(); ?>tutor/submit_complete_signup/1">

		<p>Select 1-3 subjects you'd like to tutor. You can add more later once are done signing up.</p>
		
		<?php 
			$subjects = $this->system->get_subjects(); 
			foreach ($this->user->tutor_subjects($this->user->data()) as $s){
				$my_subjects[$s->subject . '|' . $s->grade] = true;
			}
		?>
		
		
		<?php 
			foreach ($subjects as $subject){
				$sub[$subject->value][] = $subject->grade;
			}
		?>
		
		<?php foreach ($sub as $subject => $grades): ?>
		<div>
			<h4><?php echo $subject; ?></h4>
			<ul class="no-bullet">
				<?php foreach ($grades as $grade): ?>
				<li><input <?php if ($my_subjects[$subject.'|'.$grade]) echo 'checked'; ?>  ( type="checkbox" name="subject_grade[]" value="<?php echo $subject;?>|<?php echo $grade; ?>" /> <?php echo $grade; ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
		
		<?php endforeach; ?>
		
		<hr />
		<p class="align-right">
			<input type="submit" class="btn btn-primary" value="Next" />
		</p>
	
	</form>
</div>
