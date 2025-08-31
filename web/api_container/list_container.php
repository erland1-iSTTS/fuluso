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
			$sql = "SELECT *,DATE_FORMAT(created_at,'%d %M %Y') AS dateFormat FROM master_g3e_container where is_active = 1 AND date(created_at) >= curdate() - 7 AND date(created_at) <= curdate()"; //select where step 3 - request bl
		    $result = mysqli_query($CONN, $sql);
			$count_data = mysqli_num_rows($result);
		    $arr_data = [];
		    while($row = mysqli_fetch_assoc($result)){
		        array_push($arr_data, array(
					'con_id' => $row['con_id'],
					'con_code' => $row['con_code'],
					'con_text' => $row['con_text'],
					'con_name' => $row['con_name'],
					'created_at' => $row['dateFormat']
		        ));
		    }
		    $response['Response'] = "True";
        	$response['Data'] = $arr_data;
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
