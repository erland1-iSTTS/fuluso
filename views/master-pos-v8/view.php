<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'View Master Pos';
$this->params['breadcrumbs'][] = ['label' => 'Master Pos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="pos-v8-view">
    <h1><?= Html::encode($this->title) ?></h1>
	
	<div style="margin-top:20px">
		<?= DetailView::widget([
			'model' => $model,
			'attributes' => [
				'pos_name',
				[
					'attribute' => 'pos_type',
					'value' => function($model){
						if($model->pos_type == 1){
							return 'AR';
						}elseif($model->pos_type == 2){
							return 'AP'; 
						}elseif($model->pos_type == 3){
							return 'BOTH'; 
						}else{
							return '';
						}
					}
				],
				[
					'attribute' => 'pos_fee_usd',
					'value' => function($model){
						return number_format($model->pos_fee_usd,0,'.',',');
					}
				],
				[
					'attribute' => 'pos_fee_idr',
					'value' => function($model){
						return number_format($model->pos_fee_idr,0,'.',',');
					}
				],
				[
					'attribute' => 'pos_jenis',
					'value' => function($model){
						if($model->pos_jenis == 1){
							return 'Variable';
						}elseif($model->pos_jenis == 2){
							return 'Fixed'; 
						}else{
							return '';
						}
					}
				],
				[
					'attribute' => 'pos_validity_begin',
					'label' => 'Validity Start',
					'value' => function($model){
						return date('d F Y', strtotime($model->pos_validity_begin));
					}
				],
				[
					'attribute' => 'pos_validity_end',
					'label' => 'Validity End',
					'value' => function($model){
						return date('d F Y', strtotime($model->pos_validity_end));
					}
				],
			],
		]) ?>
	</div>
	
	<p>
		<?= Html::a('Back', ['index'], ['class' => 'btn btn-default']) ?>
	</p>
</div>
