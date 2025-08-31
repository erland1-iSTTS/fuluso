<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use richardfan\widget\JSRegister;
use yii\bootstrap4\Modal;

use app\models\PosV8;
use app\models\Packages;
use app\models\Currency;
use app\models\MasterPpn;
use app\models\Config;
use app\models\PpnDetail;

use app\models\MasterHakAkses;

$akses_hmc = MasterHakAkses::find()->where(['id_role' => Yii::$app->user->identity->id_role, 'id_menu' => 10])->one();

$pos 		= PosV8::find()->where(['is_active'=>1])->orderby(['pos_name'=>SORT_ASC])->all();
$packages 	= Packages::find()->orderby(['packages_name'=>SORT_ASC])->all();
$currency 	= Currency::find()->orderby(['currency_id'=>SORT_ASC])->all();
$ppn		= PpnDetail::find()->where(['>=' , 'validity' , date('Y-m-d')])->one();
$defaultppn	= PpnDetail::find()->where(['>=' , 'validity' , date('Y-m-d')])->one();
$config		= Config::find()->where(['name'=>'HMC'])->one();

echo "<script>console.log('".$ppn->name."');</script>";

date_default_timezone_set('Asia/Jakarta');
?>

<style>
	.btn-menu{
		text-decoration: none;
		border: none;
		text-align: left;
		color: #337ab7;
	}
	
	.btn-menu:hover{
		color: #0a58ca;
	}
	
	.btn-menu:focus{
		box-shadow: none;
	}
	
	h2{
		font-size:30px !important;
	}

	.gap{
		padding: 0px 8px 0px 0px;
	}

	.gap:hover{
		text-decoration:none !important;
	}
</style>

<div class="accordion" id="job_billing">
	<div class="card">
		<div class="card-header" id="headingbilling0">
			<div class="row pl-2 pr-2">
				<h2 class="m-0" style="width:86%;background-color:#eee;" data-toggle="collapse" data-target="#collapsebilling0">
					<button class="btn btn-menu" type="button" data-toggle="collapse" data-target="#collapsebilling0">
						Invoice IDR
					</button>
				</h2>
				<div class="pr-3" style="width:14%;background-color:#eee;">
					<button type="button" class="btn btn-dark float-right w-100" id="btn_create_invoice_idt" onclick="createInvoiceIdt()">Create Invoice IDR</button>
				</div>
				<?= $this->render('invoice_idr/invoice_idr_modal') ?>
			</div>
		</div>
		
		<div id="collapsebilling0" class="collapse" data-parent="#job_billing">
			<div class="card-body p-3">
				<?= $this->render('invoice_idr/invoice_idr_index') ?>
			</div>
		</div>
	</div>
	
	<div class="card">
		<div class="card-header" id="headingbilling1">
			<div class="row pl-2 pr-2">
				<h2 class="m-0" style="width:86%;background-color:#eee;" data-toggle="collapse" data-target="#collapsebilling1">
					<button class="btn btn-menu" type="button" data-toggle="collapse" data-target="#collapsebilling1">
						Cost IDR
					</button>
				</h2>
				<div class="pr-3" style="width:14%;background-color:#eee;">
					<button type="button" class="btn btn-dark float-right w-100" id="btn_create_cost_idt" onclick="createCostIdt()">Create Cost IDR</button>
				</div>
				<?= $this->render('cost_idr/cost_idr_modal') ?>
			</div>
		</div>
		
		<div id="collapsebilling1" class="collapse" data-parent="#job_billing">
			<div class="card-body p-3">
				<?= $this->render('cost_idr/cost_idr_index') ?>
			</div>
		</div>
	</div>
	
	<?php
		$akses_hmc = true;
		if($akses_hmc){ 
		// if(isset($akses_hmc)){ 
	?>
	
	<div class="card">
		<div class="card-header" id="headingbilling2">
			<div class="row pl-2 pr-2">
				<h2 class="m-0" style="width:86%;background-color:#eee;" data-toggle="collapse" data-target="#collapsebilling2">
					<button class="btn btn-menu" type="button" data-toggle="collapse" data-target="#collapsebilling2">
						Invoice HMC
					</button>
				</h2>
				<div class="pr-3" style="width:14%;background-color:#eee;">
					<button type="button" class="btn btn-dark float-right w-100" id="btn_create_invoice_hmc" onclick="createInvoiceHmc()">Create Invoice HMC</button>
				</div>
				<?= $this->render('invoice_hmc/invoice_hmc_modal') ?>
				<?= $this->render('invoice_hmc/invoice_hmc_modal2') ?>
			</div>
		</div>
		
		<div id="collapsebilling2" class="collapse" data-parent="#job_billing">
			<div class="card-body p-3">
				<?= $this->render('invoice_hmc/invoice_hmc_index') ?>
			</div>
		</div>
	</div>
	
	<div class="card">
		<div class="card-header" id="headingbilling3">
			<div class="row pl-2 pr-2">
				<h2 class="m-0" style="width:86%;background-color:#eee;" data-toggle="collapse" data-target="#collapsebilling3">
					<button class="btn btn-menu" type="button" data-toggle="collapse" data-target="#collapsebilling3">
						Cost HMC
					</button>
				</h2>
				<div class="pr-3" style="width:14%;background-color:#eee;">
					<button type="button" class="btn btn-dark float-right w-100" id="btn_create_cost_hmc" onclick="createCostHmc()">Create Cost HMC</button>
				</div>
				<?= $this->render('cost_hmc/cost_hmc_modal') ?>
			</div>
		</div>
		
		<div id="collapsebilling3" class="collapse" data-parent="#job_billing">
			<div class="card-body p-3">
				<?= $this->render('cost_hmc/cost_hmc_index') ?>
			</div>
		</div>
	</div>
	
	<?php } ?>
