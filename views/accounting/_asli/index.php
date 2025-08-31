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

<div class="accordion" id="panel_accounting">
	<div class="card">
		<div class="card-header" id="heading1">
			<div class="row pl-2 pr-2">
				<h2 class="uncomplete m-0" style="width:100%;background-color:#eee" data-toggle="collapse" data-target="#collapse_acc1" aria-expanded="true">
					<button class="btn btn-menu" type="button" data-toggle="collapse" data-target="#collapse_acc1" aria-expanded="true">
						AR IDT
					</button>
				</h2>
			</div>
		</div>
		
		<div id="collapse_acc1" class="collapse show" data-parent="#panel_accounting">
			<div class="card-body p-3">
				<?= $this->render('ar_receipt_list', []) ?>
				<?= $this->render('ar_receipt_create', []) ?>
			</div>
		</div>
	</div>
	
	<div class="card">
		<div class="card-header" id="heading2">
			<div class="row pl-2 pr-2">
				<h2 class="uncomplete m-0" style="width:100%;background-color:#eee" data-toggle="collapse" data-target="#collapse_acc2">
					<button class="btn btn-menu" type="button" data-toggle="collapse" data-target="#collapse_acc2">
						AP VOUCHER (PAYMENT)
					</button>
				</h2>
			</div>
		</div>
		
		<div id="collapse_acc2" class="collapse" data-parent="#panel_accounting">
			<div class="card-body p-3">
				<?= $this->render('list_ap_payment', []) ?>
			</div>
		</div>
	</div>
	
	<div class="card" style="display:<?= $visible_maker ?>">
		<div class="card-header" id="heading">
			<div class="row pl-2 pr-2">
				<h2 class="uncomplete m-0" style="width:100%;background-color:#eee" data-toggle="collapse" data-target="#collapse_create_ap" aria-expanded="true">
					<button class="btn btn-menu" type="button" data-toggle="collapse" data-target="#collapse_create_ap" aria-expanded="true">
						AP Opr Voucher - Create - by maker
					</button>
				</h2>
			</div>
		</div>
		
		<div id="collapse_create_ap" class="collapse" data-parent="#panel_accounting">
			<div class="card-body p-3">
				<?= $this->render('list_ap_opr') ?>
				<?= $this->render('create_ap_opr') ?>
			</div>
		</div>
	</div>
	
	<div class="card" style="display:<?= $visible_approver ?>">
		<div class="card-header" id="heading">
			<div class="row pl-2 pr-2">
				<h2 class="uncomplete m-0" style="width:100%;background-color:#eee" data-toggle="collapse" data-target="#collapse_input_ap_opr" aria-expanded="true">
					<button class="btn btn-menu" type="button" data-toggle="collapse" data-target="#collapse_input_ap_opr" aria-expanded="true">
						AP Opr Voucher - Payment - by approver
					</button>
				</h2>
			</div>
		</div>
		
		<div id="collapse_input_ap_opr" class="collapse" data-parent="#panel_accounting">
			<div class="card-body p-3">
				<?= $this->render('list_ap_opr_voucher') ?>
			</div>
		</div>
	</div>
	
	<div class="card">
		<div class="card-header" id="heading3">
			<div class="row pl-2 pr-2">
				<h2 class="uncomplete m-0" style="width:100%;background-color:#eee" data-toggle="collapse" data-target="#collapse_acc3">
					<button class="btn btn-menu" type="button" data-toggle="collapse" data-target="#collapse_acc3">
						AR HMC
					</button>
				</h2>
			</div>
		</div>
		
		<div id="collapse_acc3" class="collapse" data-parent="#panel_accounting">
			<div class="card-body p-3">
				<?php //$this->render('notice', []) ?>
			</div>
		</div>
	</div>
</div>

<?php Modal::begin(); ?>
<?php Modal::end(); ?>

<script>
	$(document).ready(function(){
		
	});
	
	$('.account').select2({
		dropdownCssClass : 'mediumdrop',
		dropdownParent: '#panel_accounting',
	});
	
	$('.account_ap_opr').select2({
		dropdownCssClass : 'mediumdrop',
		dropdownParent: '#panel_accounting',
	});
	
	$('#btn_create_ar').on('click', function(){
		$('#modal_create_ar').modal({backdrop: 'static', keyboard: false});
		$('#modal_create_ar').show();
	});
	
	$('#btn_create_ap_opr_voucher').on('click', function(){
		$('#modal_create_ap_opr_voucher').modal({backdrop: 'static', keyboard: false});
		$('#modal_create_ap_opr_voucher').show();
	});
</script>
