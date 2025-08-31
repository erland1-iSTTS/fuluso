<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MasterNewJob */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-new-job-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'job')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'job_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'job_location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'job_year')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'job_month')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'job_number')->textInput() ?>

    <?= $form->field($model, 'job_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'job_customer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'job_from')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'job_to')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'job_ship')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'job_hb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'job_mb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'g3_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'g3_total')->textInput() ?>

    <?= $form->field($model, 'g3_packages')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
