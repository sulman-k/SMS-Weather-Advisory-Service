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
$unsubscribers=array();
$date_check = '';
$cellno_check = '';
$result=array();
if($param != 'date'){

    if(strlen($param) == 11){
        $date_check = " AND cellno = '$param' ";
    }else{
        $date_check = " AND cellno LIKE '%$param%' ";
    }

}else if ($param){
    $date_check = " AND unsub_dt BETWEEN '$st' AND '$end'";
}

$offset = ($off_set - 1) * $page_limit;

$response = array("success" => -100);
$subscribers = array();
$total_count = 0;
if (isset($state) && isset($userid) && in_array($role, $cro))

{
    $sql_total = "SELECT COUNT(*) as total FROM subscriber_unsub WHERE  `status` > 0 " . $date_check;
    doLog('[sr_kb_loadUnSubscribers][] [sql_total: ' . $sql_total . '][dt chck:' . $date_check . ']');
    $result = $kb_conn->query($sql_total);
    $row = $result->fetch_assoc();
    $total_count = $row['total'];

    $sql = "SELECT cellno,IFNULL(sub_dt,'N/A')AS sub_dt,IFNULL(unsub_dt,'N/A')AS last_unsub_dt,IFNULL(sub_mode,'N/A')AS sub_mode,IFNULL(unsub_mode,'N/A')AS unsub_mode,IFNULL(charge_attempt_dt,'N/A')AS charge_attempt_dt,IFNULL(last_charge_dt,'N/A')AS last_charge_dt,IFNULL(next_charge_dt,'N/A')AS next_charge_dt,IFNULL(grace_expire_dt,'N/A')AS grace_expire_dt FROM subscriber_unsub su WHERE su.cellno NOT IN (SELECT DISTINCT(cellno) FROM subscriber) AND`status` > 0  $date_check  order by sub_dt desc LIMIT $offset ,$page_limit ";

    doLog('[sr_kb_loadUnSubscribers][] [sql: ' . $sql . ']');
    $result = $kb_conn->query($sql);
    if ($result->num_rows>0) {

        while ($row = $result->fetch_assoc()) {


            $unsubscribers[] = $row;
        }

        $response["success"] = 100;
        $response["total_pages"] = $total_count;
        $response["page_num"] = $off_set;
        $response["sr_offset"] = $offset;
        $response["limit"] = $page_limit;
        $response["msg"] = "Successfully found Data";
        $response["unsubscriber"] = $unsubscribers;
    }



    else {
        $response["msg"] = "No record found for K_Bima  Unsubscriber";
    }

}

else {
    header('Location: ../php/logout.php');
}

echo json_encode($response);
?>