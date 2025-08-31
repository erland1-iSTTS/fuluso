<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\VarDumper;
?>

<style>
	.form-group{
		margin-bottom: 10px;
	}
</style>

<?php
	if(!empty($model)){
		$telp = $model->customer_telephone;
		$telp1 = explode(' ', $telp)[0];
		$telp2 = explode(' ', $telp)[1];
		$telp3 = explode(' ', $telp)[2];
	}
?>


<div class="master-profile-form" style="margin-top:50px">
	<?php $form = ActiveForm::begin([
		'id' => 'customer-form',
		'action' => ['master-profile/edit-customer?id='.$model->customer_id],
		'options' => ['enctype' => 'multipart/form-data'],
	]); ?>
		<div class="row">
			<input type="hidden" id="customer-customer_id" name="Customer[customer_id]" value="<?= $model->customer_id ?>">
			
			<!-- Left -->
			<div class="col-5">
				<div class="row">
					<label class="col-sm-3">Type</label>
					<div class="col-sm-9">
						<div class="form-check form-check-inline col-md-4">
							<input type="radio" class="form-check-input" id="customer-customer_local" name="Customer[customer_type]" value="local" <?= $model->customer_type == 1 ? 'checked' : '' ?>>
							<label class="form-check-label" for="customer-customer_local">Cust. Local</label>
						</div>
						<div class="form-check form-check-inline col-md-5">
							<input type="radio" class="form-check-input" id="customer-customer_overseas" name="Customer[customer_type]" value="overseas" <?= $model->customer_type == 2 ? 'checked' : '' ?>>
							<label class="form-check-label" for="customer-customer_overseas">Cust. Overseas</label>
						</div>
					</div>
				</div>
				
				<div class="form-group row div-isvendor">
					<label class="col-sm-3">Vendor</label>
					<div class="col-sm-9">
						<div class="form-check form-check-inline col-md-4">
							<input type="checkbox" class="form-check-input" id="customer-isvendor" name="Customer[is_vendor]" value="1" <?= $model->is_vendor == 1 ? 'checked' : '' ?>>
							<label class="form-check-label" for="customer-isvendor">As Vendor</label>
						</div>
					</div>
				</div>
				
				<div class="form-group row div-customer">
					<label class="col-sm-3">Status</label>
					<div class="col-sm-9">
						<div class="form-check form-check-inline col-md-4">
							<input type="radio" class="form-check-input" id="customer-status1" name="Customer[status]" value="agent" <?= $model->status == 1 ? 'checked' : '' ?>>
							<label class="form-check-label" for="customer-status1">Agent</label>
						</div>
						<div class="form-check form-check-inline col-md-5">
							<input type="radio" class="form-check-input" id="customer-status2" name="Customer[status]" value="nonagent" <?= $model->status == 0 ? 'checked' : '' ?>>
							<label class="form-check-label" for="customer-status2">Non-Agent</label>
						</div>
					</div>
				</div>
				<div class="form-group row div-customer">
					<label class="col-sm-3">Nickname</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="customer-customer_nickname" name="Customer[customer_nickname]" value="<?= $model->customer_nickname ?>">
					</div>
				</div>
				<div class="form-group row div-customer">
					<label class="col-sm-3">Name</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="customer-customer_name" name="Customer[customer_companyname]" value="<?= $model->customer_companyname ?>">
					</div>
				</div>
				<div class="form-group row div-customer">
					<label class="col-sm-3">Address</label>
					<div class="col-sm-9">
						<?php
							$text = preg_split('/\n/',$model->customer_address);
						?>
						<!--<textarea class="form-control address-customer" id="customer-customer_address" name="Customer[customer_address]" rows="6"><?php // $model->customer_address ?></textarea>-->
						
						<input type="text" class="form-control address-customer" id="customer-customer_address-1" name="Customer[customer_address1]" value="<?= isset($text[0]) ? $text[0] : '' ?>" placeholder="Address" maxlength="55">
						<input type="text" class="form-control" id="customer-customer_address-2" name="Customer[customer_address2]" value="<?= isset($text[1]) ? $text[1] : '' ?>" placeholder="Address" maxlength="55">
						<input type="text" class="form-control" id="customer-customer_address-3" name="Customer[customer_address3]" value="<?= isset($text[2]) ? $text[2] : '' ?>" placeholder="Address" maxlength="55">
						<input type="text" class="form-control" id="customer-customer_address-4" name="Customer[customer_address4]" value="<?= isset($text[3]) ? $text[3] : '' ?>" placeholder="Address" maxlength="55">
						<input type="text" class="form-control" id="customer-customer_address-5" name="Customer[customer_address5]" value="<?= isset($text[4]) ? $text[4] : '' ?>" placeholder="Address" maxlength="55">
						<input type="text" class="form-control" id="customer-customer_address-6" name="Customer[customer_address6]" value="<?= isset($text[5]) ? $text[5] : '' ?>" placeholder="Address" maxlength="55">
					</div>
				</div>
				
				<!-- Div tambah address alias maksimal 5 -->
				<div id="address_alias_list" style="width:100%">
					<?php 
						if(!empty($alias)){
							$i=1;
							foreach($alias as $row){
					?>
						<div class="form-group row" style="margin-top:30px;">
							<input type="hidden" id="customer-customer_id_alias<?= $i ?>" name="Customer[alias][<?= $i ?>][customer_alias_id]" value="<?= $row['customer_alias_id'] ?>">
						
							<label class="col-sm-3">Alias #<?= $i ?></label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="customer-customer_alias<?= $i ?>" name="Customer[alias][<?= $i ?>][customer_name]" value="<?= $row['customer_name'] ?>">
								</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3"></label>
							<div class="col-sm-9">
								<?php
									$textalias = preg_split('/\n/',$row['customer_alias']);
								?>
								<!--<textarea class="form-control address-customer" id="customer-customer_address_alias<?php // $i ?>" name="Customer[alias][<?php // $i ?>][customer_alias]" rows="6"><php //$row['customer_alias'] ?></textarea>-->
								
								<input type="text" class="form-control address-customer" id="customer-customer_address_alias1<?= $i ?>" placeholder="Address" value="<?= isset($textalias[0]) ? $textalias[0] : '' ?>" name="Customer[alias][<?= $i ?>][customer_alias1]" maxlength="55">
								<input type="text" class="form-control" id="customer-customer_address_alias2<?= $i ?>" placeholder="Address" value="<?= isset($textalias[1]) ? $textalias[1] : '' ?>" name="Customer[alias][<?= $i ?>][customer_alias2]" maxlength="55">
								<input type="text" class="form-control" id="customer-customer_address_alias3<?= $i ?>" placeholder="Address" value="<?= isset($textalias[2]) ? $textalias[2] : '' ?>" name="Customer[alias][<?= $i ?>][customer_alias3]" maxlength="55">
								<input type="text" class="form-control" id="customer-customer_address_alias4<?= $i ?>" placeholder="Address" value="<?= isset($textalias[3]) ? $textalias[3] : '' ?>" name="Customer[alias][<?= $i ?>][customer_alias4]" maxlength="55">
								<input type="text" class="form-control" id="customer-customer_address_alias5<?= $i ?>" placeholder="Address" value="<?= isset($textalias[4]) ? $textalias[4] : '' ?>" name="Customer[alias][<?= $i ?>][customer_alias5]" maxlength="55">
								<input type="text" class="form-control" id="customer-customer_address_alias6<?= $i ?>" placeholder="Address" value="<?= isset($textalias[5]) ? $textalias[5] : '' ?>" name="Customer[alias][<?= $i ?>][customer_alias6]" maxlength="55">
							</div>
						</div>
						<?php $i++; } ?>
					<?php } ?>
				</div>
				
				<div class="form-group row d-flex justify-content-end">
					<div class="col-sm-4">
						<button type="button" class="btn btn-dark" id="btn-add-alias" style="width:100%">Add Alias</button>
					</div>
				</div>
			</div>
			
			<!-- Right -->
			<div class="offset-1 col-6">
				<div class="form-group row div-customer">
					<label class="col-sm-3">Telephone</label>
					<div class="col-sm-2">
						<input type="text" class="form-control" id="customer-customer_telephone1" name="Customer[telp1]" maxlength="4" value="<?= $telp1 ?>">
					</div>
					<div class="col-sm-2 pl-0">
						<input type="text" class="form-control" id="customer-customer_telephone2" name="Customer[telp2]" maxlength="3" value="<?= $telp2 ?>">
					</div>
					<div class="col-sm-5 pl-0">
						<input type="text" class="form-control" id="customer-customer_telephone3" name="Customer[telp3]" maxlength="12" value="<?= $telp3 ?>">
					</div>
				</div>
				<div class="form-group row div-customer">
					<label class="col-sm-3">Contact Person</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="customer-customer_contact_person" name="Customer[customer_contact_person]" value="<?= $model->customer_contact_person ?>">
					</div>
				</div>
				<div class="form-group row div-customer">
					<label class="col-sm-3">NPWP</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="customer-customer_npwp" name="Customer[customer_npwp]"  placeholder="00.000.000.0-000.000" value="<?= $model->customer_npwp ?>">
					</div>
				</div>
				<!--<div class="form-group row div-customer">
					<label class="col-sm-3">File NPWP</label>
					<div class="col-sm-9">
						<input type="file" id="customer-customer_npwp_file" name="Customer[customer_npwp_file]" placeholder="( Upload File )">
					</div>
				</div>-->
				<div class="form-group row div-customer">
					<label class="col-sm-3">Email</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="customer-customer_email_1" name="Customer[customer_email_1]" value="<?= $model->customer_email_1 ?>">
						<input type="text" class="form-control" id="customer-customer_email_2" name="Customer[customer_email_2]" value="<?= $model->customer_email_2 ?>">
						<input type="text" class="form-control" id="customer-customer_email_3" name="Customer[customer_email_3]" value="<?= $model->customer_email_3 ?>">
						<input type="text" class="form-control" id="customer-customer_email_4" name="Customer[customer_email_4]" value="<?= $model->customer_email_4 ?>">
					</div>
				</div>
			</div>
		</div>
		<div class="row d-flex justify-content-end">
			<div class="col-sm-1">
				<button type="submit" class="btn btn-dark" id="btn-add-alias" style="width:100%">Save</button>
			</div>
		</div>
	</div>
    <?php ActiveForm::end(); ?>
