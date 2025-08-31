<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Customer;
use app\models\MasterNewJobinvoice;
use app\models\MasterNewJobinvoiceDetail;
use yii\helpers\VarDumper;
?>

<div id="index-invoice-hmc">
	<hr>
	<div class="row">
		<div class="col-12">
			<table class="table" id="table-invoice-hmc" style="font-size:12px">
				<thead class="table-secondary">
					<tr>
						<th width="8%">Invoice No</th>
						<th width="8%">Date</th>
						<th width="8%">Due Date</th>
						<th width="18%">Customer</th>
						<th width="18%">To</th>
						<th width="11%">Notes</th>
						<th width="5%" class="text-center">Type</th>
						<th width="10%" class="text-right">Amount</th>
						<th width="16%"></th>
					</tr>
				</thead>
				<tbody>
					<?php
						$invoice_hmc = MasterNewJobinvoice::find()->where(['inv_job_id' => $_GET['id'], 'inv_currency' => 'USD', 'inv_is_active' => 1])->orderBy(['inv_count'=>SORT_DESC])->all();
						$i = 0;
						foreach($invoice_hmc as $row){
						
						$customer_hmc = Customer::find()->where(['customer_id'=>$row['inv_customer'], 'is_active' => 1])->one(); 
						$to_hmc = Customer::find()->where(['customer_id'=>$row['inv_to'], 'is_active' => 1])->one(); 
					?>
						<tr>
							<td><?= 'HMC'.str_pad($row['inv_count'],6,'0',STR_PAD_LEFT) ?></td>
							<td><?= date_format(date_create($row['inv_date']), 'd M Y'); ?></td>
							<td><?= date_format(date_create($row['inv_due_date']), 'd M Y'); ?></td>
							<td><?= $customer_hmc->customer_companyname ?></td>
							<td><?= $to_hmc->customer_companyname ?></td>
							<td><?= $row['additional_notes'] ?></td>
							<td class="text-center"><?= $row['inv_type'] == 4 ? 'Breakdown' : 'Short' ?></td>
							<td class="text-right"><?= number_format($row['inv_grandtotal'] ,0,'.',','); ?> USD</td>
							<td class="text-center">
								<a class="btn" onclick="deleteInvoiceHmc(<?= $row['inv_id'] ?>)" title="Delete"><i class="fa fa-trash"></i></a>
								<?php if($row['inv_type'] == 4){ ?>
							
								<!--<a class="btn btn-clear btn-xs" onclick="editInvoiceHmcBk(<?= $row['inv_id'] ?>)" title="Edit">Edit Invoice</a>-->
								<a href="<?= Url::base() ?>/job/print-invoice-hmc-bk?id_job=<?= $_GET['id']?>&id_invoice=<?= $row['inv_id'] ?>" target="_blank" class="btn btn-xs" title="PDF">
									<i class="fa fa-file-pdf-o" style="font-size:20px"></i>
									<!--<img width="20" height="22" src="<?php //Url::base().'/img/icon-pdf.jpg' ?>"/>-->
								</a>
								<!--<span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
								<span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>-->
								
								<?php }else{ ?>
								
								<!--<a class="btn btn-clear btn-xs" onclick="editInvoiceHmc(<?= $row['inv_id'] ?>)" title="Edit">Edit Invoice</a>-->
								<a href="<?= Url::base() ?>/job/print-invoice-hmc?id_job=<?= $_GET['id']?>&id_invoice=<?= $row['inv_id'] ?>" target="_blank" class="btn btn-xs" title="PDF">
									<i class="fa fa-file-pdf-o" style="font-size:20px"></i>
									<!--<img width="20" height="22" src="<?php //Url::base().'/img/icon-pdf.jpg' ?>"/>-->
								</a>
								<!--<span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
								<span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>-->
								
								<?php }?>
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
