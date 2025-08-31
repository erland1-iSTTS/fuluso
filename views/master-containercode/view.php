<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'View Master Container Prefix';
$this->params['breadcrumbs'][] = ['label' => 'Master Container Prefix', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="containercode-view">
    <h1><?= Html::encode($this->title) ?></h1>
	
	<div style="margin-top:20px">
		<?= DetailView::widget([
			'model' => $model,
			'attributes' => [
				'containercode_name',
			],
		]) ?>
	</div>
	
	<p>
		<?= Html::a('Back', ['index'], ['class' => 'btn btn-default']) ?>
	</p>
</div>
