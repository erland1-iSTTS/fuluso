<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Bank */

$this->title = $model->b_id;
$this->params['breadcrumbs'][] = ['label' => 'Banks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="bank-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'b_id' => $model->b_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'b_id' => $model->b_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'b_id',
            'b_name',
            'b_code',
            'flag',
            'timestamp',
        ],
    ]) ?>

</div>
