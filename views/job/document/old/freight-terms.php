<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Packages;
use app\models\Movement;
use app\models\PosV8;
use app\models\Freight;
use app\models\Country;
use app\models\MasterNewJobBooking;
?>

<?php
//short
$freight = Freight::find()->orderby(['freight_name'=>SORT_ASC])->all();

//breakdown
$pos = PosV8::find()->where(['is_active'=>1])->orderby(['pos_name'=>SORT_ASC])->all();
$packages = Packages::find()->orderby(['packages_name'=>SORT_ASC])->all();
$movement = Movement::find()->orderby(['movement_name'=>SORT_ASC])->all();
$country = Country::find()->orderby(['name'=>SORT_ASC])->all();
?>

<div id="freight-terms-index">
<?php $form = ActiveForm::begin(['id' => 'form_freight', 'action' => Url::base().'/job/save-freight']); ?>
	
	<input type="hidden" value="<?= $_GET['id']?>" name="MasterG3eHblDescription[hbldes_job_id]">
	
	<div class="col-md-12 mb-4">
		<h6>FREIGHT & TERMS</h6>
	</div>
	
	<div style="display:flex">
		<!-- Left -->
		<div style="width:50%;">
			<div class="ml-3">
				<div class="form-check">
					<input class="form-check-input" type="radio" name="freightterms1" id="radio1" checked required>
					<label class="fw-normal" for="radio1">Short</label>
				</div>
				
				<div class="col-md-4" style="padding-left:20px;">
					<div class="form-group">
						<select class="form-select form-select-lg" name="MasterG3eHblDescription[hbldes_freight]">
							<?php
								foreach($freight as $row){
									if(isset($freight_terms->hbldes_freight)){
										if($freight_terms->hbldes_freight == $row['freight_id']){
											$selected = 'selected';
										}else{
											$selected = '';
										}
									}else{
										$selected = '';
									}
									
									echo "<option value='".$row['freight_id']."' ".$selected.">".
										$row['freight_name'].
									"</option>";
								}
							?>
						</select>
					</div>
				</div>
			</div>
			
			<div class="ml-3">
				<div class="form-check">
					<input class="form-check-input" type="radio" name="freightterms1" id="radio2">
					<label class="fw-normal" for="radio2">Breakdown</label>
				</div>
				
				<div class="col-md-10" style="padding-left:20px;">
					<input type="text" class="form-control mb-2">
					<input type="text" class="form-control mb-2">
					<input type="text" class="form-control mb-2">
					<input type="text" class="form-control mb-2">
					<input type="text" class="form-control mb-2">
				</div>
			</div>
		</div>
		
		<!-- Right -->
		<div style="width:50%;">
			<div class="row">
				<div class="ml-3 mr-2">
					<label class="fw-normal">Payable At</label>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<select class="form-select form-select-lg" name="MasterG3eHblDescription[hbldes_payable]">
							<?php
								foreach($country as $row){
									if(isset($freight_terms->hbldes_payable)){
										if($freight_terms->hbldes_payable == $row['id']){
											$selected = 'selected';
										}else{
											$selected = '';
										}
									}else{
										$selected = '';
									}
									
									echo "<option value='".$row['id']."' ".$selected.">".
										$row['name'].
									"</option>";
								}
							?>
						</select>
					</div>
				</div>
				
				<div class="ml-3 mr-2">
					<label class="fw-normal">Transport Mode</label>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<?php
							$vesselrouting = MasterNewJobBooking::find()->where(['id_job' => $_GET['id']])->one();
							
							if(isset($vesselrouting)){
								$m = Movement::find()->where(['movement_id' => $vesselrouting['hblrouting_movement']])->one();
								if(isset($m)){
									$transport_mode = $m->movement_name;
								}else{
									$transport_mode ='-';
								}
							}else{
								$transport_mode = '-';
							}
						?>
						<input type="text" class="form-control" placeholder="Transport Mode" value="<?= $transport_mode?>" readonly></input>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="fw-normal">Payable Details</label>
						<textarea class="form-control" id="payable-details" rows="3" name="MasterG3eHblDescription[hbldes_payable_details]" required><?php if($freight_terms){echo str_replace("\\n","\n",$freight_terms->hbldes_payable_details);} ?></textarea>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Comment Sementara
	<div class="col-md-12">
		<div class="col-md-10" style="padding-left:20px;">
			<table class="table" id="table_breakdown">
				<tr>
					<td width="5%"></td>
					<td width="20%">Desc. of Charges</td>
					<td width="20%">Detail</td>
					<td width="18%">Basis</td>
					<td width="10%">Jumlah</td>
					<td width="10%">Satuan</td>
					<td width="17%">Tarif</td>
				</tr>
				<tr>
					<td class="text-center">
						<button class="btn btn-xs btn-success rounded-pill" style="padding: 0px 5px" onclick="addrow()">
							<span class="fa fa-plus align-middle"></span>
						</button>
					</td>
					<td>
						<select class="form-select form-select-lg">
							<?php
								foreach($pos as $row){
									echo "<option value=''>".
										$row['pos_name'].
									"</option>";
								}
							?>
						</select>
					</td>
					<td>
						<input type="text" class="form-control" value="">
					</td>
					<td>
						<div class="row">
							<div class="col-md-6 pr-1">
								<input type="text" class="form-control" placeholder="0" value="">
							</div>
							<div class="col-md-6 pl-1">
								<select class="form-select form-select-lg">
									<?php
										foreach($packages as $row){
											echo "<option value=''>".
												$row['packages_name'].
											"</option>";
										}
									?>
								</select>
							</div>
						</div>
					</td>
					<td>
						<input type="text" class="form-control" placeholder="0" value="">
					</td>
					<td>
						<select class="form-select form-select-lg">
							<?php
								foreach($packages as $row){
									echo "<option value=''>".
										$row['packages_name'].
									"</option>";
								}
							?>
						</select>
					</td>
					<td>
						<div class="row">
							<div class="col-md-7 pr-1">
								<input type="text" class="form-control" placeholder="0" value="">
							</div>
							<div class="col-md-5 pl-1 pt-2">
								<input type="text" class="form-control" style="height:25px" value="00">
							</div>	
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>-->
	
	<!--<div class="col-md-12"><hr class="mt-3"></div>-->
