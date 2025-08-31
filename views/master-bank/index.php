<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\widgets\ActiveForm;

$this->title = 'Master Bank';
?>

<style>
	.table-custom th {
		background-color: #ddd;
	}
	
	.table-custom th a{
		color: black;
	}
	
	.form-group{
		margin-bottom: 10px;
	}
</style>

<div class="bank-index">
    <h1><?= Html::encode($this->title) ?></h1>
	
	<div class="master-bank-form" style="margin:20px 0px">
		<?php $form = ActiveForm::begin(); ?>
			<div class="row">
				<div class="col-2">
					<div class="form-group row">
						<div class="col-sm-12">
							<input type="text" class="form-control" id="bank-b_name" name="" placeholder="BANK NAME">
						</div>
					</div>
				</div>
				<div class="col-1 pl-0">
					<div class="form-group row">
						<div class="col-sm-12">
							<input type="text" class="form-control" id="bank-b_code" name="" placeholder="CODE" maxlength="5">
						</div>
					</div>
				</div>
				<div class="col-2 pl-0">
					<button type="button" class="btn btn-dark">ADD NEW</button>
				</div>
			</div>
		<?php ActiveForm::end(); ?>
	</div>
	
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout'=>'{items}{pager}',
		'tableOptions' => ['id' => 'table-master-batch','class' => 'table table-custom'],
        'columns' => [
            [
				'class' => 'yii\grid\SerialColumn',
				'headerOptions' => ['class' => 'text-center'],
				'contentOptions'=> ['style'=>'text-align:center;width:70px;'],
			],
            'b_name',
            'b_code',
            [
				'class' => 'yii\grid\ActionColumn',
				'template'=>'{view}{update}{delete}',
				'contentOptions'=>['style' => 'width:100px'],
				'buttons'=>[
					'view'=>function($url, $model){
						$icon = '<svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1.125em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="#343a40" d="M573 241C518 136 411 64 288 64S58 136 3 241a32 32 0 000 30c55 105 162 177 285 177s230-72 285-177a32 32 0 000-30zM288 400a144 144 0 11144-144 144 144 0 01-144 144zm0-240a95 95 0 00-25 4 48 48 0 01-67 67 96 96 0 1092-71z"></path></svg>';
						return Html::a($icon, ['view', 'b_id'=>$model->b_id], [
							'title' => 'view',
							'style' => 'padding:0px 2px',
						]);
					},
					'update'=>function($url, $model){
						$icon = '<svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="#343a40" d="M498 142l-46 46c-5 5-13 5-17 0L324 77c-5-5-5-12 0-17l46-46c19-19 49-19 68 0l60 60c19 19 19 49 0 68zm-214-42L22 362 0 484c-3 16 12 30 28 28l122-22 262-262c5-5 5-13 0-17L301 100c-4-5-12-5-17 0zM124 340c-5-6-5-14 0-20l154-154c6-5 14-5 20 0s5 14 0 20L144 340c-6 5-14 5-20 0zm-36 84h48v36l-64 12-32-31 12-65h36v48z"></path></svg>';
						return Html::a($icon, ['view', 'b_id'=>$model->b_id], [
							'title' => 'Update',
							'style' => 'padding:0px 2px',
						]);
					},
					'delete'=>function($url, $model){
						$icon = '<svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:.875em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="#343a40" d="M32 464a48 48 0 0048 48h288a48 48 0 0048-48V128H32zm272-256a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zM432 32H312l-9-19a24 24 0 00-22-13H167a24 24 0 00-22 13l-9 19H16A16 16 0 000 48v32a16 16 0 0016 16h416a16 16 0 0016-16V48a16 16 0 00-16-16z"></path></svg>';
						return Html::a($icon, ['delete', 'b_id'=>$model->b_id], [
							'title' => 'Delete',
							'style' => 'padding:0px 2px',
						]);
					},
				],
            ],
        ],
    ]); ?>
</div>
