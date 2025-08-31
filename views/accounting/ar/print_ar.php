<?php
use app\models\PosV8;
use app\models\Packages;
use app\models\Customer;
use app\models\MasterNewJob;
use app\models\MasterNewJobinvoice;
use app\models\MasterNewJobinvoiceDetail;
use app\models\MasterNewJobvoucher;
?>

<?php
	$payment = MasterNewJobvoucher::find()->where(['vch_id'=>$id])->one();
	
	if(isset($payment)){
		if(!empty($payment->vch_count_multiple) && $payment->vch_count_multiple !== '-'){
			$count_multiple = $payment->vch_count_multiple;
		}else{
			$count_multiple = '';
		}
		
		$tahun = date_format(date_create_from_format('Y-m-d', $payment->vch_date), 'y');
		$bulan = date_format(date_create_from_format('Y-m-d', $payment->vch_date), 'm');
		$day = date_format(date_create_from_format('Y-m-d', $payment->vch_date), 'd');
		$vch_count = str_pad($payment->vch_count, 6, '0', STR_PAD_LEFT);
		
		$voucher_number = $vch_count;
		$voucher_date = $tahun.''.$bulan.''.$day;
		
		if($payment->vch_pembayaran_type == 1){
			$type = 'AR-C';
			$bayar_type = 'BKM';
			
			$title1 = 'AR - C - BUKTI KAS MASUK';
			$title2 = $type.'-'.$voucher_number.''.$count_multiple.'-'.$voucher_date;
		}else{
			$type = 'AR-B';
			$bayar_type = 'BBM';
			
			$title1 = 'AR - B - BUKTI BANK MASUK';
			$title2 = $type.'-'.$voucher_number.''.$count_multiple.'-'.$voucher_date;
		}
		
		$vch_date = date_format(date_create_from_format('Y-m-d', $payment->vch_date), 'd F Y');
		$vch_faktur = $payment->vch_faktur;
		$vch_currency = $payment->vch_currency;
		
		//Invoice
		$invoice = MasterNewJobinvoice::find()->where(['inv_id'=>$payment->vch_invoice])->one();
		$invoice_detail = MasterNewJobinvoiceDetail::find()->where(['invd_inv_id'=>$payment->vch_invoice])->orderBy(['invd_id'=>SORT_ASC])->asArray()->all();
		
		$inv_date = date_format(date_create_from_format('Y-m-d', $invoice->inv_date), 'd F Y');
		$inv_due_date = date_format(date_create_from_format('Y-m-d', $invoice->inv_due_date), 'd F Y');
		$customer = Customer::find()->where(['customer_id'=>$invoice->inv_to, 'is_active' => 1])->one();  
		$total = number_format($invoice->inv_total,2,'.',',');
		$total_ppn = number_format($invoice->inv_total_ppn,2,'.',',');
		$grandtotal = number_format($invoice->inv_grandtotal,2,'.',',');
		
		//Job
		$job = MasterNewJob::find()->where(['id'=>$payment->vch_job_id])->one();
		$ref_number = $job->job_name;
	}
?>

