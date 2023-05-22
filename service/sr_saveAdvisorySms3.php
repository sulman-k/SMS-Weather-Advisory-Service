<?php
require_once('../php/in_common.php');
require_once('../php/in_dbConnection.php');
require_once('../php/convertsms.php');

$userid = $_SESSION['username'];
$role = $_SESSION['role'];

$potato_sms = isset($_POST['potato'])? $_POST['potato']: '';
$maize_sms = isset($_POST['maize'])? $_POST['maize']: '';
$wheat_sms = isset($_POST['wheat'])? $_POST['wheat']: '';
$sugarcane_sms = isset($_POST['sugarcane'])? $_POST['sugarcane']: '';
$cotton_sms = isset($_POST['cotton'])? $_POST['cotton']: '';
$rice_sms = isset($_POST['rice'])? $_POST['rice']: '';

$response = array("success" => -100);
$contents = array();

$convertor = new SmsConversion();

$sql = '';

$hex_potato_sms = $convertor->getHexacode($potato_sms);
$hex_maize_sms = $convertor->getHexacode($maize_sms);
$hex_wheat_sms = $convertor->getHexacode($wheat_sms);
$hex_sugarcane_sms = $convertor->getHexacode($sugarcane_sms);
$hex_cotton_sms = $convertor->getHexacode($cotton_sms);
$hex_rice_sms = $convertor->getHexacode($rice_sms);


if (isset($userid) && in_array($role, $ops)) {

    try {
        $conn->autocommit(FALSE);
        $response["msg"] = 'Advisory is going to update';

        $result = '';
        $sql = "update sms_push_advisory set sms_text = '$potato_sms' , sms_text_advisory_only = '$hex_potato_sms' WHERE id < 21";
        doLog('[sr_addSubscriber][] [username: ' . $userid . '][sql: ' . $sql . ' ]');
        $result = $conn->query($sql);
        if ($result === false) {
            throw new Exception('SQL Error: advisory missouri ' . $conn->error);
        }

        $result = '';
        $sql = "update sms_push_advisory set sms_text = '$maize_sms' , sms_text_advisory_only = '$hex_maize_sms' WHERE id < 41 and id > 20";
        doLog('[sr_addSubscriber][] [username: ' . $userid . '][sql: ' . $sql . ' ]');
        $result = $conn->query($sql);
        if ($result === false) {
            throw new Exception('SQL Error: advisory missouri ' . $conn->error);
        }

        $result = '';
        $sql = "update sms_push_advisory set sms_text = '$wheat_sms' , sms_text_advisory_only = '$hex_wheat_sms' WHERE id < 61 and id > 40";
        doLog('[sr_addSubscriber][] [username: ' . $userid . '][sql: ' . $sql . ' ]');
        $result = $conn->query($sql);
        if ($result === false) {
            throw new Exception('SQL Error: advisory missouri ' . $conn->error);
        }

        $result = '';
        $sql = "update sms_push_advisory set sms_text = '$sugarcane_sms' , sms_text_advisory_only = '$hex_sugarcane_sms' WHERE id < 81 and id > 60";
        doLog('[sr_addSubscriber][] [username: ' . $userid . '][sql: ' . $sql . ' ]');
        $result = $conn->query($sql);
        if ($result === false) {
            throw new Exception('SQL Error: advisory missouri ' . $conn->error);
        }

        $result = '';
        $sql = "update sms_push_advisory set sms_text = '$cotton_sms' , sms_text_advisory_only = '$hex_cotton_sms' WHERE id < 101 and id > 80";
        doLog('[sr_addSubscriber][] [username: ' . $userid . '][sql: ' . $sql . ' ]');
        $result = $conn->query($sql);
        if ($result === false) {
            throw new Exception('SQL Error: advisory missouri ' . $conn->error);
        }

        $result = '';
        $sql = "update sms_push_advisory set sms1_text = '$rice_sms' , sms_text_advisory_only = '$hex_rice_sms' WHERE id > 100";
        doLog('[sr_addSubscriber][] [username: ' . $userid . '][sql: ' . $sql . ' ]');
        $result = $conn->query($sql);
        if ($result === false) {
            throw new Exception('SQL Error: advisory missouri ' . $conn->error);
        }


        $conn->commit();
        $response["msg"] = "Advisory messages have been uploaded";
        $response["success"] = 100;

    } catch (Exception $e) {
        $response["msg"] = 'Transaction failed: ' . $e->getMessage();
        $conn->rollback();
    }
    $conn->autocommit(TRUE);



} else {
    header('Location: ../php/logout.php');
}

echo json_encode($response);
?>
