<style>
	
	.table {
		width: 100%;
		border-collapse: collapse;
	}
	

	.table td, .table th {
		padding: 10px;
		border: 1px solid #eee;
		font-size: 11pt;
	}
	
	.table th {
		background: #15b188;
		border: 1px solid #15b188;
		color: #fff;
		font-size: 11pt;
	}
	
	.table tr:nth-child(even) td {
		background: #f5f5f5;
		font-size: 11pt;
	} 
	
</style>
<div style="margin: -20px -15px 0 -15px; padding: 15px">

	<script type="text/javascript">
		
	$(document).ready(function(){
		var colors = [
			'#15b188',
			'#eebb00',
			'#2682d5',
			'#e2332a',
			'#27384c',
			'#23c759',
			'#e16a0b',
			'#874aa7',
			'#e6ecee',
			'#129273',
			'#f08b00',
			'#1e6aad',
			'#b4241c',
			'#222f3f',
			'#6b7a7a',
			'#20a44c',
			'#c83f00',
			'#7c269f',
			'#b0b6bb'
		];
										
		jsql.query("SELECT * FROM _charts ORDER BY `order` ASC", null, function(charts){
			for (var i in charts){
				var chart = charts[i];
				
				switch (chart.type){
					
					case "table":
						var styles = [];
						if (chart.height) styles.push('height: ' + chart.height + 'px;');
						var style = styles.join('; ');

						
						var chart_html = '<div class="span-box span-'+chart.span+'"><div style="'+style+'" class="chart-container"><h3>'+chart.title+'</h3><div class="chart-'+chart.id+'"></div></div>';

						$('.dashboard').append(chart_html);


						if (chart.y_axis.indexOf('|') < 0){
							var y_query = chart.y_axis+ ' AS `y` ';
							if (chart.order_limit){
								var order_y = chart.order_limit;
							} else {
								var order_y = ' ORDER BY `y` DESC';
							}
						} else {

							var axes = chart.y_axis.split('|');
							var axes_query = [];
							for (var y = 0; y < axes.length; y++){
								var axis = axes[y];
								axes_query.push(axis+ ' AS `y' + y + '` ');
							}

							var y_query = axes_query.join(', ');
							if (chart.order_limit){
								var order_y = chart.order_limit;
							} else {
								var order_y = '';
							}

						}
						
						var id = chart.id;
						
						new jsql.query('SELECT '+chart.x_axis+' AS `x` ,'+y_query+'  FROM '+chart.from+(chart.filters ? ' WHERE ' + chart.filters : '')+' GROUP BY `x` '+ order_y, chart,  function(res, chart){
							var labels = [];
							var data = [];
							var chartdata = [];
							
							console.log(res);
							
							if (chart.y_axis.indexOf('|') >= 0){
								var y_labels = chart.y_labels.split(',');
								
								var html = '<table class="table"><thead>';
								html	+= '<tr><th>'+chart.x_labels+'</th>';
								for (var i in y_labels){
									var y_label = y_labels[i];
									html	+= '<th>'+y_label+'</th>';									
								}
								html 	+= '</tr>';
								html 	+= '</thead><tbdoy>';
								
								var precision = [];
								precision = chart.y_precision.split(',');
		
								for (var i in res){
									var row = res[i];
									
									html += '<tr><td>'+row['x']+'</td>';
									for (var j = 0; j < y_labels.length; j++){
										if (precision[j]){
											var y = number_format(row['y'+j], precision[j]);
											var y_style = 'text-align: right';
										} else {
											var y = row['y'+j];
											var y_style = '';
										}
										html += '<td style="'+y_style+'">'+y+'</td>';
									}
									html += '</tr>';
								}

								
								html 	+= '</tbody></table>';
								$('.chart-'+chart.id).html(html);

							} else {
								
								var html = '<table class="table"><thead>';
								html 	+= '</thead><tbdoy>';
								html	+= '<tr><th>'+chart.x_labels+'</th><th>'+chart.y_labels+'</th></tr>';
								
								var total = 0;
								for (var i in res){
									var row = res[i];
									if (chart.y_precision){
										var y = number_format(parseFloat(row.y),parseInt(chart.y_precision));
										var y_style = 'text-align: right';
									} else {
										var y = row.y;
									}
									html	+= 	'<tr><td>'+row.x+'</td><td style="'+y_style+'">'+row.y+'</td></tr>';
									total += parseFloat(row.y);
								}
								html 	+= '</tbody></table>';
								$('.chart-'+chart.id).html(html);
							}
							
						});
						
					break;
					
					case "logo":
					
						$('.dashboard').append('<div style="clear:both"></div><img style="width: 30%" src="logo.png" />');					
					break;
					case "heading":
						var style = chart.style;
						
						$('.dashboard').append('<div style="clear:both"></div><h1 style="'+style+'">'+chart.title+'</h1>');
					break;
					case "separator":

						$('.dashboard').append('<div class="separator" style="clear:both"></div>');
					break;
					case "figure":
						var styles = [];
						if (chart.height){
							styles.push('height: ' + chart.height + 'px; display: table-cell; vertical-align: middle; width: 100%');
						}
						var style = styles.join('; ');
						var chart_html = '<div class="span-box span-'+chart.span+'" style="display: table"><div style="'+style+'" class="chart-container"><div class="chart-'+chart.id+'"></div></div></div>';				
						
						$('.dashboard').append(chart_html);

					
						var id = chart.id;
						var title = chart.title;
						console.log('SELECT '+chart.x_axis+' AS `figure` FROM '+chart.from + (chart.filters ? ' WHERE ' + chart.filters : ''));
						new jsql.query('SELECT '+chart.x_axis+' AS `figure` FROM '+chart.from + (chart.filters ? ' WHERE ' + chart.filters : ''), chart, function(res, chart){
							if (chart.x_precision){
								var figure = number_format(res[0].figure,chart.x_precision);
							} else {
								var figure = number_format(res[0].figure);
							}
						
							$('.chart-'+chart.id).html('<h1 style="font-weight: bold; text-align: center">'+figure+'</h1><p style="text-align: center">'+chart.title+'</p>');
						})
					
					break;
					case "figurecompare":
						var styles = [];
						if (chart.height){
							styles.push('height: ' + chart.height + 'px; display: table-cell; vertical-align: middle; width: 100%');
						}
						var style = styles.join('; ');
						
						var chart_html = '<div class="span-box span-'+chart.span+'" style="display: table"><div style="'+style+'" class="chart-container"><div class="chart-'+chart.id+'"></div></div></div>';				
						
						$('.dashboard').append(chart_html);

					
						var id = chart.id;
						var title = chart.title;

						new jsql.query('SELECT '+chart.x_axis+' AS `figure` FROM '+chart.from + (chart.filters ? ' WHERE ' + chart.filters : ''), chart, function(res, chart){
							
							if (chart.x_precision){
								var figure = number_format(res[0].figure,chart.x_precision);
								var compare = number_format(parseFloat(chart.y_axis),chart.x_precision);
							} else {
								var figure = number_format(res[0].figure);
								var compare = number_format(parseFloat(chart.y_axis));
							}

							var percent = parseFloat(res[0].figure) / parseFloat(chart.y_axis) * 100;
							percent = percent.toFixed(2);
							var prefix = chart.prefix ? chart.prefix : '';
							$('.chart-'+chart.id).html('<h1 style="font-weight: bold; text-align: center">'+prefix+figure+' <small style="font-weight:normal">vs</small> '+prefix+compare+' <span>('+percent+'%)</span></h1><p style="text-align: center">'+chart.title+'</p>');
						})
					
					break;
					case "bar":
					
						var styles = [];
						if (chart.height) height = chart.height;
						else height = '';

						var chart_html = '<div class="span-box span-'+chart.span+'"><div class="chart-container"><h3>'+chart.title+'</h3><div class="chart-'+chart.id+'"><canvas height="'+height+'" id="ch'+chart.id+'"></canvas></div></div>';

						$('.dashboard').append(chart_html);
						
						


						if (chart.y_axis.indexOf('|') < 0){
							var y_query = chart.y_axis+ ' AS `y` ';
							var order_y = ' ORDER BY `y` DESC';
						} else {

							var axes = chart.y_axis.split('|');
							var axes_query = [];
							for (var y = 0; y < axes.length; y++){
								var axis = axes[y];
								axes_query.push(axis+ ' AS `y' + y + '` ');
							}

							var y_query = axes_query.join(', ');
							var order_y = '';
						}
						
						var id = chart.id;
						
						console.log('SELECT '+chart.x_axis+' AS `x` ,'+y_query+'  FROM '+chart.from+(chart.filters ? ' WHERE ' + chart.filters : '')+' GROUP BY '+chart.x_axis+ ' '+ order_y);
						
						new jsql.query('SELECT '+chart.x_axis+' AS `x` ,'+y_query+'  FROM '+chart.from+(chart.filters ? ' WHERE ' + chart.filters : '')+' GROUP BY '+chart.x_axis+ ' '+ order_y, chart,  function(res, chart){
							var labels = [];
							var data = [];
							var chartdata = [];
							
							console.log(res);
							
							if (chart.y_axis.indexOf('|') >= 0){
								var dataset = [];
								var axes = chart.y_axis.split('|');
								var axes_query = [];
								var y_labels = chart.y_labels.split(',');
								var labels = [];
								

								
								for (var y = 0; y < axes.length; y++){
									var axis = axes[y];
									var data = [];
									labels = [];
									
									for (var j in res){
										if (res[j].x && res[j]['y'+y] != 0){
											y_labels.push(res[j].x);
											data.push(parseFloat(res[j]['y'+y]));
										}
									}
									
									var set = {
										label: y_labels[y],
										data: data,
										backgroundColor: colors[y]
									}
									
									dataset.push(set)
									
								}
								


								for (var j in res){
									if (res[j].x){
										labels.push(res[j].x);
									}
								}
								
								
								
								var ctx = document.getElementById('ch'+chart.id).getContext('2d');
								new Chart(ctx, {
									type: 'bar',
									data: {
										labels: labels,
										datasets: dataset
									}
								});

							} else {
								
								

								var cl = [];
								if (chart.x_labels){
									cl = JSON.parse(chart.x_labels);
									
								}
															
								for (var j in res){
									if (res[j].x && res[j].y != 0){
										if (cl[res[j].x]){
											labels.push(cl[res[j].x]);
										} else {
											labels.push(res[j].x);
										}
										data.push(parseFloat(res[j].y));
									}
								}
								

								
								var ctx = document.getElementById('ch'+chart.id).getContext('2d');
								new Chart(ctx, {
									type: 'bar',
									options: {
										scales: {
											yAxes: [
												{
													ticks: {
														beginAtZero: true
													}
												}
											]
										},
										legend: {
											display: false
										},
										segmentShowStroke: false
									},
									data: {
										labels: labels,
										datasets: [{
											data: data,
											backgroundColor: colors
										}]
									}
								});
								
							}
							
						})
						
					break;
					case "doughnut":
						var styles = [];
						if (chart.height) height = chart.height;
						else height = '';
					
						var chart_html = '<div class="span-box span-'+chart.span+'"><div class="chart-container"><h3>'+chart.title+'</h3><div class="chart-'+chart.id+'"><canvas height="'+height+'" id="ch'+chart.id+'"></canvas><div class="legend"></div></div></div>';

						$('.dashboard').append(chart_html);
	
						var id = chart.id;
						new jsql.query('SELECT '+chart.x_axis+' AS `x` ,'+chart.y_axis+' AS `y` FROM '+chart.from+(chart.filters ? ' WHERE ' + chart.filters : '')+' GROUP BY '+chart.x_axis+ ' ORDER BY y DESC', chart,  function(res, chart){
							var labels = [];
							var data = [];
							
							for (var j in res){
								if (res[j].x && res[j].y != 0){
									labels.push(res[j].x);
									data.push(parseFloat(res[j].y));
								}
							}
							var ctx = document.getElementById('ch'+chart.id).getContext('2d');
							new Chart(ctx, {
								type: 'doughnut',
								options: {
									legend: {
										position: 'right',
										labels: {
											boxWidth: 11
										}
									},
									segmentShowStroke: false
								},
								data: {
									labels: labels,
									datasets: [{
										data: data,
										backgroundColor: colors
									}]
								},
							});
	
							
						})
					break;
					case "pie":
					
						var styles = [];
						if (chart.height) height = chart.height;
						else height = '';
					
						var chart_html = '<div class="span-box span-'+chart.span+'"><div class="chart-container"><h3>'+chart.title+'</h3><div class="chart-'+chart.id+'"><canvas height="'+height+'" id="ch'+chart.id+'"></canvas><div class="legend"></div></div></div>';

						$('.dashboard').append(chart_html);
	
						var id = chart.id;
						new jsql.query('SELECT '+chart.x_axis+' AS `x` ,'+chart.y_axis+' AS `y` FROM '+chart.from+(chart.filters ? ' WHERE ' + chart.filters : '')+' GROUP BY '+chart.x_axis+ ' ORDER BY y DESC', chart,  function(res, chart){
							var labels = [];
							var data = [];
							
							for (var j in res){
								if (res[j].x && res[j].y != 0){
									labels.push(res[j].x);
									data.push(parseFloat(res[j].y));
								}
							}
							var ctx = document.getElementById('ch'+chart.id).getContext('2d');
							new Chart(ctx, {
								type: 'pie',
								options: {
									legend: {
										position: 'right',
										labels: {
											boxWidth: 11
										}
									},
									segmentShowStroke: false
								},
								data: {
									labels: labels,
									datasets: [{
										data: data,
										backgroundColor: colors
									}]
								},
							});
							
	
							
						})
					break;
					case "polar":
					
						var chart_html = '<div class="span-box span-'+chart.span+'"><div class="chart-container"><h3>'+chart.title+'</h3><div class="chart-'+chart.id+'"><canvas id="ch'+chart.id+'"></canvas></div></div>';

						$('.dashboard').append(chart_html);
	
						var id = chart.id;
						new jsql.query('SELECT '+chart.x_axis+' AS `x` ,'+chart.y_axis+' AS `y` FROM '+chart.from+(chart.filters ? ' WHERE ' + chart.filters : '')+' GROUP BY '+chart.x_axis+ ' ORDER BY y DESC', chart,  function(res, chart){
							var labels = [];
							var data = [];
							
							for (var j in res){
								if (res[j].x && res[j].y != 0){
									labels.push(res[j].x);
									data.push(parseFloat(res[j].y));
								}
							}
							var ctx = document.getElementById('ch'+chart.id).getContext('2d');
							new Chart(ctx, {
								type: 'polarArea',
								data: {
									labels: labels,
									datasets: [{
										data: data,
										backgroundColor: colors
									}]
								},
							});
	
							
						})
					break;
				}
				
	
			}
			
			$('.dashboard').append('<div style="clear:both"></div>');
		})
		
	})
		
	</script>
	<div style="max-width: 1000px; margin: 0 auto;">
		<div class="dashboard" style="min-height: 100%; padding: 0px;">
			
		</div>
	</div>
	