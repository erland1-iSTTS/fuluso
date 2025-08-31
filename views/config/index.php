<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use richardfan\widget\JSRegister;

$this->title = 'Configuration';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="config-index">
	<?php $form = ActiveForm::begin([
		'id' => 'config_form',
		'action' => ['config/save'],
	]); ?>
	
	<div class="card">
		<div class="card-body">
			<h1 style="margin-bottom:30px"><?= Html::encode($this->title) ?></h1>
			
			<div class="row">
				<div class="col-12">
					<table class="table table-bordered">
						<thead class="bg-black">
							<tr>
								<th width="50%">Name</th>
								<th width="50%">Value</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$i=0;
								foreach($model as $row){ 
							?>
								<tr>
									<td><?= $row['name'] ?></td>
									<td>
										<input type="hidden" class="form-control" value="<?= $row['id']?>" name="Config[detail][<?= $i?>][id]">
										
										<div class="row">
											<div class="col-12">
												<?php
													if($row['name'] == 'HMC'){
														if($row['value'] == 1){
															$checked1 = 'checked';
															$checked2 = '';
														}else{
															$checked1 = '';
															$checked2 = 'checked';
														}
													}
												?>
											
												<input type="checkbox" id="check_show" name="hmc" for="hmc" value="1" <?= $checked1?> disabled>
												<label for="check_show">Show</label>
												
												&emsp;
												
												<input type="checkbox" id="check_hide" name="hmc" value="0" <?= $checked2?> disabled>
												<label for="check_hide">Hide</label>
											</div>
										</div>
									</td>
								</tr>
							<?php $i++;} ?>
						</tbody>
					</table>
				</div>
			</div>
			
			<div class="row">
				<div class="col-12">
					<?= Html::button('Change', ['class' => 'btn btn-primary', 'id' => 'btn_change', 'onclick' => 'changeConfig()']) ?>
					<?= Html::submitButton('Save', ['class' => 'btn btn-success', 'id' => 'btn_save', 'style' => 'display:none']) ?>
				</div>
			</div>
		</div>
	</div>
	<?php ActiveForm::end(); ?>
</div>

<?php JSRegister::begin(['position' => \yii\web\View::POS_END]); ?>
<script>
	$('input[type="checkbox"]').on('change', function() {
	   $('input[type="checkbox"]').not(this).prop('checked', false);
	});

	function changeConfig(){
		$('#btn_change').hide();
		$('#btn_save').show();
		
		$('input').attr('disabled', false);
		$('input').attr('readonly', false);
	}
</script>
<?php JSRegister::end(); ?>
