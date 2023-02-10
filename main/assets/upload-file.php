<?php
	include("../../Admin_Start_Include.php");
	
	include("functions.inc.php");
	
	if($_GET['Parent']){
		$Parent=$_GET['Parent'];
	}elseif($_POST['Parent']){
		$Parent=$_POST['Parent'];
	}else{
	 	$Parent=0;
	}
	
	if($_POST['Submit']){
		if(!eregi(".php",$_FILES['FileName']['name'])){
			if(eregi(".swf",$_FILES['FileName']['name'])){
				$Type="flash";
			}else{
				$Type="image";
			}
			
			
			$m= new AddToDatabase();
			$m->AddPosts($_POST,$_FILES);
			$m->AddTable("assets");
			$m->AddExtraFields(array("AssetFoldersID"=>$Parent,"Type"=>$Type));
			$m->MoveFile("FileName","../../../assets/$Parent/");
			$m->DoStuff();
			$NewID=$m->ReturnID();
			$Message="File Uploaded";
		};
	};

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Insert File</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
<script>
<?php
	if($_POST['Submit']){
?>
	opener.location.href=opener.location.href;
<?php }; ?>
</script>
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
.style1 {color: #FF0000}
-->
</style></head>

<body>
<form action="upload-file.php" method="post" enctype="multipart/form-data" name="form1">
  <span class="contentHeading">File Upload  </span>
  <table width="61%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><img src="../../images/contentTop.gif" width="606" height="17" /></td>
    </tr>
    <tr>
      <td class="box"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr align="center">
            <td colspan="2" align="left" class="style1">
              <?php print $Message;?>
            </td>
          </tr>
          <tr align="center">
            <td width="33%" align="left"><strong>Path</strong></td>
            <td width="67%" align="left"><?php printShowPath($Parent,$ClientsID,"upload-file.php");?></td>
          </tr>
          <tr>
            <td><strong>File to upload</strong></td>
            <td><input name="FileName" type="file" id="FileName"></td>
          </tr>
          <tr>
            <td><strong>Description</strong></td>
            <td><textarea name="Description" cols="50" rows="5" id="Description"></textarea></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="right">
              <input name="Parent" type="hidden" id="Parent" value="<?php print $Parent;?>">
              <input type="submit" name="Submit" value="Submit">
            </div></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td><img src="../../images/contentFooter.gif" width="606" height="12" /></td>
    </tr>
  </table>
</form>
</body>
</html>
