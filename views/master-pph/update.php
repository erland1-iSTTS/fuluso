<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MasterPph */

$this->title = 'Update Master Pph: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Master Pphs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="master-pph-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
