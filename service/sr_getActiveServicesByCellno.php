<?php
/**
 * Created by PhpStorm.
 * User: mm
 * Date: 6/14/2020
 * Time: 3:21 PM
 */


require_once('../php/in_common.php');
require_once('../php/in_dbConnection.php');

$username=$_SESSION['username'];
$role=$_SESSION['role'];

$myobj=new stdClass();

$cellno=isset($_GET['cellno'])?$_GET['cellno']:'';
$response=array("success"=>-100);
$active_paidwalls=array();
if(isset($username) && in_array($role,$paid_wall_unsub)|| in_array($role,$cro)){

    //$sql="Select * from subscriber where cellno='$cellno' AND `status`>0";
    $sql="SELECT s.*,sc.srvcname,sc.amount FROM subscriber s JOIN service sc ON s.`service_id`=sc.id AND s.`cellno`='$cellno' AND s.`status`>0";
    doLog('[sr_getActiveServiceByCellno][KZ] [sql: ' . $sql . ']');
    $result=$conn->query($sql);
    if($result->num_rows>0){
        $row=$result->fetch_assoc();

        $myobj=new stdClass();
        $myobj->amount=(float)$row['amount'];
        //$myobj->amount=0;

        $myobj->key='kz';
        $myobj->value='watson Zemindar ';
        $active_paidwalls[]=$myobj;
        $response['success']=100;
    }

    //$sql="Select * from subscriber where cellno='$cellno' AND `status`>0";
    $sql="SELECT s.*,sc.srvcname,sc.amount FROM subscriber s JOIN service sc ON s.`service_id`=sc.id AND s.`cellno`='$cellno' AND s.`status`>0";

    doLog('[sr_getActiveServiceByCellno][watson Sehat] [sql: ' . $sql . ']');
    $result=$wdc_conn->query($sql);
    if($result->num_rows>0){
        $row=$result->fetch_assoc();

        $myobj_wdc=new stdClass();
        $myobj_wdc->amount=(float)$row['amount'];
        $myobj_wdc->key='wdc';
        $myobj_wdc->value='watson Sehat';
        $active_paidwalls[]=$myobj_wdc;
        $response['success']=100;

    }

    //$sql="Select * from subscriber where cellno='$cellno' AND `status`>0";
    $sql="SELECT s.*,'watson Aangan' as srvcname, 0 as amount FROM subscriber s where s.`cellno`='$cellno' AND s.`status`>0";

    doLog('[sr_getActiveServiceByCellno][watson Aangan] [sql: ' . $sql . ']');
    $result=$ka_conn->query($sql);
    if($result->num_rows>0){
        $response['success']=100;
        $row=$result->fetch_assoc();

        $myobj_kaw=new stdClass();
        $myobj_kaw->amount=(float)$row['amount'];
        $myobj_kaw->key='kaw';
        $myobj_kaw->value='watson Aangan';
        $active_paidwalls[]=$myobj_kaw;

    }
    //$sql="Select * from subscriber where cellno='$cellno' AND `status`>0";
    $sql="SELECT s.*,sc.srvcname,sc.amount FROM subscriber s JOIN service sc ON s.`service_id`=sc.id AND s.`cellno`='$cellno' AND s.`status`>0";

    doLog('[sr_getActiveServiceByCellno][watson rose] [sql: ' . $sql . ']');
    $result=$km_conn->query($sql);
    if($result->num_rows>0){
        $row=$result->fetch_assoc();

        $myobj_km=new stdClass();
        $myobj_km->amount=(float)$row['amount'];
        $myobj_km->key='kam';
        $myobj_km->value='watson rose';
        $response['success']=100;
        $active_paidwalls[]=$myobj_km;

    }
    //$sql="Select * from subscriber where cellno='$cellno' AND `status`>0";
    $sql="SELECT s.*,sc.srvcname,sc.amount FROM subscriber s JOIN service sc ON s.`service_id`=sc.id AND s.`cellno`='$cellno' AND s.`status`>0";

    doLog('[sr_getActiveServiceByCellno][watson Zindagi] [sql: ' . $sql . ']');
    $result=$kb_conn->query($sql);
    if($result->num_rows>0){
        $row=$result->fetch_assoc();
        $myobj_kb=new stdClass();
        $myobj_kb->amount=(float)$row['amount'];
        $myobj_kb->key='kb';
        $myobj_kb->value='watson Zindagi';
        $response['success']=100;
        $active_paidwalls[]=$myobj_kb;
    }
    //$sql="Select * from subscriber where cellno='$cellno' AND `status`>0";
    $sql="SELECT s.*,sc.srvcname,sc.amount FROM subscriber s JOIN service sc ON s.`service_id`=sc.id AND s.`cellno`='$cellno' AND s.`status`>0";

    doLog('[sr_getActiveServiceByCellno][watson william] [sql: ' . $sql . ']');
    $result=$kk_conn->query($sql);
    if($result->num_rows>0){
        $row=$result->fetch_assoc();

        $myobj_kk=new stdClass();
        $myobj_kk->amount=(float)$row['amount'];
        $myobj_kk->key='kk';
        $myobj_kk->value='watson william';
        $active_paidwalls[]=$myobj_kk;
        $response['success']=100;
    }
    //$sql="Select * from subscriber where cellno='$cellno' AND `status`>0";
    $sql="SELECT s.*,sc.srvcname,sc.amount FROM subscriber s JOIN service sc ON s.`service_id`=sc.id AND s.`cellno`='$cellno' AND s.`status`>0";

    doLog('[sr_getActiveServiceByCellno][watson guard] [sql: ' . $sql . ']');
    $result=$kj_conn->query($sql);
    if($result->num_rows>0){
        $row=$result->fetch_assoc();
        $myobj_kj=new stdClass();
        $myobj_kj->amount=(float)$row['amount'];
        $myobj_kj->key='kj';
        $myobj_kj->value='watson guard';
        $active_paidwalls[]=$myobj_kj;
        $response['success']=100;

    }
    //$sql="Select * from subscriber where cellno='$cellno' AND `status`>0";
    $sql="SELECT s.*,sc.srvcname,sc.amount FROM subscriber s JOIN service sc ON s.`service_id`=sc.id AND s.`cellno`='$cellno' AND s.`status`>0";

    doLog('[sr_getActiveServiceByCellno][watson Radio] [sql: ' . $sql . ']');
    $result=$rm_conn->query($sql);
    if($result->num_rows>0){
        $row=$result->fetch_assoc();

        $myobj_rm=new stdClass();
        $myobj_rm->amount=(float)$row['amount'];
        $myobj_rm->key='rm';
        $myobj_rm->value='watson Radio';
        $active_paidwalls[]=$myobj_rm;
        $response['success']=100;

    }
   // $sql="Select * from subscriber where cellno='$cellno' AND `status`>0";
    $sql="SELECT s.*,sc.srvcname,sc.amount FROM subscriber s JOIN service sc ON s.`service_id`=sc.id AND s.`cellno`='$cellno' AND s.`status`>0";

    doLog('[sr_getActiveServiceByCellno][watson Naama] [sql: ' . $sql . ']');
    $result=$kn_conn->query($sql);
    if($result->num_rows>0){
        $row=$result->fetch_assoc();

        $myobj_kn=new stdClass();
        $myobj_kn->amount=(float)$row['amount'];
        $myobj_kn->key='kn';
        $myobj_kn->value='watson Naama';
        $active_paidwalls[]=$myobj_kn;
        $response['success']=100;

    }

   // $sql="Select * from subscriber where cellno='$cellno' AND `status`>0";
    $sql="SELECT s.*,sc.srvcname,sc.amount FROM subscriber s JOIN service sc ON s.`service_id`=sc.id AND s.`cellno`='$cellno' AND s.`status`>0";

    doLog('[sr_getActiveServiceByCellno][Zarai Directory] [sql: ' . $sql . ']');
    $result=$zd_conn->query($sql);
    if($result->num_rows>0){
        $row=$result->fetch_assoc();
        $myobj_zd=new stdClass();
        $myobj_zd->amount=(float)$row['amount'];
        $myobj_zd->key='zd';
        $myobj_zd->value='Zarai Directory';
        $active_paidwalls[]=$myobj_zd;
        $response['success']=100;

    }

    //$sql="Select * from subscriber where cellno='$cellno' AND `status`>0";
    $sql="SELECT s.*,sc.srvcname,sc.amount FROM subscriber s JOIN service sc ON s.`service_id`=sc.id AND s.`cellno`='$cellno' AND s.`status`>0";

    doLog('[sr_getActiveServiceByCellno][watson Amdani] [sql: ' . $sql . ']');
    $result=$kad_conn->query($sql);
    if($result->num_rows>0){
        $row=$result->fetch_assoc();

        $myobj_kad=new stdClass();
        $myobj_kad->amount=(float)$row['amount'];
        $myobj_kad->key='kad';
        $myobj_kad->value='watson Amdani';
        $active_paidwalls[]=$myobj_kad;
        $response['success']=100;

    }

    $sql="SELECT s.*,sc.srvcname,sc.amount FROM subscriber s JOIN service sc ON s.`service_id`=sc.id AND s.`cellno`='$cellno' AND s.`status`>0";

    doLog('[sr_getActiveServiceByCellno][watson Tahafuz] [sql: ' . $sql . ']');
    $result=$kt_conn->query($sql);
    if($result->num_rows>0){
        $row=$result->fetch_assoc();

        $myobj_kt=new stdClass();
        $myobj_kt->amount=(float)$row['amount'];
        $myobj_kt->key='kt';
        $myobj_kt->value='watson Tahafuz';
        $active_paidwalls[]=$myobj_kt;
        $response['success']=100;

    }



    $response['active_service']=$active_paidwalls;
    $response['msg']='Successfully found record';



}
else {
        header('Location: ../php/logout.php');
}

    echo json_encode($response);

?>
