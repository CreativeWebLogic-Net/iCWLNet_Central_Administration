<?
//$loc="Location: main/logged-in/index.php";
					//header($loc);	

//if($_SERVER['SERVER_PORT']!=443){
	//	header("Location: https://www.iwebbiz.com.au/management/");
	//}
	session_start();
	//print_r($_REQUEST);
	/*
	if(isset($_SESSION["administratorsID"])){
		$loc="Location: main/logged-in/index.php";
		header($loc);
	}
	*/
	include("./Admin_Start_Include.php");
	/*
	$current_dir=pathinfo(__DIR__);
	if($_SERVER["PHP_SELF"]=="/index.php"){
		if(!isset($_SESSION['original_administratorsID'])){
			$loc="Location: /logout.php";
			header($loc);
		}
	}else{
		if(isset($_SESSION["administratorsID"])){
			$loc="Location: main/logged-in/index.php";
			header($loc);
		}
	}
	*/
	/*
	print $_SERVER["PHP_SELF"]."-".$current_dir['dirname']."--".$loc;
	$app_data['APPBASEDIR']='./';
	$app_data['MODULEBASEDIR']=$app_data['APPBASEDIR'].'modules/';
	$app_data['CLASSESBASEDIR']=$app_data['APPBASEDIR'].'classes/';
	$app_data['INCLUDESBASEDIR']=$app_data['APPBASEDIR'].'includes/';

	//define('$app_data['APPBASEDIR']','../');
	define('CLASSESBASEDIR',$app_data['APPBASEDIR'].'classes/');
	include(CLASSESBASEDIR.'clsLogger.php');
	
	$log = new clsLog();
	$log->general("Start Management ",1);
	include($app_data['CLASSESBASEDIR'].'clsDataBase.php');
	include($app_data['CLASSESBASEDIR']."clsVariables.php");
	$vs=new clsVariables();
	$vs->Set_Log($log);
	$log->general("-clsVariables Loaded-",1);
	$r=new clsDatabaseInterface();
	$log->general("-clsDI Started-",1);
	$log->general("\n",1);
	$r->Set_Log($log);
	//echo"0-----------------------------------------------------------------------------";
	$log->general('Loading Create VS $r',1);
	$r->Set_Vs($vs);
	$log->general("\n",1);
	*/
	
	
	
	if(isset($_GET['Message']))$Message=$_GET['Message'];
	
	if(isset($_POST['Submit'])){
		if($_POST['Submit']!=""){
			//$r=new ReturnRecord();
			$sql="SELECT id,SU,clientsID,username FROM administrators where username='$_POST[UserName]' and password='$_POST[Password]'";
			//print $sql;
			$data=$r->rawQuery($sql);
			$dataarray=$r->Fetch_Array($data);
			//print_r($dataarray);
			if(isset($dataarray[0])){
				if($dataarray[0]>0){ //admin login ok
					
					$_SESSION["administratorsID"]=$dataarray[0];
					$_SESSION["SU"]=$dataarray[1];
					$_SESSION["clientsID"]=$dataarray[2];
					$_SESSION["username"]=$dataarray[3];

					$_SESSION['original_clientsID']=$dataarray[2];
					$_SESSION['original_administratorsID']=$dataarray[0];
					
					//$r=new ReturnRecord();
					if($_SESSION["SU"]=="CWL"){
						$sql="SELECT MIN( domains.id) FROM domains WHERE  clientsID=".$_SESSION['clientsID'];
					}else{
						$sql="SELECT MIN( domains.id) FROM domains,administrators_domains WHERE domains.id=administrators_domains.domainsID";
						$sql.=" AND administratorsID=$_SESSION[administratorsID] AND clientsID=$_SESSION[clientsID]";
					}
					
					//print $sql;
					$rslt=$r->RawQuery($sql);
					if($rslt){
						if($r->NumRows($rslt)>0){
							$data=$r->Fetch_Array();
							if($data[0]>0){
								$_SESSION['original_domainsID']=$data[0];
								//$_SESSION['domainsID']=$data[0];
								//print_r($_SESSION);
							}
						}
					}
					//exit();
					$loc="Location: main/logged-in/index.php";
					//header($loc);
					//print $loc;
				}else{	//admin login bad
					$Message="Incorrect Username or Password";
				};
			}else{
				$Message="Incorrect Username or Password";
				
			}
		}
	}
	/*
	}else{
		$Message="Incorrect Username or Password";
	}
	*/

?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Bubble CMS Lite Administration</title>
<link href="css/management.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--

.style1 {
	color: #313C52;
	font-weight: bold;
}
-->
</style></head>
<body>
<table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#000000">
  <tr>
    <td >
	<?php
		if(isset($_SESSION["administratorsID"])){
			
	?>
	We are redireting you into managment, <a href="main/logged-in/index.php">Click Here</a> To Manually Forward.
			<script>
			location.href = "main/logged-in/index.php";
			</script>
	<?php
			
		}else{
	?>
	<form name="form1" method="post" action="">
      <table  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center"><img src="images/logo-bcmslite.jpg" width="364" height="80" alt="Bubble CMS Lite"></td>
        </tr>
        
        <tr>
          <td align="center" >
		  	<table>
			<tr>
			<td>
		 	<table width="100%"  border="0" cellspacing="0" cellpadding="10">
              <tr>
                <td>
					<table  border="0" align="center" cellpadding="0" cellspacing="6" class="ManagementLoginBox">
                  		<tr>
                      		<td height="20" colspan="2" align="center" ><span class="RedText"><?php print $Message; ?></span></td>
                      	</tr>
                    	<tr>
							<td width="130" height="20" align="right" ><strong>Username:</strong> &nbsp; </td>
							<td width="212"><input name="UserName" type="text" class="loginfield" id="UserName"></td>
						</tr>
						<tr>
							<td  width="130" height="20" align="right"><strong>Password:</strong> &nbsp; </td>
							<td><input name="Password" type="password" class="loginfield" id="Password"></td>
						</tr>
						<tr>
							<td colspan="2" align="center"><input name="Submit" type="submit" class="loginbutton" value="Login"></td>
						</tr>
                    </table>
				</td>
              </tr>
          	</table>
			</td>
			<td>
				<table bgcolor="#CCC">
					
					<tr>
						<td><a href="http://yellow.sitemanage.info">Yellow Server - Asura Hosing</a></td>
					</tr>
					<tr>
						<td><a href="http://reseller.sitemanage.info">Hostgator Reseller Server</a></td>
					</tr>
					
					<tr>
						<td><a href="http://sitemanage.info">Main Server - Cloud Hosting</a></td>
					</tr>
				</table>
			<td>
			</tr>
			</table>
		  </td>
        </tr>
	
        
        
      </table>
      
      </form>
	  <?php
		}
	  ?>
	  </td>
  </tr>
</table>
</body>
</html>