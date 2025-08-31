<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CustomerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'customer_id') ?>

    <?= $form->field($model, 'customer_nickname') ?>

    <?= $form->field($model, 'customer_companyname') ?>

    <?= $form->field($model, 'customer_address') ?>

    <?= $form->field($model, 'customer_email_1') ?>

    <?php // echo $form->field($model, 'customer_email_2') ?>

    <?php // echo $form->field($model, 'customer_email_3') ?>

    <?php // echo $form->field($model, 'customer_email_4') ?>

    <?php // echo $form->field($model, 'customer_telephone') ?>

    <?php // echo $form->field($model, 'customer_contact_person') ?>

    <?php // echo $form->field($model, 'customer_npwp') ?>

    <?php // echo $form->field($model, 'customer_npwp_file') ?>

    <?php // echo $form->field($model, 'is_active') ?>

    <?php // echo $form->field($model, 'customer_type') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
