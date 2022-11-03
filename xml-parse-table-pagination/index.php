<?php include('pagination.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
	<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>	
</head>
<body>
<div class="container">
	<div style="height: 20px;"></div>
	<div class="row">
		<div class="col-lg-2">
		</div>
		<div class="col-lg-8">
			<div class="mb-3 row">
				<div class="col-sm-6">
					<div class='input-group date' id='datetimepicker1'>
						<input type='text' class="form-control" />
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
				<div class="col-sm-6">
					<button type="button" id="search" class="input-group btn btn-primary">Search</button>
				</div>
			</div>
			<h4>impressions: <?=$list['grandTotal']['@attributes']['impressions']?></h4>
			<h4>totalClicks: <?=$list['grandTotal']['@attributes']['totalClicks']?></h4>
			<h4>estimatedRevenue: <?=$list['grandTotal']['@attributes']['estimatedRevenue']?></h4>
			<table width="80%" class="table table-striped table-bordered table-hover">
				<thead>
					<th>No</th>
					<th>Keyword</th>
					<th>Total Impressions</th>
					<th>Total Clicks</th>
					<th>Total Revenue</th>
				</thead>
				<tbody>
				<?php
					$no = 0;
					foreach ($infos as $key => $v) {
						$no++;
				?>
						<tr>
							<td><?php echo $no; ?></td>
							<td><a href="#" onclick="showHours('<?php echo $v['date']; ?>');"><?php echo $key; ?></a></td>
							<td><?php echo $v['impressions']; ?></td>
							<td><?php echo $v['totalClicks']; ?></td>
							<td><?php echo '$'.$v['estimatedRevenue']; ?></td>
						</tr>
				<?php
					}		
				?>
				</tbody>
			</table>
			<div id="pagination_controls" style="text-align: center;"><?php echo $paginationCtrls; ?></div>
		</div>
		<div class="col-lg-2">
		</div>
	</div>
</div>

<script type="text/javascript">
	$(function () {
		$('#datetimepicker1').datetimepicker({
			format: 'MM/DD/YYYY',
			defaultDate: '<?=$date?>'
		});

		$('#search').on('click', function () {
			var date = $('#datetimepicker1').find("input").val();
			location.href = "index.php?pn="+<?=$pagenum?>+"&d=" + date;
		});
	});

	function showHours(hours) {
		alert(hours);
	}
</script>
</body>
</html>