<?php
require_once('../php/in_common.php');
require_once('../php/in_dbConnection.php');

$userid = $_SESSION['username'];
$role = $_SESSION['role'];

$state = isset($_GET['state']) ? $_GET['state'] : null;
$cellno = isset($_GET['cellno']) ? $_GET['cellno'] : null;

$response = array("success" => -100);
/*$names = array();
$langs_missouri = array();
$langs_gb = array();
$states = array();
$locations = array();
$services = array();*/
$sub_profile = array();
$wdc_profile=array();
$result='';
if (isset($userid) && in_array($role, $cro)) {


    $sql="SELECT cellno,IFNULL(district,'N/A')AS district,ifnull(srvc_id,'N/A')AS srvc_id,IFNULL(state,'N/A')AS state,IFNULL(lang,'N/A')AS lang,IFNULL(sub_name,'Zimindar sahib')AS sub_name,IFNULL(first_sub_dt,'NULL')AS first_sub_dt,IFNULL(last_sub_dt,'NULL')AS last_sub_dt,IFNULL(last_unsub_dt,'NULL')AS last_unsub_dt,IFNULL(sub_mode,'NULL')AS sub_mode,IFNULL(occupation,'N/A')AS occupation,IFNULL(village,'Default Chak')AS village,IFNULL(land_size,'1')AS land_size,IFNULL(land_unit,'QILLA')AS land_unit,IFNULL(unsub_mode,'NULL')AS unsub_mode,IFNULL(alert_type,'N/A')AS alert_type,IFNULL(tehsil,'N/A')AS tehsil,IFNULL(COMMENT,'DEFAULT')AS COMMENT,IFNULL(bc_mode,'N/A')AS bc_mode FROM subscriber_unsub where cellno='$cellno'";
    //$sql = "SELECT cellno,IF(sub_name,'NULL',sub_name) ,IF(occupation,'NULL',occupation),IF(lang,'NULL',lang),IF(state,'NULL',state),IF(district,'NULL',district) ,IF(tehsil,'NULL',tehsil),IF(first_sub_dt,'NULL',first_sub_dt),IF(last_sub_dt,'NULL',last_sub_dt) ,IF(last_unsub_dt,'NULL',last_unsub_dt) ,IF(sub_mode,'NULL',sub_mode) ,IF(unsub_mode,'NULL',unsub_mode) ,IF(village,'NULL',village),IF(srvc_id,'NULL',srvc_id) ,IF(land_size,'NULL',land_size) ,IF(land_unit,'NULL',land_unit) ,IF(alert_type,'NULL',alert_type) ,IF(bc_mode,'NULL',bc_mode) ,IF(COMMENT,'NULL',COMMENT) FROM subscriber_unsub WHERE cellno='$cellno'";
    doLog('[sr_getUnSubProfileNew][getSubProfile] [sql: ' . $sql . ']');
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            $sub_profile[] = $row;
        }
        $response["success"] = 100;
        $response["msg"] = "Successfully found Data";

        $response["sub_profile"] = $sub_profile;
    } else {
        $response["msg"] = "No results found for subscriber";
    }


} else {
    header('Location: ../php/logout.php');
}

echo json_encode($response);
?>

