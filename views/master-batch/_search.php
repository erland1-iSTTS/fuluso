<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MasterBatchSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="batch-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'batch_id') ?>

    <?= $form->field($model, 'pol_id') ?>

    <?= $form->field($model, 'pol_dod') ?>

    <?= $form->field($model, 'pc_vessel') ?>

    <?= $form->field($model, 'pc_voyage') ?>

    <?php // echo $form->field($model, 'pcv_doa') ?>

    <?php // echo $form->field($model, 'pcv_dod') ?>

    <?php // echo $form->field($model, 'lfp_id') ?>

    <?php // echo $form->field($model, 'lfp_doa') ?>

    <?php // echo $form->field($model, 'lfp_dod') ?>

    <?php // echo $form->field($model, 'lfp_vessel') ?>

    <?php // echo $form->field($model, 'lfp_voyage') ?>

    <?php // echo $form->field($model, 'pod_id') ?>

    <?php // echo $form->field($model, 'pod_doa') ?>

    <?php // echo $form->field($model, 'is_active') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
