<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use richardfan\widget\JSRegister;
use yii\bootstrap4\Modal;
?>

<style type="text/css">
  /*.container2{
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
  }

  .table>tbody>tr>td, .table>tbody>tr>th, .table>tbody>tr>td>p {
    vertical-align: middle;
	margin: 0px;
  }
 
  .gap{
    padding: 0px 8px 0px 0px;
  }*/
</style>

<style>
	.btn-menu{
		text-decoration: none;
		border: none;
		text-align: left;
		color: #337ab7;
	}
	
	.btn-menu:hover{
		color: #0a58ca;
	}
	
	.btn-menu:focus{
		box-shadow: none;
	}
	
	h2{
		font-size:30px !important;
	}
</style>

<div class="accordion" id="job_billing">
	<div class="card">
		<div class="card-header" id="headingbilling0">
			<div class="row pl-2 pr-2">
				<h2 class="m-0" style="width:100%;background-color:#eee;" data-toggle="collapse" data-target="#collapsebilling0">
					<button class="btn btn-menu" type="button" data-toggle="collapse" data-target="#collapsebilling0">
						Invoice IDT
					</button>
				</h2>
			</div>
		</div>
		
		<div id="collapsebilling0" class="collapse" data-parent="#job_billing">
			<div class="card-body p-3">
				<?php //$this->render('invoice_idt', ['party' => $party]) ?>
				<?= $this->render('invoice_idt') ?>
			</div>
		</div>
	</div>
	
	<div class="card">
		<div class="card-header" id="headingbilling1">
			<div class="row pl-2 pr-2">
				<h2 class="m-0" style="width:100%;background-color:#eee;" data-toggle="collapse" data-target="#collapsebilling1">
					<button class="btn btn-menu" type="button" data-toggle="collapse" data-target="#collapsebilling1">
						Invoice HMC
					</button>
				</h2>
			</div>
		</div>
		
		<div id="collapsebilling1" class="collapse" data-parent="#job_billing">
			<div class="card-body p-3">
				<?php //$this->render('invoice_idt', ['party' => $party]) ?>
				<?= $this->render('invoice_hmc') ?>
			</div>
		</div>
	</div>
	
	<div class="card">
		<div class="card-header" id="headingbilling2">
			<div class="row pl-2 pr-2">
				<h2 class="m-0" style="width:100%;background-color:#eee;" data-toggle="collapse" data-target="#collapsebilling2">
					<button class="btn btn-menu" type="button" data-toggle="collapse" data-target="#collapsebilling2">
						Operational Cost Voucher IDT
					</button>
				</h2>
			</div>
		</div>
		
		<div id="collapsebilling2" class="collapse" data-parent="#job_billing">
			<div class="card-body p-3">
				<?php //$this->render('invoice_idt', ['party' => $party]) ?>
				<?= $this->render('cost_voucher_idt') ?>
			</div>
		</div>
	</div>
	
	<div class="card">
		<div class="card-header" id="headingbilling3">
			<div class="row pl-2 pr-2">
				<h2 class="m-0" style="width:100%;background-color:#eee;" data-toggle="collapse" data-target="#collapsebilling3">
					<button class="btn btn-menu" type="button" data-toggle="collapse" data-target="#collapsebilling3">
						Operational Cost Voucher HMC
					</button>
				</h2>
			</div>
		</div>
		
		<div id="collapsebilling3" class="collapse" data-parent="#job_billing">
			<div class="card-body p-3">
				<?php //$this->render('invoice_idt', ['party' => $party]) ?>
				<?= $this->render('cost_voucher_hmc') ?>
			</div>
		</div>
	</div>
	
	<?= $this->render('modal_create_invoice_idt') ?>
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
  