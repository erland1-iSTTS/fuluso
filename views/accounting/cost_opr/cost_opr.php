<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Modal;
use richardfan\widget\JSRegister;
use app\models\MasterPortfolioAccount;
use app\models\PosV8;
use app\models\MasterNewJobcost;
use app\models\MasterNewCostopr;
use app\models\MasterNewJobvoucher;

date_default_timezone_set('Asia/Jakarta');
?>

<?php
$account	= MasterPortfolioAccount::find()->where(['flag'=>1])->orderBy(['name'=>SORT_ASC])->all();
$pos		= PosV8::find()->where(['is_active'=>1])->orderby(['pos_name'=>SORT_ASC])->all();
$list_cost 	= MasterNewJobcost::find()->where(['vch_is_active'=>1])->orderBy(['vch_count'=>SORT_DESC])->all();
?>

<style>
	.container{
		max-width: 97% !important;
		padding: 20px !important;
	}
	
	.cost-operational input,
	.cost-operational select,
	.cost-operational textarea{
		font-size: 12px;
	}
	
	.table-detail-inv,
	.table-detail-inv thead td,
	.table-detail-inv .total td{
		border-top: 1px solid lightgray;
		border-bottom: 1px solid lightgray;
		padding: 5px !important;
	}
	
	.table-detail-inv tbody td{
		border: none;
		padding: 5px !important;
	}
	
	option{
		color: black;
	}
</style>

<div class="ap-idr-payment" style="font-size:12px">
	<div class="row">
		<div class="col-12">
			<div class="float-left">
				<a href="<?= Url::base().'/accounting/index'?>" type="button" class="btn btn-dark">Back to Menu<a>
			</div>
			<div class="text-center">
				<h5><b>COST OPERATIONAL PAYMENT</b></h5>
			</div>
		</div>
	</div>
	<hr style="border-top:1px solid black;">
	<br>
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
		<button type="button" id="filter_ar_search" onclick="searchAp()" class="btn btn-default mr-1">FILTER</button>
		<button type="button" id="filter_ar_clear" onclick="clearAp()" class="btn btn-default mr-5">RESET</button>
		<button type="button" id="btn_ar_multiple" onclick="multipleAp()" class="btn btn-dark">AP MULTIPLE +</button>
	</div>
	
	<br>
	
	<div class="row">
		<div class="col-7">
			<table class="table table-bordered" style="font-size:15px;">
				<tr>
					<td style="width:120px; text-align:center; background-color:#ccc; border-right:1px white solid">COST</td>
					<td style="width:100px; text-align:center; background-color:#ccc; border-right:1px white solid">DATE</td>
					<td style="width:100px; text-align:center; background-color:#ccc; border-right:1px white solid">AMOUNT</td>
					<td style="width:100px; text-align:center; background-color:#ccc; border-right:1px white solid">AP</td>
				</tr>
				
				<?php
					$i = 1;
					$currency = 'IDR';
					foreach($cost as $row){
					
					if($row['vch_currency'] == 'USD'){
						$kode = 'HMC';
					}else{
						$kode = 'IDT';
					}
				?>
					<tr>
						<td style="text-align:left;">
							<a href="<?= Url::base() ?>/job/print-cost?id_job=<?= $row['vch_job_id']?>&id_cost=<?= $row['vch_id'] ?>" style="color:black;text-decoration:none" target="_blank">
								<i class="fa fa-file-pdf-o mr-1"></i>
							</a>
							<?= 'AP-'.'<span style="color:red">X-000000-</span>'.str_pad($row['vch_count'],6,'0',STR_PAD_LEFT); ?>
						</td>
						<td style="text-align:center">
							<?= date_format(date_create($row['vch_date']), 'd M Y') ?>
						</td>
						<td style="text-align:center">
							<?= number_format($row['vch_grandtotal'],'0','.',',').' '.$currency ?>
						</td>
						<td style="text-align:center">
							<button type="button" class="btn btn-dark" onclick="createApCostOpr(<?= $row['vch_id'] ?>)" title="Create">CREATE AP</button>
						</td>
					</tr>
					<tr>
						<td colspan="4" style="background-color:#F5F5F5">
							<?php
								$vch_cost_idr = MasterNewJobvoucher::find()
											->where(['vch_cost' => $row['vch_id'], 'vch_is_active' => 1])
											->orderBy(['vch_id'=>SORT_ASC])
											->all();
											
								if(isset($vch_cost_idr)){
									foreach($vch_cost_idr as $v){
										
										if($v['vch_pembayaran_type'] == 1){
											$type = 'AP-C';
											$bayar_type = 'BKK';
											$bank = '';
										}else{
											$type = 'AP-B';
											$bayar_type = 'BBK';
											$vch_bank = MasterPortfolioAccount::find()->where(['id'=>$v['vch_bank']])->one();
											if(isset($vch_bank)){
												$bank = $vch_bank->name;
											}else{
												$bank = '';
											}
										}
										
										if(!empty($v['vch_count_multiple']) && $v['vch_count_multiple'] !== '-'){
											$vch_count_multiple = $v['vch_count_multiple'];
										}else{
											$vch_count_multiple = '';
										}
										
										$tahun = date_format(date_create_from_format('Y-m-d', $v['vch_date']), 'y');
										$bulan = date_format(date_create_from_format('Y-m-d', $v['vch_date']), 'm');
										$day = date_format(date_create_from_format('Y-m-d', $v['vch_date']), 'd');
										$vch_count = str_pad($v['vch_count'], 6, '0', STR_PAD_LEFT);
										
										$voucher_number = $vch_count;
										$voucher_date = $tahun.''.$bulan.''.$day;
							?>
								<div class="row" style="margin:0px 0px 10px 0px">
									<div>
										<a href="<?= Url::base().'/accounting/print-ap?id='.$v['vch_id'] ?>" style="color:black;text-decoration:none" target="_blank">
											<i class="fa fa-file-pdf-o mr-2"></i>
										</a>
									</div>
									
									<div style="color:blue">
										<div onclick="editAp(<?= $v['vch_id'] ?>)" style="cursor:pointer" title="Edit">
											<?= $type.'-'.$voucher_number.''.$vch_count_multiple.'-'.$voucher_date ?>
										</div>
									</div>
									
									<div class="ml-2 mr-2"> / </div>
										
									<div style="width:15%;text-align:right">
										<?= number_format($v['vch_amount'],'0','.',',').' '.$v['vch_currency'] ?>
									</div>
									
									<div class="ml-2 mr-2"> / </div>
									
									<div style="width:20%">
										<?= empty($bank) ? '-': $bank ?>
									</div>
								</div>
								<?php } ?>
							<?php } ?>
						</td>
					</tr>
				<?php } ?>
			</table>
		</div>
		
		<div class="col-1"></div>
		<div class="col-4">
			<?php
				$payment_voucher = MasterNewCostopr::find()
					->joinWith('paymentcost')
					->select(['master_new_costopr.vch_due_date', 'sum(master_new_costopr.vch_grandtotal) as total'])
					// ->where(['is', 'master_new_jobvoucher.vch_id' , null])
					->where(['or', ['is', 'master_new_jobvoucher.vch_id', null], ['master_new_jobvoucher.vch_is_active' => 0]])
					// ->andWhere(['>=', 'inv_due_date', date('Y-m-d'). '23:59:59'])
					// ->andWhere(['vch_is_active' => 1,'inv_is_active' => 1])
					->andWhere(['master_new_costopr.vch_is_active' => 1])
					->groupBy(['master_new_costopr.vch_due_date'])
					->asArray()
					->all();
				
				// VarDumper::dump($payment_voucher,10,true);die();
				
				$total_all = 0;
				foreach($payment_voucher as $row){
					$total_all += ($row['total']*1);
				}
			?>
			
			<div class="row m-0" style="border:1px solid lightgray;font-size:25px;padding:10px">
				<div class="col-6">Total</div>
				<div class="col-6 text-right"><?php //$total_all ?>0</div>
			</div>
			
			<!--<table class="table table-bordered" style="font-size:15px;">
				<?php 
					$total_all = 0;
					foreach($payment_voucher as $row){
				?>
				<tr>
					<td width="50%"><?= $row['vch_due_date'] ?></td>
					<td width="50%" class="text-right"><?= $row['total'] ?></td>
				</tr>
				<?php } ?>
			</table>-->
		</div>
	</div>

