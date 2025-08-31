<?php
use yii\helpers\Html;

$this->title = 'Create Master Signature';
$this->params['breadcrumbs'][] = ['label' => 'Master Signature', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="signature-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
