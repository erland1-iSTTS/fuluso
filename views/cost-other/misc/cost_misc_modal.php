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
<?php $form = ActiveForm::begin(['id' => 'form_cost_misc', 'action' => Url::base().'/cost-other/save-cost-misc']); ?>
<input type="hidden" id="cost_id" value="" name="MasterNewCostmisc[vch_id]">

	<?php
		Modal::begin([
			'title' => 'Create Cost Misc',
			'id' => 'modal_cost_misc',
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
							<input type="date" class="form-control" id="vch_date_misc" value="<?= date('Y-m-d') ?>" name="MasterNewCostmisc[vch_date]" required>
						</div>
					</div>
				</div>
				
				<div class="col-6">
					<div class="row">
						<div class="col-2">
							<label class="fw-normal">Due Date</label>
						</div>
						<div class="col-7">
							<input type="date" class="form-control" id="vch_due_date_misc" value="<?= date('Y-m-d') ?>" name="MasterNewCostmisc[vch_due_date]" required>
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
							<input type="text" class="form-control" id="vch_pay_to_misc" name="MasterNewCostmisc[vch_pay_to]" required>
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
							<select class="form-select form-select-lg" id="vch_pay_for_misc" name="MasterNewCostmisc[office_id]" required>
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
						<table class="table" id="table_cost_misc">
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
										<select class="form-select form-select-lg" id="cost_pos_misc-1" name="MasterNewCostmiscDetail[detail][1][vchd_pos]" required>
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
										<input type="text" class="form-control" id="cost_detail_misc-1" value="" name="MasterNewCostmiscDetail[detail][1][vchd_detail]">
									</td>
									<td>
										<input type="text" class="form-control cost_jumlah" id="cost_jumlah_misc-1" value="" name="MasterNewCostmiscDetail[detail][1][qty]" onkeyup="changeInputCost_misc(this.id)" required>
									</td>
									<td>
										<select class="form-select form-select-lg" id="cost_jumlahpack_misc-1" name="MasterNewCostmiscDetail[detail][1][vchd_unit_type]" required>
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
												<input type="hidden" class="form-control cost_tarif_misc" id="cost_tarif_misc-1" value="" name="MasterNewCostmiscDetail[detail][1][vchd_rate]">
												<input type="text" class="form-control cost_tarif1_misc" id="cost_tarif1_misc-1" value="" onkeyup="changeInputCost_misc(this.id)" required>
											</div>
											<div class="col-5 pl-1 pt-2">
												<input type="text" class="form-control cost_tarif2_misc" id="cost_tarif2_misc-1" style="height:25px" value="00" onkeyup="changeInputCost_misc(this.id)">
											</div>	
										</div>
									</td>
									<!-- Subtotal -->
									<td class="text-right">
										<label class="fw-normal mb-0" id="cost_label_subtotal_misc-1">0.00</label>
										<input type="hidden" class="form-control cost_subtotal_misc" id="cost_subtotal_misc-1" value="" name="MasterNewCostmiscDetail[detail][1][vchd_amount]">
									</td>
									<td>IDR</td>
									<td>
										<span><?= $ppn->name.'-'.$ppn->amount.' %' ?></span>
										<!-- <select class="form-select form-select-lg cost_ppntype_misc" id="cost_ppntype_misc-1" name="MasterNewCostmiscDetail[detail][1][vchd_id_ppn]" onchange="getTotalCost_misc()" required>
											<option value="0"></option> -->
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
										<!-- </select> -->
										<input type="hidden" class="form-control cost_ppn_misc" id="cost_ppn_misc-1" value="<?= $ppn->id ?>" name="MasterNewCostmiscDetail[detail][1][vchd_ppn]">
									</td>
									<td>
										<span><?= $pph->name.'-'.$pph->amount.' %' ?></span>
										<!-- <select class="form-select form-select-lg cost_ppntype_misc" id="cost_ppntype_misc-1" name="MasterNewCostmiscDetail[detail][1][vchd_id_ppn]" onchange="getTotalCost_misc()" required>
											<option value="0"></option> -->
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
										<!-- </select> -->
										<input type="hidden" class="form-control cost_pph_misc" id="cost_pph_misc-1" value="<?= $pph->id ?>" name="MasterNewCostmiscDetail[detail][1][vchd_pph]">
									</td>
								</tr>
								
								<tr>
									<td colspan="2">
										<button type="button" class="btn btn-success" onclick="addrow_cost_misc()">
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
										<p id="cost_label_total_misc">0.00</p>
										<input type="hidden" class="form-control cost_total_misc" id="cost_total_misc" value="" name="MasterNewCostmisc[vch_total]">
										
										<!-- PPN -->
										<p class="mb-0" id="cost_label_ppn_misc">0.00</p>
										<input type="hidden" class="form-control cost_totalppn_misc" id="cost_totalppn_misc" value="" name="MasterNewCostmisc[vch_total_ppn]">
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
										<p id="cost_label_grandtotal_misc">0.00</p>
										<input type="hidden" class="form-control cost_grandtotal_misc" id="cost_grandtotal_misc" value="" name="MasterNewCostmisc[vch_grandtotal]">
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
	
	function addrow_cost_misc(){
		id = $('#table_cost_misc tbody tr').length-2;
		
		if(id){
            i = id+1;
        }else{
            i = 1;
		}

		item = '';
		item += '<tr>';
			item += '<td class="text-center">';
				item += '<button class="btn btn-xs btn-danger" style="padding: 0px 5px" onclick="delrow_cost_misc($(this))">';
					item += '<span class="fa fa-trash align-middle"></span>';
				item += '</button>';
			item += '</td>';
			item += '<td>';
				item += '<select class="form-select form-select-lg" id="cost_pos_misc-'+i+'" name="MasterNewCostmiscDetail[detail]['+i+'][vchd_pos]" required>';
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
				item += '<input type="text" class="form-control" id="cost_detail_misc-'+i+'" value="" name="MasterNewCostmiscDetail[detail]['+i+'][vchd_detail]">';
			item += '</td>';
			
			item += '<td>';
				item += '<input type="text" class="form-control cost_jumlah_misc" id="cost_jumlah_misc-'+i+'" value="" name="MasterNewCostmiscDetail[detail]['+i+'][qty]" onkeyup="changeInputCost_misc(this.id)" required>';
			item += '</td>';
			item += '<td>';
				item += '<select class="form-select form-select-lg" id="cost_jumlahpack_misc-'+i+'" name="MasterNewCostmiscDetail[detail]['+i+'][vchd_unit_type]" required>';
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
						item += '<input type="hidden" class="form-control cost_tarif_misc" id="cost_tarif_misc-'+i+'" value="" name="MasterNewCostmiscDetail[detail]['+i+'][vchd_rate]">';
						item += '<input type="text" class="form-control cost_tarif1_misc" id="cost_tarif1_misc-'+i+'" value="" onkeyup="changeInputCost_misc(this.id)" required>';
					item += '</div>';
					item += '<div class="col-5 pl-1 pt-2">';
						item += '<input type="text" class="form-control cost_tarif2_misc" id="cost_tarif2_misc-'+i+'" style="height:25px" value="00" onkeyup="changeInputCost_misc(this.id)">';
					item += '</div>';	
				item += '</div>';
			item += '</td>';
			
			item += '<td class="text-right">';
				item += '<label class="fw-normal mb-0" id="cost_label_subtotal_misc-'+i+'">0.00</label>';
				item += '<input type="hidden" class="form-control cost_subtotal_misc" id="cost_subtotal_misc-'+i+'" value="" name="MasterNewCostmiscDetail[detail]['+i+'][vchd_amount]">';
			item += '</td>';
			item += '<td>IDR</td>';
			
			item += '<td>';
				// item += '<select class="form-select form-select-lg cost_ppntype_misc" id="cost_ppntype_misc-'+i+'" name="MasterNewCostmiscDetail[detail]['+i+'][vchd_id_ppn]" onchange="getTotalCost_misc()" required>';
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
				item += '<input type="hidden" class="form-control cost_ppn_misc" id="cost_ppn_misc-'+i+'" value="<?= $ppn->id ?>" name="MasterNewCostmiscDetail[detail]['+i+'][vchd_ppn]">';
			item += '</td>';
			item += '<td>';
				// item += '<select class="form-select form-select-lg cost_ppntype_misc" id="cost_ppntype_misc-'+i+'" name="MasterNewCostmiscDetail[detail]['+i+'][vchd_id_ppn]" onchange="getTotalCost_misc()" required>';
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
				item += '<input type="hidden" class="form-control cost_pph_misc" id="cost_pph_misc-'+i+'" value="<?= $pph->id ?>" name="MasterNewCostmiscDetail[detail]['+i+'][vchd_pph]">';
			item += '</td>';
		item += '</tr>';
		
		tr = $('#table_cost_misc tbody tr').length-3;
	
		$('#table_cost_misc tbody tr:eq('+tr+')').after(item);
		
		// Gabungan Tarif
		$('.cost_tarif1_misc, .cost_tarif2_misc').on('keyup', function(){
			$('.cost_tarif_misc').each(function(i){
				input_tarif1 = Number($('.cost_tarif1_misc').eq(i).val());
				input_tarif2 = $('.cost_tarif2_misc').eq(i).val();
				
				if(input_tarif1 == ''){
					input_tarif1 = 0;
				}
				if(input_tarif2 == ''){
					input_tarif2 = '00';
				}
				
				tarif = input_tarif1+'.'+input_tarif2;
				
				$('.cost_tarif_misc').eq(i).val(tarif);
			});
		});
	}
	
	function delrow_cost_misc(el){
		if(confirm('Apakah anda yakin ingin menghapus data ini?')){
			el.parent().parent().remove();
		
			getTotalCost_misc();
		}
	}
	
	function changeInputCost_misc(id){
		idx = id.split('-')[1];
		
		jumlah 	= $('#cost_jumlah_misc-'+idx).val();
		tarif1 	= $('#cost_tarif1_misc-'+idx).val();
		tarif2 	= $('#cost_tarif2_misc-'+idx).val();
		ppntype	= $('#cost_ppntype_misc-'+idx+' option:selected').html();
		
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
		
		$('#cost_label_subtotal_misc-'+idx).html(addSeparator(subtotal.toFixed(2)));
		$('#cost_subtotal_misc-'+idx).val(subtotal);
		$('#cost_ppn_misc-'+idx).val(totalppn);
		
		getTotalCost_misc();
	}
	
	// Gabungan Tarif
	$('.cost_tarif1_misc, .cost_tarif2_misc').on('keyup', function(){
		$('.cost_tarif_misc').each(function(i){
			input_tarif1 = Number($('.cost_tarif1_misc').eq(i).val());
			input_tarif2 = $('.cost_tarif2_misc').eq(i).val();
			
			if(input_tarif1 == ''){
				input_tarif1 = 0;
			}
			if(input_tarif2 == ''){
				input_tarif2 = '00';
			}
			
			tarif = input_tarif1+'.'+input_tarif2;
			
			$('.cost_tarif_misc').eq(i).val(tarif);
		});
	});
	
	function getTotalCost_misc(){
		total = 0;
		total_ppn = 0;
		
        $('.cost_subtotal_misc').each(function(index) {
			if($(this).val() == ''){
				subtotal = 0;
			}else{
				subtotal = $(this).val();
			}
			
			ppntype	= $('.cost_ppntype_misc:eq('+index+') option:selected').html();
			if(ppntype){
				ppn = parseFloat(ppntype.split('-')[1].replace('%',''));
			}else{
				ppn = 0;
			}
			
			total += parseFloat(subtotal);
			total_ppn += Math.floor(parseFloat(subtotal) * parseFloat(ppn) / 100);
        });
		
		grandtotal = total + total_ppn;
		
		$('#cost_label_total_misc').html(addSeparator(total.toFixed(2)));
		$('#cost_total_misc').val(total);
		
		$('#cost_label_ppn_misc').html(addSeparator(total_ppn.toFixed(2)));
		$('#cost_totalppn_misc').val(total_ppn);

		$('#cost_label_grandtotal_misc').html(addSeparator(grandtotal.toFixed(2)));
		$('#cost_grandtotal_misc').val(grandtotal);
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
