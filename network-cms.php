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
          <?php include("./main/includes/submenu-network.php");?>
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
                <td>

                <h2>CMS Network</h2>
                <span id="sceditor-start-marker" class="sceditor-selection sceditor-ignore" style="display: none; line-height: 0;"> </span><span id="sceditor-end-marker" class="sceditor-selection sceditor-ignore" style="display: none; line-height: 0;"> </span><table width="100%"><tbody><tr><td valign="top"><img style="padding-right:50px" src="<?php print $app_data['asset-sever']; ?>/bcms/assets/portfolio.jpg"><br></td><td><div><table><tbody><tr><td valign="top">Cloud<a href="http://creativeweblogic.net"><br>creativeweblogic.net<br> </a><a href="http://ozychurch.com">ozychurch.com<br> </a><a href="http://internetlogistics.net">internetlogistics.net<br> </a><a href="http://sydneywebdev.net">sydneywebdev.net<br> </a><a href="http://w-d.biz">w-d.biz<br> </a><a href="http://web-dev.biz">web-dev.biz<br> </a><a href="http://website-design.sydney">website-design.sydney<br></a><a href="https://bizdirectory.online">bizdirectory.online</a><br> <a href="http://l--k.me">l--k.me - Url Shortener<br> </a><a href="http://sitemanage.info">sitemanage.info<br></a><a href="http://bizhome.me">bizhome.me</a><p class="" style=""></p><br></td><td>Linux Reseller #1<a href="http://icwl.me"><br>icwl.me<br> </a><a href="http://icwl.host">icwl.host<br> </a><a href="http://macquariechurch.com">macquariechurch.com<br> </a><a href="http://bubblecms.biz">bubblecms.biz<br> </a><a href="http://bizfurnace.com">bizfurnace.com<br> </a><a href="http://l-k.biz">l-k.biz<br> </a><a href="http://easycms.site">easycms.site<br> </a><a href="http://bizpage.club">bizpage.club<br> </a><a href="http://businesswebsites.club">businesswebsites.club<br></a><a href="http://cpanel-hosting.info">cpanel-hosting.info<br> </a><a href="http://freesslcert.club">freesslcert.club<br> </a><a href="http://imessages.club">imessages.club<br> </a><a href="http://inetbook.club">inetbook.club<br> </a><a href="http://promo-network.info">promo-network.info<br> </a><a href="http://smoothbuild.website">smoothbuild.website</a> <br></td></tr><tr><td>Linux Reseller #2<br> <a href="http://home-page.live">home-page.live<br> </a><a href="http://bizpages.me">bizpages.me<br> </a><a href="http://creativeweblogic.info">creativeweblogic.info<br> </a><a href="http://hostingdiscount.club">hostingdiscount.club<br> </a><a href="http://sydneygardening.info">sydneygardening.info</a> <br></td><td>Shared #1<br> <a href="http://ownpage.club">ownpage.club<br> </a><a href="http://website-development.online">website-development.online</a> <br></td></tr><tr><td>Wordpress<br> <a href="http://creativelogistics.site">creativelogistics.site</a> <br></td><td>VPS #1<br> <a href="http://auseo.net">auseo.net<br></a>VPS #2<br> <a href="http://ozhost.live">ozhost.live</a> <br> <br></td></tr><tr><td>White Label<br><a href="http://ozdev.org">ozdev.org<br> </a><a href="http://hostingproducts.club">hostingproducts.club<br></a>Shared #2<br> <a href="http://i-n.club">i-n.club</a> <br></td><td>Windows Reseller<a href="http://audev.org"><br>audev.org</a> <br></td></tr></tbody></table></div><p><br></p></td></tr></tbody></table><p class="sceditor-nlf"><br></p>            
           
				
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