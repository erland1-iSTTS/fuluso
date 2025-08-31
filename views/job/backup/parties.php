<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Customer;
use app\models\CustomerAlias;
?>

<?php
$customer = Customer::find()->where(['is_active'=>1])->orderBy(['customer_nickname'=>SORT_ASC])->all();
?>

<div id="parties-index">
<?php $form = ActiveForm::begin(['id' => 'form_parties', 'action' => Url::base().'/job/save-parties']); ?>
	<input type="hidden" value="<?= $_GET['id']?>" name="MasterNewJobBooking[id_job]">
	
	<div class="row m-0">
		<div class="col-md-6 pb-3 border-right">
			<label class="fw-normal">SHIPPER :</label>
			<div class="form-group">
				<select class="form-control" style="width:100%" id="shipper_nickname" name="MasterNewJobBooking[shipper1]" required>
					<option></option>
					<?php
						foreach($customer as $row){
							if(isset($parties->shipper1)){
								if($parties->shipper1 == $row['customer_id']){
									$selected = 'selected';
								}else{
									$selected = '';
								}
							}else{
								$selected = '';
							}
							echo "<option value='".$row['customer_id']."' ".$selected.">".
								$row['customer_nickname'].
							"</option>";
						}
					?>
				</select>
			</div>
			<div class="form-group">
				<select class="form-select form-select-lg" style="width:100%" id="shipper_alias" name="MasterNewJobBooking[shipper2]" required>
					<option value="" disabled selected hidden>Shipper Alias</option>
					<?php
						if(isset($parties->shipper1)){
							$customer_alias = CustomerAlias::find()->where(['customer_id'=>$parties->shipper1])->orderBy(['customer_name'=>SORT_ASC])->all();
							
							foreach($customer_alias as $row){
								if($parties->shipper2 == $row['customer_alias_id']){
									$selected = 'selected';
								}else{
									$selected = '';
								}
								
								echo "<option value='".$row['customer_alias_id']."' ".$selected.">".
									$row['customer_name'].
								"</option>";
							}
						}
					?>
				</select>
			</div>
			<div class="form-group">
				<textarea class="form-control" id="shipper_address" placeholder="Shipper Address" rows="5" name="MasterNewJobBooking[shipper3]" readonly><?php if($parties){echo str_replace("\\n","\n",$parties->shipper3);} ?></textarea>
			</div>
		</div>
		
		<div class="col-md-6 pb-3">
			<label class="fw-normal">CONSIGNEE :</label>
			<div class="form-group">
				<select class="form-select" style="width:100%" id="consignee_nickname" name="MasterNewJobBooking[consignee1]" required>
					<option></option>
					<?php
						foreach($customer as $row){
							if(isset($parties->consignee1)){
								if($parties->consignee1 == $row['customer_id']){
									$selected = 'selected';
								}else{
									$selected = '';
								}
							}else{
								$selected = '';
							}
							echo "<option value='".$row['customer_id']."' ".$selected.">".
								$row['customer_nickname'].
							"</option>";
						}
					?>
				</select>
			</div>
			<div class="form-group">
				<select class="form-select form-select-lg" style="width:100%" id="consignee_alias" name="MasterNewJobBooking[consignee2]" required>
					<option value="" disabled selected hidden>Consignee Alias</option>
					<?php
						if(isset($parties->consignee1)){
							$customer_alias = CustomerAlias::find()->where(['customer_id'=>$parties->consignee1])->orderBy(['customer_name'=>SORT_ASC])->all();
							
							foreach($customer_alias as $row){
								if($parties->consignee2 == $row['customer_alias_id']){
									$selected = 'selected';
								}else{
									$selected = '';
								}
								
								echo "<option value='".$row['customer_alias_id']."' ".$selected.">".
									$row['customer_name'].
								"</option>";
							}
						}
					?>
				</select>
			</div>
			<div class="form-group">
				<textarea class="form-control" id="consignee_address" placeholder="Consignee Address" rows="5" name="MasterNewJobBooking[consignee3]" readonly><?php if($parties){echo str_replace("\\n","\n",$parties->consignee3);} ?></textarea>
			</div>
		</div>
	</div>
	
	<div class="row m-0">
		<div class="col-md-6 pt-4 pb-3 border-top border-right border-bottom">
			<label class="fw-normal">NOTIFY PARTY :</label>
			<div class="form-group">
				<select class="form-select" style="width:100%" id="party_nickname" name="MasterNewJobBooking[notify1]" required>
					<option></option>
					<?php
						foreach($customer as $row){
							if(isset($parties->notify1)){
								if($parties->notify1 == $row['customer_id']){
									$selected = 'selected';
								}else{
									$selected = '';
								}
							}else{
								$selected = '';
							}
							echo "<option value='".$row['customer_id']."' ".$selected.">".
								$row['customer_nickname'].
							"</option>";
						}
					?>
				</select>
			</div>
			<div class="form-group">
				<select class="form-select form-select-lg" style="width:100%" id="party_alias" name="MasterNewJobBooking[notify2]" required>
					<option value="" disabled selected hidden>Notify Party Alias</option>
					<?php
						if(isset($parties->notify1)){
							$customer_alias = CustomerAlias::find()->where(['customer_id'=>$parties->notify1])->orderBy(['customer_name'=>SORT_ASC])->all();
							
							foreach($customer_alias as $row){
								if($parties->notify2 == $row['customer_alias_id']){
									$selected = 'selected';
								}else{
									$selected = '';
								}
								
								echo "<option value='".$row['customer_alias_id']."' ".$selected.">".
									$row['customer_name'].
								"</option>";
							}
						}
					?>
				</select>
			</div>
			<div class="form-group">
				<textarea class="form-control" id="party_address" placeholder="Notify Party Address" rows="5" name="MasterNewJobBooking[notify3]" readonly><?php if($parties){echo str_replace("\\n","\n",$parties->notify3);} ?></textarea>
			</div>
		</div>
		
		<div class="col-md-6 pt-4 pb-3 border-top border-bottom">
			<label class="fw-normal">CONTACT :</label>
			<div class="form-group">
				<select class="form-select" style="width:100%" id="contact_nickname" name="MasterNewJobBooking[contact1]" required>
					<option></option>
					<?php
						foreach($customer as $row){
							if(isset($parties->contact1)){
								if($parties->contact1 == $row['customer_id']){
									$selected = 'selected';
								}else{
									$selected = '';
								}
							}else{
								$selected = '';
							}
							echo "<option value='".$row['customer_id']."' ".$selected.">".
								$row['customer_nickname'].
							"</option>";
						}
					?>
				</select>
			</div>
			<div class="form-group">
				<select class="form-select form-select-lg" style="width:100%" id="contact_alias" name="MasterNewJobBooking[contact2]" required>
					<option value="" disabled selected hidden>Contact Alias</option>
					<?php
						if(isset($parties->contact1)){
							$customer_alias = CustomerAlias::find()->where(['customer_id'=>$parties->contact1])->orderBy(['customer_name'=>SORT_ASC])->all();
							
							foreach($customer_alias as $row){
								if($parties->contact2 == $row['customer_alias_id']){
									$selected = 'selected';
								}else{
									$selected = '';
								}
								
								echo "<option value='".$row['customer_alias_id']."' ".$selected.">".
									$row['customer_name'].
								"</option>";
							}
						}
					?>
				</select>
			</div>
			
			<div class="form-group">
				<textarea class="form-control" id="contact_address" placeholder="Contact Address" rows="5" name="MasterNewJobBooking[contact3]" readonly><?php if($parties){echo str_replace("\\n","\n",$parties->contact3);} ?></textarea>
			</div>
		</div>
	</div>
