<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\MasterPpn;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MasterPpnSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Ppns';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-ppn-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Master Ppn', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            //'defaults',
            //'is_active',
            //'created_date',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, MasterPpn $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
