<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use richardfan\widget\JSRegister;

/* @var $this yii\web\View */
/* @var $model app\models\MasterCurrency */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-currency-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user')->textInput(['value'=>'Desy', 'readonly'=>true, 'maxlength' => true]) ?>

    <?= $form->field($model, 'flag')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php JSRegister::begin(['position' => \yii\web\View::POS_END]); ?>
<script>

</script>
<?php JSRegister::end(); ?>