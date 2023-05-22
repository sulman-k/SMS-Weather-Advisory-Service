<?php
/**
 * Created by PhpStorm.
 * User: mm
 * Date: 2/3/2020
 * Time: 8:34 PM
 */
require_once ('../php/in_dbConnection.php');
require_once ('../php/in_common.php');
$username=$_SESSION['username'];
$role=$_SESSION['role'];
$response=array("success"=>-100);
$services=array();
if(isset($username) && in_array($role,$bulk_unsub)){
    $sql="Select * from services_payplan";
    if (isset($_REQUEST['pwi']))
    {
        $sql = $sql." WHERE `paid_wall_id` =".$_REQUEST['pwi'];
    }
  doLog('[sr_getAllServicesAmount.php][get query ] [sql: ' . $sql . ']');
  $result=$bu_conn->query($sql);
  if($result->num_rows>0){
      while ($row=$result->fetch_assoc()){
          $servicesAmounts[]=$row;
      }
      $response['success']=100;
      $response['msg']='Successfully found servicesAmounts';
      $response['servicesAmounts']=$servicesAmounts;
  }else{
      $response['msg']='Sorry no record found for servicesAmounts';
  }
}else{
    header('Locations: ../php/logout.php');
}
echo json_encode($response);
?>