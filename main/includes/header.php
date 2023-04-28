<?php
	//print_r($app_data['domains']);
?>
<div id="ManagementHeader">
	
	<div id="ManagementHeaderRightColumn">
    	<?php
		/*
		$head_r=$r;
		$sql="SELECT id,Name FROM languages ORDER BY Name";
			$rslt=$head_r->rawQuery($sql);
			//print $sql;
			$LanguageCount=$r->NumRows($rslt);
		*/
		?>
        
        <div id="ManagementHeaderLanguageSelection" <?php print($LanguageCount==1 ? "class='hidden'" : "");?>>
        	<form action="../logged-in/index.php" method="post" name="frmLanguages" id="frmLanguages">
                <strong class="whitetextbold">Language: </strong>
                <select name="languagesID" id="languagesID" onChange="this.form.submit()">
					<?php
                        /*
						try{
							for($x=0;$x<$LanguageCount;$x++){
								//while($data=$r->Fetch_Array()){
							
								$data=$r->Fetch_Array();
								$LanguageName=$data[1];
								if(!isset($_SESSION['languagesID'])) $_SESSION['languagesID']=$data[0];
								$tmp=($data[0]==$_SESSION['languagesID'] ? "selected" : "");
								echo"<option value='$data[0]' $tmp>$LanguageName</option>";
							
							};
						}catch(Exception $e){
							//print_r($e);
						}
						*/
						/*
						print_r($app_data['languages']);
						$selected_key=$_SESSION['languagesID'];
						$drop_array=$app_data['languages'];
						foreach($drop_array as $key=>$val){
							foreach($val as $key2=>$val2){
								//print "-1-".$key2."--\n\n";
								//print "-2-".var_export($val,true)."--\n\n";

								print "-3-".$key2."--\n\n";
								print "-4-".$val2."--\n\n";
								$tmp=($val[0]==$selected_key ? "selected" : "");
							
								echo"<option value='".$key2."' ".$tmp.">".$val2."</option>";
							}
						}
						*/
						if(count($app_data['languages'])>0){
							$selected_key=$_SESSION['original_languagesID'];
							$drop_array=$app_data['languages'];
							foreach($drop_array as $key=>$val){
								foreach($val as $key2=>$val2){
									$tmp=($key2==$selected_key ? "selected" : "");
									echo"<option value='".$key2."' ".$tmp.">".$val2."</option>";
								}
							}
						}
                    ?>
                </select>
              </form>
        </div>
        <div id="ManagementHeaderWebsiteSelection">
        	
            <?php
				
				if(count($app_data['domains'])>1){
					print '<form action="../logged-in/index.php" method="post" name="frmClients" id="frmClients"><span class="whitetextbold">Website:</span><select name="domainsID" id="domainsID" onChange="this.form.submit()">';
					$selected_key=$_SESSION['original_domainsID'];
					$drop_array=$app_data['domains'];
					foreach($drop_array as $key=>$val){
						//print_r($val);
						//foreach($val as $key2=>$val2){
							
							//$tmp=($val['id']==$selected_key ? "selected" : "");
							if($val['id']==$selected_key){
								$tmp="selected";
								$app_data['current_domain']=$app_data['domains'][$key];
							}else{
								$tmp="";
							}
							echo"<option value='".$val['id']."' ".$tmp.">".$val['title']."</option>";
						//}
					}
					print "</select></form>";
				}elseif(count($app_data['domains'])==1){
					$drop_array=$app_data['domains'][0];
					$app_data['current_domain']=$app_data['domains'][0];
					//foreach($drop_array as $key=>$val){
						print('<span class="whitetextbold">Website: '.$app_data['domains'][0]['title'].'</span>');
					//}
				}else{
					print('<span class="whitetextbold">No Website: Add one now</span>');
					$app_data['current_domain']=false;
				}
				
			?>
          
        </div>
        <div id="ManagementHeaderClientSelection">
        	<?php
				//print_r($_SESSION);
				if($_SESSION["SU"]=="CWL"){ ?>
        <form action="../logged-in/index.php" method="post" name="frmClients" id="frmClients2">
          <span class="whitetextbold">Client:</span>
          <select name="clientsID" id="clientsID" onchange="this.form.submit()">
            <?php
				
				if(count($app_data['clients'])>1){
					$selected_key=$_SESSION['original_clientsID'];
					$drop_array=$app_data['clients'];
					foreach($drop_array as $key=>$val){
						foreach($val as $key2=>$val2){
							$tmp=($key2==$selected_key ? "selected" : "");
							echo"<option value='".$key2."' ".$tmp.">".$val2."</option>";
						}
					}
				}elseif(count($app_data['clients'])==1){

				}
			?>
          </select>
        </form><?php };?>
        </div>
        <div id="ManagementHeaderLoggedIn" class="whitetextbold">
        	<?php
				print "Connected Server: ".$r->server_name." / ";
			?>
            <?php if($LanguageCount<2){ ?>
				<span id="ManagementHeaderLanguageDisplay" <?php print($LanguageCount==1 ?  "class='whitetextbold'" :  "class='redwarningtextbold'");?>>
        			<?php 
						if($LanguageCount==1){
							?>Current language: <?php print $LanguageName;?> / <?php
						}else{
							?>WARNING YOU NEED TO ADD A LANGUAGE<?php
						}
					?>
        		</span>
            <?php }; ?>
            Logged in as: <?php print $_SESSION["username"];?>
        </div>
    </div>
    <div style="clear:both">
    </div>
</div>
