<div class="max1280 padding">
	<h1 class="thin">Welcome, <?php echo $this->user->data('firstname'); ?>!</h1>
	<p>To get started, tell us a little more about yourself and your tutoring preferences.</p>

	<hr />

	<form method="post" action="<?php echo base_url(); ?>tutor/submit_complete_signup/0">

		<?php foreach ($questions as $question): ?>
		
		<p><strong><?php echo $question->question; ?></strong></p>


		<?php foreach (json_decode($question->answers) as $answer): ?>
		<div style="padding-left: 50px">
		<input <?php if ($responses[$question->number]->answer == $answer) echo 'checked'; ?> style="margin-left: -50px" type="radio" name="question[<?php echo $question->number; ?>]" value="<?php echo $answer; ?>" /> 
		<?php echo $answer; ?>
		</div>
		<?php endforeach; ?>

		
		<?php endforeach; ?>
		<br />
		<hr /><br />
		<p class="align-right">
			<input type="submit" class="btn btn-primary" value="Next" />
		</p>
	
	</form>
</div>
