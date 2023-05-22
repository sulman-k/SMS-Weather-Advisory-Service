<?php
/**
 * Created by PhpStorm.
 * User: mm
 * Date: 2/3/2020
 * Time: 12:58 PM
 */

require_once ('../php/in_dbConnection.php');
require_once ('../php/in_session.php');
require_once ('../php/in_common.php');

$username=$_SESSION['username'];
$role=$_SESSION['role'];
$job_summary=array();
$response=array("success"=>-100);
$id=isset($_GET['id'])?$_GET['id']:'';
if(isset($username) && in_array($role,$bulk_unsub)){
    $sql="Show tables like 'job_$id'";
    doLog('[sr_updateJobStatus.php][check if table exist ] [sql: ' . $sql . ']');
    $result=$bu_conn->query($sql);
    if($result->num_rows>0){
        $sql="Select count(*) as total from job_$id";
        doLog('[sr_unsubJobSummary.php][ get job summary] [sql: ' . $sql . ']');
        $result=$bu_conn->query($sql);
        if($result->num_rows > 0){
            $row=$result->fetch_assoc();
            $response['total']=$row['total'];
            $response['success']=100;
            $response['msg']="Successfully found total cellno count";
        }else{
            $response['msg']="Sorry total count not found";
        }

        $sql="Select count(*) as unsubscribed from job_$id where `unsub_status`=100";
        doLog('[sr_unsubJobSummary.php][ get job summary] [sql: ' . $sql . ']');
        $result=$bu_conn->query($sql);
        if($result->num_rows > 0){
            $row=$result->fetch_assoc();
            $response['unsubscribed']=$row['unsubscribed'];
            $response['success']=100;
            $response['msg']="Successfully found unsubscribed cellno";
        }else{
            $response['msg']="Sorry no count found unsubscribed cellno";
        }

        $sql="Select count(*) as not_active_subscriber from job_$id where `unsub_status`=200";
        doLog('[sr_unsubJobSummary.php][ get job summary] [sql: ' . $sql . ']');
        $result=$bu_conn->query($sql);
        if($result->num_rows > 0){
            $row=$result->fetch_assoc();
            $response['not_active_subscriber']=$row['not_active_subscriber'];
            $response['success']=100;
            $response['msg']="Successfully found count of  not active subscriber cellno";
        }else{
            $response['msg']="Sorry no count found unsubscribed cellno";
        }

        $sql="Select count(*) as not_un_subscribed from job_$id where `unsub_status`=300";
        doLog('[sr_unsubJobSummary.php][ get job summary] [sql: ' . $sql . ']');
        $result=$bu_conn->query($sql);
        if($result->num_rows > 0){
            $row=$result->fetch_assoc();
            $response['not_un_subscribed']=$row['not_un_subscribed'];
            $response['success']=100;
            $response['msg']="Successfully found count of  not un subscribed cellno ";
        }else{
            $response['msg']="Sorry no count found  not un subscribed cellno";
        }

    }else{
        $response['msg']='Sorry table not exist for this job';
    }

}else{
    header("Location: ../php/logout.php");
}
echo json_encode($response);
?>
