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
    <td width="205" height="29" valign="middle" class="leftColumnHeader"><span class="leftside">
      <div id="p7TMctrl" align="center"> <a href="#" onclick="P7_TMall(0);return false">Expand All</a> | <a href="#" onclick="P7_TMall(1);return false">Collapse All</a> </div>
    </span></td>
    <td colspan="2" rowspan="2" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="content">
      <!--DWLayoutTable-->
      <tr>
        <td width="9" height="13"></td>
        <td width="606"></td>
        <td width="9"></td>
      </tr>
      <tr>
        <td height="59"></td>
        <td valign="top"><span class="contentHeading">Modify or Delete </span><br />
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <!--DWLayoutTable-->
          <tr>
            <td width="606" height="17" valign="top"><img src="../../images/contentTop.gif" width="606" height="17" /></td>
              </tr>
          <tr>
            <td height="24" valign="top" class="box"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr>
                  <td width="14%" class="tableHeaders"><div align="center">Header</div></td>
                  <td width="14%" class="tableHeaders"><div align="center">Header</div></td>
                  <td width="14%" class="tableHeaders"><div align="center">Header</div></td>
                  <td width="31%" class="tableHeaders"><div align="center">Header</div></td>
                  <td width="11%" class="tableHeaders"><div align="center">Header</div></td>
                  <td width="9%" class="tableHeaders"><div align="center">Header</div></td>
                  <td width="7%" class="tableHeaders"><div align="center">Header</div></td>
                </tr>
                <tr>
                  <td bgcolor="#DDDDDD"><div align="center" class="contentTableText">qld</div></td>
                  <td bgcolor="#DDDDDD"><div align="center" class="contentTableText">australia</div></td>
                  <td bgcolor="#DDDDDD"><div align="center" class="contentTableText">goonaroid</div></td>
                  <td bgcolor="#DDDDDD"><div align="center" class="contentTableText">7 goon street ,Helensvale </div></td>
                  <td bgcolor="#DDDDDD"><div align="center"><img src="../../images/modifyButton.gif" width="55" height="15" /></div></td>
                  <td bgcolor="#DDDDDD"><div align="center"><img src="../../images/modifyButton.gif" width="55" height="15" /></div></td>
                  <td bgcolor="#DDDDDD"><div align="center"></div></td>
                </tr>
                <tr>
                  <td bgcolor="#EBEBEB"><div align="center"><span class="contentTableText">qld</span></div></td>
                  <td bgcolor="#EBEBEB"><div align="center"><span class="contentTableText">australia</span></div></td>
                  <td bgcolor="#EBEBEB"><div align="center"><span class="contentTableText">goonaroid</span></div></td>
                  <td bgcolor="#EBEBEB"><div align="center"><span class="contentTableText">7 goon street ,Helensvale </span></div></td>
                  <td bgcolor="#EBEBEB"><div align="center"><img src="../../images/modifyButton.gif" width="55" height="15" /></div></td>
                  <td bgcolor="#EBEBEB"><div align="center"><img src="../../images/modifyButton.gif" width="55" height="15" /></div></td>
                  <td bgcolor="#EBEBEB"><div align="center"></div></td>
                </tr>
              </table>              </td>
          </tr>
          <tr>
            <td height="12" valign="top"><img src="../../images/contentFooter.gif" width="606" height="12" /></td>
          </tr>
          <tr>
            <td height="6">To modify an item blah blah blah. To modify an item blah blah blah, To modify an item blah blah blah<br />
              <strong>Tip</strong>: you can select multiple items <br /></td>
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
    <td height="31" colspan="3" class="footer"><div align="right">Placement text </div></td>
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
