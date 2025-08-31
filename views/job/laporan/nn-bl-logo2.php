<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\MasterNewJob;
use app\models\Vessel;
use app\models\Country;

use app\models\MasterG3eHblCusdata;
use app\models\MasterG3eJobrouting;

use app\models\MasterG3eVesselbatch;
use app\models\MasterVesselRouting;
use app\models\MasterVesselRoutingDetail;
use app\models\MasterG3eHblRouting;

use app\models\MasterG3eHblCargodetail;
use app\models\MasterG3eContainer;
use app\models\Freight;

use app\models\MasterG3eBatch;

use app\models\MasterG3eHblDescription;

use yii\helpers\VarDumper;

$job = MasterNewJob::find()->where(['id'=>$id])->asArray()->one();
$type = $job['g3_type'];
$total = $job['g3_total'];
$packages = $job['g3_packages'];
$job_location = $job['job_location'];

$ori_batch = MasterG3eBatch::find()->where(['batchform_job'=>$id])->asArray()->one();
if(isset($ori_batch)){
	$batchform1 = $ori_batch['batchform_1'];
	$batchform2 = $ori_batch['batchform_2'];
	$batchform3 = $ori_batch['batchform_3'];
}

$open_hidden1 = 0;
$open_hidden2 = 0;
?>

<?php
	$cus = MasterG3eHblCusdata::find()->where(['hblcusdata_job_id'=>$id])->asArray()->one();
	
	$hblcusdata_shipper = $cus['hblcusdata_shipper'];
	$hblcusdata_shipper_info = $cus['hblcusdata_shipper_info'];

	$hblcusdata_consignee = $cus['hblcusdata_consignee'];
	$hblcusdata_consignee_info = $cus['hblcusdata_consignee_info'];

	$hblcusdata_notify = $cus['hblcusdata_notify'];
	$hblcusdata_notify_info = $cus['hblcusdata_notify_info'];

	$hblcusdata_alsonotify = $cus['hblcusdata_alsonotify'];
	$hblcusdata_alsonotify_info = $cus['hblcusdata_alsonotify_info'];
?>

<?php
	$vb = MasterG3eVesselbatch::find()->where(['vessel_job_id'=>$id])->one();
	
	if(isset($vb)){
		$vr = MasterVesselRouting::find()->where(['id'=>$vb->vessel_batch_id])->one();
		
		if(isset($vr)){
			$point_start = $vr->point_start;
			$vessel_start = $vr->vessel_start;
			$voyage_start = $vr->voyage_start;
			$date_start = $vr->date_start;
			$point_end = $vr->point_end;
			$vessel_end = $vr->vessel_end;
			$voyage_end = $vr->voyage_end;
			$date_end = $vr->date_end;
			
			if(isset($vr)){
				$vessel = Vessel::find()->where(['vessel_code'=>$vr->laden_on_board])->one();
				$vrd = MasterVesselRoutingDetail::find()->where(['id_vessel_routing'=>$vr->id, 'laden_on_board'=>1])->one();
				
				$laden_code = $vr->laden_on_board;
				$laden_name = $vessel->vessel_name;
				$laden_date = $vrd->date_etd;
			}else{
				$laden_code = '';
				$laden_name = '';
				$laden_date = '';
			}
		}
	}
	
	$mr = MasterG3eHblRouting::find()->where(['hblrouting_job_id'=>$id])->one();
	
	if(isset($mr)){
		$place_of_receipt = $mr->place_of_receipt;
		$port_of_loading = $mr->port_of_loading;
		$port_of_delivery = $mr->port_of_delivery;
		$port_of_discharge = $mr->port_of_discharge;
	}
?>

