<?php
	include("../../Admin_Start_Include.php");
	//print_r($_POST);
	
	switch($_POST['cmd']){
		case "has_template_got_sidebar" :
			if($_POST['TemplatesID']>0){
				$SearchTemplate=$_POST['TemplatesID'];
			}else{
				$rslt=$r->rawQuery("SELECT templatesID FROM domains WHERE id=$_SESSION[domainsID]");
				$data=mysql_fetch_array($rslt);
				$SearchTemplate=$data[0];
			}
			$rslt=$r->rawQuery("SELECT allow_sidebar FROM templates WHERE id=$SearchTemplate");
			$data=mysql_fetch_array($rslt);
			$response=array("sidebar_available"=>$data[0]);
			
		break;
		
	}
	print "response=".json_encode($response);
?>