<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Bank */

$this->title = 'Update Bank: ' . $model->b_id;
$this->params['breadcrumbs'][] = ['label' => 'Banks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->b_id, 'url' => ['view', 'b_id' => $model->b_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bank-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
