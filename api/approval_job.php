<?php
    include 'init.php';
	
    if($_POST['data'] == '')
	{
		$data = array();
    }
	else
    {
    	$data = json_decode(base64_decode(filter_input(INPUT_POST, 'data')), true);
	}
	
	$key = $data['api_key'];
	$id_job = $data['id_job'];
	$status = $data['status']; // 0 = approved, 1 = on request, 2 = rejected
	
	if(isset($key))
	{
		if($key == $global_api_key)
	    {
			if($status == 0)
			{
				$sql = "UPDATE job_info set step = 4, status = ".$status.", updated_at = ".date('Y-m-d H:i:s')." where id_job = ".$id_job;
				$query = mysqli_query($CONN, $sql);
			}
			else if($status == 2)
			{
				$sql = "UPDATE job_info set step = 3, status = ".$status.", updated_at = ".date('Y-m-d H:i:s')." where id_job = ".$id_job;
				$query = mysqli_query($CONN, $sql);
			}
			
			if($query)
			{
				$response['Response'] = "True";
				$response['Message'] = "Success";
			}
			else
			{
				$response['Response'] = "False";
				$response['Message'] = mysqli_error($CONN);
			}
	    }
	    else
	    {
			$response['Response'] = "False";
			$response['Message'] = "Invalid Key";
	    }
	}
	else
	{
		$response['Response'] = "False";
		$response['Message'] = "Something went wrong";
	}
	
	echo json_encode($response);
?>