<div class="draft-bl-index">
	<!-- Addres + Header -->
	<div class="w-100">
		<!-- Left -->
		<div style="float:left;width:49%">
			<!-- Shipper -->
			<div class="border-top border-bottom" style="height:96px;padding-top:3px;padding-bottom:3px">
				<div class="label-header">
					SHIPPER/EXPORTER (COMPLETE NAME AND ADDRESS)
				</div>
				<div class="font2 pl1">
					<?php
						// Maks 6 baris (6 x 15px), selebih nya dipotong
						$lines_arr_shipper = preg_split('/\n/',$hblcusdata_shipper_info);
						$num_newlines_shipper = count($lines_arr_shipper);
						
						if($num_newlines_shipper > 6)
						{
							for($i=0; $i<6; $i++)
							{
								echo strtoupper(nl2br($lines_arr_shipper[$i]));
							}
						}
						else
						{
							echo strtoupper(nl2br($hblcusdata_shipper_info));
							echo '<br/>';
						}
					?>
				</div>
			</div>
			
			<!-- Consignee -->
			<div class="border-bottom" style="height:96px;padding-top:3px;padding-bottom:3px">
				<div class="label-header">
					CONSIGNEE (COMPLETE NAME AND ADDRESS)
				</div>
				<div class="font2 pl1">
					<?php
						// Maks 6 baris (6 x 15px), selebih nya dipotong
						$lines_arr_consignee = preg_split('/\n/',$hblcusdata_consignee_info);
						$num_newlines_consignee = count($lines_arr_consignee);
						
						if($num_newlines_consignee > 6)
						{
							for($i=0; $i<6; $i++)
							{
								echo strtoupper(nl2br($lines_arr_consignee[$i]));
							}
						}
						else
						{
							echo strtoupper(nl2br($hblcusdata_consignee_info));
							echo '<br/>';
						}
					?>
				</div>
			</div>
			
			<!-- Notify Party -->
			<div style="height:96px;padding-top:3px;padding-bottom:3px">
				<div class="label-header">
					NOTIFY PARTY (COMPLETE NAME AND ADDRESS)
				</div>
				<div class="font2 pl1">
					<?php
						// Maks 6 baris (6 x 15px), selebih nya dipotong
						$lines_arr_notify = preg_split('/\n/',$hblcusdata_notify_info);
						$num_newlines_notify = count($lines_arr_notify);
						
						if($num_newlines_notify > 6)
						{
							for($i=0; $i<6; $i++)
							{
								echo strtoupper(nl2br($lines_arr_notify[$i]));
							}
						}
						else
						{
							echo strtoupper(nl2br($hblcusdata_notify_info));
							echo '<br/>';
						}
					?>
				</div>
			</div>
		</div>
		
		<!-- Right -->
		<div style="float:right;width:50%">
			<!-- Logo + Title -->
			<div style="height:93px;">
				<img src="<?= Url::base().'/img/newlogo.png'?>" width="230px">
				
				<div style="float:left;width:55%;padding-top:14px">
					<div class="couriers" style="font-size:14px;">
						<span style="letter-spacing:1px;background-color:yellow">NON-NEGOTIABLE</span><br/>
						<span style="letter-spacing:1px;">BILL OF LADING</span>
					</div>
				</div>
				
				<div style="float:right;width:44%;margin-top:10px;padding-top:21.3px">
					<div class="label-header">
						BILL OF LADING NO.
					</div>
					<span class="couriers" style="font-size:14px">
						<?php
							$k = MasterG3eJobrouting::find()->where(['jr_job_id'=>$id])->asArray()->one();
							
							$total_hbl = $k['jr_hbl'];
							$jr_house_scac = $k['jr_house_scac'];
							
							$nomor_hbl = $jr_house_scac.' '.$job['job_location'].''.$job['job_year'].''. $job['job_month'].''.str_pad($job['job_number'],5, '0', STR_PAD_LEFT);
							
							echo $jr_house_scac;
							echo '&nbsp;&nbsp;';
							// echo $job['job_location'].''.$job['job_year'].''. $job['job_month'].''.str_pad($job['job_number'],5, '0', STR_PAD_LEFT);
						?>
					</span>
					<span class="couriers" style="font-size:18px">
						<?= $job['job_location'].''.$job['job_year'].''. $job['job_month'].''.str_pad($job['job_number'],5, '0', STR_PAD_LEFT); ?>
					</span>
				</div>
			</div>
			
			<!-- Reference -->
			<div class="border-bottom" style="height:96px;padding-top:3px;padding-bottom:3px">
				<div class="label-header">
					REFERENCE
				</div>
				<div class="font2 pl1">
					<?php
						$desc = MasterG3eHblDescription::find()->where(['hbldes_job_id'=>$id])->one();
						$reff = MasterG3eJobrouting::find()->where(['jr_job_id'=>$id])->one();
						
						if(isset($desc)){
							$freight = Freight::find()->where(['freight_id'=>$desc->hbldes_freight])->one();
							$country = Country::find()->where(['id'=>$desc->hbldes_payable])->one();
							
							if($desc->hbldes_payable_status == 0){
								if(empty($desc->hbldes_freight) || $desc->hbldes_freight == '-'){
									echo '&nbsp;';
								}else{
									echo 'FREIGHT '.$freight->freight_name;
								}
								
								echo '<br>';
								
								if(empty($desc->hbldes_payable_details) || $desc->hbldes_payable_details == '-'){
									echo '&nbsp;';
								}else{
									echo $desc->hbldes_payable_details;
								}
								
								echo '<br>';
								
								if(isset($reff)){
									$text = preg_split('/\n/',$reff->jr_ref_number);
									
									if(isset($text[0]) && $text[0] !== '-'){
										echo $text[0];
									}
									
									if(isset($text[1])){
										echo '<br>'.$text[1];
									}
									
									if(isset($text[2])){
										echo '<br>'.$text[2];
									}
									
									if(isset($text[3])){
										echo '<br>'.$text[3];
									}
								}
							}else{
								if(empty($desc->hbldes_freight) || $desc->hbldes_freight == '-'){
									echo '&nbsp;';
								}else{
									echo 'FREIGHT '.$freight->freight_name.' PAYABLE AT '.$country->name;
								}
								
								echo '<br>';
								
								if(empty($desc->hbldes_payable_details) || $desc->hbldes_payable_details == '-'){
									echo '&nbsp;';
								}else{
									echo $desc->hbldes_payable_details;
								}
								
								echo '<br>';
								if(isset($reff)){
									$text = preg_split('/\n/',$reff->jr_ref_number);
									
									if(isset($text[0]) && $text[0] !== '-'){
										echo $text[0];
									}
									
									if(isset($text[1])){
										echo '<br>'.$text[1];
									}
									
									if(isset($text[2])){
										echo '<br>'.$text[2];
									}
									
									if(isset($text[3])){
										echo '<br>'.$text[3];
									}
								}
							}
						}else{
							echo '&nbsp;';
							echo '<br>';
							if(empty($desc->hbldes_payable_details) || $desc->hbldes_payable_details == '-'){
								echo '&nbsp;';
							}else{
								echo $desc->hbldes_payable_details;
							}
							echo '<br>';
							if(isset($reff)){
								$text = preg_split('/\n/',$reff->jr_ref_number);
								
								if(isset($text[0]) && $text[0] !== '-'){
									echo $text[0];
								}
								
								if(isset($text[1])){
									echo '<br>'.$text[1];
								}
								
								if(isset($text[2])){
									echo '<br>'.$text[2];
								}
								
								if(isset($text[3])){
									echo '<br>'.$text[3];
								}
							}
						}
					?>
				</div>
			</div>
			
			<!-- Also Notify Party -->
			<div style="height:96px;padding-top:3px;padding-bottom:3px">
				<div class="label-header">
					ALSO NOTIFY PARTY-ROUTING & INSTRUCTION
				</div>
				<div class="font2 pl1">
					<?php
						// Maks 6 baris, selebih nya dipotong
						$lines_arr_alsonotify = preg_split('/\n/',$hblcusdata_alsonotify_info);
						$num_newlines_alsonotify = count($lines_arr_alsonotify);
						
						if($num_newlines_alsonotify > 65)
						{
							for($i=0; $i<6; $i++)
							{
								echo strtoupper(nl2br($lines_arr_alsonotify[$i]));
							}
						}
						else
						{
							echo strtoupper(nl2br($hblcusdata_alsonotify_info));
							echo '<br/>';
						}
					?>
				</div>
			</div>
		</div>
		
		<div style="clear:both"></div>
	</div>
	
	<div class="w-100">
		<div style="float:left;width:32.5%;padding-right:0.1cm">
			<div class="label-header border-top" style="padding-top:3px">
				PRE-CARRIAGE BY
			</div>
			<div class="font2 border-bottom pl1" style="padding-bottom:3px">
			   <?= isset($vr) ? $vr->vesselstart->vessel_name.' '.$voyage_start : '' ?>
			</div>
		</div>
		<div style="float:left;width:32.5%;padding-left:0.1cm;padding-right:0.1cm">
			<div class="label-header border-top" style="padding-top:3px">
				PLACE OF RECEIPT
			</div>
			<div class="font2 border-bottom pl1" style="padding-bottom:3px">
				<?php 
					if(!empty($place_of_receipt)){ 
						echo $place_of_receipt; 
					}else{
						if(isset($vb)){
							echo $vb->por->point_name;
						}else{
							echo '&nbsp;';
						}
					}
				?>
			</div>
		</div>
		<div style="float:left;width:32.5%;padding-left:0.1cm;">
			<div class="label-header border-top" style="padding-top:3px">
				POINT AND COUNTRY OF ORIGIN OF GOODS
			</div>
			<div class="font2 border-bottom pl1" style="padding-bottom:3px">
				<?php
					$origin = MasterG3eJobrouting::find()->where(['jr_job_id'=>$id])->one();
					
					if(!empty($origin->jr_country_origin)){
						echo $origin->country->name;
					}else{
						echo '&nbsp;';
					}
				?>
			</div>
		</div>
	</div>
	
	<div class="w-100">
		<div style="float:left;width:32.5%;padding-right:0.1cm">
			<div class="label-header" style="padding-top:3px">
				VESSEL/VOYAGE/FLAG
			</div>
			<div class="font2 border-bottom pl1" style="padding-bottom:3px">
				<?= isset($vr) ? $vr->vesselend->vessel_name.' '.$voyage_end : '' ?>
			</div>
		</div>
		<div style="float:left;width:32.5%;padding-left:0.1cm;padding-right:0.1cm">
			<div class="label-header" style="padding-top:3px">
				PORT OF LOADING
			</div>
			<div class="font2 border-bottom pl1" style="padding-bottom:3px">
				<?php 
					if(!empty($port_of_loading)){
						echo $port_of_loading;
					}else{
						if(isset($vr)){
							echo $vr->pointstart->point_name;
						}else{
							echo '&nbsp;';
						}
					}
				?>
			</div>
		</div>
		<div style="float:left;width:32.5%;padding-left:0.1cm">
			<div class="label-header" style="padding-top:3px">
				ORIGINAL TO BE RELEASED AT
			</div>
			<div class="font2 border-bottom pl1" style="padding-bottom:3px">
				<?php
					$r = MasterG3eHblDescription::find()->where(['hbldes_job_id'=>$id])->one();
				
					if(isset($r) && $r->hbldes_poi !== '-'){
						echo $r->office->office_name;
					}else{
						echo '&nbsp;';
					}
				?>
			</div>
		</div>
	</div>
	
	<div class="w-100 border-bottom">
		<div style="float:left;width:32.5%;padding-right:0.1cm">
			<div class="label-header" style="padding-top:3px">
				PORT OF DISCHARGE
			</div>
			<div class="font2 pl1" style="padding-bottom:3px">
				<?php 
					if(!empty($port_of_discharge)){
						echo $port_of_discharge;
					}else{
						if(isset($vr)){
							echo $vr->pointend->point_name;
						}else{
							echo '&nbsp;';
						}
					}
				?>
			</div>
		</div>
		<div style="float:left;width:32.5%;padding-left:0.1cm;padding-right:0.1cm">
			<div class="label-header" style="padding-top:3px">
				PLACE OF DELIVERY
			</div>
			<div class="font2 pl1" style="padding-bottom:3px">
				<?php 
					if(!empty($port_of_delivery)){
						echo $port_of_delivery;
					}else{
						if(isset($vb)){
							echo $vb->fod->point_name;
						}else{
							echo '&nbsp;';
						}
					}
				?>
			</div>
		</div>
		<div style="float:left;width:32.5%;padding-left:0.1cm">
			<div class="label-header" style="padding-top:3px">
				DECLARED VALUE
			</div>
			<div class="font2 pl1" style="padding-bottom:3px">
				<?php
					$desc = MasterG3eHblDescription::find()->where(['hbldes_job_id'=>$id])->one();
					
					if(isset($desc) && $desc->hbldes_declared_list !== '-'){
						// Jk nilai nya kosong, mk dikosongi saja
						if(empty($desc->hbldes_declared_text1) && empty($desc->hbldes_declared_text2)){
							echo '&nbsp;';
						}else{
							echo $desc->hbldes_declared_list.' '.$desc->hbldes_declared_text1.' - '.$desc->hbldes_declared_text2;
						}
					}else{
						echo '&nbsp;';
					}
				?>
			</div>
		</div>
	</div>
	
	<div class="w-100 border-bottom arial" style="font-size:10px;text-align:center;padding-top:3px;padding-bottom:3px">
		UNDERMENTIONED PARTICULARS AS DECLARED AND FURNISHED BY THE SHIPPER<br/>
		QUANTITY, CONDITION, CONTENTS AND ALL OTHER INFORMATION SHOWN ARE UNKNOWN TO THE CARRIER
	</div>
	
	<div class="w-100 border-bottom" style="padding-top:3px;padding-bottom:3px">
		<div class="label-header" style="float:left;width:75%">
			Container / Seal No.; Kind of Packages; Description of Goods; Marks and Numbers
		</div>
		<div class="label-header" style="text-align:right;float:right;width:24%">
			Weight; Measurement
		</div>

		<div style="clear:both"></div>
		
		<div style="width:80%">
			<table width="100%" class="font2" style="text-align:center;border:0px;margin:0px 0px 7px 0px;border-collapse:collapse">
				<?php
					$x = MasterG3eHblCargodetail::find()->where(['hblcrg_job_id' => $id])->orderBy(['hblcrg_container_count'=>SORT_ASC]);
					
					if($x->count() > 0)
					{
						$i = 1;
						$tot_hblcrg_gross_value = 0;
						$tot_hblcrg_nett_value = 0;
						$tot_hblcrg_msr_value = 0;
						
						foreach($x->asArray()->all() as $row){
							$data = MasterG3eContainer::find()->where(['con_count' => $i, 'con_job_id' => $id])->asArray()->one();
							// $data = MasterG3eHblCargodetail::find()->where(['hblcrg_job_id' => $id])->asArray()->one();
							
							$crg = $row['hblcrg_name'];
							$crg_detail = (explode(" ",$crg));
							
							$hblcon_code = $crg_detail[0];
							$hblcon_text = $crg_detail[1];
							$hblcon_name = $crg_detail[2];
							
							// $hblcon_code = $data['con_code'];
							// $hblcon_text = $data['con_text'];
							// $hblcon_name = $data['con_name'];
							
							$container = $hblcon_code.''.$hblcon_text.' '.$hblcon_name;
							$container2 = $hblcon_code.''.$hblcon_text.' / '.$hblcon_name;
						?>
							<tr>
								<td width="12%" class="pl1" style="text-align:left"><?= $hblcon_code.''.$hblcon_text;  ?></td>
								<td width="12%"><?= $hblcon_name ?></td>
								<td width="10%"><?= strtoupper($row['hblcrg_seal']) ?></td>
								<td width="15%" style="text-align:right"><?= $row['hblcrg_pack_value'].' '.stripslashes($row['hblcrg_pack_type']); ?></td>
								
								<td width="17%" style="text-align:right">
									<?php 
										if($row['hblcrg_gross_value'] != '.' && $row['hblcrg_gross_value'] != '.00')
										{
											echo number_format($row['hblcrg_gross_value'],3, '.', ',').' '.$row['hblcrg_gross_type'];
										}
									?>
								</td>
								<td width="17%" style="text-align:right">
									<?php 
										if($row['hblcrg_nett_value'] != '.' && $row['hblcrg_nett_value'] != '.00')
										{
											echo number_format($row['hblcrg_nett_value'],3, '.', ',').' '.$row['hblcrg_nett_type'];
										}
									?>
								</td>
								<td width="17%" style="text-align:right">
									<?php 
										if($row['hblcrg_msr_value'] != '.' && $row['hblcrg_msr_value'] != '.00')
										{
											echo number_format($row['hblcrg_msr_value'],3, '.', ',').' '.$row['hblcrg_msr_type'];
										}
									?>
								</td>
							</tr>
							
							<?php
							/*if(!empty($row['hblcrg_description']) || $row['hblcrg_description'] !== '-')
							{
								echo '<tr>
										<td style="width:120px" align="left">
											<div></div>
										</td>
										<td style="width:120px"></td>
										<td style="width:250px; text-align:left">'.nl2br(stripslashes($row['hblcrg_description'])).'</td>
									</tr>';
							}*/
							$i++;

							$tot_hblcrg_gross_value += $row['hblcrg_gross_value'];
							$tot_hblcrg_nett_value += $row['hblcrg_nett_value'];
							$tot_hblcrg_msr_value += $row['hblcrg_msr_value'];

							$hblcrg_gross_type = $row['hblcrg_gross_type'];
							$hblcrg_nett_type = $row['hblcrg_nett_type'];
							$hblcrg_msr_type = $row['hblcrg_msr_type'];
						}
					}
					
					//max 3 container agar tidak bermasalah
					/*$rows_container = intval($x->count());
					
					if($rows_container < 4){
						$kurang = 4 - $rows_container;
						for($x=1; $x <= $kurang; $x++){
							if($x == $kurang){
								$class = '';
							}else{
								$class = '';
							}
							
							echo '<tr><td colspan="7" class="'.$class.'">&nbsp;</td></tr>';
						}
					}*/
				?>
			</table>
		</div>
		
		<div style="height:auto;padding-top:3px;" class="border-top">
			<table width="100%" class="font2" style="text-align:center;border:0px;margin:0px;border-collapse:collapse">
				<?php
					$count_cargo = MasterG3eHblCargodetail::find()->where(['hblcrg_job_id' => $id])->orderBy(['hblcrg_container_count'=>SORT_ASC])->count();
					$v = MasterG3eHblDescription::find()->where(['hbldes_job_id'=>$id])->asArray()->one();
					
					if(!empty($v['hbldes_desofgood_text']))
					{
					?>
					<tr>
						<td valign="top" align="left" width="100px" style="padding:0px;">
							<div style="width:100px">
								<?php
									if(!empty($v['hbldes_mark']))
									{
										echo nl2br($v['hbldes_mark']);
									}
									else
									{
										echo '&nbsp;';
									}
								?>
							</div>
						</td>
						<td valign="top" width="120px" style="padding:0px;">
							<div style="position:relative; width:120px">
								<?php
								if($type == 'FCL')
								{
									echo nl2br($v['hbldes_desofgood_text']);
								}else
								{
									echo '&nbsp;';
								}
								?>
							</div>
						</td>
						<td valign="top" width="300px" style="text-align:left;padding:0px;">
							<div style="width:300px">
								<?php
								if($type != 'FCL')
								{
									echo 'SAID TO CONTAIN <br/>';
								}
								
								if($count_cargo == 5){
									$maxrow1 = 20; 
								}elseif($count_cargo == 4){
									$maxrow1 = 21; 
								}elseif($count_cargo == 3){
									$maxrow1 = 22; 
								}elseif($count_cargo == 2){
									$maxrow1 = 23;
								}else{
									$maxrow1 = 24;
								}
								
								$desc = MasterG3eHblDescription::find()->where(['hbldes_job_id'=>$id])->asArray()->one();
								
								$hbldes_desofgood_text = str_replace('\n', '<br/>', $desc['hbldes_desofgood']);
								$hbldes_desofgood_text = str_replace(' ', '&nbsp;', $hbldes_desofgood_text);
								
								$lines_arr = preg_split('/\n/',$hbldes_desofgood_text);
								$num_newlines = count($lines_arr);
								
								if($num_newlines > $maxrow1)
								{
									for($i=0; $i< $maxrow1; $i++)
									{
										echo nl2br($lines_arr[$i]);
									}
									$open_hidden1 = 1;
								}
								else
								{
									echo nl2br($hbldes_desofgood_text);
									
									if($type != 'FCL')
									{
										$sisa = $maxrow1 - intval($num_newlines) - 1;
									}else{
										$sisa = $maxrow1 - intval($num_newlines);
									}
									
									for($i=0; $i < $sisa; $i++){
										echo '&nbsp;';
										echo '<br/>';
									}
									
									$open_hidden1 = 0;
								}
								?>
							</div>
						</td>
						<td valign="top" width="80px" style="text-align:right;padding:0px;">
							<div style="width:80px">
								<?php if(!empty($tot_hblcrg_gross_value)) echo 'GW :<br/>';?>
								<?php if(!empty($tot_hblcrg_nett_value)) echo 'NW :<br/>';?>
								<?php if(!empty($tot_hblcrg_msr_value)) { echo 'MEAS :'; }?>
							</div>
						</td>
						<td valign="top" width="150px" colpan="2" style="text-align:right;padding-right:30px">
							<div style="width:150px">
								<?php
									if(!empty($tot_hblcrg_gross_value))
									{
										echo str_pad(number_format($tot_hblcrg_gross_value,3, '.', ',').'&nbsp;&nbsp;','7', ' ', STR_PAD_LEFT).' '.$hblcrg_gross_type;
										echo '<br>';
									}

									if(!empty($tot_hblcrg_nett_value))
									{
										echo str_pad(number_format($tot_hblcrg_nett_value,3, '.', ',').'&nbsp;&nbsp;','7', ' ', STR_PAD_LEFT).' '.$hblcrg_nett_type;
										echo '<br>';
									}

									if(!empty($tot_hblcrg_msr_value))
									{
										echo str_pad(number_format($tot_hblcrg_msr_value,4, '.', ','),'7', ' ', STR_PAD_LEFT).' '.$hblcrg_msr_type;
										echo '<br>';
									}
								?>
							</div>
						</td>
					</tr>
					<?php
					}
             		?>
			</table>
		</div>
	</div>
	
	<!-- OCEAN FREIGHT TERMS -->
	<div class="w-100 border-bottom" style="padding-top:3px;padding-bottom:3px">
		<div class="font2">
			FREIGHT
			<?php
				$desc = MasterG3eHblDescription::find()->where(['hbldes_job_id'=>$id])->one();
				
				if(isset($desc)){
					if($desc->hbldes_freight !== '-'){
						echo $desc->freight->freight_name;
					}else{
						echo '&nbsp;';
					}
				}
			?>
			<br/>
			<?php
				if($type == 'FCL'){
					echo 'SHIPPER STOW, LOAD, COUNT AND SEAL';
				}else{
					echo 'SAID TO CONTAIN DECLARED BY THE SHIPPER, UNKNOWN TO THE CARRIER.';
				}
			?>
			<br/>
			DESTINATION CHARGES COLLECT PER TARIFF, AND TO BE COLLECTED FROM THE PARTY WHO LAWFULLY DEMANDS DELIVERY OF THE CARGO.
		</div>
	</div>
	
	<div>
		<div style="float:left;width:4.2%;padding-top:5px;padding-left:7px">
			<img src="<?= Url::base().'/img/nn.jpg'?>" width="25px" height="220px">
		</div>
		
		<div style="float:left;width:44%;padding-top:3px;">
			<div style="margin-bottom:10px">
				<div class="label-header">
					FREIGHT & CHARGES PAYABLE AT / BY:
				</div>
				<div class="font2 pl1">
					FREIGHT
					<?php
						$desc = MasterG3eHblDescription::find()->where(['hbldes_job_id'=>$id])->one();
						
						if(isset($desc)){
							if($desc->hbldes_freight !== '-'){
								echo $desc->freight->freight_name;
							}else{
								echo '&nbsp;';
							}
							// echo nl2br(strtoupper($desc['hbldes_payable_details']));
						}
					?>
				</div>
			</div>
			
			<!--<div class="border-top border-bottom" style="height:96px;padding-top:3px;padding-bottom:3px;"> Ori BL--> 
			<div class="border-top" style="height:96px;padding-top:3px;padding-bottom:3px;margin-bottom:20px">
				<div class="label-header">
					DELIVERY / ROUTING AGENT - REFERENCES AND INSTRUCTIONS
				</div>
				<div class="font2 pl1">
					<?php
						$r = MasterG3eJobrouting::find()->where(['jr_job_id'=>$id])->asArray()->one();
						
						// Maks 6 baris (6 x 15px), selebih nya dipotong
						$lines_arr_agentloc = preg_split('/\n/', $r['jr_agentloc']);
						$num_newlines_agentloc = count($lines_arr_agentloc);
						
						if($num_newlines_agentloc > 6)
						{
							for($i=0; $i<6; $i++)
							{
								echo strtoupper(nl2br($lines_arr_agentloc[$i]));
							}
						}
						else
						{
							echo strtoupper(nl2br($r['jr_agentloc']));
							echo '<br/>';
						}
					?>
				</div>
			</div>
			
			<!--<div class="" style="padding-top:3px;padding-bottom:3px"> Ori BL-->
			<div class="border-top" style="padding-top:3px;padding-bottom:3px">
				<div class="label-header">Laden on Board / Shipped on Board</div>
				<div class="couriers pl1" style="font-size:14px;margin-bottom:6px">
					<?= isset($vr) ? $vr->vesselstart->vessel_name.' '.$voyage_start : '' ?>
				</div>
				
				<div class="label-header">Date : ( DAY/MO/YEAR ) </div>
				<div class="couriers pl1" style="font-size:14px">
					<?php
						if(isset($laden_date)){
							$date = date_format(date_create_from_format('Y-m-d', $laden_date), 'd F Y');
							echo strtoupper($date);
						}
					?>
				</div>
			</div>
			
			<div class="arial" style="font-size:10px;margin-top:5px">
				<?php
					/*if(isset($batchform1) && isset($batchform2) && isset($batchform3))
					{
						if(!empty($batchform1) && !empty($batchform2) && !empty($batchform3))
						{
							echo '<b>ORI # </b>'.$batchform1.' '.$batchform2.' '.$batchform3;
						}
					}else{
						echo '<b>ORI # </b>';
					}*/
				?>
			</div>
		</div>
		
		<div style="float:right;width:50%;padding-top:3px;">
			<div class="label-header" style="padding-left:0px;text-align:justify">
				RECEIVE by the Carrier, the goods in apparent good order and condition, as far as by reasonable means of checking as specific above unless otherwise stated.
				<br/>The Carrier, in accordance with the previsions contained in this document:<br/>
				1. Undertakes to perform or to procure the performance of the entire transport from the place of receipt to the place of delivery state above, and<br/>
				2. Assumes liabilities prescribed in this document for such transport.<br/>
				One of the signed Bill of Lading must be surrended duly endorsed in exchange of the Goods or Delivery Order.
			</div>
			
			<div style="clear:both"></div>
			
			<div class="w-100" style="margin-top:5px;padding-left:0px">
				<div style="float:left;width:58.5%;margin-bottom:5px;">
					<div class="arial" style="float:left;width:40%;font-size:9px;line-height:15px">
						BILL OF LADING NO.
					</div>
					<div class="font2" style="float:left;width:60%;text-align:left;">
						<?php
							$k = MasterG3eJobrouting::find()->where(['jr_job_id'=>$id])->asArray()->one();
							
							$total_hbl = $k['jr_hbl'];
							$jr_house_scac = $k['jr_house_scac'];

							$nomor_hbl = $jr_house_scac.' '.$job['job_location'].''.$job['job_year'].''. $job['job_month'].''.str_pad($job['job_number'],5, '0', STR_PAD_LEFT);
							
							if(isset($k)){
								// echo '<div style="float:left;width:18%;">'.$jr_house_scac.'</div>';
								// echo '<div style="float:left;width:45%;">'.$job['job_location'].''.$job['job_year'].''. $job['job_month'].''.str_pad($job['job_number'],5, '0', STR_PAD_LEFT).'</div>';
							
								echo '<span>'.$jr_house_scac.'</span>';
								echo ' ';
								echo '<span style="font-size:14px">'.$job['job_location'].''.$job['job_year'].''. $job['job_month'].''.str_pad($job['job_number'],5, '0', STR_PAD_LEFT).'</span>';
							}else{
								echo '&nbsp;';
							}
						?>
					</div>
				</div>
				<div style="float:right;width:41%;">
					<div class="arial" style="float:left;width:70%;font-size:9px;padding-left:15px;line-height:15px">
						Number of Original B(s)/L
					</div>
					<div class="font2" style="float:left;width:15%;text-align:right;line-height:15px">				
						<?php
							$desc = MasterG3eHblDescription::find()->where(['hbldes_job_id'=>$id])->one();
				
							if(isset($desc)){
								echo $desc->hbldes_original;
							}
						?>
					</div>
				</div>
			</div>
			
			<div style="clear:both"></div>
			
			<div class="w-100" style="margin-bottom:5px;padding-left:0px">
				<div style="float:left;width:58.5%;">
					<div class="arial" style="float:left;width:40%;font-size:9px;">
						Place of Issue
					</div>
					<div class="font2" style="float:left;width:60%;text-align:left;">
						<?php
							$desc = MasterG3eHblDescription::find()->where(['hbldes_job_id'=>$id])->one();
							
							if(isset($desc) && $desc->hbldes_poi !== '-'){
								echo $desc->office->office_name;
							}else{
								echo '&nbsp;';
							}
						?>
					</div>
				</div>
				<div style="float:right;width:41%;">
					<div class="arial" style="float:left;width:35%;font-size:9px;padding-left:15px">
						Date of Issue
					</div>
					<div class="font2" style="float:left;width:50%;text-align:right;">
						<?php
							$desc = MasterG3eHblDescription::find()->where(['hbldes_job_id'=>$id])->asArray()->one();
							
							if(isset($desc)){
								$hbldes_doi_day = $desc['hbldes_doi_day'];
								$hbldes_doi_month = $desc['hbldes_doi_month'];
								$hbldes_doi_year = $desc['hbldes_doi_year'];
								
								if($hbldes_doi_day !== '-' && $hbldes_doi_month !== '-' && $hbldes_doi_year !== '-'){
									$date = date_format(date_create_from_format('Y-m-d', $hbldes_doi_year.'-'.$hbldes_doi_month.'-'.$hbldes_doi_day), 'd M Y');
									echo strtoupper($date);
								}else{
									echo '&nbsp;';
								}
							}
						?>
					</div>
				</div>
			</div>
			
			<div style="padding-left:0px">
				<div class="label-header" style="margin-bottom:3px;width:50px;margin-right:10px;padding-top:2px">
					SIGNED BY
				</div>
				
				<div class="label-header" style="margin-bottom:3px;">
					IN WITNESS of the contract herein contained the number of originals stated above has been issued and signed, one of which being accomplished, the other(s) to be void.
				</div>
				
				<div class="font2 pl1">
					<?php
						$data = MasterG3eHblDescription::find()->where(['hbldes_job_id'=>$id])->asArray()->one();
						
						if(isset($data)){
							echo strtoupper(nl2br($data['hbldes_signature_text']));
						}
					?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php 
	if($open_hidden1 == 1){
?>
<pagebreak>

<div style="position:relative; width:100%; color:black;" align="center">
    <div style="position:relative; width:785px; border:#fff 1px solid" align="left">

	    <div style="position:relative; font-size:18px; font-family:couriers; border-bottom:#000 1px solid;float: left">
		    ATTACHMENT
	    </div>
	    <div style="position:relative; font-size:12px; font-family:couriers; border-bottom:#000 1px solid;float: left">
		    <div style="margin-top:5px; margin-bottom:5px;float:left;width:20%">
			    BILL OF LADING NO. 
			</div>	
			<div style="float:left;width:50%">
				<span style="font-family:couriers; font-size:14px; font-weight:bold">
					<?php
						$k = MasterG3eJobrouting::find()->where(['jr_job_id'=>$id])->asArray()->one();
						
						$total_hbl = $k['jr_hbl'];
						$jr_house_scac = $k['jr_house_scac'];

						$nomor_hbl = $jr_house_scac.' '.$job['job_location'].''.$job['job_year'].''. $job['job_month'].''.str_pad($job['job_number'],5, '0', STR_PAD_LEFT);
						
						if(isset($k)){
							echo '<div style="float:left;width:10%;font-size:10px; margin-right:5px">'.$jr_house_scac.'</div>';
							echo '<div style="float:left;width:50%;">'.$job['job_location'].''.$job['job_year'].''. $job['job_month'].''.str_pad($job['job_number'],5, '0', STR_PAD_LEFT).'</div>';
						}
					?>
			    </span>
		    </div>
	    </div>
		
	    <!-- CONTENT -->
		<div style="position:relative; margin:0px 0px 0px 0px; border-top:#000 1px solid;">
			<div style="position:relative; border-bottom:#000 1px solid; font-size:10px; font-weight:bold; padding-top:2px; padding-bottom:2px" align="center" class="font1">
				UNDERMENTIONED PARTICULARS AS DECLARED AND FURNISHED BY THE SHIPPER<br/>
				QUANTITY, CONDITION, CONTENTS AND ALL OTHER INFORMATION SHOWN ARE UNKNOWN TO THE CARRIER
			</div>
		
			<!-- ISI CONTENT -->
			<div style="margin-top:5px">
             	<table width="100%" cellspacing="0" cellpadding="2" class="font2" style="text-align:center; border:0px">
                    <?php
						$desc = MasterG3eHblDescription::find()->where(['hbldes_job_id'=>$id])->asArray()->one();
					
						if(!empty($desc['hbldes_desofgood']))
						{
 					?>
 					<tr>
 						<td valign="top" width="100px" align="left">
 							<div></div>
 						</td>
 						<td valign="top" width="120px"></td>
 						<td valign="top" width="300px" style="text-align:left" colspan="4">
 							<?php
								if($count_cargo == 5){
									$startrow1 	= 20; 
									$maxrow2 	= 91; 
								}elseif($count_cargo == 4){
									$startrow1 	= 21; 
									$maxrow2 	= 92; 
								}elseif($count_cargo == 3){
									$startrow1 	= 22; 
									$maxrow2 	= 93; 
								}elseif($count_cargo == 2){
									$startrow1	= 23;
									$maxrow2 	= 94;
								}else{
									$startrow1 	= 24;
									$maxrow2 	= 95;
								}
							
								$hbldes_desofgood_text = str_replace('\n', '<br/>', $desc['hbldes_desofgood']);
								$hbldes_desofgood_text = str_replace(' ', '&nbsp;', $hbldes_desofgood_text);

								$lines_arr = preg_split('/\n/',$hbldes_desofgood_text);
								$num_newlines = count($lines_arr);
								
								if($num_newlines > $maxrow2)
								{
									for($i=$startrow1; $i<$maxrow2; $i++)
									{
										if(isset($lines_arr[$i])){
											echo nl2br($lines_arr[$i]);
										}
									}
									$open_hidden2 = 1;
								}
								else
								{
									for($i=$startrow1; $i<$maxrow2; $i++)
									{
										if(isset($lines_arr[$i])){
											echo nl2br($lines_arr[$i]);
										}
									}
									
									echo '<br/>';
									
									$open_hidden2 = 0;
								}
 							?>
 						</td>
 					</tr>
 					<?php } ?>
                 </table>
             </div>

 			<div style="position:relative; margin-left:0px">
				<?php
					echo '-------------------------------------------------------------------------------------------------------------------------------------------------------------------------';
				?>
 			</div>
 		</div>
    </div>
</div>
<?php }if($open_hidden2 == 1){ ?>
<pagebreak>

<div style="position:relative; width:100%; color:black;" align="center">
    <div style="position:relative; width:785px; border:#fff 1px solid" align="left">

	    <div style="position:relative; font-size:18px; font-family:couriers; border-bottom:#000 1px solid;float: left">
		    ATTACHMENT
	    </div>
	    <div style="position:relative; font-size:12px; font-family:couriers; border-bottom:#000 1px solid;float: left">
		    <div style="margin-top:5px; margin-bottom:5px;float:left;width:20%">
			    BILL OF LADING NO. 
			</div>	
			<div style="float:left;width:50%">
				<span style="font-family:couriers; font-size:14px; font-weight:bold">
					<?php
						$k = MasterG3eJobrouting::find()->where(['jr_job_id'=>$id])->asArray()->one();
						
						$total_hbl = $k['jr_hbl'];
						$jr_house_scac = $k['jr_house_scac'];

						$nomor_hbl = $jr_house_scac.' '.$job['job_location'].''.$job['job_year'].''. $job['job_month'].''.str_pad($job['job_number'],5, '0', STR_PAD_LEFT);
						
						if(isset($k)){
							echo '<div style="float:left;width:10%;font-size:10px; margin-right:5px">'.$jr_house_scac.'</div>';
							echo '<div style="float:left;width:50%;">'.$job['job_location'].''.$job['job_year'].''. $job['job_month'].''.str_pad($job['job_number'],5, '0', STR_PAD_LEFT).'</div>';
						}
					?>
			    </span>
		    </div>
	    </div>
		
	    <!-- CONTENT -->
		<div style="position:relative; margin:0px 0px 0px 0px; border-top:#000 1px solid;">
			<div style="position:relative; border-bottom:#000 1px solid; font-size:10px; font-weight:bold; padding-top:2px; padding-bottom:2px" align="center" class="font1">
				UNDERMENTIONED PARTICULARS AS DECLARED AND FURNISHED BY THE SHIPPER<br/>
				QUANTITY, CONDITION, CONTENTS AND ALL OTHER INFORMATION SHOWN ARE UNKNOWN TO THE CARRIER
			</div>
		
			<!-- ISI CONTENT -->
            <div style="margin-top:5px">
             	<table width="100%" cellspacing="0" cellpadding="2" class="font2" style="text-align:center;border:0px">
                    <?php
						$desc = MasterG3eHblDescription::find()->where(['hbldes_job_id'=>$id])->asArray()->one();
					
						if(!empty($desc['hbldes_desofgood']))
						{
 					?>
 					<tr>
 						<td valign="top" width="100px" align="left">
 							<div></div>
 						</td>
 						<td valign="top" width="120px"></td>
 						<td valign="top" width="300px" style="text-align:left" colspan="4">
 							<?php
								if($count_cargo == 5){
									$startrow2 	= 91; 
									$maxrow3 	= 162; 
								}elseif($count_cargo == 4){
									$startrow2 	= 92; 
									$maxrow3 	= 163; 
								}elseif($count_cargo == 3){
									$startrow2 	= 93; 
									$maxrow3 	= 164; 
								}elseif($count_cargo == 2){
									$startrow2	= 94;
									$maxrow3 	= 165;
								}else{
									$startrow2 	= 95;
									$maxrow3 	= 166;
								}
								
								$hbldes_desofgood_text = str_replace('\n', '<br/>', $desc['hbldes_desofgood']);
								$hbldes_desofgood_text = str_replace(' ', '&nbsp;', $hbldes_desofgood_text);

								$lines_arr = preg_split('/\n/',$hbldes_desofgood_text);
								$num_newlines = count($lines_arr);
								
								if($num_newlines > $maxrow3)
								{
									for($i=$startrow2; $i<$maxrow3; $i++)
									{
										if(isset($lines_arr[$i])){
											echo nl2br($lines_arr[$i]);
										}
									}
									$open_hidden3 = 1;
								}
								else
								{
									for($i=$startrow2; $i<$maxrow3; $i++)
									{
										if(isset($lines_arr[$i])){
											echo nl2br($lines_arr[$i]);
										}
									}
									
									$open_hidden3 = 0;
								}
 							?>
 						</td>
 					</tr>
 					<?php } ?>
                 </table>
             </div>

 			<div style="position:relative;margin-left:0px">
				<?php
					echo '-------------------------------------------------------------------------------------------------------------------------------------------------------------------------';
				?>
 			</div>
 		</div>
    </div>
</div>
<?php } ?>
