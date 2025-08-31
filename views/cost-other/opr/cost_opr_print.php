<?php
use app\models\PosV8;
use app\models\Packages;
use app\models\Customer;
use app\models\MasterNewJob;
use app\models\MasterNewJobcost;
use app\models\MasterNewJobcostDetail;
use app\models\MasterNewCostopr;
use app\models\MasterNewCostoprDetail;
use app\models\MasterNewJobvoucher;
use app\models\Office;
?>

<?php
//Cost
$cost = MasterNewJobcost::find()->where(['vch_id'=>$id_cost])->one();
$cost_detail = MasterNewJobcostDetail::find()->where(['vchd_vch_id'=>$id_cost])->orderBy(['vchd_id'=>SORT_ASC])->asArray()->all();

$office = Office::find()->where(['office_code'=>$cost->vch_office_id])->one();

$cost_date = date_format(date_create_from_format('Y-m-d', $cost->vch_date), 'd F Y');
$cost_due_date = date_format(date_create_from_format('Y-m-d', $cost->vch_due_date), 'd F Y');
// $pay_for = Customer::find()->where(['customer_id'=>$cost->vch_pay_for, 'is_active' => 1])->one();  
$total = number_format($cost->vch_total,2,'.',',');
$total_ppn = number_format($cost->vch_total_ppn,2,'.',',');
$grandtotal = number_format($cost->vch_grandtotal,2,'.',',');

// $payment = MasterNewJobvoucher::find()->where(['vch_cost'=>$id_cost, 'vch_currency'=>'IDR', 'vch_is_active'=>1])->one();
$payment = MasterNewJobvoucher::find()->where(['vch_cost'=>99999, 'vch_currency'=>'IDR', 'vch_type'=>3])->one();

if(!isset($payment)){ 
	$kode = 'AP-'.'<span style="color:red">'.'X-000000'.'-</span>'.date_format(date_create($cost->vch_date), 'ymd');
}else{
	if($payment->vch_pembayaran_type == 1){
		$tipe = 'C';
	}else{
		$tipe = 'B';
	}
	$kode = 'AP-'.$tipe.'-'.str_pad($cost->vch_count,6,'0',STR_PAD_LEFT).'-'.date_format(date_create($cost->vch_date), 'ymd');
}
?>

<div class="print-cost-idr">
	<div class="title" style="margin-bottom:10px">
		<div style="font-family:'Arial, Helvetica, sans-serif';font-size:16px">
			<b>COST OPERATIONAL</b>
		</div>
	</div>
	
	<table class="arial" style="font-size:12px;margin-bottom:10px">
		<tr>
			<td width="135px">COST NUMBER</td>
			<td width="5px">:</td>
			<td><?= $kode ?></td>
		</tr>
		<tr>
			<td width="135px">PAY TO</td>
			<td width="5px">:</td>
			<td><?= strtoupper($cost->vch_pay_to) ?></td>
		</tr>
		<tr>
			<td width="135px">Office</td>
			<td width="5px">:</td>
			<td><?= $office->office_name ?></td>
		</tr>
	</table>
	
	<table id="table_cost_detail" style="margin-bottom:20px">
		<tr class="border-top-bottom">
		   <td width="24%">DESCRIPTION OF CHARGES</td>
		   <td width="19%">DETAIL</td>
		   <td width="13%">QUANTITY</td>
		   <td width="13%">UNIT</td>
		   <td class="text-right" width="13%">AMOUNT</td>
		   <td class="text-right" width="13%">TOTAL</td>
		   <td class="text-right" width="5%">CURR</td>
		</tr>
		<?php if(isset($cost_detail)){
			foreach($cost_detail as $row){
		?>
			<tr class="tbody">
				<td>
					<?php
						$pos = PosV8::find()->where(['pos_id' => $row['vchd_pos']])->one();
						$pos_name = $pos->pos_name;
						
						echo $pos_name;
					?>
				</td>
				<td><?= $row['vchd_detail'] ?></td>
				<td class="text-right">
					<?php
						$amount = number_format($row['vchd_basis2_total'],2,'.',',');
						echo $amount;
					?>
				</td>
				<td>
					<?php
						$package = Packages::find()->where(['packages_name' => $row['vchd_basis2_type']])->one();
						$packages_basis = $package->packages_name;
						
						echo $packages_basis;
					?>
				</td>
				<td class="text-right">
					<?php
						$amount = number_format($row['vchd_amount'],2,'.',',');
						echo $amount;
					?>
				</td>
				<td class="text-right">
					<?php
						$amount = number_format($row['vchd_amount'],2,'.',',');
						echo $amount;
					?>
				</td>
				<td class="text-right">IDR</td>
			</tr>
		<?php }
			}
		?>
		
		<?php if($cost->vch_total_ppn > 0){?>
			<tr class="">
				<td colspan="5" class="text-right">TOTAL</td>
				<td class="text-right"><?= $total ?></td>
				<td class="text-right">IDR</td>
			</tr>
			<tr class="">
				<td colspan="5" class="text-right">PPN</td>
				<td class="text-right"><?= $total_ppn ?></td>
				<td class="text-right">IDR</td>
			</tr>
			<tr class="border-bottom">
				<td colspan="5" class="text-right">GRANDTOTAL</td>
				<td class="text-right"><?= $grandtotal ?></td>
				<td class="text-right">IDR</td>
			</tr>
			<!--<tr class="border-top-bottom">
				<td colspan="7"><?= strtoupper($terbilang).' RUPIAH' ?></td>
			</tr>-->
		<?php }else{ ?>
			<tr class="border-bottom">
				<td colspan="5" class="text-right">TOTAL AMOUNT</td>
				<td class="text-right"><?= $total ?></td>
				<td class="text-right">IDR</td>
			</tr>
		<?php } ?>
	</table>
</div>
