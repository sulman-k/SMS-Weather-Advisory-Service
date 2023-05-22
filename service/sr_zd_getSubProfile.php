<?php
/**
 * Created by PhpStorm.
 * User: mm
 * Date: 1/21/2020
 * Time: 6:05 PM
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



    $sql = "SELECT cellno,sub_dt,unsub_dt ,sub_mode,unsub_mode,charge_attempt_dt,last_charge_dt,next_charge_dt,grace_expire_dt FROM subscriber WHERE cellno='$cellno'";
    doLog('[sr_zd_getSubProfile][getSubProfile] [sql: ' . $sql . ']');
    $result = $zd_conn->query($sql);
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            $sub_profile[] = $row;
        }

    } else {
        $response["msg"] = "No results found for subscriber";
    }

    $response["success"] = 100;
    $response["msg"] = "Successfully found Data";

    $response["zd_profile"] = $sub_profile;
} else {
    header('Location: ../php/logout.php');
}

echo json_encode($response);
?>

