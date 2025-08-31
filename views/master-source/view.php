<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'View Master Source';
$this->params['breadcrumbs'][] = ['label' => 'Master Source', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="source-view">
    <h1><?= Html::encode($this->title) ?></h1>
	
	<div style="margin-top:20px">
		<?= DetailView::widget([
			'model' => $model,
			'attributes' => [
				'source_code',
				'source_detail',
			],
		]) ?>
	</div>
	
	<p>
		<?= Html::a('Back', ['index'], ['class' => 'btn btn-default']) ?>
	</p>
</div>
