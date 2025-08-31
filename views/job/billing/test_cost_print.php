<?php
use yii\helpers\VarDumper;
use yii\helpers\Url;


	/*include 'init.php';
	include 'lib.php';

	$job = $_GET['job'];
	$id = $_GET['vch'];

	$p = mysqli_fetch_array(mysqli_query($CONN, 'SELECT * FROM master_new_jobcost WHERE vch_id = "'.$id.'"'));
     $date = $p['vch_date'];
     $customer = $p['vch_customer'];
	$pay_to = $p['vch_pay_to'];
	$carrier = $p['vch_carrier'];
	$vch_pengembalian = $p['vch_pengembalian'];
	$vch_from = $p['vch_from'];
	$vch_count = $p['vch_count'];
	$vch_type = $p['vch_type'];
	$vch_currency = $p['vch_currency'];

	$m = mysqli_fetch_array(mysqli_query($CONN, 'SELECT * FROM master_new_jobvoucher WHERE vch_job_id = "'.$job.'"'));
	$cost = $m['vch_cost'];

	if(!empty($customer))
	{
		$r = mysqli_fetch_array(mysqli_query($CONN, 'SELECT * FROM customer WHERE customer_id = "'.$customer.'"'));
		$customer_companyname = $r['customer_companyname'];
	}
	else
	{
		$customer_companyname = $carrier;
	}

	$p = mysqli_fetch_array(mysqli_query($CONN, 'SELECT * FROM master_new_job WHERE id = "'.$job.'"'));
     $id_x = $p['id'];
     $job_x = $p['job'];
     $job_type_x = $p['job_type'];
     $job_location_x = $p['job_location'];
     $job_year_x = $p['job_year'];
     $job_month_x = $p['job_month'];

     $job_number_x = $p['job_number'];
     if(strlen($job_number_x) == 1) { $job_number_x = '000'.$job_number_x; }
     elseif(strlen($job_number_x) == 2) { $job_number_x = '00'.$job_number_x; }
     elseif(strlen($job_number_x) == 3) { $job_number_x = '0'.$job_number_x; }
     elseif(strlen($job_number_x) == 4) { $job_number_x = $job_number_x; }*/
?>

