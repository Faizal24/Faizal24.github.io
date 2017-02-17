<?php
	$me = $this->user->data();
?>
<div class="max1280 padding">
	<a style="margin-top: 15px" class="float-right btn" href="report_card">Back</a>
	<h1 class="thin">Report Card &raquo; Assessment</h1>
</div>

<div class="grey-bg">
<div class="max1024 padding min-height-600">	
	

	
	
	<div>
		

			<?php
				$assessment	= json_decode($session->assessment);
			?>
			<h3 class="thin">Assessment on <strong class="primary"><?php echo $info->student_name; ?></strong> during <strong class="primary"><?php echo $info->subject; ?> &mdash; <?php echo $info->grade; ?></strong> lesson on <strong class="primary"><?php echo date('j F Y',strtotime($session->date)); ?></strong></h3>
			
				
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
					<a class="btn" href="report_card">Done</a>
				</p>
				
				
		
		<div class="spacer"></div>
		<div class="spacer"></div>
		
	</div>

	
					
</div>

</div>