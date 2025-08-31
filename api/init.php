<?php
  	// Localhost
    // $CONN = mysqli_connect('localhost','root','') or die ('Error Connect MysqlServer');
  	// mysqli_select_db($CONN, 'fulusoad_mis') or die ('Error Connect Database');
	//Server
	$CONN = mysqli_connect('localhost','dbadmin','5kBTRT6QJdan794e') or die ('Error Connect MysqlServer');
  	mysqli_select_db($CONN, 'fuluso_v9') or die ('Error Connect Database');
	
	date_default_timezone_set('Asia/Jakarta');
  	$global_api_key = 'fuluso-v9';
  	session_start();
?>
