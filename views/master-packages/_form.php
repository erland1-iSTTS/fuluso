<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="packages-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'packages_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'packages_plural')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
