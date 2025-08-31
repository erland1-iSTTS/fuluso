<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
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
    background-color: transparent;
    border-color: #000000;
    color: #000000;
  }

  .btn-dark{
    background-color: #343a40;
    color: #ffffff;
  }
	
  .float-middle{
    text-align: center;
    /* margin-right: 20px; */
  }

  .table>tbody>tr>td, .table>tbody>tr>th, .table>tbody>tr>td>p {
    vertical-align: middle;
	margin: 0px;
  }
 
  .gap{
    padding: 0px 8px 0px 0px;
  }
</style>

<div class="accordion" id="job_billing">
	<div class="card">
		<div class="card-header" id="headingbilling0">
			<div class="row pl-2 pr-2">
				<h2 class="m-0" style="width:100%;background-color:#eee;" data-toggle="collapse" data-target="#collapsebilling0">
					<button class="btn btn-menu" id="btn-parties" type="button" data-toggle="collapse" data-target="#collapsebilling0">
						Invoice IDT
					</button>
				</h2>
			</div>
		</div>
		
		<div id="collapsebilling0" class="collapse" data-parent="#job_billing">
			<div class="card-body p-3">
				<hr>
				<div class="container2">
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
				<div class="container"><a class="btn btn-dark">Create Invoice</a></div><br>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="createinvidtmodal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  <div class="modal-dialog modal-lg modal-dialog-centered" role="document"  style="width:100%">
		<div class="modal-content" style="width:100%">
		  <div class="modal-header">
			<h5 class="modal-title" id="modal-invoice-title">Create Invoice IDT</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body" id="modal-invoice-body">
			<!-- <img src = "images/billing-idt-create.png" style="width:100%"> -->
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary">Save</button>
		  </div>
		</div>
	  </div>
	</div>
	<div class="modal fade" id="createcostidtmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document"  style="width:1000px">
		<div class="modal-content" style="width:1000px">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Create Cost Voucher</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<!-- <img src = "images/billing-voucher-idt-create.png" style="width:100%"> -->
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary">Save</button>
		  </div>
		</div>
	  </div>
	</div>

<?php
	Modal::begin([
		'title' => 'Create Invoice IDT',
		'id' => 'createinvidtmodal',
		'size' => 'modal-lg',
	]);
?>
	<div id="content">
		
	</div>
<?php Modal::end(); ?>

<script type="text/javascript">
	function hideshowidtcostlist() {
		if (document.getElementById('billing-idt-cost-list').style.display=="none") {
		  document.getElementById('billing-idt-cost-list').style.display = "block";
		  document.getElementById('billing-idt-cost-button').style.display = "block";
		} else {
		  document.getElementById('billing-idt-cost-list').style.display = "none";
		  document.getElementById('billing-idt-cost-button').style.display = "none";
		}
	}

	function showidtview() {
		document.getElementById('billing-idt-list').style.display = "none";
		document.getElementById('billing-idt-view').style.display = "block";
	}

	function showidtlist() {
		document.getElementById('billing-idt-list').style.display = "block";
		document.getElementById('billing-idt-view').style.display = "none";
	}

	function hidetable() {
		if($("#bil_table").is(":hidden"))
		  $("#bil_table").show();
		else
		  $("#bil_table").hide();
	}

	function hidetableHMC() {
		if($("#hmc_table").is(":hidden"))
		  $("#hmc_table").show();
		else
		  $("#hmc_table").hide();
	}

	function hidetable2() {
		if($("#cost_table2").is(":hidden"))
		  $("#cost_table2").show();
		else
		  $("#cost_table2").hide();
	}

	function hidetableHMC2() {
		if($("#hmc_table2").is(":hidden"))
		  $("#hmc_table2").show();
		else
		  $("#hmc_table2").hide();
	}

	function showModalInv()
	{
		console.log('testt');
		$("#content").load("jobbilling2.php");
		// $("#modal-invoice-title").load("jobbilling.php #modal-invoice-title");
		// $("#modal-invoice-body").load("jobbilling.php #modal-invoice-body");
	}

	function showModalInvHMC()
	{
		$("#modal-invoice-title").load("jobbilling.php #modal-invoicehmc-title");
		$("#modal-invoice-body").load("jobbilling.php #modal-invoicehmc-body");
	}
