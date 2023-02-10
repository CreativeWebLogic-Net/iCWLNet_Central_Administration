<?php
	include("../../Admin_Start_Include.php");
	if(isset($_GET['Delete'])){
    if($_GET['Delete']=="Disable"){
      if(isset($_GET['DFiles'])){
        if(is_array($_GET['DFiles'])){
          $m= new BulkDBChange();
          $m->Set_Database($r);
          $m->AddIDArray($_GET['DFiles']);
          $m->WhatToChange("status","Rejected",false);
          $m->AddTable("users");
          $Errors=$m->DoChange();
          
          if($Errors==""){
            $Message="Accounts Disabled";
          }else{
            $Message=$Errors;
          };
        }else{
          $Message="No Accounts Selected To Disable";
        };
      }
    };

    if($_GET['Delete']=="Enable"){
      if(isset($_GET['DFiles'])){
        if(is_array($_GET['DFiles'])){
          $m= new BulkDBChange();
          $m->Set_Database($r);
          $m->AddIDArray($_GET['DFiles']);
          $m->WhatToChange("status","Approved",false);
          $m->AddTable("users");
          $Errors=$m->DoChange();
          
          if($Errors==""){
            $Message="Accounts Enabled";
          }else{
            $Message=$Errors;
          };
        }else{
          $Message="No Accounts Selected To Disable";
        };
      };
    };
  };
	
	
	
	
	
	if(isset($_GET['SText'])) $SText=$_GET['SText'];
	elseif (isset($_POST['SText'])) $SText=$_POST['SText'];
	if(isset($_GET['SType'])) $SType=$_GET['SType'];
	elseif (isset($_POST['SType'])) $SType=$_POST['SType'];
	if(isset($_GET['OType'])) $OType=$_GET['OType'];
	elseif (isset($_POST['OType'])) $OType=$_POST['OType'];
	else $OType="id";
	if(isset($_GET['OOType'])) $OOType=$_GET['OOType'];
	elseif (isset($_POST['OOType'])) $OOType=$_POST['OOType'];
	else $OOType="ASC";
	if(isset($_GET['NumRows'])) $NumRows=$_GET['NumRows'];
	elseif (isset($_POST['NumRows'])) $NumRows=$_POST['NumRows'];
	else $NumRows=10;
	if(isset($_GET['Page'])) $Page=$_GET['Page'];
	elseif(isset($_POST['Page'])) $Page=$_POST['Page'];
	else $Page=1;
	
  $SearchSQL="";
	$RecordsPerPage=$NumRows;
	$DynField="email";
	if(!empty($SText)){
		$SearchSQL="AND $SType LIKE '%$SText%'";
		if(($SType!="id")&&($SType!="name")) $DynField=$SType;
	};
	
	
	$SQL1="SELECT COUNT(*) FROM users,mod_business_categories ";
  $SQL1.="WHERE users.mod_business_categoriesID=mod_business_categories.id ";
  //$SQL1.="AND domainsID=".$_SESSION['domainsID']." ".$SearchSQL;
  $SQL1.="AND domainsID=0 ".$SearchSQL;
  //$SQL1="SELECT COUNT(*) FROM users,mod_business_categories WHERE users.mod_business_categoriesID=mod_business_categories.id AND domainsID=$_SESSION[domainsID] $SearchSQL";
	
  $rset=$r->rawQuery($SQL1);
  
	$rdata=$r->Fetch_Array($rset);
	if(isset($rdata[0])) $rcount=$rdata[0];
  else $rcount=0;
  
	$MaxPages=ceil($rcount/$RecordsPerPage);
	if($Page>$MaxPages) $Page=$MaxPages;
	$StartRecord=($Page-1)*$RecordsPerPage;
	if($StartRecord<0) $StartRecord=0;
	$SQL2="SELECT users.id,users.name,$DynField,status FROM users,mod_business_categories";
  $SQL2.=" WHERE users.mod_business_categoriesID=mod_business_categories.id ";
  $sql_domains="AND domainsID=$_SESSION[domainsID]";
  $sql_domains2="AND domainsID=0";
  $SQL3=$SQL2;
  $SQL2.=$sql_domains." $SearchSQL  ORDER BY $OType $OOType LIMIT $StartRecord,$RecordsPerPage";
  $SQL3.=$sql_domains2." $SearchSQL  ORDER BY $OType $OOType LIMIT $StartRecord,$RecordsPerPage";
	$rset=$r->rawQuery($SQL2);
  
  $SQL_table=$SQL2;
  //print $SQL2."\n\n<br>";
  $nrows=$r->NumRows();
  if($nrows<1){
    $rset=$r->rawQuery($SQL3);
    $nrows=$r->NumRows();
    $rcount=$nrows;
    if($nrows<1){
      $rcount=0;
    }else{
      $SQL_table=$SQL3;
    }
    
  }
  print "numrows=>".$nrows."--\n\n".$SQL3;
 
  if(!isset($SText)) $SText="";
  if(!isset($SType)) $SType="";
  if((isset($NumRows))&&(isset($SType))&&(isset($OType))&&(isset($OOType))&&(isset($SText))){
	  $NPPage="NumRows=".$NumRows."&SType=".$SType."&OType=".$OType."&OOType=".$OOType."&SText=".urlencode($SText);
  }else{
    $NPPage="";
  }
  $RecTo=($StartRecord+$RecordsPerPage);
	if($RecTo>$rcount) $RecTo=$rcount;
	
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

