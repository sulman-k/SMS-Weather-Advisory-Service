<?php
/**
 * Created by PhpStorm.
 * User: mm
 * Date: 8/5/2020
 * Time: 3:20 PM
 */


require_once('../php/in_dbConnection.php');
require_once('../php/in_common.php');

$userid = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$role = $_SESSION['role'];

$response = array("success" => -100,"first_charge"=>0);

$cellno = isset($_GET['cellno']) ? $_GET['cellno'] : '';
$service=isset($_GET['service'])?$_GET['service']:'';
$st=isset($_GET['st'])?$_GET['st']:'';
$end=isset($_GET['end'])?$_GET['end']:'';

$st=$st." 00:00:00";
$end=$end." 23:59:59";
$connection='';
$conn_array=array("kz"=>$conn,"wdc"=>$wdc_conn,"kaw"=>$ka_conn,"kam"=>$km_conn,"kb"=>$kb_conn,"kk"=>$kk_conn,"kj"=>$kj_conn,"rm"=>$rm_conn,"zd"=>$zd_conn,"kn"=>$kn_conn,"kad"=>$kad_conn,"kt"=>$kt_conn);

foreach ($conn_array as $k => $v) {
     if($k==$service) {

         $connection = $conn_array[$k];
     }
}

if (isset($userid) && in_array($role,$paid_wall_unsub)) {

    $sql="Select sum(charge_amount) as first_sum from charge_attempts where cellno='$cellno' AND response_dt BETWEEN '$st' and '$end' and  response_code =100";
    doLog('[sr_chargingDetailsByCellno][New Subscription] [sql: ' . $sql . ']');
    $result=$connection->query($sql);
    if($result->num_rows>0){
        $row=$result->fetch_assoc();
        $first_charge=$row['first_sum'];
        doLog('[sr_chargingDetailsByCellno][New Subscription] [firtst_charge: ' . $first_charge . ']');


        $response[ 'first_charge']=(float) $row['first_sum'];

    }
    $sql="Select sum(charge_amount) as second_sum from daily_charge_attempts where cell_no='$cellno' AND response_dt BETWEEN '$st' and '$end' and response_code =100";
    doLog('[sr_chargingDetailsByCellno][Renewal Charged] [sql: ' . $sql . ']');
    $result=$connection->query($sql);
    if($result->num_rows>0){
        $row=$result->fetch_assoc();

        $second_charge=$row['second_sum'];
        doLog('[sr_chargingDetailsByCellno][New Subscription] [firtst_charge: ' . $second_charge . ']');

        $response['second_charge']=(float) $row['second_sum'];


    }
    $response['success'] = 100;




} else {
    header('Location: ../php/logout.php');
}

echo json_encode($response);
?>