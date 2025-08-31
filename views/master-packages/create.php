<?php
use yii\helpers\Html;

$this->title = 'Create Master Packages';
$this->params['breadcrumbs'][] = ['label' => 'Master Packages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="packages-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