<?php ActiveForm::end(); ?>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		check_complete_parties();
	});
	
	$('#shipper_nickname').select2({
		placeholder: "Shipper Name",
	});
	$('#consignee_nickname').select2({
		placeholder: "Consignee Name",
	});
	$('#party_nickname').select2({
		placeholder: "Notify Party Name",
	});
	$('#contact_nickname').select2({
		placeholder: "Contact Name",
	});
	
	$('#shipper_nickname').change(function(){
		var id = $('#shipper_nickname').val();
		get_shipper(id);
		check_complete_parties();
	});
	
	$('#consignee_nickname').change(function(){
		var id = $('#consignee_nickname').val();
		get_consignee(id);
		check_complete_parties();
	});
	
	$('#party_nickname').change(function(){
		var id = $('#party_nickname').val();
		get_party(id);
		check_complete_parties();
	});
	
	$('#contact_nickname').change(function(){
		var id = $('#contact_nickname').val();
		get_contact(id);
		check_complete_parties();
	});
	
	// shipper
	function get_shipper(id){
		$.ajax({
			url: '<?=Url::base().'/job/get-customer-alias'?>',
			data: {'id':id},
			dataType: 'json',
			method: 'POST',
            async: 'false'
		}).done(function(res){
			if(res.list_customer)
			{
				var list = res.list_customer;
				
				$('#shipper_alias').find('option').remove().end();
				
				list.forEach(a => {
					$('#shipper_alias').append('<option value="'+a['customer_alias_id']+'">'+a['customer_name']+'</option>');
				});
			}
			if(res.address){
				$('#shipper_address').val(res.address);
			}
		}).fail(function(err){
			
		});
	}
	
	//consignee
	function get_consignee(id){
		$.ajax({
			url: '<?=Url::base().'/job/get-customer-alias'?>',
			data: {'id':id},
			dataType: 'json',
			method: 'POST',
            async: 'false'
		}).done(function(res){
			if(res.list_customer)
			{
				var list = res.list_customer;
				
				$('#consignee_alias').find('option').remove().end();
				
				list.forEach(a => {
					$('#consignee_alias').append('<option value="'+a['customer_alias_id']+'">'+a['customer_name']+'</option>');
				});
			}
			if(res.address){
				$('#consignee_address').val(res.address);
			}
		}).fail(function(err){
			
		});
	}
	
	//party
	function get_party(id){
		$.ajax({
			url: '<?=Url::base().'/job/get-customer-alias'?>',
			data: {'id':id},
			dataType: 'json',
			method: 'POST',
            async: 'false'
		}).done(function(res){
			if(res.list_customer)
			{
				var list = res.list_customer;
				
				$('#party_alias').find('option').remove().end();
				
				list.forEach(a => {
					$('#party_alias').append('<option value="'+a['customer_alias_id']+'">'+a['customer_name']+'</option>');
				});
			}
			if(res.address){
				$('#party_address').val(res.address);
			}
		}).fail(function(err){
			
		});
	}
	
	//contact
	function get_contact(id){
		$.ajax({
			url: '<?=Url::base().'/job/get-customer-alias'?>',
			data: {'id':id},
			dataType: 'json',
			method: 'POST',
            async: 'false'
		}).done(function(res){
			if(res.list_customer)
			{
				var list = res.list_customer;
				
				$('#contact_alias').find('option').remove().end();
				
				list.forEach(a => {
					$('#contact_alias').append('<option value="'+a['customer_alias_id']+'">'+a['customer_name']+'</option>');
				});
			}
			if(res.address){
				$('#contact_address').val(res.address);
			}
		}).fail(function(err){
			
		});
	}
	
	//check complete
	function check_complete_parties(){
		if($('#shipper_nickname').val() != '' && $('#consignee_nickname').val() != '' &&
			$('#party_nickname').val() != '' && $('#contact_nickname').val() != ''){
			$('#heading0 h2').removeClass('uncomplete');
			$('#heading0 h2').addClass('complete');
			$('#heading0 .row div').removeClass('uncomplete');
			$('#heading0 .row div').addClass('complete');
		}else{
			$('#heading0 h2').addClass('uncomplete');
			$('#heading0 h2').removeClass('complete');
			$('#heading0 .row div').addClass('uncomplete');	
			$('#heading0 .row div').removeClass('complete');
		}
	}
</script>
