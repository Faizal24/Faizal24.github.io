<?php
	$me = $this->user->data();
?>
<div class="spacer"></div>

<div class="max1024 padding">
	
	
	<?php if ($this->session->flashdata('review_submitted')): ?>
	<p class="success">Your review has been submitted.</p>
	<div class="spacer"></div>
	<?php endif; ?>

	
	
	<div class="tutor-profile-photo" style="background-image: url('uploads/profile/<?php echo $tutor->photo; ?>')"></div>
	<div class="tutor-details">
		
		<?php if ($review->id): ?>
		
			<h3>Your review on <?php echo $tutor->firstname; ?> <?php echo $tutor->lastname; ?></h2>
			<p>
			<?php if ($review->review): ?>
			<?php echo nl2br($review->review); ?>
			<?php endif; ?>
			</p>
			<p class="primary">
				<?php for ($i = 0; $i < $review->rating; $i++): ?>
				<i class="fa fa-star"></i>
				<?php endfor; ?>
			</p>
			
			
			
		<?php else: ?>
			<h2>Submit a Review on <?php echo $tutor->firstname; ?> <?php echo $tutor->lastname; ?></h2>
			
			
			
			<form method="post">
				
				<p>Your review</p>
				
				
				
				<textarea name="review" placeholder=""  class="textarea"></textarea>
				<br />
				<p>Your rating</p>
				<?php if ($error['rating']): ?>
				<p class="error"><?php echo $error['rating']; ?></p>
				<?php endif; ?>
				<label class="red-hover"><input type="radio" value="1" name="rating" /> <i class="fa fa-star"></i> </label> &nbsp;&nbsp;&nbsp;
				<label class="red-hover"><input type="radio" value="2" name="rating" /> <i class="fa fa-star"></i><i class="fa fa-star"></i> </label> &nbsp;&nbsp;&nbsp;
				<label class="red-hover"><input type="radio" value="3" name="rating" /> <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> </label> &nbsp;&nbsp;&nbsp;
				<label class="red-hover"><input type="radio" value="4" name="rating" /> <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> </label> &nbsp;&nbsp;&nbsp;					
				<label class="red-hover"><input type="radio" value="5" name="rating" /> <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> </label>		
				<br /><br />
				<hr />
				<p class="align-right">
					<a href="mytutor/details/<?php echo $req_id; ?>">Cancel</a> 	 &nbsp;&nbsp;		<input type="submit" name="submit" class="btn btn-primary" value="Submit" />
				</p>
				
				
			</form>
		
		<?php endif; ?>
		
		<div class="spacer"></div>
		<div class="spacer"></div>
		
	</div>

	
					
</div>
