<?php
require_once('../php/in_common.php');
require_once('../php/in_dbConnection.php');

$userid = $_SESSION['username'];
$role = $_SESSION['role'];

$srvc_id = isset($_GET['srvc_id']) ? $_GET['srvc_id']: '';
$state = isset($_GET['state']) ? $_GET['state'] : '';

$condition = '';
if(strlen($srvc_id) > 0){
    $condition = " AND sd.`srvc_id`='$srvc_id'";
}

$response = array("success" => -100);
$advisory = array();

if (isset($userid) && in_array($role, $ops)) {

    $sql = "SELECT ps.srvc_id, pl.`lang`, ps.`state`
FROM  srvc_def sd
INNER JOIN state_srvc ps
ON sd.`srvc_id`=ps.`srvc_id`
INNER JOIN state_lang pl
ON ps.`state`= pl.`state`
WHERE ps.state = '$state' AND sd.`focusable` > 0 ".$condition."
ORDER BY ps.`srvc_id` DESC";
    doLog('[sr_loadAdvisory.php][sql: ' . $sql . ']');
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $srvc_id = '';
        $srvc_id_old = '';
        while ($row = $result->fetch_assoc()) {


            $srvc_id = $row['srvc_id'];
            if($srvc_id != $srvc_id_old){
                if(isset($languages)){
                    rsort($languages);
                    doLog('[sr_loadAdvisory.php][ADD: ' . $srvc_id_old . ']');
                    $advisory[$srvc_id_old] = $languages;
                }
                $languages = array();
                $languages[]=$row['lang'];
                $srvc_id_old = $srvc_id;
            }else{
                $languages[]=$row['lang'];
                $srvc_id_old = $srvc_id;
            }
        }

        rsort($languages);
        $advisory[$srvc_id_old] = $languages;

        $response["success"] = 100;
        $response["msg"] = "Successfully found advisory";
        $response["advisory"] = $advisory;


    } else {
        $response["msg"] = "No results found";
    }
} else {
    header('Location: ../php/logout.php');
}

echo json_encode($response);
?>
