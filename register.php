<?php
    session_start();
	
	include("./Admin_Start_Include.php");
	
	
	
	
	if(isset($_GET['Message']))$Message=$_GET['Message'];
	
	if(isset($_POST['Submit'])){
    if($_POST['contact_name']!=""){
      $client_name=$_POST['contact_name'];
    }else{
      $client_name=$_POST['name'];
    }
    $sql="INSERT INTO clients (Name) VALUES  ('".$client_name."')";
    
    //print $sql;
    $rslt=$r->RawQuery($sql);
    $Insert_Id=$r->Insert_Id();

    $hash=md5($_POST['UserName'].$_POST['password']);
    $sql="INSERT INTO administrators (name,email,username,password,administratorActive,SU,clientsID,hash) VALUES  ('".$_POST['contact_name']."','".$_POST['email']."'";
    $sql.=",'".$_POST['UserName']."','".$_POST['password']."','1','Yes','".$Insert_Id."','".$hash."')";
    
    //print $sql;
    $rslt=$r->RawQuery($sql);
    //$Insert_Id=$r->Insert_Id();
    //echo"10-----------------------------------------------------------".var_export($r,true)."------------------";
    if($_POST['subdomain']==""){
      $_POST['subdomain']=str_replace(" ","-",$client_name);
    }else{
      $_POST['subdomain']=str_replace(" ","-",$_POST['subdomain']);
    }
    
    $atd= new AddToDatabase($log);
    //echo"688-----------------------------------------------------------".var_export($r,true)."------------------";
    
   // $atd->Set_Log($log);
    $atd->Set_Database($r);
    //echo"689-----------------------------------------------------------".var_export($r,true)."------------------";
    
    $atd->Set_Vs($vs);
    $atd->AddPosts($_POST,$_FILES);
   // echo"690-----------------------------------------------------------".var_export($r,true)."------------------";
    
    $atd->AddTable("users");
    //echo"691-----------------------------------------------------------".var_export($r,true)."------------------";
    $FieldArray=array("clientsID"=>$Insert_Id,"STATUS"=>"New","administratorActive"=>0);
    $atd->AddExtraFields($FieldArray);
    $atd->DoStuff();
    $NewID=$atd->ReturnID();

    $econtent="\n\n Welcome to iCWLNet website builder. \n";
    $econtent.="You must activate your account. Please follow the below link \n";
    $econtent.="https://sitemanage.info/index.php?hash=".$hash." \n";
    $econtent.="Contact Us: https://creativeweblogic.net \n";
    $to      = $_POST['email'];
    $subject = 'New User Register';
    $message = $econtent;
    $headers = array(
        'From' => 'admin@sitemanage.info',
        'Reply-To' => 'admin@sitemanage.info',
        'X-Mailer' => 'PHP/' . phpversion()
    );

    mail($to, $subject, $message, $headers);
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
<?php include("./main/includes/header-empty.php");?>
<?php include("./main/includes/mainmenubar-empty.php");?>
<table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0" class="border">
  <tr>
    <td width="179" valign="top" class="ManagementContentLeftColumn"><table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0" class="ManagementContentLeftColumnLinks">
      <tr>
        <td height="10">&nbsp;</td>
      </tr>
      <tr>
        <td><span class="leftside">
          <?php include("./main/includes/submenu-login.php");?>
        </span></td>
      </tr>
    </table></td>
    <td valign="top" class="rightbg">
      <br />
      <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>
		  
	<form name="form1" method="post" action="">
			
  <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td valign="top"><form action="register.php"  method="post" name="form2" onSubmit="YY_checkform('form2','FirstName','#q','0','You must fill in the field Name.','Email','S','2','You must fill in a valid Email Address.','UserName','#q','0','You must fill in the field Username.','Password','#q','0','You must fill in the field Password','Password2','#Password','6','Passwords must match.');return document.MM_returnValue" >
              <span class="pageheading">Add New Account </span><span class="RedText"><?php print $Message; ?></span><br>
              <br>
            <br>
            <span class="RedText"><strong>*</strong></span><strong> Mandatory Fields </strong>
            <table width="100%" border="0" cellpadding="3" cellspacing="1" id="table">
              <tr>
                <td class="tabletitle"><strong>Profile Domain</strong></td>
                <td class="tablewhite"><input name="subdomain" type="text" id="subdomain" size="45"> .bizdirectory.online</td>
              </tr>
              <tr>
                <td width="163" class="tabletitle"><strong> Business Name<span class="RedText">*</span></strong></td>
                <td width="352" class="tablewhite"><input name="name" type="text" id="name" size="45"></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>Contact Name</strong></td>
                <td class="tablewhite"><input name="contact_name" type="text" id="contact_name" size="45"></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong> Email<span class="RedText">*</span></strong></td>
                <td class="tablewhite"><input name="email" type="text" id="email" size="45"></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>Address 1</strong></td>
                <td class="tablewhite"><input name="address2" type="text" id="address" size="45"></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>Address 2</strong></td>
                <td class="tablewhite"><input name="address" type="text" id="address" size="45"></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>Address 3</strong></td>
                <td class="tablewhite"><input name="address3" type="text" id="address" size="45"></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>Suburb</strong></td>
                <td class="tablewhite"><input name="suburb" type="text" id="suburb" size="45"></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>City</strong></td>
                <td class="tablewhite"><input name="city" type="text" id="city" size="45"></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>State</strong></td>
                <td class="tablewhite"><input name="state" type="text" id="state" size="45"></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>Postcode</strong></td>
                <td class="tablewhite"><input name="postcode" type="text" id="postcode" size="45"></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>Country</strong></td>
                <td class="tablewhite"><SELECT NAME="countryID" id="countryID">
                  <?php
					  	$Count=0;
					 //	$r=new ReturnRecord();
            //$sql="SELECT id,CategoryTitle FROM mod_business_categories WHERE domainsID=".$_SESSION['domainsID']." ORDER BY CategoryTitle";
            $sql="SELECT id,Country_Name FROM countries ORDER BY Country_Name";
            //print $sql;
						$sq2=$r->rawQuery($sql);  
						while ($myrow = $r->Fetch_Array($sq2)) {
							print "<option value='$myrow[0]' >$myrow[1]</option>";
						};
						?>
                </SELECT></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>Phone</strong></td>
                <td class="tablewhite"><input name="phone" type="text" id="phone" size="45"></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>Mobile</strong></td>
                <td class="tablewhite"><input name="mobile" type="text" id="mobile" size="45"></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>Fax</strong></td>
                <td class="tablewhite"><input name="fax" type="text" id="fax" size="45"></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>Website</strong></td>
                <td class="tablewhite"><input name="website" type="text" id="website" size="45"></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>Username:</strong> </td>
                <td class="tablewhite"><input name="UserName" type="text" id="UserName" size="45"></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>Password</strong></td>
                <td class="tablewhite"><input name="password" type="text" id="password" size="45"></td>
              </tr>
              
              <tr>
                <td class="tabletitle"><strong>TAX Identifier</strong></td>
                <td class="tablewhite"><input name="abn" type="text" id="abn" size="45"></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>Business Category</strong></td>
                <td class="tablewhite"><SELECT NAME="mod_business_categoriesID" id="mod_business_categoriesID">
                  <?php
					  	$Count=0;
					 //	$r=new ReturnRecord();
            //$sql="SELECT id,CategoryTitle FROM mod_business_categories WHERE domainsID=".$_SESSION['domainsID']." ORDER BY CategoryTitle";
            $sql="SELECT id,CategoryTitle FROM mod_business_categories WHERE domainsID=0 ORDER BY CategoryTitle";
            //print $sql;
						$sq2=$r->rawQuery($sql);  
						while ($myrow = $r->Fetch_Array($sq2)) {
							print "<option value='$myrow[0]' >$myrow[1]</option>";
						};
						?>
                </SELECT></td>
              </tr>
              <tr>
                <td class="tabletitle"><strong>Directory Description</strong></td>
                <td class="tablewhite"><textarea name="business_description" cols="45" rows="4" id="business_description"></textarea></td>
              </tr>
              
              <tr>
                <td colspan="2" align="center" class="tablewhite">
                <input name="Submit" type="submit"  class="formbuttons" id="Submit" value="Save" onClick="return confirmSubmit()">
					      </td>
              </tr>
              </table>
            <p><br>
              
              </p>
            </form></td>
        </tr>
      </table>

      </td>
		  <td>
		  
		  </td>
        </tr>
        
        
      </table>
      
      </form>
		  

		</td>
        </tr>
        
      </table></td>
  </tr>
</table>
<?php include("./main/includes/footer.php");?>
</body>
</html>
<?php 
  include("./main/includes/end-of-file.php");
?>