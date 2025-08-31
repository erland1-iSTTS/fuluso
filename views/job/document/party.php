<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Customer;
use app\models\CustomerAlias;
use app\models\MasterG3eHblCusdata;
use app\models\MasterG3eJobrouting;
use yii\helpers\VarDumper;

$customer = Customer::find()->where(['is_active'=>1])->orderBy(['customer_companyname'=>SORT_ASC])->all();

$data1 = MasterG3eHblCusdata::find()->where(['hblcusdata_job_id' => $_GET['id']])->one();
$data2 = MasterG3eJobrouting::find()->where(['jr_job_id' => $_GET['id']])->one();

if($party->isNewRecord){
	$checked = '';
}else{
	$checked = 'checked';
}

//Sort count untuk update data party
if(!empty($party)){
	$array = array();
	
	if(!empty($party->customer_count)){
		$array[$party->customer_count] =  [
			'party' => $party->customer,
			'alias' => $party->customer_alias, 
			'address' => $party->customer_address, 
			'data' => 'customer',
		];
	}
	
	if(!empty($party->shipper_count)){
		$array[$party->shipper_count] =  [
			'party' => $party->shipper,
			'alias' => $party->shipper_alias, 
			'address' => $party->shipper_address, 
			'data' => 'shipper',
		];
	}
	
	if(!empty($party->consignee_count)){
		$array[$party->consignee_count] =  [
			'party' => $party->consignee,
			'alias' => $party->consignee_alias, 
			'address' => $party->consignee_address, 
			'data' => 'consignee',
		];
	}
	
	if(!empty($party->notify_count)){
		$array[$party->notify_count] =  [
			'party' => $party->notify,
			'alias' => $party->notify_alias, 
			'address' => $party->notify_address, 
			'data' => 'notify',
		];
	}
	
	if(!empty($party->alsonotify_count)){
		$array[$party->alsonotify_count] =  [
			'party' => $party->alsonotify,
			'alias' => $party->alsonotify_alias, 
			'address' => $party->alsonotify_address, 
			'data' => 'alsonotify',
		];
	}
	
	if(!empty($party->agent_count)){
		$array[$party->agent_count] =  [
			'party' => $party->agent,
			'alias' => $party->agent_alias, 
			'address' => $party->agent_address, 
			'data' => 'agent',
		];
	}
	
	if(!empty($party->billingparty_count_1)){
		$array[$party->billingparty_count_1] = [
			'party' => $party->billingparty_1,
			'alias' => $party->billingparty_alias_1, 
			'address' => $party->billingparty_address_1, 
			'data' => 'billing',
		];
	}
	
	if(!empty($party->billingparty_count_2)){
		$array[$party->billingparty_count_2] =  [
			'party' => $party->billingparty_2,
			'alias' => $party->billingparty_alias_2, 
			'address' => $party->billingparty_address_2, 
			'data' => 'billing',
		];
	}
	
	if(!empty($party->billingparty_count_3)){
		$array[$party->billingparty_count_3] =  [
			'party' => $party->billingparty_3,
			'alias' => $party->billingparty_alias_3, 
			'address' => $party->billingparty_address_3, 
			'data' => 'billing',
		];
	}
	
	if(!empty($party->billingparty_count_erc)){
		$array[$party->billingparty_count_erc] =  [
			'party' => $party->billingparty_erc,
			'alias' => $party->billingparty_alias_erc, 
			'address' => $party->billingparty_address_erc, 
			'data' => 'erc',
		];
	}
	
	ksort($array);
	// VarDumper::dump($array,10,true);die();
}
?>

<style>
	select option{
		color: #555;
	}
</style>

