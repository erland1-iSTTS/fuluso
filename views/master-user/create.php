<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MasterUser */

$this->title = 'Create Master User';
$this->params['breadcrumbs'][] = ['label' => 'Master Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
