<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'View Master Account Repr';
$this->params['breadcrumbs'][] = ['label' => 'Master Account Repr', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="account-repr-view">
    <h1><?= Html::encode($this->title) ?></h1>

	<div style="margin-top:20px">
		<?= DetailView::widget([
			'model' => $model,
			'attributes' => [
				'name',
			],
		]) ?>
	</div>
	
	<p>
		<?= Html::a('Back', ['index'], ['class' => 'btn btn-default']) ?>
	</p>
</div>
