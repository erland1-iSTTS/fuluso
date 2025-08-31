<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\MasterNewJob;
?>

<style type="text/css">
	.buttoncopy{
		background-color:#444;
		color:#fff;
		border-radius: 4px;
		font-size: 10px;
		width:120px;
		text-align: center;
		padding: 5px;
		cursor: pointer;
	}

	table tbody tr th,
	table tbody tr td{
		font-size: 10px;
	}
</style>

<button class="btn btn-dark mb-3" style="font-size:10px" onclick="location.href = '<?= Url::base().'/job/create'?>'">Create New Job</button>

<table class="table table-sm">
  <thead>
    <tr>
      <th scope="col">Job ID</th>
      <th scope="col">Customer</th>
      <th scope="col">From</th>
      <th scope="col">To</th>
      <th scope="col">Vessel</th>
      <th scope="col">HB</th>
      <th scope="col">MB</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    
	<?php 
		$jobs = MasterNewJob::find()
				// ->select(['master_new_job.*', 'master_new_noa.*', 'master_new_noa.id as id_jobs', 'id_job'])
				->Joinwith('masterNewNoas')
				->where(['job'=>'G3'])
				// ->andWhere(['job_location'=>'SB'])
				// ->where(['master_new_noa.status'=>1])
				->orderBy(['job_number'=>SORT_DESC])
				->limit(10)
				->all();
	?>
	
	<?php
		foreach($jobs as $row){
	?>
		<tr>
			<th scope="row"><?= $row['job_name'] ?></th>
			<td><?= $row['customer_name'] ?></td>
			<td><?= $row['job_from'] ?></td>
			<td><?= $row['job_to'] ?></td>
			<td><?= $row['job_ship'] ?></td>
			<td><?= $row['job_hb'] ?></td>
			<td><?= $row['job_mb'] ?></td>
			<!--<td><a href="../v9/index-2.php?job=<?php //$row['id_job'] ?>" class="btn btn-dark" style="font-size:10px">Copy & Create as New</a></td>-->
			<td><a href="<?= Url::base().'/job/update?id='.$row['id'] ?>" class="btn btn-dark" style="font-size:10px">Copy New</a></td>
		</tr>
	<?php } ?>
    
    <tr style="background-color:#f8f8f8;color:#AAA">
      <th scope="row">G3IJK22033388</th>
      <td>IDJKTHEMASTEEL (PT. THE MASTER STEEL MANUFACTORY)</td>
      <td>KLGTW</td>
      <td>JKTID</td>
      <td>EVER BOARD</td>
      <td>KELJKT2203001</td>
      <td>KEEJKT223022</td>
      <td><button class="btn btn-dark" style="font-size:10px">Copy New</button></td>
    </tr>
    
    <tr style="background-color:#f8f8f8;color:#AAA">
      <th scope="row">G3ESB22033361</th>
      <td>IDBLBISAMA (CV. BISAMA TRADING)</td>
      <td>SUBID</td>
      <td>MONCAD</td>
      <td>MSC RINI III</td>
      <td>-</td>
      <td>MMEDUJQ8233919B</td>
      <td><button class="btn btn-dark" style="font-size:10px">Copy New</button></td>
    </tr>
    
  </tbody>
</table>