<body >
<?php include("../includes/header.php");?>
<?php include("../includes/mainmenubar.php");?>
<table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0" class="border">
  <tr>
    <td width="179" valign="top" class="ManagementContentLeftColumn"><table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0" class="ManagementContentLeftColumnLinks">
      <tr>
        <td height="10">&nbsp;</td>
      </tr>
      <tr>
        <td><?php include("../includes/submenu-members.php");?></td>
      </tr>
    </table></td>
    <td valign="top" class="rightbg">
      <br />
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><form action="modify.php"  method="get" name="form2" >
              <p><span class="pageheading">Modify / Delete Members </span><span class="RedText"><?php print $Message; ?></span></p>
              <table border="0" align="center" cellpadding="2" cellspacing="1"  id="table">
                <tr>
                  <td align="right" class="tabletitle">Keywords : </td>
                  <td width="150"><input name="SText" type="text" class="formFields" id="SText" value="<?php print $SText;?>" size="30"></td>
                  <td align="right" class="tabletitle">Search By :</td>
                  <td width="116" class="tabletitle"><select name="SType" class="formFields" id="SType">
                    <option value="id" <?php print($SType=="id" ? "selected" :"");?>>User ID</option>
                    <option value="name" <?php print($SType=="name" ? "selected" :"");?>>Name</option>
                    <option value="email" <?php print($SType=="email" ? "selected" :"");?>>Email</option>
                    <option value="address" <?php print($SType=="address" ? "selected" :"");?>>Address</option>
                    <option value="suburb" <?php print($SType=="suburb" ? "selected" :"");?>>Suburb</option>
                    <option value="state" <?php print($SType=="state" ? "selected" :"");?>>State</option>
                    <option value="postcode" <?php print($SType=="postcode" ? "selected" :"");?>>Postcode</option>
                    
                    <option value="phone" <?php print($SType=="phone" ? "selected" :"");?>>Phone</option>
                    <option value="mobile" <?php print($SType=="mobile" ? "selected" :"");?>>Mobile</option>
                    <option value="website" <?php print($SType=="website" ? "selected" :"");?>>Website</option>
                    <option value="contact_name" <?php print($SType=="contact_name" ? "selected" :"");?>>Contact Name</option>
                    <option value="abn" <?php print($SType=="abn" ? "selected" :"");?>>ABN</option>
                  </select></td>
                  <td width="75" colspan="4" rowspan="2" align="center" class="tabletitle"><input name="Search" type="submit" class="formButtons" value="Search"></td>
                </tr>
                <tr>
                  <td width="81" align="right" class="tabletitle">Sort By : </td>
                  <td align="center" class="tabletitle">
                    <select name="OType" id="OType">
                      <option value="id" <?php print($OType=="id" ? "selected" :"");?>>User ID</option>
                      <option value="name" <?php print($OType=="name" ? "selected" :"");?>>Name</option>
                      <option value="email" <?php print($OType=="email" ? "selected" :"");?>>Email</option>
                      <option value="status" <?php print($OType=="status" ? "selected" :"");?>>Status</option>
                    </select>
                  </td>
                  <td width="130" align="center" class="tabletitle">
                    <select name="OOType" id="OOType">
                      <option value="ASC" <?php print($OOType=="ASC" ? "selected" :"");?>>Ascending</option>
                      <option value="DESC" <?php print($OOType=="DESC" ? "selected" :"");?>>Descending</option>
                    </select>
                  </td>
                  <td align="center" class="tabletitle"><select name="NumRows" class="formFields" id="NumRows">
                    <option value="10">10 Rows</option>
                    <option value="20">20 Rows</option>
                    <option value="40">40 Rows</option>
                    <option value="80">80 Rows</option>
                    <option value="160">160 Rows</option>
                  </select></td>
                </tr>
              </table>
              <br>
              <table width="100%" border="0" cellpadding="3" cellspacing="1" id="table"  >
                <tr bgcolor="#363E57" id="tablecell">
                  <td width="13%" class="tabletitle"> ID</td>
                  <td width="34%" class="tabletitle">Name</td>
                  <td bgcolor="#363E57" class="tabletitle"><?php ucwords(str_replace("_"," ",$DynField));?></td>
                  <td width="4%" align="center" bgcolor="#363E57" class="tabletitle">Status</td>
                  <td width="9%" align="center" class="tabletitle">Modify</td>
                  <td width="9%" align="center" class="tabletitle">Select</td>
                </tr>
                <?php
					$Count=0;
          //echo "=>$rcount<=";
          $rset=$r->rawQuery($SQL_table);
          $rcount=$r->NumRows();
					if($rcount>0){
						while ($myrow = $r->Fetch_Array()) {
              //echo "$myrow[0]<=";
				?>
                <tr class="<?php print(($Count%2)==0 ? "row1" : "row2"); ?>">
                  <td><?php print $myrow[0];?></td>
                  <td><?php print $myrow[1];?></td>
                  <td><?php print $myrow[2];?></td>
                  <td align="center"><?php print $myrow[3];?></td>
                  <td align="center"><a href="modify-edit.php?id=<?php print $myrow[0];?>"><img src="../../images/modify.gif" width="47" height="16" border="0"></a></td>
                  <td><div align="center">
                      <input type="checkbox" name="DFiles[]" value="<?php print $myrow[0];?>">
                  </div></td>
                </tr>
                <?php
							$Count++;
						};
					};
					?>
                <tr align="right" bgcolor="#B2C8D8">
                  <td colspan="5" align="left" bgcolor="#B2C8D8"><p>
                    <?php print($StartRecord+1);?>
                    -
  <?php print $RecTo;?>
                    of
  <?php print $rcount;?>
                    Results</p>
                    <p>
                      <?php if($Page>1){ ?>
                      <a href="modify.php?Page=<?php print $Page-1;?>&<?php print $NPPage?>" >&lt;&lt;Back</a> 
                      <?php }; ?>
                      <?php
		for($x=1;$x<=$MaxPages;$x++){
			?><a href="modify.php?Page=<?php print $x;?>&<?php print $NPPage?>" ><?php print $x?></a> <?php
		};
	  ?>
                      <?php
						if($Page<$MaxPages){
					?>
                       <a href="modify.php?Page=<?php print $Page+1;?>&<?php print $NPPage?>" >Next &gt;&gt; </a>
                      <?php
						};
					?>
                  </p></td>
                  <td align="center"><input name="Delete" type="submit" class="formbuttons" id="Delete" value="Disable" onClick="return confirmSubmit()">
                  <input name="Delete" type="submit" class="formbuttons" id="Delete" value="Enable" onClick="return confirmSubmit()"></td>
                </tr>
              </table>
            <strong><br>
              To Delete an Administrator:</strong> select the checkbox for that Administrator and then choose Delete button. <br>
            <strong>Tip:</strong> You can select multiple Administrators. <br>
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
