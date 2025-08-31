<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>

<style type="text/css">
  .container2{
    padding: 0px 15px;
  }

  .small-text{
    font-size: 11px;
  }

  .bg-secondary2{
    background-color: #bebebe;
  }

  .bg-light-red{
    background-color: #ffeded;
  }

  .bg-gray{
    background-color: #ececec;
  }

  .bg-white{
    background-color: white;
  }

  .btn-clear{
    background-color: none;
    border-color: #000000;
    color: #000000;
  }

  .btn-dark{
    background-color: #343a40;
    color: #ffffff;
  }

  .float-right{
    text-align: right;
    margin-right: 20px;
    vertical-align: middle;
  }

  .float-middle{
    text-align: center;
    /* margin-right: 20px; */
  }

  .table>tbody>tr>td, .table>tbody>tr>th, .table>tbody>tr>td>p {
    vertical-align: middle;
    margin: 0px 0px 0px 0px;
  }

  .gap{
    padding: 0px 8px 0px 0px;
  }
</style>

<div class="accordion" id="arapidrhmc">

	<!--<div class="card">
		<div class="card-header" id="headingbilling1">
			<div class="row pl-2 pr-2">
				<h2 class="m-0" style="width:100%;background-color:#eee;" data-toggle="collapse" data-target="#collapsebilling1">
					<button class="btn btn-menu" id="btn-parties" type="button" data-toggle="collapse" data-target="#collapsebilling1">
						Invoice HMC
					</button>
				</h2>
			</div>
		</div>
		
		<div id="collapsebilling1" class="collapse">
			<div class="card-body p-3">
				
				
			</div>
		</div>
	</div>-->
	
	<div class="card">
		<div class="card-header" id="headingarapidt">
			<div class="row pl-2 pr-2">
				<h2 class="m-0" style="width:100%;background-color:#eee;" data-toggle="collapse" data-target="#collapsearapidt">
					<button class="btn btn-menu" id="btn-parties" type="button" data-toggle="collapse" data-target="#collapsearapidt">
						AR/AP IDT
					</button>
				</h2>
			</div>
		</div>
		
		<div id="collapsearapidt" class="collapse" data-parent="#arapidrhmc">
			<div class="card-body p-3">
				<div class="accordion" id="job_arap">
					
					<div class="card">
						<div class="card-header" id="headingarap0">
							<div class="row pl-2 pr-2">
								<h2 class="m-0" style="width:100%;background-color:#eee;" data-toggle="collapse" data-target="#collapsearap0">
									<button class="btn btn-menu" id="btn-parties" type="button" data-toggle="collapse" data-target="#collapsearap0">
										&emsp;AR/AP Invoice
									</button>
								</h2>
							</div>
						</div>
						
						<div id="collapsearap0" class="collapse" data-parent="#job_arap">
							<div class="card-body p-3">
								<hr>
								<div class="container2">
								  <table class="table">
									<thead class="bg-secondary2">
									  <tr>
										<th width="15%">Invoice No</th>
										<th width="10%">Date</th>
										<th width="35%">To</th>
										<th width="15%" class="float-middle">Amount</th>
										<th width="12%"></th>
										<th width="13%"></th>
									  </tr>
									</thead>
									<tbody>
									  <tr>
										<td scope="row">IDT004698</td>
										<td>5 Mar 2022</td>
										<td>PT THE MASTER STEEL MANUFACTORY</td>
										<td><p class="text-right">1,500,000 IDR</p></td>
										<td>
										   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
										   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
										   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
										</td>
										<td><a class="btn btn-clear btn-xs">Payment</a></td>
									  </tr>
									  <tr>
										<td scope="row">IDT004699</td>
										<td>4 Mar 2022</td>
										<td>AHASEES GENERAL TRADING LLC</td>
										<td><p class="text-right">800,000 IDR</p></td>
										<td>
										   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
										   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
										   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
										</td>
										<td><a class="btn btn-clear btn-xs">Payment</a></td>
									  </tr>
									  <tr>
										<td scope="row">IDT004688</td>
										<td>3 Mar 2022</td>
										<td>LAMBERTI BROS (WHOLESALE) PTY LTD.</td>
										<td><p class="text-right">2,770,000 IDR</p></td>
										<td>
										   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
										   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
										   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
										</td>
										<td><a class="btn btn-clear btn-xs" onclick="hidetab();">Payment</a></td>
									  </tr>

									  <tr style="display:none" class="bg-gray" id="inv_table">
										<td colspan="2"></td>
										<td colspan="4">
										<div style="border: 1px solid black;">
										  <table class="table" style="vertical-align: center;">
											<thead class="bg-secondary2">
											  <tr>
												<th width="15%" class="float-middle">DATE</th>
												<th width="10%" class="float-middle">TYPE</th>
												<th width="10%" class="float-middle">NOMOR</th>
												<th width="15%" class="float-middle">Amount</th>
												<th width="40%" class="float-middle">REMARK</th>
											  </tr>
											</thead>
											<tbody>
											  <tr class="bg-white">
												<td scope="row">1 APRIL 2022</td>
												<td>ARC/BKM</td>
												<td>BKM2204001</td>
												<td><p class="text-right">1,500,000 IDR</p></td>
												<td></td>
											  </tr>
											</tbody>
										  </table>
										</div><br>
										<div class="text-right"><a class="btn btn-dark" data-toggle="modal" onclick="showModalPay()" data-target="#createpaymentidtcostmodal">Create Payment</a></div>
										</td>
									  </tr>

									  <tr class="bg-light-red">
										<td scope="row">IDT004682</td>
										<td>2 Mar 2022</td>
										<td>SL FRAZER ENTERPRISES PTY LTD.</td>
										<td><p class="text-right">720,000 IDR</p></td>
										<td>
										   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
										   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
										   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
										</td>
										<td><a class="btn btn-clear btn-xs">Payment</a></td>
									  </tr>
									  <tr class="bg-light-red">
										<td scope="row">IDT004687</td>
										<td>1 Mar 2022</td>
										<td>PLATINUM RP PTY LTD.</td>
										<td><p class="text-right">16,800,000 IDR</p></td>
										<td>
										   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
										   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
										   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
										</td>
										<td><a class="btn btn-clear btn-xs">Payment</a></td>
									  </tr>
									</tbody>
								  </table>
								</div>
							</div>
						</div>
					</div>
					
