<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Batch;
use app\models\Point;
use app\models\Movement;
use app\models\MasterVesselRouting;
?>

<style type="text/css">
	table th{
		border: 0px!important;
	}
</style>

<div id="routing-index">
<?php $form = ActiveForm::begin(['id' => 'form_vessel_routing', 'action' => Url::base().'/job/save-vessel-routing']); ?>
	<input type="hidden" value="<?= $_GET['id']?>" name="MasterNewJobBooking[id_job]">

	<div style="margin:20px 0px 30px 20px">
		<div class="row">
			<div class="col-12">
				<label class="control-label align-middle"><b>Vessel & Routing &nbsp;:&nbsp;</b></label>
				<select class="form-select" style="width:75%" id="vessel_routing_search" name="MasterNewJobBooking[batch]" onchange="changeVesselRouting()" required>
					<?php
						$master_vr = MasterVesselRouting::find()->where(['is_active'=>1])->limit(500)->orderBy(['id'=>SORT_DESC])->all();
						
						foreach($master_vr as $row){
							echo "<option value='' <?= isset($vessel_routing->batch) ? '' : 'selected' ?> disabled hidden></option>";
							if(isset($vessel_routing->batch)){
								if($vessel_routing->batch == $row['id']){
									$selected = 'selected';
								}else{
									$selected = '';
								}
							}else{
								$selected = '';
							}
							echo "<option value=".$row['id']." ".$selected.">BT".
								sprintf("%08d", $row['id'])."&nbsp;&nbsp;-&nbsp;&nbsp;".
								$row['point_start']."/".
								$row['vessel_start']."/".
								$row['voyage_start']."/".
								$row['date_start']."&emsp;".
								$row['point_end']."/".
								$row['vessel_end']."/".
								$row['voyage_end']."/".
								$row['date_end'].
							"</option>";
						}
					?>
				</select>
			</div>
		</div>
	</div>

	<div class="col-md-12">
		<table class="table" id="table-batch">
			<thead class="table-secondary">
				<tr>
					<th width="20%">VESSEL</th>
					<th width="20%">VOYAGE</th>
					<th width="24%">ETD</th>
					<th width="24%">ETA</th>
					<!--<th width="12%">REFERENCE</th>-->
				</tr>
			</thead>
			<tbody>
				
			</tbody>
		</table>
	</div>
	
	<?php 
		$movement = Movement::find()->orderBy(['movement_name'=>SORT_ASC])->all();
		$point = Point::find()->orderBy(['point_name'=>SORT_ASC])->all();
	?>
	
	<div class="col-md-12">
		<table class="table">
			<tr>
				<td width="13%" class="text-center">Place of Receipt</td>
				<td width="20%" class="text-center">
					
					<!-- Place Of Receipt Input Select -->
					<div class="row" id="select_por">
						<div class="col-9 pr-0 form-group">
							<select class="form-select form-select-lg" id="place-receipt" name="MasterNewJobBooking[port_of_receipt]" onchange="select_por()" required>
								<?php
									foreach($point as $row){
										if(isset($vessel_routing->port_of_receipt)){
											if($vessel_routing->port_of_receipt == $row['point_code']){
												$selected = 'selected';
											}else{
												$selected = '';
											}
										}else{
											$selected = '';
										}
										echo "<option value='".$row['point_code']."' ".$selected.">".
											$row['point_name'].
										"</option>";
									}
								?>
							</select>
						</div>
						<div class="col-3 pl-0">
							<button type="button" class="btn btn-clear ml-1 w-100" onclick="select_por()" style="font-size: 12px !important">
								<i class="fa fa-check"></i>
							</button>
						</div>
					</div>
					
					<!-- Place Of Receipt Input Text -->
					<div class="row"  id="input_por">
						<div class="col-9 pr-0 form-group">
							<input type="text" class="form-control" id="place-receipt-text" value="<?= $hblrouting->place_of_receipt ?>" name="MasterG3eHblRouting[place_of_receipt]" required>
						</div>
						<div class="col-3 pl-0">
							<button type="button" class="btn btn-dark ml-1 w-100" onclick="change_por()" style="font-size: 12px !important">X</button>
						</div>
					</div>
				</td>
				<td width="17%" class="text-center border-right">&nbsp;</td>
				
				<td width="13%" class="text-center">Port of Loading</td>
				<td width="20%" class="text-center">
					<!-- Port of Loading Input Select -->
					<div class="row" id="select_pol">
						<div class="col-9 pr-0 form-group">
							<select class="form-select form-select-lg" id="port-loading" name="MasterNewJobBooking[port_of_loading]" onchange="select_pol()" required>
								<?php
									foreach($point as $row){
										if(isset($vessel_routing->port_of_loading)){
											if($vessel_routing->port_of_loading == $row['point_code']){
												$selected = 'selected';
											}else{
												$selected = '';
											}
										}else{
											$selected = '';
										}
										echo "<option value='".$row['point_code']."' ".$selected.">".
											$row['point_name'].
										"</option>";
									}
								?>
							</select>
						</div>
						<div class="col-3 pl-0">
							<button type="button" class="btn btn-clear ml-1 w-100" onclick="select_pol()" style="font-size: 12px !important">
								<i class="fa fa-check"></i>
							</button>
						</div>
					</div>
					
					<!-- Port of Loading Input Text -->
					<div class="row" id="input_pol">
						<div class="col-9 pr-0 form-group">
							<input type="text" class="form-control" id="port-loading-text" value="<?= $hblrouting->port_of_loading ?>" name="MasterG3eHblRouting[port_of_loading]" required>
						</div>
						<div class="col-3 pl-0">
							<button type="button" class="btn btn-dark ml-1 w-100" onclick="change_pol()" style="font-size: 12px !important">X</button>
						</div>
					</div>
				</td>
				<td width="17%" class="text-center">&nbsp;</td>
			</tr>
			
			<tr class="border-bottom">
				<td class="text-center">Port of Discharge</td>
				
				<td class="text-center">
					<!-- Port of Discharge Input Select -->
					<div class="row" id="select_pod">
						<div class="col-9 pr-0 form-group">
							<select class="form-select form-select-lg" id="port-discharge" name="MasterNewJobBooking[port_of_discharge]" onchange="select_pod()" required>
								<?php
									foreach($point as $row){
										if(isset($vessel_routing->port_of_discharge)){
											if($vessel_routing->port_of_discharge == $row['point_code']){
												$selected = 'selected';
											}else{
												$selected = '';
											}
										}else{
											$selected = '';
										}
										echo "<option value='".$row['point_code']."' ".$selected.">".
											$row['point_name'].
										"</option>";
									}
								?>
							</select>
						</div>
						<div class="col-3 pl-0">
							<button type="button" class="btn btn-clear ml-1 w-100" onclick="select_pod()" style="font-size: 12px !important">
								<i class="fa fa-check"></i>
							</button>
						</div>
					</div>
					
					<!-- Port of Discharge Input Text -->
					<div class="row" id="input_pod">
						<div class="col-9 pr-0 form-group">
							<input type="text" class="form-control" id="port-discharge-text" value="<?= $hblrouting->port_of_discharge ?>" name="MasterG3eHblRouting[port_of_discharge]" required>
						</div>
						<div class="col-3 pl-0">
							<button type="button" class="btn btn-dark ml-1 w-100" onclick="change_pod()" style="font-size: 12px !important">X</button>
						</div>
					</div>
				</td>
				
				<td class="text-center border-right"></td>
				<td class="text-center">Final Destination</td>
				<td class="text-center">
					<!-- Port of Delivery Input Select -->
					<div class="row" id="select_fod">
						<div class="col-9 pr-0 form-group">
							<select class="form-select form-select-lg" id="final-destination" name="MasterNewJobBooking[final_destination]" onchange="select_fod()" required>
								<?php
									foreach($point as $row){
										if(isset($vessel_routing->final_destination)){
											if($vessel_routing->final_destination == $row['point_code']){
												$selected = 'selected';
											}else{
												$selected = '';
											}
										}else{
											$selected = '';
										}
										echo "<option value='".$row['point_code']."' ".$selected.">".
											$row['point_name'].
										"</option>";
									}
								?>
							</select>
						</div>
						<div class="col-3 pl-0">
							<button type="button" class="btn btn-clear ml-1 w-100" onclick="select_fod()" style="font-size: 12px !important">
								<i class="fa fa-check"></i>
							</button>
						</div>
					</div>
					
					<!-- Port of Delivery Input Text -->
					<div class="row" id="input_fod">
						<div class="col-9 pr-0 form-group">
							<input type="text" class="form-control" id="final-destination-text" value="<?= $hblrouting->port_of_delivery ?>" name="MasterG3eHblRouting[port_of_delivery]" required>
						</div>
						<div class="col-3 pl-0">
							<button type="button" class="btn btn-dark ml-1 w-100" onclick="change_fod()" style="font-size: 12px !important">X</button>
						</div>
					</div>
				</td>
				<td class="text-center">
					<div class="form-group">
						<select class="form-select form-select-lg" name="MasterNewJobBooking[hblrouting_movement]" required>
							<?php
								foreach($movement as $row){
									if(isset($vessel_routing->hblrouting_movement)){
										if($vessel_routing->hblrouting_movement == $row['movement_id']){
											$selected = 'selected';
										}else{
											$selected = '';
										}
									}else{
										$selected = '';
									}
									echo "<option value='".$row['movement_id']."' ".$selected.">".
										$row['movement_name'].
									"</option>";
								}
							?>
						</select>
					</div>
				</td>
			</tr>
		</table>
	</div>
