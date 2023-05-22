<?php
require_once('../php/in_dbConnection.php');
require_once('../php/in_common.php');

$userid = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$role = $_SESSION['role'];
$token='';
$response = array("success" => -100);

$cellno = isset($_GET['cellno']) ? $_GET['cellno'] : '';

//http://192.168.70.169:8089/MagriAPI/subscribe?cellno=03461113252&subMode=WEB
if (isset($userid) && in_array($role, $cro) ||  in_array($role,$paid_wall_unsub)) {

    if (strlen($cellno) > 0 && strlen($cellno) == 11) {

        $response["success"] = -100;
        $url = WDC_SUBCRIBE_URL;
        $fields = array(
            'cellno' => urlencode($cellno),
            "subMode" => DEFAULT_SUB_MODE
        );
        //url-ify the data for the POST
        $fields_string = "";
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        //rtrim($fields_string, '&');
        $fields_string = substr_replace($fields_string, "", -1);

        doLog("URL for Web Doc Subscrition  - " . $url . $fields_string);
        //open connection
        $ch = curl_init();

        //set the url
        curl_setopt($ch, CURLOPT_URL, $url . $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        //echo $result;exit;
        $result = json_decode($result);
        $response["success"] = $result->responseCode;
        $response["msg"] = $result->message;
        $response["issub"] = $result->IS_SUB;


        //now calling charging API
         if($result->IS_SUB = 'Y'){

             $url = WDC_CHARGE_URL;
//             $fields = array(
//                 'cellno' => urlencode($cellno),
//                 "subMode" => DEFAULT_SUB_MODE
//             );
//             //url-ify the data for the POST
//             $fields_string = "";
//             foreach ($fields as $key => $value) {
//                 $fields_string .= $key . '=' . $value . '&';
//             }
//             //rtrim($fields_string, '&');
//             $fields_string = substr_replace($fields_string, "", -1);
//
             doLog("URL for Web Doc Charging  - " . $url . 'cellno=' .urlencode($cellno));
//             //open connection
             $ch = curl_init();

             //set the url
             curl_setopt($ch, CURLOPT_URL, $url . 'cellno=' .urlencode($cellno));
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

             //execute post
             $result_charge = curl_exec($ch);
             //close connection
             curl_close($ch);

         }

        //-------------------get subscriber-------------------------------
        if ($result->IS_SUB = "Y") {

            $sql = "SELECT cellno,sub_dt,sub_dt AS last_sub_dt,status AS sub_status FROM subscriber  WHERE status > 0  AND  cellno = '$cellno'";

            doLog('[sr_wdc_addSubscribers][] [sql: ' . $sql . ']');
            $result = $wdc_conn->query($sql);
            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {


                    $row['sub_status'] = 'New Subscriber';
                    if ($row['last_sub_dt'] > $row['last_sub_dt']) {
                        $row['sub_status'] = 'Re Subscriber';
                    }

                    $subscribers['subscriber'] = $row;
                }
            }

            doLog("[sr_addSubscriber][Response Code] - " . $result->responseCode . " - [API Response Message] -" . $result->message . " - IS_SUB - " . $result->IS_SUB);
        } else {
            $response["msg"] = "Cellno is not valid";
            doLog('[sr_wdc_addSubscriber][Checking in Subscriber] [cellno: ' . $cellno . '] is not valid');
        }

    } else {
        header('Location: ../php/logout.php');
    }
}
echo json_encode($response);
?>