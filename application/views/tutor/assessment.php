<?php
	$me = $this->user->data();
?>
<div class="max1280 padding">
	<h1 class="thin">Schedule &raquo; Student Assessment</h1>
	<p>Submit your assessment of your student during this session.</p>
</div>

<div class="grey-bg">
<div class="max1024 padding min-height-600">	
	
	<?php if ($this->session->flashdata('review_submitted')): ?>
	<p class="success">Your review has been submitted.</p>
	<div class="spacer"></div>
	<?php endif; ?>

	
	
	<div>
		
		<?php if ($session->assessment): ?>
			<?php
				$assessment	= json_decode($session->assessment);
			?>
			<h3 class="thin">Your assessment on <strong class="primary"><?php echo $info->student_name; ?></strong> during <strong class="primary"><?php echo $info->subject; ?> &mdash; <?php echo $info->grade; ?></strong> lesson on <strong class="primary"><?php echo date('j F Y',strtotime($session->date)); ?></strong></h3>
			
				
				<p>
					<div style="float: right">
						<label class="<?php if ($assessment->communication == 1) echo 'primary assess-bold'; ?> red-hover">1</label> &nbsp;&nbsp;&nbsp;
						<label class="<?php if ($assessment->communication == 2) echo 'primary assess-bold'; ?> red-hover">2</label> &nbsp;&nbsp;&nbsp;
						<label class="<?php if ($assessment->communication == 3) echo 'primary assess-bold'; ?> red-hover">3</label> &nbsp;&nbsp;&nbsp;
						<label class="<?php if ($assessment->communication == 4) echo 'primary assess-bold'; ?> red-hover">4</label> &nbsp;&nbsp;&nbsp;					
						<label class="<?php if ($assessment->communication == 5) echo 'primary assess-bold'; ?> red-hover">5</label>		
					</div>
					<label style="display: inline-block; width: 200px">Communication</label>
				</p>
				
				<hr />

				<p>
					<div style="float: right">
						<label class="<?php if ($assessment->behavior == 1) echo 'primary assess-bold'; ?> red-hover">1</label> &nbsp;&nbsp;&nbsp;
						<label class="<?php if ($assessment->behavior == 2) echo 'primary assess-bold'; ?> red-hover">2</label> &nbsp;&nbsp;&nbsp;
						<label class="<?php if ($assessment->behavior == 3) echo 'primary assess-bold'; ?> red-hover">3</label> &nbsp;&nbsp;&nbsp;
						<label class="<?php if ($assessment->behavior == 4) echo 'primary assess-bold'; ?> red-hover">4</label> &nbsp;&nbsp;&nbsp;					
						<label class="<?php if ($assessment->behavior == 5) echo 'primary assess-bold'; ?> red-hover">5</label>		
					</div>
					<label style="display: inline-block; width: 200px">Behavior</label>
				</p>
				
				<hr />
				
				<p>
					<div style="float: right">
						<label class="<?php if ($assessment->comprehension == 1) echo 'primary assess-bold'; ?> red-hover">1</label> &nbsp;&nbsp;&nbsp;
						<label class="<?php if ($assessment->comprehension == 2) echo 'primary assess-bold'; ?> red-hover">2</label> &nbsp;&nbsp;&nbsp;
						<label class="<?php if ($assessment->comprehension == 3) echo 'primary assess-bold'; ?> red-hover">3</label> &nbsp;&nbsp;&nbsp;
						<label class="<?php if ($assessment->comprehension == 4) echo 'primary assess-bold'; ?> red-hover">4</label> &nbsp;&nbsp;&nbsp;					
						<label class="<?php if ($assessment->comprehension == 5) echo 'primary assess-bold'; ?> red-hover">5</label>		
					</div>
					<label style="display: inline-block; width: 200px">Comprehension</label>
				</p>
				<hr />

				<h3>Summary</h3>
				<?php echo nl2br($assessment->summary); ?>
				
				<br />
				<hr />
				
				<p class="align-right">
					<a class="btn" href="tutor/schedule">Back</a>
				</p>
				
				
		<?php else: ?>
			<h3 class="thin">Submit your assessment on <strong class="primary"><?php echo $info->student_name; ?></strong> during <strong class="primary"><?php echo $info->subject; ?> &mdash; <?php echo $info->grade; ?></strong> lesson on <strong class="primary"><?php echo date('j F Y',strtotime($session->date)); ?></strong></h3>
			
			
			
			<form method="post">
				
				<p>
					<div style="float: right">
						<label class="red-hover"><input type="radio" value="1" name="assessment[communication]" /> 1</label> &nbsp;&nbsp;&nbsp;
						<label class="red-hover"><input type="radio" value="2" name="assessment[communication]" /> 2</label> &nbsp;&nbsp;&nbsp;
						<label class="red-hover"><input type="radio" value="3" name="assessment[communication]" /> 3</label> &nbsp;&nbsp;&nbsp;
						<label class="red-hover"><input type="radio" value="4" name="assessment[communication]" /> 4</label> &nbsp;&nbsp;&nbsp;					
						<label class="red-hover"><input type="radio" value="5" name="assessment[communication]" /> 5</label>		
					</div>
					<label style="display: inline-block; width: 200px">Communication</label>
				</p>
				
				<hr />

				<p>
					<div style="float: right">
						<label class="red-hover"><input type="radio" value="1" name="assessment[behavior]" /> 1</label> &nbsp;&nbsp;&nbsp;
						<label class="red-hover"><input type="radio" value="2" name="assessment[behavior]" /> 2</label> &nbsp;&nbsp;&nbsp;
						<label class="red-hover"><input type="radio" value="3" name="assessment[behavior]" /> 3</label> &nbsp;&nbsp;&nbsp;
						<label class="red-hover"><input type="radio" value="4" name="assessment[behavior]" /> 4</label> &nbsp;&nbsp;&nbsp;					
						<label class="red-hover"><input type="radio" value="5" name="assessment[behavior]" /> 5</label>		
					</div>
					<label style="display: inline-block; width: 200px">Behavior</label>
				</p>
				
				<hr />
				
				<p>
					<div style="float: right">
						<label class="red-hover"><input type="radio" value="1" name="assessment[comprehension]" /> 1</label> &nbsp;&nbsp;&nbsp;
						<label class="red-hover"><input type="radio" value="2" name="assessment[comprehension]" /> 2</label> &nbsp;&nbsp;&nbsp;
						<label class="red-hover"><input type="radio" value="3" name="assessment[comprehension]" /> 3</label> &nbsp;&nbsp;&nbsp;
						<label class="red-hover"><input type="radio" value="4" name="assessment[comprehension]" /> 4</label> &nbsp;&nbsp;&nbsp;					
						<label class="red-hover"><input type="radio" value="5" name="assessment[comprehension]" /> 5</label>		
					</div>
					<label style="display: inline-block; width: 200px">Comprehension</label>
				</p>
				

				
				<textarea name="assessment[summary]" placeholder="Summary"  class="textarea"></textarea>
				<br />
				<hr />
				
				<p class="align-right">
					<a href="tutor/schedule">Cancel</a> 	 &nbsp;&nbsp;		<input type="submit" name="submit" class="btn btn-primary" value="Submit" />
				</p>

				
			</form>
		
		<?php endif; ?>
		
		<div class="spacer"></div>
		<div class="spacer"></div>
		
	</div>

	
					
</div>

</div>