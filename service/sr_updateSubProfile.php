<?php
require_once('../php/in_dbConnection.php');
require_once('../php/in_common.php');

$userid = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$role = $_SESSION['role'];

$response = array("success" => -100);

$oldData = json_decode($_POST['oldData'], true);

$cellno = isset($_POST['cellno']) ? $_POST['cellno'] : '';
$name = isset($_POST['sub_name']) ? $_POST['sub_name'] : '';
$occupation  = isset($_POST['occupation'])? $_POST['occupation'] : '';
$lang = isset($_POST['lang']) ? $_POST['lang'] : '';
$state = isset($_POST['state']) ? $_POST['state'] : '';
$location  = isset($_POST['district'])&& $_POST['district'] != '' ? $_POST['district'] : 'unknown';
$village  = isset($_POST['village'])? $_POST['village'] : '';
$srvc_id = isset($_POST['srvc_id']) ? $_POST['srvc_id'] : '';
$land = isset($_POST['land']) ? $_POST['land'] : '';
$land_unit  = isset($_POST['land_unit'])? $_POST['land_unit'] : '';
$alerts_type = isset($_POST['alerts_type']) && $_POST['alerts_type'] != '' ? $_POST['alerts_type'] : 500;
$bc_mode = isset($_POST['channel']) ? $_POST['channel'] : '';
$comment  = isset($_POST['comment'])? $_POST['comment'] : '';
$tehsil  = isset($_POST['tehsil'])? $_POST['tehsil'] : '';
$has_selected_loc = isset($_POST['has_selected_loc'])?$_POST['has_selected_loc']:'';

$comment = $conn->real_escape_string($comment);

// ####################  start HELP REQUEST ######################
$help_id = isset($_POST['help_id']) ? $_POST['help_id'] : '';
$problem = isset($_POST['problem']) ? $_POST['problem'] : '';
$user_query = isset($_POST['user_query']) ? $_POST['user_query'] : '';
$support  = isset($_POST['support'])? $_POST['support'] : '';
// ####################  end HELP REQUEST ######################

if (isset($userid) && in_array($role, $cro)) {

        // start curl request to update profile data
    $response["success"] = -100;
    $url = UPDATE_PROFILE_URL;
    $fields = array(
        'cellno' => urlencode($cellno) ,
        'sub_name' => urlencode($name),
        'occupation' => urlencode($occupation),
        'lang' => urlencode($lang),
        'state' => urlencode($state),
        'district' => urlencode($location),
        'village' => urlencode($village),
        'srvc_id' => urlencode($srvc_id),
        'land_size' => urlencode($land),
        'land_unit' => urlencode($land_unit),
        'alert_type' => urlencode($alerts_type),
        'bc_mode' => urlencode($bc_mode),
        'comment' => urlencode($comment),
        'tehsil'  => urlencode($tehsil),
        "src" => DEFAULT_UNSUB_MODE
    );
    if(!empty($has_selected_loc) && $has_selected_loc != -100)
        $fields['has_selected_loc'] = $has_selected_loc;
    //url-ify the data for the POST
    $fields_string ="";
    //$defaultColumn = ['cellno','src','state'];

    $defaultColumn = array('cellno','src','state');


    foreach($fields as $key=>$value) {
        if(in_array($key,$defaultColumn) ||(array_key_exists($key,$oldData) && $oldData[$key] != str_replace("+"," ",$value)))
        $fields_string .= $key.'='.$value.'&';
    }
    //rtrim($fields_string, '&');
    $fields_string = substr_replace($fields_string, "", -1);

    doLog("Curl url - ".$url);
    doLog("Curl url fields - ".$fields_string);
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
    doLog("[UpdateSubProfile][Response Code] - ".$result->responseCode ." - [API Response Message] -".$result->message);

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