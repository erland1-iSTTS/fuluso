<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'View Master Signature';
$this->params['breadcrumbs'][] = ['label' => 'Master Signature', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="signature-view">
    <h1><?= Html::encode($this->title) ?></h1>
	
	<div style="margin-top:20px">
		<?= DetailView::widget([
			'model' => $model,
			'attributes' => [
				'signature_name:ntext',
			],
		]) ?>
	</div>
	
	<p>
		<?= Html::a('Back', ['index'], ['class' => 'btn btn-default']) ?>
	</p>
</div>
