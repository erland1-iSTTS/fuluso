<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\PpnDetail;
use app\models\PphDetail;

$this->title = 'Master Pos';
date_default_timezone_set('Asia/Jakarta');
?>

<style>
	.table-custom th{
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
	
	.control-label{
		font-weight: bold;
	}
	
	.select2-container--krajee-bs4 .select2-selection--single{
		padding: 0px !important;
	}
	
	.select2-container--krajee-bs4 .select2-selection__clear{
		line-height: 35px !important;
		padding-right: 5px;
	}
	
	#posv8-pos_jenis label:first-child{
		margin-right: 20px;
	}
</style>

<div class="pos-v8-index">
    <h1><?= Html::encode($this->title) ?></h1>
	
    <div class="master-pos-form" style="margin:20px 0px">
		<?php $form = ActiveForm::begin([
			'action' => ['master-pos-v8/save'],
		]); ?>
			<div class="row">
				<input type="hidden" id="posv8-pos_id" name="PosV8[pos_id]">
			
				<div style="width:21%;max-width:21%;padding:0px 15px">
					<?= $form->field($model, 'pos_name')->textInput(['maxlength' => true, 'placeholder' => 'POS NAME']) ?>
				</div>
				<div class="pl-0" style="width:12%;max-width:12%;padding:0px 15px">
					<?= $form->field($model, 'pos_type')->widget(Select2::classname(), [
						'data' => [
							'1' => 'AR',
							'2' => 'AP',
							'3'	=> 'BOTH',
						],
						'hideSearch' => true,
						'options' => ['placeholder' => 'TYPE'],
						'pluginOptions' => [
							'allowClear' => false,
						],
					]); ?>
				</div>
				<div class="col-1 pl-0">
					<?= $form->field($model, 'pos_fee_usd')->textInput(['maxlength' => true, 'placeholder' => '0']) ?>
				</div>
				<div class="col-1 pl-0">
					<?= $form->field($model, 'pos_fee_idr')->textInput(['maxlength' => true, 'placeholder' => '0']) ?>
				</div>
				<div class="col-5 pl-0 pr-0">
					<div class="form-group row">
						<div class="col-sm-12">
							<label><b>Validity Period</b></label>
							<div class="row">
								<div style="width:45%;padding:0px 0px 0px 15px">
									<input type="date" class="form-control" id="posv8-pos_validity_begin" value="<?= date('Y-m-d') ?>" name="PosV8[pos_validity_begin]" required>
								</div>
								<div class="text-center" style="width:5px;max-width:20px;padding:5px 15px 0px 10px">-</div>
								<div style="width:45%;padding:0px 15px 0px 0px">
									<input type="date" class="form-control" id="posv8-pos_validity_end" value="<?= date('Y-m-d') ?>" name="PosV8[pos_validity_end]" required>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-1 pl-0" style="margin-top:28px">
					<?= Html::submitButton('ADD', ['class' => 'btn btn-dark', 'id' => 'btn_submit']) ?>
				</div>
			</div>
			<div class="row">
				<div class="col-3">
					<?= $form->field($model, 'pos_jenis')->radioList([
						'1' => 'Variable',
						'2' => 'Fixed',
					]) ?>
				</div>
				<div class="col-3">
					<?= 
						$form->field($model, 'id_detail_ppn')->widget(Select2::class, [
							'data' => ArrayHelper::map(PpnDetail::find()->all(), 'id', 'name'),
							'options' => ['placeholder' => 'Select PPN'],
							'pluginOptions' => ['allowClear' => true],
						]);
					?>
				</div>
				<div class="col-3">
					<?= $form->field($model, 'id_detail_pph')->widget(Select2::class, [
						'data' => ArrayHelper::map(PphDetail::find()->all(), 'id', 'name'),
						'options' => ['placeholder' => 'Select PPH'],
						'pluginOptions' => ['allowClear' => true],
					]);
					?>
				</div>
			</div>
		<?php ActiveForm::end(); ?>
	</div>
	
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'layout'=>'{items}{pager}',
		'tableOptions' => ['id' => 'table-master-batch','class' => 'table table-custom'],
		'rowOptions' => function ($model, $key, $index, $column){
			$now 	= date('Y-m-d');
			$begin 	= $model->pos_validity_begin;
			$end 	= $model->pos_validity_end;
			
			if($end < $now){
				return ['class' => 'table-danger'];
			}else{
				return ['class' => 'table-success'];
			}
		},
        'columns' => [
            [
				'class' => 'yii\grid\SerialColumn',
				'headerOptions' => ['class' => 'text-center'],
				'contentOptions'=> ['style'=>'text-align:center;width:70px;'],
			],
            'pos_name',
			[
				'attribute' => 'pos_type',
				'contentOptions'=>['style' => 'width:100px;text-align:center;'],
				'value' => function ($model){
					if($model->pos_type == 1){
						return 'AR';
					}elseif($model->pos_type == 2){
						return 'AP';
					}elseif($model->pos_type == 3){
						return 'BOTH';
					}else{
						return '';
					}
                },
				'filter' => Select2::widget([
					'model' => $searchModel,
					'attribute' => 'pos_type',
					'data' => [
						'1' => 'AR',
						'2' => 'AP',
						'3' => 'BOTH',
					],
					'hideSearch' => true,
					'options' => ['placeholder' => ''],
					'pluginOptions' => [
						'allowClear' => true,
					],
				]),
			],
			[
				'attribute' => 'pos_fee_usd',
				'contentOptions'=>['style' => 'width:100px;text-align:right;'],
				'value' => function ($model){
                    if($model->pos_fee_usd){
						return $model->pos_fee_usd;
					}else{
						return '';
					}
                },
			],
			[
				'attribute' => 'pos_fee_idr',
				'contentOptions'=>['style' => 'width:100px;text-align:right;'],
				'value' => function ($model){
					if($model->pos_fee_idr){
						return $model->pos_fee_idr;
					}else{
						return '';
					}
                },
			],
			[
				'attribute' => 'pos_jenis',
				'contentOptions'=>['style' => 'width:150px;text-align:center;'],
				'value' => function ($model){
					if($model->pos_jenis == 1){
						return 'Variable';
					}elseif($model->pos_jenis == 2){
						return 'Fixed';
					}else{
						return '';
					}
                },
				'filter' => Select2::widget([
					'model' => $searchModel,
					'attribute' => 'pos_jenis',
					'data' => [
						'1' => 'Variable',
						'2' => 'Fixed',
					],
					'hideSearch' => true,
					'options' => ['placeholder' => ''],
					'pluginOptions' => [
						'allowClear' => true,
					],
				]),
			],
			[
				'attribute' => 'pos_validity_end',
				'contentOptions' => ['style' => 'width:20%'],
				'label' => 'Validity Period',
				'filter' => false,
				'value' => function ($model){
					$date_begin = date_format(date_create($model->pos_validity_begin), 'j M Y');
					$date_end = date_format(date_create($model->pos_validity_end), 'j M Y');
                    return $date_begin.' - '.$date_end;
                },
			],
            [
				'class' => 'yii\grid\ActionColumn',
				'template'=>'{renew}{view}{update}{delete}',
				'contentOptions'=>['style' => 'width:120px'],
				'buttons'=>[
					'renew'=>function($url, $model){
						$icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16"" height="16"" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"> <path d="M2.5 2v6h6M21.5 22v-6h-6"/><path d="M22 11.5A10 10 0 0 0 3.2 7.2M2 12.5a10 10 0 0 0 18.8 4.2"/></svg>';
						return Html::a($icon, ['renew', 'id'=>$model->pos_id], [
							'title' => 'renew',
							'style' => 'padding:0px 2px',
						]);
					},
					'view'=>function($url, $model){
						$icon = '<svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1.125em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="#343a40" d="M573 241C518 136 411 64 288 64S58 136 3 241a32 32 0 000 30c55 105 162 177 285 177s230-72 285-177a32 32 0 000-30zM288 400a144 144 0 11144-144 144 144 0 01-144 144zm0-240a95 95 0 00-25 4 48 48 0 01-67 67 96 96 0 1092-71z"></path></svg>';
						return Html::a($icon, ['view', 'id'=>$model->pos_id], [
							'title' => 'view',
							'style' => 'padding:0px 2px',
						]);
					},
					'update'=>function($url, $model){
						$icon = '<svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="#343a40" d="M498 142l-46 46c-5 5-13 5-17 0L324 77c-5-5-5-12 0-17l46-46c19-19 49-19 68 0l60 60c19 19 19 49 0 68zm-214-42L22 362 0 484c-3 16 12 30 28 28l122-22 262-262c5-5 5-13 0-17L301 100c-4-5-12-5-17 0zM124 340c-5-6-5-14 0-20l154-154c6-5 14-5 20 0s5 14 0 20L144 340c-6 5-14 5-20 0zm-36 84h48v36l-64 12-32-31 12-65h36v48z"></path></svg>';
						return Html::button($icon, [
							'class' => 'btn',
							'title' => 'Update',
							'style' => 'padding:0px 2px',
							'onclick' => 'editData('. $model->pos_id .')',
						]);
					},
					'delete'=>function($url, $model){
						$icon = '<svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:.875em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="#343a40" d="M32 464a48 48 0 0048 48h288a48 48 0 0048-48V128H32zm272-256a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zM432 32H312l-9-19a24 24 0 00-22-13H167a24 24 0 00-22 13l-9 19H16A16 16 0 000 48v32a16 16 0 0016 16h416a16 16 0 0016-16V48a16 16 0 00-16-16z"></path></svg>';
						return Html::button($icon, [
							'class' => 'btn',
							'title' => 'Delete',
							'style' => 'padding:0px 2px',
							'onclick' => 'deleteData('. $model->pos_id .')',
						]);
					},
				],
            ],
        ],
    ]); ?>
