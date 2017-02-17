<div class="max1280 padding">
	<h1 class="thin">Clients</h1>
</div>

<div class="grey-bg">
<div class="max1024 padding min-height-600">



	<?php foreach ($clients as $client): ?>
		<?php
			$user = $this->user->email($client->client);
		?>
		<div class="job-request">
			<div class="job-request-action">				
				<a href="tutor/client_details/<?php echo $user->id; ?>" class="btn mb-5 btn-block btn-green">View</a>
			</div>
			<div class="large-profile-photo" style="height: 80px; width: 80px; background-image: url('uploads/profile/<?php echo $user->photo; ?>')"></div>
			<h2><?php echo $user->firstname; ?> <?php echo $user->lastname; ?> </h2>
			Mobile: <?php echo $user->mobile; ?>			
		</div>
	
	<?php endforeach; ?>
	<?php if (!count($clients)): ?>
	<p><i>There are no clients requests so far.</i></p>
	<?php endif; ?>
</div>