<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Batch */

$this->title = $model->batch_id;
$this->params['breadcrumbs'][] = ['label' => 'Batches', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="batch-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'batch_id' => $model->batch_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'batch_id' => $model->batch_id], [
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
            'batch_id',
            'pol_id',
            'pol_dod',
            'pc_vessel',
            'pc_voyage',
            'pcv_doa',
            'pcv_dod',
            'lfp_id',
            'lfp_doa',
            'lfp_dod',
            'lfp_vessel',
            'lfp_voyage',
            'pod_id',
            'pod_doa',
            'is_active',
        ],
    ]) ?>

</div>
