<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */

$this->title = $model->customer_id;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="customer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'customer_id' => $model->customer_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'customer_id' => $model->customer_id], [
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
            'customer_id',
            'customer_nickname',
            'customer_companyname',
            'customer_address:ntext',
            'customer_email_1:email',
            'customer_email_2:email',
            'customer_email_3:email',
            'customer_email_4:email',
            'customer_telephone',
            'customer_contact_person',
            'customer_npwp',
            'customer_npwp_file',
            'is_active',
            'customer_type',
            'status',
        ],
    ]) ?>

</div>
