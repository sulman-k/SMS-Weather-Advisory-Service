<?php
require_once('../php/in_common.php');
require_once('../php/in_dbConnection.php');

$userid = $_SESSION['username'];
$role = $_SESSION['role'];

$state = isset($_GET['state']) ? $_GET['state'] : null;
$cellno = isset($_GET['cellno']) ? $_GET['cellno'] : null;

$response = array("success" => -100);
$names = array();
$langs_missouri = array();
$langs_gb = array();
$states = array();
$locations = array();
$services = array();
$sub_profile = array();

if (isset($userid) && in_array($role, $cro)) {



    $sql = "SELECT cellno,IFNULL(location,'NULL')AS location,IFNULL(state,'NULL')AS state,IFNULL(lang,'NULL')AS lang,IFNULL(sub_name,'Zimindar sahib')AS sub_name,IFNULL(first_sub_dt,'NULL')AS first_sub_dt,IFNULL(last_sub_dt,'NULL')AS last_sub_dt,IFNULL(last_unsub_dt,'NULL')AS last_unsub_dt,IFNULL(sub_mode,'NULL')AS sub_mode,IFNULL(occupation,'NULL')AS occupation,IFNULL(village,'Default Chak')AS village,IFNULL(land_size,'1')AS land_size,IFNULL(land_unit,'QILLA')AS land_unit,IFNULL(unsub_mode,'NULL')AS unsub_mode,IFNULL(alert_type,'NULL')AS alert_type,IFNULL(COMMENT,'DEFAULT')AS COMMENT,IFNULL(bc_mode,'NULL')AS bc_mode FROM subscriber_unsub
  WHERE  `state`='$state'  AND `cellno` = '$cellno'";
    doLog('[sr_ka_getUnSubProfileNew][getSubProfile] [sql: ' . $sql . ']');
    $result = $ka_conn->query($sql);
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            $sub_profile[] = $row;
        }

    } else {
        $response["msg"] = "No results found for Unsubscriber";
    }

    $response["success"] = 100;
    $response["msg"] = "Successfully found Data";

    $response["sub_profile"] = $sub_profile;
} else {
    header('Location: ../php/logout.php');
}

echo json_encode($response);
?>
