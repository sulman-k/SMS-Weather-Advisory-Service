<?php
class SmsConversion
{
   public function getHexacode($msg) {
		
		$found = false;
		$tempArray = array();
		$finalArray = array();
		
		
		for($i=0; $i < strlen($msg); $i++){	

			#echo "[$i]CHR: ".$msg[$i]."<br>";
			$nextIndex = $i+1;
			#if($nextIndex != strlen($msg) && $msg[$i] == "&" && $msg[$nextIndex] == "#"){
			if($msg[$i] == "&"){
				$found = true;
				$srt = implode("",$tempArray);				
				#echo "STR: $srt<br>";
				if($srt != "")
					$finalArray[] = $srt;				
				unset($tempArray);
				$tempArray =  array();				
			}else if($msg[$i] == ";"){
				$found = false;
			}
			
			if($found == false){
				//make conversion here
				$con = $msg[$i];
				if($msg[$i] != ";")
				$con = ord($msg[$i]).';';
				$tempArray[]=$con;
			}else{
				if($msg[$i] !="&" && $msg[$i] != "#" ){
					$tempArray[]=$msg[$i];
				}
			}
		}	

		if(count($tempArray) > 0){
				$srt = implode("",$tempArray);				
				$finalArray[] = $srt;
		}
		$decimelMsg = implode("",$finalArray);
		$arrData = explode(";", $decimelMsg);
		//remove last number because this is empty string because last number string is ';'  
		unset($arrData[count($arrData)-1]);		
		for($j=0; $j < count($arrData); $j++){
			$val = $arrData[$j];
			//convert decimel value to hax
			$val = dechex($val);
			$len = strlen($val);
			//make converted number to 4-digit number(by append required 0 on right-end side)
			if($len == 1)
				$val = '000'.$val;	
			else if($len == 2)
				$val = '00'.$val;
			else if($len == 3)
				$val = '0'.$val;
			//insert % between 2 number
			#echo $val.':::';	
			$val = '%'.substr($val, 0, 2).'%'.substr($val, 2, 3);				
			#echo $val.'<br>';
			$arrData[$j] = $val;	
    	}
		//this is final  message for sms...

		return implode("",$arrData);
    }
}


?>
