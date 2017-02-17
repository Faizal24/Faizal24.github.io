<div class="max1280 padding">
	<h1 class="thin">Tutor Test: <?php echo $subject->subject; ?> &mdash; <?php echo $subject->grade; ?></h1>
</div>

<div class="grey-bg">
<div class="max1024 padding min-height-600">

	<h1 class="thin">Welcome, <?php echo $this->user->data('firstname'); ?>!</h1>
	<p>Complete the test below. To pass the test you need to make sure to answer ALL questions correctly.</p>

	<hr />

	<form method="post" action="<?php echo base_url(); ?>tutor/complete_test/<?php echo $subject->id; ?>">

		<?php foreach ($questions as $question): ?>
		
		<p><strong><?php echo $question->question; ?></strong></p>


		<?php foreach (json_decode($question->answers) as $answer): ?>
		<div style="padding-left: 50px">
		<input <?php if ($responses[$question->number]->answer == $answer) echo 'checked'; ?> style="margin-left: -50px" type="radio" name="response[<?php echo $question->number; ?>]" value="<?php echo $answer; ?>" /> 
		<?php echo $answer; ?>
		</div>
		<?php endforeach; ?>

		
		<?php endforeach; ?>
		<br />
		<hr /><br />
		<p class="align-right">
			<input type="submit" class="btn btn-primary" value="Complete Test" />
		</p>
	
	</form>

</div>