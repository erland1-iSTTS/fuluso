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

date_default_timezone_set('Asia/Jakarta');
?>

<div id="modal-cost-opr-create">
<?php $form = ActiveForm::begin(['id' => 'form_cost_opr', 'action' => Url::base().'/cost-other/save-cost-opr']); ?>
<input type="hidden" id="cost_id" value="" name="MasterNewJobcost[vch_id]">

	<?php
		Modal::begin([
			'title' => 'Create Cost Operational',
			'id' => 'modal_cost_opr',
			'size' => 'modal-xl',
		]);
	?>
		<div id="content">
			<div class="row form-group">
				<div class="col-6">
					<div class="row">
						<div class="col-2">
							<label class="fw-normal">Date</label>
						</div>
						<div class="col-7">
							<input type="date" class="form-control" id="vch_date_idr" value="<?= date('Y-m-d') ?>" name="MasterNewJobcost[vch_date]" required>
						</div>
					</div>
				</div>
				
				<div class="col-6">
					<div class="row">
						<div class="col-2">
							<label class="fw-normal">Due Date</label>
						</div>
						<div class="col-7">
							<input type="date" class="form-control" id="vch_due_date_idr" value="<?= date('Y-m-d') ?>" name="MasterNewJobcost[vch_due_date]" required>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<!-- Pay To -->
				<div class="col-6 mb-4">
					<div class="row">
						<div class="col-2">
							<label class="fw-normal">Pay To</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" id="vch_pay_to_idr" name="MasterNewJobcost[vch_pay_to]" required>
						</div>
					</div>
				</div>
				
				<!-- Office -->
				<div class="col-6">
					<div class="row">
						<div class="col-2">
							<label class="fw-normal">Office</label>
						</div>
						<div class="col-7">
							<select class="form-select form-select-lg" id="vch_pay_for_idr" name="MasterNewJobcost[office_id]" required>
								<option></option>
								<?php
									foreach($office as $row){
										$selected = '';
										
										echo "<option value='".$row['office_code']."' ".$selected.">".
											$row['office_name'].
										"</option>";
									}
								?>
							</select>
						</div>
					</div>
				</div>
				
				<br>
				
				<!-- Table Detail -->
				<div class="row" style="overflow-x:auto;">
					<div class="col-12">
						<table class="table" id="table_cost_opr">
							<thead>
								<tr>
									<td width="5%"></td>
									<td width="18%">Desc. of Charges</td>
									<td width="20%">Detail</td>
									<td width="9%">Jumlah</td>
									<td width="7%">Satuan</td>
									<td width="14%">Rate</td>
									<td width="12%">Amount</td>
									<td width="5%">Curr</td>
									<td width="10%">PPN</td>
									<td width="10%">PPH</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="text-center"></td>
									<td>
										<select class="form-select form-select-lg" id="cost_pos-1" name="MasterNewJobcostDetail[detail][1][vchd_pos]" required>
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
										<input type="text" class="form-control" id="cost_detail-1" value="" name="MasterNewJobcostDetail[detail][1][vchd_detail]">
									</td>
									<td>
										<input type="text" class="form-control cost_jumlah" id="cost_jumlah-1" value="" name="MasterNewJobcostDetail[detail][1][qty]" onkeyup="changeInputCost(this.id)" required>
									</td>
									<td>
										<select class="form-select form-select-lg" id="cost_jumlahpack-1" name="MasterNewJobcostDetail[detail][1][vchd_unit_type]" required>
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
												<input type="hidden" class="form-control cost_tarif" id="cost_tarif-1" value="" name="MasterNewJobcostDetail[detail][1][vchd_rate]">
												<input type="text" class="form-control cost_tarif1" id="cost_tarif1-1" value="" onkeyup="changeInputCost(this.id)" required>
											</div>
											<div class="col-5 pl-1 pt-2">
												<input type="text" class="form-control cost_tarif2" id="cost_tarif2-1" style="height:25px" value="00" onkeyup="changeInputCost(this.id)">
											</div>	
										</div>
									</td>
									<!-- Subtotal -->
									<td class="text-right">
										<label class="fw-normal mb-0" id="cost_label_subtotal-1">0.00</label>
										<input type="hidden" class="form-control cost_subtotal" id="cost_subtotal-1" value="" name="MasterNewJobcostDetail[detail][1][vchd_amount]">
									</td>
									<td>IDR</td>
									<td>
										<span><?= $ppn->name.'-'.$ppn->amount ?></span>
										<!-- <select class="form-select form-select-lg cost_ppntype" id="cost_ppntype-1" name="MasterNewJobcostDetail[detail][1][vchd_id_ppn]" onchange="getTotalCost()" required>
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
										</select> -->
										<input type="hidden" class="form-control cost_ppn" id="cost_ppn-1" value="<?= $ppn->id ?>" name="MasterNewJobcostDetail[detail][1][vchd_ppn]">
									</td>
									<td>
										<span><?= $pph->name.'-'.$pph->amount ?></span>
										<!-- <select class="form-select form-select-lg cost_ppntype" id="cost_ppntype-1" name="MasterNewJobcostDetail[detail][1][vchd_id_ppn]" onchange="getTotalCost()" required>
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
										</select> -->
										<input type="hidden" class="form-control cost_ppn" id="cost_pph-1" value="<?= $pph->id ?>" name="MasterNewJobcostDetail[detail][1][vchd_pph]">
									</td>
								</tr>
								
								<tr>
									<td colspan="2">
										<button type="button" class="btn btn-success" onclick="addrow_cost_opr()">
											<span class="fa fa-plus align-middle"></span> Tambah
										</button>
									</td>
									<td colspan="3"></td>
									<td>
										<p>Jumlah</p>
										<p class="mb-0">PPN</p>
									</td>
									<td class="text-right">
										<!-- Jumlah -->
										<p id="cost_label_total">0.00</p>
										<input type="hidden" class="form-control cost_total" id="cost_total" value="" name="MasterNewJobcost[vch_total]">
										
										<!-- PPN -->
										<p class="mb-0" id="cost_label_ppn">0.00</p>
										<input type="hidden" class="form-control cost_totalppn" id="cost_totalppn" value="" name="MasterNewJobcost[vch_total_ppn]">
									</td>
									<td>
										<p>IDR</p>
										<p class="mb-0">IDR</p>
									</td>
									<td></td>
								</tr>
								<!-- Grandtotal -->
								<tr>
									<td colspan="5"></td>
									<td>TOTAL</td>
									<td class="text-right">
										<p id="cost_label_grandtotal">0.00</p>
										<input type="hidden" class="form-control cost_grandtotal" id="cost_grandtotal" value="" name="MasterNewJobcost[vch_grandtotal]">
									</td>
									<td>IDR</td>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
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
<?php ActiveForm::end(); ?>
</div>

