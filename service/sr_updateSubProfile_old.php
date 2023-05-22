<?php
require_once('../php/in_dbConnection.php');
require_once('../php/in_common.php');

$userid = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$role = $_SESSION['role'];

$response = array("success" => -100);

$cellno = isset($_POST['cellno']) ? $_POST['cellno'] : '';
$name = isset($_POST['name']) ? $_POST['name'] : '';
$occupation  = isset($_POST['occupation'])? $_POST['occupation'] : '';
$lang = isset($_POST['lang']) ? $_POST['lang'] : '';
$state = isset($_POST['state']) ? $_POST['state'] : '';
$location  = isset($_POST['location'])&& $_POST['location'] != '' ? $_POST['location'] : 'unknown';
$village  = isset($_POST['village'])? $_POST['village'] : '';
$srvc_id = isset($_POST['srvc']) ? $_POST['srvc'] : '';
$land = isset($_POST['land']) ? $_POST['land'] : '';
$land_unit  = isset($_POST['land_unit'])? $_POST['land_unit'] : '';
$alerts_type = isset($_POST['alerts_type']) && $_POST['alerts_type'] != '' ? $_POST['alerts_type'] : 500;
$channel = isset($_POST['channel']) ? $_POST['channel'] : '';
$comment  = isset($_POST['comment'])? $_POST['comment'] : '';
$problem_type=isset($_POST['problem'])? $_POST['problem']:'';
$comment = $conn->real_escape_string($comment);


// ####################  start HELP REQUEST ######################
$help_id = isset($_POST['help_id']) ? $_POST['help_id'] : '';
$problem = isset($_POST['problem']) ? $_POST['problem'] : '';
$user_query = isset($_POST['user_query']) ? $_POST['user_query'] : '';
$support  = isset($_POST['support'])? $_POST['support'] : '';
// ####################  end HELP REQUEST ######################

$profile_status = isset($_POST['profile_status']) ? $_POST['profile_status'] : '';


if (isset($userid) && in_array($role, $cro)) {

    $sql = "SELECT * FROM subscriber WHERE cellno = '$cellno'";
    $result = $conn->query($sql);
    doLog('[sr_getSubProfile][getSubProfile] [sql: ' . $sql . ']');
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row_subscriber = $result->fetch_assoc();

        $old_sub_name = isset($row_subscriber['sub_name']) ? $row_subscriber['sub_name'] : '';
        $old_last_sub_dt = isset($row_subscriber['last_sub_dt']) ? $row_subscriber['last_sub_dt'] : '';
        $old_location = isset($row_subscriber['location']) ? $row_subscriber['location'] : '';
        $old_state = isset($row_subscriber['state']) ? $row_subscriber['state'] : '';
        $old_srvc_id = isset($row_subscriber['srvc_id']) ? $row_subscriber['srvc_id'] : '';
        $old_lang = isset($row_subscriber['lang']) ? $row_subscriber['lang'] : '';
        $old_bc_mode = isset($row_subscriber['bc_mode']) ? $row_subscriber['bc_mode'] : 'BOTH';
        $old_alert_type = isset($row_subscriber['alert_type']) ? $row_subscriber['alert_type']: 500;
    }


    $sql = "SELECT * FROM sub_profile WHERE cellno = '$cellno'";
    $result = $conn->query($sql);
    doLog('[sr_getSubProfile][getSubProfile] [sql: ' . $sql . ']');
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row_profile = $result->fetch_assoc();



        $old_gender = isset($row_profile['gender']) ? $row_profile['gender'] : '';
        $old_occupation = isset($row_profile['occupation']) ? $row_profile['occupation'] : '';
        $old_village = isset($row_profile['village']) ? $row_profile['village'] : '';
        $old_land_size = isset($row_profile['land_size']) ? $row_profile['land_size'] : '';
        $old_land_unit = isset($row_profile['land_unit']) ? $row_profile['land_unit'] : '';

    }



    $sql="INSERT INTO `sub_help_log`
            (`dt`,
             `cellno`,
             `sub_dt`,
             `old_srvc_id`,
             `new_srvc_id`,
             `old_state`,
             `new_state`,
             `old_location`,
             `new_location`,
             `old_lang`,
             `new_lang`,
             `old_bc_mode`,
             `new_bc_mode`,
             `old_alert_type`,
             `new_alert_type`,
            `old_occupation`,
             `new_occupation`,
             `old_gender`,
             `new_gender`,
             `old_village`,
             `new_village`,
             `old_land_size`,
             `new_land_size`,

             `old_land_unit`,
             `new_land_unit`,
             
           
              
             `src`)
