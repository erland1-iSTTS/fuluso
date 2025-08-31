<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\MasterPph;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MasterPphSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Pphs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-pph-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Master Pph', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, MasterPph $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
