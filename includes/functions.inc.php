<?php

    function is_base64($str){
         if($str === base64_encode(base64_decode($str))){
             return true;
         }
         return false;
     }    


function exceptions_error_handler($severity, $message, $filename, $lineno) {
    throw new ErrorException($message, 0, $severity, $filename, $lineno);
}

//set_error_handler('exceptions_error_handler');



function dirify($text)
{
	$text=strtolower($text);
	$code_entities_match = array(' ','--','&quot;','!','@','#','$','%','^','&','*','(',')','_','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",',','.','*','+','~','`','=');
	$code_entities_replace = array('-','-','','','','','','','','','','','','','','','','','','','','','','','');
	$text = str_replace($code_entities_match, $code_entities_replace, $text);
	return $text;
} 
/*
function dirify($s) {
     $s = convert_high_ascii($s);  ## convert high-ASCII chars to 7bit.
     $s = strtolower($s);           ## lower-case.
     $s = strip_tags($s);       ## remove HTML tags.
     $s = preg_replace('!&[^;\s]+;!','',$s);         ## remove HTML entities.
     $s = preg_replace('![^\w\s.]!','',$s);           ## remove non-word/space/period chars.
     $s = preg_replace('!\s+!','-',$s);               ## change space chars to dashes.
     return $s;    
}
*/
function convert_high_ascii($s) {
 	$HighASCII = array(
 		"!\xc0!" => 'A',    # A`
 		"!\xe0!" => 'a',    # a`
 		"!\xc1!" => 'A',    # A'
 		"!\xe1!" => 'a',    # a'
 		"!\xc2!" => 'A',    # A^
 		"!\xe2!" => 'a',    # a^
 		"!\xc4!" => 'Ae',   # A:
 		"!\xe4!" => 'ae',   # a:
 		"!\xc3!" => 'A',    # A~
 		"!\xe3!" => 'a',    # a~
 		"!\xc8!" => 'E',    # E`
 		"!\xe8!" => 'e',    # e`
 		"!\xc9!" => 'E',    # E'
 		"!\xe9!" => 'e',    # e'
 		"!\xca!" => 'E',    # E^
 		"!\xea!" => 'e',    # e^
 		"!\xcb!" => 'Ee',   # E:
 		"!\xeb!" => 'ee',   # e:
 		"!\xcc!" => 'I',    # I`
 		"!\xec!" => 'i',    # i`
 		"!\xcd!" => 'I',    # I'
 		"!\xed!" => 'i',    # i'
 		"!\xce!" => 'I',    # I^
 		"!\xee!" => 'i',    # i^
 		"!\xcf!" => 'Ie',   # I:
 		"!\xef!" => 'ie',   # i:
 		"!\xd2!" => 'O',    # O`
 		"!\xf2!" => 'o',    # o`
 		"!\xd3!" => 'O',    # O'
 		"!\xf3!" => 'o',    # o'
 		"!\xd4!" => 'O',    # O^
 		"!\xf4!" => 'o',    # o^
 		"!\xd6!" => 'Oe',   # O:
 		"!\xf6!" => 'oe',   # o:
 		"!\xd5!" => 'O',    # O~
 		"!\xf5!" => 'o',    # o~
 		"!\xd8!" => 'Oe',   # O/
 		"!\xf8!" => 'oe',   # o/
 		"!\xd9!" => 'U',    # U`
 		"!\xf9!" => 'u',    # u`
 		"!\xda!" => 'U',    # U'
 		"!\xfa!" => 'u',    # u'
 		"!\xdb!" => 'U',    # U^
 		"!\xfb!" => 'u',    # u^
 		"!\xdc!" => 'Ue',   # U:
 		"!\xfc!" => 'ue',   # u:
 		"!\xc7!" => 'C',    # ,C
 		"!\xe7!" => 'c',    # ,c
 		"!\xd1!" => 'N',    # N~
 		"!\xf1!" => 'n',    # n~
 		"!\xdf!" => 'ss'
 	);
 	$find = array_keys($HighASCII);
 	$replace = array_values($HighASCII);
 	$s = preg_replace($find,$replace,$s);
     return $s;
}
//echo"xxx";
function GetModulesPermissions(){
	
	//echo"yyy";
	//$r=new ReturnRecord();
	/*
    global $r;
	$RetArr=array();
	if(isset($_SESSION['original_domainsID'])){
		$sql="SELECT modulesID FROM domains_modules WHERE domainsID=".$_SESSION['original_domainsID'];
		print $sql;
		$rslt=$r->RawQuery($sql);
		while($myrow=$r->Fetch_Array()){
			$RetArr[]=$myrow[0];
		}
	}
	
		
	return $RetArr;
	*/
}

