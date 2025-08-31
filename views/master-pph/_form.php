<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MasterPph */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-pph-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= Html::hiddenInput('removed_details', '', ['id' => 'removed-details']) ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="panel panel-default mb-3">
        <div class="panel-heading">
            <h4>PPH Details</h4>
            <button type="button" class="btn btn-success" id="add-row">Add New Row</button>
        </div>
        <br>
        <div class="panel-body">
            <div style="border: 1px solid #ddd; padding: 15px; border-radius: 4px;">
                <div class="row" style="border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 15px;">
                    <div class="col-sm-4">
                        <label class="control-label"><b>Name</b></label>
                    </div>
                    <div class="col-sm-3">
                        <label class="control-label"><b>Amount</b></label>
                    </div>
                    <div class="col-sm-3">
                        <label class="control-label"><b>Validity</b></label>
                    </div>
                    <div class="col-sm-2">
                    </div>
                </div>
                <div id="pph-details">
                    <?php
                    if (!$model->isNewRecord && !empty($model->pphDetails)) {
                        foreach ($model->pphDetails as $i => $detail) { ?>
                            <div class="pph-row">
                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <?= Html::hiddenInput("details[$i][id]", $detail->id) ?>
                                            <input type="text" name="details[<?= $i ?>][name]" class="form-control" maxlength="true" value="<?= Html::encode($detail->name) ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="number" name="details[<?= $i ?>][amount]" class="form-control" step="0.01" value="<?= Html::encode($detail->amount) ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="date" name="details[<?= $i ?>][validity]" class="form-control" value="<?= Html::encode($detail->validity) ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-danger btn-sm remove-row" style="width: auto; padding: 5px 10px;" data-id="<?= $detail->id ?>"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } else { ?>
                        <div class="pph-row">
                            <div class="row" style="margin-bottom: 10px;">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <input type="text" name="details[0][name]" class="form-control" maxlength="true">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <input type="number" name="details[0][amount]" class="form-control" step="0.01">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <input type="date" name="details[0][validity]" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-danger btn-sm remove-row" style="width: auto; padding: 5px 10px;"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$js = <<<JS
$(document).ready(function() {
    var removedDetails = [];

    // Add new row
    $('#add-row').click(function() {
        var rowCount = $('.pph-row').length;
        var newRow = $('.pph-row').first().clone();
        
        // Update the input names with new index
        newRow.find('input').each(function() {
            var name = $(this).attr('name');
            name = name.replace(/\[\d+\]/, '[' + rowCount + ']');
            $(this).attr('name', name);
            $(this).val(''); // Clear the values
        });
        newRow.find('[name$="[id]"]').remove(); // Remove any ID field for new rows
        
        $('#pph-details').append(newRow);
    });

    // Remove row
    $(document).on('click', '.remove-row', function() {
        if ($('.pph-row').length > 1) {
            var detailId = $(this).data('id');
            if (detailId) {
                removedDetails.push(detailId);
                $('#removed-details').val(JSON.stringify(removedDetails));
            }
            
            $(this).closest('.pph-row').remove();
            
            // Reindex remaining rows
            $('.pph-row').each(function(index) {
                $(this).find('input').each(function() {
                    var name = $(this).attr('name');
                    if (name) {
                        name = name.replace(/\[\d+\]/, '[' + index + ']');
                        $(this).attr('name', name);
                    }
                });
            });
        } else {
            alert('Cannot remove the last row!');
        }
    });

    // Clear form fields in cloned row
    $(document).on('click', '#add-row', function() {
        var lastRow = $('.pph-row:last');
        lastRow.find('input[type="text"], input[type="number"], input[type="date"]').val('');
    });
});
JS;

$this->registerJs($js);
?>
