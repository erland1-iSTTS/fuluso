<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use yii\widgets\ActiveForm;

use app\models\Customer;
use app\models\CustomerAlias;

use app\models\PosV8;
use app\models\Packages;
use app\models\Currency;
use app\models\Movement;
use app\models\Signature;
use app\models\Office;
use app\models\JobParty;

use app\models\PpnDetail;
use app\models\PphDetail;
use app\models\MasterNewJobinvoice;
use app\models\MasterNewJobcost;

use yii\helpers\VarDumper;


$customer 	= Customer::find()->where(['is_active'=>1])->orderBy(['customer_companyname'=>SORT_ASC])->all();
$pos 		= PosV8::find()->where(['is_active'=>1])->orderby(['pos_name'=>SORT_ASC])->all();
$packages 	= Packages::find()->orderby(['packages_name'=>SORT_ASC])->all();
$currency 	= Currency::find()->orderby(['currency_id'=>SORT_ASC])->all();
$movement 	= Movement::find()->orderby(['movement_name'=>SORT_ASC])->all();
$signature	= Signature::find()->where(['is_active'=>1])->orderby(['signature_name'=>SORT_ASC])->all();
$office 	= Office::find()->all();
$ppn		= PpnDetail::find()->where(['>=' , 'validity' , date('Y-m-d')])->one();
$pph		= PphDetail::find()->where(['>=' , 'validity' , date('Y-m-d')])->one();

// Input Customer dr Job Party
// $job_party = JobParty::find()->where(['id_job' => $_GET['id'],'is_active' => 1])->one();

// if(isset($job_party)){
	// $data_customer = Customer::find()->where(['customer_id' => $job_party->customer, 'is_active'=>1])->one();
	// $data_customer_alias = CustomerAlias::find()->where(['customer_alias_id' => $job_party->customer_alias, 'is_active'=>1])->one();
	
	// $nama_customer = $data_customer->customer_companyname;
	// $id_customer = $data_customer->customer_id;
	// $customer_alias = $data_customer_alias->customer_name;
	// $id_customer_alias = $data_customer_alias->customer_alias_id;
// }else{
	// $nama_customer = '';
	// $id_customer = '';
	// $customer_alias = '';
	// $id_customer_alias = '';
// }

if($ppn == null || empty($ppn)){
	echo "<script>alert('Tidak ada PPN yang valid')</script>";
}

date_default_timezone_set('Asia/Jakarta');
?>

