<?php
use yii\helpers\Html;

$this->title = 'Update Master Bank';
$this->params['breadcrumbs'][] = ['label' => 'Master Bank', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="master-portfolio-account-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
