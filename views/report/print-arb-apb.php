<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use yii\widgets\ActiveForm;
use richardfan\widget\JSRegister;
use app\models\Customer;
use app\models\MasterNewJobinvoice;
use app\models\MasterNewJobvoucher;
use yii\helpers\VarDumper;

date_default_timezone_set('Asia/Jakarta');
?>

<div class="report-bank">
	<table border="0" cellpadding="3" cellspacing="3">
		<tr>
			<td colspan="11" class="text-left border-bottom">
				<span style="font-size:20px;">LAPORAN ARB/BBM - APB/BBK</span>&emsp;&emsp;&emsp;&emsp;
				<span style="font-size:20px"><?= strtoupper($month_year) ?></span>
			</td>
		</tr>
		<tr>
			<td width="15%" class="text-center border-bottom border-left">E-FAKTUR No.</td>
			<td width="7%" class="text-center border-bottom border-right">TANGGAL</td>

			<td width="9%" class="text-center border-bottom">ARB/BBM No.</td>
			<td width="7%" class="text-center border-bottom">TANGGAL</td>
			<td width="10%" class="text-center border-bottom border-right">JUMLAH</td>

			<td width="9%" class="text-center border-bottom">APB/BBK No. (BNI)</td>
			<td width="7%" class="text-center border-bottom">TANGGAL</td>
			<td width="10%" class="text-center border-bottom border-right">JUMLAH</td>

			<td width="9%" class="text-center border-bottom">APB/BBK No. (PERMATA)</td>
			<td width="7%" class="text-center border-bottom">TANGGAL</td>
			<td width="10%" class="text-center border-bottom border-right">JUMLAH</td>
		</tr>
		
		<?php
			$total_ar = 0;
			$total_ap1 = 0;
			$total_ap2 = 0;
		
			foreach($payments as $row){
				// Hanya tampil yg bank BRI dan Permata saja
				if(@$row->bank->name == 'BNI' || @$row->bank->name == 'PERMATA'){
		?>
			<tr>
				<!-- E-FAKTUR -->
				<td class="text-center border-bottom border-left">
					<?= $row['vch_faktur']; ?>
				</td>
				
				<!-- TANGGAL -->
				<td class="text-center border-bottom border-right">
					<?php
						if($row['vch_faktur_tgl'] !== '0000-00-00' && !empty($row['vch_faktur_tgl'])){
							echo strtoupper(date_format(date_create_from_format('Y-m-d', $row['vch_faktur_tgl']), 'd M Y'));
						}
					?>
				</td>
					
				<!-- =============================================================== -->
				<!-- NOMOR ARB PERMATA -->
				<td class="text-center border-bottom">
					<?php
					if($row['vch_type'] == 1)
					{
						if(@$row->bank->name == 'PERMATA')
						{
							if(!empty($row['vch_bank'])){
								echo '<div style="font-weight:bold">'.@$row->bank->name.' - '.@$row->bank->code.'</div>';
							} 
							
							$tahun = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'y');
							$bulan = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'm');
							$vch_count = str_pad($row['vch_count_alias'], 3, '0', STR_PAD_LEFT);
							
							$voucher_number = $tahun.''.$bulan.''.$vch_count;
							
							if($row['vch_faktur'] == 'BIAYA OP')
							{
								echo 'BBM '.$voucher_number.'-B';
							}
							else
							{
								if(!empty($row['vch_count_multiple']) && $row['vch_count_multiple'] !== '-'){
									$count_multiple = $row['vch_count_multiple'];
								}else{
									$count_multiple = '';
								}
								
								echo '<div class="link" onclick="updateCount('. $row['vch_id'] . ','. $row['vch_count_alias'] .')">'.'BBM '.$voucher_number.''.$count_multiple.'</div>';
							}
						}
					}
					?>
				</td>
				
				<!-- DATE -->
				<td class="text-center border-bottom">
					<?php
					if(@$row->bank->name == 'PERMATA')
					{
						if($row['vch_type'] == 1)
						{
							echo strtoupper(date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'd M Y'));
						}
					}
					?>
				</td>

				<!-- JUMLAH -->
				<td class="text-right border-bottom border-right">
					<?php
					if(@$row->bank->name == 'PERMATA')
					{
						if($row['vch_type'] == 1)
						{
							echo number_format($row['vch_amount'],0,'.',',');
							$total_ar += $row['vch_amount'];
						}
					}
					?>
				</td>
				
				<!-- ============================================================ -->
				<!-- NOMOR APB BNI -->
				<td class="text-center border-bottom">
					<?php
					if($row['vch_type'] == 2)
					{
						if(@$row->bank->name == 'BNI')
						{
							if(!empty($row['vch_bank'])){
								echo '<div style="font-weight:bold">'.@$row->bank->name.' - '.@$row->bank->code.'</div>';
							} 
							
							$tahun = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'y');
							$bulan = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'm');
							$vch_count = str_pad($row['vch_count_alias'], 3, '0', STR_PAD_LEFT);
							
							$voucher_number = $tahun.''.$bulan.''.$vch_count;
							
							if($row['vch_faktur'] == 'BIAYA OP')
							{
								echo 'BBK '.$voucher_number.'-B';
							}
							else
							{
								if(!empty($row['vch_count_multiple']) && $row['vch_count_multiple'] !== '-'){
									$count_multiple = $row['vch_count_multiple'];
								}else{
									$count_multiple = '';
								}
								
								echo '<div class="link" onclick="updateCount('. $row['vch_id'] . ','. $row['vch_count_alias'] .')">'.'BBK '.$voucher_number.''.$count_multiple.'</div>';
							}
						}
					}
					?>
				</td>
				
				<!-- DATE -->
				<td class="text-center border-bottom">
					<?php
					if(@$row->bank->name == 'BNI')
					{
						if($row['vch_type'] == 2)
						{
							echo strtoupper(date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'd M Y'));
						}
					}
					?>
				</td>

				<!-- JUMLAH -->
				<td class="text-right border-bottom border-right">
					<?php
					if(@$row->bank->name == 'BNI')
					{
						if($row['vch_type'] == 2)
						{
							echo number_format($row['vch_amount'],0,'.',',');
							$total_ap1 += $row['vch_amount'];
						}
					}
					?>
				</td>
				
				<!-- ============================================================ -->
				<!-- NOMOR APB PERMATA -->
				<td class="text-center border-bottom">
					<?php
					if($row['vch_type'] == 2)
					{
						if(@$row->bank->name == 'PERMATA')
						{
							if(!empty($row['vch_bank'])){
								echo '<div style="font-weight:bold">'.@$row->bank->name.' - '.@$row->bank->code.'</div>';
							} 
							
							$tahun = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'y');
							$bulan = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'm');
							$vch_count = str_pad($row['vch_count_alias'], 3, '0', STR_PAD_LEFT);
							
							$voucher_number = $tahun.''.$bulan.''.$vch_count;
							
							if($row['vch_faktur'] == 'BIAYA OP')
							{
								echo 'BBK '.$voucher_number.'-B';
							}
							else
							{
								if(!empty($row['vch_count_multiple']) && $row['vch_count_multiple'] !== '-'){
									$count_multiple = $row['vch_count_multiple'];
								}else{
									$count_multiple = '';
								}
								
								echo '<div class="link" onclick="updateCount('. $row['vch_id'] . ','. $row['vch_count_alias'] .')">'.'BBK '.$voucher_number.''.$count_multiple.'</div>';
							}
						}
					}
					?>
				</td>

				<!-- DATE -->
				<td class="text-center border-bottom">
					<?php
					if(@$row->bank->name == 'PERMATA')
					{
						if($row['vch_type'] == 2)
						{
							echo strtoupper(date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'd M Y'));
						}
					}
					?>
				</td>

				<!-- JUMLAH -->
				<td class="text-right border-bottom border-right">
					<?php
					if(@$row->bank->name == 'PERMATA')
					{
						if($row['vch_type'] == 2)
						{
							echo number_format($row['vch_amount'],0,'.',',');
							$total_ap2 += $row['vch_amount'];
						}
					}
					?>
				</td>
			</tr>
			<?php } ?>
		<?php } ?>
		
		<tr>
			<td class="text-center border-bottom border-left" colspan="4"><b>TOTAL</b></td>
			<td class="text-right border-bottom border-right">
				<b><?= number_format($total_ar,0,'.',',') ?></b>
			</td>
			<td class="border-bottom" colspan="2"></td>
			<td class="text-right border-bottom border-right">
				<b><?= number_format($total_ap1,0,'.',',') ?></b>
			</td>
			<td class="border-bottom" colspan="2"></td>
			<td class="text-right border-bottom border-right">
				<b><?= number_format($total_ap2,0,'.',',') ?></b>
			</td>
		</tr>
	</table>
</div>
