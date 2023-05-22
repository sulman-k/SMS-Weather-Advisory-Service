<?php
require_once('../php/in_common.php');
require_once('../php/in_dbConnection.php');

$userid = $_SESSION['username'];
$role = $_SESSION['role'];

$id = isset($_GET['id']) ? $_GET['id'] : '';

$response = array("success" => -100);
$menuSegData = array();

if (isset($userid) && in_array($role, $admin)) {

    $sql = "SELECT * FROM menu_segment WHERE menu_id = $id ORDER BY seg_order";
    $result = $conn->query($sql);
    doLog('[sr_getMenuSegments.php][auto_weather] [sql: ' . $sql . ']');
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        //  $i=0;
        while ($row = $result->fetch_assoc()) {

            for($i=1; $i<10; $i++){
                $file_in_db = $row['seg_file_'.$i];
                if(strlen($file_in_db) > 0){
                    $row['seg_file_'.$i] = $menu_path.'/'.$file_in_db.'.wav';
                }
            }
            $menuSegData[] = $row;
        }

        $response["success"] = 100;
        $response["msg"] = "Successfully found Data";
        $response["menuSegData"] = $menuSegData;

    } else {
        $response["msg"] = "No results found for this City";
    }
} else {
    header('Location: ../php/logout.php');
}

echo json_encode($response);
?>
