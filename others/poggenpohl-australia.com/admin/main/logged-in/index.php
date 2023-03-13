<?php
	include("../../Admin_Start_Include.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Admin</title>
<link href="../../css/backend.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
-->
</style></head>

<body>
<center>
<table width="829" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr>
    <td height="68" colspan="2" valign="top"><img src="../../images/logo.gif" width="261" height="68" /></td>
    <td width="569" valign="top"><div align="right"><img src="../../images/headerRight.gif" alt="topHeader" width="568" height="68" /></div></td>
  </tr>
  <tr>
    <td height="26" colspan="3" valign="middle" class="loggedInBar"><div align="right">Logged in as : 
	<?php
						//output administrator name
						$r=new ReturnRecord();
						$data=$r->rawQuery("SELECT UserName FROM Administrators WHERE id='$_SESSION[AdminKey]'");
						$dataarray=mysql_fetch_array($data);
						echo $dataarray[0];
					?>
	 </div></td>
  </tr>
  <tr>
    <td width="205" height="29" valign="bottom" class="leftColumnHeader">      <div id="p7TMctrl" align="center"> 
        <div align="left"> <a href="#" onclick="P7_TMall(0);return false"> 
      Expand All</a> | <a href="#" onclick="P7_TMall(1);return false">Collapse All</a> </div></td>
    <td colspan="2" rowspan="2" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="content">
      <!--DWLayoutTable-->
      <tr>
        <td width="9" height="13"></td>
        <td width="606"></td>
        <td width="9"></td>
      </tr>
      <tr>
        <td height="59"></td>
        <td valign="top"><span class="contentHeading">Logged In </span><br />
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <!--DWLayoutTable-->
            <tr>
              <td width="606" height="17" valign="top"><img src="../../images/contentTop.gif" width="606" height="17" /></td>
            </tr>
            <tr>
              <td height="24" valign="top" class="box"><div align="center">Welcome to Poggenpohl Australia's Administration </div></td>
            </tr>
            <tr>
              <td height="12" valign="top"><img src="../../images/contentFooter.gif" width="606" height="12" /></td>
            </tr>
            
          </table></td>
        <td></td>
      </tr>
      
      
      
      
      
      
    </table></td>
  </tr>
  <tr>
    <td height="123" valign="top" bgcolor="#F1F4F7" class="left"><span class="leftside"><?php
			include("../../menu.php");  
		?></span></pre>    </td>
  </tr>
  
  <tr>
    <td height="31" colspan="3" class="footer"><div align="right">&copy; Copyright IWebBiz </div></td>
  </tr>
  <tr>
    <td height="1"></td>
    <td width="56"></td>
    <td></td>
  </tr>
</table>
</center>
</body>
</html>
