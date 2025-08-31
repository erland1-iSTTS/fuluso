<?php
use yii\helpers\Html;

$this->title = 'Update Master Point';
$this->params['breadcrumbs'][] = ['label' => 'Master Point', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="point2-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
