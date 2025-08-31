<?php
$this->title = 'Fuluso';
?>

<div class="site-index">
	<ul class="nav nav-pills">
		<li class="nav-item"><a href="#batch" class="nav-link active" data-toggle="tab">Batch Kapal</a></li>
		<li class="nav-item"><a href="#job" class="nav-link" data-toggle="tab">Job Files</a></li>
		<li class="nav-item"><a href="#verify" class="nav-link" data-toggle="tab">Accounting</a></li>
		<li class="nav-item"><a href="#final" class="nav-link" data-toggle="tab">Final</a></li>
		<li class="nav-item"><a href="#report" class="nav-link" data-toggle="tab">Report</a></li>
		<li class="nav-item"><a href="#log" class="nav-link" data-toggle="tab">Log</a></li>
		<li class="nav-item"><a href="#master" class="nav-link" data-toggle="tab">Master Data</a></li>
	</ul>
	<br>
	<div class="tab-content">
		<div class="tab-pane active" id="batch"> 	
			<?= $this->render('batch-list') ?>
		</div>
		
		<div class="tab-pane" id="job">
			<?= $this->render('job-list.php') ?>
		</div>
		
		<div class="tab-pane" id="verify">Verification</div>
		<div class="tab-pane" id="final">Final</div>
		<div class="tab-pane" id="report">Report</div>
		
		<div class="tab-pane" id="log">
			<img src = "images/log.png" style="width:100%">
		</div>
		
		<div class="tab-pane" id="master">
			<div class="overview-panel">
				<div class="row">
					<div class="col-12">
						<div style="padding:5px;display:inline-block;">
							<a href="master-batch" class="btn btn-dark">Master Vessel & Routing</a><br>
						</div>
						<div style="padding:5px;display:inline-block;">
							<a href="master-profile" class="btn btn-dark">Master Profile</a>
						</div>
						<div style="padding:5px;display:inline-block;">
							<a href="master-vessel" class="btn btn-dark">Master Vessel</a><br>
						</div>
						<div style="padding:5px;display:inline-block;">
							<a href="master-pos-v8" class="btn btn-dark">Master Pos</a><br>
						</div>
						<div style="padding:5px;display:inline-block;">
							<a href="point2" class="btn btn-dark">Master Point</a><br>
						</div>
					</div>
				</div>
				
				<hr style="margin:10px 0px">
				
				<div class="row">
					<div class="col-12">
						<div style="padding:5px;display:inline-block;">
							<a href="master-packages" class="btn btn-dark">Master Packages</a><br>
						</div>
						<div style="padding:5px;display:inline-block;">
							<a href="master-containercode" class="btn btn-dark">Master Container Prefix</a><br>
						</div>
						<div style="padding:5px;display:inline-block;">
							<a href="master-movement" class="btn btn-dark">Master Movement</a><br>
						</div>
						<div style="padding:5px;display:inline-block;">
							<a href="master-unit" class="btn btn-dark">Master Weight & Measurement</a><br>
						</div>
						<div style="padding:5px;display:inline-block;">
							<a href="master-account-repr" class="btn btn-dark">Master Account Repr</a><br>
						</div>
						<div style="padding:5px;display:inline-block;">
							<a href="master-source" class="btn btn-dark">Master Source</a><br>
						</div>
						<div style="padding:5px;display:inline-block;">
							<a href="master-bank" class="btn btn-dark">Master Bank</a><br>
						</div>
						<div style="padding:5px;display:inline-block;">
							<a href="master-signature" class="btn btn-dark">Master Signature</a><br>
						</div>
						<div style="padding:5px;display:inline-block;">
							<a href="master-ppn" class="btn btn-dark">Master PPN</a><br>
						</div>
					</div>
				</div>
				
				<hr style="margin:10px 0px">
				
				<div class="row">
					<div class="col-12">
						<div style="padding:5px;display:inline-block;">
							<a href="mobile/login" class="btn btn-dark">Container</a><br>
						</div>
					</div>
				</div>
				
				<hr style="margin:10px 0px">
				
				<div class="row">
					<div class="col-12">
						<div style="padding:5px;display:inline-block;">
							<a href="site/merge" class="btn btn-dark">Data Merge Customer</a><br>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
