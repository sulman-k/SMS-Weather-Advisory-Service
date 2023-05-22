<?php
/**
 * Created by PhpStorm.
 * User: brad
 * Date: 9/1/2020
 * Time: 11:34 AM
 */




require_once('../php/in_dbConnection.php');
require_once('../php/in_common.php');

$userid = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$role = $_SESSION['role'];

$response = array("success" => -100);

$cellno = isset($_GET['cellno']) ? $_GET['cellno'] : '';

$state = '';
/*$location = '';
$srvc_id = '';
$lang = '';*/



if (isset($userid) && in_array($role, $cro) ||  in_array($role,$paid_wall_unsub)) {

    if (strlen($cellno) > 0 && strlen($cellno) <= 11) {

        $response["success"] = -100;
        $url = KT_UNSUBSCRIBE_URL;
        $unsub_mode= DEFAULT_UNSUB_MODE_WEBDOC;


        if(in_array($role,$paid_wall_unsub)){
            $fields = array(
                'cellno' => urlencode($cellno) ,
                "unSubMode" => DEFAULT_UNSUB_MODE_WEBDOC
            );
        }else{
            $fields = array(
                'cellno' => urlencode($cellno) ,
                "unSubMode" => DEFAULT_UNSUB_MODE
            );
        }


        //url-ify the data for the POST
        $fields_string ="";
        foreach($fields as $key=>$value) {
            $fields_string .= $key.'='.$value.'&';
        }
        rtrim($fields_string, '&');

        //open connection
        $ch = curl_init();

        //set the url
        curl_setopt($ch,CURLOPT_URL, $url.$fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        doLog("URL for watson Tahafuz UnSub  - " . $url . $fields_string);

        //execute post
        $result = curl_exec($ch);

        //close connection
        curl_close($ch);
        //echo $result;exit;
        $result = json_decode($result);

        $response["success"] = $result->responseCode;
        $response["msg"] = $result->message;
        doLog("[sr_kt_dounSubscribe][Response Code] - ".$result->responseCode ." - [API Response Message] -".$result->message);


/*
        if(in_array($role,$paid_wall_unsub) && $result->responseCode===100){
            $sql="update subscriber_unsub set unsub_mode ='$unsub_mode'   where cellno = '$cellno'";
            doLog('[sr_kt_doUnsubscribe][Update subscriber] [cellno: ' . $cellno . '][Query]'.$sql);
            $result=$kt_conn->query($sql);
            if($result){
                $sql="UPDATE subscriber_unsub_history SET unsub_mode  = '$unsub_mode' WHERE cellno = '$cellno' ORDER BY unsub_dt DESC LIMIT 1";
                doLog('[sr_kt_doUnsubscribe][Update subscriber_unsub_history] [cellno: ' . $cellno . '][Query]'.$sql);
                $result=$kt_conn->query($sql);
                if($result){
                    $response['success']=100;
                    $response['msg']='Successfully un subscribe from the service';
                }else{
                    $response['success']=-100;
                    $response['msg']='Successfully un subscribe but not update the subscriber unsub history table';

                }

            }else{

                $response['success']=-100;
                $response['msg']='Successfully un subscribe but not update the subscriber unsub table';

            }


        }*/


    } else {
        $response["msg"] = "Cellno is not valid";
        doLog('[sr_kt_doUnsubscribe][Checking in Subscriber] [cellno: ' . $cellno . '] is not valid');
    }

} else {
    header('Location: ../php/logout.php');
}

echo json_encode($response);
?>