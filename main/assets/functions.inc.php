<?php
	function ShowPath($Parent,$ClientsID,$BaseUrl){
		$r=new ReturnRecord();
		$rslt=$r->RawQuery("SELECT Name,Parent FROM assetfolders WHERE ClientsID='$ClientsID' AND id='$Parent'");
		while($data=mysql_fetch_array($rslt)){
			$ret="<a href='$BaseUrl?Parent=$Parent'>$data[0]</a>";
			$ret=showpath($data[1],$ClientsID,$BaseUrl)." / ".$ret;
		}
		return $ret;
	}
	
	function DeleteAsset($id){
		$r=new ReturnRecord();
		$rslt=$r->RawQuery("SELECT FileName,AssetFoldersID FROM assets WHERE id='$id'");
		while($data=mysql_fetch_array($rslt)){
			unlink("../../../assets/$data[1]/$data[0]");
		}
		$r->RawQuery("DELETE FROM assets WHERE id='$id'");
	}
	
	function DeleteAssetFolder($id){
		$r=new ReturnRecord();
		// get rid of files
		$rslt=$r->RawQuery("SELECT id,FileName FROM assets WHERE AssetFoldersID='$id'");
		while($data=mysql_fetch_array($rslt)){
			DeleteAsset($data[0]);
		}
		//get rid of child folders
		$rslt=$r->RawQuery("SELECT id FROM assetfolders WHERE Parent='$id'");
		while($data=mysql_fetch_array($rslt)){
			DeleteAssetFolder($data[0]);
		}
		// remove directory
		$r->RawQuery("DELETE FROM assetfolders WHERE id='$id'");
		rmdir("../../../assets/$id");
	}


?>