</div>

<script>
	function editData(id){
		$.ajax({
			url: '<?=Url::base().'/master-pos-v8/get-data'?>',
			data: {'id': id},
			dataType: 'json',
			method: 'POST',
            async: 'false'
		}).done(function(result){
			if(result){
				console.log(result);
				$('#posv8-pos_id').val(result.pos_id);
				$('#posv8-pos_name').val(result.pos_name);
				$('#posv8-pos_type').val(result.pos_type).trigger('change');
				
				if(result.pos_fee_idr !== '' && result.pos_fee_idr !== null){
					$('#posv8-pos_fee_idr').val(result.pos_fee_idr);
				}
				
				if(result.pos_fee_usd !== '' && result.pos_fee_usd !== null){
					$('#posv8-pos_fee_usd').val(result.pos_fee_usd);
				}
				
				$('#posv8-pos_validity_begin').val(result.pos_validity_begin);
				$('#posv8-pos_validity_end').val(result.pos_validity_end);
				
				if(result.pos_jenis == 1){
					$('#posv8-pos_jenis input:eq(0)').prop('checked', true);
					$('#posv8-pos_jenis input:eq(1)').prop('checked', false);
				}else if(result.pos_jenis == 2){
					$('#posv8-pos_jenis input:eq(0)').prop('checked', false);
					$('#posv8-pos_jenis input:eq(1)').prop('checked', true);
				}
				$('#btn_submit').text('EDIT');
			}
		});
	}
	
	function deleteData(id){
		var deleted = confirm('Are you sure want to delete?');
		
		if(deleted == true){
			url = '<?= Url::base()?>/master-pos-v8/delete-data?id='+id;
			window.location.replace(url);
		}
	}
</script>
