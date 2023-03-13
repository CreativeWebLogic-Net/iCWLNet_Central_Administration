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
		$m= new AddToDatabase();
		$m->AddPosts($_POST,$_FILES);
		$m->AddTable("assetfolders");
		$m->AddExtraFields(array("ClientsID"=>1));
		$m->DoStuff();
		$NewID=$m->ReturnID();
		
		
		
		// create template folder
		if(!file_exists("../../../assets/$NewID")){
			$oldumask = umask(0);
			mkdir("../../../assets/$NewID", 0777); // or even 01777 so you get the sticky bit set
			umask($oldumask);
		}
	};

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Insert Folder</title>
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
-->
</style></head>

<body>
<form name="form1" method="post" action="create-folder.php">
  <span class="contentHeading">Insert Folder</span>
  <table width="61%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><img src="../../images/contentTop.gif" width="606" height="17" /></td>
    </tr>
    <tr>
      <td class="box"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
          
          <tr align="center">
            <td width="33%" align="left"><strong>Path</strong></td>
            <td width="67%" align="left"><?php printShowPath($Parent,1,"create-folder.php");?></td>
          </tr>
          <tr>
            <td><strong>Folder Name</strong></td>
            <td><input name="Name" type="text" id="Name" size="50"></td>
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
