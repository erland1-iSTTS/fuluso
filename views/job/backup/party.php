<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Customer;
use app\models\CustomerAlias;
use app\models\MasterG3eHblCusdata;
use app\models\MasterG3eJobrouting;
use yii\helpers\VarDumper;

$customer = Customer::find()->where(['is_active'=>1])->orderBy(['customer_nickname'=>SORT_ASC])->all();

$data1 = MasterG3eHblCusdata::find()->where(['hblcusdata_job_id' => $_GET['id']])->one();
$data2 = MasterG3eJobrouting::find()->where(['jr_job_id' => $_GET['id']])->one();

if($party->isNewRecord){
	$checked = '';
}else{
	$checked = 'checked';
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
		<!-- Party 1 -->
		<div class="col-md-4 pb-3 border-right">
			<label class="fw-normal">Party 1</label>
			<div class="form-group">
				<select class="form-control" style="width:100%" id="party-1" name="MasterNewJobBooking[cus1]" required>
					<option></option>
					<?php
						foreach($customer as $row){
							if(isset($party->contact1)){
								if($party->contact1 == $row['customer_id']){
									$selected = 'selected';
								}else{
									$selected = '';
								}
							}else{
								$selected = '';
							}
							echo "<option value='".$row['customer_id']."' ".$selected.">".
								$row['customer_nickname'].
							"</option>";
						}
					?>
				</select>
			</div>
			<div class="form-group">
				<select class="form-select form-select-lg" style="width:100%" id="party_alias-1" name="MasterNewJobBooking[cus2]" required>
					<option value="" disabled selected hidden></option>
					<?php
						if(isset($party->contact1)){
							$customer_alias = CustomerAlias::find()->where(['customer_id'=>$party->contact1])->orderBy(['customer_name'=>SORT_ASC])->all();
							
							foreach($customer_alias as $row){
								if($party->contact2 == $row['customer_alias_id']){
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
				<textarea class="form-control" id="party_address-1" placeholder="" rows="5" name="MasterNewJobBooking[cus3]" readonly><?php if($party){echo str_replace("\\n","\n",$party->contact3);} ?></textarea>
			</div>
			
			<div class="row d-flex justify-content-between m-0">
				<div class="form-check form-check-inline mb-2 ml-2">
					<input type="checkbox" class="form-check-input check_party_1 check_customer" name="customer" value="1" onchange="checking($(this))" <?= $checked ?> id="customer1">
					<label class="form-check-label" for="customer1" style="font-size:10px">Customer</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="checkbox" class="form-check-input check_party_1 check_shipper" name="shipper" value="1" onchange="checking($(this))" id="shipper1">
					<label class="form-check-label" for="shipper1" style="font-size:10px">Shipper</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="checkbox" class="form-check-input check_party_1 check_consignee" name="consignee" value="1" onchange="checking($(this))" id="consignee1">
					<label class="form-check-label" for="consignee1" style="font-size:10px">Consignee</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="checkbox" class="form-check-input check_party_1 check_notify_party" name="notify" value="1" onchange="checking($(this))" id="notify_party1">
					<label class="form-check-label" for="notify_party1" style="font-size:10px">Notify Party</label>
				</div>
			</div>
			<div class="row d-flex justify-content-between m-0">
				<div class="form-check form-check-inline mb-2 ml-2">
					<input type="checkbox" class="form-check-input check_party_1 check_also_notify" name="also_notify" value="1" onchange="checking($(this))" id="also_notify1">
					<label class="form-check-label" for="also_notify1" style="font-size:10px">Also Notify</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="checkbox" class="form-check-input check_party_1 check_agent" name="agent" value="1" onchange="checking($(this))" id="agent1">
					<label class="form-check-label" for="agent1" style="font-size:10px">Routing Agent</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="checkbox" class="form-check-input check_party_1 check_billing_party" name="billing_party" value="1" onchange="checking($(this))" id="billing_party1">
					<label class="form-check-label" for="billing_party1" style="font-size:10px">Billing Party</label>
				</div>
			</div>
		</div>
		
		<!-- Party 2 -->
		<div class="col-md-4 pb-3 border-right">
			<label class="fw-normal">Party 2</label>
			<div class="form-group">
				<select class="form-control" style="width:100%" id="party-2" name="MasterNewJobBooking[ship1]" required>
					<option></option>
					<?php
						foreach($customer as $row){
							if(isset($data1->hblcusdata_shipper)){
								if($data1->hblcusdata_shipper == $row['customer_id']){
									$selected = 'selected';
								}else{
									$selected = '';
								}
							}else{
								$selected = '';
							}
							echo "<option value='".$row['customer_id']."' ".$selected.">".
								$row['customer_nickname'].
							"</option>";
						}
					?>
				</select>
			</div>
			<div class="form-group">
				<select class="form-select form-select-lg" style="width:100%" id="party_alias-2" name="MasterNewJobBooking[ship2]" required>
					<option value="" disabled selected hidden></option>
					<?php
						if(isset($data1->hblcusdata_shipper)){
							$customer_alias2 = CustomerAlias::find()->where(['customer_id'=>$data1->hblcusdata_shipper])->orderBy(['customer_name'=>SORT_ASC])->all();
							
							foreach($customer_alias2 as $row){
								if($data1->hblcusdata_shipper2 == $row['customer_alias_id']){
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
				<textarea class="form-control" id="party_address-2" placeholder="" rows="5" name="MasterNewJobBooking[ship3]" readonly><?php if($data1){echo str_replace("\\n","\n",$data1->hblcusdata_shipper_info);} ?></textarea>
			</div>
			
			<div class="row d-flex justify-content-between m-0">
				<div class="form-check form-check-inline mb-2 ml-2">
					<input type="checkbox" class="form-check-input check_party_2 check_customer" name="customer" value="2" onchange="checking($(this))" id="customer2">
					<label class="form-check-label" for="customer2" style="font-size:10px">Customer</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="checkbox" class="form-check-input check_party_2 check_shipper" name="shipper" value="2" onchange="checking($(this))" <?= $checked ?> id="shipper2">
					<label class="form-check-label" for="shipper2" style="font-size:10px">Shipper</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="checkbox" class="form-check-input check_party_2 check_consignee" name="consignee" value="2" onchange="checking($(this))" id="consignee2">
					<label class="form-check-label" for="consignee2" style="font-size:10px">Consignee</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="checkbox" class="form-check-input check_party_2 check_notify_party" name="notify" value="2" onchange="checking($(this))" id="notify_party2">
					<label class="form-check-label" for="notify_party2" style="font-size:10px">Notify Party</label>
				</div>
			</div>
			<div class="row d-flex justify-content-between m-0">
				<div class="form-check form-check-inline mb-2 ml-2">
					<input type="checkbox" class="form-check-input check_party_2 check_also_notify" name="also_notify" value="2" onchange="checking($(this))" id="also_notify2">
					<label class="form-check-label" for="also_notify2" style="font-size:10px">Also Notify</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="checkbox" class="form-check-input check_party_2 check_agent" name="agent" value="2" onchange="checking($(this))" id="agent2">
					<label class="form-check-label" for="agent2" style="font-size:10px">Routing Agent</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="checkbox" class="form-check-input check_party_2 check_billing_party" name="billing_party" value="2" onchange="checking($(this))" id="billing_party2">
					<label class="form-check-label" for="billing_party2" style="font-size:10px">Billing Party</label>
				</div>
			</div>
		</div>
		
		<!-- Party 3 -->
		<div class="col-md-4 pb-3">
			<label class="fw-normal">Party 3</label>
			<div class="form-group">
				<select class="form-control" style="width:100%" id="party-3" name="MasterNewJobBooking[consign1]" required>
					<option></option>
					<?php
						foreach($customer as $row){
							if(isset($data1->hblcusdata_consignee)){
								if($data1->hblcusdata_consignee == $row['customer_id']){
									$selected = 'selected';
								}else{
									$selected = '';
								}
							}else{
								$selected = '';
							}
							echo "<option value='".$row['customer_id']."' ".$selected.">".
								$row['customer_nickname'].
							"</option>";
						}
					?>
				</select>
			</div>
			<div class="form-group">
				<select class="form-select form-select-lg" style="width:100%" id="party_alias-3" name="MasterNewJobBooking[consign2]" required>
					<option value="" disabled selected hidden></option>
					<?php
						if(isset($data1->hblcusdata_consignee)){
							$customer_alias3 = CustomerAlias::find()->where(['customer_id'=>$data1->hblcusdata_consignee])->orderBy(['customer_name'=>SORT_ASC])->all();
							
							foreach($customer_alias3 as $row){
								if($data1->hblcusdata_consignee2 == $row['customer_alias_id']){
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
				<textarea class="form-control" id="party_address-3" placeholder="" rows="5" name="MasterNewJobBooking[consign3]" readonly><?php if($data1){echo str_replace("\\n","\n",$data1->hblcusdata_consignee_info);} ?></textarea>
			</div>
			
			<div class="row d-flex justify-content-between m-0">
				<div class="form-check form-check-inline mb-2 ml-2">
					<input type="checkbox" class="form-check-input check_party_3 check_customer" name="customer" value="3" onchange="checking($(this))" id="customer3">
					<label class="form-check-label" for="customer3" style="font-size:10px">Customer</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="checkbox" class="form-check-input check_party_3 check_shipper" name="shipper" value="3" onchange="checking($(this))" id="shipper3">
					<label class="form-check-label" for="shipper3" style="font-size:10px">Shipper</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="checkbox" class="form-check-input check_party_3 check_consignee" name="consignee" value="3" onchange="checking($(this))" <?= $checked ?> id="consignee3">
					<label class="form-check-label" for="consignee3" style="font-size:10px">Consignee</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="checkbox" class="form-check-input check_party_3 check_notify_party" name="notify" value="3" onchange="checking($(this))" id="notify_party3">
					<label class="form-check-label" for="notify_party3" style="font-size:10px">Notify Party</label>
				</div>
			</div>
			<div class="row d-flex justify-content-between m-0">
				<div class="form-check form-check-inline mb-2 ml-2">
					<input type="checkbox" class="form-check-input check_party_3 check_also_notify" name="also_notify" value="3" onchange="checking($(this))" id="also_notify3">
					<label class="form-check-label" for="also_notify3" style="font-size:10px">Also Notify</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="checkbox" class="form-check-input check_party_3 check_agent" name="agent" value="3" onchange="checking($(this))" id="agent3">
					<label class="form-check-label" for="agent3" style="font-size:10px">Routing Agent</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="checkbox" class="form-check-input check_party_3 check_billing_party" name="billing_party" value="3" onchange="checking($(this))" id="billing_party3">
					<label class="form-check-label" for="billing_party3" style="font-size:10px">Billing Party</label>
				</div>
			</div>
		</div>
	</div>

	<!-- Row 2 -->
	<div class="row m-0">
		<!-- Party 4 -->
		<div class="col-md-4 pb-3 pt-3 border-right border-top border-bottom">
			<label class="fw-normal">Party 4</label>
			<div class="form-group">
				<select class="form-control" style="width:100%" id="party-4" name="MasterNewJobBooking[notify_party1]" required>
					<option></option>
					<?php
						foreach($customer as $row){
							if(isset($data1->hblcusdata_notify)){
								if($data1->hblcusdata_notify == $row['customer_id']){
									$selected = 'selected';
								}else{
									$selected = '';
								}
							}else{
								$selected = '';
							}
							echo "<option value='".$row['customer_id']."' ".$selected.">".
								$row['customer_nickname'].
							"</option>";
						}
					?>
				</select>
			</div>
			<div class="form-group">
				<select class="form-select form-select-lg" style="width:100%" id="party_alias-4" name="MasterNewJobBooking[notify_party2]" required>
					<option value="" disabled selected hidden></option>
					<?php
						if(isset($data1->hblcusdata_notify)){
							$customer_alias4 = CustomerAlias::find()->where(['customer_id'=>$data1->hblcusdata_notify])->orderBy(['customer_name'=>SORT_ASC])->all();
							
							foreach($customer_alias4 as $row){
								if($data1->hblcusdata_notify2 == $row['customer_alias_id']){
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
				<textarea class="form-control" id="party_address-4" placeholder="" rows="5" name="MasterNewJobBooking[notify_party3]" readonly><?php if($data1){echo str_replace("\\n","\n",$data1->hblcusdata_notify_info);} ?></textarea>
			</div>
			
			<div class="row d-flex justify-content-between m-0">
				<div class="form-check form-check-inline mb-2 ml-2">
					<input type="checkbox" class="form-check-input check_party_4 check_customer" name="customer" value="4" onchange="checking($(this))" id="customer4">
					<label class="form-check-label" for="customer4" style="font-size:10px">Customer</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="checkbox" class="form-check-input check_party_4 check_shipper" name="shipper" value="4" onchange="checking($(this))" id="shipper4">
					<label class="form-check-label" for="shipper4" style="font-size:10px">Shipper</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="checkbox" class="form-check-input check_party_4 check_consignee" name="consignee" value="4" onchange="checking($(this))" id="consignee4">
					<label class="form-check-label" for="consignee4" style="font-size:10px">Consignee</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="checkbox" class="form-check-input check_party_4 check_notify_party" name="notify" value="4" onchange="checking($(this))" <?= $checked ?> id="notify_party4">
					<label class="form-check-label" for="notify_party4" style="font-size:10px">Notify Party</label>
				</div>
			</div>
			<div class="row d-flex justify-content-between m-0">
				<div class="form-check form-check-inline mb-2 ml-2">
					<input type="checkbox" class="form-check-input check_party_4 check_also_notify" name="also_notify" value="4" onchange="checking($(this))" id="also_notify4">
					<label class="form-check-label" for="also_notify4" style="font-size:10px">Also Notify</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="checkbox" class="form-check-input check_party_4 check_agent" name="agent" value="4" onchange="checking($(this))" id="agent4">
					<label class="form-check-label" for="agent4" style="font-size:10px">Routing Agent</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="checkbox" class="form-check-input check_party_4 check_billing_party" name="billing_party" value="4" onchange="checking($(this))" id="billing_party4">
					<label class="form-check-label" for="billing_party4" style="font-size:10px">Billing Party</label>
				</div>
			</div>
		</div>
		
		<!-- Party 5 -->
		<div class="col-md-4 pb-3 pt-3 border-right border-top border-bottom div_party">
			<label class="fw-normal">Party 5</label>
			<div class="form-group">
				<select class="form-control" style="width:100%" id="party-5" name="MasterNewJobBooking[also_notify1]" required>
					<option></option>
					<?php
						foreach($customer as $row){
							if(isset($data1->hblcusdata_alsonotify)){
								if($data1->hblcusdata_alsonotify == $row['customer_id']){
									$selected = 'selected';
								}else{
									$selected = '';
								}
							}else{
								$selected = '';
							}
							echo "<option value='".$row['customer_id']."' ".$selected.">".
								$row['customer_nickname'].
							"</option>";
						}
					?>
				</select>
			</div>
			<div class="form-group">
				<select class="form-select form-select-lg" style="width:100%" id="party_alias-5" name="MasterNewJobBooking[also_notify2]" required>
					<option value="" disabled selected hidden></option>
					<?php
						if(isset($data1->hblcusdata_alsonotify)){
							$customer_alias5 = CustomerAlias::find()->where(['customer_id'=>$data1->hblcusdata_alsonotify])->orderBy(['customer_name'=>SORT_ASC])->all();
							
							foreach($customer_alias5 as $row){
								if($data1->hblcusdata_alsonotify2 == $row['customer_alias_id']){
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
				<textarea class="form-control" id="party_address-5" placeholder="" rows="5" name="MasterNewJobBooking[also_notify3]" readonly><?php if($data1){echo str_replace("\\n","\n",$data1->hblcusdata_alsonotify_info);} ?></textarea>
			</div>
			
			<div class="row d-flex justify-content-between m-0">
				<div class="form-check form-check-inline mb-2 ml-2">
					<input type="checkbox" class="form-check-input check_party_5 check_customer" name="customer" value="5" onchange="checking($(this))" id="customer5">
					<label class="form-check-label" for="customer5" style="font-size:10px">Customer</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="checkbox" class="form-check-input check_party_5 check_shipper" name="shipper" value="5" onchange="checking($(this))" id="shipper5">
					<label class="form-check-label" for="shipper5" style="font-size:10px">Shipper</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="checkbox" class="form-check-input check_party_5 check_consignee" name="consignee" value="5" onchange="checking($(this))" id="consignee5">
					<label class="form-check-label" for="consignee5" style="font-size:10px">Consignee</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="checkbox" class="form-check-input check_party_5 check_notify_party" name="notify" value="5" onchange="checking($(this))" id="notify_party5">
					<label class="form-check-label" for="notify_party5" style="font-size:10px">Notify Party</label>
				</div>
			</div>
			<div class="row d-flex justify-content-between m-0">
				<div class="form-check form-check-inline mb-2 ml-2">
					<input type="checkbox" class="form-check-input check_party_5 check_also_notify" name="also_notify" value="5" onchange="checking($(this))" <?= $checked ?> id="also_notify5">
					<label class="form-check-label" for="also_notify5" style="font-size:10px">Also Notify</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="checkbox" class="form-check-input check_party_5 check_agent" name="agent" value="5" onchange="checking($(this))" id="agent5">
					<label class="form-check-label" for="agent5" style="font-size:10px">Routing Agent</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="checkbox" class="form-check-input check_party_5 check_billing_party" name="billing_party" value="5" onchange="checking($(this))" id="billing_party5">
					<label class="form-check-label" for="billing_party5" style="font-size:10px">Billing Party</label>
				</div>
			</div>
		</div>
		
		<!-- Party 6 -->
		<div class="col-md-4 pb-3 pt-3 border-top border-bottom">
			<label class="fw-normal">Party 6</label>
			<div class="form-group">
				<select class="form-control" style="width:100%" id="party-6" name="MasterNewJobBooking[agent1]" required>
					<option></option>
					<?php
						foreach($customer as $row){
							if(isset($data2->jr_agent_list)){
								if($data2->jr_agent_list == $row['customer_id']){
									$selected = 'selected';
								}else{
									$selected = '';
								}
							}else{
								$selected = '';
							}
							echo "<option value='".$row['customer_id']."' ".$selected.">".
								$row['customer_nickname'].
							"</option>";
						}
					?>
				</select>
			</div>
			<div class="form-group">
				<select class="form-select form-select-lg" style="width:100%" id="party_alias-6" name="MasterNewJobBooking[agent2]" required>
					<option value="" disabled selected hidden></option>
					<?php
						if(isset($data2->jr_agent_list)){
							$customer_alias6 = CustomerAlias::find()->where(['customer_id'=>$data2->jr_agent_list])->orderBy(['customer_name'=>SORT_ASC])->all();
							
							foreach($customer_alias6 as $row){
								if($data2->jr_agentcity_list == $row['customer_alias_id']){
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
				<textarea class="form-control" id="party_address-6" placeholder="" rows="5" name="MasterNewJobBooking[agent3]" readonly><?php if($data2){echo str_replace("\\n","\n",$data2->jr_agentloc);} ?></textarea>
			</div>
			
			<div class="row d-flex justify-content-between m-0">
				<div class="form-check form-check-inline mb-2 ml-2">
					<input type="checkbox" class="form-check-input check_party_6 check_customer" name="customer" value="6" onchange="checking($(this))" id="customer6">
					<label class="form-check-label" for="customer6" style="font-size:10px">Customer</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="checkbox" class="form-check-input check_party_6 check_shipper" name="shipper" value="6" onchange="checking($(this))" id="shipper6">
					<label class="form-check-label" for="shipper6" style="font-size:10px">Shipper</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="checkbox" class="form-check-input check_party_6 check_consignee" name="consignee" value="6" onchange="checking($(this))" id="consignee6">
					<label class="form-check-label" for="consignee6" style="font-size:10px">Consignee</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="checkbox" class="form-check-input check_party_6 check_notify_party" name="notify" value="6" onchange="checking($(this))" id="notify_party6">
					<label class="form-check-label" for="notify_party6" style="font-size:10px">Notify Party</label>
				</div>
			</div>
			<div class="row d-flex justify-content-between m-0">
				<div class="form-check form-check-inline mb-2 ml-2">
					<input type="checkbox" class="form-check-input check_party_6 check_also_notify" name="also_notify" value="6" onchange="checking($(this))" id="also_notify6">
					<label class="form-check-label" for="also_notify6" style="font-size:10px">Also Notify</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="checkbox" class="form-check-input check_party_6 check_agent" name="agent" value="6" onchange="checking($(this))" <?= $checked ?> id="agent6">
					<label class="form-check-label" for="agent6" style="font-size:10px">Routing Agent</label>
				</div>
				
				<div class="form-check form-check-inline mb-2">
					<input type="checkbox" class="form-check-input check_party_6 check_billing_party" name="billing_party" value="6" onchange="checking($(this))" id="billing_party6">
					<label class="form-check-label" for="billing_party6" style="font-size:10px">Billing Party</label>
				</div>
			</div>
		</div>
	</div>

	<!-- Row 3 -->
	<div class="row m-0" id="extend_party">
		
	</div>
	<button type="button" class="btn btn-dark mb-2" id="add_party" style="margin:10px 20px">+ Add Party</button>
<?php ActiveForm::end(); ?>
</div>

<script>
	$(document).ready(function(){
		change_select();
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
			typex == 'check_notify_party' || typex == 'check_also_notify'){
			max = 1;
		}
		
		if(typex == 'check_billing_party'){
			max = 4;
		}
		
		checked_now = $('.'+typex+':checked').length;
		
		//Jika sdh batax max, checkbox dgn class yg sama tdk bs dicentang
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
			
			if(typex == 'check_agent' && checked){
				$('#'+input1).prop('name', 'MasterNewJobBooking[agent1]');
				$('#'+input2).prop('name', 'MasterNewJobBooking[agent2]');
				$('#'+input3).prop('name', 'MasterNewJobBooking[agent3]');
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
			
			if(typex == 'check_billing_party' && checked){
				count = $('.check_billing_party:checked').length;
				
				$('#'+input1).prop('name', 'MasterNewJobBooking[billing_party_'+count+']');
				$('#'+input2).prop('name', 'MasterNewJobBooking[billing_party_alias_'+count+']');
				$('#'+input3).prop('name', 'MasterNewJobBooking[billing_party_address_'+count+']');
				
				$(el).prop('name', 'billing_party_'+count);
			}
		}, 300);
	}
	
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
	
	function ajax_party(el){
		id = el.attr('id');
		idx = id.split('-')[1];
		
		
		var key = $('#'+id).val();
		var id = idx;
		getparty(key, id);
		check_complete_party();
	}
	
	function change_select(){
		/*$('.select_party').select2({
		// $('#party-'+id).select2({
			tags: true,
			placeholder: "Select an Option",
			allowClear: true,
			width: '100%'
		});*/
		// $("select").select2("destroy").select2();
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
		
		id2 = $('.check_billing_party:checked').length;
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
					item += "<?php
						foreach($customer as $row){
							echo "<option value='".$row['customer_id']."'>".
								$row['customer_nickname'].
							"</option>";
						}
					?>";
				item += '</select>';
			item += '</div>';
			item += '<div class="form-group">';
				item += '<select class="form-select form-select-lg" style="width:100%" id="party_alias-'+i+'" required>';
					item += '<option value="" disabled selected hidden></option>';
					item += "<?php
						$customer_alias = CustomerAlias::find()->where(['customer_id'=>$party->contact1])->orderBy(['customer_name'=>SORT_ASC])->all();
						
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
				item += '<div class="form-check form-check-inline mb-2 ml-2">';
					item += '<input type="checkbox" class="form-check-input check_party_'+i+' check_customer" name="customer" value="'+i+'" onchange="checking($(this))" id="customer'+i+'">';
					item += '<label class="form-check-label" for="customer'+i+'" style="font-size:10px">Customer</label>';
				item += '</div>';
				
				item += '<div class="form-check form-check-inline mb-2">';
					item += '<input type="checkbox" class="form-check-input check_party_'+i+' check_shipper" name="shipper" value="'+i+'" onchange="checking($(this))" id="shipper'+i+'">';
					item += '<label class="form-check-label" for="shipper'+i+'" style="font-size:10px">Shipper</label>';
				item += '</div>';
				
				item += '<div class="form-check form-check-inline mb-2">';
					item += '<input type="checkbox" class="form-check-input check_party_'+i+' check_consignee" name="consignee" value="'+i+'" onchange="checking($(this))" id="consignee'+i+'">';
					item += '<label class="form-check-label" for="consignee'+i+'" style="font-size:10px">Consignee</label>';
				item += '</div>';
				
				item += '<div class="form-check form-check-inline mb-2">';
					item += '<input type="checkbox" class="form-check-input check_party_'+i+' check_notify_party" name="notify" value="'+i+'" onchange="checking($(this))" id="notify_party'+i+'">';
					item += '<label class="form-check-label" for="notify_party'+i+'" style="font-size:10px">Notify Party</label>';
				item += '</div>';
			item += '</div>';
			item += '<div class="row d-flex justify-content-between m-0">';
				item += '<div class="form-check form-check-inline mb-2 ml-2">';
					item += '<input type="checkbox" class="form-check-input check_party_'+i+' check_also_notify" name="also_notify" value="'+i+'" onchange="checking($(this))" id="also_notify'+i+'">';
					item += '<label class="form-check-label" for="also_notify'+i+'" style="font-size:10px">Also Notify</label>';
				item += '</div>';
				
				item += '<div class="form-check form-check-inline mb-2">';
					item += '<input type="checkbox" class="form-check-input check_party_'+i+' check_agent" name="agent" value="'+i+'" onchange="checking($(this))" id="agent'+i+'">';
					item += '<label class="form-check-label" for="agent'+i+'" style="font-size:10px">Routing Agent</label>';
				item += '</div>';
				
				item += '<div class="form-check form-check-inline mb-2">';
					item += '<input type="checkbox" class="form-check-input check_party_'+i+' check_billing_party" name="billing_party" value="'+i+'" onchange="checking($(this))" id="billing_party'+i+'">';
					item += '<label class="form-check-label" for="billing_party'+i+'" style="font-size:10px">Billing Party</label>';
				item += '</div>';
			item += '</div>';
		item += '</div>';
		
		$("#extend_party").append(item);
		
		change_select();
		
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
			// console.log(res);
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
	
	//check complete
	function check_complete_party(){
		if($('#party-1').val() != '' && $('#party-2').val() != '' &&
			$('#party-3').val() != '' && $('#party-4').val() != '' &&
			$('#party-5').val() != '' && $('#party-6').val() != ''){
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