<?php ActiveForm::end(); ?>
</div>

<script>
	$(document).ready(function(){
		check_complete();
		
		<?php if(isset($vessel_routing->batch)){ ?>
			setTimeout(function(){
				getVesselRouting();
			}, 500);
		<?php } ?>
		
		<?php if(isset($hblrouting->place_of_receipt)){ ?>
			$('#select_por').hide();
			$('#input_por').show();
		<?php }else{ ?>
			$('#select_por').show();
			$('#input_por').hide();
		<?php } ?>
		
		<?php if(isset($hblrouting->port_of_loading)){ ?>
			$('#select_pol').hide();
			$('#input_pol').show();
		<?php }else{ ?>
			$('#select_pol').show();
			$('#input_pol').hide();
		<?php } ?>
		
		<?php if(isset($hblrouting->port_of_discharge)){ ?>
			$('#select_pod').hide();
			$('#input_pod').show();
		<?php }else{ ?>
			$('#select_pod').show();
			$('#input_pod').hide();
		<?php } ?>
		
		<?php if(isset($hblrouting->port_of_delivery)){ ?>
			$('#select_fod').hide();
			$('#input_fod').show();
		<?php }else{ ?>
			$('#select_fod').show();
			$('#input_fod').hide();
		<?php } ?>
	});
	
	$('#vessel_routing_search').select2({
		placeholder: "Vessel & Routing",
	});
	
	// First Page load
	function getVesselRouting(){
		var id = $('#vessel_routing_search').val();
		
		$.ajax({
			url: '<?=Url::base().'/job/get-vessel-routing'?>',
			data: {'id':id},
			dataType: 'json',
			method: 'POST',
            async: 'false'
		}).done(function(res){
			if(res.details){
				item = '';
				$(res.details).each(function(key, value){
					item += '<tr class="border-bottom">';
						item += '<td>'+value['vessel_code']+'</td>';
						item += '<td>'+value['voyage']+'</td>';
						item += '<td>'+value['point_etd']+' '+value['date_etd']+'</td>';
						item += '<td>'+value['point_eta']+' '+value['date_eta']+'</td>';
						// item += '<td>'+value['reference']+'</td>';
					item += '</tr>';
				});
				
				$('#table-batch tbody').html(item);
			}
			
			if(res.from && res.to){
				$('#job_from_to').html(res.from+' & '+res.to);
			}
			
			if(res.vessel){
				$('#ves').html(res.vessel);
			}
		}).fail(function(err){
			
		});
	}
	
	// Batch Change
	function changeVesselRouting(){
		var id = $('#vessel_routing_search').val();
		
		$.ajax({
			url: '<?=Url::base().'/job/get-vessel-routing'?>',
			data: {'id':id},
			dataType: 'json',
			method: 'POST',
            async: 'false'
		}).done(function(res){
			//Place of Receipt dan Port of Loading otomatis dr etd awal
			$('#place-receipt').val(res.from).trigger('change');
			$('#place-receipt-text').val(res.from);
			$('#select_por').hide();
			$('#input_por').show();
			
			$('#port-loading').val(res.from).trigger('change');
			$('#port-loading-text').val(res.from);
			$('#select_pol').hide();
			$('#input_pol').show();
			
			if(res.details){
				item = '';
				$(res.details).each(function(key, value){
					item += '<tr class="border-bottom">';
						item += '<td>'+value['vessel_code']+'</td>';
						item += '<td>'+value['voyage']+'</td>';
						item += '<td>'+value['point_etd']+' '+value['date_etd']+'</td>';
						item += '<td>'+value['point_eta']+' '+value['date_eta']+'</td>';
						// item += '<td>'+value['reference']+'</td>';
					item += '</tr>';
					
					//Port of discharge otomatis dr eta terakhir
					var isLastElement = key == res.details.length -1;
					if(isLastElement){
						$('#port-discharge').val(value['point_eta']).trigger('change');
						$('#port-discharge-text').val(value['point_eta']);
						$('#select_pod').hide();
						$('#input_pod').show();
					}
				});
				
				$('#table-batch tbody').html(item);
			}
			
			if(res.from && res.to){
				$('#job_from_to').html(res.from+' & '+res.to);
			}
			
			if(res.vessel){
				$('#ves').html(res.vessel);
			}
		}).fail(function(err){
			
		});
	}
	
	function select_por(){
		$('#select_por').hide();
		
		por = $('#place-receipt :selected').html();
		
		$('#place-receipt-text').val(por);
		$('#input_por').show();
	}
	
	function change_por(){
		$('#select_por').show();
		$('#input_por').hide();
	}
	
	function select_pol(){
		$('#select_pol').hide();
		
		pol = $('#port-loading :selected').html();
		
		$('#port-loading-text').val(pol);
		$('#input_pol').show();
	}
	
	function change_pol(){
		$('#select_pol').show();
		$('#input_pol').hide();
	}
	
	function select_pod(){
		$('#select_pod').hide();
		
		pod = $('#port-discharge :selected').html();
		
		$('#port-discharge-text').val(pod);
		$('#input_pod').show();
	}
	
	function change_pod(){
		$('#select_pod').show();
		$('#input_pod').hide();
	}
	
	function select_fod(){
		$('#select_fod').hide();
		
		fod = $('#final-destination :selected').html();
		
		$('#final-destination-text').val(fod);
		$('#input_fod').show();
	}
	
	function change_fod(){
		$('#select_fod').show();
		$('#input_fod').hide();
	}
	
	//check complete
	function check_complete(){
		if($('#vessel_routing_search').val() != '' && $('#place-receipt').val() != '' && 
			$('#port-loading').val() != '' && $('#port-discharge').val() != '' && 
			$('#final-destination').val() != ""){
			$('#heading1 h2').removeClass('uncomplete');
			$('#heading1 h2').addClass('complete');
			$('#heading1 .row div').removeClass('uncomplete');
			$('#heading1 .row div').addClass('complete');
		}else{
			$('#heading1 h2').addClass('uncomplete');
			$('#heading1 h2').removeClass('complete');
			$('#heading1 .row div').addClass('uncomplete');
			$('#heading1 .row div').removeClass('complete');
		}
	}
</script>