<div id="party-index">
<?php $form = ActiveForm::begin(['id' => 'form_party', 'action' => Url::base().'/job/save-party']); ?>
	<input type="hidden" value="<?= $_GET['id']?>" name="MasterNewJobBooking[id_job]">
	
	<div class="row m-0">
		<div class="col-12 mb-4" id="error-party" style="display:none;color:#dc3545">
			Pastikan data terisi lengkap (Customer, Shipper, Consignee, Notify Party, Routing Agent, Billing Party)
		</div>
		
		<!-- Party 1 -->
		<div class="col-md-4 pb-3 border-right" id="div-1">
			<label class="fw-normal">Party 1</label>
			<div class="form-group">
				<select class="form-control" style="width:100%" id="party-1" name="MasterNewJobBooking[cus1]" required>
					<option value="" disabled <?= isset($array['1']['party']) ? '' : 'selected' ?> hidden></option>
					<?php
						foreach($customer as $row){
							if(isset($array['1']['party'])){
								if($array['1']['party'] == $row['customer_id']){
									$selected = 'selected';
								}else{
									$selected = '';
								}
							}else{
								$selected = '';
							}
							echo "<option value='".$row['customer_id']."' ".$selected.">".
								$row['customer_companyname'].
							"</option>";
						}
					?>
				</select>
			</div>
			<div class="form-group">
				<select class="form-select form-select-lg" style="width:100%" id="party_alias-1" name="MasterNewJobBooking[cus2]" required>
					<option value="" disabled <?= isset($array['1']['alias']) ? '' : 'selected' ?> hidden></option>
					<?php
						if(isset($array['1']['party'])){
							$customer_alias = CustomerAlias::find()->where(['customer_id'=>$array['1']['party']])->orderBy(['customer_name'=>SORT_ASC])->all();
							
							foreach($customer_alias as $row){
								if($array['1']['alias']  == $row['customer_alias_id']){
									$selected = 'selected';
								}else{
									$selected = '';
								}
								
								echo "<option value='".$row['customer_alias_id']."' ".$selected.">".
									$row['customer_name'].
								"</option>";
							}
						}
					?>
				</select>
			</div>
			<div class="form-group">
				<textarea class="form-control" id="party_address-1" placeholder="" rows="5" name="MasterNewJobBooking[cus3]" readonly><?php if(isset($array['1']['address'])){echo str_replace("\\n","\n",$array['1']['address']);} ?></textarea>
			</div>
			
			<div class="row d-flex justify-content-between m-0">
				<div class="form-check form-check-inline mb-2 ml-2" style="width:18%">
					<input type="checkbox" class="form-check-input check_party_1 check_customer" name="customer" value="1" onchange="checking($(this))" <?php if(isset($array['1']['data'])){ if($array['1']['data'] == 'customer'){echo 'checked';}} ?> id="customer1">
					<label class="form-check-label" for="customer1" style="font-size:10px">Customer</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:22%">
					<input type="checkbox" class="form-check-input check_party_1 check_shipper" name="shipper" value="1" onchange="checking($(this))" <?php if(isset($array['1']['data'])){ if($array['1']['data'] == 'shipper'){echo 'checked';}} ?> id="shipper1">
					<label class="form-check-label" for="shipper1" style="font-size:10px">Shipper</label>
				</div>
				
				<div class="form-check form-check-inline mb-2"style="width:20%">
					<input type="checkbox" class="form-check-input check_party_1 check_consignee" name="consignee" value="1" onchange="checking($(this))" <?php if(isset($array['1']['data'])){ if($array['1']['data'] == 'consignee'){echo 'checked';}} ?> id="consignee1">
					<label class="form-check-label" for="consignee1" style="font-size:10px">Consignee</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:25%">
					<input type="checkbox" class="form-check-input check_party_1 check_notify_party" name="notify" value="1" onchange="checking($(this))" <?php if(isset($array['1']['data'])){ if($array['1']['data'] == 'notify'){echo 'checked';}} ?> id="notify_party1">
					<label class="form-check-label" for="notify_party1" style="font-size:10px">Notify Party</label>
				</div>
			</div>
			<div class="row d-flex justify-content-between m-0">
				<div class="form-check form-check-inline mb-2 ml-2" style="width:18%">
					<input type="checkbox" class="form-check-input check_party_1 check_also_notify" name="also_notify" value="1" onchange="checking($(this))" <?php if(isset($array['1']['data'])){ if($array['1']['data'] == 'alsonotify'){echo 'checked';}} ?> id="also_notify1">
					<label class="form-check-label" for="also_notify1" style="font-size:10px">Also Notify</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:22%">
					<input type="checkbox" class="form-check-input check_party_1 check_agent" name="agent" value="1" onchange="checking($(this))" <?php if(isset($array['1']['data'])){ if($array['1']['data'] == 'agent'){echo 'checked';}} ?> id="agent1">
					<label class="form-check-label" for="agent1" style="font-size:10px">Routing Agent</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:20%">
					<input type="checkbox" class="form-check-input check_party_1 check_billing_party" name="billing_party" value="1" <?php if(isset($array['1']['data'])){ if($array['1']['data'] == 'billing'){echo 'checked';}} ?> onchange="checking($(this))" id="billing_party1">
					<label class="form-check-label" for="billing_party1" style="font-size:10px">Billing Party</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:25%">
					<input type="checkbox" class="form-check-input check_party_1 check_erc" name="erc" value="1" <?php if(isset($array['1']['data'])){ if($array['1']['data'] == 'erc'){echo 'checked';}} ?> onchange="checking($(this))" id="erc1">
					<label class="form-check-label" for="erc1" style="font-size:10px">Billing Party-ERC</label>
				</div>
			</div>
		</div>
		
		<!-- Party 2 -->
		<div class="col-md-4 pb-3 border-right" id="div-2">
			<label class="fw-normal">Party 2</label>
			<div class="form-group">
				<select class="form-control" style="width:100%" id="party-2" name="MasterNewJobBooking[ship1]" required>
					<option value="" disabled <?= isset($array['2']['party']) ? '' : 'selected' ?> hidden></option>
					<?php
						foreach($customer as $row){
							if(isset($array['2']['party'])){
								if($array['2']['party'] == $row['customer_id']){
									$selected = 'selected';
								}else{
									$selected = '';
								}
							}else{
								$selected = '';
							}
							echo "<option value='".$row['customer_id']."' ".$selected.">".
								$row['customer_companyname'].
							"</option>";
						}
					?>
				</select>
			</div>
			<div class="form-group">
				<select class="form-select form-select-lg" style="width:100%" id="party_alias-2" name="MasterNewJobBooking[ship2]" required>
					<option value="" disabled <?= isset($array['2']['alias']) ? '' : 'selected' ?> hidden></option>
					<?php
						if(isset($array['2']['party'])){
							$customer_alias2 = CustomerAlias::find()->where(['customer_id'=>$array['2']['party']])->orderBy(['customer_name'=>SORT_ASC])->all();
							
							foreach($customer_alias2 as $row){
								if($array['2']['alias'] == $row['customer_alias_id']){
									$selected = 'selected';
								}else{
									$selected = '';
								}
								
								echo "<option value='".$row['customer_alias_id']."' ".$selected.">".
									$row['customer_name'].
								"</option>";
							}
						}
					?>
				</select>
			</div>
			<div class="form-group">
				<textarea class="form-control" id="party_address-2" placeholder="" rows="5" name="MasterNewJobBooking[ship3]" readonly><?php if(isset($array['2']['address'])){echo str_replace("\\n","\n",$array['2']['address']);} ?></textarea>
			</div>
			
			<div class="row d-flex justify-content-between m-0">
				<div class="form-check form-check-inline mb-2 ml-2" style="width:18%">
					<input type="checkbox" class="form-check-input check_party_2 check_customer" name="customer" value="2" onchange="checking($(this))" <?php if(isset($array['2']['data'])){ if($array['2']['data'] == 'customer'){echo 'checked';}} ?> id="customer2">
					<label class="form-check-label" for="customer2" style="font-size:10px">Customer</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:22%">
					<input type="checkbox" class="form-check-input check_party_2 check_shipper" name="shipper" value="2" onchange="checking($(this))" <?php if(isset($array['2']['data'])){ if($array['2']['data'] == 'shipper'){echo 'checked';}} ?> id="shipper2">
					<label class="form-check-label" for="shipper2" style="font-size:10px">Shipper</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:20%">
					<input type="checkbox" class="form-check-input check_party_2 check_consignee" name="consignee" value="2" onchange="checking($(this))" <?php if(isset($array['2']['data'])){ if($array['2']['data'] == 'consignee'){echo 'checked';}} ?> id="consignee2">
					<label class="form-check-label" for="consignee2" style="font-size:10px">Consignee</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:25%">
					<input type="checkbox" class="form-check-input check_party_2 check_notify_party" name="notify" value="2" onchange="checking($(this))" <?php if(isset($array['2']['data'])){ if($array['2']['data'] == 'notify'){echo 'checked';}} ?> id="notify_party2">
					<label class="form-check-label" for="notify_party2" style="font-size:10px">Notify Party</label>
				</div>
			</div>
			<div class="row d-flex justify-content-between m-0">
				<div class="form-check form-check-inline mb-2 ml-2" style="width:18%">
					<input type="checkbox" class="form-check-input check_party_2 check_also_notify" name="also_notify" value="2" onchange="checking($(this))" <?php if(isset($array['2']['data'])){ if($array['2']['data'] == 'alsonotify'){echo 'checked';}} ?> id="also_notify2">
					<label class="form-check-label" for="also_notify2" style="font-size:10px">Also Notify</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:22%">
					<input type="checkbox" class="form-check-input check_party_2 check_agent" name="agent" value="2" onchange="checking($(this))" <?php if(isset($array['2']['data'])){ if($array['2']['data'] == 'agent'){echo 'checked';}} ?> id="agent2">
					<label class="form-check-label" for="agent2" style="font-size:10px">Routing Agent</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:20%">
					<input type="checkbox" class="form-check-input check_party_2 check_billing_party" name="billing_party" value="2" onchange="checking($(this))" <?php if(isset($array['2']['data'])){ if($array['2']['data'] == 'billing'){echo 'checked';}} ?> id="billing_party2">
					<label class="form-check-label" for="billing_party2" style="font-size:10px">Billing Party</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:25%">
					<input type="checkbox" class="form-check-input check_party_2 check_erc" name="erc" value="2" onchange="checking($(this))" <?php if(isset($array['2']['data'])){ if($array['2']['data'] == 'erc'){echo 'checked';}} ?> id="erc2">
					<label class="form-check-label" for="erc2" style="font-size:10px">Billing Party-ERC</label>
				</div>
			</div>
		</div>
		
		<!-- Party 3 -->
		<div class="col-md-4 pb-3" id="div-3">
			<label class="fw-normal">Party 3</label>
			<div class="form-group">
				<select class="form-control" style="width:100%" id="party-3" name="MasterNewJobBooking[consign1]" required>
					<option value="" disabled <?= isset($array['3']['party']) ? '' : 'selected' ?> hidden></option>
					<?php
						foreach($customer as $row){
							if(isset($array['3']['party'])){
								if($array['3']['party'] == $row['customer_id']){
									$selected = 'selected';
								}else{
									$selected = '';
								}
							}else{
								$selected = '';
							}
							echo "<option value='".$row['customer_id']."' ".$selected.">".
								$row['customer_companyname'].
							"</option>";
						}
					?>
				</select>
			</div>
			<div class="form-group">
				<select class="form-select form-select-lg" style="width:100%" id="party_alias-3" name="MasterNewJobBooking[consign2]" required>
					<option value="" disabled <?= isset($array['3']['alias']) ? '' : 'selected' ?> hidden></option>
					<?php
						if(isset($array['3']['party'])){
							$customer_alias3 = CustomerAlias::find()->where(['customer_id'=>$array['3']['party']])->orderBy(['customer_name'=>SORT_ASC])->all();
							
							foreach($customer_alias3 as $row){
								if($array['3']['alias'] == $row['customer_alias_id']){
									$selected = 'selected';
								}else{
									$selected = '';
								}
								
								echo "<option value='".$row['customer_alias_id']."' ".$selected.">".
									$row['customer_name'].
								"</option>";
							}
						}
					?>
				</select>
			</div>
			<div class="form-group">
				<textarea class="form-control" id="party_address-3" placeholder="" rows="5" name="MasterNewJobBooking[consign3]" readonly><?php if(isset($array['3']['address'])){echo str_replace("\\n","\n",$array['3']['address']);} ?></textarea>
			</div>
			
			<div class="row d-flex justify-content-between m-0">
				<div class="form-check form-check-inline mb-2 ml-2" style="width:18%">
					<input type="checkbox" class="form-check-input check_party_3 check_customer" name="customer" value="3" onchange="checking($(this))" <?php if(isset($array['3']['data'])){ if($array['3']['data'] == 'customer'){echo 'checked';}} ?> id="customer3">
					<label class="form-check-label" for="customer3" style="font-size:10px">Customer</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:22%">
					<input type="checkbox" class="form-check-input check_party_3 check_shipper" name="shipper" value="3" onchange="checking($(this))" <?php if(isset($array['3']['data'])){ if($array['3']['data'] == 'shipper'){echo 'checked';}} ?> id="shipper3">
					<label class="form-check-label" for="shipper3" style="font-size:10px">Shipper</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:20%">
					<input type="checkbox" class="form-check-input check_party_3 check_consignee" name="consignee" value="3" onchange="checking($(this))" <?php if(isset($array['3']['data'])){ if($array['3']['data'] == 'consignee'){echo 'checked';}} ?> id="consignee3">
					<label class="form-check-label" for="consignee3" style="font-size:10px">Consignee</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:25%">
					<input type="checkbox" class="form-check-input check_party_3 check_notify_party" name="notify" value="3" onchange="checking($(this))" <?php if(isset($array['3']['data'])){ if($array['3']['data'] == 'notify'){echo 'checked';}} ?> id="notify_party3">
					<label class="form-check-label" for="notify_party3" style="font-size:10px">Notify Party</label>
				</div>
			</div>
			<div class="row d-flex justify-content-between m-0">
				<div class="form-check form-check-inline mb-2 ml-2" style="width:18%">
					<input type="checkbox" class="form-check-input check_party_3 check_also_notify" name="also_notify" value="3" onchange="checking($(this))" <?php if(isset($array['3']['data'])){ if($array['3']['data'] == 'alsonotify'){echo 'checked';}} ?> id="also_notify3">
					<label class="form-check-label" for="also_notify3" style="font-size:10px">Also Notify</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:22%">
					<input type="checkbox" class="form-check-input check_party_3 check_agent" name="agent" value="3" onchange="checking($(this))" <?php if(isset($array['3']['data'])){ if($array['3']['data'] == 'agent'){echo 'checked';}} ?> id="agent3">
					<label class="form-check-label" for="agent3" style="font-size:10px">Routing Agent</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:20%">
					<input type="checkbox" class="form-check-input check_party_3 check_billing_party" name="billing_party" value="3" onchange="checking($(this))" <?php if(isset($array['3']['data'])){ if($array['3']['data'] == 'billing'){echo 'checked';}} ?> id="billing_party3">
					<label class="form-check-label" for="billing_party3" style="font-size:10px">Billing Party</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:25%">
					<input type="checkbox" class="form-check-input check_party_3 check_erc" name="erc" value="3" onchange="checking($(this))" <?php if(isset($array['3']['data'])){ if($array['3']['data'] == 'erc'){echo 'checked';}} ?> id="erc3">
					<label class="form-check-label" for="erc3" style="font-size:10px">Billing Party-ERC</label>
				</div>
			</div>
		</div>
	</div>

	<!-- Row 2 -->
	<div class="row m-0">
		<!-- Party 4 -->
		<div class="col-md-4 pb-3 pt-3 border-right border-top border-bottom" id="div-4">
			<label class="fw-normal">Party 4</label>
			<div class="form-group">
				<select class="form-control" style="width:100%" id="party-4" name="MasterNewJobBooking[notify_party1]" required>
					<option value="" disabled <?= isset($array['4']['party']) ? '' : 'selected' ?> hidden></option>
					<?php
						foreach($customer as $row){
							if(isset($array['4']['party'])){
								if($array['4']['party'] == $row['customer_id']){
									$selected = 'selected';
								}else{
									$selected = '';
								}
							}else{
								$selected = '';
							}
							echo "<option value='".$row['customer_id']."' ".$selected.">".
								$row['customer_companyname'].
							"</option>";
						}
					?>
				</select>
			</div>
			<div class="form-group">
				<select class="form-select form-select-lg" style="width:100%" id="party_alias-4" name="MasterNewJobBooking[notify_party2]" required>
					<option value="" disabled <?= isset($array['4']['alias']) ? '' : 'selected' ?> hidden></option>
					<?php
						if(isset($array['4']['party'])){
							$customer_alias4 = CustomerAlias::find()->where(['customer_id'=>$array['4']['party']])->orderBy(['customer_name'=>SORT_ASC])->all();
							
							foreach($customer_alias4 as $row){
								if($array['4']['alias'] == $row['customer_alias_id']){
									$selected = 'selected';
								}else{
									$selected = '';
								}
								
								echo "<option value='".$row['customer_alias_id']."' ".$selected.">".
									$row['customer_name'].
								"</option>";
							}
						}
					?>
				</select>
			</div>
			<div class="form-group">
				<textarea class="form-control" id="party_address-4" placeholder="" rows="5" name="MasterNewJobBooking[notify_party3]" readonly><?php if(isset($array['4']['address'])){echo str_replace("\\n","\n",$array['4']['address']);} ?></textarea>
			</div>
			
			<div class="row d-flex justify-content-between m-0">
				<div class="form-check form-check-inline mb-2 ml-2" style="width:18%">
					<input type="checkbox" class="form-check-input check_party_4 check_customer" name="customer" value="4" onchange="checking($(this))" <?php if(isset($array['4']['data'])){ if($array['4']['data'] == 'customer'){echo 'checked';}} ?> id="customer4">
					<label class="form-check-label" for="customer4" style="font-size:10px">Customer</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:22%">
					<input type="checkbox" class="form-check-input check_party_4 check_shipper" name="shipper" value="4" onchange="checking($(this))" <?php if(isset($array['4']['data'])){ if($array['4']['data'] == 'shipper'){echo 'checked';}} ?> id="shipper4">
					<label class="form-check-label" for="shipper4" style="font-size:10px">Shipper</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:20%">
					<input type="checkbox" class="form-check-input check_party_4 check_consignee" name="consignee" value="4" onchange="checking($(this))" <?php if(isset($array['4']['data'])){ if($array['4']['data'] == 'consignee'){echo 'checked';}} ?> id="consignee4">
					<label class="form-check-label" for="consignee4" style="font-size:10px">Consignee</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:25%">
					<input type="checkbox" class="form-check-input check_party_4 check_notify_party" name="notify" value="4" onchange="checking($(this))" <?php if(isset($array['4']['data'])){ if($array['4']['data'] == 'notify'){echo 'checked';}} ?> id="notify_party4">
					<label class="form-check-label" for="notify_party4" style="font-size:10px">Notify Party</label>
				</div>
			</div>
			<div class="row d-flex justify-content-between m-0">
				<div class="form-check form-check-inline mb-2 ml-2" style="width:18%">
					<input type="checkbox" class="form-check-input check_party_4 check_also_notify" name="also_notify" value="4" onchange="checking($(this))" <?php if(isset($array['4']['data'])){ if($array['4']['data'] == 'alsonotify'){echo 'checked';}} ?> id="also_notify4">
					<label class="form-check-label" for="also_notify4" style="font-size:10px">Also Notify</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:22%">
					<input type="checkbox" class="form-check-input check_party_4 check_agent" name="agent" value="4" onchange="checking($(this))" <?php if(isset($array['4']['data'])){ if($array['4']['data'] == 'agent'){echo 'checked';}} ?> id="agent4">
					<label class="form-check-label" for="agent4" style="font-size:10px">Routing Agent</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:20%">
					<input type="checkbox" class="form-check-input check_party_4 check_billing_party" name="billing_party" value="4" onchange="checking($(this))" <?php if(isset($array['4']['data'])){ if($array['4']['data'] == 'billing'){echo 'checked';}} ?> id="billing_party4">
					<label class="form-check-label" for="billing_party4" style="font-size:10px">Billing Party</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:25%">
					<input type="checkbox" class="form-check-input check_party_4 check_erc" name="erc" value="4" onchange="checking($(this))" <?php if(isset($array['4']['data'])){ if($array['4']['data'] == 'erc'){echo 'checked';}} ?> id="erc4">
					<label class="form-check-label" for="erc4" style="font-size:10px">Billing Party-ERC</label>
				</div>
			</div>
		</div>
		
		<!-- Party 5 -->
		<div class="col-md-4 pb-3 pt-3 border-right border-top border-bottom div_party" id="div-5">
			<label class="fw-normal">Party 5</label>
			<div class="form-group">
				<select class="form-control" style="width:100%" id="party-5" name="MasterNewJobBooking[also_notify1]" required>
					<option value="" disabled <?= isset($array['5']['party']) ? '' : 'selected' ?> hidden></option>
					<?php
						foreach($customer as $row){
							if(isset($array['5']['party'])){
								if($array['5']['party'] == $row['customer_id']){
									$selected = 'selected';
								}else{
									$selected = '';
								}
							}else{
								$selected = '';
							}
							echo "<option value='".$row['customer_id']."' ".$selected.">".
								$row['customer_companyname'].
							"</option>";
						}
					?>
				</select>
			</div>
			<div class="form-group">
				<select class="form-select form-select-lg" style="width:100%" id="party_alias-5" name="MasterNewJobBooking[also_notify2]" required>
					<option value="" disabled <?= isset($array['5']['alias']) ? '' : 'selected' ?> hidden></option>
					<?php
						if(isset($array['5']['party'])){
							$customer_alias5 = CustomerAlias::find()->where(['customer_id'=>$array['5']['party']])->orderBy(['customer_name'=>SORT_ASC])->all();
							
							foreach($customer_alias5 as $row){
								if($array['5']['alias'] == $row['customer_alias_id']){
									$selected = 'selected';
								}else{
									$selected = '';
								}
								
								echo "<option value='".$row['customer_alias_id']."' ".$selected.">".
									$row['customer_name'].
								"</option>";
							}
						}
					?>
				</select>
			</div>
			<div class="form-group">
				<textarea class="form-control" id="party_address-5" placeholder="" rows="5" name="MasterNewJobBooking[also_notify3]" readonly><?php if(isset($array['5']['address'])){echo str_replace("\\n","\n",$array['5']['address']);} ?></textarea>
			</div>
			
			<div class="row d-flex justify-content-between m-0">
				<div class="form-check form-check-inline mb-2 ml-2" style="width:18%">
					<input type="checkbox" class="form-check-input check_party_5 check_customer" name="customer" value="5" onchange="checking($(this))" <?php if(isset($array['5']['data'])){ if($array['5']['data'] == 'customer'){echo 'checked';}} ?> id="customer5">
					<label class="form-check-label" for="customer5" style="font-size:10px">Customer</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:22%">
					<input type="checkbox" class="form-check-input check_party_5 check_shipper" name="shipper" value="5" onchange="checking($(this))" <?php if(isset($array['5']['data'])){ if($array['5']['data'] == 'shipper'){echo 'checked';}} ?> id="shipper5">
					<label class="form-check-label" for="shipper5" style="font-size:10px">Shipper</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:20%">
					<input type="checkbox" class="form-check-input check_party_5 check_consignee" name="consignee" value="5" onchange="checking($(this))" <?php if(isset($array['5']['data'])){ if($array['5']['data'] == 'consignee'){echo 'checked';}} ?> id="consignee5">
					<label class="form-check-label" for="consignee5" style="font-size:10px">Consignee</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:25%">
					<input type="checkbox" class="form-check-input check_party_5 check_notify_party" name="notify" value="5" onchange="checking($(this))" <?php if(isset($array['5']['data'])){ if($array['5']['data'] == 'notify'){echo 'checked';}} ?> id="notify_party5">
					<label class="form-check-label" for="notify_party5" style="font-size:10px">Notify Party</label>
				</div>
			</div>
			<div class="row d-flex justify-content-between m-0">
				<div class="form-check form-check-inline mb-2 ml-2" style="width:18%">
					<input type="checkbox" class="form-check-input check_party_5 check_also_notify" name="also_notify" value="5" onchange="checking($(this))" <?php if(isset($array['5']['data'])){ if($array['5']['data'] == 'alsonotify'){echo 'checked';}} ?> id="also_notify5">
					<label class="form-check-label" for="also_notify5" style="font-size:10px">Also Notify</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:22%">
					<input type="checkbox" class="form-check-input check_party_5 check_agent" name="agent" value="5" onchange="checking($(this))" <?php if(isset($array['5']['data'])){ if($array['5']['data'] == 'agent'){echo 'checked';}} ?> id="agent5">
					<label class="form-check-label" for="agent5" style="font-size:10px">Routing Agent</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:20%">
					<input type="checkbox" class="form-check-input check_party_5 check_billing_party" name="billing_party" value="5" onchange="checking($(this))" <?php if(isset($array['5']['data'])){ if($array['5']['data'] == 'billing'){echo 'checked';}} ?> id="billing_party5">
					<label class="form-check-label" for="billing_party5" style="font-size:10px">Billing Party</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:25%">
					<input type="checkbox" class="form-check-input check_party_5 check_billing_party" name="erc" value="5" onchange="checking($(this))" <?php if(isset($array['5']['data'])){ if($array['5']['data'] == 'erc'){echo 'checked';}} ?> id="erc5">
					<label class="form-check-label" for="erc5" style="font-size:10px">Billing Party-ERC</label>
				</div>
			</div>
		</div>
		
		<!-- Party 6 -->
		<div class="col-md-4 pb-3 pt-3 border-top border-bottom" id="div-6">
			<label class="fw-normal">Party 6</label>
			<div class="form-group">
				<select class="form-control" style="width:100%" id="party-6" name="MasterNewJobBooking[agent1]" required>
					<option value="" disabled <?= isset($array['6']['party']) ? '' : 'selected' ?> hidden></option>
					<?php
						foreach($customer as $row){
							if(isset($array['6']['party'])){
								if($array['6']['party'] == $row['customer_id']){
									$selected = 'selected';
								}else{
									$selected = '';
								}
							}else{
								$selected = '';
							}
							echo "<option value='".$row['customer_id']."' ".$selected.">".
								$row['customer_companyname'].
							"</option>";
						}
					?>
				</select>
			</div>
			<div class="form-group">
				<select class="form-select form-select-lg" style="width:100%" id="party_alias-6" name="MasterNewJobBooking[agent2]" required>
					<option value="" disabled <?= isset($array['6']['alias']) ? '' : 'selected' ?> hidden></option>
					<?php
						if(isset($array['6']['party'])){
							$customer_alias6 = CustomerAlias::find()->where(['customer_id'=>$array['6']['party']])->orderBy(['customer_name'=>SORT_ASC])->all();
							
							foreach($customer_alias6 as $row){
								if($array['6']['alias'] == $row['customer_alias_id']){
									$selected = 'selected';
								}else{
									$selected = '';
								}
								
								echo "<option value='".$row['customer_alias_id']."' ".$selected.">".
									$row['customer_name'].
								"</option>";
							}
						}
					?>
				</select>
			</div>
			<div class="form-group">
				<textarea class="form-control" id="party_address-6" placeholder="" rows="5" name="MasterNewJobBooking[agent3]" readonly><?php if(isset($array['6']['address'])){echo str_replace("\\n","\n",$array['6']['address']);} ?></textarea>
			</div>
			
			<div class="row d-flex justify-content-between m-0">
				<div class="form-check form-check-inline mb-2 ml-2" style="width:18%">
					<input type="checkbox" class="form-check-input check_party_6 check_customer" name="customer" value="6" onchange="checking($(this))" <?php if(isset($array['6']['data'])){ if($array['6']['data'] == 'customer'){echo 'checked';}} ?> id="customer6">
					<label class="form-check-label" for="customer6" style="font-size:10px">Customer</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:22%">
					<input type="checkbox" class="form-check-input check_party_6 check_shipper" name="shipper" value="6" onchange="checking($(this))" <?php if(isset($array['6']['data'])){ if($array['6']['data'] == 'shipper'){echo 'checked';}} ?> id="shipper6">
					<label class="form-check-label" for="shipper6" style="font-size:10px">Shipper</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:20%">
					<input type="checkbox" class="form-check-input check_party_6 check_consignee" name="consignee" value="6" onchange="checking($(this))" <?php if(isset($array['6']['data'])){ if($array['6']['data'] == 'consignee'){echo 'checked';}} ?> id="consignee6">
					<label class="form-check-label" for="consignee6" style="font-size:10px">Consignee</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:25%">
					<input type="checkbox" class="form-check-input check_party_6 check_notify_party" name="notify" value="6" onchange="checking($(this))" <?php if(isset($array['6']['data'])){ if($array['6']['data'] == 'notify'){echo 'checked';}} ?> id="notify_party6">
					<label class="form-check-label" for="notify_party6" style="font-size:10px">Notify Party</label>
				</div>
			</div>
			<div class="row d-flex justify-content-between m-0">
				<div class="form-check form-check-inline mb-2 ml-2" style="width:18%">
					<input type="checkbox" class="form-check-input check_party_6 check_also_notify" name="also_notify" value="6" onchange="checking($(this))" <?php if(isset($array['6']['data'])){ if($array['6']['data'] == 'alsonotify'){echo 'checked';}} ?> id="also_notify6">
					<label class="form-check-label" for="also_notify6" style="font-size:10px">Also Notify</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:22%">
					<input type="checkbox" class="form-check-input check_party_6 check_agent" name="agent" value="6" onchange="checking($(this))" <?php if(isset($array['6']['data'])){ if($array['6']['data'] == 'agent'){echo 'checked';}} ?> id="agent6">
					<label class="form-check-label" for="agent6" style="font-size:10px">Routing Agent</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:20%">
					<input type="checkbox" class="form-check-input check_party_6 check_billing_party" name="billing_party" value="6" onchange="checking($(this))" <?php if(isset($array['6']['data'])){ if($array['6']['data'] == 'billing'){echo 'checked';}} ?> id="billing_party6">
					<label class="form-check-label" for="billing_party6" style="font-size:10px">Billing Party</label>
				</div>
				
				<div class="form-check form-check-inline mb-2" style="width:25%">
					<input type="checkbox" class="form-check-input check_party_6 check_erc" name="erc" value="6" onchange="checking($(this))" <?php if(isset($array['6']['data'])){ if($array['6']['data'] == 'erc'){echo 'checked';}} ?> id="erc6">
					<label class="form-check-label" for="erc6" style="font-size:10px">Billing Party-ERC</label>
				</div>
			</div>
		</div>
	</div>

	<!-- Row 3 -->
	<div class="row m-0" id="extend_party">
		<!-- Default value saat update-->
		<?php if(count($array) > 6){ ?>
			<?php 
				$no = 7;
				
				// Remove array data party < 7 dan foreach sisa nya
				unset($array[1]);
				unset($array[2]);
				unset($array[3]);
				unset($array[4]);
				unset($array[5]);
				unset($array[6]);
				
				foreach($array as $row){ 
			?>
				<div class="col-md-4 pb-3 pt-3 <?php if($no !== 9){echo 'border-right';} ?> border-top border-bottom" id="div-<?= $no ?>">
					<div class="row d-flex justify-content-between m-0">
						<label class="fw-normal title">Party <?= $no ?></label>
						<button type="button" class="btn btn-xs btn-danger mb-2" onclick="rmItem($(this))"><i class="fa fa-trash"></i></button>
					</div>
					
					<div class="form-group">
						<select class="form-control" style="width:100%" id="<?= 'party-'.$no ?>" name="MasterNewJobBooking[expand]" required>
							<option value="" disabled <?= isset($array[$no]['party']) ? '' : 'selected' ?> hidden></option>
							<?php
								foreach($customer as $row){
									if(isset($array[$no]['party'])){
										if($array[$no]['party'] == $row['customer_id']){
											$selected = 'selected';
										}else{
											$selected = '';
										}
									}else{
										$selected = '';
									}
									echo "<option value='".$row['customer_id']."' ".$selected.">".
										$row['customer_companyname'].
									"</option>";
								}
							?>
						</select>
					</div>
					<div class="form-group">
						<select class="form-select form-select-lg" style="width:100%" id="<?= 'party_alias-'.$no ?>" name="MasterNewJobBooking[expand]" required>
							<option value="" disabled <?= isset($array[$no]['alias']) ? '' : 'selected' ?> hidden></option>
							<?php
								if(isset($array[$no]['party'])){
									$customer_alias4 = CustomerAlias::find()->where(['customer_id'=>$array[$no]['party']])->orderBy(['customer_name'=>SORT_ASC])->all();
									
									foreach($customer_alias4 as $row){
										if($array[$no]['alias'] == $row['customer_alias_id']){
											$selected = 'selected';
										}else{
											$selected = '';
										}
										
										echo "<option value='".$row['customer_alias_id']."' ".$selected.">".
											$row['customer_name'].
										"</option>";
									}
								}
							?>
						</select>
					</div>
					<div class="form-group">
						<textarea class="form-control" id="<?= 'party_address-'.$no ?>" placeholder="" rows="5" name="MasterNewJobBooking[expand]" readonly><?php if(isset($array[$no]['address'])){echo str_replace("\\n","\n",$array[$no]['address']);} ?></textarea>
					</div>
					
					<div class="row d-flex justify-content-between m-0">
						<div class="form-check form-check-inline mb-2 ml-2" style="width:18%">
							<input type="checkbox" class="form-check-input <?= 'check_party_'.$no ?> check_customer" name="customer" value="<?= $no ?>" onchange="checking($(this))" <?php if(isset($array[$no]['data'])){ if($array[$no]['data'] == 'customer'){echo 'checked';}} ?> id="<?= 'customer'.$no ?>">
							<label class="form-check-label" for="<?= 'customer'.$no ?>" style="font-size:10px">Customer</label>
						</div>
						
						<div class="form-check form-check-inline mb-2" style="width:22%">
							<input type="checkbox" class="form-check-input <?= 'check_party_'.$no ?> check_shipper" name="shipper" value="<?= $no ?>" onchange="checking($(this))" <?php if(isset($array[$no]['data'])){ if($array[$no]['data'] == 'shipper'){echo 'checked';}} ?> id="<?= 'shipper'.$no ?>">
							<label class="form-check-label" for="<?= 'shipper'.$no ?>" style="font-size:10px">Shipper</label>
						</div>
						
						<div class="form-check form-check-inline mb-2" style="width:20%">
							<input type="checkbox" class="form-check-input <?= 'check_party_'.$no ?> check_consignee" name="consignee" value="<?= $no ?>" onchange="checking($(this))" <?php if(isset($array[$no]['data'])){ if($array[$no]['data'] == 'consignee'){echo 'checked';}} ?> id="<?= 'consignee'.$no ?>">
							<label class="form-check-label" for="<?= 'consignee'.$no ?>" style="font-size:10px">Consignee</label>
						</div>
						
						<div class="form-check form-check-inline mb-2" style="width:25%">
							<input type="checkbox" class="form-check-input <?= 'check_party_'.$no ?> check_notify_party" name="notify" value="<?= $no ?>" onchange="checking($(this))" <?php if(isset($array[$no]['data'])){ if($array[$no]['data'] == 'notify'){echo 'checked';}} ?> id="<?= 'notify_party'.$no ?>">
							<label class="form-check-label" for="<?= 'notify_party'.$no ?>" style="font-size:10px">Notify Party</label>
						</div>
					</div>
					<div class="row d-flex justify-content-between m-0">
						<div class="form-check form-check-inline mb-2 ml-2" style="width:18%">
							<input type="checkbox" class="form-check-input <?= 'check_party_'.$no ?> check_also_notify" name="also_notify" value="<?= $no ?>" onchange="checking($(this))" <?php if(isset($array[$no]['data'])){ if($array[$no]['data'] == 'alsonotify'){echo 'checked';}} ?> id="<?= 'also_notify'.$no ?>">
							<label class="form-check-label" for="<?= 'also_notify'.$no ?>" style="font-size:10px">Also Notify</label>
						</div>
						
						<div class="form-check form-check-inline mb-2" style="width:22%">
							<input type="checkbox" class="form-check-input <?= 'check_party_'.$no ?> check_agent" name="agent" value="<?= $no ?>" onchange="checking($(this))" <?php if(isset($array[$no]['data'])){ if($array[$no]['data'] == 'agent'){echo 'checked';}} ?> id="<?= 'agent'.$no ?>">
							<label class="form-check-label" for="<?= 'agent'.$no ?>" style="font-size:10px">Routing Agent</label>
						</div>
						
						<div class="form-check form-check-inline mb-2" style="width:20%">
							<input type="checkbox" class="form-check-input <?= 'check_party_'.$no ?> check_billing_party" name="billing_party" value="<?= $no ?>" onchange="checking($(this))" <?php if(isset($array[$no]['data'])){ if($array[$no]['data'] == 'billing'){echo 'checked';}} ?> id="<?= 'billing_party'.$no ?>">
							<label class="form-check-label" for="<?= 'billing_party'.$no ?>" style="font-size:10px">Billing Party</label>
						</div>
						
						<div class="form-check form-check-inline mb-2" style="width:25%">
							<input type="checkbox" class="form-check-input <?= 'check_party_'.$no ?> check_erc" name="erc" value="<?= $no ?>" onchange="checking($(this))" <?php if(isset($array[$no]['data'])){ if($array[$no]['data'] == 'erc'){echo 'checked';}} ?> id="<?= 'erc'.$no ?>">
							<label class="form-check-label" for="<?= 'erc'.$no ?>" style="font-size:10px">Billing Party-ERC</label>
						</div>
					</div>
				</div>
		
			<?php $no++;} ?>
		<?php } ?>
	</div>
	<button type="button" class="btn btn-dark mb-2" id="add_party" style="margin:10px 20px">+ Add Party</button>
