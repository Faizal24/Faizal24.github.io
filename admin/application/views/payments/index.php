<script type="text/javascript">
	
$(document).ready(function(){
	$('ul.tabs a').click(function(){
		$('div.tab-content').hide();
		var rel = $(this).attr('rel');
		$('div.tab-content[rel='+rel+']').show();
	})
	
	
})

</script>

<form method="get" action="payments" class="submit float-right">
	From <input value="<?php echo $from; ?>" type="text" name="from" class="date text w-100px" />
	To <input value="<?php echo $to; ?>" type="text" name="to" class="date text w-100px" />
	<input type="submit" class="btn btn-primary" value="Filter" />
</form>

<h1 class="main-separator-blue-tint">Payments &amp; Refunds</h1>

<div>
	<p>Showing records from <?php echo $from; ?> to <?php echo $to; ?></p>
</div>

<div class="project-content pt-15">
	<ul class="tabs mt-10">
		<li><a class="tab-current" rel="payments">Received Payments</a></li>
		<li><a rel="payables">Payables</a></li>
		<li><a rel="refunds">Refunds</a></li>
	</ul>
	
	<div class="tab-content tab-current" rel="payments">
				
		<table class="grid table-blue-header fw table-spaced">
			<thead>
				<tr>
					<th>Job Order ID</th>
					<th>Date/Time</th>
					<th>Parent</th>
					<th>Tutor</th>
					<th>Amount</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="5"><i>There are no payments received.</i></td>
				</tr>
			</tbody>
		</table>
		
	</div>

	<div class="tab-content" rel="payables" >
		
		<table class="grid table-blue-header fw table-spaced">
			<thead>
				<tr>
					<th>Job Order ID</th>
					<th>Date/Time</th>
					<th>Parent</th>
					<th>Tutor</th>
					<th>Job Amount</th>
					<th>MyTutor Commission</th>
					<th>Amount Payable</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="7"><i>There are no payables.</i></td>
				</tr>
			</tbody>
		</table>
		
	</div>


	<div class="tab-content" rel="refunds" >
		
		<table class="grid table-blue-header fw table-spaced">
			<thead>
				<tr>
					<th>Job Order ID</th>
					<th>Date/Time</th>
					<th>Parent</th>
					<th>Tutor</th>
					<th>Amount</th>
					<th>Reason</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="6"><i>There are no refund requests.</i></td>
				</tr>
			</tbody>
		</table>
		
	</div>

</div>