<!-- Modal Create Payment AP -->
<?php
	Modal::begin([
		'title' => 'Create Cost Operational Payment',
		'id' => 'modal_payment_cost_opr',
		'size' => 'modal-lg',
	]);
?>
	<?php $form = ActiveForm::begin([
		'id' => 'form_payment_cost_opr', 
		'action' => ['accounting/save-cost-opr-payment'],
		'options' => ['enctype' => 'multipart/form-data'],
	]); ?>
		<input type="hidden" id="vch_id" value="" name="MasterNewJobvoucher[vch_id]">
		<input type="hidden" id="vch_id_cost" name="MasterNewJobvoucher[vch_cost]">
		<input type="hidden" id="vch_id_job" name="MasterNewJobvoucher[vch_job_id]">
		
		<div id="div_ap_cost" style="padding:10px;border:1px solid lightgray;margin-bottom:20px;background:#f8f8f8;">
			
		</div>
		
		<div class="row mb-1">
			<label class="col-2">Tanggal</label>
			<div class="col-4">
				<input type="date" class="form-control" id="vch_date" value="<?= date('Y-m-d') ?>" name="MasterNewJobvoucher[vch_date]">
			</div>
		</div>

		<div class="row">
			<label class="col-2">Type</label>
			<div class="col-9">
				<div class="form-check form-check-inline col-4">
					<input type="radio" class="form-check-input vch_mode" id="vch_mode1" name="MasterNewJobvoucher[vch_pembayaran_type]" value="1">
					<label class="form-check-label" for="vch_mode1">AP-C-OPR</label>
				</div>
				<div class="form-check form-check-inline col-5">
					<input type="radio" class="form-check-input vch_mode" id="vch_mode2" name="MasterNewJobvoucher[vch_pembayaran_type]" value="2">
					<label class="form-check-label" for="vch_mode2">AP-B-OPR</label>
				</div>
			</div>
		</div>
		
		<div class="row mb-2" id="div_split_bkk_check" style="display:none">
			<div class="offset-5 col-7" style="padding-left:40px;">
				<input type="checkbox" class="form-check-input" id="splitbkk" name="MasterNewJobvoucher[splitbkk]" value="1">
				<label class="form-check-label" for="splitbkk">Split and Create APC / BKK</label>
			</div>
		</div>
		
		<div class="row mb-1" id="div_account" style="display:none">
			<label class="col-2"></label>
			<div class="col-7">
				<select class="form-control" id="id_account" name="MasterNewJobvoucher[vch_bank]">
					<?php
						foreach($account as $row){
							echo '<option value="'.$row['id'].'">'.
								$row['name'].
							'</option>';
						}
					?>
				</select>
			</div>
		</div>
		
		<div class="row mb-1">
			<label class="col-2"></label>
			<div class="col-7">
				<input type="text" class="form-control" id="vch_informasi" value="" placeholder="Informasi" name="MasterNewJobvoucher[vch_pembayaran_info]">
			</div>
		</div>
		
		<div class="row mt-2 mb-2" id="div_bkk_type" style="display:none">
			<label class="col-2"></label>
			<div class="col-9">
				<label id="label_mode_type">BKK Type :</label>
				<div class="form-check form-check-inline col-md-12">
					<input type="radio" class="form-check-input bkk_type" id="bkk_type1" name="MasterNewJobvoucher[bkk_type]" value="1">
					<label class="form-check-label" for="bkk_type1">OPR - JOB</label>
				</div>
				<div class="form-check form-check-inline col-md-12">
					<input type="radio" class="form-check-input bkk_type" id="bkk_type2" name="MasterNewJobvoucher[bkk_type]" value="2">
					<label class="form-check-label" for="bkk_type2">Umum</label>
				</div>
				<div class="form-check form-check-inline col-md-12">
					<input type="radio" class="form-check-input bkk_type" id="bkk_type3" name="MasterNewJobvoucher[bkk_type]" value="3">
					<label class="form-check-label" for="bkk_type3">Lainnya</label>
				</div>
			</div>
		</div>
		
		<div class="row mt-2 mb-2" id="div_bbk_type" style="display:none">
			<label class="col-2"></label>
			<div class="col-9" id="div_split_bbk_type">
				<label id="label_mode_type">BBK Type :</label>
				<div class="form-check form-check-inline col-md-12">
					<input type="radio" class="form-check-input bbk_type" id="bbk_type1" name="MasterNewJobvoucher[bbk_type]" value="1">
					<label class="form-check-label" for="bbk_type1">OPR - JOB</label>
				</div>
				<div class="form-check form-check-inline col-md-12">
					<input type="radio" class="form-check-input bbk_type" id="bbk_type2" name="MasterNewJobvoucher[bbk_type]" value="2">
					<label class="form-check-label" for="bbk_type2">Umum</label>
				</div>
				<div class="form-check form-check-inline col-md-12">
					<input type="radio" class="form-check-input bbk_type" id="bbk_type3" name="MasterNewJobvoucher[bbk_type]" value="2">
					<label class="form-check-label" for="bbk_type3">Lainnya</label>
				</div>
			</div>
			
			<label class="col-2"></label>
			<div class="col-9 mt-2" id="div_split_bkk_type">
				<label id="label_mode_type">BKK Type :</label>
				<div class="form-check form-check-inline col-md-12">
					<input type="radio" class="form-check-input non_bkk_type" id="bkk_type4" name="MasterNewJobvoucher[non_bkk_type]" value="1">
					<label class="form-check-label" for="bkk_type4">OPR - JOB</label>
				</div>
				<div class="form-check form-check-inline col-md-12">
					<input type="radio" class="form-check-input non_bkk_type" id="bkk_type5" name="MasterNewJobvoucher[non_bkk_type]" value="2">
					<label class="form-check-label" for="bkk_type5">Umum</label>
				</div>
				<div class="form-check form-check-inline col-md-12">
					<input type="radio" class="form-check-input non_bkk_type" id="bkk_type6" name="MasterNewJobvoucher[non_bkk_type]" value="3">
					<label class="form-check-label" for="bkk_type6">Lainnya</label>
				</div>
			</div>
		</div>
		
		<div class="row mb-1">
			<label class="col-2">Amount</label>
			<div class="col-2 pr-1">
				<select class="form-control" id="vch_currency" name="MasterNewJobvoucher[vch_currency]">
					<option value="IDR">IDR</option>
					<option value="USD">USD</option>
				</select>
			</div>
			<div class="col-5 pl-0">
				<input type="text" class="form-control" id="vch_amount" value="" name="MasterNewJobvoucher[vch_amount]" required>
			</div>
		</div>
		
		<div class="row mb-3">
			<label class="col-2">No Faktur</label>
			<span class="col-9">
				<div style="width:70px;display:inline-block">
					<input type="text" class="form-control" id="vch_faktur1" maxlength="3" value="" name="MasterNewJobvoucher[vch_faktur1]">
				</div>&nbsp;.&nbsp;
				<div style="width:70px;display:inline-block">
					<input type="text" class="form-control" id="vch_faktur2" maxlength="3" value="" name="MasterNewJobvoucher[vch_faktur2]">
				</div>&nbsp;-&nbsp;
				<div style="width:70px;display:inline-block">
					<input type="text" class="form-control" id="vch_faktur3" maxlength="2" value="" name="MasterNewJobvoucher[vch_faktur3]">
				</div>&nbsp;.&nbsp;
				<div style="width:100px;display:inline-block">
					<input type="text" class="form-control" id="vch_faktur4" maxlength="8" value="" name="MasterNewJobvoucher[vch_faktur4]">
				</div>
			</span>
		</div>
		
		<!--<div class="row form-group">
			<label class="col-2">Upload</label>
			<div class="col-9">
				<input type="file" id="vch_file" name="MasterNewJobvoucher[vch_file]">
			</div>
		</div>-->
		
		<div class="row">
			<div class="col-12 text-right">
				<button type="submit" class="btn btn-dark">Save</button>
			</div>
		</div>
	<?php ActiveForm::end(); ?>
