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
		$username = $data['username'];
		$password = sha1($data['password']);
	}
	
    if(isset($key))
	{
	    if($key == $global_api_key)
	    {
			if($username !='' and $password !='')
			{
				$response['Username'] = $username;
				$response['Response'] = "True";
				$response['Message'] = "Login Success";
			} 
	        else
			{
				$response['Response'] = "False";
				$response['Message'] = "Incomplete Data";
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
