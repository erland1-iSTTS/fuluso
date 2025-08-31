<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'View Master Vessel';
$this->params['breadcrumbs'][] = ['label' => 'Master Vessel', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="vessel-view">
    <h1><?= Html::encode($this->title) ?></h1>

	<div style="margin-top:20px">
		<?= DetailView::widget([
			'model' => $model,
			'attributes' => [
				'vessel_code',
				'vessel_name',
			],
		]) ?>
	</div>
	
	<p>
		<?= Html::a('Back', ['index'], ['class' => 'btn btn-default']) ?>
	</p>
</div>
