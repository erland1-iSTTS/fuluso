<?php
use yii\helpers\Html;

$this->title = 'Update Master Movement';
$this->params['breadcrumbs'][] = ['label' => 'Master Movement', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="movement-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
