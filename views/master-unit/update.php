<?php
use yii\helpers\Html;

$this->title = 'Update Master Weight / Measurement';
$this->params['breadcrumbs'][] = ['label' => 'Master Weight / Measurement', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="unit-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
