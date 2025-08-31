<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Modal;
use richardfan\widget\JSRegister;
use app\models\MasterHakAkses;
?>

<?php
	$akses_maker = MasterHakAkses::find()->where(['id_role' => Yii::$app->user->identity->id_role])->andWhere(['id_menu' => 5])->one();
	$akses_approver = MasterHakAkses::find()->where(['id_role' => Yii::$app->user->identity->id_role])->andWhere(['id_menu' => 6])->one();
	
	if($akses_maker){
		$visible_maker = '';
	}else{
		$visible_maker = 'none';
	}
	
	if($akses_approver){
		$visible_approver = '';
	}else{
		$visible_approver = 'none';
	}
?>


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

<div class="accordion" id="panel_cost">
	<div class="card">
		<div class="card-header" id="headcost1">
			<div class="row pl-2 pr-2">
				<h2 class="m-0" style="width:86%;background-color:#eee;" data-toggle="collapse" data-target="#collapsecost1">
					<button class="btn btn-menu" type="button" data-toggle="collapse" data-target="#collapsecost1">
						Cost Operational
					</button>
				</h2>
				<div class="pr-3" style="width:14%;background-color:#eee;">
					<button type="button" class="btn btn-dark float-right w-100" id="btn_create_cost_misc" onclick="createCostOpr()">Create Cost Opr</button>
				</div>
				<?= $this->render('opr/cost_opr_modal') ?>
			</div>
		</div>
		
		<div id="collapsecost1" class="collapse" data-parent="#panel_cost">
			<div class="card-body p-3">
				<?= $this->render('opr/cost_opr_index') ?>
			</div>
		</div>
	</div>
	
	<div class="card">
		<div class="card-header" id="headcost2">
			<div class="row pl-2 pr-2">
				<h2 class="m-0" style="width:86%;background-color:#eee;" data-toggle="collapse" data-target="#collapsecost2">
					<button class="btn btn-menu" type="button" data-toggle="collapse" data-target="#collapsecost2">
						Cost Misc
					</button>
				</h2>
				<div class="pr-3" style="width:14%;background-color:#eee;">
					<button type="button" class="btn btn-dark float-right w-100" id="btn_create_cost_misc" onclick="createCostMisc()">Create Cost Misc</button>
				</div>
				<?= $this->render('misc/cost_misc_modal') ?>
			</div>
		</div>
		
		<div id="collapsecost2" class="collapse" data-parent="#panel_cost">
			<div class="card-body p-3">
				<?= $this->render('misc/cost_misc_index') ?>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		
	});
	
	function createCostMisc(){
		$('#modal_cost_misc').modal({backdrop: 'static', keyboard: false});
		$('#modal_cost_misc').show();
	}
	
	function createCostOpr(){
		$('#modal_cost_opr').modal({backdrop: 'static', keyboard: false});
		$('#modal_cost_opr').show();
	}
	
	
	
	
	$('#btn_create_ar').on('click', function(){
		$('#modal_create_ar').modal({backdrop: 'static', keyboard: false});
		$('#modal_create_ar').show();
	});
	
	$('#btn_create_ap_opr_voucher').on('click', function(){
		$('#modal_create_ap_opr_voucher').modal({backdrop: 'static', keyboard: false});
		$('#modal_create_ap_opr_voucher').show();
	});
</script>
