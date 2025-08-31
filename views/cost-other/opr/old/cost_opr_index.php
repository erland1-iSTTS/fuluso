<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Customer;
use app\models\MasterNewCostopr;
use app\models\MasterNewCostoprDetail;
use app\models\MasterNewJobvoucher;
use yii\helpers\VarDumper;
?>

<div id="index-cost-idt">
	<hr>
	<div class="row">
		<div class="col-12">
			<table class="table" id="table-cost-idt" style="font-size:12px">
				<thead class="table-secondary">
					<tr>
						<th width="12%">Cost No</th>
						<th width="8%">Date</th>
						<th width="8%">Due Date</th>
						<th width="16%">Pay To</th>
						<th width="16%">Office</th>
						<th width="8%" class="text-right">PPN</th>
						<th width="12%" class="text-right">Amount</th>
						<th width="22%"></th>
					</tr>
				</thead>
				<tbody>
					<?php
						$cost_opr = MasterNewCostopr::find()->where(['vch_currency' => 'IDR', 'vch_is_active' => 1])->orderBy(['vch_count'=>SORT_DESC])->all();
						$i = 0;
						foreach($cost_opr as $row){
						
						$payment_check = MasterNewJobvoucher::find()
										// ->where(['vch_cost' => $row['vch_id']])
										->where(['vch_cost' => 999999])
										->andWhere(['vch_currency' => 'IDR', 'vch_is_active' => 1])
										->one();
									
						if(!isset($payment_check)){ 
							$kode = 'AP-'.'<span style="color:red">'.'X-000000'.'-</span>'.date_format(date_create($row['vch_date']), 'ymd');
						}else{
							if($payment_check->vch_pembayaran_type == 1){
								$tipe = 'C';
							}else{
								$tipe = 'B';
							}
							
							$kode = 'AP-'.$tipe.'-'.str_pad($row['vch_count'],6,'0',STR_PAD_LEFT).'-'.date_format(date_create($row['vch_date']), 'ymd');
						}
					?>
						<tr>
							<!--<td><?php //'VPI'.str_pad($row['vch_count'],6,'0',STR_PAD_LEFT) ?></td>-->
							<td><?= $kode ?></td>
							<td><?= date_format(date_create($row['vch_date']), 'd M Y'); ?></td>
							<td><?= date_format(date_create($row['vch_due_date']), 'd M Y'); ?></td>
							<td><?= $row['vch_pay_to'] ?></td>
							<td>Surabaya</td>
							<td class="text-right"><?= number_format($row['vch_total_ppn'] ,0,'.',','); ?></td>
							<td class="text-right"><?= number_format($row['vch_grandtotal'] ,0,'.',','); ?> IDR</td>
							<td class="text-center">
								<!--<a class="btn btn-clear btn-xs" onclick="editCostIdt(<?= $row['vch_id'] ?>)" title="Edit">Edit Cost</a>-->
								<a href="<?= Url::base() ?>/cost-other/print-cost-opr?id_cost=<?= $row['vch_id']?>" target="_blank" class="btn btn-xs" title="PDF">
									<i class="fa fa-file-pdf-o" style="font-size:20px"></i>
									<!--<img width="20" height="22" src="<?php //Url::base().'/img/icon-pdf.jpg' ?>"/>-->
								</a>
								
								<!--<?php 
									$payment = MasterNewJobvoucher::find()
										->where(['vch_cost' => $row['vch_id']])
										->andWhere(['is not', 'vch_file', null])
										->andWhere(['!=', 'vch_file', ''])
										->all();
									
									if(isset($payment)){ 
										foreach($payment as $kp => $p){
										$path = Url::base().'/upload/payment_ap/'.$p['vch_id'].'/'.$p['vch_file'];
								?>
									<a href="<?= $path ?>" class="btn btn-clear btn-xs" title="Bukti Bayar">Bukti Bayar</a>
									<?php } ?>
								<?php } ?>-->
								<!--<span class="gap"><img width="22" height="20" src="<?= Url::base().'/img/icon-mail.jpg' ?>"/></span>
								<span class="gap"><img width="20" height="20" src="<?= Url::base().'/img/icon-print.jpg' ?>"/></span>-->
							</td>
						</tr>
					<?php $i++;} ?>
				</tbody>
			</table>
		</div>
	</div>
	<hr>
</div>

<script>
	$(document).ready(function(){
	});
</script>
