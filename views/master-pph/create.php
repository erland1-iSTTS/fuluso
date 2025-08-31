<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MasterPph */

$this->title = 'Create Master Pph';
$this->params['breadcrumbs'][] = ['label' => 'Master Pphs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-pph-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