VALUES (NOW(),
        '$cellno',
        '$old_last_sub_dt',
        IF('$old_srvc_id'='',NULL,'$old_srvc_id'),
        IF('$srvc_id'='',NULL,'$srvc_id'),
         IF('$old_state'='',NULL,'$old_state'),
        IF('$state'='',NULL,'$state'),
        IF('$old_location'='',NULL,'$old_location'),
        IF('$location'='',NULL,'$location'),
        IF('$old_lang'='',NULL,'$old_lang'),
        IF('$lang'='',NULL,'$lang'),
        '$old_bc_mode',
        '$channel',
        '$old_alert_type',
        '$alerts_type',
        IF('$old_occupation'='',NULL,'$old_occupation'),
        IF('$occupation'='',NULL,'$occupation'),
        IF('$old_gender'='',NULL,'$old_gender'),
        IF('$old_gender'='',NULL,'$old_gender'),
        IF('$old_village'='',NULL,'$old_village'),
        IF('$village'='',NULL,'$village'),
        IF('$old_land_size'='',NULL,'$old_land_size'),
        IF('$land'='',NULL,'$land'),
        IF('$old_land_unit'='',NULL,'$old_land_unit'),
        IF('$land_unit'='',NULL,'$land_unit'),
     
        'WEB')";

    //  IF('$location'='',NULL,'$location')

    doLog('[sr_getSubProfile][sub_help_log][getSubProfile] [sql: ' . $sql . ']');
    $result = $conn->query($sql);
    doLog('[sr_getSubProfile][sub_help_log][getSubProfile] [result: ' . $result . ']');

    try {
        $conn->autocommit(FALSE);
        $response["msg"] = 'Profile is going to update';

        $result = '';
        $sql = "UPDATE `sub_profile` SET `occupation` = IF('$occupation'='',NULL,'$occupation'), `village` = IF('$village'='',NULL,'$village'), `land_size` = IF('$land'='',NULL,'$land'), `land_unit` = IF('$land_unit'='',NULL,'$land_unit'), `comment` = IF('$comment'='',NULL,'$comment'), `dt` = NOW() WHERE `cellno` = '$cellno'";
        doLog('[sr_updateSubProfile][] [username: ' . $username . '][sql: ' . $sql . ' ]');
        $result = $conn->query($sql);
        if($result === false) {
            throw new Exception('SQL Error: sub_profile ' . $conn->error);
        }

        $result = '';
        $sql2 = "UPDATE  `subscriber` SET `location` = IF('$location'='',NULL,'$location'), `state` = IF('$state'='',NULL,'$state'), `srvc_id` = IF('$srvc_id'='',NULL,'$srvc_id'), `lang` = IF('$lang'='',NULL,'$lang'), `sub_name` = IF('$name'='',NULL,'$name'), `bc_mode` = '$channel' , `alert_type` = '$alerts_type'  WHERE `cellno` = '$cellno'";
        doLog('[sr_updateSubProfile][] [username: ' . $username . '][sql: ' . $sql2 . ' ]');
        $result = $conn->query($sql2);
        if($result === false) {
            throw new Exception('SQL Error: subscriber ' . $conn->error);
        }

        $result = '';
        $sql3 = "UPDATE `sub_stats` SET `last_update_dt` = NOW(), `last_update_by` = '$userid'  WHERE `cellno` = '$cellno'";
        doLog('[sr_updateSubProfile][] [username: sub_stats ' . $username . '][sql: ' . $sql3 . ' ]');
        $result = $conn->query($sql3);
        if($result === false) {
            throw new Exception('SQL Error: ' . $conn->error);
        }

        $conn->commit();
        $response["msg"] = 'Transaction completed successfully!';
        $response["success"] = 100;

    } catch (Exception $e) {
        $response["msg"] = 'Transaction failed: ' . $e->getMessage();
        $conn->rollback();
    }
    $conn->autocommit(TRUE);


    doLog('[sr_updateSubProfile][Update from Help Request] [help_id: ' . $help_id. '][length: ' . strlen($help_id) . ' ]');

    if(strlen($help_id) > 0) {


        $sql = "UPDATE `help_requests`
SET `ask_through` = 'WEB',
  `status` = 100,
  `problem_type` = IF('$problem'='',NULL,'$problem'),
  `user_query` = IF('$user_query'='',NULL,'$user_query'),
  `support_provided` = IF('$support'='',NULL,'$support'),
  `response_dt` = NOW()
WHERE `id` = $help_id";
        doLog('[sr_updateSubProfile][Update from Help Request] [username: ' . $username . '][sql: ' . $sql . ' ]');
        $result = $conn->query($sql);

    }




}else{
    header('Location: ../php/logout.php');
}

echo json_encode($response);
?>