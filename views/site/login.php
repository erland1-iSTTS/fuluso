<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>


<style>
	body{
		/*background-color: black;*/
	}
	
	.div-login{
		display: flex;
		justify-content: center;
	}
	
	.content-login{
		padding: 4%;
		border: 1px solid #ccc;
	}
	
	.logo{
		text-align: center;
		margin-top: 20px;
		margin-bottom: 40px;
	}
	
	.form-group{
		margin-bottom: 30px;
	}
	
	@media screen and (min-width: 300px) {
		.div-login{
			margin-top: 10%;
		}
		
		.content-login{
			width: 80%;
		}
	}
	
	@media screen and (min-width: 550px) {
		.div-login{
			margin-top: 8%;
		}
		
		.content-login{
			width: 75%;
		}
	}
	
	@media screen and (min-width: 800px) {
		.div-login{
			margin-top: 5%;
		}
		
		.content-login{
			width: 50%;
		}
	}
	
	@media screen and (min-width: 1024px) {
		.div-login{
			margin-top: 5%;
		}
		
		.content-login{
			width: 40%;
		}
	}
</style>

<div class="index-login">
	<div class="div-login">
		<div class="content-login">
			<div class="logo">
				<img src="<?=Url::base()?>/img/newlogo.png" class="w-100"> 
			</div>
			
			<div class="form-login">
				<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

					<?= $form->field($model, 'username')->textInput() ?>

					<?= $form->field($model, 'password')->passwordInput() ?>
					
					<div class="form-group">
						<div class="row">
							<div class="col-12">
								<?= Html::submitButton('Login', ['class' => 'btn btn-dark w-100', 'name' => 'login-button']) ?>
							</div>
						</div>
					</div>
				<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div>
</div>
