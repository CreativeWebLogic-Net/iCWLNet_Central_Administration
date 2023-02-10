<?php
	include("../../Admin_Start_Include.php");
	
	//$r= new ReturnRecord();  // base object for returning data or raw queries
	
  if(isset($_POST['Submit'])){
    if($_POST['Submit']){
      if(isset($_POST['URI'])){
        if(($_POST['URI']=="")||($_POST['URI']=="/news-item/example-page-address/")){
          if(isset($_POST['Title'])){
            $_POST['URI']="/news-item/".urlencode(str_replace(" ","-",$_POST['Title']))."/";
          }
        }
      }
      if(isset($_POST['Meta_Title'])){
        if($_POST['Meta_Title']=="") $_POST['Meta_Title']=$_POST['Title'];
      };
      $m= new AddToDatabase($log);
      $m->Set_Database($r);
      $m->AddPosts($_POST,$_FILES);
      $m->AddTable("content_pages");
      $m->AddExtraFields(array("languagesID"=>$_SESSION['languagesID']));
      $m->AddExtraFields(array("domainsID"=>$_SESSION['domainsID']));
      $m->AddExtraFields(array("module_viewsID"=>332));
      $m->AddExtraFields(array("Menu_Hide"=>"Yes"));
      $m->AddFunctions(array("Changed"=>"NOW()"));
      $m->DoStuff();
      $NewID=$m->ReturnID();
      $m= new AddToDatabase($log);
      $m->Set_Database($r);
      $m->AddPosts($_POST,$_FILES);
      $m->AddTable("mod_news");
      $m->AddExtraFields(array("content_pagesID"=>$NewID));
      $m->AddExtraFields(array("Approved"=>"Yes"));
      $m->DoStuff();
      
      
      $Message="Page Added";
    };
  };
	
  $r->AddTable("domains");
	$r->AddSearchVar($_SESSION['domainsID']);
	$DInsert=$r->GetRecord();
  if(!isset($DInsert['templatesID'])) $DInsert['templatesID']=0;
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Bubble CMS Lite Administration</title>
<link href="<?php print $app_data['asset-sever']; ?>/admin/css/management.css" rel="stylesheet" type="text/css">
</head>
<script language="javascript" type="text/javascript" src="/tinymce/jscripts/tiny_mce/tiny_mce_src.js"></script>
<script language="javascript" type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		plugins : "table,advhr,advimage,advlink,searchreplace,paste,directionality,noneditable,contextmenu,iespell",
		theme_advanced_buttons1_add_before : "",
		theme_advanced_buttons1_add : "fontselect,fontsizeselect",
		theme_advanced_buttons2_add : "separator,forecolor,backcolor,search,replace",
		theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator",
		theme_advanced_buttons3_add_before : "tablecontrols,separator",
		theme_advanced_buttons3_add : "advhr,separator,ltr,rtl,iespell",
		
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		content_css : "/templates/goat_general/css/general.css",
	    plugin_insertdate_dateFormat : "%Y-%m-%d",
	    plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "hr[class|width|size|noshade]",
		external_link_list_url : "example_link_list.js",
		external_image_list_url : "example_image_list.js",
		flash_external_list_url : "example_flash_list.js",
		file_browser_callback : "fileBrowserCallBack",
		paste_use_dialog : false,
		theme_advanced_resizing : true,
		theme_advanced_resize_horizontal : false,
		theme_advanced_link_targets : "_something=My somthing;_something2=My somthing2;_something3=My somthing3;"
	});
	
	var FileWindow;
	
	function fileBrowserCallBack(field_name, url, type, win) {
		FileWindow=win;
		// This is where you insert your custom filebrowser logic
		//alert("Filebrowser callback: field_name: " + field_name + ", url: " + url + ", type: " + type);
		window.open('/management/main/assets/assets.php?field_name='+ field_name +"&type=" + type,'Assets','width=650,height=600');
		// Insert new URL, this would normaly be done in a popup
		//win.document.forms[0].elements[field_name].value ="" ;
	}
	function CallBackReturn(field_name, url){
		FileWindow.document.forms[0].elements[field_name].value =url ;
	}
</script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}


function confirmSubmit()
{
var agree=confirm("Are you sure you wish to continue?");
if (agree)
	return true ;
else
	return false ;
}