</script>
	
	<div class="card">
		<div class="card-header" id="headingbilling1">
			<div class="row pl-2 pr-2">
				<h2 class="m-0" style="width:100%;background-color:#eee;" data-toggle="collapse" data-target="#collapsebilling1">
					<button class="btn btn-menu" id="btn-parties" type="button" data-toggle="collapse" data-target="#collapsebilling1">
						Invoice HMC
					</button>
				</h2>
			</div>
		</div>
		
		<div id="collapsebilling1" class="collapse" data-parent="#job_billing">
			<div class="card-body p-3">
				<hr>
				<div class="container2">
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
						<td scope="row">HMC004698</td>
						<td>5 Mar 2022</td>
						<td>PT THE MASTER STEEL MANUFACTORY</td>
						<td><p class="text-right">1,500 USD</p></td>
						<td class="text-right"><a class="btn btn-clear btn-xs">View Invoice</a></td>
						<td><a class="btn btn-clear btn-xs">View Cost</a></td>
						<td>
						   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
						   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
						   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
						</td>
					  </tr>
					  <tr>
						<td scope="row">HMC004699</td>
						<td>4 Mar 2022</td>
						<td>AHASEES GENERAL TRADING LLC</td>
						<td><p class="text-right">800 USD</p></td>
						<td class="text-right"><a class="btn btn-clear btn-xs">View Invoice</a></td>
						<td><a class="btn btn-clear btn-xs">View Cost</a></td>
						<td>
						   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
						   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
						   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
						</td>
					  </tr>
					  <tr>
						<td scope="row">HMC004688</td>
						<td>3 Mar 2022</td>
						<td>LAMBERTI BROS (WHOLESALE) PTY LTD.</td>
						<td><p class="text-right">2,770 USD</p></td>
						<td class="text-right"><a class="btn btn-clear btn-xs" onclick="hidetableHMC();">View Invoice</a></td>
						<td><a class="btn btn-clear btn-xs">View Cost</a></td>
						<td>
						   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
						   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
						   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
						</td>
					  </tr>

					  <tr style="display:none" class="bg-gray" id="hmc_table">
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
								<td><p class="text-right">1,500 USD</p></td>
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
								<td><p class="text-right">2,770 USD</p></td>
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
								<td><p class="text-right">800 USD</p></td>
								<td>
								   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
								   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
								   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
								</td>
							  </tr>
							</tbody>
						  </table>
						</div><br>
						<div class="text-right"><a class="btn btn-dark" onclick="showModalInvHMC()" data-toggle="modal" data-target="#createinvidtmodal">Create Cost Voucher</a></div>
						</td>
					  </tr>

					  <tr class="bg-light-red">
						<td scope="row">HMC004682</td>
						<td>2 Mar 2022</td>
						<td>SL FRAZER ENTERPRISES PTY LTD.</td>
						<td><p class="text-right">720 USD</p></td>
						<td class="text-right"><a class="btn btn-clear btn-xs">View Invoice</a></td>
						<td><a class="btn btn-clear btn-xs">View Cost</a></td>
						<td>
						   <span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
						   <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
						   <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
						</td>
					  </tr>
					  <tr class="bg-light-red">
						<td scope="row">HMC004687</td>
						<td>1 Mar 2022</td>
						<td>PLATINUM RP PTY LTD.</td>
						<td><p class="text-right">16,800 USD</p></td>
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
				<div class="container"><a class="btn btn-dark">Create Invoice</a></div><br>
				
			</div>
		</div>
	</div>
	
	<div class="card">
		<div class="card-header" id="headingbilling2">
			<div class="row pl-2 pr-2">
				<h2 class="m-0" style="width:100%;background-color:#eee;" data-toggle="collapse" data-target="#collapsebilling2">
					<button class="btn btn-menu" id="btn-parties" type="button" data-toggle="collapse" data-target="#collapsebilling2">
						Operational Cost Voucher IDT
					</button>
				</h2>
			</div>
		</div>
		
		<div id="collapsebilling2" class="collapse" data-parent="#job_billing">
			<div class="card-body p-3">
				<hr>
				<div class="container2">
				  <table class="table">
					<thead class="bg-secondary2">
					  <tr>
						<th>Voucher No</th>
						<th>Created Date</th>
						<th>Transaction Date</th>
						<th>Source</th>
						<th>Tipe</th>
						<th>Method</th>
						<th class="float-middle">Amount</th>
						<th></th>
					  </tr>
					</thead>
					<tbody>
					  <tr>
						<td scope="row">VOR 09705</td>
						<td>5 Mar 2022</td>
						<td>5 Mar 2022</td>
						<td>Kas</td>
						<td>Pokok</td>
						<td>Kas</td>
						<td><p class="text-right">500,000 IDR</p></td>
						<td>
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
						    <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
						    <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
						</td>
					  </tr>
					  <tr>
						<td scope="row">VOR 09704</td>
						<td>4 Mar 2022</td>
						<td>4 Mar 2022</td>
						<td>Kas</td>
						<td>Pokok</td>
						<td>Kas</td>
						<td><p class="text-right">800,000 IDR</p></td>
						<td>
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
						    <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
						    <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
						</td>
					  </tr>
					  <tr onclick="hidetable2();">
						<td scope="row">VOR 09703</td>
						<td>3 Mar 2022</td>
						<td>3 Mar 2022</td>
						<td>B1838R</td>
						<td>Variable</td>
						<td>Transfer</td>
						<td><p class="text-right">770,000 IDR</p></td>
						<td>
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
						    <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
						    <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
						</td>
					  </tr>

					  <tr style="display:none" class="bg-gray" id="cost_table2">
						<td colspan="2"></td>
						<td colspan="6">
						<div style="border: 1px solid black;">
						  <table class="table" style="vertical-align: center;">
							<thead  class="bg-secondary2">
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
						</div>
						</td>
					  </tr>

					  <tr>
						<td scope="row">VOR 09702</td>
						<td>2 Mar 2022</td>
						<td>2 Mar 2022</td>
						<td>Kas</td>
						<td>Variable</td>
						<td>Cash</td>
						<td><p class="text-right">320,000 IDR</p></td>
						<td>
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
						    <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
						    <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
						</td>
					  </tr>
					  <tr>
						<td scope="row">VOR 09701</td>
						<td>1 Mar 2022</td>
						<td>1 Mar 2022</td>
						<td>Kas</td>
						<td>Variable</td>
						<td>Transfer</td>
						<td><p class="text-right">800,000 IDR</p></td>
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
				<div class="container"><a class="btn btn-dark">Create Cost Voucher</a></div><br>
				
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="createoprcostmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document"  style="width:700px">
		<div class="modal-content" style="width:700px">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Create Operational Cost Voucher IDT</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<!--<img src = "images/billing-opr-cost-create.png" style="width:100%">-->
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary">Save</button>
		  </div>
		</div>
	  </div>
	</div>

