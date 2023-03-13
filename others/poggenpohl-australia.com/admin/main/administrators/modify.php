<?php
	include("../../Admin_Start_Include.php");
	
	if($_POST['Delete']=="Delete"){
		if(is_array($_POST['DFiles'])){
			$m= new DeleteFromDatabase();
			$m->AddIDArray($_POST['DFiles']);
			$m->AddTable("Administrators");
			$Errors=$m->DoDelete();
			$m->AddTable("AGroups_Links");
			$m->AltDeleteVar("AdministratorsID");
			$Errors.=$m->DoDelete();
			if($Errors==""){
				$Message="Administrators Deleted";
			}else{
				$Message=$Errors;
			};
		}else{
			$Message="No Administrators Selected To Delete";
		};
	};
	
	
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
</style>
<script language="JavaScript" type="text/JavaScript">
<!--


function confirmSubmit()
{
var agree=confirm("Are you sure you wish to continue?");
if (agree)
	return true ;
else
	return false ;
}

//-->
</script>

</head>

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
    <td width="205" align="center" valign="top" class="leftColumnHeader"><table width="95%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="27"><a href="#" onclick="P7_TMall(0);return false">Expand All</a> | <a href="#" onclick="P7_TMall(1);return false">Collapse All</a> </td>
      </tr>
      <tr>
        <td><div align="left"> <a href="#" onclick="P7_TMall(0);return false"> </a></div>
          <span class="leftside">
          <br />
          <?php
			include("../../menu.php");  
		?>
          </span> </td>
      </tr>
    </table>
      <div align="left"></div>        </td>
    <td colspan="2" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="content">
      <!--DWLayoutTable-->
      <tr>
        <td width="9" height="13"></td>
        <td width="606"></td>
        <td width="9"></td>
      </tr>
      <tr>
        <td height="59"></td>
        <td valign="top"><span class="contentHeading">Modify / Delete Administrator </span><span class="RedText"><?php print $Message; ?></span><br />
          <table width="98%" border="0" cellpadding="0" cellspacing="0">
            <!--DWLayoutTable-->
            <tr>
              <td width="606" height="17" valign="top"><img src="../../images/contentTop.gif" width="606" height="17" /></td>
            </tr>
            <tr>
              <td height="24" valign="top" class="box"><form action="modify.php"  method="post" name="form2" id="form2" onsubmit="YY_checkform('form2','FirstName','#q','0','You must fill in the field Name.','Email','S','2','You must fill in a valid Email Address.','UserName','#q','0','You must fill in the field Username.','Password','#q','0','You must fill in the field Password','Password2','#Password','6','Passwords must match.');return document.MM_returnValue" >
  <br />
  <span class="RedText"><strong>*</strong></span><strong> Mandatory Fields </strong>
  <table width="100%" border="0" cellpadding="3" cellspacing="1" id="table">
    <tr bgcolor="#363E57" id="tablecell">
      <td class="tableHeaders"> Name</td>
      <td class="tableHeaders">Email</td>
      <td width="1%" align="center" class="tableHeaders">Modify</td>
      <td width="1%" align="center" class="tableHeaders">Delete</td>
    </tr>
    <?php
					  	$Count=0;
					 	$r=new ReturnRecord();
						$sq2=$r->rawQuery("SELECT id,FirstName,LastName,Email FROM Administrators");  
						while ($myrow = mysql_fetch_row($sq2)) {
						?>
    <tr bgcolor="<?=(($Count%2)==0 ? "#DDDDDD" : "#EBEBEB"); ?>">
      <td><?=$myrow[1]." ".$myrow[2];?></td>
      <td><?=$myrow[3];?></td>
      <td align="center"><a href="modify-edit.php?id=<?=$myrow[0];?>"><img src="../../images/modify.gif" width="47" height="16" border="0" /></a></td>
      <td><div align="center">
          <input type="checkbox" name="DFiles[]" value="<?=$myrow[0];?>" />
      </div></td>
    </tr>
    <?
							$Count++;
						};
					?>
    <tr align="right" >
      <td colspan="3" class="tableHeaders">&nbsp;</td>
      <td align="center" class="tableHeaders"><input name="Delete" type="submit" class="formbuttons" id="Delete" value="Delete" onclick="return confirmSubmit()" />
      </td>
    </tr>
  </table>
              <strong>To Delete an Administrator:</strong> select the checkbox for that Administrator and then choose Delete button. <br />
              <strong>Tip:</strong> You can select multiple Administrators.
              </form></td>
            </tr>
            <tr>
              <td height="12" valign="top"><img src="../../images/contentFooter.gif" width="606" height="12" /></td>
            </tr>
          </table>
          <br /></td>
        <td></td>
      </tr>
      
      
      
      
      
      
    </table></td>
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
