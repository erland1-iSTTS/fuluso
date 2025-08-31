<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MasterPpn */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Master Ppns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="master-ppn-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php //DetailView::widget([
        //'model' => $model,
        //'attributes' => [
        //    'name',
        //],
    //]) 
    ?>

    <div class="card">
        <div class="card-body">
            <h3>Details</h3>
            <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Validity</th>
                  </tr>
                </thead>
                <tbody>
                    <?php foreach ($model->ppnDetails as $key => $value) { ?>
                      <tr>
                          <th scope="row"><?= $key + 1 ?></th>
                          <td><?= $value->name ?></td>
                          <td><?= $value->amount ?></td>
                          <td><?= $value->validity ?></td>
                      </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
