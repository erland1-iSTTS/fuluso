<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Master Data';
?>

<div class="menu-master">
	<div class="overview-panel">
		<div class="row">
			<div class="col-12">
				<div style="padding:5px;display:inline-block;">
					<a href="<?= url::base().'/master-vessel-routing/index' ?>" target="_blank" class="btn btn-dark">Master Vessel & Routing</a><br>
				</div>
				<div style="padding:5px;display:inline-block;">
					<a href="<?= url::base().'/master-profile/index' ?>" target="_blank" class="btn btn-dark">Master Profile</a>
				</div>
				<div style="padding:5px;display:inline-block;">
					<a href="<?= url::base().'/master-vessel/index' ?>" target="_blank" class="btn btn-dark">Master Vessel</a><br>
				</div>
				<div style="padding:5px;display:inline-block;">
					<a href="<?= url::base().'/master-pos-v8/index' ?>" target="_blank" class="btn btn-dark">Master Pos</a><br>
				</div>
				<div style="padding:5px;display:inline-block;">
					<a href="<?= url::base().'/point2/index' ?>" target="_blank" class="btn btn-dark">Master Point</a><br>
				</div>
				<div style="padding:5px;display:inline-block;">
					<a href="<?= url::base().'/point/index' ?>" target="_blank" class="btn btn-dark">Master Point Miror</a><br>
				</div>
			</div>
		</div>
		
		<hr style="margin:10px 0px">
		
		<div class="row">
			<div class="col-12">
				<div style="padding:5px;display:inline-block;">
					<a href="<?= url::base().'/master-packages/index' ?>" target="_blank" class="btn btn-dark">Master Packages</a><br>
				</div>
				<div style="padding:5px;display:inline-block;">
					<a href="<?= url::base().'/master-containercode/index' ?>" target="_blank" class="btn btn-dark">Master Container Prefix</a><br>
				</div>
				<div style="padding:5px;display:inline-block;">
					<a href="<?= url::base().'/master-movement/index' ?>" target="_blank" class="btn btn-dark">Master Movement</a><br>
				</div>
				<div style="padding:5px;display:inline-block;">
					<a href="<?= url::base().'/master-unit/index' ?>" target="_blank" class="btn btn-dark">Master Weight & Measurement</a><br>
				</div>
				<div style="padding:5px;display:inline-block;">
					<a href="<?= url::base().'/master-account-repr/index' ?>" target="_blank" class="btn btn-dark">Master Account Repr</a><br>
				</div>
				<div style="padding:5px;display:inline-block;">
					<a href="<?= url::base().'/master-source/index' ?>" target="_blank" class="btn btn-dark">Master Source</a><br>
				</div>
				<div style="padding:5px;display:inline-block;">
					<a href="<?= url::base().'/master-portfolio-account/index' ?>" target="_blank" class="btn btn-dark">Master Bank</a><br>
				</div>
				<div style="padding:5px;display:inline-block;">
					<a href="<?= url::base().'/master-signature/index' ?>" target="_blank" class="btn btn-dark">Master Signature</a><br>
				</div>
				<div style="padding:5px;display:inline-block;">
					<a href="<?= url::base().'/master-ppn/index' ?>" target="_blank" class="btn btn-dark">Master PPN</a><br>
				</div>
				<div style="padding:5px;display:inline-block;">
					<a href="<?= url::base().'/master-pph/index' ?>" target="_blank" class="btn btn-dark">Master PPH</a><br>
				</div>
			</div>
		</div>
		
		<hr style="margin:10px 0px">
		
		<div class="row">
			<div class="col-12">
				<!--<div style="padding:5px;display:inline-block;">
					<a href="<?php //url::base().'/mobile/approve-bl' ?>" target="_blank" class="btn btn-dark">Approval BL</a><br>
				</div>-->
				<div style="padding:5px;display:inline-block;">
					<a href="<?= url::base().'/apk/fuluso-container-v1.apk' ?>" download target="_blank" class="btn btn-dark">Aplikasi Container</a><br>
				</div>
				
				<div style="padding:5px;display:inline-block;">
					<a href="<?= url::base().'/apk/fuluso-app-container-v1.apk' ?>" download target="_blank" class="btn btn-dark">Aplikasi Approval BL</a><br>
				</div>
				
				<div style="padding:5px;display:inline-block;">
					<a href="<?= url::base().'/mobile-container/menu' ?>" target="_blank" class="btn btn-dark">Container Website</a><br>
				</div>
			</div>
		</div>
		
		<hr style="margin:10px 0px">
		
		<div class="row">
			<div class="col-12">
				<div style="padding:5px;display:inline-block;">
					<a href="<?= url::base().'/master-user/index' ?>" target="_blank" class="btn btn-dark">Master User</a><br>
				</div>
				
				<div style="padding:5px;display:inline-block;">
					<a href="<?= url::base().'/master-role/index' ?>" target="_blank" class="btn btn-dark">Master Role</a><br>
				</div>
				
				<div style="padding:5px;display:inline-block;">
					<a href="<?= url::base().'/master-hak-akses/index' ?>" target="_blank" class="btn btn-dark">Master Hak Akses</a><br>
				</div>
			</div>
		</div>
		
		<hr style="margin:10px 0px">
		
		<div class="row">
			<div class="col-12">
				<div style="padding:5px;display:inline-block;">
					<a href="<?= url::base().'/site/merge' ?>" target="_blank" class="btn btn-dark">Data Merge Customer</a><br>
				</div>
			</div>
		</div>
		
		<hr style="margin:10px 0px">
		
		<div class="row">
			<div class="col-12">
				<div style="padding:5px;display:inline-block;">
					<a href="<?= url::base().'/config/index' ?>" target="_blank" class="btn btn-dark">Configuration</a><br>
				</div>
			</div>
		</div>
	</div>
</div>
