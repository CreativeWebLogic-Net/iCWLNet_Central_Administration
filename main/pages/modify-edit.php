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
	
  if(!isset($Insert['sidebar_module_viewsID'])) $Insert['sidebar_module_viewsID']=0;
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Bubble CMS Lite Administration</title>
<link href="<?php print $app_data['asset-sever']; ?>/admin/css/management.css" rel="stylesheet" type="text/css">
<script src="<?php print $app_data['asset-sever']; ?>bcms/javascript/jquery-3.6.1.min.js"></script>
<link rel="stylesheet" href="<?php print $app_data['asset-sever']; ?>bcms/javascript/sceditor/minified/themes/default.min.css" id="theme-style" />
		  
		<script src="<?php print $app_data['asset-sever']; ?>bcms/javascript/sceditor/minified/themes/default.min.css" id="theme-style" /></script>
		  
		<script src="<?php print $app_data['asset-sever']; ?>bcms/javascript/sceditor/minified/sceditor.min.js"></script>
		<script src="<?php print $app_data['asset-sever']; ?>bcms/javascript/sceditor/minified/icons/monocons.js"></script>
		<script src="<?php print $app_data['asset-sever']; ?>bcms/javascript/sceditor/minified/formats/bbcode.js"></script>
    <style>
			html {
				font-family: Arial, Helvetica, sans-serif;
				font-size: 13px;
			}
			form div {
				padding: .5em;
			}
			code:before {
				position: absolute;
				content: 'Code:';
				top: -1.35em;
				left: 0;
			}
			code {
				margin-top: 1.5em;
				position: relative;
				background: #eee;
				border: 1px solid #aaa;
				white-space: pre;
				padding: .25em;
				min-height: 1.25em;
			}
			code:before, code {
				display: block;
				text-align: left;
			}
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

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
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
<!-- =============================== Start JQuery Functionality====================== -->
<script type="text/javascript" src="/templates/jquery/jquery.js"></script>
<script type="text/javascript">
	// onload start function
	$(function() {
		Check_Templates_Details();
		Set_SideBar_Code();
	});
	
	
	function Check_Templates_Details(){
		var CurrentTemplatesID=$('#templatesID').val();
		var TargetUrl="/management/main/ajax/pages.inc.php";
		var JSONData = {"cmd" : "has_template_got_sidebar","TemplatesID" :  CurrentTemplatesID};
		$.post(TargetUrl,JSONData,
			  function(data){
				//var answer=
				eval(data);
				//alert(response.sidebar_available);//data.sidebar_available); // John
				//console.log(data.time); //  2pm
				if(response.sidebar_available=="Yes"){
					$("#SidebarRow1").show();
					$("#SidebarRow2").show();
				}else{
					$("#SidebarRow1").hide();
					$("#SidebarRow2").hide();
					$("#sidebar_module_viewsID").val(0);
				}
				Set_SideBar_Code();
			  });//, "json");
	}
	
	function Set_SideBar_Code(){
		var WidgetType=$("#sidebar_module_viewsID").val();
		if(WidgetType!=11) $("#SidebarRow2").hide();
		else $("#SidebarRow2").show();
		
	}

</script>

<!-- =============================== End JQuery Functionality====================== -->
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
                <td colspan="2" align="center"><textarea name="content_text" cols="120" rows="20" id="content_text"><?php print(isset($TInsert['content_text']) ? $TInsert['content_text'] : "");?></textarea></td>
                </tr>
                <tr id="SidebarRow1">
                <td colspan="2" align="left"><strong>Side Bar : 
                  <select name="sidebar_module_viewsID" id="sidebar_module_viewsID" onChange="Set_SideBar_Code()">
                    <option value="0" <?php print($Insert['sidebar_module_viewsID']==0 ? "selected" : "");?>>No Side Bar</option>
                    <option value="32" <?php print($Insert['sidebar_module_viewsID']==32 ? "selected" : "");?>>News List Widget</option>
                    <option value="11" <?php print($Insert['sidebar_module_viewsID']==11 ? "selected" : "");?>>Text Widget</option>
                  </select>
                </strong></td>
              </tr>
              <tr id="SidebarRow2">
                <td colspan="2" align="center"><textarea name="content_text_sidebar" cols="120" rows="20" id="content_text_sidebar"><?php print $TSInsert['content_text'];?></textarea></td>
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
<script>
			var textarea = document.getElementById('content_text');
			sceditor.create(textarea, {
				format: 'xhtml',
				icons: 'monocons',
				style: '<?php print $app_data['asset-sever']; ?>bcms/javascript/sceditor/minified/themes/content/default.min.css'
			});


			var themeInput = document.getElementById('theme');
			themeInput.onchange = function() {
				var theme = '<?php print $app_data['asset-sever']; ?>bcms/javascript/sceditor/minified/themes/' + themeInput.value + '.min.css';

				document.getElementById('theme-style').href = theme;
			};
		</script>
<?php include("../includes/footer.php");?>
</body>
</html>
<?php 
  include("../includes/end-of-file.php");
?>
