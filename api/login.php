<?php
    include "init.php";
	$data = array();
	
	
    if($_POST["data"] == "") {
		$data = array();
    } else {
    	$data = json_decode(base64_decode(filter_input(INPUT_POST, 'data')), true);
    }
	
	$key = $data['api_key'];
	$username = $data['username'];
	$password = sha1($data['password']);
	
    if(isset($key))
	{
	    if($key == $global_api_key)
	    {
			if($username !='' and $password !='')
			{
				 $check_idlogin = "";
				$str = 'select * from master_user where username="'.$username.'" and password="'.$password.'" ';
	              $sql = mysqli_query($CONN,$str);
	              while ($row = mysqli_fetch_array($sql)) {
	                $check_idlogin = $row['id'];
	              }
				
				
				  if ($check_idlogin == "")
	              {
					  $response['Response'] = "False";
					  $response['Message'] = "Login Failed";
	              }
	              else
				  {
					$response['Username'] = $username;
					$response['id'] = $check_idlogin;
					$response['Response'] = "True";
					$response['Message'] = "Login Success";
				  }
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
		$response['key'] = $key;
		$response['data'] = $data;
	}
	
	echo json_encode($response);
?>
