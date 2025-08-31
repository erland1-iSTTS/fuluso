<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Point;
use app\models\Vessel;

$this->title = 'Create Vessel & Routing';
?>

<style>
	.btn-default{
		background-color: #f1f1f1;
		border: 1px solid lightgrey;
	}
</style>

<div class="batch-index">
	<div class="row" style="margin-bottom:10px">
		<h4 style="font-weight:700;margin-bottom:25px">Add New Master Vessel & Routing</h4>
		
		<table class="table table-bordered" id="table-batch">
			<thead>
				<tr>
					<th width="30%" style="background-color:#ffffcc">VESSEL & VOY</th>
					<th class="text-center" width="28%" colspan="2" style="background-color:#ffffcc">ETD</th>
					<th class="text-center" width="28%" colspan="2" style="background-color:#ffffcc">ETA</th>
					<th width="14%" style="background-color:#fae4d7">REFERENCE</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>...</td>
					<td class="text-right">...</td>
					<td>...</td>
					<td class="text-right">...</td>
					<td>...</td>
					<td>...</td>
				</tr>
				<tr>
					<td>...</td>
					<td class="text-right">...</td>
					<td>...</td>
					<td class="text-right">...</td>
					<td>...</td>
					<td>...</td>
				</tr>
			</tbody>
		</table>
	</div>
	
	<div id="batch" class="row" style="border:1px solid lightgrey;padding:15px">
		<div class="col-6">
			<div class="row">
				<div class="col-12">
					<label class="form-group"><b>Port Of Loading</b></label>
				</div>
			</div>
			<!-- Vessel + Voyage -->
			<div class="row mb-2">
				<div class="col-6">
					<select class="form-control" id="vessel-0" onchange="change_vessel_voyage(this.id)">
						<?php
							$vessel = Vessel::find()->where(['is_active'=>1])->orderby(['vessel_code'=>SORT_ASC])->all();
							
							foreach($vessel as $row){
								echo '<option value="'.$row['id'].'">'.$row['vessel_code'].'</option>';
							}
						?>
					</select>
				</div>
				<div class="col-5 pl-0">
					<input type="text" class="form-control" id="voyage-0" onkeyup="change_vessel_voyage(this.id)">
				</div>
			</div>
			
			<!-- Point + Date ETD -->
			<div class="row mb-2">
				<div class="col-5">
					<select class="form-control" id="point_etd-0" onchange="change_point_etd(this.id)">
						<?php
							$point = Point::find()->where(['is_active'=>1])->orderby(['point_code'=>SORT_ASC])->all();
							
							foreach($point as $row){
								echo '<option value="'.$row['point_code'].'">'.$row['point_code'].'</option>';
							}
						?>
					</select>
				</div>
				<div class="col-4 pl-0">
					<input type="date" class="form-control" id="date_etd-0" name="date_etd-0" onchange="change_date_etd(this.id)">
				</div>
			</div>
			
			<!-- Point + Date ETA -->
			<div class="row mb-2">
				<div class="col-5">
					<select class="form-control" id="point_eta-0" onchange="change_point_eta(this.id)">
						<?php
							$point = Point::find()->where(['is_active'=>1])->orderby(['point_code'=>SORT_ASC])->all();
							
							foreach($point as $row){
								echo '<option value="'.$row['point_code'].'">'.$row['point_code'].'</option>';
							}
						?>
					</select>
				</div>
				<div class="col-4 pl-0" id="cont_date_eta-0">
					<input type="date" class="form-control" id="date_eta-0" name="date_eta-0" onchange="change_date_eta(this.id)">
				</div>
			</div>
			
			<div class="row mb-2">
				<div class="col-7">
					<input type="text" class="form-control" id="reference-0" onkeyup="change_reference(this.id)">
				</div>
			</div>
		</div>
		
		<div class="col-6">
			<div class="row">
				<div class="col-12">
					<label class="form-group"><b>Port Of Discharge</b></label>
				</div>
			</div>
			<!-- Vessel + Voyage -->
			<div class="row mb-2">
				<div class="col-6">
					<select class="form-control" id="vessel-1" onchange="change_vessel_voyage(this.id)">
						<?php
							$vessel = Vessel::find()->where(['is_active'=>1])->orderby(['vessel_code'=>SORT_ASC])->all();
							
							foreach($vessel as $row){
								echo '<option value="'.$row['id'].'">'.$row['vessel_code'].'</option>';
							}
						?>
					</select>
				</div>
				<div class="col-5 pl-0">
					<input type="text" class="form-control" id="voyage-1" onkeyup="change_vessel_voyage(this.id)">
				</div>
			</div>
			
			<!-- Point + Date ETD -->
			<div class="row mb-2">
				<div class="col-5">
					<select class="form-control" id="point_etd-1" onchange="change_point_etd(this.id)">
						<?php
							$point = Point::find()->where(['is_active'=>1])->orderby(['point_code'=>SORT_ASC])->all();
							
							foreach($point as $row){
								echo '<option value="'.$row['point_code'].'">'.$row['point_code'].'</option>';
							}
						?>
					</select>
				</div>
				<div class="col-4 pl-0">
					<input type="text" disabled class="form-control" id="date_etd-1" name="date_etd-1" onchange="change_date_etd(this.id)">
				</div>
			</div>
			
			<!-- Point + Date ETA -->
			<div class="row mb-2">
				<div class="col-5">
					<select class="form-control" id="point_eta-1" onchange="change_point_eta(this.id)">
						<?php
							$point = Point::find()->where(['is_active'=>1])->orderby(['point_code'=>SORT_ASC])->all();
							
							foreach($point as $row){
								echo '<option value="'.$row['point_code'].'">'.$row['point_code'].'</option>';
							}
						?>
					</select>
				</div>
				<div class="col-4 pl-0">
					<input type="date" class="form-control" id="date_eta-1" name="date_eta-1" onchange="change_date_eta(this.id)">
				</div>
			</div>
			
			<div class="row mb-2">
				<div class="col-7">
					<input type="text" class="form-control" id="reference-1" onkeyup="change_reference(this.id)">
				</div>
			</div>
		</div>
		
		<div id="batch_add" style="width:100%"></div>
		
		<div class="row ml-0 w-100">
			<div class="col-12">
				<button type="button" class="btn-default" id="btn-add" onclick="addrow()"><b>+</b></button>
				
				<div class="float-right">
					<input type="checkbox" id="check-last">
					<label class="form-check-label" for="check-last"> As last Foreign Port</label>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$('select').select2();
	
	$('#check-last').change(function(){
        $('#btn-add').toggle();
    });
	
	function change_vessel_voyage(id){
		var idx = id.split('-')[1];
		var vessel = $('#vessel-'+idx+' option:selected').text();
		var voyage = $('#voyage-'+idx).val();
		
		$('#table-batch tbody tr:eq('+idx+') td:eq(0)').html(vessel+' '+voyage);
	}
	
	function change_point_etd(id){
		var idx = id.split('-')[1];
		var point = $('#point_etd-'+idx+' option:selected').text();
		
		$('#table-batch tbody tr:eq('+idx+') td:eq(1)').html(point);
	}
	
	function change_date_etd(id){
		var idx = id.split('-')[1] * 1;
		var etd = $('#date_etd-'+idx).val();
		
		const monthNames = ["Jan", "Feb", "March", "Apr", "May", "June",
		  "July", "Aug", "Sept", "Oct", "Nov", "Dec"
		];
		
		d = new Date(etd);
		var day = ("0" + d.getDate()).slice(-2);
        var month = ("0" + (d.getMonth() + 1)).slice(-2);
        var year = d.getFullYear();
		
		if(d){
			date_etd = d.getDate()+'-'+monthNames[d.getMonth()];
		}else{
			date_etd = '';
		}
		$('#table-batch tbody tr:eq('+idx+') td:eq(2)').html(date_etd);

		if(id == "date_etd-0")
		{
			$("#date_eta-0").attr("min", [year, month, day].join('-'));
		}
	}
	
	function change_point_eta(id){
		var idx = id.split('-')[1];
		var point = $('#point_eta-'+idx+' option:selected').text();
		
		$('#table-batch tbody tr:eq('+idx+') td:eq(3)').html(point);
	}
	
	function change_date_eta(id){
		var idx = id.split('-')[1] * 1;
		var eta = $('#date_eta-'+idx).val();
		
		const monthNames = ["Jan", "Feb", "March", "Apr", "May", "June",
		  "July", "Aug", "Sept", "Oct", "Nov", "Dec"
		];
		
		d = new Date(eta);
		var day = ("0" + d.getDate()).slice(-2);
        var month = ("0" + (d.getMonth() + 1)).slice(-2);
        var year = d.getFullYear();
		
		if(d){
			date_eta = d.getDate()+'-'+monthNames[d.getMonth()];
		}else{
			date_eta = '';
		}
		$('#table-batch tbody tr:eq('+idx+') td:eq(4)').html(date_eta);

		$("#date_etd-"+parseInt(idx+1)).val([year, month, day].join('/'));
		$("#date_eta-"+parseInt(idx+1)).attr("min", [year, month, day].join('-'));
		change_date_etd("date_etd-"+parseInt(idx+1));
	}
	
	function change_reference(id){
		var idx = id.split('-')[1];
		
		var reference = $('#reference-'+idx).val();
		
		$('#table-batch tbody tr:eq('+idx+') td:eq(5)').html(reference);
	}
	

    function addrow(){
		var id = $('#table-batch tbody tr').length;
		
		item = '<div class="row" style="margin:5px 0px">';
			//Left
			item += '<div class="col-6">';
				item += '<div class="row">';
					item += '<div class="col-12">';
						item += '<label class="form-group"><b>Port Of Loading</b></label>';
					item += '</div>';
				item += '</div>';
				
				item += '<div class="row mb-2">';
					item += '<div class="col-6">';
						item += '<select class="form-control" id="vessel-'+id+'" onchange="change_vessel_voyage(this.id)">';
							item += '<?php
								$vessel = Vessel::find()->where(['is_active'=>1])->orderby(['vessel_code'=>SORT_ASC])->all();
								
								foreach($vessel as $row){
									echo '<option value="'.$row['id'].'">'.$row['vessel_code'].'</option>';
								}
							?>';
						item += '</select>';
					item += '</div>';
					item += '<div class="col-5 pl-0">';
						item += '<input type="text" class="form-control" id="voyage-'+id+'" onkeyup="change_vessel_voyage(this.id)">';
					item += '</div>';
				item += '</div>';
				
				item += '<div class="row mb-2">';
					item += '<div class="col-5">';
						item += '<select class="form-control" id="point_etd-'+id+'" onchange="change_point_etd(this.id)">';
							item += '<?php
								$point = Point::find()->where(['is_active'=>1])->orderby(['point_code'=>SORT_ASC])->all();
								
								foreach($point as $row){
									echo '<option value="'.$row['point_code'].'">'.$row['point_code'].'</option>';
								}
							?>';
						item += '</select>';
					item += '</div>';
					item += '<div class="col-4 pl-0">';
						item += '<input type="text" disabled class="form-control" id="date_etd-'+id+'" name="date_etd-0" onchange="change_date_etd(this.id)">';
					item += '</div>';
				item += '</div>';
				
				item += '<div class="row mb-2">';
					item += '<div class="col-5">';
						item += '<select class="form-control" id="point_eta-'+id+'" onchange="change_point_eta(this.id)">';
							item += '<?php
								$point = Point::find()->where(['is_active'=>1])->orderby(['point_code'=>SORT_ASC])->all();
								
								foreach($point as $row){
									echo '<option value="'.$row['point_code'].'">'.$row['point_code'].'</option>';
								}
							?>';
						item += '</select>';
					item += '</div>';
					item += '<div class="col-4 pl-0">';
						item += '<input type="date" class="form-control" id="date_eta-'+id+'" name="date_eta-0" onchange="change_date_eta(this.id)">';
					item += '</div>';
				item += '</div>';
				
				item += '<div class="row mb-2">';
					item += '<div class="col-7">';
						item += '<input type="text" class="form-control" id="reference-'+id+'" onkeyup="change_reference(this.id)">';
					item += '</div>';
				item += '</div>';
			item += '</div>';
			//Right
			item += '<div class="col-6">';
				item += '<div class="row">';
					item += '<div class="col-12">';
						item += '<label class="form-group"><b>Port Of Discharge</b></label>';
					item += '</div>';
				item += '</div>';
				
				item += '<div class="row mb-2">';
					item += '<div class="col-6">';
						item += '<select class="form-control" id="vessel-'+(id+1)+'" onchange="change_vessel_voyage(this.id)">';
							item += '<?php
								$vessel = Vessel::find()->where(['is_active'=>1])->orderby(['vessel_code'=>SORT_ASC])->all();
								
								foreach($vessel as $row){
									echo '<option value="'.$row['id'].'">'.$row['vessel_code'].'</option>';
								}
							?>';
						item += '</select>';
					item += '</div>';
					item += '<div class="col-5 pl-0">';
						item += '<input type="text" class="form-control" id="voyage-'+(id+1)+'" onkeyup="change_vessel_voyage(this.id)">';
					item += '</div>';
				item += '</div>';
				
				item += '<div class="row mb-2">';
					item += '<div class="col-5">';
						item += '<select class="form-control" id="point_etd-'+(id+1)+'" onchange="change_point_etd(this.id)">';
							item += '<?php
								$point = Point::find()->where(['is_active'=>1])->orderby(['point_code'=>SORT_ASC])->all();
								
								foreach($point as $row){
									echo '<option value="'.$row['point_code'].'">'.$row['point_code'].'</option>';
								}
							?>';
						item += '</select>';
					item += '</div>';
					item += '<div class="col-4 pl-0">';
						item += '<input type="text" disabled class="form-control" id="date_etd-'+(id+1)+'" name="date_etd-0" onchange="change_date_etd(this.id)">';
					item += '</div>';
				item += '</div>';
				
				item += '<div class="row mb-2">';
					item += '<div class="col-5">';
						item += '<select class="form-control" id="point_eta-'+(id+1)+'" onchange="change_point_eta(this.id)">';
							item += '<?php
								$point = Point::find()->where(['is_active'=>1])->orderby(['point_code'=>SORT_ASC])->all();
								
								foreach($point as $row){
									echo '<option value="'.$row['point_code'].'">'.$row['point_code'].'</option>';
								}
							?>';
						item += '</select>';
					item += '</div>';
					item += '<div class="col-4 pl-0">';
						item += '<input type="date" class="form-control" id="date_eta-'+(id+1)+'" name="date_eta-0" onchange="change_date_eta(this.id)">';
					item += '</div>';
				item += '</div>';
				
				item += '<div class="row mb-2">';
					item += '<div class="col-7">';
						item += '<input type="text" class="form-control" id="reference-'+(id+1)+'" onkeyup="change_reference(this.id)">';
					item += '</div>';
				item += '</div>';
			item += '</div>';
		item += '</div>';
		
		row = '<tr>';
			row += '<td>...</td>';
			row += '<td class="text-right">...</td>';
			row += '<td>...</td>';
			row += '<td class="text-right">...</td>';
			row += '<td>...</td>';
			row += '<td>...</td>';
		row += '</tr>';
		row += '<tr>';
			row += '<td>...</td>';
			row += '<td class="text-right">...</td>';
			row += '<td>...</td>';
			row += '<td class="text-right">...</td>';
			row += '<td>...</td>';
			row += '<td>...</td>';
		row += '</tr>';
		
		
		$('#batch_add').append(item);
		$('#table-batch tbody').append(row);
	}
</script>
