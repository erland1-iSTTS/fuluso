<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use richardfan\widget\JSRegister;
use yii\bootstrap4\Modal;
use app\models\PosV8;
use app\models\Packages;
use app\models\MasterPpn;
use app\models\CostVoucherV5;
use yii\helpers\VarDumper;

date_default_timezone_set('Asia/Jakarta');

$pos 		= PosV8::find()->where(['is_active'=>1])->orderby(['pos_name'=>SORT_ASC])->all();
$packages 	= Packages::find()->orderby(['packages_name'=>SORT_ASC])->all();
$ppn 		= MasterPpn::find()->where(['is_active'=>1])->all();
?>

<style>
	.btn-rounded{
		border-radius: 50% !important;
		padding: 4px 10px;
	}
	
	.btn-remove{
		padding: 5px 8px;
	}

	.btn-rounded span{
		font-size: 12px;
	}
	
	select{
		color: black!important;
	}

</style>

<?php
	$form = ActiveForm::begin([
		'id' => 'form_create_ap_maker', 
		'action' => Url::base().'/accounting/create-ap-opr-voucher'
	]);
?>
<?php
	Modal::begin([
		'title' => 'Create AP Voucher IDT',
		'id' => 'modal_create_ap_opr_voucher',
		'size' => 'modal-xl',
	]);
?>

<div class="create-ap-maker-index">
	<div class="row mb-2">
		<div class="col-12">
			<label class="fw-normal">Date : </label> <?= date('d F Y') ?>
		</div>
	</div>
	
	<div class="row mb-2">
		<div class="col-12">
			<div class="form-check form-check-inline mb-2">
				<input type="radio" class="form-check-input" id="type_pokok" name="CostVoucherV5[cv_type]" value="1" required <?php if(isset($ap_opr_type)){ if($ap_opr_type->cv_type == 1){ echo 'checked'; }}?>>
				<label class="form-check-label" for="type_pokok">Pokok</label>
			</div>
			
			<div class="form-check form-check-inline mb-2">
				<input type="radio" class="form-check-input" id="type_var" name="CostVoucherV5[cv_type]" value="2" <?php if(isset($ap_opr_type)){ if($ap_opr_type->cv_type == 2){ echo 'checked'; }}?>>
				<label class="form-check-label" for="type_var">Variable</label>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-12">
			<table class="table mb-0" id="table_create_ap_maker" style="font-size:12px">
				<thead>
					<tr>
						<th width="1%"></th>
						<th width="20%">POS</th>
						<th width="15%">Detail</th>
						<th width="15%">Jumlah</th>
						<th width="10%">Satuan</th>
						<th width="18%">Amount</th>
						<th width="15%" class="text-right">Subtotal</th>
						<th width="6%" class="text-center">Curr</th>
					</tr>
				</thead>
				<tbody>
					<tr id="row-0">
						<td class="text-center">
							<button type="button" class="btn btn-success btn-rounded" onclick="addRow()">
								<span class="fa fa-plus"></span>
							</button>
						</td>
						<td>
							<select class="form-select form-select-lg" id="pos-0" name="CostVoucherV5[detail][0][cv_pos]" required>
								<option value="" disabled hidden></option>
								<?php
									foreach($pos as $row){
										$selected = '';

										echo "<option value='".$row['pos_id']."' ".$selected.">".
											$row['pos_name'].
										"</option>";
									}
								?>
							</select>
						</td>
						<td>
							<input type="text" class="form-control" id="detail-0" name="CostVoucherV5[detail][0][cv_detail]" >
						</td>
						<td>
							<input type="text" class="form-control qty" id="qty-0" value="" name="CostVoucherV5[detail][0][cv_qty]" onkeyup="changeInput(this.id)" required>
						</td>
						<td>
							<select class="form-select form-select-lg" id="packages-0" name="CostVoucherV5[detail][0][cv_packages]" required>
								<?php
									foreach($packages as $row){
										$name = str_replace("'", "&apos;", $row['packages_name']);
										
										$selected = '';
										
										echo "<option value='".$name."' ".$selected.">".
											$row['packages_name'].
										"</option>";
									}
								?>
							</select>
						</td>
						<td>
							<input type="text" class="form-control amount" id="amount-0" value="" name="CostVoucherV5[detail][0][cv_amount]" onkeyup="changeInput(this.id)" required>
						</td>
						<td class="text-right">
							<div id="div_subtotal-0">0.00</div>
							<input type="hidden" class="form-control subtotal" id="subtotal-0" value="" name="CostVoucherV5[detail][0][cv_subtotal]">
						</td>
						<td class="text-center">IDR</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	
	<div class="row">
		<div class="col-12">
			<table class="table mb-0" style="font-size:12px">
				<tr style="visibility:hidden">
					<td class="border-bottom-0" width="4%"></td>
					<td class="border-bottom-0" width="12%">Jumlah</td>
					<td class="border-bottom-0" width="70%"></td>
					<td class="border-bottom-0 text-right" width="9%" id="total_jumlah">0.00</td>
					<td class="border-bottom-0 text-center" width="5%">IDR</td>
				</tr>
				<tr style="display:none">
					<td class="border-top-0"></td>
					<td class="border-top-0">PPN</td>
					<td class="border-top-0"></td>
					<td class="border-top-0 text-right" id="total_ppn">0.00</td>
					<td class="border-top-0 text-center">IDR</td>
				</tr>
				<tr style="display:none">
					<td class="border-top-0"></td>
					<td class="border-top-0">PPH</td>
					<td class="border-top-0"></td>
					<td class="border-top-0 text-right" id="total_pph">0.00</td>
					<td class="border-top-0 text-center">IDR</td>
				</tr>
				<tr>
					<td></td>
					<td>TOTAL</td>
					<td></td>
					<td class="text-right" id="grandtotal">0.00</td>
					<td class="text-center">IDR</td>
				</tr>
			</table>
		</div>
	</div>
	
	<hr>
	
	<div class="row form-group" style="float:right">
		<div class="col-12 text-right">
			<button type="submit" class="btn btn-dark">Save</button>
		</div>
	</div>
