<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Vessel;
use app\models\Point;

$vessel = Vessel::find()->where(['is_active'=>1])->orderby(['vessel_name'=>SORT_ASC])->asArray()->all();
// $point = Point::find()->where(['is_active'=>1])->orderby(['point_code'=>SORT_ASC])->asArray()->all();
$point = Point::find()->orderby(['point_code'=>SORT_ASC])->asArray()->all();
?>

<div class="vessel-routing-index">
<?php $form = ActiveForm::begin(); ?>
	<input type="hidden" name="MasterVesselRouting[id]" value="<?= isset($model->id) ? $model->id : '' ?>">

	<div class="row" style="margin-bottom:20px">
		<div class="col-12">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th width="30%" style="background-color:#ffffcc">VESSEL & VOY</th>
						<th width="28%" class="text-center" style="background-color:#ffffcc">ETD</th>
						<th width="28%" class="text-center" style="background-color:#ffffcc">ETA</th>
						<th width="14%" style="background-color:#fae4d7">REFERENCE</th>
					</tr>
				</thead>
				
				<?php if ($model->isNewRecord) { ?>
				<tbody id="body">
					<tr>
						<td>
							<div class="row">
								<div class="col-7">
									<select class="form-control" style="width:100%" id="vessel-0" name="MasterVesselRoutingDetail[0][vessel_code]" required>
									   <?php
											foreach($vessel as $row){
												echo "<option value='".$row['vessel_code']."'>".
													$row['vessel_name'].
												"</option>";
											}
										?>
									</select>
								</div>
								<div class="col-5 pl-0">
									<input type="text" class="form-control" placeholder="Voyage" maxlength="15" id="voyage-0" name="MasterVesselRoutingDetail[0][voyage]" required>
								</div>
								<div class="col-12 pt-3">
									<input type="checkbox" class="laden_on_board" id="laden_on_board-0" name="MasterVesselRoutingDetail[0][laden_on_board]" checked onchange="check_laden_on_board()">
									<label class="form-check-label" for="laden_on_board-0">&nbsp;Laden On Board</label>
								</div>
							</div>
						</td>
						<td>
							<div class="row">
								<div class="col-6">
									<select class="form-control" style="width:100%" id="point_etd-0" name="MasterVesselRoutingDetail[0][point_etd]" required>
										<?php
											foreach($point as $row){
												echo "<option value='".$row['point_code']."'>".
													$row['point_code'].
												"</option>";
											}
										?>
									</select>
								</div>
								<div class="col-6 pl-0">
									<input type="date" class="form-control" id="date_etd-0" oninput="changeETA(this);" name="MasterVesselRoutingDetail[0][date_etd]" required>
								</div>
								<div class="col-12 pt-3 checkbox_lfp">
									<input type="checkbox" id="check-last" onchange="checklast()">
									<label class="form-check-label" for="check-last">&nbsp;As Last Foreign Port</label>
								</div>
							</div>
						</td>
						<td>
							<div class="row">
								<div class="col-6">
									<select class="form-control" style="width:100%" id="point_eta-0" onchange="changeETA(this);" name="MasterVesselRoutingDetail[0][point_eta]" required>
										<?php
											foreach($point as $row){
												echo "<option value='".$row['point_code']."'>".
													$row['point_code'].
												"</option>";
											}
										?>
									</select>
								</div>
								<div class="col-6 pl-0">
									<input type="date" class="form-control" id="date_eta-0" oninput="changeETA(this);" name="MasterVesselRoutingDetail[0][date_eta]" required>
								</div>
							</div>
						</td>
						<td>
							<input type="text" class="form-control" placeholder="Reference" id="reference-0" name="MasterVesselRoutingDetail[0][reference]">
						</td>
					</tr>
				</tbody>
				<?php }else{ ?>
				<!-- Update -->
				<tbody id="body">
				<?php
					$last_key = count($details)-1;
					$i=0;
					foreach($details as $key => $detail){
				?>
					<tr>
						<td>
							<div class="row">
								<div class="col-7">
									<select class="form-control" style="width:100%" id="vessel-<?= $i ?>" name="MasterVesselRoutingDetail[<?= $i ?>][vessel_code]" required>
									   <?php
											foreach($vessel as $row){
												if($detail['vessel_code'] == $row['vessel_code']){
													$selected = 'selected';
												}else{
													$selected = '';
												}
												
												echo "<option value='".$row['vessel_code']."' ".$selected.">".
													$row['vessel_name'].
												"</option>";
											}
										?>
									</select>
								</div>
								<div class="col-5 pl-0">
									<input type="text" class="form-control" placeholder="Voyage" maxlength="15" id="voyage-<?= $i ?>" value="<?= $detail['voyage'] ?>" name="MasterVesselRoutingDetail[<?= $i ?>][voyage]" required>
								</div>
								<div class="col-12 pt-3">
									<?php $detail->laden_on_board == 1 ? $checked = 'checked' : $checked = ''; ?>
								
									<input type="checkbox" class="laden_on_board" id="laden_on_board-<?= $i ?>" name="MasterVesselRoutingDetail[<?= $i ?>][laden_on_board]" <?= $checked ?> onchange="check_laden_on_board()">
									<label class="form-check-label" for="laden_on_board-<?= $i ?>">&nbsp;Laden On Board</label>
								</div>
							</div>
						</td>
						<td>
							<div class="row">
								<div class="col-6" style="display:none">
									<select class="form-control" style="width:100%;" id="point_etd-<?= $i ?>" name="MasterVesselRoutingDetail[<?= $i ?>][point_etd]" required>
										<?php
											foreach($point as $row){
												if($detail['point_etd'] == $row['point_code']){
													$selected = 'selected';
												}else{
													$selected = '';
												}
												
												echo "<option value='".$row['point_code']."' ".$selected.">".
													$row['point_code'].
												"</option>";
											}
										?>
									</select>
								</div>	
								<div class="col-6">	
									<input type="text" class="form-control" id="pointetd-<?= $i ?>" value="<?= $detail->point_etd ?>" readonly></input>
								</div>
								<div class="col-6 pl-0">
									<?php ($key !== 0) ? $readonly = 'readonly' : $readonly = '' ?>
								
									<input type="date" class="form-control" id="date_etd-<?= $i ?>" value="<?= $detail['date_etd'] ?>" <?php //$readonly ?> oninput="changeETA(this);" name="MasterVesselRoutingDetail[<?= $i ?>][date_etd]" required>
								</div>
								<?php if($key == $last_key){?>
									<div class="col-12 pt-3 checkbox_lfp">
										<input type="checkbox" id="check-last" onchange="checklast()">
										<label class="form-check-label" for="check-last">&nbsp;As Last Foreign Port</label>
									</div>
								<?php } ?>
							</div>
						</td>
						<td>
							<div class="row">
								<div class="col-6">
									<select class="form-control" style="width:100%" id="point_eta-<?= $i ?>" onchange="changeETA(this);" name="MasterVesselRoutingDetail[<?= $i ?>][point_eta]" required>
										<?php
											foreach($point as $row){
												if($detail['point_eta'] == $row['point_code']){
													$selected = 'selected';
												}else{
													$selected = '';
												}
												
												echo "<option value='".$row['point_code']."' ".$selected.">".
													$row['point_code'].
												"</option>";
											}
										?>
									</select>
								</div>
								<div class="col-6 pl-0">
									<input type="date" class="form-control" id="date_eta-<?= $i ?>"  min="<?= $detail['date_etd']?>" value="<?= $detail['date_eta'] ?>" oninput="changeETA(this);" name="MasterVesselRoutingDetail[<?= $i ?>][date_eta]" required>
								</div>
							</div>
						</td>
						<td>
							<input type="text" class="form-control" placeholder="Reference" id="reference-<?= $i ?>" value="<?= $detail['reference'] ?>" name="MasterVesselRoutingDetail[<?= $i ?>][reference]">
						</td>
					</tr>
				<?php $i++;}} ?>
				</tbody>
			</table>
		</div>
		<br>
		
		<div class="col-12 mb-4">
			<img style="cursor:pointer;" width="30" height="30" id="btn-add" onclick="addBaris()" src="https://img.icons8.com/material-sharp/24/000000/plus-2-math--v1.png"/>
		</div>
		
		<div class="col-12">
			<?= Html::a('Back', ['index'], ['class' => 'btn btn-default']) ?>
			<button type="submit" class="btn btn-dark">Save</button>
		</div>
	</div>
