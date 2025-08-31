<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

$this->title = 'Master New Jobs';
?>

<div class="master-new-job-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Master New Job', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'job',
            'job_type',
            'job_location',
            'job_year',
            //'job_month',
            //'job_number',
            //'job_name',
            //'customer_name',
            //'job_customer',
            //'job_from',
            //'job_to',
            //'job_ship',
            //'job_hb',
            //'job_mb',
            //'g3_type',
            //'g3_total',
            //'g3_packages',
            //'status',
            //'timestamp',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, MasterNewJob $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
