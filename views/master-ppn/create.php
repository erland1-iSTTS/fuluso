<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MasterPpn */

$this->title = 'Create Master Ppn';
$this->params['breadcrumbs'][] = ['label' => 'Master Ppns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-ppn-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
