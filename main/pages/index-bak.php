<?php
	include("../../Admin_Start_Include.php");
	
	//$r= new ReturnRecord();  // base object for returning data or raw queries
	if(isset($_POST['Submit'])){
		if($_POST['Submit']){
			if(($_POST['URI']=="")||($_POST['URI']=="/example-page-address/")){
				$_POST['URI']=$_POST['Title'];
			}
			$_POST['URI']=dirify($_POST['URI']);// remove reserved characters
			if(substr($_POST['URI'],0,1)!="/") $_POST['URI']="/".$_POST['URI']; // if start of string not /
			if(substr($_POST['URI'],strlen($_POST['URI'])-1,1)!="/") $_POST['URI']=$_POST['URI']."/";// if end of string not /
			if(($_POST['MenuTitle']=="")||($_POST['MenuTitle']=="Example Menu Title")){
				$_POST['MenuTitle']=$_POST['Title'];
			}
			if($_POST['Meta_Title']=="") $_POST['Meta_Title']=$_POST['Title'];
			if($_POST['HomePage']=="Yes"){
				$r->RawQuery("UPDATE content_pages SET HomePage='No' WHERE domainsID=".$app_data['domainsID']." AND languagesID=".$app_data['languagesID']);
			}
			// check if no homepage
			$rslt=$r->RawQuery("SELECT COUNT(*) FROM content_pages WHERE domainsID=".$app_data['domainsID']." AND languagesID=".$app_data['languagesID']);
			$data=$r->Fetch_Array($rslt);
			if($data[0]==0){// if none set current to home
				$_POST['HomePage']="Yes";
				$_POST['URI']="/";
			}
			$m= new AddToDatabase($log);
      $m->Set_Database($r);
			$m->AddPosts($_POST,$_FILES);
			$m->AddTable("content_pages");
			$m->AddExtraFields(array("languagesID"=>$app_data['languagesID']));
			$m->AddExtraFields(array("domainsID"=>$app_data['domainsID']));
			$m->AddExtraFields(array("module_viewsID"=>1));
			$m->AddFunctions(array("Changed"=>"NOW()"));
			$m->DoStuff();
			$NewID=$m->ReturnID();
			$m= new AddToDatabase($log);
      $m->Set_Database($r);
			$m->AddPosts($_POST,$_FILES);
			$m->AddTable("mod_text");
			$m->AddExtraFields(array("content_pagesID"=>$NewID,"sidebar_content"=>"No"));
			$m->DoStuff();
      /* removed 2023-03-19
			if($_POST['sidebar_module_viewsID']==11){
				$_POST['content_text_sidebar']=$r->Escape($_POST['content_text_sidebar']);
				$r->RawQuery("INSERT INTO mod_text (content_pagesID,content_text,sidebar_content) VALUES ($NewID,'$_POST[content_text_sidebar]','Yes')");
			}
			removed 2023-03-19 */
			$Message="Page Added";
		};
	}
  
	$r->AddTable("domains");
	$r->AddSearchVar($app_data['domainsID']);
	$DInsert=$r->GetRecord();
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Bubble CMS Lite Administration</title>
<link href="<?php print $app_data['asset-sever']; ?>/admin/css/management.css" rel="stylesheet" type="text/css">
<script src="<?php print $app_data['asset-sever']; ?>bcms/javascript/jquery-3.6.1.min.js"></script>
<script src="https://cdn.tiny.cloud/1/3jsa01x4hcn3n3tkpahp3nay10ytu6ufb5vc51n3egqa9awu/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
  
    
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

function ClearText(target){
	target.value="";	
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
<!-- =============================== Start JQuery Functionality====================== -->
<!--
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
		if(WidgetType==11) $("#SidebarRow2").show();
		else $("#SidebarRow2").hide();
		
	}
-->
</script>

