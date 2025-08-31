<?php
use yii\helpers\Url;
use yii\helpers\Html;

use app\models\MasterNewJob;
use app\models\JobInfo;
use app\models\Customer;
use app\models\Batch;
use app\models\Vessel;
use app\models\MasterVesselRouting;

use app\models\MasterNewJobinvoice;
use app\models\MasterNewJobinvoiceDetail;


use app\models\MasterG3eJobrouting;
use app\models\MasterG3eHblRouting;
use app\models\MasterG3eVesselbatch;
use app\models\MasterG3eHblCargodetail;

use app\models\PosV8;
use app\models\Packages;
use app\models\JobParty;
use yii\helpers\VarDumper;

date_default_timezone_set('Asia/Jakarta');

//Job
$job = MasterNewJob::find()->where(['id' => $id_job])->one();
$job_info = $job->job;
$job_type = $job->job_type;
$job_number = $job->job_number;
$ref_number = $job->job_name;

//JobInfo
$jobinfo = JobInfo::find()->where(['id_job' => $id_job])->one();

//Invoice
$invoice = MasterNewJobinvoice::find()->where(['inv_id'=>$id_invoice])->one();
$no_invoice = 'IDT'.str_pad($invoice->inv_count,6,'0',STR_PAD_LEFT);
$invoice_date = date_format(date_create_from_format('Y-m-d', $invoice->inv_date), 'd F Y');
$inv_to_address = $invoice->inv_to3;

$total = number_format($invoice->inv_total,2,'.',',');
$total_ppn = number_format($invoice->inv_total_ppn,2,'.',',');
$grandtotal = number_format($invoice->inv_grandtotal,2,'.',',');

$invoice_detail = MasterNewJobinvoiceDetail::find()->where(['invd_inv_id'=>$id_invoice])->all();

//Customer
$customer = Customer::find()->where(['customer_id' => $invoice->inv_customer,'is_active' => 1])->one();
$customer_nickname		 = $customer->customer_nickname;
$customer_companyname	 = $customer->customer_companyname;
$customer_address		 = $customer->customer_address;
$customer_telephone		 = $customer->customer_telephone;
$customer_contact_person = $customer->customer_contact_person;
$customer_npwp			 = $customer->customer_npwp;

//Vessel + Routing
$routing = MasterG3eHblRouting::find()->where(['hblrouting_job_id' => $id_job])->one();
$place_of_receipt	= $routing->place_of_receipt;
$port_of_loading 	= $routing->port_of_loading;
$port_of_delivery	= $routing->port_of_delivery;
$port_of_discharge	= $routing->port_of_discharge;

$vessel_batch = MasterG3eVesselbatch::find()->where(['vessel_job_id' => $id_job])->one();
$vessel_batch_id = $vessel_batch['vessel_batch_id'];

$batch = Batch::find()->where(['batch_id' => $vessel_batch_id ])->one();
$batch_id 	= $batch->batch_id;
$pol_id		= $batch->pol_id;
$pol_dod 	= $batch->pol_dod;
$pc_vessel 	= $batch->pc_vessel;
$pc_voyage  = $batch->pc_voyage;

$vessel_routing = MasterVesselRouting::find()->where(['id'=>$vessel_batch_id])->one();
$vessel_start = $vessel_routing->vessel_start;
$voyage_start = $vessel_routing->voyage_start;
$vessel_end = $vessel_routing->vessel_end;
$voyage_end = $vessel_routing->voyage_end;
$point_start = $vessel_routing->point_start;
$date_start = date_format(date_create_from_format('Y-m-d', $vessel_routing->date_start), 'd-m-Y');
$point_end = $vessel_routing->point_end;
$date_end = date_format(date_create_from_format('Y-m-d', $vessel_routing->date_end), 'd-m-Y');

$containers = MasterG3eHblCargodetail::find()->where(['hblcrg_job_id'=>$id_job])->asArray()->all();

$inv_currency = 'IDR';
?>

