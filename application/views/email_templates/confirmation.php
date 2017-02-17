<html>
<head>
	<style>
		body {
			background: #ddd;
			font-family: sans-serif;
			font-weight: 300;
			font-size: 11pt;
			line-height: 150%;
			padding: 20px;
		}
		
		#container {
			width: 500px;
			padding: 20px;
			background: #fff;
			margin: 0 auto;
			border-radius: 10px;
			box-shadow: 0 0 10px rbga(0,0,0,0.5);
		}
		
		h1 {
			font-weight: 300;
		}
		
		table.table {
			margin: 15px 0;
			font-size: 10pt;
			border-collapse: collapse;
			width: 100%;
		}
		
		table.table td, table.table th {
			border: 1px solid #ddd;
			padding: 10px;
		}
		
		table.table th {
			background: #eee;
			text-align: left;
		}
		
	</style>
</head>
<body>
	
	<div id="container">
		
		<div style="text-align: center; padding: 10px 10px 30px 10px;">
			<img src="<?php echo base_url(); ?>email/maibasuh-logo.png" style="width: 50%" />
		</div>
		
		<h1>Order Confirmation</h1>
		<p>Hi <?php echo $name; ?></p>
		<p>We have received your order with the details as below:</p>
		
		<table class="table">
			<tr>
				<th class="label">Vehicle</th>
				<td class="input"><?php echo $order->vehicle_model; ?> (<?php echo $order->vehicle_plate_no; ?>)</td>
			</tr>
			<tr>
				<th class="label">Location</th>
				<td class="input"><?php echo $order->address; ?></td>
			</tr>
			<tr>
				<th class="label">Date/Time</th>
				<td class="input"><?php echo strtotime('h:iA', strtotime($order->appointment_time)); ?> <?Php echo date('l, j F Y', strtotime($order->appointment_date)); ?></td>
			</tr>
			<tr>
				<th class="label">Package Details</th>
				<td class="input">
					<?php echo $order->tasks; ?>
				</td>
			</tr>
			<?php if ($payable != 0): ?>
				<?php if ($order->voucher_code): ?>
					<tr>
						<th class="label">Amount</th>
						<td class="input">
							<strong>RM0.00 (Voucher: <?php echo $order->voucher_code; ?>)</strong>
						</td>
					</tr>
				
				<?php else: ?>				
					<tr>
						<th class="label">Amount</th>
						<td class="input">
							<strong>RM<?php echo number_format($payable); ?></strong>
						</td>
					</tr>
				<?php endif; ?>
			<?php else: ?>
			
			<tr>
				<th class="label">Amount</th>
				<td class="input">
					<strong>RM0.00 (Subscription Package)</strong>
				</td>
			</tr>
			
			<?php endif; ?>
			
		</table>

		<p>Our detailer will be in touch with you the soonest.</p>
		
		<p>Thank you,<br />
			<strong>MaiBasuh Team</strong>
		</p>
		
	</div>
</body>

</html>