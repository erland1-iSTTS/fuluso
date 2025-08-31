<?php
    include 'init.php';
	
	

	
    if(!isset($_POST['data']))
	{
		$data = array();
    }
	else
	{
		$data = json_decode(base64_decode(filter_input(INPUT_POST, 'data')), true);
		
	}
	
	$key = $data['api_key'];
	$con_id = $data['con_id'];
	$username = $data['username'];
	
	if(isset($key))
	{
		if($key == $global_api_key)
		{
			
			$sql = "UPDATE master_g3e_container set is_active = 0 where con_id = ".$con_id;
			$query = mysqli_query($CONN, $sql);
			
		    $response['Response'] = "True";
        	$response['Message'] = "Success";
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
	
?>