<script type="text/javascript">
	function hideshowoprcostdetail() {
		if (document.getElementById('billing-oprcost-detail').style.display=="none") {
		  document.getElementById('billing-oprcost-detail').style.display = "block";
		} else {
		  document.getElementById('billing-oprcost-detail').style.display = "none";
		}
	}
</script>
	
	<div class="card">
		<div class="card-header" id="headingbilling3">
			<div class="row pl-2 pr-2">
				<h2 class="m-0" style="width:100%;background-color:#eee;" data-toggle="collapse" data-target="#collapsebilling3">
					<button class="btn btn-menu" id="btn-parties" type="button" data-toggle="collapse" data-target="#collapsebilling3">
						Operational Cost Voucher HMC
					</button>
				</h2>
			</div>
		</div>
		
		<div id="collapsebilling3" class="collapse" data-parent="#job_billing">
			<div class="card-body p-3">
				<hr>
				<div class="container2">
				  <table class="table">
					<thead class="bg-secondary2">
					  <tr>
						<th>Voucher No</th>
						<th>Created Date</th>
						<th>Transaction Date</th>
						<th>Source</th>
						<th>Tipe</th>
						<th>Method</th>
						<th class="float-middle">Amount</th>
						<th></th>
					  </tr>
					</thead>
					<tbody>
					  <tr>
						<td scope="row">VOR 09705</td>
						<td>5 Mar 2022</td>
						<td>5 Mar 2022</td>
						<td>Kas</td>
						<td>Pokok</td>
						<td>Kas</td>
						<td><p class="text-right">500 USD</p></td>
						<td>
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
						    <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
						    <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
						</td>
					  </tr>
					  <tr>
						<td scope="row">VOR 09704</td>
						<td>4 Mar 2022</td>
						<td>4 Mar 2022</td>
						<td>Kas</td>
						<td>Pokok</td>
						<td>Kas</td>
						<td><p class="text-right">800 USD</p></td>
						<td>
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
						    <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
						    <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
						</td>
					  </tr>
					  <tr onclick="hidetableHMC2();">
						<td scope="row">VOR 09703</td>
						<td>3 Mar 2022</td>
						<td>3 Mar 2022</td>
						<td>B1838R</td>
						<td>Variable</td>
						<td>Transfer</td>
						<td><p class="text-right">770 USD</p></td>
						<td>
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
						    <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
						    <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
						</td>
					  </tr>

					  <tr style="display:none" class="bg-gray" id="hmc_table2">
						<td colspan="2"></td>
						<td colspan="6">
						<div style="border: 1px solid black;">
						  <table class="table" style="vertical-align: center;">
							<thead  class="bg-secondary2">
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
						</div>
						</td>
					  </tr>

					  <tr>
						<td scope="row">VOR 09702</td>
						<td>2 Mar 2022</td>
						<td>2 Mar 2022</td>
						<td>Kas</td>
						<td>Variable</td>
						<td>Cash</td>
						<td><p class="text-right">320 USD</p></td>
						<td>
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-pdf.jpg' ?>"/></span>
						    <span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
						    <span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>
						</td>
					  </tr>
					  <tr>
						<td scope="row">VOR 09701</td>
						<td>1 Mar 2022</td>
						<td>1 Mar 2022</td>
						<td>Kas</td>
						<td>Variable</td>
						<td>Transfer</td>
						<td><p class="text-right">800 USD</p></td>
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
				<div class="container"><a class="btn btn-dark">Create Cost Voucher</a></div><br>
				
			</div>
		</div>
	</div>
</div>
  