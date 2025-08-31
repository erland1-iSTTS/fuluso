<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="vessel-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'vessel_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vessel_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vessel_lloyd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vessel_buildyear')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vessel_flag')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vessel_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_active')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
