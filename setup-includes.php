<?php
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
	//----------------------------------static asset files------------------------------
	$app_data['asset-severs'][0]='<?php print $app_data['asset-sever']; ?>/'; // linode server
	$app_data['asset-severs'][1]='https://spaces.auseo.net/'; // digital ocean custom server
	$app_data['asset-severs'][2]='https://static-cms.nyc3.cdn.digitaloceanspaces.com/'; // digital ocean cdn server
	$app_data['asset-severs'][3]='https://static-cms.nyc3.digitaloceanspaces.com/'; //digital ocean standard server
	$app_data['asset-severs'][4]='https://assets.ownpage.club/'; //asura standard server
	$app_data['asset-severs'][5]='https://assets.hostingdiscount.club/'; //asura reseller server
	$app_data['asset-severs'][6]='https://assets.icwl.me/'; //hostgator reseller server
	$app_data['asset-severs'][7]='https://static-assets.w-d.biz/'; //cloud unlimited server
	$app_data['asset-severs'][8]='https://assets.i-n.club/'; //ionos unlimited server

	$app_data['asset-sever']=$app_data['asset-severs'][0];
	//----------------------------------------------------------------
	//----------------------------------------------------------------
	$app_data['languages']=array();
	$app_data['domains']=array();
	$app_data['clients']=array();
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

	include($app_data['INCLUDESDIR']."config.inc.php");	
	include($app_data['INCLUDESDIR']."functions.inc.php");
	include($app_data['CLASSESBASEDIR']."clsMail.php");
	include($app_data['CLASSESBASEDIR'].'clsLogger.php');
	
	$log = new clsLog();
	//$log = "";
	$log->general("Start Management ",1);
	include($app_data['CLASSESBASEDIR'].'clsDataBase.php');
	include($app_data['CLASSESBASEDIR']."clsVariables.php");
	$vs=new clsVariables();
	$vs->Set_Log($log);
	$log->general("-clsVariables Loaded-",1);
	$r=new clsDatabaseInterface($log);
	$r->CreateDB();
	$log->general('Loading Create VS $r',1);
	$r->Set_Vs($vs);

	$email=new clsEmail();
	

?>