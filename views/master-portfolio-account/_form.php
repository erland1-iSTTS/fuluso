<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="master-portfolio-account-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'accountno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'accountname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bankname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bankaddress')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'bankswift')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remarks')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
		<?= Html::a('Back', ['index'], ['class' => 'btn btn-default']) ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-dark']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
