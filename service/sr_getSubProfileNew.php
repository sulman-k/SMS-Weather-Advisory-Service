<?php
/**
 * Created by PhpStorm.
 * User: irfan
 * Date: 12/5/2017
 * Time: 5:20 PM
 */

require_once('../php/in_common.php');
require_once('../php/in_dbConnection.php');

$userid = $_SESSION['username'];
$role = $_SESSION['role'];

$state = isset($_GET['state']) ? $_GET['state'] : null;
$cellno = isset($_GET['cellno']) ? $_GET['cellno'] : null;

$response = array("success" => -100);
$names = array();
$statesData = array();
$states = array();
$sub_profile = array();

if (isset($userid) && in_array($role, $cro)) {



    $sql = "SELECT * FROM subscriber s INNER JOIN sub_profile sp ON s.`cellno`=sp.`cellno` WHERE  s.`state`='$state'  AND s.`cellno` = '$cellno'";
    doLog('[sr_getSubProfile][getSubProfile] [sql: ' . $sql . ']');
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            //$row['location'] =$row['district'];
            $sub_profile[] = $row;
        }

    }

    $sql = "SELECT * FROM sub_names ORDER BY id";

    doLog('[sr_getSubProfile][getSubProfileNames] [sql: ' . $sql . ']');
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            $names[] = $row;
        }

    }
    //---------------get all state
    $sql = "SELECT * FROM state WHERE `status` > 0";

    doLog('[sr_getSubProfile][getstate] [sql: ' . $sql . ']');
    $prov_result = $conn->query($sql);
    if ($prov_result->num_rows > 0) {
        doLog('[sr_getSubProfile][state] [sql: ' . $result->num_rows . ']');
        while ($row = $prov_result->fetch_assoc()) {
            $prov_info = $row;
            //$prov_info =array();
            $prov = $row['id'];
            //--------get Languages---------------------
            $sql = "SELECT lang FROM  state_lang  WHERE state = '$prov' ";
            doLog('[sr_getSubProfile][Languages] [sql: ' . $sql . ']');
            $result = $conn->query($sql);
            $langs = array();
            if ($result->num_rows > 0) {
                while ($data = $result->fetch_assoc()) {
                    array_push($langs,$data['lang']);
                }
            }
            $prov_info['langs'] = $langs;

            //--------get Services---------------------
            $sql = "SELECT ps.srvc_id FROM state_srvc ps INNER JOIN srvc_def sd ON ps.`srvc_id` = sd.srvc_id WHERE  ps.state = '$prov' AND 
                    sd.srvc_type = 'crop' AND sd.focusable > 0";
            doLog('[sr_getSubProfile][Services] [sql: ' . $sql . ']');
            $result = $conn->query($sql);
            $services = array();
            if ($result->num_rows > 0) {
                while ($data = $result->fetch_assoc()) {
                    array_push($services,$data['srvc_id']);
                }
            }
            $prov_info['services'] = $services;

            //--------get Locations---------------------
            //$sql = "SELECT id,state FROM location WHERE state = '$prov' AND status > 0 ORDER BY loc_order  ";
            $sql="SELECT n.id district,n.default_srvc_id,IFNULL( t.id,'unknown' ) tehsil FROM district n LEFT JOIN tehsil t 
                        ON n.id = t.district WHERE n.state = '$prov' AND n.status > 0 ORDER BY loc_order ";
            doLog('[sr_getSubProfile][Locations] [sql: ' . $sql . ']');//
            $result = $conn->query($sql);
            $locations = array();
            $ditrictWiseTehsils = array();
            if ($result->num_rows > 0) {
                while ($data = $result->fetch_assoc()) {
                    $tehsilArray = array();
                    $district = $data['district'];
                    $tehsil = $data['tehsil'];

                    //$prov = $data['state'];
                    $ditrictWiseTehsils[$district]['tehsils'][] = $tehsil;
                    $ditrictWiseTehsils[$district]['default_srvc_id'] = $data['default_srvc_id'];

                }
            }
           // $prov_info['district'] = $locations;
            $prov_info['districts'] = $ditrictWiseTehsils;
            $statesData[$prov] = $prov_info;

            //array_push($states,$prov);

        }
    }
    // districts = states[state].districts;
    // tehsils = districts[district].tehsils;

    $response["success"] = 100;
    $response["msg"] = "Successfully found Data";
    $response["names"] = $names;
    $response["sub_profile"] = $sub_profile;
    $response["statesData"] = $statesData;
    //$response["states"] = $states;
    //$response["newstate"] = $ditrictWiseTehsils;
} else {
    header('Location: ../php/logout.php');
}

echo json_encode($response);
?>
