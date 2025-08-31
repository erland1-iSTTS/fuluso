<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use richardfan\widget\JSRegister;
?>

<style>
	.btn-menu{
		text-decoration: none;
		border: none;
		text-align: left;
		color: #337ab7;
	}
	
	.btn-menu:hover{
		color: #0a58ca;
	}
	
	.btn-menu:focus{
		box-shadow: none;
	}
	
	h2{
		font-size:30px !important;
	}
</style>

<div class="accordion" id="panel_job">
	<div class="card">
		<div class="card-header" id="heading9">
			<div class="row pl-2 pr-2">
				<h2 class="uncomplete m-0" style="width:92%" data-toggle="collapse" data-target="#collapse9">
					<button class="btn btn-menu" type="button" data-toggle="collapse" data-target="#collapse9">
						Party
					</button>
				</h2>
				<div class="uncomplete pr-3" style="width:8%">
					<button type="button" class="btn btn-dark float-right" id="btn_save_party" title="Save">
						<i class="fa fa-save"></i>
					</button>
				</div>
			</div>
		</div>
		
		<div id="collapse9" class="collapse" data-parent="#panel_job">
			<div class="card-body p-3">
				<?= $this->render('party', ['party' => $party, 'jobbooking' => $jobbooking]) ?>
			</div>
		</div>
	</div>
	
	<div class="card">
		<div class="card-header" id="heading1">
			<div class="row pl-2 pr-2">
				<h2 class="uncomplete m-0" style="width:92%" data-toggle="collapse" data-target="#collapse1">
					<button class="btn btn-menu" type="button" data-toggle="collapse" data-target="#collapse1">
						Vessel & Routing
					</button>
				</h2>
				<div class="uncomplete pr-3" style="width:8%">
					<button type="button" class="btn btn-dark float-right" id="btn_save_vessel_routing" title="Save">
						<i class="fa fa-save"></i>
					</button>
				</div>
			</div>
		</div>
		
		<div id="collapse1" class="collapse" data-parent="#panel_job">
			<div class="card-body p-3">
				<?= $this->render('vessel-routing', ['vessel_routing' => $vessel_routing, 'hblrouting' => $hblrouting,]) ?>
			</div>
		</div>
	</div>
	
	<div class="card">
		<div class="card-header" id="heading2">
			<div class="row pl-2 pr-2">
				<h2 class="uncomplete m-0" style="width:92%" data-toggle="collapse" data-target="#collapse2">
					<button class="btn btn-menu" type="button" data-toggle="collapse" data-target="#collapse2">
						Cargo
					</button>
				</h2>
				<div class="uncomplete pr-3" style="width:8%">
					<button type="button" class="btn btn-dark float-right" id="btn_save_cargo" title="Save">
						<i class="fa fa-save"></i>
					</button>
				</div>
			</div>
		</div>
		
		<div id="collapse2" class="collapse" data-parent="#panel_job">
			<div class="card-body p-3">
				<?php $form = ActiveForm::begin(['id' => 'form_cargo', 'action' => Url::base().'/job/save-cargo']); ?>
					<div id = "cargo-choose" style="display:block">
						<?= $this->render('cargo-choose', ['job' => $job, 'cargo' => $cargo,]) ?>
					</div>
					<div id = "cargo-input" style="display:none">
						<?= $this->render('cargo-input', ['cargo' => $cargo,]) ?>
					</div>
				<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div>

	<div class="card">
		<div class="card-header" id="heading3">
			<div class="row pl-2 pr-2">
				<h2 class="uncomplete m-0" style="width:92%" data-toggle="collapse" data-target="#collapse3">
					<button class="btn btn-menu" type="button" data-toggle="collapse" data-target="#collapse3">
						Description
					</button>
				</h2>
				<div class="uncomplete pr-3" style="width:8%">
					<button type="button" class="btn btn-dark float-right" id="btn_save_description" title="Save">
						<i class="fa fa-save"></i>
					</button>
				</div>
			</div>
		</div>
		
		<div id="collapse3" class="collapse" data-parent="#panel_job">
			<div class="card-body p-3">
				<?= $this->render('description', ['description' => $description,]) ?>
			</div>
		</div>
	</div>
	
	<div class="card">
		<div class="card-header" id="heading4">
			<div class="row pl-2 pr-2">
				<h2 class="uncomplete m-0" style="width:92%" data-toggle="collapse" data-target="#collapse4">
					<button class="btn btn-menu" type="button" data-toggle="collapse" data-target="#collapse4">
						Freight & Terms
					</button>
				</h2>
				<div class="uncomplete pr-3" style="width:8%">
					<button type="button" class="btn btn-dark float-right" id="btn_save_freight" title="Save">
						<i class="fa fa-save"></i>
					</button>
				</div>
			</div>
		</div>
		
		<div id="collapse4" class="collapse" data-parent="#panel_job">
			<div class="card-body p-3">
				<?= $this->render('freight-terms', ['freight_terms' => $freight_terms,]) ?>
			</div>
		</div>
	</div>
	
	<div class="card">
		<div class="card-header" id="heading8">
			<div class="row pl-2 pr-2">
				<h2 class="uncomplete m-0" style="width:92%" data-toggle="collapse" data-target="#collapse8">
					<button class="btn btn-menu" type="button" data-toggle="collapse" data-target="#collapse8">
						Reference
					</button>
				</h2>
				<div class="uncomplete pr-3" style="width:8%">
					<button type="button" class="btn btn-dark float-right" id="btn_save_reference" title="Save">
						<i class="fa fa-save"></i>
					</button>
				</div>
			</div>
		</div>
		
		<div id="collapse8" class="collapse" data-parent="#panel_job">
			<div class="card-body p-3">
				<?= $this->render('reference', ['reference' => $reference, 'ori_bl_batch' => $ori_bl_batch]) ?>
			</div>
		</div>
	</div>
	
	<div class="card">
		<div class="card-header" id="heading5">
			<div class="row pl-2 pr-2">
				<h2 class="uncomplete m-0" style="width:92%" data-toggle="collapse" data-target="#collapse5">
					<button class="btn btn-menu" type="button" data-toggle="collapse" data-target="#collapse5">
						Footer
					</button>
				</h2>
				<div class="uncomplete pr-3" style="width:8%">
					<button type="button" class="btn btn-dark float-right" id="btn_save_footer" title="Save">
						<i class="fa fa-save"></i>
					</button>
				</div>
			</div>
		</div>
		
		<div id="collapse5" class="collapse" data-parent="#panel_job">
			<div class="card-body p-3">
				<?= $this->render('footer', ['footer' => $footer,]) ?>
			</div>
		</div>
	</div>
	
	<!--<div class="card mb-5">
		<div class="card-header" id="heading6">
			<div class="row pl-2 pr-2">
				<h2 class="uncomplete m-0" style="width:100%;background-color:#eee" data-toggle="collapse" data-target="#collapse6">
					<button class="btn btn-menu" type="button" data-toggle="collapse" data-target="#collapse6">
						Notice of Arrival & Delivery Order Release
					</button>
				</h2>
			</div>
		</div>
		
		<div id="collapse6" class="collapse" data-parent="#panel_job">
			<div class="card-body p-3">
				<?php //$this->render('notice') ?>
			</div>
		</div>
	</div>-->
