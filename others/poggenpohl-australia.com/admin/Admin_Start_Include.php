<?
	session_start();
	if(!$_SESSION['AdminKey']){
		header("Location: ../..../index.php?Message=Session+Expired");
		exit();
	}
	include("../../DB_Class.php");
	$r=new ReturnRecord();


?>
