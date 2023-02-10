<?php
/*
Class log { 
   // 
   const USER_ERROR_DIR = 'logs/UserErrorLog.txt'; 
   const GENERAL_ERROR_DIR = 'logs/ErrorLog.txt';
   //var LogText=array();
   /* 
    User Errors... 
   */ 
   /*
    private function Add_To_List($msg){
        $this->LogText[]=$msg."/n";
    }
    
    private function Fill_Log_Array($msg,$error_code=1,$memberID=0,$member_name=""){
        $Current_Page=$_SERVER['PHP_SELF'];
        $Current_Server=$_SERVER['SERVER_NAME'];
        $Remote_IP=$_SERVER['REMOTE_ADDR'];
        $Remote_Host=$_SERVER['REMOTE_HOST'];
        $Date = date("d.m.Y h:i:s");
        if($memberID>0){
            $error_type="User";
        }else{
            $error_type="General";
        }
            $value_array["Error_Type"]=$error_type;
        $Return_Array=array("Message"=>$msg,"Error_Code"=>$error_code,"Error_Type"=>$error_type,"MemberID"=>$memberID,"Member_Name"=>$member_name,"Current_Page"=>$Current_Page,"Current_Server"=>$Current_Server,"Remote_IP"=>$Remote_IP,"Remote_Host"=>$Remote_Host,"$Date"=>$Date);
        return $Return_Array;
    }
    
    private function Print_List(){
        $output_list=array();
        $error_type="General";
        $add_to_output=false;
        $exc_general_output_array=array();
        $exc_user_output_array=array();
        $warn_general_output_array=array();
        $warn_user_output_array=array();
        foreach($this->LogText as $item_key=>$value_array){
            if($value_array["Error_Code"]>=3){ // if warning or exception
                if($value_array["Error_Type"]=="User"){
                    $exc_user_output_array[]=$value_array;
                }else{
                    $exc_general_output_array[]=$value_array;
                }
                $output_list[]=$value_array;
            }else{
                if($value_array["Error_Type"]=="User"){
                    $warn_user_output_array[]=$value_array;
                }else{
                    $warn_general_output_array[]=$value_array;
                }
            }
        }
        $exc_user_error_text=var_export($exc_user_output_array,true);
        $exc_general_error_text=var_export($exc_general_output_array,true);
        $warn_user_error_text=var_export($warn_user_output_array,true);
        $warn_general_error_text=var_export($warn_general_output_array,true);
        error_log($exc_user_error_text,3, self::USER_ERROR_DIR);
        error_log($exc_general_error_text,3, self::GENERAL_ERROR_DIR); 
        error_log($warn_user_error_text,1, self::USER_ERROR_DIR);
        error_log($warn_general_error_text,1, self::GENERAL_ERROR_DIR); 
        if(count($output_list)>0){
            $output_text=var_export($output_list,true);
            echo"<pre>";
            print_r($output_text);
            echo"</pre>"; 
        }
        
    }
    
   public function user($msg,$error_code=1,$memberID=0,$member_name="") 
     { 
        $log_array=$this->Fill_Log_Array($msg,$error_code,$memberID,$member_name)
        $this->Add_To_List($log_array);
     } 
      
     public function general($msg,$error_code=1) 
     { 
        $log_array=$this->Fill_Log_Array($msg,$error_code)
        $this->Add_To_List($log_array);
        
     } 
     */
   /*
    public function user($msg,$error_code=1,$memberID=0,$member_name="") 
     { /*
        $date = date("d.m.Y h:i:s");
         $log = "Page:  ".$Current_Page."    |Error Code:  ".$error_code."  |Date:  ".$date."  |UserID:  ".$memberID."  |User:  ".$member_name." |  ".$msg."\n\n\n"; 
        print($log."\n");
        //if($error_code>=3) print($log."\n"); // exception error
        //error_log($log, $error_code, self::USER_ERROR_DIR); 
     */
        } 
      */
      /*
     public function general($msg,$error_code=1) 
     { 
     /*   
     $Current_Page=$_SERVER['PHP_SELF'];
        $date = date("d.m.Y h:i:s"); 
        $log = "Page:  ".$Current_Page."   |Error Code:  ".$error_code."  |Date:  ".$date."  |  ".$msg."\n\n\n";
        print($log."\n");
        //error_log($log, $error_code, self::GENERAL_ERROR_DIR); 
        
     } 
     */
     /*
     
     public function read_log_file($path) 
     { 
        $contents =""
        $filename = $path;
        $handle = fopen($filename, "r");
        $contents = fread($handle, filesize($filename));
        fclose($handle);
        return $contents; 
     } 
     
     public function display_user_log() 
     { 
        $log_text=$this->read_log_file(self::USER_ERROR_DIR);
        return $log_text;
        //print($log_text); 
     } 
     
     public function display_general_log() 
     { 
        $log_text=$this->read_log_file(self::GENERAL_ERROR_DIR);
        return $log_text;
        //print($log_text); 
     } 
     
     public function display_all_logs() 
     { 
        $general_log=$this>display_general_log();
        $general_log=display_user_log();
        $log_text=$this->read_log_file(self::USER_ERROR_DIR);
        print($log_text);
     } 
     */
     
 } 
 */
?>
