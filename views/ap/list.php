<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Customer;
use app\models\ApVoucher;
use app\models\MasterNewJob;
use app\models\MasterPortfolioAccount;

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
		<div class="col-1 pl-0 pr-0">	
			<div class="form-group">
				<select class="form-control" style="width:100%" id="filter_currency">
					<option>IDT</option>
					<option>HMC</option>
					<option>RC</option>
					<option>Other</option>
				</select>
			</div>
		</div>	
		<div class="col-2">
			<div class="form-group">
				<select class="form-control" style="width:100%" id="filter_voucher_status">
					<option>All Vouchers</option>
					<option>Unpaid Vouchers</option>
					<option>Paid Vouchers</option>
				</select>
			</div>
		</div>
		<div class="col-7">
			<button type="button" class="btn btn-dark float-right" id="btn_create_ap">Create AP Voucher</button>
		</div>
	</div>
	
	<div class="row">
		<div class="col-12">
			<table class="table" id="table-invoice-idt" style="font-size:10px">
				<thead class="table-secondary">
					<tr>
						<th width="10%">Voucher No</th>
						<th width="8%">Date</th>
						<th width="10%">Pay For</th>
						<th width="8%">Payee</th>
						<th width="12%" class="text-right">DPP</th>
						<th width="8%" class="text-right">PPN</th>
						<th width="10%" class="text-right">PPH</th>
						<th width="12%" class="text-right">Amount</th>
						<th width="5%" class="text-center">Type</th>
						<th width="9%" class="text-center">Account</th>
						<th width="8%"></th>
					</tr>
				</thead>
				<tbody>
					<?php
						$ap_voucher = ApVoucher::find()->where(['is_active'=>1])->orderBy(['voucher_number' => SORT_DESC])->all();
						$i = 0;
						foreach($ap_voucher as $row){
							$pay_for = Customer::find()->where(['customer_id'=>$row['id_pay_for'], 'is_active' => 1])->one(); 
							$pay_to = Customer::find()->where(['customer_id'=>$row['id_pay_to'], 'is_active' => 1])->one();
							
							if($row['type'] == 'IDT'){
								if(empty($row['dpp'])){
									$dpp = '-';
								}else{
									$dpp = number_format($row['dpp'],0,'.',',').' IDR';
								}
								
								if(empty($row['ppn'])){
									$ppn = '-';
								}else{
									$ppn = number_format($row['ppn'],0,'.',',').' IDR';
								}
								
								if(empty($row['pph'])){
									$pph = '-';
								}else{
									$pph = number_format($row['pph'],0,'.',',').' IDR';
								}
							}else{
								$dpp = '-';
								$ppn = '-';
								$pph = '-';
							}
							
							if($row['type'] == 'IDT'){
								$amount = number_format($row['amount_idr'],0,'.',',').' IDR';
							}
							
							if($row['type'] == 'HMC'){
								//Jk ada amount idr di prioritaskan dulu, jk tdk ada baru amount usd
								if($row['amount_idr'] > 0){
									$amount = number_format($row['amount_idr'],0,'.',',').' IDR';
								}else{
									if($row['amount_usd'] > 0){
										$amount = number_format($row['amount_usd'],0,'.',',').' USD';
									}else{
										$amount = '0 IDR';
									}
								}
							}
							
							if($row['type'] == 'RC' || $row['type'] == 'Other'){
								if($row['currency'] == 'IDR'){
									$amount = number_format($row['amount_idr'],0,'.',',').' IDR';
								}else{
									$amount = number_format($row['amount_usd'],0,'.',',').' USD';
								}
							}
					?>
						<tr>
							<td><?= $row['voucher_name'] ?></td>
							<td><?= date_format(date_create($row['invoice_date']), 'd M Y'); ?></td>
							<td><?= $pay_for->customer_nickname ?></td>
							<td><?= $pay_to->customer_nickname ?></td>
							<td class="text-right"><?= $dpp ?></td>
							<td class="text-right"><?= $ppn ?></td>
							<td class="text-right" style="color:#dc3545"><?= $pph ?></td>
							<td class="text-right"><?= $amount ?></td>
							<td class="text-center"><?= $row['type'] ?></td>
							<td class="text-center">
								<?php
									$account = MasterPortfolioAccount::find()->where(['id'=>$row['id_portfolio_account'], 'flag'=>1])->one();
									
									if(isset($account)){
										echo $account->name;
									}else{
										echo '-';
									}
								?>
							</td>
							<td>
								<span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
								<!--<span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
								<span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>-->
							</td>
						</tr>
						
						<tr style="display:none" class="bg-gray" id="bil_table">
							<td colspan="2"></td>
							<td colspan="5">
								<div class="">
								  <table class="table mb-2">
									<thead class="table-secondary">
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
										<td scope="row">VPI220789</td>
										<td>3 Mar 2022</td>
										<td>PT. CAHAYA TERANG</td>
										<td>ACH</td>
										<td><p class="text-right">800,000 IDR</p></td>
										<td>
											<img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/>
											<span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
											<span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
										</td>
									  </tr>
									</tbody>
								  </table>
								</div>
								<div class="text-right">
									<button type="button" class="btn btn-dark" id="btn_create_cost_voucher_idt">Create Cost Voucher</button>
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
	});
</script>
