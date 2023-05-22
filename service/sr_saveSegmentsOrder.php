<?php
require_once('../php/in_common.php');
require_once('../php/in_dbConnection.php');

$userid = $_SESSION['username'];
$role = $_SESSION['role'];

$new_order = isset($_POST['new_order']) ? $_POST['new_order'] : '';

$new_order = explode(",", $new_order);

$response = array("success" => -100);


if (isset($userid) && in_array($role, $admin)) {

    $sql = '';
    foreach ($new_order as $order) {

        $order = explode("_",$order);
        $id = $order[0];
        $new_order = $order[1];

        $sql = "UPDATE menu_segment SET seg_order = $new_order WHERE id = $id";
        $result = '';
        $result = $conn->query($sql);
        doLog('[sr_saveSegmentOrder][sql: ' . $sql . ']');

        if ($result) {

            $response["success"] = 100;
            $response["msg"] = "Segment Order has been successfully updated";

        } else {
            $response["msg"] = "Unable to update Segment Order";
        }
    }
} else {
    header('Location: ../php/logout.php');
}

echo json_encode($response);
?>
