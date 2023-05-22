<?php
/**
 * Created by PhpStorm.
 * User: mm
 * Date: 1/21/2020
 * Time: 5:40 PM
 */


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
$result=array();
if($param != 'date'){

    if(strlen($param) == 11){
        $date_check = " AND cellno = '$param' ";
    }else{
        $date_check = " AND cellno LIKE '%$param%' ";
    }

}else if ($param){
    $date_check = " AND sub_dt BETWEEN '$st' AND '$end'";
}

$offset = ($off_set - 1) * $page_limit;

$response = array("success" => -100);
$subscribers = array();
$total_count = 0;
if (isset($state) && isset($userid) && in_array($role, $cro) || in_array($role,$paid_wall_unsub)) {


    $sql_total = "SELECT COUNT(*) as total FROM subscriber WHERE  `status` > 0 " . $date_check;
    doLog('[sr_zd_loadSubscribers][] [sql_total: ' . $sql_total . '][dt chck:' . $date_check . ']');
    $result = $zd_conn->query($sql_total);
    $row = $result->fetch_assoc();
    $total_count = $row['total'];

    $sql = "SELECT cellno,sub_dt AS last_sub_dt,status AS sub_status,unsub_dt FROM subscriber  WHERE `status` > 0  $date_check  order by sub_dt desc LIMIT $offset ,$page_limit ";

    doLog('[sr_zd_loadSubscribers][] [sql: ' . $sql . ']');
    $result = $zd_conn->query($sql);
    if ($result->num_rows>0) {

        while ($row = $result->fetch_assoc()) {


            $row['sub_status'] = 'New Subscriber';
            if ($row['last_sub_dt'] > $row['last_sub_dt']) {
                $row['sub_status'] = 'Re Subscriber';
            }

            $subscribers[] = $row;
        }

        $response["success"] = 100;
        $response["total_pages"] = $total_count;
        $response["page_num"] = $off_set;
        $response["sr_offset"] = $offset;
        $response["limit"] = $page_limit;
        $response["msg"] = "Successfully found Data";
        $response["subscribers"] = $subscribers;

    } else {
        $response["msg"] = "No record found for subscriber";
    }

}
else {
    header('Location: ../php/logout.php');
}

echo json_encode($response);
?>
