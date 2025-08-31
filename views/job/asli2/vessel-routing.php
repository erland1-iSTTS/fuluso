<?php
use yii\helpers\Url;
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
				<select class="form-select" style="width:75%" id="vessel_routing_search" name="MasterNewJobBooking[batch]" onchange="getVesselRouting()" required>
					<?php
						$master_vr = MasterVesselRouting::find()->where(['is_active'=>1])->limit(500)->orderBy(['id'=>SORT_ASC])->all();
						
						foreach($master_vr as $row){
							echo "<option></option>";
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
					<th width="12%">REFERENCE</th>
				</tr>
			</thead>
			<tbody>
				
			</tbody>
		</table>
	</div>
	
	<?php 
		$movement = Movement::find()->orderBy(['movement_name'=>SORT_ASC])->all();
		$point = Point::find()->where(['fd'=>1])->orderBy(['point_name'=>SORT_ASC])->all();
	?>
	
	<div class="col-md-12">
		<table class="table">
			<tr>
				<td width="16%" class="text-center">Place of Receipt</td>
				<td width="17%" class="text-center">SURABAYA, ID</td>
				<td width="17%" class="text-center border-right">
					<div class="form-group">
						<select class="form-select form-select-lg" id="place-receipt" name="MasterNewJobBooking[port_of_receipt]" required>
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
				</td>
				<td width="16%" class="text-center">Port of Loading</td>
				<td width="17%" class="text-center">SURABAYA, ID</td>
				<td width="17%" class="text-center">
					<div class="form-group">
						<select class="form-select form-select-lg" id="port-loading" name="MasterNewJobBooking[port_of_loading]" required>
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
				</td>
			</tr>
			<tr class="border-bottom">
				<td class="text-center">Port Of Discharge</td>
				<td class="text-center">SURABAYA, ID</td>
				<td class="text-center border-right">
					<div class="form-group">
						<select class="form-select form-select-lg" id="port-discharge" name="MasterNewJobBooking[port_of_discharge]" required>
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
				</td>
				<td class="text-center">Final Destination</td>
				<td class="text-center">
					<div class="form-group">
						<select class="form-select form-select-lg" id="final-destination" name="MasterNewJobBooking[final_destination]" required>
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
	});
	
	$('#vessel_routing_search').select2({
		placeholder: "Vessel & Routing",
	});
	
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
						item += '<td>'+value['reference']+'</td>';
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
