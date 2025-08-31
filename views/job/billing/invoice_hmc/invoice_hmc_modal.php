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

// Input Customer dr Job Party
$job_party = JobParty::find()->where(['id_job' => $_GET['id'],'is_active' => 1])->one();

if(isset($job_party)){
	$data_customer = Customer::find()->where(['customer_id' => $job_party->customer, 'is_active'=>1])->one();
	$data_customer_alias = CustomerAlias::find()->where(['customer_alias_id' => $job_party->customer_alias, 'is_active'=>1])->one();
	
	$nama_customer = $data_customer->customer_companyname;
	$id_customer = $data_customer->customer_id;
	$customer_alias = isset($data_customer_alias->customer_name) ? $data_customer_alias->customer_name : '';
	$id_customer_alias = isset($data_customer_alias->customer_alias_id) ? $data_customer_alias->customer_alias_id : '';
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

if(!empty($customer)){
	$array_to2 = array();
	
	foreach($customer as $c){
		$array_to2[] = [
			'customer_id' => $c->customer_id,
			'customer_companyname' => $c->customer_companyname,
		];
	}
}

date_default_timezone_set('Asia/Jakarta');
?>

<div id="modal-inv-hmc-create">
<?php $form = ActiveForm::begin(['id' => 'form_invoice_hmc', 'action' => Url::base().'/job/save-invoice-hmc']); ?>
<input type="hidden" value="<?= $_GET['id']?>" name="MasterNewJobinvoice[inv_job_id]">
<input type="hidden" id="invoice_id_hmc" value="" name="MasterNewJobinvoice[inv_id]">

	<?php
		Modal::begin([
			'title' => 'Create Invoice HMC',
			'id' => 'modal_invoice_hmc',
			'size' => 'modal-xl',
			'options' => [
				'tabindex' => false,
			],
		]);
	?>
		<div id="content">
			<div class="row mb-4">
				<div class="col-12">
					<button type="button" class="btn btn-dark" onclick="showShort()">Short</button>
					<button type="button" class="btn btn-dark" onclick="showBreakdown()">Breakdown</button>
					
					<input type="hidden" class="form-control" id="inv_hmc_type" value="3" name="MasterNewJobinvoice[inv_type]" required>
				</div>
			</div>
		
			<div class="row form-group">
				<div class="col-1">
					<label class="fw-normal">Date</label>
				</div>
				<div class="col-3">
					<input type="date" class="form-control" id="date_invoice_hmc" value="<?= date('Y-m-d') ?>" name="MasterNewJobinvoice[inv_date]" required>
				</div>
				
				<div class="col-1 offset-2 text-right">
					<label class="fw-normal">Due Date</label>
				</div>
				<div class="col-3">
					<input type="date" class="form-control" id="due_date_invoice_hmc" value="<?= date('Y-m-d') ?>" name="MasterNewJobinvoice[inv_due_date]" required>
				</div>
			</div>
			
			<!-- Customer -->
			<div class="row">
				<div class="col-6">
					<div class="row">
						<div class="col-2">
							<label class="fw-normal">Customer</label>
						</div>
						<div class="col-10">
							<div class="form-group">
								<!--<input type="text" class="form-control" id="nama_inv_hmc_cust1" value="<?= $nama_customer ?>" readonly>
								<input type="hidden" class="form-control" id="inv_hmc_cust1" name="MasterNewJobinvoice[inv_customer]" value="<?= $id_customer ?>">-->
							
								<select class="form-select form-select-lg" id="inv_hmc_from1" name="MasterNewJobinvoice[inv_customer]" required>
									<option></option>
									<?php
										if(isset($array_to2)){
											foreach($array_to2 as $row){
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
								<!--<input type="text" class="form-control" id="nama_inv_hmc_cust2" value="<?= $customer_alias ?>" readonly>
								<input type="hidden" class="form-control" id="inv_hmc_cust2" name="MasterNewJobinvoice[inv_customer2]" value="<?= $id_customer_alias ?>">-->
								
								<select class="form-select form-select-lg" id="inv_hmc_from2" name="MasterNewJobinvoice[inv_customer2]" required>
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
								<textarea class="form-control" id="inv_hmc_from3" rows="5" name="MasterNewJobinvoice[inv_customer3]" readonly><?php //if(isset($job_party->customer_address)){ echo str_replace("\\n","\n",$job_party->customer_address); }?></textarea>
							</div>
						</div>
					</div>
				</div>
				
				<!-- To -->
				<div class="col-6">
					<div class="row">
						<div class="col-2">
							<label class="fw-normal">To</label>
						</div>
						<div class="col-10">
							<div class="form-group">
								<select class="form-select form-select-lg" id="inv_hmc_to1" name="MasterNewJobinvoice[inv_to]" required>
									<option></option>
									<?php
										// customer mengikuti document-party
										/*if(isset($array_to)){
											foreach($array_to as $row){
												$selected = '';
												
												echo "<option value='".$row['customer_id']."' ".$selected.">".
													$row['customer_companyname'].
												"</option>";
											}
										}*/
										
										// all customer
										if(isset($array_to2)){
											foreach($array_to2 as $row){
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
								<select class="form-select form-select-lg" id="inv_hmc_to2" name="MasterNewJobinvoice[inv_to2]" required>
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
								<textarea class="form-control" id="inv_hmc_to3" rows="5" name="MasterNewJobinvoice[inv_to3]" readonly></textarea>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-6 mb-4">
					<div class="row">
						<div class="col-2">
							<label class="fw-normal">Notes</label>
						</div>
						<div class="col-10">
							<textarea class="form-control" id="additional_notes_hmc" rows="4" placeholder="Additional Notes" name="MasterNewJobinvoice[additional_notes]"></textarea>
						</div>
					</div>
				</div>
				
				<div class="col-6 mb-4">
					<div class="row">
						<div class="col-2">Currency</div>
						<div class="col-10">
							<select class="form-select form-select-lg" id="currency" name="MasterNewJobinvoice[inv_currency]" required>
								<option value="USD">USD</option>
								<option value="IDR">IDR</option>
							</select>
						</div>
					</div>
				</div>
				
				<br>
				<!-- Table Detail -->
				<div class="row" id="div_hmc_short">
					<div class="col-12">
						<table class="table" id="table_invoice_hmc">
							<thead>
								<tr>
									<td width="5%"></td>
									<td width="15%">Desc. of Charges</td>
									<td width="25%">Detail</td>
									<td width="13%">Basis</td>
									<td width="7%">Jumlah</td>
									<td width="7%">Satuan</td>
									<td width="14%">Rate</td>
									<td width="9%">Amount</td>
									<td width="5%">Curr</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="text-center"></td>
									<td>
										<select class="form-select form-select-lg" id="pos_hmc-1" name="MasterNewJobinvoiceDetail[detail][1][invd_pos]" required>
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
										<input type="text" class="form-control" id="detail_hmc-1" value="" name="MasterNewJobinvoiceDetail[detail][1][invd_detail]">
									</td>
									<td>
										<div class="row">
											<div class="col-6 pr-1">
												<input type="text" class="form-control basis" id="basis_hmc-1" value="" name="MasterNewJobinvoiceDetail[detail][1][invd_basis1_total]" onkeyup="changeInputInvoiceHmc(this.id)" required>
											</div>
											<div class="col-6 pl-1">
												<select class="form-select form-select-lg" id="basispack_hmc-1" name="MasterNewJobinvoiceDetail[detail][1][invd_basis1_type]" required>
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
										<input type="text" class="form-control jumlah" id="jumlah_hmc-1" value="" name="MasterNewJobinvoiceDetail[detail][1][invd_basis2_total]" onkeyup="changeInputInvoiceHmc(this.id)" required>
									</td>
									<td>
										<select class="form-select form-select-lg" id="jumlahpack_hmc-1" name="MasterNewJobinvoiceDetail[detail][1][invd_basis2_type]" required>
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
												<input type="hidden" class="form-control tarif" id="tarif_hmc-1" value="" name="MasterNewJobinvoiceDetail[detail][1][invd_rate]">
												<input type="text" class="form-control tarif1" id="tarif1_hmc-1" value="" onkeyup="changeInputInvoiceHmc(this.id)" required>
											</div>
											<div class="col-5 pl-1 pt-2">
												<input type="text" class="form-control tarif2" id="tarif2_hmc-1" style="height:25px" value="00" onkeyup="changeInputInvoiceHmc(this.id)">
											</div>	
										</div>
									</td>
									<!-- Subtotal -->
									<td class="text-right">
										<label class="fw-normal mb-0" id="label_subtotal_hmc-1">0.00</label>
										<input type="hidden" class="form-control subtotal_hmc" id="subtotal_hmc-1" value="" name="MasterNewJobinvoiceDetail[detail][1][invd_amount]">
									</td>
									<td>USD</td>
								</tr>
								
								<tr>
									<td colspan="2">
										<button type="button" class="btn btn-success" onclick="addrowhmc()">
											<span class="fa fa-plus align-middle"></span> Tambah
										</button>
									</td>
									<td colspan="8"></td>
								</tr>
								<!-- Grandtotal -->
								<tr>
									<td colspan="6"></td>
									<td>TOTAL</td>
									<td class="text-right">
										<p id="label_grandtotal_hmc">0.00</p>
										<input type="hidden" class="form-control grandtotal" id="grandtotal_hmc" value="" name="MasterNewJobinvoice[inv_grandtotal]">
									</td>
									<td>USD</td>
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
	
	$('#inv_hmc_from1').change(function(){
		var key = $('#inv_hmc_from1').val();
		var id = 'inv_hmc_from';
		getpartyInvoice(key, id);
	});
	
	//Get customer alias address
	$('#inv_hmc_from2').change(function(){
		var key = $('#inv_hmc_from2').val();
		var id = 'inv_hmc_from';
		getpartyaliasInvoice(key, id);
	});
	
	$('#inv_hmc_to1').change(function(){
		var key = $('#inv_hmc_to1').val();
		var id = 'inv_hmc_to';
		getpartyInvoice(key, id);
	});
	
	//Get customer alias address
	$('#inv_hmc_to2').change(function(){
		var key = $('#inv_hmc_to2').val();
		var id = 'inv_hmc_to';
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
			if(res.data){
				$('#'+id+'3').val(res.data['customer_alias']);
			}
		});
	}
	
	function addrowhmcsell(){
		id = $('#table_invoice_hmc_breakdown_sell tbody tr').length-1;
		
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
				item += '<select class="form-select form-select-lg" id="pos_hmc-'+i+'" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_pos]" required>';
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
				item += '<input type="text" class="form-control" id="detail_hmc-'+i+'" value="" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_detail]">';
			item += '</td>';
			item += '<td>';
				item += '<div class="row">';
					item += '<div class="col-6 pr-1">';
						item += '<input type="text" class="form-control basis" id="basis_hmc-'+i+'" value="" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_basis1_total]" onkeyup="changeInputInvoiceHmc(this.id)" required>';
					item += '</div>';
					item += '<div class="col-6 pl-1">';
						item += '<select class="form-select form-select-lg" id="basispack_hmc-'+i+'" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_basis1_type]" required>';
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
				item += '<input type="text" class="form-control jumlah" id="jumlah_hmc-'+i+'" value="" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_basis2_total]" onkeyup="changeInputInvoiceHmc(this.id)" required>';
			item += '</td>';
			item += '<td>';
				item += '<select class="form-select form-select-lg" id="jumlahpack_hmc-'+i+'" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_basis2_type]" required>';
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
						item += '<input type="hidden" class="form-control tarif" id="tarif_hmc-'+i+'" value="" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_rate]">';
						item += '<input type="text" class="form-control tarif1" id="tarif1_hmc-'+i+'" value="" onkeyup="changeInputInvoiceHmc(this.id)" required>';
					item += '</div>';
					item += '<div class="col-5 pl-1 pt-2">';
						item += '<input type="text" class="form-control tarif2" id="tarif2_hmc-'+i+'" style="height:25px" value="00" onkeyup="changeInputInvoiceHmc(this.id)">';
					item += '</div>';	
				item += '</div>';
			item += '</td>';
			
			item += '<td class="text-right">';
				item += '<label class="fw-normal mb-0" id="label_subtotal_hmc-'+i+'">0.00</label>';
				item += '<input type="hidden" class="form-control subtotal_hmc" id="subtotal_hmc-'+i+'" value="" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_amount]">';
			item += '</td>';
			item += '<td>USD</td>';
			
		item += '</tr>';
		
		tr = $('#table_invoice_hmc_breakdown_sell tbody tr').length-2;
	
		$('#table_invoice_hmc_breakdown_sell tbody tr:eq('+tr+')').after(item);
		
		// Gabungan Tarif
		$('.tarif1, .tarif2').on('keyup', function(){
			$('.tarif').each(function(i){
				input_tarif1 = Number($('.tarif1').eq(i).val());
				input_tarif2 = $('.tarif2').eq(i).val();
				
				if(input_tarif1 == ''){
					input_tarif1 = 0;
				}
				if(input_tarif2 == ''){
					input_tarif2 = '00';
				}
				
				tarif = input_tarif1+'.'+input_tarif2;
				
				$('.tarif').eq(i).val(tarif);
			});
		});
	}
	
	function addrowhmccost(){
		id = $('#table_invoice_hmc_breakdown_cost tbody tr').length-1;
		
		if(id){
            i = id+1;
        }else{
            i = 1;
		}
		console.log(id);
		
		item = '';
		item += '<tr>';
			item += '<td class="text-center">';
				item += '<button class="btn btn-xs btn-danger" style="padding: 0px 5px" onclick="delrow($(this))">';
					item += '<span class="fa fa-trash align-middle"></span>';
				item += '</button>';
			item += '</td>';
			item += '<td>';
				item += '<select class="form-select form-select-lg" id="pos_hmc_cost-'+i+'" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_pos]" required>';
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
				item += '<input type="text" class="form-control" id="detail_hmc_cost-'+i+'" value="" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_detail]">';
			item += '</td>';
			item += '<td>';
				item += '<div class="row">';
					item += '<div class="col-6 pr-1">';
						item += '<input type="text" class="form-control basis" id="basis_hmc_cost-'+i+'" value="" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_basis1_total]" onkeyup="changeInputInvoiceHmc(this.id)" required>';
					item += '</div>';
					item += '<div class="col-6 pl-1">';
						item += '<select class="form-select form-select-lg" id="basispack_hmc_cost-'+i+'" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_basis1_type]" required>';
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
				item += '<input type="text" class="form-control jumlah" id="jumlah_hmc_cost-'+i+'" value="" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_basis2_total]" onkeyup="changeInputInvoiceHmc(this.id)" required>';
			item += '</td>';
			item += '<td>';
				item += '<select class="form-select form-select-lg" id="jumlahpack_hmc_cost-'+i+'" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_basis2_type]" required>';
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
						item += '<input type="hidden" class="form-control tarif" id="tarif_hmc_cost-'+i+'" value="" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_rate]">';
						item += '<input type="text" class="form-control tarif1" id="tarif1_hmc_cost-'+i+'" value="" onkeyup="changeInputInvoiceHmc(this.id)" required>';
					item += '</div>';
					item += '<div class="col-5 pl-1 pt-2">';
						item += '<input type="text" class="form-control tarif2" id="tarif2_hmc_cost-'+i+'" style="height:25px" value="00" onkeyup="changeInputInvoiceHmc(this.id)">';
					item += '</div>';	
				item += '</div>';
			item += '</td>';
			
			item += '<td class="text-right">';
				item += '<label class="fw-normal mb-0" id="label_subtotal_hmc_cost-'+i+'">0.00</label>';
				item += '<input type="hidden" class="form-control subtotal_hmc" id="subtotal_hmc_cost-'+i+'" value="" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_amount]">';
			item += '</td>';
			item += '<td>USD</td>';
			
		item += '</tr>';
		
		tr = $('#table_invoice_hmc_breakdown_cost tbody tr').length-2;
	
		$('#table_invoice_hmc_breakdown_cost tbody tr:eq('+tr+')').after(item);
		
		// Gabungan Tarif
		$('.tarif1, .tarif2').on('keyup', function(){
			$('.tarif').each(function(i){
				input_tarif1 = Number($('.tarif1').eq(i).val());
				input_tarif2 = $('.tarif2').eq(i).val();
				
				if(input_tarif1 == ''){
					input_tarif1 = 0;
				}
				if(input_tarif2 == ''){
					input_tarif2 = '00';
				}
				
				tarif = input_tarif1+'.'+input_tarif2;
				
				$('.tarif').eq(i).val(tarif);
			});
		});
	}
	
	function addrowhmc(){
		id = $('#table_invoice_hmc tbody tr').length-2;
		
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
				item += '<select class="form-select form-select-lg" id="pos_hmc-'+i+'" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_pos]" required>';
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
				item += '<input type="text" class="form-control" id="detail_hmc-'+i+'" value="" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_detail]">';
			item += '</td>';
			item += '<td>';
				item += '<div class="row">';
					item += '<div class="col-6 pr-1">';
						item += '<input type="text" class="form-control basis" id="basis_hmc-'+i+'" value="" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_basis1_total]" onkeyup="changeInputInvoiceHmc(this.id)" required>';
					item += '</div>';
					item += '<div class="col-6 pl-1">';
						item += '<select class="form-select form-select-lg" id="basispack_hmc-'+i+'" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_basis1_type]" required>';
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
				item += '<input type="text" class="form-control jumlah" id="jumlah_hmc-'+i+'" value="" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_basis2_total]" onkeyup="changeInputInvoiceHmc(this.id)" required>';
			item += '</td>';
			item += '<td>';
				item += '<select class="form-select form-select-lg" id="jumlahpack_hmc-'+i+'" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_basis2_type]" required>';
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
						item += '<input type="hidden" class="form-control tarif" id="tarif_hmc-'+i+'" value="" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_rate]">';
						item += '<input type="text" class="form-control tarif1" id="tarif1_hmc-'+i+'" value="" onkeyup="changeInputInvoiceHmc(this.id)" required>';
					item += '</div>';
					item += '<div class="col-5 pl-1 pt-2">';
						item += '<input type="text" class="form-control tarif2" id="tarif2_hmc-'+i+'" style="height:25px" value="00" onkeyup="changeInputInvoiceHmc(this.id)">';
					item += '</div>';	
				item += '</div>';
			item += '</td>';
			
			item += '<td class="text-right">';
				item += '<label class="fw-normal mb-0" id="label_subtotal_hmc-'+i+'">0.00</label>';
				item += '<input type="hidden" class="form-control subtotal_hmc" id="subtotal_hmc-'+i+'" value="" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_amount]">';
			item += '</td>';
			item += '<td>USD</td>';
			
		item += '</tr>';
		
		tr = $('#table_invoice_hmc tbody tr').length-3;
	
		$('#table_invoice_hmc tbody tr:eq('+tr+')').after(item);
		
		// Gabungan Tarif
		$('.tarif1, .tarif2').on('keyup', function(){
			$('.tarif').each(function(i){
				input_tarif1 = Number($('.tarif1').eq(i).val());
				input_tarif2 = $('.tarif2').eq(i).val();
				
				if(input_tarif1 == ''){
					input_tarif1 = 0;
				}
				if(input_tarif2 == ''){
					input_tarif2 = '00';
				}
				
				tarif = input_tarif1+'.'+input_tarif2;
				
				$('.tarif').eq(i).val(tarif);
			});
		});
	}
	
	function delrow(el){
		if(confirm('Apakah anda yakin ingin menghapus data ini?')){
			el.parent().parent().remove();
		
			getTotalHmc();
		}
	}
	
	function changeInputInvoiceHmc(id){
		console.log(id);
		
		idx = id.split('-')[1];
		
		basis 	= $('#basis_hmc-'+idx).val();
		jumlah 	= $('#jumlah_hmc-'+idx).val();
		tarif1 	= $('#tarif1_hmc-'+idx).val();
		tarif2 	= $('#tarif2_hmc-'+idx).val();
		// ppntype	= $('#ppntype_hmc-'+idx+' option:selected').html();
		
		tarif = parseFloat(tarif1+'.'+tarif2);
		
		// ppn = parseFloat(ppntype.split('-')[1].replace('%',''));
		ppn = 0;
		
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
		
		if(ppn !== 0){
			totalppn = Math.floor(parseFloat(subtotal) * parseFloat(ppn) / 100);
		}else{
			totalppn = 0;
		}
		
		$('#label_subtotal_hmc-'+idx).html(addSeparator(subtotal.toFixed(2)));
		$('#subtotal_hmc-'+idx).val(subtotal);
		$('#ppn_hmc-'+idx).val(totalppn);
		
		getTotalHmc();
	}
	
	// Gabungan Tarif
	$('.tarif1, .tarif2').on('keyup', function(){
		$('.tarif').each(function(i){
			input_tarif1 = Number($('.tarif1').eq(i).val());
			input_tarif2 = $('.tarif2').eq(i).val();
			
			if(input_tarif1 == ''){
				input_tarif1 = 0;
			}
			if(input_tarif2 == ''){
				input_tarif2 = '00';
			}
			
			tarif = input_tarif1+'.'+input_tarif2;
			
			$('.tarif').eq(i).val(tarif);
		});
	});
	
	function getTotalHmc(){
		total = 0;
		total_ppn = 0;
		
        $('.subtotal_hmc').each(function(index) {
			if($(this).val() == ''){
				subtotal = 0;
			}else{
				subtotal = $(this).val();
			}
			
			// ppntype	= $('.ppntype:eq('+index+') option:selected').html();
			// ppn = parseFloat(ppntype.split('-')[1].replace('%',''));
			
			total += parseFloat(subtotal);
			// total_ppn += Math.floor(parseFloat(subtotal) * parseFloat(ppn) / 100);
        });
		
		grandtotal = total + total_ppn;
		
		$('#label_total_hmc').html(addSeparator(total.toFixed(2)));
		$('#total_hmc').val(total);
		
		$('#label_ppn_hmc').html(addSeparator(total_ppn.toFixed(2)));
		$('#totalppn_hmc').val(total_ppn);

		$('#label_grandtotal_hmc').html(addSeparator(grandtotal.toFixed(2)));
		$('#grandtotal_hmc').val(grandtotal);
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
