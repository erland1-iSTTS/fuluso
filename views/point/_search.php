<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PointSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="point-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'point_code') ?>

    <?= $form->field($model, 'point_name') ?>

    <?= $form->field($model, 'por') ?>

    <?= $form->field($model, 'pol') ?>

    <?php // echo $form->field($model, 'pot') ?>

    <?php // echo $form->field($model, 'pod') ?>

    <?php // echo $form->field($model, 'fd') ?>

    <?php // echo $form->field($model, 'pots') ?>

    <?php // echo $form->field($model, 'podel') ?>

    <?php // echo $form->field($model, 'point_notes') ?>

    <?php // echo $form->field($model, 'is_active') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