<!-- =============================== End JQuery Functionality====================== -->
</head>
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
          <td valign="top"><form action="index.php"  method="post" name="form2" onSubmit="YY_checkform('form2','FirstName','#q','0','You must fill in the field Name.','Email','S','2','You must fill in a valid Email Address.','UserName','#q','0','You must fill in the field Username.','Password','#q','0','You must fill in the field Password','Password2','#Password','6','Passwords must match.');return document.MM_returnValue" >
              <span class="pageheading">Add New Page </span><span class="RedText"><?php print $Message; ?></span><br>
              <br>
            Complete the page details below.<br>
            <br>
            <span class="RedText"><strong>*</strong></span><strong> Mandatory Fields </strong>
            <table width="100%" border="0" cellpadding="3" cellspacing="1" id="tablecell">
              <tr>
                <td><strong>Page Title<span class="RedText">*</span></strong></td>
                <td><input name="Title" type="text" id="Title" value="Example Page Title" size="45" onClick="ClearText(this)"></td>
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
					//$tmp=($data[0]==$DInsert['templatesID'] ? "selected" : "");
					//echo"<option value='$data[0]' $tmp>$data[1]</option>";
					echo"<option value='$data[0]' >$data[1]</option>";
				};
			?>
                </select></td>
              </tr>
              <tr id="SHPRow1" style="display:none">
                <td><strong>Page Address<span class="RedText">*</span></strong></td>
                <td><input name="URI" type="text" id="URI" value="/example-page-address/" size="45" onClick="ClearText(this)"></td>
              </tr>
              <tr id="SHPRow2" style="display:none">
                <td><strong>Menu Title</strong></td>
                <td><input name="MenuTitle" type="text" id="MenuTitle" value="Example Menu Title" size="45" onClick="ClearText(this)"></td>
              </tr>
              <tr id="SHPRow3"  style="display:none">
                <td ><strong>Who Can View The Page</strong></td>
                <td ><select name="Exposure" id="Exposure">
                  <option value="Public">Public</option>
                  <option value="Member">Member</option>
                  <option value="Both" selected>Both Members and Public</option>
                </select></td>
              </tr>
              <tr id="SHPRow4" style="display:none">
                <td><strong>Home Page</strong></td>
                <td><label>
                  <input type="radio" name="HomePage" value="Yes">
                  Yes
                  <input name="HomePage" type="radio" value="No" checked>
                  No</label></td>
              </tr>
              <tr id="SHPRow5" style="display:none">
                <td ><strong>Hide From Menu</strong></td>
                <td ><input type="radio" name="Menu_Hide" value="Yes">
                  Yes
                  <input name="Menu_Hide" type="radio" value="No" checked>
                  No</td>
              </tr>
              <tr id="SHPRow6" style="display:none">
                <td><strong>Sort Order</strong></td>
                <td><input name="Sort_Order" type="text" id="Sort_Order" size="4"></td>
              </tr>
              <tr>
                <td colspan="2"><a href="javascript:ShowHide(0);"><span id="ShowHideText">Show Search Engine Options</span></a></td>
              </tr>
              <tr id="SHRow0" style="display:none">
                <td><strong>Meta Title</strong></td>
                <td><input name="Meta_Title" type="text" id="MenuTitle4" size="45"></td>
              </tr>
              <tr id="SHRow1" style="display:none">
                <td><strong>Meta Keywords</strong></td>
                <td><input name="Meta_Keywords" type="text" id="Meta_Keywords" size="45"></td>
              </tr>
              <tr id="SHRow2" style="display:none">
                <td><strong>Meta Description</strong></td>
                <td><input name="Meta_Description" type="text" id="MenuTitle3" size="45"></td>
              </tr>
              <tr>
                <td colspan="2"><strong>Content<span class="RedText">*</span></strong></td>
              </tr>
              <tr>
                <td colspan="2" align="center"><textarea name="content_text" cols="120" rows="20" id="content_text"></textarea></td>
                </tr>
                <tr id="SidebarRow1">
                <td colspan="2" align="left"><strong>Side Bar : 
                  <select name="sidebar_module_viewsID" id="sidebar_module_viewsID" onChange="Set_SideBar_Code()">
                    <option value="0" selected>No Side Bar</option>
                    <option value="32">News List Widget</option>
                    <option value="11">Text Widget</option>
                  </select>
                </strong></td>
              </tr>
              <tr id="SidebarRow2">
                <td colspan="2" align="center"><textarea name="content_text_sidebar" cols="120" rows="20" id="content_text_sidebar"></textarea></td>
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

<script>
    tinymce.init({
      selector: 'textarea',
      plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });
  </script>
  <!--
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
    -->
<?php include("../includes/footer.php");?>
</body>
</html>
<?php 
  include("../includes/end-of-file.php");
?>