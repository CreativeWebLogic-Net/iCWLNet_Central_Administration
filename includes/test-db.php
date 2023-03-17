<?php
    try{
		//$connect = array('hostname'=>'localhost','usernamedb'=>'bubblelite','passworddb'=>'DickSux5841','dbName'=>'bubblelite2');
		$DB=array();
		//$DB['server_type']="pgSQL";
		$DB['server_type']="MySQL";
		//$DB['server_type'] = "Sqlite";
			
		if($DB['server_type']=="MySQL"){
		
			$DB['server_tag']="db-localhost.php";
			$DB['server_desc']="Server Localhost";
			$DB['current_dir']="/var/www/html";
			$DB['server_number']=0;
			$DB['hostname']="localhost";
			$DB['usernamedb']='danielruul78';
			$DB['passworddb']='DickSux5841';
			$DB['dbName']='bubblelite2';
			
		}

		print_r($DB);
		$links = new mysqli($DB['hostname'], $DB['usernamedb'], $DB['passworddb'],$DB['dbName']);
		//$links->select_db($connect['dbName']);
		// Check connection
		if($links->connect_error) {
			//die("Connection failed: " . $links->connect_error);

			print("Connection failed: " . $links->connect_error);
		}else{
			print("Connected successfully: " .var_export($DB,true));

		}
		echo 'Connected successfully';
		$query='SELECT * FROM domains LIMIT 0,1';
		$result = $links->query($query);
		$myrow=$result->fetch_row();
		print_r($myrow);
	}catch(MySQLException $e){
		print_r($e);
	}
?>