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

function getSrvcId($conn, $loc, $prov)
{

    $sql = "SELECT * FROM location WHERE id = '$loc' AND state = '$prov'";
    $result = $conn->query($sql);
    doLog('[sr_addSubscriber][getSrvcId][Checking for default_srvc_id] [sql: ' . $sql . ']');
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
    $result = $conn->query($sql);
    doLog('[sr_addSubscriber][getLangBystate][Checking for default_lang] [sql: ' . $sql . ']');
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lang = $row['default_lang'];
    } else {
        $lang = 'wheat';
    }
    return $lang;
}

if (isset($userid) && in_array($role, $cro)) {

    if (strlen($cellno) > 0 && strlen($cellno) == 11) {


        $sql = "SELECT * FROM subscriber WHERE cellno = '$cellno'";
        $result = $conn->query($sql);
        doLog('[sr_addSubscriber][Checking in Subscriber] [sql: ' . $sql . ']');
        $result = $conn->query($sql);
        if (!$result->num_rows > 0) {

            $sql = "SELECT * FROM subscriber_unsub WHERE cellno = '$cellno'";
            $result = $conn->query($sql);
            doLog('[sr_addSubscriber][Checking in Subscriber Unsub] [sql: ' . $sql . ']');
            $result = $conn->query($sql);
            if (!$result->num_rows > 0) {

                $fifth_char = substr($cellno, 4, 1);

                $sql = "SELECT * FROM bi_location_$fifth_char WHERE cellno = '$cellno'";
                doLog('[sr_addSubscriber][Checking in bi_location_' . $fifth_char . ' ] [sql: ' . $sql . ']');
                $result = $biConn->query($sql);
                if ( $result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $state = $row['state'];
                    $location = $row['location'];
                    doLog('[sr_addSubscriber][Got result in bi_location_' . $fifth_char . ' now going to match in location] [state: ' . $state . '] [location: ' . $location . ']');

                    $sql = "SELECT * FROM location WHERE id = '$location' AND state = '$state'";
                    $result = $conn->query($sql);
                    doLog('[sr_addSubscriber][Checking in location] [sql: ' . $sql . '] '. $result->num_rows);
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {

                        $row = $result->fetch_assoc();
                        $srvc_id = $row['default_srvc_id'];
                        $lang = getLangBystate($conn, $state);

                        doLog('[sr_addSubscriber][Got result in location ] [state: ' . $state . '] [location: ' . $location . ']');
                    } else {
                        $state = 'missouri';
                        $location = 'unknown';
                        doLog('[sr_addSubscriber][No result found location now using default values] [state: ' . $state . '] [location: ' . $location . ']');
                        $srvc_id = getSrvcId($conn, $location, $state);
                        $lang = getLangBystate($conn, $state);
                    }

                } else {
                    $state = 'missouri';
                    $location = 'unknown';
                    doLog('[sr_addSubscriber][No result found in bi_location_' . $fifth_char . ' now using default values] [state: ' . $state . '] [location: ' . $location . ']');
                    $srvc_id = getSrvcId($conn, $location, $state);
                    $lang = getLangBystate($conn, $state);
                }

                $srvc_id = isset($srvc_id) ? $srvc_id : '';
                $$lang = isset($lang) ? $lang : '';

                try {
                    $conn->autocommit(FALSE);
                    $response["msg"] = 'Profile is going to update';

                    $result = '';

                    $sql = "INSERT INTO `sub_profile` (`cellno`,`gender`, `occupation`, `village`, `land_size`, `land_unit`,`dt`) VALUES ('$cellno','".DEFAULT_GENDER."','".DEFAULT_OCCUPATION."','".DEFAULT_VILLAGE ."','".DEFAULT_LAND_SIZE."','".DEFAULT_LAND_UNIT."', NOW()) ON DUPLICATE KEY UPDATE `dt`= NOW()";
                    doLog('[sr_addSubscriber][] [username: ' . $userid . '][sql: ' . $sql . ' ]');
                    $result = $conn->query($sql);
                    if ($result === false) {
                        throw new Exception('SQL Error: sub_profile ' . $conn->error);
                    }

                    $result = '';
                    $bc_mode = DEFAULT_BC_MODE;
                    $alert_type = DEFAULT_ALERT_TYPE;
                    $subname = DEFAULT_SUB_NAME;
                    $sql2 = "INSERT INTO `subscriber` (`cellno`, `location`, `state`, `srvc_id`, `lang`, `sub_name`, `first_sub_dt`, `last_sub_dt`, `sub_mode`, `bc_mode`, `alert_type`,  `status`)
                              VALUES ('$cellno', IF('$location'='',NULL,'$location'), IF('$state'='',NULL,'$state'), IF('$srvc_id'='',NULL,'$srvc_id'), IF('$lang'='',NULL,'$lang'), '$subname', NOW(), NOW(), 'WEB', '$bc_mode', $alert_type, 100) ";
                    doLog('[sr_addSubscriber][] [username: ' . $userid . '][sql: ' . $sql2 . ' ]');
                    $result = $conn->query($sql2);
                    if ($result === false) {
                        throw new Exception('SQL Error: subscriber ' . $conn->error);
                    }

                    $result = '';
                    //$sql3 = "INSERT INTO `sub_stats` (`cellno`,`last_update_dt`, `last_update_by`, `call_count`) VALUES ('$cellno', NOW(), '$userid', 0)";
                    $sql3 = "INSERT INTO `sub_stats` (`cellno`, `last_update_dt`, `last_update_by`, `mo_call`, `mt_call`, `mo_sms`, `mt_sms`)
                             VALUES ('$cellno', NOW(), '$userid', '0', '0', '0', '0')
                             ON DUPLICATE KEY UPDATE `last_update_dt` = NOW() , `last_update_by` = '$userid' ";
                    doLog('[sr_addSubscriber][] [username: sub_stats ' . $userid . '][sql: ' . $sql3 . ' ]');
                    $result = $conn->query($sql3);
                    if ($result === false) {
                        throw new Exception('SQL Error: ' . $conn->error);
                    }

                    $conn->commit();
                    $response["msg"] = $cellno . ' has successfully been subscribe <br> <b>state</b> '.  ucfirst($state) . '<br> <b>Location</b> '.ucfirst($location);
                    $response["success"] = 100;

                } catch (Exception $e) {
                    $response["msg"] = 'Transaction failed: ' . $e->getMessage();
                    $conn->rollback();
                }
                $conn->autocommit(TRUE);


                $result = '';
                $sql = "INSERT INTO `web_subscriber_details` (`cellno`,`state` ,`dt`, `agent_name`, `action_type`) VALUES ('$cellno', IF('$state'='',NULL,'$state') , NOW(), '$userid', 'SUBSCRIBE');";
                doLog('[sr_addSubscriber][] [username: ' . $userid . '][sql: ' . $sql . ' ]');
                $result = $conn->query($sql);
                //-------------------get subscriber-------------------------------

                $sql = "SELECT * FROM subscriber  WHERE `status` > 0 AND `state`='$state'AND cellno = '$cellno'";
                $result = $conn->query($sql);
                doLog('[sr_loadSubscribers][] [sql: ' . $sql . ']');
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {

                    while ($row = $result->fetch_assoc()) {

                        $row['sub_status'] = 'New Subscriber';
                        if ($row['last_sub_dt'] > $row['first_sub_dt']) {
                            $row['sub_status'] = 'Re Subscriber';
                        }

                        $response['subscriber'] = $row;
                    }
                }


            } else {

                doLog('[sr_addSubscriber][Found in Sub Unsub fetching info for returnee user ] [sql: ' . $sql . ']');
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


                try {
                    $conn->autocommit(FALSE);

                    $result = '';
                    $sql = "INSERT INTO `sub_profile` (`cellno`, `gender`, `occupation`, `village`, `land_size`, `land_unit`, `comment`, `dt`)
                            VALUES ('$cellno', IF('$gender'='',NULL,'$gender'), IF('$occupation'='',NULL,'$occupation'), IF('$village'='',NULL,'$village'), IF('$land_size'='',NULL,'$land_size'), IF('$land_unit'='',NULL,'$land_unit'), IF('$comment'='',NULL,'$comment'), NOW())
                            ON DUPLICATE KEY UPDATE  `dt` = NOW() ";
                    doLog('[sr_addSubscriber][sub_unsub data] [username: ' . $userid . '][sql: ' . $sql . ' ]');
                    $result = $conn->query($sql);
                    if ($result === false) {
                        throw new Exception('SQL Error: sub_profile ' . $conn->error);
                    }

                    //  IF('$last_unsub_dt'='',NULL,'$last_unsub_dt')

                    $result = '';
                    $bc_mode = DEFAULT_BC_MODE;
                    $alert_type = DEFAULT_ALERT_TYPE;
                    $subname = DEFAULT_SUB_NAME;
                    $sql2 = "INSERT INTO `subscriber` (`cellno`, `location`, `state`, `srvc_id`, `lang`, `sub_name`, `first_sub_dt`, `last_sub_dt`, `last_unsub_dt`, `sub_mode`, `bc_mode`, `alert_type`, `last_charge_dt`, `status`, `last_call_dt`)
VALUES ('$cellno', IF('$location'='',NULL,'$location'), IF('$state'='',NULL,'$state'), IF('$srvc_id'='',NULL,'$srvc_id'), IF('$lang'='',NULL,'$lang')
, IF('$sub_name'='',NULL,'$sub_name'), IF('$first_sub_dt'='',NULL,'$first_sub_dt'), NOW(), IF('$last_unsub_dt'='',NULL,'$last_unsub_dt'), '$sub_mode', '$bc_mode', $alert_type, IF('$last_charge_dt'='',NULL,'$last_charge_dt')  ,$status, IF('$last_call_dt'='',NULL,'$last_call_dt')) ";
                    doLog('[sr_addSubscriber][sub_unsub data] [username: ' . $userid . '][sql: ' . $sql2 . ' ]');
                    $result = $conn->query($sql2);
                    if ($result === false) {
                        throw new Exception('SQL Error: subscriber ' . $conn->error);
                    }

                    $result = '';
                    $sql3 = "INSERT INTO `sub_stats` (`cellno`,`last_update_dt`, `last_update_by`, `mo_call` , `mt_call`, `mo_sms`, `mt_sms`)
                             VALUES ('$cellno', NOW(), '$userid', $mo_call , $mt_call, $mo_sms, $mt_sms)
                             ON DUPLICATE KEY UPDATE `last_update_dt` = NOW() , `last_update_by` = '$userid' ";
                    doLog('[sr_addSubscriber][sub_unsub data] [username: sub_stats ' . $userid . '][sql: ' . $sql3 . ' ]');
                    $result = $conn->query($sql3);
                    if ($result === false) {
                        throw new Exception('SQL Error: ' . $conn->error);
                    }

                    $conn->commit();
                    $response["msg"] = $cellno . ' has successfully been subscribe';
                    $response["success"] = 100;

                } catch (Exception $e) {
                    $response["msg"] = 'Transaction failed: ' . $e->getMessage();
                    $conn->rollback();
                }
                $conn->autocommit(TRUE);

                $result = '';
                $sql = "INSERT INTO `web_subscriber_details` (`cellno`, `state`, `dt`, `agent_name`, `action_type`)
                        VALUES ('$cellno', IF('$state'='',NULL,'$state'), NOW(), '$userid', 'RE-SUBSCRIBE');";
                doLog('[sr_addSubscriber][] [username: ' . $userid . '][sql: ' . $sql . ' ]');
                $result = $conn->query($sql);
                //-------------------get subscriber-------------------------------

                $sql = "SELECT * FROM subscriber  WHERE `status` > 0 AND `state`='$state'AND cellno = '$cellno'";
                $result = $conn->query($sql);
                doLog('[sr_loadSubscribers][] [sql: ' . $sql . ']');
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {

                    while ($row = $result->fetch_assoc()) {

                        $row['sub_status'] = 'New Subscriber';
                        if ($row['last_sub_dt'] > $row['first_sub_dt']) {
                            $row['sub_status'] = 'Re Subscriber';
                        }

                        $response['subscriber'] = $row;
                    }
                }


            }


        } else {
            $response["msg"] = "$cellno is already a subscriber press Search button to find";
            doLog('[sr_addSubscriber][Checking in Subscriber] [sql: ' . $response["msg"] . ']');
        }
    } else {
        $response["msg"] = "Cellno is not valid";
        doLog('[sr_addSubscriber][Checking in Subscriber] [cellno: ' . $cellno . '] is not valid');
    }

} else {
    header('Location: ../php/logout.php');
}

echo json_encode($response);
?>