<html>

	<head>
		<?php// include 'init_header.php'; ?>
	</head>

	<body style="background-color:white">

		<div style="background-color:white; padding:10px;position:absolute;top:0px;left:0px;line-height:normal">

			<div style="position:relative; font-size:16px; font-weight:bold; margin-bottom:10px">
				BIAYA JOB
			</div>

			<table cellpadding="0" cellspacing="0" border="0" style="font-size:12px; font-family:Arial, Helvetica, sans-serif; margin-bottom:10px">
				<tr>
					<td><div style="width:130px">VOUCHER NUMBER</div></td>
					<td>: VPM220325<?php //if($vch_type == 1) echo 'VPI'.cost_number($id); else echo 'VPM'.cost_number($id);?></td>
				</tr>
				<tr>
					<td><div style="width:130px">REF. NUMBER</div></td>
					<td>: G3ESR22083714<?php //echo $job_x.''.$job_type_x.''.$job_location_x.''.$job_year_x.''.$job_month_x.''.$job_number_x;?></td>
				</tr>
				<tr>
					<td><div style="width:130px">DATE</div></td>
					<td>: <?= date('d F Y')?><?php //$newDate = date("d F Y", strtotime($date)); echo strtoupper($newDate);?></td>
				</tr>
				<tr>
					<td><div style="width:130px">PAY FOR</div></td>
					<td>: CV. KAMPUNG JATI<?php // echo strtoupper($customer_companyname);?></td>
				</tr>
				<tr>
					<td><div style="width:130px">PAY TO</div></td>
					<td>: BU KIKI<?php //if(!empty($pay_to)) {echo strtoupper($pay_to);} else {echo strtoupper($customer_companyname);}?></td>
				</tr>
			</table>

			<table cellpadding="0" cellspacing="0" border="0" style="font-size:12px; font-family:Arial, Helvetica, sans-serif;">
				<tr>
				   <td colspan="7"><div style="background-color:#999; height:1px; margin-top:5px; margin-bottom:5px; border-top:1px solid black"></td>
			    </tr>
			    <tr>
				   <td style="width:187pt">DESCRIPTION OF CHARGES</td>
				   <td style="width:140pt"></td>
				   <td style="width:60pt">BASIC</td>
				   <td style="width:80pt">QUANTITY</td>
				   <td style="width:100pt" align="right">AMOUNT</td>
				   <td style="width:120pt" align="right">TOTAL</td>
				   <td style="width:30pt" align="right">CURR</td>
			    </tr>

			    <tr>
				   <td colspan="7"><div style="background-color:#999; height:1px; margin-top:5px; margin-bottom:5px; border-top:1px solid black"></td>
			    </tr>

			    <?php
			    /*$tot_jumlah = 0;
			    $sql = mysqli_query($CONN, 'SELECT * FROM master_new_jobcost_detail WHERE invd_inv_id = "'.$id.'" AND invd_amount != 0 ');
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
				   $invd_exch = $r['invd_exch'];*/
				   ?>
				   <tr>
					  <td><?php// echo pos_name($invd_pos);?>EXP MISC</td>
					  <td><?php //echo $invd_detail;?>	REFUND</td>
					  <td><?php //echo $invd_basis1_total.' '.$invd_basis1_type;?>1 SHPT</td>
					  <td><?php //echo $invd_basis2_total.' '.$invd_basis2_type;?>1 40'HC</td>
					  <td align="right">3.000.000.00	
						<?php
						    // $rate_pisah = explode('.', $invd_rate);
						    // if(empty($rate_pisah[1])){ $rate_pisah[1] = '00'; };
						    // echo numberToCurrency3($rate_pisah[0]).'.'.$rate_pisah[1];
						    // $invd_rate_new = $rate_pisah[0].'.'.$rate_pisah[1];
						?>
					  </td>
					  <td align="right">3.000.000.00	
						<?php
						    // $amount_pisah = explode('.', $invd_amount);
						    // if(empty($amount_pisah[1])){ $amount_pisah[1] = '00'; };
						    // echo numberToCurrency3($amount_pisah[0]).'.'.$amount_pisah[1];
						    // $invd_amount_new = $amount_pisah[0].'.'.$amount_pisah[1];
						?>
					  </td>
					  <td align="right">IDR
						<?php //echo $vch_currency;?>
					  </td>
				   </tr>

				   <?php
				   //$tot_jumlah = $tot_jumlah + $invd_amount;
			   // }
			    ?>

			   <tr>
				  <td colspan="7"><div style="background-color:#999; height:1px; margin-top:5px; margin-bottom:5px; border-top:1px solid black"></td>
			   </tr>

			   <tr>
				  <td colspan="5" align="right">TOTAL</td>
				  <td align="right">3.000.000.00
					<?php
					    // $tot_jumlah_pisah = explode('.', $tot_jumlah);
					    // if(empty($tot_jumlah_pisah[1])){ $tot_jumlah_pisah[1] = '00'; };
					    // echo numberToCurrency3($tot_jumlah_pisah[0]).'.'.$tot_jumlah_pisah[1];
					    // $tot_jumlah_new = $tot_jumlah_pisah[0].'.'.$tot_jumlah_pisah[1];
					?>
				  </td>
				  <td align="right">IDR
					<?php //echo $vch_currency;?>
				  </td>
			   </tr>

			    <tr>
				   <td colspan="7"><div style="background-color:#999; height:1px; margin-top:5px; margin-bottom:5px; border-top:1px solid black"></td>
			    </tr>

			    <tr>
				   <td colspan="7">TIGA JUTA RUPIAH
					  <?php
					  /*if($vch_currency == 'IDR')
					  {
						  $last_amount = str_replace(',', '', number_format($tot_jumlah_new,2));
     					  $last_amount = str_replace('.', ',', $last_amount);
     					  echo strtoupper(terbilang($last_amount)).' RUPIAH';
					  }
					  else
					  {
						  $last_amount = explode('.', $tot_jumlah_new);
						  echo strtoupper(convertNumber($last_amount[0])).' USD';
					  }*/
					  ?>
				   </td>
			    </tr>
			    <tr>
				   <td colspan="7"><div style="background-color:#999; height:1px; margin-top:5px; margin-bottom:5px; border-top:1px solid black"></td>
			    </tr>

				<?php
				$vch_pengembalian = '';
				if(!empty($vch_pengembalian))
				{
				?>
				<tr>
					<td colspan="5" align="right">PENGEMBALIAN</td>
					<td align="right">
						<?php
							// $tot_pengembalian_pisah = explode('.', $vch_pengembalian);
							// if(empty($tot_pengembalian_pisah[1])){ $tot_pengembalian_pisah[1] = '00'; };
							// echo numberToCurrency3($tot_pengembalian_pisah[0]).'.'.$tot_pengembalian_pisah[1];
						?>
						</td>
					<td align="right">
						<?php// echo $vch_currency;?>
					</td>
				</tr>
				<tr>
					<td colspan="7"><div style="background-color:#999; height:1px; margin-top:5px; margin-bottom:5px; border-top:1px solid black"></td>
				</tr>

			    	<tr>
				   	<td>
					   Pembayaran : <br/>
					   <table cellpadding="0" cellspacing="0" border="1" style="font-size:12px; font-family:Arial, Helvetica, sans-serif;">
					    <tr>
						  <td><div style="margin:5px">DATE</div></td>
						  <td><div style="margin:5px">TYPE</div></td>
						  <td><div style="margin:5px">NO</div></td>
						  <td><div style="margin:5px">AMOUNT</div></td>
						  <td><div style="margin:5px">REMARK</div></td>
					    </tr>
					    <?php
					   $tot_jumlah = 0;
					   $sql = mysqli_query($CONN, 'SELECT * FROM master_new_jobvoucher WHERE vch_cost = 62');
					   while($r = mysqli_fetch_array($sql))
					   {
						  $vch_date = $r['vch_date'];
						  $vch_currency = $r['vch_currency'];
						  $vch_amount = $r['vch_amount'];
						  $vch_pembayaran_type = $r['vch_pembayaran_type'];
						  $vch_pembayaran_info = $r['vch_pembayaran_info'];

						  if($vch_pembayaran_type == 1)
						  {
							  $type = 'APC / BKK';
							  $ty = 'BKK'.invoice_number($r['vch_count']);
						  }
						  else
						  {
							  $type = 'APB / BBK';
							  $ty = 'BBK'.invoice_number($r['vch_count']);
						  }
						  ?>
						  <tr>
							  <td><div style="margin:5px"><?php echo $vch_date; ?></div></td>
							  <td><div style="margin:5px"><?php echo $type; ?></div></td>
							  <td><div style="margin:5px"><?php echo $ty; ?></div></td>
							  <td><div style="margin:5px; text-align:right"><?php echo numberToCurrency3($vch_amount); ?></div></td>
							  <td><div style="margin:5px"><?php echo strtoupper($vch_pembayaran_info); ?></div></td>
						  </tr>
						  <?php
					   }
					   ?>

				   </td>
			   </tr>
				<?php
				}
				else
				{
					// $check = mysqli_num_rows(mysqli_query($CONN, 'SELECT * FROM master_new_jobvoucher WHERE vch_cost = '.$id.''));

					// if($check != 0)
					// {
					?>
						<!--<tr>
		 				    <td>
							    <div style="position:relative; margin-bottom:10px;">
			 					    Pembayaran :
							    </div>
		 					    <table cellpadding="0" cellspacing="0" border="1" style="font-size:12px; font-family:Arial, Helvetica, sans-serif;">
		 		    				<tr>
		 		    				   <td><div style="margin:5px">DATE</div></td>
		 						   <td><div style="margin:5px">TYPE</div></td>
		 						   <td><div style="margin:5px">NO</div></td>
		 						   <td><div style="margin:5px">AMOUNT</div></td>
		 						   <td><div style="margin:5px">REMARK</div></td>
		 		    			     </tr>
		 						<?php
		 		 			    /*$tot_jumlah = 0;
		 		 			    $sql = mysqli_query($CONN, 'SELECT * FROM master_new_jobvoucher WHERE vch_cost = '.$id.'');
		 		 			    while($r = mysqli_fetch_array($sql))
		 		 			    {
		 		 				   $vch_date = $r['vch_date'];
		 		 				   $vch_currency = $r['vch_currency'];
		 		 				   $vch_amount = $r['vch_amount'];
		 		 				   $vch_pembayaran_type = $r['vch_pembayaran_type'];
		 		 				   $vch_pembayaran_info = $r['vch_pembayaran_info'];

		 		 				   if($vch_pembayaran_type == 1)
		 		 				   {
		 		 					   $type = 'APC / BKK';
		 							   $ty = 'BKK'.voucher_new_number($r['vch_id']);
		 		 				   }
		 		 				   else
		 		 				   {
		 		 				   	   $type = 'APB / BBK';
		 							   $ty = 'BBK'.voucher_new_number($r['vch_id']);
		 		 				   }*/
		 		 				   ?>
		 						   <tr>
		 							   <td><div style="margin:5px"><?php //echo $vch_date; ?></div></td>
		 							   <td><div style="margin:5px"><?php //echo $type; ?></div></td>
		 							   <td><div style="margin:5px"><?php// echo $ty; ?></div></td>
		 							   <td><div style="margin:5px; text-align:right"><?php //echo numberToCurrency3($vch_amount); ?></div></td>
		 							   <td><div style="margin:5px"><?php //echo strtoupper($vch_pembayaran_info); ?></div></td>
		 					        </tr>
		 		 				   <?php
		 		 			    // }
		 		 			    ?>
		 				    </td>
		 			    </tr>->
					<?php
					// }
				}
				?>

			</table>

		</div>

	</body>

</html>
