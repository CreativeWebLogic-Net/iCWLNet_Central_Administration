<?
	include('DB_Class.php');
	
	$Message=$_GET['Message'];
	
	if($_POST['Submit']){
		$r=new ReturnRecord();
		$data=$r->rawQuery("SELECT id FROM Administrators where UserName='$_POST[UserName]' and Password='$_POST[Password]'");
		$dataarray=mysql_fetch_array($data);
		$AdminKey=$dataarray[0];
		
		if($AdminKey>0){ //admin login ok
			session_start();
			$_SESSION["AdminKey"]=$AdminKey;
			header("Location: main/logged-in../index.php");
		}else{	//admin login bad
			$Message="Incorrect Username or Password";
		};
	};

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Admin</title>
<link href="css/backend.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><form name="form1" method="post" action="index.php">
      <table  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="left"><img src="images/logo.gif" width="261" height="68" vspace="5"></td>
        </tr>
        
        <tr>
          <td align="center" ><table width="100%"  border="0" cellspacing="0" cellpadding="10">
              <tr>
                <td bgcolor="#F1F4F7" class="LogBox">
				<span class="RedText"><?php print $Message; ?></span>
				<table  border="0" align="center" cellpadding="0" cellspacing="6">
                    <tr>
                      <td width="170" height="20" align="right" class="loginwhite"><strong>Username:</strong> &nbsp; </td>
                      <td><input name="UserName" type="text" class="loginfield" id="UserName"></td>
                    </tr>
                    <tr>
                      <td  width="170" height="20" align="right" class="loginwhite"><strong>Password:</strong> &nbsp; </td>
                      <td><input name="Password" type="password" class="loginfield" id="Password"></td>
                    </tr>
                    <tr>
                      <td align="right">&nbsp;</td>
                      <td><input name="Submit" type="submit" class="loginbutton" value="Login"></td>
                    </tr>
                    
                </table></td>
              </tr>
          </table></td>
        </tr>
        
      </table>
    </form></td>
  </tr>
</table>
</body>
</html>
