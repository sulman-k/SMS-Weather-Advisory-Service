
<?php
/**
 * Created by PhpStorm.
 * User: mm
 * Date: 1/14/2020
 * Time: 3:38 PM
 */

require_once('../php/in_common.php');
require_once('../php/in_dbConnection.php');

$userid = $_SESSION['username'];
$role = $_SESSION['role'];

$off_set = isset($_GET['offset']) ? $_GET['offset'] : 1;
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
        $date_check = " AND `to` = '$param' ";
    }else{
        $date_check = " AND `to` LIKE '%$param%' ";
    }

}else if ($param){
    $date_check = " AND dt BETWEEN '$st' AND '$end'";
}

$offset = ($off_set - 1) * $page_limit;

$response = array("success" => -100);
$sms_details = array();
$total_count = 0;
if ( isset($userid) && in_array($role, $crop)) {


    $sql_total = "SELECT COUNT(*) as total FROM send_sms where status != 'null'" . $date_check;
    doLog('[sr_load_sms][] [sql_total: ' . $sql_total . '][dt chck:' . $date_check . ']');
    $result = $ci_conn->query($sql_total);
    if($result){
        $row = $result->fetch_assoc();
        $total_count = $row['total'];
    }else{
        $response["msg"] = "No record found";
    }
    $sql = "SELECT * from send_sms where status !='null' $date_check  order by id desc LIMIT $offset ,$page_limit ";
        doLog('[sr_load_sms][] [sql: ' . $sql . ']');
        $result1 = $ci_conn->query($sql);
    if ($result1->num_rows > 0) {

            while ($row = $result1->fetch_assoc()) {

                $sms_details[] = $row;
            }

            $response["success"] = 100;
            $response["total_pages"] = $total_count;
            $response["page_num"] = $off_set;
            $response["sr_offset"] = $offset;
            $response["limit"] = $page_limit;
            $response["msg"] = "Successfully found Data";
            $response["sms_details"] = $sms_details;
    } else {
            $response["msg"] = "No record found";
    }

}
else {
    header('Location: ../php/logout.php');
}

echo json_encode($response);
?>
