<?php
/**
 * Created by PhpStorm.
 * User: irfan
 * Date: 12/14/2017
 * Time: 2:30 PM
 */
require_once('../php/in_dbConnection.php');
require_once('../php/in_common.php');

$userid = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$role = $_SESSION['role'];
if (isset($userid) && in_array($role, $batch_user )) {
    $upload_id = $_POST['upload_id'];
    $response = array("success"=>-100);
    $query = "Select id,cellno  FROM ba_lists WHERE upload_id = '$upload_id' AND status = -100";
    $records = mysqli_query($conn,$query);
    if($records->num_rows > 0){
        $successCount = 0;
        $failureCount = 0;
        while ($row = $records->fetch_assoc()){
            $cellno = $row['cellno'];
            $idForUpdate = $row['id'];

            $url = UNSUBCRIBE_URL;
            $fields = array(
                'cellno' => urlencode($cellno) ,
                "unSubMode" => DEFAULT_UNSUB_MODE
            );
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

            //execute post
            $result = curl_exec($ch);
            //close connection
            curl_close($ch);
            //echo $result;exit;
            $result = json_decode($result);
            $response["success"] = $result->responseCode;
            $response["msg"] = $result->message;
            doLog("[sr_executeBulkActionUnSub][Response Code] - ".$result->responseCode ." - [API Response Message] -".$result->message);
            if($result->responseCode == 100){
                updateStatus($idForUpdate,$conn,100,$result->message);
                $successCount++;
            }else{
                updateStatus($idForUpdate,$conn,0,$result->message);
                $failureCount++;
                doLog("[sr_executeBulkActionUnSub][Checking in Subscriber] [Warning: '$cellno' . '--'.$result->message ]");
            }


            $result = '';
            $sql = "INSERT INTO `web_subscriber_details` (`cellno`, `state`, `dt`, `agent_name`, `action_type`) VALUES ('$cellno',IF('$state'='',NULL,'$state'), NOW(), '$userid', 'UN-SUBSCRIBE') ";
            //doLog('[sr_addSubscriber][] [username: ' . $userid . '][sql: ' . $sql . ' ]');
            $result = $conn->query($sql);

        } //end of while loop
        $query = "UPDATE ba_uploads SET comments = 'Upload confirmed',status = 100,actions_rec_cnt = '$successCount',skipped_rec_cnt = '$failureCount' WHERE id = '$upload_id' ";
        $rs = mysqli_query($conn,$query);
        $response['success'] = 100;
        $response["msg"] = 'Transaction Successful';
        $response['validNumbers'] = $records->num_rows;
        $response['successRatio'] = $successCount;
        $response['failureRatio'] = $failureCount;

    }else{ // if record not found in ba_lists table
        $response['msg'] = "Record Not Found";
    }

    echo json_encode($response);
}else { // login credential invalid
    doLog("[sr_executeBulkActionUnSub][Credential Invalid][login credential invalid for user id - '$userid' AND role - '$role']");
    header('Location: ../php/logout.php');
}

function updateStatus($id,$conn,$status,$comment)
{
    $query = "UPDATE ba_lists SET status = '$status',comments = '$comment',action = 'unsub' WHERE id = '$id'";
    //doLog("[sr_executeBulkActionUnSub][UpdateStatus][Query]['$query']");
    if(mysqli_query($conn,$query)){
        //doLog("[sr_executeBulkActionUnSub][UpdateStatus][Success][Status Updated Successfully for id - '$id']");
    }else{
        doLog("[sr_executeBulkActionUnSub][UpdateStatus][failure][Status Not Updated for id - '$id']");
    }
}