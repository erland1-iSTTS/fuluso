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
	$con_code = $data['con_code'];
	$con_text = $data['con_text'];
	$con_name = $data['con_name'];
	$username = $data['username'];
	
	if(isset($key))
	{
		if($key == $global_api_key)
		{
			$sql = 'INSERT into master_g3e_container (con_code,con_text,con_name) 
			VALUES("'.$con_code.'","'.$con_text.'","'.$con_name.'")';
			
			$a = mysqli_query($CONN, $sql);

			if ($a)
			{
				$response['Response'] = "True";
				$response['Message'] = "Success";
			}
			else
			{
				$response['Response'] = "False";
				$response['Message'] = "Gagal";
				$response['Sql'] = $sql;
				$response['Error'] = mysqli_error($CONN);
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
	
	echo json_encode($response,  JSON_UNESCAPED_SLASHES);
?>
