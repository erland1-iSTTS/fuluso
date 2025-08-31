<?php
use yii\helpers\Html;

$this->title = 'Update Master Vessel & Routing';
$this->params['breadcrumbs'][] = ['label' => 'Master Vessel & Routing', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="vessel-routing-update">
    <h1><?= Html::encode($this->title) ?></h1>
	
    <?= $this->render('_form', [
        'model' => $model,
        'details' => $details,
    ]) ?>
</div>
