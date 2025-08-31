<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\MasterContainer;
use yii\widgets\ActiveForm;

$this->title = 'List Container';
date_default_timezone_set('Asia/Jakarta');
?>

<style>
	.index-container{
		padding: 4%;
		border: 1px solid #ccc;
	}
	
	.alert-success{
		color: #155724;
		background-color: #d4edda;
		border-color: #c3e6cb !important;
		border-radius: 5px;
		vertical-align: middle;
		padding: 10px;
		text-align: center;
	}
	
	#table-list-container,
	#table-list-container tr,
	#table-list-container td{
		border: 0px;
	}
	
	#table-list-container td{
		padding: 5px;
	}
</style>

<div class="list-container">
	<div class="index-container">
		<h5 style="font-weight:700;margin-bottom:20px"><?= Html::encode($this->title) ?></h5>
		Data kontainer 7 hari terakhir
		
		<?php 
			if(Yii::$app->session->getFlash('success')){
				echo '<div class="alert alert-success" role="alert">';
				echo 'Data kontainer : <br>';
				echo Yii::$app->session->getFlash('success').'<br>';
				echo 'telah dihapus';
				echo '</div>';
			} 
		?>
		
		<hr style="margin: 20px 0px 10px 0px">
		
		<table class="table mb-0" id="table-list-container">
			<?php
				$now = date('Y-m-d').' 23:59:59';
				$lastday = date('Y-m-d', strtotime('-7 days')).' 00:00:00';
				
				$datas = MasterContainer::find()
						->where(['between', 'created_at', $lastday, $now])
						->andWhere(['is_active'=>1])
						->orderBy(['created_at'=>SORT_DESC])
						->asArray()
						->all();
				
				foreach($datas as $key => $data){
					if($key == 0){
			?>		
				<tr>
					<td colspan="4">
						<b>
						<?php 
							$date = date('d F Y', strtotime($data['created_at']));
							echo $date;
						?>
						</b>
					</td>
				</tr>
				<tr>
					<td width="22%"><?= $data['con_code'] ?></td>
					<td width="25%"><?= $data['con_text'] ?></td>
					<td width="22%"><?= $data['con_name'] ?></td>
					<td width="28%" class="text-center"><b><span id="row-<?=$data['con_id']?>" onclick="deletes(<?=$data['con_id']?>)" data-code="<?=$data['con_code']?>" data-no="<?=$data['con_text']?>" data-type="<?=$data['con_name']?>" style="padding:2.5px"> x </span></b></td>
				</tr>
			<?php }else{
					$date_now = date('d F Y', strtotime($data['created_at']));
					
					if($date !== $date_now){
					?>
						<tr>
							<td colspan="4"><hr style="margin:10px 0px"></td>
						</tr>
						<tr>
							<td colspan="4">
								<b>
								<?php 
									$date = date('d F Y', strtotime($data['created_at']));
									echo $date;
								?>
								</b>
							</td>
						</tr>
						<tr>
							<td><?= $data['con_code'] ?></td>
							<td><?= $data['con_text'] ?></td>
							<td><?= $data['con_name'] ?></td>
							<td class="text-center"><b><span id="row-<?=$data['con_id']?>" onclick="deletes(<?=$data['con_id']?>)" data-code="<?=$data['con_code']?>" data-no="<?=$data['con_text']?>" data-type="<?=$data['con_name']?>" style="padding:2.5px"> x </span></b></td>
						</tr>
						
					<?php }else{ ?>
					
						<tr>
							<td><?= $data['con_code'] ?></td>
							<td><?= $data['con_text'] ?></td>
							<td><?= $data['con_name'] ?></td>
							<td class="text-center"><b><span id="row-<?=$data['con_id']?>" onclick="deletes(<?=$data['con_id']?>)" data-code="<?=$data['con_code']?>" data-no="<?=$data['con_text']?>" data-type="<?=$data['con_name']?>" style="padding:2.5px"> x </span></b></td>
						</tr>
						
					<?php } 
				}
			}?>
		</table>
		<hr style="margin:10px 0px">
		
		<div class="row" style="margin-top:40px;">
			<div class="col-12">
				<?= Html::a('Back', '../mobile-container/menu', ['style'=>'color:black;text-decoration:none']) ?>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div id="modal_delete" class="modal">
	<div class="modal-dialog mt-5">
		<div class="modal-content">
			<div class="modal-body text-center">
				<h5 style="font-weight:700">Delete Container</h5>
				<br>
				<?php $form = ActiveForm::begin(['id'=>'delete', 'action'=>'delete']); ?>
					Apa anda yakin hendak<br>menghapus data ini ?
						
					<?= $form->field($model, 'con_id', ['template'=>'{input}', 'options'=>['tag'=>false]])->hiddenInput()->label(false); ?>
					<br>
					<div class="text-center mt-4"><span id="no_container"></span></div>
					
					<div class="row justify-content-center mt-4 pt-1 border-top">
						<div class="offset-md-2 col-4">
							<?= Html::button('Cancel', ['class' => 'btn btn-close lnj-type-button', 'data-dismiss' => 'modal', 'style'=>'width:100%']) ?>
						</div>
						<div class="col-4">
							<?= Html::submitButton('Delete', ['class' => 'btn active-lnj-type-button', 'style'=>'width:100%']) ?>
						</div>
					</div>
				<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script>
	function deletes(id){
		code = $('#row-'+id).data('code');
		no = $('#row-'+id).data('no');
		type = $('#row-'+id).data('type');
		
		$('#no_container').html(code+' '+no+' '+type);
		$('#modal_delete').modal({backdrop: 'static', keyboard: false});
		$('#modal_delete').show();
		$('#mastercontainer-con_id').val(id);
	}
</script>
