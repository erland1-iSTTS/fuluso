<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use richardfan\widget\JSRegister;
use kartik\select2\Select2;
use app\models\Container;
use app\models\Containercode;
?>

<div class="container-form">
    <?php $form = ActiveForm::begin(); ?>
	
    <?php
        $list_prefix = ArrayHelper::map(Containercode::find()->andWhere(['is_active'=>1])->all(),'containercode_name','containercode_name');

        echo $form->field($model, 'con_code')->widget(Select2::classname(), [
            'data' => $list_prefix,
            'options' => ['placeholder' => ''],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>
	
    <?= $form->field($model, 'con_text', ['enableAjaxValidation' => true])->textInput(['type'=>'number', 'minlength'=>7, 'maxlength' => true, 'min'=>1, 'max'=>9999999, 'onkeypress'=>'return onlyNumberKey(event)']) ?>
	
	<?php
        $list_type = ArrayHelper::map(Container::find()->andWhere(['is_active'=>1])->all(),'container_name','container_name');

        echo $form->field($model, 'con_name')->widget(Select2::classname(), [
            'data' => $list_type,
            'options' => ['placeholder' => ''],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>


    <div class="form-group">
		<div class="row">
			<div class="col-12 mt-2 mb-3">
				<?= Html::submitButton('Save', ['class' => 'btn btn-dark w-100']) ?>
			</div>
			<div class="col-12">
				<?= Html::a('Cancel', '../mobile-container/menu', ['style'=>'color:black;text-decoration:none']) ?>
			</div>
		</div>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<script>
	//Disable word 'e' for input number
	$(':input[type="number"]').keydown(function(e){
		if(e.keyCode == 69)
			return false;
	});
	
	function onlyNumberKey(evt) {
		var ASCIICode = (evt.which) ? evt.which : evt.keyCode
		if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
			return false;
		return true;
	}
</script>
