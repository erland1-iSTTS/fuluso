<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use richardfan\widget\JSRegister;
use yii\bootstrap4\Modal;
?>

<div class="modal fade" id="createinvidtmodal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document"  style="width:100%">
	<div class="modal-content" style="width:100%">
	  <div class="modal-header">
		<h5 class="modal-title" id="modal-invoice-title">Create Invoice IDT</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="modal-body" id="modal-invoice-body">
		<!-- <img src = "images/billing-idt-create.png" style="width:100%"> -->
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		<button type="button" class="btn btn-primary">Save</button>
	  </div>
	</div>
  </div>
</div>


<?php
	Modal::begin([
		'title' => 'Create Invoice IDT',
		'id' => 'createinvidtmodal',
		'size' => 'modal-lg',
	]);
?>
	<div id="content">
		
	</div>
<?php Modal::end(); ?>

