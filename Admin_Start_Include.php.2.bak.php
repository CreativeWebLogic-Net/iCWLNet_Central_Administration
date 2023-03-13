<?php	
	ini_set( 'display_errors', '1' );
	session_start();
	
	//----------------------------------------------------------------
	// root data types
	//----------------------------------------------------------------
	$module_data=array();
	$domain_user_data=array();
	$domain_data=array();
	$app_data=array();
	$template_data=array();
	$content_data=array();
	$text_data=array();
	$bizcat_data=array();
	$sidebar_data=array();
	$news_data=array();
	$content_domain_data=array();
	//--------------------------------------------------

	$app_data['asset-severs'][0]='<?php print $app_data['asset-sever']; ?>/'; // linode server
	$app_data['asset-severs'][1]='https://spaces.auseo.net/'; // digital ocean custom server
	$app_data['asset-severs'][2]='https://static-cms.nyc3.cdn.digitaloceanspaces.com/'; // digital ocean cdn server
	$app_data['asset-severs'][3]='https://static-cms.nyc3.digitaloceanspaces.com/'; //digital ocean standard server
	$app_data['asset-severs'][4]='https://assets.ownpage.club/'; //asura standard server
	$app_data['asset-severs'][5]='https://assets.hostingdiscount.club/'; //asura reseller server
	$app_data['asset-severs'][6]='https://assets.icwl.me/'; //hostgator reseller server
	$app_data['asset-severs'][7]='https://static-assets.w-d.biz/'; //cloud unlimited server
	$app_data['asset-severs'][8]='https://assets.i-n.club/'; //ionos unlimited server
	$app_data['asset-severs'][9]='https://assets.creativeweblogic.net'; //ionos unlimited server

	$app_data['asset-sever']=$app_data['asset-severs'][9];
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

	include($include_dir."setup-includes.php");
	include_once($include_dir."includes/functions.inc.php");
	ob_start("callback");
	
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
	///echo"--44844-\n\n";
	if(isset($_POST['clientsID'])){
		if($_POST['clientsID']){
			
			$_SESSION['original_clientsID']=$_POST['clientsID'];
			//
			$_SESSION['original_languagesID']=false;
			$_SESSION['original_domainsID']=false;
			echo"--44845-\n\n".var_export($_SESSION,true)."--4484599-\n\n";
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
		$r->Initialise_Remote_Server(true);
		//$head_r=&$r;
		$sql="SELECT id,Name FROM languages ORDER BY Name";
		$rslt=$r->rawQuery($sql);
		//print $sql;
		$LanguageCount=$r->NumRows($rslt);
		//for($x=0;$x<$LanguageCount;$x++){
		while($data=$r->Fetch_Array()){
		
			//$data=$r->Fetch_Array();
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
	}catch(Exception $e){
		//print_r($e);
	}
	//-----------------------------------------------------------------------------------------------------------	
	// Set domain
	//-----------------------------------------------------------------------------------------------------------
	try{
		$r->Initialise_Remote_Server(true);
		$domain_name="sitemanage.info";
		$app_data['remote_server']=array();
		$app_data['remote_server']['domain_name']=$domain_name;
		if(isset($_SESSION['original_domainsID'])){
			if(is_numeric($_SESSION['original_domainsID'])){
				
				//echo"--1234-\n\n";
				$sql="SELECT domains.Name,ClientsID FROM domains WHERE domains.id='".$_SESSION['original_domainsID']."'";
				//print "\n\n".$sql."\n\n";
				$rslt=$r->rawQuery($sql);
				$data=$r->Fetch_Array();
				if($r->NumRows()>0){
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
		//echo"--3334-\n\n";
		//print $sql;
		
		$rslt=$r->rawQuery($sql);
		if($r->NumRows()>0){
			while($data=$r->Fetch_Array()){
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
				$dval=$data[1]." -> ".$data[2];
				$app_data['domains'][]=array($data[0]=>$dval);
				//echo"<option value='$data[0]' $tmp>$data[1] -> $data[2]</option>";
			};
			//echo"--14414-\n\n";
		}
		
	//$_SESSION['ModsPermArr']=GetModulesPermissions();
	}catch(Exception $e){
		//print_r($e);
	}
	
	//-----------------------------------------------------------------------------------------------------------	
	try{
		$r->Initialise_Remote_Server(true);
		if($_SESSION["SU"]=="CWL"){ 
			$sql="SELECT id,Name FROM clients ORDER BY Name";
			
			$rslt=$r->RawQuery($sql);
			if($r->NumRows()>0){
				while($data=$r->Fetch_Array()){
					//$tmp=($data[0]==$_SESSION['clientsID'] ? true : false);
					//$app_data['clients'][]=array($data[0]=>$data[1],"selected"=>$tmp);
					$app_data['clients'][]=array($data[0]=>$data[1]);
					//echo"<option value='$data[0]' $tmp>$data[1]</option>";
				};
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
	

	//-----------------------------------------------------------------------------------------------------------					
	$domain_name=$app_data['remote_server']['domain_name'];
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
?>