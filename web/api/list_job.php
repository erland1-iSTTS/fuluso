<?php
    include 'init.php';
	
	

	
    if(!isset($_POST['data']))
	{
		$data = array();
    }
	else
	{
		$data = json_decode(base64_decode(filter_input(INPUT_POST, 'data')), true);
		
		$key = $data['api_key'];
	}
	
	if(isset($key))
	{
		if($key == $global_api_key)
		{
			$sql = "SELECT * FROM job_info LEFT JOIN master_new_job 
						on master_new_job.id = job_info.id_job
						where job_info.step = 3 and job_info.is_active = 1"; //select where step 3 - request bl
		    $result = mysqli_query($CONN, $sql);
			$count_data = mysqli_num_rows($result);
			
			
			
		    $arr_data = [];
		    while($row = mysqli_fetch_assoc($result)){
		        array_push($arr_data, array(
					'id' => $row['id'],
					'id_job' => $row['id_job'],
					'job_number' => $row['job_name'],
					'customer' => $row['customer_name'],
					'job_from' => getPointName($row['job_from'], $CONN),
					'job_to' => getPointName($row['job_to'], $CONN),
					'document' => "http://".$_SERVER['SERVER_NAME'].'/v9/web/upload/job/'.$row['id_job'].'/doc1/'.$row['doc_1'],
					'draft_bl' => "http://".$_SERVER['SERVER_NAME'].'/v9/web/job/print-draft-bl?id='.$row['id_job'],
					'nn_bl' => "http://".$_SERVER['SERVER_NAME'].'/v9/web/job/print-nn-bl?id='.$row['id_job'],
		        ));
		    }
			
			
			
		    $response['Response'] = "True";
        	$response['Data'] = $arr_data;
        	$response['Count'] = $count_data;
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
	
	echo json_encode($response,  JSON_UNESCAPED_SLASHES);
	
	function getPointName($var, $CONN)
	{
		
		
		$sql = "SELECT * FROM point where point_code = '".$var."' and is_active = 1";
		$name = '';
		$result = mysqli_query($CONN, $sql);
		
		while($row = mysqli_fetch_assoc($result)){
			if(isset($row['point_name'])){
				$name = $row['point_name'];
			}else{
				$name = '';
			}
		}
		return $name;
	}
?>
