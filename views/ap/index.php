<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Modal;
use richardfan\widget\JSRegister;
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

<div class="accordion" id="panel_ap" style="font-size:12px">
	<div class="card">
		<div class="card-header" id="heading">
			<div class="row pl-2 pr-2">
				<h2 class="uncomplete m-0" style="width:100%;background-color:#eee" data-toggle="collapse" data-target="#collapse_ap" aria-expanded="true">
					<button class="btn btn-menu" type="button" data-toggle="collapse" data-target="#collapse_ap" aria-expanded="true">
						AP
					</button>
				</h2>
			</div>
		</div>
		
		<div id="collapse_ap" class="collapse show" data-parent="#panel_ap">
			<div class="card-body p-3">
				<?= $this->render('list') ?>
				<?= $this->render('create') ?>
			</div>
		</div>
	</div>
</div>

<?php Modal::begin(); ?>
<?php Modal::end(); ?>

<script>
	$(document).ready(function(){
	});
	
	$('#btn_create_ap').on('click', function(){
		$('#modal_create_ap').modal({backdrop: 'static', keyboard: false});
		$('#modal_create_ap').show();
	});
</script>
