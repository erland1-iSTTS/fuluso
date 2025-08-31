<?php
use yii\helpers\Html;

$this->title = 'Create Master Vessel';
$this->params['breadcrumbs'][] = ['label' => 'Master Vessel', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="vessel-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
