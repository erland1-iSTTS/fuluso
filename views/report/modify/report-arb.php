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
	
	.link{
		cursor: pointer;
		color: #00F;
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

<div class="report-bank" style="font-size:12px">
	<div class="row">
		<div class="col-12">
			<div class="float-left">
				<a href="<?= Url::base().'/report/report-arb'?>" type="button" class="btn btn-dark">Back<a>
			</div>
			<div class="text-center">
				<h5><b>MODIFY ALIAS REPORT AR-B</b></h5>
			</div>
		</div>
	</div>
	
	<hr style="border-top:1px solid black;">
	
	<br>
	<br>
	
	<table class="table table-bordered" style="font-size:12px">
		<tr>
			<td colspan="6" style="background-color:#2f2f2f; color:#fff; text-align:left">
				<div style="display:inline-block; margin-left:15px; font-size:20px; margin-right:100px">LAPORAN AR-B</div>
				<div style="display:inline-block; margin-left:15px; font-size:20px"><?= strtoupper($filter_date) ?></div>
			</td>
		</tr>
		<tr>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center" width="20%">ARB/BBM No. (BNI)</td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center" width="15%">TANGGAL</td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center" width="15%">JUMLAH</td>
			
			<td style="background-color:#2f2f2f; color:#fff" class="text-center" width="20%">ARB/BBM No. (PERMATA)</td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center" width="15%">TANGGAL</td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center" width="15%">JUMLAH</td>
		</tr>
		
		<?php
			$total_ar1 = 0;
			$total_ar2 = 0;
			$total_ap1 = 0;
			$total_ap2 = 0;
		
			foreach($payments as $row){
				// Hanya tampil yg bank BRI dan Permata saja
				if(@$row->bank->name == 'BNI' || @$row->bank->name == 'PERMATA'){
		?>
			<tr>
				<!-- =============================================================== -->
				<!-- NOMOR ARB BNI -->
				<td class="text-center">
					<?php
					if($row['vch_type'] == 1)
					{
						if(@$row->bank->name == 'BNI')
						{
							/*if(!empty($row['vch_bank'])){
								echo '<div style="font-weight:bold">'.@$row->bank->name.' - '.@$row->bank->code.'</div>';
							}*/
							
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
							
							$type = 'AR-B';
							$voucher_number = $type.'-'.$vch_count.''.$count_multiple.'-'.$voucher_date;
							
							if($row['vch_faktur'] == 'BIAYA OP')
							{
								echo $voucher_number.'-B';
							}
							else
							{
								echo '<div class="link" onclick="updateCount('. $row['vch_id'] . ','. $row['vch_count_alias'] .')">'.$voucher_number.'</div>';
							}
						}
					}
					?>
				</td>
				
				<!-- DATE -->
				<td class="text-center">
					<?php
					if(@$row->bank->name == 'BNI')
					{
						if($row['vch_type'] == 1)
						{
							echo date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'd M Y');
						}
					}
					?>
				</td>

				<!-- JUMLAH -->
				<td class="text-right">
					<?php
					if(@$row->bank->name == 'BNI')
					{
						if($row['vch_type'] == 1)
						{
							echo number_format($row['vch_amount'],0,'.',',');
							$total_ar1 += $row['vch_amount'];
						}
					}
					?>
				</td>
				
				<!-- NOMOR ARB PERMATA -->
				<td class="text-center">
					<?php
					if($row['vch_type'] == 1)
					{
						if(@$row->bank->name == 'PERMATA')
						{
							/*if(!empty($row['vch_bank'])){
								echo '<div style="font-weight:bold">'.@$row->bank->name.' - '.@$row->bank->code.'</div>';
							}*/
							
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
							
							$type = 'AR-B';
							$voucher_number = $type.'-'.$vch_count.''.$count_multiple.'-'.$voucher_date;
							
							if($row['vch_faktur'] == 'BIAYA OP')
							{
								echo $voucher_number.'-B';
							}
							else
							{
								echo '<div class="link" onclick="updateCount('. $row['vch_id'] . ','. $row['vch_count_alias'] .')">'.$voucher_number.'</div>';
							}
						}
					}
					?>
				</td>
				
				<!-- DATE -->
				<td class="text-center">
					<?php
					if(@$row->bank->name == 'PERMATA')
					{
						if($row['vch_type'] == 1)
						{
							echo strtoupper(date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'd M Y'));
						}
					}
					?>
				</td>

				<!-- JUMLAH -->
				<td class="text-right">
					<?php
					if(@$row->bank->name == 'PERMATA')
					{
						if($row['vch_type'] == 1)
						{
							echo number_format($row['vch_amount'],0,'.',',');
							$total_ar2 += $row['vch_amount'];
						}
					}
					?>
				</td>
			</tr>
			<?php } ?>
		<?php } ?>
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
					<input type="hidden" class="form-control" id="report_link" name="report_link">
					<input type="hidden" class="form-control" id="report_params" name="report_params">
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
		$('#id_payment').val(vch_id);
		$('#count_number').val(vch_count_alias);
		$('#report_type').val('alias');
		$('#report_link').val('report-arb-alias');
		$('#report_params').val('<?= $_GET['date'] ?>');
		
		$('#modal_update_count_alias').modal({backdrop: 'static', keyboard: false});
		$('#modal_update_count_alias').show();
	}
</script>
