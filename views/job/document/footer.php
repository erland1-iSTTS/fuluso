<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Currency;
use app\models\Movement;
use app\models\Signature;
use app\models\Office;
use app\models\MasterNewJobBooking;
use app\models\MasterVesselRouting;
use app\models\Vessel;

date_default_timezone_set('Asia/Jakarta');
?>

<?php
$currency = Currency::find()->orderby(['currency_id'=>SORT_ASC])->all();
$movement = Movement::find()->orderby(['movement_name'=>SORT_ASC])->all();
$signature = Signature::find()->where(['is_active'=>1])->orderby(['signature_name'=>SORT_ASC])->all();
$office = Office::find()->all();
$job_routing = MasterNewJobBooking::find()->where(['id_job'=>$_GET['id']])->one();

if(isset($job_routing)){
	$vr = MasterVesselRouting::find()->where(['id'=>$job_routing->batch])->one();
	if(isset($vr)){
		$vessel = Vessel::find()->where(['vessel_code'=>$vr->laden_on_board])->one();
		
		$ves = $vr->laden_on_board.' - '.$vessel->vessel_name;
	}else{
		$ves = '-';
	}
}else{
	$ves = '-';
}

?>

<div id="freight-terms-index">
<?php $form = ActiveForm::begin(['id' => 'form_footer', 'action' => Url::base().'/job/save-footer']); ?>
	<input type="hidden" value="<?= $_GET['id']?>" name="MasterG3eHblDescription[hbldes_job_id]">
	
	<div class="row ml-0">
		<div class="col-md-5">
			<div class="row">
				<div class="col-md-5">
					<label class="fw-normal">Movement</label>
				</div>
				<div class="col-md-7">
					<div class="form-group">
						<?php
							$vesselrouting = MasterNewJobBooking::find()->where(['id_job' => $_GET['id']])->one();
							
							if(isset($vesselrouting)){
								$m = Movement::find()->where(['movement_id' => $vesselrouting['hblrouting_movement']])->one();
								if(isset($m)){
									echo $m->movement_name;
								}else{
									echo '-';
								}
							}else{
								echo '-';
							}
						?>
						<!--<select class="form-select form-select-lg" name="MasterG3eHblDescription[movement]">
							<?php
								/*foreach($movement as $row){
									echo "<option value='".$row['movement_id']."'>".
										$row['movement_name'].
									"</option>";
								}*/
							?>
						</select>-->
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-5 offset-md-1">
			<div class="row">
				<div class="col-md-5">
					<label class="fw-normal">Num of Original BL</label>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<input type="text" class="form-control" id="original-bl" placeholder="0" value="<?php if($footer){echo $footer->hbldes_original;} ?>" name="MasterG3eHblDescription[hbldes_original]" required>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row ml-0">
		<div class="col-md-5">
			<div class="row">
				<div class="col-md-5">
					<label>Declared Value</label>
				</div>
				<div class="col-md-3 pr-1">
					<div class="form-group">
						<select class="form-select form-select-lg" id="currency-id" name="MasterG3eHblDescription[hbldes_declared_list]" required>
							<?php
								foreach($currency as $row){
									if(isset($footer->hbldes_declared_list)){
										if($footer->hbldes_declared_list == $row['currency_id']){
											$selected = 'selected';
										}else{
											$selected = '';
										}
									}else{
										$selected = '';
									}
									
									echo "<option value='".$row['currency_id']."' ".$selected.">".
										$row['currency_id'].
									"</option>";
								}
							?>
						</select>
					</div>
				</div>
				<div class="col-md-2 pl-1 pr-1">
					<div class="form-group">
						<input type="text" class="form-control" id="currency" maxlength="12" placeholder="0" value="<?php if($footer){echo $footer->hbldes_declared_text1;} ?>" name="MasterG3eHblDescription[hbldes_declared_text1]" required>
					</div>
				</div>
				-
				<div class="col-md-1 pl-1" style="flex:0 0 15%;max-width:15%;">
					<div class="form-group">
						<input type="text" class="form-control" id="currency-decimal" maxlength="12" placeholder="00" value="<?php if($footer){echo $footer->hbldes_declared_text2;} ?>" name="MasterG3eHblDescription[hbldes_declared_text2]" required>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-5 offset-md-1 mb-2">
			<div class="row">
				<div class="col-md-5">
					<label class="fw-normal">Place of Issue</label>
				</div>
				<div class="col-md-7">
					<div class="form-group">
						<select class="form-select form-select-lg" name="MasterG3eHblDescription[hbldes_poi]" required>
							<?php
								foreach($office as $row){
									if(isset($footer->hbldes_poi)){
										if($footer->hbldes_poi == $row['office_code']){
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
	
	<div class="row ml-0">
		<div class="col-md-5">
			<div class="row">
				<div class="col-md-5">
					<label class="fw-normal">Laden On Board</label>
				</div>
				<div class="col-md-7">
					<div class="form-group">
						<?= $ves ?>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-5 offset-md-1 mb-3">
			<div class="row">
				<div class="col-md-5">
					<label class="fw-normal">Date of Issue</label>
				</div>
				<div class="col-md-7">
					<input type="date" class="form-control" id="date_issue" min="<?= date('Y-m-d') ?>" value="<?php if($footer){echo $footer->date_of_issue;} ?>" name="MasterG3eHblDescription[date_of_issue]" required>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row ml-0">
		<div class="col-md-5">
			<div class="row">
				<div class="col-md-5">
					<label class="fw-normal">Date</label>
				</div>
				<div class="col-md-7">
					<div class="form-group">
						<?php
							echo date('d F Y');
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-md-12"><hr class="mt-4"></div>
	
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-4">
				<label class="fw-normal">Signature</label>
			</div>
			<div class="col-md-8">
				<div class="form-group">
					<select class="form-select form-select-lg" id="sign_name" name="MasterG3eHblDescription[hbldes_signature]" required>
						<?php
							foreach($signature as $row){
								if(isset($footer->hbldes_signature)){
									if($footer->hbldes_signature == $row['signature_id']){
										$selected = 'selected';
									}else{
										$selected = '';
									}
								}else{
									$selected = '';
								}
								
								echo "<option value='".$row['signature_id']."' ".$selected.">".
									$row['signature_name'].
								"</option>";
							}
						?>
					</select>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-md-4 offset-md-2" style="clear:both">
		<div class="form-group">
			<textarea readonly class="form-control" id="sign-full" rows="7" name="MasterG3eHblDescription[hbldes_signature_text]" required><?php if($footer){echo str_replace("\\n","\n",$footer->hbldes_signature_text);} ?></textarea>
		</div>
	</div>
<?php ActiveForm::end(); ?>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#currency-id').val('IDR').trigger('change');
		
		check_complete_footer();
		
		setTimeout(function(){
			ajax_signature();
		}, 500);
	});
	
	$('#sign_name').change(function(){
		ajax_signature();
	});
	
	$('#original-bl, #currency, #currency-decimal').on('keyup', function(){
		check_complete_footer();
	});
	
	function ajax_signature(){
		var id = $('#sign_name').val();
		
		$.ajax({
			url: '<?=Url::base().'/job/get-signature'?>',
			data: {'id':id},
			dataType: 'json',
			method: 'POST',
            async: 'false'
		}).done(function(res){
			if(res.signature){
				$('#sign-full').val(res.signature['signature_name']);
			}
		}).fail(function(err){
			
		});
	}
	
	//check complete
	function check_complete_footer(){
		if($('#original-bl').val() != "" && $('#currency').val() != "" && $('#currency-decimal').val() != "" && $('#date_issue').val() != ""){
			$('#heading5 h2').removeClass('uncomplete');
			$('#heading5 h2').addClass('complete');
			$('#heading5 .row div').removeClass('uncomplete');	
			$('#heading5 .row div').addClass('complete');	
		}else{
			$('#heading5 h2').addClass('uncomplete');
			$('#heading5 h2').removeClass('complete');
			$('#heading5 .row div').addClass('uncomplete');
			$('#heading5 .row div').removeClass('complete');
		}
	}
</script>
