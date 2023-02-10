<?php
	include("../../Admin_Start_Include.php");
	if(isset($_POST['Delete'])){
		if($_POST['Delete']=="Delete"){
			if(is_array($_POST['DFiles'])){
        $r->Set_Current_Server($app_data['remote_server']['domain_name']);
				$m= new DeleteFromDatabase();
        $m->Set_Database($r);
				$m->AddIDArray($_POST['DFiles']);
				$m->AddTable("content_pages");
				$Errors=$m->DoDelete();
				if($Errors==""){
					$Message="Pages Deleted";
				}else{
					$Message=$Errors;
				};
			}else{
				$Message="No Pages Selected To Delete";
			};
		};
	}else{
		//$Message="No Pages Selected To Delete";
	}
	if(isset($_POST['Sort'])){
		if($_POST['Sort']){
			print_r($_POST);
			if(is_array($_POST['SFiles'])){
        $r->Set_Current_Server($app_data['remote_server']['domain_name']);
				$m= new BulkDBChange();
        $m->Set_Database($r);
				$m->AddIDMultiArray($_POST['SFiles']);
				$m->WhatToChange("Sort_Order");
				$m->AddTable("content_pages");
				$Errors=$m->DoChange();
				
				if($Errors==""){
					$Message="Sort Orders Changed";
				}else{
					$Message=$Errors;
				};
			}else{
				$Message="No Available Items";
			};
		};
	}
	
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Bubble CMS Lite Administration</title>
<link href="<?php print $app_data['asset-sever']; ?>/admin/css/management.css" rel="stylesheet" type="text/css">
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
          <td><form action="modify.php"  method="post" name="form2" >
              <span class="pageheading">Modify / Delete Pages </span><span class="RedText"><?php print $Message; ?></span><br>
              <br>
              <table width="100%" border="0" cellpadding="3" cellspacing="1" id="table">
                <tr bgcolor="#363E57" id="tablecell">
                  <td width="28%" class="tabletitle"> Page Address</td>
                  <td width="28%" class="tabletitle">Title</td>
                  <td width="20%" bgcolor="#363E57" class="tabletitle">Menu Title</td>
                  <td width="7%" align="center" bgcolor="#363E57" class="tabletitle">Sort</td>
                  <td width="8%" align="center" class="tabletitle">Modify</td>
                  <td width="9%" align="center" class="tabletitle">Delete</td>
                </tr>
                <?php
					  	$Count=0;
					 	//$r=new ReturnRecord();
						$sql="SELECT id,URI,Title,MenuTitle,Sort_Order FROM content_pages WHERE domainsID=".$app_data['domainsID']." AND languagesID=".$app_data['languagesID']." AND module_viewsID=1 ORDER BY Sort_Order";
						//print $sql;
						$sq2=$r->rawQuery($sql);  
            $nrows=$r->NumRows();
            if($nrows>0){
                while ($myrow = $r->Fetch_Array($sq2)) {
                  ?>
                      <tr class="<?php print(($Count%2)==0 ? "row1" : "row2"); ?>">
                        <td><?php print $myrow[1];?></td>
                        <td><?php print $myrow[2];?></td>
                        <td><?php print $myrow[3];?></td>
                        <td align="center"><input name="SFiles[<?php print $myrow[0];?>]" type="text" id="SFiles[<?php print $myrow[0];?>]" value="<?php print $myrow[4];?>" size="3"></td>
                        <td align="center"><a href="modify-edit.php?id=<?php print $myrow[0];?>"><img src="../../images/modify.gif" width="47" height="16" border="0"></a></td>
                        <td><div align="center">
                            <input type="checkbox" name="DFiles[]" value="<?php print $myrow[0];?>">
                        </div></td>
                      </tr>
                      <?php
                    $Count++;
                  };
              }
						
					?>
                <tr align="right" bgcolor="#B2C8D8">
                  <td colspan="5"><input name="Sort" type="submit" class="formbuttons" id="Sort" value="Change Sort Order" onClick="return confirmSubmit()"></td>
                  <td align="center"><input name="Delete" type="submit" class="formbuttons" id="Delete" value="Delete" onClick="return confirmSubmit()">                  </td>
                </tr>
              </table>
            <strong><br>
              To Delete a Page:</strong> select the checkbox for that Page and then choose Delete button. <br>
            <strong>Tip:</strong> You can select multiple Pages. <br>
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
