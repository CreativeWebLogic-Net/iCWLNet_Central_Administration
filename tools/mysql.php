<?php
    //echo"<br>-110-----------------------------------------------------------";
    
    $DB['server_tag']="db-w-d.php";
    $DB['server_desc']="Cloud Server";
    $DB['current_dir']="D:\Documents\Projects\Easy Bubble CMS\GitHub\iCWLNet_Central_Administration";
    $DB['server_number']=1;
    $DB['hostname']="localhost";
    $DB['usernamedb']='cwy0ek0e_bubblel';
    $DB['passworddb']='DickSux5841';
    $DB['dbName']='bubblelite2';

    $current_server_tag=$DB['server_tag'];
    //$TArr=$DB['server_tag'];
        //$this->server_name=$server_name;
    $server_desc=$DB['server_desc'];
    //$server_login=$DB;

    $db_login=$DB;
    //echo"<br>-110----------------------".var_export($db_login,true)."-------------------------------------";
    $new_links = new mysqli($db_login['hostname'], $db_login['usernamedb'], $db_login['passworddb'],$db_login['dbName'] );
    //print "99--|--".$db_login['hostname']."--|--".$db_login['usernamedb']."--|--".$db_login['passworddb']."--|--".$db_login['dbName']."--|--\n\n";
    //echo"\n\n<br>-110001----------------------".var_export($new_links,true)."-------------------------------------";
    $query = 'SELECT * FROM administrators';
    $result = $new_links->query($query);
	//echo"666----------------------------".var_export($result,true)."-------------------------------------------------\n\n";
    while($row = $result->fetch_array(MYSQLI_NUM)){
        print_r($row);
    };
	
				
					

?>