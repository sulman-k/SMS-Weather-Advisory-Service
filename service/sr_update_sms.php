<?php
/**
 * Created by PhpStorm.
 * User: mm
 * Date: 1/16/2020
 * Time: 8:23 PM
 */

require_once('../php/in_common.php');
require_once('../php/in_dbConnection.php');

$userid = $_SESSION['username'];
$role = $_SESSION['role'];

$response=array("success"=>-100);
$cellno=$_POST['cellno'];
$id=$_POST['id'];
$msg=$_POST['msg'];

if(isset($userid) && in_array($role,$crop)){
   $sql="Update send_sms set `sms_text`='$msg' where `to`='$cellno' and id='$id'";
    doLog('[sr_update_sms.php][] [sql: ' . $sql . ']');
    $result=$ci_conn->query($sql);
    if($result){
        $response['success']=100;
        $response['msg']='Successfully update message';
    }else{
        $response['msg']='Sorry message not updated';
    }


}else{
    header('Location: ../php/logout.php');
}
echo json_encode($response);
?>