<div id="modal-cost-hmc-create">
<?php $form = ActiveForm::begin(['id' => 'form_cost_hmc', 'action' => Url::base().'/job/save-cost-hmc']); ?>
<!--<input type="hidden" value="<?php //$_GET['id']?>" name="MasterNewJobcost[vch_job_id]">
<input type="hidden" id="cost_id_hmc" value="" name="MasterNewJobcost[vch_id]">-->

	<?php
		Modal::begin([
			'title' => 'Create New Cost Operational & Misc',
			'id' => 'modal_create_misc',
			'size' => 'modal-xl',
		]);
	?>
		<div id="content">
			<div class="row form-group">
				<div class="col-1">
					<label class="fw-normal">User</label>
				</div>
				<div class="col-3">
					Desy (Surabaya)
				</div>
			</div>
			
			<div class="row form-group">
				<div class="col-1">
					<label class="fw-normal">Date</label>
				</div>
				<div class="col-3">
					1 Agustus 2023
				</div>
				<div class="col-1"></div>
				<div class="col-3">Payee</div>
			</div>
			
			<div class="row form-group">
				<div class="col-1">
					<label class="fw-normal">Pos</label>
				</div>
				<div class="col-3">
					<select class="form-select form-select-lg" id="cost_pos_hmc-1" name="MasterNewJobcostDetail[detail][1][vchd_pos]" required>
						<option value="" disabled hidden></option>
						<?php
							foreach($pos as $row){
								$selected = '';

								echo "<option value='".$row['pos_id']."' ".$selected.">".
									$row['pos_name'].
								"</option>";
							}
						?>
					</select>
				</div>
				<div class="col-1"></div>
				<div class="col-3">
					<select class="form-select form-select-lg">
						<option>ALLIED INTERNATIONAL (ANA SALEH)</option>
					</select>
				</div>
			</div>
			
			<div class="row form-group">
				<div class="col-1">
					<label class="fw-normal">Description</label>
				</div>
				<div class="col-3">
					<input type="text" class="form-control" value="SOLAR INNOVA"></input>
				</div>
				<div class="col-1"></div>
				<div class="col-3">
					<select class="form-select form-select-lg">
						<option>UASDLLJEDC</option>
					</select>
				</div>
			</div>
			
			<div class="row form-group">
				<div class="col-1">
					<label class="fw-normal">DPP</label>
				</div>
				<div class="col-3">
					<input type="text" class="form-control" value="1,000,000"></input>
				</div>
				<div class="col-1"></div>
				<div class="col-3">
					<input type="text" class="form-control" readonly value="ADDRESS"></input>
				</div>
			</div>
			
			<div class="row form-group">
				<div class="col-1">
					<label class="fw-normal">PPN</label>
				</div>
				<div class="col-3">
					<select class="form-select form-select-lg">
						<option>050-1.1%</option>
					</select>
				</div>
			</div>
			
			<div class="row form-group">
				<div class="col-1">
					<label class="fw-normal">Netto</label>
				</div>
				<div class="col-3">
					1,110,000
				</div>
			</div>
			
			<div class="row form-group">
				<div class="col-1">
					<label class="fw-normal">Attachment</label>
				</div>
				<div class="col-3">
					<button type="button" class="btn btn-dark">Upload File</button>
				</div>
			</div>
			<!--<div class="row">
				<div class="col-6 mb-4">
					<div class="row">
						<div class="col-2">
							<label class="fw-normal">Pay For</label>
						</div>
						<div class="col-7">
							<select class="form-select form-select-lg" id="vch_pay_for_hmc" name="MasterNewJobcost[vch_pay_for]" required>
								<option></option>
								<?php
									foreach($customer as $row){
										$selected = '';
										
										echo "<option value='".$row['customer_id']."' ".$selected.">".
											$row['customer_companyname'].
										"</option>";
									}
								?>
							</select>
						</div>
					</div>
				</div>
				
				<div class="col-6">
					<div class="row">
						<div class="col-2">
							<label class="fw-normal">Pay To</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" id="vch_pay_to_hmc" name="MasterNewJobcost[vch_pay_to]" required>
						</div>
					</div>
				</div>
				<br>
				
				<div class="row">
					<div class="col-12">
						<table class="table" id="table_cost_hmc">
							<thead>
								<tr>
									<td width="5%"></td>
									<td width="15%">Desc. of Charges</td>
									<td width="15%">Detail</td>
									<td width="13%">Basis</td>
									<td width="7%">Jumlah</td>
									<td width="7%">Satuan</td>
									<td width="14%">Rate</td>
									<td width="9%">Amount</td>
									<td width="5%">Curr</td>
									<td width="10%">PPN</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="text-center"></td>
									<td>
										<select class="form-select form-select-lg" id="cost_pos_hmc-1" name="MasterNewJobcostDetail[detail][1][vchd_pos]" required>
											<option value="" disabled hidden></option>
											<?php
												foreach($pos as $row){
													$selected = '';

													echo "<option value='".$row['pos_id']."' ".$selected.">".
														$row['pos_name'].
													"</option>";
												}
											?>
										</select>
									</td>
									<td>
										<input type="text" class="form-control" id="cost_detail_hmc-1" value="" name="MasterNewJobcostDetail[detail][1][vchd_detail]">
									</td>
									<td>
										<div class="row">
											<div class="col-6 pr-1">
												<input type="text" class="form-control cost_basis" id="cost_basis_hmc-1" value="" name="MasterNewJobcostDetail[detail][1][vchd_basis1_total]" onkeyup="changeInputCostHmc(this.id)" required>
											</div>
											<div class="col-6 pl-1">
												<select class="form-select form-select-lg" id="cost_basispack_hmc-1" name="MasterNewJobcostDetail[detail][1][vchd_basis1_type]" required>
													<?php
														foreach($packages as $row){
															$name = str_replace("'", "&apos;", $row['packages_name']);
															
															$selected = '';

															echo "<option value='".$name."' ".$selected.">".
																$row['packages_name'].
															"</option>";
														}
													?>
												</select>
											</div>
										</div>
									</td>
									<td>
										<input type="text" class="form-control cost_jumlah" id="cost_jumlah_hmc-1" value="" name="MasterNewJobcostDetail[detail][1][vchd_basis2_total]" onkeyup="changeInputCostHmc(this.id)" required>
									</td>
									<td>
										<select class="form-select form-select-lg" id="cost_jumlahpack_hmc-1" name="MasterNewJobcostDetail[detail][1][vchd_basis2_type]" required>
											<?php
												foreach($packages as $row){
													$name = str_replace("'", "&apos;", $row['packages_name']);
													
													$selected = '';

													echo "<option value='".$name."' ".$selected.">".
														$row['packages_name'].
													"</option>";
												}
											?>
										</select>
									</td>
									<td>
										<div class="row">
											<div class="col-7 pr-1">
												<input type="hidden" class="form-control cost_tarif" id="cost_tarif_hmc-1" value="" name="MasterNewJobcostDetail[detail][1][vchd_rate]">
												<input type="text" class="form-control cost_tarif1" id="cost_tarif1_hmc-1" value="" onkeyup="changeInputCostHmc(this.id)" required>
											</div>
											<div class="col-5 pl-1 pt-2">
												<input type="text" class="form-control cost_tarif2" id="cost_tarif2_hmc-1" style="height:25px" value="00" onkeyup="changeInputCostHmc(this.id)">
											</div>	
										</div>
									</td>
									
									<td class="text-right">
										<label class="fw-normal mb-0" id="cost_label_subtotal_hmc-1">0.00</label>
										<input type="hidden" class="form-control cost_subtotal" id="cost_subtotal_hmc-1" value="" name="MasterNewJobcostDetail[detail][1][vchd_amount]">
									</td>
									<td>USD</td>
									<td>
										<select class="form-select form-select-lg cost_ppntype" id="cost_ppntype_hmc-1" name="MasterNewJobcostDetail[detail][1][vchd_id_ppn]" onchange="getTotalCostHmc()" required>
											<option value="0"></option>
											<?php
												// foreach($ppn as $row){
												// 	$name = explode('-', $row['name']);
												// 	$name_ppn = $name[1].'-'.$row['amount'].'%';
													
												// 	$selected = '';
													
												// 	echo "<option value='".$row['id']."' ".$selected.">".
												// 		$name_ppn.
												// 	"</option>";
												// }
											?>
										</select>
										<input type="hidden" class="form-control cost_ppn" id="cost_ppn_hmc-1" value="" name="MasterNewJobcostDetail[detail][1][vchd_ppn]">
									</td>
								</tr>
								
								<tr>
									<td colspan="2">
										<button type="button" class="btn btn-success" onclick="addrow_cost_hmc()">
											<span class="fa fa-plus align-middle"></span> Tambah
										</button>
									</td>
									<td colspan="4"></td>
									<td>
										<p>Jumlah</p>
										<p class="mb-0">PPN</p>
									</td>
									<td class="text-right">
										<p id="cost_label_total_hmc">0.00</p>
										<input type="hidden" class="form-control cost_total" id="cost_total_hmc" value="" name="MasterNewJobcost[vch_total]">
										
										<p class="mb-0" id="cost_label_ppn">0.00</p>
										<input type="hidden" class="form-control cost_totalppn" id="cost_totalppn_hmc" value="" name="MasterNewJobcost[vch_total_ppn]">
									</td>
									<td>
										<p>USD</p>
										<p class="mb-0">USD</p>
									</td>
									<td></td>
								</tr>
								
								<tr>
									<td colspan="6"></td>
									<td>TOTAL</td>
									<td class="text-right">
										<p id="cost_label_grandtotal_hmc">0.00</p>
										<input type="hidden" class="form-control cost_grandtotal" id="cost_grandtotal_hmc" value="" name="MasterNewJobcost[vch_grandtotal]">
									</td>
									<td>USD</td>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>-->
			</div>
			<hr>
			
			<div class="row form-group" style="float:right">
				<div class="col-12">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-dark">Save</button>
				</div>
			</div>
		</div>
	<?php Modal::end(); ?>
	
	<?php
		Modal::begin([
			'title' => 'Create AP Cost Operational & Misc',
			'id' => 'modal_create_apmisc',
			'size' => 'modal-xl',
		]);
	?>
		<div id="content">
			<div id="" style="border:1px solid gray;padding:10px">
				<div class="row form-group">
					<div class="col-1">
						<label class="fw-normal">User</label>
					</div>
					<div class="col-3">
						Desy (Surabaya)
					</div>
				</div>
				
				<div class="row form-group">
					<div class="col-1">
						<label class="fw-normal">Date</label>
					</div>
					<div class="col-3">
						1 Agustus 2023
					</div>
					<div class="col-1"></div>
					<div class="col-3">Payee</div>
				</div>
				
				<div class="row form-group">
					<div class="col-1">
						<label class="fw-normal">Pos</label>
					</div>
					<div class="col-3">
						<select class="form-select form-select-lg" id="cost_pos_hmc-1" name="MasterNewJobcostDetail[detail][1][vchd_pos]" required>
							<option value="" disabled hidden></option>
							<?php
								foreach($pos as $row){
									$selected = '';

									echo "<option value='".$row['pos_id']."' ".$selected.">".
										$row['pos_name'].
									"</option>";
								}
							?>
						</select>
					</div>
					<div class="col-1"></div>
					<div class="col-3">
						<select class="form-select form-select-lg">
							<option>ALLIED INTERNATIONAL (ANA SALEH)</option>
						</select>
					</div>
				</div>
				
				<div class="row form-group">
					<div class="col-1">
						<label class="fw-normal">Description</label>
					</div>
					<div class="col-3">
						<input type="text" class="form-control" value="SOLAR INNOVA"></input>
					</div>
					<div class="col-1"></div>
					<div class="col-3">
						<select class="form-select form-select-lg">
							<option>UASDLLJEDC</option>
						</select>
					</div>
				</div>
				
				<div class="row form-group">
					<div class="col-1">
						<label class="fw-normal">DPP</label>
					</div>
					<div class="col-3">
						<input type="text" class="form-control" value="1,000,000"></input>
					</div>
					<div class="col-1"></div>
					<div class="col-3">
						<input type="text" class="form-control" readonly value="ADDRESS"></input>
					</div>
				</div>
				
				<div class="row form-group">
					<div class="col-1">
						<label class="fw-normal">PPN</label>
					</div>
					<div class="col-3">
						<select class="form-select form-select-lg">
							<option>050-1.1%</option>
						</select>
					</div>
				</div>
				
				<div class="row form-group">
					<div class="col-1">
						<label class="fw-normal">Netto</label>
					</div>
					<div class="col-3">
						1,110,000
					</div>
				</div>
				
				<div class="row form-group">
					<div class="col-1">
						<label class="fw-normal">Attachment</label>
					</div>
					<div class="col-3">
						<button type="button" class="btn btn-dark">Upload File</button>
					</div>
				</div>
			</div>
		</div>
		<br>
		<div id="" class="form-group" style="border:1px solid gray;padding:10px">
			<div class="row">
				<div class="col-12">
					Payment
				</div>
			</div>
			
			<div class="row">
				<div class="col-12">
					AP-B-20230202 &emsp;&emsp; 2 Feb 2023 &emsp;&emsp; 800.000 &emsp;&emsp; Bank &emsp; OCBC
				</div>
			</div>
		</div>
		
		Outstanding Payment : <span style="color:red">600.000</span>
		<br>
		<div class="row">
			<div class="col-1">
				Type
			</div>
			<div class="col-3">
				<div class="form-check form-check-inline">
					<input type="radio" class="form-check-input" id="pos-type1" name="pos-type" value="1" checked>
					<label class="form-check-label" for="pos-type1">Operational</label>
					&emsp;&nbsp;&nbsp;
					<input type="radio" class="form-check-input" id="pos-type2" name="pos-type" value="2">
					<label class="form-check-label" for="pos-type2">Misc</label>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-1">
				Source
			</div>
			<div class="col-3">
				<div class="form-check form-check-inline">
					<input type="radio" class="form-check-input" id="pos-type1" name="pos-type" value="1" checked>
					<label class="form-check-label" for="pos-type1">Cash</label>
					&emsp;&nbsp;&nbsp;
					<input type="radio" class="form-check-input" id="pos-type2" name="pos-type" value="2">
					<label class="form-check-label" for="pos-type2">Bank</label>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-1">
				Amount
			</div>
			<div class="col-3">
				<input type="text" class="form-control"></input>
			</div>
			IDR
		</div>
		
		<div class="row form-group" style="float:right">
				<div class="col-12">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-dark">Save</button>
				</div>
			</div>
	<?php Modal::end(); ?>
	
	
