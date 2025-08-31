<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MasterNewJob */

$this->title = 'Update Master New Job: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Master New Jobs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="master-new-job-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
