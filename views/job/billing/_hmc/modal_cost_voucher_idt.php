<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use richardfan\widget\JSRegister;
use yii\bootstrap4\Modal;

use app\models\Customer;
use app\models\PosV8;
use app\models\Packages;
use app\models\Currency;
use app\models\Movement;
use app\models\Signature;
use app\models\Office;
use app\models\JobParty;
use app\models\CustomerAlias;
use app\models\MasterPpn;
use app\models\DMasterNewJobinvoice;
use app\models\DMasterNewJobinvoiceDetail;

$customer 	= Customer::find()->where(['is_active'=>1])->orderBy(['customer_companyname'=>SORT_ASC])->all();
$pos 		= PosV8::find()->where(['is_active'=>1])->orderby(['pos_name'=>SORT_ASC])->all();
$packages 	= Packages::find()->orderby(['packages_name'=>SORT_ASC])->all();
$currency 	= Currency::find()->orderby(['currency_id'=>SORT_ASC])->all();
$movement 	= Movement::find()->orderby(['movement_name'=>SORT_ASC])->all();
$signature	= Signature::find()->where(['is_active'=>1])->orderby(['signature_name'=>SORT_ASC])->all();
$office 	= Office::find()->all();
$ppn		= MasterPpn::find()->where(['is_active'=>1])->all();
?>

<?php $form = ActiveForm::begin(['id' => 'form_invoice_idt', 'action' => Url::base().'/job/save-invoice-idt']); ?>
<input type="hidden" value="<?= $_GET['id']?>" name="DMasterNewJobinvoice[inv_job_id]">
<?php
	Modal::begin([
		'title' => 'Create Cost Voucher IDT',
		'id' => 'cost_voucher_idt',
		'size' => 'modal-xl',
	]);
