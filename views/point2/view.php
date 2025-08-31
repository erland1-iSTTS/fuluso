<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'View Master Point';
$this->params['breadcrumbs'][] = ['label' => 'Master Point', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="point2-view">
    <h1><?= Html::encode($this->title) ?></h1>

	<div style="margin-top:20px">
		<?= DetailView::widget([
			'model' => $model,
			'attributes' => [
				'locode',
				'name',
				'namewodiacritics',
				'subdiv',
				'function',
				'status',
				'date',
				'iata',
				'coordinates',
				'remarks',
			],
		]) ?>
	</div>
	
	<p>
		<?= Html::a('Back', ['index'], ['class' => 'btn btn-default']) ?>
	</p>
</div>
