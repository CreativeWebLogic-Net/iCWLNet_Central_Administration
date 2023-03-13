<?php
	
	//session_start();
  //echo"0001----------------------------||-------------------------------------------------\n\n";
	
	$load_file="./Admin_Start_Include.php";
  if(file_exists($load_file)){
    //echo"23322332111----------------------------||-------------------------------------------------\n\n";
	    include_once($load_file);
  }else{
    //echo"23322332----------------------------||-------------------------------------------------\n\n";
  }
  //echo"0002----------------------------||-------------------------------------------------\n\n";
	
	
	$login=false;
	
	if(isset($_GET['Message']))$Message=$_GET['Message'];
	if(isset($_GET['hash'])){
		$login=true;
		$sql="UPDATE administrators SET administratorActive=1 WHERE hash='".$_GET['hash']."'";
		$data=$r->rawQuery($sql);
		$sql="SELECT * FROM administrators where hash='".$_GET['hash']."' LIMIT 0,1";
	}

  //print_r($_POST);
	
	if(isset($_POST['Submit'])){
		if($_POST['Submit']!=""){
			$login=true;
			//$r=new ReturnRecord();
			$sql="SELECT * FROM administrators where username='$_POST[UserName]' and password='$_POST[Password]' AND administratorActive=1 LIMIT 0,1";
			print $sql;
			
		}
	}

	if($login){
    echo"\n\n0000----------------------------||-------------------------------------------------\n\n";
		$data=$r->rawQuery($sql);
    print_r($data);
    echo"\n\n0001----------------------------||-------------------------------------------------\n\n";
		$dataarray=$r->Fetch_Array($data);
		print_r($dataarray);
    echo"\n\n0002----------------------------||-------------------------------------------------\n\n";
	
		if(isset($dataarray[0])){
			if($dataarray[0]>0){ //admin login ok
				
				$_SESSION["administratorsID"]=$dataarray[0];
				$_SESSION["SU"]=$dataarray[6];
				$_SESSION["clientsID"]=$dataarray[7];
				$_SESSION["username"]=$dataarray[3];

				$_SESSION['original_clientsID']=$_SESSION["clientsID"];//$dataarray[2];
				$_SESSION['original_administratorsID']=$_SESSION["administratorsID"];//$dataarray[0];
				
				//$r=new ReturnRecord();
				if($_SESSION["SU"]=="CWL"){
					$sql="SELECT MIN( domains.id) FROM domains WHERE  clientsID=".$_SESSION['clientsID'];
				}else{
					$sql="SELECT MIN( domains.id) FROM domains,administrators_domains WHERE domains.id=administrators_domains.domainsID";
					$sql.=" AND administratorsID=$_SESSION[administratorsID] AND clientsID=$_SESSION[clientsID]";
				}
				
				print $sql;
				$rslt=$r->RawQuery($sql);
				if($rslt){
					if($r->NumRows($rslt)>0){
						$data=$r->Fetch_Array($rslt);
						if($data[0]>0){
							$_SESSION['original_domainsID']=$data[0];
							//$_SESSION['domainsID']=$data[0];
							//print_r($_SESSION);
						}
					}
				}
				//exit();
				$loc="Location: main/logged-in/index.php";
				//header($loc);
				//print $loc;
			}else{	//admin login bad
				$Message="Incorrect Username or Password";
			};
		}else{
			$Message="Incorrect Username or Password";
			
		}

	}
	

?><html>
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
		  <?php
		if(isset($_SESSION["administratorsID"])){
			
	?>
	We are redireting you into managment, <a href="main/logged-in/index.php">Click Here</a> To Manually Forward.
			<script>
			location.href = "main/logged-in/index.php";
			</script>
	<?php
			
		}else{
	?>	
	<form name="form1" method="post" action="">
			

      <table  border="0" align="center" cellpadding="0" cellspacing="0">
       
        <tr>
          <td align="center" ><table width="100%"  border="0" cellspacing="0" cellpadding="10">
              <tr>
                <td><table  border="0" align="center" cellpadding="0" cellspacing="6" class="ManagementLoginBox">
				<tr>
                      <td height="20" colspan="2" align="center" ><span class="blacktextbold">Welcome to Creative Web Logic's Website Builder</span></td>
                      </tr>
                  <tr>
                      <td height="20" colspan="2" align="center" ><span class="RedText"><?php print $Message; ?></span></td>
                      </tr>
                    <tr>
                      <td width="130" height="20" align="right" ><span class="blacktextbold"><strong>Username:</strong> &nbsp;</span> </td>
                      <td width="212"><input name="UserName" type="text" class="loginfield" id="UserName"></td>
                    </tr>
                    <tr>
                      <td  width="130" height="20" align="right"><span class="blacktextbold"><strong>Password:</strong> &nbsp;</span> </td>
                      <td><input name="Password" type="password" class="loginfield" id="Password"></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="center">
					  <input name="Login_Code" type="hidden" value="123456789"> 	
					  <input name="Submit" type="submit" class="loginbutton" value="Login"> <a href="register.php">Register</a>
					</td>
                      </tr>
                    
                </table>
				
				</td>
              </tr>
          </table></td>
		  <td>
		  
		  </td>
        </tr>
        
        
      </table>
      
      </form>
		  
<?php
		}
	  ?>
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