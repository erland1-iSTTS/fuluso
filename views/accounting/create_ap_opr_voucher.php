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

//Check data bulan ini
$ap_opr_voucher = CostVoucherV5::find()->where(['cv_month'=>date('n'), 'cv_year'=>date('Y')])->orderBy(['cv_id' => SORT_ASC]);
$ap_opr_type = CostVoucherV5::find()->where(['cv_month'=>date('n'), 'cv_year'=>date('Y')])->orderBy(['cv_id' => SORT_ASC])->one();
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
	if($ap_opr_voucher->count() > 0){
		$form = ActiveForm::begin([
			'id' => 'form_create_ap_maker', 
			'action' => Url::base().'/accounting/update-ap-opr-voucher'
		]);
	}else{
		$form = ActiveForm::begin([
			'id' => 'form_create_ap_maker', 
			'action' => Url::base().'/accounting/create-ap-opr-voucher'
		]);
	}
?>

<div class="create-ap-maker-index">
	<div class="row">
		<div class="col-12">
			<span style="font-size:15px"><b>Create AP Voucher IDT</b></span>
		</div>
	</div>
	
	<hr>
	
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
						<th width="12%">POS</th>
						<th width="12%">Detail</th>
						<th width="14%">Jumlah</th>
						<th width="8%">Satuan</th>
						<th width="12%">Amount</th>
						<th width="12%">PPN</th>
						<th width="12%">PPH</th>
						<th width="12%" class="text-right">Subtotal</th>
						<th width="6%" class="text-center">Curr</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						//Check Data bulan ini sdh pernah ada / blm
						if($ap_opr_voucher->count() > 0){ 
							
							$i=0;
							foreach($ap_opr_voucher->all() as $ap){
						?>
							<tr id="row-<?= $i ?>">
								<td class="text-center">
									<?php if($i == 0){ ?>
										<button type="button" class="btn btn-success btn-rounded" onclick="addRow()">
											<span class="fa fa-plus"></span>
										</button>
									<?php }else{ ?>
										<button type="button" class="btn btn-danger btn-remove" id="remove-<?= $i ?>" onclick="removeRow(this.id)">
											<i class="fa fa-trash"></i>
										</button>
									<?php } ?>
								</td>
								<td>
									<input type="hidden" id="id-<?= $i?>" value="<?= $ap['cv_id'] ?>" name="CostVoucherV5[detail][<?= $i ?>][cv_id]">
									
									<select class="form-select form-select-lg" id="pos-<?= $i ?>" name="CostVoucherV5[detail][<?= $i ?>][cv_pos]" required>
										<option value="" disabled hidden></option>
										<?php
											foreach($pos as $row){
												if($ap['cv_pos'] == $row['pos_id']){
													$selected = 'selected';
												}else{
													$selected = '';
												}

												echo "<option value='".$row['pos_id']."' ".$selected.">".
													$row['pos_name'].
												"</option>";
											}
										?>
									</select>
								</td>
								<td>
									<input type="text" class="form-control" id="detail-<?= $i ?>" value="<?= $ap['cv_detail'] ?>" name="CostVoucherV5[detail][<?= $i ?>][cv_detail]" required>
								</td>
								<td>
									<input type="text" class="form-control qty" id="qty-<?= $i ?>" value="<?= $ap['cv_qty'] ?>" name="CostVoucherV5[detail][<?= $i ?>][cv_qty]" onkeyup="changeInput(this.id)" required>
								</td>
								<td>
									<select class="form-select form-select-lg" id="packages-<?= $i ?>" name="CostVoucherV5[detail][<?= $i ?>][cv_packages]" required>
										<?php
											foreach($packages as $row){
												$name = str_replace("'", "&apos;", $row['packages_name']);
												
												if($ap['cv_packages'] == $row['packages_name']){
													$selected = 'selected';
												}else{
													$selected = '';
												}
												
												echo "<option value='".$name."' ".$selected.">".
													$row['packages_name'].
												"</option>";
											}
										?>
									</select>
								</td>
								<td>
									<input type="text" class="form-control amount" id="amount-<?= $i ?>" value="<?= $ap['cv_amount']*1 ?>" name="CostVoucherV5[detail][<?= $i ?>][cv_amount]" onkeyup="changeInput(this.id)" required>
								</td>
								<td>
									<select class="form-select form-select-lg ppntype" id="ppntype-<?= $i ?>" name="CostVoucherV5[detail][<?= $i ?>][id_ppn]" onchange="changeInput(this.id)" required>
										<option></option>
										<?php
											foreach($ppn as $row){
												$name = explode('-', $row['name']);
												$name_ppn = $name[1].'-'.$row['amount'].'%';
												
												if($ap['id_ppn'] == $row['id']){
													$selected = 'selected';
												}else{
													$selected = '';
												}
												echo "<option value='".$row['id']."' ".$selected.">".
													$name_ppn.
												"</option>";
											}
										?>
									</select>
									<input type="hidden" class="form-control ppn" id="ppn-<?= $i ?>" value="<?= $ap['ppn'] ?>" name="CostVoucherV5[detail][<?= $i ?>][ppn]">
								</td>
								<td>
									<input type="text" class="form-control pph" id="pph-<?= $i ?>" value="<?= $ap['pph']*1 ?>" name="CostVoucherV5[detail][<?= $i ?>][pph]" onkeyup="changeInput(this.id)" required>
								</td>
								<td class="text-right">
									<div id="div_subtotal-<?= $i ?>"><?= number_format($ap['cv_subtotal'],0,'.',',') ?></div>
									<input type="hidden" class="form-control subtotal" id="subtotal-<?= $i ?>" value="<?= $ap['cv_subtotal'] ?>" name="CostVoucherV5[detail][<?= $i ?>][cv_subtotal]">
								</td>
								<td class="text-center">IDR</td>
							</tr>
						<?php $i++;} ?>
						
					<?php }else{ ?>
					
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
								<input type="text" class="form-control" id="detail-0" name="CostVoucherV5[detail][0][cv_detail]" required>
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
							<td>
								<select class="form-select form-select-lg ppntype" id="ppntype-0" name="CostVoucherV5[detail][0][id_ppn]" onchange="changeInput(this.id)" required>
									<option></option>
									<?php
										foreach($ppn as $row){
											$name = explode('-', $row['name']);
											$name_ppn = $name[1].'-'.$row['amount'].'%';
											
											// Baru -> Default yg 050-1,1%
											if($name[1] == '050'){
												$selected = 'selected';
											}else{
												$selected = '';
											}
											echo "<option value='".$row['id']."' ".$selected.">".
												$name_ppn.
											"</option>";
										}
									?>
								</select>
								<input type="hidden" class="form-control ppn" id="ppn-0" value="" name="CostVoucherV5[detail][0][ppn]">
							</td>
							<td>
								<input type="text" class="form-control pph" id="pph-0" value="" name="CostVoucherV5[detail][0][pph]" onkeyup="changeInput(this.id)" required>
							</td>
							<td class="text-right">
								<div id="div_subtotal-0">0.00</div>
								<input type="hidden" class="form-control subtotal" id="subtotal-0" value="" name="CostVoucherV5[detail][0][cv_subtotal]">
							</td>
							<td class="text-center">IDR</td>
						</tr>
						
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	
	<div class="row">
		<div class="col-12">
			<table class="table mb-0" style="font-size:12px">
				<tr>
					<td class="border-bottom-0" width="4%"></td>
					<td class="border-bottom-0" width="12%">Jumlah</td>
					<td class="border-bottom-0" width="70%"></td>
					<td class="border-bottom-0 text-right" width="9%" id="total_jumlah">0.00</td>
					<td class="border-bottom-0 text-center" width="5%">IDR</td>
				</tr>
				<tr>
					<td class="border-top-0"></td>
					<td class="border-top-0">PPN</td>
					<td class="border-top-0"></td>
					<td class="border-top-0 text-right" id="total_ppn">0.00</td>
					<td class="border-top-0 text-center">IDR</td>
				</tr>
				<tr>
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
<?php ActiveForm::end(); ?>

<script>
	$(document).ready(function(){
		get_total_jumlah();
		get_total_ppn();
		get_total_pph();
		get_grandtotal();
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
		id_ppn = $('#ppntype-'+idx).val();
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
		subtotal = (qty * amount) + total_ppn - pph;
		
		$('#ppn-'+idx).val(total_ppn);
		
		$('#div_subtotal-'+idx).html(addSeparator(subtotal.toFixed(2)));
		$('#subtotal-'+idx).val(subtotal);
		
		get_total_jumlah();
		get_total_ppn();
		get_total_pph();
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
				item += '<input type="text" class="form-control" id="detail-'+id+'" name="CostVoucherV5[detail]['+id+'][cv_detail]" required>';
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
			item += '<td>';
				item += '<select class="form-select form-select-lg ppntype" id="ppntype-'+id+'" name="CostVoucherV5[detail]['+id+'][id_ppn]" onchange="changeInput(this.id)" required>';
					item += '<option></option>';
					item += "<?php
						foreach($ppn as $row){
							$name = explode('-', $row['name']);
							$name_ppn = $name[1].'-'.$row['amount'].'%';
							
							// Baru -> Default yg 050-1,1%
							if($name[1] == '050'){
								$selected = 'selected';
							}else{
								$selected = '';
							}
							echo "<option value='".$row['id']."' ".$selected.">".
								$name_ppn.
							"</option>";
						}
					?>";
				item += '</select>';
				item += '<input type="hidden" class="form-control ppn" id="ppn-'+id+'" value="" name="CostVoucherV5[detail]['+id+'][ppn]">';
			item += '</td>';
			item += '<td>';
				item += '<input type="text" class="form-control pph" id="pph-'+id+'" value="" name="CostVoucherV5[detail]['+id+'][pph]" onkeyup="changeInput(this.id)" required>';
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