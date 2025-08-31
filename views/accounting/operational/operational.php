<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Modal;
use richardfan\widget\JSRegister;
use app\models\MasterPortfolioAccount;
use app\models\PosV8;

date_default_timezone_set('Asia/Jakarta');
?>

<?php
$account = MasterPortfolioAccount::find()->where(['flag'=>1])->orderBy(['name'=>SORT_ASC])->all();
$pos 	 = PosV8::find()->where(['is_active'=>1])->orderby(['pos_name'=>SORT_ASC])->all();
?>

<style>
	.container{
		max-width: 97% !important;
		padding: 20px !important;
	}
	
	.cost-operational input,
	.cost-operational select,
	.cost-operational textarea{
		font-size: 12px;
	}
	
</style>

<div class="cost-operational" style="font-size:12px">
	<div class="row">
		<div class="col-12">
			<div class="float-left">
				<a href="<?= Url::base().'/accounting/index'?>" type="button" class="btn btn-dark">Back to Menu<a>
			</div>
			<div class="text-center">
				<h5><b>COST OPERATIONAL IDR</b></h5>
			</div>
		</div>
	</div>
	<hr style="border-top:1px solid black;">
	
	<?php $form = ActiveForm::begin([
		'id' => 'form_cost_operational', 
		'action' => Url::base().'/accounting/save-cost-operational']); 
	?>
		<input type="hidden" id="vch_id" value="" name="MasterNewJobvoucher[vch_id]">
		
		<div class="row row_form mb-1" id="row-0">
			<div class="col-md-1 pr-0 pr-1">
				<label>Label</label>
				<select class="form-control" id="vch_label" name="MasterNewJobvoucher[Detail][0][vch_label]">
					<option value="1">PENDAPATAN LAIN</option>
					<option value="2">BIAYA LAIN</option>
				</select>
			</div>
			
			<div class="col-md-1 pl-0 pr-1">
				<label>Station</label>
				<select class="form-control" id="vch_details" name="MasterNewJobvoucher[Detail][0][vch_details]">
					<option value="1">IDSUB</option>
					<option value="2">IDJKT</option>
					<option value="3">IDSRG</option>
				</select>
			</div>
			
			<div class="col-md-1 pl-0 pr-1">
				<label>BANK</label>
				<select class="form-control" id="id_account" name="MasterNewJobvoucher[Detail][0][vch_bank]">
					<?php
						foreach($account as $row){
							echo '<option value="'.$row['id'].'">'.
								$row['name'].
							'</option>';
						}
					?>
				</select>
			</div>
			
			<div class="col-md-1 pl-0 pr-1">
				<label>Mode</label>
				<select class="form-control" id="mode" name="MasterNewJobvoucher[mode]">
					<option value="1">ARB-BBM</option>
					<option value="2">ARC-BKM</option>
					<option value="3">APB-BBK</option>
					<option value="4">APC-BKK</option>
				</select>
				<div class="form-check form-check-inline mt-2 div_autobkk">
					<input type="checkbox" class="form-check-input vch_mode" id="autobkk" name="MasterNewJobvoucher[autobkk]" value="1">
					<label class="form-check-label" for="autobkk"> Auto BKK</label>
				</div>
			</div>
			
			<div class="col-md-1 pl-0 pr-1">
				<label>Tanggal</label>
				<input type="date" class="form-control" id="vch_date" value="<?= date('Y-m-d') ?>" name="MasterNewJobvoucher[Detail][0][vch_date]">
			</div>
			
			<div class="col-md-2 pl-0 pr-1">
				<label>POS</label>
				<select class="form-control" id="vch_pos" name="MasterNewJobvoucher[Detail][0][vch_pos]">
					<?php
						foreach($pos as $row){
							$selected = '';

							echo "<option value='".$row['pos_id']."' ".$selected.">".
								$row['pos_name'].
							"</option>";
						}
					?>
				</select>
			</div>
			<div class="col-md-2" style="padding-left:5px; padding-right:0px">
				<label>Reference</label>
				<textarea class="form-control" id="vch_keterangan" placeholder="Reference" name="MasterNewJobvoucher[Detail][0][vch_keterangan]" rows="5"></textarea>
			</div>
			<div class="col-md-2" style="padding-left:5px; padding-right:0px">
				<label>Jumlah</label>
				<input type="text" class="form-control" id="vch_amount" placeholder="Jumlah" name="MasterNewJobvoucher[Detail][0][vch_amount]" required>
			</div>
			<div class="col-md-1" style="padding-left:5px; padding-right:0px">
				<label>&nbsp;</label><br/>
				<button type="sumbit" class="btn btn-dark" id="btn_create" onclick="return confirm('Are you sure?');">Create</button>
				<button type="sumbit" class="btn btn-dark" id="btn_edit" onclick="return confirm('Are you sure?');" style="display:none">Edit</button>
				
				<div id="div-btn-add" class="mt-1">
					<button type="button" class="btn btn-success" id="btn_add" onclick="addRow()"><span style="" class="fa fa-plus align-middle"></span> Tambah</button>
				</div>
			</div>
		</div>
		
		<div id="div_append"></div>
	
		
		
		
	<?php ActiveForm::end(); ?>
	
	<br><br>
	
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
		<button type="button" id="filter_opr_search" onclick="searchOpr()" class="btn btn-default mr-1">FILTER</button>
		<button type="button" id="filter_opr_clear" onclick="clearOpr()" class="btn btn-default mr-4">RESET</button>
	</div>
	
	<br>
	
	<table class="table table-hover" style="font-size:14px;width:100%">
		<tr style="background-color:#ccc">
			<td class="text-center" width="3%">NO.</td>
			<td class="text-center" width="8%">STATION</td>
			<td class="text-center" width="8%">BANK</td>
			<td class="text-center" width="8%">MODE</td>
			<td class="text-center" width="8%">NOMOR</td>
			<td class="text-center" width="8%">TGL</td>
			<td width="15%">POS</td>
			<td width="16%">REFERENCE</td>
			<td class="text-right" width="14%">JUMLAH</td>
			<td class="text-center" width="12%"></td>
		</tr>
		<?php
			$i = 1;
			foreach($cost_opr as $row){
				if($row['vch_details'] == 1){
					$station = 'IDSUB';
				}elseif($row['vch_details'] == 2){
					$station = 'IDJKT';
				}elseif($row['vch_details'] == 3){
					$station = 'IDSRG';
				}
				
				/*if(!empty($row['vch_pembayaran_type']) || $row['vch_pembayaran_type'] !== '-'){
					$vch_bank = MasterPortfolioAccount::find()->where(['id'=>$row['vch_bank']])->one();
					$bank = $vch_bank->name;
				}else{
					$bank = '-';
				}*/
				
				if($row['vch_type'] == 1 && $row['vch_pembayaran_type'] == 2){
					$mode = 1;
					$mode_name = 'ARB-BBM';
				}else if($row['vch_type'] == 1 && $row['vch_pembayaran_type'] == 1){
					$mode = 2;
					$mode_name = 'ARC-BKM';
				}else if($row['vch_type'] == 2 && $row['vch_pembayaran_type'] == 2){
					$mode = 3;
					$mode_name = 'APB-BBK';
				}else if($row['vch_type'] == 2 && $row['vch_pembayaran_type'] == 1){
					$mode = 4;
					$mode_name = 'APC-BKK';
				}
				
				$tahun = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'y');
				$bulan = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'm');
				$vch_count = str_pad($row['vch_count'], 3, '0', STR_PAD_LEFT);
				$voucher_number = $tahun.''.$bulan.''.$vch_count.'-B';
				
				$date = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'd M Y');
				
				$vch_pos = PosV8::find()->where(['pos_id' => $row['vch_pos']])->one();
				if(isset($vch_pos)){
					$pos_name = $vch_pos->pos_name;
				}else{
					$pos_name = '';
				}
				
		?>
			<tr>
				<td class="text-center"><?= $i ?></td>
				<td class="text-center"><?= $station ?></td>
				<td class="text-center"><?php //$bank ?></td>
				<td class="text-center"><?= $mode_name ?></td>
				<td class="text-center"><?= $voucher_number ?></td>
				<td class="text-center"><?= strtoupper($date) ?></td>
				<td><?= strtoupper($pos_name) ?></td>
				<td><?= strtoupper($row['vch_keterangan']) ?></td>
				<td class="text-right"><?= number_format($row['vch_amount'],2,'.',','); ?></td>
				<td class="text-center">
					<a class="btn btn-default mr-1" title="Pdf" href="<?= Url::base().'/accounting/print-cost-operational?id='.$row['vch_id'] ?>" target="_blank">
						<i class="fa fa-file-pdf-o"></i>
					</a>
					<button type="button" class="btn btn-dark mr-1" title="Edit" onclick="editCostOperational(<?= $row['vch_id'] ?>)">
						<i class="fa fa-edit"></i>
					</button>
					<button type="button" class="btn btn-danger mr-1" title="Delete" onclick="deleteCostOpr(<?= $row['vch_id'] ?>)">
						<i class="fa fa-trash"></i>
					</button>
				</td>
			</tr>
		<?php $i++; } ?>
	</table>