?>
	<div id="content">
		<div class="row form-group">
            <div class="col-1">
                <label class="fw-normal">Date</label>
            </div>
			<div class="col-3">
				<input type="date" class="form-control" id="costidt_date" value="<?= date('Y-m-d') ?>" name="MasterNewJobCost[]" required>
			</div>
        </div>
		
		<div class="row form-group">
            <div class="col-1">
                <label class="fw-normal">Payee</label>
            </div>
			<div class="col-3">
				<select class="form-control" id="costidt_pay" name="MasterNewJobCost[]" required>
					<option value="" disabled hidden></option>
					<?php
						foreach($customer as $row){
							if(isset($job_customer->customer)){
								if($job_customer->customer == $row['customer_id']){
									$selected = 'selected';
								}else{
									$selected = '';
								}
							}else{
								$selected = '';
							}
							
							echo "<option value='".$row['customer_id']."' ".$selected.">".
								$row['customer_companyname'].
							"</option>";
						}
					?>
				</select>
			</div>
			
			<div class="offset-1 col-2">
				<label class="fw-normal">Upload Document</label>
			</div>
			<div class="col-4">
				<div class="row m-0">
					<input type="text" class="form-control" style="width:50%" id="" name="">
					<button type="button" class="btn btn-default">Choose File</button>
				</div>
				<span style="white-space:nowrap;font-size:10px">( JPG, PNG, PDF, DOC, XLS, Max 10 MB )</span>
			</div>
			
        </div>
		<br>
		<div class="row">
			<div class="col-12">
				<table class="table" id="table_cost_voucher_idt">
					<thead>
						<tr>
							<td width="5%"></td>
							<td width="15%">Desc. of Charges</td>
							<td width="15%">Detail</td>
							<td width="13%">Basis</td>
							<td width="7%">Jumlah</td>
							<td width="7%">Satuan</td>
							<td width="14%">Rate</td>
							<td width="9%">Amount</td>
							<td width="5%">Curr</td>
							<td width="10%">PPN</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="text-center">
								<button type="button" class="btn btn-xs btn-success rounded-pill" style="padding: 0px 5px" onclick="addrowCostIdt()">
									<span class="fa fa-plus align-middle"></span>
								</button>
							</td>
							<td>
								<select class="form-select form-select-lg" id="costidt_pos-1" name="DMasterNewJobinvoiceDetail[detail][1][invd_pos]" required>
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
								<input type="text" class="form-control" id="costidt_detail-1" value="" name="DMasterNewJobinvoiceDetail[detail][1][invd_detail]" required>
							</td>
							<td>
								<div class="row">
									<div class="col-6 pr-1">
										<input type="text" class="form-control basis" id="costidt_basis-1" value="" name="DMasterNewJobinvoiceDetail[detail][1][invd_basis1_total]" onkeyup="changeBasisCostIdt(this.id)" required>
									</div>
									<div class="col-6 pl-1">
										<select class="form-select form-select-lg" id="costidt_basispack-1" name="DMasterNewJobinvoiceDetail[detail][1][invd_basis1_type]" required>
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
									</div>
								</div>
							</td>
							<td>
								<input type="text" class="form-control jumlah" id="costidt_jumlah-1" value="" name="DMasterNewJobinvoiceDetail[detail][1][invd_basis2_total]" onkeyup="changeJumlahCostIdt(this.id)" required>
							</td>
							<td>
								<select class="form-select form-select-lg" id="costidt_jumlahpack-1" name="DMasterNewJobinvoiceDetail[detail][1][invd_basis2_type]" required>
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
								<div class="row">
									<div class="col-7 pr-1">
										<input type="hidden" class="form-control costidt_tarif" id="costidt_tarif-1" value="" name="DMasterNewJobinvoiceDetail[detail][1][invd_rate]">
										<input type="text" class="form-control costidt_tarif1" id="costidt_tarif1-1" value="" onkeyup="changeTarifCostIdt(this.id)" required>
									</div>
									<div class="col-5 pl-1 pt-2">
										<input type="text" class="form-control costidt_tarif2" id="costidt_tarif2-1" style="height:25px" value="00" onkeyup="changeTarifCostIdt(this.id)">
									</div>	
								</div>
							</td>
							<!-- Subtotal -->
							<td class="text-right">
								<label class="fw-normal mt-1 mb-0" id="costidt_label_subtotal-1">0.00</label>
								<input type="hidden" class="form-control costidt_subtotal" id="costidt_subtotal-1" value="" name="DMasterNewJobinvoiceDetail[detail][1][invd_amount]">
							</td>
							<td>IDR</td>
							<td>
								<select class="form-select form-select-lg costidt_ppntype" id="costidt_ppntype-1" name="DMasterNewJobinvoiceDetail[detail][1][invd_ppn]" required onchange="getTotalCostIdt()">
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
							</td>
						</tr>
						
						<tr>
							<td colspan="6"></td>
							<td>
								<p>Jumlah</p>
								<p>PPN</p>
							</td>
							<td class="text-right">
								<!-- Jumlah -->
								<label class="fw-normal mt-1 mb-0" id="costidt_label_total">0.00</label>
								<input type="hidden" class="form-control costidt_total" id="costidt_total" value="" name="DMasterNewJobinvoice[inv_total]">
								<br>
								<!-- PPN -->
								<label class="fw-normal mt-1 mb-0" id="costidt_label_ppn">0.00</label>
								<input type="hidden" class="form-control costidt_totalppn" id="costidt_totalppn" value="" name="DMasterNewJobinvoice[inv_ppn]">
							</td>
							<td>
								<p>IDR</p>
								<p>IDR</p>
							</td>
							<td></td>
						</tr>
						<!-- Grandtotal -->
						<tr>
							<td colspan="6"></td>
							<td>TOTAL</td>
							<td class="text-right">
								<label class="fw-normal mt-1 mb-0" id="costidt_label_grandtotal">0.00</label>
								<input type="hidden" class="form-control costidt_grandtotal" id="costidt_grandtotal" value="" name="DMasterNewJobinvoice[inv_grandtotal]">
							</td>
							<td>IDR </td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<hr>
		
		<div class="row form-group" style="float:right">
			<div class="col-12">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-dark">Save</button>
			</div>
		</div>
	</div>
<?php Modal::end(); ?>
<?php ActiveForm::end(); ?>

