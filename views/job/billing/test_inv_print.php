<?php
use yii\helpers\Url;
use yii\helpers\Html;


use app\models\MasterNewJob;
use app\models\MasterG3eHblRouting;


use app\models\PosV8;
use app\models\DMasterNewJobinvoice;
use app\models\DMasterNewJobinvoiceDetail;

use yii\helpers\VarDumper;

$job = MasterNewJob::find()->where(['id' => $_GET['id']])->one();
$routing = MasterG3eHblRouting::find()->where(['hblrouting_job_id' => $_GET['id']])->one();
$invoice = DMasterNewJobinvoice::find()->where(['inv_job_id' => $_GET['id']])->one();
$invoice_detail = DMasterNewJobinvoiceDetail::find()->where(['invd_job_id' => $_GET['id']])->all();

// VarDumper::dump($job->job_name,10,true);die();

	/*include 'init.php';
	include 'lib.php';

	$job_id = $_GET['job'];

	$inv = $_GET['inv'];

	$r = mysqli_fetch_array(mysqli_query($CONN, 'SELECT * FROM master_g3e_vesselbatch WHERE vessel_job_id = '.$job_id.''));
	$vessel_place_receipt = $r['vessel_place_receipt'];
	$vessel_place_delivery = $r['vessel_place_delivery'];
	$vessel_freight_term = $r['vessel_freight_term'];


	// INVOICE ==================================================================================================
	$p = mysqli_fetch_array(mysqli_query($CONN, 'SELECT * FROM master_new_jobinvoice WHERE inv_id = '.$inv.''));
	$inv_job_id = $p['inv_job_id'];
	$inv_job_group = $p['inv_job_group'];
	$inv_type = $p['inv_type'];
	$inv_count = $p['inv_count'];
	$inv_date = $p['inv_date'];
	$inv_code = $p['inv_code'];
	$inv_currency = $p['inv_currency'];
	$inv_ppn = $p['inv_ppn'];
	$inv_total = $p['inv_total'];
	$inv_customer = $p['inv_customer'];
	$inv_customer2 = $p['inv_customer2'];
	$inv_customer3 = $p['inv_customer3'];
	$inv_to1 = $p['inv_to'];
	$inv_to2 = $p['inv_to2'];
	$inv_to3 = $p['inv_to3'];
	$additional_notes = $p['additional_notes'];
	$no_bl_sementara = $p['no_bl_sementara'];

	$inv_is_active = $p['inv_is_active'];

	$tt = explode('-', $inv_date);

	$p = mysqli_fetch_array(mysqli_query($CONN, 'SELECT * FROM master_new_job WHERE id = '.$inv_job_id.''));
	$id = $p['id'];
	$job = $p['job'];
	$job_type = $p['job_type'];
	$job_location = $p['job_location'];
	$job_year = $p['job_year'];
	$job_month = $p['job_month'];

	$job_number = $p['job_number'];
	if(strlen($job_number) == 1) { $job_number = '000'.$job_number; }
	elseif(strlen($job_number) == 2) { $job_number = '00'.$job_number; }
	elseif(strlen($job_number) == 3) { $job_number = '0'.$job_number; }
	elseif(strlen($job_number) == 4) { $job_number = $job_number; }

	$job_customer = $p['job_customer'];
	$job_from = $p['job_from'];
	$job_to = $p['job_to'];
	$job_ship = $p['job_ship'];
	$job_hb = $p['job_hb'];
	$job_mb = $p['job_mb'];

	$job_group = $job_type;
	$ref_number = $job.''.$job_type.''.$job_location.''.$job_year.''.$job_month.''.$job_number;
	// echo $inv_job_id;exit;

	if($job == 'G1')
	{
		//master customer
		$r = mysqli_fetch_array(mysqli_query($CONN, 'SELECT * FROM customer WHERE customer_id = '.$inv_customer.''));
		$customer_nickname = $r['customer_nickname'];
		$customer_companyname = $r['customer_companyname'];
		$customer_address = $r['customer_address'];
		$customer_telephone = $r['customer_telephone'];
		$customer_contact_person = $r['customer_contact_person'];
		$customer_npwp = $r['customer_npwp'];

		// information
		$r = mysqli_fetch_array(mysqli_query($CONN, 'SELECT * FROM master_new_jobdata WHERE detail_job_id = '.$inv_job_id.''));
		$date_departure = $r['date_departure'];
		$date_arrival = $r['date_arrival'];
		$detail_id = $r['detail_id'];
		$additional_notes1 = $r['additional_notes'];

		$b = mysqli_fetch_array(mysqli_query($CONN, 'SELECT * FROM point WHERE point_code = "'.$r['loading_location'].'"'));
		$point_name = $b['point_name'];

		$b = mysqli_fetch_array(mysqli_query($CONN, 'SELECT * FROM vessel WHERE vessel_code = "'.$r['vessel_name1'].'"'));
		$vessel_name = $b['vessel_name'];
		$vessel_name2 = $r['vessel_name2'];

		$b = mysqli_fetch_array(mysqli_query($CONN, 'SELECT * FROM point WHERE point_code = "'.$r['departure'].'"'));
		$departure = $b['point_name'];

		$b = mysqli_fetch_array(mysqli_query($CONN, 'SELECT * FROM point WHERE point_code = "'.$r['destinition'].'"'));
		$destinition = $b['point_name'];

		$peb_1 = $r['peb_1'];
		$peb_2 = $r['peb_2'];
		$peb_3 = $r['peb_3'];
		$peb_4 = $r['peb_4'];
	}
	else if($job == 'G3')
     {
		//master customer
		$r = mysqli_fetch_array(mysqli_query($CONN, 'SELECT * FROM customer WHERE customer_id = '.$inv_customer.''));
		$customer_nickname = $r['customer_nickname'];
		$customer_companyname = $r['customer_companyname'];
		$customer_address = $r['customer_address'];
		$customer_telephone = $r['customer_telephone'];
		$customer_contact_person = $r['customer_contact_person'];
		$customer_npwp = $r['customer_npwp'];

		$r = mysqli_fetch_array(mysqli_query($CONN, 'SELECT * FROM master_g3e_vesselbatch WHERE vessel_job_id = '.$job_id.''));
		$vessel_batch_id = $r['vessel_batch_id'];

		$br = mysqli_fetch_array(mysqli_query($CONN, 'SELECT * FROM batch WHERE batch_id = '.$vessel_batch_id.''));
		$batch_id = $br['batch_id'];
		$pol_id = $br['pol_id'];
		$pol_dod = $br['pol_dod'];
		$pc_vessel = $br['pc_vessel'];

		$pc_voyage = $br['pc_voyage'];
		$pcv_doa = $br['pcv_doa'];
		$pcv_dod = $br['pcv_dod'];
		$lfp_id = $br['lfp_id'];

		$lfp_doa = $br['lfp_doa'];
		$lfp_dod = $br['lfp_dod'];
		$lfp_vessel = $br['lfp_vessel'];
		$lfp_voyage = $br['lfp_voyage'];

		$pod_id = $br['pod_id'];
		$pod_doa = $br['pod_doa'];
		$is_active = $br['is_active'];

		$point_name = $pc_vessel;
		$vessel_name = $pol_id;
		$vessel_name2 = $pcv_dod;

		$b = mysqli_fetch_array(mysqli_query($CONN, 'SELECT * FROM point WHERE point_code = "'.$pol_id.'"'));
		$pol_code = $b['point_name'];

		$b = mysqli_fetch_array(mysqli_query($CONN, 'SELECT * FROM point WHERE point_code = "'.$pod_id.'"'));
		$pod_code = $b['point_name'];

		$by = mysqli_fetch_array(mysqli_query($CONN, 'SELECT * FROM vessel WHERE vessel_code = "'.$pc_vessel.'"'));
		$vessel_name_x = $by['vessel_name'];

		$by = mysqli_fetch_array(mysqli_query($CONN, 'SELECT * FROM vessel WHERE vessel_code = "'.$lfp_vessel.'"'));
		$vessel2_name_x = $by['vessel_name'];

		if($inv_currency == 2)
		{
			$inv_currency = 1;
		}
     }

	// MPDF
	$nama_dokumen=$ref_number.' '.$customer_nickname; //Beri nama file PDF hasil.
*/
// $job = 'G3';
$job_type = 'E';
// $inv_currency = 2;