</div>

<script>
	$(document).ready(function(){
		<?php if($model->isNewRecord){ ?>
			$('#customer-customer_local').prop('checked', true);
			$('#customer-status1').prop('checked', true);
		<?php } ?>
	});
	
	$('#btn-add-alias').on('click', function(){
		
		if($('#customer-customer_local').is(':checked') == true || $('#customer-customer_overseas').is(':checked') == true){
			var i = $('.address-customer').length;
			
			//Maksimal address customer alias 5 kali
			if(i < 6){
				item = '<div class="form-group row" style="margin-top:30px;">';
					item += '<label class="col-sm-3">Alias #'+i+'</label>';
					item += '<div class="col-sm-9">';
						item += '<input type="text" class="form-control" id="customer-customer_alias'+i+'" name="Customer[alias]['+i+'][customer_name]">';
					item += '</div>';
				item += '</div>';
				item += '<div class="form-group row">';
					item += '<label class="col-sm-3"></label>';
					item += '<div class="col-sm-9">';
						// item += '<textarea class="form-control address-customer" id="customer-customer_address_alias'+i+'" name="Customer[alias]['+i+'][customer_alias]" rows="6"></textarea>';
						item += '<input type="text" class="form-control address-customer" id="customer-customer_address_alias1'+i+'" placeholder="Address" name="Customer[alias]['+i+'][customer_alias1]" maxlength="55">';
						item += '<input type="text" class="form-control" id="customer-customer_address_alias2'+i+'" placeholder="Address" name="Customer[alias]['+i+'][customer_alias2]" maxlength="55">';
						item += '<input type="text" class="form-control" id="customer-customer_address_alias3'+i+'" placeholder="Address" name="Customer[alias]['+i+'][customer_alias3]" maxlength="55">';
						item += '<input type="text" class="form-control" id="customer-customer_address_alias4'+i+'" placeholder="Address" name="Customer[alias]['+i+'][customer_alias4]" maxlength="55">';
						item += '<input type="text" class="form-control" id="customer-customer_address_alias5'+i+'" placeholder="Address" name="Customer[alias]['+i+'][customer_alias5]" maxlength="55">';
						item += '<input type="text" class="form-control" id="customer-customer_address_alias6'+i+'" placeholder="Address" name="Customer[alias]['+i+'][customer_alias6]" maxlength="55">';
					item += '</div>';
				item += '</div>';
					
				$('#address_alias_list').append(item);
			}
		}
		
		if($('#customer-customer_carrier').is(':checked') == true){
			var j = $('.address-carrier').length+1;
			
			//Maksimal address carrier alias 10 kali
			if(j < 11){
				item = '<div class="form-group row" style="margin-top:30px;">';
					item += '<label class="col-sm-3">Name #'+j+'</label>';
					item += '<div class="col-sm-9">';
						item += '<input type="text" class="form-control" id="customer-customer_alias'+j+'" name="Carrier[alias]['+j+'][name]">';
					item += '</div>';
				item += '</div>';
				item += '<div class="form-group row">';
					item += '<label class="col-sm-3">Address #'+j+'</label>';
					item += '<div class="col-sm-9">';
						item += '<textarea class="form-control address-carrier" id="customer-customer_address_alias'+j+'" name="Carrier[alias]['+j+'][detail]" rows="6"></textarea>';
					item += '</div>';
				item += '</div>';
					
				$('#address_alias_list').append(item);
			}
		}
	});
</script>
