<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\MasterNewJob;

use app\models\MasterG3eHblCusdata;
use app\models\MasterG3eJobrouting;

use app\models\MasterG3eVesselbatch;
use app\models\MasterVesselRouting;
use app\models\MasterVesselRoutingDetail;
use app\models\MasterG3eHblRouting;

use app\models\MasterG3eHblCargodetail;
use app\models\MasterG3eContainer;

use app\models\MasterG3eHblDescription;

use yii\helpers\VarDumper;

$job = MasterNewJob::find()->where(['id'=>$id])->asArray()->one();
$type = $job['g3_type'];
$total = $job['g3_total'];
$packages = $job['g3_packages'];
$job_location = $job['job_location'];
?>

<div class="draft-bl-index">
	<div class="w-100">
		<!-- HEADER -->
		<div class="title-draft" style="float:left; width:60%; text-align:left;">
			<img src="<?= Url::base().'/img/logo.jpg'?>" width="250px">
		</div>
		
		<div style="float:right; width:40%; text-align:right;">
			<div style="font-size:20px" class="font1">
				NON NEGOTIABLE<br/>
				BILL OF LADING
			</div>
			<div style="font-size:8px; padding-bottom:2px" class="font4">
				(NON NEGOTIABLE UNLESSCONSIGNED TO ORDER)
			</div>
		</div>
		<div style="clear:both"></div>
	</div>
	
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
	
	<div style="margin:10px 0px 0px 0px">
		<div class="w-100 border-top border-bottom">

			<div class="m-0 p-0 border-right" style="float:left; width:49.8%;">
				<div class="border-bottom" style="height:82px">
					<div style="padding-left:4px; padding-top:2px" class="font4">
						SHIPPER/EXPORTER (COMPLETE NAME AND ADDRESS)
					</div>
					<div style="margin-left:10px" class="font2">
						<?php echo strtoupper(nl2br($hblcusdata_shipper_info)); ?>
					</div>
				</div>

				<div style="height:86px">
					<div style="padding-left:4px; padding-top:2px" class="font4">
						CONSIGNEE (COMPLETE NAME AND ADDRESS)
					</div>
					<div style="margin-left:10px" class="font2">
						<?php echo strtoupper(nl2br($hblcusdata_consignee_info)); ?>
					</div>
				</div>
			</div>

			<div class="m-0 p-0" style="float:right; width:50%">
				<div class="border-bottom" style="height:28px">
					<div style="padding-left:4px; padding-top:2px" class="font4">
						BILL OF LADING NO.
					</div>
					<div style="margin-left:10px" class="font2">
						<?php
							$k = MasterG3eJobrouting::find()->where(['jr_job_id'=>$id])->asArray()->one();
							
							$total_hbl = $k['jr_hbl'];
							$jr_house_scac = $k['jr_house_scac'];

							// $nomor_hbl = $jr_house_scac.' '.$job_location.''. $job;

							echo '<div style="float:left;width:10%; font-size:10px; margin-right:5px">'.$jr_house_scac.'</div>';
							echo '<div style="float:left;width:30%;">'.$k['jr_ref_number'].'</div>';
						?>
					</div>
				</div>
				<div class="border-bottom" style="height:28px">
					<div style="padding-left:4px; padding-top:2px" class="font4">
						EXPORT REFERENCE
					</div>
					<div style="margin-left:10px" class="font2">
						<?php
							$r = MasterG3eJobrouting::find()->where(['jr_job_id'=>$id])->one();
							
							if(isset($r)){
								echo strtoupper($r->jr_ref_number);
							}
						?>
					</div>
				</div>
				<div class="border-bottom" style="height:82px">
					<div style="padding-left:4px; padding-top:2px" class="font4">
						DELIVERY / ROUTING AGENT - REFERENCES AND INSTRUCTIONS
					</div>
					<div style="margin-left:10px" class="font2">
						<?php
							$k = MasterG3eJobrouting::find()->where(['jr_job_id'=>$id])->asArray()->one();
						
							echo strtoupper(nl2br($r['jr_agentloc']));
						?>
					</div>
				</div>
				<div class="w-100" style="height:28px">
					<div class="border-right" style="float:left; width:50%;height:30px">
						<div style="padding-left:4px; padding-top:2px" class="font4">
							POINT AND COUNTRY OF ORIGIN OF GOODS
						</div>
						<div style="position:relative; margin-left:10px" class="font2">
							<?php
								$origin = MasterG3eJobrouting::find()->where(['jr_job_id'=>$id])->one();
								
								// echo $origin->country->name;
							?>
						</div>
					</div>
					<div style="float:right; width:49%;">
						<div style="position:relative; padding-left:4px; padding-top:2px" class="font4">
							ORIGINAL TO BE RELEASED AT
						</div>
						<div style="margin-left:10px" class="font2">
							<?php
								$r = MasterG3eHblDescription::find()->where(['hbldes_job_id'=>$id])->one();
							
								if(isset($r)){
									echo $r->office->office_name;
								}
							?>
						</div>
					</div>
				</div>
			</div>
			<div style="clear:both"></div>
		</div>
	</div>

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
	
	<div style="margin:0px 0px 0px 0px">
		<div style="border-bottom:#000 1px solid;">
			<div style="float:left; width:49.8%">

				<div style="height:82px">
					<div style="padding-left:4px; padding-top:2px" class="font4">
						NOTIFY PARTY (COMPLETE NAME AND ADDRESS)
					</div>
					<div style="position:relative; margin-left:10px" class="font2">
						<?php echo strtoupper(nl2br($hblcusdata_notify_info)); ?>
					</div>
				</div>

				<div class="border-top">
					<div class="border-right" style="float:left; width:49%; height:38px">
						<div style="padding-left:4px; padding-top:2px" class="font4">
							PRE-CARRIAGE BY
						</div>
						<div style="margin-left:10px" class="font2">
						   <?= isset($vr) ? $vr->vesselstart->vessel_name.' '.$voyage_start : '' ?>
						</div>
					</div>
					<div style="float:right;width:50%">
						<div style="padding-left:4px; padding-top:2px" class="font4">
							PLACE OF RECEIPT
						</div>
						<div style="margin-left:10px; width:150px" class="font2">
							<?php 
								if(!empty($place_of_receipt)){ 
									echo $place_of_receipt; 
								}else{
									if(isset($vb)){
										echo $vb->por->point_name;
									}else{
										echo '';
									}
								}
							?>
						</div>
					</div>
					<div style="clear:both"></div>
				</div>

				<div class="border-top">
					<div class="border-right" style="float:left; width:49%; height:38px">
						<div style="padding-left:4px; padding-top:2px" class="font4">
							VESSEL/VOYAGE/FLAG
						</div>
						<div style="margin-left:10px" class="font2">
							<?= isset($vr) ? $vr->vesselend->vessel_name.' '.$voyage_end : '' ?>
						</div>
					</div>
					<div style="float:right;width:50%">
						<div style="padding-left:4px; padding-top:2px" class="font4">
							PORT OF LOADING
						</div>
						<div style="margin-left:10px; width:150px" class="font2">
							<?php 
								if(!empty($port_of_loading)){
									echo $port_of_loading;
								}else{
									if(isset($vr)){
										echo $vr->pointstart->point_name;
									}else{
										echo '';
									}
								}
							?>
						</div>
					</div>
					<div style="clear:both"></div>
				</div>

				<div class="border-top">
					<div class="border-right" style="float:left; width:49%; height:38px">
						<div style="padding-left:4px; padding-top:2px" class="font4">
							PORT OF DISCHARGE
						</div>
						<div style="margin-left:10px" class="font2">
							<?php 
								if(!empty($port_of_discharge)){
									echo $port_of_discharge;
								}else{
									if(isset($vr)){
										echo $vr->pointend->point_name;
									}else{
										echo '';
									}
								}
							?>
						</div>
					</div>
					<div style="float:right;width:50%">
						<div style="padding-left:4px; padding-top:2px" class="font4">
							PLACE OF DELIVERY
						</div>
						<div style="margin-left:10px; width:150px" class="font2">
							<?php 
								if(!empty($port_of_delivery)){
									echo $port_of_delivery;
								}else{
									if(isset($vb)){
										echo $vb->fod->point_name;
									}else{
										echo '';
									}
								}
							?>
						</div>
					</div>
					<div style="clear:both"></div>
				</div>
			</div>
			<div class="border-left" style="float:right; width:50%; height:199px;">
				<div class="border-bottom" style="height:83px">
					<div style="padding-left:4px; padding-top:2px" class="font4">
						ALSO NOTIFY PARTY-ROUTING & INSTRUCTION
					</div>
					<div style="margin-left:10px" class="font2">
						<?php echo strtoupper(nl2br($hblcusdata_alsonotify_info)); ?>
					</div>
				</div>
				<div style="height:38px">
					<div style="padding-left:4px; padding-top:2px" class="font4">
						TYPE OF MOVEMENT
					</div>
					<div style="position:relative; margin-left:10px" class="font2">
						<?= isset($vb) ? $vb->movement->movement_name : '' ?>
					</div>
				</div>
			<div style="height:38px"></div>
			</div>
			<div style="clear:both"></div>
		</div>
	</div>
	
	<?php 
	
	?>
	
	<!-- CONTENT -->
	<div class="border-top m-0">
		<div class="border-bottom font1" style="font-size:10px; font-weight:bold; padding-top:2px; padding-bottom:2px; text-align:center">
			UNDERMENTIONED PARTICULARS AS DECLARED AND FURNISHED BY THE SHIPPER<br/>
			QUANTITY, CONDITION, CONTENTS AND ALL OTHER INFORMATION SHOWN ARE UNKNOWN TO THE CARRIER
		</div>
		<div style="font-size:10px; padding-top:2px" class="font4">
			<div style="float:left; width:70%; padding-left:4px">
				Container / Seal No.; Kind of Packages; Description of Goods; Marks and Numbers
			</div>
			<div style="float:right;width:20%;text-align:right">
				Weight; Measurement
			</div>
			<div style="clear:both"></div>
		</div>

		<!-- ISI CONTENT -->
		<div style="padding-left:3px">
			<table width="100%" cellspacing="0" cellpadding="2" class="m-0 font2" style="text-align:center; border:0px">
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
							$hblcon_code = $data['con_code'];
							$hblcon_text = $data['con_text'];
							$hblcon_name = $data['con_name'];
							
							$container = $hblcon_code.''.$hblcon_text.' '.$hblcon_name;
							$container2 = $hblcon_code.''.$hblcon_text.' / '.$hblcon_name;
						?>
							<tr>
								<td colspan="6" style="text-align:left;padding-top:5px;">
									<div>
										<?php echo $hblcon_code.''.$hblcon_text; ?>
										/
										<?php echo $hblcon_name; ?>
										/
										<?php echo strtoupper($row['hblcrg_seal']); ?>
										/ 
										<?php echo $row['hblcrg_pack_value'].' '.stripslashes($row['hblcrg_pack_type']); ?>
										
										<?php
										if($row['hblcrg_gross_value'] != '.' && $row['hblcrg_gross_value'] != '.00')
										{
											echo ' / ';
											echo $row['hblcrg_gross_value'].' '.$row['hblcrg_gross_type'];
										}

										if($row['hblcrg_nett_value'] != '.' && $row['hblcrg_nett_value'] != '.00')
										{
											echo ' / ';
											echo $row['hblcrg_nett_value'].' '.$row['hblcrg_nett_type'];
										}

										if($row['hblcrg_msr_value'] != '.' && $row['hblcrg_msr_value'] != '.00')
										{
											echo ' / ';
											echo $row['hblcrg_msr_value'].' '.$row['hblcrg_msr_type'];
										}
										?>
										<div style="clear:both"></div>
									</div>
								</td>
							</tr>
							<?php
							if(!empty($row['hblcrg_description']))
							{
								echo '<tr>
										<td style="width:120px" align="left">
											<div></div>
										</td>
										<td style="width:120px"></td>
										<td style="width:250px; text-align:left">'.nl2br(stripslashes($row['hblcrg_description'])).'</td>
									</tr>';
							}
							$i++;

							$tot_hblcrg_gross_value = $tot_hblcrg_gross_value + $row['hblcrg_gross_value'];
							$tot_hblcrg_nett_value = $tot_hblcrg_nett_value + $row['hblcrg_nett_value'];
							$tot_hblcrg_msr_value = $tot_hblcrg_msr_value + $row['hblcrg_msr_value'];

							$hblcrg_gross_type = $row['hblcrg_gross_type'];
							$hblcrg_nett_type = $row['hblcrg_nett_type'];
							$hblcrg_msr_type = $row['hblcrg_msr_type'];
						}
					}
				
					echo '<tr>
						<td colspan="6" class="border-top"></td>
					</tr>';
					
					$v = MasterG3eHblDescription::find()->where(['hbldes_job_id'=>$id])->asArray()->one();
					
					if(!empty($v['hbldes_desofgood_text']))
					{
					?>
					<tr>
						<td valign="top" align="left">
							<div style="width:120px">
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
						<td valign="top">
							<div style="position:relative; width:70px">
								<?php
								//if($type == 'FCL')
								// {
									$conta = MasterG3eContainer::find()->select(['con_name'])->where(['con_job_id'=>$id])->distinct()->asArray()->all();
									
									foreach($conta as $row){
										$jumlah = MasterG3eContainer::find()->where(['con_job_id'=>$id, 'con_name'=>$row['con_name']])->count();
										
										echo $jumlah.'X'.$row['con_name'].'<br/>';
									}
								// }
								?>
							</div>
						</td>
						<td valign="top" style="text-align:left">
							<div style="position:relative; width:365px">
								<?php
								if($type != 'FCL')
								{
									echo 'SAID TO CONTAIN <br/>';
								}

								$desc = MasterG3eHblDescription::find()->where(['hbldes_job_id'=>$id])->asArray()->one();
								
								$hbldes_desofgood_text = str_replace('\n', '<br/>', $desc['hbldes_desofgood']);
								$hbldes_desofgood_text = str_replace(' ', '&nbsp;', $hbldes_desofgood_text);

								$lines_arr = preg_split('/\n/',$hbldes_desofgood_text);
								$num_newlines = count($lines_arr);
								if($num_newlines > '19')
								{
									for($i=0; $i<19; $i++)
									{
										echo nl2br($lines_arr[$i]);
									}
									$open_hidden = 1;
								}
								else
								{
									echo nl2br($hbldes_desofgood_text);

									echo '<br/>';
								}
								?>
							</div>
						</td>
						<td valign="top" align="right">
							<div style="position:relative; width:55px">
								<?php if(!empty($tot_hblcrg_gross_value)) echo 'GW :<br/>';?>
								<?php if(!empty($tot_hblcrg_nett_value)) echo 'NW :<br/>';?>
								<?php if(!empty($tot_hblcrg_msr_value)) { echo 'MEAS :'; }?>
							</div>
						</td>
						<td valign="top" colpan="2" align="left">
							<div style="position:relative; width:150px">
								<?php
									if(!empty($tot_hblcrg_gross_value))
									{
										$check1 = explode('.', $tot_hblcrg_gross_value);
										if(count($check1) == 2) { echo $tot_hblcrg_gross_value.' '.$hblcrg_gross_type.'<br/>'; }

										else { echo $tot_hblcrg_gross_value.'00 '.$hblcrg_gross_type.'<br/>'; }
									}

									if(!empty($tot_hblcrg_nett_value))
									{
										$check2 = explode('.', $tot_hblcrg_nett_value);
										if(count($check2) == 2) { echo $tot_hblcrg_nett_value.' '.$hblcrg_nett_type.'<br/>'; }
										else { echo $tot_hblcrg_nett_value.'00 '.$hblcrg_nett_type.'<br/>'; }
									}

									if(!empty($tot_hblcrg_msr_value))
									{
										$check3 = explode('.', $tot_hblcrg_msr_value);
										if(count($check3) == 2) { echo $tot_hblcrg_msr_value.' '.$hblcrg_msr_type.'<br/>'; }
										else { echo $tot_hblcrg_msr_value.'00 '.$hblcrg_msr_type.'<br/>'; }
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
	
	<div style="margin-bottom:2px">
		<div style="margin-left:0px">
			<div class="border-top w-100"></div>
		</div>
		<div style="margin-top:3px; margin-bottom:3px" class="font2">
			<!-- OCEAN FREIGHT TERMS -->
			FREIGHT
			<?php
				$desc = MasterG3eHblDescription::find()->where(['hbldes_job_id'=>$id])->one();
				
				if(isset($desc)){
					echo $desc->freight->freight_name;
				}
			?>
			<br/>
			<?php
			if($type == 'FCL')
			{
				echo 'SHIPPER STOW, LOAD, COUNT AND SEAL';
			}
			else
			{
				echo 'SAID TO CONTAIN DECLARED BY THE SHIPPER, UNKNOWN TO THE CARRIER.';
			}
			?>
			<br/>
			DESTINATION CHARGES COLLECT PER TARIFF, AND TO BE COLLECTED FROM THE PARTY WHO LAWFULLY DEMANDS DELIVERY OF THE CARGO.  <br/>
		</div>
		<div style="margin-left:0px">
			<div class="border-top w-100"></div>
		</div>
		<div style="clear:both"></div>
	</div>
	
	<div class="m-0">
		<div class="w-100" style="">
			<div style="float:left; width: 5.5%; padding-top:7px;">
				<img src="<?= Url::base().'/img/nn.jpg'?>" width="35px">
			</div>
			
			<div class="border-top border-right"style="float:left; width:44%;">
				<div style="padding-left:4px; padding-top:2px; height:270px" class="font4">
					FREIGHT & CHARGES PAYABLE AT / BY:
					<div class="font2" style="margin-top:5px">
						OCEAN FREIGHT
						<?php
							$desc = MasterG3eHblDescription::find()->where(['hbldes_job_id'=>$id])->one();
							
							if(isset($desc)){
								echo $desc->freight->freight_name;
								echo nl2br(strtoupper($desc['hbldes_payable_details']));
							}
						?>
					</div>
				</div>
				
					
				<div style="padding-left:4px;">
					<div style="font-size:10px; margin-top:5px" class="font4">Laden on Board / Shipped on Board </div>
					<div style="font-size:12px; margin-top:2px" class="font4"><?= isset($vr) ? strtoupper($vr->vesselstart->vessel_name.' - '.$voyage_start) : ''; ?></div>
					<div style="font-size:10px; margin-top:5px" class="font4">Date : ( DAY/MO/YEAR ) </div>
					<div style="font-size:12px; margin-top:2px" class="font4">
						<?php
							if(isset($date_end)){
								$date = date_format(date_create_from_format('Y-m-d', $date_end), 'd F Y');
								echo strtoupper($date);
							}
						?>
					</div>
				</div>
			</div>
			
			<div class="border-top" style="float:left; width:50%">
				<div style="border-bottom:#000 1px solid; font-size:8px; text-align:justify" class="font4">
					<div style="margin:5px">
					RECEIVE by the Carrier, the goods in apparent good order and condition, as far as by reasonable means of checking as specific above unless otherwise stated.
					<br/>The Carrier, in accordance with the previsions contained in this document:<br/>
					1. Undertakes to perform or to procure the performance of the entire transport from the place of receipt to the<br/>
					&nbsp;&nbsp;&nbsp;&nbsp;place of delivery state above, and<br/>
					2. Assumes liabilities prescribed in this document for such transport.<br/>
					One of the signed Bill of Lading must be surrended duly endorsed in exchange of the Goods or Delivery Order.
					</div>
				</div>
				
				<div class="border-bottom">
					<div style="border:#000 2px solid">
						<div style="float:left; width:40%; font-size:9px; vertical-align:middle; height:20px; line-height:20px; padding-left:2px" class="font4">
							BILL OF LADING NO.
						</div>
						<div style="float:right; width:58%; text-align:left; vertical-align:middle" class="font2">
							<?php
								$k = MasterG3eJobrouting::find()->where(['jr_job_id'=>$id])->asArray()->one();
								
								$total_hbl = $k['jr_hbl'];
								$jr_house_scac = $k['jr_house_scac'];

								// $nomor_hbl = $jr_house_scac.' '.$job_location.''. $job;
								if(isset($k)){
									echo '<div style="float:left;width:10%; font-size:10px; margin-right:5px">'.$jr_house_scac.'</div>';
									echo '<div style="float:left;width:30%;">'.$k['jr_ref_number'].'</div>';
								}
							?>
						</div>
						<div style="clear:both"></div>
					</div>
				</div>
				
				<div class="border-bottom" style="vertical-align:middle; height:20px; line-height:20px;">
					<div style="float:left; width:40%; font-size:9px; padding-left:4px" class="font4">
						Number of Original B(s)/L
					</div>
					<div style="float:right; width:58%; text-align:left" class="font2">
						3
					</div>
					<div style="clear:both"></div>
				</div>
				
				<div class="border-bottom" style="vertical-align:middle; height:20px; line-height:20px;">
					<div style="float:left; width:40%; font-size:9px; padding-left:4px" class="font4">
						Place of Issue
					</div>
					<div style="float:right; width:58%; text-align:left" class="font2">
						<?php
							$desc = MasterG3eHblDescription::find()->where(['hbldes_job_id'=>$id])->one();
				
							if(isset($desc)){
								echo $desc->office->office_name;
							}
						?>
					</div>
					<div style="clear:both"></div>
				</div>
				
				<div class="border-bottom" style="vertical-align:middle; height:20px; line-height:20px;">
					<div style="float:left; width:40%; font-size:9px; padding-left:4px" class="font4">
						Date of Issue ( DAY/MO/YEAR )
					</div>
					<div style="float:right; width:58%; text-align:left" class="font2">
						<?php
							$desc = MasterG3eHblDescription::find()->where(['hbldes_job_id'=>$id])->asArray()->one();
							
							if(isset($desc)){
								$hbldes_doi_day = $desc['hbldes_doi_day'];
								$hbldes_doi_month = $desc['hbldes_doi_month'];
								$hbldes_doi_year = $desc['hbldes_doi_year'];
								
								$date = date_format(date_create_from_format('Y-m-d', $hbldes_doi_year.'-'.$hbldes_doi_month.'-'.$hbldes_doi_day), 'd F Y');
								echo $date;
							}
						?>
					</div>
					<div style="clear:both"></div>
				</div>
				
				<div style="height:96px">
					<div style="margin-bottom:3px; width:50px; margin-right:10px; font-size:8px; padding-left:4px; padding-top:2px" class="font4">
						SIGNED BY
					</div>
					
					<div style="margin-bottom:3px; margin-right:10px; font-size:8px; padding-left:4px" class="font4">
						IN WITNESS of the contract herein contained the number of originals stated above has been issued and signed, one of which being accomplished, the other(s) to be void.
					</div>
					
					<div style="padding-left:4px" class="font2">
						<?php
							$data = MasterG3eHblDescription::find()->where(['hbldes_job_id'=>$id])->asArray()->one();
							
							if(isset($data)){
								echo strtoupper(nl2br($data['hbldes_signature_text']));
							}
						?>
					</div>
					<div style="clear:both"></div>
				</div>
			</div>
		</div>
			
		<div class="border-top" style="margin-left:35px" class="font2">
			<?php
				if(!empty($batchform1) && !empty($batchform2) && !empty($batchform3))
				{
					//echo 'BATCH# '.$batchform1.' / '.$batchform2.' / '.$batchform3;
				}
			?>
		</div>
	</div>
</div>
