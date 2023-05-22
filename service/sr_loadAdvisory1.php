<?php
require_once('../php/in_common.php');
require_once('../php/in_dbConnection.php');

$userid = $_SESSION['username'];
$role = $_SESSION['role'];

$state = isset($_GET['state']) ? $_GET['state'] : '';

$response = array("success" => -100);
$services_pu = array();

if (isset($userid) && in_array($role, $ops)) {

    $sql = "SELECT ps.*
FROM state_srvc ps
INNER JOIN srvc_def sd
ON ps.`srvc_id` = sd.srvc_id
WHERE  sd.srvc_type = 'crop' AND sd.focusable > 0 AND ps.`state` = '$state' ";
    $result = $conn->query($sql);
    doLog('[sr_loadAdvisorymissouri.php][EDIT] [sql: ' . $sql . ']');
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        //  $i=0;
        while ($row = $result->fetch_assoc()) {
            $services_pu[] = $row;
        }

        $response["success"] = 100;
        $response["msg"] = "Successfully found Data";
        $response["services_pu"] = $services_pu;

    } else {
        $response["msg"] = "No results found for focusable crops ";
    }
} else {
    header('Location: ../php/logout.php');
}

echo json_encode($response);
?>
