<?php
require_once('../php/in_common.php');
require_once('../php/in_dbConnection.php');

$userid = $_SESSION['username'];
$role = $_SESSION['role'];

$seg_type = isset($_GET['seg_type']) ? $_GET['seg_type'] : '';

$response = array("success" => -100);
$contents = array();
$sql = '';

if (isset($userid) && in_array($role, $content)) {
    $sql = "select * from content WHERE seg_type = $seg_type order by id desc";

    doLog('getContent] [sql: ' . $sql . ']');
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            $row['file_name'] = $path.'/'.$row['file_name']. '.wav';
            $contents[] = $row;
        }
        $response["success"] = 100;

        $response["contents"] = $contents;
        $response["msg"] = "Successfully found contents for this segment type";

    } else {
        $response["msg"] = "No contents found for this segment type";
    }
} else {
    header('Location: ../php/logout.php');
}

echo json_encode($response);
?>
