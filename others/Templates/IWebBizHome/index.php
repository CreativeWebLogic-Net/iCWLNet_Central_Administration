<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?=$PageDetails['metadata'];?>
<title>IWebBiz CMS - <?=$PageDetails['pagetitle'];?></title>
<link href="<?=$PageDetails['templatedir'];?>css/general.css" rel="stylesheet" type="text/css" />
<script src="<?=$PageDetails['templatedir'];?>jscript/functions.js"></script>
<script src="/main/ajax.js"></script>
<script>

	MaxCOs['/<?=TEMPLATESDIR.$Page[$CurrentPage]['template']."/"?>']=<?=$MaxCOs[$Page[$CurrentPage]['template']]?>;
</script>
<style>
body {
	background-color:#FFFFFF;
	
}
.footer {
	font-family: arial;
	font-size: 11px;
	color: #FFFFFF;
	background-image: url(<?=$PageDetails['templatedir'];?>images/footerBg.gif);
	padding-right: 10px;
	padding-left: 10px;
}

</style>

</head>

<body onLoad="OnPageLoadStartup()">
<table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="750" height="254" valign="top"><table width="750" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="2" align="right" valign="top" bgcolor="#FFFFFF" class="whitelink"><?=createinstance(11);?></td>
      </tr>
      <tr>
        <td height="241" colspan="2" valign="top" bgcolor="#FFFFFF"><?=createinstance(8);?></td>
      </tr>
      <tr>
        <td height="20" colspan="2" valign="bottom" bgcolor="#FFFFFF" class="pageheading"><?=createinstance(4);?></td>
        </tr>
      <tr>
        <td height="20" valign="bottom" bgcolor="#FFFFFF" class="pageheading">
          <table width="110" border="0" cellspacing="0" cellpadding="0" style="display:none" id="LoadingIcon">
            <tr>
              <td width="32" bgcolor="#FFFFFF" height="20"><img src="<?=$PageDetails['templatedir'];?>images/mozilla_blu.gif" /></td>
              <td width="118" bgcolor="#FFFFFF"><span id="LoadingText">Loading...</span></td>
            </tr>
          </table></td>
        <td height="20" align="right" valign="bottom" bgcolor="#FFFFFF" class="pageheading"><?=createinstance(12);?></td>
      </tr>
      <tr>
        <td width="20%"  valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="8"></td>
          </tr>
        </table>
          <table width="133" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="contactBoxCopy">
          <tr>
            <td width="121" height="13"><iframe src="/main/ajax-iframe.php" name="AJAXIFrame" id="AJAXIFrame" width="0" marginwidth="0" height="0" marginheight="0" scrolling="no" frameborder="0"></iframe></td>
            
          </tr>
          <tr>
            <td height="150" valign="top" class="content">
              <p><span id="CO5">
                <?=createinstance(5);?>
              </span> </p>
              <p>
                <span id="CO6"><?=createinstance(6);?></span>              </p></td>
            </tr>
          
        </table>          
          <br /></td>
        <td width="80%" valign="top" bgcolor="#FFFFFF" class="content"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td valign="top"><br />
              <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="51%" class="pageheading"><span id="PageTitle"><?=$PageDetails['pagetitle'];?></span>
                    <br /> </td>
                  <td width="21%" class="pageheading"></td>
                  <td width="28%" align="right" class="pageheading"><?=createinstance(7);?></td>
                </tr>
                <tr>
                  <td colspan="3"><table width="98%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="1" bgcolor="#000000"></td>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                  <td colspan="3"><?=createinstance(1);?><br /></td>
                </tr>
                <tr>
                  <td colspan="3"><?=createinstance(2);?><br /></td>
                </tr>
                <tr>
                  <td colspan="3"><?=createinstance(3);?></td>
                </tr>
                <tr>
                  <td colspan="3"><?=createinstance(10);?></td>
                </tr>
              </table>              </td>
          </tr>
        </table>
          <br /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        
        
        <tr>
          <td width="67%" height="31" class="footer"><span class="whitetext"><?=createinstance(9);?></span></td>
          <td width="33%" align="right"  class="footer"><a href="http://www.iwebbiz.com.au" >Website Design Development IWebBiz</a></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