<?php Modal::end(); ?>


<!-- Modal Edit Payment AP -->
<?php
	Modal::begin([
		'title' => 'Edit AP Payment',
		'id' => 'modal_edit_payment_cost_opr',
		'size' => 'modal-lg',
	]);
?>
	<?php $form = ActiveForm::begin([
		'id' => 'form_edit_payment_ap', 
		'action' => ['accounting/edit-cost-opr-payment'],
		// 'action' => ['accounting/save-cost-opr-payment'],
		'options' => ['enctype' => 'multipart/form-data'],
	]); ?>
		<input type="hidden" id="edit_vch_id" value="" name="MasterNewJobvoucher[vch_id]">
		<input type="hidden" id="edit_vch_id_cost" name="MasterNewJobvoucher[vch_cost]">
		<input type="hidden" id="edit_vch_id_job" name="MasterNewJobvoucher[vch_job_id]">
		
		<div id="edit_div_ap_cost" style="padding:10px;border:1px solid lightgray;margin-bottom:20px;background:#f8f8f8;">
			
		</div>
		
		<div class="row mb-1">
			<label class="col-2">Tanggal</label>
			<div class="col-4">
				<input type="date" class="form-control" id="edit_vch_date" value="<?= date('Y-m-d') ?>" name="MasterNewJobvoucher[vch_date]">
			</div>
		</div>

		<div class="row">
			<label class="col-2">Type</label>
			<div class="col-9">
				<div class="form-check form-check-inline col-md-4">
					<input type="radio" class="form-check-input edit_vch_mode" id="edit_vch_mode1" name="MasterNewJobvoucher[vch_pembayaran_type]" value="1">
					<label class="form-check-label" for="edit_vch_mode1">AP-C-OPR</label>
				</div>
				<div class="form-check form-check-inline col-md-5">
					<input type="radio" class="form-check-input edit_vch_mode" id="edit_vch_mode2" name="MasterNewJobvoucher[vch_pembayaran_type]" value="2">
					<label class="form-check-label" for="edit_vch_mode2">AP-B-OPR</label>
				</div>
			</div>
		</div>
		
		<div class="row mb-1" id="edit_div_account" style="display:none">
			<label class="col-2"></label>
			<div class="col-7">
				<select class="form-control" id="edit_id_account" name="MasterNewJobvoucher[vch_bank]">
					<?php
						foreach($account as $row){
							echo '<option value="'.$row['id'].'">'.
								$row['name'].
							'</option>';
						}
					?>
				</select>
			</div>
		</div>
		
		<div class="row mb-1">
			<label class="col-2"></label>
			<div class="col-7">
				<input type="text" class="form-control" id="edit_vch_informasi" value="" placeholder="Informasi" name="MasterNewJobvoucher[vch_pembayaran_info]">
			</div>
		</div>
		
		<div class="row mt-3 mb-3" id="edit_div_bkk_type" style="display:none">
			<label class="col-2"></label>
			<div class="col-9">
				<label id="label_mode_type">BKK Type :</label>
				<div class="form-check form-check-inline col-md-12">
					<input type="radio" class="form-check-input bkk_type" id="edit_bkk_type1" name="MasterNewJobvoucher[bkk_type]" value="1">
					<label class="form-check-label" for="edit_bkk_type1">OPR - JOB</label>
				</div>
				<div class="form-check form-check-inline col-md-12">
					<input type="radio" class="form-check-input bkk_type" id="edit_bkk_type2" name="MasterNewJobvoucher[bkk_type]" value="2">
					<label class="form-check-label" for="edit_bkk_type2">Umum</label>
				</div>
				<div class="form-check form-check-inline col-md-12">
					<input type="radio" class="form-check-input bkk_type" id="edit_bkk_type3" name="MasterNewJobvoucher[bkk_type]" value="3">
					<label class="form-check-label" for="edit_bkk_type3">Lainnya</label>
				</div>
			</div>
		</div>
		
		<div class="row mt-3 mb-3" id="edit_div_bbk_type" style="display:none">
			<label class="col-2"></label>
			<div class="col-9 mb-3">
				<label id="label_mode_type">BBK Type :</label>
				<div class="form-check form-check-inline col-md-12">
					<input type="radio" class="form-check-input edit_bbk_type" id="edit_bbk_type1" name="MasterNewJobvoucher[bbk_type]" value="1">
					<label class="form-check-label" for="edit_bbk_type1">OPR - JOB</label>
				</div>
				<div class="form-check form-check-inline col-md-12">
					<input type="radio" class="form-check-input edit_bbk_type" id="edit_bbk_type2" name="MasterNewJobvoucher[bbk_type]" value="2">
					<label class="form-check-label" for="edit_bbk_type2">Umum</label>
				</div>
				<div class="form-check form-check-inline col-md-12">
					<input type="radio" class="form-check-input edit_bbk_type" id="edit_bbk_type3" name="MasterNewJobvoucher[bbk_type]" value="2">
					<label class="form-check-label" for="edit_bbk_type3">Lainnya</label>
				</div>
			</div>
		</div>
		
		<div class="row mb-1">
			<label class="col-2">Amount</label>
			<div class="col-2 pr-1">
				<select class="form-control" id="edit_vch_currency" name="MasterNewJobvoucher[vch_currency]">
					<option value="IDR">IDR</option>
					<option value="USD">USD</option>
				</select>
			</div>
			<div class="col-5 pl-0">
				<input type="text" class="form-control" id="edit_vch_amount" value="" name="MasterNewJobvoucher[vch_amount]" required>
			</div>
		</div>
		
		<div class="row mb-3">
			<label class="col-2">No Faktur</label>
			<span class="col-9">
				<div style="width:70px;display:inline-block">
					<input type="text" class="form-control" id="edit_vch_faktur1" maxlength="3" value="" name="MasterNewJobvoucher[vch_faktur1]">
				</div>&nbsp;.&nbsp;
				<div style="width:70px;display:inline-block">
					<input type="text" class="form-control" id="edit_vch_faktur2" maxlength="3" value="" name="MasterNewJobvoucher[vch_faktur2]">
				</div>&nbsp;-&nbsp;
				<div style="width:70px;display:inline-block">
					<input type="text" class="form-control" id="edit_vch_faktur3" maxlength="2" value="" name="MasterNewJobvoucher[vch_faktur3]">
				</div>&nbsp;.&nbsp;
				<div style="width:100px;display:inline-block">
					<input type="text" class="form-control" id="edit_vch_faktur4" maxlength="8" value="" name="MasterNewJobvoucher[vch_faktur4]">
				</div>
			</span>
		</div>
		
		<!--<div class="row form-group">
			<label class="col-2">Upload</label>
			<div class="col-9">
				<input type="file" id="edit_vch_file" name="MasterNewJobvoucher[vch_file]">
			</div>
		</div>-->
		
		<div class="row">
			<div class="col-12 text-right">
				<button type="submit" class="btn btn-dark" id="btn_save_edit">Save</button>
			</div>
		</div>
	<?php ActiveForm::end(); ?>
