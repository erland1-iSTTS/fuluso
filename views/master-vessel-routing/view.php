<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'View Master Vessel & Routing';
$this->params['breadcrumbs'][] = ['label' => 'Master Vessel & Routing', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="vessel-routing-view">
	<h1><?= Html::encode($this->title) ?></h1>

    <div class="row" style="margin-top:20px">
		<div class="col-12">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th width="30%" style="background-color:#ffffcc">VESSEL & VOY</th>
						<th width="28%" class="text-center" style="background-color:#ffffcc">ETD</th>
						<th width="28%" class="text-center" style="background-color:#ffffcc">ETA</th>
						<th width="14%" style="background-color:#fae4d7">REFERENCE</th>
					</tr>
				</thead>
				
				<tbody>
				<?php
					$last_key = count($details)-1;
					$i=0;
					foreach($details as $key => $detail){
				?>
					<tr>
						<td>
							<div class="row">
								<div class="col-7">
									<input type="text" class="form-control" value="<?= $detail['vessel_code'] ?>" readonly>
								</div>
								<div class="col-5 pl-0">
									<input type="text" class="form-control" value="<?= $detail['voyage'] ?>" readonly>
								</div>
								<div class="col-12 pt-3">
									<?php $detail->laden_on_board == 1 ? $checked = 'checked' : $checked = ''; ?>
								
									<input type="checkbox" <?= $checked ?> disabled>
									<label class="form-check-label">&nbsp;Laden On Board</label>
								</div>
							</div>
						</td>
						<td>
							<div class="row">
								<div class="col-6">
									<input type="text" class="form-control" value="<?= $detail['point_etd'] ?>" readonly>
								</div>
								<div class="col-6 pl-0">
									<input type="date" class="form-control" value="<?= $detail['date_etd'] ?>" readonly>
								</div>
							</div>
						</td>
						<td>
							<div class="row">
								<div class="col-6">
									<input type="text" class="form-control" value="<?= $detail['point_eta'] ?>" readonly>
								</div>
								<div class="col-6 pl-0">
									<input type="date" class="form-control" value="<?= $detail['date_eta'] ?>" readonly>
								</div>
							</div>
						</td>
						<td>
							<input type="text" class="form-control" value="<?= $detail['reference'] ?>" readonly>
						</td>
					</tr>
				<?php $i++;} ?>
				</tbody>
			</table>
		</div>
	</div>
	
	<p>
		<?= Html::a('Back', ['index'], ['class' => 'btn btn-default']) ?>
	</p>
</div>
