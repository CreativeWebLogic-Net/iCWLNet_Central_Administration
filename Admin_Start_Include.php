<?php	
	
	//echo"0003----------------------------||-------------------------------------------------\n\n";
	
	session_start();
	ini_set( 'display_errors', '1' );
	//echo"000----------------------------||-------------------------------------------------\n\n";
					
	
	//----------------------------------------------------------------
	// check if log in session valid
	//----------------------------------------------------------------
	$include_dir="../../";
	$current_dir=pathinfo(__DIR__);
	$file_ext=substr($_SERVER["PHP_SELF"], -3, 3);
	$file_root=substr($_SERVER["PHP_SELF"], 0, 1);
	$slash_count=substr_count($_SERVER["PHP_SELF"],'/'); 
	//if($_SERVER["PHP_SELF"]!="/index.php"){
	if(($file_ext=="php")&&($file_root=="/")&&($slash_count==1)){
		// local admin content
		$include_dir="./";
		//print $file_ext."-->".$file_root."->".$slash_count;
	}elseif($_SERVER["PHP_SELF"]!="/index.php"){
		$include_dir="../../";
		if(!isset($_SESSION['original_administratorsID'])){
			$loc="Location: /logout.php";
			header($loc);
		}
	}else{
		$include_dir="./";
		if(isset($_SESSION["administratorsID"])){
			$loc="Location: main/logged-in/index.php";
			header($loc);
		}
	}
	
	$tag_match_array=array();
	//echo"<br>0005501----------------------------|-|-------------------------------------------------\n\n";
	include($include_dir."setup-includes.php");
	include_once($include_dir."includes/functions.inc.php");
	//ob_start("callback");
	
	//echo"<br>\n\n 00055----------------------------|-|-------------------------------------------------\n\n";
	
	//-----------------------------------------------------------------------------------------------------------	
	// Set app variables from drop down menu posting
	//-----------------------------------------------------------------------------------------------------------
	
	if(isset($_POST['LanguagesID'])){
		if($_POST['LanguagesID']){
			$_SESSION['original_languagesID']=$_POST['LanguagesID'];
			$LanguagesID=$_POST['LanguagesID'];
		}elseif(!$_SESSION['original_languagesID']){
			$_SESSION['original_languagesID']=1;
			$LanguagesID=1;
		}
	}else{
		$_SESSION['original_languagesID']=1;
		$LanguagesID=1;
	}
	
	//print_r($_SESSION);
	$app_data['LANGUAGESID']=$LanguagesID;
	
	if(isset($_POST['clientsID'])){
		if($_POST['clientsID']){
			
			$_SESSION['original_clientsID']=$_POST['clientsID'];
			//
			$_SESSION['original_languagesID']=false;
			$_SESSION['original_domainsID']=false;
			//echo"--44845-\n\n".var_export($_SESSION,true)."--4484599-\n\n";
		}else{
			if(!isset($_SESSION['original_clientsID'])){
				$_SESSION['original_clientsID']=false;
			}
			if(isset($_POST['languagesID'])){
				if($_POST['languagesID']){
					$_SESSION['original_languagesID']=$_POST['languagesID'];
				}
			}
			if(isset($_POST['domainsID'])){
				if($_POST['domainsID']){
					$_SESSION['original_domainsID']=$_POST['domainsID'];
				}
			}
		}
	}else{
		if(!isset($_SESSION['original_clientsID'])){
			$_SESSION['original_clientsID']=false;
		}
		if(isset($_POST['languagesID'])){
			if($_POST['languagesID']){
				$_SESSION['original_languagesID']=$_POST['languagesID'];
			}
		}
		if(isset($_POST['domainsID'])){
			if($_POST['domainsID']){
				$_SESSION['original_domainsID']=$_POST['domainsID'];
			}
		}
	}

	//print_r($_SESSION);
	//echo"--44844-\n\n";

	$_SESSION['languagesID']=$_SESSION['original_languagesID'];

	if(isset($_SESSION['languagesID'])) $app_data['original_vars']['languagesID']=$_SESSION['languagesID'];
	if(isset($_SESSION['domainsID'])) $app_data['original_vars']['domainsID']=$_SESSION['domainsID'];
	if(isset($_SESSION['original_clientsID'])) $app_data['original_vars']['clientsID']=$_SESSION['original_clientsID'];
	
	if(isset($_POST['domainsID'])){
		if($_SESSION['original_domainsID']) $_SESSION['ModsPermArr']=GetModulesPermissions();
	}
	//-----------------------------------------------------------------------------------------------------------	
	// Set language
	//-----------------------------------------------------------------------------------------------------------
	try{
		
		//$r->Initialise_Remote_Server(true);
		//$head_r=&$r;
		$sql="SELECT id,Name FROM languages ORDER BY Name";
		//$r->test_mysql($sql);
		//print "\n\n 876501------|--".$sql."--|----|--\n<br>";
		$rslt=$r->rawQuery($sql);
		//$data=$r->Fetch_Array($rslt);
		//print "\n\n 8765------|--".$sql."--|--".var_export($rslt,true)."--|-".var_export($data,true)."--|\n<br>";
		//print "9900876----------|--".$sql."--|--\n<br>";

		


		//$r->test_mysql_db_result($rslt);
		//print "99008765----------|--".var_export($rslt,true)."--|--\n<br>";
		$LanguageCount=$r->NumRows($rslt);
		//print "99008765----------|--".$LanguageCount."--|--\n<br>";
		//for($x=0;$x<$LanguageCount;$x++){
		if($LanguageCount>0){
			while($data=$r->Fetch_Array($rslt)){
				//print "8765----------|--".var_export($data,true)."--|--\n<br>";
				//print_r($data);
				//$data=$r->Fetch_Array();
				//print "\n\n8765----------|--".var_export($data,true)."--|--\n";
				$LanguageName=$data[1];
				if(!is_numeric($_SESSION['original_languagesID'])){
					$_SESSION['original_languagesID']=$data[0];
					//echo"--1111-\n\n";
				} 
				//$tmp=($data[0]==$_SESSION['languagesID'] ? "selected" : "");
				//$tmp=($data[0]==$_SESSION['languagesID'] ? true : false);
				$app_data['languages'][]=array($data[0]=>$LanguageName);
				//echo"<option value='$data[0]' $tmp>$LanguageName</option>";
			
			};
		}else{
			//print "\n\n5678\n\n----------|--".var_export($data,true)."--|--\n\n\n";
		}
		
	}catch(Exception $e){
		//print_r($e);
	}
	//print_r($app_data);
	//-----------------------------------------------------------------------------------------------------------	
	// Set domain
	//-----------------------------------------------------------------------------------------------------------
	try{
		//echo"--4321-\n\n";
		$r->Initialise_Remote_Server(true);
		//echo"--43210-\n\n";
		$domain_name="sitemanage.info";
		$app_data['remote_server']=array();
		$app_data['remote_server']['domain_name']=$domain_name;
		//exit("languages3");
		//echo"--1234---|-".var_export($_SESSION,true)."-|-\n\n";
		if(isset($_SESSION['original_domainsID'])){
			if(is_numeric($_SESSION['original_domainsID'])){
				
				//echo"--1234-\n\n";
				$sql="SELECT domains.Name,ClientsID FROM domains WHERE domains.id='".$_SESSION['original_domainsID']."'";
				
				$rslt=$r->rawQuery($sql);
				$data=$r->Fetch_Array($rslt);
				//echo"--12345----|--".$sql."---|-".var_export($data,true)."-|---\n\n";
				$num_rows=$r->NumRows($rslt);
				//echo"--12345432100----|--".$num_rows."---|-".var_export($data,true)."-|---\n\n";
				if($num_rows>0){
					if(is_array($data)){
						//echo"--123454321----|--".$sql."---|DDD-".var_export($data,true)."-|---\n\n";
						$domain_name=$data[0];
						$app_data['remote_server']['domain_name']=$domain_name;
						$domain_id=0;
						$_SESSION['original_clientsID']=$data[1];
						$app_data['original_clientsID']=$data[1];
						// ------------------------- access remote server installation
						$r->Set_Current_Server($domain_name);
						//echo"--4321-\n\n";
						$sql="SELECT domains.id FROM domains WHERE domains.Name='".$domain_name."'";
						//print $sql;
						//print "\n\n".$sql."\n\n";
						$rslt=$r->rawQuery($sql);
						$data=$r->Fetch_Array();
						//echo"--4445-\n\n".$domain_id;
						//print_r($data);
						if($r->NumRows()>0){
							$domain_id=$data[0];
							$_SESSION['domainsID']=$domain_id;
							$app_data['domainsID']=$domain_id;
							//echo"--4333-\n\n".$domain_id;
						}
					}
					
				}
			}else{
				//echo"--2222-\n\n";
			}
			
			
		};
	}catch(Exception $e){
		//print_r($e);
	}
	
	
	
	//-----------------------------------------------------------------------------------------------------------	
	$domain_name="sitemanage.info";
	$app_data['domains_populate']['search_sql']="";
	try{
		$r->Initialise_Remote_Server(true);
		if(isset($_SESSION['original_clientsID'])){
			if(isset($_SESSION["SU"])){
				if($_SESSION["SU"]!="No"){
				
					$sql="SELECT domains.id,SiteTitle,Name as Host FROM domains WHERE clientsID=".$_SESSION['original_clientsID']." ORDER BY Name";
				
				}else{
					
					if(isset($_SESSION['administratorsID'])){
						$sql="SELECT domains.id,SiteTitle,Name as Host FROM domains,administrators_domains ";
						$sql.="WHERE domains.id=administrators_domains.domainsID AND administratorsID=".$_SESSION['administratorsID']." AND clientsID=".$_SESSION['original_clientsID'];
						$sql.=" ORDER BY Name";
					}else{
						$sql="SELECT domains.id,SiteTitle,Name as Host FROM domains WHERE id=666";
					}
					
				}
			}
			
			
		}else{
			if(!$_SESSION['original_clientsID']){
				$sql="SELECT domains.id,clientsID FROM domains WHERE id=".$_SESSION['original_domainsID']." LIMIT 0,1";
				$rslt=$r->rawQuery($sql);
				$data=$r->Fetch_Array();
				$_SESSION['original_clientsID']=$data[1];
				$app_data['original_clientsID']=$data[1];
			}
			
		}
		$app_data['domains_populate']['search_sql']=$sql;
		//-----------------------------------------------------------------------------------------------------------	
		
		
		
		$rslt=$r->rawQuery($sql);
		//print "\n\n -- 5554321--".$sql."----|--".var_export($app_data,true)."-|--\n\n";
		$num_rows=$r->NumRows($rslt);
		//print "\n\n -- 555--".$num_rows."\n\n";
		if($num_rows>0){
			$data=$r->Fetch_Array($rslt);
			//print "\n\n -- 55500--".$sql."\n\n";
			while($data=$r->Fetch_Array($rslt)){
				//print "\n\n -- 54321--".$sql."----|--".var_export($data,true)."-|--\n\n";
				if(isset($_SESSION['original_domainsID'])){
					if(!is_numeric($_SESSION['original_domainsID'])){
						$_SESSION['original_domainsID']=$data[0];
						//echo"--11114-\n\n";
					}
				}else{
					$_SESSION['original_domainsID']=$data[0];
					//echo"--11115-\n\n";
				}
				//$tmp=($data[0]==$_SESSION['domainsID'] ? true : false);
				//$app_data['domains'][]=array($data[0]=>$data[1],"url"=>$data[2],"selected"=>$tmp);
				//print "\n\n -- 5554321--".$sql."----|--".var_export($data,true)."-|--\n\n";
				
				// below new
				$dval=$data[1]." -> ".$data[2];
				$app_data['domains'][]=array($data[0]=>$dval);
				// end new

				//echo"<option value='$data[0]' $tmp>$data[1] -> $data[2]</option>";
				//print "\n\n -- 5554321--".$sql."----|--".var_export($data,true)."-|--\n\n";
			};
			//echo"--14414-\n\n";
		}
		
	//$_SESSION['ModsPermArr']=GetModulesPermissions();
	}catch(Exception $e){
		//print_r($e);
	}
	//print "\n\n -- 5552--".$sql."\n\n";
	//print_r($app_data);
	//-----------------------------------------------------------------------------------------------------------	
	try{
		//print "\n\n -- 5551234--".$sql."\n\n";
		$r->Initialise_Remote_Server(true);
		if(isset($_SESSION["SU"])){
			if($_SESSION["SU"]=="CWL"){ 
				$sql="SELECT id,Name FROM clients ORDER BY Name";
				
				$rslt=$r->RawQuery($sql);
				
				$client_count=$r->NumRows($rslt);
				//print "\n\n -- 555123456--".$client_count."\n\n";
				if($client_count>0){
					while($data=$r->Fetch_Array($rslt)){
						//$tmp=($data[0]==$_SESSION['clientsID'] ? true : false);
						//$app_data['clients'][]=array($data[0]=>$data[1],"selected"=>$tmp);
						$app_data['clients'][]=array($data[0]=>$data[1]);
						//echo"<option value='$data[0]' $tmp>$data[1]</option>";
					};
				}
				//print "\n\n -- 1234555123456--n\n";
				//print_r($app_data);
			}
		}
		
	}catch(Exception $e){
		//print_r($e);
	}
	
	//--------------------------Set Global Administrators data---------------------------------------------------------------------------------	
	$app_data['administrators']=array();
	if(isset($_SESSION["administratorsID"])){
		$sql="SELECT * FROM administrators where id='".$_SESSION["administratorsID"]."' LIMIT 0,1";
		$data=$r->rawQuery($sql);
		$dataarray=$r->Fetch_Assoc($data);
		if(count($dataarray)>0){ //admin login ok
			$app_data['administrators']=$dataarray;
		}
	}
	//print "\n\n -- 55533--".$sql."\n\n";
	

	//-----------------------------------------------------------------------------------------------------------					
	
	
	//exit();
	//$domain_name=$app_data['remote_server']['domain_name'];
	$domain_name="localhost";
	$r->Set_Current_Server($domain_name);
	//print "$$-".$domain_name."--\n";
	//-----------------------------------------------------------------------------------------------------------	
	if(isset($_SESSION['languagesID'])){
		$app_data['languagesID']=$_SESSION['languagesID'];
	}elseif(isset($_SESSION['original_languagesID'])){
		$app_data['languagesID']=$_SESSION['original_languagesID'];
	}
	
	if(isset($_SESSION['domainsID'])){
		$app_data['domainsID']=$_SESSION['domainsID'];
	}elseif(isset($_SESSION['original_domainsID'])){
		$app_data['domainsID']=$_SESSION['original_domainsID'];
	}

	if(isset($_SESSION['clientsID'])){
		$app_data['clientsID']=$_SESSION['clientsID'];
	}elseif(isset($_SESSION['original_clientsID'])){
		$app_data['clientsID']=$_SESSION['original_clientsID'];
	}

	if(isset($_SESSION["SU"])){
		$app_data['SU']=$_SESSION["SU"];
	}
	//print "\n\n -- 5554400--".var_export($_SESSION,true)."\n\n";
	//print "\n\n -- 55544--".var_export($app_data,true)."\n\n";
?>