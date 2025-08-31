<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use yii\widgets\ActiveForm;
use app\models\MasterNewJob;
use app\models\MasterNewJobBooking;
use app\models\MasterVesselRouting;
use app\models\MasterNewJobvoucher;
use app\models\MasterNewJobinvoice;
use yii\helpers\VarDumper;
?>

<style>
	.smalltitle{
		font-size: 9px;
	}
	
	.btn-clear{
		background-color: transparent;
		border-color: #000000;
		color: #000000;
		font-size:12px;
	}
	
	.gap{
		padding: 0px 8px 0px 0px;
	}
</style>

<?php
	if(isset($_GET['id'])){
		$job = MasterNewJob::find()->where(['id'=>$_GET['id']])->one();
		
		$id = $job['job_name'];
		$cus = $job['customer_name'];
		// $from_to = $job['job_from'].', '.$job['job_to'];
		// $vessel = !empty($job['job_ship']) ? $job['job_ship']: '-';
		$hb = !empty($job['job_hb']) ? $job['job_hb'] : '&emsp;-&emsp;';
		$mb = !empty($job['job_mb']) ? $job['job_mb'] : '&emsp;-&emsp;';
		
		//From - To - Vessel
		$job_routing = MasterNewJobBooking::find()->where(['id_job'=>$_GET['id']])->one();
		
		if(isset($job_routing)){
			$vr = MasterVesselRouting::find()->where(['id'=>$job_routing->batch])->one();
			if(isset($vr)){
				$from = $vr->pointstart->point_name;
				$to = $vr->pointend->point_name;
				$ves = $vr->laden_on_board;
			}else{
				$from = '&emsp;-&emsp;';
				$to = '&emsp;-&emsp;';
				$ves = '&emsp;-&emsp;';
			}
		}else{
			$from = '&emsp;-&emsp;';
			$to = '&emsp;-&emsp;';
			$ves = '&emsp;-&emsp;';
		}
	}else{
		$id = '&emsp;-&emsp;';
		$cus = '&emsp;-&emsp;';
		$hb = '&emsp;-&emsp;';
		$mb = '&emsp;-&emsp;';
	}
?>

