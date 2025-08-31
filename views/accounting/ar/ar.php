<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Modal;
use richardfan\widget\JSRegister;
use app\models\MasterPortfolioAccount;
use app\models\PosV8;
use app\models\MasterNewJobinvoice;
use app\models\MasterNewJobvoucher;
use app\models\JobInfo;
use yii\helpers\VarDumper;

date_default_timezone_set('Asia/Jakarta');
?>

<?php
$account 	  = MasterPortfolioAccount::find()->where(['flag'=>1])->orderBy(['name'=>SORT_ASC])->all();
$pos 	 	  = PosV8::find()->where(['is_active'=>1])->orderby(['pos_name'=>SORT_ASC])->all();
$list_invoice = MasterNewJobinvoice::find()->where(['inv_is_active'=>1])->orderBy(['inv_count'=>SORT_DESC])->all();
$currency 	  = isset($_GET['curr']) ? $_GET['curr'] : 'IDR';	
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
	
	.table-detail-inv,
	.table-detail-inv thead td,
	.table-detail-inv .total td{
		border-top: 1px solid lightgray;
		border-bottom: 1px solid lightgray;
		padding: 5px !important;
	}
	
	.table-detail-inv tbody td{
		border: none;
		padding: 5px !important;
	}
	
	option{
		color: black;
	}
	
	.summary td{
		border: 1px solid lightgray;
	}
</style>

