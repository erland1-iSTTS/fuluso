<?php
use yii\helpers\Url;
use yii\helpers\Html;
use richardfan\widget\JSRegister;
use app\models\Customer;
use app\models\MasterNewJobinvoice;
use app\models\MasterNewJobcost;
use app\models\MasterNewJobcostDetail;
use app\models\MasterNewJobvoucher;
use yii\helpers\VarDumper;

date_default_timezone_set('Asia/Jakarta');
?>

<style>
	.container{
		max-width: 97% !important;
		padding: 20px !important;
	}
	
	body{
		width: 2200px;
		overflow-x: auto;
	}
	
	table{
    	border-collapse: collapse;
	}
	
	#table_detail_cost,
	#table_detail_cost tr,
	#table_detail_cost td{
		border: 0px !important;
	}
</style>

<div class="report-ap" style="font-size:12px">
	<div class="row">
		<div class="col-12">
			<div class="float-left">
				<a href="<?= Url::base().'/report/index'?>" type="button" class="btn btn-dark">Back to Menu<a>
			</div>
			<div class="text-center">
				<h5><b>REPORT MP</b></h5>
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
		<button type="button" id="filter_ar_search" onclick="searchMp()" class="btn btn-default mr-1">FILTER</button>
		<button type="button" id="filter_ar_clear" onclick="clearMp()" class="btn btn-default mr-4">RESET</button>
	</div>
	
	<br>
	<br>
	
	<table class="table table-bordered" style="font-size:12px">
		<tr>
			<td colspan="9" style="background-color:#2f2f2f; color:#fff; text-align:left">
				<div style="display:inline-block;margin-left:15px; font-size:20px; margin-right:200px">LAPORAN AP</div>
				<div style="display:inline-block;margin-left:15px; font-size:20px"><?= strtoupper($month_year) ?></div>
			</td>
			<td colspan="9" style="background-color:#2f2f2f; color:#fff; font-size:20px">APB-BBK / APC-BKK</td>
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
			<!-- AP -->
			<td style="background-color:#2f2f2f; color:#fff" class="text-center"><div style="width:100px">PAY TO</div></td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center"><div style="width:150px">INVOICE</div></td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center"><div style="width:80px">JUMLAH</div></td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center"><div style="width:150px">NOMOR</div></td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center"><div style="width:80px">TANGGAL</div></td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center"><div style="width:80px">JUMLAH APB</div></td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center"><div style="width:80px">JUMLAH APC</div></td>
			<td style="background-color:#2f2f2f; color:#fff" class="text-center"><div style="width:80px">OP/SP</div></td>
		</tr>
		
		<?php 
			$jumlah_total = 0;
			$jumlah_total_ppn = 0;
			$jumlah_grandtotal = 0;
			$jumlah_grandtotal_cost = 0;
			$total_grandtotal_cost = 0;
			$jumlah_apb = 0;
			$jumlah_apc = 0;
			$grandtotal_apb = 0;
			$grandtotal_apc = 0;
			$total_voucher = 0;
			$grandtotal_op_sp = 0;
			$hit = 0;
			
			foreach($job as $row){
				// Invoice
				$invoice = MasterNewJobinvoice::find()
							->where(['inv_is_active' => 1])
							->andWhere(['inv_job_id' => $row['id']])
							->andWhere(['inv_currency' => 'USD'])
							->orderBy(['inv_count'=>SORT_ASC])
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
					<?= 'HMC'.str_pad($inv['inv_count'],6,'0',STR_PAD_LEFT); ?>
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
				
				<td colspan="8" style="padding:0px 3px">
					<table class="table" id="table_detail_cost" style="font-size:12px; text-align:center; margin-bottom:0px;">
						<?php
							$x = 1;
							$cost = MasterNewJobcost::find()
									->where(['vch_job_id' => $row['id']])
									->andWhere(['vch_is_active' => 1])
									->andWhere(['vch_currency' => 'USD'])
									->orderBy(['vch_count'=>SORT_ASC])
									->all();
							$count_cost = MasterNewJobcost::find()
									->where(['vch_job_id' => $row['id']])
									->andWhere(['vch_is_active' => 1])
									->orderBy(['vch_count'=>SORT_ASC])
									->count();
							
							if(isset($cost)){
								foreach($cost as $c){
						?>
								<tr>
									<!-- PAY TO -->
									<td align="left" style="padding:2px 3px 2px 3px; width:100px" width="100px">
										<div style="width:100px">
											<?= strtoupper($c['vch_pay_to']) ?>
										</div>
									</td>
									
									<!-- COST DETAIL -->
									<td align="left" style="padding:2px 3px 2px 3px; width:150px" width="150px">
										<div style="width:150px">
											<?php
												$detail = MasterNewJobcostDetail::find()
															->where(['vchd_vch_id'=>$c['vch_id']])
															->andWhere(['vchd_is_active'=>1])
															->one();
												
												echo $detail->vchd_detail;
											?>
										</div>
									</td>
									
									<!-- JUMLAH -->
									<td align="right" style="padding:2px 3px 2px 3px; width:80px" width="80px">
										<div style="width:80px">
											<?php
												$cost = MasterNewJobcost::find()
														->where(['vch_id' => $c['vch_id']])
														->andWhere(['vch_is_active' => 1])
														->one();
												
												echo number_format($cost->vch_grandtotal,0,'.',',');
												$grandtotal_cost = $cost->vch_grandtotal;
												$jumlah_grandtotal_cost += $cost->vch_grandtotal;
												$total_grandtotal_cost += $cost->vch_grandtotal;
											?>
										</div>
									</td>
									
									<!-- NOMOR -->
									<td align="center" style="border-top:0px; color:#000; padding:2px 3px 2px 3px; width:150px" width="150px">
										<div style="width:150px">
											<?php
												$payment = MasterNewJobvoucher::find()
															->where(['vch_cost'=>$c['vch_id']])
															->andWhere(['vch_type'=>2])
															->andWhere(['vch_is_active'=>1])
															->all();
												
												if(isset($payment)){
													foreach($payment as $p){
														if(!empty($p['vch_count_multiple']) && $p['vch_count_multiple'] !== '-'){
															$count_multiple = $p['vch_count_multiple'];
														}else{
															$count_multiple = '';
														}
														
														$tahun = date_format(date_create_from_format('Y-m-d', $p['vch_date']), 'y');
														$bulan = date_format(date_create_from_format('Y-m-d', $p['vch_date']), 'm');
														$vch_count = str_pad($p['vch_count'], 3, '0', STR_PAD_LEFT);
														
														$voucher_number = $tahun.''.$bulan.''.$vch_count;
												
														if($p['vch_pembayaran_type'] == 1){
															$type = 'APC / BKK';
															$bayar_type = 'BKK';
														}else{
															$type = 'APB / BBK';
															$bayar_type = 'BBK';
														}
														
														echo '<div style="position:relative; margin-bottom:2px">';
														echo $type.''.$voucher_number.''.$count_multiple;
														echo '</div>';
													}
												}
											?>
										</div>
									</td>
									
									<!-- TANGGAL -->
									<td align="center" style="border-top:0px; color:#000; padding:2px 3px 2px 3px; width:80px" width="80px">
										<div style="width:80px">
											<?php
												$payment = MasterNewJobvoucher::find()
															->where(['vch_cost'=>$c['vch_id']])
															->andWhere(['vch_type'=>2])
															->andWhere(['vch_is_active'=>1])
															->all();
												
												if(isset($payment)){
													foreach($payment as $p){
														echo '<div style="position:relative; margin-bottom:2px">';
														echo date_format(date_create_from_format('Y-m-d', $p['vch_date']), 'd m Y');
														echo '</div>';
													}
												}
											?>
										</div>
									</td>
									
									<!-- JUMLAH APB -->
									<td align="right" style="border-top:0px; color:#000; padding:2px 3px 2px 3px; width:80px" width="80px">
										<div style="width:80px">
											<?php
												$payment = MasterNewJobvoucher::find()
															->where(['vch_cost'=>$c['vch_id']])
															->andWhere(['vch_type'=>2])
															->andWhere(['vch_pembayaran_type'=>2])
															->andWhere(['vch_is_active'=>1])
															->all();
												
												if(isset($payment)){
													foreach($payment as $row){
														if(empty($row['vch_amount']) || $row['vch_amount'] == '-'){
															$apb = 0;
														}else{
															$apb = (int) $row['vch_amount'];
														}
														
														if(!empty($apb)){
															echo number_format($apb,0,'.',',');
														}
														
														$total_voucher += $apb;
														$jumlah_apb += $apb;
														$grandtotal_apb += $apb;
													}
												}
											?>
										</div>
									</td>

									<!-- JUMLAH APC -->
									<td align="right" style="border-top:0px; color:#000; padding:2px 3px 2px 3px; width:80px" width="80px">
										<div style="width:80px">
											<?php
												$payment = MasterNewJobvoucher::find()
															->where(['vch_cost'=>$c['vch_id']])
															->andWhere(['vch_type'=>2])
															->andWhere(['vch_pembayaran_type'=>1])
															->andWhere(['vch_is_active'=>1])
															->all();
												
												if(isset($payment)){
													foreach($payment as $row){
														if(empty($row['vch_amount']) || $row['vch_amount'] == '-'){
															$apc = 0;
														}else{
															$apc = (int) $row['vch_amount'];
														}
														
														if(!empty($apc)){
															echo number_format($apc,0,'.',',');
														}
														
														$total_voucher += $apc;
														$jumlah_apc += $apc;
														$grandtotal_apc += $apc;
													}
												}
											?>
										</div>
									</td>

									<!-- OP/SP -->
									<td align="right" style="border-top:0px; color:#000; padding:2px 3px 2px 3px; width:80px" width="80px">
										<div style="width:80px">
											<?php
												$hit += $grandtotal_cost-$jumlah_apb-$jumlah_apc;
												$op_sp = $jumlah_grandtotal_cost-$total_voucher;
												
												if($x == $count_cost){
													if($op_sp < 0)
													{
														echo '('.str_replace('-', '', number_format($op_sp,0,'.',',')).')';
													}
													else
													{
														echo number_format($op_sp,0,'.',',');
													}
												}
											?>
										</div>
									</td>
								</tr>
							<?php
								$jumlah_apb=0;
								$jumlah_apc=0;
								$x++;
							}
							?>
						<?php } ?>
					</table>
				</td>
			</tr>
			<?php
			$i++;
			}
		$op_sp = 0;
		$jumlah_grandtotal_cost = 0;
		$total_voucher = 0;
		}
		?>
		
		<tr>
			<td colspan="6" style="color:#fff; background-color:#2f2f2f; text-align:center"><div style="width:100%">TOTAL</div></td>
			<td style="color:#fff; background-color:#2f2f2f; border-top:1px solid black; text-align:right"><?= number_format($jumlah_total,0,'.',',') ?></td>
			<td style="color:#fff; background-color:#2f2f2f; border-top:1px solid black; text-align:right"><?= number_format($jumlah_total_ppn,0,'.',',') ?></td>
			<td style="color:#fff; background-color:#2f2f2f; border-top:1px solid black; text-align:right"><?= number_format($jumlah_grandtotal,0,'.',',') ?></td>

			<td colspan="2" style="color:#fff; background-color:#2f2f2f; border-top:1px solid black; width:250px" width="250px"><div style="width:250px"></div></td>
			<td style="color:#fff; background-color:#2f2f2f; border-top:1px solid black; width:80px; text-align:right" width="80px"><div style="width:80px"><?= number_format($total_grandtotal_cost,0,'.',',') ?></div></td>
			<td colspan="2" style="color:#fff; background-color:#2f2f2f; border-top:1px solid black; width:180px" width="180px"><div style="width:180px"></div></td>
			<td style="color:#fff; background-color:#2f2f2f; border-top:1px solid black; width:80px; text-align:right" width="80px"><div style="width:80px"><?= number_format($grandtotal_apb,0,'.',',') ?></div></td>
			<td style="color:#fff; background-color:#2f2f2f; border-top:1px solid black; width:80px; text-align:right" width="80px"><div style="width:80px"><?= number_format($grandtotal_apc,0,'.',',') ?></div></td>
			<td style="color:#fff; background-color:#2f2f2f; border-top:1px solid black; width:80px; text-align:right" width="80px"><div style="width:80px"><?= number_format($hit,0,'.',',') ?></div></td>
		</tr>
	</table>
</div>

<script>
	$(document).ready(function(){
		
	});
	
	function searchMp(){
		month = $('#filter-month').val();
		year = $('#filter-year').val();
		
		url = '<?= Url::base()?>/report/report-mp?month='+month+'&year='+year;
		window.location.replace(url);
	}
	
	function clearMp(){
		url = '<?= Url::base()?>/report/report-mp';
		window.location.replace(url);
	}
</script>
