<?php
require_once('../php/in_common.php');
require_once('../php/in_dbConnection.php');

$userid = $_SESSION['username'];
$role = $_SESSION['role'];

$off_set = isset($_GET['offset']) ? $_GET['offset'] : 1;
$state = isset($_GET['state']) ? $_GET['state'] : null;
$param = isset($_GET['param']) && strlen($_GET['param']) > 0 ? $_GET['param'] : 0;


$st = isset($_GET['st']) ? $_GET['st'] : '';
$end = isset($_GET['end']) ? $_GET['end'] : '';

$st = $st . ' 00:00:00';
$end = $end . ' 23:59:59';

$date_check = '';
$cellno_check = '';

if($param != 'date'){

    if(strlen($param) == 11){
        $date_check = " AND cellno = '$param' ";
    }else{
        $date_check = " AND cellno LIKE '%$param%' ";
    }

}else if ($param){
    $date_check = " AND last_unsub_dt BETWEEN '$st' AND '$end'";
}

$offset = ($off_set - 1) * $page_limit;

$response = array("success" => -100);
$subscribers = array();
$total_count = 0;
if (isset($state) && isset($userid) && in_array($role, $cro)) {


    //$sql_total = "SELECT COUNT(*) as total FROM subscriber s INNER JOIN sub_profile sp ON s.`cellno`=sp.`cellno` WHERE s.`status` > 0 AND s.`state`='$state' ". $date_check;
    //$sql_total = "SELECT COUNT(*) AS total FROM subscriber_unsub WHERE status > 0 AND state='$state' " . $date_check;

    $sql_total = "SELECT COUNT(*) AS total FROM subscriber_unsub WHERE status > 0  " . $date_check;
    doLog('[sr_loadunSubscribers][] [sql_total: ' . $sql_total . ']');
    $result = $conn->query($sql_total);
    $row = $result->fetch_assoc();
    $total_count = $row['total'];

    //$sql = "SELECT * FROM subscriber s INNER JOIN sub_profile sp ON s.`cellno`=sp.`cellno` WHERE s.`status` > 0 AND s.`state`='$state'  $date_check  LIMIT $offset ,$page_limit";
    $sql = " SELECT cellno,IFNULL(district,'NULL')AS district,IFNULL(state,'NULL')AS state,IFNULL(lang,'NULL')AS lang,IFNULL(sub_name,'Zimindar sahib')AS sub_name,IFNULL(first_sub_dt,'NULL')AS first_sub_dt,IFNULL(last_sub_dt,'NULL')AS last_sub_dt,IFNULL(last_unsub_dt,'NULL')AS last_unsub_dt,IFNULL(sub_mode,'NULL')AS sub_mode,IFNULL(occupation,'NULL')AS occupation,IFNULL(village,'Default Chak')AS village,IFNULL(land_size,'1')AS land_size,IFNULL(land_unit,'QILLA')AS land_unit,IFNULL(unsub_mode,'NULL')AS unsub_mode,IFNULL(alert_type,'NULL')AS alert_type,IFNULL(tehsil,'NULL')AS tehsil,IFNULL(COMMENT,'DEFAULT')AS COMMENT,IFNULL(bc_mode,'N/A')AS bc_mode FROM subscriber_unsub su
WHERE su.cellno NOT IN (SELECT DISTINCT(cellno) FROM subscriber)   $date_check  LIMIT $offset ,$page_limit";
    //$result = $conn->query($sql);
    doLog('[sr_loadunSubscribers][] [sql: ' . $sql . ']');
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            $unsubscriber[] = $row;
        }

        $response["success"] = 100;
        $response["total_pages"] = $total_count;
        $response["page_num"] = $off_set;
        $response["sr_offset"] = $offset;
        $response["limit"] = $page_limit;
        $response["msg"] = "Successfully found Data";
        $response["unsubscriber"] = $unsubscriber;

    } else {
        $response["msg"] = "No record found for Unsubscriber";
    }

}else{
    header('Location: ../php/logout.php');
}


echo json_encode($response);
?>
