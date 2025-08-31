<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use yii\widgets\ActiveForm;
use richardfan\widget\JSRegister;
use app\models\Customer;
use app\models\MasterNewJobinvoice;
use app\models\MasterNewJobvoucher;
use yii\helpers\VarDumper;

date_default_timezone_set('Asia/Jakarta');
?>

<style>
	.container{
		max-width: 97% !important;
		padding: 20px !important;
	}
	
	body{
		width: 100%;
		overflow-x: auto;
	}
	
	table{
    	border-collapse: collapse;
	}
	
	.link, .link:hover{
		color: #000;
		text-decoration: none;
	}
		
	a.text-danger:hover{
		color: #dc3545 !important;
	}
	
	.nav-pills .nav-link.active{
		background-color: #2f2f2f;
	}
	
	.nav-pills .nav-link.active:hover{
		background-color: #2f2f2f;
	}
	
	.nav-pills .nav-link{
		color: black;
	}
	
	.nav-pills .nav-link:hover{
		background-color: #eeeeee;
	}
</style>

<div class="report-cash" style="font-size:12px">
	<div class="row">
		<div class="col-12">
			<div class="float-left">
				<a href="<?= Url::base().'/report/index'?>" type="button" class="btn btn-dark">Back to Menu<a>
			</div>
			<div class="text-center">
				<h5><b>REPORT AP-C FIXED</b></h5>
			</div>
		</div>
	</div>
	
	<hr style="border-top:1px solid black;">
	
	<div class="tab mb-3">
		<ul class="nav nav-pills">
			<li class="nav-item">
				<a class="nav-link" href="<?= Url::base() ?>/report/report-arc">AR-C</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?= Url::base() ?>/report/report-apc-convert">AP-C CONVERT</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?= Url::base() ?>/report/report-apc-cash">AP-C CASH</a>
			</li>
			<li class="nav-item">
				<a class="nav-link active" href="#">AP-C FIXED</a>
			</li>
		</ul>
	</div>
	
	<div class="row">
		<div class="col-1 mt-2 pr-0">MONTH/YEAR : </div>
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
		<div class="col-1 pl-0 pr-1">
			<select class="form-control" id="filter-year">
				<?php
					$year = date('Y');
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
					<option value="<?= $i ?>" <?= $selected ?>> <?= $i ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-2">
			<button type="button" id="filter_search" onclick="searchApc()" class="btn btn-default mr-1">FILTER</button>
			<button type="button" id="filter_clear" onclick="clearApc()" class="btn btn-default mr-4">RESET</button>
		</div>
		
		<div class="col-1 pr-0">MODIFY ALIAS : </div>
		<div class="col-2 pl-0 pr-1">
			<input type="date" class="form-control" id="date_alias" value="<?= date('Y-m-d')?>"></input>
		</div>
		<div class="col-2">
			<button type="button" id="filter_clear" onclick="modifyApc()" class="btn btn-default mr-4">MODIFY</button>
		</div>
		
		<div class="col-2 text-right">
			<button type="button" id="btn_print" onclick="printApc()" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i>&emsp;PDF</button>
		</div>
	</div>
	
	<br>
	<br>
	
	<table class="table table-bordered" style="font-size:12px">
		<tr>
			<td colspan="7" style="background-color:#2f2f2f; color:#fff; text-align:left">
				<div style="display:inline-block; margin-left:15px; font-size:20px; margin-right:100px">LAPORAN AP-C CASH</div>
				<div style="display:inline-block; margin-left:15px; font-size:20px"><?= strtoupper($month_year) ?></div>
			</td>
		</tr>
		<tr>
			<td rowspan="2" style="background-color:#2f2f2f;vertical-align:middle; color:#fff" class="text-center" width="10%">PDF</td>
			<td rowspan="2" style="background-color:#2f2f2f;vertical-align:middle; color:#fff" class="text-center" width="20%">E-FAKTUR No.</td>
			<td rowspan="2" style="background-color:#2f2f2f;vertical-align:middle; color:#fff" class="text-center" width="10%">TANGGAL</td>
			<td colspan="3" style="background-color:#2f2f2f;vertical-align:middle; color:#fff" class="text-center" width="45%">APC/BKM No.</td>
			<td rowspan="2" style="background-color:#2f2f2f;vertical-align:middle; color:#fff" class="text-center" width="15%">JUMLAH</td>
		</tr>
		<tr>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center" width="15%">FIN1-SB</td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center" width="15%">FIN2-JK</td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center" width="15%">FIN3-SR</td>
		</tr>
		
		<?php
			$total_ar = 0;
			$total_sb = 0;
			$total_jk = 0;
			$total_sr = 0;
			
			foreach($payments as $row){
		?>
			<tr>
				<!-- INV -->
				<?php
					if($row['vch_invoice'] != 0)
					{
						echo '<td class="text-center">';
						echo '<a href="'.Url::base().'/accounting/print-ar?id='.$row['vch_id'].'" style="font-size:12px" class="btn btn-danger btn-md" target="_blank">';
						echo '<i class="fa fa-file-pdf-o"></i>&emsp;INV';
						echo '</a>';
						echo '</td>';
					}
				?>
				
				<!-- COST -->
				<?php
					if($row['vch_cost'] != 0)
					{
						echo '<td class="text-center">';
						echo '<a href="'.Url::base().'/accounting/print-ap?id='.$row['vch_id'].'" style="font-size:12px" class="btn btn-danger btn-md" target="_blank">';
						echo '<i class="fa fa-file-pdf-o"></i>&emsp;COST';
						echo '</a>';
						echo '</td>';
					}
				?>

				<!-- OP -->
				<?php
					if($row['vch_faktur'] == 'BIAYA OP')
					{
						echo '<td class="text-center">';
						echo '<a href="'.Url::base().'/accounting/print-cost-operational?id='.$row['vch_id'].'" style="font-size:12px" class="btn btn-danger btn-md" target="_blank">';
						echo '<i class="fa fa-file-pdf-o"></i>&emsp;OP';
						echo '</a>';
						echo '</td>';
					}
				?>

				<!-- E-FAKTUR -->
				<td class="text-center">
					<?= $row['vch_faktur']; ?>
				</td>
				
				<!-- TANGGAL -->
				<td class="text-center">
					<?php
						if($row['vch_faktur_tgl'] !== '0000-00-00' && !empty($row['vch_faktur_tgl'])){
							echo strtoupper(date_format(date_create_from_format('Y-m-d', $row['vch_faktur_tgl']), 'd M Y'));
						}
					?>
				</td>
				
				<!-- NOMOR ARC SB -->
				<td class="text-center">
					<?php
						if($row['vch_type'] == 2)
						{
							if(!empty($row['vch_count_multiple']) && $row['vch_count_multiple'] !== '-'){
								$count_multiple = $row['vch_count_multiple'];
							}else{
								$count_multiple = '';
							}
							
							$tahun = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'y');
							$bulan = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'm');
							$day = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'd');
							
							$voucher_date = $tahun.''.$bulan.''.$day;
							$count_alias = $row['vch_count_alias'];
							$vch_count = str_pad($row['vch_count_alias'], 6, '0', STR_PAD_LEFT);
							
							$type = 'AP-C';
							$voucher_number = $type.'-'.$vch_count.''.$count_multiple.'-'.$voucher_date;
							
							if($row['vch_faktur'] == 'BIAYA OP')
							{
								if($row['vch_details'] == 1)
								{
									echo '<div class="link" onclick="updateCount('. $row['vch_id'] . ','. $row['vch_count_alias'] .')">'.$voucher_number.'-B</a>';
								
									$total_sb += $row['vch_amount'];
								}
							}
							else
							{
								if($row->job->job_location == 'SB')
								{
									echo '<div class="link" onclick="updateCount('. $row['vch_id'] . ','. $row['vch_count_alias'] .')">'.$voucher_number.'</a>';
								
									$total_sb += $row['vch_amount'];
								}
							}
						}
					?>
				</td>
				
				<!-- NOMOR ARC JK -->
				<td class="text-center">
					<?php
						if($row['vch_type'] == 2)
						{
							if(!empty($row['vch_count_multiple']) && $row['vch_count_multiple'] !== '-'){
								$count_multiple = $row['vch_count_multiple'];
							}else{
								$count_multiple = '';
							}
							
							$tahun = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'y');
							$bulan = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'm');
							$day = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'd');
							
							$voucher_date = $tahun.''.$bulan.''.$day;
							$vch_count = str_pad($row['vch_count_alias'], 6, '0', STR_PAD_LEFT);
							
							$type = 'AP-C';
							$voucher_number = $type.'-'.$vch_count.''.$count_multiple.'-'.$voucher_date;
							
							if($row['vch_faktur'] == 'BIAYA OP')
							{
								if($row['vch_details'] == 2)
								{
									echo '<div class="link" onclick="updateCount('. $row['vch_id'] . ','. $row['vch_count_alias'] .')">'.$voucher_number.'-B</a>';
								
									$total_jk += $row['vch_amount'];
								}
							}
							else
							{
								if($row->job->job_location == 'JK')
								{
									echo '<div class="link" onclick="updateCount('. $row['vch_id'] . ','. $row['vch_count_alias'] .')">'.$voucher_number.'</a>';
								
									$total_jk += $row['vch_amount'];
								}
							}
						}
					?>
				</td>
				
				<!-- NOMOR ARC SR -->
				<td class="text-center">
					<?php
						if($row['vch_type'] == 2)
						{
							if(!empty($row['vch_count_multiple']) && $row['vch_count_multiple'] !== '-'){
								$count_multiple = $row['vch_count_multiple'];
							}else{
								$count_multiple = '';
							}
							
							$tahun = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'y');
							$bulan = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'm');
							$day = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'd');
							
							$voucher_date = $tahun.''.$bulan.''.$day;
							$vch_count = str_pad($row['vch_count_alias'], 6, '0', STR_PAD_LEFT);
							
							$type = 'AP-C';
							$voucher_number = $type.'-'.$vch_count.''.$count_multiple.'-'.$voucher_date;
							
							if($row['vch_faktur'] == 'BIAYA OP')
							{
								if($row['vch_details'] == 3)
								{
									echo '<div class="link" onclick="updateCount('. $row['vch_id'] . ','. $row['vch_count_alias'] .')">'.$voucher_number.'-B</a>';
								
									$total_sr += $row['vch_amount'];
								}
							}
							else
							{
								if($row->job->job_location == 'SR')
								{
									echo '<div class="link" onclick="updateCount('. $row['vch_id'] . ','. $row['vch_count_alias'] .')">'.$voucher_number.'</a>';
								
									$total_sr += $row['vch_amount'];
								}
							}
						}
					?>
				</td>
				
				<!-- JUMLAH -->
				<td class="text-right">
					<?php
						if($row['vch_type'] == 2)
						{
							echo number_format($row['vch_amount'],0,'.',',');
							$total_ar += $row['vch_amount'];
						}
					?>
				</td>
			</tr>
		<?php } ?>
		
		<tr>
			<td align="center" colspan="3">JUMLAH TOTAL AR-C FIXED</td>
			<td align="right">
				<b><?= number_format($total_sb,0,'.',',') ?></b>
			</td>
			<td align="right">
				<b><?= number_format($total_jk,0,'.',',') ?></b>
			</td>
			<td align="right">
				<b><?= number_format($total_sr,0,'.',',') ?></b>
			</td>
			<td align="right">
				<b><?= number_format($total_ar,0,'.',',') ?></b>
			</td>
		</tr>
	</table>
