<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Modal;

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
	
	.alert-warning{
		color: #856404;
		background-color: #fff3cd;
		border-color: #ffeeba !important;
		border-radius: 5px;
		vertical-align: middle;
		padding: 10px;
	}
	
	.alert-danger{
		color: #721c24;
		background-color: #f8d7da;
		border-color: #f5c6cb !important;
		border-radius: 5px;
		vertical-align: middle;
		padding: 10px;
	}
	
	.alert-success{
		color: #155724;
		background-color: #d4edda;
		border-color: #c3e6cb !important;
		border-radius: 5px;
		vertical-align: middle;
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
						<label>User : Henry</label>
						<?= Html::a('Logout', '#', ['style'=>'color:black;text-decoration:none']) ?>
					</div>
				</div>
			</div>
		</div>
		
		<?php if(Yii::$app->session->getFlash('approve')){ ?>
			<div class="alert alert-success" role="alert">
				BL FOR G3ESB22083707 Has been approved
			</div>
		<?php } ?>
		
		<?php if(Yii::$app->session->getFlash('reject')){ ?>
			<div class="alert alert-danger" role="alert">
				BL FOR G3ESB22083707 Has been rejected
			</div>
		<?php } ?>
		
		
		<div class="alert alert-warning m-0" role="alert">
			5 Original BL Request
		</div>
		
		<div class="row" style="display:inline" id="req-1">
			<div class="col-12 box">
				G3ESB22083707<br>
				PT. MITRA PRODIN<br>
				SURABAYA, ID —> LONG BEACH, CA USA<br>
			</div>
		</div>
		
		<div class="row" style="display:inline" id="req-2">
			<div class="col-12 box">
				G3ESB22083706<br>
				PT. SERBA GURIH INDONESIA<br>
				SURABAYA, ID -> OAKLAND, CA USA<br>
			</div>
		</div>
		
		<div class="row" style="display:inline" id="req-3">
			<div class="col-12 box">
				G3EJK22083705<br>
				PT. YOUME INDONESIA<br>
				JAKARTA, ID -> OAKLAND, CA USA<br>
			</div>
		</div>
		
		<div class="row" style="display:inline" id="req-4">
			<div class="col-12 box">
				G3EJK22083702<br>
				PT. TIGERMANDIRI PRATAMA<br>
				JAKARTA, ID -> NEW YORK, NY USA<br>
			</div>
		</div>
		
		<div class="row" style="display:inline" id="req-5">
			<div class="col-12 box">
				G3ESR22063557<br>
				PT. TIGA BINTANG JAYA<br>
				SEMARANG, ID -> LONG BEACH, CA USA<br>
			</div>
		</div>
	</div>
</div>



<?php
	Modal::begin([
		'title' => 'Request Original BL',
		'id' => 'modal_req_bl',
	]);
?>
	G3ESR22063557<br>
	PT. TIGA BINTANG JAYA<br>
	SEMARANG, ID -> LONG BEACH, CA USA<br>
	Type : Seaway Bill
	<hr>
	<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>View Document
	<br>
	<br>
	<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>Draft BL
	&emsp;&emsp;&emsp;&emsp;
	<span class="gap"><img width="20" height="22" src="<?= Url::base().'/img/icon-list.jpeg' ?>"/></span>NN BL
	<br><br>
	<div class="form-group">
		<div class="row">
			<div class="col-12 mt-2 mb-3">
				<?= Html::a('Approve', '../mobile-approve-bl/list2?action=approve', ['class'=>'btn btn-success w-100']) ?>
			</div>
			<div class="col-12">
				<?= Html::a('Reject', '../mobile-approve-bl/list2?action=reject', ['style'=>'color:red;text-decoration:none']) ?>
			</div>
		</div>
    </div>
<?php Modal::end(); ?>



<script>
	$('#req-1,#req-2,#req-3,#req-4,#req-5').on('click', function(){
		// window.location.href = "<?=Url::base()?>/mobile-approve-bl/create";
		$('#modal_req_bl').modal('show');
	});
	
	$('#container_list').on('click', function(){
		// window.location.href = "<?=Url::base()?>/mobile-container/view";
	});
</script>
