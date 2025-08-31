<?php
use yii\helpers\Html;

$this->title = 'Update Master Container Prefix';
$this->params['breadcrumbs'][] = ['label' => 'Master Container Prefix', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="containercode-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