<?php ActiveForm::end(); ?>
</div>

<script>
	$('select').select2();
	
    var count = $('.table tbody tr').length-1;
    $(document).ready(function(){
        var count = $('.table tbody tr').length-1;
    });

    function addBaris()
    {
        count++;
        vessel = <?php echo json_encode($vessel) ?>;
        point = <?php echo json_encode($point) ?>;
        html = "<tr>";
        html += '<td><div class="row"> <div class="col-7"><select class="form-control" style="width:100%" id="vessel-'+count+'" name="MasterVesselRoutingDetail['+count+'][vessel_code]" required>';
        for(const a of vessel)
        {
            html += '<option value="'+a['vessel_code']+'">'+a['vessel_name']+'</option>';
        }
        html += '</select>';
		
		html += '</div> <div class="col-5 pl-0"><input class="form-control" type="text" placeholder="Voyage" maxlength="15" id="voyage-'+count+'" name="MasterVesselRoutingDetail['+count+'][voyage]" required></div>';

		html += '<div class="col-12 pt-3"><input type="checkbox" class="laden_on_board" id="laden_on_board-'+count+'" name="MasterVesselRoutingDetail['+count+'][laden_on_board]" onchange="check_laden_on_board()"><label class="form-check-label" for="laden_on_board-'+count+'">&nbsp;Laden On Board</label></div></div></td>';

        html += '<td><div class="row"> <div class="col-6"><select class="form-control" style="width:100%;display:none;" id="point_etd-'+count+'" name="MasterVesselRoutingDetail['+count+'][point_etd]" required>';
        for(const a of point)
        {
            html += '<option value="'+a['point_code']+'">'+a['point_code']+'</option>';
        }
        html += '</select>';
		
		html += '<input type="text" class="form-control" id="pointetd-'+count+'" readonly></input>';
		
		html += '</div> <div class="col-6 pl-0"><input class="form-control" type="date" id="date_etd-'+count+'" name="MasterVesselRoutingDetail['+count+'][date_etd]" required></div> <div class="col-12 pt-3 checkbox_lfp"><input type="checkbox" id="check-last" onchange="checklast()"><label class="form-check-label" for="check-last">&nbsp;As Last Foreign Port</label></div> </div></td>';

        html += '<td><div class="row"> <div class="col-6"><select class="form-control" style="width:100%" id="point_eta-'+count+'" onchange="changeETA(this);" name="MasterVesselRoutingDetail['+count+'][point_eta]" required>';
        for(const a of point)
        {
            html += '<option value="'+a['point_code']+'">'+a['point_code']+'</option>';
        }
        html += '</select>';
		
		html += '</div> <div class="col-6 pl-0"><input class="form-control" type="date" id="date_eta-'+count+'" oninput="changeETA(this);" name="MasterVesselRoutingDetail['+count+'][date_eta]" required></div> </div></td>';

        html += '<td><input type="text" class="form-control" placeholder="Reference" id="reference-'+count+'" name="MasterVesselRoutingDetail['+count+'][reference]" required></td>';
        html += '</tr>';
		
		$('.checkbox_lfp').remove();
        $("#body").append(html);
		
		check_laden_on_board();
		
		changeETA($('#date_eta-'+(count-1)));
    }
	
	function checklast(){
		$("#btn-add").toggle();
	}

	// Baris ETD selanjutnya default mengikuti ETA sblmnya (Point readonly, Tanggal nya msh boleh di edit)
    function changeETA(el)
    {
		id = $(el).attr('id').split("-")[1] * 1;
		
        var date = new Date($("#date_eta-"+parseInt(id)).val());
        var day = ("0" + date.getDate()).slice(-2);
        var month = ("0" + (date.getMonth() + 1)).slice(-2);
        var year = date.getFullYear();

        if($(el).attr('id') == "date_etd-0")
        {
            $("#date_eta-0").attr("min", [year, month, day].join('-'));
        }
        else
        {
            if(count != 0)
            {
                $("#date_etd-"+parseInt(id+1)).val([year, month, day].join('-'));
                $("#date_eta-"+parseInt(id+1)).attr("min", [year, month, day].join('-'));
            }
        }
		
		last_eta = $("#point_eta-"+parseInt(id)).val();
		last_eta_text = $("#point_eta-"+parseInt(id)+' :selected').html();
		
		$("#point_etd-"+parseInt(id+1)).val(last_eta);
		$("#pointetd-"+parseInt(id+1)).val(last_eta_text);
    }
	
	function check_laden_on_board(){
		$('input.laden_on_board[type="checkbox"]').on('change', function(){
			$('input.laden_on_board[type="checkbox"]').not(this).prop('checked', false);
			
			$(this).val('true');
		});
	}
</script>
