<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Modal;
use richardfan\widget\JSRegister;
use app\models\MasterHakAkses;
?>

<style>
	.btn-menu{
		text-decoration: none;
		border: none;
		text-align: left;
		color: #337ab7;
	}
	
	.btn-menu:hover{
		color: #0a58ca;
	}
	
	.btn-menu:focus{
		box-shadow: none;
	}
	
	h2{
		font-size:30px !important;
	}
</style>

<div class="accordion" id="panel_report">
	<!--<div class="card">
		<div class="card-header" id="heading1">
			<div class="row pl-2 pr-2">
				<h2 class="uncomplete m-0" style="width:100%;background-color:#eee" data-toggle="collapse" data-target="#collapse_report1">
					<button class="btn btn-menu" type="button" onclick="window.location='<?= Url::base().'/report/report-ar'?>'">
						REPORT AR
					</button>
				</h2>
			</div>
		</div>
	</div>
	
	<div class="card">
		<div class="card-header" id="heading2">
			<div class="row pl-2 pr-2">
				<h2 class="uncomplete m-0" style="width:100%;background-color:#eee" data-toggle="collapse" data-target="#collapse_report2">
					<button class="btn btn-menu" type="button" onclick="window.location='<?= Url::base().'/report/report-ap'?>'">
						REPORT AP
					</button>
				</h2>
			</div>
		</div>
	</div>-->
	
	<div class="card">
		<div class="card-header" id="heading3">
			<div class="row pl-2 pr-2">
				<h2 class="uncomplete m-0" style="width:100%;background-color:#eee" data-toggle="collapse" data-target="#collapse_report3">
					<button class="btn btn-menu" type="button" onclick="window.location='<?= Url::base().'/report/report-arb'?>'">
						REPORT AR-B&emsp;|&emsp;REPORT AP-B
					</button>
				</h2>
			</div>
		</div>
	</div>
	
	<!--<div class="card">
		<div class="card-header" id="heading3">
			<div class="row pl-2 pr-2">
				<h2 class="uncomplete m-0" style="width:100%;background-color:#eee" data-toggle="collapse" data-target="#collapse_report3">
					<button class="btn btn-menu" type="button" onclick="window.location='<?= Url::base().'/report/report-apb'?>'">
						REPORT AP-B
					</button>
				</h2>
			</div>
		</div>
	</div>-->
	
	<div class="card">
		<div class="card-header" id="heading4">
			<div class="row pl-2 pr-2">
				<h2 class="uncomplete m-0" style="width:100%;background-color:#eee" data-toggle="collapse" data-target="#collapse_report4">
					<button class="btn btn-menu" type="button" onclick="window.location='<?= Url::base().'/report/report-arc'?>'">
						REPORT AR-C&emsp;|&emsp;REPORT AP-C CONVERT&emsp;|&emsp;REPORT AP-C CASH&emsp;|&emsp;REPORT AP-C FIXED
					</button>
				</h2>
			</div>
		</div>
	</div>
	
	<!--<div class="card">
		<div class="card-header" id="heading5">
			<div class="row pl-2 pr-2">
				<h2 class="uncomplete m-0" style="width:100%;background-color:#eee" data-toggle="collapse" data-target="#collapse_report5">
					<button class="btn btn-menu" type="button" onclick="window.location='<?= Url::base().'/report/report-mr'?>'">
						REPORT MR
					</button>
				</h2>
			</div>
		</div>
	</div>
	
	<div class="card">
		<div class="card-header" id="heading6">
			<div class="row pl-2 pr-2">
				<h2 class="uncomplete m-0" style="width:100%;background-color:#eee" data-toggle="collapse" data-target="#collapse_report6">
					<button class="btn btn-menu" type="button" onclick="window.location='<?= Url::base().'/report/report-mp'?>'">
						REPORT MP
					</button>
				</h2>
			</div>
		</div>
	</div>-->
</div>