//----------------------------------------------------------------
function callback($buffer)
{
	// replace all the apples with oranges
	//return (str_replace("Yamba", "oranges", $buffer));
	//$buffer="\n".$buffer;
	//$buffer = trim($buffer," \t\n\r"););
	global $tag_match_array;
	//print_r($tag_match_array);

	$sub_string_total="xx";
	$match_array=array();
	$inner_array=array();
	$search=0;
	$buffer_size=strlen($buffer);
	$query="";
	$str_match="";
	$cur_match=""; 
	$inner_match="";
	$start_count=0;
	$end_count=0;
	while($search<=$buffer_size){
	
	//while($search<=150){
		$sub_string = substr($buffer, $search, 1);
		if($sub_string=="{"){
			$start_count++;
			$cur_match.=$sub_string;
		}elseif($sub_string=="}"){
			$end_count++;
			$cur_match.=$sub_string;
		}else{
			if($start_count>0){
				$cur_match.=$sub_string;
				$inner_match.=$sub_string;
			}
		}
		if(($start_count==2)&&($end_count==2)){
			$match_array[]=$cur_match;
			$inner_array[]=$inner_match;
			$cur_match="";
			$inner_match="";
			$start_count=0;
			$end_count=0;
		}

		
		//$query.=" ".$search;
		/*
		if($sub_string==" "){
			$sub_string_total.=$sub_string."\n".$query;
		}else{
			$sub_string_total.=$sub_string.$query;
		}
		*/
		//$sub_string_total.=$sub_string;
		//$query.="+".$sub_string."-|->".$search." \n";
		//$query.=$sub_string;
		$search++;
	}
	/*
	foreach($match_array as $key=>$val){
		//str_replace($val, "oranges", $buffer)

	}
	*/
	//$buffer="--".$search."-".$buffer_size."-".$buffer;
	
	for($x=0;$x<count($match_array);$x++){
		if(isset($tag_match_array[$inner_array[$x]])){
			$query.="| ".$x." |\n ".$inner_array[$x]."\n--".$match_array[$x]."=>".$tag_match_array[$inner_array[$x]];//var_export($tag_match_array[$inner_array[$x]],true);
			$buffer=str_replace($match_array[$x], $tag_match_array[$inner_array[$x]], $buffer);
		}else{
			$buffer=str_replace($match_array[$x], "", $buffer);
		}
		
		//.$inner_array[$x]."\n--".$tag_match_array[$x]."\n--".$match_array[$x]."\n-------------------\n";
		
		/*
		if(array_key_exists($inner_array[$x], $tag_match_array)){
			//$buffer=str_replace($match_array[$x], $tag_match_array[$x], $buffer);
			//$buffer="| ".$x." |\n ".var_export($match_array,true)."\n--".var_export($inner_array,true)."\n--".var_export($tag_match_array,true)."\n--".$buffer;
			
		}else{
			$buffer=str_replace($match_array[$x], $tag_match_array[$x], $buffer);
		}
		*/
		
	}
	
	$buffer=$query."--".$buffer;
	$pos = strpos($buffer, "<");
	$buffer=substr($buffer, $pos);
	$buffer="<!DOCTYPE HTML>".$buffer;
	//$buffer = trim($buffer);
	return $buffer;
}

?>