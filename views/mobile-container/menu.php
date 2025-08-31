<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Container';
?>

<style>
	.mobile{
		display: flex;
		justify-content: center;
	}
	
	.index-container{
		padding: 4%;
		border: 1px solid #ccc;
	}
	
	@media screen and (min-width: 300px) {
		.mobile{
			margin-top: 10%;
		}
		
		.index-container{
			width: 80%;
		}
		
		.logo img{
			width: 100%;
		}
		
		.icon-container img{
			width: 35%;
		}
	}
	
	@media screen and (min-width: 550px) {
		.mobile{
			margin-top: 8%;
		}
		
		.index-container{
			width: 75%;
		}
		
		.logo img{
			width: 100%;
		}
		
		.icon-container img{
			width: 45%;
		}
	}
	
	@media screen and (min-width: 800px) {
		.mobile{
			margin-top: 0px;
		}
		
		.index-container{
			width: 100%;
		}
		
		.logo img{
			width: 50%;
		}
		
		.icon-container img{
			width: 20%;
		}
	}
	
	@media screen and (min-width: 1024px) {
		.mobile{
			margin-top: 0px;
		}
		
		.logo img{
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
	
	.btn-outline-dark:hover{
		background-color: transparent;
		color: black;
	}
	
	.box{
		border: 1px solid #ccc;
		border-radius: 15px;
		padding: 10px;
	}
</style>

<div class="mobile">
	<div class="index-container">
		<div class="logo text-center">
			<img src="<?=Url::base()?>/img/logo.jpg"> 
		</div>
		
		<div class="row">
			<div class="col-12 mb-3">
				<div class="row">
					<div class="col-12 d-flex justify-content-between">
						<label>User : Joko</label>
						<?= Html::a('Logout', '../mobile/login', ['style'=>'color:black;text-decoration:none']) ?>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row" style="display:inline" id="container_add">
			<div class="col-12 box">
				<div class="icon-container" style="display:inline"><img src="<?=Url::base()?>/img/icon-container_add.jpg"></div>
				<label>Input Container</label>
			</div>
		</div>
		
		<div class="row" style="display:inline" id="container_list">
			<div class="col-12 box">
				<div class="icon-container" style="display:inline"><img src="<?=Url::base()?>/img/icon-container_list.jpg"></div>
				<label>List Container</label>
			</div>
		</div>
		
	</div>
</div>

<script>
	$('#container_add').on('click', function(){
		window.location.href = "<?=Url::base()?>/mobile-container/create";
	});
	
	$('#container_list').on('click', function(){
		window.location.href = "<?=Url::base()?>/mobile-container/view";
	});
</script>
