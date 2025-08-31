<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use app\models\MasterNewJob;

$this->title = 'Create New Job';
?>

<style>
	.middle{
		display: flex;
		align-items: center;
	}
	
	.cursor-default{
		cursor: default;
	}
</style>


<div class="create-master-job">
	<div class="master-currency-form">
		<div class="overview-panel pl-3">
			<?php
				$job = MasterNewJob::find()->where(['job'=>'G3'])->orderby(['job_number'=>SORT_DESC])->one();
				$no =  $job->job_number + 1;
			?>
		
			<?php $form = ActiveForm::begin([
				'layout' => 'horizontal',
				'fieldConfig' => [
					'horizontalCssClasses' => [
						'label' => 'col-sm-2',
						'offset' => 'col-sm-offset-2',
						'wrapper' => 'col-sm-4',
					],
				],
			]); ?>
			
			<?= $form->field($model, 'job_number', ['options' => ['tag' => false]])->hiddenInput(['value'=>$no, 'readonly'=>true, 'maxlength' => true])->label(false) ?>
			
			<?php //$form->field($model, 'job_number_generate')->textInput(['readonly'=>true, 'maxlength' => true])->label('Create Job No') ?>
			
			<div class="row" style="margin:5px 0px 15px 0px">
				<div class="middle" style="width:12%">
					<b>Create Job No</b>
				</div>
				<div class="middle text-center" style="width:2%">
					:
				</div>
				<div class="middle" style="width:25%">
					<div id="masternewjob-job_number_generate"></div>
				</div>
			</div>
			
			<div class="row ml-0 mb-3">
				<div class="middle"  style="width:12%">
					<b>Username</b>
				</div>
				<div class="middle text-center" style="width:2%">
					:
				</div>
				<div class="middle" style="width:18%">
					Dessy
				</div>
				<div class="middle" style="width:8%">
					<b>Office</b>
				</div>
				<div class="middle text-center" style="width:2%">
					:
				</div>
				<div class="middle" style="width:24%">
					<div id="office_select">
						<span id="office">Surabaya</span>
						<button type="button" class="btn btn-dark ml-3" onclick="change_office()" style="font-size: 12px !important">Change</button>
					</div>
					<div id="office_choose" style="display: inline-flex;">
						<select class="form-control" id="job-office" name="MasterNewJob[job_location]" style="width:100%" required>
							<option value="SB">Surabaya</option>
							<option value="SR">Semarang</option>
							<option value="JK">Jakarta</option>
						</select>
						
						<button type="button" class="btn btn-dark ml-3" onclick="choose_office()" style="font-size: 12px !important">Choose</button>
					</div>
				</div>
				<div class="middle" style="width:8%">
					<b>Job Type</b>
				</div>
				<div class="middle text-center" style="width:2%">
					:
				</div>
				<div class="row middle m-0" style="width:20%">
					<div class="form-check form-check-inline m-0" style="padding:0px 1rem 0px 0.5rem" required>
						<input type="radio" class="form-check-input" id="job-job_type1" name="MasterNewJob[job_type]" value="E">
						<label class="form-check-label" for="job-job_type1">Export</label>
					</div>
					<div class="form-check form-check-inline m-0" style="padding-left:1.2rem">
						<input type="radio" class="form-check-input" id="job-job_type2" name="MasterNewJob[job_type]" value="I">
						<label class="form-check-label" for="job-job_type2">Import</label>
					</div>
				</div>
			</div>
			
			<div class="mb-1">
				<?= Html::submitButton('Confirm', ['class' => 'btn btn-dark', 'style' => 'font-size:12px !important;']) ?>
			</div>
			
			<?php ActiveForm::end(); ?>
		</div>	
	</div>
</div>

<div class="tab-content">
	<div class="tab-pane active" id="job">
		<ul class="nav nav-tabs job" role="tablist">
			<li class="nav-item" role="presentation"><a href="#" class="nav-link active cursor-default" role="tab" data-toggle="tab">Document</a></li>
			<li class="nav-item" role="presentation"><a href="#" class="nav-link cursor-default" role="tab" data-toggle="tab">Billling</a></li>
			<li class="nav-item" role="presentation"><a href="#" class="nav-link cursor-default" role="tab" data-toggle="tab">AR/ AP</a></li>
			<li class="nav-item" role="presentation"><a href="#" class="nav-link cursor-default" role="tab" data-toggle="tab">Final</a></li>
		</ul>
		<div class="tab-content job-content">
			<div class="tab-pane active" id="jobdoc" role="tabpanel"><?= $this->render('default/job-document') ?></div>
			<div class="tab-pane" id="jobbilling" role="tabpanel"></div>
			<div class="tab-pane" id="jobarap" role="tabpanel"></div>
			<div class="tab-pane" id="jobfinal" role="tabpanel"></div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		$('#office_choose').hide();
		
		var no = $('#masternewjob-job_number').val();
		var office = $('#job-office').val();
		var date = new Date();
		
		year  = date.getFullYear().toString().slice(-2);
		month = (date.getMonth() + 1).toString().padStart(2, "0");
		$('#masternewjob-job_number_generate').html('G3-'+'-'+office+year+month+no);
	});
	
	function change_office(){
		$('#office_select').hide();
		$('#office_choose').show();
	}
	
	function choose_office(){
		$('#office_select').show();
		$('#office_choose').hide();
		
		
		var no = $('#masternewjob-job_number').val();
		
		var office = $('#job-office').val();
		var office_name = $('#job-office option:selected').html();
		var date = new Date();
		
		year  = date.getFullYear().toString().slice(-2);
		month = (date.getMonth() + 1).toString().padStart(2, "0");
		
		if($('#job-job_type1').is(':checked')){
			var type = 'E';
		}else if($('#job-job_type2').is(':checked')){
			var type = 'I';
		}else{
			var type = '-';
		}
		
		$('#office').html(office_name);
		$('#masternewjob-job_number_generate').html('G3'+type+'-'+office+year+month+no);
	}
	
	$('#job-job_type1').on('change', function(){
		var no = $('#masternewjob-job_number').val();
		var office = $('#job-office').val();
		var date = new Date();
		
		year  = date.getFullYear().toString().slice(-2);
		month = (date.getMonth() + 1).toString().padStart(2, "0");
		
		$('#masternewjob-job_number_generate').html('G3E'+'-'+office+year+month+no);
	});
	
	$('#job-job_type2').on('change', function(){
		var no = $('#masternewjob-job_number').val();
		var office = $('#job-office').val();
		var date = new Date();
		
		year  = date.getFullYear().toString().slice(-2);
		month = (date.getMonth() + 1).toString().padStart(2, "0");
		
		$('#masternewjob-job_number_generate').html('G3I'+'-'+office+year+month+no);
	});
</script>