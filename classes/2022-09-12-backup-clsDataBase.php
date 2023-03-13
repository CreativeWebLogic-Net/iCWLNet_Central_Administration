<?php
	//-----------------------------------------------------------------------------------------------------------
	
	class clsDatabaseInterface{
		var $SQL;
		var $Table;
		var $TargetField="id";
		var $SearchVar;
		var $NewSearchVar=array();
		public $m;
		var $vs;
		var $links;
		var $result;
		var $DBFile="db-local.php";
		var $default_db="bubblelite2";
		public $log="";
		var $log_text="";
	
	
		
		
		function __construct(){
			
		}
		
		public function Set_Log(&$log){
			$this->log=$log;
			$this->log->general('M Log Success:',1);
				
		}
		
		public function Set_Vs(&$vs=false){
			$this->vs=$vs;
			//$this->log->general('Vs Success: ".var_export($this->vs,true),1);
				
		}
		
		public function CreateDB(){
			
			try{
				
				$this->log->general("CreateDB Start Success: ",1);
					
				$this->m = new clsDatabaseConnect();
				$this->log->general("CreateDB M Success: ",1);
				$this->m->Set_Log($this->log);
				//$this->m->Startup();
				//echo"3-----------------------------------------------------------------------------";
				//$this->links = $this->m->Connect($this->DBFile);
				$this->links = $this->m->Connect();
				//echo"4-----------------------------------------------------------------------------";
				if(isset($this->links->connect_error)) {
					$this->log->general("Connection failed: " . $this->links->connect_error,3);
				}else{
					$this->log->general("m->Connection Success: ".var_export($this->links,true),1);
				}
				//$this->m->Set_Log("clsDBCon Success: ",1);
				//echo"5-----------------------------------------------------------------------------";
			}catch(MySQLErrorException $e){
				$this->log->general("MySQL Connection Error: ".var_export($e,true),3);
			}
			
		}
		
		function Reset(){
			$this->Table="";
			$this->TargetField="id";
			$this->SearchVar="";
			$this->NewSearchVar=array();
		}
		
		function ChangeDBFile($db){
			$this->DBFile=$db;
			$this->m = new clsDatabaseConnect();
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
			//print "ll";
			if(!$this->links) $this->CreateDB();
			$m_arg = "SELECT * FROM $this->Table where $this->TargetField='$this->SearchVar'";
			
			foreach($this->NewSearchVar as $key=>$val){
				$m_arg .= " AND $key='$val'";
			}
			
			//print("d11d");
			$this->SQL=$m_arg;
			//$result=$this->rawQuery($m_arg);
			$this->result = $this->rawQuery($this->SQL);
			if($this->result){
				$m_rows = $this->Fetch_Assoc();
				//print_r($m_rows);
				if(is_array($m_rows)){
					foreach($m_rows as $key => $value){
						$m_rows[$key]=stripslashes($m_rows[$key]);
					};
				};
				//print("ddd");
				return $m_rows;
			}else{
				$this->log->general("Multi MySQL Error->".var_export($this->result,true)." ".$query,3);
				//print "ERROR: $m_arg";
			}
		}
		function GetMultiRecord(){
			if(!$this->links) $this->CreateDB();
			$m_arg = "SELECT * FROM $this->Table where $this->TargetField='$this->SearchVar'";
			
			$this->result=$this->rawQuery($m_arg);
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
			try{
				$this->log->general("Start Num Rows->",3);
				$num_rows=$this->result->num_rows;
				$this->log->general("Row Count->".$num_rows,3);
				$this->log->general("\n",3);
				return $num_rows;
			}catch(Exception $e){
				$this->log->general("MySQL NumRows Exception->".var_export($e,true)." ".$this->SQL,3);
				return 0;
			}
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
	
	//-----------------------------------------------------------------------------------------------------------
	
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
	
	//-----------------------------------------------------------------------------------------------------------
	
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
	
	//-----------------------------------------------------------------------------------------------------------
	
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
	
	//-----------------------------------------------------------------------------------------------------------
	
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
		}
		
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
	
	//-----------------------------------------------------------------------------------------------------------
	class clsDatabaseConnect{
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
		var $all_databases_array=array();
		var $server_tags=array();
		var $all_db_login_data=array();
		var $local_db=array();
		var $host_name="localhost";
		//var $db_name_serv=array(0=>0,1=>0,2=>0);
		var $db_name_def_num=array(0=>0,1=>0,2=>0);
		var $db_num_ser=array(0=>0,1=>0,2=>0);
		var $current_server_tag="";
		//-----------------------------------------------------------------------------------------------------------
	
		//function ConnectDbase(){
		function __construct(){	
			$this->Initialise_Current_Server();
		}
		
		//-----------------------------------------------------------------------------------------------------------
		
		
		public function Set_Log(&$log){
			$this->log=$log;
			$this->log->general('Set Log Boot Success: $r->',1);
				
		}
		
		//-----------------------------------------------------------------------------------------------------------
		private function Initialise_Current_Server(){
			
			$this->current_dir=pathinfo(__DIR__);
			$current_directory=$this->current_dir['dirname'];
			//$DB_Login_Data=$this->all_db_login_data;
			$this->host_name=gethostname();
			$DB=array();
			switch($current_directory){
				//-----------------------------------------------------------------------------------------------------------
				
				case 'D:\xampp\htdocs\bcms':
					$DB['server_tag']="db-local.php";
					$DB['server_desc']="Home Xampp Server";
					$DB['current_dir']="D:/xampp/htdocs";
					$DB['server_number']=0;
					$DB['hostname']="cwl.strangled.net";
					$DB['usernamedb']='bubblelite';
					$DB['passworddb']='DickSux5841';
					$DB['dbName']="icwl0738_bubblelite2";
					$DB['dbNames']=array("icwl0738_bubblelite2","takebookings","partnerspro","smsg");
					$server_login["db-local.php"]=array('server_tag'=>$DB['server_tag'],'usernamedb'=>'bubblelite','passworddb'=>'DickSux5841','server_desc'=>$DB['server_desc'],'current_dir'=>$DB['current_dir'],'server_number'=>$DB['server_number'],'hostname'=>$DB['hostname'],'usernamedb'=>$DB['usernamedb'],'passworddb'=>$DB['passworddb'],'dbName'=>$DB['dbName'],'dbNames'=>$DB['dbNames']);
					//print_r($server_login);
				break;
					//-----------------------------------------------------------------------------------------------------------
				case '/home1/cwy0ek0e/public_html/bcms':
					$DB['server_tag']="db-w-d.php";
					$DB['server_desc']="Cloud Server";
					$DB['current_dir']="/home1/cwy0ek0e/public_html";
					$DB['server_number']=1;
					$DB['hostname']="localhost";
					$DB['usernamedb']='cwy0ek0e_bubblel';
					$DB['passworddb']='DickSux5841';
					$DB['dbName']='cwy0ek0e_bubblelite2';
					$DB['dbNames']=array('cwy0ek0e_bubblelite2','cwy0ek0e_takebookings','cwy0ek0e_partnerspro','cwy0ek0e_smsg');
					$server_login["db-w-d.php"]=array('server_tag'=>$DB['server_tag'],'usernamedb'=>'cwy0ek0e_bubblel','passworddb'=>'exa532%$d','server_desc'=>$DB['server_desc'],'current_dir'=>$DB['current_dir'],'server_number'=>$DB['server_number'],'hostname'=>$DB['hostname'],'usernamedb'=>$DB['usernamedb'],'passworddb'=>$DB['passworddb'],'dbName'=>$DB['dbName'],'dbNames'=>$DB['dbNames']);
					//print_r($server_login);
				break;
				//-----------------------------------------------------------------------------------------------------------
				case '/home2/icwl0738/public_html/bcms':
					$DB['server_tag']="db-icwl.php";
					$DB['server_desc']="WHM Reseller Server";
					$DB['current_dir']="/home2/icwl0738/public_html";
					$DB['server_number']=2;
					$DB['hostname']="localhost";
					$DB['usernamedb']='icwl0738_bubblel';
					$DB['passworddb']='dfa456%$d';
					$DB['dbName']="icwl0738_bubblelite2";
					$DB['dbNames']=array('icwl0738_bubblelite2','icwl0738_takebookings','icwl0738_partnerspro','icwl0738_smsg');
					$server_login["db-icwl.php"]=array('server_tag'=>$DB['server_tag'],'usernamedb'=>'icwl0738_bubblel','passworddb'=>'DickSux5841','server_desc'=>$DB['server_desc'],'current_dir'=>$DB['current_dir'],'server_number'=>$DB['server_number'],'hostname'=>$DB['hostname'],'usernamedb'=>$DB['usernamedb'],'passworddb'=>$DB['passworddb'],'dbName'=>$DB['dbName'],'dbNames'=>$DB['dbNames']);
					//print_r($server_login);
				break;
				
				
				//-----------------------------------------------------------------------------------------------------------
				case '/home2/wallbk0ag3oq/public_html/bcms':
					$DB['server_tag']="wp-cwl.php";
					$DB['server_desc']="Wordpress Server";
					$DB['current_dir']="/home2/wallbk0ag3oq/public_html";
					$DB['server_number']=3;
					$DB['hostname']="creativeweblogic.net";
					$DB['usernamedb']="admin";
					$DB['passworddb']="DickSux5841";
					$DB['dbName']="wpdb";
					$DB['dbNames']=array();
					$server_login["wp-cwl.php"]=array('server_tag'=>$DB['server_tag'],'server_desc'=>$DB['server_desc'],'current_dir'=>$DB['current_dir'],'server_number'=>$DB['server_number'],'hostname'=>$DB['hostname'],'usernamedb'=>$DB['usernamedb'],'passworddb'=>$DB['passworddb'],'dbName'=>$DB['dbName'],'dbNames'=>$DB['dbNames']);
					//print_r($server_login);
				break;
				
				//-----------------------------------------------------------------------------------------------------------
				
				case '/var/www/html/bcms':	
					
					//switch($this->host_name){
						
						//case "ozhost.live":
							$DB['server_tag']="db-linode.php";
							$DB['server_desc']="Private VPS";
							$DB['current_dir']="/var/www/html";
							$DB['server_number']=4;
							$DB['hostname']="localhost";
							$DB['usernamedb']="root";
							$DB['passworddb']="DickSux5841";
							$DB['dbName']="bubblelite2";
							$DB['dbNames']=array('bubblelite2','takebookings','partnerspro','smsg');
							$server_login["db-linode.php"]=array('server_tag'=>$DB['server_tag'],'server_desc'=>$DB['server_desc'],'current_dir'=>$DB['current_dir'],'server_number'=>$DB['server_number'],'hostname'=>$DB['hostname'],'usernamedb'=>$DB['usernamedb'],'passworddb'=>$DB['passworddb'],'dbName'=>$DB['dbName'],'dbNames'=>$DB['dbNames']);
							//print_r($server_login);
						break;
						//*/
					//}
						/*
						//-----------------------------------------------------------------------------------------------------------
						case '/var/www/html/bcms':
							$DB['server_tag']="db-do.php";
							$DB['server_desc']="VPS Cloud Server";
							$DB['current_dir']="/var/www/html";
							$DB['server_number']=5;
							$DB['hostname']="localhost";
							$DB['usernamedb']="danielruul";
							$DB['passworddb']="DickSux5841";
							$DB['dbName']="bubblelite2";
							$DB['dbNames']=array('bubblelite2','takebookings','partnerspro','smsg');
							$server_login["db-do.php"]=array('server_tag'=>$DB['server_tag'],'server_desc'=>$DB['server_desc'],'current_dir'=>$DB['current_dir'],'server_number'=>$DB['server_number'],'hostname'=>$DB['hostname'],'usernamedb'=>$DB['usernamedb'],'passworddb'=>$DB['passworddb'],'dbName'=>$DB['dbName'],'dbNames'=>$DB['dbNames']);
							//print_r($server_login);
						break;
						*/
						
						//-----------------------------------------------------------------------------------------------------------
						/*
						default:
							print($this->host_name."<br>");
							echo"-----------------------error selecting host server-------------------------------------";
						break;
							*/
					//}
				}

				
				case '/home/relozdev/public_html':
					$DB['server_tag']="db-iserver.php";
					$DB['server_desc']="Inter Server Shared";
					$DB['current_dir']="/var/www/html";
					$DB['server_number']=5;
					$DB['hostname']="127.0.0.1";
					$DB['usernamedb']="relozdev_danielruul";
					$DB['passworddb']="DickSux5841";
					$DB['dbName']="relozdev_bubblelite2";
					$DB['dbNames']=array('relozdev_bubblelite2','relozdev_takebookings','relozdev_partnerspro','relozdev_smsg');
					$server_login["db-do.php"]=array('server_tag'=>$DB['server_tag'],'server_desc'=>$DB['server_desc'],'current_dir'=>$DB['current_dir'],'server_number'=>$DB['server_number'],'hostname'=>$DB['hostname'],'usernamedb'=>$DB['usernamedb'],'passworddb'=>$DB['passworddb'],'dbName'=>$DB['dbName'],'dbNames'=>$DB['dbNames']);
					//print_r($server_login);
				break;
				
				//-----------------------------------------------------------------------------------------------------------
				case "/home/audevorg/domains/audev.org/public_html/bcms":
					$DB['server_tag']="db-goog.php";
					$DB['server_desc']="Shared Cheap Server";
					$DB['current_dir']="﻿﻿﻿/home/audevorg/domains/audev.org/public_html/bcms";
					$DB['server_number']=7;
					$DB['hostname']="localhost";
					$DB['usernamedb']="audevorg_danielruul";
					$DB['passworddb']="DickSux5841";
					$DB['dbName']="audevorg_bubblecmslite2";
					$DB['dbNames']=array('audevorg_bubblecmslite2','audevorg_bubblecmslite2','audevorg_bubblecmslite2','audevorg_bubblecmslite2');
					$server_login["db-goog.php"]=array('server_tag'=>$DB['server_tag'],'server_desc'=>$DB['server_desc'],'current_dir'=>$DB['current_dir'],'server_number'=>$DB['server_number'],'hostname'=>$DB['hostname'],'usernamedb'=>$DB['usernamedb'],'passworddb'=>$DB['passworddb'],'dbName'=>$DB['dbName'],'dbNames'=>$DB['dbNames']);
					//print_r($server_login);
					
				break;
				
				default:
					print($current_directory."<br>");
					echo"-----------------------error selecting server-------------------------------------";
				break;
				
				//-----------------------------------------------------------------------------------------------------------
			}
			//$this->log->general('Server Find:->'.var_export($server_login,true),1);
			//print_r($server_login);
			
			//-----------------------------------------------------------------------------------------------------------
			//$this->server_num=$server_num;
			if(count($DB)>0){
				$this->current_server_tag=$DB['server_tag'];
				$this->current_dir=$DB['current_dir'];
				//$this->server_name=$server_name;
				$this->server_desc=$DB['server_desc'];
				$this->log_text.$this->current_dir;
				//$this->def_db_num[$server_num]=0;
				$this->server_login=$server_login;
				//$this->db_logins[$server_name]=$server_login;
			}
			//-----------------------------------------------------------------------------------------------------------	
			
		}
		
		
		public function Connect($TArr=""){
			
			try{	
				 //$db_ser_num=$this->Initialise_Current_Server();
				//$TArr=array();
				//if($TArr==""){
				//}
				if(isset($this->links[$TArr]))
				{
					return $this->links[$TArr];
				}
				else
				{
					if($TArr==""){
						$TArr=$this->current_server_tag;
					}
					
					try{
						//$Server_Number=$this->Initialise_Current_Server();	
					//print $db_name;
						//$this->log->general("-mysqli login-".var_export($this->server_login,true)."-".$TArr."|");
						$db_login=$this->server_login[$TArr];
						//$db_login=$db_vars;
						//print_r($db_login);
						////if(!isset($db_login['hostname'])) $db_login['hostname']="localhost";
						//$db_login['usernamedb']="icwl0738_bubblel";
						$mysqli = new mysqli($db_login['hostname'], $db_login['usernamedb'], $db_login['passworddb'],$db_login['dbName'] );
					
						// Check connection
						if($mysqli->connect_error) {
							//$cerr="Connection failed: " . $this->mysqli->connect_error;
							//$this->log_text.=$cerr;
							$this->log->general("-Connection Error-".$mysqli->connect_error."\n vars:=".var_export($db_login),3);
						}else{
							$this->log->general("-Connection Success->".$TArr,1);
							$this->log->general("\n",1);
							//$this->log->general("Success... %s\n".var_export($mysqli,true),3); 
							$this->links[$TArr]=$mysqli;
						}
					}catch(﻿MySQLErrorException $e){
						$this->log->general("-MySQLErrorException-".var_export($e,true),3);	
						
					}
					$this->log->general("-Return Connection Success->".$TArr,1);
					return $this->links[$TArr];
				}	
			}catch(﻿Exception $e){
				$this->log->general("-Exception-".var_export($e,true),3);
			}
			
		}
		
		
	}
?>