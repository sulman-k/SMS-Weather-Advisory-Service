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



    $sql = "SELECT * FROM subscriber s INNER JOIN sub_profile sp ON s.`cellno`=sp.`cellno` WHERE  s.`state`='$state'  AND s.`cellno` = '$cellno'";
    doLog('[sr_getSubProfile][getSubProfile] [sql: ' . $sql . ']');
    $result = $tc_conn->query($sql);
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            $sub_profile[] = $row;
        }

    } else {
        $response["msg"] = "No results found for subscriber";
    }

    $sql = "SELECT * FROM sub_names ORDER BY id";

    doLog('[sr_getSubProfile][getSubProfile] [sql: ' . $sql . ']');
    $result = $tc_conn->query($sql);
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            $names[] = $row;
        }

    } else {
        $response["msg"] = "No results found for Sub Names";
    }

    $sql = "SELECT p.id , pl.lang
FROM state p
INNER JOIN state_lang pl
ON p.id= pl.`state`
WHERE p.`status` > 0";

    doLog('[sr_getSubProfile][getSubProfile] [sql: ' . $sql . ']');
    $result = $tc_conn->query($sql);
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            if(!strcmp($row['id'],'missouri')) {
                $langs_missouri[] = $row;
            }else if(!strcmp($row['id'],'gb')){
                $langs_gb[] = $row;
            }
        }


    } else {
        $response["msg"] = "No results found for Languages";
    }

    $sql = "SELECT * FROM state WHERE `status` > 0";

    doLog('[sr_getSubProfile][getSubProfile] [sql: ' . $sql . ']');
    $result = $tc_conn->query($sql);
    if ($result->num_rows > 0) {
        
        while ($row = $result->fetch_assoc()) {
            $states[] = $row;
        }

    } else {
        $response["msg"] = "No results found for state";
    }

    $sql = "SELECT id,state FROM district WHERE `status` > 0 ORDER BY loc_order";

    doLog('[sr_getSubProfile][getSubProfile] [sql: ' . $sql . ']');
    $result = $tc_conn->query($sql);
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            $locations[] = $row;
        }

    } else {
        $response["msg"] = "No results found for state";
    }


    $sql = "SELECT ps.*
FROM state_srvc ps
INNER JOIN srvc_def sd
ON ps.`srvc_id` = sd.srvc_id
WHERE  sd.srvc_type = 'crop' AND sd.focusable > 0";

    doLog('[sr_getSubProfile][getSubProfile] [sql: ' . $sql . ']');
    $result = $tc_conn->query($sql);
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            $services[] = $row;
        }

    } else {
        $response["msg"] = "No results found for state";
    }

    $response["success"] = 100;
    $response["msg"] = "Successfully found Data";
    $response["names"] = $names;
    $response["langs_missouri"] = $langs_missouri;
    $response["langs_gb"] = $langs_gb;

    $response["sub_profile"] = $sub_profile;

    $response["states"] = $states;
    $response["locations"] = $locations;
    $response["servcesi"] = $services;
} else {
    header('Location: ../php/logout.php');
}

echo json_encode($response);
?>