<div class="ar-idr-payment" style="font-size:12px">
	<div class="row">
		<div class="col-12" style="display:flex;justify-content:space-between">
			<div>
				<a href="<?= Url::base().'/accounting/index'?>" class="btn btn-dark">Back to Menu</a>
			</div>
			<div>
				<h5><b>AR PAYMENT - <?= $currency ?></b></h5>
			</div>
			<div>
				<button type="button" onclick="searchCurr('IDR')" class="btn btn-dark">IDR</button>
				<button type="button" onclick="searchCurr('USD')" class="btn btn-dark">USD</button>
			</div>
		</div>
	</div>
	<hr style="border-top:1px solid black;">
	<br>
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
		<div class="col-5">
			<button type="button" id="filter_ar_search" onclick="searchAr()" class="btn btn-default mr-1">FILTER</button>
			<button type="button" id="filter_ar_clear" onclick="clearAr()" class="btn btn-default mr-4">RESET</button>
			<button type="button" id="btn_ar_multiple" onclick="multipleAr()" class="btn btn-dark">AR MULTIPLE +</button>
		</div>
		
		<div class="col-2 pr-0">
			<select class="form-control" id="filter-summary">
				<option>NOW</option>
				<option>3 MONTH</option>
				<option>5 MONTH</option>
			</select>
		</div>
		<div class="col-2">
			<button type="button" id="filter_summary_search" onclick="searchSummary()" class="btn btn-default mr-1">FILTER</button>
		</div>
	</div>
	
	<br>
	
	<div class="row">
		<div class="col-7">
			<table class="table table-bordered" style="font-size:15px;">
				<tr>
					<td style="width:120px; text-align:center; background-color:#ccc; border-right:1px white solid">INV</td>
					<td style="width:100px; text-align:center; background-color:#ccc; border-right:1px white solid">DATE</td>
					<td style="width:100px; text-align:center; background-color:#ccc; border-right:1px white solid">AMOUNT</td>
					<td style="width:100px; text-align:center; background-color:#ccc; border-right:1px white solid">AR</td>
				</tr>
				
				<?php
					$i = 1;
					foreach($invoice as $row){
				?>
					<tr>
						<td style="text-align:left;">
							<a href="<?= Url::base() ?>/job/print-invoice?id_job=<?= $row['inv_job_id']?>&id_invoice=<?= $row['inv_id'] ?>" style="color:black;text-decoration:none" target="_blank">
								<i class="fa fa-file-pdf-o mr-1"></i>
							</a>
							<?php
								$jobinfo = JobInfo::find()->where(['id_job'=>$row['inv_job_id'], 'is_active' => 1])->one();
								
								if(isset($jobinfo)){
									if($jobinfo->step == 5 || $jobinfo->step == 6){
										$erc = '-ER';
									}else{
										$erc = '';
									}
								}else{
									$erc = '';
								}
								
							if($row['inv_currency'] == 'USD'){
								$kode = 'HMC';
							}else{
								$kode = 'IDT';
							}
							?>
							
							
							<?= $kode.str_pad($row['inv_count'],6,'0',STR_PAD_LEFT).$erc; ?>
						</td>
						<td style="text-align:center">
							<?= date_format(date_create($row['inv_date']), 'd M Y') ?>
						</td>
						<td style="text-align:right">
							<?= number_format($row['inv_grandtotal'],'0','.',',').' '.$currency ?>
						</td>
						<td style="text-align:center">
							<button type="button" class="btn btn-dark" onclick="createAr(<?= $row['inv_id'] ?>)" title="Create">CREATE AR</button>
						</td>
					</tr>
					<tr>
						<td colspan="4" style="background-color:#F5F5F5">
							<?php
								$vch_idr = MasterNewJobvoucher::find()
											->where(['vch_invoice' => $row['inv_id'], 'vch_is_active' => 1])
											->orderBy(['vch_id'=>SORT_ASC])
											->all();
								
								if(isset($vch_idr)){
									foreach($vch_idr as $v){
										if($v['vch_pembayaran_type'] == 1){
											$type = 'AR-C';
											$bayar_type = 'BKM';
											$bank = '';
										}else{
											$type = 'AR-B';
											$bayar_type = 'BBM';
											$vch_bank = MasterPortfolioAccount::find()->where(['id'=>$v['vch_bank']])->one();
											$bank = $vch_bank->name;
										}
										
										if(!empty($v['vch_count_multiple']) && $v['vch_count_multiple'] !== '-'){
											$vch_count_multiple = $v['vch_count_multiple'];
										}else{
											$vch_count_multiple = '';
										}
										
										$tahun = date_format(date_create_from_format('Y-m-d', $v['vch_date']), 'y');
										$bulan = date_format(date_create_from_format('Y-m-d', $v['vch_date']), 'm');
										$day = date_format(date_create_from_format('Y-m-d', $v['vch_date']), 'd');
										$vch_count = str_pad($v['vch_count'], 6, '0', STR_PAD_LEFT);
										
										$voucher_number = $vch_count;
										$voucher_date = $tahun.''.$bulan.''.$day;
								?>
									<div class="row" style="margin:0px 0px 10px 0px;">
										<div>
											<a href="<?= Url::base().'/accounting/print-ar?id='.$v['vch_id'] ?>" style="color:black;text-decoration:none" target="_blank">
												<i class="fa fa-file-pdf-o mr-2"></i>
											</a>
										</div>
										
										<div style="color:blue">
											<div onclick="editAr(<?= $v['vch_id'] ?>)" style="cursor:pointer" title="Edit">
												<?= $type.'-'.$voucher_number.''.$vch_count_multiple.'-'.$voucher_date ?>
											</div>
										</div>
										
										<div class="ml-2 mr-2"> / </div>
										
										<div style="width:15%;text-align:right">
											<?= number_format($v['vch_amount'],'0','.',',').' '.$v['vch_currency'] ?>
										</div>
										
										<div class="ml-2 mr-2"> / </div>
										
										<div style="width:20%">
											<?= empty($bank) ? '-': $bank ?>
										</div>
									</div>
								<?php } ?>
							<?php } ?>
						</td>
					</tr>
				<?php } ?>
			</table>
		</div>
		
		<div class="col-1"></div>
		<div class="col-4">
			<?php
				$payment_voucher = MasterNewJobinvoice::find()
					->joinWith('paymentinvoice')
					->select(['inv_due_date', 'sum(inv_grandtotal) as total'])
					// ->where(['is', 'master_new_jobvoucher.vch_id' , null])
					->where(['or', ['is', 'master_new_jobvoucher.vch_id', null], ['master_new_jobvoucher.vch_is_active' => 0]])
					// ->andWhere(['>=', 'inv_due_date', date('Y-m-d'). '23:59:59'])
					->andWhere(['inv_currency' => $currency])
					->andWhere(['inv_is_active' => 1])
					->groupBy(['inv_due_date'])
					->asArray()
					->all();
				
				// VarDumper::dump($payment_voucher,10,true);die();
				
				$total_all = 0;
				foreach($payment_voucher as $row){
					$total_all += ($row['total']*1);
				}
			?>
			
			<div class="row m-0" style="border:1px solid lightgray;font-size:25px;padding:10px">
				<div class="col-6">Total</div>
				<div class="col-6 text-right"><?= number_format($total_all,'0','.',',').' '.$currency ?></div>
			</div>
			
			<table class="table table-bordered summary" style="font-size:15px;">
				<?php 
					$total_all = 0;
					foreach($payment_voucher as $row){
				?>
				<tr>
					<td width="50%"><?= date_format(date_create_from_format('Y-m-d', $row['inv_due_date']), 'd-m-Y') ?></td>
					<td width="50%" class="text-right"><?= number_format($row['total'],'0','.',',').' '.$currency ?></td>
				</tr>
				<?php } ?>
			</table>
		</div>
	</div>


