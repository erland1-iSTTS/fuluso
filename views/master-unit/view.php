<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'View Master Weight / Measurement';
$this->params['breadcrumbs'][] = ['label' => 'Master Weight / Measurement', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="unit-view">
    <h1><?= Html::encode($this->title) ?></h1>
	
	<div style="margin-top:20px">
		<?= DetailView::widget([
			'model' => $model,
			'attributes' => [
				'unit_name',
				[
					'attribute' => 'unit_type',
					'value' => function($model){
						if($model->unit_type == 1){
							return 'Weight';
						}else{
							return 'Measurement'; 
						}
					}
				]
			],
		]) ?>
	</div>
	
	<p>
		<?= Html::a('Back', ['index'], ['class' => 'btn btn-default']) ?>
	</p>
</div>
