<?php
	include("../../Admin_Start_Include.php");
	
	
	//$r= new ReturnRecord();  // base object for returning data or raw queries
	$r->Set_Current_Server($app_data['remote_server']['domain_name']);
	if(isset($_POST['Submit'])){
		if($_POST['Submit']){
			if($_POST['HomePage']=="Yes"){
				$r->RawQuery("UPDATE content_pages SET HomePage='No' WHERE languagesID=$_SESSION[languagesID] AND domainsID=$_SESSION[domainsID]");
			}
			$_POST['URI']=dirify($_POST['URI']);// remove reserved characters
			if(substr($_POST['URI'],0,1)!="/") $_POST['URI']="/".$_POST['URI']; // if start of string not /
			if(substr($_POST['URI'],strlen($_POST['URI'])-1,1)!="/") $_POST['URI']=$_POST['URI']."/";// if end of string not /
			$m= new UpdateDatabase($log);
      $m->Set_Database($r);
			$m->AddPosts($_POST,$_FILES);
			$m->AddSkip(array("id"));
			$m->AddTable("content_pages");
			$m->AddFunctions(array("Changed"=>"NOW()"));
			$m->AddID($_POST['id']);
			$m->DoStuff();
			//change main text content
			$_POST['content_text']=$r->Escape($_POST['content_text']);
			$r->RawQuery("UPDATE mod_text SET content_text='$_POST[content_text]' WHERE content_pagesID=$_POST[id] AND sidebar_content='No'");
			//change sidebar text content
      /* removed 2023-03-19
			if($_POST['sidebar_module_viewsID']==11){
				$rslt=$r->RawQuery("SELECT COUNT(*) FROM mod_text WHERE content_pagesID=$_POST[id] AND sidebar_content='Yes'");
				if($rslt){
					$_POST['content_text_sidebar']=$r->Escape($_POST['content_text_sidebar']);
					$data=$r->Fetch_Array();
					if($data[0]>0){
						$r->RawQuery("UPDATE mod_text SET content_text='$_POST[content_text_sidebar]' WHERE content_pagesID=$_POST[id] AND sidebar_content='Yes'");//echo "xx";
					}else{
						$r->RawQuery("INSERT INTO mod_text (content_pagesID,content_text,sidebar_content) VALUES ($_POST[id],'$_POST[content_text_sidebar]','Yes')");//echo "yy";
					}
				}else{
					//echo "zz";	
				}
			}

      removed 2023-03-19 */
			$Message="Page Updated";
		};
	}else{
		
	}
	
	if(isset($_GET['id'])){
		if($_GET['id']) $id=$_GET['id'];
	}
	if(isset($_POST['id'])){
		if ($_POST['id']) $id=$_POST['id'];
	}
	
	
	
	//echo"=> 1add search var=>".var_export($_POST,true)."<=\n\n";
	$r->AddTable("content_pages");
	$r->AddSearchVar($id);
  //echo"=>2 add search var=>".var_export($_POST,true)."<=\n\n";
	$Insert=$r->GetRecord();
	$r->AddTable("mod_text");
	$r->AddSearchVar($id);
	$r->AddNewSearchVar("sidebar_content","No");
	$r->ChangeTarget("content_pagesID");
	$TInsert=$r->GetRecord();
  //print_r($TInsert);
	if(!isset($TSInsert['content_text'])){
    $TSInsert['content_text']="";
  }
  //$TSInsert['content_text']="";
  if(isset($Insert['sidebar_module_viewsID'])){
    if($Insert['sidebar_module_viewsID']==11){
      $r->AddTable("mod_text");
      $r->AddSearchVar($id);
      //$r->AddNewSearchVar("sidebar_content","Yes");
      $r->AddNewSearchVar("sidebar_content","No");
      $r->ChangeTarget("content_pagesID");
      $TSInsert=$r->GetRecord();
      //echo"=>content_text=>".var_export($TSInsert,true)."<=\n\n";
    }
  }
	
  //if(!isset($Insert['sidebar_module_viewsID'])) $Insert['sidebar_module_viewsID']=0;
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Bubble CMS Lite Administration</title>
<link href="<?php print $app_data['asset-sever']; ?>/admin/css/management.css" rel="stylesheet" type="text/css">
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

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

