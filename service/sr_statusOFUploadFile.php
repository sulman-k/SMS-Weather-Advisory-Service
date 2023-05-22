<?php
/**
 * Created by PhpStorm.
 * User: brad
 * Date: 7/12/2019
 * Time: 3:10 PM
 */
require_once('../php/in_dbConnection.php');
require_once('../php/in_common.php');
$userid = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$role = $_SESSION['role'];
$response = array("success"=>-100);
if (isset($userid) && in_array($role, $batch_user )) {
    $id=$_GET['id'];
    $tbl_name='list_'.$id;
    $sql="Select * from $tbl_name where status ='0'";
    $result=mysqli_query($conn,$sql);
    if($result){
    $count=mysqli_num_rows($result);
    $response['success']=100;
    $response['count']=$count;
    $response['msg']='Remaining Number for processing are ';

    }else{
        $response['msg']='Uploaded list is fully proceed';
    }

} else { // login credential invalid
    doLog("[sr_deleteActiveSubscriber][Credential Invalid][login credential invalid for user id - '$userid' AND role - '$role']");
    header('Location: ../php/logout.php');
}
echo json_encode($response);
?>
