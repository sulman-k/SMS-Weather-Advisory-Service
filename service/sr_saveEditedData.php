<?php
require_once('../php/in_common.php');
require_once('../php/in_dbConnection.php');
require_once('../php/convertsms.php');

$userid = $_SESSION['username'];
$role = $_SESSION['role'];

$id = isset($_POST['id']) ? $_POST['id'] : '';

$state = isset($_POST['state']) ? $_POST['state'] : '';
$date = isset($_POST['newDate']) ? $_POST['newDate'] : '';
$location_id = isset($_POST['location']) ? $_POST['location'] : '';
$prev_location_id = isset($_POST['prev_location']) ? $_POST['prev_location'] : '';

$min_temp = isset($_POST['minTemp']) ? $_POST['minTemp'] : '';
$max_temp = isset($_POST['maxTemp']) ? $_POST['maxTemp'] : '';
$condition_id = isset($_POST['weather']) ? $_POST['weather'] : '';
$condition_3day_id = isset($_POST['weather_3day']) ? $_POST['weather_3day'] : '';

$eve_min_temp = isset($_POST['eve_minTemp']) ? $_POST['eve_minTemp'] : '';
$eve_max_temp = isset($_POST['eve_maxTemp']) ? $_POST['eve_maxTemp'] : '';
$eve_condition_id = isset($_POST['eve_weather']) ? $_POST['eve_weather'] : '';
$eve_condition_3day_id = isset($_POST['eve_weather_3day']) ? $_POST['eve_weather_3day'] : '';

$response = array("success" => -100);
$srvc = array();

$convertor = new SmsConversion();
$intro = '';
$lowest_temp = '';
$maximum_temp = '';
$next_days = '';


$response = array("success" => -100);
$srvc = array();

$convertor = new SmsConversion();


