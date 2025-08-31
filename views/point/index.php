<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PointSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Points';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
	.table-custom th {
		background-color: #ddd;
	}
	
	.table-custom th a{
		color: black;
	}
	
	/* Custom Pagination */
	.pagination li{
		padding: 5px 10px;
		margin: 0px 2px;
		
		border: 1px solid #343a40;
		border-radius: 3px;
	}
	
	.pagination li a{
		color: black;
	}
	
	.pagination li.active{
		background-color: #343a40;
	}
	
	.pagination li.active a{
		color: white;
	}
</style>

<div class="point-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php //Html::a('Create Point', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'layout'=>'{items}{pager}',
		'tableOptions' => ['id' => 'table-master-batch','class' => 'table table-custom'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'point_code',
            'point_name',
            // 'por',
            // 'pol',
            //'pot',
            //'pod',
            //'fd',
            //'pots',
            //'podel',
            //'point_notes:ntext',
            //'is_active',
            /*[
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Point $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],*/
        ],
    ]); ?>


</div>
