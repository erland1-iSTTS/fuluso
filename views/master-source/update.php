<?php
use yii\helpers\Html;

$this->title = 'Update Master Source';
$this->params['breadcrumbs'][] = ['label' => 'Master Source', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="source-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
