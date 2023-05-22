<?php
require_once('../php/in_common.php');
require_once('../php/in_dbConnection.php');

$userid = $_SESSION['username'];
$role = $_SESSION['role'];

$id = isset($_POST['menu_del'])? $_POST['menu_del']: '';

$response = array("success" => -100);
$contents = array();
$sql = '';

if (isset($userid) && in_array($role, $admin)) {
    $sql = "DELETE FROM menu_box WHERE id = $id";

    $result = '';
    doLog('delete menu ] [sql: ' . $sql . ']');
    $result = $conn->query($sql);
    doLog('delete content] [mysqli_affected_rows($conn): ' . mysqli_affected_rows($conn) . ']');

    if (mysqli_affected_rows($conn)) {
        $response["success"] = 100;
        $response["msg"] = "Successfully deleted contents";

    } else {
        $response["msg"] = "Something went wrong while deleting";
    }
} else {
    header('Location: ../php/logout.php');
}

echo json_encode($response);
?>
