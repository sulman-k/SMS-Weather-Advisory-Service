<?php
require_once ('../php/in_common.php');
require_once ('../php/in_dbConnection.php');
require_once ('../php/convertsms.php');

$userid=$_SESSION['username'];
$role=$_SESSION['role'];

$adv_sms=isset($_POST['sms_adv'])?$_POST['sms_adv']:'';

$response=array("success"=>-100);
$contents=array();
//$convertor=new SmsConversion();
$sql='';

//echo $adv_sms;*/
//$hexa_adv_sms=$convertor->getHexacode($adv_sms);
$url_encoded_adv_sms = urlencode($adv_sms);
//print_r(unpack("C*", $adv_sms));
if(isset($userid)&& in_array($role,$ops)){


        $result='';
        $sql="INSERT INTO sms_push_news (sms_text)VALUES('$url_encoded_adv_sms')";
        doLog( '[sr_saveSmsAdvisory][][username:'.$userid.'][sql:'.$sql.']');
        $result=$conn->query($sql);
        if($result){
            $response["msg"]="Advisory message successfully saved";
            $response["success"]=100;
        }else{
            $response["msg"]="Unable to save advisory msg";
        }


}else{
    header( 'Location:../php/logout.php');
}
echo json_encode($response);
?>