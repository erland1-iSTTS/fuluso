<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="unit-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'unit_id')->textInput() ?>

    <?= $form->field($model, 'unit_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unit_type')->textInput() ?>

    <?= $form->field($model, 'is_active')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
