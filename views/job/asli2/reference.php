<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Office;
use app\models\Country;
use app\models\MasterNewJob;

$office = Office::find()->all();
$country = Country::find()->orderby(['name'=>SORT_ASC])->all();
$job = MasterNewJob::find()->where(['id'=>$_GET['id']])->one();
?>

<div id="freight-terms-index">
<?php $form = ActiveForm::begin(['id' => 'form_reference', 'action' => Url::base().'/job/save-reference']); ?>
	<input type="hidden" value="<?= $_GET['id']?>" name="MasterG3eJobrouting[jr_job_id]">
	
	<div class="col-md-12 mb-4">
		<h6>REFERENCE</h6>
	</div>
	
	<div class="row m-0">
		<div class="form-group col-12">
			<div class="row">
				<div class="col-2 ">
					<label class="fw-normal">Export Reference</label>
				</div>
				<div class="col-3">
					<input type="text" class="form-control" id="export_ref" value="<?php if($reference->jr_ref_number){echo $reference->jr_ref_number;} ?>" name="MasterG3eJobrouting[jr_ref_number]" required>
				</div>
			</div>
		</div>
		
		<div class="form-group col-12">
			<div class="row">
				<div class="col-2">
					<label class="fw-normal">MBL No.</label>
				</div>
				<div class="col-1 pr-0">
					<input type="text" class="form-control" maxlength="4" id="mbl_no1" value="<?php if($reference->jr_scac){echo $reference->jr_scac;} ?>" name="MasterG3eJobrouting[jr_scac]" required>
				</div>
				<div class="col-2">
					<input type="text" class="form-control" maxlength="10" id="mbl_no2" value="<?php if($reference->jr_mbl){echo $reference->jr_mbl;} ?>" name="MasterG3eJobrouting[jr_mbl]" required>
				</div>
			</div>
		</div>
		
		<div class="form-group col-12">
			<div class="row">
				<div class="col-2 ">
					<label class="fw-normal">HBL No.</label>
				</div>
				<div class="col-3">
					<input type="number" class="form-control" id="hbl_no" value="<?php if($reference->jr_hbl){echo $reference->jr_hbl;}else{echo $job->job_year.$job->job_month.$job->job_number;} ?>" name="MasterG3eJobrouting[jr_hbl]" required>
				</div>
			</div>
		</div>
		
		<div class="form-group col-12">
			<div class="row">
				<div class="pl-3" style="width:20%">
					<label class="fw-normal">Point and Country Of Origin</label>
				</div>
				<div class="col-3">
					<select class="form-control" id="reference_country" name="MasterG3eJobrouting[jr_country_origin]">
						<?php
							foreach($country as $row){
								if(isset($reference->jr_country_origin)){
									if($reference->jr_country_origin == $row['id']){
										$selected = 'selected';
									}else{
										$selected = '';
									}
								}else{
									if($row['name'] == 'INDONESIA'){
										$selected = 'selected';
									}else{
										$selected = '';
									}
								}
								
								echo "<option value='".$row['id']."' ".$selected.">".
									$row['name'].
								"</option>";
							}
						?>
					</select>
				</div>
			</div>
		</div>
		
		<div class="form-group col-12">
			<div class="row">
				<div  class="pl-3" style="width:20%">
					<label class="fw-normal">Origin To Be Released At</label>
				</div>
				<div class="col-3">
					<select class="form-control" id="origin_released" name="MasterG3eJobrouting[jr_office]">
						<?php
							foreach($office as $row){
								if(isset($reference->jr_office)){
									if($reference->jr_office == $row['office_code']){
										$selected = 'selected';
									}else{
										$selected = '';
									}
								}else{
									$selected = '';
								}
								
								echo "<option value='".$row['office_code']."' ".$selected.">".
									$row['office_name'].
								"</option>";
							}
						?>
					</select>
				</div>
			</div>
		</div>
	</div>
		
<?php ActiveForm::end(); ?>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		check_complete_reference();
	});
	
	$('#reference_country').select2({
		placeholder: "Customer Name",
	});
	
	$('#export_ref, #mbl_no1, #mbl_no2').on('keyup', function() {
		check_complete_reference();
	});
	
	$('#reference_country').change(function(){
		check_complete_reference();
	});
	
	$('#reference_country').change(function(){
		check_complete_reference();
	});
	
	//check complete
	function check_complete_reference(){
		if($('#export_ref').val() != '' && $('#mbl_no1').val() != '' &&
			$('#mbl_no2').val() != '' && $('#reference_country').val() != '' &&
			$('#origin_released').val() != ''){
			$('#heading8 h2').removeClass('uncomplete');
			$('#heading8 h2').addClass('complete');
			$('#heading8 .row div').removeClass('uncomplete');
			$('#heading8 .row div').addClass('complete');
		}else{
			$('#heading8 h2').addClass('uncomplete');
			$('#heading8 h2').removeClass('complete');
			$('#heading8 .row div').addClass('uncomplete');	
			$('#heading8 .row div').removeClass('complete');
		}
	}
</script>
