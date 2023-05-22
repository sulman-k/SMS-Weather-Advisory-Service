<?php
require_once('../php/in_common.php');
require_once('../php/in_dbConnection.php');

$userid = $_SESSION['username'];
$role = $_SESSION['role'];

$response = array("success" => -100);
$menuBoxData = array();

if (isset($userid) && in_array($role, $admin)) {

    $sql = "SELECT * FROM menu_box ORDER BY id";
    doLog('[sr_loadMenuBox.php][sql: ' . $sql . ']');
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $menu_id = $row['id'];
            $sql = "SELECT * FROM menu_segment where menu_id = $menu_id";
            //doLog('[sr_loadMenuBox.php][menu_segment] [sql: ' . $sql . ']');
            $result1 = $conn->query($sql);

            if($result1->num_rows > 0){
                $row['segment_available'] = true;
            }else{
                $row['segment_available'] = false;
            }

            $menuBoxData[] = $row;
        }
        $response["success"] = 100;
        $response["msg"] = "Successfully found weather";
        $response["menuBoxData"] = $menuBoxData;

    } else {
        $response["msg"] = "No results found for this City";
    }
} else {
    header('Location: ../php/logout.php');
}

echo json_encode($response);
?>