<div class="overview-panel">
	<div class="row">
		<div class="ml-3">
			<table style="max-width:700px">
				<tr>
					<td>
						<div class="smalltitle">JOB ID</div>
						<span style="font-size:12px"><?= $id ?></span>
						&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
					<td>
						<div class="smalltitle">CUSTOMER</div>
						<span style="font-size:12px"><?= $cus ?></span>
						&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
					<td>
						<div class="smalltitle">FROM & TO</div>
						<span style="font-size:12px" id="job_from_to"><?= $from.' & '.$to ?></span>
						&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
					<td>
						<div class="smalltitle">VESSEL, HB, MB</div>
						<span style="font-size:12px" id="ves"><?= $ves ?></span> /
						<span style="font-size:12px" id="hb"><?= $hb ?></span> /
						<span style="font-size:12px" id="mb"><?= $mb ?></span>
					</td>
				</tr>
			</table>
		</div>
		<div class="ml-auto" style="margin-right:35px;margin-top:5px">
			<!-- Draft -->
			<?php if($jobinfo->step == 1 || empty($jobinfo->step)){ ?>
				<div class="row generate">
					<div style="margin-right:20px">
						<a href="<?= Url::base().'/job/print-draft-bl?id='.$_GET['id'] ?>" target="_blank" style="text-decoration:none;color:black;font-size:12px;">
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>Draft BL
						</a>
					</div>
					<a href="<?= Url::base().'/job/generate-nn-bl?id='.$_GET['id'] ?>" class="btn btn-clear btn-xs" id="generate-nn-bl">Generate NN BL</a>
				</div>
			
			<!-- NN BL -->
			<?php }elseif($jobinfo->step == 2){ ?>
				<div class="row request">
					<div style="margin-right:20px">
						<a href="<?= Url::base().'/job/print-draft-bl?id='.$_GET['id'] ?>" target="_blank" style="text-decoration:none;color:black;font-size:12px;">
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>Draft BL
						</a>
					</div>
					<!--<div style="margin-right:20px">
						<a href="<?= Url::base().'/job/print-nn-bl?id='.$_GET['id'] ?>" target="_blank" style="text-decoration:none;color:black;font-size:12px;">
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>NN BL
						</a>
					</div>-->
					<div style="margin-right:20px">
						<a href="<?= Url::base().'/job/print-nn-bl-logo?id='.$_GET['id'] ?>" target="_blank" style="text-decoration:none;color:black;font-size:12px;">
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>NN BL-Logo
						</a>
					</div>
					<a class="btn btn-clear btn-xs" id="req-origin-bl">Request Original BL</a>
				</div>
			
			<!-- Original BL on request -->
			<?php }elseif($jobinfo->step == 3){ ?>
				<div class="row on-progress">
					<div style="margin-right:20px">
						<a href="<?= Url::base().'/job/print-draft-bl?id='.$_GET['id'] ?>" target="_blank" style="text-decoration:none;color:black;font-size:12px;">
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>Draft BL
						</a>
					</div>
					<!--<div style="margin-right:20px">
						<a href="<?= Url::base().'/job/print-nn-bl?id='.$_GET['id'] ?>" target="_blank" style="text-decoration:none;color:black;font-size:12px;">
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>NN BL
						</a>
					</div>-->
					<div style="margin-right:20px">
						<a href="<?= Url::base().'/job/print-nn-bl-logo?id='.$_GET['id'] ?>" target="_blank" style="text-decoration:none;color:black;font-size:12px;">
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>NN BL-Logo
						</a>
					</div>
					<a href="<?= Url::base().'/job/approve-original-bl?id='.$_GET['id'] ?>" class="btn btn-clear btn-xs" id="origin-on-progress" style="border:none">Original BL : On Request<br><span style="font-size:9px;color:green"><i>( Bypass to Original BL )</i></span></a>
				</div>
			
			<!-- Original BL -->
			<?php }elseif($jobinfo->step == 4){ ?>
				<div class="row views">
					<div style="margin-right:20px">
						<a href="<?= Url::base().'/job/print-draft-bl?id='.$_GET['id'] ?>" target="_blank" style="text-decoration:none;color:black;font-size:12px;">
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>Draft BL
						</a>
					</div>
					<!--<div style="margin-right:20px">
						<a href="<?= Url::base().'/job/print-nn-bl?id='.$_GET['id'] ?>" target="_blank" style="text-decoration:none;color:black;font-size:12px;">
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>NN BL
						</a>
					</div>-->
					<div style="margin-right:20px">
						<a href="<?= Url::base().'/job/print-nn-bl-logo?id='.$_GET['id'] ?>" target="_blank" style="text-decoration:none;color:black;font-size:12px;">
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>NN BL-Logo
						</a>
					</div>
					<div style="margin-right:20px" id="origin-bl">
						<a href="<?= Url::base().'/job/print-ori-bl?id='.$_GET['id'] ?>" target="_blank" style="text-decoration:none;color:black;font-size:12px;">
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>Original BL
						</a>
					</div>
					<a class="btn btn-clear btn-xs" id="req-erc_swb_cr">Request ERC / SWB / CR</a>
				</div>
			
			<!-- Express Release on process -->
			<?php }elseif($jobinfo->step == 5){ ?>
				<div class="row views">
					<div style="margin-right:20px">
						<a href="<?= Url::base().'/job/print-draft-bl?id='.$_GET['id'] ?>" target="_blank" style="text-decoration:none;color:black;font-size:12px;">
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>Draft BL
						</a>
					</div>
					<!--<div style="margin-right:20px">
						<a href="<?= Url::base().'/job/print-nn-bl?id='.$_GET['id'] ?>" target="_blank" style="text-decoration:none;color:black;font-size:12px;">
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>NN BL
						</a>
					</div>-->
					<div style="margin-right:20px">
						<a href="<?= Url::base().'/job/print-nn-bl-logo?id='.$_GET['id'] ?>" target="_blank" style="text-decoration:none;color:black;font-size:12px;">
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>NN BL-Logo
						</a>
					</div>
					<div style="margin-right:20px" id="origin-bl">
						<a href="<?= Url::base().'/job/print-ori-bl?id='.$_GET['id'] ?>" target="_blank" style="text-decoration:none;color:black;font-size:12px;">
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>Original BL
						</a>
					</div>
					<a href="<?= Url::base().'/job/approve-express-release?id='.$_GET['id'] ?>" class="btn btn-clear btn-xs" id="erc-on-process" style="border:none">Express Release : On Process<br><span style="font-size:9px;color:green"><i>( Bypass to Express Release )</i></span></a>
				</div>
			
			<!-- Express Release -->
			<?php }elseif($jobinfo->step == 6){ ?>
				<div class="row views2">
					<div style="margin-right:20px" id="inv-express-release">
						<a href="<?= Url::base().'/job/print-inv-erc?id='.$_GET['id'] ?>" target="_blank" style="text-decoration:none;color:black;font-size:12px;">
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>Invoice Express Release
						</a>
					</div>
					
					<?php 
						$invoice = MasterNewJobinvoice::find()
							->where(['inv_job_id'=>$_GET['id']])
							->andWhere(['inv_is_active'=>1])
							->one();
						
						if(isset($invoice)){
							$payment_check = MasterNewJobvoucher::find()
								->where(['vch_job_id' => $_GET['id']])
								->where(['vch_invoice' => $invoice->inv_id])
								->one();
						}else{
							$payment_check = '';
						}
					?>
					<?php if(isset($payment_check) && !empty($payment_check)){ ?>
						<div style="margin-right:20px" id="express-release">
							<a href="<?= Url::base().'/job/print-erc?id='.$_GET['id'] ?>" target="_blank" style="text-decoration:none;color:black;font-size:12px;">
								<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>Express Release
							</a>
						</div>
					<?php }else{ ?>
						<div style="margin-right:20px" id="express-release">
							<div style="text-decoration:none;color:lightgray;font-size:12px;">
								<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list-gray.jpeg' ?>"/></span>Express Release
							</div>
						</div>
					<?php } ?>
					
				</div>
			
			<!-- Seaway Bill on process -->
			<?php }elseif($jobinfo->step == 7){ ?>
				<div class="row views">
					<div style="margin-right:20px">
						<a href="<?= Url::base().'/job/print-draft-bl?id='.$_GET['id'] ?>" target="_blank" style="text-decoration:none;color:black;font-size:12px;">
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>Draft BL
						</a>
					</div>
					<!--<div style="margin-right:20px">
						<a href="<?= Url::base().'/job/print-nn-bl?id='.$_GET['id'] ?>" target="_blank" style="text-decoration:none;color:black;font-size:12px;">
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>NN BL
						</a>
					</div>-->
					<div style="margin-right:20px">
						<a href="<?= Url::base().'/job/print-nn-bl-logo?id='.$_GET['id'] ?>" target="_blank" style="text-decoration:none;color:black;font-size:12px;">
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>NN BL-Logo
						</a>
					</div>
					<div style="margin-right:20px" id="origin-bl">
						<a href="<?= Url::base().'/job/print-ori-bl?id='.$_GET['id'] ?>" target="_blank" style="text-decoration:none;color:black;font-size:12px;">
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>Original BL
						</a>
					</div>
					<a href="<?= Url::base().'/job/approve-seaway-bill?id='.$_GET['id'] ?>" class="btn btn-clear btn-xs" id="swb-on-process" style="border:none">Seaway Bill : On Process<br><span style="font-size:9px;color:green"><i>( Bypass to Seaway Bill )</i></a>
				</div>
			
			<!-- Seaway Bill -->
			<?php }elseif($jobinfo->step == 8){ ?>
				<div class="row views2">
					<div style="margin-right:20px" id="seaway-bill">
						<a href="<?= Url::base().'/job/print-seaway-bill?id='.$_GET['id'] ?>" target="_blank" style="text-decoration:none;color:black;font-size:12px;">
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>Seaway Bill
						</a>
					</div>
				</div>
			
			<!-- Cargo Receipt on process -->
			<?php }elseif($jobinfo->step == 9){ ?>
				<div class="row views">
					<div style="margin-right:20px">
						<a href="<?= Url::base().'/job/print-draft-bl?id='.$_GET['id'] ?>" target="_blank" style="text-decoration:none;color:black;font-size:12px;">
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>Draft BL
						</a>
					</div>
					<!--<div style="margin-right:20px">
						<a href="<?= Url::base().'/job/print-nn-bl?id='.$_GET['id'] ?>" target="_blank" style="text-decoration:none;color:black;font-size:12px;">
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>NN BL
						</a>
					</div>-->
					<div style="margin-right:20px">
						<a href="<?= Url::base().'/job/print-nn-bl-logo?id='.$_GET['id'] ?>" target="_blank" style="text-decoration:none;color:black;font-size:12px;">
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>NN BL-Logo
						</a>
					</div>
					<div style="margin-right:20px" id="origin-bl">
						<a href="<?= Url::base().'/job/print-ori-bl?id='.$_GET['id'] ?>" target="_blank" style="text-decoration:none;color:black;font-size:12px;">
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>Original BL
						</a>
					</div>
					<a href="<?= Url::base().'/job/approve-cargo-receipt?id='.$_GET['id'] ?>" class="btn btn-clear btn-xs" id="cr-on-process" style="border:none">Cargo Receipt : On Process<br><span style="font-size:9px;color:green"><i>( Bypass to Cargo Receipt )</i></a>
				</div>
			
			<!-- Cargo Receipt -->
			<?php }elseif($jobinfo->step == 10){ ?>
				<div class="row views2">
					<div style="margin-right:20px" id="cargo-receipt">
						<a href="<?= Url::base().'/job/print-cargo-receipt?id='.$_GET['id'] ?>" target="_blank" style="text-decoration:none;color:black;font-size:12px;">
							<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>Cargo Receipt
						</a>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>

<div class="tab-content">
	<div class="tab-pane active" id="job">
		<ul class="nav nav-tabs job" role="tablist">
			<li class="nav-item" role="presentation"><a href="#jobdoc" class="nav-link active" role="tab" data-toggle="tab">Document</a></li>
			<li class="nav-item" role="presentation"><a href="#jobbilling" class="nav-link" role="tab" data-toggle="tab">Billling</a></li>
		</ul>
		<div class="tab-content job-content">
			<div class="tab-pane active" id="jobdoc" role="tabpanel"><?= $this->render('document/index-document', ['job' => $job, 'party' => $party, 'jobbooking' => $jobbooking, 'vessel_routing' => $vessel_routing, 'hblrouting' => $hblrouting, 'cargo' => $cargo, 'description' => $description, 'freight_terms' => $freight_terms, 'reference' => $reference, 'ori_bl_batch' => $ori_bl_batch, 'footer' => $footer,]) ?></div>
			<div class="tab-pane" id="jobbilling" role="tabpanel"><?= $this->render('billing/index-billing') ?></div>
		</div>
	</div>
</div>

<?php
	Modal::begin([
		'title' => 'Request Original BL',
		'id' => 'modal1',
	]);
?>
	<?php $form = ActiveForm::begin([
		'id'=>'form-doc1', 
		'action'=>Url::base().'/job/save-doc1',
		'options' => ['enctype' => 'multipart/form-data']
	]); ?>
	
	<div class="form-group row">
		<div class="col-3">
			<label class="control-label">Document<br><i>(*Max 5 MB)</i></label>
		</div>
		
		<div class="col-9">
			<div class="row m-0">
				<?= $form->field($jobinfo, 'id_job')->hiddenInput(['value'=>$_GET['id']])->label(false) ?>
				<div class="col-6">
					<button type="button" class="btn btn-default w-100" id="btn_upload1" onclick="triggerUpload('document1')">Upload Document</button>
				</div>
				<div class="col-4 p-0 pt-2">
					<span type="button" id="btn_cancel_upload1" onclick="cancelUpload('document1')">X&nbsp;&nbsp;Cancel</span>
				</div>
			</div>
			
			<div class="col-12 mt-2">
				<div class="row m-0">
					<label id="document1-label" class="default-form-label"></label>
					<?= $form->field($jobinfo, 'doc_1', ['template'=>'{input}{error}', 'options'=>['style'=>'margin-bottom:0px']])->fileInput(['id' => 'document1', 'onchange' => "changeName('document1')", 'style' => 'display:none;']) ?>
				</div>
			</div>
		</div>
	</div>
	
	<div>Batch Original</div>
	
	<div class="row form-group">
		<div class="col-4 pr-0">
			<input type="text" class="form-control" name="branch_1" required>
		</div>
		<div class="col-4 pr-0">
			<input type="text" class="form-control" name="branch_2" required>
		</div>
		<div class="col-4">
			<input type="text" class="form-control" name="branch_3" required>
		</div>
	</div>
	
	<button type="submit" form="form-doc1" class="btn btn-dark">Confirm</button>
	<?php ActiveForm::end(); ?>
<?php Modal::end(); ?>

<?php
	Modal::begin([
		'title' => 'Request ERC / SWB / CR',
		'id' => 'modal2',
	]);
?>
	<?php $form = ActiveForm::begin([
		'id'=>'form-doc2', 
		'action'=>Url::base().'/job/save-doc2',
		'options' => ['enctype' => 'multipart/form-data']
	]); ?>
	
	<div class="form-group row">
		<div class="col-3">
			<label class="control-label">Type</label>
		</div>
		<div class="col-9 p-0">
			<div class="form-check form-check-inline m-0" style="padding-right:0.7rem">
				<input type="radio" class="form-check-input" id="req-type1" name="req-type" value="erc">
				<label class="form-check-label" for="req-type1">Express Release</label>
			</div>
			<div class="form-check form-check-inline m-0" style="padding-right:0.7rem">
				<input type="radio" class="form-check-input" id="req-type2" name="req-type" value="swb">
				<label class="form-check-label" for="req-type2">Seaway Bill</label>
			</div>
			<div class="form-check form-check-inline m-0" style="padding-right:0.2rem">
				<input type="radio" class="form-check-input" id="req-type3" name="req-type" value="cr">
				<label class="form-check-label" for="req-type3">Cargo Receipt</label>
			</div>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-3">
			<label class="control-label">Document<br><i>(*Max 5 MB)</i></label>
		</div>
		<div class="col-9 p-0">
			<div class="row m-0">
				<?= $form->field($jobinfo, 'id_job')->hiddenInput(['value'=>$_GET['id']])->label(false) ?>
				<div class="col-6 pl-0">
					<button type="button" class="btn btn-default w-100" id="btn_upload2" onclick="triggerUpload('document2')">Upload Document</button>
				</div>
				<div class="col-4 p-0 pt-2">
					<span type="button" id="btn_cancel_upload2" onclick="cancelUpload('document2')">X&nbsp;&nbsp;Cancel</span>
				</div>
			</div>
			
			<div class="col-12 mt-2">
				<div class="row m-0">
					<label id="document2-label" class="default-form-label"></label>
					<?= $form->field($jobinfo, 'doc_2', ['template'=>'{input}{error}', 'options'=>['style'=>'margin-bottom:0px']])->fileInput(['id' => 'document2', 'onchange' => "changeName('document2')", 'style' => 'display:none;']) ?>
				</div>
			</div>
		</div>
	</div>
	
	<button type="submit" form="form-doc2" class="btn btn-dark">Confirm Request</button>
	<?php ActiveForm::end(); ?>
<?php Modal::end(); ?>

<script>
	$('#req-origin-bl').on('click', function(){
		$('#modal1').modal({backdrop: 'static', keyboard: false});
		$('#modal1').modal('show');
	});
	
	$('#req-erc_swb_cr').on('click', function(){
		$('#modal2').modal({backdrop: 'static', keyboard: false});
		$('#modal2').modal('show');
	});
	
	//Clear notif error in modal upload
	$('#btn_upload1, #btn_cancel_upload1, #btn_upload2, #btn_cancel_upload2').on('click', function(){
		$('.help-block').html('');
	});
	
	/*$('#erc-on-process').on('click', function(){
		$('.views').hide();
		$('.views2').show();
		$('#express-release').show();
		$('#seaway-bill').hide();
		$('#cargo-receipt').hide();
	});
	
	$('#swb-on-process').on('click', function(){
		$('.views').hide();
		$('.views2').show();
		$('#express-release').hide();
		$('#seaway-bill').show();
		$('#cargo-receipt').hide();
	});
	
	$('#cr-on-process').on('click', function(){
		$('.views').hide();
		$('.views2').show();
		$('#express-release').hide();
		$('#seaway-bill').hide();
		$('#cargo-receipt').show();
	});*/
</script>
