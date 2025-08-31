<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="containercode-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'containercode_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'containercode_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_active')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
