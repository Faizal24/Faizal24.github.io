<div class="max1280 padding">
	<a href="tutor/dashboard#subjects" class="btn float-right" style="margin-top: 15px">Back</a>
	<h1 class="thin">Edit Subject</h1>
	<p>Change your rate per hour for the subject.</p>
	<hr />
</div>



<div class="max1024 padding min-height-600">
	<form method="post" action="<?php echo base_url(); ?>tutor/edit_subject/<?php echo $subject->id; ?>">
		
		<table class="grid">
			<thead>
				<tr>
					<th>Subject</th>
					<th style="width: 130px;">Rate</th>
				</tr>				
			</thead>
			<tbody>
				<tr>
					<td><?php echo $subject->subject; ?> &mdash; <?php echo $subject->grade; ?></td>
					<td style="text-align: center"><input style="width: 100px; text-align: center" type="text" class="text number" name="rate" value="<?php echo $subject->rate; ?>" /></td> 
				</tr>
			</tbody>
		</table>
		

		<p class="align-right">
			<input type="submit" name="submit" class="btn btn-primary" value="Save" />
		</p>
	
	</form>
</div>
