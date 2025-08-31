<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use richardfan\widget\JSRegister;
use yii\bootstrap4\Modal;

use app\models\Customer;
use app\models\MasterNewJob;
use app\models\MasterPpn;
use app\models\MasterPph;
use app\models\MasterPortfolioAccount;

$customer = Customer::find()->where(['is_active'=>1])->orderBy(['customer_companyname'=>SORT_ASC])->all();
$ppn = MasterPpn::find()->where(['is_active'=>1])->all();
$pph = MasterPph::find()->where(['is_active'=>1])->all();
$account = MasterPortfolioAccount::find()->where(['flag'=>1])->orderBy(['accountname'=>SORT_ASC])->all();
?>

<style>
	.flex{
		display: flex;
		align-items: center;
	}
	
	input{
		padding: 6px !important;
	}
</style>

<?php
	Modal::begin([
		'title' => 'Create AR Receipt IDT',
		'id' => 'modal_create_ar',
		'size' => 'modal-xl',
	]);
?>
	<?php $form = ActiveForm::begin([
		'id' => 'form_ar_receipt', 
		'action' => Url::base().'/accounting/save-ar-receipt']); 
	?>

	<div id="content">
		<div class="row m-0">
			<div class="flex form-group mr-2" style="width:32%">
				<span style="width:20%">Date</span>
				<div style="width:80%">
					<?= date('d F Y') ?>
				</div>
			</div>
        </div>
		
		<div class="row m-0">
			<div class="flex form-group mr-4" style="width:35%">
				<span style="width:20%">Customer</span>
				<div style="width:80%">
					<select class="form-control" id="input_customer" onchange="checkInvoice()" name="ArReceipt[id_customer]" required>
						<?php
							foreach($customer as $row){
								echo '<option value="'.$row['customer_id'].'">'.
									$row['customer_companyname'].
								'</option>';
							}
						?>
					</select>
				</div>
			</div>
			
			<div class="flex form-group mr-2" style="width:30%">
				<span style="width:20%">Amount</span>
				<div class="mr-2" style="width:65%">
					<input type="text" class="form-control" placeholder="Amount" id="input_amount">
					<div class="error-notif" style="color:#dc3545;position:absolute" id="error-amount"></div>
				</div>
				<div style="width:15%">
					IDR
				</div>
			</div>
			
			<div class="flex form-group" style="width:32%">
				<span style="width:20%">Account</span>
				<div style="width:80%">
					<select class="form-control" id="input_account" name="ArReceipt[id_portfolio_account]" required>
						<option></option>
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
		
		<hr>
		
		<div class="row">
			<div class="col-12">
				<table class="table mb-0" id="table_invoice" style="font-size:10px">
					<thead class="table-secondary">
						<tr>
							<th width="10%">Invoice No</th>
							<th width="10%">Job No</th>
							<th width="8%">Date</th>
							<th width="8%" class="text-right">DPP</th>
							<th width="7%" class="text-right">PPN</th>
							<th width="7%" class="text-right">PPH</th>
							<th width="10%" class="text-right">Amount</th>
							<th width="10%" class="text-right">Short Paid</th>
							<th width="12%"></th>
							<th width="18%">Payment</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>
		</div>
		
		<hr class="mt-0">
		
		<div class="row form-group" style="float:right">
			<div class="col-12 text-right">
				<button type="button" class="btn btn-dark" id="btn-create-ar-receipt" onclick="submitArReceipt()">Create AR Receipt</button>
			</div>
		</div>
	</div>
	<?php ActiveForm::end(); ?>
<?php Modal::end(); ?>

