<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Office;
use app\models\Country;
use app\models\MasterNewJob;
use app\models\Carrier;

$office  = Office::find()->all();
$country = Country::find()->orderby(['name'=>SORT_ASC])->all();
$job 	 = MasterNewJob::find()->where(['id'=>$_GET['id']])->one();
$carrier = Carrier::find()->where(['is_active'=>1])->all();
?>

<div id="freight-terms-index">
<?php $form = ActiveForm::begin(['id' => 'form_reference', 'action' => Url::base().'/job/save-reference']); ?>
	<input type="hidden" value="<?= $_GET['id']?>" name="MasterG3eJobrouting[jr_job_id]">
	
	<div class="col-md-12 mb-4">
		<h6>REFERENCE</h6>
	</div>
	
	<div style="display:flex">
		<!-- Left -->
		<div style="width:50%">
			<div class="form-group col-12">
				<div class="row">
					<div class="col-3">
						<label class="fw-normal">Export Reference</label>
					</div>
					<div class="col-8">
						<?php
							if($reference->jr_ref_number){
								// $text = explode('\n', nl2br($reference->jr_ref_number));
								$text = preg_split('/\n/',$reference->jr_ref_number);
							}
						?>
					
						<!--<input type="text" class="form-control" id="export_ref" value="<?php //if($reference->jr_ref_number){echo $reference->jr_ref_number;} ?>" name="MasterG3eJobrouting[jr_ref_number]" required>-->
						<input type="text" class="form-control" id="export_ref" value="<?= isset($text[0]) ? $text[0] : '' ?>" name="MasterG3eJobrouting[jr_ref_number1]" required>
						<input type="text" class="form-control" id="export_ref2" value="<?= isset($text[1]) ? $text[1] : '' ?>" name="MasterG3eJobrouting[jr_ref_number2]">
						<input type="text" class="form-control" id="export_ref3" value="<?= isset($text[2]) ? $text[2] : '' ?>" name="MasterG3eJobrouting[jr_ref_number3]">
						<input type="text" class="form-control" id="export_ref4" value="<?= isset($text[3]) ? $text[3] : '' ?>" name="MasterG3eJobrouting[jr_ref_number4]">
					</div>
				</div>
			</div>
			
			<div class="form-group col-12">
				<div class="row">
					<div class="col-3">
						<label class="fw-normal">MBL No.</label>
					</div>
					<div class="col-3 pr-0">
						<input type="text" class="form-control" maxlength="5" id="mbl_no1" value="<?php if($reference->jr_scac){echo $reference->jr_scac;} ?>" name="MasterG3eJobrouting[jr_scac]" required>
					</div>
					<div class="col-5">
						<input type="text" class="form-control" maxlength="15" id="mbl_no2" value="<?php if($reference->jr_mbl){echo $reference->jr_mbl;} ?>" name="MasterG3eJobrouting[jr_mbl]" required>
					</div>
				</div>
			</div>
			
			<div class="form-group col-12">
				<div class="row">
					<div class="col-3">
						<label class="fw-normal">HBL No.</label>
					</div>
					<div class="col-8">
						<input type="number" class="form-control" id="hbl_no" value="<?php if(isset($reference->jr_hbl) && !empty($reference->jr_hbl)){echo $reference->jr_hbl;} ?>" name="MasterG3eJobrouting[jr_hbl]">
					</div>
				</div>
			</div>
			
			<div class="form-group col-12">
				<div class="row">
					<div class="col-3">
						<label class="fw-normal">House SCAC</label>
					</div>
					<div class="col-8">
						<input type="text" class="form-control" id="ref-house_scac" value="<?php if($reference->jr_house_scac){echo $reference->jr_house_scac;} ?>" name="MasterG3eJobrouting[jr_house_scac]" required>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Right -->
		<div style="width:50%">
			<div class="form-group col-12">
				<div class="row">
					<div class="col-4">
						<label class="fw-normal">Type</label>
					</div>
					
					<div class="col-7">
						<div class="flex">
							<div class="form-check form-check-inline m-0" style="padding:0px 5px;">
								<input type="radio" class="form-check-input" id="ref-type1" name="MasterG3eJobrouting[jr_type]" value="house" <?php if(isset($reference->jr_type)){ if($reference->jr_type == 'house'){ echo 'checked'; }}?>>
								<label class="form-check-label" for="ref-type1">House</label>
							</div>
							<div class="form-check form-check-inline m-0" style="padding:0px 5px;">
								<input type="radio" class="form-check-input" id="ref-type2" name="MasterG3eJobrouting[jr_type]" value="master" <?php if(isset($reference->jr_type)){ if($reference->jr_type == 'master'){ echo 'checked'; }}?>>
								<label class="form-check-label" for="ref-type2">Master</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="form-group col-12">
				<div class="row">
					<div class="col-4 pr-0">
						<label class="fw-normal">Carrier</label>
					</div>
					<div class="col-7">
						<select class="form-control" id="ref-carrier" name="MasterG3eJobrouting[jr_crcode_list]">
							<?php
								foreach($carrier as $row){
									if(!empty($reference->jr_crcode_list)){
										if($reference->jr_crcode_list == $row['carrier_id']){
											$selected = 'selected';
										}else{
											$selected = '';
										}
									}else{
										$selected = '';
									}
									
									echo "<option value='".$row['carrier_id']."' ".$selected.">".
										$row['carrier_code'].
									"</option>";
								}
							?>
						</select>
					</div>
				</div>
			</div>
			
			<div class="form-group col-12">
				<div class="row">
					<div class="col-4 pr-0">
						<label class="fw-normal">Point and Country Of Origin</label>
					</div>
					<div class="col-7">
						<select class="form-control" id="reference_country" name="MasterG3eJobrouting[jr_country_origin]">
							<?php
								foreach($country as $row){
									if(!empty($reference->jr_country_origin)){
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
					<div class="col-4 pr-0">
						<label class="fw-normal">Origin To Be Released At</label>
					</div>
					<div class="col-7">
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
	</div>	
	
	<div class="col-md-12"><hr class="mt-1"></div>
	
	<div class="col-md-12 mb-4">
		<h6>BATCH ORIGINAL</h6>
	</div>
	
	<div class="row form-group m-0">
		<div class="ml-3">
			<label class="fw-normal">Batch #1</label>
		</div>
		<div class="col-3">
			<input type="text" class="form-control" disabled id="oribatch-1" value="<?php if($ori_bl_batch->batchform_1){echo $ori_bl_batch->batchform_1;} ?>" name="MasterG3eBatch[batchform_1]">
		</div>
		
		&emsp;&emsp;&emsp;
		
		<div class="">
			<label class="fw-normal">Batch #2</label>
		</div>
		<div class="col-3">
			<input type="text" class="form-control" disabled id="oribatch-2" value="<?php if($ori_bl_batch->batchform_2){echo $ori_bl_batch->batchform_2;} ?>" name="MasterG3eBatch[batchform_2]">
		</div>
		
		&emsp;&emsp;&emsp;
		
		<div class="">
			<label class="fw-normal">Batch #3</label>
		</div>
		<div class="col-3">
			<input type="text" class="form-control" disabled id="oribatch-3" value="<?php if($ori_bl_batch->batchform_3){echo $ori_bl_batch->batchform_3;} ?>" name="MasterG3eBatch[batchform_3]">
		</div>
	</div>
<?php ActiveForm::end(); ?>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		check_complete_reference();
		
		//Jika type kosong, mk default house
		if(!$('#ref-type1').is(':checked') && !$('#ref-type2').is(':checked')){
			$('#ref-type1').prop('checked',true);
		}
	});
	
	$('#ref-carrier').select2({
		placeholder: "Carrier",
	});
	
	$('#reference_country').select2({
		placeholder: "Country",
	});
	
	$('#export_ref, #mbl_no1, #mbl_no2, #ref-house_scac').on('keyup', function(){
		check_complete_reference();
	});
	
	//check complete
	function check_complete_reference(){
		if($('#export_ref').val() != '' && $('#mbl_no1').val() != '' &&
			$('#mbl_no2').val() != '' && $('#ref-house_scac').val() != ''){
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
