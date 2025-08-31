<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use yii\widgets\ActiveForm;

use app\models\Customer;
use app\models\CustomerAlias;

use app\models\PosV8;
use app\models\Packages;
use app\models\Currency;
use app\models\Movement;
use app\models\Signature;
use app\models\Office;
use app\models\JobParty;

use app\models\MasterPpn;
use app\models\MasterNewJobinvoice;
use app\models\MasterNewJobinvoiceDetail;

use yii\helpers\VarDumper;


$customer 	= Customer::find()->where(['is_active'=>1])->orderBy(['customer_companyname'=>SORT_ASC])->all();
$pos 		= PosV8::find()->where(['is_active'=>1])->orderby(['pos_name'=>SORT_ASC])->all();
$packages 	= Packages::find()->orderby(['packages_name'=>SORT_ASC])->all();
$currency 	= Currency::find()->orderby(['currency_id'=>SORT_ASC])->all();
$movement 	= Movement::find()->orderby(['movement_name'=>SORT_ASC])->all();
$signature	= Signature::find()->where(['is_active'=>1])->orderby(['signature_name'=>SORT_ASC])->all();
$office 	= Office::find()->all();
$ppn		= MasterPpn::find()->where(['is_active'=>1])->all();

// Input Customer dr Job Party
$job_party = JobParty::find()->where(['id_job' => $_GET['id'],'is_active' => 1])->one();

if(isset($job_party)){
	$data_customer = Customer::find()->where(['customer_id' => $job_party->customer, 'is_active'=>1])->one();
	$data_customer_alias = CustomerAlias::find()->where(['customer_alias_id' => $job_party->customer_alias, 'is_active'=>1])->one();
	
	$nama_customer = $data_customer->customer_companyname;
	$id_customer = $data_customer->customer_id;
	$customer_alias = $data_customer_alias->customer_name;
	$id_customer_alias = $data_customer_alias->customer_alias_id;
}else{
	$nama_customer = '';
	$id_customer = '';
	$customer_alias = '';
	$id_customer_alias = '';
}

// Input To dr Job Party (Khusus Billing Party)
if(isset($job_party)){
	$array_to = array();

	if(!empty($job_party->billingparty_count_1)){
		$data_customer = Customer::find()->where(['customer_id' => $job_party->billingparty_1, 'is_active'=>1])->one();
		
		$array_to[1] = [
			'customer_id' => $job_party->billingparty_1,
			'customer_companyname' => $data_customer->customer_companyname,
			'customer_alias_id' => $job_party->billingparty_alias_1, 
			'address' => $job_party->billingparty_address_1,
		];
	}
	
	if(!empty($job_party->billingparty_count_2)){
		$data_customer = Customer::find()->where(['customer_id' => $job_party->billingparty_2, 'is_active'=>1])->one();
		
		$array_to[2] =  [
			'customer_id' => $job_party->billingparty_2,
			'customer_companyname' => $data_customer->customer_companyname,
			'customer_alias_id' => $job_party->billingparty_alias_2, 
			'address' => $job_party->billingparty_address_2,
		];
	}
	
	if(!empty($job_party->billingparty_count_3)){
		$data_customer = Customer::find()->where(['customer_id' => $job_party->billingparty_3, 'is_active'=>1])->one();
		
		$array_to[3] =  [
			'customer_id' => $job_party->billingparty_3,
			'customer_companyname' => $data_customer->customer_companyname,
			'customer_alias_id' => $job_party->billingparty_alias_3, 
			'address' => $job_party->billingparty_address_3,
		];
	}
	
	if(!empty($job_party->billingparty_count_4)){
		$data_customer = Customer::find()->where(['customer_id' => $job_party->billingparty_4, 'is_active'=>1])->one();
		
		$array_to[4] =  [
			'customer_id' => $job_party->billingparty_4,
			'customer_companyname' => $data_customer->customer_companyname,
			'customer_alias_id' => $job_party->billingparty_alias_4, 
			'address' => $job_party->billingparty_address_4,
		];
	}
}

date_default_timezone_set('Asia/Jakarta');
?>

