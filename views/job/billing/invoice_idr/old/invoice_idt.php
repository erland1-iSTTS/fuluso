<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Customer;
use app\models\MasterNewJobinvoice;
use app\models\MasterNewJobinvoiceDetail;

use app\models\MasterNewJobcost;
use app\models\MasterNewJobcostDetail;
use yii\helpers\VarDumper;
?>

<div id="index-invoice-idt">
	<hr>
	<div class="row">
		<div class="col-12">
			<table class="table" id="table-invoice-idt">
				<thead class="table-secondary">
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
					<?php
						$invoice_idt = MasterNewJobinvoice::find()->where(['inv_job_id' => $_GET['id'], 'inv_is_active' => 1])->all();
						$i = 0;
						foreach($invoice_idt as $row){
						
						$customer_idt = Customer::find()->where(['customer_id'=>$row['inv_to'], 'is_active' => 1])->one(); 
					?>
						<tr>
							<td scope="row"><?= 'IDT'.str_pad($row['inv_count'],6,'0',STR_PAD_LEFT) ?></td>
							<td><?= date_format(date_create($row['inv_date']), 'd M Y'); ?></td>
							<td><?= $customer_idt->customer_companyname ?></td>
							<td><p class="text-right"><?= number_format($row['inv_total'] ,0,'.',','); ?> IDR</p></td>
							<td class="text-right">
								<a class="btn btn-clear btn-xs" onclick="editCost(<?= $row['inv_id'] ?>)">Edit Invoice</a>
							</td>
							<!--<td><a class="btn btn-clear btn-xs" id="cost-<?= $i ?>" onclick="showCost(<?= $i ?>)">View Cost</a></td>-->
							<td>
								<a href="<?= Url::base() ?>/job/print-inv?id=<?= $_GET['id']?>&inv_id=<?= $row['inv_id'] ?>" target="_blank" class="gap">
									<img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/>
								</a>
								<!--<span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
								<span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>-->
							</td>
						</tr>
						
						<?php
							$voucher = MasterNewJobcost::find()->where(['vch_job_id' => $_GET['id'], 'vch_inv_id'=>$row['inv_id']])->one();
							
							if(isset($voucher)){
								$voucher_detail = MasterNewJobcostDetail::find()->where(['invd_jobcost_id' => $voucher->vch_id])->all();
							}
						?>
							<tr style="display:none" class="table_cost_voucher_idt bg-gray">
								<td colspan="2"></td>
								<td colspan="5">
									<div class="">
									  <table class="table mb-2">
										<thead class="table-secondary">
										  <tr>
											<th width="15%">Voucher No</th>
											<th width="15%">Date</th>
											<th width="25%">Payee</th>
											<th width="10%" class="text-right">PPN</th>
											<th width="20%" class="text-right">Amount</th>
											<th width="15%"></th>
										  </tr>
										</thead>
										<tbody>
										<?php 
											if(isset($voucher) && isset($voucher_detail)){
												foreach($voucher_detail as $vou){ 
										?>
										  <tr class="bg-white">
											<td scope="row"><?= 'VPI'.str_pad($vou['invd_count'],'5', '0', STR_PAD_LEFT)?></td>
											<td><?= date_format(date_create($voucher->vch_date), 'd M Y'); ?></td>
											<td><?= $voucher->vch_pay_to ?></td>
											<td class="text-right"><?= number_format($vou['invd_ppn'] ,2,'.',',') ?></td>
											<td class="text-right"><?= number_format($vou['invd_amount'] ,2,'.',',') ?> IDR</td>
											<td>
												<a href="<?= Url::base() ?>/job/print-cost?id=<?= $_GET['id']?>" target="_blank" class="gap">
													<img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/>
												</a>
												<span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
												<span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
											</td>
										  </tr>
										<?php }} ?>
										</tbody>
									  </table>
									</div>
									<div class="text-right">
										<button type="button" class="btn btn-dark" onclick="create_cost_voucher_idt(<?= $row['inv_id'] ?>)">Create Cost Voucher</button>
									</div>
								</td>
							</tr>
					<?php $i++;} ?>
				</tbody>
			</table>
		</div>
	</div>
	<hr>
</div>

<script>
	$(document).ready(function(){
	});
</script>
