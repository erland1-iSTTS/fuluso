<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Input Container';
?>

<style>
	.index-container{
		padding: 4%;
		border: 1px solid #ccc;
	}
	
	.alert-success{
		color: #155724;
		background-color: #d4edda;
		border-color: #c3e6cb !important;
		border-radius: 5px;
		vertical-align: middle;
		padding: 10px;
		text-align: center;
	}
</style>

<div class="add-container">
	<div class="index-container">
		<?= $this->render('_form', [
			// 'model' => $model,
		]) ?>
	</div>
</div>
