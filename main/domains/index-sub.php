<?php
	include("../../Admin_Start_Include.php");
	//-----------------------------------------------------------------------------------------------------------	
	// Get public domains to add subdomains
	//-----------------------------------------------------------------------------------------------------------
	try{
		$r->Initialise_Remote_Server(true);
		$sql="SELECT id AS domainsID,domains.Name AS Host,ClientsID FROM domains WHERE Public='Yes'";
        $rslt=$r->rawQuery($sql);
        
        if($r->NumRows()>0){
            //$domain_name=$data[1];
            while($data=$r->Fetch_Assoc()){
                $app_data['public_domains'][]=$data;
            }
        }
	}catch(Exception $e){
		//print_r($e);
	}
	
	
	//$r= new ReturnRecord();  // base object for returning data or raw queries
  //--------Add new domain---------------------------------------------------------------------------------------------------	
	if(isset($_POST['Submit'])){
		if($_POST['Submit']){
      
      //------add domain to sitemanage.info-----------------------------------------------------------------------------------------------------	
      $r->Initialise_Remote_Server(true);
      $sql="SELECT id AS domainsID,Name AS Host,serversID FROM domains WHERE id='".$_POST['DomainsID']."'";
      $rslt=$r->rawQuery($sql);
      
      if($r->NumRows()>0){
        $data=$r->Fetch_Assoc();
        $app_data['selected_domain']=$data;
      }
      //------add domain to sitemanage.info-----------------------------------------------------------------------------------------------------	
      $_POST['Name']=$_POST['Name'].".".$app_data['selected_domain']['Host'];
      //$_POST['ClientsID']=$_SESSION['clientsID'];
      //$_POST['serversID']=$app_data['selected_domain']['serversID'];
      //------check domain unique-----------------------------------------------------------------------------------------------------	
     
      /*
      $sql="SELECT COUNT(*) AS domain_count FROM domains WHERE Name='".$_POST['Name']."'";
      print $sql;
      $rslt=$r->rawQuery($sql);
      $data=$r->Fetch_Array();
      
      if($data[0]>0){
        $Message="Website Taken Create A New Subdomain";

      }else{
       */ 
        //------add domain to sitemanage.info-----------------------------------------------------------------------------------------------------	
        $r->Initialise_Remote_Server(true);
        $m= new AddToDatabase($log);
        $m->Set_Database($r);
        $m->AddPosts($_POST,$_FILES);
        $m->AddExtraFields(array("ClientsID"=>$_SESSION['clientsID']));
			  $m->AddExtraFields(array("serversID"=>$app_data['selected_domain']['serversID']));
        $m->AddTable("domains");
        $m->DoStuff();
        $NewID=$m->ReturnID();

        
        if(isset($_POST['modulesID'])){
          if(is_array($_POST['modulesID'])){
            foreach($_POST['modulesID'] as $moduleID){
              $r->RawQuery("INSERT INTO domains_modules (domainsID,modulesID) VALUES ($NewID,$moduleID)");
            }
          }
        }
        
        //-------add domain to remote server----------------------------------------------------------------------------------------------------
        $domain_name=$app_data['remote_server']['domain_name'];
	      $r->Set_Current_Server($domain_name);
        if($r->Original_DBFile!=$r->DBFile){
          //print "$$-".$domain_name."--\n";
          //print $app_data['selected_domain']['Host'];	
          //$r->Initialise_Remote_Server($app_data['selected_domain']['Host']);

          $m= new AddToDatabase($log);
          $m->Set_Database($r);
          $m->Set_Remote_Database($domain_name);
          $m->AddPosts($_POST,$_FILES);
          $m->AddExtraFields(array("ClientsID"=>$_SESSION['clientsID']));
          $m->AddExtraFields(array("serversID"=>$app_data['selected_domain']['serversID']));
          $m->AddTable("domains");
          $m->DoStuff();
          $NewID=$m->ReturnID();

          
          if(isset($_POST['modulesID'])){
            if(is_array($_POST['modulesID'])){
              foreach($_POST['modulesID'] as $moduleID){
                $r->RawQuery("INSERT INTO domains_modules (domainsID,modulesID) VALUES ($NewID,$moduleID)");
              }
            }
          }
        }
        
        //-------show page----------------------------------------------------------------------------------------------------	

        
        
        $Message="Website Added";
      //}
      
			
		};
	}
	
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Bubble CMS Lite Administration</title>
<link href="<?php print $app_data['asset-sever']; ?>/admin/css/management.css" rel="stylesheet" type="text/css">
</head>
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
          <td valign="top"><form action="index-sub.php"  method="post" name="form2" onSubmit="YY_checkform('form2','FirstName','#q','0','You must fill in the field Name.','Email','S','2','You must fill in a valid Email Address.','UserName','#q','0','You must fill in the field Username.','Password','#q','0','You must fill in the field Password','Password2','#Password','6','Passwords must match.');return document.MM_returnValue" >
              <span class="pageheading">Add New Website </span><span class="RedText"><?php print $Message; ?></span><br>
              <br>
            Complete the Website details below.<br>
            <br>
            <span class="RedText"><strong>*</strong></span><strong> Mandatory Fields </strong>
            <table width="100%" border="0" cellpadding="3" cellspacing="1" id="tablecell">
              <tr>
                <td><strong>Website Title<span class="RedText">*</span></strong></td>
                <td><input name="SiteTitle" type="text" id="SiteTitle" size="45"></td>
              </tr>
              <tr>
                <td width="163"><strong> Website Address<span class="RedText">*</span></strong></td>
                <td width="352">
                    <input name="Name" type="text" id="Name" size="45"> .
                    <select name="DomainsID" id="DomainsID">
                    <?php

              if(count($app_data['public_domains'])>0){
                //$Count=0;
                $output="";
               $drop_array=$app_data['public_domains'];
                //print_r($drop_array);
                foreach($drop_array as $key=>$val){
                  //foreach($val as $key2=>$val2){
                    
                    $output.="\n<option value='".$val['domainsID']."'>".$val['Host']."</option>";
                    /*
                    //$tmp=($key2==$selected_key ? "selected" : "");
                    //echo"<option value='".$key2."' ".$tmp.">".$val2."</option>";
                    $output.='<tr class="'."\n";
                    $op=(($Count%2)==0 ? "row1" : "row2");
                    $output.=$op;
                    $output.='"><td>'.$val2.'</td>'."\n";
                    $output.='<td align="center"><a href="modify-edit.php?id='.$key2.'">'."\n";
                    $output.='<img src="../../images/modify.gif" width="47" height="16" border="0"></a></td>'."\n";
                    $output.='<td><div align="center"><input type="checkbox" name="DFiles[]" value="'.$key2.'">'."\n";
                    $output.='</div></td></tr>'."\n";
                    */
                    //$Count++;
                  //}
                }
                print $output;
              }
              ?></select>
                </td>
              </tr>
              <tr>
                <td><strong>Default Template</strong></td>
                <td><select name="templatesID" id="templatesID">
                  <?php
						
				//$r=new ReturnRecord();
				$rslt=$r->rawQuery("SELECT id,Name FROM templates ORDER BY Name");
				while($data=$r->Fetch_Array($rslt)){
					echo"<option value='$data[0]' $tmp>$data[1]</option>";
				};
			?>
                </select></td>
              </tr>
              <tr>
                <td><strong>Admin Email Address<span class="RedText">*</span></strong></td>
                <td><input name="AEmail" type="text" id="AEmail" size="45"></td>
              </tr>
              <tr>
                <td colspan="2"><strong>Google SiteMaps Meta Tag</strong></td>
              </tr>
              <tr>
                <td colspan="2"><textarea name="GSiteMapMeta" cols="110" id="GSiteMapMeta"></textarea></td>
              </tr>
              <tr>
                <td colspan="2"><strong>Google Analytics Code</strong></td>
              </tr>
              <tr>
                <td colspan="2"><textarea name="Analytics" cols="110" rows="9" id="Analytics"></textarea></td>
              </tr>
              <tr>
                <td><strong>Installed Modules</strong></td>
                <td><select name="modulesID[]" size="5" multiple id="modulesID[]">
                  <?php
					$rslt=$r->RawQuery("SELECT id,Name FROM modules WHERE optional='Yes'");
					while($myrow=$r->Fetch_Array($rslt)){
						echo "<option value='$myrow[0]' >$myrow[1]</a>";	
					}
				
				?>
                </select></td>
              </tr>
              </table>
            <p>
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