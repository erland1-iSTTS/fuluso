<?php
use yii\helpers\Url;
use yii\helpers\Html;
use richardfan\widget\JSRegister;
use app\models\MasterNewJob;

date_default_timezone_set('Asia/Jakarta');
?>

<style type="text/css">
	.btn,
	table tbody tr th,
	table tbody tr td{
		font-size: 10px;
	}
	
	.table-hover tbody tr:hover{
		background-color: #F0F8FF !important;
	}
</style>

<button class="btn btn-dark mb-4" onclick="location.href = '<?= Url::base().'/job/create'?>'">Create New Job</button>

<div class="row mb-3">
	<div class="pl-3 pt-2 pr-2">Search [Job & Customer] </div>
	<div class="col-3 pl-0">
		<input type="text" class="form-control" id="input-search" value="<?= $filter_search ?>"></input>
	</div>
	
	<div class="pl-3 pt-2 pr-2">Month / Year </div>
	<div class="col-1 pl-0 pr-1">
		<select class="form-control" id="filter-month">
			<?php for($i=1;$i<13;$i++){ 
				
				if(empty($filter_month)){
					if($i == date('n')){
						$selected = 'selected';
					}else{
						$selected = '';
					}
				}else{
					if($i == $filter_month){
						$selected = 'selected';
					}else{
						$selected = '';
					}
				}
			?>
				<option value="<?= $i ?>" <?= $selected ?>> <?= strtoupper(date('M', mktime(0, 0, 0, $i, 10))) ?></option>
			<?php } ?>
		</select>
	</div>
	<div class="col-1 pl-0 pr-3">
		<select class="form-control" id="filter-year">
			<?php
				$year = date('y');
				$max = $year+5;
				$min = $year-5;
				
				for($i=$min;$i<=$max;$i++){
				
				if(empty($filter_year)){
					if($i == $year){
						$selected = 'selected';
					}else{
						$selected = '';
					}
				}else{
					if($i == $filter_year){
						$selected = 'selected';
					}else{
						$selected = '';
					}
				}
			?>
				<option value="<?= $i ?>" <?= $selected ?>> <?= date_format(date_create_from_format('y', $i), 'Y') ?></option>
			<?php } ?>
		</select>
	</div>
	
	<button type="button" id="filter_ar_search" onclick="searchJob()" class="btn btn-default mr-1">FILTER</button>
	<button type="button" id="filter_ar_clear" onclick="clearJob()" class="btn btn-default">RESET</button>
</div>

<table class="table table-hover table-sm">
	<thead>
		<tr>
			<th scope="col">Job ID</th>
			<th scope="col">Customer</th>
			<th scope="col">From</th>
			<th scope="col">To</th>
			<th scope="col">Vessel</th>
			<th scope="col">HB</th>
			<th scope="col">MB</th>
			<!--<th scope="col"></th>-->
		</tr>
	</thead>
	<tbody>
		<?php
			foreach($jobs as $row){
		?>
			<tr onclick="window.location='<?= Url::base().'/job/update?id='.$row['id'] ?>'">
				<th scope="row"><?= $row['job_name'] ?></th>
				<td><?= $row['customer_name'] ?></td>
				<td><?= $row['job_from'] ?></td>
				<td><?= $row['job_to'] ?></td>
				<td><?= $row['job_ship'] ?></td>
				<td><?= $row['job_hb'] ?></td>
				<td><?= $row['job_mb'] ?></td>
				<!--<td><a href="<?= Url::base().'/job/copy-new?id='.$row['id'] ?>" class="btn btn-dark">Copy New</a></td>-->
			</tr>
		<?php } ?>
	</tbody>
</table>

<script>
	$(document).ready(function(){
		
	});
	
	function searchJob(){
		search = $('#input-search').val();
		month = $('#filter-month').val();
		year = $('#filter-year').val();
		
		url = '<?= Url::base()?>/job/index?search='+search+'&month='+month+'&year='+year;
		window.location.replace(url);
	}
	
	function clearJob(){
		url = '<?= Url::base()?>/job/index';
		window.location.replace(url);
	}
</script>
