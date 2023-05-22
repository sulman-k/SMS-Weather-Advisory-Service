<?php
require_once('../php/in_common.php');
require_once('../php/in_dbConnection.php');

$userid = $_SESSION['username'];
$role = $_SESSION['role'];

$param = isset($_GET['param']) && strlen($_GET['param']) > 0 ? $_GET['param'] : 0;
$state  = isset($_GET['state']) ? $_GET['state'] : '';
$off_set = isset($_GET['offset']) ? $_GET['offset'] : 1;

$st  = isset($_GET['st']) ? $_GET['st'] : '';
$end  = isset($_GET['end']) ? $_GET['end'] : '';

$st = $st . ' 00:00:00';
$end = $end . ' 23:59:59';

$condition = '';

if(!strcmp($state, "kr")){
    $conn = $rm_conn;
    $state = 'missouri';
}

if($param != 'date'){

    if(strlen($param) == 11){
        $condition = " AND cellno = '$param' ";
    }else{
        $condition = " AND cellno LIKE '%$param%' ";
    }

}else if ($param){
    $condition = " AND request_dt BETWEEN '$st' AND '$end'";
}

$offset = ($off_set - 1) * $page_limit;

$response = array("success" => -100);
$helpRequests = array();

if (isset($userid) && in_array($role, $cro)) {

    //$sql_total = "SELECT COUNT(*) as total FROM subscriber WHERE  `status` > 0 AND `state`='$state' ". $date_check;
/*    $sql_total = "SELECT COUNT(*) as total  FROM help_requests WHERE state = '$state' AND  status  < 0  ".$condition." ";*/
    $sql_total = "SELECT COUNT(*) as total  FROM help_requests WHERE  status  < 0  ".$condition." ";

    doLog('[sr_loadHelpRequest][] [sql_total: ' . $sql_total . ']');
    $result = $rm_conn->query($sql_total);
    $row = $result->fetch_assoc();
    $total_count  = $row['total'];

    $sql = "SELECT * FROM help_requests WHERE   status < 0  ".$condition." ORDER BY request_dt desc LIMIT $offset ,$page_limit ";
    doLog('[sr_kr_loadHelpRequest.php][sql: ' . $sql . ']');
    $result = $rm_conn->query($sql);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $helpRequests[] = $row;

        }
        $response["success"] = 100;
        $response["msg"] = "Successfully found helpRequests";
        $response["helpRequests"] = $helpRequests;


        $response["total_pages"] = $total_count;
        $response["page_num"] = $off_set;
        $response["sr_offset"] = $offset;
        $response["limit"] = $page_limit;

    } else {
        $response["msg"] = "No results found for help requests";
    }
} else {
    header('Location: ../php/logout.php');
}

echo json_encode($response);
?>
