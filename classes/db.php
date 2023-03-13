<?php


    //echo"db-file-0-------------------|-666-|----------------------------------------------------------\n\n";
			
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
        $DB['usernamedb']='username';
        $DB['passworddb']='password';
        $DB['dbName']='bubblelite2';
        
    }
    

    if($DB['server_type']=="pgSQL"){
        $DB['server_tag']="db-pgSQL.php";
        $DB['server_desc']="pgSQL";
        $DB['current_dir']="/var/www/html";
        $DB['server_number']=2;
        $DB['hostname']="localhost";
        $DB['usernamedb']='username';
        $DB['passworddb']='password';
        $DB['dbName']="cwy0ek0e_bubblelite2";
    }


    if($DB['server_type'] == "Sqlite") {
        $DB['server_tag'] = "db-sqlite3.php";
        $DB['server_desc'] = "Sqlite3";
        $DB['current_dir'] = "/var/www/html";
        $DB['server_number'] = 2;
        $DB['hostname'] = "none";
        $DB['usernamedb'] = "none";
        $DB['passworddb'] = "none";
        $DB['dbName'] = './db/bubblelite.db';
    }

    $DB['dbNames']=array($DB['dbName']);

    $server_DB=array('current_db_type'=>$DB['server_type'],'server_tag'=>$DB['server_tag'],'server_desc'=>$DB['server_desc']
    ,'current_dir'=>$DB['current_dir'],'server_number'=>$DB['server_number'],
    'hostname'=>$DB['hostname'],'usernamedb'=>$DB['usernamedb'],'passworddb'=>$DB['passworddb'],
    'dbName'=>$DB['dbName'],'dbNames'=>$DB['dbNames']);

    $server_login[$DB['server_tag']]=$server_DB;
    //echo"db-file-9-------------------|-".var_export($server_login,true)."-|----------------------------------------------------------\n\n";
	
?>
