<?php
use yii\helpers\Url;
use yii\helpers\Html;
use richardfan\widget\JSRegister;
use app\models\Customer;
use app\models\MasterNewJobinvoice;
use app\models\MasterNewJobvoucher;

date_default_timezone_set('Asia/Jakarta');
?>

<style>
	.container{
		max-width: 97% !important;
		padding: 20px !important;
	}
	
	body{
		width: 2600px;
		overflow-x: auto;
	}
	
	table{
    	border-collapse: collapse;
	}
</style>

<div class="report-ar" style="font-size:12px">
	<div class="row">
		<div class="col-12">
			<div class="float-left">
				<a href="<?= Url::base().'/report/index'?>" type="button" class="btn btn-dark">Back to Menu<a>
			</div>
			<div class="text-center">
				<h5><b>REPORT AR</b></h5>
			</div>
		</div>
	</div>
	
	<hr style="border-top:1px solid black;">
	
	<div class="row">
		<div class="col-1 mt-2 pr-0">MONTH/YEAR : </div>
		<div class="col-1 pl-0 pr-1">
			<select class="form-control" id="filter-month">
				<?php for($i=1;$i<13;$i++){ 
					
					if(empty($filter_month)){
						if($i == date('n')){
							$selected = 'selected';
						}else{
							$selected = '';
						}
					}else{
						if($i == $filter_month){
							$selected = 'selected';
						}else{
							$selected = '';
						}
					}
				?>
					<option value="<?= $i ?>" <?= $selected ?>> <?= strtoupper(date('M', mktime(0, 0, 0, $i, 10))) ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-1 pl-0 pr-1">
			<select class="form-control" id="filter-year">
				<?php
					$year = date('Y');
					$max = $year+5;
					$min = $year-5;
					
					for($i=$min;$i<=$max;$i++){
					
					if(empty($filter_year)){
						if($i == $year){
							$selected = 'selected';
						}else{
							$selected = '';
						}
					}else{
						if($i == $filter_year){
							$selected = 'selected';
						}else{
							$selected = '';
						}
					}
				?>
					<option value="<?= $i ?>" <?= $selected ?>> <?= $i ?></option>
				<?php } ?>
			</select>
		</div>
		<button type="button" id="filter_ar_search" onclick="searchAr()" class="btn btn-default mr-1">FILTER</button>
		<button type="button" id="filter_ar_clear" onclick="clearAr()" class="btn btn-default mr-4">RESET</button>
	</div>
	
	<br>
	<br>
	
	<table class="table table-bordered" style="font-size:12px">
		<tr>
			<td colspan="13" style="background-color:#2f2f2f; color:#fff; text-align:left">
				<div style="display:inline-block;margin-left:15px; font-size:20px; margin-right:200px">LAPORAN AR</div>
				<div style="display:inline-block;margin-left:15px; font-size:20px"><?= strtoupper($month_year) ?></div>
			</td>
			<td colspan="7" style="background-color:#2f2f2f; color:#fff; font-size:20px">ARB-BBM / ARC-BKM</td>
		</tr>
		<tr>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center">JOB NO.</td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center">INVOICE</td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center">TANGGAL</td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center">CUSTOMER</td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center">E-FAKTUR</td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center">TANGGAL</td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center">JUMLAH</td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center">PPN</td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center">TOTAL</td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center">PPh DIPUNGUT</td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center">E-FAKTUR PPh</td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center">TANGGAL</td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center">NETTO</td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center">NOMOR</td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center">ALIAS</td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center">TANGGAL</td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center">JUMLAH ARB</td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center">JUMLAH ARC</td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center">OP/SP</td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center"></td>
		</tr>
		
		<?php 
			$jumlah_total = 0;
			$jumlah_total_ppn = 0;
			$jumlah_grandtotal = 0;
			$jumlah_pph = 0;
			$jumlah_netto = 0;
			$jumlah_arb = 0;
			$jumlah_arc = 0;
			$total_voucher = 0;
			$jumlah_op_sp = 0;
			
			if(isset($_GET['sort'])){
				if($_GET['sort'] == 'up'){
					$sort = ['inv_count'=>SORT_ASC];
				}else{
					$sort = ['inv_count'=>SORT_DESC];
				}
			}else{
				$sort = ['inv_count'=>SORT_ASC];
			}
			
			foreach($job as $row){
				// Invoice
				$invoice = MasterNewJobinvoice::find()
							->where(['inv_is_active' => 1])
							->andWhere(['inv_job_id' => $row['id']])
							->andWhere(['inv_currency' => 'IDR'])
							->orderBy($sort)
							->all();
				
				$i=1;
				foreach($invoice as $inv){
		?>
			<tr>
				<td class="text-center">
					<?php 
						if($i == 1){ 
							echo $row['job_name'];
						}
					?>
				</td>
				
				<!-- NO. INVOICE -->
				<td class="text-center">
					<?= 'IDT'.str_pad($inv['inv_count'],6,'0',STR_PAD_LEFT); ?>
				</td>
				
				<!-- TANGGAL -->
				<td class="text-center">
					<div style="width:80px">
						<?php
							echo date_format(date_create_from_format('Y-m-d', $inv['inv_date']), 'd M Y');
						?>
					</div>
				</td>
				
				<!-- CUSTOMER -->
				<td class="text-left">
					<div style="width:200px">
						<?php
							$customer = Customer::find()->where(['customer_id'=>$inv['inv_to'], 'is_active' => 1])->one();  
							echo strtoupper($customer->customer_companyname);
						?>
					</div>
				</td>
				
				<!-- E-FAKTUR -->
				<td class="text-center">
					<div style="width:130px">
						<?php
							$payment = MasterNewJobvoucher::find()->where(['vch_invoice'=>$inv['inv_id']])->one();
							if(isset($payment)){
								echo $payment->vch_faktur;
							}else{
								echo '';
							}
						?>
					</div>
				</td>
				
				<!-- TANGGAL -->
				<td class="text-center">
					<div style="width:80px">
						<?php
							echo date_format(date_create_from_format('Y-m-d', $inv['inv_date']), 'd M Y');
						?>
					</div>
				</td>
				
				<!-- JUMLAH -->
				<td class="text-right">
					<div style="width:80px">
						<?php
							echo number_format($inv['inv_total'],0,'.',',');
							$jumlah_total += $inv['inv_total'];
						?>
					</div>
				</td>
				
				<!-- PPN -->
				<td class="text-right">
					<div style="width:80px">
						<?php
							echo number_format($inv['inv_total_ppn'],0,'.',',');
							$jumlah_total_ppn += $inv['inv_total_ppn'];
						?>
					</div>
				</td>
				
				<!-- GRANDTOTAL -->
				<td class="text-right">
					<div style="width:80px">
						<?php
							echo number_format($inv['inv_grandtotal'],0,'.',',');
							$jumlah_grandtotal += $inv['inv_grandtotal'];
						?>
					</div>
				</td>
				
				<!-- PPH DIPUNGUT -->
				<td class="text-right">
					<div style="width:80px">
						<?php
							$payment = MasterNewJobvoucher::find()
										->where(['vch_invoice'=>$inv['inv_id']])
										->andWhere(['vch_type'=>1])
										->andWhere(['vch_is_active'=>1])
										->all();
										
							if(isset($payment)){
								$total_pph = 0;
								foreach($payment as $row){
									if(empty($row['vch_amount_pph']) || $row['vch_amount_pph'] == '-'){
										$pph = 0;
									}else{
										$pph = (int) $row['vch_amount_pph'];
									}
									$total_pph += $pph;
								}
							}
							echo number_format($total_pph,0,'.',',');
							$jumlah_pph += $total_pph;
						?>
					</div>
				</td>
				
				<!-- E-FAKTUR PPh -->
				<td class="text-center">
					<div style="width:180px">
						<?php
							$payment = MasterNewJobvoucher::find()->where(['vch_invoice'=>$inv['inv_id']])->one();
							if(isset($payment)){
								echo $payment->vch_nomor_pph;
							}else{
								echo '';
							}
						?>
					</div>
				</td>
				
				<!-- TANGGAL PPH -->
				<td class="text-center">
					<?php
						$payment = MasterNewJobvoucher::find()->where(['vch_invoice'=>$inv['inv_id']])->one();
						
						if(!empty($payment->vch_nomor_pph) && $payment->vch_nomor_pph !== '-'){
							echo date_format(date_create_from_format('Y-m-d', $payment->vch_date_pph), 'd M Y');
						}else{
							echo '-';
						}
					?>
				</td>
				
				<!-- NETTO -->
				<td align="right">
					<div style="width:80px" class="font_check">
						<?php
							$payment = MasterNewJobvoucher::find()->where(['vch_invoice'=>$inv['inv_id']])->one();
							
							$netto = $inv['inv_grandtotal'] - $total_pph;
							echo number_format($netto,0,'.',',');
							
							$jumlah_netto += $netto;
						?>
					</div>
				</td>
				
				<!-- NOMOR PAYMENT -->
				<td align="center">
					<?php
						$payment = MasterNewJobvoucher::find()
									->where(['vch_invoice'=>$inv['inv_id']])
									->andWhere(['vch_type'=>1])
									->andWhere(['vch_is_active'=>1])
									->all();
						
						foreach($payment as $row){
							if(!empty($row['vch_count_multiple']) && $row['vch_count_multiple'] !== '-'){
								$count_multiple = $row['vch_count_multiple'];
							}else{
								$count_multiple = '';
							}
							
							$tahun = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'y');
							$bulan = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'm');
							$day   = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'd');
							$voucher_date = $tahun.''.$bulan.''.$day;
							
							$vch_count = str_pad($row['vch_count'], 6, '0', STR_PAD_LEFT);
							
							
							$voucher_number = $tahun.''.$bulan.''.$vch_count;
					
							if($row['vch_pembayaran_type'] == 1){
								$type = 'AR-C';
								$bayar_type = 'BKM';
								
								$title1 = 'ARC - BUKTI KAS MASUK';
								$title2 = $type.''.$voucher_number.''.$count_multiple;
							}else{
								$type = 'AR-B';
								$bayar_type = 'BBM';
								
								$title1 = 'ARB - BUKTI BANK MASUK';
								$title2 = $type.''.$voucher_number.''.$count_multiple;
							}
							
							echo $type.'-'.$vch_count.''.$count_multiple.'-'.$voucher_date.'<br>';
						}
					?>
				</td>
				
				<!-- NOMOR PAYMENT ALIAS -->
				<td align="center">
					<?php
						$payment = MasterNewJobvoucher::find()
									->where(['vch_invoice'=>$inv['inv_id']])
									->andWhere(['vch_type'=>1])
									->andWhere(['vch_is_active'=>1])
									->all();
						
						foreach($payment as $row){
							if(!empty($row['vch_count_multiple']) && $row['vch_count_multiple'] !== '-'){
								$count_multiple = $row['vch_count_multiple'];
							}else{
								$count_multiple = '';
							}
							
							$tahun = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'y');
							$bulan = date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'm');
							$vch_count = str_pad($row['vch_count'], 3, '0', STR_PAD_LEFT);
							
							$voucher_number = $tahun.''.$bulan.''.$vch_count;
					
							if($row['vch_pembayaran_type'] == 1){
								$type = 'ARC / BKM';
								$bayar_type = 'BKM';
								
								$title1 = 'ARC - BUKTI KAS MASUK';
								$title2 = $type.''.$voucher_number.''.$count_multiple;
							}else{
								$type = 'ARB / BBM';
								$bayar_type = 'BBM';
								
								$title1 = 'ARB - BUKTI BANK MASUK';
								$title2 = $type.''.$voucher_number.''.$count_multiple;
							}
							
							// $title2 = $type.'-'.$voucher_number.''.$count_multiple.'-'.$voucher_date;
							echo $type.''.$voucher_number.''.$count_multiple.'<br>';
						}
					?>
				</td>
				
				<!-- TANGGAL PAYMENT -->
				<td align="center">
					<div style="width:80px" class="font_check">
						<?php
							$payment = MasterNewJobvoucher::find()
									->where(['vch_invoice'=>$inv['inv_id']])
									->andWhere(['vch_type'=>1])
									->andWhere(['vch_is_active'=>1])
									->all();
						
							foreach($payment as $row){
								echo date_format(date_create_from_format('Y-m-d', $row['vch_date']), 'd M Y').'<br>';
							}
						?>
					</div>
				</td>
				
				<!-- JUMLAH ARB -->
				<td align="right">
					<div style="width:80px" class="font_check">
						<?php
							$payment = MasterNewJobvoucher::find()
								->where(['vch_invoice'=>$inv['inv_id']])
								->andWhere(['vch_type'=>1])
								->andWhere(['vch_pembayaran_type'=>'2'])
								->andWhere(['vch_is_active'=>1])
								->all();
							
							if(isset($payment)){
								$total_arb = 0;
								foreach($payment as $row){
									if(empty($row['vch_amount']) || $row['vch_amount'] == '-'){
										$arb = 0;
									}else{
										$arb = (int) $row['vch_amount'];
									}
									$total_arb += $arb;
								}
							}
							
							echo number_format($total_arb,0,'.',',');
							
							$jumlah_arb += $total_arb;
							$total_voucher += $total_arb;
						?>
					</div>
				</td>

				<!-- JUMLAH ARC -->
				<td align="right">
					<div style="width:80px" class="font_check">
						<?php
							$payment = MasterNewJobvoucher::find()
								->where(['vch_invoice'=>$inv['inv_id']])
								->andWhere(['vch_type'=>1])
								->andWhere(['vch_pembayaran_type'=>'1'])
								->andWhere(['vch_is_active'=>1])
								->all();
							
							if(isset($payment)){
								$total_arc = 0;
								foreach($payment as $row){
									if(empty($row['vch_amount']) || $row['vch_amount'] == '-'){
										$arc = 0;
									}else{
										$arc = (int) $row['vch_amount'];
									}
									$total_arc += $arc;
								}
							}
							
							echo number_format($total_arc,0,'.',',');
							
							$jumlah_arc += $total_arc;
							$total_voucher += $total_arc;
						?>
					</div>
				</td>

				<!-- OP/SP -->
				<td align="right">
					<div style="width:80px" class="font_check">
						<?php
							$op_sp = $total_voucher - ($jumlah_grandtotal - $total_pph);
							
							if($op_sp < 0){
								echo '(' .number_format($op_sp,0,'.',','). ')';
							}else{
								echo number_format($op_sp,0,'.',',');
							}
							
							$jumlah_op_sp += $op_sp;
							
							$total_voucher = 0;
							$total_pph = 0;
						?>
					</div>
				</td>
				
				<td>
					<span onclick="moveUp(<?= $i ?>)" style="cursor:pointer"><i class="fa fa-arrow-up" title="Up"></i></span>
					<span onclick="moveDown(<?= $i ?>)" style="cursor:pointer"><i class="fa fa-arrow-down" title="Down"></i></span>
				</td>
			</tr>
			<?php $i++;} ?>
		<?php } ?>
		
		<tr>
			<td colspan="6" style="background-color:#2f2f2f; color:#fff; text-align:center">TOTAL</td>
			<td style="background-color:#2f2f2f; color:#fff" align="right" class="font_check">
				<?php echo number_format($jumlah_total,0,'.',','); ?>
			</td>
			<td style="background-color:#2f2f2f; color:#fff" align="right" class="font_check">
				<?php echo number_format($jumlah_total_ppn,0,'.',','); ?>
			</td>
			<td style="background-color:#2f2f2f; color:#fff" align="right" class="font_check">
				<?php echo number_format($jumlah_grandtotal,0,'.',','); ?>
			</td>
			<td style="background-color:#2f2f2f; color:#fff" align="right" class="font_check">
				<?php echo number_format($jumlah_pph,0,'.',','); ?>
			</td>
			<td style="background-color:#2f2f2f; color:#fff" align="right" class="font_check"></td>
			<td style="background-color:#2f2f2f; color:#fff" align="right" class="font_check"></td>

			<?php
				if($jumlah_netto == ($jumlah_arb+$jumlah_arc)) $color = '#157121'; else $color = '#711d15';
				echo '<td style="background-color:'.$color.'; color:#fff;" align="right" class="font_check">';
				echo number_format($jumlah_netto,0,'.',',');
				echo '</td>';
			?>

			<td style="background-color:#2f2f2f; color:#fff" align="right" class="font_check"></td>
			<td style="background-color:#2f2f2f; color:#fff" align="right" class="font_check"></td>
			<td style="background-color:#2f2f2f; color:#fff" align="right" class="font_check"></td>
			<?php
				if($jumlah_netto == ($jumlah_arb+$jumlah_arc)) $color = '#157121'; else $color = '#711d15';
				echo '<td style="background-color:'.$color.'; color:#fff" align="right" class="font_check">';
				echo number_format($jumlah_arb,0,'.',',');
				echo '</td>';
			?>

			<?php
				if($jumlah_netto == ($jumlah_arb+$jumlah_arc)) $color = '#157121'; else $color = '#711d15';
				echo '<td style="background-color:'.$color.'; color:#fff" align="right" class="font_check">';
				echo number_format($jumlah_arc,0,'.',',');
				echo '</td>';
			?>
			
			<?php
				if($jumlah_op_sp < 0)
				{
					echo '<td style="background-color:#711d15; color:#fff" align="right" class="font_check">';
					echo '('.number_format(str_replace('-', '', $jumlah_op_sp),0,'.',',').')';
					echo '</td>';
				}
				else if($jumlah_op_sp > 0)
				{
					echo '<td style="background-color:#711d15; color:#fff" align="right" class="font_check">';
					echo number_format($jumlah_op_sp,0,'.',',');
					echo '</td>';
				}
				else
				{
					echo '<td style="background-color:#157121; color:#fff" align="right" class="font_check">';
					echo number_format($jumlah_op_sp,0,'.',',');
					echo '</td>';
				}
			?>
			<td style="background-color:#2f2f2f; color:#fff" align="right" class="font_check"></td>
		</tr>
	</table>
</div>

<script>
	$(document).ready(function(){
		
	});
	
	function searchAr(){
		month = $('#filter-month').val();
		year = $('#filter-year').val();
		
		url = '<?= Url::base()?>/report/report-ar?month='+month+'&year='+year;
		window.location.replace(url);
	}
	
	function clearAr(){
		url = '<?= Url::base()?>/report/report-ar';
		window.location.replace(url);
	}
	
	function moveUp(){
		month = $('#filter-month').val();
		year = $('#filter-year').val();
		
		url = '<?= Url::base()?>/report/report-ar?month='+month+'&year='+year+'&sort=up';
		window.location.replace(url);
	}
	
	function moveDown(){
		month = $('#filter-month').val();
		year = $('#filter-year').val();
		
		url = '<?= Url::base()?>/report/report-ar?month='+month+'&year='+year+'&sort=down';
		window.location.replace(url);
	}
</script>