<?php ActiveForm::end(); ?>
</div>

<script>
	$(document).ready(function(){
		// Saat update cek maks Append 3x, maka button add akan hilang
		count = $('.title').length;
		if(count == 3){
			$('#add_party').hide();
		}
		
		//Checking checkbox ulang untuk penamaan saat update
		billing = 0;
		setTimeout(function(){
			$('#party-index input:checkbox:checked').each(function(index, value){
				check = $('.check_party_'+(index+1)+':checked').attr('name');
				
				//Penamaan input untuk save DB
				input1 = $(this).parent().parent().parent().find('select:eq(0)').attr('id');
				input2 = $(this).parent().parent().parent().find('select:eq(1)').attr('id');
				input3 = $(this).parent().parent().parent().find('textarea:eq(0)').attr('id');
			
			
				if(check == 'customer'){
					$('#'+input1).prop('name', 'MasterNewJobBooking[cus1]');
					$('#'+input2).prop('name', 'MasterNewJobBooking[cus2]');
					$('#'+input3).prop('name', 'MasterNewJobBooking[cus3]');
				}
				
				if(check == 'shipper'){
					$('#'+input1).prop('name', 'MasterNewJobBooking[ship1]');
					$('#'+input2).prop('name', 'MasterNewJobBooking[ship2]');
					$('#'+input3).prop('name', 'MasterNewJobBooking[ship3]');
				}
				
				if(check == 'consignee'){
					$('#'+input1).prop('name', 'MasterNewJobBooking[consign1]');
					$('#'+input2).prop('name', 'MasterNewJobBooking[consign2]');
					$('#'+input3).prop('name', 'MasterNewJobBooking[consign3]');
				}

				if(check == 'notify'){
					$('#'+input1).prop('name', 'MasterNewJobBooking[notify_party1]');
					$('#'+input2).prop('name', 'MasterNewJobBooking[notify_party2]');
					$('#'+input3).prop('name', 'MasterNewJobBooking[notify_party3]');
				}
				
				if(check == 'also_notify'){
					$('#'+input1).prop('name', 'MasterNewJobBooking[also_notify1]');
					$('#'+input2).prop('name', 'MasterNewJobBooking[also_notify2]');
					$('#'+input3).prop('name', 'MasterNewJobBooking[also_notify3]');
				}

				if(check == 'agent'){
					$('#'+input1).prop('name', 'MasterNewJobBooking[agent1]');
					$('#'+input2).prop('name', 'MasterNewJobBooking[agent2]');
					$('#'+input3).prop('name', 'MasterNewJobBooking[agent3]');
				}
				
				if(check == 'billing_party'){
					billing += 1;
					
					$('#'+input1).prop('name', 'MasterNewJobBooking[billing_party_'+billing+']');
					$('#'+input2).prop('name', 'MasterNewJobBooking[billing_party_alias_'+billing+']');
					$('#'+input3).prop('name', 'MasterNewJobBooking[billing_party_address_'+billing+']');
					
					$(this).prop('name', 'billing_party_'+billing);
				}
				
				if(check == 'erc'){
					$('#'+input1).prop('name', 'MasterNewJobBooking[billing_party_erc]');
					$('#'+input2).prop('name', 'MasterNewJobBooking[billing_party_alias_erc]');
					$('#'+input3).prop('name', 'MasterNewJobBooking[billing_party_address_erc]');
				}
			});
		}, 700);
		
		check_complete_party();
	});
	
	$('#party-1').select2();
	$('#party-2').select2();
	$('#party-3').select2();
	$('#party-4').select2();
	$('#party-5').select2();
	$('#party-6').select2();
	$('#party-7').select2();
	
	//Pengecekan maksimal checkbox yg dicentang
	function checking(el){
		id = el.attr('id');
		type = el.attr('class');
		typex = type.split(' ')[2];
		
		if(typex == 'check_customer' || typex == 'check_shipper' || 
			typex == 'check_consignee'  || typex == 'check_agent' ||
			typex == 'check_notify_party' || typex == 'check_also_notify' || typex == 'check_erc' ){
			max = 1;
		}
		
		if(typex == 'check_billing_party'){
			max = 3;
		}
		
		checked_now = $('.'+typex+':checked').length;
		
		//Jika sdh batas max, checkbox dgn class yg sama tdk bs dicentang
		if(checked_now > max){
			$(el).prop('checked', false);
		}
		
		//Penamaan input untuk save DB
		input1 = el.parent().parent().parent().find('select:eq(0)').attr('id');
		input2 = el.parent().parent().parent().find('select:eq(1)').attr('id');
		input3 = el.parent().parent().parent().find('textarea:eq(0)').attr('id');
		
		setTimeout(function() { 
			checked = $('#'+id).is(':checked');
			
			if(typex == 'check_customer' && checked){
				$('#'+input1).prop('name', 'MasterNewJobBooking[cus1]');
				$('#'+input2).prop('name', 'MasterNewJobBooking[cus2]');
				$('#'+input3).prop('name', 'MasterNewJobBooking[cus3]');
			}
			
			if(typex == 'check_shipper' && checked){
				$('#'+input1).prop('name', 'MasterNewJobBooking[ship1]');
				$('#'+input2).prop('name', 'MasterNewJobBooking[ship2]');
				$('#'+input3).prop('name', 'MasterNewJobBooking[ship3]');
			}
			
			if(typex == 'check_consignee' && checked){
				$('#'+input1).prop('name', 'MasterNewJobBooking[consign1]');
				$('#'+input2).prop('name', 'MasterNewJobBooking[consign2]');
				$('#'+input3).prop('name', 'MasterNewJobBooking[consign3]');
			}
			
			if(typex == 'check_notify_party' && checked){
				$('#'+input1).prop('name', 'MasterNewJobBooking[notify_party1]');
				$('#'+input2).prop('name', 'MasterNewJobBooking[notify_party2]');
				$('#'+input3).prop('name', 'MasterNewJobBooking[notify_party3]');
			}
			
			if(typex == 'check_also_notify' && checked){
				$('#'+input1).prop('name', 'MasterNewJobBooking[also_notify1]');
				$('#'+input2).prop('name', 'MasterNewJobBooking[also_notify2]');
				$('#'+input3).prop('name', 'MasterNewJobBooking[also_notify3]');
			}

			if(typex == 'check_agent' && checked){
				$('#'+input1).prop('name', 'MasterNewJobBooking[agent1]');
				$('#'+input2).prop('name', 'MasterNewJobBooking[agent2]');
				$('#'+input3).prop('name', 'MasterNewJobBooking[agent3]');
			}
			
			if(typex == 'check_billing_party' && checked){
				// reset penamaan setiap kali ada perubahan, spy tdk ketumpuk nama yg sama
				$('.check_billing_party:checked').each(function(index, value){
					$('.check_billing_party:checked:eq('+index+')').parent().parent().parent().find('select:eq(0)').prop('name', 'MasterNewJobBooking[billing_party_'+(index+1)+']');
					$('.check_billing_party:checked:eq('+index+')').parent().parent().parent().find('select:eq(1)').prop('name', 'MasterNewJobBooking[billing_party_alias_'+(index+1)+']');
					$('.check_billing_party:checked:eq('+index+')').parent().parent().parent().find('textarea:eq(0)').prop('name', 'MasterNewJobBooking[billing_party_address_'+(index+1)+']');
				
					$('.check_billing_party:checked:eq('+index+')').prop('name', 'billing_party_'+(index+1));
				});
			}
			
			if(typex == 'check_erc' && checked){
				$('#'+input1).prop('name', 'MasterNewJobBooking[billing_party_erc]');
				$('#'+input2).prop('name', 'MasterNewJobBooking[billing_party_alias_erc]');
				$('#'+input3).prop('name', 'MasterNewJobBooking[billing_party_address_erc]');
			}
		}, 300);
	}
	
	//Clear notif error setiap change select / checkbox
	$('select, input[type=checkbox]').on('change', function(){
	   $('#error-party').css('display', 'none');
	});
	
	//Pengecekan checked only 1 checkbox setiap div
	$('.check_party_1').on('change', function(){
	   $('.check_party_1').not(this).prop('checked', false);
	});
	
	$('.check_party_2').on('change', function(){
	   $('.check_party_2').not(this).prop('checked', false);
	});
	
	$('.check_party_3').on('change', function(){
	   $('.check_party_3').not(this).prop('checked', false);
	});
	
	$('.check_party_4').on('change', function(){
	   $('.check_party_4').not(this).prop('checked', false);
	});
	
	$('.check_party_5').on('change', function(){
	   $('.check_party_5').not(this).prop('checked', false);
	});
	
	$('.check_party_6').on('change', function(){
	   $('.check_party_6').not(this).prop('checked', false);
	});

	$('.check_party_7').on('change', function(){
	   $('.check_party_7').not(this).prop('checked', false);
	});
		
	$('.check_party_8').on('change', function(){
	   $('.check_party_8').not(this).prop('checked', false);
	});
	
	$('.check_party_9').on('change', function(){
	   $('.check_party_9').not(this).prop('checked', false);
	});
	
	$('#party-1').change(function(){
		var key = $('#party-1').val();
		var id = 1;
		getparty(key, id);
		check_complete_party();
	});
	
	$('#party-2').change(function(){
		var key = $('#party-2').val();
		var id = 2;
		getparty(key, id);
		check_complete_party();
	});
	
	$('#party-3').change(function(){
		var key = $('#party-3').val();
		var id = 3;
		getparty(key, id);
		check_complete_party();
	});
	
	$('#party-4').change(function(){
		var key = $('#party-4').val();
		var id = 4;
		getparty(key, id);
		check_complete_party();
	});
	
	$('#party-5').change(function(){
		var key = $('#party-5').val();
		var id = 5;
		getparty(key, id);
		check_complete_party();
	});
	
	$('#party-6').change(function(){
		var key = $('#party-6').val();
		var id = 6;
		getparty(key, id);
		check_complete_party();
	});
	
	$('#party-7').change(function(){
		var key = $('#party-7').val();
		var id = 7;
		getparty(key, id);
		check_complete_party();
	});
	
	$('#party-8').change(function(){
		var key = $('#party-8').val();
		var id = 8;
		getparty(key, id);
		check_complete_party();
	});
	
	$('#party-9').change(function(){
		var key = $('#party-9').val();
		var id = 9;
		getparty(key, id);
		check_complete_party();
	});
	
	//Get customer alias address
	$('#party_alias-1').change(function(){
		var key = $('#party_alias-1').val();
		var id = 1;
		getpartyalias(key, id);
	});
	
	$('#party_alias-2').change(function(){
		var key = $('#party_alias-2').val();
		var id = 2;
		getpartyalias(key, id);
	});
	
	$('#party_alias-3').change(function(){
		var key = $('#party_alias-3').val();
		var id = 3;
		getpartyalias(key, id);
	});
	
	$('#party_alias-4').change(function(){
		var key = $('#party_alias-4').val();
		var id = 4;
		getpartyalias(key, id);
	});
	
	$('#party_alias-5').change(function(){
		var key = $('#party_alias-5').val();
		var id = 5;
		getpartyalias(key, id);
	});
	
	$('#party_alias-6').change(function(){
		var key = $('#party_alias-6').val();
		var id = 6;
		getpartyalias(key, id);
	});
	
	$('#party_alias-7').change(function(){
		var key = $('#party_alias-7').val();
		var id = 7;
		getpartyalias(key, id);
	});
	
	$('#party_alias-8').change(function(){
		var key = $('#party_alias-8').val();
		var id = 8;
		getpartyalias(key, id);
	});
	
	$('#party_alias-9').change(function(){
		var key = $('#party_alias-9').val();
		var id = 9;
		getpartyalias(key, id);
	});
	
	function ajax_party(el){
		id = el.attr('id');
		idx = id.split('-')[1];
		
		
		var key = $('#'+id).val();
		var id = idx;
		getparty(key, id);
		check_complete_party();
	}
	
	//Button add-remove
	$('#add_party').on('click', function(){
		$('#extend_party').children().eq(0).addClass('border-right');
		$('#extend_party').children().eq(1).addClass('border-right');
		
		id = $('#extend_party').children().eq($('#extend_party').children().length-1).attr('id');
        if(id){
            i = parseInt(id.split('-')[1])+1;
        }else{
            i = 7;
		}
		
		id2 = $('.check_billing_party:checked').length;console.log(id);console.log(i);
		if(id2){
            a = id2+1;
        }else{
            a = 1;
		}
		
		item = '';
		
		item += '<div class="col-md-4 pb-3 pt-3 border-top border-bottom" id="div-'+i+'">';
			item += '<div class="row d-flex justify-content-between m-0">';
				item += '<label class="fw-normal title">Party</label>';
				item += '<button type="button" class="btn btn-xs btn-danger mb-2" onclick="rmItem($(this))"><i class="fa fa-trash"></i></button>';
			item += '</div>';
			item += '<div class="form-group">';
				item += '<select class="form-control select_party" style="width:100%" id="party-'+i+'" onchange="ajax_party($(this))" required>';
					item += '<option value="" disabled selected hidden></option>';
					item += '<?php
						foreach($customer as $row){
							echo '<option value="'.$row['customer_id'].'">'.
								str_replace("'", "`",$row['customer_companyname']).
							'</option>';
						}
					?>';
				item += '</select>';
			item += '</div>';
			item += '<div class="form-group">';
				item += '<select class="form-select form-select-lg" style="width:100%" id="party_alias-'+i+'" required>';
					item += '<option value="" disabled selected hidden></option>';
					item += "<?php
						$customer_alias = CustomerAlias::find()->where(['customer_id'=>$jobbooking->contact1])->orderBy(['customer_name'=>SORT_ASC])->all();
						
						foreach($customer_alias as $row){
							echo "<option value='".$row['customer_alias_id']."'>".
								$row['customer_name'].
							"</option>";
						}
					?>";
				item += '</select>';
			item += '</div>';
			item += '<div class="form-group">';
				item += '<textarea class="form-control" id="party_address-'+i+'" placeholder="" rows="5" readonly></textarea>';
			item += '</div>';
			
			item += '<div class="row d-flex justify-content-between m-0">';
				item += '<div class="form-check form-check-inline mb-2 ml-2" style="width:18%">';
					item += '<input type="checkbox" class="form-check-input check_party_'+i+' check_customer" name="customer" value="'+i+'" onchange="checking($(this))" id="customer'+i+'">';
					item += '<label class="form-check-label" for="customer'+i+'" style="font-size:10px">Customer</label>';
				item += '</div>';
				
				item += '<div class="form-check form-check-inline mb-2" style="width:22%">';
					item += '<input type="checkbox" class="form-check-input check_party_'+i+' check_shipper" name="shipper" value="'+i+'" onchange="checking($(this))" id="shipper'+i+'">';
					item += '<label class="form-check-label" for="shipper'+i+'" style="font-size:10px">Shipper</label>';
				item += '</div>';
				
				item += '<div class="form-check form-check-inline mb-2" style="width:20%">';
					item += '<input type="checkbox" class="form-check-input check_party_'+i+' check_consignee" name="consignee" value="'+i+'" onchange="checking($(this))" id="consignee'+i+'">';
					item += '<label class="form-check-label" for="consignee'+i+'" style="font-size:10px">Consignee</label>';
				item += '</div>';
				
				item += '<div class="form-check form-check-inline mb-2" style="width:25%">';
					item += '<input type="checkbox" class="form-check-input check_party_'+i+' check_notify_party" name="notify" value="'+i+'" onchange="checking($(this))" id="notify_party'+i+'">';
					item += '<label class="form-check-label" for="notify_party'+i+'" style="font-size:10px">Notify Party</label>';
				item += '</div>';
			item += '</div>';
			item += '<div class="row d-flex justify-content-between m-0">';
				item += '<div class="form-check form-check-inline mb-2 ml-2" style="width:18%">';
					item += '<input type="checkbox" class="form-check-input check_party_'+i+' check_also_notify" name="also_notify" value="'+i+'" onchange="checking($(this))" id="also_notify'+i+'">';
					item += '<label class="form-check-label" for="also_notify'+i+'" style="font-size:10px">Also Notify</label>';
				item += '</div>';
				
				item += '<div class="form-check form-check-inline mb-2" style="width:22%">';
					item += '<input type="checkbox" class="form-check-input check_party_'+i+' check_agent" name="agent" value="'+i+'" onchange="checking($(this))" id="agent'+i+'">';
					item += '<label class="form-check-label" for="agent'+i+'" style="font-size:10px">Routing Agent</label>';
				item += '</div>';
				
				item += '<div class="form-check form-check-inline mb-2" style="width:20%">';
					item += '<input type="checkbox" class="form-check-input check_party_'+i+' check_billing_party" name="billing_party_'+a+'" value="'+i+'" onchange="checking($(this))" id="billing_party'+i+'">';
					item += '<label class="form-check-label" for="billing_party'+i+'" style="font-size:10px">Billing Party</label>';
				item += '</div>';
				
				item += '<div class="form-check form-check-inline mb-2" style="width:25%">';
					item += '<input type="checkbox" class="form-check-input check_party_'+i+' check_erc" name="erc" value="'+i+'" onchange="checking($(this))" id="erc'+i+'">';
					item += '<label class="form-check-label" for="erc'+i+'" style="font-size:10px">Billing Party-ERC</label>';
				item += '</div>';
			item += '</div>';
		item += '</div>';
		
		$("#extend_party").append(item);
		
		// Maksimal Append 3x, maka button akan hilang
		count = $('.title').length;
		if(count == 3){
			$('#add_party').hide();
		}
		
		// Rename ulang judul div
		var x = 0;
		var y = 7;
		 $('.title').each(function(){
			$('.title').eq(x).html('Party '+y);
			x++;
			y++;
		});
		
		$('.check_party_7').on('change', function(){
		   $('.check_party_7').not(this).prop('checked', false);
		});
		
		$('.check_party_8').on('change', function(){
		   $('.check_party_8').not(this).prop('checked', false);
		});
		
		$('.check_party_9').on('change', function(){
		   $('.check_party_9').not(this).prop('checked', false);
		});
		
		// Get alias setelah add 
		$('#party_alias-7').change(function(){
			var key = $('#party_alias-7').val();
			var id = 7;
			getpartyalias(key, id);
		});
		
		$('#party_alias-8').change(function(){
			var key = $('#party_alias-8').val();
			var id = 8;
			getpartyalias(key, id);
		});
		
		$('#party_alias-9').change(function(){
			var key = $('#party_alias-9').val();
			var id = 9;
			getpartyalias(key, id);
		});
	});
	
	function rmItem(el)
    {
		el.parent().parent().remove();
		
		// If append < 3, maka button add akan tampil
		count = $('.title').length;
		if(count < 3){
			$('#add_party').show();
		}
		
		// Rename ulang judul div
		var x = 0;
		var y = 7;
		 $('.title').each(function(){
			$('.title').eq(x).html('Party '+y);
			x++;
			y++;
		});
    }
	
	//Ajax party
	function getparty(key, id){
		$.ajax({
			url: '<?=Url::base().'/job/get-customer-alias'?>',
			data: {'id': key},
			dataType: 'json',
			method: 'POST',
            async: 'false'
		}).done(function(res){
			if(res.list_customer)
			{
				var list = res.list_customer;
				
				$('#party_alias-'+id).find('option').remove().end();
				
				list.forEach(a => {
					$('#party_alias-'+id).append('<option value="'+a['customer_alias_id']+'">'+a['customer_name']+'</option>');
				});
			}
			if(res.address){
				$('#party_address-'+id).val(res.address);
			}
		}).fail(function(err){
			
		});
	}
	
	//Ajax get address customer alias
	function getpartyalias(key, id){
		$.ajax({
			url: '<?=Url::base().'/job/get-customer-alias-address'?>',
			data: {'id': key},
			dataType: 'json',
			method: 'POST',
            async: 'false'
		}).done(function(res){
			if(res.data){
				$('#party_address-'+id).val(res.data['customer_alias']);
			}
		});
	}
	
	//check complete
	function check_complete_party(){
		if(($('#party-1').val() != '' && $('#party-1').val() != null) && 
			($('#party-2').val() != '' && $('#party-2').val() != null) &&
			($('#party-3').val() != ''  && $('#party-3').val() != null) && 
			($('#party-4').val() != ''  && $('#party-4').val() != null) &&
			($('#party-5').val() != ''  && $('#party-5').val() != null) && 
			($('#party-6').val() != '' && $('#party-6').val() != null) ){
			$('#heading9 h2').removeClass('uncomplete');
			$('#heading9 h2').addClass('complete');
			$('#heading9 .row div').removeClass('uncomplete');
			$('#heading9 .row div').addClass('complete');
		}else{
			$('#heading9 h2').addClass('uncomplete');
			$('#heading9 h2').removeClass('complete');
			$('#heading9 .row div').addClass('uncomplete');	
			$('#heading9 .row div').removeClass('complete');
		}
	}
</script>
