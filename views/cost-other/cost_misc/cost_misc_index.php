<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Customer;
use app\models\MasterNewJobcost;
use app\models\MasterNewJobcostDetail;
use app\models\MasterNewJobvoucher;
use yii\helpers\VarDumper;
?>

<style>
	.red{
		color:red;
	}
</style>

<div id="index-cost-misc">
	<div class="row">
		<div class="col-1 pr-0">
			<select class="form-control">
				<option>JAN</option>
				<option>FEB</option>
				<option>MAR</option>
				<option>APR</option>
				<option>MAY</option>
				<option>JUN</option>
				<option>JUL</option>
			</select>
		</div>
		<div class="col-1 pr-0">
			<select class="form-control">
				<option>2023</option>
				<option>2022</option>
				<option>2021</option>
			</select>
		</div>
		&emsp;&nbsp;&nbsp;
		<div class="form-check form-check-inline">
			<input type="radio" class="form-check-input" id="pos-type1" name="pos-type" value="1" checked>
			<label class="form-check-label" for="pos-type1">All</label>
			&emsp;&nbsp;&nbsp;
			<input type="radio" class="form-check-input" id="pos-type2" name="pos-type" value="2">
			<label class="form-check-label" for="pos-type2">Outstanding</label>
			&emsp;&nbsp;&nbsp;
			<input type="radio" class="form-check-input" id="pos-type2" name="pos-type" value="2">
			<label class="form-check-label" for="pos-type2">Paid</label>
		</div>
		&emsp;&nbsp;&nbsp;
		<button type="button" class="btn btn-default">FILTER</button>
		&emsp;
		<button type="button" class="btn btn-default">RESET</button>
	</div>
	
	<hr>
	<div class="row">
		<div class="col-12">
			<table class="table" id="table-cost-misc" style="font-size:12px">
				<thead class="table-secondary">
					<tr>
						<th width="8%">Cost No</th>
						<th width="8%">Date</th>
						<th width="8%">Payee</th>
						<th width="10%">Pos</th>
						<th width="12%">Description</th>
						<th width="8%" class="text-right">Dpp</th>
						<th width="8%" class="text-right">PPN</th>
						<th width="8%" class="text-right">Netto</th>
						<th width="8%" class="text-right">Outstanding</th>
						<th width="22%"></th>
					</tr>
				</thead>
				<tbody>
					<?php
						// $cost_hmc = MasterNewJobcost::find()->where(['vch_job_id' => $_GET['id'], 'vch_currency' => 'USD', 'vch_is_active' => 1])->orderBy(['vch_count'=>SORT_DESC])->all();
						// $i = 0;
						// foreach($cost_hmc as $row){
						
						// $customer_cost_hmc = Customer::find()->where(['customer_id'=>$row['vch_pay_for'], 'is_active' => 1])->one();
					?>
						<tr>
							<td>AP-<span class="red">X-000000</span></td>
							<td>5 Jan 2023</td>
							<td>PT ABC</td>
							<td>BEL KEBERSIHAN</td>
							<td>JAN 2023</td>
							<td>1,000,000</td>
							<td>110,000</td>
							<td>1,110,000</td>
							<td>50,000</td>
							<td>
								<button type="button" class="btn btn-dark">View</button>
								<button type="button" class="btn btn-dark">Edit</button>
								<button type="button" class="btn btn-dark" onclick="createApMisc()">AP</button>
								<button type="button" class="btn btn-dark">Print AP</button>
							</td>
						</tr>
						<tr>
							<td>AP-<span class="red">X-000000</span></td>
							<td>4 Jan 2023</td>
							<td>PT ABC</td>
							<td>BEL BBM</td>
							<td>SOLAR B 777 FLS</td>
							<td>1,200,000</td>
							<td>120,000</td>
							<td>1,320,000</td>
							<td>80,000</td>
							<td>
								<button type="button" class="btn btn-dark">View</button>
								<button type="button" class="btn btn-dark">Edit</button>
								<button type="button" class="btn btn-dark" onclick="createApMisc()">AP</button>
								<button type="button" class="btn btn-dark">Print AP</button>
							</td>
						</tr>
						<tr>
							<td>AP-B-230801</span></td>
							<td>11 Jan 2023</td>
							<td>PT ABC</td>
							<td>BIA LAIN-LAIN</td>
							<td>-</td>
							<td>2,000,000</td>
							<td>20,000</td>
							<td>2,020,000</td>
							<td>0</td>
							<td>
								<button type="button" class="btn btn-dark">View</button>
								<button type="button" class="btn btn-dark btn-sm">Print AP</button>
							</td>
						</tr>
					<?php //$i++;} ?>
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
