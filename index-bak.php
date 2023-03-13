<?php

	
	$exception="";
	try{
		include("Admin_Start_Include.php");

		if(isset($_SESSION["administratorsID"])){
			$loc="Location: main/logged-in/index.php";
			header($loc);
			exit();
		}
	

		if(isset($_GET['Message'])){
			if($Message==""){
				$Message=$_GET['Message'];
			}
		}
		
		if(isset($_POST['Submit'])){
			if($_POST['Submit']){
				//$r=new ReturnRecord();
				//$r=new clsDatabaseInterface($log);
				//$r->CreateDB();
				$sql="SELECT id,SU,clientsID,username FROM administrators where username='".$_POST['UserName']."' and password='".$_POST['Password']."'";
				//$sql="SELECT id,SU,clientsID,username FROM administrators LIMIT 0,1";
				//print $sql;
				//print_r($r->server_login);
				
				$data=$r->rawQuery($sql);
				$nrows=$r->NumRows();
				if($nrows>0){
					$dataarray=$r->Fetch_Array($data);
				}else{
					$dataarray[0]=false;
					//print "failure".var_export($data,true);
				}
				
				
				//print_r($dataarray);
				if($dataarray[0]){
					if($dataarray[0]>0){ //admin login ok
						
						$_SESSION["administratorsID"]=$dataarray[0];
						$_SESSION["SU"]=$dataarray[1];
						$_SESSION["clientsID"]=$dataarray[2];
						$_SESSION["username"]=$dataarray[3];
						
						//$r=new ReturnRecord();
						$sql="SELECT MIN( domains.id) FROM domains,administrators_domains WHERE domains.id=administrators_domains.domainsID AND administratorsID=$_SESSION[administratorsID] AND clientsID=$_SESSION[clientsID]";
						print $sql;
						$rslt=$r->RawQuery($sql);
						if($rslt){
							if($r->NumRows($rslt)>0){
								$data=$r->Fetch_Array();
								if(isset($data[0])){
									if($data[0]>0){
										$_SESSION['domainsID']=$data[0];
										$loc="Location: main/logged-in/index.php";
										header($loc);
										exit();
										$log->general("11 \n->".var_exportr($_SESSION,true),3);
										//print_r($_SESSION);
									}
								}
								
							}
						}
						$loc="Location: main/logged-in/index.php";
						$log->general("12 \n->".$loc,3);
						header($loc);
						exit();
						//print $loc;
					}else{	//admin login bad
						$Message="Incorrect Username or Password";
					};
				}else{
					$Message="Incorrect Username or Password";
					
				}
			}
		}else{
			$Message="Incorrect Username or Password";
		}
		$exit="try";
	}catch(Exception $e){
		global $exception;
		$exception=$e;
		$exit="catch";
		//$log->general("-Admin Log in error-".var_export($e,true),3);
		//$log->general("666-Admin Log in error-",3);
		
		//print_r($e);
	}
	/*
	if($exception!=""){
		$txt="667-Admin Throw Log in error-".var_export($exception,true);
		$log->general($txt,3);
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
    <td ><form name="form1" method="post" action="">
      <table  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center"><img src="images/logo-bcmslite.jpg" width="364" height="80" alt="Bubble CMS Lite"></td>
        </tr>
        
        <tr>
          <td align="center" ><table width="100%"  border="0" cellspacing="0" cellpadding="10">
              <tr>
                <td><table  border="0" align="center" cellpadding="0" cellspacing="6" class="ManagementLoginBox">
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
                      <td colspan="2" align="center">
					  <input name="Login_Code" type="hidden" value="123456789"> 	
					  <input name="Submit" type="submit" class="loginbutton" value="Login">
					</td>
                      </tr>
                    
                </table>
				
				</td>
              </tr>
          </table></td>
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
		  </td>
        </tr>
        
        
      </table>
      
      </form></td>
  </tr>
</table>
</body>
</html>
<?php
	$log->display_all();
?>