<?php
	Modal::begin([
		'title' => 'Create AR Payment',
		'id' => 'modal_payment_ar_idt',
		'size' => 'modal-lg',
	]);
?>
	<?php $form = ActiveForm::begin([
		'id' => 'form_payment_ar_idt',
		'action' => ['accounting/save-ar-payment'],
	]); ?>
		<input type="hidden" id="vch_id" value="" name="MasterNewJobvoucher[vch_id]">
		<input type="hidden" id="vch_id_invoice" name="MasterNewJobvoucher[vch_invoice]">
		<input type="hidden" id="vch_id_job" name="MasterNewJobvoucher[vch_job_id]">
		
		<div id="div_ar_invoice" style="padding:10px;border:1px solid lightgray;margin-bottom:20px;background:#f8f8f8;">
			
		</div>
		
		<div class="row mb-1">
			<label class="col-2">Tanggal</label>
			<div class="col-4">
				<input type="date" class="form-control" id="vch_date" value="<?= date('Y-m-d') ?>" name="MasterNewJobvoucher[vch_date]">
			</div>
		</div>

		<div class="row">
			<label class="col-2">Type</label>
			<div class="col-9">
				<div class="form-check form-check-inline col-md-4">
					<input type="radio" class="form-check-input vch_mode" id="vch_mode1" name="MasterNewJobvoucher[vch_pembayaran_type]" value="1">
					<label class="form-check-label" for="vch_mode1">AR-C-CASH</label>
				</div>
				<div class="form-check form-check-inline col-md-5">
					<input type="radio" class="form-check-input vch_mode" id="vch_mode2" name="MasterNewJobvoucher[vch_pembayaran_type]" value="2">
					<label class="form-check-label" for="vch_mode2">AR-B-BANK</label>
				</div>
			</div>
		</div>
		
		<div class="row mb-1" id="div_account" style="display:none">
			<label class="col-2"></label>
			<div class="col-7">
				<select class="form-control" id="id_account" name="MasterNewJobvoucher[vch_bank]">
					<?php
						foreach($account as $row){
							echo '<option value="'.$row['id'].'">'.
								$row['name'].
							'</option>';
						}
					?>
				</select>
			</div>
		</div>
		
		<div class="row mb-1">
			<label class="col-2"></label>
			<div class="col-7">
				<input type="text" class="form-control" id="vch_informasi" value="" placeholder="Informasi" name="MasterNewJobvoucher[vch_pembayaran_info]">
			</div>
		</div>
		
		<!--<div class="row mb-1">
			<label class="col-2"></label>
			<div class="col-7">
				<input type="text" class="form-control" id="vch_rate_kurs" value="" placeholder="Rate Kurs" name="MasterNewJobvoucher[vch_rate_kurs]">
			</div>
		</div>-->
		
		<div class="row mb-1">
			<label class="col-2">Amount</label>
			<div class="col-2 pr-1">
				<select class="form-control" id="vch_currency" name="MasterNewJobvoucher[vch_currency]">
					<option value="IDR">IDR</option>
					<option value="USD">USD</option>
				</select>
			</div>
			<div class="col-5 pl-0">
				<input type="text" class="form-control" id="vch_amount" value="" name="MasterNewJobvoucher[vch_amount]" required>
			</div>
		</div>
		
		<div class="row mb-1">
			<label class="col-2">No Faktur</label>
			<span class="col-9">
				<div style="width:70px;display:inline-block">
					<input type="text" class="form-control" id="vch_faktur1" maxlength="3" value="" name="MasterNewJobvoucher[vch_faktur1]" required>
				</div>&nbsp;.&nbsp;
				<div style="width:70px;display:inline-block">
					<input type="text" class="form-control" id="vch_faktur2" maxlength="3" value="" name="MasterNewJobvoucher[vch_faktur2]" required>
				</div>&nbsp;-&nbsp;
				<div style="width:70px;display:inline-block">
					<input type="text" class="form-control" id="vch_faktur3" maxlength="2" value="" name="MasterNewJobvoucher[vch_faktur3]" required>
				</div>&nbsp;.&nbsp;
				<div style="width:100px;display:inline-block">
					<input type="text" class="form-control" id="vch_faktur4" maxlength="8" value="" name="MasterNewJobvoucher[vch_faktur4]" required>
				</div>
			</span>
		</div>
		
		<div class="row mb-1">
			<div class="col-2">
				<div class="form-check form-check-inline col-md-12">
					<input type="checkbox" class="form-check-input" id="vch_with_pph" name="MasterNewJobvoucher[vch_ck_pph]">
					<label class="form-check-label" for="vch_with_pph">With PPH</label>
				</div>
			</div>
		</div>
		<hr>
		<div id="div_pph" style="display:none">
			<div class="row mb-1">
				<label class="col-2">Tgl. PPH</label>
				<div class="col-4">
					<input type="date" class="form-control" id="vch_date_pph" value="<?= date('Y-m-d') ?>" name="MasterNewJobvoucher[vch_date_pph]">
				</div>
			</div>
			
			<div class="row mb-1">
				<label class="col-2">Nomor Bupot</label>
				<div class="col-6">
					<input type="text" class="form-control" id="vch_nomor_pph" value="" name="MasterNewJobvoucher[vch_nomor_pph]">
				</div>
			</div>
			
			<div class="row mb-1">
				<label class="col-2">Amount PPH</label>
				<div class="col-6">
					<input type="text" class="form-control" id="vch_amount_pph" value="" name="MasterNewJobvoucher[vch_amount_pph]">
				</div>
			</div>
			<hr>
		</div>
		
		<div class="row">
			<div class="col-12 text-right">
				<button type="submit" class="btn btn-dark">Save</button>
			</div>
		</div>
	<?php ActiveForm::end(); ?>