</div>

<script type="text/javascript">
	$(document).ready(function(){
		<?php if(!empty($cargo)){ ?>
			$('#cargo-choose').hide();
			$('#cargo-input').show();
			
			$('#heading2 h2').removeClass('uncomplete');
			$('#heading2 h2').addClass('complete');
			$('#heading2 .row div').removeClass('uncomplete');
			$('#heading2 .row div').addClass('complete');
		<?php } ?>
	});

	$('#btn_cargo_confirm').click(function(){
		$('#cargo-choose').hide();
		$('#cargo-input').show();
	});
	
	$('#btn_cargo_back').click(function(){
		$('#cargo-input').hide();
		$('#cargo-choose').show();
	});
	
	$('#btn_save_party').click(function(){
		// Also notify tidak wajib diisi
		checkbox_customer = $('.check_customer:checked').length;
		checkbox_shipper = $('.check_shipper:checked').length;
		checkbox_consignee = $('.check_consignee:checked').length;
		checkbox_agent = $('.check_agent:checked').length;
		checkbox_notify_party = $('.check_notify_party:checked').length;
		checkbox_also_notify = $('.check_also_notify:checked').length;
		checkbox_billing_party = $('.check_billing_party:checked').length;
		
		input_customer = $('.check_customer:checked').parent().parent().parent().find('select:eq(0)').val();
		input_shipper = $('.check_shipper:checked').parent().parent().parent().find('select:eq(0)').val();
		input_consignee = $('.check_consignee:checked').parent().parent().parent().find('select:eq(0)').val();
		input_agent = $('.check_agent:checked').parent().parent().parent().find('select:eq(0)').val();
		input_notify_party = $('.check_notify_party:checked').parent().parent().parent().find('select:eq(0)').val();
		input_also_notify  = $('.check_also_notify:checked').parent().parent().parent().find('select:eq(0)').val();
		input_billing_party = $('.check_billing_party:checked').parent().parent().parent().find('select:eq(0)').val();
		
		input_select = $('#party-index select').filter(function() { return this.value !== ""; }).length / 2;
		input_checkbox = $('#party-index input:checkbox:checked').length;
		
		// Also_notify tidak wajib diisi
		if(checkbox_customer > 0 && checkbox_shipper > 0 & checkbox_consignee > 0 && checkbox_agent > 0 && checkbox_notify_party > 0 && 
			input_customer !== null && input_shipper !== null & input_consignee !== null && input_agent !== null && input_notify_party !== null){
			$('#form_party').submit();
		}else{
			$('#error-party').show();
		}
	});
	
	$('#btn_save_vessel_routing').click(function(){
		//Check empty value
		if($('#vessel_routing_search').val() != ''){
			$('#form_vessel_routing').submit();
		}
	});
	
	$('#btn_save_cargo').click(function(){
		if($('#contain_type1').is(':checked') == true){
			lcl = $('#input-lcl').val();
			pack = $('#input-lcl-packages').val(); 
			
			if(lcl !== '' && pack !== ''){
				$('#form_cargo').submit();
				// setTimeout(function() { 
					// $('#shipping-mark').val('-');
					// $('#form_description').submit();
				// }, 1000);
			}
		}else{
			fcl = $('#input-fcl').val();
			con_list = $('#con_list label').length;
			input_package = $('.input_package').filter(function() { return $(this).val() == ""; }).length;
			
			if(fcl !== '' && con_list !== 0 && input_package < 1){
				$('#form_cargo').submit();
				// setTimeout(function() {
					// $('#form_description').submit();
				// }, 1000);
			}
		}
	});
	
	$('#btn_save_description').click(function(){
		//Check empty value
		// var empty_input = $('#form_description input').filter(function() { return this.value == ""; });
		
		// if(empty_input.length < 1 ){
			$('#form_description').submit();
		// }
	});
	
	$('#btn_save_freight').click(function(){
		$('#form_freight').submit();
	});
	
	$('#btn_save_reference').click(function(){
		//Check empty value
		var empty_input = $('#form_reference input :not(#oribatch-1, #oribatch-, #oribatch-3)').filter(function() { return this.value == ""; });
		
		if(empty_input.length < 1 ){
			$('#form_reference').submit();
		}
	});
	
	$('#btn_save_footer').click(function(){
		//Check empty value
		var empty_input = $('#form_footer input').filter(function() { return this.value == ""; });
		
		if(empty_input.length < 1 ){
			$('#form_footer').submit();
		}
	});
	
	function showinputcargo() {
		document.getElementById('cargo-choose').style.display = "none";
		document.getElementById('cargo-input').style.display = "block";
	}

	function showchoosecargo() {
		document.getElementById('cargo-choose').style.display = "block";
		document.getElementById('cargo-input').style.display = "none";
	} 
</script>
