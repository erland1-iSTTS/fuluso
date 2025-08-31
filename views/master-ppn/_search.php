<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MasterPpnSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-ppn-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'amount') ?>

    <?= $form->field($model, 'validity_begin') ?>

    <?= $form->field($model, 'validity_end') ?>

    <?php // echo $form->field($model, 'defaults') ?>

    <?php // echo $form->field($model, 'is_active') ?>

    <?php // echo $form->field($model, 'created_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
