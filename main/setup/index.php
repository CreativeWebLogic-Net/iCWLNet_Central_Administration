<?php
	include("../../Admin_Start_Include.php");
	
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Bubble CMS Lite Administration</title>
<link href="<?php print $app_data['asset-sever']; ?>/admin/css/management.css" rel="stylesheet" type="text/css">
</head>

<body >
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
          <?php include("../includes/submenu-setup.php");?>
        </span></td>
      </tr>
    </table></td>
    <td valign="top" class="rightbg"><br />
      <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td><h2>Bubble CMS Lite Setup</h2>
            <br>
Be carefull in this area, you could potentially damage your website, use with care!!!! 
</td>
        </tr>
      </table>
      <br></td>
  </tr>
</table>
<?php include("../includes/footer.php");?>
</body>
</html>
<?php 
  include("../includes/end-of-file.php");
?>
