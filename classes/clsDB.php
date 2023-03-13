<?php
	
	class ReturnRecord{
		var $SQL;
		var $Table;
		var $TargetField="id";
		var $SearchVar;
		var $NewSearchVar=array();
		var $m;
		var $vs;
		var $links;
		var $result;
		var $DBFile="db-local.php";
		var $default_db="bubblelite2";
		public $log="";
		var $log_text="";
	
	
		//function ReturnRecord(){
		
		function __construct($DBlinks=false,&$vs=false){
			//exit("00");
			if($DBlinks!=false){
				if($DBlinks) $this->links=$DBlinks;
				if($vs) $this->vs=$vs;
			}
			
			
		}
		
		function Set_Log(&$log){
			$this->log=$log;
			$this->log->general('Boot Success: $r->',1);
				
		}
		
		function CreateDB(){
			try{
				$this->m = new ConnectDbase();
				$this->m->Set_Log($this->log);
				$this->m->Startup();
				
				//$this->links = $this->m->Connect($this->DBFile);
				$this->links = $this->m->Connect();
				if(isset($this->links->connect_error)) {
					$this->log->general("Connection failed: " . $this->links->connect_error,3);
				}else{
					$this->log->general("Connection Success: ".var_export($this->links,true),1);
				}
			}catch(MySQLErrorException $e){
				$this->log->general("MySQL Connection Error: ".var_export($e,true),3);
			}
			
		}
		
		function Set_All_Variables($vs){
			$this->vs = $vs;
			//$this->log=$this->vs->var_save["Classes"]['log'];
			$this->m->Set_Log($this->log);
				
		}
		
		function Get_Log_Text(){
			$this->log_text.=$this->m->log_text;
			return $this->log_text;
		}
		
		function Reset(){
			$this->Table="";
			$this->TargetField="id";
			$this->SearchVar="";
			$this->NewSearchVar=array();
		}
		
		function ChangeDBFile($db){
			$this->DBFile=$db;
			$this->m = new ConnectDbase();
			$this->links = $this->m->Connect($this->DBFile);
			//$this->links = $this->m->Connect($this->DBFile);
			$this->Set_Database($this->DBFile,$this->default_db);
		}
		
		function Set_Database($ser_nam,$dbname){
			$this->links[$ser_nam]->select_db($dbname);
		}
		
		function AddTable($Table){
			$this->Table=$Table;
		}
		function ChangeTarget($to){
			$this->TargetField=$to;
		}
		function AddSearchVar($id){
			$this->SearchVar=$id;
		}
		function AddNewSearchVar($key,$id){
			$this->NewSearchVar[$key]=$id;
		}
		function GetRecord(){
			if(!$this->links) $this->CreateDB();
			$m_arg = "SELECT * FROM $this->Table where $this->TargetField='$this->SearchVar'";
			foreach($this->NewSearchVar as $key=>$val){
				$m_arg .= " AND $key='$val'";
			}
			print $m_arg;
			$this->SQL=$m_arg;
			//$result=$this->rawQuery($m_arg);
			$this->result = $this->links->query($this->SQL);
			if($this->result){
				$m_rows = $this->Fetch_Assoc();
				//print_r($m_rows);
				if(is_array($m_rows)){
					foreach($m_rows as $key => $value){
						$m_rows[$key]=stripslashes($m_rows[$key]);
					};
				};
				return $m_rows;
			}else{
				$this->log->general("Multi MySQL Error->".var_export($this->result,true)." ".$query,3);
				//print "ERROR: $m_arg";
			}
		}
		function GetMultiRecord(){
			if(!$this->links) $this->CreateDB();
			$m_arg = "SELECT * FROM $this->Table where $this->TargetField='$this->SearchVar'";
			
			$this->result=$this->links->query($m_arg);
			if($this->result){
				while($m_rows = $this->Fetch_Array());
				{
					if(is_array($m_rows)){
						foreach($m_rows as $key => $value){
							$m_rows[$count][$key]=stripslashes($m_rows[$key]);
						};
					};
					$count++;
				}
			}else{
				$this->log->general("Multi MySQL Error->".var_export($this->result,true)." ".$query,3);
				//print "ERROR: $m_arg";
			}
			return $m_rows;
		}
		
		function rawQuery($query)
		{
			if(!$this->links) $this->CreateDB();
			try{
				$this->SQL=$query;
				if(isset($this->links)){
					$this->result = $this->links->query($query);
					
					if(!$this->result){
						$this->log->general("No MySQL Result->".$query,3);
						return false;
					}else{
						return $this->result;
					}
				}else{
					$this->log->general("No MySQL Session->".$query,3);
				}
			}catch(MySQLException $e){
				$this->log->general("MySQL Exception->".var_export($e,true)." ".$query,3);
			
			}
		}
		
		function NumRows(){
		$num_rows=$this->result->num_rows;
		//$num_rows=$this->links->num_rows;
		return $num_rows;
		/*	
		try{
				$num_rows=$this->links->num_rows;
				return $num_rows;
			}catch(MySQLErrorException $e){
				$this->log->general("MySQL NumRows Exception->".var_export($e,true)." ".$this->SQL,3);
				return 0;
			}
			
			
		*/
		}
		
		function Fetch_Array()
		{
			$row = $this->result->fetch_array(MYSQLI_NUM);
			return $row;
			
		}
		
		function Fetch_Assoc()
		{
			$row = $this->result->fetch_assoc();
			return $row;
			
		}
		
		function Error()
		{
			$er = $this->result->error;
			return $er;
			
		}
		
		
		function Escape($string)
		{
			$st = $this->links->real_escape_string($string);
			return $st;
			
		}
		
		function Insert_Id(){
			try{
				//$InsertID=$this->result->mysqli_insert_id();
				//$InsertID=$this->result->mysqli_insert_id();
				//$InsertID=$this->result->mysqli_insert_id;
				//$InsertID=$this->result->mysqli_insert_id($this->links);
				$InsertID = $this->links->insert_id;
				return $InsertID;
			}catch(﻿MySQLErrorException $e){
				$this->log->general("-Insert_Id failed--".var_export($e,true),3);
			}
		}
		
		function rawQueryX($query)
		{
			
			$temp = $this->links->query($query);
			return $temp;
		}
		
		function otherRawQuery($query)
		{
			
			
			$temp = $this->links->query($query);
			return $temp;
		}
		
		function returnDBLink()
		{
			return $this->links;
		}
		
	}
	
	/*
	class BulkDBChange{
		var $Table;
		var $RecordArray=array();
		var $MultiArray=array();
		var $WhatToChange;
		var $WhatToChangeTo;
		var $Target="id";
		var $Errors;
		var $DBFile="db-local.php";
		var $default_db="bubblelite2";
		var $m;
		var $r;
		var $links;
		
		function __construct(){
			//exit("00");
			
			$this->m = new ConnectDbase();
			$this->links = $this->m->Connect($this->DBFile);
			if($this->links->connect_error) {
				die("Connection failed: " . $this->links->connect_error);
			}
			$this->r = new ReturnRecord($this->links);
			//print_r($this->links);
			//exit("no links");
			
		}
		
		function ChangeDBFile($db){
			$this->DBFile=$db;
			$this->m = new ConnectDbase();
			$this->links = $this->m->Connect($this->DBFile);
			$this->r = new ReturnRecord();
			$this->Set_Database($this->DBFile,$this->default_db);
		}
		
		function Set_Database($ser_nam,$dbname){
			$this->links[$ser_nam]->select_db($dbname);
		}
		
		
		function AddTable($Table){
			$this->Table=$Table;
		}
		function AddIDMultiArray($DFiles){
			$this->MultiArray=$DFiles;
		}
		function AddIDArray($DFiles){
			$this->RecordArray=$DFiles;
		}
		function WhatToChange($var,$to=""){
			$this->WhatToChange=$var;
			$this->WhatToChangeTo=$to;
		}
		function ChangeTarget($var){
			$this->Target=$var;
			
		}
		
		function DoChange(){
			if(count($this->RecordArray)>0){
				foreach($this->RecordArray as $key => $value){
					
					$query= "UPDATE $this->Table SET $this->WhatToChange='$this->WhatToChangeTo' WHERE $this->Target='$value'";
					
					$result = $this->r->query($query);
					
				}
			}elseif(count($this->MultiArray)>0){
				//print_r($this->MultiArray);
				foreach($this->MultiArray as $key => $value){
					
					$query= "UPDATE $this->Table SET $this->WhatToChange='$this->WhatToChangeTo' WHERE $this->Target='$value'";
					
					$result = $this->r->query($query);
				}
			}else{
				$this->Errors.="No Items Selected";
			}
			return $this->Errors;
		}
	}
	*/
	/*
	
	
	class DeleteFromDatabase{
		var $Table;
		var $RecordArray=array();
		var $WhatToDelete="id";
		var $Errors;
		var $DBFile="db-local.php";
		var $default_db="bubblelite2";
		var $m;
		var $r;
		var $links;
		
		
		function __construct(){
			//exit("00");
			$this->m = new ConnectDbase();
			$this->links = $this->m->Connect($this->DBFile);
			if($this->links->connect_error) {
				die("Connection failed: " . $this->links->connect_error);
			}
			$this->r = new ReturnRecord($this->links);
			
		}

		
		
		function ChangeDBFile($db){
			$this->DBFile=$db;
			$this->m = new ConnectDbase();
			$this->links = $this->m->Connect($this->DBFile);
			$this->Set_Database($this->DBFile,$this->default_db);
		}
		
		function Set_Database($ser_nam,$dbname){
			$this->links[$ser_nam]->select_db($dbname);
		}
		
		function AddTable($Table){
			$this->Table=$Table;
		}
		
		function AddIDArray($DFiles){
			$this->RecordArray=$DFiles;
		}
		function AltDeleteVar($var){
			$this->WhatToDelete=$var;
		}
		
		function DeletePhotos($Photos){
			if(is_array($Photos)){
				foreach($Photos as $field => $path){
					foreach($this->RecordArray as $key => $value){
						$query= "SELECT $field FROM $this->Table WHERE $this->WhatToDelete='$value'";
						$result = $this->links->query($query);
						
						while($myrow=$result->fetch_row()){
							if($myrow[0]!=""){
								if(file_exists($path.$myrow[0])){
									unlink($path.$myrow[0]);
								}
							}
						}
					}
				}
			}
		}
		
		function DoDelete(){
			if(is_array($this->RecordArray)){
				foreach($this->RecordArray as $key => $value){
					
					$query= "DELETE FROM $this->Table where $this->WhatToDelete='$value'";
					$result = $this->links->query($query);
				}
			}else{
				$this->Errors.="No Items Selected";
			}
			return $this->Errors;
		}
	}
	*/
	/*
	class AddToDatabase{
		var $SQL;
		var $SQLFields;
		var $SQLData;
		var $Table;
		var $PostArray=array();
		var $FileArray=array();
		var $SkipArray=array();
		var $ValidArray=array();
		var $MoveArray=array();
		var $MoveToArray=array();
		var $Errors;
		var $NoDupes=array();
		var $DBFile="db-local.php";
		var $default_db="bubblelite2";
		var $FirstRun=true;
		var $InsertType="Insert";
		
		var $ExtraFields=array();
		
		var $ImageArray=array();
		var $ImageToArray=array();
		var $ImageSizeArray=array();
		var $ImageChangeTo=array();
		
		var $KImageArray=array();
		var $KSmallToArray=array();
		var $KBigToArray=array();
		var $KSmallDBArray=array();
		var $KBigDBArray=array();
		var $KImageSizeArray=array();
		var $FunctionArray=array();
		var $AutoIncrement="id";
		var $AutoIncVal=0;
		var $m;
		var $r;
		var $links;
		
		
		function __construct(){
			//exit("00");
			$this->m = new ConnectDbase();
			$this->links = $this->m->Connect($this->DBFile);
			if($this->links->connect_error) {
				die("Connection failed: " . $this->links->connect_error);
			}
			$this->r = new ReturnRecord($this->links);
			
		}
		
		function Reset(){
			$this->FirstRun=true;
			$this->SQLFields="";
			$this->SQLData="";
			$this->ExtraFields=array();
			$this->FunctionArray=array();
			$this->ValidArray=array();
			$this->AutoIncVal=0;
		}
		
		function str_makerand ($length) 
		{ 
			$minlength=$length;
			$maxlength=$length;
			$charset = "abcdefghijklmnopqrstuvwxyz"; 
			$charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
			$charset .= "0123456789"; 
			if ($minlength > $maxlength) $length = mt_rand ($maxlength, $minlength); 
			else                         $length = mt_rand ($minlength, $maxlength); 
			for ($i=0; $i<$length; $i++) $key .= $charset[(mt_rand(0,(strlen($charset)-1)))]; 
			return $key; 
		} 
		
		function ChangeInsertType($to){
			$this->InsertType=$to;
		}
		
		function ChangeDBFile($db){
			$this->DBFile=$db;
			$this->m = new ConnectDbase();
			$this->links = $this->m->Connect($this->DBFile);
			$this->Set_Database($this->DBFile,$this->default_db);
		}
		
		function Set_Database($ser_nam,$dbname){
			$this->links[$ser_nam]->select_db($dbname);
		}
		
		function AddNoDupe($NoDupe){
			$this->NoDupes=$NoDupe;
		}
		
		function AddID($id){
			$this->AutoIncVal=$id;
		}
		function AddFunctions($FunctionArray){
			$this->FunctionArray=$FunctionArray;
		}
		function AddExtraFields($FieldArray){
			$this->ExtraFields=array_merge($this->ExtraFields,$FieldArray);
		}
		function MoveFile($VarName,$MoveTo){
			$this->MoveArray[]=$VarName;
			$this->MoveToArray[]=$MoveTo;
		}
		function ResizeImage($VarName,$MoveTo,$Size,$ChangeTo=""){
			$this->ImageArray[]=$VarName;
			$this->ImageToArray[]=$MoveTo;
			$this->ImageSizeArray[]=$Size;
			$this->ImageChangeTo[]=$ChangeTo;
		}
		function KeepAndResizeImage($VarName,$DBSmall,$DBBig,$MoveToSmall,$MoveToBig,$Size){
			$this->KImageArray[]=$VarName;
			$this->KSmallDBArray[]=$DBSmall;
			$this->KBigDBArray[]=$DBBig;
			$this->KSmallToArray[]=$MoveToSmall;
			$this->KBigToArray[]=$MoveToBig;
			$this->KImageSizeArray[]=$Size;
		}
		
		function AddPosts($PArray,$FArray){
			$this->PostArray=$PArray;
			$this->FileArray=$FArray;
		}
		function AddSkip($SArray){
			$this->SkipArray=$SArray;
		}
		function AddTable($Table){
			$this->Table=$Table;
			$this->SetValid();
		}
		function ChangeAutoInc($to){
			$this->AutoIncrement=$to;
		}
		
		function ReturnID(){
			return $this->AutoIncVal;
		}
		function GetNextID(){
			if($this->AutoIncVal==0){
				
				$query= "SHOW TABLE STATUS LIKE '$this->Table'";
				$sq2 = $this->links->query($query);
				$result = $sq2->fetch_assoc();
				$this->AutoIncVal=$result['Auto_increment'];
			};
		}
		function IsDupes(){
			$RetVal=false;
			if(is_array($this->NoDupes)){
				foreach($this->NoDupes as $val){
					if($this->PostArray[$val]){
						$SQL="SELECT id FROM $this->Table WHERE $val='".$this->PostArray[$val]."'";
						//print $SQL;
						$sq2 = $this->r->query($SQL);
						while ($myrow = mysql_fetch_row($sq2)) {
							$RetVal=true;
							$this->Errors.="Duplicate field on $val ";
						};
					}
				};
			};
			return $RetVal;
		}
		
		
		function SetValid(){
			$m_arg = $this->r->query("SHOW COLUMNS FROM $this->Table");
			//$this->ValidArray = mysql_fetch_array(mysql_query($m_arg));
			while ($myrow = $this->r->FetchArray()) {
				$this->ValidArray[]=$myrow[0];
			};
		}
		
		
		
		function DoStuff(){
			if(!$this->IsDupes()){
				if($this->FirstRun){
					$First=true;
					$this->GetNextID();
					foreach($this->PostArray as $key => $value){
						//echo"key=$key -value=$value<br>";
						if((!in_array($key,$this->SkipArray))&&(in_array($key,$this->ValidArray))){
							if($First){
								$this->SQLFields.="$key";
								if(is_string($value)){
									$value=mysql_real_escape_string(stripslashes($value));
								};
								$this->SQLData="'$value'";
							}else{
								$this->SQLFields.=",$key";
								if(is_string($value)){
									$value=mysql_real_escape_string(stripslashes($value));
								};
								$this->SQLData.=",'$value'";
							};
							$First=false;
						};
					};
					//echo"==============FILES===========";
					if(isset($this->FileArray)){
						if(is_array($this->FileArray)){
							foreach($this->FileArray as $key => $value){
								//echo"key=$key----------------<br>";
								
								$value['name']=eregi_replace(" ","_",$value['name']); //get rid of spaces
								
								$MoveToKey=array_search($key,$this->MoveArray);
								//$ImageKey=array_search($key,$this->ImageArray);
								$ImageKeys=array_keys($this->ImageArray,$key);
								$KImageKey=array_search($key,$this->KImageArray);
								//echo"--$MoveToKey--";
								if(is_numeric($MoveToKey)){
									//echo"<br>Send File To ".$this->MoveToArray[$MoveToKey]." <br>";
									if($First){
										$this->SQLFields.="$key";
										$this->SQLData="'".$value['name']."'";
									}else{
										$this->SQLFields.=",$key";
										$this->SQLData.=",'".$value['name']."'";
									};
									copy($value['tmp_name'],$this->MoveToArray[$MoveToKey].$value['name']);
									if (file_exists($value['tmp_name'])) unlink($value['tmp_name']);
									$First=false;
								}elseif(is_array($ImageKeys)){
									//echo"<br>Send File To ".$this->ImageToArray[$ImageKey]." and Resize To ".$this->ImageSizeArray[$ImageKey]."<br>";
									foreach($ImageKeys as $IKey =>$IVal){
										//$value['name']=$this->str_makerand(5).$value['name'];
										if($value['name']!="") $value['name']=$this->str_makerand(5).$value['name'];
										$value['name'] = ereg_replace("[^A-Za-z0-9]", "", $value['name'] );
										print $value['name'];
										if($value['name']!="") $value['name']=$this->str_makerand(5).$value['name'];
										if($value['tmp_name']!="") $ImgData=getimagesize($value['tmp_name']);
										if($ImgData['channels']==4){
											exec("convert -colorspace RGB -resize ".$this->ImageSizeArray[$IVal]." ".$value['tmp_name']." ".$this->ImageToArray[$IVal].$value['name']);
										}else{
											exec("convert -resize ".$this->ImageSizeArray[$IVal]." ".$value['tmp_name']." ".$this->ImageToArray[$IVal].$value['name']);
										}
										
										if($this->ImageChangeTo[$IVal]!="") $key=$this->ImageChangeTo[$IVal];
										if($First){
											$this->SQLFields.="$key";
											$this->SQLData="'".$value['name']."'";
										}else{
											$this->SQLFields.=",$key";
											$this->SQLData.=",'".$value['name']."'";
										};
										$First=false;
									}
									if (file_exists($value['tmp_name'])) unlink($value['tmp_name']);
									
								}elseif(is_numeric($KImageKey)){
									//echo"<br>Send Small File To ".$this->KSmallToArray[$KImageKey]." and Insert FileName into".$this->KSmallDBArray[$KImageKey]." and Resize To ".$this->KImageSizeArray[$KImageKey]."<br>";
									//echo"<br>Send Big File To ".$this->KBigToArray[$KImageKey]." and Insert FileName into".$this->KBigDBArray[$KImageKey]." <br>";
									if($value['name']!="") $value['name']=$this->str_makerand(5).$value['name'];
									$value['name'] = ereg_replace("[^A-Za-z0-9]", "", $value['name'] );
										
									$SmallFileName="Small-".$value['name'];
									$BigFileName="Big-".$value['name'];
									copy($value['tmp_name'],$this->KBigToArray[$KImageKey].$BigFileName);
									if($value['tmp_name']!="") $ImgData=getimagesize($value['tmp_name']);
									if($ImgData['channels']==4){ //CMYK Image
										exec("convert -colorspace RGB -resize ".$this->KImageSizeArray[$KImageKey]." ".$value['tmp_name']." ".$this->KSmallToArray[$KImageKey].$SmallFileName);
									}else{
										exec("convert -resize ".$this->KImageSizeArray[$KImageKey]." ".$value['tmp_name']." ".$this->KSmallToArray[$KImageKey].$SmallFileName);
									}
									if (file_exists($value['tmp_name'])) unlink($value['tmp_name']);
									if($First){
										$this->SQLFields.=$this->KSmallDBArray[$KImageKey];
										$this->SQLData="'".$SmallFileName."'";
									}else{
										$this->SQLFields.=",".$this->KSmallDBArray[$KImageKey];
										$this->SQLData.=",'".$SmallFileName."'";
									}
									$this->SQLFields.=",".$this->KBigDBArray[$KImageKey];
									$this->SQLData.=",'".$BigFileName."'";
									$First=false;
								}
								//foreach($value as $key2 => $value2){
									//echo"key=$key2 -value=$value2<br>";
								//};
							};
						};
					}
					if(isset($this->ExtraFields)){
						foreach($this->ExtraFields as $key => $value){
							if($First){
								$this->SQLFields.="$key";
								if(is_string($value)){
									$value=mysql_real_escape_string(stripslashes($value));
								};
								$this->SQLData="'$value'";
							}else{
								$this->SQLFields.=",$key";
								if(is_string($value)){
									$value=mysql_real_escape_string(stripslashes($value));
								};
								$this->SQLData.=",'$value'";
							};
							$First=false;
						}
					}
					if(isset($this->FunctionArray)){
						foreach($this->FunctionArray as $key => $value){
							if($First){
								$this->SQLFields.="$key";
								if(is_string($value)){
									$value=mysql_real_escape_string(stripslashes($value));
								};
								$this->SQLData="$value";
							}else{
								$this->SQLFields.=",$key";
								if(is_string($value)){
									$value=mysql_real_escape_string(stripslashes($value));
								};
								$this->SQLData.=",$value";
							};
							$First=false;
						}
					}
					$this->FirstRun=false;
				}
				$this->SQL="$this->InsertType INTO $this->Table ($this->SQLFields,$this->AutoIncrement) VALUES ($this->SQLData,$this->AutoIncVal)";
				$result = $this->r->query($this->SQL);
				if(!$result){
					echo"error-$this->SQL"; 
				}
			}
			//print $this->SQL."<br>";
			return $this->Errors;
			
		}
	}
	*/
	/*
	class UpdateDatabase{
		var $SQL;
		var $SQLData;
		var $Table;
		var $ID;
		var $PostArray=array();
		var $FileArray=array();
		var $SkipArray=array();
		var $MoveArray=array();
		var $MoveToArray=array();
		var $MoveToChange=array();
		var $ValidArray=array();
		var $Errors;
		var $NoDupes=array();
		var $FirstRun=true;
		var $ExtraFields=array();
		var $FunctionArray=array();
		
		var $PrimaryKey="id";		
		var $ImageArray=array();
		var $ImageToArray=array();
		var $ImageSizeArray=array();
		var $ImageChangeTo=array();
		
		var $KImageArray=array();
		var $KSmallToArray=array();
		var $KBigToArray=array();
		var $KSmallDBArray=array();
		var $KBigDBArray=array();
		var $KImageSizeArray=array();
		var $DBFile="db-local.php";
		var $default_db="bubblelite2";
		var $m;
		var $r;
		var $links;
		
		function __construct(){
			//exit("00");
			$this->m = new ConnectDbase();
			$this->links = $this->m->Connect($this->DBFile);
			if($this->links->connect_error) {
				die("Connection failed: " . $this->links->connect_error);
			}
			$this->r = new ReturnRecord($this->links);
			
		}
		
		
		function Reset(){
			$this->FirstRun=true;
			$this->SQLFields="";
			$this->SQLData="";
			$this->ExtraFields=array();
			$this->FunctionArray=array();
			$this->ValidArray=array();
			$this->AutoIncVal=0;
		}
		
		function str_makerand ($length) 
		{ 
			$minlength=$length;
			$maxlength=$length;
			$charset = "abcdefghijklmnopqrstuvwxyz"; 
			$charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
			$charset .= "0123456789"; 
			if ($minlength > $maxlength) $length = mt_rand ($maxlength, $minlength); 
			else                         $length = mt_rand ($minlength, $maxlength); 
			for ($i=0; $i<$length; $i++) $key .= $charset[(mt_rand(0,(strlen($charset)-1)))]; 
			return $key; 
		} 
		function AddFunctions($FunctionArray){
			$this->FunctionArray=$FunctionArray;
		}
		
		function ChangeDBFile($db){
			$this->DBFile=$db;
			$this->m = new ConnectDbase();
			$this->links = $this->m->Connect($this->DBFile);
			$this->Set_Database($this->DBFile,$this->default_db);
		}
		
		function Set_Database($ser_nam,$dbname){
			$this->links[$ser_nam]->select_db($dbname);
		}}
		
		function AddNoDupe($NoDupe){
			$this->NoDupes=$NoDupe;
		}
		function AddExtraFields($FieldArray){
			$this->ExtraFields=array_merge($this->ExtraFields,$FieldArray);
		}
		function MoveFile($VarName,$MoveTo,$ChangeTo=""){
			$this->MoveArray[]=$VarName;
			$this->MoveToArray[]=$MoveTo;
			$this->MoveToChange[]=$ChangeTo;
		}
		function ResizeImage($VarName,$MoveTo,$Size,$ChangeTo=""){
			$this->ImageArray[]=$VarName;
			$this->ImageToArray[]=$MoveTo;
			$this->ImageSizeArray[]=$Size;
			$this->ImageChangeTo[]=$ChangeTo;
		}
		function KeepAndResizeImage($VarName,$DBSmall,$DBBig,$MoveToSmall,$MoveToBig,$Size){
			$this->KImageArray[]=$VarName;
			$this->KSmallDBArray[]=$DBSmall;
			$this->KBigDBArray[]=$DBBig;
			$this->KSmallToArray[]=$MoveToSmall;
			$this->KBigToArray[]=$MoveToBig;
			$this->KImageSizeArray[]=$Size;
		}
		
		function AddPosts($PArray,$FArray){
			$this->PostArray=$PArray;
			$this->FileArray=$FArray;
		}
		function AddDefaultCheckBoxes($CArray){
			foreach($CArray as $key => $value){
				if(!isset($this->PostArray[$value])){
					$this->PostArray[$value]="";
				}
			};
		}
		function AddSkip($SArray){
			$this->SkipArray=$SArray;
		}
		function ChangeAutoInc($newkey){
			$this->PrimaryKey=$newkey;
		}
		function AddTable($Table){
			$this->Table=$Table;
			$this->SetValid();
		}
		function AddID($id){
			$this->ID=$id;
		}
		function SetValid(){
			$m_arg = $this->r->rawQuery("SHOW COLUMNS FROM $this->Table");
			//$this->ValidArray = mysql_fetch_array(mysql_query($m_arg));
			while ($myrow = $this->r->Fetch_Array($m_arg)) {
				$this->ValidArray[]=$myrow[0];
			};
		}
		
		function IsDupes(){
			$RetVal=false;
			if(is_array($this->NoDupes)){
				foreach($this->NoDupes as $val){
					$sq2 = $this->r->rawQuery("SELECT id FROM $this->Table WHERE $val='".$this->PostArray[$val]."'");
					while ($myrow = $this->links->Fetch_Array($sq2)) {
						if($this->ID!=$myrow[0]){
							$RetVal=true;
							$this->Errors.="Duplicate field on $val ";
						};
					};
				};
			};
			return $RetVal;
		}
		
		function CheckDel($old){
			$new = $value['name'];
			if($old==$new){
			}
			else{
				foreach($this->FileArray as $key => $value){
					unlink("../../../Pdf/$old");
				}
			}
		}
		
		function DeletePhotos($Photos){
			if(is_array($Photos)){
				foreach($Photos as $field => $path){
					$sql= "SELECT $field FROM $this->Table WHERE $this->PrimaryKey='$this->ID'";
					$result = $this->r->rawQuery($sql,$this->links);
					while($myrow=$this->r->Fetch_Array($result)){
						if($myrow[0]!=""){
							if(file_exists($path.$myrow[0])){
								unlink($path.$myrow[0]);
							}
						}
					}
				}
			}
		}
				
		function DoStuff(){
			if(!$this->IsDupes()){
				if($this->FirstRun){
					$First=true;
					foreach($this->PostArray as $key => $value){
						//echo"key=$key -value=$value<br>";
						if((!in_array($key,$this->SkipArray))&&(in_array($key,$this->ValidArray))){
							if($First){
								if(is_string($value)){
									$value=$this->r->Escape(stripslashes($value));
								};
								$this->SQLData="$key='$value'";
							}else{
								if(is_string($value)){
									$value=$this->r->Escape(stripslashes($value));
								};
								$this->SQLData.=",$key='$value'";
							};
							$First=false;
						};
					};
					//echo"==============FILES===========";
					if(is_array($this->FileArray)){
						foreach($this->FileArray as $key => $value){
							$value['name']=eregi_replace(" ","_",$value['name']); //get rid of spaces
							if($value['name']){ // check to see if file actually sent
								//echo"key=$key----------------<br>";
								$MoveToKey=array_search($key,$this->MoveArray);
								$ImageKeys=array_keys($this->ImageArray,$key);
								$KImageKey=array_search($key,$this->KImageArray);
								//echo"--$MoveToKey--";
								if(is_numeric($MoveToKey)){
									//echo"<br>Send File To ".$this->MoveToArray[$MoveToKey]." <br>";
									if($this->MoveToChange[$MoveToKey]!="") $value['name']=$this->MoveToChange[$MoveToKey];
									if($First){
										$this->SQLData="$key='".$value['name']."'";
									}else{
										$this->SQLData.=",$key='".$value['name']."'";
									};	
									
									copy($value['tmp_name'],$this->MoveToArray[$MoveToKey].$value['name']);
									if($value['tmp_name']!="")	unlink($value['tmp_name']);
									$First=false;
								}
								if((is_array($ImageKeys))&&(count($ImageKeys)>0)){
									//echo"<br>Send File To ".$this->ImageToArray[$ImageKey]." and Resize To ".$this->ImageSizeArray[$ImageKey]."<br>";
									foreach($ImageKeys as $IKey =>$IVal){
										if($value['name']!=""){
											$value['name']=$this->str_makerand(5).$value['name'];
											$value['name'] = ereg_replace("[^A-Za-z0-9]", "", $value['name'] );
											if($value['tmp_name']!="") $ImgData=getimagesize($value['tmp_name']);
											if($ImgData['channels']==4){
												exec("convert -colorspace RGB -resize ".$this->ImageSizeArray[$IVal]." ".$value['tmp_name']." ".$this->ImageToArray[$IVal].$value['name']);
											}else{
												exec("convert -resize ".$this->ImageSizeArray[$IVal]." ".$value['tmp_name']." ".$this->ImageToArray[$IVal].$value['name']);
											}
											
											if($this->ImageChangeTo[$IVal]!="") $key=$this->ImageChangeTo[$IVal];
											if($First){
												$this->SQLData="$key='".$value['name']."'";
											}else{
												$this->SQLData.=",$key='".$value['name']."'";
											};
											$First=false;
										}
									}
									if($value['tmp_name']!="")	unlink($value['tmp_name']);
									
									
								}elseif(is_numeric($KImageKey)){
									if($value['name']!=""){
										$value['name']=$this->str_makerand(5).$value['name'];
										$value['name'] = ereg_replace("[^A-Za-z0-9]", "", $value['name'] );
										$SmallFileName="Small-".$value['name'];
										$BigFileName="Big-".$value['name'];
										copy($value['tmp_name'],$this->KBigToArray[$KImageKey].$BigFileName);
										if($value['tmp_name']!="") $ImgData=getimagesize($value['tmp_name']);
										if($ImgData['channels']==4){ //CMYK Image
											exec("convert -colorspace RGB -resize ".$this->KImageSizeArray[$KImageKey]." ".$value['tmp_name']." ".$this->KSmallToArray[$KImageKey].$SmallFileName);
										}else{
											exec("convert -resize ".$this->KImageSizeArray[$KImageKey]." ".$value['tmp_name']." ".$this->KSmallToArray[$KImageKey].$SmallFileName);
										}
										if($value['tmp_name']!="")	unlink($value['tmp_name']);
										if($First){
											$this->SQLData=$this->KSmallDBArray[$KImageKey]."='".$SmallFileName."'";
										}else{
											$this->SQLData.=",".$this->KSmallDBArray[$KImageKey]."='".$SmallFileName."'";
										}
										$this->SQLData.=",".$this->KBigDBArray[$KImageKey]."='".$BigFileName."'";
										$First=false;
									}
								}
							};
							//foreach($value as $key2 => $value2){
								//echo"key=$key2 -value=$value2<br>";
							//};
							
							
						};
					};
					// functions
					foreach($this->FunctionArray as $key => $value){
						if($First){
							if(is_string($value)){
								$value=$this->r->Escape(stripslashes($value));
							};
							$this->SQLData="$key=$value";
						}else{
							if(is_string($value)){
								$value=$this->r->Escape(stripslashes($value));
							};
							$this->SQLData.=",$key=$value";
						};
						$First=false;
					}
					// extra fields
					foreach($this->ExtraFields as $key => $value){
						if($First){
							if(is_string($value)){
								$value=$this->r->Escape(stripslashes($value));
							};
							$this->SQLData="$key='$value'";
						}else{
							if(is_string($value)){
								$value=$this->r->Escape(stripslashes($value));
							};
							$this->SQLData.=",$key='$value'";
						};
						$First=false;
					};
					$this->FirstRun=false;
				};
				//create and execute the query
				$this->SQL="UPDATE $this->Table SET $this->SQLData WHERE $this->PrimaryKey=$this->ID";
				$result = $this->r->rawQuery($this->SQL);
				if(!$result){
					echo"error-$this->SQL"; 
				}
				print $this->SQL;
			}
			return $this->Errors;
		}
	}
	*/
	/*
	*/
	class ConnectDbase{
		public $log=false;
		var $log_text="";
		var $links = array();
		var $connect=array();
		var $mysqli=false;
		var $Insert_Id=false;
		var $db_logins=array();
		var $dbss=array();
		var $current_dir="";
		var $default_db=array();
		var $def_db="";
		var $server_names=array();
		var $server_num=0;
		var $db_num=array(0=>0,1=>0,2=>0);
		var $def_db_num=array(0=>0,1=>0,2=>0);
		var $datab_name="";
		var $server_login=array();
		//var $db_name_serv=array(0=>0,1=>0,2=>0);
		var $db_name_def_num=array(0=>0,1=>0,2=>0);
		var $db_num_ser=array(0=>0,1=>0,2=>0);
				
		//function ConnectDbase(){
		function __construct(){	
			//$this->log->general("__construct");
			//$this->ser_nams=array("db-local.php","db-icwl.php","db-w-d.php");
			
		}
		
		public function Startup(){
			$this->DBSettings();
			$this->SetDB();
		}
		
		public function Db_Name_To_Num($DBName,$server_num=0){
			$db_key=array_search($DBName, $this->dbss[$this->server_names[$server_num]]);
			return $db_key;
		}
		
		public function Server_Name_To_Num($ServerName){
			$server_num=array_search($ServerName, $this->server_names);
			return $server_num;
		}
		public function Set_DB_Num($server_num=0,$db_num=0){
			$this->db_num[$server_num]=$db_num;
		}
		/*
		public function Set_Login_DBs(){
			//$this->log->general("Set_Login_DBs");
			$server_names=$this->server_names;
			//$server_num=$this->Find_Server_Number();
			//$db_num=$this->db_num;
			//$this->server_num=$server_num;
			$server_num=0;
			$db_num=$this->db_num[$server_num];
			$current_db_name=$this->dbss[$server_names[$server_num]][$db_num];
			$current_db_list=$this->dbss[$server_names[$server_num]];
			$this->db_logins[$server_names[$server_num]] = array('hostname'=>'cwl.strangled.net','usernamedb'=>'bubblelite','passworddb'=>'gae431%$d','dbName'=>$current_db_name,'dbNames'=>$current_db_list);
			$server_num=1;
			$db_num=$this->db_num[$server_num];
			$current_db_name=$this->dbss[$server_names[$server_num]][$db_num];
			$current_db_list=$this->dbss[$server_names[$server_num]];
			$this->db_logins[$server_names[$server_num]] = array('hostname'=>'localhost','usernamedb'=>'icwl0738_bubblel','passworddb'=>'dfa456%$d','dbName'=>$current_db_name,'dbNames'=>$current_db_list);
			$server_num=2;
			$db_num=$this->db_num[$server_num];
			$current_db_name=$this->dbss[$server_names[$server_num]][$db_num];
			$current_db_list=$this->dbss[$server_names[$server_num]];
			$this->db_logins[$server_names[$server_num]] = array('hostname'=>'ozychurch.com','usernamedb'=>'cwy0ek0e_bubblel','passworddb'=>'exa532%$d','dbName'=>$current_db_name,'dbNames'=>$current_db_list);
			
		}
		*/
		

		public function SetDB($db_name="",$db_num=false){
			try{
				//$this->log->general("SetDB");
				$db_name_num=0;
				$datab_name="";
				$server_names=$this->server_names;
				
				$db_def_num=$this->db_name_def_num[$server_num];
				$dbs_on_server=$this->dbss[$server_names[$server_num]];
				$result_key=array_search($db_name, $dbs_on_server);
				if($db_name!=""){
					foreach($dbs_on_server as $db_name_key=>$data_b_name){
						if($db_name==$data_b_name){
							$db_name_num=$db_name_key;
							$datab_name=$data_b_name;
						}
					}
				}elseif($result_key!=-1){
					$db_name_num=$result_key;
					$datab_name=$dbs_on_server[$result_key];//$data_b_name;
				}elseif((is_int($db_num))&&($db_num!=false)){
					if($db_num>0){
						$db_name_num=$db_num;
						$datab_name=$dbs_on_server[$db_name_num];
					}
				}else{
					
					$server_name=$server_names[$server_num];
					$dbs_on_server=$this->dbss[$server_name];
					$server_default_dbname=$dbs_on_server[$db_def_num];
					$datab_name=$this->dbss[$server_name][$db_def_num];
					$db_name_num=$db_def_num;
					
				}
				
				$db_collections=$this->dbss[$server_names[$server_num]];
				$datab_name=$db_collections[$db_def_num];
				$this->datab_name=$datab_name;
				$db_default_key=array_search($datab_name, $db_collections);
				//$this->default_db=array($this->dbss[$server_names[0]][0],$this->dbss[$server_names[1]][0],$this->dbss[$server_names[2]][0]);//array('bubblelite2','icwl0738_bubblelite2','cwy0ek0e_bubblelite2');
				/*
				foreach($db_collections as $key=>$val){

				}
				$this->default_db=array($db_collections[0],$db_collections[1],$this->dbss[$server_names[2]][0]);//array('bubblelite2','icwl0738_bubblelite2','cwy0ek0e_bubblelite2');
				$db_collections
				*/
				$this->def_db=$this->default_db[$server_num];
				$cdir=$this->Find_Root_Dir();
				//print($this->current_dir);

				$this->server_num=$server_num;
				$this->links[$server_names[$server_num]]=$this->Connect($server_names[$server_num]);
				//$db_name_def_num[$server_num]=$this->dbss[$server_names[$server_num]][$this->def_db_num[$server_num]];
				$db_name=$this->dbss[$server_names[$server_num]][$this->db_name_def_num[$server_num]];
				$this->Set_Database($server_names[$server_num],$db_name_serv[$server_num]);
				$this->ser_nams=$server_names;
			}catch(Exception $e){
				//$this->log->general(var_export($e));

			}
		}
		
		
		
		function Find_Root_Dir(){
			$this->log->general("Find_Root_Dir");
			$this->current_dir=pathinfo(__DIR__);
			$this->current_dir=$this->current_dir['dirname'];
			return $this->current_dir;
		}
		
		function Find_Server_Num($sname){
			$this->log->general("Find_Server_Num");
			$db_num=array_keys($this->server_names, $sname);
			return $db_num;
		}
		
		function Get_Database($ser_num,$db_num=0,$db_name=""){
			//$this->links[$ser_nam]->select_db($dbname);
			$this->log->general("Get_Database");
			if($db_name!=""){
				foreach($this->dbss[$server_names[$ser_num]] as $dnum=>$dname){
					if($dname==$db_name) $db_num=$dnum;
				}
			}
			
			$dbname=$this->dbss[$this->server_names[$ser_num]][$db_num];
			$ser_nam=$this->server_names[$ser_num];
			$rslt=$this->Set_Database($ser_nam,$dbname);
			return $rslt;
		}
		
		function Get_Other_Database($ser_num,$db_num=0,$db_name=""){
			//$this->links[$ser_nam]->select_db($dbname);
			$this->log->general("Get_Other_Database");
			$snames=$this->server_names;
			if($db_name!=""){
				$db_num=array_keys($this->dbss[$snames[$ser_num]], $db_name);
				$db_num_ser[$ser_num]=$db_num;
			}
			$this->db_num_ser[$ser_num]=$db_num;
			$this->links[$this->server_names[$ser_num]]->select_db($this->dbss[$snames[$ser_num]][$db_num]);
		}
		public function Set_Database($ser_nam,$dbname){
			$this->log->general("Set_Database");
			//$this->links[$ser_nam]->select_db($dbname);
			$this->links[$ser_nam]->select_db($dbname);
			return $this->links[$ser_nam];
		
		}
		
		function Select_Run_Database($ser_nam,$dbname){
			$this->log->general("Select_Run_Database");
			$links=$this->Set_Database($ser_nam,$dbname);	
			return $links;
		}
		
		function Load_All_Database(){
			$this->log->general("Load_All_Database");
			foreach($this->db_logins as $ser_nam=>$db_details){
				$this->links[$ser_nam]=$this->Connect($ser_nam);
				foreach($db_details['dbName'] as $db_key=>$db_val){
					$this->Set_Database($ser_nam,$db_val);
				}
			}
		}

		
		public function Set_Log(&$log){
			$this->log=$log;
			$this->log->general('Boot Success: m->');
				
		}
		

		
		public function Set_Login_DBs($server_database_number=false){
			//$this->log->general("Set_Login_DBs");
			$server_names=$this->server_names;
			if(!$server_num){
				$server_num=$this->Find_Server_Number();
			}else{
				$server_num=$server_database_number;
			}
			//$db_num=$this->db_num;
			//$this->server_num=$server_num;
			//-------------------------------------------------------------------------------------------------
			$server_num=0;
			$db_num=$this->db_num[$server_num];
			$current_db_name=$this->dbss[$server_names[$server_num]][$db_num];
			$current_db_list=$this->dbss[$server_names[$server_num]];
			$this->db_logins[$server_names[$server_num]] = array('hostname'=>'cwl.strangled.net','usernamedb'=>'bubblelite','passworddb'=>'DickSux5841','dbName'=>$current_db_name,'dbNames'=>$current_db_list);
			//-------------------------------------------------------------------------------------------------
			
			$server_num=1;
			$db_num=$this->db_num[$server_num];
			$current_db_name=$this->dbss[$server_names[$server_num]][$db_num];
			$current_db_list=$this->dbss[$server_names[$server_num]];
			$this->db_logins[$server_names[$server_num]] = array('hostname'=>'localhost','usernamedb'=>'icwl0738_bubblel','passworddb'=>'dfa456%$d','dbName'=>$current_db_name,'dbNames'=>$current_db_list);
			$server_num=2;
			$db_num=$this->db_num[$server_num];
			$current_db_name=$this->dbss[$server_names[$server_num]][$db_num];
			$current_db_list=$this->dbss[$server_names[$server_num]];
			$this->db_logins[$server_names[$server_num]] = array('hostname'=>'ozychurch.com','usernamedb'=>'cwy0ek0e_bubblel','passworddb'=>'exa532%$d','dbName'=>$current_db_name,'dbNames'=>$current_db_list);
			return $this->db_logins;
		}
		
		
		
		public function DBSettings($Database_Number=0){
			//$this->log->general("DBSettings");
			$server_names=array("db-local.php","db-icwl.php","db-w-d.php");
			$this->server_names=$server_names;
			
			$Database_Number=0;$srlst=$server_names[$Database_Number];
			$this->dbss[$server_names[$Database_Number]]=array("Default_Server_Number"=>$Database_Number,"Server_Names_Database"=>$srlst,"Default_Database"=>"bubblelite2","Database_list"=>array($srlst=>'bubblelite2',$srlst=>'takebookings',$srlst=>'partnerspro',$srlst=>'smsg'));
			$Database_Number=1;$srlst=$server_names[$Database_Number];
			$this->dbss[$server_names[$Database_Number]]=array("Default_Server_Number"=>$Database_Number,"Server_Names_Database"=>$srlst,"Default_Database"=>"icwl0738_bubblelite2","Database_list"=>array($srlst=>'icwl0738_bubblelite2',$srlst=>'icwl0738_takebookings',$srlst=>'icwl0738_partnerspro',$srlst=>'icwl0738_smsg'));
			$Database_Number=2;$srlst=$server_names[$Database_Number];
			$this->dbss[$server_names[$Database_Number]]=array("Default_Server_Number"=>$Database_Number,"Server_Names_Database"=>$srlst,"Default_Database"=>"cwy0ek0e_bubblelite2","Database_list"=>array($srlst=>'cwy0ek0e_bubblelite2',$srlst=>'cwy0ek0e_takebookings',$srlst=>'cwy0ek0e_partnerspro',$srlst=>'cwy0ek0e_smsg'));
			
			//,"Default_Server"=>$srlst,"Default_Server"=>$srlst,
			//$this->dbss[$server_names[1]]=array('icwl0738_bubblelite2','icwl0738_takebookings','icwl0738_partnerspro','icwl0738_smsg');
			//$this->dbss[$server_names[2]]=array('cwy0ek0e_bubblelite2','cwy0ek0e_takebookings','cwy0ek0e_partnerspro','cwy0ek0e_smsg');
			$output=array();
			$db_output=array();
			$return_array=$this->dbss;//[$server_names[$Database_Number]];
			
			foreach($return_array as $Server_Type=>$value_arrays){
				foreach($value_arrays as $Server_Details=>$Server_Values){
					if(isset($Server_Values['Database_list'])){
						$output[]=$value_arrays;
					}
				}
			}
			$return_array=$output;
			
			/*
			DBs=>$this->dbss[$server_names[$Database_Number]];
			$ret=array("Server"=>$server_names,"Databases_Each_Server"=>);
			*/
			//print_r($return_array);
			return ($return_array);
		}

		function Find_Server_Number(){
			//$this->log->general("Find_Server_Number");
			$server_names=$this->server_names;
			$this->current_dir=pathinfo(__DIR__);
			$current_directory=$this->current_dir['dirname'];
			//$current_selected_db=$this->datab_name;

			$server_names=$this->server_names;
			$server_num=0;
			$db_num=$this->db_num[$server_num];
			/*
			$current_db_name=$this->dbss[$server_names[$server_num]][$db_num];

			$Requested_DB_Name=$this->dbss[$server_names[$server_num]]
			*/
			switch($current_directory){
				
				case "/home2/icwl0738/public_html":
					$server_num=1;
					$current_selected_db_num=$this->db_num[$server_num];
					$current_selected_db=$this->dbss[$server_names[$server_num]][$current_selected_db_num];
					
					$server_name="db-icwl.php";
					$server_desc="WHM Reseller Server";
					$current_dir="/home2/icwl0738/public_html";
					$current_db_list=$this->dbss[$server_name];
					$server_login = array('hostname'=>'icwl.me','usernamedb'=>'icwl0738_bubblel','passworddb'=>'dfa456%$d','dbName'=>$current_selected_db,'dbNames'=>$current_db_list);
				break;
				case "/home1/cwy0ek0e/public_html":
					$server_num=2;
					$current_selected_db_num=$this->db_num[$server_num];
					$current_selected_db=$this->dbss[$server_names[$server_num]][$current_selected_db_num];
					$server_name="db-w-d.php";
					$server_desc="Cloud Server";
					$current_dir="/home1/cwy0ek0e/public_html";
					$current_db_list=$this->dbss[$server_name];
					$server_login = array('hostname'=>'ozychurch.com','usernamedb'=>'cwy0ek0e_bubblel','passworddb'=>'exa532%$d','dbName'=>$current_selected_db,'dbNames'=>$current_db_list);
				break;
				default:
				//-----------------------------------------------------------------------------------------------------------
				case "D:\xampp\htdocs":
					
					$server_num=0;
					/*
					$current_selected_db_num=$this->db_num[$server_num];
					$current_selected_db=$this->dbss[$server_names[$server_num]][$current_selected_db_num];
					*/
					$server_name="db-local.php";
					$server_desc="Home Xampp Server";
					$current_dir="D:/xampp/htdocs";
					$current_db_list=$this->dbss[$this->server_names[$server_num]];
					
					//$current_selected_db=$current_db_list[$db_num];
					//$server_login= array('hostname'=>'cwl.strangled.net','usernamedb'=>'bubblelite','passworddb'=>'DickSux5841','dbName'=>$current_selected_db,'dbNames'=>$current_db_list);
					$server_login= array('hostname'=>'cwl.strangled.net','usernamedb'=>'bubblelite','passworddb'=>'DickSux5841','dbName'=>'bubblelite2','dbNames'=>array());
					//$server_login= array('hostname'=>'cwl.strangled.net','usernamedb'=>'bubblelite','passworddb'=>'DickSux5841','dbName'=>$current_selected_db,'dbNames'=>$current_db_list);
					
					//print_r($server_login);
				break;
				//-----------------------------------------------------------------------------------------------------------
				
				/*
				default:
					$server_num=0;
					$this->db_logins[$server_names[$server_num]] = array('hostname'=>'cwl.strangled.net','usernamedb'=>'bubblelite','passworddb'=>'gae431%$d','dbName'=>$this->dbss[$server_names[$server_num]]);
				break;
				*/
			}
			//-----------------------------------------------------------------------------------------------------------
				
			/*
			$server_num;
			$current_selected_db_num=$this->db_num[$server_num];
			$current_selected_db=$this->dbss[$server_names[$server_num]];//[$current_selected_db_num];
			$current_db_list=$this->dbss[$this->server_names[$server_num]];
			$current_selected_db=$current_db_list[$db_num];
			print_r($this->dbss);
			//-----------------------------------------------------------------------------------------------------------
				*/
			//-----------------------------------------------------------------------------------------------------------
				
			$this->server_num=$server_num;
			$this->current_dir=$current_dir;
			$this->server_name=$server_name;
			$this->server_desc=$server_desc;
			$this->log_text.$this->current_dir;
			$this->def_db_num[$server_num]=0;
			$this->server_login=$server_login;
			$this->db_logins[$server_name]=$server_login;
			return $server_num;
			//-----------------------------------------------------------------------------------------------------------
				
		}
		
		
		
		function Connect($TArr="",&$log=false){
			/*
			$this->server_num=$server_num;
			$this->current_dir=$current_dir;
			$this->server_name=$server_name;
			$this->server_desc=$server_desc;
			$this->log_text.$this->current_dir;
			$this->def_db_num[$server_num]=0;
			$this->server_login=$server_login;
			$this->db_logins[$server_name]=$server_login;
			*/
			
			try{
				//-----------------------------------------------------------------------------------------------------------
				/*
				$this->Find_Server_Number();
				$TArr=$this->server_names[$this->server_num];
				$this->log->general("-Start-DB-",1);
				$server_names=$this->server_names;
				//print_r($server_names);
				$this->log->general("-Server_Names-".var_export($server_names,true),3);
				
				$this->Set_Login_DBs();
				
				$db_vars=$this->db_logins[$TArr];
				print_r($this->db_logins[$TArr]);
				*/
				//-----------------------------------------------------------------------------------------------------------
				
				/*
				$this->log->general("-db_vars-".var_export($db_vars)."-db_logins-".var_export($this->db_logins),3);
				$db_name=$this->dbss[$server_names[$this->db_ser_num]][$this->db_num_ser[$this->db_ser_num]];
				$this->log->general("-DB_Names-".var_export($db_login),3);
				$db_vars['db_Name']=$db_name;
				$this->log->general("-Server_Names-".var_export($db_vars),3);
				$db_login=$this->server_login;
				$this->log->general("-Connection  Codes-\n vars:=".var_export($db_login),3);
				*/
			}catch(﻿Exception $e){
				$this->log->general("-StartException-".var_export($e,true),3);	
						
			}
			
			try{	
				$db_ser_num=$this->Find_Server_Number();
				$TArr=$this->server_names[$db_ser_num];
				if($TArr==""){
					$TArr=$this->server_names[$db_ser_num];
				}
				if(isset($this->links[$TArr]))
				{
					return $this->links[$TArr];
				}
				else
				{
					//$this->links[$TArr] = new mysqli($this->db_logins[$TArr]['hostname'], $this->db_logins[$TArr]['usernamedb'], $this->db_logins[$TArr]['passworddb']);
					//if($log) $this->log=$log;
					/*
					$this->log->general("-Start-DB-");
					$server_names=$this->server_names;
					$db_vars=$this->db_logins[$TArr];
					$db_name=$this->dbss[$server_names[$db_ser_num]][$this->db_num_ser[$db_ser_num]];
					$db_vars['db_Name']=$db_name;
					$db_login=$this->server_login;
					*/
					/*
					$this->dbss[$server_names[0]]=
					*/
					
					try{
						$Server_Number=$this->Find_Server_Number();	
					//$this->log->general("-CDB-DBName-".var_export($db_login);
						//print $db_name;
						$db_login=$this->server_login;
						//$db_login=$db_vars;
						$this->log->general("-mysqli login-".var_export($db_login,true));
						$mysqli = new mysqli($db_login['hostname'], $db_login['usernamedb'], $db_login['passworddb'],$db_login['dbName'] );
					
						// Check connection
						if($mysqli->connect_error) {
							//$cerr="Connection failed: " . $this->mysqli->connect_error;
							//$this->log_text.=$cerr;
							$this->log->general("-Connection Error-".$mysqli->connect_error."\n vars:=".var_export($db_login),3);
						}else{
							$this->log->general("-Connection Success-",1);
							$this->log->general("Success... %s\n".var_export($mysqli,true),3); 
							$this->links[$TArr]=$mysqli;
						}
					}catch(﻿MySQLErrorException $e){
						$this->log->general("-MySQLErrorException-".var_export($e,true),3);	
						
					}
					
					
					
					/*
					$IId=$this->mysqli->Insert_Id;
					if(is_int($IId)){
						$this->Insert_Id=$IId;
					}
					$ser_num=$this->Find_Server_Number();
					$dbname=$this->dbss[$TArr][$this->db_num_ser[$ser_num]];
					$this->links[$TArr]=$this->Select_Run_Database($TArr,$dbname);
					*/
					return $this->links[$TArr];
				}
				
			}catch(﻿MySQLErrorException $e){
				$this->log->general("-MySQLErrorException-".var_export($e,true),3);	
				/*
				$this->log_text.=$mysqli->connect_error;	
				$this->log_text.=var_export($e);
				$this->log->general("-Connection failed-DBName-".$this->log_text);
				*/
			
			}
			
		}
		
	}
	
?>



