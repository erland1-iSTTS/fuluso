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

<div class="final-index">
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
				<select class="form-control" style="width:100%" id="filter_status">
					<option>Unpaid</option>
					<option>Paid</option>
					<option>All</option>
				</select>
			</div>
		</div>
	</div>

	<div class="row">
		<div style="width:50%;padding-right:10px">
			<div class="row">
				<div class="col-12">
					<table class="table" id="table-invoice" style="font-size:10px">
						<thead class="table-secondary">
							<tr>
								<th width="21%">Job Reference No.</th>
								<th width="15%">DN / CN No.</th>
								<th width="12%" class="text-center">Date</th>
								<th width="20%"class="text-right">Amount</th>
								<th width="20%"class="text-right">PAID</th>
								<th width="12%"class="text-center" >Date</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$ap_voucher = ApVoucher::find()->where(['is_active'=>1])->orderBy(['invoice_date' => SORT_DESC])->all();
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
									<td class="text-center"><?= date_format(date_create($row['invoice_date']), 'd M Y'); ?></td>
									<td class="text-right">IDR <?= number_format($row['amount_idr'],0,'.',','); ?> </td>
									<td class="text-right">
										<?php 
											// if($row['status_bayar'] == 1){
											if(!empty($row['payment_date'])){
												echo 'IDR '.number_format($row['amount_idr'],0,'.',',');
											}else{
												echo '-';
											}
										?>
									</td>
									<td class="text-center">
										<?php 
											if(!empty($row['payment_date'])){
												echo date_format(date_create($row['due_date']), 'd M Y');
											}else{
												echo '-';
											}
										?>
									</td>
								</tr>
							<?php $i++;} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<div style="width:50%;padding-left:10px">
			<div class="row">
				<div class="col-12">
					<table class="table" id="table-invoice" style="font-size:10px">
						<thead class="table-secondary">
							<tr>
								<th colspan="4" class="text-center">COUNTER</th>
								<th width="20%" class="text-right">PAID</th>
								<th width="12%" class="text-center" >Date</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td width="21%">-</td>
								<td width="15%">-</td>
								<td width="12%" class="text-center">-</td>
								<td width="20%" class="text-right">IDR 0.00</td>
								<td class="text-right">IDR 0.00</td>
								<td class="text-center">-</td>
							</tr>
							<tr>
								<td>ID-SINARSURYA</td>
								<td>HMC003850</td>
								<td class="text-center">14 Jan 2022</td>
								<td class="text-right">IDR 5.500.000</td>
								<td class="text-right">IDR 5.500.000</td>
								<td class="text-center">18 Jan 2022</td>
							</tr>
							<tr>
								<td width="21%">-</td>
								<td width="15%">-</td>
								<td width="12%" class="text-center">-</td>
								<td width="20%" class="text-right">IDR 0.00</td>
								<td class="text-right">IDR 0.00</td>
								<td class="text-center">-</td>
							</tr>
							<tr>
								<td width="21%">-</td>
								<td width="15%">-</td>
								<td width="12%" class="text-center">-</td>
								<td width="20%" class="text-right">IDR 0.00</td>
								<td class="text-right">IDR 0.00</td>
								<td class="text-center">-</td>
							</tr>
							<tr>
								<td width="21%">ID-IHS</td>
								<td width="15%">HMC003853</td>
								<td width="12%" class="text-center">15 Jan 2022</td>
								<td width="20%" class="text-right">IDR 11.250.000</td>
								<td class="text-right">IDR 11.250.000</td>
								<td class="text-center">02 Feb 2022</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
