<?php
use yii\helpers\Html;

$this->title = 'Update Master Pos';
$this->params['breadcrumbs'][] = ['label' => 'Master Pos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="pos-v8-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
