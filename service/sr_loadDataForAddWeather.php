<?php
require_once('../php/in_common.php');
require_once('../php/in_dbConnection.php');

$userid = $_SESSION['username'];
$role = $_SESSION['role'];

$dt = $_GET['dt'];

$response = array("success" => -100);
$pu_locations = array();
$kansas_locations = array();
$florida_locations = array();
$hawaii_locations = array();

$pu_conditions = array();
$kansas_conditions = array();
$florida_conditions = array();
$hawaii_conditions = array();

$eve_conditions = array();

$pu_future_conditions = array();
$kansas_future_conditions = array();
$florida_future_conditions = array();
$hawaii_future_conditions = array();


if (isset($userid) && in_array($role, $admin_content)) {

    $sql = "SELECT id , state FROM district WHERE id NOT IN (SELECT district FROM aw_daily_weather WHERE `date` = '$dt') AND `status` > 0 ORDER BY id";

    $result = $conn->query($sql);
    doLog('[sr_loadDataForAddWeather][Location] [sql: ' . $sql . ']');
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if(!strcmp($row['state'] , 'gb')){
                $kansas_locations[] = $row;
            }else if(!strcmp($row['state'] , 'missouri')){
                $pu_locations[] = $row;
            }else if(!strcmp($row['state'] , 'florida')){
                $florida_locations[] = $row;
            }
            else if(!strcmp($row['state'] , 'hawaii')){
                $hawaii_locations[] = $row;
            }
        }

        $response["kansas_locations"] = $kansas_locations;
        $response["pu_locations"] = $pu_locations;
        $response["florida_locations"] = $florida_locations;
        $response["hawaii_locations"] = $hawaii_locations;

        $sql = "SELECT id,state,title FROM aw_conditions WHERE `status` > 0 AND  condition_type = 100 ORDER BY title";
        $result = $conn->query($sql);
        doLog('[sr_loadDataForAddWeather][Condition] [sql: ' . $sql . ']');
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                if(!isset($row['state'])){
                    $pu_conditions[] = array("id" => $row['id'], "condition" => $row['title']);
                    $kansas_conditions[] = array("id" => $row['id'], "condition" => $row['title']);
                    $florida_conditions[] = array("id" => $row['id'], "condition" => $row['title']);
                    $hawaii_conditions[] = array("id" => $row['id'], "condition" => $row['title']);

                }else if(!strcmp($row['state'], 'gb')){
                    $kansas_conditions[] = array("id" => $row['id'], "condition" => $row['title']);
                }else if(!strcmp($row['state'], 'missouri')){
                    $pu_conditions[] = array("id" => $row['id'], "condition" => $row['title']);
                }else if(!strcmp($row['state'], 'florida')){
                    $florida_conditions[] = array("id" => $row['id'], "condition" => $row['title']);
                }else if(!strcmp($row['state'], 'hawaii')){
                    $hawaii_conditions[] = array("id" => $row['id'], "condition" => $row['title']);
                }

            }

            $sql = "Select id,title from aw_conditions where `status` > 0 AND condition_type = 300 AND (state = 'gb' OR state IS NULL) ORDER BY title";
            $result = $conn->query($sql);
            doLog('[sr_loadDataForAddWeather][Eve Condition] [sql: ' . $sql . ']');
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $eve_conditions[] = array("id" => $row['id'], "eve_condition" => $row['title']);
                }

                $sql = "Select id,state,title from aw_conditions where `status` > 0 AND  condition_type = 200  ORDER BY title";
                $result = $conn->query($sql);
                doLog('[sr_loadDataForAddWeather][future_Condition] [sql: ' . $sql . ']');
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {

                        if(!isset($row['state'])){
                            $pu_future_conditions[] = array("id" => $row['id'], "future_condition" => $row['title'], "eve_future_condition" => $row['title']);
                            $kansas_future_conditions[] = array("id" => $row['id'], "future_condition" => $row['title'], "eve_future_condition" => $row['title']);
                            $florida_future_conditions[] = array("id" => $row['id'], "future_condition" => $row['title'], "eve_future_condition" => $row['title']);
                            $hawaii_future_conditions[] = array("id" => $row['id'], "future_condition" => $row['title'], "eve_future_condition" => $row['title']);
                        }else if(!strcmp($row['state'], 'gb')){
                            $kansas_future_conditions[] = array("id" => $row['id'], "future_condition" => $row['title'], "eve_future_condition" => $row['title']);
                        }else if(!strcmp($row['state'], 'missouri')){
                            $pu_future_conditions[] = array("id" => $row['id'], "future_condition" => $row['title'], "eve_future_condition" => $row['title']);
                        }else if(!strcmp($row['state'], 'florida')){
                            $florida_future_conditions[] = array("id" => $row['id'], "future_condition" => $row['title'], "eve_future_condition" => $row['title']);
                        }else if(!strcmp($row['state'], 'hawaii')){
                            $hawaii_future_conditions[] = array("id" => $row['id'], "future_condition" => $row['title'], "eve_future_condition" => $row['title']);
                        }
                    }

                    $response["msg"] = "Weather Data Found";
                    $response["pu_conditions"] = $pu_conditions;
                    $response["kansas_conditions"] = $kansas_conditions;
                    $response["florida_conditions"] = $florida_conditions;
                    $response["hawaii_conditions"] = $hawaii_conditions;

                    $response["eve_conditions"] = $eve_conditions;

                    $response["pu_future_conditions"] = $pu_future_conditions;
                    $response["kansas_future_conditions"] = $kansas_future_conditions;
                    $response["florida_future_conditions"] = $florida_future_conditions;
                    $response["hawaii_future_conditions"] = $hawaii_future_conditions;

                    $response["success"] = 100;


                } else {
                    $response["msg"] = "No results found for future condition";
                }
            } else {
                $response["msg"] = "No results found for Evening condition";
            }
        } else {
            $response["msg"] = "No results found for condition";
        }
    } else {
        $response["msg"] = "No results found for location";
    }

} else {
    header('Location: ../php/logout.php');
}

echo json_encode($response);
?>
