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
	$payment = MasterNewJobvoucher::find()
		->where(['vch_id'=>$id])
		->one();
	
	if(isset($payment)){
		if($payment->vch_type == 1 && $payment->vch_pembayaran_type == 2){
			$mode = 'BBM';
			$type = 'AR-B';
		}else if($payment->vch_type == 1 && $payment->vch_pembayaran_type == 1){
			$mode = 'BKM';
			$type = 'AR-C';
		}else if($payment->vch_type == 2 && $payment->vch_pembayaran_type == 2){
			$mode = 'BBK';
			$type = 'AP-B';
		}else if($payment->vch_type == 2 && $payment->vch_pembayaran_type == 1){
			$mode = 'BKK';
			$type = 'AP-C';
		}
		
		if(!empty($payment->vch_count_multiple) && $payment->vch_count_multiple !== '-'){
			$vch_count_multiple = $payment->vch_count_multiple;
		}else{
			$vch_count_multiple = '';
		}
		
		$tahun = date_format(date_create_from_format('Y-m-d', $payment->vch_date), 'y');
		$bulan = date_format(date_create_from_format('Y-m-d', $payment->vch_date), 'm');
		$day = date_format(date_create_from_format('Y-m-d', $payment->vch_date), 'd');
		$vch_count = str_pad($payment->vch_count, 6, '0', STR_PAD_LEFT);
		$voucher_date = $tahun.''.$bulan.''.$day;
		
		$voucher_number = $type.'-'.$vch_count.''.$vch_count_multiple.'-'.$voucher_date.'-B';
		
		$pos = PosV8::find()->where(['pos_id' => $payment->vch_pos])->one();
		if(isset($pos)){
			$pos_name = $pos->pos_name;
		}else{
			$pos_name = '';
		}
		
		$vch_date = date_format(date_create_from_format('Y-m-d', $payment->vch_date), 'd M Y');
		$vch_currency = $payment->vch_currency;
	}
?>

<div class="print-operational-payment">
	<div class="title" style="margin-bottom:15px">
		<div class="title1" style="float:left;width:40%;">
			COST OPERATIONAL
		</div>
		<div class="title1 text-right" style="float:left;">
			<?= $voucher_number ?>
		</div>
	</div>
	
	<table class="table-detail-operational" style="margin-bottom:10px">
		<thead>
			<tr class="thead">
			   <td class="text-center" width="15%">TANGGAL</td>
			   <td width="28%">POS</td>
			   <td width="37%">REFERENCE / DETAILS</td>
			   <td class="text-right" width="20%">JUMLAH</td>
			</tr>
		</thead>
		<tbody>
			<tr class="border-bottom">
				<td class="text-center"><?= strtoupper($vch_date) ?></td>
				<td><?= strtoupper($pos_name) ?></td>
				<td><?= strtoupper($payment->vch_keterangan) ?></td>
				<td class="text-right">
					<?php
						$amount = number_format($payment->vch_amount,2,'.',',');
						echo $amount;
					?>
				</td>
			</tr>
		</tbody>
	</table>
	
	<div style="font-size:10px">
		<i>
		<?php 
			if($payment->vch_details == 1){
				echo 'IDSUB'; 
			}elseif($payment->vch_details == 2){
				echo 'IDJKT';
			}elseif($payment->vch_details == 3){
				echo 'IDSRG';
			}?>
		</i>
	</div>
</div>
