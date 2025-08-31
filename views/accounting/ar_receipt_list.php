<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\ArReceipt;
use app\models\Customer;
use app\models\MasterNewJob;
use app\models\MasterPortfolioAccount;
use app\models\MasterNewJobinvoice;
use app\models\MasterNewJobinvoiceDetail;

date_default_timezone_set('Asia/Jakarta');
?>

<div id="ap-index">
	<div class="row">
		<div class="col-2">
			<div class="form-group">
				<select class="form-control" style="width:100%" id="filter_date">
					<?php
						for($m=1; $m<=12; $m++){
							if($m ==  date('n')){
								$selected = 'selected';
							}else{
								$selected = '';
							}
							
							$month = date('F', mktime(0,0,0,$m, 1, date('Y')));
							
							echo "<option value='".$m."' ".$selected.">".
								$month.' '.date('Y').
							"</option>";
						}
					?>
				</select>
			</div>
		</div>
		<div class="col-2 pl-0 pr-0">	
			<div class="form-group">
				<select class="form-control" style="width:100%" id="filter_type">
					<option>AR Receipts</option>
					<option>All Invoices</option>
					<option>Unpaid Invoices</option>
					<option>Paid Invoices</option>
				</select>
			</div>
		</div>
		<div class="col-8">
			<button type="button" class="btn btn-dark float-right" id="btn_create_ar">Create AR Receipt</button>
		</div>
	</div>
	
	<div class="row">
		<div class="col-12">
			<table class="table" id="table-invoice-idt" style="font-size:12px">
				<thead class="table-secondary">
					<tr>
						<th width="20%">AR Receipt No</th>
						<th width="15%">Date</th>
						<th width="30%">Customer</th>
						<th width="15%">Account</th>
						<th width="20%" class="text-right">Amount</th>
						<!--<th width="12%"></th>-->
						
						
						<!--<th width="12%">Invoice No</th>
						<th width="10%">Job No</th>
						<th width="10%">Date</th>
						<th width="20%">To</th>
						<th width="15%">Amount</th>
						<th width="10%"></th>-->
					</tr>
				</thead>
				<tbody>
					<?php
						$ar_receipt = ArReceipt::find()->where(['is_active' => 1])->orderBy(['created_at' => SORT_DESC])->all();
						$i = 0;
						foreach($ar_receipt as $row){
							
						$customer_idt = Customer::find()->where(['customer_id'=>$row['id_customer']])->one();
						$account_idt = MasterPortfolioAccount::find()->where(['id'=>$row['id_portfolio_account']])->one();
					?>
						<tr>
							<td><?= 'AR-IDR-'.str_pad($row['ar_count'],'6', '0', STR_PAD_LEFT)?></td>
							<td><?= date_format(date_create($row['payment_date']), 'd M Y'); ?></td>
							<td><?= $customer_idt->customer_companyname ?></td>
							<td><?= $account_idt->accountname ?></td>
							<td><p class="text-right"><?= number_format($row['total_payment'] ,0,'.',','); ?> IDR</p></td>
							<!--<td>
								<span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
								<span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
								<span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
							</td>-->
						</tr>
					<?php $i++;} ?>
				</tbody>
			</table>
		</div>
	</div>
</div>


<script type="text/javascript">
	$(document).ready(function(){
		
	});
</script>
