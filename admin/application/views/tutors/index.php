

<form method="get" action="#tutors/page" class="submit float-right">
	<input value="<?php echo $term; ?>" type="text" class="text" name="term" placeholder="Search" />
</form>

<h1 class="main-separator-blue-tint">Tutors</h1>
<div class="spacer"></div>

<table class="grid table-spaced table-collapse table-full-width">
	<thead>
		<tr>
			<th>Name</th>
			<th>Email</th>
			<th class="w-150px">Registered On</th>
			<th class="w-150px">Account Status</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($users as $user): ?>
		<tr href="tutors/view/<?php echo $user->id; ?>" class="link">
			<td><?php echo $user->firstname . ' ' . $user->lastname; ?></td>
			<td><?php echo $user->email; ?></td>
			<td class="align-center"><?php echo date('j F Y', strtotime($user->registered_on)); ?></td>
			<td class="align-center"><?php echo $user->status; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>



<p>
	Showing <?php echo count($users); ?> of <?php echo $total_users; ?>. Page <?php echo $page; ?> of <?php echo $total_pages; ?>
</p>
<hr />

<p class="pagination">
	<?php
		$from 			= $page - 5 < 1 ? 1 : $page - 5;
		$to 			= $page + 5 > $total_pages ? $total_pages : $page + 5;
		$search_filter	= $term ? '?term=' . urlencode($term) : '';
	?>
	
	<?php if ($page != 1): ?>
	<a class="link btn" href="users/page/1<?php echo $search_filter; ?>">&laquo;</a>
	<?php endif; ?>
	<?php for ($i = $from; $i <= $to; $i++): ?>
		<?php if ($i == $page): ?>
			<a class="btn btn-no-style"><?php echo $i; ?></a>
		<?php else: ?>
			<a class="link btn" href="users/page/<?php echo $i; ?><?php echo $search_filter; ?>"><?php echo $i; ?></a>
		<?php endif; ?>
	<?php endfor; ?>
	<?php if ($page != $to): ?>
	<a class="link btn" href="users/page/<?php echo $total_pages; ?><?php echo $search_filter; ?>">&raquo;</a>
	<?php endif; ?>

</p>