<?php ActiveForm::end(); ?>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		check_complete_freight();
	});
	
	$('#payable-details').on('keyup', function(){
		check_complete_freight();
	});
	
	//check complete
	function check_complete_freight(){
		if($('#payable-details').val() != ""){
			$('#heading4 h2').removeClass('uncomplete');
			$('#heading4 h2').addClass('complete');
			$('#heading4 .row div').removeClass('uncomplete');
			$('#heading4 .row div').addClass('complete');
		}else{
			$('#heading4 h2').addClass('uncomplete');
			$('#heading4 h2').removeClass('complete');
			$('#heading4 .row div').addClass('uncomplete');
			$('#heading4 .row div').removeClass('complete');
		}
	}
	
	function addrow(){
		item = '<tr>';
			item += '<td class="text-center">';
				//item += '<button class="btn btn-xs btn-danger rounded-pill" onclick="removerow()">';
				//	item += '<span class="fa fa-minus align-middle"></span>';
				//item += '</button>';
			item += '</td>';
			item += '<td>';
				item += '<select class="form-select form-select-lg">';
					item +="<?php
						foreach($pos as $row){
							echo "<option value='".$row['pos_name']."'>".
								$row['pos_name'].
							"</option>";
						}
					?>";
				item += '</select>';
			item += '</td>';
			item += '<td>';
				item += '<input type="text" class="form-control" value="">';
			item += '</td>';
			item += '<td>';
				item += '<div class="row">';
					item += '<div class="col-md-6 pr-1">';
						item += '<input type="text" class="form-control" placeholder="0" value="">';
					item += '</div>';
					item += '<div class="col-md-6 pl-1">';
						item += '<select class="form-select form-select-lg">';
							item +="<?php
								foreach($packages as $row){
									str_replace("'", "`", $row['packages_name']);
									
									echo "<option value=''>".
										$row['packages_name'].
									"</option>";
								}
							?>";
						item += '</select>';
					item += '</div>';
				item += '</div>';
			item += '</td>';
			item += '<td>';
				item += '<input type="text" class="form-control" placeholder="0" value="">';
			item += '</td>';
			item += '<td>';
				item += '<select class="form-select form-select-lg">';
					item +="<?php
						foreach($packages as $row){
							echo "<option value=''>".
								$row['packages_name'].
							"</option>";
						}
					?>";
				item += '</select>';
			item += '</td>';
			item += '<td>';
				item += '<div class="row">';
					item += '<div class="col-md-7 pr-1">';
						item += '<input type="text" class="form-control" placeholder="0" value="">';
					item += '</div>';
					item += '<div class="col-md-5 pl-1 pt-2">';
						item += '<input type="text" class="form-control" style="height:25px" value="00">';
					item += '</div>';
				item += '</div>';
			item += '</td>';
		item += '</tr>';
		
		$('#table_breakdown tbody').append(item);
	}
</script>
