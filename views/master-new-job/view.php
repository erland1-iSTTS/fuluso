<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MasterNewJob */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Master New Jobs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="master-new-job-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'job',
            'job_type',
            'job_location',
            'job_year',
            'job_month',
            'job_number',
            'job_name',
            'customer_name',
            'job_customer',
            'job_from',
            'job_to',
            'job_ship',
            'job_hb',
            'job_mb',
            'g3_type',
            'g3_total',
            'g3_packages',
            'status',
            'timestamp',
        ],
    ]) ?>

</div>
