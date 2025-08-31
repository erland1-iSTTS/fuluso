<?php
use app\models\Customer;
use app\models\CustomerAlias;
use yii\helpers\Url;

$connection = Yii::$app->getDb();
$command = $connection->createCommand('select * from  customer_merge2');
$result = $command->queryAll();
?>

<a href="<?= Url::base()?>/customer_data_merge.csv" class="btn btn-dark mb-4" title="Download" target="_blank" download>Download</a>

<table class="table">
	<th>No.</th>
	<th>Company Name</th>
	<th>Customer Nickname</th>
	<th>Customer Name</th>
	<th>Customer Alias</th>
	<tbody>
		<?php
			$no = 1;
			foreach ($result as $val){
				echo '<tr>';
				echo '<td>'.$no.'</td>';
				echo '<td>'.$val['customer_companyname'].'</td>';
				echo '<td>'.$val['customer_nickname'].'</td>';
				echo '<td>'.$val['customer_name'].'</td>';
				echo '<td>'.$val['customer_alias'].'</td>';
				echo '</tr>';
			$no++;}
		?>
	</tbody>
</table>