<?php Modal::end(); ?>

<!-- AP Multiple -->
<?php
	Modal::begin([
		'title' => 'Create AP Payment',
		'id' => 'modal_payment_ap_idt_multiple',
		'size' => 'modal-lg',
	]);
?>
	<?php $form = ActiveForm::begin([
		'id' => 'form_payment_cost_opr_multiple',
		'action' => ['accounting/save-ap-payment-multiple'],
		'options' => ['enctype' => 'multipart/form-data'],
	]); ?>
		
		<div class="row mb-2">
			<label class="col-2">Tanggal</label>
			<div class="col-4">
				<input type="date" class="form-control" id="vch_date" value="<?= date('Y-m-d') ?>" name="MasterNewJobvoucher[vch_date]">
			</div>
		</div>
		
		<!--<div class="row mb-2">
			<label class="col-2">Upload</label>
			<div class="col-4">
				<input type="file" id="multi_vch_file" name="MasterNewJobvoucher[vch_file]">
			</div>
		</div>-->

		<div class="row mb-3">
			<label class="col-2 pt-2">Total Cost</label>
			<div class="col-2">
				<input type="number" class="form-control" id="rows_multi_ap" onkeyup="addrows_multi_ap()">
			</div>
			<!--<div class="col-4">
				<button type="button" class="btn btn-success" onclick="addrow_cost()">
					<span class="fa fa-plus align-middle"></span> Tambah
				</button>
			</div>-->
		</div>
		
		<div id="div_multiple_ap">
			
		</div>
		
		<div class="row">
			<div class="col-12 text-right">
				<button type="submit" class="btn btn-dark">Save</button>
			</div>
		</div>
	<?php ActiveForm::end(); ?>
