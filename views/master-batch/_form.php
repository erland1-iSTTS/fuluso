<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Batch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="batch-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'batch_id')->textInput() ?>

    <?= $form->field($model, 'pol_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pol_dod')->textInput() ?>

    <?= $form->field($model, 'pc_vessel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pc_voyage')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pcv_doa')->textInput() ?>

    <?= $form->field($model, 'pcv_dod')->textInput() ?>

    <?= $form->field($model, 'lfp_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lfp_doa')->textInput() ?>

    <?= $form->field($model, 'lfp_dod')->textInput() ?>

    <?= $form->field($model, 'lfp_vessel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lfp_voyage')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pod_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pod_doa')->textInput() ?>

    <?= $form->field($model, 'is_active')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
