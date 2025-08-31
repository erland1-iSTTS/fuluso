<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="point2-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ch')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'locode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'namewodiacritics')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subdiv')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'function')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'iata')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'coordinates')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remarks')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
