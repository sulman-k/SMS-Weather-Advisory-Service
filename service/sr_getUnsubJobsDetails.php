<?php
/**
 * Created by PhpStorm.
 * User: mm
 * Date: 1/31/2020
 * Time: 6:42 PM
 */
require_once ('../php/in_dbConnection.php');
require_once ('../php/in_session.php');
require_once ('../php/in_common.php');
$username=$_SESSION['username'];
$role=$_SESSION['role'];
$response=array("success"=>-100);
$st=isset($_GET['st'])?$_GET['st']:'';
$end=isset($_GET['end'])?$_GET['end']:'';
$off_set=isset($_GET['offset'])?$_GET['offset']:'';
$datecheck='';
$jobs_details=array();
if($st !='undefined'&& $end !="undefined"){
    $st=$st.' 00:00:00';
    $end=$end.' 23:59:59';
    $datecheck= "where upload_dt between '$st' and '$end'";
}
$offset = ($off_set - 1) * $page_limit;

if(isset($username)&& in_array($role,$bulk_unsub)){
    $sql="Select count(*) as total from bulk_sub_unsub_job " .$datecheck;
    doLog('[sr_getUnsubJobsDetails.php][get total ] [sql: ' . $sql . ']');
    $result=$bu_conn->query($sql);
    if($result->num_rows>0){
        $row=$result->fetch_assoc();
        $response['total']=$row['total'];
    }else{
        $response['msg']='Sorry can not get total of all records';
    }
    $sql="SELECT b.* ,s.paid_wall_name FROM bulk_sub_unsub_job b JOIN services s ON s.paid_wall_id =b.paid_wall_id  ".$datecheck."   ORDER BY b.`id` DESC Limit $offset ,$page_limit";
    doLog('[sr_getUnsubJobsDetails.php][get record ] [sql: ' . $sql . ']');
    $result=$bu_conn->query($sql);
    if($result->num_rows>0){
        while ($row=$result->fetch_assoc()){
            $jobs_details[]=$row;
        }
        $response["success"]=100;
        $response['msg']='Successfully found all record';
        $response['jobs_details']=$jobs_details;
        $response['page_number']=$off_set;
    }else{
        $response['page_number']=$off_set;
        $response['jobs_details']=$jobs_details;
        $response['msg']='Sorry not record found';
    }
}else{
    header('Location: ../php/logout.php');
}
echo json_encode($response);
?>