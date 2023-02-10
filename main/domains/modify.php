<?php
	include("../../Admin_Start_Include.php");
	$app_data['delete_domain']=array();
	if(isset($_POST['Delete'])){
		if($_POST['Delete']=="Delete"){
      $delete_id_array=$_POST['DFiles'];
      
			//if(is_array($_POST['DFiles'])){
      if(is_array($delete_id_array)){
        //---delete from sitemanage--------------------------------------------------------------------------";
        $r->Initialise_Remote_Server(true);
				$m= new DeleteFromDatabase($log);
        $m->Set_Database($r);
				$m->AddIDArray($_POST['DFiles']);
				$m->AddTable("domains");
				$Errors=$m->DoDelete();
        $Errors="";
				if($Errors==""){
					$Message="Web Sites Deleted";
				}else{
					$Message=$Errors;
				};
        
        //------get remote domain info-----------------------------------------------------------------------------------------------------
        $count=0;	
        //print "\n$$101-".var_export($_POST['DFiles'],true)."--\n";
        $id_array=$delete_id_array;
        $app_data['delete_domain']=array();
        foreach($delete_id_array as $key=>$val){
          //print "\n$$166855-".$val."--".$key."-".$count."--\n";
          
          $id_array[$key]=$val;
          //print "$$10199-".var_export($delete_id_array,true)."--\n";
          $sql="SELECT id AS domainsID,Name AS Host,serversID FROM domains WHERE id='".$val."'";
          $rslt=$r->rawQuery($sql);
          //print "\n$$10119-".$val."--".$sql."--\n";
          
          if($r->NumRows()>0){
            //print "$$101-".$data."--".$sql."--\n";
            $data=$r->Fetch_Assoc();
            //print "\n$$171-".var_export($data,true)."--".$r->current_link."--\n";
            //print_r($data);
            $delete_local_domain_data=$data;
            $app_data['delete_domain'][$count]=$delete_local_domain_data;
            
            //------get remote domain info-----------------------------------------------------------------------------------------------------	
            $remote_host=$delete_local_domain_data['Host'];
            //print "\n4444-".$remote_host."--\n";
            

            $remote=new clsDatabaseInterface($log);
            $remote->CreateDB();
            $remote->Set_Vs($vs);

            $remote->Set_Current_Server($remote_host);
            $sql2="SELECT id AS remote_domainsID,Name AS remote_Host,serversID AS remote_serversID FROM domains WHERE Name='".$remote_host."'";
            $rslt2=$remote->rawQuery($sql2);
            
            if($remote->NumRows()>0){
              
              $remote_data=$remote->Fetch_Assoc();
              $app_data['delete_domain'][$count]=array_merge($delete_local_domain_data, $remote_data);
              //print "\n$$1000-".var_export($remote_data,true)."--".$sql2."--\n";
              //$delete_domain_data = array_merge($delete_local_domain_data, $remote_data);
              //$delete_domain_data=$remote_data;

              //print_r($app_data['delete_domain']);
              //$app_data['delete_domain'][$count]=$delete_domain_data;
              //print_r($app_data['delete_domain']);
              
              $count++;
            }else{
              //print "\n$$7777777-no domain found->".$val."--".$sql2."--".$remote->current_link."--\n";
              $remote_data=array();
              $delete_domain_data =array();
            }
            
            
            //$r->Set_Current_Server($delete_domain_data['Host']);
            /*
            print_r($app_data['delete_domain']);
            $app_data['delete_domain'][]=$delete_domain_data;
            print_r($app_data['delete_domain']);\*/
            //$count++;
          }else{
            //print "$$171334-select error-".var_export($data,true)."--".$sql."-".$count."--\n";
            //print "\n$$88888-no home domain found->".$val."--".$sql."--".$r->current_link."---\n";
          }
          
        }
        //print "\n$$11111111-".var_export($app_data['delete_domain'],true)."----\n";
        //---delete from remote server--------------------------------------------------------------------------";
        
        foreach($app_data['delete_domain'] as $key=>$val){
          //$Domain_Name=$val['remote_Host'];
          if(count($val)>3){
            $m= new DeleteFromDatabase($log);
            $m->Set_Database($r);
            $m->Set_Remote_Database($val['remote_Host']);
            $m->ClearID();
            $m->AddID($val['remote_domainsID']);
            $m->AddTable("domains");
            $Errors=$m->DoDelete();
            $Errors="";
            if($Errors==""){
              $Message="Web Sites Deleted";
            }else{
              $Message=$Errors;
            };
          }
          
        }
        //-----------------------------------------------------------------------------------------------------------	
        //echo"--3334-\n\n";
        //print $sql;
        //print_r($app_data);
        $rslt=$r->rawQuery($app_data['domains_populate']['search_sql']);
        if($r->NumRows()>0){
          $app_data['domains']=array();
          while($data=$r->Fetch_Array()){
            $dval=$data[1]." -> ".$data[2];
            $app_data['domains'][]=array($data[0]=>$dval);
          };
        }
			}else{
				$Message="No Web Sites Selected To Delete";
			};
		};
	};
  /*
  print_r($app_data['delete_domain']);
	print_r($app_data['domains']);
  */
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
          <td><form action="modify.php"  method="post" name="form2" >
              <span class="pageheading">Modify / Delete Web Sites </span><span class="RedText"><?php print $Message; ?></span><br>
              <br>
              <table width="100%" border="0" cellpadding="3" cellspacing="1" id="table">
                <tr bgcolor="#363E57" id="tablecell">
                  <td class="tabletitle"> Website Address</td>
                  <td width="8%" align="center" class="tabletitle">Modify</td>
                  <td width="9%" align="center" class="tabletitle">Delete</td>
                </tr>
                <?php

              if(count($app_data['domains'])>0){
                $Count=0;
                $output="";
                $selected_key=$_SESSION['original_domainsID'];
                $drop_array=$app_data['domains'];
                //print_r($drop_array);
                foreach($drop_array as $key=>$val){
                  foreach($val as $key2=>$val2){
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
                    $Count++;
                  }
                }
                print $output;
              }
              /*
					  	$Count=0;
					 	if($_SESSION["SU"]!="No"){
							$sql="SELECT domains.id,Name FROM domains WHERE clientsID=$_SESSION[clientsID] ORDER BY Name";
						}else{
							$sql="SELECT domains.id,Name FROM domains,administrators_domains WHERE domains.id=administrators_domains.domainsID AND administratorsID=$_SESSION[administratorsID] AND clientsID=$_SESSION[clientsID] ORDER BY Name";
						}
						$sq2=$r->rawQuery($sql);  
						while ($myrow = $r->Fetch_Array($sq2)) {
						?>
                <tr class="<?php print(($Count%2)==0 ? "row1" : "row2"); ?>">
                  <td><?php print $myrow[1];?></td>
                  <td align="center"><a href="modify-edit.php?id=<?php print $myrow[0];?>"><img src="../../images/modify.gif" width="47" height="16" border="0"></a></td>
                  <td><div align="center">
                      <input type="checkbox" name="DFiles[]" value="<?php print $myrow[0];?>">
                  </div></td>
                </tr>
                <?php
							$Count++;
						};
            */
					?>
                <tr align="right" bgcolor="#B2C8D8">
                  <td colspan="2">&nbsp;</td>
                  <td align="center"><input name="Delete" type="submit" class="formbuttons" id="Delete" value="Delete" onClick="return confirmSubmit()">                  </td>
                </tr>
              </table>
            <strong><br>
              To Delete a Website:</strong> select the checkbox for that Website and then choose Delete button. <br>
            <strong>Tip:</strong> You can select multiple Websites. <br>
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