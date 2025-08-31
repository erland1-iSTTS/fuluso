<?php 
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>

<div id="description-index">
<?php $form = ActiveForm::begin(['id' => 'form_description', 'action' => Url::base().'/job/save-description']); ?>
	<input type="hidden" value="<?= $_GET['id']?>" name="MasterG3eHblDescription[hbldes_job_id]">
	
	<div class="row">
		<div class="col-md-3 pr-1">
			<div class="form-group">
				<label class="fw-normal">Shipping Mark</label>
				<textarea class="form-control" id="shipping-mark" rows="15" name="MasterG3eHblDescription[hbldes_mark]" required><?php if($description){echo str_replace("\\n","\n",$description->hbldes_mark);} ?></textarea>
			</div>
		</div>
		
		<div class="col-md-2 pl-1 pr-1">
			<div class="form-group">
				<label class="fw-normal">Total No of Conts.</label>
				<textarea class="form-control" id="total-container" rows="15" name="MasterG3eHblDescription[hbldes_desofgood_text]" required><?php if($description){echo str_replace("\\n","\n",$description->hbldes_desofgood_text);} ?></textarea>
			</div>
		</div>
		
		<div class="col-md-4 pl-1 pr-1">
			<div class="form-group">
				<label class="fw-normal">Description of Goods</label>
				<textarea class="form-control" id="description-goods" rows="15" name="MasterG3eHblDescription[hbldes_desofgood]" required><?php if($description){echo str_replace("\\n","\n",$description->hbldes_desofgood);} ?></textarea>
			</div>
		</div>
		
		<div class="col-md-3 pl-1">
			<div class="form-group">
				<label class="fw-normal">Weight & Measurements</label>
				<textarea class="form-control text-right" id="weight-measurements" rows="15" name="MasterG3eHblDescription[hbldes_weight]" required><?php if($description){echo str_replace("\\n","\n",$description->hbldes_weight);} ?></textarea>
			</div>
		</div>
	</div>
<?php ActiveForm::end(); ?>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		check_complete_description();
	});
	
	$('#shipping-mark, #total-container, #description-goods, #weight-measurements').on('keyup', function(){
		check_complete_description();
	});
	
	//check complete
	function check_complete_description(){
		if($('#shipping-mark').val() != "" && $('#total-container').val() != "" && 
			$('#description-goods').val() != "" && $('#weight-measurements').val() != ""){
			$('#heading3 h2').removeClass('uncomplete');
			$('#heading3 h2').addClass('complete');
			$('#heading3 .row div').removeClass('uncomplete');	
			$('#heading3 .row div').addClass('complete');	
		}else{
			$('#heading3 h2').addClass('uncomplete');
			$('#heading3 h2').removeClass('complete');
			$('#heading3 .row div').addClass('uncomplete');
			$('#heading3 .row div').removeClass('complete');
		}
	}
</script>
