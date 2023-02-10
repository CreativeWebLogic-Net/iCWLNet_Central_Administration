<?php
	include("../../Admin_Start_Include.php");
	
	
	if(isset($_GET['id'])) $id=$_GET['id'];
	elseif (isset($_POST['id'])) $id=$_POST['id'];
	
	
	
	
	$r->AddTable("users");
	$r->AddSearchVar($id);
	$Insert=$r->GetRecord();
	
  if(isset($_POST['Submit'])){
    if($_POST['Submit']){
      $m= new UpdateDatabase($log);
      $m->Set_Database($r);
      $m->AddPosts($_POST,$_FILES);
      $m->AddSkip(array("id"));
      $m->AddTable("users");
      $m->AddID($_POST['id']);
      $m->DoStuff();
      $Message="User Updated";
    }
	}
	$r->AddTable("users");
	$r->AddSearchVar($id);
	$Insert=$r->GetRecord();
	
  if(!isset($Insert['accesslvl'])){
    $Insert['accesslvl']="";
  }
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Bubble CMS Lite Administration</title>
<link href="<?php print $app_data['asset-sever']; ?>/admin/css/management.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
var SHPrefix=Array();
var SHTextSpan=Array();
var SHHiddenText=Array();
var SHVisibleText=Array();
var SHRowCount=Array();
SHTextSpan[0]="ShowHideText";
SHPrefix[0]="SHAccount";
SHHiddenText[0]="Show Unpaid Transactions";
SHVisibleText[0]="Hide Upaid Transactions";
SHRowCount[0]=1;

SHTextSpan[1]="ShowHidePay";
SHPrefix[1]="SHPay";
SHHiddenText[1]="Show Account Payment";
SHVisibleText[1]="Hide Account Payment";
SHRowCount[1]=1;


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
      <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td valign="top">
            <form action="modify-edit.php"  method="post" name="form2" >
              <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><span class="pageheading">Modify Member </span><span class="RedText"><?php print $Message; ?></span></td>
                  <td width="20%" align="right"><a href="modify.php" class="buttonbacklist">Back To List </a></td>
                </tr>
              </table>
              <br>
              <span id="SHPay0" style="display:none">
              <table width="399" border="0" cellspacing="1" cellpadding="2" id="table">
                <tr class="tablewhite">
                  <td width="115" align="center">Pay Amount : </td>
                  <td width="137">$
                  <input type="text" name="Amount" id="Amount"></td>
                  <td width="131" align="center"><input type="submit" name="Pay" id="Pay" value="Pay Account"></td>
                </tr>
              </table>
              </span>
              
              
                
            <span class="RedText"><strong>*</strong></span><strong> Mandatory Fields </strong>
            <table width="100%" border="0" cellpadding="3" cellspacing="1" id="table">
              <tr>
                <td class="tabletitle"><strong>Member ID</strong></td>
                <td class="tablewhite"><?php print $Insert['id'];?></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>Sub Domain</strong></td>
                <td class="tablewhite"><input name="subdomain" type="text" id="subdomain" value="<?php print $Insert['subdomain'];?>" size="45"></td>
              </tr>
              <tr>
                <td width="163" class="tabletitle"><strong> Business Name<span class="RedText">*</span></strong></td>
                <td width="352" class="tablewhite"><input name="name" type="text" id="name" value="<?php print $Insert['name'];?>" size="45"></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>Contact Name</strong></td>
                <td class="tablewhite"><input name="contact_name" type="text" id="contact_name" value="<?php print $Insert['contact_name'];?>" size="45"></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong> Email<span class="RedText">*</span></strong></td>
                <td class="tablewhite"><input name="email" type="text" id="email" value="<?php print $Insert['email'];?>" size="45"></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>Address</strong></td>
                <td class="tablewhite"><input name="address" type="text" id="address" value="<?php print $Insert['address'];?>" size="45"></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>Suburb</strong></td>
                <td class="tablewhite"><input name="suburb" type="text" id="suburb" value="<?php print $Insert['suburb'];?>" size="45"></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>State</strong></td>
                <td class="tablewhite"><input name="state" type="text" id="state" value="<?php print $Insert['state'];?>" size="45"></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>Postcode</strong></td>
                <td class="tablewhite"><input name="postcode" type="text" id="postcode" value="<?php print $Insert['postcode'];?>" size="45"></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>Phone</strong></td>
                <td class="tablewhite"><input name="phone" type="text" id="phone" value="<?php print $Insert['phone'];?>" size="45"></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>Mobile</strong></td>
                <td class="tablewhite"><input name="mobile" type="text" id="mobile" value="<?php print $Insert['mobile'];?>" size="45"></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>Fax</strong></td>
                <td class="tablewhite"><input name="fax" type="text" id="fax" value="<?php print $Insert['fax'];?>" size="45"></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>Website</strong></td>
                <td class="tablewhite">http//
                  <input name="website" type="text" id="website" value="<?php print $Insert['website'];?>" size="45"></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>Password</strong></td>
                <td class="tablewhite"><input name="password" type="text" id="password" value="<?php print $Insert['password'];?>" size="45"></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>Status</strong></td>
                <td class="tablewhite"><select name="status" id="accesslvl">
                  <option value="New" <?php print($Insert['accesslvl']=="New" ? "selected" : "");?>>New Member</option>
                  <option value="Rejected" <?php print($Insert['accesslvl']=="Rejected" ? "selected" : "");?>>Rejected</option>
                  <option value="Approved" <?php print($Insert['accesslvl']=="Approved" ? "selected" : "");?>>Approved</option>
                </select></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>Abn</strong></td>
                <td class="tablewhite"><input name="abn" type="text" id="abn" value="<?php print $Insert['abn'];?>" size="45"></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>Business Category</strong></td>
                <td class="tablewhite">
                  <SELECT NAME="mod_business_categoriesID" id="mod_business_categoriesID">
                    <?php
                      $Count=0;
                    //$r=new ReturnRecord();
                    //$sq2=$r->rawQuery("SELECT id,CategoryTitle FROM mod_business_categories WHERE domainsID=".$_SESSION['domainsID']." ORDER BY CategoryTitle");  
                    $sq2=$r->rawQuery("SELECT id,CategoryTitle FROM mod_business_categories WHERE domainsID=0 ORDER BY CategoryTitle");  
                    while ($myrow = $r->Fetch_Array($sq2)) {
                      print "<option value='$myrow[0]' ".($Insert['mod_business_categoriesID']==$myrow[0] ? "selected" : "").">$myrow[1]</option>";
                    };
                    ?>
                  </SELECT>
                </td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>Directory Description</strong></td>
                <td class="tablewhite"><textarea name="business_description" cols="45" rows="4" id="business_description"><?php print $Insert['business_description'];?>
                </textarea></td>
              </tr>
            </table>
            <input name="Button2" type="button" class="formbuttons" onClick="MM_goToURL('parent','modify.php');return document.MM_returnValue;return confirmSubmit()" value="Cancel">
            <input name="Submit" type="submit"  class="formbuttons" id="Submit3" value="Save" onClick="return confirmSubmit()">
            <input name="id" type="hidden" id="id" value="<?php print $id; ?>">
          </form>
        </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?php include("../includes/footer.php");?>
</body>
</html>
<?php 
  include("../includes/end-of-file.php");
?>
