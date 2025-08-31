<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use richardfan\widget\JSRegister;
use yii\bootstrap4\Modal;
use app\models\MasterNewJob;
use app\models\MasterG3eJobrouting;
use app\models\Customer;
use app\models\MasterPpn;
use app\models\MasterPortfolioAccount;
use app\models\Carrier;
use app\models\MasterPph;

$customer = Customer::find()->where(['is_active'=>1])->orderBy(['customer_nickname'=>SORT_ASC])->all();
$job = MasterNewJob::find()->where(['like', 'timestamp', date('Y').'-'])->orderBy(['job_name'=>SORT_DESC])->all();
$ppn = MasterPpn::find()->where(['is_active'=>1])->all();
$pph = MasterPph::find()->where(['is_active'=>1])->all();
$account = MasterPortfolioAccount::find()->where(['flag'=>1])->orderBy(['accountname'=>SORT_ASC])->all();
$carrier = Carrier::find()->where(['is_active'=>1])->all();

date_default_timezone_set('Asia/Jakarta');
?>

<style>
	.flex{
		display: flex;
		align-items: center;
	}
	
	/* Input Date */
	input[type="date"]::before {
	content: attr(placeholder);
	position: absolute;
	  color: #999999;
	}

	input[type="date"] {
	  color: #ffffff;
	}

	input[type="date"]:focus,
	input[type="date"]:valid {
	  color: #666666;
	}

	input[type="date"]:focus::before,
	input[type="date"]:valid::before {
	  content: "";
	}
	
	/* Input, Select */
	input, select{
		font-size: 12px !important;
		padding: 6px !important;
	}
</style>

<?php $form = ActiveForm::begin(['id' => 'form_create_ap_voucher', 'action' => Url::base().'/ap/create']); ?>
<?php
	Modal::begin([
		'title' => 'Create AP Voucher',
		'id' => 'modal_create_ap',
		'size' => 'modal-xl',
	]);
