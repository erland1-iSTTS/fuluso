<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'View Master Packages';
$this->params['breadcrumbs'][] = ['label' => 'Master Packages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="packages-view">
    <h1><?= Html::encode($this->title) ?></h1>
	
	<div style="margin-top:20px">
		<?= DetailView::widget([
			'model' => $model,
			'attributes' => [
				'packages_name',
				'packages_plural',
			],
		]) ?>
	</div>
	
	<p>
		<?= Html::a('Back', ['index'], ['class' => 'btn btn-default']) ?>
	</p>
</div>