<script>
	$(document).ready(function(){
	});
	
	function addrow_cost_opr(){
		id = $('#table_cost_opr tbody tr').length-2;
		
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
				item += '<select class="form-select form-select-lg" id="cost_pos-'+i+'" name="MasterNewJobcostDetail[detail]['+i+'][vchd_pos]" required>';
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
				item += '<input type="text" class="form-control" id="cost_detail-'+i+'" value="" name="MasterNewJobcostDetail[detail]['+i+'][vchd_detail]">';
			item += '</td>';
			
			item += '<td>';
				item += '<input type="text" class="form-control cost_jumlah" id="cost_jumlah-'+i+'" value="" name="MasterNewJobcostDetail[detail]['+i+'][qty]" onkeyup="changeInputCost(this.id)" required>';
			item += '</td>';
			item += '<td>';
				item += '<select class="form-select form-select-lg" id="cost_jumlahpack-'+i+'" name="MasterNewJobcostDetail[detail]['+i+'][vchd_unit_type]" required>';
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
						item += '<input type="hidden" class="form-control cost_tarif" id="cost_tarif-'+i+'" value="" name="MasterNewJobcostDetail[detail]['+i+'][vchd_rate]">';
						item += '<input type="text" class="form-control cost_tarif1" id="cost_tarif1-'+i+'" value="" onkeyup="changeInputCost(this.id)" required>';
					item += '</div>';
					item += '<div class="col-5 pl-1 pt-2">';
						item += '<input type="text" class="form-control cost_tarif2" id="cost_tarif2-'+i+'" style="height:25px" value="00" onkeyup="changeInputCost(this.id)">';
					item += '</div>';	
				item += '</div>';
			item += '</td>';
			
			item += '<td class="text-right">';
				item += '<label class="fw-normal mb-0" id="cost_label_subtotal-'+i+'">0.00</label>';
				item += '<input type="hidden" class="form-control cost_subtotal" id="cost_subtotal-'+i+'" value="" name="MasterNewJobcostDetail[detail]['+i+'][vchd_amount]">';
			item += '</td>';
			item += '<td>IDR</td>';
			
			item += '<td>';
				// item += '<select class="form-select form-select-lg cost_ppntype" id="cost_ppntype-'+i+'" name="MasterNewJobcostDetail[detail]['+i+'][vchd_id_ppn]" onchange="getTotalCost()" required>';
				// 	item += '<option value="0"></option>';
					item += <?= $ppn->name.'-'.$ppn->amount.'%' ?> + "<?php
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
				item += '<input type="hidden" class="form-control cost_ppn" id="cost_ppn-'+i+'" value="<?= $ppn->id ?>" name="MasterNewJobcostDetail[detail]['+i+'][vchd_ppn]">';
			item += '</td>';
			item += '<td>';
				// item += '<select class="form-select form-select-lg cost_ppntype" id="cost_ppntype-'+i+'" name="MasterNewJobcostDetail[detail]['+i+'][vchd_id_ppn]" onchange="getTotalCost()" required>';
				// 	item += '<option value="0"></option>';
					item += <?= $pph->name.'-'.$pph->amount.'%' ?> + "<?php
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
				item += '<input type="hidden" class="form-control cost_ppn" id="cost_pph-'+i+'" value="<?= $pph->id ?>" name="MasterNewJobcostDetail[detail]['+i+'][vchd_pph]">';
			item += '</td>';
		item += '</tr>';
		
		tr = $('#table_cost_opr tbody tr').length-3;
	
		$('#table_cost_opr tbody tr:eq('+tr+')').after(item);
		
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
		
			getTotalCost();
		}
	}
	
	function changeInputCost(id){
		idx = id.split('-')[1];
		
		jumlah 	= $('#cost_jumlah-'+idx).val();
		tarif1 	= $('#cost_tarif1-'+idx).val();
		tarif2 	= $('#cost_tarif2-'+idx).val();
		ppntype	= $('#cost_ppntype-'+idx+' option:selected').html();
		
		tarif = parseFloat(tarif1+'.'+tarif2);
		
		if(ppntype){
			ppn = parseFloat(ppntype.split('-')[1].replace('%',''));
		}else{
			ppn = 0;
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
		
		subtotal = jumlah * tarif;
		
		if(ppn !== 0){
			totalppn = Math.floor(parseFloat(subtotal) * parseFloat(ppn) / 100);
		}else{
			totalppn = 0;
		}
		
		$('#cost_label_subtotal-'+idx).html(addSeparator(subtotal.toFixed(2)));
		$('#cost_subtotal-'+idx).val(subtotal);
		$('#cost_ppn-'+idx).val(totalppn);
		
		getTotalCost();
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
	
	function getTotalCost(){
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
		
		$('#cost_label_total').html(addSeparator(total.toFixed(2)));
		$('#cost_total').val(total);
		
		$('#cost_label_ppn').html(addSeparator(total_ppn.toFixed(2)));
		$('#cost_totalppn').val(total_ppn);

		$('#cost_label_grandtotal').html(addSeparator(grandtotal.toFixed(2)));
		$('#cost_grandtotal').val(grandtotal);
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
