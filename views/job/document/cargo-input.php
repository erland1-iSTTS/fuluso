<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Unit;
use app\models\Packages;
use app\models\MasterG3eHblCargodetail;
use yii\helpers\VarDumper;
?>

<?php
if(!empty($cargo)){
	$model = MasterG3eHblCargodetail::find()->where(['hblcrg_job_id' => $_GET['id'], 'hblcrg_is_active' => 1])->one();
}
$unit = Unit::find()->where(['is_active'=>1])->orderby(['unit_name'=>SORT_ASC])->all();
$packages = Packages::find()->orderby(['packages_name'=>SORT_ASC])->all();
?>

<div id="cargo-input-index">
	<input type="hidden" value="<?= $_GET['id']?>" name="MasterG3eHblCargodetail[hblcrg_job_id]">
	
	<textarea id="desc-hbldes_desofgood_text" name="Desc[hbldes_desofgood_text]" style="display:none"></textarea>
	<textarea  id="desc-hbldes_weight" name="Desc[hbldes_weight]" style="display:none"></textarea>
	
	<div class="col-md-12">
		<table class="table" id="table-cargo-input">
			<tr class="header">
				<td width="18%">CONTAINER</td>
				<td width="19%">SEAL</td>
				<td width="15%">PACKAGES</td>
				<td width="16%">
					GW 
					<div class="d-inline-block" style="width:70%">
						<select class="form-select form-select-lg" id="satuan_gross" name="MasterG3eHblCargodetail[hblcrg_gross_type]" onchange="total_weight()" required>
							<?php
								foreach($unit as $row){
									if(isset($model->hblcrg_gross_type)){
										if($model->hblcrg_gross_type == $row['unit_name']){
											$selected = 'selected';
										}else{
											$selected = '';
										}
									}else{
										// Default
										if($row['unit_name'] == 'KGS'){
											$selected = 'selected';
										}else{
											$selected = '';
										}
									}
									
									echo "<option value='".$row['unit_name']."' ".$selected.">".
										$row['unit_name'].
									"</option>";
								}
							?>
						</select>
					</div>
				</td>
				<td width="16%">
					NW
					<div class="d-inline-block" style="width:70%">
						<select class="form-select form-select-lg" id="satuan_nett" name="MasterG3eHblCargodetail[hblcrg_nett_type]" onchange="total_weight()" required>
							<?php
								foreach($unit as $row){
									if(isset($model->hblcrg_nett_type)){
										if($model->hblcrg_nett_type == $row['unit_name']){
											$selected = 'selected';
										}else{
											$selected = '';
										}
									}else{
										// Default
										if($row['unit_name'] == 'KGS'){
											$selected = 'selected';
										}else{
											$selected = '';
										}
									}
									
									echo "<option value='".$row['unit_name']."' ".$selected.">".
										$row['unit_name'].
									"</option>";
								}
							?>
						</select>
					</div>
				</td>
				<td width="16%">
					MEAS
					<div class="d-inline-block" style="width:70%">
						<select class="form-select form-select-lg" id="satuan_measurement" name="MasterG3eHblCargodetail[hblcrg_msr_type]" onchange="total_weight()" required>
							<?php
								foreach($unit as $row){
									if(isset($model->hblcrg_msr_type)){
										if($model->hblcrg_msr_type == $row['unit_name']){
											$selected = 'selected';
										}else{
											$selected = '';
										}
									}else{
										// Default
										if($row['unit_name'] == 'CBM'){
											$selected = 'selected';
										}else{
											$selected = '';
										}
									}
									
									echo "<option value='".$row['unit_name']."' ".$selected.">".
										$row['unit_name'].
									"</option>";
								}
							?>
						</select>
					</div>
				</td>
			</tr>
			
			<?php if(!empty($cargo)){
			
				$i = 0;
				foreach($cargo as $crg){
			?>
				<tr>
					<td>
						<b><?= $crg['hblcrg_name'] ?></b>
						<input type="hidden" class="form-control" value="<?= $crg['hblcrg_name'] ?>" name="MasterG3eHblCargodetail[detail][<?= $i ?>][hblcrg_name]" required>
					</td>
					<td>
						<input type="text" class="form-control" placeholder="Seal Number" value="<?= $crg['hblcrg_seal'] ?>" name="MasterG3eHblCargodetail[detail][<?= $i ?>][hblcrg_seal]" required>
					</td>
					
					<td>
						<div class="row">
							<div class="col-md-7 pr-1">
								<input type="text" class="form-control input_package" placeholder="0" value="<?= $crg['hblcrg_pack_value'] ?>" name="MasterG3eHblCargodetail[detail][<?= $i ?>][hblcrg_pack_value]" onkeyup="total_package()" required>
							</div>
							<div class="col-md-5 pl-1">
								<select class="form-select form-select-lg input_type_package" name="MasterG3eHblCargodetail[detail][<?= $i ?>][hblcrg_pack_type]" onchange="total_package()" required>
									<?php
										foreach($packages as $row){
											$name = str_replace("'", "&apos;", $row['packages_plural']);
											
											if($crg['hblcrg_pack_type'] == $row['packages_plural']){
												$selected = 'selected';
											}else{
												$selected = '';
											}
											
											echo "<option value='".$name."' ".$selected.">".
												$row['packages_plural'].
											"</option>";
										}
									?>
								</select>
							</div>
						</div>
					</td>
					
					<?php
						$gross = explode('.', $crg['hblcrg_gross_value']);
						$hblcrg_gross_value1 = $gross[0];
						$hblcrg_gross_value2 = $gross[1];
						$nett = explode('.', $crg['hblcrg_nett_value']);
						$hblcrg_nett_value1 = $nett[0];
						$hblcrg_nett_value2 = $nett[1];
						$msr = explode('.', $crg['hblcrg_msr_value']);
						$hblcrg_msr_value1 = $msr[0];
						$hblcrg_msr_value2 = $msr[1];
					?>
					
					<td>
						<div class="row">
							<div class="col-md-8 pr-1">
								<input type="hidden" class="form-control input_gross_value" value="<?= $crg['hblcrg_gross_value'] ?>" name="MasterG3eHblCargodetail[detail][<?= $i ?>][hblcrg_gross_value]">
								<input type="text" class="form-control input_gross1" value="<?= $hblcrg_gross_value1 ?>" name="MasterG3eHblCargodetail[detail][<?= $i ?>][hblcrg_gross_value1]" onkeyup="total_weight()" required>
							</div>
							<div class="col-md-4 pl-1 pt-2">
								<input type="text" class="form-control input_gross2" style="height:25px" placeholder="000" value="<?= $hblcrg_gross_value2 ?>" name="MasterG3eHblCargodetail[detail][<?= $i ?>][hblcrg_gross_value2]" onkeyup="total_weight()" required>
							</div>
						</div>
					</td>
					
					<td>
						<div class="row">
							<div class="col-md-8 pr-1">
								<input type="hidden" class="form-control input_nett_value" value="<?=  $crg['hblcrg_nett_value'] ?>" name="MasterG3eHblCargodetail[detail][<?= $i ?>][hblcrg_nett_value]">
								<input type="text" class="form-control input_nett1" value="<?= $hblcrg_nett_value1 ?>" name="MasterG3eHblCargodetail[detail][<?= $i ?>][hblcrg_nett_value1]" onkeyup="total_weight()" required>
							</div>
							<div class="col-md-4 pl-1 pt-2">
								<input type="text" class="form-control input_nett2" style="height:25px" placeholder="000" value="<?= $hblcrg_nett_value2 ?>" name="MasterG3eHblCargodetail[detail][<?= $i ?>][hblcrg_nett_value2]" onkeyup="total_weight()" required>
							</div>
						</div>
					</td>
					
					<td>
						<div class="row">
							<div class="col-md-7 pr-1">
								<input type="hidden" class="form-control input_measurement_value" value="<?= $crg['hblcrg_msr_value'] ?>" name="MasterG3eHblCargodetail[detail][<?= $i ?>][hblcrg_msr_value]">
								<input type="text" class="form-control input_measurement1" value="<?= $hblcrg_msr_value1 ?>" name="MasterG3eHblCargodetail[detail][<?= $i ?>][hblcrg_msr_value1]" onkeyup="total_weight()" required>
							</div>
							<div class="col-md-5 pl-1 pt-2">
								<input type="text" class="form-control input_measurement2" style="height:25px" placeholder="000" value="<?= $hblcrg_msr_value2 ?>" name="MasterG3eHblCargodetail[detail][<?= $i ?>][hblcrg_msr_value2]" onkeyup="total_weight()" required>
							</div>
						</div>
					</td>
				</tr>
				
				<tr>
					<td></td>
					<td colspan="5">
						<textarea class="form-control" placeholder="Container Description" rows="5" name="MasterG3eHblCargodetail[detail][<?= $i ?>][hblcrg_description]" required><?php if($cargo){echo str_replace("\\n","\n",$crg['hblcrg_description']);} ?></textarea>
					</td>
				</tr>
				<?php $i++;} ?>
			<?php } ?>
		</table>
	</div>
	
	<div class="col-md-12">
		<div class="form-group">
			<a href="#" class="text-black text-decoration-underline fs-3" id="btn_cargo_back">Go back and edit containers</a>
		</div>
	</div>
	
	<div class="col-md-12"><hr class="mt-4"></div>
</div>
