<?php
    session_start();
	
	include("./Admin_Start_Include.php");
	
	
	
	
	if(isset($_GET['Message']))$Message=$_GET['Message'];
	
	

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
          <?php include("./main/includes/submenu-hosting.php");?>
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
                <td> <h2>Hosting</h2>
                
                <table width="100%"><tbody><tr><td valign="top"><p>Windows Hosting Features</p><p><br></p><table><tbody><tr><td><span style="color: rgb(80, 103, 117); font-family:" open="">Key Features<br></span> <br></td><td><br></td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">Host Website</span> <br></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">Windows Server 2019</span> <br></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">Plesk Obsidian 18.x</span> <br></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">One Click Script Installation</span> <br></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">Email Accounts</span> <br></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">SQL Databases</span> <br></td><td>X</td></tr><tr><td><font face="Open Sans, Arial" color="#434343"><span style="font-size: 15px; background-color: rgb(255, 255, 255);">Sub Domains</span></font></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">Parked Domains</span></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">Free Website Backup</span></td><td>X</td></tr><tr><td><span style="color: rgb(80, 103, 117); font-family:" open="">Email Features</span></td><td><br></td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">POP3/SMTP/IMAP</span></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">Webmail Access</span></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">Autoresponders</span></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">Mailing Lists</span></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">Email Forwarders</span></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">Catch All Email</span></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">Junk Mail Filters</span></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">Anti Spam</span></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">Attachment Limit</span></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">Website Statistics</span></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">Awstats</span></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">Webalizer</span></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">Individual Mailbox Storage&nbsp;</span></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">Overall Mailbox Storage</span></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">Email Sends Per Hour</span></td><td>25</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open=""><br>Database Features<br><br></span></td><td><br></td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">MariaDB 10.5.x</span></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">MariaDB DB with phpMyAdmin</span></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">Anti Spam</span></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">MSSQL 2019 Express</span></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">Connect DB with SQL Management Studio</span></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">MySQL Connector/ODBC 3.51.30</span></td><td>X</td></tr><tr><td><span style="color: rgb(80, 103, 117); font-family:" open="">Programming Languages</span></td><td><br></td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">PHP 5.6,7.3,7.4,8.0</span></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">Classic ASP</span></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">ASP.net 3.5, 4.8, 6.0</span></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">.NET Core 2.x, 3.x, 5.x</span></td><td>X</td></tr><tr><td>MVC 4 and 5<br class="Apple-interchange-newline"></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">ASP.NET AJAX</span></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">ImageMagick</span></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">GD</span></td><td>X</td></tr><tr><td><span style="color: rgb(67, 67, 67); font-family:" open="">Perl</span></td><td>X</td></tr><tr><td>Curl</td><td>X</td></tr><tr><td>Cloudflare</td><td>X</td></tr><tr><td><br></td><td></td></tr></tbody></table><p class="sceditor-nlf"></p><br></td><td valign="top">Linux Hosting Features<br><br><table><tbody><tr><td>Basic Features<br><br></td><td><br></td></tr><tr><td>CPU Allocation</td><td>X</td></tr><tr><td>NVMe Storage</td><td>X</td></tr><tr><td>Bandwidth</td><td>X</td></tr><tr><td>RAM Allocation</td><td>X</td></tr><tr><td>Free SSL Certificates</td><td>X</td></tr><tr><td>Inodes</td><td>X</td></tr><tr><td>Email Accounts</td><td>X</td></tr><tr><td>Sub-Domains</td><td>X</td></tr><tr><td>Addon Websites</td><td>X</td></tr><tr><td>PHP Version Selector</td><td>X</td></tr><tr><td>Remote Backups</td><td>X</td></tr><tr><td>Free Domain Registration</td><td>X</td></tr><tr><td>Free Dedicated IP</td><td>X</td></tr><tr><td><br>Account Features<br><br></td><td><br></td></tr><tr><td>Full Email Compaitability</td><td>X</td></tr><tr><td>Premium Website Builder</td><td>X</td></tr><tr><td>Softaculous (400+ Applications)</td><td>X</td></tr><tr><td>Upgrade At Anytime</td><td>X</td></tr><tr><td><br>Server Features<br><br></td><td><br></td></tr><tr><td>Litespeed</td><td>X</td></tr><tr><td>Anti-DDoS Protection</td><td>X</td></tr><tr><td>10Gbit Ports</td><td>X</td></tr><tr><td>99.9% Uptime</td><td>X</td></tr><tr><td><br>Email Features<br><br></td><td><br></td></tr><tr><td>Email Accounts</td><td>X</td></tr><tr><td>Email Forwarders</td><td>X</td></tr><tr><td>Email Auto-Responders</td><td>X</td></tr><tr><td>Mail Lists</td><td>X</td></tr><tr><td>Catch-All Email</td><td>X</td></tr><tr><td>Vacation Messages</td><td>X</td></tr><tr><td>Webmail Access</td><td>X</td></tr><tr><td>Squirrelmail</td><td>X</td></tr><tr><td>Roundcube</td><td>X</td></tr><tr><td>Spam Assassin</td><td>X</td></tr><tr><td>Spam Filters</td><td>X</td></tr><tr><td>Applications</td><td>X</td></tr><tr><td>Wordpress</td><td>X</td></tr><tr><td>Joomla</td><td>X</td></tr><tr><td>Portals / CMS</td><td>X</td></tr><tr><td>E-Commerce</td><td>X</td></tr><tr><td>Blogs</td><td>X</td></tr><tr><td>Customer Support Apps</td><td>X</td></tr><tr><td>Project Management Apps</td><td>X <br></td></tr><tr><td>Image Galleries</td><td>X</td></tr><tr><td>Wiki's</td><td>X</td></tr><tr><td>Blogs</td><td>X</td></tr><tr><td>Calenders</td><td>X</td></tr><tr><td>Gaming Related Apps&gt;</td><td>X</td></tr><tr><td>Mail Apps</td><td>X</td></tr><tr><td>Forums</td><td>X</td></tr><tr><td>Frameworks</td><td>X</td></tr><tr><td>Billing Apps</td><td>X</td></tr><tr><td>Premium Site Builder</td><td>X</td></tr><tr><td>Educational Apps</td><td>X</td></tr><tr><td><br>Control Panel Features<br><br></td></tr><tr><td>Free SSL Installer</td><td>X</td></tr><tr><td>System Information</td><td>X</td></tr><tr><td>Resource Usage</td><td>X</td></tr><tr><td>File Manager</td><td>X</td></tr><tr><td>Apache Handlers</td><td>X</td></tr><tr><td>Create/Restore Backups</td><td>X</td></tr><tr><td>CronJob Management</td><td>X</td></tr><tr><td>2FA Authentication</td><td>X</td></tr><tr><td>Password Protected Directories</td><td>X</td></tr><tr><td>Mime Types</td><td>X</td></tr><tr><td>DNS Management</td><td>X</td></tr><tr><td>SSH Access</td><td>X</td></tr></tbody></table></td></tr></tbody></table><p class="sceditor-nlf"><br></p>            
           
				
				</td>
              </tr>
          </table></td>
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