</div>
<?php Modal::end(); ?>
<?php ActiveForm::end(); ?>

<script>
	$(document).ready(function(){
	});
	
	function changeInput(id){
		idx = id.split('-')[1];
		
		//Qty
		qty = $('#qty-'+idx).val();
		if(qty == '' || qty == '-'){
			qty = 0;
		}else{
			qty = qty;
		}
		
		//Amount
		amount = $('#amount-'+idx).val();
		if(amount == '' || amount == '-'){
			amount = 0;
		}else{
			amount = amount;
		}
		
		//PPN
		/*id_ppn = $('#ppntype-'+idx).val();
		ppn = $('#ppntype-'+idx+' :selected').html();
		
		if(ppn == ''){
			persen_ppn = 0;
		}else{
			persen_ppn = ppn.split('-')[1].split('%')[0];
		}
		
		//PPH
		pph = $('#pph-'+idx).val();
		if(pph == '' || pph == '-'){
			pph = 0;
		}else{
			pph = pph;
		}
		
		total_ppn = (persen_ppn/100 * (qty * amount));
		subtotal = (qty * amount) + total_ppn - pph;*/
		subtotal = (qty * amount);
		
		$('#ppn-'+idx).val(0);
		
		$('#div_subtotal-'+idx).html(addSeparator(subtotal.toFixed(2)));
		$('#subtotal-'+idx).val(subtotal);
		
		get_total_jumlah();
		// get_total_ppn();
		// get_total_pph();
		get_grandtotal();
	}
	
	function get_total_jumlah(){
		total = 0;
		
		$('.qty').each(function(key, value){
			if($(this).val() == ''){
				qty = 0;
			}else{
				qty = $(this).val();
			}
			
			amount = $('.amount:eq('+key+')').val();
			
			if(amount == ''){
				amount = 0;
			}else{
				amount = amount;
			}
			
			total += parseFloat(qty * amount);
			
			$('#total_jumlah').html(addSeparator(total.toFixed(2)));
		});
	}
	
	function get_total_ppn(){
		total = 0;
		
		$('.ppn').each(function(key, value){
			if($(this).val() == ''){
				ppn = 0;
			}else{
				ppn = $(this).val();
			}
			
			total += parseFloat(ppn);
			
			$('#total_ppn').html(addSeparator(total.toFixed(2)));
		});
	}
	
	function get_total_pph(){
		total = 0;
		
		$('.pph').each(function(key, value){
			if($(this).val() == ''){
				pph = 0;
			}else{
				pph = $(this).val();
			}
			
			total += parseFloat(pph);
			
			$('#total_pph').html(addSeparator(total.toFixed(2)));
		});
	}
	
	function get_grandtotal(){
		total = 0;
		
		$('.subtotal').each(function(key, value){
			if($(this).val() == ''){
				subtotal = 0;
			}else{
				subtotal = $(this).val();
			}
			
			total += parseFloat(subtotal);
			
			$('#grandtotal').html(addSeparator(total.toFixed(2)));
		});
	}
	
	function addRow(){
		//Row id
		rows = $('#table_create_ap_maker tbody tr').length;
		
		if(rows == 0){
			id = 1;
		}else{
			last_tr = $('#table_create_ap_maker tbody tr:last-child').attr('id');
			id = parseFloat(last_tr.split('-')[1]) + 1;
		}
		
		item = '<tr id="row-'+id+'">';
			item += '<td class="text-center">';
				item += '<button type="button" class="btn btn-danger btn-remove" id="remove-'+id+'" onclick="removeRow(this.id)">';
					item += '<i class="fa fa-trash"></i>';
				item += '</button>';
			item += '</td>';
			item += '<td>';
				item += '<select class="form-select form-select-lg" id="pos-'+id+'" name="CostVoucherV5[detail]['+id+'][cv_pos]" required>';
					item += '<option value="" disabled hidden></option>';
					item += "<?php
						foreach($pos as $row){
							$selected = '';

							echo "<option value='".$row['pos_id']."' ".$selected.">".
								$row['pos_name'].
							"</option>";
						}
					?>";
				item += '</select>';
			item += '</td>';
			item += '<td>';
				item += '<input type="text" class="form-control" id="detail-'+id+'" name="CostVoucherV5[detail]['+id+'][cv_detail]">';
			item += '</td>';
			item += '<td>';
				item += '<input type="text" class="form-control qty" id="qty-'+id+'" value="" name="CostVoucherV5[detail]['+id+'][cv_qty]" onkeyup="changeInput(this.id)" required>';
			item += '</td>';
			item += '<td>';
				item += '<select class="form-select form-select-lg" id="packages-'+id+'" name="CostVoucherV5[detail]['+id+'][cv_packages]" required>';
					item += "<?php
						foreach($packages as $row){
							$name = str_replace("'", "&apos;", $row['packages_name']);
							
							$selected = '';
							
							echo "<option value='".$name."' ".$selected.">".
								$row['packages_name'].
							"</option>";
						}
					?>";
				item += '</select>';
			item += '</td>';
			item += '<td>';
				item += '<input type="text" class="form-control amount" id="amount-'+id+'" value="" name="CostVoucherV5[detail]['+id+'][cv_amount]" onkeyup="changeInput(this.id)" required>';
			item += '</td>';
			item += '<td class="text-right">';
				item += '<div id="div_subtotal-'+id+'">0.00</div>';
				item += '<input type="hidden" class="form-control subtotal" id="subtotal-'+id+'" value="" name="CostVoucherV5[detail]['+id+'][cv_subtotal]">';
			item += '</td>';
			item += '<td class="text-center">IDR</td>';
		item += '</tr>';
		
		$('#table_create_ap_maker tbody').append(item);
	}
	
	function removeRow(id){
		idx = id.split('-')[1];
		
		$('#row-'+idx).remove();
		
		get_total_jumlah();
		get_total_ppn();
		get_total_pph();
		get_grandtotal();
	}
	
	//Thousand Separator
	function Separator(id){
		$('#'+id).keyup(function(event)
		{
			if(event.which >= 37 && event.which <= 40) return;
			
			$(this).val(function(index, value){
				return value
					// Keep only digits, decimal points, and dashes at the start of the string:
					.replace(/[^\d.-]|(?!^)-/g, "")
					// Remove duplicated decimal points, if they exist:
					.replace(/^([^.]*\.)(.*$)/, (_, g1, g2) => g1 + g2.replace(/\./g, ''))
					// Keep only two digits past the decimal point:
					.replace(/\.(\d{2})\d+/, '.$1')
					// Add thousands separators:
					.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
			});
		});
	}
	
	function clearSeparator(val){
		return val.replace(/[^\d.-]|(?!^)-/g, "");
	}
	
	function addSeparator(nStr){
		nStr += '';
		var x = nStr.split('.');
		var x1 = x[0];
		var x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
		}
		return x1 + x2;
	}
</script>