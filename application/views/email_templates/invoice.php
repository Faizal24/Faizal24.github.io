<html>
<head>
	<style>
		body {
			background: #fff;
			font-family: sans-serif;
			font-weight: 300;
			font-size: 11pt;
			line-height: 150%;
			padding: 20px;
		}
		
		#container {
			width: 600px;
			padding: 20px;
			background: #fff;
			margin: 0 auto;
			border-radius: 10px;
			box-shadow: 0 0 10px rbga(0,0,0,0.5);
		}
		
		h1, h3 {
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
			background: #f5f5f5;
			text-align: left;
		}
		
		table.table-inverse {
			margin: 15px 0;
			font-size: 10pt;
			border-collapse: collapse;
			width: 100%;
		}
		
		
		table.table-inverse td, table.table-inverse th {
			border: 1px solid #fff;
			background: #f5f5f5;
			padding: 10px;
		}
		
		
	</style>
</head>
<body>
	
	<div id="container">
		<h1 style="float:right">Tax Invoice</h1>
		<div style="padding: 10px 10px 30px 10px;">
			<img src="<?php echo base_url(); ?>email/maibasuh-logo.png" style="width: 50%" />
		</div>
		
		<table class="table-inverse">
			<tr>
				<td>
					<span style="color: #888">MAIBASUH ID</span><br />
					<?php echo $user->email; ?>
				</td>
				<td>
					<span style="color: #888">BILLED TO</span><br />
					<?php echo $user->name; ?>
				</td>
				<td>
					<span style="color: #888">TAX INVOICE ID</span><br />
					<?php echo $invoice_id; ?>
				</td>
			</tr>
			<tr>
				<td>
					<span style="color: #888">ORDER ID</span><br />
					<?php echo $order_id; ?>
				</td>
				<td></td>
				<td>
					<span style="color: #888">DATE</span><br />
					<?php echo date('j F Y', strtotime($date)); ?>
				</td>
			</tr>
		</table>
		
		
		<h3>Purchase Information</h3>
		
		<table class="table">
			<tr>
				<th>Item/Service</th>
				<th>Price (RM)</th>
			</tr>
			<tr>
				<td>
					<?php echo $item_name; ?>
				</td>
				<td style="text-align: center">
					<?php echo number_format($item_price,2); ?>
				</td>
			</tr>
			<tr>
				<td style="text-align: right">
					<span style="color: #888">TOTAL</span><br />
				</td>
				<td style="text-align: center">
					<strong><?php echo number_format($item_price,2); ?></strong>
				</td>
			</tr>
			<!--
			<tr>
				<td style="text-align: right">
					<span style="color: #888">GST</span><br />
				</td>
				<td style="text-align: center">
					<?php echo number_format($item_price*6/106,2); ?>
				</td>
			</tr>
			-->
		</table>
		
		
		
	</div>
</body>
</html>