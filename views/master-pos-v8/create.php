<?php
use yii\helpers\Html;

$this->title = 'Create Master Pos';
$this->params['breadcrumbs'][] = ['label' => 'Master Pos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="pos-v8-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
