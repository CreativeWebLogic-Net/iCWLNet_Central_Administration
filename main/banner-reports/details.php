<?php
	include("../../Admin_Start_Include.php");
	
	if($_GET['id']) $id=$_GET['id'];
	elseif ($_POST['id']) $id=$_POST['id'];
	
	$r->AddTable("users");
	$r->AddSearchVar($id);
	$Insert=$r->GetRecord();
	
	
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
        <td><?php include("../includes/submenu-banners.php");?></td>
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
              <p><span class="pageheading">Report Details For User -
                <?php print $Insert['id'];?>
                -
                <?php print $Insert['name'];?>
              </span></p>
              <p>Pay Per Click Total=<span class="contentHeading">
              <?php print $Insert['TheBill'];?>
              </span><br>
                <br>
                <br>
              Advert Amounts:-</p>
              <table width="100%" border="0" cellpadding="3" cellspacing="1" id="table">
                <tr bgcolor="#363E57" id="tablecell">
                  <td width="33%" height="18" align="center" class="tabletitle"> Advert Name</td>
                  <td width="37%" align="center" class="tabletitle">Banner Channel Name</td>
                  <td width="15%" align="center" class="tabletitle">Start Date</td>
                  <td width="15%" align="center" class="tabletitle">Amount</td>
                </tr>
                <?php
					  	$Count=0;
					 	$r=new ReturnRecord();
						$sq2=$r->rawQuery("SELECT Adverts.Name,Channels.Name,BillFrom,Fee,Channels.PInterval,DATEDIFF(NOW(),BillFrom),Deleted,DATEDIFF(DeletedDate,BillFrom),Channels.id FROM Adverts,Channels WHERE Adverts.ChannelsID=Channels.id AND usersID=$id AND Fee>0 ORDER BY BillFrom");  
						while ($myrow = $r->Fetch_Array($sq2)) {
							//$Total+=$myrow[1];
							if($myrow[6]=='Y') $myrow[5]=$myrow[7];
						?>
                <tr class="<?php print(($Count%2)==0 ? "row1" : "row2"); ?>">
                  <td align="center"><?php print $myrow[0];?></td>
      <td align="center"><?php print $myrow[1];?></td>
      <td align="center"><?php print $myrow[2];?></td>
      <td align="center"> $
        <?php
		
		$sq5=$r->rawQuery("SELECT Fee,PInterval FROM ChannelsCustom WHERE ChannelsID=$myrow[8] AND usersID=$id "); 
		if(mysql_num_rows($sq5)>0){ 
			$data = $r->Fetch_Array($sq5);
			$myrow[3]=$data[0];
			$myrow[4]=$data[1];
		}
		
		if($myrow[4]=="Days"){
			$STmp=$myrow[5]*$myrow[3];
		}elseif($myrow[4]=="Weeks"){
			$STmp=$myrow[5]*$myrow[3]/7;
		}elseif($myrow[4]=="Months"){
			$STmp=$myrow[5]*$myrow[3]/30.4375;
		}elseif($myrow[4]=="Years"){
			$STmp=$myrow[5]*$myrow[3]/365.25;
		}
		Print number_format($STmp,2);
		$ATotal+=$STmp;
		?></td>
                </tr>
                <?php
							$Count++;
						};
					?>
                <tr align="right" bgcolor="#B2C8D8">
                  <td colspan="3" bgcolor="#B2C8D8">Total:</td>
                  <td align="center"><span class="tableHeaders">
                    $ <?php printnumber_format($ATotal,2);?>
                  </span></td>
                </tr>
              </table>
              <p><span class="contentHeading"><strong>Payments</strong></span> </p>
              <table width="100%" border="0" cellpadding="3" cellspacing="1" id="table">
                <tr bgcolor="#363E57" id="tablecell">
                  <td width="83%" align="center"  class="tabletitle">Date</td>
                  <td width="17%" align="right"  class="tabletitle">Amount</td>
                </tr>
                <?php
					  	$Count=0;
					 	$r=new ReturnRecord();
						$sq2=$r->rawQuery("SELECT id,Amount,DatePaid FROM Payments WHERE usersID=$id ORDER BY DatePaid");  
						while ($myrow = $r->Fetch_Array($sq2)) {
							$Total+=$myrow[1];
						?>
                <tr class="<?php print(($Count%2)==0 ? "row1" : "row2"); ?>">
                  <td align="center"><?php print $myrow[2];?></td>
                  <td align="right"> $
                    <?php print $myrow[1];?></td>
                </tr>
                <?php
							$Count++;
						};
					?>
                <tr bgcolor="<?php print(($Count%2)==0 ? "#DDDDDD" : "#EBEBEB"); ?>">
                  <td align="right" bgcolor="#B2C8D8" class="tableHeaders">Total </td>
                  <td align="right" bgcolor="#B2C8D8" class="tableHeaders"><?php print $Total;?></td>
                </tr>
              </table>
              <p>Balance=
                <?php printnumber_format($Total-$Insert['TheBill']-$ATotal,2);?>
              </p>
              <br>
          </form></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php include("../includes/footer.php");?>
</body>
</html>
