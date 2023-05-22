<?php
/**
 * Created by PhpStorm.
 * User: brad
 * Date: 7/12/2019
 * Time: 2:32 PM
 */
require_once('../php/in_dbConnection.php');
require_once('../php/in_common.php');

$userid = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$role = $_SESSION['role'];
if (isset($userid) && in_array($role, $batch_user )) {
    $upload_id = $_POST['upload_id'];
    $tbl_name=$_POST['tbl_name'];
    $response = array("success"=>-100);

    $sql = "SELECT sb.cellno FROM subscriber AS sb JOIN $tbl_name ON sb.`cellno`=$tbl_name.cellno WHERE  DATE(last_call_dt) >= DATE(NOW()) - INTERVAL 30 DAY";
    doLog("[sr_deleteActiveSubscriber][Select active subscriber][ '$sql' ]");
    $num='';
    $result = mysqli_query($conn, $sql);
    if($result) {
        while ($row = $result->fetch_assoc()) {
            $num = $row;
        }
        foreach ($num as $num) {
            $query = "delete from $tbl_name where cellno='$num'";
            doLog("[sr_deleteActiveSubscriber][delete Active Subscriber from list ][ '$query' ]");
            $result = mysqli_query($conn, $query);

        }
        $response['success']=100;
        $response['msg']='Active Subscriber are Successfully deleted ';
        }else{
        $response['msg']='No Active Subscriber is found';
    }
} else { // login credential invalid
    doLog("[sr_deleteActiveSubscriber][Credential Invalid][login credential invalid for user id - '$userid' AND role - '$role']");
    header('Location: ../php/logout.php');
}
echo json_encode($response);
?>