<script>
	$(document).ready(function(){
	});
	
	function addrowCostIdt(){
		id = $('#table_cost_voucher_idt tbody tr').length-2;
		
		if(id){
            i = id+1;
        }else{
            i = 1;
		}

		item = '';
		item += '<tr>';
			item += '<td class="text-center">';
				item += '<button class="btn btn-xs btn-danger" style="padding: 0px 5px" onclick="delrowCostIdt($(this))">';
					item += '<span class="fa fa-trash align-middle"></span>';
				item += '</button>';
			item += '</td>';
			item += '<td>';
				item += '<select class="form-select form-select-lg" id="costidt_pos-'+i+'" name="DMasterNewJobinvoiceDetail[detail]['+i+'][invd_pos]" required>';
					item += '<option value="" disabled selected hidden></option>';
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
				item += '<input type="text" class="form-control" id="costidt_detail-'+i+'" value="" name="DMasterNewJobinvoiceDetail[detail]['+i+'][invd_detail]" required>';
			item += '</td>';
			item += '<td>';
				item += '<div class="row">';
					item += '<div class="col-6 pr-1">';
						item += '<input type="text" class="form-control costidt_basis" id="costidt_basis-'+i+'" value="" name="DMasterNewJobinvoiceDetail[detail]['+i+'][invd_basis1_total]" onkeyup="changeBasisCostIdt(this.id)" required>';
					item += '</div>';
					item += '<div class="col-6 pl-1">';
						item += '<select class="form-select form-select-lg" id="costidt_basispack-'+i+'" name="DMasterNewJobinvoiceDetail[detail]['+i+'][invd_basis1_type]" required>';
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
					item += '</div>';
				item += '</div>';
			item += '</td>';

			item += '<td>';
				item += '<input type="text" class="form-control costidt_jumlah" id="costidt_jumlah-'+i+'" value="" name="DMasterNewJobinvoiceDetail[detail]['+i+'][invd_basis2_total]" onkeyup="changeJumlahCostIdt(this.id)" required>';
			item += '</td>';
			item += '<td>';
				item += '<select class="form-select form-select-lg" id="costidt_jumlahpack-'+i+'" name="DMasterNewJobinvoiceDetail[detail]['+i+'][invd_basis2_type]" required>';
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
				item += '<div class="row">';
					item += '<div class="col-7 pr-1">';
						item += '<input type="hidden" class="form-control costidt_tarif" id="costidt_tarif-'+i+'" value="" name="DMasterNewJobinvoiceDetail[detail]['+i+'][invd_rate]">';
						item += '<input type="text" class="form-control costidt_tarif1" id="costidt_tarif1-'+i+'" value="" onkeyup="changeTarifCostIdt(this.id)" required>';
					item += '</div>';
					item += '<div class="col-5 pl-1 pt-2">';
						item += '<input type="text" class="form-control costidt_tarif2" id="costidt_tarif2-'+i+'" style="height:25px" value="00" onkeyup="changeTarifCostIdt(this.id)">';
					item += '</div>';	
				item += '</div>';
			item += '</td>';
			
			item += '<td class="text-right">';
				item += '<label class="fw-normal mt-1 mb-0" id="costidt_label_subtotal-'+i+'">0.00</label>';
				item += '<input type="hidden" class="form-control costidt_subtotal" id="costidt_subtotal-'+i+'" value="" name="DMasterNewJobinvoiceDetail[detail]['+i+'][invd_amount]">';
			item += '</td>';
			item += '<td>IDR</td>';
			
			item += '<td>';
				item += '<select class="form-select form-select-lg costidt_ppntype" id="costidt_ppntype-'+i+'" name="DMasterNewJobinvoiceDetail[detail]['+i+'][invd_ppn]" onchange="getTotalCostIdt()" required>';
					item += "<?php
						foreach($ppn as $row){
							$name = explode('-', $row['name']);
							$name_ppn = $name[1].'-'.$row['amount'].'%';
							
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
			item += '</td>';
		item += '</tr>';
		
		tr = $('#table_cost_voucher_idt tbody tr').length-3;
	
		$('#table_cost_voucher_idt tbody tr:eq('+tr+')').after(item);
	}
	
	function delrowCostIdt(el){
		el.parent().parent().remove();
		
		getTotal();
	}
	
	function changeInputCostIdt(id){
		idx = id.split('-')[1];
		
		basis 	= $('#costidt_basis-'+idx).val();
		jumlah 	= $('#costidt_jumlah-'+idx).val();
		tarif1 	= $('#costidt_tarif1-'+idx).val();
		tarif2 	= $('#costidt_tarif2-'+idx).val();
		ppntype	= $('#costidt_ppntype-'+idx+' option:selected').html();
		
		tarif = parseFloat(tarif1+'.'+tarif2);
		
		ppn = parseFloat(ppntype.split('-')[1].replace('%',''));
		
		if(!basis){
			basis = 0
		}
		if(!jumlah){
			jumlah = 0
		}
		if(!tarif){
			tarif = 0
		}
		if(!ppn){
			ppn = 0
		}
		
		subtotal = basis * jumlah * tarif;
		
		$('#costidt_label_subtotal-'+idx).html(addSeparator(subtotal.toFixed(2)));
		$('#costidt_subtotal-'+idx).val(subtotal);
	}


	function changeBasisCostIdt(id){
		idx = id.split('-')[1];
		
		basis = $('#costidt_basis-'+idx).val();
		jumlah = $('#costidt_jumlah-'+idx).val();
		tarif1 	= $('#costidt_tarif1-'+idx).val();
		tarif2 	= $('#costidt_tarif2-'+idx).val();
		
		tarif = parseFloat(tarif1+'.'+tarif2);
		
		if(basis == ''){
			basis = 0;
		}else{
			basis = $('#costidt_basis-'+idx).val();
		}
		
		if(jumlah == ''){
			jumlah = 0;
		}else{
			jumlah = $('#costidt_jumlah-'+idx).val();
		}
		
		subtotal = basis * jumlah * tarif;
		
		$('#costidt_label_subtotal-'+idx).html(addSeparator(subtotal.toFixed(2)));
		$('#costidt_subtotal-'+idx).val(subtotal);
		
		getTotalCostIdt();
	}
	
	function changeJumlahCostIdt(id){
		idx = id.split('-')[1];
		
		basis = $('#costidt_basis-'+idx).val();
		jumlah = $('#costidt_jumlah-'+idx).val();
		tarif1 	= $('#costidt_tarif1-'+idx).val();
		tarif2 	= $('#costidt_tarif2-'+idx).val();
		
		tarif = parseFloat(tarif1+'.'+tarif2);
		
		if(basis == ''){
			basis = 0;
		}else{
			basis = $('#costidt_basis-'+idx).val();
		}
		
		if(jumlah == ''){
			jumlah = 0;
		}else{
			jumlah = $('#costidt_jumlah-'+idx).val();
		}
		
		subtotal = basis * jumlah * tarif;
		
		$('#costidt_label_subtotal-'+idx).html(addSeparator(subtotal.toFixed(2)));
		$('#costidt_subtotal-'+idx).val(subtotal);
		
		getTotalCostIdt();
	}
	
	// Gabungan Tarif
	$('.costidt_tarif1, .costidt_tarif2').on('keyup', function(){
		$('.tarif').each(function(i){
			input_tarif1 = Number($('.costidt_tarif1').eq(i).val());
			input_tarif2 = $('.costidt_tarif2').eq(i).val();
			
			tarif = input_tarif1+'.'+input_tarif2;
			
			$('.costidt_tarif').eq(i).val(tarif);
		});
	});

	function changeTarifCostIdt(id){
		idx = id.split('-')[1];
		
		basis = $('#costidt_basis-'+idx).val();
		jumlah = $('#costidt_jumlah-'+idx).val();
		tarif1 	= $('#costidt_tarif1-'+idx).val();
		tarif2 	= $('#costidt_tarif2-'+idx).val();
		
		tarif = parseFloat(tarif1+'.'+tarif2);
		
		if(basis == ''){
			basis = 0;
		}else{
			basis = $('#costidt_basis-'+idx).val();
		}
		
		if(jumlah == ''){
			jumlah = 0;
		}else{
			jumlah = $('#costidt_jumlah-'+idx).val();
		}
		
		subtotal = basis * jumlah * tarif;
		
		$('#costidt_label_subtotal-'+idx).html(addSeparator(subtotal.toFixed(2)));
		$('#costidt_subtotal-'+idx).val(subtotal);
		
		getTotalCostIdt();
	}
	
	function getTotalCostIdt(){
		total = 0;
		total_ppn = 0;
		
        $('.costidt_subtotal').each(function(index) {
			if($(this).val() == ''){
				subtotal = 0;
			}else{
				subtotal = $(this).val();
			}
			
			ppntype	= $('.costidt_ppntype:eq('+index+') option:selected').html();
			ppn = parseFloat(ppntype.split('-')[1].replace('%',''));
			
			total += parseFloat(subtotal);
			total_ppn += Math.floor(parseFloat(subtotal) * parseFloat(ppn) / 100);
        });
		
		// ppn = Math.floor(0.011 * total);
		grandtotal = total + total_ppn;
		
		$('#costidt_label_total').html(addSeparator(total.toFixed(2)));
		$('#costidt_total').val(total);
		
		$('#costidt_label_ppn').html(addSeparator(total_ppn.toFixed(2)));
		$('#costidt_totalppn').val(total_ppn);

		$('#costidt_label_grandtotal').html(addSeparator(grandtotal.toFixed(2)));
		$('#costidt_grandtotal').val(grandtotal);
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
	
	$('.qty, .qty_kg, .harga, .subtotal').keyup(function(event)
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