?>
	<div id="content">
		<div class="row form-group">
            <div class="col-6">
                <label class="fw-normal">Date : </label> <?= date('d F Y') ?>
            </div>
			<div class="col-6 text-right">
				<div class="form-check form-check-inline mb-2 ml-2">
					<input type="radio" class="form-check-input" id="type1" name="type" value="IDT" onchange="checkInput()" <?php if(isset($array['1']['data'])){ if($array['1']['data'] == 'customer'){echo 'checked';}} ?> checked>
					<label class="form-check-label" for="type1">IDT</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="radio" class="form-check-input" id="type2" name="type" value="HMC" onchange="checkInput()" <?php if(isset($array['1']['data'])){ if($array['1']['data'] == 'shipper'){echo 'checked';}} ?>>
					<label class="form-check-label" for="type2">HMC</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="radio" class="form-check-input" id="type3" name="type" value="RC" onchange="checkInput()" <?php if(isset($array['1']['data'])){ if($array['1']['data'] == 'consignee'){echo 'checked';}} ?>>
					<label class="form-check-label" for="type3">RC</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="radio" class="form-check-input" id="type4" name="type" value="Other" onchange="checkInput()" <?php if(isset($array['1']['data'])){ if($array['1']['data'] == 'notify'){echo 'checked';}} ?>>
					<label class="form-check-label" for="type4">Other</label>
				</div>
			</div>
        </div>
		
		<div class="overview-panel" style="font-size:10px">
			<div class="row" style="margin:0px 0px 20px 0px">
				<div class="flex mr-4" style="width:25%">
					<span style="width:20%">Job / MBL</span>
					<div style="width:80%">
						<select class="form-control" id="job_no">
							<?php
								foreach($job as $row){
									$reference = MasterG3eJobrouting::find()->where(['jr_job_id'=>$row['id']])->one();
									if($reference){
										$mbl = $reference->jr_mbl;
									}else{
										$mbl = ' ';
									}
									
									$job_no = substr($row['job_name'], 3, 25);
									$cust = $row['customer_name'];
									
									echo '<option value="'.$row['id'].'">'.
										$job_no.'-'.strtoupper($mbl).'('.$cust.')'.
									'</option>';
								}
							?>
						</select>
					</div>
				</div>
				
				<div class="flex mr-4" style="width:25%">
					<span style="width:25%">Invoice No</span>
					<div style="width:75%">
						<input type="text" class="form-control" placeholder="Invoice no" id="no_invoice" name="">
						<div class="error-info" id="error-no_invoice" style="color:#dc3545"></div>
					</div>
				</div>
				
				<div class="flex mr-4" style="width:25%">
					<span style="width:17%">Payee</span>
					<div style="width:83%">
						<select class="form-control" id="pay_to">
							<?php
								foreach($customer as $row){
									echo '<option value="'.$row['customer_id'].'">'.
										$row['customer_nickname'].
									'</option>';
								}
							?>
							<?php
								foreach($carrier as $row){
									echo '<option value="'.$row['carrier_id'].'">'.
										$row['carrier_code'].
									'</option>';
								}
							?>
						</select>
					</div>
				</div>
				
				<div class="flex mr-2" style="width:15%;display:none">
					<span style="width:25%">Date</span>
					<div style="width:75%">
						<input type="date" class="form-control p-2" placeholder="Date" value="<?= date('Y-m-d')?>" id="inv_date" name="">
					</div>
				</div>
				
				<div class="flex mr-2" style="width:17%">
					<span style="width:20%">Due</span>
					<div style="width:80%">
						<?php
							//Default H+1 (jika H+1 jatuh di sabtu/minggu, maka geser ke senin)
							$date = DateTime::createFromFormat('Y-m-d',date('Y-m-d'));
							$date->modify('+1 day');
							$tommorow = $date->format('l');
							
							if($tommorow == 'Saturday'){
								$date->modify('+2 day');
								$due_default = $date->format('Y-m-d');
							}elseif($tommorow == 'Sunday'){
								$date->modify('+1 day');
								$due_default = $date->format('Y-m-d');
							}else{
								$due_default = $date->format('Y-m-d');
							}
						?>
					
						<input type="date" class="form-control p-2" placeholder="Due" value="<?= $due_default ?>" id="date_due" name="">
					</div>
				</div>
			</div>
			
			<div class="row m-0">
				<!-- Input Type IDT -->
				<div class="flex div_idt mr-1" style="width:25%;display:none">
					<span style="width:20%">DPP</span>
					<div style="width:80%">
						<input type="text" class="form-control" placeholder="DPP" id="dpp" name="">
						<div class="error-info" id="error-dpp" style="color:#dc3545"></div>
					</div>
				</div>
				<div class="flex div_idt mr-1" style="width:8%;display:none">
					<select class="form-select form-select-lg" placeholder="PPN" id="input_ppn" name="" onchange="">
						<option value="0"></option>
						<?php
							foreach($ppn as $row){
								$name = explode('-', $row['name']);
								$name_ppn = $name[1].'-'.$row['amount'].'%';
								
								// Default yg 050-1,1%
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
					
					<select class="form-select form-select-lg" placeholder="PPH" id="input_pph" name="" onchange="" style="display:none">
						<option value="0"></option>
						<?php
							foreach($pph as $row){
								// Default yg 2%
								if($row['id'] == 1){
									$selected = 'selected';
								}else{
									$selected = '';
								}
								
								echo "<option value='".$row['id']."' selected>".
									$row['name'].
								"</option>";
							}
						?>
					</select>
				</div>
				<div class="flex div_idt mr-4" style="width:18.5%;display:none">
					&nbsp;&nbsp;IDR
					<div class="error-info" id="error-pph" style="color:#dc3545"></div>
				</div>
				
				<!-- Input Type HMC -->
				<div class="flex div_hmc mr-4" style="width:25%;display:none">
					<span style="width:20%">Amount</span>
					<div class="flex" style="width:80%">
						<input type="text" class="form-control" placeholder="Amount" id="amount_usd" name="">
						&nbsp;&nbsp;USD
						<div class="error-info" id="error-amount_usd" style="color:#dc3545"></div>
					</div>
				</div>
				<div class="flex div_hmc mr-4" style="width:25%;display:none">
					<span style="width:25%">Equal To</span>
					<div class="flex" style="width:75%">
						<input type="text" class="form-control" placeholder="Amount" value="" id="amount_idr" name="">
						&nbsp;&nbsp;IDR
						<div class="error-info" id="error-amount_idr" style="color:#dc3545"></div>
					</div>
				</div>
				
				<!-- Input Type RC/Other -->
				<div class="flex div_rc_other mr-1" style="width:25%;display:none">
					<span style="width:20%">Amount</span>
					<div style="width:80%">
						<input type="text" class="form-control" placeholder="Amount" id="amount_rc_other" name="">
						<div class="error-info" id="error-amount_rc_other" style="color:#dc3545"></div>
					</div>
				</div>
				<div class="flex div_rc_other mr-4" style="width:8%;display:none">
					<select class="form-select form-select-lg" placeholder="Currency" id="currency" name="" onchange="">
						<option value="IDR">IDR</option>
						<option value="USD">USD</option>
					</select>
				</div>
				
				<div class="flex mr-4" style="width:25%">
					<span style="width:17%">Account</span>
					<div style="width:83%">
						<select class="form-control" id="id_account">
							<?php
								foreach($account as $row){
									echo '<option value="'.$row['id'].'">'.
										$row['accountname'].' - '.$row['accountno'].' ( '.$row['bankname'].' )'.
									'</option>';
								}
							?>
						</select>
					</div>
				</div>
				
				<div class="flex mr-2" style="width:10%">
					<button type="button" class="btn btn-outline-dark w-100" style="font-size:10px" id="attach_file" onclick="upload()">Attach File</button>
					<div class="error-info" id="error-attach_file" style="color:#dc3545"></div>
				</div>
				<div class="flex" style="width:6%">
					<button type="button" class="btn btn-dark w-100" style="font-size:10px" onclick="addRow()">+ Add</button>
				</div>
			</div>
        </div>
		
		<hr>
		
		<div class="row">
			<div class="col-12">
				<table class="table mb-0" id="table_invoice" style="font-size:10px">
					<thead class="table-secondary">
						<tr>
							<th width="10%">Job No</th>
							<th width="8%">MBL</th>
							<th width="12%">Pay For (Customer)</th>
							<th width="5%">Payee</th>
							<th width="8%">Invoice No</th>
							<th width="8%">Invoice Date</th>
							<th width="8%">Due Date</th>
							<th width="10%" class="text-right">DPP</th>
							<th width="10%" class="text-right">PPN</th>
							<th width="10%" class="text-right">PPH</th>
							<th width="10%" class="text-right">Amount</th>
							<th width="1%"></th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>
		</div>
		
		<hr class="mt-0">
		
		<div class="row" style="font-size:12px">
			<div class="col-6">
				<b>Total</b>
			</div>
			<div class="col-6 text-right" id="total_voucher">
				<b>0</b>
			</div>
		</div>
		
		<hr>
		
		<div class="row form-group" style="float:right">
			<div class="col-12 text-right">
				<button type="submit" class="btn btn-dark">Create AP Voucher</button>
			</div>
		</div>
	</div>
<?php Modal::end(); ?>
<?php ActiveForm::end(); ?>

<script>
	$(document).ready(function(){
		checkInput();
	});
	
	function checkInput(){
		type = $('input[name="type"]:checked').val();
		
		if(type == 'IDT'){
			$('.div_idt').show();
			$('.div_hmc').hide();
			$('.div_rc_other').hide();
		}else if(type == 'HMC'){
			$('.div_idt').hide();
			$('.div_hmc').show();
			$('.div_rc_other').hide();
		}else if(type == 'RC' || type == 'Other'){
			$('.div_idt').hide();
			$('.div_hmc').hide();
			$('.div_rc_other').show();
		}
		
		// Clear Input
		$('#dpp').val('');
		$('#pph').val('');
		$('#amount_usd').val('');
		$('#amount_idr').val('');
		$('#amount_rc_other').val('');
	}
	
	
	$('#job_no').select2({
		dropdownCssClass : 'bigdrop',
		dropdownParent: '#modal_create_ap',
	});
	
	$('#pay_to').select2({
		dropdownCssClass : 'mediumdrop',
		dropdownParent: '#modal_create_ap',
	});
	
	$('#id_account').select2({
		dropdownCssClass : 'bigdrop',
		dropdownParent: '#modal_create_ap',
	});
	
	function addRow(){
		id_job = $('#job_no').val();
		job = $('#job_no :selected').html();
		type = $('input[name="type"]:checked').val();
		id_account = $('#id_account').val();
		
		no_job = job.split('-')[0];
		no_mbl = job.split('-')[1].split('(')[0];
		
		if(no_mbl == '' || no_mbl == ' '){
			display_mbl = '-';
		}else{
			display_mbl = no_mbl;
		}
		
		pay_for = job.split('(')[1].split(')')[0];
		
		pay_to = $('#pay_to').val();
		display_pay_to = $('#pay_to :selected').html();
		
		invoice_no = $('#no_invoice').val();
		
		if(invoice_no == ''){
			display_invoice_no = '-';
		}else{
			display_invoice_no = invoice_no;
		}
		
		inv_date = $('#inv_date').val();
		inv_due =  $('#date_due').val();
		
		const month_full = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
		const month_short = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
		
		// Invoice_date
		if(inv_date !== ''){
			date1 = inv_date.split('-');
			date1_month = (date1[1]*1)-1;
			
			invoice_date = date1[2]+' '+month_short[date1_month]+' '+date1[0];
		}else{
			invoice_date = '-';
		}
		
		// Invoice_due
		if(inv_due !== ''){
			date2 = inv_due.split('-');
			date2_month = (date2[1]*1)-1;
			
			invoice_due = date2[2]+' '+month_short[date2_month]+' '+date2[0];
		}else{
			invoice_due = '-';
		}
		
		//DPP
		dpp = $('#dpp').val();
		
		if(dpp == ''){
			display_dpp = '-';
			total_dpp = 0;
		}else{
			display_dpp = addSeparator(dpp);
			total_dpp = dpp;
		}
		
		//PPN
		id_ppn = $('#input_ppn').val();
		ppn = $('#input_ppn :selected').html();
		
		if(ppn == ''){
			display_ppn = '-';
			total_ppn = 0;
		}else{
			persen_ppn = ppn.split('-')[1].split('%')[0];
		
			total_ppn = parseFloat(Math.floor(persen_ppn/100 * total_dpp)).toFixed(0);
			
			if(total_ppn > 0){
				display_ppn = addSeparator(total_ppn);
			}else{
				display_ppn = '-';
			}
		}
		
		//PPH
		id_pph = $('#input_pph').val();
		pph = $('#input_pph :selected').html();
		
		if(pph == '' || pph == '-' || total_ppn == 0){
			display_pph = '-';
			total_pph = 0;
		}else{
			persen_pph = pph.split('-')[1].split('%')[0];
		
			total_pph = parseFloat(Math.floor(persen_pph/100 * total_dpp)).toFixed(0);
			
			if(total_pph > 0){
				display_pph = addSeparator(total_pph);
			}else{
				display_pph = '-';
			}
		}
		
		//Amount
		if(type == 'IDT'){
			//pph default 2% - Pembulatan ke bawah
			// total_pph = parseFloat(Math.floor(2/100 * total_dpp)).toFixed(0);
			// display_pph = addSeparator(total_pph);
			
			total_amount_idr = parseFloat(total_dpp) + parseFloat(total_ppn) - parseFloat(total_pph);
			total_amount_usd = 0;
			currency = 'IDR';
			
			display_amount = addSeparator(total_amount_idr)+' IDR';
			
		}else if(type == 'HMC'){
			total_amount_usd = $('#amount_usd').val();
			total_amount_idr = $('#amount_idr').val();
			
			if(total_amount_usd == ''){
				total_amount_usd = 0;
			}
			
			if(total_amount_idr == ''){
				total_amount_idr = 0;
			}
			
			//Default pakai yg idr, jika kosong baru pakai yg usd
			if(total_amount_idr > 0){
				currency = 'IDR';
				display_amount = addSeparator(total_amount_idr)+' IDR';
			}else{
				currency = 'USD';
				display_amount = addSeparator(total_amount_usd)+' USD';
			}
			
		}else if(type == 'RC' || type == 'Other'){
			currency = $('#currency').val();
			
			if(currency == 'IDR'){
				total_amount_usd = 0;
				total_amount_idr = $('#amount_rc_other').val();
				display_amount = addSeparator(total_amount_idr)+' IDR';
			}else{
				total_amount_usd = $('#amount_rc_other').val();
				total_amount_idr = 0;
				display_amount = addSeparator(total_amount_usd)+' USD';
			}
		}
		
		//Row id
		rows = $('#table_invoice tbody tr').length;
		
		if(rows == 0){
			id = 1;
		}else{
			last_tr = $('#table_invoice tbody tr:last-child').attr('id');
			id = parseFloat(last_tr.split('-')[1]) + 1;
		}
		
		item = '<tr id="row-'+id+'">';
			item += '<td>';
			item += no_job;
			item += '<input type="hidden" value="'+id_job+'" name="ApVoucher[detail]['+id+'][id_job]">';
			item += '<input type="hidden" value="'+type+'" name="ApVoucher[detail]['+id+'][type]">';
			item += '<input type="hidden" value="'+id_account+'" name="ApVoucher[detail]['+id+'][id_account]">';
			item += '</td>';
			
			item += '<td>';
			item += display_mbl;
			item += '</td>';
			
			item += '<td>';
			item += pay_for;
			item += '</td>';
			
			item += '<td>';
			item += display_pay_to;
			item += '<input type="hidden" value="'+pay_to+'" name="ApVoucher[detail]['+id+'][pay_to]">';
			item += '</td>';
			
			item += '<td>';
			item += display_invoice_no;
			item += '<input type="hidden" value="'+invoice_no+'" name="ApVoucher[detail]['+id+'][invoice_no]">';
			item += '</td>';
			
			item += '<td>';
			item += invoice_date;
			item += '<input type="hidden" value="'+inv_date+'" name="ApVoucher[detail]['+id+'][invoice_date]">';
			item += '</td>';
			
			item += '<td>';
			item += invoice_due;
			item += '<input type="hidden" value="'+inv_due+'" name="ApVoucher[detail]['+id+'][due_date]">';
			item += '</td>';
			
			item += '<td class="text-right">';
			item += display_dpp;
			item += '<input type="hidden" value="'+total_dpp+'" name="ApVoucher[detail]['+id+'][dpp]">';
			item += '</td>';
			
			item += '<td class="text-right">';
			item += display_ppn;
			item += '<input type="hidden" value="'+id_ppn+'" name="ApVoucher[detail]['+id+'][id_ppn]">';
			item += '<input type="hidden" value="'+total_ppn+'" name="ApVoucher[detail]['+id+'][ppn]">';
			item += '</td>';
			
			item += '<td class="text-right" style="color:#dc3545">';
			item += display_pph;
			item += '<input type="hidden" value="'+total_pph+'" name="ApVoucher[detail]['+id+'][pph]">';
			item += '</td>';
			
			item += '<td class="text-right">';
			item += display_amount;
			item += '<input type="hidden" class="currency" value="'+currency+'" name="ApVoucher[detail]['+id+'][currency]">';
			item += '<input type="hidden" class="amount_idr" value="'+total_amount_idr+'" name="ApVoucher[detail]['+id+'][amount_idr]">';
			item += '<input type="hidden" class="amount_usd" value="'+total_amount_usd+'" name="ApVoucher[detail]['+id+'][amount_usd]">';
			item += '</td>';
			
			item += '<td style="font-size:14px;cursor:pointer;">';
			item += '<span class="text-danger" onclick="rmItem($(this))"><i class="fa fa-close"></i><span>';
			item += '</td>';
		item += '</tr>';
		
		$('#table_invoice tbody').append(item);
		
		$('#no_invoice').val('');
		$('#dpp').val('');
		$('#pph').val('');
		
		checkTotal();
	}
	
	function rmItem(el){
		el.parent().parent().remove();
		
		checkTotal();
	}
	
	function checkTotal(){
		total = 0;
		
		if($('#table_invoice tbody tr').length > 0){
			$('.amount_idr').each(function(){
				total += parseFloat($(this).val());
				
				$('#total_voucher').html(addSeparator(total)+' IDR');
			});
		}else{
			$('#total_voucher').html(0);
		}
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
