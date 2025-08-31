<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Customer;
use app\models\MasterNewJobinvoice;
use app\models\MasterNewJobinvoiceDetail;
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
						
						$customer_idt = Customer::find()->where(['customer_id'=>$row['inv_customer'], 'is_active' => 1])->one(); 
					?>
						<tr>
							<td scope="row">IDT004698</td>
							<td><?= date_format(date_create($row['inv_date']), 'd M Y'); ?></td>
							<td><?= $customer_idt->customer_companyname ?></td>
							<td><p class="text-right"><?= number_format($row['inv_total'] ,0,'.',','); ?> IDR</p></td>
							<td class="text-right">
								<a class="btn btn-clear btn-xs" onclick="editCost(<?= $row['inv_id'] ?>)">View Invoice</a>
							</td>
							<td><a class="btn btn-clear btn-xs" id="cost-<?= $i ?>" onclick="showCost(<?= $i ?>)">View Cost</a></td>
							<td>
								<a href="<?= Url::base() ?>/job/print-inv?id=<?= $_GET['id']?>&inv_id=<?= $row['inv_id'] ?>" target="_blank" class="gap">
									<img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/>
								</a>
								<span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
								<span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
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
											<a href="<?= Url::base() ?>/job/print-cost?id=<?= $_GET['id']?>" target="_blank" class="gap">
												<img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/>
											</a>
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
	<hr>
</div>

<script>
	$(document).ready(function(){
	});
	
	$('#btn_create_cost_voucher_idt').on('click', function(){
		$('#cost_voucher_idt').modal({backdrop: 'static', keyboard: false});
		$('#cost_voucher_idt').show();
	});
</script>

	<!--<div class="container2">
	  <table class="table" style="vertical-align: center;">
		<thead class="bg-secondary2">
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
		  <tr>
			<td scope="row">IDT004698</td>
			<td>5 Mar 2022</td>
			<td>PT THE MASTER STEEL MANUFACTORY</td>
			<td><p class="text-right">1,500,000 IDR</p></td>
			<td class="text-right"><a class="btn btn-clear btn-xs">View Invoice</a></td>
			<td><a class="btn btn-clear btn-xs">View Cost</a></td>
			<td>
			  <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
			  <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
			  <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
			</td>
		  </tr>
		  <tr>
			<td scope="row">IDT004699</td>
			<td>4 Mar 2022</td>
			<td>AHASEES GENERAL TRADING LLC</td>
			<td><p class="text-right">800,000 IDR</p></td>
			<td class="text-right"><a class="btn btn-clear btn-xs">View Invoice</a></td>
			<td><a class="btn btn-clear btn-xs">View Cost</a></td>
			<td>
			  <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
			  <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
			  <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
			</td>
		  </tr>
		  <tr>
			<td scope="row">IDT004688</td>
			<td>3 Mar 2022</td>
			<td>LAMBERTI BROS (WHOLESALE) PTY LTD.</td>
			<td><p class="text-right">2,770,000 IDR</p></td>
			<td class="text-right"><a class="btn btn-clear btn-xs" onclick="hidetable();">View Invoice</a></td>
			<td><a class="btn btn-clear btn-xs">View Cost</a></td>
			<td>
			  <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
			  <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
			  <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
			</td>
		  </tr>
		  
		  <tr style="display:none" class="bg-gray" id="bil_table">
			<td colspan="2"></td>
			<td colspan="5">
			<div style="border: 1px solid black;">
			  <table class="table" style="vertical-align: center;">
				<thead class="bg-secondary2">
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
					<td scope="row">VPI220585</td>
					<td>5 Mar 2022</td>
					<td>PT MITRA PRODIN</td>
					<td>MSC</td>
					<td><p class="text-right">1,500,000 IDR</p></td>
					<td>
					  <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
					  <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
					  <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
					</td>
				  </tr>
				  <tr class="bg-white">
					<td scope="row">VPI220489</td>
					<td>4 Mar 2022</td>
					<td>PT. GLOBAL ABADI JAYA</td>
					<td>MSC</td>
					<td><p class="text-right">2,770,000 IDR</p></td>
					<td>
					  <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
					  <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
					  <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
					</td>
				  </tr>
				  <tr class="bg-white">
					<td scope="row">VPI220789</td>
					<td>3 Mar 2022</td>
					<td>PT. CAHAYA TERANG</td>
					<td>ACH</td>
					<td><p class="text-right">800,000 IDR</p></td>
					<td>
						<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
						<span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
						<span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
					</td>
				  </tr>
				</tbody>
			  </table>
			</div><br>
			<div class="text-right"><a class="btn btn-dark" onclick="showModalInv()" data-toggle="modal" data-target="#createinvidtmodal">Create Cost Voucher</a></div>
			</td>
		  </tr>

		  <tr class="bg-light-red">
			<td scope="row">IDT004682</td>
			<td>2 Mar 2022</td>
			<td>SL FRAZER ENTERPRISES PTY LTD.</td>
			<td><p class="text-right">720,000 IDR</p></td>
			<td class="text-right"><a class="btn btn-clear btn-xs">View Invoice</a></td>
			<td><a class="btn btn-clear btn-xs">View Cost</a></td>
			<td>
			   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
			   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
			   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
			</td>
		  </tr>
		  <tr class="bg-light-red">
			<td scope="row">IDT004687</td>
			<td>1 Mar 2022</td>
			<td>PLATINUM RP PTY LTD.</td>
			<td><p class="text-right">16,800,000 IDR</p></td>
			<td class="text-right"><a class="btn btn-clear btn-xs">View Invoice</a></td>
			<td><a class="btn btn-clear btn-xs">View Cost</a></td>
			<td>
			   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
			   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
			   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
			</td>
		  </tr>
		</tbody>
	  </table>
	</div>
				
	<hr>
	<div class="container"><a class="btn btn-dark">Create Invoice</a></div><br>-->