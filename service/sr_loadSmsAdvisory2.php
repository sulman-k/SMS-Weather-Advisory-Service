<?php
require_once('../php/in_common.php');
require_once('../php/in_dbConnection.php');

$userid = $_SESSION['username'];


$response = array("success" => -100);
$sms_push_advisory = array();

if (in_array(validateUserRole($conn, $_SESSION['username']) , $ops)) {

    $sql = "SELECT * FROM sms_push_advisory GROUP BY crop_focus_id ORDER BY id LIMIT 6";

    $result = $conn->query($sql);
    doLog('[sr_loadSmsAdvisoryAdvisory][Location] [sql: ' . $sql . ']');
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $row['is_sent'] = $row['is_sent'] == 100 ? "Sent" : "Pending";
            $sms_push_advisory[] = $row;
        }
        $response["sms_push_advisory"] = $sms_push_advisory;
        $response["success"] = 100;

    } else {
        $response["msg"] = "No results found for advisory sms";
    }

} else {
    header('Location: ../php/logout.php');
}

echo json_encode($response);
?>