var SHPrefix=Array();
var SHTextSpan=Array();
var SHHiddenText=Array();
var SHVisibleText=Array();
var SHRowCount=Array();
SHTextSpan[0]="ShowHideText";
SHPrefix[0]="SHRow";
SHHiddenText[0]="Show Search Engine Options";
SHVisibleText[0]="Hide Search Engine Options";
SHRowCount[0]=3;

SHTextSpan[1]="ShowHidePageText";
SHPrefix[1]="SHPRow";
SHHiddenText[1]="Show Page Options";
SHVisibleText[1]="Hide Page Options";
SHRowCount[1]=7;

function ShowHide(Group){
	var target=document.getElementById(SHTextSpan[Group]);
	var SetGroupTo="";
	if(target.innerHTML==SHHiddenText[Group]){
		target.innerHTML=SHVisibleText[Group];
	}else{
		target.innerHTML=SHHiddenText[Group];
		SetGroupTo="none";
	}
	for(x=0;x<SHRowCount[Group];x++){
		target=document.getElementById(SHPrefix[Group]+x);
		target.style.display=SetGroupTo;
	}
}

</script>
<!-- =============================== Start JQuery Functionality====================== -->

<script>
    ClassicEditor
        .create( document.querySelector( '#content_text' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
<!-- =============================== End JQuery Functionality====================== -->
</head>

<?php include("../includes/header.php");?>
<?php include("../includes/mainmenubar.php");?>
<table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0" class="border">
  <tr>
    <td width="179" valign="top" class="ManagementContentLeftColumn"><table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0" class="ManagementContentLeftColumnLinks">
      <tr>
        <td height="10">&nbsp;</td>
      </tr>
      <tr>
        <td><?php include("../includes/submenu-content.php");?></td>
      </tr>
    </table></td>
    <td valign="top" class="rightbg">
      <br />
      <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td valign="top"><form action="modify-edit.php"  method="post" name="form2" onSubmit="YY_checkform('form2','FirstName','#q','0','You must fill in the field Name.','Email','S','2','You must fill in a valid Email Address.','UserName','#q','0','You must fill in the field Username.','Password','#q','0','You must fill in the field Password','Password2','#Password','6','Passwords must match.');return document.MM_returnValue">
              <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><span class="pageheading">Modify Page </span><span class="RedText"><?php print $Message; ?></span></td>
                  <td width="20%" align="right"><a href="modify.php" class="buttonbacklist">Back To List </a></td>
                </tr>
              </table>
            <br>
            Complete the page details below.<br>
            <br>
            <span class="RedText"><strong>*</strong></span><strong> Mandatory Fields </strong>
            <table width="100%" border="0" cellpadding="3" cellspacing="1" id="tablecell">
              <tr>
                <td><strong>Title<span class="RedText">*</span></strong></td>
                <td><input name="Title" type="text" id="Title" value="<?php print $Insert['Title'];?>" size="45"></td>
              </tr>
              <tr>
                <td colspan="2"><a href="javascript:ShowHide(1);"><span id="ShowHidePageText">Show Page Options</span></a></td>
                </tr>
              <tr id="SHPRow0" style="display:none">
                <td width="163"><strong>Template</strong></td>
                <td width="352"><select name="templatesID" id="templatesID"  onChange="Check_Templates_Details()">
                <option value="0" selected>Website Default</option>
                  <?php
						
				//$r=new ReturnRecord();
				$rslt=$r->rawQuery("SELECT id,Name FROM templates ORDER BY Name");
				while($data=$r->Fetch_Array()){
					$tmp=($data[0]==$Insert['templatesID'] ? "selected" : "");
					//echo"<option value='$data[0]' $tmp>$data[1]</option>";
				};
			?>
                </select></td>
              </tr>
              <tr id="SHPRow1" style="display:none">
                <td><strong>Page Address<span class="RedText">*</span></strong></td>
                <td><input name="URI" type="text" id="URI" value="<?php print $Insert['URI'];?>" size="45"></td>
              </tr>
              <tr id="SHPRow2" style="display:none">
                <td><strong>Menu Title</strong></td>
                <td><input name="MenuTitle" type="text" id="MenuTitle" value="<?php print $Insert['MenuTitle'];?>" size="45"></td>
              </tr>
              <tr id="SHPRow3"  style="display:none">
                <td><strong>Who Can View The Page</strong></td>
                <td><select name="Exposure" id="Exposure">
                  <option value="Public" <?php print($Insert['Exposure']=="Public" ? "selected": "");?>>Public</option>
                  <option value="Member" <?php print($Insert['Exposure']=="Member" ? "selected": "");?>>Member</option>
                  <option value="Both" <?php print($Insert['Exposure']=="Both" ? "selected": "");?>>Both Members and Public</option>
                </select></td>
              </tr>
              <tr id="SHPRow4" style="display:none">
                <td><strong>Home Page</strong></td>
                <td><label>
                  <input type="radio" name="HomePage" value="Yes" <?php print($Insert['HomePage']=="Yes" ? "checked": "");?>>
                  Yes
                  <input name="HomePage" type="radio" value="No" <?php print($Insert['HomePage']=="No" ? "checked": "");?>>
                  No</label></td>
              </tr>
              <tr id="SHPRow5" style="display:none">
                <td><strong>Hide From Menu</strong></td>
                <td><input type="radio" name="Menu_Hide" value="Yes" <?php print($Insert['Menu_Hide']=="Yes" ? "checked": "");?>>
                  Yes
                  <input name="Menu_Hide" type="radio" value="No" <?php print($Insert['Menu_Hide']=="No" ? "checked": "");?>>
                  No</td>
              </tr>
              <tr id="SHPRow6" style="display:none">
                <td><strong>Sort Order</strong></td>
                <td><input name="Sort_Order" type="text" id="Sort_Order" value="<?php print $Insert['Sort_Order'];?>" size="4"></td>
              </tr>
              <tr>
                <td colspan="2"><a href="javascript:ShowHide(0);"><span id="ShowHideText">Show Search Engine Options</span></a></td>
              </tr>
              <tr id="SHRow0" style="display:none">
                <td><strong>Meta Title</strong></td>
                <td><input name="Meta_Title" type="text" id="MenuTitle4" value="<?php print $Insert['Meta_Title'];?>" size="45"></td>
              </tr>
              <tr id="SHRow1" style="display:none">
                <td><strong>Meta Keywords</strong></td>
                <td><input name="Meta_Keywords" type="text" id="Meta_Keywords" value="<?php print $Insert['Meta_Keywords'];?>" size="45"></td>
              </tr>
              <tr id="SHRow2" style="display:none">
                <td><strong>Meta Description</strong></td>
                <td><input name="Meta_Description" type="text" id="MenuTitle3" value="<?php print $Insert['Meta_Description'];?>" size="45"></td>
              </tr>
              <tr>
                <td colspan="2"><strong>Content<span class="RedText">*</span></strong></td>
              </tr>
              <tr>
                <td colspan="2" align="center">
                <textarea name="content_text" cols="120" rows="20" id="content_text"><?php print $TInsert['content_text'];?></textarea>
                  
                </td>
              </tr>
                
            </table>
            <input name="Button2" type="button" class="formbuttons" onClick="MM_goToURL('parent','modify.php');return document.MM_returnValue;return confirmSubmit()" value="Cancel">
            <input name="Submit" type="submit"  class="formbuttons" id="Submit3" value="Save" onClick="return confirmSubmit()">
            <input name="id" type="hidden" id="id" value="<?php print $id; ?>">
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
