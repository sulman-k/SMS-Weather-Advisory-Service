<?php
/**
 * Created by PhpStorm.
 * User: mm
 * Date: 9/1/2020
 * Time: 11:39 AM
 */



require_once('../php/in_common.php');
require_once('../php/in_dbConnection.php');

$userid = $_SESSION['username'];
$role = $_SESSION['role'];

$state = isset($_GET['state']) ? $_GET['state'] : null;
$cellno = isset($_GET['cellno']) ? $_GET['cellno'] : null;

$response = array("success" => -100);

$sub_profile = array();
$wdc_profile=array();
$result='';
$s_id='';

if (isset($userid) && in_array($role, $cro)) {



    $sql = "SELECT cellno,sub_dt,unsub_dt ,sub_mode,unsub_mode,charge_attempt_dt,last_charge_dt,next_charge_dt,grace_expire_dt,service_id FROM subscriber WHERE cellno='$cellno'";
    doLog('[sr_kt_getSubProfile][getSubProfile] [sql: ' . $sql . ']');
    $result = $kt_conn->query($sql);
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            $sub_profile[] = $row;
            $s_id=$row['service_id'];

        }

    } else {
        $response["msg"] = "No results found for subscriber";
    }


    $sql="Select `amount` from `service` where id=$s_id";
    doLog('[sr_kt_getSubProfile][getSubProfile] [service amount: ' . $sql . ']');
    $result = $kt_conn->query($sql);
    if ($result) {
        $amount=$result->fetch_assoc();
        $amount=$amount['amount'];
        $response['amount']=$amount;
    } else {
        $response["msg"] = "No results found for user package plan";
    }


    $response["success"] = 100;
    $response["msg"] = "Successfully found Data";

    $response["kt_profile"] = $sub_profile;
} else {
    header('Location: ../php/logout.php');
}

echo json_encode($response);
?>

