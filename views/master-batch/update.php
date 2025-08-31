<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Batch */

$this->title = 'Update Batch: ' . $model->batch_id;
$this->params['breadcrumbs'][] = ['label' => 'Batches', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->batch_id, 'url' => ['view', 'batch_id' => $model->batch_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="batch-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