<div id="modal-inv-idt-create">
<?php $form = ActiveForm::begin(['id' => 'form_invoice_idt', 'action' => Url::base().'/job/save-invoice-idt']); ?>
<input type="hidden" value="<?= $_GET['id']?>" name="MasterNewJobinvoice[inv_job_id]">

	<?php
		Modal::begin([
			'title' => 'Create Invoice IDT',
			'id' => 'modal_invoice_idt_create',
			'size' => 'modal-xl',
		]);
	?>
		<div id="content">
			<div class="row form-group">
				<div class="col-1">
					<label class="fw-normal">Date</label>
				</div>
				<div class="col-3">
					<input type="date" class="form-control" id="date_invoice_idt" value="<?= date('Y-m-d') ?>" name="MasterNewJobinvoice[inv_date]" required>
				</div>
			</div>
			
			<!-- Customer -->
			<div class="row">
				<div class="col-6 mb-4">
					<div class="row">
						<div class="col-2">
							<label class="fw-normal">Customer</label>
						</div>
						<div class="col-10">
							<div class="form-group">
								<input type="text" class="form-control" id="nama_inv_idt_cust1" value="<?= $nama_customer ?>" readonly>
								<input type="hidden" class="form-control" id="inv_idt_cust1" name="MasterNewJobinvoice[inv_customer]" value="<?= $id_customer ?>">
							</div>
						</div>
						
						<div class="col-2"></div>
						<div class="col-10">
							<div class="form-group">
								<input type="text" class="form-control" id="nama_inv_idt_cust2" value="<?= $customer_alias ?>" readonly>
								<input type="hidden" class="form-control" id="inv_idt_cust2" name="MasterNewJobinvoice[inv_customer2]" value="<?= $id_customer_alias ?>">
							</div>
						</div>
						
						<div class="col-2"></div>
						<div class="col-10">
							<div class="form-group">
								<textarea class="form-control" id="inv_idt_cust3" rows="5" name="MasterNewJobinvoice[inv_customer3]" readonly><?php if(isset($job_party->customer_address)){ echo str_replace("\\n","\n",$job_party->customer_address); }?></textarea>
							</div>
						</div>
					</div>
				</div>
				
				<!-- To -->
				<div class="col-6 mb-4">
					<div class="row">
						<div class="col-1"></div>
						<div class="col-1">
							<label class="fw-normal">To</label>
						</div>
						<div class="col-10">
							<div class="form-group">
								<select class="form-select form-select-lg" id="inv_idt_to1" name="MasterNewJobinvoice[inv_to]" required>
									<option></option>
									<?php
										if(isset($array_to)){
											foreach($array_to as $row){
												$selected = '';
												
												echo "<option value='".$row['customer_id']."' ".$selected.">".
													$row['customer_companyname'].
												"</option>";
											}
										}
									?>
								</select>
							</div>
						</div>
						
						<div class="col-2"></div>
						<div class="col-10">
							<div class="form-group">
								<select class="form-select form-select-lg" id="inv_idt_to2" name="MasterNewJobinvoice[inv_to2]" required>
									<option value="" disabled hidden></option>
									<?php
										$customer_alias = CustomerAlias::find()->where(['is_active'=>1])->orderBy(['customer_name'=>SORT_ASC])->all();

										foreach($customer_alias as $row){
											$selected = '';
											
											echo "<option value='".$row['customer_alias_id']."' ".$selected.">".
												$row['customer_name'].
											"</option>";
										}
									?>
								</select>
							</div>
						</div>
						
						<div class="col-2"></div>
						<div class="col-10">
							<div class="form-group">
								<textarea class="form-control" id="inv_idt_to3" rows="5" name="MasterNewJobinvoice[inv_to3]" readonly></textarea>
							</div>
						</div>
					</div>
				</div>
				<br>
				<!-- Table Detail -->
				<div class="row">
					<div class="col-12">
						<table class="table" id="table_invoice_idt">
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
										<button type="button" class="btn btn-xs btn-success rounded-pill" style="padding: 0px 5px" onclick="addrow()">
											<span class="fa fa-plus align-middle"></span>
										</button>
									</td>
									<td>
										<select class="form-select form-select-lg" id="pos-1" name="MasterNewJobinvoiceDetail[detail][1][invd_pos]" required>
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
										<input type="text" class="form-control" id="detail-1" value="" name="MasterNewJobinvoiceDetail[detail][1][invd_detail]">
									</td>
									<td>
										<div class="row">
											<div class="col-6 pr-1">
												<input type="text" class="form-control basis" id="basis-1" value="" name="MasterNewJobinvoiceDetail[detail][1][invd_basis1_total]" onkeyup="changeInputInvoice(this.id)" required>
											</div>
											<div class="col-6 pl-1">
												<select class="form-select form-select-lg" id="basispack-1" name="MasterNewJobinvoiceDetail[detail][1][invd_basis1_type]" required>
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
										<input type="text" class="form-control jumlah" id="jumlah-1" value="" name="MasterNewJobinvoiceDetail[detail][1][invd_basis2_total]" onkeyup="changeInputInvoice(this.id)" required>
									</td>
									<td>
										<select class="form-select form-select-lg" id="jumlahpack-1" name="MasterNewJobinvoiceDetail[detail][1][invd_basis2_type]" required>
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
												<input type="hidden" class="form-control tarif" id="tarif-1" value="" name="MasterNewJobinvoiceDetail[detail][1][invd_rate]">
												<input type="text" class="form-control tarif1" id="tarif1-1" value="" onkeyup="changeInputInvoice(this.id)" required>
											</div>
											<div class="col-5 pl-1 pt-2">
												<input type="text" class="form-control tarif2" id="tarif2-1" style="height:25px" value="00" onkeyup="changeInputInvoice(this.id)">
											</div>	
										</div>
									</td>
									<!-- Subtotal -->
									<td class="text-right">
										<label class="fw-normal mt-1 mb-0" id="label_subtotal-1">0.00</label>
										<input type="hidden" class="form-control subtotal" id="subtotal-1" value="" name="MasterNewJobinvoiceDetail[detail][1][invd_amount]">
									</td>
									<td>IDR</td>
									<td>
										<select class="form-select form-select-lg ppntype" id="ppntype-1" name="MasterNewJobinvoiceDetail[detail][1][invd_ppn]" onchange="getTotal()" required>
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
										<label class="fw-normal mt-1 mb-0" id="label_total">0.00</label>
										<input type="hidden" class="form-control total" id="total" value="" name="MasterNewJobinvoice[inv_total]">
										<br>
										<!-- PPN -->
										<label class="fw-normal mt-1 mb-0" id="label_ppn">0.00</label>
										<input type="hidden" class="form-control totalppn" id="totalppn" value="" name="MasterNewJobinvoice[inv_ppn]">
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
										<label class="fw-normal mt-1 mb-0" id="label_grandtotal">0.00</label>
										<input type="hidden" class="form-control grandtotal" id="grandtotal" value="" name="MasterNewJobinvoice[inv_grandtotal]">
									</td>
									<td>IDR </td>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<hr>
			
			<div class="row form-group" style="float:right">
				<div class="col-12">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-dark">Save</button>
				</div>
			</div>
		</div>
	<?php Modal::end(); ?>