</div>

<?php $form = ActiveForm::begin([
	'id' => 'form_count_alias', 
	'action' => Url::base().'/report/save-count-alias'
]); ?>

	<?php
		Modal::begin([
			'title' => 'Update',
			'id' => 'modal_update_count_alias',
			'size' => 'modal-sm',
		]);
	?>
		<div id="content">
			<div class="row form-group">
				<div class="col-12">
					<input type="hidden" class="form-control" id="id_payment" name="MasterNewJobvoucher[vch_id]">
					<input type="hidden" class="form-control" id="report_type" name="report_type">
					<input type="text" class="form-control" id="count_number" name="MasterNewJobvoucher[vch_count_alias]">
				</div>
			</div>
		</div>
		
		<div class="row form-group" style="float:right">
				<div class="col-12">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-dark">Save</button>
				</div>
			</div>
		</div>
	<?php Modal::end(); ?>
<?php ActiveForm::end(); ?>

<script>
	$(document).ready(function(){
		
	});
	
	function updateCount(vch_id, vch_count_alias){
		/*$('#id_payment').val(vch_id);
		$('#count_number').val(vch_count_alias);
		$('#report_type').val('cash');
		
		$('#modal_update_count_alias').modal({backdrop: 'static', keyboard: false});
		$('#modal_update_count_alias').show();*/
	}
	
	function searchApc(){
		month = $('#filter-month').val();
		year = $('#filter-year').val();
		
		url = '<?= Url::base()?>/report/report-apc-fixed?month='+month+'&year='+year;
		window.location.replace(url);
	}
	
	function clearApc(){
		url = '<?= Url::base()?>/report/report-apc-fixed';
		window.location.replace(url);
	}
	
	function modifyApc(){
		date = $('#date_alias').val();
		
		url = '<?= Url::base()?>/report/report-apc-fixed-alias?date='+date;
		window.location.replace(url);
	}
	
	function printApc(){
		month = $('#filter-month').val();
		year = $('#filter-year').val();
		
		url = '<?= Url::base()?>/report/print-arc-apc?month='+month+'&year='+year;
		window.open(url, '_blank');
	}
</script>
