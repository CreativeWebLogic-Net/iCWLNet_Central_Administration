<?php
		
	function SwapDates($Date){
		$TmpArr=split("-|/",$Date);
		return $TmpArr[2]."-".$TmpArr[1]."-".$TmpArr[0];
	}
	
	function FindInstanceDescription($ModuleName,$Instance){
		$r=new ReturnRecord();
		$sq2=$r->rawQueryX("SELECT Description FROM ".$ModuleName."_Instance WHERE Module_InstanceID='$Instance'");  
		while($myrow=@mysql_fetch_row($sq2)){
			return $myrow[0];
		}
		return "Standard";
	};
	
	function GetAdminEmail($Which){
		$r=new ReturnRecord();
		$sq2=$r->rawQuery("SELECT $Which FROM AdminEmails WHERE id='1'");  
		while($myrow=mysql_fetch_row($sq2)){
			return $myrow[0];
		};
	}
	
	function ReadAFile($filename){
		$handle = fopen($filename, "r");
		$contents = fread($handle, filesize($filename));
		fclose($handle);
		return $contents;
	}
?>