?>

<html>
	<head>
		<title><?php //echo $nama_dokumen;?></title>
	</head>

	<body style="font-family:Arial, Helvetica, sans-serif; font-size:12px">
		<div style="position:absolute;top:0;left:0; width:100%; color:black; font-family:Arial, Helvetica, sans-serif; font-size:12px;line-height:normal;" align="center">
	    	<div style="position:relative; width:778px; height:1102px; border:#ccc 0px solid" align="left">

				<div id="header" style="position:relative">
					<div style="vertical-align:top">
						<?php //include 'test_inv_logo.php'; ?>
						<div style="position:relative; margin-bottom:20px; margin-top:14px">
							<div style="position:relative; font-size:18pt;line-height:normal; left:-1px; letter-spacing: 1px;">PT. FULUSO KENCANA INTERNATIONAL</div>
							<div style="position:relative; font-size:7pt;line-height:normal">
								<div style="position:relative; margin-bottom:0px">Jl. Tanjung Batu 21L/12A, Surabaya 60177, Indonesia &nbsp;&nbsp;&nbsp;<span style="position:relative; top:2px; font-size:15px">&bull;</span>
								&nbsp;&nbsp;&nbsp;P. +62 31 357 7000 / 5120 5555
								&nbsp;&nbsp;&nbsp;<span style="position:relative; top:2px; font-size:15px">&bull;</span>
								&nbsp;&nbsp;&nbsp;<span style="position:relative; top:-1;">ID@fuluso.com</span></div>

							</div>
						</div>
					</div>
					<!-- <div style="float:right; vertical-align:top; text-align:right">
						<div style="position:relative; font-size:20px;">
							INVOICE
						</div>
						<div style="position:relative; font-size:22px;">
							<?php //if($inv_currency == 1) echo 'HMC'.invoice_number($inv_count); else  echo 'IDT'.invoice_number($inv_count); ?>
						</div>
						<div style="position:relative; font-size:10px;">
							<?php //echo date("d F Y", strtotime($inv_date)); ?>
						</div>
					</div> -->
				</div>

				<div id="address" style="position:relative; margin-bottom:20px">
					<?php if($job->job == 'G1') { ?>
						<div style="display:inline-block; width:490px; vertical-align:top">
							<div style="position:relative; margin-bottom:3px">
								<div style="display:inline-block; width:130px">REF. NUMBER</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block"><?= $job->job_name ?></div>

							</div>
							<div style="position:relative; margin-bottom:3px">
								<div style="display:inline-block; width:130px">CUSTOMER</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block"><?= $job->customer_name ?></div>

							</div>
							<div style="position:relative; margin-bottom:3px">
								<div style="display:inline-block; width:130px">HBL / HAWB NO.</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block">-
									<?php// if(!empty($no_bl_sementara)) { echo strtoupper($no_bl_sementara); } else { echo strtoupper($job_hb); } ?>
								</div>
							</div>
							<div style="position:relative; margin-bottom:3px">
								<div style="display:inline-block; width:130px">MBL / MAWB NO.</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block">HAMBURG, DE
									<?php //echo strtoupper($job_mb); ?>
								</div>
							</div>
							<div style="position:relative; margin-bottom:3px">
								<div style="display:inline-block; width:130px">VESSEL</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block"><?php echo strtoupper($vessel_name.' - '.$vessel_name2);?></div>

							</div>
							<div style="position:relative; margin-bottom:3px">
								<div style="display:inline-block; width:130px">DEPARTURE</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block"><?php echo strtoupper($departure);?></div>

							</div>
							<div style="position:relative; margin-bottom:3px">
								<div style="display:inline-block; width:130px">DEPARTURE DATE</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block"><?php echo strtoupper($date_departure);?></div>

							</div>
							<div style="position:relative; margin-bottom:3px">
								<div style="display:inline-block; width:130px">ARRIVAL</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block"><?php echo strtoupper($destinition);?></div>

							</div>
							<div style="position:relative; margin-bottom:3px">
								<div style="display:inline-block; width:130px">ARRIVAL DATE</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block"><?php echo strtoupper($date_arrival);?></div>

							</div>
							<div style="position:relative; margin-bottom:3px">
								<div style="display:inline-block; width:130px">PEB/PIB NO.</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block"><?php echo strtoupper($peb_1.'-'.$peb_2.'-'.$peb_3.'-'.$peb_4);?></div>

							</div>
							<div style="position:relative; margin-bottom:3px">
								<div style="display:inline-block; width:130px; vertical-align:top">CONT. NUMBER</div>
								<div style="display:inline-block; width:5px; vertical-align:top">: </div>
								<div style="display:inline-block; vertical-align:top; width:270px">
									<?php
										$bb = mysqli_fetch_array(mysqli_query($CONN, 'SELECT * FROM master_new_jobdata
										WHERE detail_job_id = '.$inv_job_id.''));
										$detail_id = $bb['detail_id'];
										$amount = $bb['amount'];

										if($amount == 1)
										{
											echo 'LCL '.$bb['amount_value'].' '.$bb['amount_pack_type'];
										}
										else
										{
											$data_x = mysqli_query($CONN, 'SELECT * FROM master_new_jobdata_amount
											WHERE jda_jobdetail_id = "'.$detail_id.'"');
											while($p = mysqli_fetch_array($data_x))
											{
												echo '<div style="display:inline-block; width:135px">'.$p['jda_type'].' '.$p['jda_total'].' '.$p['jda_ukuran'].'</div>';
											}
										}
									?>
								</div>

							</div>
						</div>
						<div style="display:inline-block; vertical-align:top; width:280px; position:relative;">
							<div style="position:relative">
								<div style="display:inline-block; width:120px">INVOICE NO.</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block; font-size:22px; letter-spacing:2px;">
									<?php if($inv_currency == 1) echo 'HMC'.invoice_number($inv_count); else  echo 'IDT'.invoice_number($inv_count); ?>
								</div>
							</div>
							<div style="position:relative; margin-bottom:10px">
								<div style="display:inline-block; width:120px">DATE</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block">
									<?php echo date("d F Y", strtotime($inv_date)); ?>
								</div>
							</div>
							<div style="position:relative">
								<div>TO :</div>
								<div style="width:275px">
									<?php
										if(!empty($inv_to3))
										{
											echo nl2br($inv_to3).'<br/>';
											if($inv_code != 'E')
											{
												echo npwp_name($inv_to1).'<br/>';
											}
										}
										else
										{
											echo $customer_companyname.'<br/>';
											echo nl2br($customer_address).'<br/>';
											if($inv_code != 'E')
											{
												echo $customer_npwp.'<br/>';
											}
										}
									?>
								</div>

							</div>
							<div style="position:relative; margin-top:10px">
								<div style="display:inline-block; width:120px; vertical-align:top">ADDITIONAL NOTES</div>
								<div style="display:inline-block; width:5px; vertical-align:top">: </div>
								<div style="width:275px">
									<?php
										if(!empty($additional_notes1))
										{
											echo strtoupper(nl2br($additional_notes1));
										}
										else
										{
											echo strtoupper(nl2br($additional_notes));
										}
									?>
								</div>

							</div>
						</div>


					<?php } else if($job->job == 'G3') { ?>
					<?php if($job_type == 'E') { ?>
						<div style="display:inline-block; width:490px; vertical-align:top">
							<div style="position:relative; margin-bottom:3px">
								<div style="display:inline-block; width:130px; vertical-align:top">REF. NUMBER</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block; vertical-align:top"><?= $job->job_name ?></div>

							</div>
							<div style="position:relative; margin-bottom:3px">
								<div style="display:inline-block; width:130px; vertical-align:top">CUSTOMER</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block; vertical-align:top"><?= $job->customer_name ?></div>

							</div>
							<div style="position:relative; margin-bottom:3px">
								<div style="display:inline-block; width:130px; vertical-align:top">HBL / HAWB NO.</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block; vertical-align:top">-
									<?php
										/*if($job_id == '111')
										{
											echo 'JNF/261/12/16';
										}
										else
										{
											if(!empty($no_bl_sementara))
											{
												echo strtoupper($no_bl_sementara);
											}
											else
											{
												$by = mysqli_fetch_array(mysqli_query($CONN, 'SELECT * FROM master_g3e_jobrouting WHERE jr_job_id = "'.$job_id.'"'));
												$jr_office = str_replace('O', '', $by['jr_office']);
												//echo $by['jr_house_scac'].' '.$jr_office.''.$job_year.''.$job_month.''.generateHBoL($by['jr_hbl']);
												echo $by['jr_house_scac'].' '.$jr_office.''.jobNumberBL($job_id);
											}
										}*/
									?>
								</div>

							</div>
							<?php
								/*$r = mysqli_fetch_array(mysqli_query($CONN, 'SELECT * FROM master_g3e_hbl_routing WHERE hblrouting_job_id = '.$job_id.''));
								$place_of_receipt = $r['place_of_receipt'];
								$port_of_loading = $r['port_of_loading'];
								$port_of_delivery = $r['port_of_delivery'];
								$port_of_discharge = $r['port_of_discharge'];*/
							?>
							<div style="position:relative; margin-bottom:3px">
								<div style="display:inline-block; width:130px; vertical-align:top">PORT OF LOADING</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block; vertical-align:top">
									<?php if(isset($routing)){ echo $routing->port_of_loading; }else{ echo '-'; } ?>
								</div>

							</div>
							<div style="position:relative; margin-bottom:3px">
								<div style="display:inline-block; width:130px; vertical-align:top">PORT OF DISCHARGE</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block; vertical-align:top">
									<?php if(isset($routing)){ echo $routing->port_of_discharge; }else{ echo '-'; } ?>
									<?php // if(!empty($port_of_discharge)) { echo $port_of_discharge; } else { echo point_name($pod_id); }?>
								</div>

							</div>
							<div style="position:relative; margin-bottom:3px">
								<div style="display:inline-block; width:130px; vertical-align:top">FINAL DESTINATION</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block; vertical-align:top">
									<?php if(isset($routing)){ echo $routing->port_of_delivery; }else{ echo '-'; } ?>
									<?php //if(!empty($port_of_delivery)) { echo $port_of_delivery; } else { echo point_name($vessel_place_delivery); }?>
								</div>
							</div>
							<div style="position:relative; margin-bottom:3px">
								<div style="display:inline-block; width:130px; vertical-align:top">VESSEL</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block; vertical-align:top">TRADER 094S
									<?php if(isset($routing)){ echo $routing->port_of_delivery; }else{ echo '-'; } ?>
									<?php
									/*if($job_id == '264')
									{
										echo 'KYAUK PHYU STAR V.1584S';
									}
									else if($job_id == '306')
									{
										echo 'SINAR SABANG V. 427S';
									}
									else
									{
										echo strtoupper($vessel_name_x.' '.$pc_voyage).'<br/> '.strtoupper($vessel2_name_x .' '. $lfp_voyage);
									}*/
									?>
								</div>

							</div>
							<div style="position:relative; margin-bottom:3px">
								<div style="display:inline-block; width:130px; vertical-align:top">DEPARTURE</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block; vertical-align:top">GRHBG 2022-08-30
									<?php
									/*if($job_id == '264')
									{
										echo viewTanggal_simple('2016-12-16');
									}
									else if($job_id == '306')
									{
										echo '2017-01-10';
									}
									else
									{
										echo strtoupper($pol_id.' '.$pcv_dod);
									}*/
									?>
								</div>

							</div>
							<div style="position:relative; margin-bottom:3px">
								<div style="display:inline-block; width:130px; vertical-align:top">ARRIVAL</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block; vertical-align:top"> IDSRG 2022-10-05
									<?php
									/*if($job_id == '264')
									{
										echo viewTanggal_simple('2016-12-29');
									}
									else if($job_id == '306')
									{
										echo '2017-01-28';
									}
									else
									{
										echo strtoupper($pod_id.' '.$pod_doa);
									}*/
									?>
								</div>
							</div>

							<div style="position:relative; margin-bottom:3px; display:">
								<div style="display:inline-block; width:130px; vertical-align:top">CONT. NUMBER : </div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block; vertical-align:top">BSIU 9516145 40'HC
									<?php
										/*if($job_id == '264')
										{
											echo 'LCL';
										}
										else if($job_id == '306')
										{
											echo 'DFSU6979060 / 40HC';
										}
										else
										{
											echo '<div style="display:inline-block; width:130px; vertical-align:top">';
											$query_container = mysqli_query($CONN, 'SELECT * FROM master_g3e_container WHERE con_job_id = "'.$job_id.'" limit 0,9');
											while($by = mysqli_fetch_array($query_container))
											{
												$con_count = $by['con_count'];
												$con_code = $by['con_code'];
												$con_text = $by['con_text'];
												$con_name = $by['con_name'];

												echo $con_code.' '.$con_text.' '.$con_name.'<br/>';
											}
											echo '</div>';

											echo '<div style="display:inline-block; width:130px; vertical-align:top">';
											$query_container = mysqli_query($CONN, 'SELECT * FROM master_g3e_container WHERE con_job_id = "'.$job_id.'" limit 9,9');
											while($by = mysqli_fetch_array($query_container))
											{
												$con_count = $by['con_count'];
												$con_code = $by['con_code'];
												$con_text = $by['con_text'];
												$con_name = $by['con_name'];

												echo $con_code.' '.$con_text.' '.$con_name.'<br/>';
											}
											echo '</div>';
										}*/
									?>
								</div>

							</div>
						</div>

						<div style="display:inline-block; vertical-align:top; width:280px; position:relative;top:-7px">
							<div style="position:relative">
								<div style="display:inline-block; width:120px">INVOICE NO.</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block; font-size:22px; letter-spacing:2px;">IDT005566
									<?php //if($inv_currency == 1) echo 'HMC'.invoice_number($inv_count); else  echo 'IDT'.invoice_number($inv_count); ?>
								</div>
							</div>
							<div style="position:relative; margin-bottom:10px">
								<div style="display:inline-block; width:120px">DATE</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block"><?= date('d F Y')?>
									<?php//echo date("d F Y", strtotime($inv_date)); ?>
								</div>
							</div>
							<div style="position:relative">
								<div>TO :</div>PT. CAHAYA PERMATA GANDARI <br>
									JL. PERUM GRIYA LESTARI B4/10<br>
									RT.003 / RW.009 GONDORIYO<br>
									NGALIYAN, SEMARANG, JAWA TENGAH<br>
									INDONESIA<br>
									-<br>
									96.602.496.0-503.000<br>
								<div style="width:275px; margin-top:15px">
									
									<?php
										/*if(!empty($inv_to3))
										{
											echo nl2br($inv_to3).'<br/>';
											if($inv_code != 'E')
											{
												echo npwp_name($inv_to1).'<br/>';
											}
										}
										else
										{
											echo $customer_companyname.'<br/>';
											echo nl2br($customer_address).'<br/>';
											if($inv_code != 'E')
											{
												echo $customer_npwp.'<br/>';
											}
										}*/
									?>
								</div>

							</div>
							<div style="position:relative; margin-top:0px">
								<div style="display:inline-block; width:120px; vertical-align:top">ADDITIONAL NOTES</div>
								<div style="display:inline-block; width:5px; vertical-align:top">: </div>
								<div style="width:275px">
									<?php
										/*if($job_id == '264')
										{
											echo 'MBL NO. SHASUBGC0002';
										}
										else
										{
											echo nl2br($additional_notes);
										}*/
									?>
								</div>

							</div>
						</div>

						<!--<div style="position:relative; margin-bottom:10px; display:block">
							<div style="display:inline-block; width:130px; vertical-align:top">CONT. NUMBER</div>
							<div style="display:inline-block; width:5px; vertical-align:top">: </div>
							<div style="position:relative">
								<?php
									/*if($job_id == '264')
									{
										echo 'LCL';
									}
									else if($job_id == '306')
									{
										echo 'DFSU6979060 / 40HC';
									}
									else
									{
										$ckckckck = mysqli_num_rows(mysqli_query($CONN, 'SELECT * FROM master_g3e_container WHERE con_job_id = "'.$job_id.'"'));
										if($ckckckck > 1)
										{
											echo '<div style="display:inline-block; width:130px; vertical-align:top">';
											$query_container = mysqli_query($CONN, 'SELECT * FROM master_g3e_container WHERE con_job_id = "'.$job_id.'" limit 0,4');
											while($by = mysqli_fetch_array($query_container))
											{
												$con_count = $by['con_count'];
												$con_code = $by['con_code'];
												$con_text = $by['con_text'];
												$con_name = $by['con_name'];

												echo $con_code.' '.$con_text.' '.$con_name.'<br/>';
											}
											echo '</div>';

											echo '<div style="display:inline-block; width:130px; vertical-align:top">';
											$query_container = mysqli_query($CONN, 'SELECT * FROM master_g3e_container WHERE con_job_id = "'.$job_id.'" limit 4,4');
											while($by = mysqli_fetch_array($query_container))
											{
												$con_count = $by['con_count'];
												$con_code = $by['con_code'];
												$con_text = $by['con_text'];
												$con_name = $by['con_name'];

												echo $con_code.' '.$con_text.' '.$con_name.'<br/>';
											}
											echo '</div>';

											echo '<div style="display:inline-block; width:130px; vertical-align:top">';
											$query_container = mysqli_query($CONN, 'SELECT * FROM master_g3e_container WHERE con_job_id = "'.$job_id.'" limit 8,4');
											while($by = mysqli_fetch_array($query_container))
											{
												$con_count = $by['con_count'];
												$con_code = $by['con_code'];
												$con_text = $by['con_text'];
												$con_name = $by['con_name'];

												echo $con_code.' '.$con_text.' '.$con_name.'<br/>';
											}
											echo '</div>';

											echo '<div style="display:inline-block; width:130px; vertical-align:top">';
											$query_container = mysqli_query($CONN, 'SELECT * FROM master_g3e_container WHERE con_job_id = "'.$job_id.'" limit 12,4');
											while($by = mysqli_fetch_array($query_container))
											{
												$con_count = $by['con_count'];
												$con_code = $by['con_code'];
												$con_text = $by['con_text'];
												$con_name = $by['con_name'];

												echo $con_code.' '.$con_text.' '.$con_name.'<br/>';
											}
											echo '</div>';

											echo '<div style="display:inline-block; width:130px; vertical-align:top">';
											$query_container = mysqli_query($CONN, 'SELECT * FROM master_g3e_container WHERE con_job_id = "'.$job_id.'" limit 16,4');
											while($by = mysqli_fetch_array($query_container))
											{
												$con_count = $by['con_count'];
												$con_code = $by['con_code'];
												$con_text = $by['con_text'];
												$con_name = $by['con_name'];

												echo $con_code.' '.$con_text.' '.$con_name.'<br/>';
											}
											echo '</div>';
										}
										else
										{
											$query_container = mysqli_query($CONN, 'SELECT * FROM master_g3e_container WHERE con_job_id = "'.$job_id.'"');
											while($by = mysqli_fetch_array($query_container))
											{
												$con_count = $by['con_count'];
												$con_code = $by['con_code'];
												$con_text = $by['con_text'];
												$con_name = $by['con_name'];

												echo $con_code.' '.$con_text.' '.$con_name.'<br/>';
											}
										}
									}*/
								?>
							</div>

						</div>-->

					<?php } else if($job_type == 'I') {

						$total_ocean = mysqli_num_rows(mysqli_query($CONN, 'SELECT * FROM master_new_job_ocean WHERE id_job = "'.$job_id.'"'));
						$total_air = mysqli_num_rows(mysqli_query($CONN, 'SELECT * FROM master_new_job_air WHERE id_job = "'.$job_id.'"'));

						if($total_ocean != 0)
						{
							$oc = mysqli_fetch_array(mysqli_query($CONN, 'SELECT * FROM master_new_job_ocean WHERE id_job = "'.$job_id.'"'));
						}
						else if($total_air != 0)
						{
							$oc = mysqli_fetch_array(mysqli_query($CONN, 'SELECT * FROM master_new_job_air WHERE id_job = "'.$job_id.'"'));
						}
						?>
						<div style="display:inline-block; width:490px; vertical-align:top">
							<div style="position:relative; margin-bottom:3px">
								<div style="display:inline-block; width:130px; vertical-align:top">REF. NUMBER</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block; vertical-align:top"><?php echo $ref_number;?></div>

							</div>
							<div style="position:relative; margin-bottom:3px">
								<div style="display:inline-block; width:130px; vertical-align:top">CUSTOMER</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block; vertical-align:top"><?php echo strtoupper($customer_companyname);?></div>

							</div>
							<div style="position:relative; margin-bottom:3px">
								<div style="display:inline-block; width:130px; vertical-align:top">HBL / HAWB NO.</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block; vertical-align:top">
									<?php
										if($job_id == '111')
										{
											echo 'JNF/261/12/16';
										}
										else
										{
											if(!empty($no_bl_sementara))
											{
												echo strtoupper($no_bl_sementara);
											}
											else
											{
												$by = mysqli_fetch_array(mysqli_query($CONN, 'SELECT * FROM master_g3e_jobrouting WHERE jr_job_id = "'.$job_id.'"'));
												$jr_office = str_replace('O', '', $by['jr_office']);
												//echo $by['jr_house_scac'].' '.$jr_office.''.$job_year.''.$job_month.''.generateHBoL($by['jr_hbl']);
												echo $by['jr_house_scac'].' '.$jr_office.''.jobNumberBL($job_id);
											}
										}
									?>
								</div>

							</div>
							<?php
							/*$p = mysqli_fetch_array(mysqli_query($CONN, 'SELECT * FROM master_new_noa WHERE id_job = "'.$job_id.'"'));
							$batch = $p['batch'];
							$r = mysqli_fetch_array(mysqli_query($CONN, 'SELECT * FROM batch WHERE batch_id = "'.$batch.'"'));
							$pol_id = $r['pol_id'];
							$pol_dod = $r['pol_dod'];
							$pc_vessel = $r['pc_vessel'];
							$pc_voyage = $r['pc_voyage'];
							$pcv_doa = $r['pcv_doa'];
							$pcv_dod = $r['pcv_dod'];
							$lfp_id = $r['lfp_id'];
							$lfp_doa = $r['lfp_doa'];
							$lfp_dod = $r['lfp_dod'];
							$lfp_vessel = $r['lfp_vessel'];
							$lfp_voyage = $r['lfp_voyage'];
							$pod_id = $r['pod_id'];
							$pod_doa = $r['pod_doa'];*/
							?>
							<div style="position:relative; margin-bottom:3px">
								<div style="display:inline-block; width:130px; vertical-align:top">PORT OF LOADING</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block; vertical-align:top">
									<?php
										/*if($job_id == 524)
										{
											echo 'USATL - ATLANTA, GA USA';
										}
										else
										{
											echo point_name($pol_id);
										}*/
									?>
								</div>

							</div>
							<div style="position:relative; margin-bottom:3px">
								<div style="display:inline-block; width:130px; vertical-align:top">PORT OF DISCHARGE</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block; vertical-align:top">
									<?php
										/*if($job_id == 524)
										{
											echo 'SGSIN, SINGAPORE';
										}
										else
										{
											echo point_name($pod_id);
										}*/
									?>
								</div>

							</div>
							<div style="position:relative; margin-bottom:3px">
								<div style="display:inline-block; width:130px; vertical-align:top">FINAL DESTINATION</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block; vertical-align:top">
									<?php
										/*if($job_id == 524)
										{
											echo 'IDSUB';
										}
										else
										{
											echo point_name($job_to);
										}*/
									?>
								</div>

							</div>
							<div style="position:relative; margin-bottom:3px">
								<div style="display:inline-block; width:130px; vertical-align:top">VESSEL</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block; vertical-align:top">
									<?php
										/*if($job_id == 524)
										{
											echo 'CI5253';
										}
										else
										{
											echo vessel_name($lfp_vessel).' '.$lfp_voyage;
										}*/
									?>
								</div>

							</div>
							<div style="position:relative; margin-bottom:3px">
								<div style="display:inline-block; width:130px; vertical-align:top">DEPARTURE</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block; vertical-align:top">
									<?php
										/*if($job_id == 524)
										{
											echo '22 APR 2017';
										}
										else
										{
											echo strtoupper($pol_id.' '.$pcv_dod);
										}*/
									?>
								</div>

							</div>
							<div style="position:relative; margin-bottom:3px">
								<div style="display:inline-block; width:130px; vertical-align:top">ARRIVAL</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block; vertical-align:top">
									<?php
										/*if($job_id == 524)
										{
											echo '26 APR 2017';
										}
										else
										{
											echo strtoupper($pod_id.' '.$pod_doa);
										}*/
									?>
								</div>
							</div>
							<div style="position:relative; margin-bottom:3px">
								<div style="display:inline-block; width:130px; vertical-align:top">CONT. NUMBER</div>
								<div style="display:inline-block; width:5px; vertical-align:top">: </div>
								<div style="display:inline-block; vertical-align:top">
									<?php
										/*$query_container = mysqli_query($CONN, 'SELECT * FROM master_g3e_container WHERE con_job_id = "'.$job_id.'"');
										while($by = mysqli_fetch_array($query_container))
										{
											$con_count = $by['con_count'];
											$con_code = $by['con_code'];
											$con_text = $by['con_text'];
											$con_name = $by['con_name'];

											echo $con_code.' '.$con_text.' '.$con_name.'<br/>';
										}*/
									?>
								</div>

							</div>
						</div>

						<div style="display:inline-block; vertical-align:top; width:280px; position:relative; top:-7px">
							<div style="position:relative">
								<div style="display:inline-block; width:120px">INVOICE NO.</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block; font-size:22px; letter-spacing:2px;">
									<?php //if($inv_currency == 1) echo 'HMC'.invoice_number($inv_count); else  echo 'IDT'.invoice_number($inv_count); ?>
								</div>
							</div>
							<div style="position:relative; margin-bottom:10px">
								<div style="display:inline-block; width:120px">DATE</div>
								<div style="display:inline-block; width:5px">: </div>
								<div style="display:inline-block">
									<?php //echo date("d F Y", strtotime($inv_date)); ?>
								</div>
							</div>
							<div style="position:relative">
								<div style="width:275px; margin-top:25px">
									<?php
										/*if(!empty($inv_to3))
										{
											echo nl2br($inv_to3).'<br/>';
											if($inv_code != 'E')
											{
												echo npwp_name($inv_to1).'<br/>';
											}
										}
										else
										{
											echo $customer_companyname.'<br/>';
											echo nl2br($customer_address).'<br/>';
											if($inv_code != 'E')
											{
												echo $customer_npwp.'<br/>';
											}
										}*/
									?>
								</div>

							</div>
							<div style="position:relative; margin-top:10px">
								<div style="display:inline-block; width:120px; vertical-align:top">ADDITIONAL NOTES</div>
								<div style="display:inline-block; width:5px; vertical-align:top">: </div>
								<div style="width:275px">
									<?php
										/*if($job_id == '264')
										{
											echo 'MBL NO. SHASUBGC0002';
										}
										else
										{
											echo nl2br($additional_notes);
										}*/
									?>
								</div>

							</div>
						</div>
					<?php } } ?>
				</div>

				<div style="position:relative; border-top:1px solid #000; height:18px; line-height:18px">
					<div style="width:185px; display:inline-block; text-align:left; padding:0px 2px 0px 0px"> DESCRIPTION OF CHARGES</div>
					<div style="width:155px; display:inline-block; text-align:left; padding:0px 2px 0px 0px"></div>
					<div style="width:82px; display:inline-block; text-align:center; padding:0px 2px 0px 2px">BASIC</div>
					<div style="width:85px; display:inline-block; text-align:center; padding:0px 2px 0px 2px">QUANTITY</div>
					<div style="width:90px; display:inline-block; text-align:right; padding:0px 2px 0px 2px">AMOUNT</div>
					<div style="width:90px; display:inline-block; text-align:right; padding:0px 2px 0px 2px">TOTAL</div>
					<div style="width:40px; display:inline-block; text-align:center; padding:0px 2px 0px 2px">CURR</div>
				</div>

				<div style="position:relative; border-top:1px solid #000">
				<?php
					/*$tot_jumlah = 0;
					$tot_ppnq = 0;
					$sql = mysqli_query($CONN, 'SELECT * FROM master_new_jobinvoice_detail WHERE invd_inv_id = '.$inv.' AND invd_amount != 0 ORDER BY invd_count ASC');
					while($r = mysqli_fetch_array($sql))
					{
						$invd_pos = $r['invd_pos'];
						$invd_detail = $r['invd_detail'];
						$invd_basis1_total = $r['invd_basis1_total'];
						$invd_basis1_type = $r['invd_basis1_type'];
						$invd_basis2_total = $r['invd_basis2_total'];

						$invd_basis2_type = $r['invd_basis2_type'];

						$invd_basis2_type = str_replace("\'", "", $invd_basis2_type);

						if($invd_basis2_type == "20"){$invd_basis2_type = '20"';}
						elseif($invd_basis2_type == "40"){$invd_basis2_type = '40"';}

						$invd_rate = $r['invd_rate'];
						$invd_amount = $r['invd_amount'];
						$invd_exch = $r['invd_exch'];
						if($invd_pos == 202){
							$namepos = "EXP EXPRESS RELEASE";
						}elseif($invd_pos == 201){
							$namepos = "EXP EXPRESS RELEASE";
						// }elseif($invd_pos != 201){
						// 	$namepos = "EXP EXPRESS RELEASE FREE";
						}elseif($invd_pos !== 201){
							$namepos = pos_name($invd_pos);
						}*/
						?>
						
					<?php
						foreach($invoice_detail as $row)
						{
							$pos = PosV8::find()->where(['pos_id'=>$row['invd_pos']])->one();
					?>	
						<div style="position:relative; line-height:12px">
							<div style="width:185px; display:inline-block; text-align:left; padding:4px 2px 2px 2px; vertical-align:top">
								<?= $pos->pos_name ?>
							</div>
							<div style="width:155px; display:inline-block; text-align:left; padding:4px 2px 2px 2px; vertical-align:top">
								<?= $row['invd_detail'] ?>
							</div>
							<div style="width:82px; display:inline-block; text-align:left; padding:4px 2px 2px 2px; vertical-align:top">
								<div style="display:inline-block; width:24px; text-align:right;font-size:10px">
									<?= number_format($row['invd_basis1_total'],0,'.',',') ?>
									<?php
										/*$mm = explode('.', $invd_basis1_total);
										if(count($mm) == 2)
										{
											echo numberToCurrencyx($mm[0]).'.'.$mm[1];
										}
										else
										{
											echo numberToCurrencyx($invd_basis1_total);
										}*/
									?>&nbsp;
								</div>
								<div style="display:inline-block; width:48px;font-size:10px"><?= $row['invd_basis1_type'] ?></div>

							</div>
							<div style="width:95px; display:inline-block; text-align:left; padding:4px 2px 2px 2px; vertical-align:top">
								<div style="display:inline-block; width:38px; text-align:right;font-size:10px">
									<?= number_format($row['invd_basis2_total'],0,'.',',') ?>
									<?php
										/*$mm = explode('.', $invd_basis2_total);
										if(count($mm) == 2)
										{
											if(strlen($mm[1]) == 1)
											{
												$mm[1] = $mm[1].'0';
											}
											else
											{
												$mm[1] = substr($mm[1], 0, 3);
											}
											echo numberToCurrencyx($mm[0]).'.'.$mm[1];
										}
										else
										{
											echo numberToCurrencyx($invd_basis2_total);
										}*/
									?>&nbsp;
								</div>
								<div style="display:inline-block; width:48px;font-size:10px"><?= $row['invd_basis2_type'] ?></div>

							</div>
							<div style="width:80px; display:inline-block; text-align:right; padding:4px 2px 2px 2px; vertical-align:top">
								<?= number_format($row['invd_rate'],0,'.',',') ?>
								<?php
									/*$rate_pisah = explode('.', $invd_rate);
									if(!empty($rate_pisah[1]))
									{
										if(strlen($rate_pisah[1]) == 1)
										{
											$rate_pisah[1] = $rate_pisah[1].'0';
										}
										else
										{
											$rate_pisah[1] = substr($rate_pisah[1], 0, 2);
										}
									}
									else
									{
										$rate_pisah[1] = '00';
									}
									echo numberToCurrency3($rate_pisah[0]).'.'.$rate_pisah[1].'';
									$invd_rate_new = $rate_pisah[0].'.'.$rate_pisah[1];

									// $xx = $rate_pisah[0].'.'.$rate_pisah[1];
									// echo numberToCurrency3(round($xx, 2));
									// $invd_rate_new = round($xx, 2);*/
								?>
							</div>
							<div style="width:90px; display:inline-block; text-align:right; padding:4px 2px 2px 2px; vertical-align:top">
								<?= number_format($row['invd_amount'],0,'.',',') ?>
								<?php
									/*$amount_pisah = explode('.', $invd_amount);
									if(!empty($amount_pisah[1]))
									{
										if(strlen($rate_pisah[1]) == 1)
										{
											$amount_pisah[1] = $amount_pisah[1].'0';
										}
										else
										{
											$amount_pisah[1] = substr($amount_pisah[1], 0, 2);
										}
									}
									else
									{
										$amount_pisah[1] = '00';
									}
									echo numberToCurrency3($amount_pisah[0]).'.'.$amount_pisah[1];
									$invd_amount_new = $amount_pisah[0].'.'.$amount_pisah[1];
									// $xx = $amount_pisah[0].'.'.$amount_pisah[1];
									// echo numberToCurrency3(round($xx, 2));
									// $invd_amount_new = round($xx, 2);
											*/

								?>
							</div>
							<div style="width:40px; display:inline-block; text-align:center; padding:4px 2px 2px 2px; vertical-align:top">IDR
								<?php
									// if($inv_currency == '1') { echo 'USD';}
									// elseif($inv_currency == '2') { echo 'IDR';}
									// elseif($inv_currency == '3') { echo 'IDR';}
								?>
							</div>

						</div>
					<?php } ?>
						<?php$inv_currency = '2';
						if($inv_currency == '2')
						{
						?>
						<!--<div style="position:relative; line-height:18px">
							<div style="width:685px; display:inline-block; text-align:left; padding:4px 2px 2px 2px; vertical-align:top">
								
							</div>
						    	<div style="width:120px; display:inline-block; text-align:right; padding:4px 2px 2px 2px; vertical-align:top">
							   <?php
								  // $exch_pisah = explode('.', $invd_exch);
								  // if(empty($exch_pisah[1])){ $exch_pisah[1] = '00'; };
								  // $invd_exch_new = $exch_pisah[0].'.'.$exch_pisah[1];
							   ?>
						    	</div>
						    	<div style="width:120px; display:inline-block; text-align:right; padding:4px 2px 2px 2px; vertical-align:top">
							  <?php
								 // $tot_exch_pisah = explode('.', $invd_amount_new * $invd_exch_new);
								 // if(empty($tot_exch_pisah[1])){ $tot_exch_pisah[1] = '00'; };
								 // $tot_exch_new = $tot_exch_pisah[0].'.'.$tot_exch_pisah[1];
							  ?>
						    	</div>
						    	<div style="width:40px; display:inline-block; text-align:center; padding:4px 2px 2px 2px; vertical-align:top">
								<?php
									// if($inv_currency == '1') { echo 'USD';}
									// elseif($inv_currency == '2') { echo 'IDR';}
									// elseif($inv_currency == '3') { echo 'IDR';}
								?>
							</div>

						</div>-->
						<?php
						$tot_jumlah = '0.00';
						// }
						// else
						// {
						    // $tot_jumlah = '0.00';
						// }

						/*if($inv_ppn == '1')
						{
						    	if($inv_currency == '2')
						    	{
									$tot_ppn_pisah = explode('.', $tot_exch_new);
									if(empty($tot_ppn_pisah[1])){ $tot_ppn_pisah[1] = '00'; }
									$tot_ppn_new = $tot_ppn_pisah[0].'.'.$tot_ppn_pisah[1];

									$tot_ppnq = $tot_ppnq + $tot_ppn_new;
						    	}
						    	else
						    	{
									$tot_ppn_pisah = explode('.', $invd_amount);
									if(empty($tot_ppn_pisah[1])){ $tot_ppn_pisah[1] = '00'; }
									$tot_ppn_new = $tot_ppn_pisah[0].'.'.$tot_ppn_pisah[1];

									$tot_ppnq = $tot_ppnq + $tot_ppn_new;
						    	}
						}*/
					// }
				?>
				</div>

				<?php$inv_currency =2;
				if($inv_currency != 1)
				{
				?>
				<div style="position:relative; line-height:18px; margin-top:40px">
					<div style="position:relative">
						<div style="width:626px; display:inline-block; text-align:right; padding:2px 2px 2px 2px; vertical-align:top">
							TOTAL
						</div>
						<div style="width:90px; display:inline-block; text-align:right; padding:2px 2px 2px 2px; vertical-align:top">
							<?= number_format($invoice['inv_total'],0,'.',',') ?>
							<?php

								/*$tot_jumlah_pisah = explode('.', $tot_jumlah);
								if(empty($tot_jumlah_pisah[1])){ $tot_jumlah_pisah[1] = '00'; }
								else
								{
									if(strlen($tot_jumlah_pisah[1]) == 1)
									{
										$tot_jumlah_pisah[1] = $tot_jumlah_pisah[1].'0';
									}
									else
									{
										$tot_jumlah_pisah[1] = substr($tot_jumlah_pisah[1], 0, 2);
									}
								}

								echo numberToCurrency3($tot_jumlah_pisah[0]).'.'.$tot_jumlah_pisah[1];
								$tot_jumlah_new = $tot_jumlah_pisah[0].'.'.$tot_jumlah_pisah[1];*/
							?>
						</div>
						<div style="width:40px; display:inline-block; text-align:center; padding:2px 2px 2px 2px; vertical-align:top">IDR
							<?php
								// if($inv_currency == '1') { echo 'USD';}
								// elseif($inv_currency == '2') { echo 'IDR';}
								// elseif($inv_currency == '3') { echo 'IDR';}
							?>
						</div>

					</div>
				</div>

				<div style="position:relative; line-height:18px">
					<div style="position:relative">
						<div style="width:626px; display:inline-block; text-align:right; padding:0px 2px 2px 2px; vertical-align:top">
							PPN / VAT
						</div>
						<div style="width:90px; display:inline-block; text-align:right; padding:0px 2px 2px 2px; vertical-align:top">
							<?= number_format($invoice['inv_ppn'],0,'.',',') ?>
							<?php
								/*if($inv_currency == 1)
								{
									echo '0.00';
								}
								else
								{
									if($inv_ppn == 1)
									{

										$tot_ppnq_pisah = explode('.', $tot_ppnq);
										if(!empty($tot_ppnq_pisah[1])){ $tot_ppnq_pisah[1] = '00'; }
										else { $tot_ppnq_pisah[1] = '00'; }
										if((date("Y-m-d",strtotime($inv_date))) >= "2022-04-01" ){
											$ppnvat = floor(($tot_ppnq_pisah[0]) * 1.1/100);
										}else{
											$ppnvat = floor(($tot_ppnq_pisah[0]) * 1/100);
										}

										echo numberToCurrency3($ppnvat).'.'.$tot_ppnq_pisah[1];
										$tot_ppnq_new = $ppnvat.'.'.$tot_ppnq_pisah[1];

									}
									else
									{
										echo '0.00';
									}
								}*/
							?>
						</div>
						<div style="width:40px; display:inline-block; text-align:center; padding:2px 2px 2px 2px; vertical-align:top">IDR
							<?php
								// if($inv_currency == '1') { echo 'USD';}
								// elseif($inv_currency == '2') { echo 'IDR';}
								// elseif($inv_currency == '3') { echo 'IDR';}
							?>
						</div>

					</div>
				</div>

				<div style="position:relative; border-top:1px solid #000; line-height:18px">
					<div style="position:relative">
						<div style="width:626px; display:inline-block; text-align:right; padding:2px 2px 2px 2px; vertical-align:top">
							TOTAL
						</div>
						<div style="width:90px; display:inline-block; text-align:right; padding:2px 2px 2px 2px; vertical-align:top">
							<?= number_format($invoice['inv_total'] + $invoice['inv_ppn'],0,'.',',') ?>
							<?php
								// $tot_supertotal_pisah = explode('.', $tot_jumlah_new + $tot_ppnq_new);
								// if(empty($tot_supertotal_pisah[1])){ $tot_supertotal_pisah[1] = '00'; }
								// else
								// {
									// if(strlen($tot_supertotal_pisah[1]) == 1)
									// {
										// $tot_supertotal_pisah[1] = $tot_supertotal_pisah[1].'0';
									// }
									// else
									// {
										// $tot_supertotal_pisah[1] = substr($tot_supertotal_pisah[1], 0, 2);
									// }
								// }
								// else { $tot_supertotal_pisah[1] = '00'; }

								// $xx = $tot_supertotal_pisah[0].'.'.$tot_supertotal_pisah[1];
								// echo numberToCurrency3(round($xx, 2));
								// $tot_supertotal_new = round($xx, 2);
								// echo numberToCurrency3($tot_supertotal_pisah[0]).'.'.$tot_supertotal_pisah[1];
								// $tot_supertotal_new = $tot_supertotal_pisah[0].'.'.$tot_supertotal_pisah[1];
							?>
						</div>
						<div style="width:40px; display:inline-block; text-align:center; padding:2px 2px 2px 2px; vertical-align:top">IDR
							<?php
								// if($inv_currency == '1') { echo 'USD';}
								// elseif($inv_currency == '2') { echo 'IDR';}
								// elseif($inv_currency == '3') { echo 'IDR';}
							?>
						</div>

					</div>
				</div>
				<?php
				// }
				// else
				// {
					// echo $tot_jumlah;
					// $tot_jumlah_pisah = explode('.', $tot_jumlah);
					// if(empty($tot_jumlah_pisah[1])){ $tot_jumlah_pisah[1] = '00'; }
					// else { $tot_jumlah_pisah[1] = '00'; }
					//echo numberToCurrency3($tot_jumlah_pisah[0]).'.'.$tot_jumlah_pisah[1];
					// $tot_jumlah_new = $tot_jumlah_pisah[0].'.'.$tot_jumlah_pisah[1];
				?>
				<!--<div style="position:relative; line-height:18px; margin-top:40px">
					<div style="position:relative">
						<div style="width:626px; display:inline-block; text-align:right; padding:2px 2px 2px 2px; vertical-align:top">
							TOTAL
						</div>
						<div style="width:90px; display:inline-block; text-align:right; padding:2px 2px 2px 2px; vertical-align:top">
							<?php
								// $tot_supertotal_pisah = explode('.', $tot_jumlah_new + $tot_ppnq_new);
								// if(empty($tot_supertotal_pisah[1])){ $tot_supertotal_pisah[1] = '00'; }
								// else
								// {
									// if(strlen($tot_supertotal_pisah[1]) == 1)
									// {
										// $tot_supertotal_pisah[1] = $tot_supertotal_pisah[1].'0';
									// }
									// else
									// {
										// $tot_supertotal_pisah[1] = substr($tot_supertotal_pisah[1], 0, 2);
									// }
								// }
								// else { $tot_supertotal_pisah[1] = '00'; }

								// $xx = $tot_supertotal_pisah[0].'.'.$tot_supertotal_pisah[1];
								// echo numberToCurrency3(round($xx, 2));
								// $tot_supertotal_new = round($xx, 2);
								// echo numberToCurrency3($tot_supertotal_pisah[0]).'.'.$tot_supertotal_pisah[1];
								// $tot_supertotal_new = $tot_supertotal_pisah[0].'.'.$tot_supertotal_pisah[1];
							?>
						</div>
						<div style="width:40px; display:inline-block; text-align:center; padding:2px 2px 2px 2px; vertical-align:top">
							<?php
								// if($inv_currency == '1') { echo 'USD';}
								// elseif($inv_currency == '2') { echo 'IDR';}
								// elseif($inv_currency == '3') { echo 'IDR';}
							?>
						</div>

					</div>
				</div>-->
				<?php
				// }
				?>

				<div style="position:relative; border-top:1px solid #000; border-bottom:1px solid #000; padding:0px 2px 0px 0px; line-height:18px">
					<?php
					// if($inv_currency == '1')
					// {
						// $last_amount = str_replace(',', '', number_format($tot_supertotal_new,2));
						// $last_amount = str_replace('.', ',', $last_amount);
						// $vv = explode('.', $tot_supertotal_new);
						// if($vv[1] == '00')
						// {
							// echo 'US DOLLARS '.strtoupper(convert_number_to_words($vv[0])).' ONLY';
						// }
						// else
						// {
							// echo 'US DOLLARS '.strtoupper(convert_number_to_words($tot_supertotal_new)).' ONLY';
						// }
					// }
					// elseif($inv_currency == '2')
					// {
						// $last_amount = str_replace(',', '', number_format($tot_supertotal_new,2));
						// $last_amount = str_replace('.', ',', $last_amount);
						// echo strtoupper(terbilang($last_amount)).' RUPIAH';
					// }
					// elseif($inv_currency == '3')
					// {
						// $last_amount = str_replace(',', '', number_format($tot_supertotal_new,2));
						// $last_amount = str_replace('.', ',', $last_amount);
						// echo strtoupper(terbilang($last_amount)).' RUPIAH';
					// }
					?>SATU JUTA RUPIAH. ---
				</div>

				<div style="position:relative; margin-top:20px; left:-3px">
					<?php //include 'test_inv_remark.php'; ?>
				</div>

				<?php
				/*if($job == 'G3')
				{
					if($tot_supertotal_new < 0)
					{
						echo '<div style="position:absolute; top:110px; right:214px">CREDIT TO :</div>';
					}
					else
					{
						if($inv_currency == 1  || $inv_currency == 'USD')
						{
							echo '<div style="position:absolute; top:110px; right:234px">BILL TO :</div>';
						}
						else
						{
							echo '<div style="position:absolute; top:104px; right:262px">TO :</div>';
						}
					}
				}*/
				?>
				<div style="position:relative; margin-top:20px; left:-3px">
					<table style="font-size:11px; font-family:Arial, Helvetica, sans-serif">
						<tbody><tr>
							<td colspan="2"><b>REMARKS</b></td>
						</tr>
						<tr>
							<td valign="top">1. </td>
							<td>Any complaint must be addressed before tax invoice is issued</td>
						</tr>
						<tr>
							<td valign="top">2. </td>
							<td>All cheque and bank transfer should be crossed and made payable to "PT. FULUSO KENCANA INTERNATIONAL"</td>
						</tr>
						<tr>
							<td valign="top">3. </td>
							<td>Payment by cheque / Cash Deposit / TT is valid when the fund is credited to our company account.</td>
						</tr>
						<tr>
							<td valign="top">4. </td>
							<td>Please address your payment indicate this invoice number and mark "FULL AMOUNT" to:<br>

							<div style="height:5px"></div>
							PT. Bank Permata<br>
							Cabang Darmo Park Surabaya<br>
							<div>
								<div style="display:inline-block; width:60px; vertical-align:top">Swift Code</div>
								<div style="display:inline-block; vertical-align:top; width:4px">: </div>
								<div style="display:inline-block; vertical-align:top; ">B B B A I D J A</div>
							</div>
							<div>
								<div style="display:inline-block; width:60px; vertical-align:top">Account No.</div>
								<div style="display:inline-block; vertical-align:top; width:4px">: </div>
								<div style="display:inline-block; vertical-align:top">2 9 0 1 1 7 3 9 7 7</div>
							</div>
							<div>
								<div style="display:inline-block; width:60px; vertical-align:top">Beneficiary</div>
								<div style="display:inline-block; vertical-align:top; width:4px">: </div>
								<div style="display:inline-block; vertical-align:top">
									PT. FULUSO KENCANA INTERNATIONAL <br>
									Jl. Tanjung Batu 21L / 12A, Surabaya 60177, Indonesia
								</div>
							</div>
							</td>
						</tr>
						<tr>
							<td valign="top">5. </td>
							<td>Payment can be affected in any currency equivalent to the above amount but reserve the right to recover unfavorable exchange rate</td>
						</tr>
						<tr>
							<td valign="top">6. </td>
							<td>Our TIN / NPWP No: 01.715.871.8-605.000 for PT. FULUSO KENCANA INTERNATIONAL</td>
							<!-- NPWP Tax Registration No: 01.751.871.8-605.000  PT. FULUSO KENCANA INTERNATIONAL -->
						</tr>
						<tr>
							<td valign="top">7. </td>
							<td>Please send us the bank receipt after the remittance is done</td>
						</tr>
						<tr>
							<td colspan="2"><b>### THIS IS A COMPUTER GENERATED DOCUMENT. NO SIGNATURE IS REQUIRED ###</b></td>
						</tr>
					</tbody></table>
				</div>
			</div>
			
		</div>
		
	</body>
</html>