<script>
	$(document).ready(function(){
		
	});
	
	$('#input_customer').select2({
		dropdownCssClass : 'bigdrop',
		dropdownParent: '#modal_create_ar',
	});
	
	$('#input_account').select2({
		dropdownCssClass : 'bigdrop',
		dropdownParent: '#modal_create_ar',
		placeholder: "Account",
	});
	
	function checkInvoice(){
		id_customer = $('#input_customer').val(); 
		
		$.ajax({
			type: 'POST',
			data: {'id_customer' : id_customer},
			url: '<?= Url::base()?>/accounting/get-invoice-unpaid',
			dataType: 'json',
			async: false,
			success: function(result){
				console.log(result);
				if(result.success){
					var data = result.invoice_unpaid;
					var item = '';
					var count = 0;
					
					const month_full = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
					const month_short = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
					
					$('#table_invoice tbody').html('');
					
					for(const d of data)
					{
						item = '<tr>';
							item += '<td>IDT'+String(d['inv_count']).padStart(6, '0')+'</td>';
							
							item += '<td>';
								item += '<a href="<?= Url::base()."/job/update"?>?id='+d['inv_job_id']+'" target="_blank">';
									item += d['masterNewJob']['job_name'];
									item += '<input type="hidden" id="id_job-'+count+'" value="'+d['inv_job_id']+'" name="ArReceipt[detail]['+count+'][id_job]">';
									item += '<input type="hidden" id="id_invoice-'+count+'" value="'+d['inv_id']+'" name="ArReceipt[detail]['+count+'][id_invoice]">';
								item += '</a>';
							item += '</td>';
							
							item += '<td>';
								if(d['inv_date'] !== ''){
									date  = d['inv_date'].split('-');
									day   = date[2];
									month = (date[1]*1)-1;
									year  = date[0];
									
									inv_date = day+' '+month_short[month]+' '+year;
								}else{
									inv_date = '-';
								}
								
								item += inv_date;
								item += '<input type="hidden" id="id_job-'+count+'" value="'+d['inv_date']+'" name="ArReceipt[detail]['+count+'][invoice_date]">';
							item += '</td>';
							
							item += '<td class="text-right">';
								dpp = parseFloat(d['inv_total']);
							
								item += addSeparator(dpp);
								item += '<input type="hidden" id="dpp-'+count+'" value="'+dpp+'" name="ArReceipt[detail]['+count+'][dpp]">';
							item += '</td>';
							
							item += '<td class="text-right">';
								ppn = parseFloat(d['inv_ppn']);
							
								item += '<div id="label-ppn-'+count+'">'+addSeparator(ppn)+'</div>';
								item += '<input type="hidden" id="ppn-'+count+'" value="'+ppn+'" name="ArReceipt[detail]['+count+'][ppn]">';
							item += '</td>';
							
							item += '<td class="text-right p-1" style="color:#dc3545">';
								if(d['is_pph'] == 1){
									checked = 'checked disabled';
									pphval = d['inv_pph'];
								}else{
									//cek sdh pernah bayar / blm, jk sdh pernah brrti tdk bs edit pph lg
									if(d['inv_grandtotal'] !== d['inv_short_paid']){
										checked = 'checked disabled';
										pphval = d['inv_pph'];
									}else{
										checked = '';
										pphval = '';
									}
								}
								
								item += '<div class="row">';
									item += '<div class="col-12">';
										item += '<div class="form-check form-check-inline m-0">';
											item += '<input type="checkbox" class="form-check-input pph-'+count+'" id="pphcheck-'+count+'" onchange="checkPph(this.id)" '+checked+'>';
											item += '<label class="form-check-label" for="pphcheck-'+count+'"></label>';
										
											item += '<div id="label-pph-'+count+'">'+pphval+'</div>';
											item += '<input type="hidden" id="pph-'+count+'" name="ArReceipt[detail]['+count+'][pph]">';	
										item += '</div>';
									item += '</div>';
								item += '</div>';
							item += '</td>';
							
							item += '<td class="text-right">';
								amount = d['inv_grandtotal'];
								
								item += '<div id="label-amount-'+count+'">'+addSeparator(amount)+'</div>';
								item += '<input type="hidden" id="total_invoice-'+count+'" value="'+amount+'" name="ArReceipt[detail]['+count+'][total_invoice]">';
							item += '</td>';
							
							item += '<td class="text-right">';
								short_paid = parseFloat(d['inv_short_paid']);
								
								item += '<div id="label-short_paid-'+count+'">'+addSeparator(short_paid)+'</div>';
								item += '<input type="hidden" id="short_paid-'+count+'" value="'+short_paid+'" name="ArReceipt[detail]['+count+'][short_paid]">';
							item += '</td>';
							
							item += '<td>';
								item += '<div class="row m-0">';
									item += '<div class="form-check form-check-inline mb-2">';
										item += '<input type="radio" class="form-check-input type-'+count+'" id="typefull-'+count+'" value="1" name="ArReceipt[detail]['+count+'][payment_type]" onchange="checkPaymentType(this.id)">';
										item += '<label class="form-check-label" for="typefull-'+count+'">Full</label>';
									item += '</div>';
									
									item += '<div class="form-check form-check-inline mb-2">';
										item += '<input type="radio" class="form-check-input type-'+count+'" id="typepartial-'+count+'" value="2" name="ArReceipt[detail]['+count+'][payment_type]" onchange="checkPaymentType(this.id)">';
										item += '<label class="form-check-label" for="typepartial-'+count+'">Partial</label>';
									item += '</div>';
								item += '</div>';
							item += '</td>';
							
							item += '<td>';
								item += '<input type="text" class="form-control payment" id="total_payment-'+count+'" onkeyup="checkPayment(this.id)" name="ArReceipt[detail]['+count+'][total_payment]">';
							item += '</td>';
							
						item += '</tr>';
						
						count++;
						
						$('#table_invoice tbody').append(item);
					}
				}else{
					console.log(result.message);
				}
			},
		});
	}
	
	function checkPph(id){
		idx = id.split('-')[1];
		
		if($('#'+id).is(':checked')){
			id_pph = $('#input_pph').val();
			pph = $('#input_pph :selected').html();
			
			if(pph == '' || pph == '-'){
				display_pph = '-';
				total_pph = 0;
			}else{
				persen_pph = pph.split('-')[1].split('%')[0];
				dpp = $('#dpp-'+idx).val();
				ppn = $('#ppn-'+idx).val();
				amount = $('#total_invoice-'+idx).val();
				shortpaid = $('#short_paid-'+idx).val();
				
				total_pph = parseFloat(Math.floor(persen_pph/100 * dpp)).toFixed(0);
				
				if(total_pph > 0){
					display_pph = addSeparator(total_pph);
				}else{
					display_pph = '-';
				}
				
				if(amount == shortpaid){
					total_amount = parseFloat(dpp) + parseFloat(ppn) - parseFloat(total_pph);
					total_shortpaid = parseFloat(shortpaid) - parseFloat(total_pph);
				}
				
				$('#label-pph-'+idx).html(display_pph);
				$('#pph-'+idx).val(total_pph);
				
				$('#label-amount-'+idx).html(addSeparator(total_amount));
				$('#total_invoice-'+idx).val(total_amount);
				
				$('#label-short_paid-'+idx).html(addSeparator(total_shortpaid));
				$('#short_paid-'+idx).val(total_shortpaid);
			}
		}else{
			amount = $('#total_invoice-'+idx).val();
			shortpaid = $('#short_paid-'+idx).val();
			pph = $('#pph-'+idx).val();
			
			amount_awal = parseFloat(amount) + parseFloat(pph);
			shortpaid_awal = parseFloat(shortpaid) + parseFloat(pph);
			
			$('#label-amount-'+idx).html(addSeparator(amount_awal));
			$('#total_invoice-'+idx).val(amount_awal);
			
			$('#label-short_paid-'+idx).html(addSeparator(shortpaid_awal));
			$('#short_paid-'+idx).val(shortpaid_awal);
			
			$('#label-pph-'+idx).html('');
			$('#pph-'+idx).val(0);
		}
	}
	
	function checkPaymentType(id){
		idx = id.split('-')[1];
		
		short_paid = $('#short_paid-'+idx).val();
		
		if($('#typefull-'+idx).is(':checked')){
			$('#total_payment-'+idx).val(short_paid);
		}else{
			$('#total_payment-'+idx).val('');
		}
	}
	
	//Jika tidak ada payment_type yg dicentang, tp mengisi total_payment, mk akan otomatis checked yg partial
	function checkPayment(id){
		idx = id.split('-')[1];
		
		checked = $('.type-'+idx+':checked').length;
		value = $('#total_payment-'+idx).val();
		
		if(checked == 0){
			$('#typepartial-'+idx).prop('checked',true);
		}
		
		if(value == ''){
			$('.type-'+idx).prop('checked',false);
		}
	}
	
	function submitArReceipt(){
		input_amount = $('#input_amount').val();
		
		total = 0;
		$('.payment').each(function(){
			total += parseFloat($(this).val());
		});
		
		if(input_amount == total){
			$('#form_ar_receipt').submit();
		}else{
			$('#error-amount').html('Jumlah Amount tidak sesuai dengan detail');
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
