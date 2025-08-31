<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="signature-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'signature_name')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'is_active')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
