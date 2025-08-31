<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Login';
?>

<style>
	.mobile-login{
		display: flex;
		justify-content: center;
	}
	
	.index-login{
		padding: 4%;
		border: 1px solid #ccc;
	}
	
	@media screen and (min-width: 300px) {
		.mobile-login{
			margin-top: 10%;
		}
		
		.index-login{
			width: 80%;
		}
	}
	
	@media screen and (min-width: 550px) {
		.mobile-login{
			margin-top: 8%;
		}
		
		.index-login{
			width: 75%;
		}
	}
	
	@media screen and (min-width: 800px) {
		.mobile-login{
			margin-top: 5%;
		}
		
		.index-login{
			width: 50%;
		}
	}
	
	@media screen and (min-width: 1024px) {
		.mobile-login{
			margin-top: 5%;
		}
		
		.index-login{
			width: 40%;
		}
	}
	
	
	.logo{
		text-align: center;
		margin-bottom: 40px;
		
	}
	
	.form-group{
		margin-bottom: 30px;
	}
	
</style>

<div class="mobile-login">
	<div class="index-login">
		<div class="logo text-center">
			<img src="<?=Url::base()?>/img/logo.jpg" class="w-100"> 
		</div>
		<?php $form = ActiveForm::begin(); ?>
			<div class="form-login">
				<?= $form->field($model, 'username')->textInput() ?>

				<?= $form->field($model, 'password')->passwordInput() ?>
			</div>
			<div class="row" style="margin-top:50px">
				<div class="col-12">
					<?php if($action == 'container'){ ?>
						<?= Html::a('Login', '../mobile-container/menu', ['class'=>'btn btn-dark w-100']) ?>
					<?php }elseif($action == 'approve-bl'){ ?>
						<?= Html::a('Login', '../mobile-approve-bl/list', ['class'=>'btn btn-dark w-100']) ?>
					<?php }?>
				</div>
			</div>
		<?php ActiveForm::end(); ?>
	</div>
</div>
