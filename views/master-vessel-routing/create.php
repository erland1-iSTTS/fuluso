<?php
use yii\helpers\Html;

$this->title = 'Create Master Vessel & Routing';
$this->params['breadcrumbs'][] = ['label' => 'Master Vessel & Routing', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="vessel-routing-create">
	<h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
