<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MasterNewJobSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-new-job-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'job') ?>

    <?= $form->field($model, 'job_type') ?>

    <?= $form->field($model, 'job_location') ?>

    <?= $form->field($model, 'job_year') ?>

    <?php // echo $form->field($model, 'job_month') ?>

    <?php // echo $form->field($model, 'job_number') ?>

    <?php // echo $form->field($model, 'job_name') ?>

    <?php // echo $form->field($model, 'customer_name') ?>

    <?php // echo $form->field($model, 'job_customer') ?>

    <?php // echo $form->field($model, 'job_from') ?>

    <?php // echo $form->field($model, 'job_to') ?>

    <?php // echo $form->field($model, 'job_ship') ?>

    <?php // echo $form->field($model, 'job_hb') ?>

    <?php // echo $form->field($model, 'job_mb') ?>

    <?php // echo $form->field($model, 'g3_type') ?>

    <?php // echo $form->field($model, 'g3_total') ?>

    <?php // echo $form->field($model, 'g3_packages') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'timestamp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
