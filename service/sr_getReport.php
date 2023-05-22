<?php
require_once('../php/in_common.php');
require_once('../php/in_dbConnection.php');

$userid = $_SESSION['username'];
$role = $_SESSION['role'];

$loc_id = $_GET['loc_id'];
$startdt = $_GET['stDate'];
$enddt = $_GET['endDate'];

$src = $_GET['src'];

$response = array("success" => -100);
$smsData = array();
$eve_smsData = array();


if (isset($userid) && in_array($role, $content)) {

    if (isset($loc_id) && isset($startdt) && isset($enddt)) {


        if (!strcmp($src, 'gb')) {

            $sql = "SELECT * FROM aw_daily_weather WHERE district = '$loc_id' AND `aw_type` = 200  AND date BETWEEN '$startdt' AND '$enddt' order by date desc";
            $result = $conn->query($sql);
            doLog('[sr_getReport.php][auto_weather] [sql: ' . $sql . ']');
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $smsData[] = array("id" => $row['id'], "location" => $row['district'], "date" => $row['date'], "sms_text" => $row['sms_text']);
                }
                $response["success"] = 100;
                $response["msg"] = "Successfully found weather";
                //$response["sms_data"] = $smsData;

            } else {
                $response["msg"] = "No results found for this City";
            }


            $sql = "SELECT * FROM aw_daily_weather WHERE district = '$loc_id' AND `aw_type` = 201  AND date BETWEEN '$startdt' AND '$enddt' order by date desc";
            $result = $conn->query($sql);
            doLog('[sr_getReport.php][auto_weather] [sql: ' . $sql . ']');
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $eve_smsData[] = array("id" => $row['id'], "location" => $row['district'], "date" => $row['date'], "sms_text" => $row['sms_text']);
                }
                $response["success"] = 100;
                $response["msg"] = "Successfully found weather";
                //$response["eve_sms_data"] = $eve_smsData;

            } else {
                $response["msg"] = "No results found for this City";
            }

            for ($i = 0; $i < sizeof($smsData); $i++) {
                if ($smsData[$i]["location"] == $eve_smsData[$i]["location"] && $smsData[$i]["date"] == $eve_smsData[$i]["date"]) {
                    $smsData[$i]["eve_sms_text"] = $eve_smsData[$i]["sms_text"];
                }
            }

            $response["sms_data"] = $smsData;

        } else {

            $sql = "SELECT * FROM aw_daily_weather WHERE district = '$loc_id' AND date BETWEEN '$startdt' AND '$enddt' order by date desc";
            $result = $conn->query($sql);
            doLog('[sr_getReport.php][auto_weather] [sql: ' . $sql . ']');
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $smsData[] = array("id" => $row['id'], "date" => $row['date'], "sms_text" => $row['sms_text']);
                }
                $response["success"] = 100;
                $response["msg"] = "Successfully found weather";
                $response["sms_data"] = $smsData;

            } else {
                $response["msg"] = "No results found for this City";
            }
        }
    } else {
        $response["msg"] = "No requested parameters found";
    }
} else {
    header('Location: ../php/logout.php');
}

echo json_encode($response);
?>