function ClearText(target){
	target.value="";	
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
SHRowCount[1]=2;

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

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function YY_checkform() { //v4.71
//copyright (c)1998,2002 Yaromat.com
  var a=YY_checkform.arguments,oo=true,v='',s='',err=false,r,o,at,o1,t,i,j,ma,rx,cd,cm,cy,dte,at;
  for (i=1; i<a.length;i=i+4){
    if (a[i+1].charAt(0)=='#'){r=true; a[i+1]=a[i+1].substring(1);}else{r=false}
    o=MM_findObj(a[i].replace(/\[\d+\]/ig,""));
    o1=MM_findObj(a[i+1].replace(/\[\d+\]/ig,""));
    v=o.value;t=a[i+2];
    if (o.type=='text'||o.type=='password'||o.type=='hidden'){
      if (r&&v.length==0){err=true}
      if (v.length>0)
      if (t==1){ //fromto
        ma=a[i+1].split('_');if(isNaN(v)||v<ma[0]/1||v > ma[1]/1){err=true}
      } else if (t==2){
        rx=new RegExp("^[\\w\.=-]+@[\\w\\.-]+\\.[a-zA-Z]{2,4}$");if(!rx.test(v))err=true;
      } else if (t==3){ // date
        ma=a[i+1].split("#");at=v.match(ma[0]);
        if(at){
          cd=(at[ma[1]])?at[ma[1]]:1;cm=at[ma[2]]-1;cy=at[ma[3]];
          dte=new Date(cy,cm,cd);
          if(dte.getFullYear()!=cy||dte.getDate()!=cd||dte.getMonth()!=cm){err=true};
        }else{err=true}
      } else if (t==4){ // time
        ma=a[i+1].split("#");at=v.match(ma[0]);if(!at){err=true}
      } else if (t==5){ // check this 2
            if(o1.length)o1=o1[a[i+1].replace(/(.*\[)|(\].*)/ig,"")];
            if(!o1.checked){err=true}
      } else if (t==6){ // the same
            if(v!=MM_findObj(a[i+1]).value){err=true}
      }
    } else
    if (!o.type&&o.length>0&&o[0].type=='radio'){
          at = a[i].match(/(.*)\[(\d+)\].*/i);
          o2=(o.length>1)?o[at[2]]:o;
      if (t==1&&o2&&o2.checked&&o1&&o1.value.length/1==0){err=true}
      if (t==2){
        oo=false;
        for(j=0;j<o.length;j++){oo=oo||o[j].checked}
        if(!oo){s+='* '+a[i+3]+'\n'}
      }
    } else if (o.type=='checkbox'){
      if((t==1&&o.checked==false)||(t==2&&o.checked&&o1&&o1.value.length/1==0)){err=true}
    } else if (o.type=='select-one'||o.type=='select-multiple'){
      if(t==1&&o.selectedIndex/1==0){err=true}
    }else if (o.type=='textarea'){
      if(v.length<a[i+1]){err=true}
    }
    if (err){s+='* '+a[i+3]+'\n'; err=false}
  }
  if (s!=''){alert('The required information is incomplete or contains errors:\t\t\t\t\t\n\n'+s)}
  document.MM_returnValue = (s=='');
}
//-->
</script>

<body>
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
          <td valign="top"><form action="index.php"  method="post" enctype="multipart/form-data" name="form2" onSubmit="YY_checkform('form2','FirstName','#q','0','You must fill in the field Name.','Email','S','2','You must fill in a valid Email Address.','UserName','#q','0','You must fill in the field Username.','Password','#q','0','You must fill in the field Password','Password2','#Password','6','Passwords must match.');return document.MM_returnValue" >
              <span class="pageheading">Add New News Item</span><span class="RedText"><?php print $Message; ?></span><br>
              <br>
            Complete the news items details below.<br>
            <br>
            <span class="RedText"><strong>*</strong></span><strong> Mandatory Fields </strong>
            <table width="100%" border="0" cellpadding="3" cellspacing="1" id="table">
              <tr>
                <td class="tabletitle"><strong>News For Members Or The Public</strong></td>
                <td class="tablewhite"><select name="NType" id="NType">
                  <option value="Public">Public</option>
                  <option value="Member">Member</option>
                </select></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>News Title<span class="RedText">*</span></strong></td>
                <td class="tablewhite"><input name="Title" type="text" id="Title" value="Example News Item Title" size="45" onClick="ClearText(this)"></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>News Description</strong></td>
                <td class="tablewhite"><input name="description" type="text" id="description" value="" size="50" maxlength="150"></td>
              </tr>
              <tr>
                <td colspan="2" class="tabletitle"><a href="javascript:ShowHide(1);"><span id="ShowHidePageText">Show Page Options</span></a></td>
                </tr>
              <tr id="SHPRow0" style="display:none">
                <td width="163" class="tabletitle"><strong>Template</strong></td>
                <td width="352" class="tablewhite"><select name="templatesID" id="templatesID">
                  <?php
						
				$sql="SELECT id,Name FROM templates WHERE Hidden='No' ORDER BY Name";
        //$sql="SELECT id,Name FROM templates ORDER BY Name";
        //print $sql;
				$rslt=$r->rawQuery($sql);
				while($data=$r->Fetch_Array($rslt)){
					$tmp=($data[0]==$DInsert['templatesID'] ? "selected" : "");
					echo"<option value='$data[0]' $tmp>$data[1]</option>";
				};
        
			?>
                </select></td>
              </tr>
              <tr id="SHPRow1" style="display:none">
                <td class="tabletitle"><strong>Page Address<span class="RedText">*</span></strong></td>
                <td class="tablewhite"><input name="URI" type="text" id="URI" value="/news-item/example-page-address/" size="45" onClick="ClearText(this)"></td>
              </tr>
              <tr>
                <td colspan="2" class="tabletitle"><a href="javascript:ShowHide(0);"><span id="ShowHideText">Show Search Engine Options</span></a></td>
                </tr>
              <tr id="SHRow0" style="display:none">
                <td class="tabletitle"><strong>Meta Title</strong></td>
                <td class="tablewhite"><input name="Meta_Title" type="text" id="MenuTitle4" size="45"></td>
              </tr>
              <tr id="SHRow1" style="display:none">
                <td class="tabletitle"><strong>Meta Keywords</strong></td>
                <td class="tablewhite"><input name="Meta_Keywords" type="text" id="Meta_Keywords" size="45"></td>
              </tr>
              <tr id="SHRow2" style="display:none">
                <td class="tabletitle"><strong>Meta Description</strong></td>
                <td class="tablewhite"><input name="Meta_Description" type="text" id="MenuTitle3" size="45"></td>
              </tr>
              <tr>
                <td colspan="2" class="tabletitle"><strong>Content<span class="RedText">*</span></strong></td>
              </tr>
              <tr>
                <td colspan="2" align="center" class="tablewhite"><textarea name="content_text" cols="120" rows="20" id="content_text"></textarea></td>
                </tr>
            </table>
            <p><br>
              <input name="Submit" type="submit"  class="formbuttons" id="Submit" value="Save" onClick="return confirmSubmit()">
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
