<?php
/**
 * Created by PhpStorm.
 * User: mm
 * Date: 1/16/2020
 * Time: 8:41 PM
 */


require_once('../php/in_common.php');
require_once('../php/in_dbConnection.php');

$userid = $_SESSION['username'];
$role = $_SESSION['role'];
$response=array("success"=>-100);
$making=array();
if(isset($userid) && in_array($role,$crop)) {
    $sql="Select * from masking where status >0";
    doLog('[sr_kn_loadSubscribers][] [sql: ' . $sql . ']');
    $result=$ci_conn->query($sql);
    if($result->num_rows>0){
        while ($row=$result->fetch_assoc()){
            $masking[]=$row;
        }
        $response['success']=100;
        $response['masking']=$masking;
    }else{
        $response['msg']='No data found for masking';
    }
}else{
    header('Location: ../php/logout.php');

}
echo json_encode($response);
?>