<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use richardfan\widget\JSRegister;
use app\models\Customer;

$customer = Customer::find()->orderBy(['customer_companyname'=>SORT_ASC])->all();
?>

<div id="party-counter-index">
	<form action="">
		<div class="row m-0">
			<div class="col-md-6 pb-3 border-right">
				<div class="row d-flex justify-content-between m-0">
					<label class="fw-normal">CUSTOMER :</label>
					<div class="form-check form-check-inline mb-2 ml-2">
						<input type="checkbox" class="form-check-input customer_as" id="as_billing1">
						<label class="form-check-label" for="as_billing1" style="font-size:12px">AS BILLING PARTY</label>
					</div>
					
					<div class="form-check form-check-inline mb-2">
						<input type="checkbox" class="form-check-input customer_as" id="as_shipper">
						<label class="form-check-label" for="as_shipper" style="font-size:12px">AS SHIPPER</label>
					</div>
					
					<div class="form-check form-check-inline mb-2">
						<input type="radio" class="form-check-input" id="idt" name="input2">
						<label class="form-check-label" for="idt" style="font-size:12px">IDT</label>
					</div>
					<div class="form-check form-check-inline mb-2">
						<input type="radio" class="form-check-input" id="hmc" name="input2">
						<label class="form-check-label" for="hmc" style="font-size:12px">HMC</label>
					</div>
					<div class="form-check form-check-inline mb-2 mr-0">
						<input type="radio" class="form-check-input" id="both" name="input2">
						<label class="form-check-label" for="both" style="font-size:12px">BOTH</label>
					</div>
				</div>
				
				<div class="form-group">
					<select class="form-control" style="width:100%" id="customer_nickname">
						<option></option>
						<?php
							foreach($customer as $row){
								echo "<option value='".$row['customer_id']."'>".
									$row['customer_nickname'].
								"</option>";
							}
						?>
					</select>
				</div>
				<div class="form-group">
					<select class="form-select form-select-lg" style="width:100%" id="customer_alias" required>
						<option value="" disabled selected hidden>Customer Alias</option>
					</select>
				</div>
				<div class="form-group">
					<textarea class="form-control" id="customer_address" placeholder="Customer Address" rows="5" readonly></textarea>
				</div>
			</div>
			
			<div class="col-md-6 pb-3">
				<div class="row d-flex justify-content-between m-0">
					<label class="fw-normal">ROUTING PARTY :</label>
					<div class="form-check form-check-inline mb-2 ml-2">
						<input type="checkbox" class="form-check-input" id="as_billing2">
						<label class="form-check-label" for="as_billing2" style="font-size:12px">AS BILLING PARTY</label>
					</div>
				</div>
				
				<div class="form-group">
					<select class="form-select" style="width:100%" id="routing_party_nickname">
						<option></option>
						<?php
							foreach($customer as $row){
								echo "<option value='".$row['customer_id']."'>".
									$row['customer_nickname'].
								"</option>";
							}
						?>
					</select>
				</div>
				<div class="form-group">
					<select class="form-select form-select-lg" style="width:100%" id="routing_party_alias" required>
						<option value="" disabled selected hidden>Routing Party Alias</option>
					</select>
				</div>
				<div class="form-group">
					<textarea class="form-control" id="routing_party_address" placeholder="Routing Party Address" rows="5" readonly></textarea>
				</div>
			</div>
		</div>
		
		<div class="row m-0">
			<div class="col-md-6 pt-4 pb-3 border-top border-right border-bottom">
				<div class="row d-flex justify-content-between m-0">
					<label class="fw-normal">AGENT :</label>
					<div class="form-check form-check-inline mb-2 ml-2">
						<input type="checkbox" class="form-check-input" id="as_billing3">
						<label class="form-check-label" for="as_billing3" style="font-size:12px">AS BILLING PARTY</label>
					</div>
				</div>
				
				<div class="form-group">
					<select class="form-select" style="width:100%" id="agent_nickname">
						<option></option>
						<?php
							foreach($customer as $row){
								echo "<option value='".$row['customer_id']."'>".
									$row['customer_nickname'].
								"</option>";
							}
						?>
					</select>
				</div>
				<div class="form-group">
					<select class="form-select form-select-lg" style="width:100%" id="agent_alias" required>
						<option value="" disabled selected hidden>Agent Alias</option>
					</select>
				</div>
				<div class="form-group">
					<textarea class="form-control" id="agent_address" placeholder="Agent Address" rows="5" readonly></textarea>
				</div>
			</div>
			
			<div class="col-md-6 pt-4 pb-3 border-top border-bottom" id="div-shipper-counter">
				<div class="row d-flex justify-content-between m-0">
					<label class="fw-normal">SHIPPER :</label>
					<div class="form-check form-check-inline mb-2 ml-2">
						<input type="checkbox" class="form-check-input" id="as_billing4">
						<label class="form-check-label" for="as_billing4" style="font-size:12px">AS BILLING PARTY</label>
					</div>
				</div>
				
				<div class="form-group">
					<select class="form-select" style="width:100%" id="shipper_counter_nickname">
						<option></option>
						<?php
							foreach($customer as $row){
								echo "<option value='".$row['customer_id']."'>".
									$row['customer_nickname'].
								"</option>";
							}
						?>
					</select>
				</div>
				<div class="form-group">
					<select class="form-select form-select-lg" style="width:100%" id="shipper_counter_alias" required>
						<option value="" disabled selected hidden>Shipper Alias</option>
					</select>
				</div>
				
				<div class="form-group">
					<textarea class="form-control" id="shipper_counter_address" placeholder="Shipper Address" rows="5" readonly></textarea>
				</div>
			</div>
			<div class="col-md-6 pt-4 pb-3 border-top border-bottom" id="div-shipper-counter-same" style="display:none">
				<label class="fw-normal">SHIPPER :</label><br>
				SAME AS CUSTOMER
			</div>
		</div>
		
		<div class="row m-0" id="list-billing-party">
			<div class="col-md-6 pt-4 pb-3 border-top border-bottom">
				<label class="fw-normal mb-3">BILLING PARTY :</label>
				<div class="form-group">
					<select class="form-select" style="width:100%" id="billing_party_nickname">
						<option></option>
						<?php
							foreach($customer as $row){
								echo "<option value='".$row['customer_id']."'>".
									$row['customer_nickname'].
								"</option>";
							}
						?>
					</select>
				</div>
				<div class="form-group">
					<select class="form-select form-select-lg" style="width:100%" id="billing_party_alias" required>
						<option value="" disabled selected hidden>Billing Party Alias</option>
					</select>
				</div>
				<div class="form-group">
					<textarea class="form-control" id="billing_party_address" placeholder="Billing Party Address" rows="5" readonly></textarea>
				</div>
			</div>
		</div>
		
		<button type="button" class="btn btn-dark mb-2" id="add_billing_party" style="margin:10px 20px">+ Add</button>
	</form>