<div class="modal fade" id="createpaymentidtcostmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document"  style="width:1000px">
	<div class="modal-content" style="width:1000px">
	  <div class="modal-header">
		<h5 class="modal-title" id="modal-payment-title">Create Invoice Payment</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="modal-body" id="modal-payment-body">
		<!-- <img src = "images/arap-inv-payment.png" style="width:100%"> -->
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		<button type="button" class="btn btn-primary">Save</button>
	  </div>
	</div>
  </div>
</div>
	
 <script type="text/javascript">

  function hideshowidtpaymentlist() {
    if (document.getElementById('arap-idt-payment-list').style.display=="none") {
      document.getElementById('arap-idt-payment-list').style.display = "block";
      document.getElementById('arap-idt-payment-button').style.display = "block";
    } else {
      document.getElementById('arap-idt-payment-list').style.display = "none";
      document.getElementById('arap-idt-payment-button').style.display = "none";
    }
  }

  function hidetab() {
    if($("#inv_table").is(":hidden"))
      $("#inv_table").show();
    else
      $("#inv_table").hide();
  }

  function hidetab2() {
    if($("#cost_table").is(":hidden"))
      $("#cost_table").show();
    else
      $("#cost_table").hide();
  }

  function hidetabHMC() {
    if($("#inv_table_hmc").is(":hidden"))
      $("#inv_table_hmc").show();
    else
      $("#inv_table_hmc").hide();
  }

  function hidetabHMC2() {
    if($("#cost_table_hmc").is(":hidden"))
      $("#cost_table_hmc").show();
    else
      $("#cost_table_hmc").hide();
  }

  function showModalPay()
  {
    $("#modal-payment-title").load("jobarap.php #modal-pay-title");
    $("#modal-payment-body").load("jobarap.php #modal-pay-body");
  }

  function showModalPayHMC()
  {
    $("#modal-paymenthmc-title").load("jobarap.php #modal-pay-title");
    $("#modal-paymenthmc-body").load("jobarap.php #modal-payhmc-body");
  }

  function showModalCost()
  {
    $("#modal-cost-title").load("jobarap.php #modal-cost-title");
    $("#modal-cost-body").load("jobarap.php #modal-cost-body");
  }

  function showModalCostHMC()
  {
    $("#modal-costhmc-title").load("jobarap.php #modal-cost-title");
    $("#modal-costhmc-body").load("jobarap.php #modal-costhmc-body");
  }

  </script>
  
