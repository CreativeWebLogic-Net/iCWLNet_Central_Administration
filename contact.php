<?php
    session_start();
	
	include("./Admin_Start_Include.php");
	
	
	
	
	if(isset($_GET['Message']))$Message=$_GET['Message'];
	
  if(isset($_POST['Submit'])){
    $econtent="\n\n".$_POST['description']."\n\n";
    /*
    $email->To(array("danielruul78@gmail.com","dpr@icwl.me"));
    $email->From($_POST['name'],$_POST['email']);
    $email->Subject("SM iCWLNet Contact Form");
    $email->Body($econtent,$econtent);
    $email->Send();
    */

    $to      = 'danielruul78@gmail.com';
    $subject = 'SM iCWLNet Contact Form';
    $message = $econtent;
    $headers = array(
        'From' => 'admin@sitemanage.info',
        'Reply-To' => 'admin@sitemanage.info',
        'X-Mailer' => 'PHP/' . phpversion()
    );

    mail($to, $subject, $message, $headers);
    $Message="Email sent to admin.";
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
          <?php include("./main/includes/submenu-contact.php");?>
        </span></td>
      </tr>
    </table></td>
    <td valign="top" class="rightbg">
      <br />
      <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>
		  
	<form name="form1" method="post" action="">
			

      <table  border="0" align="center" cellpadding="0" cellspacing="0">
       
        <tr>
          <td align="center" ><table width="100%"  border="0" cellspacing="0" cellpadding="10">
              <tr>
                <td><h2>Contact US</h2>
                <table width="100%"><tbody><tr><td width="450px" valign="top"><img style="padding-right:50px" src="<?php print $app_data['asset-sever']; ?>/bcms/assets/contact.jpg"><br></td><td valign="top">Email: <a href="mailto:dpr@icwl.me">dpr@icwl.me</a><br> Phone: 61280033457<br> Mobile: 61474539524<br><br><a href="https://g.dev/cwl">Google Developer</a><br><a rel="ugc nofollow" title="https://www.facebook.com/Icwl.me" class="urlextern" href="https://www.facebook.com/Icwl.me">Facebook</a><br><a rel="ugc nofollow" title="https://twitter.com/daniel_ruul" class="urlextern" href="https://twitter.com/daniel_ruul"> Twitter</a><br><a rel="ugc nofollow" title="http://www.tiktok.com/@danielruul" class="urlextern" href="http://www.tiktok.com/@danielruul"> Tick Tock</a><br><a rel="ugc nofollow" title="https://www.linkedin.com/company/creative-web-logic/?lipi=urn%3Ali%3Apage%3Ad_flagship3_search_srp_all%3B7lvDVqY0SZmV8HnzC3Giuw%3D%3D" class="urlextern" href="https://www.linkedin.com/company/creative-web-logic/?lipi=urn%3Ali%3Apage%3Ad_flagship3_search_srp_all%3B7lvDVqY0SZmV8HnzC3Giuw%3D%3D"> Linked In<br></a><a href="https://wa.me/61474539524">Whats App</a><br><a href="https://github.com/danielruul78">Git Hub<br></a><a href="https://join.skype.com/invite/ujsaGrTZvMOi">Skype</a><br><a href="https://call.icq.com/789023ffffca4c79bf38b7730658ac3d">ICQ</a></td></tr></tbody></table><p class="sceditor-nlf"><span id="sceditor-start-marker" class="sceditor-selection sceditor-ignore" style="display: none; line-height: 0;"></span><span id="sceditor-end-marker" class="sceditor-selection sceditor-ignore" style="display: none; line-height: 0;"></span><br></p>            
           
				</td>
              </tr>
          </table>
          <form action="contact.php"  method="post" name="form2" >
              <span class="pageheading">Contact Administration </span><span class="RedText"><?php print $Message; ?></span><br>
              <br>
              <table width="100%" border="0" cellpadding="3" cellspacing="1" id="tablecell">
                <tr>
                  <td width="170"><strong> Name</strong></td>
                  <td width="465"><input name="name" type="text" class="formfield1" id="name"></td>
                </tr>
                <tr>
                  <td><strong>Email</strong></td>
                  <td><input name="email" type="text" class="formfield1" id="email"></td>
                </tr>
                <tr>
                <td ><strong>Contact Details</strong></td>
                <td><textarea name="description" cols="45" rows="4" id="description"></textarea></td>
              </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input name="Submit" type="submit" class="formbuttons" value="Send" onClick="return confirmSubmit()"></td>
                </tr>
              </table>
          </form>
        
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