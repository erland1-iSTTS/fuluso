<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Batch;
use app\models\Point;
use app\models\Movement;
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
				<select class="form-select" style="width:75%" id="batchsearch" name="MasterNewJobBooking[batch]" onchange="getbatch()">
					<?php
						$batch = Batch::find()->where(['is_active'=>1])->limit(500)->orderBy(['batch_id'=>SORT_ASC])->all();
						
						foreach($batch as $row){
							if(isset($vessel_routing->batch)){
								if($vessel_routing->batch == $row['batch_id']){
									$selected = 'selected';
								}else{
									$selected = '';
								}
							}else{
								$selected = '';
							}
							echo "<option value=".$row['batch_id']." ".$selected.">BT".
								sprintf("%08d", $row['batch_id'])."&nbsp;&nbsp;-&nbsp;&nbsp;".
								$row['pol_id']."/".
								$row['pc_vessel']."/".
								$row['pc_voyage']."/".
								$row['pol_dod']."&emsp;".
								$row['pod_id']."/".
								$row['lfp_vessel']."/".
								$row['lfp_voyage']."/".
								$row['pod_doa'].
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
					<th width="25%">Vessel</th>
					<th width="25%">Voyage</th>
					<th width="25%">ETD</th>
					<th width="25%">ETA</th>
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
						<select class="form-select form-select-lg" id="place-receipt" name="MasterNewJobBooking[port_of_receipt]">
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
						<select class="form-select form-select-lg" id="port-loading" name="MasterNewJobBooking[port_of_loading]">
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
						<select class="form-select form-select-lg" id="port-discharge" name="MasterNewJobBooking[port_of_discharge]">
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
						<select class="form-select form-select-lg" id="final-destination" name="MasterNewJobBooking[final_destination]">
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
						<select class="form-select form-select-lg" name="MasterNewJobBooking[hblrouting_movement]">
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
		
		setTimeout(function(){
			getbatch();
		}, 500);
	});
	
	$('#batchsearch').select2();
	
	function getbatch(){
		var id = $('#batchsearch').val();
		
		$.ajax({
			url: '<?=Url::base().'/job/get-batch'?>',
			data: {'id':id},
			dataType: 'json',
			method: 'POST',
            async: 'false'
		}).done(function(res){
			if(res.batch){
				item = '<tr class="border-bottom">';
					item += '<td>'+res.batch['pc_vessel']+'</td>';
					item += '<td>'+res.batch['pc_voyage']+'</td>';
					item += '<td>'+res.batch['pol_id']+' '+res.batch['pol_dod']+'</td>';
					item += '<td>'+res.batch['pod_id']+' '+res.batch['pod_doa']+'</td>';
				item += '</tr>';
				
				$('#table-batch tbody').html(item);
			}
		}).fail(function(err){
			
		});
	}
	
	//check complete
	function check_complete(){
		if($('#batchsearch').val() != '' && $('#place-receipt').val() != '' && 
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