</div>

<script>
	$(document).ready(function(){
		check_complete_parties();
	});
	
	$('#customer_nickname').select2({
		placeholder: "Customer Name",
	});
	$('#routing_party_nickname').select2({
		placeholder: "Routing Party Name",
	});
	$('#agent_nickname').select2({
		placeholder: "Agent Name",
	});
	$('#shipper_counter_nickname').select2({
		placeholder: "Shipper Name",
	});
	
	$('#billing_party_nickname').select2({
		placeholder: "Billing Party Nickname",
	});
	
	/*$('.billing_party_nickname').select2({
		placeholder: "Billing Party Nickname",
	});*/
	
	$('#customer_nickname').change(function(){
		var id = $('#customer_nickname').val();
		get_customer(id);
		check_complete_counter_party();
	});
	
	$('#routing_party_nickname').change(function(){
		var id = $('#routing_party_nickname').val();
		get_routing_party(id);
		check_complete_counter_party();
	});
	
	$('#agent_nickname').change(function(){
		var id = $('#agent_nickname').val();
		get_agent(id);
		check_complete_counter_party();
	});
	
	$('#shipper_counter_nickname').change(function(){
		var id = $('#shipper_counter_nickname').val();
		get_shipper_counter(id);
		check_complete_counter_party();
	});
	
	$('#billing_party_nickname').change(function(){
		var id = $('#billing_party_nickname').val();
		get_billing_party(id);
		check_complete_counter_party();
	});
	
	$('.customer_as').on('change', function(){
	   $('.customer_as').not(this).prop('checked', false);
	});
	
	$('#as_shipper').on('click', function(){
		if($('#as_shipper').is(":checked")){
			$('#div-shipper-counter').hide();
			$('#div-shipper-counter-same').show();
		}else{
			$('#div-shipper-counter').show();
			$('#div-shipper-counter-same').hide();
		}
	});
	
	$('#as_billing1').on('click', function(){
		$('#div-shipper-counter').show();
		$('#div-shipper-counter-same').hide();
	});
	
	$('#add_billing_party').on('click', function(){
		$('#list-billing-party').children().eq(0).addClass('border-right');
		$('#list-billing-party').children().eq(2).addClass('border-right');
		
		id = $('#list-billing-party').children().eq($('#list-billing-party').children().length-1).attr('id');
        if(id){
            row = parseInt(id.split('-')[1])+1;
        }else{
            row = 0;
		}
		
		item = '<div class="col-md-6 pt-4 pb-3 border-top border-bottom" id="billing-'+row+'">';
			item += '<div class="row d-flex justify-content-between m-0">';
				item += '<label class="fw-normal mb-3">BILLING PARTY :</label>';
				item += '<button type="button" class="btn btn-xs btn-danger mb-2" onclick="removeItem($(this))"><i class="fa fa-trash"></i></button>';
			item += '</div>';
			
			item += '<div class="form-group">';
				item += '<select class="form-select billing_party_nickname select2" style="width:100%" id="billing_party_nickname-'+row+'" onchange="get_billing_party2($(this))">';
					item += '<option></option>';
					item += "<?php
						foreach($customer as $row){
							echo "<option value='".$row['customer_id']."'>".
								$row['customer_nickname'].
							"</option>";
						}
					?>";
				item += '</select>';
			item += '</div>';
			item += '<div class="form-group">';
				item += '<select class="form-select form-select-lg" style="width:100%" id="billing_party_alias-'+row+'" required>';
					item += '<option value="" disabled selected hidden>Billing Party Alias</option>';
				item += '</select>';
			item += '</div>';
			item += '<div class="form-group">';
				item += '<textarea class="form-control" id="billing_party_address-'+row+'" placeholder="Billing Party Address" rows="5" readonly></textarea>';
			item += '</div>';
		item += '</div>';
		
		$('#list-billing-party').append(item);
		
		// $('.select2').select2();
		
		// Maksimal Append 3 kali, maka button akan hilang
		count = $('.billing_party_nickname').length;
		if(count == 3){
			$('#add_billing_party').hide();
		}
	});
	
	function removeItem(el)
    {
		el.parent().parent().remove();
		
		// If append billing party < 3, maka button add akan tampil
		count = $('.billing_party_nickname').length;
		if(count < 3){
			$('#add_billing_party').show();
		}
    }
	
	//customer
	function get_customer(id){
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
				
				$('#customer_alias').find('option').remove().end();
				
				list.forEach(a => {
					$('#customer_alias').append('<option value="'+a['customer_alias_id']+'">'+a['customer_name']+'</option>');
				});
			}
			if(res.address){
				$('#customer_address').val(res.address);
			}
		}).fail(function(err){
			
		});
	}
	
	//routing_party
	function get_routing_party(id){
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
				
				$('#routing_party_alias').find('option').remove().end();
				
				list.forEach(a => {
					$('#routing_party_alias').append('<option value="'+a['customer_alias_id']+'">'+a['customer_name']+'</option>');
				});
			}
			if(res.address){
				$('#routing_party_address').val(res.address);
			}
		}).fail(function(err){
			
		});
	}
	
	//agent
	function get_agent(id){
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
				
				$('#agent_alias').find('option').remove().end();
				
				list.forEach(a => {
					$('#agent_alias').append('<option value="'+a['customer_alias_id']+'">'+a['customer_name']+'</option>');
				});
			}
			if(res.address){
				$('#agent_address').val(res.address);
			}
		}).fail(function(err){
			
		});
	}
	
	//shipper_counter
	function get_shipper_counter(id){
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
				
				$('#shipper_counter_alias').find('option').remove().end();
				
				list.forEach(a => {
					$('#shipper_counter_alias').append('<option value="'+a['customer_alias_id']+'">'+a['customer_name']+'</option>');
				});
			}
			if(res.address){
				$('#shipper_counter_address').val(res.address);
			}
		}).fail(function(err){
			
		});
	}
	
	//billing party
	function get_billing_party(id){
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
				
				$('#billing_party_alias').find('option').remove().end();
				
				list.forEach(a => {
					$('#billing_party_alias').append('<option value="'+a['customer_alias_id']+'">'+a['customer_name']+'</option>');
				});
			}
			if(res.address){
				$('#billing_party_address').val(res.address);
			}
		}).fail(function(err){
			
		});
	}
	
	//billing party append
	function get_billing_party2(el){
		id = el.attr('id');
		idx = id.split('-')[1];
		
		key = $('#'+id).val();
		
		$.ajax({
			url: '<?=Url::base().'/job/get-customer-alias'?>',
			data: {'id':key},
			dataType: 'json',
			method: 'POST',
            async: 'false'
		}).done(function(res){
			if(res.list_customer)
			{
				var list = res.list_customer;
				
				$('#billing_party_alias-'+idx).find('option').remove().end();
				
				list.forEach(a => {
					$('#billing_party_alias-'+idx).append('<option value="'+a['customer_alias_id']+'">'+a['customer_name']+'</option>');
				});
			}
			if(res.address){
				$('#billing_party_address-'+idx).val(res.address);
			}
		}).fail(function(err){
			
		});
	}
	
	//check complete
	function check_complete_counter_party(){
		if($('#customer_nickname').val() != '' && $('#routing_party_nickname').val() != '' &&
			$('#agent_nickname').val() != '' && $('#billing_party_nickname').val() != ''){
			$('#heading7 h2').removeClass('uncomplete');
			$('#heading7 h2').addClass('complete');
			$('#heading7 .row div').removeClass('uncomplete');
			$('#heading7 .row div').addClass('complete');
		}else{
			$('#heading7 h2').addClass('uncomplete');
			$('#heading7 h2').removeClass('complete');
			$('#heading7 .row div').addClass('uncomplete');	
			$('#heading7 .row div').removeClass('complete');
		}
	}
</script>
