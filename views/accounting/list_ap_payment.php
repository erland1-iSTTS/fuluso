<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Customer;
use app\models\ApVoucher;
use app\models\MasterNewJob;
use app\models\MasterG3eJobrouting;
use app\models\MasterPortfolioAccount;

$account = MasterPortfolioAccount::find()->where(['flag'=>1])->orderBy(['accountname'=>SORT_ASC])->all();

date_default_timezone_set('Asia/Jakarta');
?>

<style>
	.selection{
		font-size: 10px !important;
	}
</style>

<div id="ap-voucher-payment-index">
	<div class="row">
		<div class="ml-3 mt-2">
			Due Date : 
		</div>
		<div class="col-2">
			<div class="form-group">
				<select class="form-control" style="width:100%" id="filter_date">
					<option>Today</option>
					<option>Tomorrow</option>
					<option>Next 3 days</option>
					<option>Next 7 days</option>
					<option>Next 14 days</option>
					<option>Next 30 days</option>
				</select>
			</div>
		</div>
		<div class="col-1 pl-0 pr-0">	
			<div class="form-group">
				<select class="form-control" style="width:100%" id="filter_status">
					<option>Unpaid</option>
					<option>Paid</option>
					<option>All</option>
				</select>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-12">
			<table class="table" id="table-invoice-idt" style="font-size:10px">
				<thead class="table-secondary">
					<tr>
						<th width="6%">Job No</th>
						<th width="7%">MBL</th>
						<th width="8%">Pay For(Customer)</th>
						<th width="8%">Payee</th>
						<th width="8%">Invoice No</th>
						<th width="7%">Invoice Date</th>
						<th width="7%">Due Date</th>
						<th width="8%" class="text-right">DPP</th>
						<th width="8%" class="text-right">PPN</th>
						<th width="8%" class="text-right">PPH</th>
						<th width="8%" class="text-right">Amount</th>
						<th width="17%">Payment Account & Status</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$ap_voucher = ApVoucher::find()->where(['is_active'=>1])->orderBy(['voucher_name' => SORT_DESC])->all();
						$i = 0;
						foreach($ap_voucher as $row){
							
						$job = MasterNewJob::find()->where(['id'=>$row['id_job']])->one();
						$job_no = substr($job->job_name, 3, 25);
						
						$reference = MasterG3eJobrouting::find()->where(['jr_job_id'=>$row['id_job']])->one();
						if($reference){
							$mbl = $reference->jr_mbl;
						}else{
							$mbl = '-';
						}
							
						$pay_for = Customer::find()->where(['customer_id'=>$row['id_pay_for'], 'is_active' => 1])->one(); 
						$pay_to = Customer::find()->where(['customer_id'=>$row['id_pay_to'], 'is_active' => 1])->one(); 
					?>
						<tr>
							<td><?= $job_no ?></td>
							<td><?= strtoupper($mbl) ?></td>
							<td><?= $pay_for->customer_nickname ?></td>
							<td><?= $pay_to->customer_nickname ?></td>
							<td><?= $row['invoice_no'] ?></td>
							<td><?= date_format(date_create($row['invoice_date']), 'd M Y'); ?></td>
							<td><?= date_format(date_create($row['due_date']), 'd M Y'); ?></td>
							<td><p class="text-right"><?= number_format($row['dpp'],0,'.',','); ?></p></td>
							<td class="text-right">
								<?php
									if(empty($row['ppn'])){
										echo '-';
									}else{
										echo number_format($row['ppn'],0,'.',',');
									}
								?>
							</td>
							<td class="text-right" style="color:#dc3545">
								<?php
									if(empty($row['pph'])){
										echo '-';
									}else{
										echo number_format($row['pph'],0,'.',',');
									}
								?>
							</td>
							<td><p class="text-right"><?= number_format($row['amount_idr'],0,'.',','); ?> IDR</p></td>
							<td>
								<div class="row">
									<div class="col-6 pr-1">
										<?php if($row['status_bayar'] == 1){
											$bank = MasterPortfolioAccount::find()->where(['id'=>$row['id_portfolio_account'], 'flag'=>1])->one();
											
											if(isset($bank)){
												echo $bank->name;
											}else{
												echo '-';
											}
										}else{ ?>
											<select class="form-control account" id="account_bank-<?= $row['id'] ?>" style="font-size:9.5px">
												<?php
													foreach($account as $ac){
														echo '<option value="'.$ac['id'].'">'.
															$ac['name'].' - '.$ac['accountno'].
														'</option>';
													}
												?>
											</select>
										<?php } ?>
									</div>
									<div class="col-6 p-0">
										<?php if($row['status_bayar'] == 1){
											echo '<span style="color:#20cc20">PAID On '.date_format(date_create($row['payment_date']), 'd M Y').'</span>';
										}else{ ?>
											<button type="button" class="btn btn-dark" style="font-size:9.5px;padding-top:10px;padding-bottom:10px" onclick="update_payment(<?= $row['id'] ?>)">Mark as Paid</button>
										<?php } ?>
									</div>
								</div>
							</td>
						</tr>
					<?php $i++;} ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		//After ajax update_payment() n page reload div ap_voucher_payment active (use session -> to check page reaload done)
		/*if(sessionStorage.reloadAfterPageLoad == '1'){
			$('#collapse_acc1').removeClass('show');
			$('#collapse_acc2').addClass('show');
			sessionStorage.reloadAfterPageLoad = '0';
		}else{;
			$('#collapse_acc1').addClass('show');
			$('#collapse_acc2').removeClass('show');
		}*/
	});
	
	function update_payment(id){
		id_account = $('#account_bank-'+id).val();
		
		$.ajax({
			type: 'POST',
			data: {'id':id, 'id_account':id_account},
			url: '<?= Url::base()?>/accounting/update-ap-payment',
			dataType: 'json',
			async: true,
			success: function(result){
				if(result.success){
					console.log(result.message);
					
					sessionStorage.reloadAfterPageLoad = '1';
					window.location.reload();
				}else{
					console.log(result.message);
				}
			},
		});
	}
</script>
