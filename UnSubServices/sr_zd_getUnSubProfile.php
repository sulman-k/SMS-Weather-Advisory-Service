<?php
/**
 * Created by PhpStorm.
 * User: mm
 * Date: 1/22/2020
 * Time: 12:02 PM
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
if (isset($userid) && in_array($role, $cro)) {



    $sql = "SELECT cellno,IFNULL(sub_dt,'00/00/0000')AS sub_dt,IFNULL(unsub_dt,'N/A')AS unsub_dt,IFNULL(sub_mode,'N/A')AS sub_mode,IFNULL(unsub_mode,'N/A')AS unsub_mode,IFNULL(charge_attempt_dt,'N/A')AS charge_attempt_dt,IFNULL(last_charge_dt,'N/A')AS last_charge_dt,IFNULL(next_charge_dt,'N/A')AS next_charge_dt,IFNULL(grace_expire_dt,'N/A')AS grace_expire_dt FROM subscriber_unsub WHERE cellno='$cellno'";
    doLog('[sr_zd_getUnSubProfile][getSubProfile] [sql: ' . $sql . ']');
    $result = $zd_conn->query($sql);
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            $sub_profile[] = $row;
        }

    } else {
        $response["msg"] = "No results found";
    }

    $response["success"] = 100;
    $response["msg"] = "Successfully found Data";

    $response["zd_profile"] = $sub_profile;
} else {
    header('Location: ../php/logout.php');
}

echo json_encode($response);
?>

