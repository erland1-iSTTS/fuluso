<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use richardfan\widget\JSRegister;
use kartik\select2\Select2;
use app\models\Container;
use app\models\Containercode;
?>

<style>
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


<div class="container-form">
	G3ESR22063557<br>
	PT. TIGA BINTANG JAYA<br>
	SEMARANG, ID -> LONG BEACH, CA USA<br>
	Type : Seaway Bill
	<hr>
	<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>View Document
	<br>
	<br>
	<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>Draft BL
	&emsp;&emsp;&emsp;&emsp;
	<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>NN BL
	<br><br>
	<div class="form-group">
		<div class="row">
			<div class="col-12 mt-2 mb-3">
				<?= Html::a('Approve', '../mobile-approve-bl/list2?action=approve', ['class'=>'btn btn-success w-100']) ?>
			</div>
			<div class="col-12">
				<?= Html::a('Reject', '../mobile-approve-bl/list2?action=reject', ['style'=>'color:red;text-decoration:none']) ?>
			</div>
		</div>
    </div>
</div>

