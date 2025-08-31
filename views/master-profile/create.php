<?php
use yii\helpers\Html;

$this->title = 'Create Master Profile';
?>

<div class="master-profile-create">
    <h4 style="font-weight:700">Add New Master Profile</h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
