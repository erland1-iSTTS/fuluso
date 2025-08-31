<?php
use yii\helpers\Url;
use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use app\models\MasterHakAkses;

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
	<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet" />
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
	<script src="https://use.fontawesome.com/666db995f7.js"></script>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        // 'brandLabel' => Html::img('@web/img/logo.png', ['class' => 'm-1', 'height' => '30px', 'alt' => 'Fuluso Transcorp']),
        'brandLabel' => Html::img('@web/img/newlogo.png', ['class' => 'm-1', 'height' => '30px', 'alt' => 'Fuluso Transcorp']),
        'brandUrl' => Yii::$app->homeUrl,
		'innerContainerOptions' => [
			'class' => 'container mw-100 p-0',
		],
        'options' => [
            // 'class' => 'navbar navbar-expand-xl bg-black navbar-dark border-bottom border-dark',
            'class' => 'navbar navbar-expand-xl navbar-light border-bottom border-dark',
        ],
    ]);
	
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav pl-3'],
        'items' => [
            ['label' => 'BATCH KAPAL', 'url' => ['/batch/index']],
            ['label' => 'JOB', 'url' => ['/job/index']],
            ['label' => 'COST OPR', 'url' => ['/job/index']],
            ['label' => 'ACCOUNTING', 'url' => ['/accounting/index']],
            ['label' => 'REPORT', 'url' => ['/report/index']],
            ['label' => 'FINAL', 'url' => ['/final/index']],
            ['label' => 'LOG', 'url' => ['/log/index']],
            ['label' => 'MASTER', 'url' => ['/master/index']],
			
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li class="btn-logout">'
				
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
				. '<span class="label-username">'.Yii::$app->user->identity->username.'</span>'
                . Html::submitButton(
                    '<i class="fa fa-sign-out"></i>',
                    ['class' => 'btn btn-link logout', 'title' => 'LOGOUT']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
	
    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container pt-4" style="max-width:98%">
        <?= $content ?>
    </div>
</main>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
