<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'View Master Bank';
$this->params['breadcrumbs'][] = ['label' => 'Master Bank', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="master-portfolio-account-view">
    <h1><?= Html::encode($this->title) ?></h1>
	
	<div style="margin-top:20px">
		<?= DetailView::widget([
			'model' => $model,
			'attributes' => [
				'name',
				'accountno',
				'accountname',
				'bankname',
				'bankaddress:ntext',
				'bankswift',
				'remarks',
			],
		]) ?>
	</div>
	
	<p>
		<?= Html::a('Back', ['index'], ['class' => 'btn btn-default']) ?>
	</p>
</div>