<?php Modal::end(); ?>

<!-- AR Multiple -->
<?php
	Modal::begin([
		'title' => 'Create AR Payment',
		'id' => 'modal_payment_ar_idt_multiple',
		'size' => 'modal-lg',
	]);
?>
	<?php $form = ActiveForm::begin([
		'id' => 'form_payment_ar_idt_multiple',
		'action' => ['accounting/save-ar-payment-multiple'],
	]); ?>
		
		<div class="row mb-1">
			<label class="col-2">Tanggal</label>
			<div class="col-4">
				<input type="date" class="form-control" id="vch_date" value="<?= date('Y-m-d') ?>" name="MasterNewJobvoucher[vch_date]">
			</div>
		</div>

		<div class="row mb-3">
			<label class="col-2 pt-2">Total Invoice</label>
			<div class="col-2">
				<input type="number" class="form-control" id="rows_multi_ar" onkeyup="addrows_multi_ar()">
			</div>
			<!--<div class="col-4">
				<button type="button" class="btn btn-success" onclick="addrow_invoice()">
					<span class="fa fa-plus align-middle"></span> Tambah
				</button>
			</div>-->
		</div>
		
		<div id="div_multiple_ar">
			
		</div>
		
		<div class="row">
			<div class="col-12 text-right">
				<button type="submit" class="btn btn-dark">Save</button>
			</div>
		</div>
	<?php ActiveForm::end(); ?>
<?php Modal::end(); ?>
</div>

