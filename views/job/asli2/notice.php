<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>

<div id="notif-index">
	<?php if(isset($_GET['id'])){ ?>
		<!--<a href="test_job_g3_import_print.php?job=<?= $_GET['id'] ?>" target="_blank" class="btn btn-dark">NOTICE OF ARRIVAL</a>
		<a href="test_job_g3_import_print_release.php?job=<?= $_GET['id'] ?>" target="_blank" class="btn btn-dark">DELIVERY ORDER RELEASE</a>-->
		<a href="../../../v9-native/test_job_g3_import_print.php?job=<?= $_GET['id'] ?>" target="_blank" class="btn btn-dark">NOTICE OF ARRIVAL</a>
		<a href="../../../v9-native/test_job_g3_import_print_release.php?job=<?= $_GET['id'] ?>" target="_blank" class="btn btn-dark">DELIVERY ORDER RELEASE</a>
	<?php }else{ ?>
		<a href="../../../v9-native/test_job_g3_import_print.php?job=1" target="_blank" class="btn btn-dark">NOTICE OF ARRIVAL</a>
		<a href="../../../v9-native/test_job_g3_import_print_release.php?job=1" target="_blank" class="btn btn-dark">DELIVERY ORDER RELEASE</a>
	<?php }?>
</div>