</div>

<script>
	$(document).ready(function(){
	});
	
	//Invoice
	function createInvoiceIdt(){
		//Reset modal
		//$('#table_invoice_idt tbody tr input').val('');
		$('#table_invoice_idt tbody tr select').prop('selectedIndex',0);
		$('#table_invoice_idt tbody tr label').html('0.00');
		$('#ppntype-1').val('<?= isset($defaultppn) ? $defaultppn->id : 1 ?>').trigger('change');	// Default PPN saat ini yg 1.1%
		$('#inv_idt_to1').prop('selectedIndex',0);
		$('#inv_idt_to2').prop('selectedIndex',0);
		$('#inv_idt_to3').val('');
		$('#invoice_id').val('');
		
		total_tr = $('#table_invoice_idt tbody tr').length;
		if(total_tr > 3){
			//Remove table tbody selain index 0, dan index 2 yg terakhir
			$('#table_invoice_idt tbody tr').not(':nth-child(1), :nth-child('+(total_tr)+'), :nth-child('+(total_tr-1)+')').remove();
		}
		
		$('#modal_invoice_idr').modal({backdrop: 'static', keyboard: false});
		$('#modal_invoice_idr').show();
	}
	
	function editInvoiceIdt(id){
		$('#modal_invoice_idr').modal({backdrop: 'static', keyboard: false});
		$('#modal_invoice_idr').show();
		
		total_tr = $('#table_invoice_idt tbody tr').length;
		if(total_tr > 3){
			//Remove table tbody selain index 0, dan index 2 yg terakhir
			$('#table_invoice_idt tbody tr').not(':nth-child(1), :nth-child('+(total_tr)+'), :nth-child('+(total_tr-1)+')').remove();
		}
		
		$.ajax({
			url: '<?=Url::base().'/job/get-invoice-idt'?>',
			data: {'id': id},
			dataType: 'json',
			method: 'POST',
            async: 'false'
		}).done(function(result){
			console.log(result);
			
			invoice = result.invoice[0];
			customer = result.customer;
			customer_alias = result.customer_alias;
			detail = result.invoice_detail;
			
			if(result.invoice.length > 0){
				$('#date_invoice_idt').val(invoice['inv_date']);
				$('#due_date_invoice_idt').val(invoice['inv_due_date']);
				$('#invoice_id').val(invoice['inv_id']);
				
				//From
				$('#nama_inv_idt_cust1').val(customer['customer_companyname']);
				$('#inv_idt_cust1').val(customer['customer_id']);
				
				$('#nama_inv_idt_cust2').val(customer_alias['customer_name']);
				$('#inv_idt_cust2').val(customer_alias['customer_alias_id']);
				
				$('#inv_idt_cust3').val(invoice['inv_customer3']);
				
				//To
				$('#inv_idt_to1').val(invoice['inv_to']).trigger('change');
				
				
				$('#additional_notes').val(invoice['additional_notes']);
				
				var key = $('#inv_idt_to1').val();
				var id = 'inv_idt_to';
				getpartyInvoice(key, id);
				
				setTimeout(function(){
					$('#inv_idt_to2').val(invoice['inv_to2']).trigger('change');
					$('#inv_idt_to3').val(invoice['inv_to3']);
				}, 800);
				
				//Detail
				if(detail.length > 0){
					i = 1;
					item = '';
					
					for(const data of detail)
					{
						if(i !== 1){
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
									item += '<input type="text" class="form-control" id="detail-'+i+'" value="'+data['invd_detail']+'" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_detail]">';
								item += '</td>';
								item += '<td>';
									item += '<div class="row">';
										item += '<div class="col-6 pr-1">';
											item += '<input type="text" class="form-control basis" id="basis-'+i+'" value="'+data['invd_basis1_total']+'" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_basis1_total]" onkeyup="changeInputInvoice(this.id)" required>';
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
									item += '<input type="text" class="form-control jumlah" id="jumlah-'+i+'" value="'+data['invd_basis2_total']+'" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_basis2_total]" onkeyup="changeInputInvoice(this.id)" required>';
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
											tarif_all = data['invd_rate'];
											tarif_1 = data['invd_rate'].split('.')[0];
											tarif_2 = data['invd_rate'].split('.')[1];
										
											item += '<input type="hidden" class="form-control tarif" id="tarif-'+i+'" value="'+tarif_all+'" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_rate]">';
											item += '<input type="text" class="form-control tarif1" id="tarif1-'+i+'" value="'+tarif_1+'" onkeyup="changeInputInvoice(this.id)" required>';
										item += '</div>';
										item += '<div class="col-5 pl-1 pt-2">';
											item += '<input type="text" class="form-control tarif2" id="tarif2-'+i+'" style="height:25px" value="'+tarif_2+'" onkeyup="changeInputInvoice(this.id)">';
										item += '</div>';	
									item += '</div>';
								item += '</td>';
								
								item += '<td class="text-right">';
									item += '<label class="fw-normal mb-0" id="label_subtotal-'+i+'">0.00</label>';
									item += '<input type="hidden" class="form-control subtotal" id="subtotal-'+i+'" value="'+data['invd_amount']+'" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_amount]">';
								item += '</td>';
								item += '<td>IDR</td>';
								
								item += '<td>';
									// item += '<select class="form-select form-select-lg ppntype" id="ppntype-'+i+'" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_id_ppn]" onchange="getTotal()" required>';
										item += "<label>" + "<?= $ppn->name ?>" + " - " + "<?= $ppn->amount ?>" + "</label>" +"<?php
											// foreach($ppn as $row){
											// 	//$name = explode('-', $row['name']);
											// 	$name_ppn = $row['name'].'-'.$row['amount'].'%';
												
											// 	// if($name[1] == '050'){
											// 	if($row['validity'] >= date('Y-m-d')){
											// 		$selected = 'selected';
											// 	}else{
											// 		$selected = '';
											// 	}
												
											// 	echo "<option value='".$row['id']."' ".$selected.">".
											// 		$name_ppn.
											// 	"</option>";
											// }
										?>";
									// item += '</select>';
									item += '<input type="hidden" class="form-control ppn" id="ppn-'+i+'" value="<?= $ppn->id ?>" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_ppn]">';
								item += '</td>';
							item += '</tr>';
						}
						i++;
					}
					
					$('#table_invoice_idt tbody tr:first-child').after(item);
					
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
					
					//Default value
					setTimeout(function(){
						var index = 1;
						$('#table_invoice_idt tbody tr').each(function(){
							
							if($('#pos-'+index).length == 1){
								$('#pos-'+index).val(result.invoice_detail[index-1]['invd_pos']).trigger('change');
								$('#detail-'+index).val(result.invoice_detail[index-1]['invd_detail']);
								$('#basis-'+index).val(result.invoice_detail[index-1]['invd_basis1_total']);
								$('#basispack-'+index).val(result.invoice_detail[index-1]['invd_basis1_type']).trigger('change');
								$('#jumlah-'+index).val(result.invoice_detail[index-1]['invd_basis2_total']);
								$('#jumlahpack-'+index).val(result.invoice_detail[index-1]['invd_basis2_type']).trigger('change');
								
								tarif_all = result.invoice_detail[index-1]['invd_rate'];
								tarif_1 = tarif_all.split('.')[0];
								tarif_2 = tarif_all.split('.')[1];
								
								basis = result.invoice_detail[index-1]['invd_basis1_total'];
								jumlah = result.invoice_detail[index-1]['invd_basis2_total'];
								
								subtotal = basis * jumlah * tarif_all;
								
								$('#tarif-'+index).val(tarif_all);
								$('#tarif1-'+index).val(tarif_1);
								$('#tarif2-'+index).val(tarif_2);
								
								$('#label_subtotal-'+index).html(addSeparator(subtotal.toFixed(2)));
								$('#subtotal-'+index).val(subtotal);
								
								$('#ppntype-'+index).val(result.invoice_detail[index-1]['invd_id_ppn']).trigger('change');
								$('#ppn-'+index).val(result.invoice_detail[index-1]['invd_ppn']);
							}
							index++;
						});
					}, 700);
					
					$('#inv_id').val(id);
				}
			}
		});
	}

	function deleteInvoiceIdt(id){
		let confirmed = confirm('Yakin ingin menghapus data ini?');
		
		if (confirmed){
			$.ajax({
				url: '<?=Url::base().'/job/delete-invoice-idt'?>',
				data: {'id': id},
				dataType: 'json',
				method: 'POST',
				async: 'false'
			}).done(function(res){
				location.reload();
			});
		}
	}

	function createInvoiceHmc(){
		$('#modal_invoice_hmc_bk').modal('hide');
		// $('#modal_invoice_hmc').hide();
		// $('#modal_invoice_hmc_bk').hide();
		
		//Reset modal
		$('#table_invoice_hmc tbody tr input').val('');
		$('#table_invoice_hmc tbody tr select').prop('selectedIndex',0);
		$('#table_invoice_hmc tbody tr label').html('0.00');
		// $('#ppntype-1').val(3).trigger('change');	// Default PPN saat ini yg 1.1%
		$('#inv_hmc_to1').prop('selectedIndex',0);
		$('#inv_hmc_to2').prop('selectedIndex',0);
		$('#inv_hmc_to3').val('');
		$('#invoice_id_hmc').val('');
		
		total_tr = $('#table_invoice_hmc tbody tr').length;
		if(total_tr > 3){
			//Remove table tbody selain index 0, dan index 2 yg terakhir
			$('#table_invoice_hmc tbody tr').not(':nth-child(1), :nth-child('+(total_tr)+'), :nth-child('+(total_tr-1)+')').remove();
		}
		
		setTimeout(function() { 
			$('#modal_invoice_hmc').modal({backdrop: 'static', keyboard: false});
			// $('#modal_invoice_hmc').modal('show');
			$('#modal_invoice_hmc').show();
		}, 500);
	}
	
	function createInvoiceHmcBk(){
		$('#modal_invoice_hmc').modal('hide');
		// $('#modal_invoice_hmc').hide();
		// $('#modal_invoice_hmc_bk').hide();
		
		//Reset modal
		$('#table_invoice_hmc_breakdown_sell tbody tr input').val('');
		$('#table_invoice_hmc_breakdown_sell tbody tr select').prop('selectedIndex',0);
		$('#table_invoice_hmc_breakdown_sell tbody tr label').html('0.00');
		
		$('#table_invoice_hmc_breakdown_cost tbody tr input').val('');
		$('#table_invoice_hmc_breakdown_cost tbody tr select').prop('selectedIndex',0);
		$('#table_invoice_hmc_breakdown_cost tbody tr label').html('0.00');
		
		// $('#ppntype-1').val(3).trigger('change');	// Default PPN saat ini yg 1.1%
		$('#inv_hmc_bk_to1').prop('selectedIndex',0);
		$('#inv_hmc_bk_to2').prop('selectedIndex',0);
		$('#inv_hmc_bk_to3').val('');
		$('#invoice_id_hmc_bk').val('');
		
		total_tr = $('#table_invoice_hmc_bk tbody tr').length;
		if(total_tr > 3){
			//Remove table tbody selain index 0, dan index 2 yg terakhir
			$('#table_invoice_hmc_bk tbody tr').not(':nth-child(1), :nth-child('+(total_tr)+'), :nth-child('+(total_tr-1)+')').remove();
		}
		
		setTimeout(function() { 
			$('#modal_invoice_hmc_bk').modal({backdrop: 'static', keyboard: false});
			// $('#modal_invoice_hmc_bk').modal('show');
			$('#modal_invoice_hmc_bk').show();
		}, 500);
	}
	
	function deleteInvoiceHmc(id){
		let confirmed = confirm('Yakin ingin menghapus data ini?');
		
		if (confirmed){
			$.ajax({
				url: '<?=Url::base().'/job/delete-invoice-hmc'?>',
				data: {'id': id},
				dataType: 'json',
				method: 'POST',
				async: 'false'
			}).done(function(res){
				location.reload();
			});
		}
	}

	/*function editInvoiceHmc(id){
		$('#modal_invoice_idr').modal({backdrop: 'static', keyboard: false});
		$('#modal_invoice_idr').show();
		
		total_tr = $('#table_invoice_idt tbody tr').length;
		if(total_tr > 3){
			//Remove table tbody selain index 0, dan index 2 yg terakhir
			$('#table_invoice_idt tbody tr').not(':nth-child(1), :nth-child('+(total_tr)+'), :nth-child('+(total_tr-1)+')').remove();
		}
		
		$.ajax({
			url: '<?=Url::base().'/job/get-invoice-idt'?>',
			data: {'id': id},
			dataType: 'json',
			method: 'POST',
            async: 'false'
		}).done(function(result){
			console.log(result);
			
			invoice = result.invoice[0];
			customer = result.customer;
			customer_alias = result.customer_alias;
			detail = result.invoice_detail;
			
			if(result.invoice.length > 0){
				$('#date_invoice_idt').val(invoice['inv_date']);
				$('#due_date_invoice_idt').val(invoice['inv_due_date']);
				$('#invoice_id').val(invoice['inv_id']);
				
				//From
				$('#nama_inv_idt_cust1').val(customer['customer_companyname']);
				$('#inv_idt_cust1').val(customer['customer_id']);
				
				$('#nama_inv_idt_cust2').val(customer_alias['customer_name']);
				$('#inv_idt_cust2').val(customer_alias['customer_alias_id']);
				
				$('#inv_idt_cust3').val(invoice['inv_customer3']);
				
				//To
				$('#inv_idt_to1').val(invoice['inv_to']).trigger('change');
				
				
				$('#additional_notes').val(invoice['additional_notes']);
				
				var key = $('#inv_idt_to1').val();
				var id = 'inv_idt_to';
				getpartyInvoice(key, id);
				
				setTimeout(function(){
					$('#inv_idt_to2').val(invoice['inv_to2']).trigger('change');
					$('#inv_idt_to3').val(invoice['inv_to3']);
				}, 800);
				
				//Detail
				if(detail.length > 0){
					i = 1;
					item = '';
					
					for(const data of detail)
					{
						if(i !== 1){
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
									item += '<input type="text" class="form-control" id="detail-'+i+'" value="'+data['invd_detail']+'" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_detail]">';
								item += '</td>';
								item += '<td>';
									item += '<div class="row">';
										item += '<div class="col-6 pr-1">';
											item += '<input type="text" class="form-control basis" id="basis-'+i+'" value="'+data['invd_basis1_total']+'" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_basis1_total]" onkeyup="changeInputInvoice(this.id)" required>';
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
									item += '<input type="text" class="form-control jumlah" id="jumlah-'+i+'" value="'+data['invd_basis2_total']+'" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_basis2_total]" onkeyup="changeInputInvoice(this.id)" required>';
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
											tarif_all = data['invd_rate'];
											tarif_1 = data['invd_rate'].split('.')[0];
											tarif_2 = data['invd_rate'].split('.')[1];
										
											item += '<input type="hidden" class="form-control tarif" id="tarif-'+i+'" value="'+tarif_all+'" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_rate]">';
											item += '<input type="text" class="form-control tarif1" id="tarif1-'+i+'" value="'+tarif_1+'" onkeyup="changeInputInvoice(this.id)" required>';
										item += '</div>';
										item += '<div class="col-5 pl-1 pt-2">';
											item += '<input type="text" class="form-control tarif2" id="tarif2-'+i+'" style="height:25px" value="'+tarif_2+'" onkeyup="changeInputInvoice(this.id)">';
										item += '</div>';	
									item += '</div>';
								item += '</td>';
								
								item += '<td class="text-right">';
									item += '<label class="fw-normal mb-0" id="label_subtotal-'+i+'">0.00</label>';
									item += '<input type="hidden" class="form-control subtotal" id="subtotal-'+i+'" value="'+data['invd_amount']+'" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_amount]">';
								item += '</td>';
								item += '<td>IDR</td>';
								
								item += '<td>';
									item += '<select class="form-select form-select-lg ppntype" id="ppntype-'+i+'" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_id_ppn]" onchange="getTotal()" required>';
										item += "<?php
											foreach($ppn as $row){
												//$name = explode('-', $row['name']);
												// $name_ppn = $row['name'].'-'.$row['amount'].'%';
												
												// if($name[1] == '050'){
												// 	$selected = 'selected';
												// }else{
												// 	$selected = '';
												// }
												
												// echo "<option value='".$row['id']."' ".$selected.">".
												// 	$name_ppn.
												// "</option>";
											}
										?>";
									item += '</select>';
									item += '<input type="hidden" class="form-control ppn" id="ppn-'+i+'" value="" name="MasterNewJobinvoiceDetail[detail]['+i+'][invd_ppn]">';
								item += '</td>';
							item += '</tr>';
						}
						i++;
					}
					
					$('#table_invoice_idt tbody tr:first-child').after(item);
					
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
					
					//Default value
					setTimeout(function(){
						var index = 1;
						$('#table_invoice_idt tbody tr').each(function(){
							
							if($('#pos-'+index).length == 1){
								$('#pos-'+index).val(result.invoice_detail[index-1]['invd_pos']).trigger('change');
								$('#detail-'+index).val(result.invoice_detail[index-1]['invd_detail']);
								$('#basis-'+index).val(result.invoice_detail[index-1]['invd_basis1_total']);
								$('#basispack-'+index).val(result.invoice_detail[index-1]['invd_basis1_type']).trigger('change');
								$('#jumlah-'+index).val(result.invoice_detail[index-1]['invd_basis2_total']);
								$('#jumlahpack-'+index).val(result.invoice_detail[index-1]['invd_basis2_type']).trigger('change');
								
								tarif_all = result.invoice_detail[index-1]['invd_rate'];
								tarif_1 = tarif_all.split('.')[0];
								tarif_2 = tarif_all.split('.')[1];
								
								basis = result.invoice_detail[index-1]['invd_basis1_total'];
								jumlah = result.invoice_detail[index-1]['invd_basis2_total'];
								
								subtotal = basis * jumlah * tarif_all;
								
								$('#tarif-'+index).val(tarif_all);
								$('#tarif1-'+index).val(tarif_1);
								$('#tarif2-'+index).val(tarif_2);
								
								$('#label_subtotal-'+index).html(addSeparator(subtotal.toFixed(2)));
								$('#subtotal-'+index).val(subtotal);
								
								$('#ppntype-'+index).val(result.invoice_detail[index-1]['invd_id_ppn']).trigger('change');
								$('#ppn-'+index).val(result.invoice_detail[index-1]['invd_ppn']);
							}
							index++;
						});
					}, 700);
					
					$('#inv_id').val(id);
				}
			}
		});
	}*/
	
	// Cost
	function createCostIdt(){
		//Reset modal
		//$('#table_cost_idr tbody tr input').val('');
		$('#table_cost_idr tbody tr select').prop('selectedIndex',0);
		$('#table_cost_idr tbody tr label').html('0.00');
		$('#vch_pay_for_idr').prop('selectedIndex',0);
		$('#vch_pay_to_idr').val('');
		
		total_tr = $('#table_cost_idr tbody tr').length;
		if(total_tr > 3){
			//Remove table tbody selain index 0, dan index 2 yg terakhir
			$('#table_cost_idr tbody tr').not(':nth-child(1), :nth-child('+(total_tr)+'), :nth-child('+(total_tr-1)+')').remove();
		}
		
		$('#modal_cost_idr').modal({backdrop: 'static', keyboard: false});
		$('#modal_cost_idr').show();
	}
	
	function editCostIdt(id){
		$('#modal_cost_idr').modal({backdrop: 'static', keyboard: false});
		$('#modal_cost_idr').show();
		
		total_tr = $('#table_cost_idr tbody tr').length;
		if(total_tr > 3){
			//Remove table tbody selain index 0, dan index 2 yg terakhir
			$('#table_cost_idr tbody tr').not(':nth-child(1), :nth-child('+(total_tr)+'), :nth-child('+(total_tr-1)+')').remove();
		}
		
		$.ajax({
			url: '<?=Url::base().'/job/get-cost-idt'?>',
			data: {'id': id},
			dataType: 'json',
			method: 'POST',
            async: 'false'
		}).done(function(result){
			console.log(result);
			
			cost = result.cost[0];
			detail = result.cost_detail;
			
			if(result.cost.length > 0){
				$('#vch_date_idr').val(cost['vch_date']);
				$('#vch_due_date_idr').val(cost['vch_due_date']);
				$('#cost_id').val(cost['vch_id']);
				
				$('#vch_pay_for_idr').val(cost['vch_pay_for']).trigger('change');
				$('#vch_pay_to_idr').val(cost['vch_pay_to']);
				
				//Detail
				if(detail.length > 0){
					i = 1;
					item = '';
					
					for(const data of detail)
					{
						if(i !== 1){
							item += '<tr>';
								item += '<td class="text-center">';
									item += '<button class="btn btn-xs btn-danger" style="padding: 0px 5px" onclick="delrow_cost($(this))">';
										item += '<span class="fa fa-trash align-middle"></span>';
									item += '</button>';
								item += '</td>';
								item += '<td>';
									item += '<select class="form-select form-select-lg" id="cost_pos-'+i+'" name="MasterNewJobcostDetail[detail]['+i+'][vchd_pos]" required>';
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
									item += '<input type="text" class="form-control" id="cost_detail-'+i+'" value="" name="MasterNewJobcostDetail[detail]['+i+'][vchd_detail]">';
								item += '</td>';
								item += '<td>';
									item += '<div class="row">';
										item += '<div class="col-6 pr-1">';
											item += '<input type="text" class="form-control cost_basis" id="cost_basis-'+i+'" value="" name="MasterNewJobcostDetail[detail]['+i+'][vchd_basis1_total]" onkeyup="changeInputCost(this.id)" required>';
										item += '</div>';
										item += '<div class="col-6 pl-1">';
											item += '<select class="form-select form-select-lg" id="cost_basispack-'+i+'" name="MasterNewJobcostDetail[detail]['+i+'][vchd_basis1_type]" required>';
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
									item += '<input type="text" class="form-control cost_jumlah" id="cost_jumlah-'+i+'" value="" name="MasterNewJobcostDetail[detail]['+i+'][vchd_basis2_total]" onkeyup="changeInputCost(this.id)" required>';
								item += '</td>';
								item += '<td>';
									item += '<select class="form-select form-select-lg" id="cost_jumlahpack-'+i+'" name="MasterNewJobcostDetail[detail]['+i+'][vchd_basis2_type]" required>';
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
											item += '<input type="hidden" class="form-control cost_tarif" id="cost_tarif-'+i+'" value="" name="MasterNewJobcostDetail[detail]['+i+'][vchd_rate]">';
											item += '<input type="text" class="form-control cost_tarif1" id="cost_tarif1-'+i+'" value="" onkeyup="changeInputCost(this.id)" required>';
										item += '</div>';
										item += '<div class="col-5 pl-1 pt-2">';
											item += '<input type="text" class="form-control cost_tarif2" id="cost_tarif2-'+i+'" style="height:25px" value="00" onkeyup="changeInputCost(this.id)">';
										item += '</div>';	
									item += '</div>';
								item += '</td>';
								
								item += '<td class="text-right">';
									item += '<label class="fw-normal mb-0" id="cost_label_subtotal-'+i+'">0.00</label>';
									item += '<input type="hidden" class="form-control cost_subtotal" id="cost_subtotal-'+i+'" value="" name="MasterNewJobcostDetail[detail]['+i+'][vchd_amount]">';
								item += '</td>';
								item += '<td>IDR</td>';
								
								item += '<td>';
									// item += '<select class="form-select form-select-lg cost_ppntype" id="cost_ppntype-'+i+'" name="MasterNewJobcostDetail[detail]['+i+'][vchd_id_ppn]" onchange="getTotalCost()" required>';
									// 	item += '<option value="0"></option>';
										item += "<label>" + "<?= $ppn->name ?>" + " - " + "<?= $ppn->amount ?>" + "</label>" +"<?php
											// foreach($ppn as $row){
											// 	//$name = explode('-', $row['name']);
											// 	$name_ppn = $row['name'].'-'.$row['amount'].'%';
												
											// 	$selected = '';
												
											// 	echo "<option value='".$row['id']."' ".$selected.">".
											// 		$name_ppn.
											// 	"</option>";
											// }
										?>";
									// item += '</select>';
									item += '<input type="hidden" class="form-control cost_ppn" id="cost_ppn-'+i+'" value="<?= $ppn->id ?>" name="MasterNewJobcostDetail[detail]['+i+'][vchd_ppn]">';
								item += '</td>';
							item += '</tr>';
						}
						i++;
					}
					
					$('#table_cost_idr tbody tr:first-child').after(item);
					
					// Gabungan Tarif
					$('.cost_tarif1, .cost_tarif2').on('keyup', function(){
						$('.cost_tarif').each(function(i){
							input_tarif1 = Number($('.cost_tarif1').eq(i).val());
							input_tarif2 = $('.cost_tarif2').eq(i).val();
							
							if(input_tarif1 == ''){
								input_tarif1 = 0;
							}
							if(input_tarif2 == ''){
								input_tarif2 = '00';
							}
							
							tarif = input_tarif1+'.'+input_tarif2;
							
							$('.cost_tarif').eq(i).val(tarif);
						});
					});
					
					//Default value
					setTimeout(function(){
						var index = 1;
						$('#table_cost_idr tbody tr').each(function(){
							
							if($('#cost_pos-'+index).length == 1){
								$('#cost_pos-'+index).val(result.cost_detail[index-1]['vchd_pos']).trigger('change');
								$('#cost_detail-'+index).val(result.cost_detail[index-1]['vchd_detail']);
								$('#cost_basis-'+index).val(result.cost_detail[index-1]['vchd_basis1_total']);
								$('#cost_basispack-'+index).val(result.cost_detail[index-1]['vchd_basis1_type']).trigger('change');
								$('#cost_jumlah-'+index).val(result.cost_detail[index-1]['vchd_basis2_total']);
								$('#cost_jumlahpack-'+index).val(result.cost_detail[index-1]['vchd_basis2_type']).trigger('change');
								
								tarif_all = result.cost_detail[index-1]['vchd_rate'];
								tarif_1 = tarif_all.split('.')[0];
								tarif_2 = tarif_all.split('.')[1];
								
								basis = result.cost_detail[index-1]['vchd_basis1_total'];
								jumlah = result.cost_detail[index-1]['vchd_basis2_total'];
								
								subtotal = basis * jumlah * tarif_all;
								
								$('#cost_tarif-'+index).val(tarif_all);
								$('#cost_tarif1-'+index).val(tarif_1);
								$('#cost_tarif2-'+index).val(tarif_2);
								
								$('#cost_label_subtotal-'+index).html(addSeparator(subtotal.toFixed(2)));
								$('#cost_subtotal-'+index).val(subtotal);
								
								$('#cost_ppntype-'+index).val(result.cost_detail[index-1]['vchd_id_ppn']).trigger('change');
								$('#cost_ppn-'+index).val(result.cost_detail[index-1]['vchd_ppn']);
							}
							index++;
						});
					}, 700);
					
					$('#cost_id').val(id);
				}
			}
		});
	}

	function deleteCostIdt(id){
		let confirmed = confirm('Yakin ingin menghapus data ini?');
		
		if (confirmed){
			$.ajax({
				url: '<?=Url::base().'/job/delete-cost-idt'?>',
				data: {'id': id},
				dataType: 'json',
				method: 'POST',
				async: 'false'
			}).done(function(res){
				location.reload();
			});
		}
	}

	function createCostHmc(){
		//Reset modal
		$('#table_cost_hmc tbody tr input').val('');
		$('#table_cost_hmc tbody tr select').prop('selectedIndex',0);
		$('#table_cost_hmc tbody tr label').html('0.00');
		$('#vch_pay_for_hmc').prop('selectedIndex',0);
		$('#vch_pay_to_hmc').val('');
		
		total_tr = $('#table_cost_hmc tbody tr').length;
		if(total_tr > 3){
			//Remove table tbody selain index 0, dan index 2 yg terakhir
			$('#table_cost_hmc tbody tr').not(':nth-child(1), :nth-child('+(total_tr)+'), :nth-child('+(total_tr-1)+')').remove();
		}
		
		$('#modal_cost_hmc').modal({backdrop: 'static', keyboard: false});
		$('#modal_cost_hmc').show();
	}

	function deleteCostHmc(id){
		let confirmed = confirm('Yakin ingin menghapus data ini?');
		
		if (confirmed){
			$.ajax({
				url: '<?=Url::base().'/job/delete-cost-hmc'?>',
				data: {'id': id},
				dataType: 'json',
				method: 'POST',
				async: 'false'
			}).done(function(res){
				location.reload();
			});
		}
	}

	function showShort(){
		// $('#div_hmc_short').show();
		// $('#div_hmc_breakdown').hide();
		// $('#inv_hmc_type').val(1);
		createInvoiceHmc();
	}
	
	function showBreakdown(){
		// $('#div_hmc_short').hide();
		// $('#div_hmc_breakdown').show();
		// $('#inv_hmc_type').val(2);
		
		createInvoiceHmcBk();
	}
	
	function createCostMisc(){
		$('#modal_create_misc').modal({backdrop: 'static', keyboard: false});
		$('#modal_create_misc').show();
	}
	
	function createApMisc(){
		$('#modal_create_apmisc').modal({backdrop: 'static', keyboard: false});
		$('#modal_create_apmisc').show();
	}
	
	/*function editCostIdt(id){
		$('#modal_cost_idr').modal({backdrop: 'static', keyboard: false});
		$('#modal_cost_idr').show();
		
		total_tr = $('#table_cost_idr tbody tr').length;
		if(total_tr > 3){
			//Remove table tbody selain index 0, dan index 2 yg terakhir
			$('#table_cost_idr tbody tr').not(':nth-child(1), :nth-child('+(total_tr)+'), :nth-child('+(total_tr-1)+')').remove();
		}
		
		$.ajax({
			url: '<?=Url::base().'/job/get-cost-idt'?>',
			data: {'id': id},
			dataType: 'json',
			method: 'POST',
            async: 'false'
		}).done(function(result){
			console.log(result);
			
			cost = result.cost[0];
			detail = result.cost_detail;
			
			if(result.cost.length > 0){
				$('#vch_date_idr').val(cost['vch_date']);
				$('#vch_due_date_idr').val(cost['vch_due_date']);
				$('#cost_id').val(cost['vch_id']);
				
				$('#vch_pay_for_idr').val(cost['vch_pay_for']).trigger('change');
				$('#vch_pay_to_idr').val(cost['vch_pay_to']);
				
				//Detail
				if(detail.length > 0){
					i = 1;
					item = '';
					
					for(const data of detail)
					{
						if(i !== 1){
							item += '<tr>';
								item += '<td class="text-center">';
									item += '<button class="btn btn-xs btn-danger" style="padding: 0px 5px" onclick="delrow_cost($(this))">';
										item += '<span class="fa fa-trash align-middle"></span>';
									item += '</button>';
								item += '</td>';
								item += '<td>';
									item += '<select class="form-select form-select-lg" id="cost_pos-'+i+'" name="MasterNewJobcostDetail[detail]['+i+'][vchd_pos]" required>';
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
									item += '<input type="text" class="form-control" id="cost_detail-'+i+'" value="" name="MasterNewJobcostDetail[detail]['+i+'][vchd_detail]">';
								item += '</td>';
								item += '<td>';
									item += '<div class="row">';
										item += '<div class="col-6 pr-1">';
											item += '<input type="text" class="form-control cost_basis" id="cost_basis-'+i+'" value="" name="MasterNewJobcostDetail[detail]['+i+'][vchd_basis1_total]" onkeyup="changeInputCost(this.id)" required>';
										item += '</div>';
										item += '<div class="col-6 pl-1">';
											item += '<select class="form-select form-select-lg" id="cost_basispack-'+i+'" name="MasterNewJobcostDetail[detail]['+i+'][vchd_basis1_type]" required>';
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
									item += '<input type="text" class="form-control cost_jumlah" id="cost_jumlah-'+i+'" value="" name="MasterNewJobcostDetail[detail]['+i+'][vchd_basis2_total]" onkeyup="changeInputCost(this.id)" required>';
								item += '</td>';
								item += '<td>';
									item += '<select class="form-select form-select-lg" id="cost_jumlahpack-'+i+'" name="MasterNewJobcostDetail[detail]['+i+'][vchd_basis2_type]" required>';
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
											item += '<input type="hidden" class="form-control cost_tarif" id="cost_tarif-'+i+'" value="" name="MasterNewJobcostDetail[detail]['+i+'][vchd_rate]">';
											item += '<input type="text" class="form-control cost_tarif1" id="cost_tarif1-'+i+'" value="" onkeyup="changeInputCost(this.id)" required>';
										item += '</div>';
										item += '<div class="col-5 pl-1 pt-2">';
											item += '<input type="text" class="form-control cost_tarif2" id="cost_tarif2-'+i+'" style="height:25px" value="00" onkeyup="changeInputCost(this.id)">';
										item += '</div>';	
									item += '</div>';
								item += '</td>';
								
								item += '<td class="text-right">';
									item += '<label class="fw-normal mb-0" id="cost_label_subtotal-'+i+'">0.00</label>';
									item += '<input type="hidden" class="form-control cost_subtotal" id="cost_subtotal-'+i+'" value="" name="MasterNewJobcostDetail[detail]['+i+'][vchd_amount]">';
								item += '</td>';
								item += '<td>IDR</td>';
								
								item += '<td>';
									item += '<select class="form-select form-select-lg cost_ppntype" id="cost_ppntype-'+i+'" name="MasterNewJobcostDetail[detail]['+i+'][vchd_id_ppn]" onchange="getTotalCost()" required>';
										item += '<option value="0"></option>';
										item += "<?php
											// foreach($ppn as $row){
											// 	//$name = explode('-', $row['name']);
											// 	$name_ppn = $row['name'].'-'.$row['amount'].'%';
												
											// 	$selected = '';
												
											// 	echo "<option value='".$row['id']."' ".$selected.">".
											// 		$name_ppn.
											// 	"</option>";
											// }
										?>";
									item += '</select>';
									item += '<input type="hidden" class="form-control cost_ppn" id="cost_ppn-'+i+'" value="" name="MasterNewJobcostDetail[detail]['+i+'][vchd_ppn]">';
								item += '</td>';
							item += '</tr>';
						}
						i++;
					}
					
					$('#table_cost_idr tbody tr:first-child').after(item);
					
					// Gabungan Tarif
					$('.cost_tarif1, .cost_tarif2').on('keyup', function(){
						$('.cost_tarif').each(function(i){
							input_tarif1 = Number($('.cost_tarif1').eq(i).val());
							input_tarif2 = $('.cost_tarif2').eq(i).val();
							
							if(input_tarif1 == ''){
								input_tarif1 = 0;
							}
							if(input_tarif2 == ''){
								input_tarif2 = '00';
							}
							
							tarif = input_tarif1+'.'+input_tarif2;
							
							$('.cost_tarif').eq(i).val(tarif);
						});
					});
					
					//Default value
					setTimeout(function(){
						var index = 1;
						$('#table_cost_idr tbody tr').each(function(){
							
							if($('#cost_pos-'+index).length == 1){
								$('#cost_pos-'+index).val(result.cost_detail[index-1]['vchd_pos']).trigger('change');
								$('#cost_detail-'+index).val(result.cost_detail[index-1]['vchd_detail']);
								$('#cost_basis-'+index).val(result.cost_detail[index-1]['vchd_basis1_total']);
								$('#cost_basispack-'+index).val(result.cost_detail[index-1]['vchd_basis1_type']).trigger('change');
								$('#cost_jumlah-'+index).val(result.cost_detail[index-1]['vchd_basis2_total']);
								$('#cost_jumlahpack-'+index).val(result.cost_detail[index-1]['vchd_basis2_type']).trigger('change');
								
								tarif_all = result.cost_detail[index-1]['vchd_rate'];
								tarif_1 = tarif_all.split('.')[0];
								tarif_2 = tarif_all.split('.')[1];
								
								basis = result.cost_detail[index-1]['vchd_basis1_total'];
								jumlah = result.cost_detail[index-1]['vchd_basis2_total'];
								
								subtotal = basis * jumlah * tarif_all;
								
								$('#cost_tarif-'+index).val(tarif_all);
								$('#cost_tarif1-'+index).val(tarif_1);
								$('#cost_tarif2-'+index).val(tarif_2);
								
								$('#cost_label_subtotal-'+index).html(addSeparator(subtotal.toFixed(2)));
								$('#cost_subtotal-'+index).val(subtotal);
								
								$('#cost_ppntype-'+index).val(result.cost_detail[index-1]['vchd_id_ppn']).trigger('change');
								$('#cost_ppn-'+index).val(result.cost_detail[index-1]['vchd_ppn']);
							}
							index++;
						});
					}, 700);
					
					$('#cost_id').val(id);
				}
			}
		});
	}*/
</script>
  