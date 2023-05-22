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
            $sql = "SELECT * FROM subscriber WHERE cellno = '$cellno'";
            $result = $conn->query($sql);
            //doLog('[sr_executeBulkActionUnSub][Checking in Subscriber] [sql: ' . $sql . ']');
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {

                $row_subscriber = $result->fetch_assoc();

                $location = isset($row_subscriber['location']) ? $row_subscriber['location'] : '';
                $state = isset($row_subscriber['state']) ? $row_subscriber['state'] : '';
                $srvc_id = isset($row_subscriber['srvc_id']) ? $row_subscriber['srvc_id'] : '';
                $lang = isset($row_subscriber['lang']) ? $row_subscriber['lang'] : '';
                $sub_name = isset($row_subscriber['sub_name']) ? $row_subscriber['sub_name'] : '';
                $first_sub_dt = strlen($row_subscriber['first_sub_dt']) > 0 ? $row_subscriber['first_sub_dt'] : '';
                $last_sub_dt = isset($row_subscriber['last_sub_dt']) ? $row_subscriber['last_sub_dt'] : '';
                $last_unsub_dt = isset($row_subscriber['last_unsub_dt']) ? $row_subscriber['last_unsub_dt'] : '';
                $sub_mode = isset($row_subscriber['sub_mode']) ? $row_subscriber['sub_mode'] : 'WEB';
                $bc_mode = isset($row_subscriber['bc_mode']) ? $row_subscriber['bc_mode'] : 'BOTH' ;
                $alert_type = isset($row_subscriber['alert_type']) ? $row_subscriber['alert_type'] : 500 ;
                $last_charge_dt = isset($row_subscriber['last_charge_dt']) ? $row_subscriber['last_charge_dt'] : '';
                $status = isset($row_subscriber['status']) ? $row_subscriber['status']: 100;
                $last_call_dt = isset($row_subscriber['last_call_dt']) ? $row_subscriber['last_call_dt'] : '';


                $sql = "SELECT * FROM sub_profile WHERE cellno = '$cellno'";
                $result = $conn->query($sql);
                //doLog('[sr_executeBulkActionUnSub][Checking in Subscriber Unsub] [sql: ' . $sql . ']');
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {

                    $row_sub_profile = $result->fetch_assoc();

                    $gender = isset($row_sub_profile['gender']) ? $row_sub_profile['gender'] : '';
                    $occupation = isset($row_sub_profile['occupation']) ? $row_sub_profile['occupation']: '';
                    $village = isset($row_sub_profile['village']) ? $row_sub_profile['village'] : '';
                    $land_size = isset($row_sub_profile['land_size']) ? $row_sub_profile['land_size'] : '';
                    $land_unit = isset($row_sub_profile['land_unit']) ? $row_sub_profile['land_unit'] : '';
                    $comment = isset($row_sub_profile['comment']) ? $row_sub_profile['comment']: '';
                    $comment = $conn->real_escape_string($comment);
                    $dt = isset($row_sub_profile['dt']) ? $row_sub_profile['dt'] : '';

                    $sql = "SELECT * FROM sub_stats WHERE cellno = '$cellno'";
                    $result = $conn->query($sql);
                    //doLog('[sr_executeBulkActionUnSub][Checking in Subscriber Unsub] [sql: ' . $sql . ']');
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {

                        $row_sub_stats = $result->fetch_assoc();

                        $last_update_dt = isset($row_sub_stats['last_update_dt']) ? $row_sub_stats['last_update_dt'] : '';
                        $last_update_by = isset($row_sub_stats['last_update_by']) ? $row_sub_stats['last_update_by'] : '' ;
                        $mo_call = isset($row['mo_call']) ? $row['mo_call'] : 0;
                        $mt_call = isset($row['mt_call']) ? $row['mt_call'] : 0;
                        $mo_sms = isset($row['mo_sms']) ? $row['mo_sms'] : 0;
                        $mt_sms = isset($row['mt_sms']) ? $row['mt_sms'] : 0;


                        try {
                            $conn->autocommit(FALSE);
                            //$response["msg"] = 'Profile is going to update';

                            $result = '';
                            $unsub_mode = DEFAULT_UNSUB_MODE;
                            $sql = "INSERT INTO `subscriber_unsub` (`cellno`, `location`, `state`, `srvc_id`, `lang`, `sub_name`, `first_sub_dt`, `last_sub_dt`, `last_unsub_dt`, `sub_mode`, `bc_mode`, `alert_type`, `last_charge_dt`, `status`, `last_call_dt`, `last_update_dt`, `last_update_by`, `mo_call` , `mt_call`, `mo_sms`, `mt_sms` , `gender`, `occupation`, `village`, `land_size`, `land_unit`, `comment`, `dt`, `unsub_mode`)
                                VALUES ('$cellno', IF('$location'='',NULL,'$location'), IF('$state'='',NULL,'$state'), IF('$srvc_id'='',NULL,'$srvc_id'), IF('$lang'='',NULL,'$lang'), IF('$sub_name'='',NULL,'$sub_name'), IF('$first_sub_dt'='',NULL,'$first_sub_dt'), IF('$last_sub_dt'='',NULL,'$last_sub_dt'), NOW(), '$sub_mode', '$bc_mode', $alert_type , IF('$last_charge_dt'='',NULL,'$last_charge_dt'), '$status', IF('$last_call_dt'='',NULL,'$last_call_dt'), IF('$last_update_dt'='',NULL,'$last_update_dt'), IF('$last_update_by'='',NULL,'$last_update_by'), $mo_call , $mt_call, $mo_sms, $mt_sms ,
                                IF('$gender'='',NULL,'$gender'), IF('$occupation'='',NULL,'$occupation'), IF('$village'='',NULL,'$village'), IF('$land_size'='',NULL,'$land_size'), IF('$land_unit'='',NULL,'$land_unit'), IF('$comment'='',NULL,'$comment'), IF('$dt'='',NULL,'$dt'), '$unsub_mode')
                                ON DUPLICATE KEY UPDATE location = IF('$location'='',NULL,'$location'), state = IF('$state'='',NULL,'$state'), srvc_id = IF('$srvc_id'='',NULL,'$srvc_id'), lang = IF('$lang'='',NULL,'$lang'), sub_name = IF('$sub_name'='',NULL,'$sub_name'), first_sub_dt = IF('$first_sub_dt'='',NULL,'$first_sub_dt') , last_sub_dt = IF('$last_sub_dt'='',NULL,'$last_sub_dt'), last_unsub_dt = NOW(), sub_mode = '$sub_mode', bc_mode = '$bc_mode', alert_type = $alert_type, last_charge_dt = IF('$last_charge_dt'='',NULL,'$last_charge_dt'), STATUS = $status, last_call_dt = IF('$last_call_dt'='',NULL,'$last_call_dt'), last_update_dt = IF('$last_update_dt'='',NULL,'$last_update_dt'), last_update_by = '$last_update_by', mo_call = $mo_call , mt_call = $mt_call , mo_sms = $mo_sms ,mt_sms = $mt_sms , occupation = IF('$occupation'='',NULL,'$occupation'), village = IF('$village'='',NULL,'$village'), land_size = IF('$land_size'='',NULL,'$land_size'), land_unit = IF('$land_unit'='',NULL,'$land_unit'), `comment` = IF('$comment'='',NULL,'$comment'), dt = NOW() , `unsub_mode` = '$unsub_mode' ";
                            //doLog('[sr_executeBulkActionUnSub][] [INSERT: ' . $userid . '][sql: ' . $sql . ' ]');
                            $result = $conn->query($sql);
                            if ($result === false) {
                                throw new Exception('SQL Error: subscriber ' . $conn->error);
                            }

                            $result = '';
                            $sql = "INSERT INTO `subscriber_unsub_history` (`id`, `cellno`, `location`, `state`, `srvc_id`, `lang`, `sub_name`, `first_sub_dt`, `last_sub_dt`, `last_unsub_dt`, `sub_mode`, `bc_mode`, `alert_type`,  `last_charge_dt`, `status`, `last_call_dt`, `last_update_dt`, `last_update_by`, `mo_call` , `mt_call`, `mo_sms`, `mt_sms`, `gender`, `occupation`, `village`, `land_size`, `land_unit`, `comment`, `dt`, `unsub_mode`) SELECT NULL, `cellno`, `location`, `state`, `srvc_id`, `lang`, `sub_name`, `first_sub_dt`, `last_sub_dt`, `last_unsub_dt`, `sub_mode`, `bc_mode`, `alert_type`, `last_charge_dt`, `status`, `last_call_dt`, `last_update_dt`, `last_update_by`, `mo_call` , `mt_call`, `mo_sms`, `mt_sms`, `gender`, `occupation`, `village`, `land_size`, `land_unit`, `comment`, `dt`, `unsub_mode` FROM subscriber_unsub WHERE cellno = '$cellno'";
                            //doLog('[sr_executeBulkActionUnSub][] [INSERT: subscriber_unsub_history ' . $userid . '][sql: ' . $sql . ' ]');
                            $result = $conn->query($sql);
                            if ($result === false) {
                                throw new Exception('SQL Error: ' . $conn->error);
                            }

                            $result = '';
                            $sql = "DELETE FROM subscriber WHERE cellno = '$cellno'";
                            //doLog('[sr_executeBulkActionUnSub][] [DELETE: subscriber ' . $userid . '][sql: ' . $sql . ' ]');
                            $result = $conn->query($sql);
                            if ($result === false) {
                                throw new Exception('SQL Error: ' . $conn->error);
                            }

                            $result = '';
                            $sql = "DELETE FROM sub_profile WHERE cellno = '$cellno'";
                            //doLog('[sr_executeBulkActionUnSub][] [DELETE: sub_profile ' . $userid . '][sql: ' . $sql . ' ]');
                            $result = $conn->query($sql);
                            if ($result === false) {
                                throw new Exception('SQL Error: ' . $conn->error);
                            }

                            $result = '';
                            $sql = "DELETE FROM sub_stats WHERE cellno = '$cellno'";
                            //doLog('[sr_executeBulkActionUnSub][] [DELETE: sub_stats ' . $userid . '][sql: ' . $sql . ' ]');
                            $result = $conn->query($sql);
                            if ($result === false) {
                                throw new Exception('SQL Error: ' . $conn->error);
                            }

                            $conn->commit();
                            updateStatus($idForUpdate,$conn,100,"Action Performed");
                            $successCount++;
                        } catch (Exception $e) {
                            //$response["msg"] = 'Transaction failed: ' . $e->getMessage();
                            $conn->rollback();
                            updateStatus($idForUpdate,$conn,0,$e->getMessage);
                            $failureCount++;
                            doLog("[sr_executeBulkActionUnSub][Checking in Subscriber] [Exception: Transaction failed: '$e->getMessage()' ]");
                        }
                        $conn->autocommit(TRUE);

                        $result = '';
                        $sql = "INSERT INTO `web_subscriber_details` (`cellno`, `state`, `dt`, `agent_name`, `action_type`) VALUES ('$cellno',IF('$state'='',NULL,'$state'), NOW(), '$userid', 'UN-SUBSCRIBE') ";
                        //doLog('[sr_addSubscriber][] [username: ' . $userid . '][sql: ' . $sql . ' ]');
                        $result = $conn->query($sql);


                    } else {  //if not in sub_stats table
                        updateStatus($idForUpdate,$conn,0,"Not found in sub_stats ");
                        $failureCount++;
                        doLog("[sr_executeBulkActionUnSub][Checking in Subscriber] [Warning: '$cellno' is not in sub_stats ]");
                    }

                } else { //if not in sub_profile table
                    updateStatus($idForUpdate,$conn,0,"Not found in sub_profile ");
                    $failureCount++;
                    doLog("[sr_executeBulkActionUnSub][Checking in Subscriber] [Warning: '$cellno' is not in sub_profile ]");
                }


            } else { // if not in subscriber table
                updateStatus($idForUpdate,$conn,0,"Not Subscriber");
                $failureCount++;
                doLog("[sr_executeBulkActionUnSub][Checking in Subscriber] [Warning: '$cellno' is not a subscriber ]");
            }
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