<?php Modal::end(); ?>
</div>

<script>
	$(document).ready(function(){
		$('#vch_mode1').prop('checked', true);
		$('#bkk_type1').prop('checked', true);
		$('#bbk_type1').prop('checked', true);
		$('#bkk_type4').prop('checked', true);
		$('#splitbkk').prop('checked', false);
		$('#vch_faktur1').val('040');
	});
	
	$('.vch_mode').on('click', function(){
		if($('#vch_mode2').is(':checked') == true){
			$('#splitbkk').prop('checked', false);
			$('#div_account').show();
			// $('#div_bbk_type').show();
			// $('#div_bkk_type').hide();
			$('#div_split_bkk_check').show();
			$('#div_split_bkk_type').hide();
		}else{
			$('#div_account').hide();
			// $('#div_bbk_type').hide();
			// $('#div_bkk_type').show();
			$('#div_split_bkk_check').hide();
		}
	});
	
	$('.edit_vch_mode').on('click', function(){
		if($('#edit_vch_mode2').is(':checked') == true){
			$('#edit_div_account').show();
			// $('#edit_div_bbk_type').show();
			// $('#edit_div_bkk_type').hide();
			$('#edit_div_split_bkk_check').show();
		}else{
			$('#edit_div_account').hide();
			// $('#edit_div_bbk_type').hide();
			// $('#edit_div_bkk_type').show();
		}
	});
	
	$('#splitbkk').on('click', function(){
		if($('#splitbkk').is(':checked') == true){
			$('#div_split_bkk_type').show();
		}else{
			$('#div_split_bkk_type').hide();
		}
	});
	
	function searchAp(){
		month = $('#filter-month').val();
		year = $('#filter-year').val();
		
		url = '<?= Url::base()?>/accounting/cost-opr?month='+month+'&year='+year;
		window.location.replace(url);
	}
	
	function clearAp(){
		url = '<?= Url::base()?>/accounting/cost-opr';
		window.location.replace(url);
	}
	
	function getCost(id){
		$.ajax({
			url: '<?=Url::base().'/accounting/get-cost-idt'?>',
			data: {'id': id},
			dataType: 'json',
			method: 'POST',
            async: 'false'
		}).done(function(result){
			cost = result.cost;
			detail = result.detail;
			
			if(cost){
				$('#vch_id_job').val(cost['vch_job_id']);
				
				item = '';
				item += '<div class="row">';
					item += '<div class="col-12 text-center" style="font-size:16px">';
						item += '<b>COST OPERATIONAL</b>';
					item += '</div>';
				item += '</div>';
				item += '<div class="row">';
					item += '<label class="col-2">DATE</label>';
					item += '<div class="col-8">';
						item += ': '+result.date_cost;
					item += '</div>';
				item += '</div>';
				item += '<div class="row">';
					item += '<label class="col-2">PAY FOR</label>';
					item += '<div class="col-8">';
						item += ': '+result.data_pay_for['customer_companyname'];
					item += '</div>';
				item += '</div>';
				item += '<div class="row">';
					item += '<label class="col-2">PAY TO</label>';
					item += '<div class="col-8">';
						item += ': '+result.data_pay_to;
					item += '</div>';
				item += '</div>';
				
				item += '<table class="table table-detail-inv">';
					item += '<thead>';
						item += '<tr>';
							item += '<td width="28%">DESCRIPTION OF CHARGES</td>';
							item += '<td width="16%" class="text-right">BASIS</td>';
							item += '<td width="16%" class="text-right">QUANTITY</td>';
							item += '<td width="16%" class="text-right">RATE</td>';
							item += '<td width="17%" class="text-right">TOTAL</td>';
							item += '<td width="5%">CURR</td>';
						item += '</tr>';
					item += '</thead>';
					
					item += '<tbody>';
						if(detail){
							for(const data of detail)
							{
								item += '</tr>';
									item += '<td>'+data['pos_name']+'</td>';
									item += '<td class="text-right">'+data['total_basis']+' '+data['packages_basis']+'</td>';
									item += '<td class="text-right">'+data['total_qty']+' '+data['packages_qty']+'</td>';
									item += '<td class="text-right">'+data['rate']+'</td>';
									item += '<td class="text-right">'+data['amount']+'</td>';
									item += '<td>IDR</td>';
								item += '</tr>';
							}
						}
						item += '<tr class="total">';
							item += '<td colspan="4" class="text-right">TOTAL</td>';
							item += '<td class="text-right">'+result.total+'</td>';
							item += '<td>IDR</td>';
						item += '</tr>';
						
						item += '<tr class="total">';
							item += '<td colspan="4" class="text-right">PPN</td>';
							item += '<td class="text-right">'+result.total_ppn+'</td>';
							item += '<td>IDR</td>';
						item += '</tr>';
						
						item += '<tr class="total">';
							item += '<td colspan="4" class="text-right">GRANDTOTAL</td>';
							item += '<td class="text-right">'+result.grandtotal+'</td>';
							item += '<td>IDR</td>';
						item += '</tr>';
					item += '</tbody>';
				item += '</table>';
				
				$('#div_ap_cost').html(item);
				$('#edit_div_ap_cost').html(item);
			}
		});
	}
	
	function createApCostOpr(id){
		//Reset Form setiap close modal
		$('#modal_payment_cost_opr').on('hidden.bs.modal', function(){
			$('#form_payment_cost_opr').trigger('reset');
			$('#vch_mode1').prop('checked', true);
			$('#bkk_type1').prop('checked', true);
			$('#bbk_type1').prop('checked', true);
			$('#bkk_type4').prop('checked', true);
			$('#vch_faktur1').val('040');
			
			$('#div_split_bkk_check').hide();
			$('#splitbkk').prop('checked', false);
			// $('#div_bkk_type').show();
			// $('#div_bbk_type').hide();
			$('#div_account').hide();
			
			$('#div_ap_cost').html('');
			$('#edit_div_ap_cost').html('');
		});
		
		$('#vch_id_cost').val(id);
		
		getCost(id);
		
		$('#modal_payment_cost_opr').modal({backdrop: 'static', keyboard: false});
		$('#modal_payment_cost_opr').show();
	}
	
	function editAp(id){
		$('#div_ap_cost').html('');
		$('#edit_div_ap_cost').html('');
		
		$.ajax({
			url: '<?=Url::base().'/accounting/get-ap-idt'?>',
			data: {'id': id},
			dataType: 'json',
			method: 'POST',
            async: 'false'
		}).done(function(result){
			ap_idt = result.ap_idt;
			cost = result.cost;
			
			if(ap_idt){
				$('#edit_vch_date').val(ap_idt['vch_date']);
				
				if(ap_idt['vch_pembayaran_type'] == 1){
					$('#edit_bbk_type1').prop('checked', true);
					
					$('#edit_vch_mode1').prop('checked', true);
					$('#edit_div_account').css('display', 'none');
					
					// $('#edit_div_bkk_type').show();
					// $('#edit_div_bbk_type').hide();
					
					type = ap_idt['bkk_type'];
					$('#edit_bkk_type'+type).prop('checked',true);
					
				}else{
					$('#edit_bkk_type1').prop('checked', true);
					
					$('#edit_vch_mode2').prop('checked', true);
					$('#edit_div_account').css('display', '');
					$('#edit_id_account').val(ap_idt['vch_bank']).trigger('change');
					
					// $('#edit_div_bkk_type').hide();
					// $('#edit_div_bbk_type').show();
					
					type = ap_idt['bbk_type'];
					$('#edit_bbk_type'+type).prop('checked',true);
				}
				
				$('#edit_vch_informasi').val(ap_idt['vch_pembayaran_info']);
				$('#edit_vch_currency').val(ap_idt['vch_currency']).trigger('change');
				$('#edit_vch_amount').val(ap_idt['vch_amount']);
				
				if(ap_idt['vch_faktur']){
					no_faktur1 = ap_idt['vch_faktur'].split('.')[0];
					no_faktur2 = ap_idt['vch_faktur'].split('.')[1].split('-')[0];
					no_faktur3 = ap_idt['vch_faktur'].split('.')[1].split('-')[1];
					no_faktur4 = ap_idt['vch_faktur'].split('.')[2];
					
					$('#edit_vch_faktur1').val(no_faktur1);
					$('#edit_vch_faktur2').val(no_faktur2);
					$('#edit_vch_faktur3').val(no_faktur3);
					$('#edit_vch_faktur4').val(no_faktur4);
				}
				
				$('#edit_vch_id').val(ap_idt['vch_id']);
				$('#edit_vch_id_cost').val(cost['vch_id']);
				$('#edit_vch_id_job').val(cost['vch_job_id']);
				
				getCost(cost['vch_id']);
				
				$('#modal_edit_payment_cost_opr').modal({backdrop: 'static', keyboard: false});
				$('#modal_edit_payment_cost_opr').show();
			}
		});
	}
	
	//------ Multi AP -----
	function multipleAp(){
		$('#div_multiple_ap').html('');
		$('#rows_multi_ap').val('');
		$('#modal_payment_ap_idt_multiple').modal({backdrop: 'static', keyboard: false});
		$('#modal_payment_ap_idt_multiple').modal('show');
	}
	
	function addrows_multi_ap(){
		$('#div_multiple_ap').html('');
		
		rows = $('#rows_multi_ap').val();
		
		// Limit loop 30x, menghindari server down
		if(rows <= 30){ 
			for(let i=0; i < rows; i++){
				addrow_cost();
			}
		}
	}
	
	function addrow_cost(){
		last = $('.list_cost').length;
		
		item = '';
		if(last == 0){
			id = 1;
			item += '<hr>';
		}else{
			id = last+1;
		}
		
		item += '<div class="row mb-1 list_cost" id="div_list_cost-'+id+'">';
			item += '<div class="col-12">';
				item += '<b>COST #'+id+'</b>';
			item += '</div>';
		item += '</div>';
		
		item += '<div class="row mb-1" id="div_list_cost-'+id+'">';
			item += '<label class="col-2">Cost</label>';
			item += '<div class="col-7">';
				item += '<select class="form-control" id="vch_id_cost-'+id+'" name="MasterNewJobvoucher[detail]['+id+'][vch_cost]" onchange="getDetailCost(this.id)" required>';
					item += '<option value="">-- List Cost --</option>';
					item += '<?php
						foreach($list_cost as $row){
							echo '<option value="'.$row['vch_id'].'">'.
								'VPI'.str_pad($row['vch_count'],6,'0',STR_PAD_LEFT).' '.'('.date_format(date_create($row['vch_date']), 'd M Y').')'.
							'</option>';
						}
					?>';
				item += '</select>';
			item += '</div>';
		item += '</div>';
		
		item += '<div id="div_ap_cost-'+id+'" style="margin-top:10px;padding:10px;border:1px solid lightgray;margin-bottom:20px;background:#f8f8f8;display:none">';
		
		item += '</div>';
		
		item += '<input type="hidden" id="vch_id_job-'+id+'" name="MasterNewJobvoucher[detail]['+id+'][vch_job_id]">';
		
		item += '<div class="row">';
			item += '<label class="col-2">Type</label>';
			item += '<div class="col-9">';
				item += '<div class="form-check form-check-inline col-md-4">';
					item += '<input type="radio" class="form-check-input vch_mode_multi" id="vch_mode1-'+id+'" name="MasterNewJobvoucher[detail]['+id+'][vch_pembayaran_type]" value="1">';
					item += '<label class="form-check-label" for="vch_mode1-'+id+'">APC / BKK</label>';
				item += '</div>';
				item += '<div class="form-check form-check-inline col-md-5">';
					item += '<input type="radio" class="form-check-input vch_mode_multi" id="vch_mode2-'+id+'" name="MasterNewJobvoucher[detail]['+id+'][vch_pembayaran_type]" value="2">';
					item += '<label class="form-check-label" for="vch_mode2-'+id+'">APB / BBK</label>';
				item += '</div>';
			item += '</div>';
		item += '</div>';
		
		item += '<div class="row mb-1" id="div_account-'+id+'" style="display:none">';
			item += '<label class="col-2"></label>';
			item += '<div class="col-7">';
				item += '<select class="form-control" id="id_account-'+id+'" name="MasterNewJobvoucher[detail]['+id+'][vch_bank]">';
					item += '<?php
						foreach($account as $row){
							echo '<option value="'.$row['id'].'">'.
								$row['name'].
							'</option>';
						}
					?>';
				item += '</select>';
			item += '</div>';
		item += '</div>';
		
		item += '<div class="row mb-1">';
			item += '<label class="col-2"></label>';
			item += '<div class="col-7">';
				item += '<input type="text" class="form-control" id="vch_informasi-'+id+'" value="" placeholder="Informasi" name="MasterNewJobvoucher[detail]['+id+'][vch_pembayaran_info]">';
			item += '</div>';
		item += '</div>';
		
		item += '<div class="row mt-3 mb-3" id="div_bkk_type-'+id+'">';
			item += '<label class="col-2"></label>';
			item += '<div class="col-9">';
				item += '<label id="label_mode_type">BKK Type :</label>';
				item += '<div class="form-check form-check-inline col-md-12">';
					item += '<input type="radio" class="form-check-input bkk_type" id="bkk_type1-'+id+'" name="MasterNewJobvoucher[detail]['+id+'][bkk_type]" value="1">';
					item += '<label class="form-check-label" for="bkk_type1-'+id+'">OPR - JOB</label>';
				item += '</div>';
				item += '<div class="form-check form-check-inline col-md-12">';
					item += '<input type="radio" class="form-check-input bkk_type" id="bkk_type2-'+id+'" name="MasterNewJobvoucher[detail]['+id+'][bkk_type]" value="2">';
					item += '<label class="form-check-label" for="bkk_type2-'+id+'">Umum</label>';
				item += '</div>';
				item += '<div class="form-check form-check-inline col-md-12">';
					item += '<input type="radio" class="form-check-input bkk_type" id="bkk_type3-'+id+'" name="MasterNewJobvoucher[detail]['+id+'][bkk_type]" value="3">';
					item += '<label class="form-check-label" for="bkk_type3-'+id+'">Lainnya</label>';
				item += '</div>';
			item += '</div>';
		item += '</div>';
		
		item += '<div class="row mt-3 mb-3" id="div_bbk_type-'+id+'" style="display:none">';
			item += '<label class="col-2"></label>';
			item += '<div class="col-9 mb-3">';
				item += '<label id="label_mode_type">BBK Type :</label>';
				item += '<div class="form-check form-check-inline col-md-12">';
					item += '<input type="radio" class="form-check-input bbk_type" id="bbk_type1-'+id+'" name="MasterNewJobvoucher[detail]['+id+'][bbk_type]" value="1">';
					item += '<label class="form-check-label" for="bbk_type1-'+id+'">OPR - JOB</label>';
				item += '</div>';
				item += '<div class="form-check form-check-inline col-md-12">';
					item += '<input type="radio" class="form-check-input bbk_type" id="bbk_type2-'+id+'" name="MasterNewJobvoucher[detail]['+id+'][bbk_type]" value="2">';
					item += '<label class="form-check-label" for="bbk_type2-'+id+'">Umum</label>';
				item += '</div>';
				item += '<div class="form-check form-check-inline col-md-12">';
					item += '<input type="radio" class="form-check-input bbk_type" id="bbk_type3-'+id+'" name="MasterNewJobvoucher[detail]['+id+'][bbk_type]" value="2">';
					item += '<label class="form-check-label" for="bbk_type3-'+id+'">Lainnya</label>';
				item += '</div>';
			item += '</div>';
			
			item += '<label class="col-2"></label>';
			item += '<div class="col-9 mb-3">';
				item += '<div class="form-check form-check-inline col-md-12">';
					item += '<input type="checkbox" class="form-check-input vch_nonbkk_multi" id="nonbkk-'+id+'" name="MasterNewJobvoucher[detail]['+id+'][nonbkk]" value="1">';
					item += '<label class="form-check-label" for="nonbkk-'+id+'">NON BKK</label>';
				item += '</div>';
			item += '</div>';
			
			item += '<label class="col-2"></label>';
			item += '<div id="div_non_bkk-'+id+'">';
				item += '<div class="col-9">';
					item += '<label id="label_mode_type">BKK Type :</label>';
					item += '<div class="form-check form-check-inline col-md-12">';
						item += '<input type="radio" class="form-check-input non_bkk_type" id="bkk_type4-'+id+'" name="MasterNewJobvoucher[detail]['+id+'][non_bkk_type]" value="1">';
						item += '<label class="form-check-label" for="bkk_type4-'+id+'">OPR - JOB</label>';
					item += '</div>';
					item += '<div class="form-check form-check-inline col-md-12">';
						item += '<input type="radio" class="form-check-input non_bkk_type" id="bkk_type5-'+id+'" name="MasterNewJobvoucher[detail]['+id+'][non_bkk_type]" value="2">';
						item += '<label class="form-check-label" for="bkk_type5-'+id+'">Umum</label>';
					item += '</div>';
					item += '<div class="form-check form-check-inline col-md-12">';
						item += '<input type="radio" class="form-check-input non_bkk_type" id="bkk_type6-'+id+'" name="MasterNewJobvoucher[detail]['+id+'][non_bkk_type]" value="3">';
						item += '<label class="form-check-label" for="bkk_type6-'+id+'">Lainnya</label>';
					item += '</div>';
				item += '</div>';
			item += '</div>';
		item += '</div>';
		
		item += '<div class="row mb-1">';
			item += '<label class="col-2">Amount</label>';
			item += '<div class="col-2 pr-1">';
				item += '<select class="form-control" id="vch_currency-'+id+'" name="MasterNewJobvoucher[detail]['+id+'][vch_currency]">';
					item += '<option value="IDR">IDR</option>';
					item += '<option value="USD">USD</option>';
				item += '</select>';
			item += '</div>';
			item += '<div class="col-5 pl-0">';
				item += '<input type="text" class="form-control" id="vch_amount-'+id+'" value="" name="MasterNewJobvoucher[detail]['+id+'][vch_amount]" required>';
			item += '</div>';
		item += '</div>';
		
		item += '<div class="row mb-3">';
			item += '<label class="col-2">No Faktur</label>';
			item += '<span class="col-9">';
				item += '<div style="width:70px;display:inline-block">';
					item += '<input type="text" class="form-control" id="vch_faktur1-'+id+'" maxlength="3" value="" name="MasterNewJobvoucher[detail]['+id+'][vch_faktur1]">';
				item += '</div>&nbsp;.&nbsp;';
				item += '<div style="width:70px;display:inline-block">';
					item += '<input type="text" class="form-control" id="vch_faktur2-'+id+'" maxlength="3" value="" name="MasterNewJobvoucher[detail]['+id+'][vch_faktur2]">';
				item += '</div>&nbsp;-&nbsp;';
				item += '<div style="width:70px;display:inline-block">';
					item += '<input type="text" class="form-control" id="vch_faktur3-'+id+'" maxlength="2" value="" name="MasterNewJobvoucher[detail]['+id+'][vch_faktur3]">';
				item += '</div>&nbsp;.&nbsp;';
				item += '<div style="width:100px;display:inline-block">';
					item += '<input type="text" class="form-control" id="vch_faktur4-'+id+'" maxlength="8" value="" name="MasterNewJobvoucher[detail]['+id+'][vch_faktur4]">';
				item += '</div>';
			item += '</span>';
		item += '</div>';
		
		item += '<hr>';
		
		$('#div_multiple_ap').append(item);
		
		$('.vch_mode_multi').on('click', function(){
			id = $(this).attr('id');
			idx = id.split('-')[1];
			
			if($('#vch_mode2-'+idx).is(':checked') == true){
				$('#div_account-'+idx).show();
				$('#div_bbk_type-'+idx).show();
				$('#div_bkk_type-'+idx).hide();
			}else{
				$('#div_account-'+idx).hide();
				$('#div_bbk_type-'+idx).hide();
				$('#div_bkk_type-'+idx).show();
			}
		});
		
		$('.vch_nonbkk_multi').on('click', function(){
			id = $(this).attr('id');
			idx = id.split('-')[1];
			
			if($('#nonbkk-'+idx).is(':checked') == true){
				$('#div_non_bkk-'+idx).hide();
			}else{
				$('#div_non_bkk-'+idx).show();
			}
		});
	}
	
	function getDetailCost(id){
		id_cost = $('#'+id).val();
		idx = id.split('-')[1];
		
		if(id_cost !== ''){
			$.ajax({
				url: '<?=Url::base().'/accounting/get-cost-idt'?>',
				data: {'id': id_cost},
				dataType: 'json',
				method: 'POST',
				async: 'false'
			}).done(function(result){
				cost = result.cost;
				detail = result.detail;
				
				if(cost){
					$('#vch_id_job-'+idx).val(cost['vch_job_id']);
					
					item = '';
					item += '<div class="row">';
						item += '<div class="col-12 text-center" style="font-size:16px">';
							item += '<b>JOB COST</b>';
						item += '</div>';
					item += '</div>';
					item += '<div class="row">';
						item += '<label class="col-2">DATE</label>';
						item += '<div class="col-8">';
							item += ': '+result.date_cost;
						item += '</div>';
					item += '</div>';
					item += '<div class="row">';
						item += '<label class="col-2">PAY FOR</label>';
						item += '<div class="col-8">';
							item += ': '+result.data_pay_for['customer_companyname'];
						item += '</div>';
					item += '</div>';
					item += '<div class="row">';
						item += '<label class="col-2">PAY TO</label>';
						item += '<div class="col-8">';
							item += ': '+result.data_pay_to;
						item += '</div>';
					item += '</div>';
					
					item += '<table class="table table-detail-inv">';
						item += '<thead>';
							item += '<tr>';
								item += '<td width="28%">DESCRIPTION OF CHARGES</td>';
								item += '<td width="16%" class="text-right">BASIS</td>';
								item += '<td width="16%" class="text-right">QUANTITY</td>';
								item += '<td width="16%" class="text-right">RATE</td>';
								item += '<td width="17%" class="text-right">TOTAL</td>';
								item += '<td width="5%">CURR</td>';
							item += '</tr>';
						item += '</thead>';
						
						item += '<tbody>';
							if(detail){
								for(const data of detail)
								{
									item += '</tr>';
										item += '<td>'+data['pos_name']+'</td>';
										item += '<td class="text-right">'+data['total_basis']+' '+data['packages_basis']+'</td>';
										item += '<td class="text-right">'+data['total_qty']+' '+data['packages_qty']+'</td>';
										item += '<td class="text-right">'+data['rate']+'</td>';
										item += '<td class="text-right">'+data['amount']+'</td>';
										item += '<td>IDR</td>';
									item += '</tr>';
								}
							}
							item += '<tr class="total">';
								item += '<td colspan="4" class="text-right">TOTAL</td>';
								item += '<td class="text-right">'+result.total+'</td>';
								item += '<td>IDR</td>';
							item += '</tr>';
							
							item += '<tr class="total">';
								item += '<td colspan="4" class="text-right">PPN</td>';
								item += '<td class="text-right">'+result.total_ppn+'</td>';
								item += '<td>IDR</td>';
							item += '</tr>';
							
							item += '<tr class="total">';
								item += '<td colspan="4" class="text-right">GRANDTOTAL</td>';
								item += '<td class="text-right">'+result.grandtotal+'</td>';
								item += '<td>IDR</td>';
							item += '</tr>';
						item += '</tbody>';
					item += '</table>';
					
					$('#div_ap_cost-'+idx).html(item);
					$('#div_ap_cost-'+idx).show();
				}
			});
		}else{
			$('#div_ap_cost-'+idx).html('');
		}
	}
</script>