<div class="modal fade" id="createpaymentidtmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document"  style="width:100%">
	<div class="modal-content" style="width:100%">
	  <div class="modal-header">
		<h5 class="modal-title" id="modal-cost-title">Create Cost Payment</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="modal-body" id="modal-cost-body">
		<!-- <img src = "images/arap-cost-payment.png" style="width:100%"> -->
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		<button type="button" class="btn btn-primary">Save</button>
	  </div>
	</div>
  </div>
</div>
					
					<div class="card">
						<div class="card-header" id="headingarap1">
							<div class="row pl-2 pr-2">
								<h2 class="m-0" style="width:100%;background-color:#eee;" data-toggle="collapse" data-target="#collapsearap1">
									<button class="btn btn-menu" id="btn-parties" type="button" data-toggle="collapse" data-target="#collapsearap1">
										&emsp;AR/AP Cost
									</button>
								</h2>
							</div>
						</div>
						
						<div id="collapsearap1" class="collapse" data-parent="#job_arap">
							<div class="card-body p-3">
								<hr>
								<div class="container2">
								  <table class="table">
									<thead class="bg-secondary2">
									  <tr>
										<th>Voucher No</th>
										<th>Date</th>
										<th>Invoice No</th>
										<th>Pay For</th>
										<th>Pay To</th>
										<th class="float-middle">Amount</th>
										<th></th>
										<th></th>
									  </tr>
									</thead>
									<tbody>
									  <tr>
										<td scope="row">VPI220154</td>
										<td>5 Mar 2022</td>
										<td><a>IDT004698</a></td>
										<td>PT MITRA PRODIN</td>
										<td>MSC</td>
										<td><p class="text-right">1,500,000 IDR</p></td>
										<td>
										   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
										   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
										   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
										</td>
										<td><a class="btn btn-clear btn-xs">Payment</a></td>
									  </tr>
									  <tr>
										<td scope="row">VPI220542</td>
										<td>4 Mar 2022</td>
										<td><a>IDT004699</a></td>
										<td>PT. GLOBAL ABADI JAYA</td>
										<td>MSC</td>
										<td><p class="text-right">800,000 IDR</p></td>
										<td>
										   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
										   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
										   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
										</td>
										<td><a class="btn btn-clear btn-xs">Payment</a></td>
									  </tr>
									  <tr>
										<td scope="row">VPI220571</td>
										<td>3 Mar 2022</td>
										<td><a>IDT004688</a></td>
										<td>PT. CAHAYA TERANG</td>
										<td>ACH</td>
										<td><p class="text-right">2,770,000 IDR</p></td>
										<td>
										   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
										   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
										   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
										</td>
										<td><a class="btn btn-clear btn-xs" onclick="hidetab2();">Payment</a></td>
									  </tr>

									  <tr style="display:none" class="bg-gray" id="cost_table">
										<td colspan="2"></td>
										<td colspan="6">
										<div style="border: 1px solid black;">
										  <table class="table" style="vertical-align: center;">
											<thead class="bg-secondary2">
											  <tr>
												<th width="">POS</th>
												<th width="">DETAIL</th>
												<th width="">QTY</th>
												<th width="">UNIT</th>
												<th width="" class="float-middle">AMOUNT</th>
												<th width="" class="float-middle">TOTAL</th>
											  </tr>
											</thead>
											<tbody>
											  <tr class="bg-white">
												<td scope="row">BIA TELKOM</td>
												<td>SPEEDY JK 22-04</td>
												<td>1</td>
												<td>UNIT</td>
												<td><p class="text-right">373.450,00</p></td>
												<td><p class="text-right">373.450,00</p></td>
											  </tr>
											</tbody>
										  </table>
										</div><br>
										<div class="text-right"><a class="btn btn-dark" data-toggle="modal" onclick="showModalCost()" data-target="#createpaymentidtmodal">Create Cost Voucher</a></div>
										</td>
									  </tr>

									  <tr class="bg-light-red">
										<td scope="row">VPI220325</td>
										<td>2 Mar 2022</td>
										<td><a>IDT004672</a></td>
										<td>PT. ANGKUT SEJAHTERA</td>
										<td>PTX</td>
										<td><p class="text-right">720,000 IDR</p></td>
										<td>
										   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
										   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
										   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
										</td>
										<td><a class="btn btn-clear btn-xs">Payment</a></td>
									  </tr>
									  <tr class="bg-light-red">
										<td scope="row">VPI220215</td>
										<td>1 Mar 2022</td>
										<td><a>IDT004678</a></td>
										<td>PT. INDO FAJAR PAGI</td>
										<td>WHL</td>
										<td><p class="text-right">16,800,000 IDR</p></td>
										<td>
										   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
										   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
										   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
										</td>
										<td><a class="btn btn-clear btn-xs">Payment</a></td>
									  </tr>
									</tbody>
								  </table>
								</div>
								
							</div>
						</div>
					</div>

