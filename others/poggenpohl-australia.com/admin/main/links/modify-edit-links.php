<?php
	include("../../Admin_Start_Include.php");
	
	$r= new ReturnRecord();  // base object for returning data or raw queries
	
	if($_POST['Submit']){
		$m= new UpdateDatabase();
		$m->AddPosts($_POST,$_FILES);
		$m->AddSkip(array("id"));
		$m->AddTable("Links");
		$m->AddID($_POST['id']);
		$m->DoStuff();
		$Message="Link Updated";
				
	};
	
	if($_GET['id']) $id=$_GET['id'];
	elseif ($_POST['id']) $id=$_POST['id'];
	
	
	$r->AddTable("Links");
	$r->AddSearchVar($id);
	$Insert=$r->GetRecord();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Admin</title>
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

</head>

<body>
<center>
<table width="829" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr>
    <td height="68" colspan="2" valign="top"><img src="../../images/logo.gif" width="261" height="68" /></td>
    <td width="569" valign="top"><div align="right"><img src="../../images/headerRight.gif" alt="topHeader" width="568" height="68" /></div></td>
  </tr>
  <tr>
    <td height="26" colspan="3" valign="middle" class="loggedInBar"><div align="right">Logged in as : 
	<?php
						//output administrator name
						$r=new ReturnRecord();
						$data=$r->rawQuery("SELECT UserName FROM Administrators WHERE id='$_SESSION[AdminKey]'");
						$dataarray=mysql_fetch_array($data);
						echo $dataarray[0];
					?>
	 </div></td>
  </tr>
  <tr>
    <td width="205" align="center" valign="top" class="leftColumnHeader"><table width="95%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="27"><a href="#" onclick="P7_TMall(0);return false">Expand All</a> | <a href="#" onclick="P7_TMall(1);return false">Collapse All</a> </td>
      </tr>
      <tr>
        <td><div align="left"> <a href="#" onclick="P7_TMall(0);return false"> </a></div>
          <span class="leftside">
          <br />
          <?php
			include("../../menu.php");  
		?>
          </span> </td>
      </tr>
    </table>
      <div align="left"></div>        </td>
    <td colspan="2" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="content">
      <!--DWLayoutTable-->
      <tr>
        <td width="9" height="13"></td>
        <td width="606"></td>
        <td width="9"></td>
      </tr>
      <tr>
        <td height="59"></td>
        <td valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><span class="pageheading"> </span><span class="RedText"><span class="contentHeading">Modify Link </span><?php print $Message; ?></span></td>
              <td width="20%" align="right"><a href="modify-links.php" class="buttonbacklist">Back To List </a></td>
            </tr>
          </table>
          <br />
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <!--DWLayoutTable-->
            <tr>
              <td width="606" height="17" valign="top"><img src="../../images/contentTop.gif" width="606" height="17" /></td>
            </tr>
            <tr>
              <td height="24" valign="top" class="box"><form action="modify-edit-links.php"  method="post" name="form2" onSubmit="YY_checkform('form2','FirstName','#q','0','You must fill in the field Name.','Email','S','2','You must fill in a valid Email Address.','UserName','#q','0','You must fill in the field Username.','Password','#q','0','You must fill in the field Password','Password2','#Password','6','Passwords must match.');return document.MM_returnValue" >
        Complete the link details below.<br>
        <br>
        <span class="RedText"><strong>*</strong></span><strong> Mandatory Fields </strong>
        <table width="99%" border="0" cellpadding="3" cellspacing="1" id="tablecell">
          <tr>
            <td><strong>Category</strong></td>
            <td><select name="LinkCategoriesID" id="LinkCategoriesID">
				<?php
					$r=new ReturnRecord();
					$sq2=$r->rawQuery("SELECT id,Name FROM LinkCategories");  
					while ($myrow = mysql_fetch_row($sq2)) {
						$Tmp=($Insert['LinkCategoriesID']==$myrow[0] ? "selected" : "");
						echo"<option value='$myrow[0]' $Tmp>$myrow[1]</option>";
					};
				?>
            </select></td>
          </tr>
          <tr>
            <td><strong>Name<span class="RedText">*</span></strong></td>
            <td><input name="Name" type="text" id="Name" value="<?php print $Insert['Name']; ?>" size="45"></td>
          </tr>
          <tr>
            <td><strong>Description</strong></td>
            <td><textarea name="Description" cols="45" rows="5" id="Description"><?php print $Insert['Description']; ?></textarea></td>
          </tr>
          <tr>
            <td><strong>Url</strong></td>
            <td><input name="Url" type="text" id="Name3" value="<?php print $Insert['Url']; ?>" size="45"></td>
          </tr>
          <tr>
            <td width="131"><strong>Sort Order  </strong></td>
            <td width="441"><input name="SOrder" type="text" id="Name4" value="<?php print $Insert['SOrder']; ?>" size="4"></td>
          </tr>
          <tr>
            <td height="25" colspan="2"><input name="Submit" type="submit"  class="formbuttons" id="Submit" value="Save" onClick="return confirmSubmit()">
              <input name="id" type="hidden" id="id" value="<?php print $id; ?>"></td>
          </tr>
        </table>
          </form></td>
            </tr>
            <tr>
              <td height="12" valign="top"><img src="../../images/contentFooter.gif" width="606" height="12" /></td>
            </tr>
            
          </table>
          <br /></td>
        <td></td>
      </tr>
      
      
      
      
      
      
    </table></td>
  </tr>

  <tr>
    <td height="31" colspan="3" class="footer"><div align="right">&copy; Copyright IWebBiz </div></td>
  </tr>
  <tr>
    <td height="1"></td>
    <td width="56"></td>
    <td></td>
  </tr>
</table>
</center>
</body>
</html>
