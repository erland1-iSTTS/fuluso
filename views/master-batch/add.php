<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Vessel;
use app\models\Point;

$this->title = 'Create Vessel & Routing';
?>

<div class="batch-index">
	<div class="row" style="margin-bottom:20px">
		<h4 style="font-weight:700;margin-bottom:25px">Add New Master Vessel & Routing</h4>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th width="30%" style="background-color:#ffffcc">VESSEL & VOY</th>
					<th width="28%" class="text-center" style="background-color:#ffffcc">ETD</th>
					<th width="28%" class="text-center" style="background-color:#ffffcc">ETA</th>
					<th width="14%" style="background-color:#fae4d7">REFERENCE</th>
				</tr>
			</thead>
			<tbody id="body">
				<tr>
					<td>
						<div class="row">
							<div class="col-7">
								<select class="form-control" style="width:100%" id="vessel-0">
								   <?php
										foreach($vessel as $row){
											echo "<option value='".$row['id']."'>".
												$row['vessel_name'].
											"</option>";
										}
									?>
								</select>
							</div>
							<div class="col-5 pl-0">
								<input type="text" class="form-control" placeholder="Voyage" id="voyage-0">
							</div>
						</div>
					</td>
					<td>
						<div class="row">
							<div class="col-6">
								<select class="form-control" style="width:100%" id="point_etd-0">
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
								<input type="date" class="form-control" id="date_etd-0" oninput="changeETA(this);">
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
								<select class="form-control" style="width:100%" id="point_eta-0">
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
								<input type="date" class="form-control" id="date_eta-0" oninput="changeETA(this);">
							</div>
						</div>
					</td>
					<td>
						<input type="text" class="form-control" placeholder="Reference" id="reference-0">
					</td>
				</tr>
			</tbody>
		</table><br>
		
		<div class="row ml-0 w-100">
			<div class="col-12">
				<img style="cursor:pointer;" width="30" height="30" id="btn-add" onclick="addBaris()" src="https://img.icons8.com/material-sharp/24/000000/plus-2-math--v1.png"/>
			</div>
		</div>
	</div>
</div>

<script>
	$('select').select2();
	
    var count = 0;
    $(document).ready(function(){
        var count = 0;
    });

    function addBaris()
    {
        count++;
        vessel = <?php echo json_encode($vessel) ?>;
        point = <?php echo json_encode($point) ?>;
        html = "<tr>";
        html += '<td><div class="row"> <div class="col-7"><select class="form-control" style="width:100%" id="vessel-'+count+'">';
        for(const a of vessel)
        {
            html += '<option value="'+a['id']+'">'+a['vessel_name']+'</option>';
        }
        html += "</select></div> <div class='col-5 pl-0'><input class='form-control' type='text' placeholder='Voyage' id='voyage-"+count+"'></div> </div></td>";

        html += '<td><div class="row"> <div class="col-6"><select class="form-control" style="width:100%" id="point_etd-'+count+'">';
        for(const a of point)
        {
            html += '<option value="'+a['point_code']+'">'+a['point_code']+'</option>';
        }
        html += '</select></div> <div class="col-6 pl-0"><input class="form-control" type="text" disabled id="date_etd-'+count+'"></div> <div class="col-12 pt-3 checkbox_lfp"><input type="checkbox" id="check-last" onchange="checklast()"><label class="form-check-label" for="check-last">&nbsp;As Last Foreign Port</label></div> </div></td>';

        html += '<td><div class="row"> <div class="col-6"><select class="form-control" style="width:100%" id="point_eta-'+count+'">';
        for(const a of point)
        {
            html += '<option value="'+a['point_code']+'">'+a['point_code']+'</option>';
        }
        html += '</select></div> <div class="col-6 pl-0"><input class="form-control" type="date" id="date_eta-'+count+'" oninput="changeETA(this);"></div> </div></td>';

        html += '<td><input type="text" class="form-control" placeholder="Reference" id="reference-'+count+'"></td>';
        html += "</tr>";
		
		$('.checkbox_lfp').remove();
        $("#body").append(html);
    }
	
	function checklast(){
		$("#btn-add").toggle();
	}

    function changeETA(el)
    {
        var date = new Date($(el).val());
        var day = ("0" + date.getDate()).slice(-2);
        var month = ("0" + (date.getMonth() + 1)).slice(-2);
        var year = date.getFullYear();

        if($(el).attr('id') == "date_etd-0")
        {
            $("#date_eta-0").attr("min", [year, month, day].join('-'));
        }
        else
        {
            id = $(el).attr('id').split("-")[1] * 1;
            if(count != 0)
            {
                $("#date_etd-"+parseInt(id+1)).val([day, month, year].join('/'));
                $("#date_eta-"+parseInt(id+1)).attr("min", [year, month, day].join('-'));
            }
        }
    }
</script>