<?php ActiveForm::end(); ?>
</div>

<script>
	$(document).ready(function(){
	});
	
	function addrow_cost_hmc(){
		id = $('#table_cost_hmc tbody tr').length-2;
		
		if(id){
            i = id+1;
        }else{
            i = 1;
		}

		item = '';
		item += '<tr>';
			item += '<td class="text-center">';
				item += '<button class="btn btn-xs btn-danger" style="padding: 0px 5px" onclick="delrow_cost($(this))">';
					item += '<span class="fa fa-trash align-middle"></span>';
				item += '</button>';
			item += '</td>';
			item += '<td>';
				item += '<select class="form-select form-select-lg" id="cost_pos_hmc-'+i+'" name="MasterNewJobcostDetail[detail]['+i+'][vchd_pos]" required>';
					item += '<option value="" disabled selected hidden></option>';
					item += "<?php
						foreach($pos as $row){
							$selected = '';

							echo "<option value='".$row['pos_id']."' ".$selected.">".
								$row['pos_name'].
							"</option>";
						}
					?>";
				item += '</select>';
			item += '</td>';
			item += '<td>';
				item += '<input type="text" class="form-control" id="cost_detail_hmc-'+i+'" value="" name="MasterNewJobcostDetail[detail]['+i+'][vchd_detail]">';
			item += '</td>';
			item += '<td>';
				item += '<div class="row">';
					item += '<div class="col-6 pr-1">';
						item += '<input type="text" class="form-control cost_basis" id="cost_basis_hmc-'+i+'" value="" name="MasterNewJobcostDetail[detail]['+i+'][vchd_basis1_total]" onkeyup="changeInputCostHmc(this.id)" required>';
					item += '</div>';
					item += '<div class="col-6 pl-1">';
						item += '<select class="form-select form-select-lg" id="cost_basispack_hmc-'+i+'" name="MasterNewJobcostDetail[detail]['+i+'][vchd_basis1_type]" required>';
							item += "<?php
								foreach($packages as $row){
									$name = str_replace("'", "&apos;", $row['packages_name']);
									
									$selected = '';

									echo "<option value='".$name."' ".$selected.">".
										$row['packages_name'].
									"</option>";
								}
							?>";
						item += '</select>';
					item += '</div>';
				item += '</div>';
			item += '</td>';

			item += '<td>';
				item += '<input type="text" class="form-control cost_jumlah" id="cost_jumlah_hmc-'+i+'" value="" name="MasterNewJobcostDetail[detail]['+i+'][vchd_basis2_total]" onkeyup="changeInputCostHmc(this.id)" required>';
			item += '</td>';
			item += '<td>';
				item += '<select class="form-select form-select-lg" id="cost_jumlahpack_hmc-'+i+'" name="MasterNewJobcostDetail[detail]['+i+'][vchd_basis2_type]" required>';
					item += "<?php
						foreach($packages as $row){
							$name = str_replace("'", "&apos;", $row['packages_name']);
							
							$selected = '';

							echo "<option value='".$name."' ".$selected.">".
								$row['packages_name'].
							"</option>";
						}
					?>";
				item += '</select>';
			item += '</td>';
			item += '<td>';
				item += '<div class="row">';
					item += '<div class="col-7 pr-1">';
						item += '<input type="hidden" class="form-control cost_tarif" id="cost_tarif_hmc-'+i+'" value="" name="MasterNewJobcostDetail[detail]['+i+'][vchd_rate]">';
						item += '<input type="text" class="form-control cost_tarif1" id="cost_tarif1_hmc-'+i+'" value="" onkeyup="changeInputCostHmc(this.id)" required>';
					item += '</div>';
					item += '<div class="col-5 pl-1 pt-2">';
						item += '<input type="text" class="form-control cost_tarif2" id="cost_tarif2_hmc-'+i+'" style="height:25px" value="00" onkeyup="changeInputCostHmc(this.id)">';
					item += '</div>';	
				item += '</div>';
			item += '</td>';
			
			item += '<td class="text-right">';
				item += '<label class="fw-normal mb-0" id="cost_label_subtotal_hmc-'+i+'">0.00</label>';
				item += '<input type="hidden" class="form-control cost_subtotal" id="cost_subtotal_hmc-'+i+'" value="" name="MasterNewJobcostDetail[detail]['+i+'][vchd_amount]">';
			item += '</td>';
			item += '<td>USD</td>';
			
			item += '<td>';
				// item += '<select class="form-select form-select-lg cost_ppntype" id="cost_ppntype_hmc-'+i+'" name="MasterNewJobcostDetail[detail]['+i+'][vchd_id_ppn]" onchange="getTotalCostHmc()" required>';
				// 	item += '<option value="0"></option>';
					item += <?= ($ppn->name) != null ? $ppn->name : '' ?> + "-" + <?= ($ppn->amount) != null ? $ppn->amount : '' ?> + "<?php
						// foreach($ppn as $row){
						// 	$name = explode('-', $row['name']);
						// 	$name_ppn = $name[1].'-'.$row['amount'].'%';
							
						// 	$selected = '';
							
						// 	echo "<option value='".$row['id']."' ".$selected.">".
						// 		$name_ppn.
						// 	"</option>";
						// }
					?>";
				// item += '</select>';
				item += '<input type="hidden" class="form-control cost_ppn" id="cost_ppn_hmc-'+i+'" value="<?= ($ppn->id) != null ? $ppn->id : '' ?>" name="MasterNewJobcostDetail[detail]['+i+'][vchd_ppn]">';
			item += '</td>';
			item += '<td>';
				// item += '<select class="form-select form-select-lg cost_ppntype" id="cost_ppntype_hmc-'+i+'" name="MasterNewJobcostDetail[detail]['+i+'][vchd_id_ppn]" onchange="getTotalCostHmc()" required>';
				// 	item += '<option value="0"></option>';
					item += <?= ($pph->name) != null ? $pph->name : '' ?> + "-" + <?= ($pph->amount) != null ? $pph->amount : '' ?> + "<?php
						// foreach($ppn as $row){
						// 	$name = explode('-', $row['name']);
						// 	$name_ppn = $name[1].'-'.$row['amount'].'%';
							
						// 	$selected = '';
							
						// 	echo "<option value='".$row['id']."' ".$selected.">".
						// 		$name_ppn.
						// 	"</option>";
						// }
					?>";
				// item += '</select>';
				item += '<input type="hidden" class="form-control cost_ppn" id="cost_pph_hmc-'+i+'" value="<?= ($pph->id) != null ? $pph->id : '' ?>" name="MasterNewJobcostDetail[detail]['+i+'][vchd_pph]">';
			item += '</td>';
		item += '</tr>';
		
		tr = $('#table_cost_hmc tbody tr').length-3;
	
		$('#table_cost_hmc tbody tr:eq('+tr+')').after(item);
		
		// Gabungan Tarif
		$('.cost_tarif1, .cost_tarif2').on('keyup', function(){
			$('.cost_tarif').each(function(i){
				input_tarif1 = Number($('.cost_tarif1').eq(i).val());
				input_tarif2 = $('.cost_tarif2').eq(i).val();
				
				if(input_tarif1 == ''){
					input_tarif1 = 0;
				}
				if(input_tarif2 == ''){
					input_tarif2 = '00';
				}
				
				tarif = input_tarif1+'.'+input_tarif2;
				
				$('.cost_tarif').eq(i).val(tarif);
			});
		});
	}
	
	function delrow_cost(el){
		if(confirm('Apakah anda yakin ingin menghapus data ini?')){
			el.parent().parent().remove();
		
			getTotalCostHmc();
		}
	}
	
	function changeInputCostHmc(id){
		idx = id.split('-')[1];
		
		basis 	= $('#cost_basis_hmc-'+idx).val();
		jumlah 	= $('#cost_jumlah_hmc-'+idx).val();
		tarif1 	= $('#cost_tarif1_hmc-'+idx).val();
		tarif2 	= $('#cost_tarif2_hmc-'+idx).val();
		ppntype	= $('#cost_ppntype_hmc-'+idx+' option:selected').html();
		
		tarif = parseFloat(tarif1+'.'+tarif2);
		
		if(ppntype){
			ppn = parseFloat(ppntype.split('-')[1].replace('%',''));
		}else{
			ppn = 0;
		}
		
		if(!basis){
			basis = 0
		}
		if(!jumlah){
			jumlah = 0
		}
		if(!tarif){
			tarif = 0
		}
		if(!ppn){
			ppn = 0
		}
		
		subtotal = basis * jumlah * tarif;
		
		if(ppn !== 0){
			totalppn = Math.floor(parseFloat(subtotal) * parseFloat(ppn) / 100);
		}else{
			totalppn = 0;
		}
		
		$('#cost_label_subtotal_hmc-'+idx).html(addSeparator(subtotal.toFixed(2)));
		$('#cost_subtotal_hmc-'+idx).val(subtotal);
		$('#cost_ppn_hmc-'+idx).val(totalppn);
		
		getTotalCostHmc();
	}
	
	// Gabungan Tarif
	$('.cost_tarif1, .cost_tarif2').on('keyup', function(){
		$('.cost_tarif').each(function(i){
			input_tarif1 = Number($('.cost_tarif1').eq(i).val());
			input_tarif2 = $('.cost_tarif2').eq(i).val();
			
			if(input_tarif1 == ''){
				input_tarif1 = 0;
			}
			if(input_tarif2 == ''){
				input_tarif2 = '00';
			}
			
			tarif = input_tarif1+'.'+input_tarif2;
			
			$('.cost_tarif').eq(i).val(tarif);
		});
	});
	
	function getTotalCostHmc(){
		total = 0;
		total_ppn = 0;
		
        $('.cost_subtotal').each(function(index) {
			if($(this).val() == ''){
				subtotal = 0;
			}else{
				subtotal = $(this).val();
			}
			
			ppntype	= $('.cost_ppntype:eq('+index+') option:selected').html();
			if(ppntype){
				ppn = parseFloat(ppntype.split('-')[1].replace('%',''));
			}else{
				ppn = 0;
			}
			
			total += parseFloat(subtotal);
			total_ppn += Math.floor(parseFloat(subtotal) * parseFloat(ppn) / 100);
        });
		
		grandtotal = total + total_ppn;
		
		$('#cost_label_total_hmc').html(addSeparator(total.toFixed(2)));
		$('#cost_total_hmc').val(total);
		
		$('#cost_label_ppn_hmc').html(addSeparator(total_ppn.toFixed(2)));
		$('#cost_totalppn_hmc').val(total_ppn);

		$('#cost_label_grandtotal_hmc').html(addSeparator(grandtotal.toFixed(2)));
		$('#cost_grandtotal_hmc').val(grandtotal);
	}
	
	//Thousand Separator
	function Separator(id){
		$('#'+id).keyup(function(event)
		{
			if(event.which >= 37 && event.which <= 40) return;
			
			$(this).val(function(index, value){
				return value
					// Keep only digits, decimal points, and dashes at the start of the string:
					.replace(/[^\d.-]|(?!^)-/g, "")
					// Remove duplicated decimal points, if they exist:
					.replace(/^([^.]*\.)(.*$)/, (_, g1, g2) => g1 + g2.replace(/\./g, ''))
					// Keep only two digits past the decimal point:
					.replace(/\.(\d{2})\d+/, '.$1')
					// Add thousands separators:
					.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
			});
		});
	}
	
	function clearSeparator(val){
		return val.replace(/[^\d.-]|(?!^)-/g, "");
	}
	
	function addSeparator(nStr){
		nStr += '';
		var x = nStr.split('.');
		var x1 = x[0];
		var x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
		}
		return x1 + x2;
	}
</script>
