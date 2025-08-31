<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Point */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="point-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'point_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'point_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'por')->textInput() ?>

    <?= $form->field($model, 'pol')->textInput() ?>

    <?= $form->field($model, 'pot')->textInput() ?>

    <?= $form->field($model, 'pod')->textInput() ?>

    <?= $form->field($model, 'fd')->textInput() ?>

    <?= $form->field($model, 'pots')->textInput() ?>

    <?= $form->field($model, 'podel')->textInput() ?>

    <?= $form->field($model, 'point_notes')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'is_active')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
