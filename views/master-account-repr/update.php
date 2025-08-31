<?php
use yii\helpers\Html;

$this->title = 'Update Master Account Repr';
$this->params['breadcrumbs'][] = ['label' => 'Master Account Repr', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="account-repr-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
