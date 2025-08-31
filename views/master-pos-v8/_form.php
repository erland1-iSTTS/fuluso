<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="pos-v8-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pos_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pos_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pos_fee_idr')->textInput() ?>

    <?= $form->field($model, 'pos_fee_usd')->textInput() ?>

    <?= $form->field($model, 'pos_validity_begin')->textInput() ?>

    <?= $form->field($model, 'pos_validity_end')->textInput() ?>

    <?= $form->field($model, 'pos_jobv')->textInput() ?>

    <?= $form->field($model, 'pos_oprv')->textInput() ?>

    <?= $form->field($model, 'pos_inv')->textInput() ?>

    <?= $form->field($model, 'pos_g1efex')->textInput() ?>

    <?= $form->field($model, 'pos_g1efix')->textInput() ?>

    <?= $form->field($model, 'pos_g2trco')->textInput() ?>

    <?= $form->field($model, 'pos_g3shex')->textInput() ?>

    <?= $form->field($model, 'pos_g3shix')->textInput() ?>

    <?= $form->field($model, 'pos_g4misc')->textInput() ?>

    <?= $form->field($model, 'is_active')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
