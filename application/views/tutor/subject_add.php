<div class="max1280 padding">
	<a href="tutor/dashboard#subjects" class="btn float-right" style="margin-top: 15px">Back</a>
	<h1 class="thin">Add Subject</h1>
	<p>Choose the subject you would like to add.</p>
	<hr />
</div>



<div class="max1024 padding min-height-600">
	<form method="post" action="<?php echo base_url(); ?>tutor/add_subject">
		
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
				<?php if (!$my_subjects[$subject.'|'.$grade]): ?>
				<li>
				
					<input type="checkbox" name="subject_grade[]" value="<?php echo $subject;?>|<?php echo $grade; ?>" /> <?php echo $grade; ?>
				</li>
				<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		</div>
		
		<?php endforeach; ?>
		
		<hr />
		<p class="align-right">
			<input type="submit" name="submit" class="btn btn-primary" value="Add" />
		</p>
	
	</form>
</div>
