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
  $sql="Select paid_wall_id,paid_wall_name from services";
  doLog('[sr_getAllServices.php][get query ] [sql: ' . $sql . ']');
  $result=$bu_conn->query($sql);
  if($result->num_rows>0){
      while ($row=$result->fetch_assoc()){
          $services[]=$row;
      }
      $response['success']=100;
      $response['msg']='Successfully found services';
      $response['services']=$services;
  }else{
      $response['msg']='Sorry no record found for services';
  }
}else{
    header('Locations: ../php/logout.php');
}
echo json_encode($response);
?>