</div>

<script>
	$(document).ready(function(){
	});
	
	function searchOpr(){
		month = $('#filter-month').val();
		year = $('#filter-year').val();
		
		url = '<?= Url::base()?>/accounting/cost-operational?month='+month+'&year='+year;
		window.location.replace(url);
	}
	
	function clearOpr(){
		url = '<?= Url::base()?>/accounting/cost-operational';
		window.location.replace(url);
	}
	
	function addRow(){
		totalrows = $('.row_form').length;
		
		if(totalrows == 1){
			row = 1; 
		}else{
			row = totalrows + 1;
		}
		
		item = '';
		item += '<div class="row row_form mb-1" id="row-'+row+'">';
			item += '<div class="col-md-1 pr-0 pr-1">';
				item += '<label>Label</label>';
				item += '<select class="form-control" id="vch_label" name="MasterNewJobvoucher[Detail]['+row+'][vch_label]">';
					item += '<option value="1">PENDAPATAN LAIN</option>';
					item += '<option value="2">BIAYA LAIN</option>';
				item += '</select>';
			item += '</div>';
			
			item += '<div class="col-md-1 pl-0 pr-1">';
				item += '<label>Station</label>';
				item += '<select class="form-control" id="vch_details" name="MasterNewJobvoucher[Detail]['+row+'][vch_details]">';
					item += '<option value="1">IDSUB</option>';
					item += '<option value="2">IDJKT</option>';
					item += '<option value="3">IDSRG</option>';
				item += '</select>';
			item += '</div>';
			
			item += '<div class="col-md-1 pl-0 pr-1">';
				item += '<label>BANK</label>';
				item += '<select class="form-control" id="id_account" name="MasterNewJobvoucher[Detail]['+row+'][vch_bank]">';
					item += '<?php
						foreach($account as $row){
							echo '<option value="'.$row['id'].'">'.
								$row['name'].
							'</option>';
						}
					?>';
				item += '</select>';
			item += '</div>';
			
			item += '<div class="col-md-1 pl-0 pr-1">';
				item += '<label>Mode</label>';
				item += '<select class="form-control" id="mode" name="MasterNewJobvoucher[Detail]['+row+'][mode]" disabled>';
					item += '<option value="1"></option>';
					item += '<option value="2"></option>';
					item += '<option value="3"></option>';
					item += '<option value="4"></option>';
				item += '</select>';
			item += '</div>';
			
			item += '<div class="col-md-1 pl-0 pr-1">';
				item += '<label>Tanggal</label>';
				item += '<input type="date" class="form-control" id="vch_date" value="<?= date('Y-m-d') ?>" name="MasterNewJobvoucher[Detail]['+row+'][vch_date]">';
			item += '</div>';
			
			item += '<div class="col-md-2 pl-0 pr-1">';
				item += '<label>POS</label>';
				item += '<select class="form-control" id="vch_pos" name="MasterNewJobvoucher[Detail]['+row+'][vch_pos]">';
					item += "<?php
						foreach($pos as $row){
							$selected = '';

							echo "<option value='".$row['pos_id']."' ".$selected.">".
								$row['pos_name'].
							"</option>";
						}
					?>";
				item += '</select>';
			item += '</div>';
			item += '<div class="col-md-2" style="padding-left:5px; padding-right:0px">';
				item += '<label>Reference</label>';
				item += '<textarea class="form-control" id="vch_keterangan" placeholder="Reference" name="MasterNewJobvoucher[Detail]['+row+'][vch_keterangan]" rows="5"></textarea>';
			item += '</div>';
			item += '<div class="col-md-2" style="padding-left:5px; padding-right:0px">';
				item += '<label>Jumlah</label>';
				item += '<input type="text" class="form-control" id="vch_amount" placeholder="Jumlah" name="MasterNewJobvoucher[Detail]['+row+'][vch_amount]" required>';
			item += '</div>';
			item += '<div class="col-md-1" style="padding-left:5px; padding-right:0px">';
				item += '<label>&nbsp;</label><br/>';
				item += '<button type="button" class="btn btn-danger" id="btn_create" onclick="removeRow('+row+')"><span class="fa fa-trash"></span></button>';
			item += '</div>';
		item += '</div>';
		
		$('#div_append').append(item);
	}
	
	function removeRow(id){
		$('#row-'+id).remove();
	}
	
	function editCostOperational(id){
		$('#div-btn-add').hide();
		$('#btn_create').hide();
		$('#div_append').html('');
		
		$.ajax({
			url: '<?=Url::base().'/accounting/get-cost-operational'?>',
			data: {'id': id},
			dataType: 'json',
			method: 'POST',
            async: 'false'
		}).done(function(result){
			detail = result.cost_idr;
			mode = result.mode;
			
			if(detail){
				$('#vch_id').val(detail['vch_id']);
				$('#vch_label').val(detail['vch_label']);
				$('#vch_details').val(detail['vch_details']);
				$('#id_account').val(detail['vch_bank']);
				$('#mode').val(mode);
				$('#vch_date').val(detail['vch_date']);
				$('#vch_pos').val(detail['vch_pos']);
				$('#vch_keterangan').val(detail['vch_keterangan']);
				$('#vch_amount').val(detail['vch_amount']);
				
				$('.div_autobkk').hide();
				$('#btn_create').hide();
				$('#btn_edit').show();
			}
		});
	}
	
	function deleteCostOpr(id){
		var deleted = confirm('Are you sure?');
		
		if(deleted == true){
			url = '<?= Url::base()?>/accounting/delete-cost-operational?id='+id;
			window.location.replace(url);
		}
	}
</script>
