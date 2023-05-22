<?php
require_once('../php/in_dbConnection.php');
require_once('../php/in_common.php');

$userid = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$role = $_SESSION['role'];

$response = array("success" => -100);

$cellno = isset($_GET['cellno']) ? $_GET['cellno'] : '';

$state = '';
$location = '';
$srvc_id = '';
$lang = '';

if (isset($userid) && in_array($role, $cro) || in_array($role,$paid_wall_unsub)) {

    if (strlen($cellno) > 0 && strlen($cellno) <= 11) {


        $sql = "SELECT * FROM subscriber WHERE cellno = '$cellno'";
        doLog('[sr_ka_doUnsubscribe][Checking in Subscriber] [sql: ' . $sql . ']');
        $result = $ka_conn->query($sql);

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
            //$has_consented = isset($row_subscriber['has_consented']) ? $row_subscriber['has_consented'] : '';


            $sql = "SELECT * FROM sub_profile WHERE cellno = '$cellno'";

            doLog('[sr_ka_doUnsubscribe][Checking in Subscriber Unsub] [sql: ' . $sql . ']');
            $result = $ka_conn->query($sql);
            if ($result->num_rows > 0) {

                $row_sub_profile = $result->fetch_assoc();

                $gender = isset($row_sub_profile['gender']) ? $row_sub_profile['gender'] : '';
                $occupation = isset($row_sub_profile['occupation']) ? $row_sub_profile['occupation']: '';
                $village = isset($row_sub_profile['village']) ? $row_sub_profile['village'] : '';
                $land_size = isset($row_sub_profile['land_size']) ? $row_sub_profile['land_size'] : '';
                $land_unit = isset($row_sub_profile['land_unit']) ? $row_sub_profile['land_unit'] : '';
                $comment = isset($row_sub_profile['comment']) ? $row_sub_profile['comment']: '';
                $comment = $ka_conn->real_escape_string($comment);
                $dt = isset($row_sub_profile['dt']) ? $row_sub_profile['dt'] : '';

                $cnt_kids_total = isset($row['cnt_kids_total']) ? $row['cnt_kids_total'] : 0;
                $cnt_kids_under18_total = isset($row['cnt_kids_under18_total']) ? $row['cnt_kids_under18_total'] : 0;
                $cnt_kids_over18_total = isset($row['cnt_kids_over18_total']) ? $row['cnt_kids_over18_total'] : 0;
                $cnt_kids_school_going_total = isset($row['cnt_kids_school_going_total']) ? $row['cnt_kids_school_going_total'] : 0;
                $cnt_cows_total = isset($row['cnt_cows_total']) ? $row['cnt_cows_total'] : 0;
                $cnt_goats_total = isset($row['cnt_goats_total']) ? $row['cnt_goats_total'] : 0;
                $cnt_sheep_total = isset($row['cnt_sheep_total']) ? $row['cnt_sheep_total'] : 0;
                $cnt_poultry_total = isset($row['cnt_poultry_total']) ? $row['cnt_poultry_total'] : 0;



                $sql = "SELECT * FROM sub_stats WHERE cellno = '$cellno'";
                doLog('[sr_ka_doUnsubscribe][Checking in Subscriber Unsub] [sql: ' . $sql . ']');
                $result = $ka_conn->query($sql);
                if ($result->num_rows > 0) {

                    $row_sub_stats = $result->fetch_assoc();

                    $last_update_dt = isset($row_sub_stats['last_update_dt']) ? $row_sub_stats['last_update_dt'] : '';
                    $last_update_by = isset($row_sub_stats['last_update_by']) ? $row_sub_stats['last_update_by'] : '' ;
                    //$call_count = $row_sub_stats['call_count'];
//                    $mo_call = $row_sub_stats['mo_call'];
//                    $mt_call = $row_sub_stats['mt_call'];
//                    $mo_sms = $row_sub_stats['mo_sms'];
//                    $mt_sms = $row_sub_stats['mt_sms'];

                    $mo_call = isset($row['mo_call']) ? $row['mo_call'] : 0;
                    $mt_call = isset($row['mt_call']) ? $row['mt_call'] : 0;
                    $mo_sms = isset($row['mo_sms']) ? $row['mo_sms'] : 0;
                    $mt_sms = isset($row['mt_sms']) ? $row['mt_sms'] : 0;


                    try {
                        $ka_conn->autocommit(FALSE);
                        $response["msg"] = 'Profile is going to update';


                        //  IF('$last_update_by'='',NULL,'$last_update_by')

                        $result = '';
                        $unsub_mode='';
                        if(in_array($role,$paid_wall_unsub)){
                            $unsub_mode=DEFAULT_UNSUB_MODE_WEBDOC;
                        }else{
                            $unsub_mode = DEFAULT_UNSUB_MODE;

                        }
                        $sql = "INSERT INTO `subscriber_unsub` (`cellno`, `location`, `state`, `srvc_id`, `lang`, `sub_name`, `first_sub_dt`, `last_sub_dt`, `last_unsub_dt`, `sub_mode`, `bc_mode`, `alert_type`, `last_charge_dt`, `status`, `last_call_dt`, `last_update_dt`, `last_update_by`, `mo_call` , `mt_call`, `mo_sms`, `mt_sms` , `gender`, `occupation`, `village`, `land_size`, `land_unit`, `comment`, `dt`, `unsub_mode`, cnt_kids_total, cnt_kids_under18_total, cnt_kids_over18_total, cnt_kids_school_going_total, cnt_cows_total, cnt_goats_total, cnt_sheep_total, cnt_poultry_total)
                                VALUES ('$cellno', IF('$location'='',NULL,'$location'), IF('$state'='',NULL,'$state'), IF('$srvc_id'='',NULL,'$srvc_id'), IF('$lang'='',NULL,'$lang'), IF('$sub_name'='',NULL,'$sub_name'), IF('$first_sub_dt'='',NULL,'$first_sub_dt'), IF('$last_sub_dt'='',NULL,'$last_sub_dt'), NOW(), '$sub_mode', '$bc_mode', $alert_type , IF('$last_charge_dt'='',NULL,'$last_charge_dt'), '$status', IF('$last_call_dt'='',NULL,'$last_call_dt'), IF('$last_update_dt'='',NULL,'$last_update_dt'), IF('$last_update_by'='',NULL,'$last_update_by'), $mo_call , $mt_call, $mo_sms, $mt_sms ,
                                IF('$gender'='',NULL,'$gender'), IF('$occupation'='',NULL,'$occupation'), IF('$village'='',NULL,'$village'), IF('$land_size'='',NULL,'$land_size'), IF('$land_unit'='',NULL,'$land_unit'), IF('$comment'='',NULL,'$comment'), IF('$dt'='',NULL,'$dt'), '$unsub_mode', $cnt_kids_total, $cnt_kids_under18_total, $cnt_kids_over18_total, $cnt_kids_school_going_total, $cnt_cows_total, $cnt_goats_total, $cnt_sheep_total, $cnt_poultry_total)
                                ON DUPLICATE KEY UPDATE location = IF('$location'='',NULL,'$location'), state = IF('$state'='',NULL,'$state'), srvc_id = IF('$srvc_id'='',NULL,'$srvc_id'), lang = IF('$lang'='',NULL,'$lang'), sub_name = IF('$sub_name'='',NULL,'$sub_name'), first_sub_dt = IF('$first_sub_dt'='',NULL,'$first_sub_dt') , last_sub_dt = IF('$last_sub_dt'='',NULL,'$last_sub_dt'), last_unsub_dt = NOW(), sub_mode = '$sub_mode', bc_mode = '$bc_mode', alert_type = $alert_type, last_charge_dt = IF('$last_charge_dt'='',NULL,'$last_charge_dt'), STATUS = $status, last_call_dt = IF('$last_call_dt'='',NULL,'$last_call_dt'), last_update_dt = IF('$last_update_dt'='',NULL,'$last_update_dt'), last_update_by = '$last_update_by', mo_call = $mo_call , mt_call = $mt_call , mo_sms = $mo_sms ,mt_sms = $mt_sms , occupation = IF('$occupation'='',NULL,'$occupation'), village = IF('$village'='',NULL,'$village'), land_size = IF('$land_size'='',NULL,'$land_size'), land_unit = IF('$land_unit'='',NULL,'$land_unit'), `comment` = IF('$comment'='',NULL,'$comment'), dt = NOW() , `unsub_mode` = '$unsub_mode'";
                        doLog('[sr_ka_doUnsubscribe][] [INSERT: ' . $userid . '][sql: ' . $sql . ' ]');
                        $result = $ka_conn->query($sql);
                        if ($result === false) {
                            throw new Exception('SQL Error: subscriber ' . $ka_conn->error);
                        }

                        $result = '';
                        $sql = "INSERT INTO `subscriber_unsub_history` (`id`, `cellno`, `location`, `state`, `srvc_id`, `lang`, `sub_name`, `first_sub_dt`, `last_sub_dt`, `last_unsub_dt`, `sub_mode`, `bc_mode`, `alert_type`,  `last_charge_dt`, `status`, `last_call_dt`, `last_update_dt`, `last_update_by`, `mo_call` , `mt_call`, `mo_sms`, `mt_sms`, `gender`, `occupation`, `village`, `land_size`, `land_unit`, `comment`, `dt`, `unsub_mode`) SELECT NULL, `cellno`, `location`, `state`, `srvc_id`, `lang`, `sub_name`, `first_sub_dt`, `last_sub_dt`, `last_unsub_dt`, `sub_mode`, `bc_mode`, `alert_type`, `last_charge_dt`, `status`, `last_call_dt`, `last_update_dt`, `last_update_by`, `mo_call` , `mt_call`, `mo_sms`, `mt_sms`, `gender`, `occupation`, `village`, `land_size`, `land_unit`, `comment`, `dt`, `unsub_mode`  FROM subscriber_unsub WHERE cellno = '$cellno'";
                        doLog('[sr_ka_doUnsubscribe][] [INSERT: subscriber_unsub_history ' . $userid . '][sql: ' . $sql . ' ]');
                        $result = $ka_conn->query($sql);
                        if ($result === false) {
                            throw new Exception('SQL Error: ' . $ka_conn->error);
                        }

                        $result = '';
                        $sql = "DELETE FROM subscriber WHERE cellno = '$cellno'";
                        doLog('[sr_ka_doUnsubscribe][] [DELETE: subscriber ' . $userid . '][sql: ' . $sql . ' ]');
                        $result = $ka_conn->query($sql);
                        if ($result === false) {
                            throw new Exception('SQL Error: ' . $ka_conn->error);
                        }

                        $result = '';
                        $sql = "DELETE FROM sub_profile WHERE cellno = '$cellno'";
                        doLog('[sr_ka_doUnsubscribe][] [DELETE: sub_profile ' . $userid . '][sql: ' . $sql . ' ]');
                        $result = $ka_conn->query($sql);
                        if ($result === false) {
                            throw new Exception('SQL Error: ' . $ka_conn->error);
                        }

                        $result = '';
                        $sql = "DELETE FROM sub_stats WHERE cellno = '$cellno'";
                        doLog('[sr_ka_doUnsubscribe][] [DELETE: sub_stats ' . $userid . '][sql: ' . $sql . ' ]');
                        $result = $ka_conn->query($sql);
                        if ($result === false) {
                            throw new Exception('SQL Error: ' . $ka_conn->error);
                        }

                        $ka_conn->commit();
                        $response["msg"] = $cellno . ' has successfully been Un-Subscribe';
                        $response["success"] = 100;

                    } catch (Exception $e) {
                        $response["msg"] = 'Transaction failed: ' . $e->getMessage();
                        $ka_conn->rollback();
                    }
                    $ka_conn->autocommit(TRUE);

                    $result = '';
                    $sql = "INSERT INTO `web_subscriber_details` (`cellno`, `state`, `dt`, `agent_name`, `action_type`) VALUES ('$cellno',IF('$state'='',NULL,'$state'), NOW(), '$userid', 'UN-SUBSCRIBE') ";
                    doLog('[sr_addSubscriber][] [username: ' . $userid . '][sql: ' . $sql . ' ]');
                    $result = $ka_conn->query($sql);



                } else {
                    $response["msg"] = "$cellno is unable to unsub due to internal DB error [sub_stats]";
                    doLog('[sr_ka_doUnsubscribe][Checking in Subscriber] [sql: ' . $response["msg"] . ']');
                }

            } else {
                $response["msg"] = "$cellno is unable to unsub due to internal DB error [sub_profile]";
                doLog('[sr_ka_doUnsubscribe][Checking in Subscriber] [sql: ' . $response["msg"] . ']');
            }


        } else {
            $response["msg"] = "$cellno is not a subscriber press Search button to find";
            doLog('[sr_ka_doUnsubscribe][Checking in Subscriber] [sql: ' . $response["msg"] . ']');
        }
    } else {
        $response["msg"] = "Cellno is not valid";
        doLog('[sr_ka_doUnsubscribe][Checking in Subscriber] [cellno: ' . $cellno . '] is not valid');
    }

} else {
    header('Location: ../php/logout.php');
}

echo json_encode($response);
?>