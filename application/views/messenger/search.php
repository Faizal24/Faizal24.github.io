
	<?php $my_id = $this->user->userdata('id'); ?>
	<div class="messenger-search-container">
	
		<?php foreach ($users as $user): if ($my_id != $user->id): $x++ ?>
		<div class="messenger-search-result">
			<div class="messenger-photo">
				<?php _uimg($user, 50); ?>
			</div>
			<div class="messenger-info">
				<a class="btn btn-mid btn-grey float-right send-message" uid="<?php echo $user->id; ?>">Send Message</a>
				<a class="profile-link" href="<?php _uurl($user); ?>"><?php echo $user->name; ?></a>
				<span class="short-info">
				<?php echo $user->education_institution ? $ue = $user->education_institution : ''; ?>
				<?php echo ($ue ? ' &mdash; ' : '') . ($user->country ? $user->country : ''); ?>
				</span>
			</div>
			<div class="clear"></div>
		</div>
		<?php endif; endforeach; ?>
		
		<?php if (!$x): ?>
		<div class="padding"><i>No users found.</i></div>
		<?php endif; ?>
	
	
	</div>