<script>
	$(document).ready(function(){
		<?php if($model->isNewRecord){ ?>
			$('#vch_mode1').prop('checked', true);
		<?php } ?>
	});
	
	$('.vch_mode').on('click', function(){
		if($('#vch_mode2').is(':checked') == true){
			$('#div_account').show();
		}else{
			$('#div_account').hide();
		}
	});
	
	$('#vch_with_pph').on('click', function(){
		if($('#vch_with_pph').is(':checked') == true){
			$('#div_pph').show();
		}else{
			$('#div_pph').hide();
			$('#vch_date_pph').val('<?= date('Y-m-d') ?>');
			$('#vch_nomor_pph').val('');
			$('#vch_amount_pph').val('');
		}
	});
	
	function searchAr(){
		month = $('#filter-month').val();
		year = $('#filter-year').val();
		currency = sessionStorage.getItem('currency');
		if(currency == '' || currency == null){
			currency = 'IDR';
		}
		
		url = '<?= Url::base()?>/accounting/ar?month='+month+'&year='+year+'&curr='+currency;
		window.location.replace(url);
	}
	
	function searchCurr(currency){
		sessionStorage.setItem('currency', currency);
		
		month = $('#filter-month').val();
		year = $('#filter-year').val();
		
		url = '<?= Url::base()?>/accounting/ar?month='+month+'&year='+year+'&curr='+currency;
		window.location.replace(url);
	}
	
	function clearAr(){
		sessionStorage.setItem('currency', 'IDR');
		url = '<?= Url::base()?>/accounting/ar';
		window.location.replace(url);
	}
	
	function getInvoice(id){
		$.ajax({
			url: '<?=Url::base().'/accounting/get-invoice-idt'?>',
			data: {'id': id},
			dataType: 'json',
			method: 'POST',
            async: 'false'
		}).done(function(result){
			invoice = result.invoice;
			detail = result.detail;
			
			if(invoice){
				$('#vch_id_job').val(invoice['inv_job_id']);
				
				item = '';
				item += '<div class="row">';
					item += '<div class="col-12 text-center" style="font-size:16px">';
						item += '<b>JOB INVOICE</b>';
					item += '</div>';
				item += '</div>';
				item += '<div class="row">';
					item += '<label class="col-2">DATE</label>';
					item += '<div class="col-8">';
						item += ': '+result.date_invoice;
					item += '</div>';
				item += '</div>';
				item += '<div class="row">';
					item += '<label class="col-2">CUSTOMER</label>';
					item += '<div class="col-8">';
						item += ': '+result.data_customer['customer_companyname'];
					item += '</div>';
				item += '</div>';
				
				item += '<table class="table table-detail-inv">';
					item += '<thead>';
						item += '<tr>';
							item += '<td width="28%">DESCRIPTION OF CHARGES</td>';
							item += '<td width="16%" class="text-right">BASIS</td>';
							item += '<td width="16%" class="text-right">QUANTITY</td>';
							item += '<td width="16%" class="text-right">RATE</td>';
							item += '<td width="17%" class="text-right">TOTAL</td>';
							item += '<td width="5%">CURR</td>';
						item += '</tr>';
					item += '</thead>';
					
					item += '<tbody>';
						if(detail){
							for(const data of detail)
							{
								item += '</tr>';
									item += '<td>'+data['pos_name']+'</td>';
									item += '<td class="text-right">'+data['total_basis']+' '+data['packages_basis']+'</td>';
									item += '<td class="text-right">'+data['total_qty']+' '+data['packages_qty']+'</td>';
									item += '<td class="text-right">'+data['rate']+'</td>';
									item += '<td class="text-right">'+data['amount']+'</td>';
									item += '<td>'+invoice['inv_currency']+'</td>';
								item += '</tr>';
							}
						}
						item += '<tr class="total">';
							item += '<td colspan="4" class="text-right">TOTAL</td>';
							item += '<td class="text-right">'+result.total+'</td>';
							item += '<td>'+invoice['inv_currency']+'</td>';
						item += '</tr>';
						
						item += '<tr class="total">';
							item += '<td colspan="4" class="text-right">PPN</td>';
							item += '<td class="text-right">'+result.total_ppn+'</td>';
							item += '<td>'+invoice['inv_currency']+'</td>';
						item += '</tr>';
						
						item += '<tr class="total">';
							item += '<td colspan="4" class="text-right">GRANDTOTAL</td>';
							item += '<td class="text-right">'+result.grandtotal+'</td>';
							item += '<td>'+invoice['inv_currency']+'</td>';
						item += '</tr>';
					item += '</tbody>';
				item += '</table>';
				
				$('#div_ar_invoice').html(item);
			}
		});
	}
	
	function createAr(id){
		//Reset Form setiap close modal
		$('#modal_payment_ar_idt').on('hidden.bs.modal', function(){
			$('#form_payment_ar_idt').trigger('reset');
			$('#vch_mode1').prop('checked', true);
			$('#div_pph').css('display', 'none');
			$('#div_ar_invoice').html('');
		});
		
		$('#vch_id_invoice').val(id);
		
		getInvoice(id);
		
		$('#modal_payment_ar_idt').modal({backdrop: 'static', keyboard: false});
		$('#modal_payment_ar_idt').modal('show');
	}
	
	function editAr(id){
		//Reset Form setiap close modal
		$('#modal_payment_ar_idt').on('hidden.bs.modal', function(){
			$('#form_payment_ar_idt').trigger('reset');
			$('#vch_mode1').prop('checked', true);
			$('#div_pph').css('display', 'none');
			$('#div_ar_invoice').html('');
		});
		
		$.ajax({
			url: '<?=Url::base().'/accounting/get-ar-idt'?>',
			data: {'id': id},
			dataType: 'json',
			method: 'POST',
            async: 'false'
		}).done(function(result){
			ar_idt = result.ar_idt;
			invoice = result.invoice;
			
			if(ar_idt){
				$('#vch_date').val(ar_idt['vch_date']);
				
				if(ar_idt['vch_pembayaran_type'] == 1){
					$('#vch_mode1').prop('checked', true);
					$('#div_account').css('display', 'none');
				}else{
					$('#vch_mode2').prop('checked', true);
					$('#div_account').css('display', '');
					$('#id_account').val(ar_idt['vch_bank']).trigger('change');
				}
				
				$('#vch_informasi').val(ar_idt['vch_pembayaran_info']);
				$('#vch_currency').val(ar_idt['vch_currency']).trigger('change');
				$('#vch_amount').val(ar_idt['vch_amount']);
				
				no_faktur1 = ar_idt['vch_faktur'].split('.')[0];
				no_faktur2 = ar_idt['vch_faktur'].split('.')[1].split('-')[0];
				no_faktur3 = ar_idt['vch_faktur'].split('.')[1].split('-')[1];
				no_faktur4 = ar_idt['vch_faktur'].split('.')[2];
				
				$('#vch_faktur1').val(no_faktur1);
				$('#vch_faktur2').val(no_faktur2);
				$('#vch_faktur3').val(no_faktur3);
				$('#vch_faktur4').val(no_faktur4);
				
				if(ar_idt['vch_ck_pph'] == 0){
					$('#vch_with_pph').prop('checked', false);
					$('#div_pph').css('display', 'none');
					$('#vch_date_pph').val('<?= date('Y-m-d') ?>');
					$('#vch_nomor_pph').val('');
					$('#vch_amount_pph').val('');
				}else{
					$('#vch_with_pph').prop('checked', true);
					$('#div_pph').css('display', '');
					$('#vch_date_pph').val(ar_idt['vch_date_pph']);
					$('#vch_nomor_pph').val(ar_idt['vch_nomor_pph']);
					$('#vch_amount_pph').val(ar_idt['vch_amount_pph']);
				}
				
				$('#vch_id').val(ar_idt['vch_id']);
				$('#vch_id_invoice').val(invoice['inv_id']);
				$('#vch_id_job').val(invoice['inv_job_id']);
				
				getInvoice(invoice['inv_id']);
				
				$('#modal_payment_ar_idt-label').html('Edit AR Payment');
				
				$('#modal_payment_ar_idt').modal({backdrop: 'static', keyboard: false});
				$('#modal_payment_ar_idt').modal('show');
			}
		});
	}
	
	//------ Multi AR -----
	function multipleAr(){
		$('#div_multiple_ar').html('');
		$('#rows_multi_ar').val('');
		$('#modal_payment_ar_idt_multiple').modal({backdrop: 'static', keyboard: false});
		$('#modal_payment_ar_idt_multiple').modal('show');
	}
	
	function addrows_multi_ar(){
		$('#div_multiple_ar').html('');
		
		rows = $('#rows_multi_ar').val();
		
		// Limit loop 30x, menghindari server down
		if(rows <= 30){ 
			for(let i=0; i < rows; i++){
				addrow_invoice();
			}
		}
	}
	
	function addrow_invoice(){
		last = $('.list_invoice').length;
		
		item = '';
		if(last == 0){
			id = 1;
			item += '<hr>';
		}else{
			id = last+1;
		}
		
		item += '<div class="row mb-1 list_invoice" id="div_list_invoice-'+id+'">';
			item += '<div class="col-12">';
				item += '<b>INV #'+id+'</b>';
			item += '</div>';
		item += '</div>';
		
		item += '<div class="row mb-1" id="div_list_invoice-'+id+'">';
			item += '<label class="col-2">Invoice</label>';
			item += '<div class="col-7">';
				item += '<select class="form-control" id="vch_id_invoice-'+id+'" name="MasterNewJobvoucher[detail]['+id+'][vch_invoice]" onchange="getDetailInvoice(this.id)" required>';
					item += '<option value="">-- List Invoice --</option>';
					item += '<?php
						foreach($list_invoice as $row){
							echo '<option value="'.$row['inv_id'].'">'.
								'IDT'.str_pad($row['inv_count'],6,'0',STR_PAD_LEFT).' '.'('.date_format(date_create($row['inv_date']), 'd M Y').')'.
							'</option>';
						}
					?>';
				item += '</select>';
			item += '</div>';
		item += '</div>';
		
		item += '<div id="div_ar_invoice-'+id+'" style="margin-top:10px;padding:10px;border:1px solid lightgray;margin-bottom:20px;background:#f8f8f8;display:none">';
		
		item += '</div>';
		
		item += '<input type="hidden" id="vch_id_job-'+id+'" name="MasterNewJobvoucher[detail]['+id+'][vch_job_id]">';
		
		item += '<div class="row">';
			item += '<label class="col-2">Type</label>';
			item += '<div class="col-9">';
				item += '<div class="form-check form-check-inline col-md-4">';
					item += '<input type="radio" class="form-check-input vch_mode_multi" id="vch_mode1-'+id+'" name="MasterNewJobvoucher[detail]['+id+'][vch_pembayaran_type]" value="1">';
					item += '<label class="form-check-label" for="vch_mode1-'+id+'">ARC / BKM</label>';
				item += '</div>';
				item += '<div class="form-check form-check-inline col-md-5">';
					item += '<input type="radio" class="form-check-input vch_mode_multi" id="vch_mode2-'+id+'" name="MasterNewJobvoucher[detail]['+id+'][vch_pembayaran_type]" value="2">';
					item += '<label class="form-check-label" for="vch_mode2-'+id+'">ARB / BBM</label>';
				item += '</div>';
			item += '</div>';
		item += '</div>';
		
		item += '<div class="row mb-1" id="div_account-'+id+'" style="display:none">';
			item += '<label class="col-2"></label>';
			item += '<div class="col-7">';
				item += '<select class="form-control" id="id_account-'+id+'" name="MasterNewJobvoucher[detail]['+id+'][vch_bank]">';
					item += '<?php
						foreach($account as $row){
							echo '<option value="'.$row['id'].'">'.
								$row['name'].
							'</option>';
						}
					?>';
				item += '</select>';
			item += '</div>';
		item += '</div>';
		
		item += '<div class="row mb-1">';
			item += '<label class="col-2"></label>';
			item += '<div class="col-7">';
				item += '<input type="text" class="form-control" id="vch_informasi-'+id+'" value="" placeholder="Informasi" name="MasterNewJobvoucher[detail]['+id+'][vch_pembayaran_info]">';
			item += '</div>';
		item += '</div>';
		
		item += '<div class="row mb-1">';
			item += '<label class="col-2">Amount</label>';
			item += '<div class="col-2 pr-1">';
				item += '<select class="form-control" id="vch_currency-'+id+'" name="MasterNewJobvoucher[detail]['+id+'][vch_currency]">';
					item += '<option value="IDR">IDR</option>';
					item += '<option value="USD">USD</option>';
				item += '</select>';
			item += '</div>';
			item += '<div class="col-5 pl-0">';
				item += '<input type="text" class="form-control" id="vch_amount-'+id+'" value="" name="MasterNewJobvoucher[detail]['+id+'][vch_amount]" required>';
			item += '</div>';
		item += '</div>';
		
		item += '<div class="row mb-1">';
			item += '<label class="col-2">No Faktur</label>';
			item += '<span class="col-9">';
				item += '<div style="width:70px;display:inline-block">';
					item += '<input type="text" class="form-control" id="vch_faktur1-'+id+'" maxlength="3" value="" name="MasterNewJobvoucher[detail]['+id+'][vch_faktur1]" required>';
				item += '</div>&nbsp;.&nbsp;';
				item += '<div style="width:70px;display:inline-block">';
					item += '<input type="text" class="form-control" id="vch_faktur2-'+id+'" maxlength="3" value="" name="MasterNewJobvoucher[detail]['+id+'][vch_faktur2]" required>';
				item += '</div>&nbsp;-&nbsp;';
				item += '<div style="width:70px;display:inline-block">';
					item += '<input type="text" class="form-control" id="vch_faktur3-'+id+'" maxlength="2" value="" name="MasterNewJobvoucher[detail]['+id+'][vch_faktur3]" required>';
				item += '</div>&nbsp;.&nbsp;';
				item += '<div style="width:100px;display:inline-block">';
					item += '<input type="text" class="form-control" id="vch_faktur4-'+id+'" maxlength="8" value="" name="MasterNewJobvoucher[detail]['+id+'][vch_faktur4]" required>';
				item += '</div>';
			item += '</span>';
		item += '</div>';
		
		item += '<div class="row mb-2">';
			item += '<div class="col-2">';
				item += '<div class="form-check form-check-inline col-md-12">';
					item += '<input type="checkbox" class="form-check-input vch_pph_multi" id="vch_with_pph-'+id+'" name="MasterNewJobvoucher[detail]['+id+'][vch_ck_pph]">';
					item += '<label class="form-check-label" for="vch_with_pph-'+id+'">With PPH</label>';
				item += '</div>';
			item += '</div>';
		item += '</div>';
		
		item += '<div id="div_pph-'+id+'" style="display:none">';
			item += '<div class="row mb-1">';
				item += '<label class="col-2">Tgl. PPH</label>';
				item += '<div class="col-4">';
					item += '<input type="date" class="form-control" id="vch_date_pph-'+id+'" value="<?= date('Y-m-d') ?>" name="MasterNewJobvoucher[detail]['+id+'][vch_date_pph]">';
				item += '</div>';
			item += '</div>';
			
			item += '<div class="row mb-1">';
				item += '<label class="col-2">Nomor PPH</label>';
				item += '<div class="col-6">';
					item += '<input type="text" class="form-control" id="vch_nomor_pph-'+id+'" value="" name="MasterNewJobvoucher[detail]['+id+'][vch_nomor_pph]">';
				item += '</div>';
			item += '</div>';
			
			item += '<div class="row mb-1">';
				item += '<label class="col-2">Amount PPH</label>';
				item += '<div class="col-6">';
					item += '<input type="text" class="form-control" id="vch_amount_pph-'+id+'" value="" name="MasterNewJobvoucher[detail]['+id+'][vch_amount_pph]">';
				item += '</div>';
			item += '</div>';
		item += '</div>';
		
		item += '<hr>';
		
		$('#div_multiple_ar').append(item);
		
		$('.vch_mode_multi').on('click', function(){
			id = $(this).attr('id');
			idx = id.split('-')[1];
			
			if($('#vch_mode2-'+idx).is(':checked') == true){
				$('#div_account-'+idx).show();
			}else{
				$('#div_account-'+idx).hide();
			}
		});
		
		$('.vch_pph_multi').on('click', function(){
			id = $(this).attr('id');
			idx = id.split('-')[1];
			
			if($('#vch_with_pph-'+idx).is(':checked') == true){
				$('#div_pph-'+idx).show();
			}else{
				$('#div_pph-'+idx).hide();
				$('#vch_date_pph-'+idx).val('<?= date('Y-m-d') ?>');
				$('#vch_nomor_pph-'+idx).val('');
				$('#vch_amount_pph-'+idx).val('');
			}
		});
	}
	
	function getDetailInvoice(id){
		id_invoice = $('#'+id).val();
		idx = id.split('-')[1];
		
		if(id_invoice !== ''){
			$.ajax({
				url: '<?=Url::base().'/accounting/get-invoice-idt'?>',
				data: {'id': id_invoice},
				dataType: 'json',
				method: 'POST',
				async: 'false'
			}).done(function(result){
				invoice = result.invoice;
				detail = result.detail;
				
				if(invoice){
					$('#vch_id_job-'+idx).val(invoice['inv_job_id']);
					
					item = '';
					item += '<div class="row">';
						item += '<div class="col-12 text-center" style="font-size:16px">';
							item += '<b>JOB INVOICE</b>';
						item += '</div>';
					item += '</div>';
					item += '<div class="row">';
						item += '<label class="col-2">DATE</label>';
						item += '<div class="col-8">';
							item += ': '+result.date_invoice;
						item += '</div>';
					item += '</div>';
					item += '<div class="row">';
						item += '<label class="col-2">CUSTOMER</label>';
						item += '<div class="col-8">';
							item += ': '+result.data_customer['customer_companyname'];
						item += '</div>';
					item += '</div>';
					
					item += '<table class="table table-detail-inv">';
						item += '<thead>';
							item += '<tr>';
								item += '<td width="28%">DESCRIPTION OF CHARGES</td>';
								item += '<td width="16%" class="text-right">BASIS</td>';
								item += '<td width="16%" class="text-right">QUANTITY</td>';
								item += '<td width="16%" class="text-right">RATE</td>';
								item += '<td width="17%" class="text-right">TOTAL</td>';
								item += '<td width="5%">CURR</td>';
							item += '</tr>';
						item += '</thead>';
						
						item += '<tbody>';
							if(detail){
								for(const data of detail)
								{
									item += '</tr>';
										item += '<td>'+data['pos_name']+'</td>';
										item += '<td class="text-right">'+data['total_basis']+' '+data['packages_basis']+'</td>';
										item += '<td class="text-right">'+data['total_qty']+' '+data['packages_qty']+'</td>';
										item += '<td class="text-right">'+data['rate']+'</td>';
										item += '<td class="text-right">'+data['amount']+'</td>';
										item += '<td>IDR</td>';
									item += '</tr>';
								}
							}
							item += '<tr class="total">';
								item += '<td colspan="4" class="text-right">TOTAL</td>';
								item += '<td class="text-right">'+result.total+'</td>';
								item += '<td>IDR</td>';
							item += '</tr>';
							
							item += '<tr class="total">';
								item += '<td colspan="4" class="text-right">PPN</td>';
								item += '<td class="text-right">'+result.total_ppn+'</td>';
								item += '<td>IDR</td>';
							item += '</tr>';
							
							item += '<tr class="total">';
								item += '<td colspan="4" class="text-right">GRANDTOTAL</td>';
								item += '<td class="text-right">'+result.grandtotal+'</td>';
								item += '<td>IDR</td>';
							item += '</tr>';
						item += '</tbody>';
					item += '</table>';
					
					$('#div_ar_invoice-'+idx).html(item);
					$('#div_ar_invoice-'+idx).show();
				}
			});
		}else{
			$('#div_ar_invoice-'+idx).html('');
		}
	}
</script>
