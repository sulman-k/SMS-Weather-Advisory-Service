<?php
require_once('../php/in_common.php');
require_once('../php/in_dbConnection.php');

$userid = $_SESSION['username'];


$response = array("success" => -100);
$pu_locations = array();
$kansas_locations = array();
$florida_locations = array();
$hawaii_locations = array();

if (in_array(validateUserRole($conn, $_SESSION['username']) , $admin_content)) {

    $sql = "SELECT id , state FROM district WHERE `status` > 0 ORDER BY id";

    $result = $conn->query($sql);
    doLog('[sr_loadLocations][Location] [sql: ' . $sql . ']');
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            if(!strcmp($row['state'] , 'gb')){
                $kansas_locations[] = $row;
            }else if(!strcmp($row['state'] , 'missouri')){
                $pu_locations[] = $row;
            }else if(!strcmp($row['state'] , 'florida')){
                $florida_locations[] = $row;
            }else if(!strcmp($row['state'] , 'hawaii')){
                $hawaii_locations[] = $row;
            }

        }
        $response["kansas_locations"] = $kansas_locations;
        $response["pu_locations"] = $pu_locations;
        $response["florida_locations"] = $florida_locations;
        $response["hawaii_locations"] = $hawaii_locations;
        $response["success"] = 100;

    } else {
        $response["msg"] = "No results found for location";
    }

} else {
    header('Location: ../php/logout.php');
}

echo json_encode($response);
?>