<?php ActiveForm::end(); ?>
</div>

<script>
	$(document).ready(function(){
	});
	
	// $('#inv_idt_to1').select2();
	
	$('#inv_idt_to1').change(function(){
		var key = $('#inv_idt_to1').val();
		var id = 'inv_idt_to';
		getpartyInvoice(key, id);
	});
	
	//Get customer alias address
	$('#inv_idt_to2').change(function(){
		var key = $('#inv_idt_to2').val();
		var id = 'inv_idt_to';
		getpartyaliasInvoice(key, id);
	});
	
	//Ajax party
	function getpartyInvoice(key, id){
		$.ajax({
			url: '<?=Url::base().'/job/get-customer-alias'?>',
			data: {'id': key},
			dataType: 'json',
			method: 'POST',
            async: 'false'
		}).done(function(res){
			if(res.list_customer)
			{
				var list = res.list_customer;
				
				$('#'+id+'2').find('option').remove().end();
				
				list.forEach(a => {
					$('#'+id+'2').append('<option value="'+a['customer_alias_id']+'">'+a['customer_name']+'</option>');
				});
			}
			if(res.address){
				$('#'+id+'3').val(res.address);
			}
		}).fail(function(err){
			
		});
	}
	
	//Ajax get address customer alias
	function getpartyaliasInvoice(key, id){
		$.ajax({
			url: '<?=Url::base().'/job/get-customer-alias-address'?>',
			data: {'id': key},
			dataType: 'json',
			method: 'POST',
            async: 'false'
		}).done(function(res){
			console.log(res);
			if(res.data){
				$('#'+id+'3').val(res.data['customer_alias']);
			}
		});
	}
	
	function addrow(){
		id = $('#table_invoice_idt tbody tr').length-2;
		
		if(id){
            i = id+1;
        }else{
            i = 1;
		}

		item = '';
		item += '<tr>';
			item += '<td class="text-center">';
				item += '<button class="btn btn-xs btn-danger" style="padding: 0px 5px" onclick="delrow($(this))">';
					item += '<span class="fa fa-trash align-middle"></span>';
				item += '</button>';
			item += '</td>';
			item += '<td>';
				item += '<select class="form-select form-select-lg" id="pos-'+i+'" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_pos]" required>';
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
				item += '<input type="text" class="form-control" id="detail-'+i+'" value="" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_detail]">';
			item += '</td>';
			item += '<td>';
				item += '<div class="row">';
					item += '<div class="col-6 pr-1">';
						item += '<input type="text" class="form-control basis" id="basis-'+i+'" value="" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_basis1_total]" onkeyup="changeInputInvoice(this.id)" required>';
					item += '</div>';
					item += '<div class="col-6 pl-1">';
						item += '<select class="form-select form-select-lg" id="basispack-'+i+'" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_basis1_type]" required>';
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
				item += '<input type="text" class="form-control jumlah" id="jumlah-'+i+'" value="" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_basis2_total]" onkeyup="changeInputInvoice(this.id)" required>';
			item += '</td>';
			item += '<td>';
				item += '<select class="form-select form-select-lg" id="jumlahpack-'+i+'" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_basis2_type]" required>';
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
						item += '<input type="hidden" class="form-control tarif" id="tarif-'+i+'" value="" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_rate]">';
						item += '<input type="text" class="form-control tarif1" id="tarif1-'+i+'" value="" onkeyup="changeInputInvoice(this.id)" required>';
					item += '</div>';
					item += '<div class="col-5 pl-1 pt-2">';
						item += '<input type="text" class="form-control tarif2" id="tarif2-'+i+'" style="height:25px" value="00" onkeyup="changeInputInvoice(this.id)">';
					item += '</div>';	
				item += '</div>';
			item += '</td>';
			
			item += '<td class="text-right">';
				item += '<label class="fw-normal mt-1 mb-0" id="label_subtotal-'+i+'">0.00</label>';
				item += '<input type="hidden" class="form-control subtotal" id="subtotal-'+i+'" value="" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_amount]">';
			item += '</td>';
			item += '<td>IDR</td>';
			
			item += '<td>';
				item += '<select class="form-select form-select-lg ppntype" id="ppntype-'+i+'" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_ppn]" onchange="getTotal()" required>';
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
		
		tr = $('#table_invoice_idt tbody tr').length-3;
	
		$('#table_invoice_idt tbody tr:eq('+tr+')').after(item);
		
		// Gabungan Tarif
		$('.tarif1, .tarif2').on('keyup', function(){
			$('.tarif').each(function(i){
				input_tarif1 = Number($('.tarif1').eq(i).val());
				input_tarif2 = $('.tarif2').eq(i).val();
				
				tarif = input_tarif1+'.'+input_tarif2;
				
				$('.tarif').eq(i).val(tarif);
			});
		});
	}
	
	function delrow(el){
		el.parent().parent().remove();
		
		getTotal();
	}
	
	function changeInputInvoice(id){
		idx = id.split('-')[1];
		
		basis 	= $('#basis-'+idx).val();
		jumlah 	= $('#jumlah-'+idx).val();
		tarif1 	= $('#tarif1-'+idx).val();
		tarif2 	= $('#tarif2-'+idx).val();
		ppntype	= $('#ppntype-'+idx+' option:selected').html();
		
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
		
		$('#label_subtotal-'+idx).html(addSeparator(subtotal.toFixed(2)));
		$('#subtotal-'+idx).val(subtotal);
		
		getTotal();
	}
	
	// Gabungan Tarif
	$('.tarif1, .tarif2').on('keyup', function(){
		$('.tarif').each(function(i){
			input_tarif1 = Number($('.tarif1').eq(i).val());
			input_tarif2 = $('.tarif2').eq(i).val();
			
			tarif = input_tarif1+'.'+input_tarif2;
			
			$('.tarif').eq(i).val(tarif);
		});
	});
	
	function getTotal(){
		total = 0;
		total_ppn = 0;
		
        $('.subtotal').each(function(index) {
			if($(this).val() == ''){
				subtotal = 0;
			}else{
				subtotal = $(this).val();
			}
			
			ppntype	= $('.ppntype:eq('+index+') option:selected').html();
			ppn = parseFloat(ppntype.split('-')[1].replace('%',''));
			
			total += parseFloat(subtotal);
			total_ppn += Math.floor(parseFloat(subtotal) * parseFloat(ppn) / 100);
        });
		
		grandtotal = total + total_ppn;
		
		$('#label_total').html(addSeparator(total.toFixed(2)));
		$('#total').val(total);
		
		$('#label_ppn').html(addSeparator(total_ppn.toFixed(2)));
		$('#totalppn').val(total_ppn);

		$('#label_grandtotal').html(addSeparator(grandtotal.toFixed(2)));
		$('#grandtotal').val(grandtotal);
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












	<!--<div class="container2">
	  <table class="table" style="vertical-align: center;">
		<thead class="bg-secondary2">
		  <tr>
			<th width="13%">Invoice No</th>
			<th width="10%">Date</th>
			<th width="28%">To</th>
			<th width="15%" class="float-middle">Amount</th>
			<th width="12%"></th>
			<th width="10%"></th>
			<th width="12%"></th>
		  </tr>
		</thead>
		<tbody>
		  <tr>
			<td scope="row">IDT004698</td>
			<td>5 Mar 2022</td>
			<td>PT THE MASTER STEEL MANUFACTORY</td>
			<td><p class="text-right">1,500,000 IDR</p></td>
			<td class="text-right"><a class="btn btn-clear btn-xs">View Invoice</a></td>
			<td><a class="btn btn-clear btn-xs">View Cost</a></td>
			<td>
			  <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
			  <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
			  <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
			</td>
		  </tr>
		  <tr>
			<td scope="row">IDT004699</td>
			<td>4 Mar 2022</td>
			<td>AHASEES GENERAL TRADING LLC</td>
			<td><p class="text-right">800,000 IDR</p></td>
			<td class="text-right"><a class="btn btn-clear btn-xs">View Invoice</a></td>
			<td><a class="btn btn-clear btn-xs">View Cost</a></td>
			<td>
			  <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
			  <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
			  <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
			</td>
		  </tr>
		  <tr>
			<td scope="row">IDT004688</td>
			<td>3 Mar 2022</td>
			<td>LAMBERTI BROS (WHOLESALE) PTY LTD.</td>
			<td><p class="text-right">2,770,000 IDR</p></td>
			<td class="text-right"><a class="btn btn-clear btn-xs" onclick="hidetable();">View Invoice</a></td>
			<td><a class="btn btn-clear btn-xs">View Cost</a></td>
			<td>
			  <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
			  <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
			  <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
			</td>
		  </tr>
		  
		  <tr style="display:none" class="bg-gray" id="bil_table">
			<td colspan="2"></td>
			<td colspan="5">
			<div style="border: 1px solid black;">
			  <table class="table" style="vertical-align: center;">
				<thead class="bg-secondary2">
				  <tr>
					<th width="15%">Voucher No</th>
					<th width="15%">Date</th>
					<th width="25%">Pay For</th>
					<th width="10%">Pay To</th>
					<th width="20%" class="float-middle">Amount</th>
					<th width="15%"></th>
				  </tr>
				</thead>
				<tbody>
				  <tr class="bg-white">
					<td scope="row">VPI220585</td>
					<td>5 Mar 2022</td>
					<td>PT MITRA PRODIN</td>
					<td>MSC</td>
					<td><p class="text-right">1,500,000 IDR</p></td>
					<td>
					  <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
					  <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
					  <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
					</td>
				  </tr>
				  <tr class="bg-white">
					<td scope="row">VPI220489</td>
					<td>4 Mar 2022</td>
					<td>PT. GLOBAL ABADI JAYA</td>
					<td>MSC</td>
					<td><p class="text-right">2,770,000 IDR</p></td>
					<td>
					  <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
					  <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
					  <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
					</td>
				  </tr>
				  <tr class="bg-white">
					<td scope="row">VPI220789</td>
					<td>3 Mar 2022</td>
					<td>PT. CAHAYA TERANG</td>
					<td>ACH</td>
					<td><p class="text-right">800,000 IDR</p></td>
					<td>
						<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
						<span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
						<span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
					</td>
				  </tr>
				</tbody>
			  </table>
			</div><br>
			<div class="text-right"><a class="btn btn-dark" onclick="showModalInv()" data-toggle="modal" data-target="#createinvidtmodal">Create Cost Voucher</a></div>
			</td>
		  </tr>

		  <tr class="bg-light-red">
			<td scope="row">IDT004682</td>
			<td>2 Mar 2022</td>
			<td>SL FRAZER ENTERPRISES PTY LTD.</td>
			<td><p class="text-right">720,000 IDR</p></td>
			<td class="text-right"><a class="btn btn-clear btn-xs">View Invoice</a></td>
			<td><a class="btn btn-clear btn-xs">View Cost</a></td>
			<td>
			   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
			   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
			   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
			</td>
		  </tr>
		  <tr class="bg-light-red">
			<td scope="row">IDT004687</td>
			<td>1 Mar 2022</td>
			<td>PLATINUM RP PTY LTD.</td>
			<td><p class="text-right">16,800,000 IDR</p></td>
			<td class="text-right"><a class="btn btn-clear btn-xs">View Invoice</a></td>
			<td><a class="btn btn-clear btn-xs">View Cost</a></td>
			<td>
			   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
			   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
			   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
			</td>
		  </tr>
		</tbody>
	  </table>
	</div>
				
	<hr>
	<div class="container"><a class="btn btn-dark">Create Invoice</a></div><br>-->