<script type="text/javascript">
  function hideshowoprcostdetailx() {
    if (document.getElementById('arap-oprcost-detail').style.display=="none") {
      document.getElementById('arap-oprcost-detail').style.display = "block";
      document.getElementById('arap-cost-payment-button').style.display = "block";
    } else {
      document.getElementById('arap-oprcost-detail').style.display = "none";
      document.getElementById('arap-cost-payment-button').style.display = "none";
    }
  }
</script>

<script type="text/javascript">
	function showarapcostview() {
		document.getElementById('arap-cost-list').style.display = "none";
		document.getElementById('arap-cost-view').style.display = "block";
	}

	function showarapcostlist() {
		document.getElementById('arap-cost-list').style.display = "block";
		document.getElementById('arap-cost-view').style.display = "none";
	}
</script>


<div class="modal fade" id="createpaymenthmccostmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document"  style="width:1000px">
    <div class="modal-content" style="width:1000px">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-paymenthmc-title">Create Invoice Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal-paymenthmc-body">
        <!-- <img src = "images/arap-inv-payment.png" style="width:100%"> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>				

				</div>
			</div>
		</div>
	</div>
	
<div class="modal fade" id="createpaymenthmcmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document"  style="width:100%">
    <div class="modal-content" style="width:100%">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-costhmc-title">Create Cost Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal-costhmc-body">
        <!-- <img src = "images/arap-cost-payment.png" style="width:100%"> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>	
	
	<div class="card">
		<div class="card-header" id="headingaraphmc">
			<div class="row pl-2 pr-2">
				<h2 class="m-0" style="width:100%;background-color:#eee;" data-toggle="collapse" data-target="#collapsearaphmc">
					<button class="btn btn-menu" id="btn-parties" type="button" data-toggle="collapse" data-target="#collapsearaphmc">
						AR/AP HMC
					</button>
				</h2>
			</div>
		</div>
		
		<div id="collapsearaphmc" class="collapse" data-parent="#arapidrhmc">
			<div class="card-body p-3">
				<div class="accordion" id="job_arap">
					<div class="card">
						<div class="card-header" id="headingarap0">
							<div class="row pl-2 pr-2">
								<h2 class="m-0" style="width:100%;background-color:#eee;" data-toggle="collapse" data-target="#collapsearap3">
									<button class="btn btn-menu" id="btn-parties" type="button" data-toggle="collapse" data-target="#collapsearap3">
										&emsp;AR/AP Invoice
									</button>
								</h2>
							</div>
						</div>
						
						<div id="collapsearap3" class="collapse" data-parent="#job_arap">
							<div class="card-body p-3">
								<hr>
								<div class="container2">
								  <table class="table">
									<thead class="bg-secondary2">
									  <tr>
										<th width="15%">Invoice No</th>
										<th width="10%">Date</th>
										<th width="35%">To</th>
										<th width="15%" class="float-middle">Amount</th>
										<th width="12%"></th>
										<th width="13%"></th>
									  </tr>
									</thead>
									<tbody>
									  <tr>
										<td scope="row">HMC004698</td>
										<td>5 Mar 2022</td>
										<td>PT THE MASTER STEEL MANUFACTORY</td>
										<td><p class="text-right">1,500 USD</p></td>
										<td>
										   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
										   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
										   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
										</td>
										<td><a class="btn btn-clear btn-xs">Payment</a></td>
									  </tr>
									  <tr>
										<td scope="row">HMC004699</td>
										<td>4 Mar 2022</td>
										<td>AHASEES GENERAL TRADING LLC</td>
										<td><p class="text-right">800 USD</p></td>
										<td>
										   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
										   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
										   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
										</td>
										<td><a class="btn btn-clear btn-xs">Payment</a></td>
									  </tr>
									  <tr>
										<td scope="row">HMC004688</td>
										<td>3 Mar 2022</td>
										<td>LAMBERTI BROS (WHOLESALE) PTY LTD.</td>
										<td><p class="text-right">2,770 USD</p></td>
										<td>
										   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
										   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
										   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
										</td>
										<td><a class="btn btn-clear btn-xs" onclick="hidetabHMC();">Payment</a></td>
									  </tr>

									  <tr style="display:none" class="bg-gray" id="inv_table_hmc">
										<td colspan="2"></td>
										<td colspan="4">
										<div style="border: 1px solid black;">
										  <table class="table" style="vertical-align: center;">
											<thead class="bg-secondary2">
											  <tr>
												<th width="15%" class="float-middle">DATE</th>
												<th width="10%" class="float-middle">TYPE</th>
												<th width="10%" class="float-middle">NOMOR</th>
												<th width="15%" class="float-middle">Amount</th>
												<th width="40%" class="float-middle">REMARK</th>
											  </tr>
											</thead>
											<tbody>
											  <tr class="bg-white">
												<td scope="row">1 APRIL 2022</td>
												<td>ARC/BKM</td>
												<td>BKM2204001</td>
												<td><p class="text-right">1,500 USD</p></td>
												<td></td>
											  </tr>
											</tbody>
										  </table>
										</div><br>
										<div class="text-right"><a class="btn btn-dark" data-toggle="modal" onclick="showModalPayHMC()" data-target="#createpaymenthmccostmodal">Create Payment</a></div>
										</td>
									  </tr>

									  <tr class="bg-light-red">
										<td scope="row">HMC004682</td>
										<td>2 Mar 2022</td>
										<td>SL FRAZER ENTERPRISES PTY LTD.</td>
										<td><p class="text-right">720 USD</p></td>
										<td>
										   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
										   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
										   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
										</td>
										<td><a class="btn btn-clear btn-xs">Payment</a></td>
									  </tr>
									  <tr class="bg-light-red">
										<td scope="row">HMC004687</td>
										<td>1 Mar 2022</td>
										<td>PLATINUM RP PTY LTD.</td>
										<td><p class="text-right">16,800 USD</p></td>
										<td>
										   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
										   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
										   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
										</td>
										<td><a class="btn btn-clear btn-xs">Payment</a></td>
									  </tr>
									</tbody>
								  </table>
								</div>
								
							</div>
						</div>
					</div>
					
					
					<div class="card">
						<div class="card-header" id="headingarap0">
							<div class="row pl-2 pr-2">
								<h2 class="m-0" style="width:100%;background-color:#eee;" data-toggle="collapse" data-target="#collapsearap4">
									<button class="btn btn-menu" id="btn-parties" type="button" data-toggle="collapse" data-target="#collapsearap4">
										&emsp;AR/AP Cost
									</button>
								</h2>
							</div>
						</div>
						
						<div id="collapsearap4" class="collapse" data-parent="#job_arap">
							<div class="card-body p-3">
								<hr>
								<div class="container2">
								  <table class="table">
									<thead class="bg-secondary2">
									  <tr>
										<th>Voucher No</th>
										<th>Date</th>
										<th>Invoice No</th>
										<th>Pay For</th>
										<th>Pay To</th>
										<th class="float-middle">Amount</th>
										<th></th>
										<th></th>
									  </tr>
									</thead>
									<tbody>
									  <tr>
										<td scope="row">VPI220154</td>
										<td>5 Mar 2022</td>
										<td><a>HMC004698</a></td>
										<td>PT MITRA PRODIN</td>
										<td>MSC</td>
										<td><p class="text-right">1,500 USD</p></td>
										<td>
										   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
										   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
										   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
										</td>
										<td><a class="btn btn-clear btn-xs">Payment</a></td>
									  </tr>
									  <tr>
										<td scope="row">VPI220542</td>
										<td>4 Mar 2022</td>
										<td><a>HMC004699</a></td>
										<td>PT. GLOBAL ABADI JAYA</td>
										<td>MSC</td>
										<td><p class="text-right">800 USD</p></td>
										<td>
										   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
										   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
										   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
										</td>
										<td><a class="btn btn-clear btn-xs">Payment</a></td>
									  </tr>
									  <tr>
										<td scope="row">VPI220571</td>
										<td>3 Mar 2022</td>
										<td><a>HMC004688</a></td>
										<td>PT. CAHAYA TERANG</td>
										<td>ACH</td>
										<td><p class="text-right">2,770 USD</p></td>
										<td>
										   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
										   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
										   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
										</td>
										<td><a class="btn btn-clear btn-xs" onclick="hidetabHMC2();">Payment</a></td>
									  </tr>

									  <tr style="display:none" class="bg-gray" id="cost_table_hmc">
										<td colspan="2"></td>
										<td colspan="6">
										<div style="border: 1px solid black;">
										  <table class="table" style="vertical-align: center;">
											<thead class="bg-secondary2">
											  <tr>
												<th width="">POS</th>
												<th width="">DETAIL</th>
												<th width="">QTY</th>
												<th width="">UNIT</th>
												<th width="" class="float-middle">AMOUNT</th>
												<th width="" class="float-middle">TOTAL</th>
											  </tr>
											</thead>
											<tbody>
											  <tr class="bg-white">
												<td scope="row">BIA TELKOM</td>
												<td>SPEEDY JK 22-04</td>
												<td>1</td>
												<td>UNIT</td>
												<td><p class="text-right">373 USD</p></td>
												<td><p class="text-right">373 USD</p></td>
											  </tr>
											</tbody>
										  </table>
										</div><br>
										<div class="text-right"><a class="btn btn-dark" data-toggle="modal" onclick="showModalCostHMC()" data-target="#createpaymenthmcmodal">Create Cost Voucher</a></div>
										</td>
									  </tr>

									  <tr class="bg-light-red">
										<td scope="row">VPI220325</td>
										<td>2 Mar 2022</td>
										<td><a>HMC004672</a></td>
										<td>PT. ANGKUT SEJAHTERA</td>
										<td>PTX</td>
										<td><p class="text-right">720 USD</p></td>
										<td>
										   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
										   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
										   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
										</td>
										<td><a class="btn btn-clear btn-xs">Payment</a></td>
									  </tr>
									  <tr class="bg-light-red">
										<td scope="row">VPI220215</td>
										<td>1 Mar 2022</td>
										<td><a>HMC004678</a></td>
										<td>PT. INDO FAJAR PAGI</td>
										<td>WHL</td>
										<td><p class="text-right">16,800 USD</p></td>
										<td>
										   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
										   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
										   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
										</td>
										<td><a class="btn btn-clear btn-xs">Payment</a></td>
									  </tr>
									</tbody>
								  </table>
								</div>
								
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	
</div>
