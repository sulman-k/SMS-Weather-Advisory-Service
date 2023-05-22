<?php
/**
 * Created by PhpStorm.
 * User: irfan
 * Date: 12/13/2017
 * Time: 3:45 PM
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
            $query = "SELECT * FROM subscriber WHERE cellno = '$cellno'";
            //doLog('[sr_executeBulkAction][Checking in Subscriber] [sql: ' . $query . ']');
            $result = mysqli_query($conn,$query);
            if (!$result->num_rows > 0) {
                $query = "SELECT * FROM subscriber_unsub WHERE cellno = '$cellno'";
               // doLog('[sr_executeBulkAction][Checking in Subscriber Unsub] [sql: ' . $query . ']');
                $result = mysqli_query($conn,$query);
                if (!$result->num_rows > 0) {
                    $state = '';
                    $location = '';
                    $srvc_id = "";
                    $lang = "";
                    $fifth_char = substr($cellno, 4, 1);
                    $query = "SELECT * FROM bi_location_$fifth_char WHERE cellno = '$cellno'";
                   // doLog('[sr_executeBulkAction][Checking in bi_location_' . $fifth_char . ' ] [sql: ' . $query . ']');
                    $result = mysqli_query($biConn, $query);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $state = $row['state'];
                        $location = $row['location'];
                        //doLog('[sr_executeBulkAction][Got result in bi_location_' . $fifth_char . ' now going to match in location] [state: ' . $state . '] [location: ' . $location . ']');

                        $sql = "SELECT * FROM location WHERE id = '$location' AND state = '$state'";
                        $result = $conn->query($sql);
                        //doLog('[sr_executeBulkAction][Checking in location] [sql: ' . $sql . '] '. $result->num_rows);
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {

                            $row = $result->fetch_assoc();
                            $srvc_id = $row['default_srvc_id'];
                            $lang = getLangBystate($conn, $state);

                            //doLog('[sr_executeBulkAction][Got result in location ] [state: ' . $state . '] [location: ' . $location . ']');
                        } else {// if not exist in location set default

                            setDefaultValues($state,$location,$srvc_id,$lang,$conn);
                        }
                    } else { // if not exist in bi_location set default
                        setDefaultValues($state,$location,$srvc_id,$lang,$conn);
                    }
                    if(doSubscribe($conn,$userid,$cellno,DEFAULT_GENDER,DEFAULT_OCCUPATION,DEFAULT_VILLAGE ,DEFAULT_LAND_SIZE,DEFAULT_LAND_UNIT,"",
                        $location,$state,$srvc_id,$lang,DEFAULT_SUB_NAME,NULL,NULL,DEFAULT_SUB_MODE,"","",100,
                        "0" , "0", "0", "0",
                        "SUBSCRIBE")){
                        updateStatus($idForUpdate,$conn,100,"Action Performed");
                        $successCount++;
                    }else{
                        updateStatus($idForUpdate,$conn,0,"validation Failed");
                        $failureCount++;
                    }

                }else{ // exist in subscriber_unsub

                    $row = $result->fetch_assoc();

                    $state = $row['state'];
                    $location = $row['location'];
                    $srvc_id = isset($row['srvc_id']) ? $row['srvc_id'] : '';
                    $lang = $row['lang'];
                    $sub_name = $row['sub_name'];
                    $first_sub_dt = isset($row['first_sub_dt']) ? $row['first_sub_dt'] : '';
                    $last_sub_dt = isset($row['last_sub_dt']) ? $row['last_sub_dt'] : '';
                    $last_unsub_dt = isset($row['last_unsub_dt']) ? $row['last_unsub_dt']: '';

                    $sub_mode = $row['sub_mode'];
                    $bc_mode = $row['bc_mode'];
                    $alert_type = $row['alert_type'];
                    $status = $row['status'];
                    $last_charge_dt = $row['last_charge_dt'];
                    $last_call_dt = $row['last_call_dt'];

                    $last_update_dt = $row['last_update_dt'];
                    $mo_call = isset($row['mo_call']) ? $row['mo_call'] : 0;
                    $mt_call = isset($row['mt_call']) ? $row['mt_call'] : 0;
                    $mo_sms = isset($row['mo_sms']) ? $row['mo_sms'] : 0;
                    $mt_sms = isset($row['mt_sms']) ? $row['mt_sms'] : 0;

                    $gender = $row['gender'];
                    $occupation = $row['occupation'];
                    $village = $row['village'];
                    $land_size = $row['land_size'];
                    $land_unit = $row['land_unit'];
                    $comment = $row['comment'];
                    $comment = $conn->real_escape_string($comment);

                    if(doSubscribe($conn,$userid,$cellno,DEFAULT_GENDER,DEFAULT_OCCUPATION,DEFAULT_VILLAGE ,DEFAULT_LAND_SIZE,DEFAULT_LAND_UNIT,$comment,
                        $location,$state,$srvc_id,$lang,$sub_name,$first_sub_dt,$last_unsub_dt,$sub_mode,$last_charge_dt,$last_call_dt,$status,
                        $mo_call , $mt_call, $mo_sms, $mt_sms,
                        "RE-SUBSCRIBE")){
                        updateStatus($idForUpdate,$conn,100,"Action Performed");
                        $successCount++;
                    }else{
                        updateStatus($idForUpdate,$conn,0,"validation Failed");
                        $failureCount++;
                    }
                }

            }else{ // if Alreday Subscriber
                updateStatus($idForUpdate,$conn,0,"Alreday Subscribed");
                $failureCount++;

            }
        } //end of while loop
        $query = "UPDATE ba_uploads SET comments = 'Upload confirmed',status = 100,actions_rec_cnt = '$successCount',skipped_rec_cnt = '$failureCount' WHERE id = '$upload_id' ";
        $rs = mysqli_query($conn,$query);
        $response['success'] = 100;
        $response['validNumbers'] = $records->num_rows;
        $response['successRatio'] = $successCount;
        $response['failureRatio'] = $failureCount;

    }else{ // if record not found in ba_list table
        $response['msg'] = "Record Not Found";
    }

    echo json_encode($response);
}else { // login credential invalid
    doLog("[sr_executeBulkAction][Credential Invalid][login credential invalid for user id - '$userid' AND role - '$role']");
    header('Location: ../php/logout.php');
}
function setDefaultValues(&$state,&$location,&$srvc_id,&$lang,$conn)
{
    $state = "missouri";
    $location = "unknown";
    //doLog('[se_executeBulkAction][setDefaultValues][No result found location now using default values] [state: ' . $state . '] [location: ' . $location . ']');
    $srvc_id = getSrvcId($conn, $location, $state);
    $lang = getLangBystate($conn, $state);
}
function updateStatus($id,$conn,$status,$comment)
{
  $query = "UPDATE ba_lists SET status = '$status',comments = '$comment' ,action='sub'WHERE id = '$id'";
  //doLog("[se_executeBulkAction][UpdateStatus][Query]['$query']");
  if(mysqli_query($conn,$query)){
      //doLog("[se_executeBulkAction][UpdateStatus][Success][Status Updated Successfully for id - '$id']");
  }else{
      doLog("[se_executeBulkAction][UpdateStatus][failure][Status Not Updated for id - '$id']");
  }
}
function getSrvcId($conn, $loc, $prov)
{

    $sql = "SELECT * FROM location WHERE id = '$loc' AND state = '$prov'";
    //doLog('[se_executeBulkAction][getSrvcId][Checking for default_srvc_id] [sql: ' . $sql . ']');
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $srvc = $row['default_srvc_id'];
    } else {
        $srvc = 'wheat';
    }
    return $srvc;
}

function getLangBystate($conn, $prov)
{

    $sql = "SELECT default_lang FROM state WHERE id = '$prov' ";
    //doLog('[se_executeBulkAction][getLangBystate][Checking for default_lang] [sql: ' . $sql . ']');
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lang = $row['default_lang'];
    } else {
        $lang = 'wheat';
    }
    return $lang;
}
function doSubscribe($conn,$userid,$cellno,$gender,$occupation,$village,$land_size,$land_unit,$comment,
                     $location,$state,$srvc_id,$lang,$sub_name,$first_sub_dt,$last_unsub_dt,$sub_mode,$last_charge_dt,$last_call_dt,$status,
                     $mo_call , $mt_call, $mo_sms, $mt_sms,
                     $action_type)
{
    $success = true;
    try {
        $conn->autocommit(FALSE);

        $sql = "INSERT INTO `sub_profile` (`cellno`, `gender`, `occupation`, `village`, `land_size`, `land_unit`, `comment`, `dt`)
                            VALUES ('$cellno', IF('$gender'='',NULL,'$gender'), IF('$occupation'='',NULL,'$occupation'), IF('$village'='',NULL,'$village'), IF('$land_size'='',NULL,'$land_size'), IF('$land_unit'='',NULL,'$land_unit'), IF('$comment'='',NULL,'$comment'), NOW())
                            ON DUPLICATE KEY UPDATE  `dt` = NOW() ";
        //doLog('[se_executeBulkAction][doSubscribe] [username: ' . $userid . '][sql: ' . $sql . ' ]');
        $result = $conn->query($sql);
        if ($result === false) {
            throw new Exception('SQL Error: sub_profile ' . $conn->error);
        }
        $bc_mode = DEFAULT_BC_MODE;
        $alert_type = DEFAULT_ALERT_TYPE;
        $sql2 = "INSERT INTO `subscriber` (`cellno`, `location`, `state`, `srvc_id`, `lang`, `sub_name`, `first_sub_dt`, `last_sub_dt`, `last_unsub_dt`, `sub_mode`, `bc_mode`, `alert_type`, `last_charge_dt`, `status`, `last_call_dt`)
                VALUES ('$cellno', IF('$location'='',NULL,'$location'), IF('$state'='',NULL,'$state'), IF('$srvc_id'='',NULL,'$srvc_id'), IF('$lang'='',NULL,'$lang')
                , IF('$sub_name'='',NULL,'$sub_name'), IF('$first_sub_dt'='',NOW(),'$first_sub_dt'), NOW(), IF('$last_unsub_dt'='',NULL,'$last_unsub_dt'), '$sub_mode', '$bc_mode', $alert_type, IF('$last_charge_dt'='',NULL,'$last_charge_dt')  ,$status, IF('$last_call_dt'='',NULL,'$last_call_dt')) ";
        //doLog('[se_executeBulkAction][doSubscribe][sub_unsub data] [username: ' . $userid . '][sql: ' . $sql2 . ' ]');
        $result = $conn->query($sql2);
        if ($result === false) {
            throw new Exception('SQL Error: subscriber ' . $conn->error);
        }

        $sql3 = "INSERT INTO `sub_stats` (`cellno`,`last_update_dt`, `last_update_by`, `mo_call` , `mt_call`, `mo_sms`, `mt_sms`)
                             VALUES ('$cellno', NOW(), '$userid', $mo_call , $mt_call, $mo_sms, $mt_sms)
                             ON DUPLICATE KEY UPDATE `last_update_dt` = NOW() , `last_update_by` = '$userid' ";
        //doLog('[se_executeBulkAction][doSubscribe][sub_unsub data] [username: sub_stats ' . $userid . '][sql: ' . $sql3 . ' ]');
        $result = $conn->query($sql3);
        if ($result === false) {
            throw new Exception('SQL Error: ' . $conn->error);
        }

        $conn->commit();
        $response["msg"] = $cellno . ' has successfully been subscribe';
        $response["success"] = 100;

    } catch (Exception $e) {
        doLog( "[se_executeBulkAction][doSubscribe][Transaction failed: " . $e->getMessage());
        $conn->rollback();
        $success = false;
    }
    $conn->autocommit(TRUE);

    $sql = "INSERT INTO `web_subscriber_details` (`cellno`, `state`, `dt`, `agent_name`, `action_type`)
            VALUES ('$cellno', IF('$state'='',NULL,'$state'), NOW(), '$userid', $action_type);";
    //doLog('[se_executeBulkAction][doSubscribe] [username: ' . $userid . '][sql: ' . $sql . ' ]');
    $result = $conn->query($sql);
    return $success;
}
