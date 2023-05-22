<?php
/**
 * Created by PhpStorm.
 * User: mm
 * Date: 1/16/2020
 * Time: 1:48 PM
 */
require_once('../php/in_common.php');
require_once('../php/in_dbConnection.php');
$userid = $_SESSION['username'];
$role = $_SESSION['role'];
$response = array("success" => -100);
$cellno=$_POST['cellno'];
$msg=$_POST['msg'];
$masking=$_POST['masking'];

if(isset($userid) && in_array($role,$crop)){
   $sql="Insert into `send_sms`(`to`,`from`,`sms_text`,`dt`)VALUES ('$cellno','$masking','$msg',NOW())";
    doLog('[sr_send_sms][sql: ' . $sql . ']');
    $result=$ci_conn->query($sql);
    if($result){
        $response['msg']='Message save successfully';
        $response['success']=100;
    }else{
        $response['msg']='Sorry message not save ';
        $response['success']=-100;
    }

} else {
    header('Location: ../php/logout.php');
}
echo json_encode($response);
?>