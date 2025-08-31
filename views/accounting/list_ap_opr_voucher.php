<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\CostVoucherV5;
use app\models\PosV8;
use app\models\MasterPortfolioAccount;

$account = MasterPortfolioAccount::find()->where(['flag'=>1])->orderBy(['accountname'=>SORT_ASC])->all();

date_default_timezone_set('Asia/Jakarta');
?>

<style>
	.selection{
		font-size: 10px !important;
	}
	
	#table-ap-opr-voucher td{
		vertical-align: middle;
	}
</style>

<?php $form = ActiveForm::begin([
	'id' => 'form_update_ap_opr_payment', 
	'action' => Url::base().'/accounting/update-ap-opr-voucher-payment'
]) ?>

<div id="ap-opr-voucher-payment-index">
	<div class="row">
		<div class="col-12">
			<span style="font-size:15px"><b>Input AP Operation Voucher Payment</b></span>
		</div>
	</div>
	
	<hr>
	
	<div class="row">
		<div class="col-12">
			<table class="table" id="table-ap-opr-voucher" style="font-size:10px">
				<thead class="table-secondary">
					<tr>
						<th width="7%">Voucher No</th>
						<th width="6%">Date</th>
						<th width="6%">Office</th>
						<th width="10%">Pos</th>
						<th width="10%">Detail</th>
						<th width="8%" class="text-center">Qty</th>
						<th width="8%" class="text-center">Unit</th>
						<th width="10%" class="text-right">Amount</th>
						<th width="10%" class="text-right">Subtotal</th>
						<th width="25%">Payment Account & Status</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$ap_opr_voucher = CostVoucherV5::find()->where(['cv_month'=>date('n'), 'cv_year'=>date('Y')])->orderBy(['cv_id' => SORT_ASC])->all();
						
						$i = 0;
						$grandtotal = 0;
						
						foreach($ap_opr_voucher as $row){
							$pos 	    = PosV8::find()->where(['pos_id'=>$row['cv_pos']])->one();
							$voucher_no = 'VCH'.str_pad($row['cv_code'],6,'0', STR_PAD_LEFT);
					?>
						<tr>
							<td>
								<input type="hidden" class="form-control" value="<?= $row['cv_id']?>" name="CostVoucherV5[detail][<?= $i ?>][cv_id]">
								<?= $voucher_no ?>
							</td>
							<td><?= date_format(date_create($row['cv_datecreated']), 'd M Y'); ?></td>
							<td>Surabaya</td>
							<td><?= $pos->pos_name ?></td>
							<td><?= $row['cv_detail'] ?></td>
							<td class="text-center">
								<?php
									if(empty($row['cv_qty'])){
										echo '-';
									}else{
										echo number_format($row['cv_qty'],0,'.',',');
									}
								?>
							</td>
							<td class="text-center"><?= $row['cv_packages'] ?></td>
							<td class="text-right">
								<?php
									if(empty($row['cv_amount'])){
										echo '-';
									}else{
										echo number_format($row['cv_amount'],0,'.',',');
									}
								?>
							</td>
							<!--<td class="text-right">
								<?php
									if(empty($row['ppn'])){
										echo '-';
									}else{
										echo number_format($row['ppn'],0,'.',',');
									}
								?>
							</td>
							<td class="text-right" style="color:#dc3545">
								<?php
									if(empty($row['pph'])){
										echo '-';
									}else{
										echo number_format($row['pph'],0,'.',',');
									}
								?>
							</td>-->
							<td class="text-right">
								<?php
									if(empty($row['cv_subtotal'])){
										echo '-';
										$subtotal = 0;
									}else{
										echo number_format($row['cv_subtotal'],0,'.',',');
										$subtotal = $row['cv_subtotal'];
									}
									
									$grandtotal += $subtotal;
								?>
							</td>
							<td>
								<div class="row">
									<?php if($row['status_payment'] == 1){ ?>
										<div class="col-7 mt-1">
											<?php 
												$bank = MasterPortfolioAccount::find()->where(['id'=>$row['id_portfolio_account'], 'flag'=>1])->one();
											
												if(isset($bank)){
													echo '<span class="mt-2">'.$bank->name.'</span>';
												}else{
													echo '-';
												}
											?>
										</div>
									<?php }else{ ?>
										<div class="col-7">
											<select class="form-control account_ap_opr" id="account_bank-<?= $i ?>" style="font-size:9.5px" name="CostVoucherV5[detail][<?= $i ?>][id_portfolio_account]">
												<?php
													foreach($account as $ac){
														echo '<option value="'.$ac['id'].'">'.
															$ac['name'].' - '.$ac['accountno'].
														'</option>';
													}
												?>
											</select>
										</div>
									<?php } ?>
									
									<?php if($row['status_payment'] == 1){ ?>
										<div class="col-5 mt-1 pl-0 pr-0">
											<span style="color:#20cc20">PAID On <?= date_format(date_create($row['payment_date']), 'd M Y') ?></span>
										</div>
									<?php }else{ ?>
										<div class="col-5 mt-2">
											<input type="checkbox" class="form-check-input" id="checks-<?= $i ?>" name="CostVoucherV5[detail][<?= $i ?>][paid]" value="1">
											<label class="form-check-label pt-1" for="checks-<?= $i ?>">Mark as Paid</label>
										</div>
									<?php } ?>
								</div>
							</td>
						</tr>
						
					<?php $i++;} ?>
				</tbody>
			</table>
		</div>
	</div>
	
	<div class="row">
		<div class="col-12">
			<table class="table border-bottom" style="font-size:10px">
				<tr>
					<td width="72%"><b>Total</b></td>
					<td class="text-right" width="8%"><b><?= number_format($grandtotal,0,'.',',');?></b></td>
					<td width="20%"></td>
				</tr>
			</table>
		</div>
	</div>
	
	<div class="row">
		<div class="col-12 text-right">
			<button type="submit" class="btn btn-dark" style="font-size:12px">Save Payment Info</button>
		</div>
	</div>
</div>
<?php ActiveForm::end(); ?>

<script type="text/javascript">
	$(document).ready(function(){
	});
</script>
