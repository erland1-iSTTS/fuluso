<?php
use yii\helpers\Url;
use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use app\models\MasterHakAkses;

// Get path Url, to set active sidebar
$url =  parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = explode('/', $url);
$length = count($path);

$controller = $path[$length-2];
$href = Url::to([$controller.'/index']); 

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
	<meta name="apple-mobile-web-app-title" content="BestForming">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link rel="manifest" href="<?= Url::base()?>/manifest.json">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
	<!-- Tambahan -->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
	<script src="https://use.fontawesome.com/666db995f7.js"></script>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<?php
	if(Yii::$app->user->identity){
		$akses_home		  = MasterHakAkses::find()->where(['id_role' => Yii::$app->user->identity->id_role, 'id_menu' => 1])->one();
		$akses_batch 	  = MasterHakAkses::find()->where(['id_role' => Yii::$app->user->identity->id_role, 'id_menu' => 2])->one();
		$akses_job 		  = MasterHakAkses::find()->where(['id_role' => Yii::$app->user->identity->id_role, 'id_menu' => 3])->one();
		$akses_ap 		  = MasterHakAkses::find()->where(['id_role' => Yii::$app->user->identity->id_role, 'id_menu' => 4])->one();
		$akses_accounting = MasterHakAkses::find()->where(['id_role' => Yii::$app->user->identity->id_role])->andWhere(['IN', 'id_menu', [5,6]])->one();
		$akses_final 	  = MasterHakAkses::find()->where(['id_role' => Yii::$app->user->identity->id_role, 'id_menu' => 7])->one();
		$akses_log 		  = MasterHakAkses::find()->where(['id_role' => Yii::$app->user->identity->id_role, 'id_menu' => 8])->one();
		$akses_master     = MasterHakAkses::find()->where(['id_role' => Yii::$app->user->identity->id_role, 'id_menu' => 9])->one();
		$akses_cost_other = MasterHakAkses::find()->where(['id_role' => Yii::$app->user->identity->id_role, 'id_menu' => 11])->one();
		
		
		
		if($akses_home){
			$visible_home = '';
		}else{
			$visible_home = 'none';
		}
		
		if($akses_batch){
			$visible_batch = '';
		}else{
			$visible_batch = 'none';
		}
		
		if($akses_job){
			$visible_job = '';
		}else{
			$visible_job = 'none';
		}
		
		if($akses_ap){
			$visible_ap = '';
		}else{
			$visible_ap = 'none';
		}
		
		if($akses_accounting){
			$visible_acc = '';
		}else{
			$visible_acc = 'none';
		}
		
		if($akses_final){
			$visible_final = '';
		}else{
			$visible_final = 'none';
		}
		
		if($akses_log){
			$visible_log = '';
		}else{
			$visible_log = 'none';
		}
		
		if($akses_master){
			$visible_master = '';
		}else{
			$visible_master = 'none';
		}
		
		if($akses_cost_other){
			$visible_cost_other = '';
		}else{
			$visible_cost_other = 'none';
		}
		
		if(Yii::$app->user->identity->id_role == 2){
			$visible_cost_other = '';
		}
	}else{
		$visible_home = 'none';
		$visible_batch = 'none';
		$visible_job = 'none';
		$visible_ap = 'none';
		$visible_acc = 'none';
		$visible_final = 'none';
		$visible_log = 'none';
		$visible_master = 'none';
		$visible_cost_other = 'none';
	}
?>

<main role="main" class="flex-shrink-0">
    <div class="container" style="max-width:85%">
		<ul class="nav nav-pills menu float-right">
			<li class="nav-item pt-2 pr-3" style="color:darkgray"><?= Yii::$app->user->identity  ?  Yii::$app->user->identity->role->role_name : '' ?></li>
			<li class="nav-item"><a href="<?= Url::base().'/site/logout' ?>" class="nav-link" data-method="post" style="color:black;border:1px solid black;background-color:transparent !important">Logout</a></li>
		</ul>
		<ul class="nav nav-pills menu">
			<li class="nav-item" style="display:<?= $visible_batch ?>"><a href="<?= Url::base().'/batch/index' ?>" class="nav-link" data-toggle="tab">Batch Kapal</a></li>
			<li class="nav-item" style="display:<?= $visible_job ?>"><a href="<?= Url::base().'/job/index' ?>" class="nav-link" data-toggle="tab">Job File</a></li>
			<li class="nav-item" style="display:<?= $visible_cost_other ?>"><a href="<?= Url::base().'/cost-other/index' ?>" class="nav-link" data-toggle="tab">Cost Opr</a></li>
			<!--<li class="nav-item" style="display:<?= $visible_ap ?>"><a href="<?= Url::base().'/ap/index' ?>" class="nav-link" data-toggle="tab">AP</a></li>-->
			<li class="nav-item" style="display:<?= $visible_acc ?>"><a href="<?= Url::base().'/accounting/index' ?>" class="nav-link" data-toggle="tab">Accounting</a></li>
			<li class="nav-item" style="display:<?= $visible_acc ?>"><a href="<?= Url::base().'/report/index' ?>" class="nav-link" data-toggle="tab">Report</a></li>
			<li class="nav-item" style="display:<?= $visible_final ?>"><a href="<?= Url::base().'/final/index' ?>" class="nav-link" data-toggle="tab">Final</a></li>
			<li class="nav-item" style="display:<?= $visible_log ?>"><a href="<?= Url::base().'/log/index' ?>" class="nav-link" data-toggle="tab">Log</a></li>
			<li class="nav-item" style="display:<?= $visible_master ?>"><a href="<?= Url::base().'/master/index' ?>" class="nav-link" data-toggle="tab">Master Data</a></li>
		</ul>
		<br>
        <?= $content ?>
    </div>
</main>

<script>
	$(document).ready(function(){
		$('.menu a').on('click', function(e){
			localStorage.setItem('activeTab', $(e.target).attr('href'));
			var link = $(e.target).attr('href');
			location.href = link;
		});	
		
		var activeTab = localStorage.getItem('activeTab');
		
		if(activeTab){
			$('.menu').find('.active').removeClass('active');
			$('.menu a[href="' + activeTab + '"]').addClass('active');
		}else{
			$('.menu a[href="<?= Url::base()?>/batch/index"]').addClass('active');
		}
	});
	
	
	/*$(document).ready(function(){
		// Set active sidebar same as url controller/index
		var url = window.location.pathname.split('/');
		var length = url.length;
		var controller = url[length-2];
		
		console.log(url);
		console.log(length);
		console.log(controller);
		
		// $('.nav-item, .nav-link').removeClass('menu-open').removeClass('active');
		
		// $('.nav-link[href*="<?= $href ?>"]').addClass('active');
		// $('.nav-link[href*="<?= $href ?>"]').parents('li').children('a').addClass('active');
		// $('.nav-link[href*="<?= $href ?>"]').parents('li').addClass('menu-open active');
	});*/
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
