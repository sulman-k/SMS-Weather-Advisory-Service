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

function getSrvcId($ka_conn, $loc, $prov)
{

    $sql = "SELECT * FROM location WHERE id = '$loc' AND state = '$prov'";
    $result = $ka_conn->query($sql);
    doLog('[sr_ka_addSubscriber][getSrvcId][Checking for default_srvc_id] [sql: ' . $sql . ']');
    $result = $ka_conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $srvc = $row['default_srvc_id'];
    } else {
        $srvc = 'wheat';
    }
    return $srvc;
}


if (isset($userid) && in_array($role, $cro)||  in_array($role,$paid_wall_unsub)) {

    if (strlen($cellno) > 0 && strlen($cellno) == 11 && $cellno[0] == 0) {

        $sql = "SELECT * FROM subscriber WHERE cellno = '$cellno'";
        //$result = $ka_conn->query($sql);
        doLog('[sr_ka_addSubscriber][Checking in Subscriber] [sql: ' . $sql . ']');
        $result = $ka_conn->query($sql);
        if (!$result->num_rows > 0) {

            $sql = "SELECT * FROM subscriber_unsub WHERE cellno = '$cellno'";
            //$result = $ka_conn->query($sql);
            doLog('[sr_ka_addSubscriber][Checking in Subscriber Unsub] [sql: ' . $sql . ']');
            $result = $ka_conn->query($sql);
                if (!$result->num_rows > 0) {

                $fifth_char = substr($cellno, 4, 1);

                $sql = "SELECT * FROM bi_location_$fifth_char WHERE cellno = '$cellno'";
                doLog('[sr_ka_addSubscriber][Checking in bi_location_' . $fifth_char . ' ] [sql: ' . $sql . ']');
                $result = $biConn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();

                    $state = $row['state'];
                    $location = $row['location'];

                    doLog('[sr_ka_addSubscriber][Got result in bi_location_' . $fifth_char . ' now going to match in location] [state: ' . $state . '] [location: ' . $location . ']');

                    $sql = "SELECT IFNULL(l.state,'') AS state, p.default_lang, IFNULL(l.id,'') AS loc, l.default_srvc_id FROM location l INNER JOIN state p ON p.id = l.state WHERE l.id = '$location' AND l.state = '$state'
                            UNION ALL
                            SELECT p.id AS state,p.default_lang, l.id AS loc, l.default_srvc_id FROM location l INNER JOIN state p ON p.id = l.state WHERE p.id = 'missouri' AND l.id = 'unknown' AND NOT EXISTS (SELECT 1  FROM location l INNER JOIN state p ON p.id = l.state WHERE l.id = '$location' AND l.state = '$state')";
                    $result = $ka_conn->query($sql);
                    doLog('[sr_ka_addSubscriber][Checking in location] [sql: ' . $sql . '] ' . $result->num_rows);
                    //$result = $ka_conn->query($sql);
                    if ($result->num_rows > 0) {

                        $row = $result->fetch_assoc();

                        $state = $row['state'];
                        $location = $row['loc'];
                        $srvc_id = $row['default_srvc_id'];
                        $lang = $row['default_lang'];

                        doLog('[sr_ka_addSubscriber][Got result in location ] [state: ' . $state . '] [location: ' . $location . ']');
                    }

                }else{
                    $state = $default_ka_state;
                    $location = $default_ka_location;
                    $lang = $default_ka_lang;
                }

                try {
                    $ka_conn->autocommit(FALSE);
                    $response["msg"] = 'Profile is going to update';

                    $result = '';

                    $sql = "INSERT INTO `sub_profile` (`cellno`,`gender`, `occupation`, `village`, `land_size`, `land_unit`,`comment`,`dt`) VALUES ('$cellno','female', 'Farmer', ' Chak Default', '1', 'Qilla', 'Default', NOW()) ON DUPLICATE KEY UPDATE `dt`= NOW()";
                    doLog('[sr_ka_addSubscriber][] [username: ' . $userid . '][sql: ' . $sql . ' ]');
                    $result = $ka_conn->query($sql);
                    if ($result === false) {
                        throw new Exception('SQL Error: sub_profile ' . $ka_conn->error);
                    }

                    $result = '';
                    $bc_mode = DEFAULT_BC_MODE;
                    $alert_type = DEFAULT_ALERT_TYPE;
                    $subname = DEFAULT_SUB_NAME;
                    $sub_mode = DEFAULT_SUB_MODE;
                    $sql2 = "INSERT INTO `subscriber` (cellno, location, state, srvc_id, lang, sub_name, bc_mode, alert_type, sub_mode, status, last_call_dt, first_sub_dt, last_sub_dt)
                              VALUES ('$cellno', IF('$location'='',NULL,'$location'), IF('$state'='',NULL,'$state'), IF('$srvc_id'='',NULL,'$srvc_id'), IF('$lang'='',NULL,'$lang'), '$subname','$bc_mode', $alert_type, '$sub_mode', 100, NOW(), NOW(), NOW()) ";
                    doLog('[sr_ka_addSubscriber][] [username: ' . $userid . '][sql: ' . $sql2 . ' ]');
                    $result = $ka_conn->query($sql2);
                    if ($result === false) {
                        throw new Exception('SQL Error: subscriber ' . $ka_conn->error);
                    }

                    $result = '';
                    //############################################# NEED TO ASK FROM SAADIQ ############################

                    $sql3 = "INSERT INTO `sub_stats` (`cellno`, `last_update_dt`, `last_update_by`, `mo_call`, `mt_call`, `mo_sms`, `mt_sms`)
                             VALUES ('$cellno', NOW(), '$userid', '0', '0', '0', '0')
                             ON DUPLICATE KEY UPDATE `last_update_dt` = NOW() , `last_update_by` = '$userid' ";
                    doLog('[sr_ka_addSubscriber][] [username: sub_stats ' . $userid . '][sql: ' . $sql3 . ' ]');
                    $result = $ka_conn->query($sql3);
                    if ($result === false) {
                        throw new Exception('SQL Error: ' . $ka_conn->error);
                    }


                    $sql4 = "INSERT INTO `sub_daily_usage_stats` (cellno, dt, sub_dt, mt_calls, state)
                             VALUES ('$cellno', CURDATE(), NOW(), 1, '$state')
                             ON DUPLICATE KEY UPDATE mt_calls = IFNULL(mt_calls, 0) + 1";
                    doLog('[sr_ka_addSubscriber][] [username: sub_stats ' . $userid . '][sql: ' . $sql3 . ' ]');
                    $result = $ka_conn->query($sql4);
                    if ($result === false) {
                        throw new Exception('SQL Error: ' . $ka_conn->error);
                    }

                    $ka_conn->commit();
                    $response["msg"] = $cellno . ' has successfully been subscribe <br> <b>state</b> ' . ucfirst($state) . '<br> <b>Location</b> ' . ucfirst($location);
                    $response["success"] = 100;

                } catch (Exception $e) {
                    $response["msg"] = 'Transaction failed: ' . $e->getMessage();
                    $ka_conn->rollback();
                }
                $ka_conn->autocommit(TRUE);


                $result = '';
                $sql = "INSERT INTO `web_subscriber_details` (`cellno`,`state` ,`dt`, `agent_name`, `action_type`) VALUES ('$cellno', IF('$state'='',NULL,'$state') , NOW(), '$userid', 'SUBSCRIBE');";
                doLog('[sr_ka_addSubscriber][] [username: ' . $userid . '][sql: ' . $sql . ' ]');
                $result = $ka_conn->query($sql);


            } else {

                doLog('[sr_ka_addSubscriber][Found in Sub Unsub fetching info for returnee user ] [sql: ' . $sql . ']');
                $row = $result->fetch_assoc();

                $state = $row['state'];
                $location = $row['location'];
                $srvc_id = isset($row['srvc_id']) ? $row['srvc_id'] : '';
                $lang = $row['lang'];
                $sub_name = $row['sub_name'];
                $first_sub_dt = isset($row['first_sub_dt']) ? $row['first_sub_dt'] : '';
                $last_sub_dt = isset($row['last_sub_dt']) ? $row['last_sub_dt'] : '';
                $last_unsub_dt = isset($row['last_unsub_dt']) ? $row['last_unsub_dt'] : '';

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
                $comment = $ka_conn->real_escape_string($comment);

                $cnt_kids_total = $row['cnt_kids_total'];
                $cnt_kids_under18_total = $row['cnt_kids_under18_total'];
                $cnt_kids_over18_total = $row['cnt_kids_over18_total'];
                $cnt_kids_school_going_total = $row['cnt_kids_school_going_total'];
                $cnt_cows_total = $row['cnt_cows_total'];
                $cnt_goats_total = $row['cnt_goats_total'];
                $cnt_sheep_total = $row['cnt_sheep_total'];
                $cnt_poultry_total = $row['cnt_poultry_total'];

                try {
                    $ka_conn->autocommit(FALSE);

                    $result = '';
                    $sql = "INSERT INTO `sub_profile` (cellno, gender, occupation, village, land_size, land_unit, comment, dt, cnt_kids_total, cnt_kids_under18_total, cnt_kids_over18_total, cnt_kids_school_going_total, cnt_cows_total, cnt_goats_total, cnt_sheep_total, cnt_poultry_total)
                            VALUES ('$cellno', IF('$gender'='',NULL,'$gender'), IF('$occupation'='',NULL,'$occupation'), IF('$village'='',NULL,'$village'), IF('$land_size'='',NULL,'$land_size'), IF('$land_unit'='',NULL,'$land_unit'), IF('$comment'='',NULL,'$comment'), NOW(), $cnt_kids_total, $cnt_kids_under18_total, $cnt_kids_over18_total, $cnt_kids_school_going_total, $cnt_cows_total, $cnt_goats_total, $cnt_sheep_total, $cnt_poultry_total)
                            ON DUPLICATE KEY UPDATE  `dt` = NOW() ";
                    doLog('[sr_ka_addSubscriber][sub_unsub data] [username: ' . $userid . '][sql: ' . $sql . ' ]');
                    $result = $ka_conn->query($sql);
                    if ($result === false) {
                        throw new Exception('SQL Error: sub_profile ' . $ka_conn->error);
                    }

                    $result = '';
                    $bc_mode = DEFAULT_BC_MODE;
                    $alert_type = DEFAULT_ALERT_TYPE;
                    $subname = DEFAULT_SUB_NAME;
                    $sql2 = "INSERT INTO `subscriber` (cellno, location, state, srvc_id, lang, sub_name, sub_mode, bc_mode, alert_type, last_call_dt, status, first_sub_dt, last_sub_dt, last_unsub_dt)
VALUES ('$cellno', IF('$location'='',NULL,'$location'), IF('$state'='',NULL,'$state'), IF('$srvc_id'='',NULL,'$srvc_id'), IF('$lang'='',NULL,'$lang')
, IF('$sub_name'='',NULL,'$sub_name'), '$sub_mode', '$bc_mode',$alert_type, IF('$last_call_dt'='',NULL,'$last_call_dt'), $status,  IF('$first_sub_dt'='',NULL,'$first_sub_dt'), IF('$last_sub_dt'='',NULL,'$last_sub_dt'),  IF('$last_unsub_dt'='',NULL,'$last_unsub_dt')) ";
                    doLog('[sr_ka_addSubscriber][sub_unsub data] [username: ' . $userid . '][sql: ' . $sql2 . ' ]');
                    $result = $ka_conn->query($sql2);
                    if ($result === false) {
                        throw new Exception('SQL Error: subscriber ' . $ka_conn->error);
                    }

                    $result = '';
                    $sql3 = "INSERT INTO `sub_stats` (`cellno`,`last_update_dt`, `last_update_by`, `mo_call` , `mt_call`, `mo_sms`, `mt_sms`)
                             VALUES ('$cellno', NOW(), '$userid', $mo_call , $mt_call, $mo_sms, $mt_sms)
                             ON DUPLICATE KEY UPDATE `last_update_dt` = NOW() , `last_update_by` = '$userid' ";
                    doLog('[sr_ka_addSubscriber][sub_unsub data] [username: sub_stats ' . $userid . '][sql: ' . $sql3 . ' ]');
                    $result = $ka_conn->query($sql3);
                    if ($result === false) {
                        throw new Exception('SQL Error: ' . $ka_conn->error);
                    }

                    $ka_conn->commit();
                    $response["msg"] = $cellno . ' has successfully been subscribe';
                    $response["success"] = 100;

                } catch (Exception $e) {
                    $response["msg"] = 'Transaction failed: ' . $e->getMessage();
                    $ka_conn->rollback();
                }
                $ka_conn->autocommit(TRUE);

                $result = '';
                $sql = "INSERT INTO `web_subscriber_details` (`cellno`, `state`, `dt`, `agent_name`, `action_type`)
VALUES ('$cellno', IF('$state'='',NULL,'$state'), NOW(), '$userid', 'RE-SUBSCRIBE');";
                doLog('[sr_addSubscriber][] [username: ' . $userid . '][sql: ' . $sql . ' ]');
                $result = $ka_conn->query($sql);

            }


        } else {
            $response["msg"] = "$cellno is already a subscriber press Search button to find";
            doLog('[sr_ka_addSubscriber][Checking in Subscriber] [sql: ' . $response["msg"] . ']');
        }
    } else {
        $response["msg"] = "Cellno is not valid";
        doLog('[sr_ka_addSubscriber][Checking in Subscriber] [cellno: ' . $cellno . '] is not valid');
    }

} else {
    header('Location: ../php/logout.php');
}

echo json_encode($response);
?>