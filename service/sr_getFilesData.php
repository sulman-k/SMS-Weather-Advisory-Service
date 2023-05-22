<?php
/**
 * Created by PhpStorm.
 * User: irfan
 * Date: 12/14/2017
 * Time: 4:34 PM
 */
require_once('../php/in_dbConnection.php');
require_once('../php/in_common.php');

$userid = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$role = $_SESSION['role'];
if (isset($userid) && in_array($role, $batch_user )) {
    $response = array("success"=>-100);
    $pageno = $_GET['offset'];
    $filename = $_GET['filename'];
    $title = $_GET['title'];
    $st = $_GET['st'];
    $end = $_GET['end'];
    $page_limit =  10;
    $offset = ($pageno - 1) *$page_limit;
    $conditions = "";
    if(!empty($title)){
        $conditions = "title LIKE '%$title%'";
    }
    if(!empty($filename)){
        if(empty($conditions)){
            $conditions = $conditions." file_name LIKE '%$filename%' ";
        }else{
            $conditions =  $conditions." AND file_name LIKE '%$filename%' ";
        }
    }
    if(!empty($st) ){
        if(empty($conditions)){
            $conditions = $conditions."  DATE(dt) BETWEEN '$st' AND '$end' ";
        }else{
            $conditions = $conditions." AND DATE(dt) BETWEEN '$st' AND '$end' ";
        }
    }
    if(!empty($conditions)){
        $conditions = " WHERE " . $conditions;
    }
    $query = "Select id,title,file_name,action,valid_rec_cnt,skipped_rec_cnt,total_rec_cnt,dt FROM ba_uploads  ".$conditions." LIMIT $page_limit OFFSET $offset";
    doLog("[sr_getFilesData][] [sql_total: '$query']");
    $records = mysqli_query($conn,$query);
    $filesData = array();
    if ($records->num_rows > 0) {

        while ($row = $records->fetch_assoc()) {

            $filesData[] = $row;
        }
        $sql_total = "SELECT COUNT(*) as total FROM ba_uploads  ".$conditions;
        doLog("[sr_getFilesData][] [sql_total: '$sql_total']");
        $result = $conn->query($sql_total);
        $row = $result->fetch_assoc();
        $total_count  = $row['total'];
        $response['success'] = 100;
        $response['filesData'] = $filesData;
        $response['totalRecords'] = $total_count;
    }else{
        $response['msg'] = "Record Not Found";
    }
echo json_encode($response);
}else { // login credential invalid
    doLog("[sr_executeBulkAction][Credential Invalid][login credential invalid for user id - '$userid' AND role - '$role']");
    header('Location: ../php/logout.php');
}