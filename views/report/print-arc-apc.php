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
			<td colspan="15" class="text-left">
				<span style="font-size:20px;">LAPORAN ARC/BKM - APC/BKK</span>&emsp;&emsp;&emsp;&emsp;
				<span style="font-size:20px"><?= strtoupper($month_year) ?></span>
			</td>
		</tr>
		<tr>
			<td rowspan="2" width="12%" class="text-center bordered">E-FAKTUR No.</td>
			<td rowspan="2" width="7%" class="text-center bordered">TANGGAL</td>
			<td rowspan="2" width="1%" class="text-center border-left border-right"></td>

			<td colspan="3" width="24%" class="text-center bordered">ARC/BKM No.</td>
			<td rowspan="2" width="8%" class="text-center bordered">TANGGAL</td>
			<td rowspan="2" width="7%" class="text-center bordered">JUMLAH</td>
			<td rowspan="2" width="1%" class="text-center border-left border-right"></td>

			<td colspan="3" width="24%" class="text-center bordered">APC/BKK No.</td>
			<td rowspan="2" width="8%" class="text-center bordered">TANGGAL</td>
			<td rowspan="2" width="8%" class="text-center border-top border-bottom border-right">JUMLAH</td>
		</tr>
		<tr>
			<td width="8%" class="text-center bordered">FIN1-SB</td>
			<td width="8%" class="text-center bordered">FIN2-JK</td>
			<td width="8%" class="text-center bordered">FIN3-SR</td>
			<td width="8%" class="text-center bordered">FIN1-SB</td>
			<td width="8%" class="text-center bordered">FIN2-JK</td>
			<td width="8%" class="text-center bordered">FIN3-SR</td>
		</tr>
		
		<?php
			$total_ar = 0;
			$total_ap = 0;
			
			foreach($payments as $row){
		?>
			<tr>
				<!-- E-FAKTUR -->
				<td class="text-center bordered">
					<?= $row['vch_faktur']; ?>
				</td>
				
				<!-- TANGGAL -->
				<td class="text-center bordered">
					<?php
						if($row['vch_faktur_tgl'] !== '0000-00-00' && !empty($row['vch_faktur_tgl'])){
							echo strtoupper(date_format(date_create_from_format('Y-m-d', $row['vch_faktur_tgl']), 'd M Y'));
						}
					?>
				</td>
				
				<td class="border-left border-right"></td>
				
				<!-- NOMOR ARC SB -->
				<td class="text-center bordered">
					<?php
						if($row['vch_type'] == 1)
						{
							$tahun = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'y');
							$bulan = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'm');
							$vch_count = str_pad($row['vch_count_alias'], 3, '0', STR_PAD_LEFT);
							
							$voucher_number = $tahun.''.$bulan.''.$vch_count;
							
							if($row['vch_faktur'] == 'BIAYA OP')
							{
								if($row['vch_details'] == 1)
								{
									echo '<div class="link" onclick="updateCount('. $row['vch_id'] . ','. $row['vch_count_alias'] .')">BKM '.$voucher_number.'-B</a>';
								}
							}
							else
							{
								if($row->job->job_location == 'SB')
								{
									echo '<div class="link" onclick="updateCount('. $row['vch_id'] . ','. $row['vch_count_alias'] .')">BKM '.$voucher_number.'</a>';
								}
							}
						}
					?>
				</td>
				
				<!-- NOMOR ARC JK -->
				<td class="text-center bordered">
					<?php
						if($row['vch_type'] == 1)
						{
							$tahun = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'y');
							$bulan = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'm');
							$vch_count = str_pad($row['vch_count_alias'], 3, '0', STR_PAD_LEFT);
							
							$voucher_number = $tahun.''.$bulan.''.$vch_count;
							
							if($row['vch_faktur'] == 'BIAYA OP')
							{
								if($row['vch_details'] == 2)
								{
									echo '<div class="link" onclick="updateCount('. $row['vch_id'] . ','. $row['vch_count_alias'] .')">BKM '.$voucher_number.'-B</a>';
								}
							}
							else
							{
								if($row->job->job_location == 'JK')
								{
									echo '<div class="link" onclick="updateCount('. $row['vch_id'] . ','. $row['vch_count_alias'] .')">BKM '.$voucher_number.'</a>';
								}
							}
						}
					?>
				</td>
				
				<!-- NOMOR ARC SR -->
				<td class="text-center bordered">
					<?php
						if($row['vch_type'] == 1)
						{
							$tahun = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'y');
							$bulan = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'm');
							$vch_count = str_pad($row['vch_count_alias'], 3, '0', STR_PAD_LEFT);
							
							$voucher_number = $tahun.''.$bulan.''.$vch_count;
							
							if($row['vch_faktur'] == 'BIAYA OP')
							{
								if($row['vch_details'] == 3)
								{
									echo '<div class="link" onclick="updateCount('. $row['vch_id'] . ','. $row['vch_count_alias'] .')">BKM '.$voucher_number.'-B</a>';
								}
							}
							else
							{
								if($row->job->job_location == 'SR')
								{
									echo '<div class="link" onclick="updateCount('. $row['vch_id'] . ','. $row['vch_count_alias'] .')">BKM '.$voucher_number.'</a>';
								}
							}
						}
					?>
				</td>
				
				<!-- DATE -->
				<td class="text-center bordered">
					<?php
						if($row['vch_type'] == 1)
						{
							echo strtoupper(date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'd M Y'));
						}
					?>
				</td>
				
				<!-- JUMLAH -->
				<td class="text-right bordered">
					<?php
						if($row['vch_type'] == 1)
						{
							echo number_format($row['vch_amount'],0,'.',',');
							$total_ar += $row['vch_amount'];
						}
					?>
				</td>
				
				<td class="border-left border-right"></td>
				
				<!-- NOMOR APC SB -->
				<td class="text-center bordered">
					<?php
						if($row['vch_type'] == 2)
						{
							$tahun = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'y');
							$bulan = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'm');
							$vch_count = str_pad($row['vch_count_alias'], 3, '0', STR_PAD_LEFT);
							
							$voucher_number = $tahun.''.$bulan.''.$vch_count;
							
							if($row['vch_faktur'] == 'BIAYA OP')
							{
								if($row['vch_details'] == 1)
								{
									echo '<div class="link" onclick="updateCount('. $row['vch_id'] . ','. $row['vch_count_alias'] .')">BKK '.$voucher_number.'-B</a>';
								}
							}
							else
							{
								if($row->job->job_location == 'SB')
								{
									echo '<div class="link" onclick="updateCount('. $row['vch_id'] . ','. $row['vch_count_alias'] .')">BKK '.$voucher_number.'</a>';
								}
							}
						}
					?>
				</td>
				
				<!-- NOMOR APC JK -->
				<td class="text-center bordered">
					<?php
						if($row['vch_type'] == 2)
						{
							$tahun = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'y');
							$bulan = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'm');
							$vch_count = str_pad($row['vch_count_alias'], 3, '0', STR_PAD_LEFT);
							
							$voucher_number = $tahun.''.$bulan.''.$vch_count;
							
							if($row['vch_faktur'] == 'BIAYA OP')
							{
								if($row['vch_details'] == 2)
								{
									echo '<div class="link" onclick="updateCount('. $row['vch_id'] . ','. $row['vch_count_alias'] .')">BKK '.$voucher_number.'-B</a>';
								}
							}
							else
							{
								if($row->job->job_location == 'JK')
								{
									echo '<div class="link" onclick="updateCount('. $row['vch_id'] . ','. $row['vch_count_alias'] .')">BKK '.$voucher_number.'</a>';
								}
							}
						}
					?>
				</td>
				
				<!-- NOMOR APC SR -->
				<td class="text-center bordered">
					<?php
						if($row['vch_type'] == 2)
						{
							$tahun = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'y');
							$bulan = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'm');
							$vch_count = str_pad($row['vch_count_alias'], 3, '0', STR_PAD_LEFT);
							
							$voucher_number = $tahun.''.$bulan.''.$vch_count;
							
							if($row['vch_faktur'] == 'BIAYA OP')
							{
								if($row['vch_details'] == 3)
								{
									echo '<div class="link" onclick="updateCount('. $row['vch_id'] . ','. $row['vch_count_alias'] .')">BKK '.$voucher_number.'-B</a>';
								}
							}
							else
							{
								if($row->job->job_location == 'SR')
								{
									echo '<div class="link" onclick="updateCount('. $row['vch_id'] . ','. $row['vch_count_alias'] .')">BKK '.$voucher_number.'</a>';
								}
							}
						}
					?>
				</td>
				
				<!-- DATE -->
				<td class="text-center bordered">
					<?php
						if($row['vch_type'] == 2)
						{
							echo strtoupper(date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'd M Y'));
						}
					?>
				</td>

				<!-- JUMLAH -->
				<td class="text-right bordered">
					<?php
					if($row['vch_type'] == 2)
						{
							echo number_format($row['vch_amount'],0,'.',',');
							$total_ap += $row['vch_amount'];
						}
					?>
				</td>
			</tr>
		<?php } ?>	
		<tr>
			<td colspan="2" class="bordered"></td>
			
			<td class="border-left border-right"></td>
			<td class="text-right bordered" colspan="4"><b>TOTAL ARC / BKM</b></td>
			<td class="text-right bordered">
				<b><?= number_format($total_ar,0,'.',',') ?></b>
			</td>

			<td class="border-left border-right"></td>
			<td class="text-right bordered" colspan="4"><b>TOTAL APC / BKK</b></td>
			<td class="text-right bordered">
				<b><?= number_format($total_ap,0,'.',',') ?></b>
			</td>
		</tr>
	</table>
</div>