<div id="print-invoice-idr">
	<div id="header" style="float:left;width:70%;margin-bottom:20px;">
		<div class="title1">
			PT. FULUSO KENCANA INTERNATIONAL
		</div>
		<div class="title2" style="margin-bottom:2px;">
			Jl. Tanjung Batu 21L/12A, Surabaya 60177, Indonesia 
			&nbsp;&nbsp;&nbsp;<span style="position:relative; top:2px; font-size:15px">&bull;</span>
			&nbsp;&nbsp;&nbsp;P. +62 31 357 7000 / 5120 5555
			&nbsp;&nbsp;&nbsp;<span style="position:relative; top:2px; font-size:15px">&bull;</span>
			&nbsp;&nbsp;&nbsp;<span style="position:relative; top:-1;">ID@fuluso.com</span>
		</div>
	</div>
	
	<div class="title2" style="float;width:30%;padding-top:15px;letter-spacing:.5px">
		<?= 'NPWP 01.715.871.8-605.000' ?>
	</div>
	
	<div style="clear: both; margin: 0pt; padding: 0pt; "></div>
	
	<div id="address" style="position:relative; margin-bottom:10px">
		<?php if($job_info == 'G1'){ ?>
			
		<?php }elseif($job_info == 'G3'){ ?>
			<?php // if($job_type == 'E') { ?>
			
				<!-- Left -->
				<div style="float:left;width:55%;margin-bottom:5px">
					<div style="float:left;margin-bottom:3px">
						<div style="float:left;width:35%">REF. NUMBER</div>
						<div style="float:left;width:7%;text-align:center">:</div>
						<div style="float:left;width:55%"><?= $ref_number ?></div>
					</div>
					<div style="float:left;margin-bottom:3px">
						<div style="float:left;width:35%">CUSTOMER</div>
						<div style="float:left;width:7%;text-align:center">:</div>
						<div style="float:left;width:55%"><?= strtoupper($customer_companyname) ?></div>
					</div>
					<div style="float:left;margin-bottom:3px">
						<div style="float:left;width:35%">HBL / HAWB NO.</div>
						<div style="float:left;width:7%;text-align:center">:</div>
						<div style="float:left;width:55%">
							<?php
								$by = MasterG3eJobrouting::find()->where(['jr_job_id' => $id_job])->one();
								
								if(isset($by)){
									$jr_office = str_replace('O', '', $by->jr_office);
									echo $by->jr_house_scac.' '.$jr_office.''.$job->job_year.$job->job_month.str_pad($job_number,4,'0',STR_PAD_LEFT);
								}else{
									echo '-';
								}
							?>
						</div>
					</div>
					<div style="float:left;margin-bottom:3px">
						<div style="float:left;width:35%">PORT OF LOADING</div>
						<div style="float:left;width:7%;text-align:center">:</div>
						<div style="float:left;width:55%"><?= $port_of_loading ?></div>
					</div>
					<div style="float:left;margin-bottom:3px">
						<div style="float:left;width:35%">PORT OF DISCHARGE</div>
						<div style="float:left;width:7%;text-align:center">:</div>
						<div style="float:left;width:55%"><?= $port_of_discharge ?></div>
					</div>
					<div style="float:left;margin-bottom:3px">
						<div style="float:left;width:35%">FINAL DESTINATION</div>
						<div style="float:left;width:7%;text-align:center">:</div>
						<div style="float:left;width:55%"><?= $port_of_delivery ?></div>
					</div>
					<div style="float:left;margin-bottom:3px">
						<div style="float:left;width:35%">VESSEL</div>
						<div style="float:left;width:7%;text-align:center">:</div>
						<div style="float:left;width:55%">
							<?= strtoupper($vessel_start.' '.$voyage_start).'<br/> '.strtoupper($vessel_end.' '. $voyage_end); ?>
						</div>
					</div>
					<div style="float:left;margin-bottom:3px">
						<div style="float:left;width:35%">DEPARTURE</div>
						<div style="float:left;width:7%;text-align:center">:</div>
						<div style="float:left;width:55%"><?= $point_start.' '.$date_start ?></div>
					</div>
					<div style="float:left;margin-bottom:3px">
						<div style="float:left;width:35%">ARRIVAL</div>
						<div style="float:left;width:7%;text-align:center">:</div>
						<div style="float:left;width:55%"><?= $point_end.' '.$date_end ?></div>
					</div>
					<div style="float:left;margin-bottom:3px">
						<div style="float:left;width:35%">CONT. NUMBER</div>
						<div style="float:left;width:7%;text-align:center">:</div>
						<div style="float:left;width:55%">
							<?php
								if(isset($containers)){
									foreach($containers as $row){
										echo $row['hblcrg_name'].'<br>';
									}
								}else{
									echo '-';
								}
							?>
						</div>
					</div>
				</div>
				
				<!-- Right -->
				<div style="float:left;width:45%;margin-bottom:5px">
					<div style="float:left;margin-bottom:3px">
						<div style="float:left;width:40%;padding-top:8px">INVOICE NO.</div>
						<div style="float:left;width:7%;text-align:center;padding-top:8px">:</div>
						<div style="float:left;width:50%;font-size:22px;letter-spacing:2px;" class="arial">
							<?= $no_invoice ?>
						</div>
					</div>
					<div style="float:left;margin-bottom:3px">
						<div style="float:left;width:40%">DATE</div>
						<div style="float:left;width:7%;text-align:center">:</div>
						<div style="float:left;width:50%">
							<?= $invoice_date ?>
						</div>
					</div>
					<div style="float:left;margin-bottom:3px">
						<div style="float:left;width:40%">TO :</div>
						<div style="float:left;width:7%;text-align:center"></div><br>
						<div style="float:left;width:100%">
							<?= nl2br($inv_to_address) ?>
							<?php
								if(isset($jobinfo)){
									if($jobinfo->step == 5 || $jobinfo->step == 6){
										echo '';
									}else{
										if($customer->customer_npwp !== '-' || !empty($customer->customer_npwp)){
											echo '<br>';
											echo 'NPWP '.$customer_npwp;
										}
									}
								}else{
									if($customer->customer_npwp !== '-' || !empty($customer->customer_npwp)){
										echo '<br>';
										echo 'NPWP '.$customer_npwp;
									}
								}
							?>
						</div>
					</div>
					<div style="float:left;margin-bottom:3px">
						<div style="float:left;width:40%">ADDITIONAL NOTES</div>
						<div style="float:left;width:7%;text-align:center">:</div><br>
						<div style="float:left;width:50%">
							<?= $invoice->additional_notes ?>
						</div>
					</div>
				</div>
			
			<?php //}elseif($job_type == 'I'){ ?>
			<?php //} ?>
		<?php } ?>
	</div>
	
	<table id="table_invoice_detail" style="margin-bottom:20px">
		<tr class="border-top-bottom">
			<td width="43%">DESCRIPTION OF CHARGES</td>
			<td width="13%">BASIC</td>
			<td width="13%">QUANTITY</td>
			<td width="13%" class="text-right">AMOUNT</td>
			<td width="13%" class="text-right">TOTAL</td>
			<td width="5%" class="text-right">CURR</td>
		</tr>
		<tr>
		<?php 
			if(isset($invoice_detail)){
				foreach($invoice_detail as $row){ 
		?>
			<tr>
				<td>
					<?php
						$pos = PosV8::find()->where(['pos_id' => $row['invd_pos']])->one();
						$pos_name = $pos->pos_name;
						
						echo $pos_name;
					?>
				</td>
				<td>1 SHPT</td>
				<td>1 DOC</td>
				<td class="text-right">
					<?php
						$amount = number_format($row['invd_amount'],2,'.',',');
						echo $amount;
					?>
				</td>
				<td class="text-right">
					<?php
						$amount = number_format($row['invd_amount'],2,'.',',');
						echo $amount;
					?>
				</td>
				<td class="text-right">IDR</td>
			</tr>
		<?php }
			} 
		?>
		<tr class="border-top">
			<td colspan="4" class="text-right">TOTAL</td>
			<td class="text-right"><?= $amount ?></td>
			<td class="text-right">IDR</td>
		</tr>
		<tr class="border-bottom">
			<td colspan="4" class="text-right">PPN</td>
			<td class="text-right"><?= $total_ppn ?></td>
			<td class="text-right">IDR</td>
		</tr>
		<tr class="border-bottom">
			<td colspan="4" class="text-right">GRANDTOTAL</td>
			<td class="text-right"><?= $grandtotal ?></td>
			<td class="text-right">IDR</td>
		</tr>
		<tr class="border-top border-bottom">
			<td colspan="7"><?= strtoupper($terbilang).' RUPIAH. ---' ?></td>
		</tr>
	</table>
	
	<table style="font-size:11px; font-family:Arial, Helvetica, sans-serif">
        <tr>
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
            <td>Please address your payment indicate this invoice number and mark "FULL AMOUNT" to:</td>
		</tr>
		<tr>
			<td></td>
			<td style="padding-left:7px">PT. Bank Permata</td>	
		</tr>
		<tr>
			<td></td>
			<td style="padding-left:7px">Cabang Darmo Park Surabaya</td>	
		</tr>
		<tr>
			<td></td>
			<td style="padding-left:7px;">
				<div style="width:100%;">
					Swift Code <span style="letter-spacing:6px">&nbsp;</span> : B B B A I D J A
				</div>
			</td>	
		</tr>
		<tr>
			<td></td>
			<td style="padding-left:7px;">
				<div style="width:100%;">
					Account No. <span style="letter-spacing:2.6px">&nbsp;</span> : 2 9 0 1 1 7 3 9 7 7
				</div>
			</td>	
		</tr>
		<tr>
			<td></td>
			<td style="padding-left:7px;">
				<div style="width:100%;">
					Beneficiary <span style="letter-spacing:4.7px">&nbsp;</span> : PT. FULUSO KENCANA INTERNATIONAL
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
    </table>
</div>
