<?php
/**
 * Created by PhpStorm.
 * User: mm
 * Date: 2/3/2020
 * Time: 11:53 AM
 */

require_once ('../php/in_dbConnection.php');
require_once ('../php/in_common.php');
require_once ('../php/in_session.php');
$username=$_SESSION['username'];
$role=$_SESSION['role'];
$response=array("success"=>-100);
$status=isset($_GET['status'])?$_GET['status']:'';
$id=isset($_GET['id'])?$_GET['id']:'';
if(isset($username) && in_array($role,$bulk_unsub)){
    $sql="Update bulk_sub_unsub_job set `status`='$status' where `id`='$id'";
    doLog('[sr_updateJobStatus.php][get total ] [sql: ' . $sql . ']');
    $result=$bu_conn->query($sql);
    if($result){
        $response['success']=100;
        $response['msg']='Successfully update job status';
    }else{
        $response['msg']='Sorry something went wrong';
    }
}else{
    header("Location:../php/logout.php");
}
echo json_encode($response);
?>