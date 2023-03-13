<?php
	include("../../Admin_Start_Include.php");
	
	if($_POST['Submit']){
		
		$m=new SendMail();
		$m->Template("../../../assets/email-templates/support.html");
		$m->To($SupportEmail);
		$m->From("IWebBiz Support Bot","support@iwebbiz.com.au");
		$m->Subject("Support Query For Capricorn at ".$_SERVER['HTTP_HOST']);
		$m->Merge(array("ServerUrl"=>"http://".eregi_replace("www.","",$_SERVER['HTTP_HOST']),"details"=>$_POST['details'],"name"=>$_POST['name'],"email"=>$_POST['email'],"phone"=>$_POST['phone'],"mobile"=>$_POST['mobile'],));
		$m->Send();
		$Message="Support Query Sent";
	};
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Bubble CMS Lite Administration</title>
<link href="<?php print $app_data['asset-sever']; ?>/admin/css/management.css" rel="stylesheet" type="text/css">
</head>

<body onLoad="P7_TMclass();P7_TMopen()">
<?php include("../includes/header.php");?>
<?php include("../includes/mainmenubar.php");?>
<table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0" class="border">
  <tr>
    <td width="179" valign="top" class="ManagementContentLeftColumn"><table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0" class="ManagementContentLeftColumnLinks">
      <tr>
        <td height="10">&nbsp;</td>
      </tr>
      <tr>
        <td><span class="leftside">
          <?php include("../includes/submenu-home.php");?>
        </span></td>
      </tr>
    </table></td>
    <td valign="top" class="rightbg">
      <br />
      <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td valign="top"><form action="contact.php"  method="post" name="form2" onSubmit="YY_checkform('form2','FirstName','#q','0','You must fill in the field Name.','Email','S','2','You must fill in a valid Email Address.','UserName','#q','0','You must fill in the field Username.','Password','#q','0','You must fill in the field Password','Password2','#Password','6','Passwords must match.');return document.MM_returnValue" >
            <span class="pageheading">Contact Support </span><span class="RedText"><?php print $Message; ?></span><br>
            <br>
            Complete the support details below.<br>
            <br>
            <span class="RedText"><strong>*</strong></span><strong> Mandatory Fields </strong>
            <table width="100%" border="0" cellpadding="3" cellspacing="1" id="tablecell">
              <tr>
                <td width="163"><strong> Name<span class="RedText">*</span></strong></td>
                <td width="352"><input name="name" type="text" id="name" size="45"></td>
              </tr>
              <tr>
                <td><strong> Email you wish to be contacted on<span class="RedText">*</span></strong></td>
                <td><input name="email" type="text" id="email" size="45"></td>
              </tr>
              <tr>
                <td><strong> Phone<span class="RedText">*</span></strong></td>
                <td><input name="phone" type="text" id="phone" size="45"></td>
              </tr>
              <tr>
                <td><strong>Mobile<span class="RedText">*</span></strong></td>
                <td><input name="mobile" type="text" id="mobile" size="45"></td>
              </tr>
              <tr>
                <td><strong> Details of your problem<span class="RedText">*</span></strong></td>
                <td><textarea name="details" cols="60" rows="10" id="details"></textarea></td>
              </tr>
            </table>
            <p><br>
              <input name="Submit" type="submit"  class="formbuttons" id="Submit" value="Send Request" onClick="return confirmSubmit()">
            </p>
          </form></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php include("../includes/footer.php");?>
</body>
</html>
<?php 
  include("../includes/end-of-file.php");
?>
