<?php
	include("../../Admin_Start_Include.php");
	
	if($_POST['Delete']=="Delete"){
		if(is_array($_POST['DFiles'])){
			$m= new DeleteFromDatabase();
			$m->AddIDArray($_POST['DFiles']);
			$m->AddTable("Links");
			$Errors=$m->DoDelete();
			if($Errors==""){
				$Message="Links Deleted";
			}else{
				$Message=$Errors;
			};
		}else{
			$Message="No Links Selected To Delete";
		};
	};
	
	
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
        <td valign="top"><span class="contentHeading">Modify / Delete Links </span><span class="RedText"><?php print $Message; ?></span><br />
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <!--DWLayoutTable-->
            <tr>
              <td width="606" height="17" valign="top"><img src="../../images/contentTop.gif" width="606" height="17" /></td>
            </tr>
            <tr>
              <td height="24" valign="top" class="box"><form action="modify-links.php"  method="post" name="form2" id="form2" >
                <span class="pageheading"> </span>
                <table width="100%" border="0" cellpadding="3" cellspacing="1" id="table">
                  <tr bgcolor="#363E57" id="tablecell">
                    <td class="tableHeaders"><span class="tabletitle">Category </span></td>
                    <td class="tableHeaders"><span class="tabletitle">Name</span></td>
                    <td width="1%" align="center" class="tableHeaders">Modify</td>
                    <td width="1%" align="center" class="tableHeaders">Delete</td>
                  </tr>
                  <?php
					  	$Count=0;
					 	$r=new ReturnRecord();
						$sq2=$r->rawQuery("SELECT Links.id,LinkCategories.Name,Links.Name FROM Links,LinkCategories WHERE Links.LinkCategoriesID=LinkCategories.id");  
						while ($myrow = mysql_fetch_row($sq2)) {
						?>
                  <tr bgcolor="<?=(($Count%2)==0 ? "#DDDDDD" : "#EBEBEB"); ?>">
                    <td><?=$myrow[1];?></td>
                    <td><?=$myrow[2];?></td>
                    <td align="center"><a href="modify-edit-links.php?id=<?=$myrow[0];?>"><img src="../../images/modify.gif" width="47" height="16" border="0" /></a><a href="modify-edit.php?id=<?=$myrow[0];?>"></a></td>
                    <td><div align="center">
                        <input type="checkbox" name="DFiles[]2" value="<?=$myrow[0];?>" />
                    </div></td>
                  </tr>
                  <?
							$Count++;
						};
					?>
                  <tr align="right" >
                    <td colspan="3" class="tableHeaders">&nbsp;</td>
                    <td align="center" class="tableHeaders"><input name="Delete2" type="submit" class="formbuttons" id="Delete2" value="Delete" onclick="return confirmSubmit()" />                    </td>
                  </tr>
                </table>
                <strong><br />
                  To Delete an Links:</strong> select the checkbox for that Link  and then choose Delete button. <br />
  <strong>Tip:</strong> You can select multiple Links. <br />
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
