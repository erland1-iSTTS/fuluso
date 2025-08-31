<?php
use yii\helpers\Html;

$this->title = 'Update Master Profile';
?>

<div class="customer-update">
	<?php if($type == 'customer'){ ?>
		<h4 style="font-weight:700">Update Master Customer</h4>
		
		<?= $this->render('_form_customer', [
			'model' => $model,
			'alias' => $alias,
		]) ?>
		
	<?php }elseif($type == 'carrier'){ ?>
		<h4 style="font-weight:700">Update Master Carrier</h4>
		
		<?= $this->render('_form_carrier', [
			'model' => $model,
		]) ?>
		
	<?php }elseif($type == 'vendor'){ ?>
		<h4 style="font-weight:700">Update Master Vendor</h4>
		
		<?= $this->render('_form_vendor', [
			'model' => $model,
		]) ?>
	
	<?php } ?>
</div>
