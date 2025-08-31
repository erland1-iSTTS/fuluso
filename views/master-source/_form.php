<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="source-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'source_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'source_detail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_active')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
