<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use richardfan\widget\JSRegister;
use app\models\MasterMenu;
use app\models\MasterAction;
use app\models\MasterHakAkses;

$this->title = 'Master Hak Akses';
?>

<div class="master-hak-akses-form">
	<h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>
		
	<?php
		//menu
		$menu_all 		 = MasterMenu::find()->where(['flag'=>1])->all();
		
		$menu_home 		 = MasterMenu::find()->where(['nama_modul'=>'home', 'flag'=>1])->all();
		$menu_batch	 	 = MasterMenu::find()->where(['nama_modul'=>'batch', 'flag'=>1])->all();
		$menu_job 		 = MasterMenu::find()->where(['nama_modul'=>'job', 'flag'=>1])->all();
		$menu_ap	 	 = MasterMenu::find()->where(['nama_modul'=>'ap', 'flag'=>1])->all();
		$menu_accounting = MasterMenu::find()->where(['nama_modul'=>'accounting', 'flag'=>1])->all();
		$menu_final 	 = MasterMenu::find()->where(['nama_modul'=>'final', 'flag'=>1])->all();
		$menu_log 		 = MasterMenu::find()->where(['nama_modul'=>'log', 'flag'=>1])->all();
		$menu_master 	 = MasterMenu::find()->where(['nama_modul'=>'master', 'flag'=>1])->all();
		
		//id_action
		$view 		= MasterAction::find()->where(['nama_action'=>'View', 'flag'=>1])->one()->id;
		$create 	= MasterAction::find()->where(['nama_action'=>'Create', 'flag'=>1])->one()->id;
		$update 	= MasterAction::find()->where(['nama_action'=>'Update', 'flag'=>1])->one()->id;
		$delete 	= MasterAction::find()->where(['nama_action'=>'Delete', 'flag'=>1])->one()->id;
		
		if($model->id == 1){
			$readonly = true;
		}else{
			$readonly = false;
		}
	?>
	
	<div class="row">
		<div class="col-12">
			<div class="row">
				<div class="col-3">
					<?= $form->field($model, 'id', ['template'=>'{input}', 'options'=>['tag'=>false]])->hiddenInput()->label(false); ?>
					
					<?= $form->field($model, 'role_name')->textInput(['placeholder'=>'Role Name', 'readonly' => $readonly, 'maxlength' => true]) ?>
				</div>
			</div>
			
			<!-- Menu All -->
			<div class="form-group-setting">
				<label class="control-label">Menu</label>
				<div class="row">
					<div class="col-7">
						<table id="table-master" class="table table-bordered table-hover">
							<thead class="table-active">
								<tr>
									<th class="text-center" width="40%">Menu</th>
									<th class="text-center" width="15%">Create</th>
									<th class="text-center" width="15%">Update</th>
									<th class="text-center" width="15%">Delete</th>
									<th class="text-center" width="15%">View</th>
								</tr>
							</thead>
							
							<?php foreach($menu_all as $row){ ?>
							<tr>
								<td><?= $row['nama_menu'] ?></td>
								<!-- Create -->
								<td class="text-center">
									<?php
										$hakakses = MasterHakAkses::find()->where(['id_role'=>$model->id, 'id_action'=>$create, 'id_menu'=>$row['id']])->one();
										
										if(isset($hakakses)){
											$checked = 'checked';
										}else{
											$checked = '';
										}
									?>
									<input type="checkbox" id="hak-akses-<?= $row['id'] ?>-<?= $create ?>"  name="MasterHakAkses[HakAkses][]" value="<?= $row['id'] ?>-<?= $create ?>" <?= $checked ?>>
								</td>
								<!-- Update -->
								<td class="text-center">
									<?php
										$hakakses = MasterHakAkses::find()->where(['id_role'=>$model->id, 'id_action'=>$update, 'id_menu'=>$row['id']])->one();
										
										if(isset($hakakses)){
											$checked = 'checked';
										}else{
											$checked = '';
										}
									?>
									<input type="checkbox" id="hak-akses-<?= $row['id'] ?>-<?= $update ?>"  name="MasterHakAkses[HakAkses][]" value="<?= $row['id'] ?>-<?= $update ?>" <?= $checked ?>>
								</td>
								<!-- Delete -->
								<td class="text-center">
									<?php
										$hakakses = MasterHakAkses::find()->where(['id_role'=>$model->id, 'id_action'=>$delete, 'id_menu'=>$row['id']])->one();

										if(isset($hakakses)){
											$checked = 'checked';
										}else{
											$checked = '';
										}
									?>
									<input type="checkbox" id="hak-akses-<?= $row['id'] ?>-<?= $delete ?>"  name="MasterHakAkses[HakAkses][]" value="<?= $row['id'] ?>-<?= $delete ?>" <?= $checked ?>>
								</td>
								<!-- View -->
								<td class="text-center">
									<?php
										$hakakses = MasterHakAkses::find()->where(['id_role'=>$model->id, 'id_action'=>$view, 'id_menu'=>$row['id']])->one();
										
										if(isset($hakakses)){
											$checked = 'checked';
										}else{
											$checked = '';
										}
									?>
									<input type="checkbox" id="hak-akses-<?= $row['id'] ?>-<?= $view ?>"  name="MasterHakAkses[HakAkses][]" value="<?= $row['id'] ?>-<?= $view ?>" <?= $checked ?>>
								</td>
							</tr>
							<?php } ?>
						</table>
					</div>
				</div>
			</div>
			
			<div class="form-group-setting">
				<div class="row">
					<div class="col-md-1">
						<?= Html::a('Back', ['master-hak-akses/index'], ['class'=>'btn lnj-type-button', 'style'=>'width:100%']) ?>
					</div>
					<div class="col-md-1">
						<?= Html::submitButton('Save', ['class' => 'btn btn-dark', 'style'=>'width:100%']) ?>
					</div>
				</div>
			</div>
		</div>
	</div>
    <?php ActiveForm::end(); ?>
</div>
