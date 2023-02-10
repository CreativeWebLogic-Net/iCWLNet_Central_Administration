<?php
	$show_su_menu=false;
	if(isset($app_data['administrators']["SU"])){
		if($app_data['administrators']["SU"]=="CWL"){	
			$show_su_menu=true;
		}elseif($app_data['administrators']["SU"]=="Yes"){	
			$show_su_menu=true;
		}
	}
	if($show_su_menu){
?>
<div id="MainMenuManagement">
    <div id="ManagementMainMenu">
        <a href="../logged-in/index.php"><span>HOME</span></a> 
        | <a href="../members/modify.php"><span>MEMBERS</span></a> 
        | <a href="../content/index.php"><span>CONTENT</span></a> 
        | <a href="../setup/index.php"><span>SETUP</span></a> 
        | <a href="../../logout.php"><span>LOG OUT</span></a>
        
    </div>
</div>
<?php 
    };
?>