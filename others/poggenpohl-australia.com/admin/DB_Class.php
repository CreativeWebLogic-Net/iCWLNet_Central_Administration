<?php
	//ver 1.1
	class ReturnRecord{
		var $Table;
		var $TargetField="id";
		var $SearchVar;
		var $m;
		var $links;
		var $DBFile="database.php";
		
		function ReturnRecord(){
			$this->m = new ConnectDbase();
			$this->links = $this->m->Connect($this->DBFile);
		}
		
		function ChangeDBFile($db){
			$this->DBFile=$db;
			$this->m = new ConnectDbase();
			$this->links = $this->m->Connect($this->DBFile);
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
		function GetRecord(){
			$m_arg = "SELECT * FROM $this->Table where $this->TargetField='$this->SearchVar'";
			//print $m_arg;
			$result=mysql_query($m_arg,$this->links);
			if($result){
				$m_rows = mysql_fetch_array($result);
				if(is_array($m_rows)){
					foreach($m_rows as $key => $value){
						$m_rows[$key]=stripslashes($m_rows[$key]);
					};
				};
				return $m_rows;
			}else{
				print "ERROR: $m_arg";
			}
		}
		function GetMultiRecord(){
			$m_arg = "SELECT * FROM $this->Table where $this->TargetField='$this->SearchVar'";
			
			$result=mysql_query($m_arg,$this->links);
			if($result){
				while($m_rows = mysql_fetch_array($result));
				{
					if(is_array($m_rows)){
						foreach($m_rows as $key => $value){
							$m_rows[$count][$key]=stripslashes($m_rows[$key]);
						};
					};
					$count++;
				}
			}else{
				print "ERROR: $m_arg";
			}
			return $m_rows;
		}
		
		function rawQuery($query)
		{
			//print($query);
			$temp = mysql_query($query,$this->links);
			//$myrow = mysql_fetch_row($temp);
			return $temp;
		}
		
		function rawQueryX($query)
		{
			//print($query);
			$temp = @mysql_query($query,$this->links);
			//$myrow = mysql_fetch_row($temp);
			return $temp;
		}
		
		function otherRawQuery($query)
		{
			$sql = $query;
			$result = mysql_query($sql,$this->links);
			return $result;
		}
		
		function returnDBLink()
		{
			return $this->links;
		}
	}
	
	
	class BulkDBChange{
		var $Table;
		var $RecordArray=array();
		var $WhatToChange;
		var $WhatToChangeTo;
		var $Target="id";
		var $Errors;
		var $DBFile="database.php";
		var $m;
		var $links;
		
		function BulkDBChange(){
			$this->m = new ConnectDbase();
			$this->links = $this->m->Connect($this->DBFile);
		}
		
		function ChangeDBFile($db){
			$this->DBFile=$db;
			$this->m = new ConnectDbase();
			$this->links = $this->m->Connect($this->DBFile);
		}
		
		function AddTable($Table){
			$this->Table=$Table;
		}
		
		function AddIDArray($DFiles){
			$this->RecordArray=$DFiles;
		}
		function WhatToChange($var,$to){
			$this->WhatToChange=$var;
			$this->WhatToChangeTo=$to;
		}
		function ChangeTarget($var){
			$this->Target=$var;
			
		}
		
		function DoChange(){
			if(is_array($this->RecordArray)){
				foreach($this->RecordArray as $key => $value){
					$sql= "UPDATE $this->Table SET $this->WhatToChange='$this->WhatToChangeTo' WHERE $this->Target='$value'";
					$result = mysql_query($sql,$this->links);
				}
			}else{
				$this->Errors.="No Items Selected";
			}
			return $this->Errors;
		}
	}
	
	
	
	
	class DeleteFromDatabase{
		var $Table;
		var $RecordArray=array();
		var $WhatToDelete="id";
		var $Errors;
		var $DBFile="database.php";
		var $m;
		var $links;
		
		function DeleteFromDatabase(){
			$this->m = new ConnectDbase();
			$this->links = $this->m->Connect($this->DBFile);
		}
		
		function ChangeDBFile($db){
			$this->DBFile=$db;
			$this->m = new ConnectDbase();
			$this->links = $this->m->Connect($this->DBFile);
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
		
		function DoDelete(){
			if(is_array($this->RecordArray)){
				foreach($this->RecordArray as $key => $value){
					$sql= "DELETE FROM $this->Table where $this->WhatToDelete='$value'";
					$result = mysql_query($sql,$this->links);
				}
			}else{
				$this->Errors.="No Items Selected";
			}
			return $this->Errors;
		}
	}
	
	
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
		var $DBFile="database.php";
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
		var $links;
		
		function AddToDatabase(){
			$this->m = new ConnectDbase();
			$this->links = $this->m->Connect($this->DBFile);
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
		
		function ChangeInsertType($to){
			$this->InsertType=$to;
		}
		
		function ChangeDBFile($db){
			$this->DBFile=$db;
			$this->m = new ConnectDbase();
			$this->links = $this->m->Connect($this->DBFile);
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
				$SQL="SHOW TABLE STATUS LIKE '$this->Table'";
				$sq2 = mysql_query($SQL,$this->links);
				$result=mysql_fetch_assoc($sq2);
				$this->AutoIncVal=$result['Auto_increment'];
			};
		}
		function IsDupes(){
			$RetVal=false;
			if(is_array($this->NoDupes)){
				foreach($this->NoDupes as $val){
					$sq2 = mysql_query("SELECT id FROM $this->Table WHERE $val='".$this->PostArray[$val]."'",$this->links);
					while ($myrow = mysql_fetch_row($sq2)) {
						$RetVal=true;
						$this->Errors.="Duplicate field on $val ";
					};
				};
			};
			return $RetVal;
		}
		
		
		function SetValid(){
			$m_arg = mysql_query("SHOW COLUMNS FROM $this->Table",$this->links);
			//$this->ValidArray = mysql_fetch_array(mysql_query($m_arg));
			while ($myrow = mysql_fetch_row($m_arg)) {
				$this->ValidArray[]=$myrow[0];
			};
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
									$value=mysql_escape_string(stripslashes($value));
								};
								$this->SQLData="'$value'";
							}else{
								$this->SQLFields.=",$key";
								if(is_string($value)){
									$value=mysql_escape_string(stripslashes($value));
								};
								$this->SQLData.=",'$value'";
							};
							$First=false;
						};
					};
					//echo"==============FILES===========";
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
								if($value['tmp_name']!="")	unlink($value['tmp_name']);
								$First=false;
							}elseif(is_array($ImageKeys)){
								//echo"<br>Send File To ".$this->ImageToArray[$ImageKey]." and Resize To ".$this->ImageSizeArray[$ImageKey]."<br>";
								foreach($ImageKeys as $IKey =>$IVal){
									//$value['name']=$this->str_makerand(5).$value['name'];
									if($value['name']!="") $value['name']=$this->str_makerand(5).$value['name'].".jpg";
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
								if($value['tmp_name']!="")	unlink($value['tmp_name']);
								
							}elseif(is_numeric($KImageKey)){
								//echo"<br>Send Small File To ".$this->KSmallToArray[$KImageKey]." and Insert FileName into".$this->KSmallDBArray[$KImageKey]." and Resize To ".$this->KImageSizeArray[$KImageKey]."<br>";
								//echo"<br>Send Big File To ".$this->KBigToArray[$KImageKey]." and Insert FileName into".$this->KBigDBArray[$KImageKey]." <br>";
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
					foreach($this->ExtraFields as $key => $value){
						if($First){
							$this->SQLFields.="$key";
							if(is_string($value)){
								$value=mysql_escape_string(stripslashes($value));
							};
							$this->SQLData="'$value'";
						}else{
							$this->SQLFields.=",$key";
							if(is_string($value)){
								$value=mysql_escape_string(stripslashes($value));
							};
							$this->SQLData.=",'$value'";
						};
						$First=false;
					}
					
					foreach($this->FunctionArray as $key => $value){
						if($First){
							$this->SQLFields.="$key";
							if(is_string($value)){
								$value=mysql_escape_string(stripslashes($value));
							};
							$this->SQLData="$value";
						}else{
							$this->SQLFields.=",$key";
							if(is_string($value)){
								$value=mysql_escape_string(stripslashes($value));
							};
							$this->SQLData.=",$value";
						};
						$First=false;
					}
					$this->FirstRun=false;
				}
				$this->SQL="$this->InsertType INTO $this->Table ($this->SQLFields,$this->AutoIncrement) VALUES ($this->SQLData,$this->AutoIncVal)";
				$result = mysql_query($this->SQL,$this->links);
				if(!$result){
					echo"error-$this->SQL"; 
				}
			}
			//print $this->SQL."<br>";
			return $this->Errors;
			
		}
	}
	
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
		var $DBFile="database.php";
		var $m;
		var $links;
		
		function UpdateDatabase(){
			$this->m = new ConnectDbase();
			$this->links = $this->m->Connect($this->DBFile);
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
		
		function ChangeDBFile($db){
			$this->DBFile=$db;
			$this->m = new ConnectDbase();
			$this->links = $this->m->Connect($this->DBFile);
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
			$m_arg = mysql_query("SHOW COLUMNS FROM $this->Table",$this->links);
			//$this->ValidArray = mysql_fetch_array(mysql_query($m_arg));
			while ($myrow = mysql_fetch_row($m_arg)) {
				$this->ValidArray[]=$myrow[0];
			};
		}
		
		function IsDupes(){
			$RetVal=false;
			if(is_array($this->NoDupes)){
				foreach($this->NoDupes as $val){
					$sq2 = mysql_query("SELECT id FROM $this->Table WHERE $val='".$this->PostArray[$val]."'",$this->links);
					while ($myrow = mysql_fetch_row($sq2)) {
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
				
		function DoStuff(){
			if(!$this->IsDupes()){
				if($this->FirstRun){
					$First=true;
					foreach($this->PostArray as $key => $value){
						//echo"key=$key -value=$value<br>";
						if((!in_array($key,$this->SkipArray))&&(in_array($key,$this->ValidArray))){
							if($First){
								if(is_string($value)){
									$value=mysql_escape_string(stripslashes($value));
								};
								$this->SQLData="$key='$value'";
							}else{
								if(is_string($value)){
									$value=mysql_escape_string(stripslashes($value));
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
								$ImageKey=array_search($key,$this->ImageArray);
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
								}elseif(is_numeric($ImageKey)){
									//echo"<br>Send File To ".$this->ImageToArray[$ImageKey]." and Resize To ".$this->ImageSizeArray[$ImageKey]."<br>";
									
									$value['name']="Small-".$value['name'];
									if($value['tmp_name']!="") $ImgData=getimagesize($value['tmp_name']);
									if($ImgData['channels']==4){ //CMYK Image
										exec("convert -colorspace RGB -resize ".$this->ImageSizeArray[$ImageKey]." ".$value['tmp_name']." ".$this->ImageToArray[$ImageKey].$value['name']);
									}else{
										exec("convert -resize ".$this->ImageSizeArray[$ImageKey]." ".$value['tmp_name']." ".$this->ImageToArray[$ImageKey].$value['name']);
									}
									if($value['tmp_name']!="")	unlink($value['tmp_name']);
									if($this->ImageChangeTo[$ImageKey]!="") $key=$this->ImageChangeTo[$ImageKey];
									if($First){
										$this->SQLData="$key='".$value['name']."'";
									}else{
										$this->SQLData.=",$key='".$value['name']."'";
									};
									$First=false;
								}elseif(is_numeric($KImageKey)){
									//echo"<br>Send Small File To ".$this->KSmallToArray[$KImageKey]." and Insert FileName into".$this->KSmallDBArray[$KImageKey]." and Resize To ".$this->KImageSizeArray[$KImageKey]."<br>";
									//echo"<br>Send Big File To ".$this->KBigToArray[$KImageKey]." and Insert FileName into".$this->KBigDBArray[$KImageKey]." <br>";
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
							};
							//foreach($value as $key2 => $value2){
								//echo"key=$key2 -value=$value2<br>";
							//};
							
							
						};
					};
					// extra fields
					foreach($this->ExtraFields as $key => $value){
						if($First){
							if(is_string($value)){
								$value=mysql_escape_string(stripslashes($value));
							};
							$this->SQLData="$key='$value'";
						}else{
							if(is_string($value)){
								$value=mysql_escape_string(stripslashes($value));
							};
							$this->SQLData.=",$key='$value'";
						};
						$First=false;
					};
					$this->FirstRun=false;
				};
				//create and execute the query
				$this->SQL="UPDATE $this->Table SET $this->SQLData WHERE $this->PrimaryKey=$this->ID";
				$result = mysql_query($this->SQL,$this->links);
				if(!$result){
					echo"error-$this->SQL"; 
				}
				//print $this->SQL;
			}
			return $this->Errors;
		}
	}
	
	class ConnectDbase{
		var $links = array();
				
		function Connect($TArr){
			include("database.php");
			if(isset($this->links[$TArr]))
			{
				return $this->links[$TArr];
			}
			else
			{
				$this->links[$TArr] = MYSQL_CONNECT($connect[$TArr]['hostname'], $connect[$TArr]['usernamedb'], $connect[$TArr]['passworddb']);
				mysql_select_db($connect[$TArr]['dbName'],$this->links[$TArr]);
				return $this->links[$TArr];
			};
		}
	}
	
?>