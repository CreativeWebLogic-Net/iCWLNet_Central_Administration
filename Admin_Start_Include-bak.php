<?php	
	ini_set( 'display_errors', '1' );
	session_start();
	$current_dir=pathinfo(__DIR__);
	//if(($current_dir['dirname']!="/home2/ownpagec/domains/red.sitemanage.info/public_html")&&($_SERVER['PHP_SELF']!="index.php")){
	/*
	if((isset($_POST['Submit']))&&(isset($_POST['UserName']))&&(isset($_POST['Password']))&&(isset($_POST['Login_Code']))){

	}else{
		if(!strpos($current_dir['dirname'],"main")){
			if(!$_SESSION['administratorsID']){
				//header("Location: ../../logout.php");
				//exit();
			}
		}
		
	}
	*/	
	
	
	//$current_dir=pathinfo(__DIR__);
	//print_r($current_dir)."<br>";
	//try{
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
	//----------------------------------------------------------------
	
	$spos=strpos($_SERVER["PHP_SELF"],'/main/');
	if($spos!==false){
		$app_data['APPBASEDIR']='../../';
		$app_data['INCLUDEBASEDIR']='/main/';
	}else{
		$app_data['APPBASEDIR']='./';
		$app_data['INCLUDEBASEDIR']='/main/';
	}
	//print $_SERVER["PHP_SELF"]."-".$current_dir['dirname']."--".$spos;
	$app_data['MODULEBASEDIR']=$app_data['APPBASEDIR'].'modules/';
	$app_data['CLASSESBASEDIR']=$app_data['APPBASEDIR'].'classes/';
	//$app_data['INCLUDESDIR']=$app_data['INCLUDEBASEDIR'].'includes/';
	$app_data['INCLUDESDIR']=$app_data['APPBASEDIR'].'includes/';

	//define('$app_data['APPBASEDIR']','../../../');
	//define('CLASSESBASEDIR',$app_data['APPBASEDIR'].'classes/');
	//include($app_data['INCLUDEDIR']."includes/config.inc.php");	
	//include($app_data['INCLUDEDIR']."includes/functions.inc.php");
	include($app_data['INCLUDESDIR']."config.inc.php");	
	include($app_data['INCLUDESDIR']."functions.inc.php");
	include($app_data['CLASSESBASEDIR']."clsMail.php");
	include($app_data['CLASSESBASEDIR'].'clsLogger.php');
	
	$log = new clsTestLog();
	//$log = "";
	$log->general("Start Management ",1);
	include($app_data['CLASSESBASEDIR'].'clsDataBase.php');
	include($app_data['CLASSESBASEDIR']."clsVariables.php");
	$vs=new clsVariables();
	$vs->Set_Log($log);
	$log->general("-clsVariables Loaded-",1);
	$r=new clsDatabaseInterface($log);
	$r->CreateDB();
	//$log->general("-clsDI Started-",1);
	//$log->general("\n",1);
	//$r->Set_Log($log);
	//echo"0-----------------------------------------------------------".var_export($r,true)."------------------";
	$log->general('Loading Create VS $r',1);
	$r->Set_Vs($vs);
	//$log->general("\n",1);
	
	/*
	echo"--44-\n\n";
	print_r($_POST);
	echo"--11-\n\n";
	echo"--442-\n\n";
	print_r($_SESSION);
	echo"--112-\n\n";
	*/
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
	$app_data['LANGUAGESID']=$LanguagesID;
	//echo"--44844-\n\n";
	if(isset($_POST['clientsID'])){
		if($_POST['clientsID']){
			
			$_SESSION['original_clientsID']=$_POST['clientsID'];
			//
			$_SESSION['original_languagesID']=false;
			$_SESSION['original_domainsID']=false;
			//echo"--44845-\n\n".var_export($_SESSION,true)."--4484599-\n\n";
		}else{
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
	//echo"--448-\n\n";
	//print_r($_POST);
	//echo"--118-\n\n";
	//echo"--4428-\n\n";
	//print_r($_SESSION);
	//echo"--1128-\n\n";
	
	/*
	if(isset($_POST['clientsID'])){
		$_SESSION['original_clientsID']=$_POST['clientsID'];
		unset($_SESSION['original_languagesID']);
		unset($_SESSION['original_domainsID']);
	}else{
		if(isset($_POST['languagesID'])){
			$_SESSION['original_languagesID']=$_POST['languagesID'];
		}
		if(isset($_POST['domainsID'])){
			$_SESSION['original_domainsID']=$_POST['domainsID'];
		}
	}
	*/
	/*
	if(isset($_POST['clientsID'])){
		$_SESSION['original_clientsID']=$_POST['clientsID'];
	}
	if(isset($_POST['domainsID'])){
		if($_POST['domainsID']){
			$_SESSION['original_domainsID']=$_POST['domainsID'];
		}
	}
	if(isset($_POST['languagesID'])){
		if($_POST['languagesID']){
			$_SESSION['original_languagesID']=$_POST['languagesID'];
		}
	}
	*/
	/*
	echo"--44-\n\n";
	print_r($_POST);
	echo"--11-\n\n";
	echo"--442-\n\n";
	print_r($_SESSION);
	echo"--112-\n\n";
	*/
	if(isset($_POST['domainsID'])){
		if($_SESSION['original_domainsID']) $_SESSION['ModsPermArr']=GetModulesPermissions();
	}
	//-----------------------------------------------------------------------------------------------------------	
	//if(isset($_SESSION['original_domainsID'])){
		/*
		$domain_name="sitemanage.info";
		$sql="SELECT domains.Name FROM domains WHERE domains.id='".$_SESSION['domainsID']."'";
		//print $sql;
		$rslt=$r->rawQuery($sql);
		$data=$r->Fetch_Array();
		$domain_name=$data[0];
		*/
		$r->Initialise_Remote_Server(true);
		//$r->Set_Current_Server($domain_name);
	//};
	//-----------------------------------------------------------------------------------------------------------
	

	try{
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

	//if(isset($_SESSION['original_domainsID'])){
		$domain_name="sitemanage.info";
		$sql="SELECT domains.Name,ClientsID FROM domains WHERE domains.id='".$_SESSION['original_domainsID']."'";
		//print $sql;
		$rslt=$r->rawQuery($sql);
		$data=$r->Fetch_Array();
		if($r->NumRows>0){
			$domain_name=$data[0];
			$_SESSION['original_clientsID']=$data[1];
			// ------------------------- access remote server installation
			$r->Set_Current_Server($domain_name);

			$sql="SELECT domains.id FROM domains WHERE domains.Name='".$domain_name."'";
			//print $sql;
			$rslt=$r->rawQuery($sql);
			$data=$r->Fetch_Array();
			if($r->NumRows()>0){
				$domain_id=$data[0];
				$_SESSION['domainsID']=$domain_id;
			}
		}
		
		
	//};
	//print "-1------------------------------------------------------------------";
	$domain_name="sitemanage.info";
	$sql="SELECT domains.id,SiteTitle,Name as Host FROM domains WHERE (SELECT clientsID FROM domains WHERE) ORDER BY Name";
	/*
	if(isset($_SESSION['original_clientsID'])){
		if($_SESSION["SU"]!="No"){
			
				$sql="SELECT domains.id,SiteTitle,Name as Host FROM domains WHERE clientsID=".$_SESSION['original_clientsID']." ORDER BY Name";
			}
		}else{
			if(isset($_SESSION['administratorsID'])){
				$sql="SELECT domains.id,SiteTitle,Name as Host FROM domains,administrators_domains ";
				$sql.="WHERE domains.id=administrators_domains.domainsID AND administratorsID=".$_SESSION['administratorsID']." AND clientsID=".$_SESSION['original_clientsID'];
				$sql.=" ORDER BY Name";
			}else{
				$sql="SELECT domains.id,SiteTitle,Name as Host FROM domains WHERE id=666";
			}
		}
	};
	*/
	//print $sql;
	
	$rslt=$r->rawQuery($sql);
	if($r->NumRows()>0){
		while($data=$r->Fetch_Array()){
			if(!is_numeric($_SESSION['original_domainsID'])){
				$_SESSION['original_domainsID']=$data[0];
			}
			//$tmp=($data[0]==$_SESSION['domainsID'] ? true : false);
			//$app_data['domains'][]=array($data[0]=>$data[1],"url"=>$data[2],"selected"=>$tmp);
			$dval=$data[1]." -> ".$data[2];
			$app_data['domains'][]=array($data[0]=>$dval);
			//echo"<option value='$data[0]' $tmp>$data[1] -> $data[2]</option>";
		};
	}
	//$_SESSION['ModsPermArr']=GetModulesPermissions();

	//-----------------------------------------------------------------------------------------------------------	
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
	//echo"--4468-\n\n";
	//print_r($_POST);
	//echo"--1168-\n\n";
	echo"--44268-\n\n";
	print_r($_SESSION);
	echo"--11268-\n\n";
	//-----------------------------------------------------------------------------------------------------------	
	
	echo"--446-\n\n";
	print_r($_POST);
	echo"--116-\n\n";
	echo"--4426-\n\n";
	print_r($_SESSION);
	echo"--1126-\n\n";
	
?>