if (isset($userid) && in_array($role, $content)) {

    if (isset($state) && isset($date) && isset($location_id) && isset($min_temp) && isset($max_temp) && isset($condition_id) && isset($condition_3day_id)) {

        if ($max_temp > $min_temp) {

            $sql = "SELECT id,`aw_type` FROM state WHERE `status` > 0 AND id = '$state'";
            doLog('[sr_saveAWdata][AW Type of state][sql : ' . $sql . ']');
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $aw_type = $row['aw_type'];
            }

            if (!strcmp($state, 'gb')) {

                $aw_type_eve = $aw_type + 1;

                $sql = "select * from district_lang_def where district= '$location_id'";
                doLog('[sr_saveEditedData][GB][Find Location] [location_id ' . $location_id . '] [user_id: ' . $userid . '][sql : ' . $sql . ']');
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $loc_sms_name = $row['aw_sms_txt'];
                    $loc_file_name = $row['aw_file_name'];
                    $sql = "select * from aw_conditions where id=$condition_id";
                    doLog('[sr_saveEditedData][GB][Find Condition] [condition_id ' . $condition_id . '] [user_id: ' . $userid . '][sql : ' . $sql . ']');
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $weather_sms_name = $row['sms_txt'];
                        $weather_file_name = $row['file_name'];

                        $sql = "select * from aw_conditions where id=$eve_condition_id";
                        doLog('[sr_saveEditedData][GB][Find Condition] [Evening condition_id ' . $eve_condition_id . '] [user_id: ' . $userid . '][sql : ' . $sql . ']');
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $eve_weather_sms_name = $row['sms_txt'];
                            $eve_weather_file_name = $row['file_name'];

                            $sql = "select * from aw_conditions where id=$condition_3day_id";
                            doLog('[sr_saveEditedData][GB][Find Future Condition] [condition_3day_id ' . $condition_3day_id . '] [user_id: ' . $userid . '][sql : ' . $sql . ']');
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $weather_3day_sms_name = $row['sms_txt'];
                                $weather_3day_file_name = $row['file_name'];

                                $sql = "select * from aw_conditions where id=$eve_condition_3day_id";
                                doLog('[sr_saveEditedData][GB][Find Future Condition] [Evening condition_3day_id ' . $eve_condition_3day_id . '] [user_id: ' . $userid . '][sql : ' . $sql . ']');
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $eve_weather_3day_sms_name = $row['sms_txt'];
                                    $eve_weather_3day_file_name = $row['file_name'];

                                    $sql = "select * from sms_parts";
                                    //doLog('[sr_saveEditedData][GB][Find Future Condition] [condition_3day_id ' . $condition_3day_id . '] [user_id: ' . $userid . '][sql : ' . $sql . ']');
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {

                                            if ($row['param'] == 'lowest_temp') {
                                                $lowest_temp = $row['value'];
                                            }
                                            if ($row['param'] == 'maximum_temp') {
                                                $maximum_temp = $row['value'];
                                            }
                                            if ($row['param'] == 'next_days') {
                                                $next_days = $row['value'];
                                            }
                                            if ($row['param'] == 'next_hours') {
                                                $next_hours = $row['value'];
                                            }
                                            if ($row['param'] == 'minus') {
                                                $minus = $row['value'];
                                            }
                                        }

                                        if ($min_temp < 0) {
                                            $min_temp_str = '&#1605;&#1606;&#1601;&#1740;' . abs($min_temp);
                                        } else {
                                            $min_temp_str = $min_temp;
                                        }
                                        if ($max_temp < 0) {
                                            $max_temp_str = '&#1605;&#1606;&#1601;&#1740;' . abs($max_temp);
                                        } else {
                                            $max_temp_str = $max_temp;
                                        }

                                        if ($eve_min_temp < 0) {
                                            $eve_min_temp_str = '&#1605;&#1606;&#1601;&#1740;' . abs($eve_min_temp);
                                        } else {
                                            $eve_min_temp_str = $eve_min_temp;
                                        }
                                        if ($eve_max_temp < 0) {
                                            $eve_max_temp_str = '&#1605;&#1606;&#1601;&#1740;' . abs($eve_max_temp);
                                        } else {
                                            $eve_max_temp_str = $eve_max_temp;
                                        }

                                        $sms_text = $loc_sms_name . ' ' . $weather_sms_name . ' ' . $lowest_temp . ' ' . $min_temp_str . ' ' . $maximum_temp . ' ' . $max_temp_str . ' ' . $next_days . ' ' . $weather_3day_sms_name;
                                        $hex_sms_text = $convertor->getHexacode($sms_text);

                                        $eve_sms_text = $loc_sms_name . ' ' . $eve_weather_sms_name . ' ' . $lowest_temp . ' ' . $eve_min_temp_str . ' ' . $maximum_temp . ' ' . $eve_max_temp_str . ' ' . $next_hours . ' ' . $eve_weather_3day_sms_name;
                                        $eve_hex_sms_text = $convertor->getHexacode($eve_sms_text);

//                                    $sql = "INSERT INTO auto_weather (id,`date`,location_id,min_temperature,max_temperature,today_condition_id,future_condition_id,today_condition_file,future_condition_file,sms_text,hex_sms_text,eve_today_condition_id,eve_future_condition_id,eve_min_temperature,eve_max_temperature,eve_today_condition_file,eve_future_condition_file,eve_sms_text,eve_hex_sms_text)
//                                    values ('','$date',$location_id,$min_temp,$max_temp,$condition_id,$condition_3day_id,'$weather_file_name','$weather_3day_file_name','$sms_text','$hex_sms_text',$eve_condition_id,$eve_condition_3day_id,$eve_min_temp,$eve_max_temp,'$eve_weather_file_name','$eve_weather_3day_file_name','$eve_sms_text','$eve_hex_sms_text')";

//                                        $sql = "INSERT INTO `aw_daily_weather` (`id`, `date`, `state`, `location`, `min_temp`, `max_temp`, `now_file_id`, `now_file_name`, `future_file_id`, `future_file_name`, `sms_text` , `hex_sms_text` , `aw_type`, `upload_dt`, `status`)
//                                        VALUES (null, '$date', '$state', '$location_id', '$min_temp', '$max_temp', $condition_id , '$weather_file_name', $condition_3day_id, '$weather_3day_file_name', '$sms_text' , '$hex_sms_text' , 200, NOW(), 100)";
                                        $sql = "UPDATE `aw_daily_weather` SET `date` = '$date', `state` = '$state', `district` = '$location_id', `min_temp` = $min_temp, `max_temp` = $max_temp, `now_file_id` = $condition_id, `now_file_name` = '$weather_file_name', `future_file_id` = $condition_3day_id, `future_file_name` = '$weather_3day_file_name', `sms_text` = '$sms_text', `hex_sms_text` = '$hex_sms_text', `upload_dt` = NOW() WHERE `id` = $id;";
                                        doLog('[sr_saveEditedData][GB][Create SMS String] [user_id: ' . $userid . '][sql : ' . $sql . ']');
                                        $result = $conn->query($sql);

//                                        $sql = "INSERT INTO `aw_daily_weather` (`id`, `date`, `state`, `location`, `min_temp`, `max_temp`, `now_file_id`, `now_file_name`, `future_file_id`, `future_file_name`, `sms_text` , `hex_sms_text` ,`aw_type`, `upload_dt`, `status`)
//                                        VALUES (null, '$date', '$state', '$location_id', '$eve_min_temp', '$eve_max_temp', $eve_condition_id , '$eve_weather_file_name', $eve_condition_3day_id, '$eve_weather_3day_file_name', '$eve_sms_text' , '$eve_hex_sms_text', 201, NOW(), 100)";
//
                                        $sql = "UPDATE `aw_daily_weather` SET `date` = '$date', `state` = '$state', `district` = '$location_id', `min_temp` = $eve_min_temp, `max_temp` = $eve_max_temp, `now_file_id` = $eve_condition_id, `now_file_name` = '$eve_weather_file_name', `future_file_id` = $eve_condition_3day_id, `future_file_name` = '$eve_weather_3day_file_name', `sms_text` = '$eve_sms_text', `hex_sms_text` = '$eve_hex_sms_text', `upload_dt` = NOW() WHERE district = '$prev_location_id' AND `date` = '$date' AND `aw_type` = $aw_type_eve  ORDER BY `date` DESC LIMIT 1";
                                        doLog('[sr_saveEditedData][GB][Create SMS String] [user_id: ' . $userid . '][sql : ' . $sql . ']');
                                        $result = $conn->query($sql);

                                        $response['success'] = 100;
                                        $response["msg"] = "SMS string has been successfully created";
                                        $response["last_id"] = $id;
                                        $response["src"] = $state;

                                    } else {
                                        $response["msg"] = "No sms parts found";
                                    }

                                } else {
                                    $response["msg"] = "No Eve Future Weather condition found";
                                }

                            } else {
                                $response["msg"] = "No Future Weather condition found";
                            }
                        } else {
                            $response["msg"] = "No Evening Weather condition found";
                        }

                    } else {
                        $response["msg"] = "No Weather condition found";
                    }
                } else {
                    $response["msg"] = "No location found";
                }
            } else {

                $sql = "select * from district_lang_def where district= '$location_id'";
                doLog('[sr_saveEditedData][missouri][Find Location] [location_id ' . $location_id . '] [user_id: ' . $userid . '][sql : ' . $sql . ']');
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $loc_sms_name = $row['aw_sms_txt'];
                    $loc_file_name = $row['aw_file_name'];
                    $sql = "select * from aw_conditions where id=$condition_id";
                    doLog('[sr_saveEditedData][missouri][Find Condition] [condition_id ' . $condition_id . '] [user_id: ' . $userid . '][sql : ' . $sql . ']');
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $weather_sms_name = $row['sms_txt'];
                        $weather_file_name = $row['file_name'];

                        $sql = "select * from aw_conditions where id=$condition_3day_id";
                        doLog('[sr_saveEditedData][missouri][Find Future Condition] [condition_3day_id ' . $condition_3day_id . '] [user_id: ' . $userid . '][sql : ' . $sql . ']');
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $weather_3day_sms_name = $row['sms_txt'];
                            $weather_3day_file_name = $row['file_name'];


                            $sql = "select * from sms_parts";
                            doLog('[sr_saveEditedData][missouri][Find Future Condition] [condition_3day_id ' . $condition_3day_id . '] [user_id: ' . $userid . '][sql : ' . $sql . ']');
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    if ($row['param'] == 'intro') {
                                        $intro = $row['value'];
                                    }
                                    if ($row['param'] == 'lowest_temp') {
                                        $lowest_temp = $row['value'];
                                    }
                                    if ($row['param'] == 'maximum_temp') {
                                        $maximum_temp = $row['value'];
                                    }
                                    if ($row['param'] == 'next_days') {
                                        $next_days = $row['value'];
                                    }
                                    if ($row['param'] == 'minus') {
                                        $minus = $row['value'];
                                    }
                                }
                                if ($min_temp < 0) {
                                    $min_temp_str = '&#1605;&#1606;&#1601;&#1740;' . abs($min_temp);
                                } else {
                                    $min_temp_str = $min_temp;
                                }
                                if ($max_temp < 0) {
                                    $max_temp_str = '&#1605;&#1606;&#1601;&#1740;' . abs($max_temp);
                                } else {
                                    $max_temp_str = $max_temp;
                                }
                                $intro = '';
                                $sms_text = $intro . ' ' . $loc_sms_name . ' ' . $weather_sms_name . ' ' . $lowest_temp . ' ' . $min_temp_str . ' ' . $maximum_temp . ' ' . $max_temp_str . ' ' . $next_days . ' ' . $weather_3day_sms_name;
                                $hex_sms_text = $convertor->getHexacode($sms_text);


                               // $sql = "INSERT INTO `aw_daily_weather` (`id`, `date`, `state`, `location`, `min_temp`, `max_temp`, `now_file_id`, `now_file_name`, `future_file_id`, `future_file_name`, `sms_text` , `hex_sms_text` , `aw_type`, `upload_dt`, `status`)
                                // VALUES (null, '$date', '$state', '$location_id', '$min_temp', '$max_temp', $condition_id , '$weather_file_name', $condition_3day_id, '$weather_3day_file_name', '$sms_text' , '$hex_sms_text' ,100, NOW(), 100)";
                                $sql = "UPDATE `aw_daily_weather` SET  `date` = '$date', `state` = '$state', `district` = '$location_id', `min_temp` = $min_temp, `max_temp` = $max_temp, `now_file_id` = $condition_id, `now_file_name` = '$weather_file_name', `future_file_id` = $condition_3day_id, `future_file_name` = '$weather_3day_file_name', `sms_text` = '$sms_text', `hex_sms_text` = '$hex_sms_text', `upload_dt` = NOW()   WHERE `id` = $id";
                                doLog('[sr_saveEditedData][missouri][Create SMS String] [user_id: ' . $userid . '][sql : ' . $sql . ']');
                                $result = $conn->query($sql);

                                $response['success'] = 100;
                                $response["msg"] = "SMS string has been successfully created";
                                $response["last_id"] = $id;
                                $response["src"] = $state;
                            } else {
                                $response["msg"] = "No sms parts found";
                            }


                        } else {
                            $response["msg"] = "No Future Weather condition found";
                        }


                    } else {
                        $response["msg"] = "No Weather condition found";
                    }
                } else {
                    $response["msg"] = "No location found";
                }

            }
        } else {
            $response["msg"] = "Maximum temperature should be greater than Minimum temperature";
        }
    } else {
        $response["msg"] = "No parameter found for Weather";
    }
}else{
    header('Location: ../php/logout.php');
}


echo json_encode($response);
?>
