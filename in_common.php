<?php

//$admin_ops_content = array("admin","ops", "content");
//$admin_ops = array("admin","ops");
//$admin_content = array("admin","content");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


$admin = array("admin");
/*$admin_content = array("admin","content");
$content = array("content");*/
$admin_content = array("admin","content");
$content = array("content");
$ops = array("ops");
$cro = array("cro");
$obdadmin=array("obdadmin");
$batch_user = array("batch");
$crop=array("crop_ins");
$bulk_unsub=array("bulk");
$paid_wall_unsub=array("single_unsub");




function validateUserRole($conn, $username)
{
    $sql = "SELECT role FROM user where user_id='$username'  AND status > 0";
    $result = $conn->query($sql);
    doLog('[in_common.php][Finding User Role] [username: ' . $username . '][sql: '. $sql .' ]');

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['role'];

    }
}

date_default_timezone_set('NorthAmerica/NewYork');
function doLog($what)
{
    $fh = fopen('magri_revamp.log', 'a');
    fwrite($fh, "[" . date("Y-m-d H:i:s", time()) . "] " . $what . "\n");
    fclose($fh);
}


function userLogActivity($conn, $activity_code)
{
    $path = $_SERVER['REQUEST_URI'];
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
    global $conn;
    $sqll = "INSERT INTO user_log " . "(user_id,dt,address,activity_code) " . "VALUES " . "('$username',NOW(),'$path', '$activity_code')";

    $resultl = $conn->query($sqll);
}


$default_ka_state = 'missouri';
$default_ka_location = 'unknown';
$default_ka_lang = 'eng';


$illegal = "#@$%^&*()+=-[]' ;,/{}|:<>?~";


$path  = '../files/AutoWeatherFiles';

$path_florida_eng = '../weather/florida/eng';

$path_missouri_eng = '../weather/missouri/eng';
$path_missouri_french= '../weather/missouri/missourii';
$path_missouri_german = '../weather/missouri/german';

$path_kansas_eng = '../weather/kansas/eng';


$path_hawaii_eng = '../weather/hawaii/eng';


$menu_path = '../prompts';
$base_path = '../content';
$temp_path = '../temp_prompts';

$amount=6;
$page_limit = 10;
$target_dir='../files/Unsub_bulk_file';

$default_bc_mode = 'BOTH';
$default_alert_type = 500;

define('DEFAULT_GENDER', 'male');
define('DEFAULT_OCCUPATION', 'Farmer');
define('DEFAULT_VILLAGE', 'Chak Default');
define('DEFAULT_LAND_SIZE', '1');
define('DEFAULT_LAND_UNIT', 'Qilla');
//Fro Subscriber
define('DEFAULT_SUB_NAME', 'john_smith');
define('DEFAULT_SUB_MODE', 'WEB');
define('DEFAULT_BC_MODE', 'BOTH');
define('DEFAULT_ALERT_TYPE', '500');
define('DEFAULT_UNSUB_MODE', 'WEB');
define('DEFAULT_UNSUB_MODE_WEBDOC','webdoc');
// KZ
define('UPDATE_PROFILE_URL','http://xwdst.t:8080/mAgri_API_Charging/update/profile?');
define('UNSUBCRIBE_URL','http://xwdst.t:8080/mAgri_API_Charging/unSubscribe?');
define('SUBCRIBE_URL','http://xwdst.t:8080/mAgri_API_Charging/subscribe?');
// KS
define('WDC_UNSUBCRIBE_URL','http://xwdst:8080/WebDocAPI/unSubscribe?');
define('WDC_SUBCRIBE_URL','http://xwdst:8080/WebDocAPI/subscribe?');
define('WDC_CHARGE_URL','http://xwdst:8080/WebDocAPI/charging?');

// KM
define('WD_KM_UNSUBCRIBE_URL','http://xwdst:8080/K_Mweshie_API/unSubscribe?');
define('WD_KM_SUBCRIBE_URL','http://xwdst:8080/K_Mweshie_API/subscribe?');
define('WD_KM_CHARGE_URL','http://xwdst:8080/K_Mweshie_API/charging?');
define('WD_KM_CHARGING_SMS','http://xwdst:8080/K_Mweshie_API/sendSms?');
//KB
define ('KB_SUBCRIBE_URL','http://xwdst.t:8080/K_BIMA_API/subscribe?');
define ('KB_UNSUBCRIBE_URL','http://xwdst.t:8080/K_BIMA_API/unSubscribe?');
// define ('KB_CHARGE_URL','http://192.168.73.136:8080/WebDocAPI/charging?');
define ('KB_CHARGE_URL','http://xwdst.t:8080/K_BIMA_API/charging?');

// KK
define('KK_SUBSCRIBE_URL','http://xwdst:8080/agri-expert-api/subscribe?');
define('KK_UNSUBSCRIBE_URL','http://xwdst:8080/agri-expert-api/unSubscribe?');
define('KK_CHARGE_URL','http://xwdst:8080/agri-expert-api/charging?');
// KJ
define('KJ_SUBSCRIBE_URL','http://xwdst:8080/watson_guard_api/subscribe?');
define('KJ_UNSUBSCRIBE_URL','http://xwdst.t:8080/watson_guard_api/unSubscribe?');
define('KJ_CHARGE_URL','http://xwdst.t:8080/watson_guard_api/charging?');
// KR
define('RM_SUBSCRIBE_URL','http://xwdst:8080/magri_rm/subscribe?');
define('RM_UNSUBSCRIBE_URL','http://xwdst:8080/magri_rm/unSubscribe?');
define('RM_CHARGE_URL','http://xwdst:8080/magri_rm/charging?');
// KN
define('KN_SUBSCRIBE_URL','http://xwdst.t:8080/kn_api_server/subscribe?');
define('KN_UNSUBSCRIBE_URL','http://xwdst.t:8080/kn_api_server/unSubscribe?');
define('KN_CHARGE_URL','http://xwdst.t:8080/kn_api_server/charging?');
// ZD
define('ZD_SUBSCRIBE_URL','http://xwdst.t:8080/ZARAI_DIRECTORY_API/subscribe?');
define('ZD_UNSUBSCRIBE_URL','http://xwdst.t:8080/ZARAI_DIRECTORY_API/unSubscribe?');
define('ZD_CHARGE_URL','http://xwdst.t:8080/ZARAI_DIRECTORY_API/charging?');
// KAA
define('KAD_SUBSCRIBE_URL','http://xwdst.t:8080/K_Amdani_API/subscribe?');
define('KAD_UNSUBSCRIBE_URL','http://xwdst.t:8080/K_Amdani_API/unSubscribe?');
define('KAD_CHARGE_URL','http://xwdst.t:8080/K_Amdani_API/charging?');


?>
