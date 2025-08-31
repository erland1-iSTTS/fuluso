<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="movement-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'movement_id')->textInput() ?>

    <?= $form->field($model, 'movement_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_active')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
