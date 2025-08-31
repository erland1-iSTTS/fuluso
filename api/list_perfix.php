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
			$sql = "SELECT * FROM containercode where is_active = 1"; //select where step 3 - request bl
		    $result = mysqli_query($CONN, $sql);
		    $arr_data = [];
		    while($row = mysqli_fetch_assoc($result)){
		        array_push($arr_data, array(
					'containercode_name' => $row['containercode_name']
		        ));
		    }
			
		    $response['Response'] = "True";
        	$response['Data'] = $arr_data;
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
