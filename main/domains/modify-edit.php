<?php
	include("../../Admin_Start_Include.php");
  //echo "-000----------------------------------------------------------------------------";
  
	//$r->Set_Current_Server($app_data['remote_server']['domain_name']);
  //$r->Initialise_Remote_Server(true);
  //print_r($_GET);
	$id=false;
  $remote_domain_name=$app_data['remote_server']['domain_name'];
	if(isset($_GET['id'])) $id=$_GET['id'];
	elseif (isset($_POST['id'])) $id=$_POST['id'];
  if(isset($_POST['Name'])){
    $Domain_Name=$_POST['Name'];
  }else{
    $Domain_Name="sitemanage.info";
  }
 // print $id;
  //---get domain that is currently being edited--------------------------------------------------------------------------";
  
	if(is_numeric($id)){
    $Domain_Name=$app_data['remote_server']['domain_name'];
    //print $Domain_Name;
    
    //$r->Initialise_Remote_Server(true);
    //$r->Set_Current_Server($Domain_Name);
    $sql="SELECT COUNT(*) FROM domains WHERE id=$id AND clientsID=".$_SESSION['original_clientsID'];
    
		$rslt=$r->RawQuery($sql);
		$data=$r->Fetch_Array($rslt);
    
		if($data[0]==0){
      $error_message="Secuirty Error->".$sql." - ".$id." - ".var_export($data,true);
			exit($error_message);
		}else{
      $success_message="--311--Secuirty Error->".$sql." - ".$id." - ".var_export($data,true);
      //print $success_message;
    }
    
	}else{
		//print_r($_GET);
    $error_message="--303--Secuirty Error->".$id." - \n\n";
		exit($error_message);
	}
  
	if(isset($_POST['Submit'])){
		if($_POST['Submit']){
      //---update sitemanage--------------------------------------------------------------------------";
      //$r->Initialise_Remote_Server(true);
			$m= new UpdateDatabase($log);
      $m->Set_Database($r);
			$m->AddPosts($_POST,$_FILES);
			$m->AddSkip(array("id"));
			$m->AddTable("domains");
			$m->AddID($id);
			$m->DoStuff();
			$Message="Website Updated";
			$r->RawQuery("DELETE FROM domains_modules WHERE domainsID=$id");
			if(isset($_POST['modulesID'])){
				if(is_array($_POST['modulesID'])){
					foreach($_POST['modulesID'] as $moduleID){
						$r->RawQuery("INSERT INTO domains_modules (domainsID,modulesID) VALUES ($id,$moduleID)");
					}
				}
			}
			$_SESSION['ModsPermArr']=GetModulesPermissions();

      //------get remote domain info-----------------------------------------------------------------------------------------------------	
      /*
      $r->Set_Current_Server($Domain_Name);
      $sql="SELECT id AS domainsID,Name AS Host,serversID FROM domains WHERE Name='".$Domain_Name."'";
      $rslt=$r->rawQuery($sql);
      
      if($r->NumRows()>0){
        $data=$r->Fetch_Assoc();
        $app_data['edit_domain']=$data;
      }
      */
      //---update remote server--------------------------------------------------------------------------";
      
      /*
      $m= new UpdateDatabase($log);
      $m->Set_Database($r);
      $m->Set_Remote_Database($Domain_Name);
			$m->AddPosts($_POST,$_FILES);
			$m->AddSkip(array("id"));
			$m->AddTable("domains");
			$m->AddID($app_data['edit_domain']["domainsID"]);
			$m->DoStuff();
      if(isset($_POST['modulesID'])){
				if(is_array($_POST['modulesID'])){
					foreach($_POST['modulesID'] as $moduleID){
						$r->RawQuery("INSERT INTO domains_modules (domainsID,modulesID) VALUES ($id,$moduleID)");
					}
				}
			}
			$Message="Website Updated";
      */
		};
	};
  
	//---retrieve remote server domain variables to edit--------------------------------------------------------------------------";
  //$Domain_Name=$app_data['remote_server']['domain_name'];
  //$r->Initialise_Remote_Server(true);
  $r->AddTable("domains");
	$r->AddSearchVar($id);
	$Insert=$r->GetRecord();
  //print_r($Insert);
	$ModsArr=array();
	$rslt=$r->RawQuery("SELECT modulesID FROM domains_modules WHERE domainsID=$id");
	while($myrow=$r->Fetch_Array($rslt)){
		$ModsArr[]=$myrow[0];
	}
  
  //---show page--------------------------------------------------------------------------";
  
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
        <td><?php include("../includes/submenu-setup.php");?></td>
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
                  <td><span class="pageheading">Modify Website - <?php print $Insert['SiteTitle'];?></span> <span class="RedText"><?php print $Message; ?></span></td>
                  <td width="20%" align="right"><a href="modify.php" class="buttonbacklist">Back To List </a></td>
                </tr>
              </table>
            <br>
            Complete the website details below.<br>
            <br>
            <span class="RedText"><strong>*</strong></span><strong> Mandatory Fields </strong>
            <table width="100%" border="0" cellpadding="3" cellspacing="1" id="tablecell">
              <tr>
                <td><strong>Website Title<span class="RedText">*</span></strong></td>
                <td><input name="SiteTitle" type="text" id="SiteTitle" value="<?php print $Insert['SiteTitle'];?>" size="45"></td>
              </tr>
              <tr>
                <td width="163"><strong> Website Address<span class="RedText">*</span></strong></td>
                <td width="352"><input name="Name" type="text" id="Name" value="<?php print $Insert['Name'];?>" size="45"></td>
              </tr>
              <tr>
                <td><strong>Domain Mirror</strong></td>
                <td><select name="mirrorID" id="mirrorID">
                
                  <?php
                  //print_r($Insert);
                    $tmp=(0==$Insert['mirrorID'] ? "selected" : "");
                    $output="<option value='0' ".$tmp.">No Mirror</option>";
                    print $output;

                    $r->Initialise_Remote_Server(true);
                    //$r=new ReturnRecord();
                    $sql="SELECT id,Name,mirrorID FROM domains WHERE clientsID=".$_SESSION['original_clientsID']." AND id<>".$Insert['id']." ORDER BY Name";
                    print $sql;
                    $rslt=$r->rawQuery($sql);
                    while($data=$r->Fetch_Array($rslt)){
                      $tmp=($data[0]==$Insert['mirrorID'] ? "selected" : "");
                      echo"<option value='$data[0]' $tmp>$data[1]</option>";
                    };
                  ?>
                </select></td>
              </tr>
              <tr>
                <td><strong>Deafult Template</strong></td>
                <td><select name="templatesID" id="templatesID">
                  <?php
						
				//$r=new ReturnRecord();
				$rslt=$r->rawQuery("SELECT id,Name FROM templates ORDER BY Name");
				while($data=$r->Fetch_Array($rslt)){
					$tmp=($data[0]==$Insert['templatesID'] ? "selected" : "");
					echo"<option value='$data[0]' $tmp>$data[1]</option>";
				};
			?>
                </select></td>
              </tr>
              <tr>
                <td><strong>Admin Email Address<span class="RedText">*</span></strong></td>
                <td><input name="AEmail" type="text" id="AEmail" value="<?php print $Insert['AEmail'];?>" size="45"></td>
              </tr>
              <tr>
                <td colspan="2"><strong>Google SiteMaps Meta Tag</strong></td>
              </tr>
              <tr>
                <td colspan="2"><textarea name="GSiteMapMeta" cols="110" id="GSiteMapMeta"><?php print $Insert['GSiteMapMeta'];?></textarea></td>
                </tr>
              <tr>
                <td colspan="2"><strong>Google Analytics Code</strong></td>
                </tr>
              <tr>
                <td colspan="2"><textarea name="Analytics" cols="110" rows="9" id="Analytics"><?php print $Insert['Analytics'];?></textarea></td>
                </tr>
              <tr>
                <td><strong>Installed Modules</strong></td>
                <td><select name="modulesID[]" size="5" multiple id="modulesID[]">
                <?php
					$rslt=$r->RawQuery("SELECT id,Name FROM modules WHERE optional='Yes'");
					while($myrow=$r->Fetch_Array($rslt)){
						$tmp=(in_array($myrow[0],$ModsArr) ? "selected" : "");
						echo "<option value='$myrow[0]' $tmp>$myrow[1]</a>";	
					}
				
				?>
                </select></td>
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