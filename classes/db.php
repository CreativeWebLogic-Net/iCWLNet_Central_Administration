<?php
    $DB=array();
    //$DB['server_type']="pgSQL";
    $DB['server_type']="MySQL";
    //$DB['server_type'] = "Sqlite";
		
    if($DB['server_type']=="MySQL"){
        $DB['server_tag']="db-default.php";
        $DB['server_desc']="Private Server";
        $DB['current_dir']="/var/www/html";
        $DB['server_number']=4;
        $DB['hostname']="localhost";
        $DB['usernamedb']="Edit This";
        $DB['passworddb']="Edit This";
        $DB['dbName']="bubblelite2";
        
    }
    

    if($DB['server_type']=="pgSQL"){
        $DB['server_tag']="db-pgSQL.php";
        $DB['server_desc']="pgSQL";
        $DB['current_dir']="/var/www/html";
        $DB['server_number']=2;
        $DB['hostname']="localhost";
        $DB['usernamedb']="Edit This";
        $DB['passworddb']="Edit This";
        $DB['dbName']="bubblelite2";
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
    $server_login[$DB['server_tag']]=array('server_tag'=>$DB['server_tag'],'server_desc'=>$DB['server_desc']
        ,'current_dir'=>$DB['current_dir'],'server_number'=>$DB['server_number'],
        'hostname'=>$DB['hostname'],'usernamedb'=>$DB['usernamedb'],'passworddb'=>$DB['passworddb'],
        'dbName'=>$DB['dbName'],'dbNames'=>$DB['dbNames']);

    function get_details(){
        global $server_login;
        return $server_login;
    }
?>