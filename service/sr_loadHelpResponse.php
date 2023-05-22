<?php
require_once('../php/in_common.php');
require_once('../php/in_dbConnection.php');

$userid = $_SESSION['username'];
$role = $_SESSION['role'];

$param = isset($_GET['param']) && strlen($_GET['param']) > 0 ? $_GET['param'] : 0;
$state  = isset($_GET['state']) ? $_GET['state'] : '';
$off_set = isset($_GET['offset']) ? $_GET['offset'] : 1;


if(!strcmp($state, "kaw")){
    $conn = $ka_conn;
    $state = "state = 'missouri' and";
}else{
    $state='';
}

$st  = isset($_GET['st']) ? $_GET['st'] : '';
$end  = isset($_GET['end']) ? $_GET['end'] : '';

$st = $st . ' 00:00:00';
$end = $end . ' 23:59:59';

$condition = '';

$action_types = array(""=>"","1"=>"Call Connectivity", "2"=>"Navigation Issues","3"=>"Content Issues",  "100"=>"Already Update","110"=>"Channel Change","120"=>"Focus Crop Change","130"=>"Location & Focus Crop Change","140"=>"Location Change","150"=>"Location/Crop/Channel Change","160"=>"Out Of Location");

if($param != 'date'){

    if(strlen($param) == 11){
        $condition = " AND cellno = '$param' ";
    }else{
        $condition = " AND cellno LIKE '%$param%' ";
    }
}else if ($param){
    $condition = " AND response_dt BETWEEN '$st' AND '$end'";
}

$offset = ($off_set - 1) * $page_limit;

$response = array("success" => -100);
$helpRequests = array();

if (isset($userid) && in_array($role, $cro)) {

    //$sql_total = "SELECT COUNT(*) as total FROM subscriber WHERE  `status` > 0 AND `state`='$state' ". $date_check;
/*    $sql_total = "SELECT COUNT(*) as total  FROM help_requests WHERE state = '$state' AND  `status`  = 100  ".$condition." ";*/
    $sql_total = "SELECT COUNT(*) as total  FROM help_requests WHERE ".$state."  `status`  = 100  ".$condition." ";
    doLog('[sr_loadHelpResponse][] [sql_total: ' . $sql_total . ']');
    $result = $conn->query($sql_total);
    $row = $result->fetch_assoc();
    $total_count  = $row['total'];

/*    $sql = "SELECT * FROM help_requests WHERE state = '$state' AND  `status` = 100  ".$condition." ORDER BY response_dt desc LIMIT $offset ,$page_limit ";*/
    $sql = "SELECT * FROM help_requests WHERE ".$state."  `status` = 100  ".$condition." ORDER BY response_dt desc LIMIT $offset ,$page_limit ";
    doLog('[sr_loadHelpResponse.php][sql: ' . $sql . ']');
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $type = $row['problem_type'];

//            if($type == 1){
//                $row['problem_type'] = "Call Connectivity";
//            }else if($type == 2){
//                $row['problem_type'] = "Navigation Issues";
//            }else if($type == 3){
//                $row['problem_type'] = "Content Issues";
//            }
            $row['problem_type'] = $action_types[$type];

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
