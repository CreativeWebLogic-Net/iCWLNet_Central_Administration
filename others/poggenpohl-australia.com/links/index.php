<?
	include("../admin/DB_Class.php");
	$r=new ReturnRecord();
?>
<html>
<head>
<title>Poggenpohl Australia - Links</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META name=KEYWORDS content="kitchens, german kitchens, design, imported kitchen, poggenpohl, australia, new south wales, northern territory, queensland, act, australian capital territory">
<link href="../style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--



<!--

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
<style type="text/css">
a:link {
	text-decoration: none;
	color: #666666;
}

a:visited {
	text-decoration: none;
	color: #666666;
}
a:hover {
	text-decoration: none;
	color: #666666;
}
a:active {
	text-decoration: none;
	color: #666666;
}
</style>
</head>

<body>
<center>
<table width="780" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr>
    <td width="780" height="85" valign="top"><div align="left">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="14%"><img src="../images/logo.gif" alt="Poggenpohl Australia Logo" width="111" height="110"></td>
          <td width="86%" align="right" class="contentsale">Knowing What Counts </td>
        </tr>
      </table>
    </div></td>
  </tr>
  <tr>
    <td height="18" valign="top" class="footer"><div align="right"><a href="../index.php" >Home</a> | <a href="../aboutUs/index.html">About Us</a> | <a href="../projects/index.html">Projects</a> | <a href="../dealers/index.html">Dealers</a> | <a href="../poggenpohl/index.html">Poggenpohl</a> | <a href="../green-kitchen/index.html">Green Kitchen</a> | <a href="../history/awards.html">History &amp; Awards</a></a> | <a href="../kitchen-care/index.html">Kitchen Care</a> | <a href="../display-sale/index.html">Display Sale</a> </div></td>
  </tr>
  <tr>
    <td height="303" valign="top"><img src="../images/largeimages/image1.jpg" width="780" height="303"></td>
  </tr>
  <tr>
    <td height="35" valign="middle" background="../images/headerBG.gif" class="contentCopy" ><div align="left"><img src="../images/titles/linksTitle.gif" width="57" height="35" align="middle"></div></td>
  </tr>
  <tr>
    <td height="132" valign="top" class="content"><div align="left">
      <p>&nbsp;</p>
      
          
              <strong>Categories:</strong><br />
                      <ul>
					  <?php
					$Count=0;
					$r=new ReturnRecord();
					$sq2=$r->rawQuery("SELECT id,Name FROM LinkCategories  ORDER BY Name");  
					while ($myrow = mysql_fetch_row($sq2)) {
						?>
                      <li><a href="index.php#A<?=$myrow[0]?>"> <?=$myrow[1]?></a></li>
                     
                      <?
					};
				?></ul>
                  
            </div>
            <br />
            <br />
            <?php
					$r=new ReturnRecord();
					$sq2=$r->rawQuery("SELECT id,Name FROM LinkCategories ORDER BY Name");  
					while ($myrow = mysql_fetch_row($sq2)) {
						?>
          </div>
          <div align="center"> <a name="A<?=$myrow[0]?>" id="A<?=$myrow[0]?>"></a> <strong>
            <?=$myrow[1]?>
          </strong> </div>
          <?
						$sq3=$r->rawQuery("SELECT id,Name,Description,Url FROM Links WHERE LinkCategoriesID='$myrow[0]' ORDER BY SOrder");  
						while ($myrow2 = mysql_fetch_row($sq3)) {
						?>
          <table width="594" align="center" id="ProductRow">
            <tr>
              <td width="420" align="left" bgcolor="#B3BED2"><?=$myrow2[1]?></td>
            </tr>
            <tr>
              <td align="left"><?=eregi_replace("\n","<br>",$myrow2[2])?></td>
            </tr>
            <tr>
              <td align="left" bgcolor="#B3BED2"><a href="<?=$myrow2[3]?>" target="_blank">
                <?=$myrow2[3]?>
              </a></td>
            </tr>
          </table>
          <br />
          <?
						};
					};
				?>
          <p align="left"></p>
        
    </div>
      </td>
  </tr>
  <tr>
    <td height="27" valign="middle" class="footer"><div align="right"><a href="../index.php">Home</a> | <a href="../aboutUs/index.html">About Us</a> | <a href="../projects/index.html">Projects</a> | <a href="../dealers/index.html">Dealers</a> | <a href="../poggenpohl/index.html">Poggenpohl</a> | <a href="index.html">Links</a> | <a href="../sitemap.html">Site Map</a></div></td>
  </tr>
</table>
</center>
</body>
</html>
