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

<div id="ap-opr-voucher-index">
	<div class="row">
		<div class="col-2">
			<div class="form-group">
				<select class="form-control" style="width:100%" id="filter_date">
					<?php
						for($m=1; $m<=12; $m++){
							if($m ==  date('n')){
								$selected = 'selected';
							}else{
								$selected = '';
							}
							
							$month = date('F', mktime(0,0,0,$m, 1, date('Y')));
							
							echo "<option value='".$m."' ".$selected.">".
								$month.' '.date('Y').
							"</option>";
						}
					?>
				</select>
			</div>
		</div>
		
		<div class="col-10">
			<button type="button" class="btn btn-dark float-right" style="font-size:12px" id="btn_create_ap_opr_voucher">Create AP Operational Voucher</button>
		</div>
	</div>
	
	<div class="row">
		<div class="col-12">
			<table class="table mb-0" id="table-ap-opr-voucher1" style="font-size:12px">
				<thead class="table-secondary">
					<tr>
						<th width="12%">Voucher No</th>
						<th width="10%">Date</th>
						<th width="16%">Pos</th>
						<th width="12%">Detail</th>
						<th width="12%" class="text-center">Qty</th>
						<th width="11%" class="text-center">Unit</th>
						<th width="11%" class="text-right">Amount</th>
						<!--<th width="10%" class="text-right">PPN</th>
						<th width="12%" class="text-right">PPH</th>-->
						<th width="16%" class="text-right">Subtotal</th>
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
						</tr>
						
					<?php $i++;} ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php ActiveForm::end(); ?>

<script type="text/javascript">
	$(document).ready(function(){
	});
</script>
