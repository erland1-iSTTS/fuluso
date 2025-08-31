<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MasterRole */

$this->title = 'Create Master Role';
$this->params['breadcrumbs'][] = ['label' => 'Master Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-role-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