<div class="print-ar-payment">
	<div class="title" style="margin-bottom:10px">
		<div class="title1" style="float:left;width:50%;">
			<?= $title1 ?>
		</div>
		<div class="title2" style="float:left;">
			<?= $title2 ?>
		</div>
	</div>
	
	<table style="font-size:12px;margin-bottom:10px">
		<tr>
			<td width="135px">INVOICE NUMBER</td>
			<td width="5px">:</td>
			<td><?= 'IDT'.str_pad($invoice->inv_count,6,'0',STR_PAD_LEFT) ?></td>
		</tr>
		<tr>
			<td width="135px">NO. FAKTUR</td>
			<td width="5px">:</td>
			<td><?= $vch_faktur ?></td>
		</tr>
		<tr>
			<td width="135px">REF. NUMBER</td>
			<td width="5px">:</td>
			<td><?= $ref_number ?></td>
		</tr>
		<!--<tr>
			<td width="135px">DATE</td>
			<td width="5px">:</td>
			<td><?= strtoupper($inv_date) ?></td>
		</tr>
		<tr>
			<td width="135px">DUE DATE</td>
			<td width="5px">:</td>
			<td><?= strtoupper($inv_due_date) ?></td>
		</tr>-->
		<tr>
			<td width="135px">CUSTOMER</td>
			<td width="5px">:</td>
			<td><?= strtoupper($customer->customer_companyname) ?></td>
		</tr>
	</table>
	
	<table class="table-detail-inv" style="margin-bottom:15px">
		<thead>
			<tr class="thead">
			   <td width="35%">DESCRIPTION OF CHARGES</td>
			   <td width="14%">BASIC</td>
			   <td width="14%">QUANTITY</td>
			   <td class="text-right" width="15%">AMOUNT</td>
			   <td class="text-right" width="15%">TOTAL</td>
			   <td class="text-right" width="5%">CURR</td>
			</tr>
		</thead>
		<tbody>
			<?php if(isset($invoice_detail)){
				foreach($invoice_detail as $row){
			?>
				<tr class="tbody">
					<td>
						<?php
							$pos = PosV8::find()->where(['pos_id' => $row['invd_pos'], 'is_active'=>1])->one();
							$pos_name = $pos->pos_name;
							
							echo $pos_name;
						?>
					</td>
					<td>
						<?php
							$total_basis = number_format($row['invd_basis1_total'],0,'.',',');
							$package = Packages::find()->where(['packages_name' => $row['invd_basis1_type']])->one();
							$packages_basis = $package->packages_name;
							
							echo $total_basis.' '.$packages_basis;
						?>
					</td>
					<td>
						<?php
							$total_qty = number_format($row['invd_basis2_total'],0,'.',',');
							$package = Packages::find()->where(['packages_name' => $row['invd_basis2_type']])->one();
							$packages_qty = $package->packages_name;
							
							echo $total_qty.' '.$packages_qty;
						?>
					</td>
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
				<td class="text-right"><?= $total ?></td>
				<td class="text-right">IDR</td>
			</tr>
			<tr class="border-bottom">
				<td colspan="4" class="text-right">PPN</td>
				<td class="text-right"><?= $total_ppn ?></td>
				<td class="text-right">IDR</td>
			</tr>
			<tr class="border-top border-bottom">
				<td colspan="4" class="text-right">TOTAL AMOUNT</td>
				<td class="text-right"><?= $grandtotal ?></td>
				<td class="text-right">IDR</td>
			</tr>
		</tbody>
	</table>
	
	<div class="pembayaran arial" style="margin-bottom:3px;font-size:12px;">
		PEMBAYARAN :
	</div>
	
	<div class="payment">
		<div style="float:left;width:18%;margin-bottom:3px;">
			<?= $title2 ?>
		</div>
		<div style="float:left;width:4%;text-align:center"> / </div>
		<div style="float:left;width:18%;margin-bottom:3px;text-align:center">
			<?= $payment->vch_faktur ?>
		</div>
		<div style="float:left;width:4%;text-align:center"> / </div>
		<div style="float:left;width:10%;text-align:right">
			<?php
				$amount = number_format($payment->vch_amount,0,'.',',');
				echo $amount;
			?>
		</div>
	</div>
	
	<?php if(!empty($payment->vch_amount_pph) || $payment->vch_amount_pph !== '-'){ ?>
	<div class="pph">	
		<div style="float:left;width:18%;margin-bottom:3px;">
			<?= $payment->vch_nomor_pph ?>
		</div>
		<div style="float:left;width:4%;text-align:center"> / </div>
		<div style="float:left;width:18%;margin-bottom:3px;text-align:center">
			<?= $payment->vch_faktur ?>
		</div>
		<div style="float:left;width:4%;text-align:center"> / </div>
		<div style="float:left;width:10%;text-align:right">
			<?php
				if($payment->vch_amount_pph > 0){
					$pph = number_format($payment->vch_amount_pph,0,'.',',');
					echo '('.$pph.')';
				}else{
					echo '0';
				}
			?>
		</div>
	</div>
	<?php } ?>
	
	<!--<table class="table-detail-payment">
		<tr>
			<td class="text-center" width="17%">DATE</td>
			<td class="text-center" width="12%">TYPE</td>
			<td class="text-center" width="15%">NOMOR</td>
			<td class="text-center" width="15%">PPH</td>
			<td class="text-center" width="20%">AMOUNT</td>
			<td class="text-center" width="21%">REMARK</td>
		</tr>
		<tr>
			<td class="text-center"><?= strtoupper($vch_date) ?></td>
			<td class="text-center"><?= strtoupper($type) ?></td>
			<td class="text-center"><?= $bayar_type.''.$voucher_number.''.$count_multiple ?></td>
			<td class="text-right">
				<?php
					// if(!empty($payment->vch_amount_pph) || $payment->vch_amount_pph !== '-'){
						// $pph = number_format($payment->vch_amount_pph,0,'.',',');
						// echo '( IDR '.$pph.' )';
					// }else{
						// echo '-';
					// }
				?>
			</td>
			<td class="text-right">
				<?php
					$amount = number_format($payment->vch_amount,0,'.',',');
					echo 'IDR '.$amount;
				?>
			</td>
			<td><?= strtoupper($payment->vch_pembayaran_info) ?></td>
		</tr>
	</table>-->
</div>
