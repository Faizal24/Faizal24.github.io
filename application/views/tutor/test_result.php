<div class="max1280 padding">
	<h1 class="thin">Tutor Test: <?php echo $subject->subject; ?> &mdash; <?php echo $subject->grade; ?></h1>
</div>

<div class="grey-bg">
<div class="max1024 padding min-height-600">

	<h1 class="thin">You have completed the test.</h1>
	<p>You have <?php echo $passed ? 'PASSED' : 'FAILED'; ?> the test. </p>

	<hr />

		<?php foreach ($questions as $question): ?>
		
		<?php if ($incorrect[$question->number]): ?>
		<p class="red"><strong><?php echo $question->question; ?></strong></p>
		<?php else: ?>
		<p class="green"><strong><?php echo $question->question; ?></strong></p>		
		<?php endif; ?>


		<?php foreach (json_decode($question->answers) as $answer): ?>
		<div style="padding-left: 50px">
		<input <?php if ($responses[$question->number] == $answer) echo 'checked'; ?> style="margin-left: -50px" type="radio" name="question[<?php echo $question->number; ?>]" value="<?php echo $answer; ?>" /> 
		<?php echo $answer; ?>
		</div>
		<?php endforeach; ?>

		
		<?php endforeach; ?>
		
		<br />
		<hr />
		<br />
		
		

		
		

		<p class="align-right">
			<?php if (!$passed): ?>
				<a class="btn btn-primary" href="tutor/test/<?php echo $subject->id; ?>">Retake Test</a>
			<?php else: ?>
				<a class="btn btn-primary" href="tutor/dashboard">Go to Dashboard</a>
			<?php endif; ?>			
		</p>
	

</div>