<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MasterNewJob */

$this->title = 'Create Master New Job';
$this->params['breadcrumbs'][] = ['label' => 'Master New Jobs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-new-job-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
