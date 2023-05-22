<?php
require_once('../php/in_common.php');
require_once('../php/in_dbConnection.php');

$userid = $_SESSION['username'];
$id = isset($_GET['id']) ? $_GET['id'] : '';

$role = $_SESSION['role'];


$response = array("success" => -100);


$locations = array();
$conditions = array();
$future_conditions = array();

$files_1 = array();
$files_2 = array();
$files_3 = array();
$files_4 = array();
$files_5 = array();


if (isset($userid) && in_array($role, $content)) {

    $sql = "SELECT * FROM aw_daily_weather WHERE id= $id ";
    doLog('[sr_getlastInsertedData][auto_weather] [sql: ' . $sql . ']');
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $state = $row['state'];



        if (!strcmp($state, 'gb')) {

            $loc_id = '';
            $date = '';
            $min_temp = '';
            $max_temp = '';
            $today_id = '';
            $future_id = '';
            $today_condition_file = '';
            $future_condition_file = '';
            $sms_text = '';

            $loc_id_eve = '';
            $date_eve = '';
            $eve_min_temp = '';
            $eve_max_temp = '';
            $eve_today_id = '';
            $eve_future_id = '';
            $eve_today_condition_file = '';
            $eve_future_condition_file = '';
            $eve_sms_text = '';


            $loc_id = $row['district'];
            $date = $row['date'];
            $min_temp = $row['min_temp'];
            $max_temp = $row['max_temp'];
            $today_id = $row['now_file_id'];
            $future_id = $row['future_file_id'];

            $today_condition_file = $row['now_file_name'];
            $future_condition_file = $row['future_file_name'];

            $sms_text = $row['sms_text'];


            $sql = "select * from sms_parts";

            doLog('[sr_getlastInsertedData][Location] [sql: ' . $sql . ']');
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $max_file = '';
                $min_file = '';
                $intro = '';
                $next_days_file = '';
                $lowest_temp = '';
                $most_temp = '';
                $next_hours = '';
                $eve_max_file = '';
                $eve_min_file = '';

                while ($row = $result->fetch_assoc()) {
                    if ($row['param'] == 'max_' . $max_temp) {
                        $max_file = $row['value'];
                    }
                    if ($row['param'] == 'min_' . $min_temp) {
                        $min_file = $row['value'];
                    }

                    if ($row['param'] == 'obd_intro') {
                        $intro = $row['value'];
                    }
//                    if ($row['param'] == 'obd_next_days') {
//                        $next_days_file = $row['value'];
//                    }
                    if ($row['param'] == 'obd_next_hours') {
                        $next_hours = $row['value'];
                    }
                    if ($row['param'] == 'obd_lowest_temp') {
                        $lowest_temp = $row['value'];
                    }
                    if ($row['param'] == 'obd_maximum_temp') {
                        $most_temp = $row['value'];
                    }
                }

                $next_days_file = 'autoweather_0.wav';

                $sql = "SELECT aw_file_name FROM district_lang_def WHERE  district = '$loc_id' ";

                doLog('[sr_getlastInsertedData][Location] [sql: ' . $sql . ']');
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $response["location"] = $loc_id;
                    $loc_file = $row["aw_file_name"];


                    $sql = "SELECT title,file_name FROM aw_conditions WHERE id= $today_id ";

                    doLog('[sr_getlastInsertedData][condition] [sql: ' . $sql . ']');
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $conditions['id'] = $today_id;
                        $response["condition"] = $row["title"];
                        $weather_file = $row["file_name"];

                        $sql = "SELECT title,file_name FROM aw_conditions WHERE id= $future_id ";

                        doLog('[sr_getlastInsertedData][future condition] [sql: ' . $sql . ']');
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            //$future_conditions['id'] = $future_id;
                            $response["future_condition"] = $row["title"];
                            $future_file = $row["file_name"];

                            $files_4[] = $path_kansas_eng . '/' . $intro;
                            $files_4[] = $path_kansas_eng . '/' . $loc_file;
                            $files_4[] = $path_kansas_eng . '/' . $weather_file;
                            $files_4[] = $path_kansas_eng . '/' . $lowest_temp;
                            $files_4[] = $path_kansas_eng . '/' . $min_file;
                            $files_4[] = $path_kansas_eng . '/' . $most_temp;
                            $files_4[] = $path_kansas_eng . '/' . $max_file;
                            $files_4[] = $path_kansas_eng . '/' . $next_days_file;
                            $files_4[] = $path_kansas_eng . '/' . $future_file;


                            $sms_text = utf8_encode($sms_text);

                            $response["msg"] = "Weather Data Found";
                            $response["min_temp"] = $min_temp;
                            $response["max_temp"] = $max_temp;
                            $response["date"] = $date;
                            $response["sms_text"] = $sms_text;
                            $response["success"] = 100;
                            $response["files_4"] = $files_4;

                        } else {
                            $response["msg"] = "No results found for Conditions";
                        }


                    } else {
                        $response["msg"] = "No results found for Conditions";
                    }

                } else {
                    $response["msg"] = "No results found for Location";
                }


                $sql = "SELECT * FROM aw_daily_weather WHERE district = '$loc_id' AND `date` = '$date' AND `aw_type` = 201  ORDER BY `date` DESC LIMIT 1";

                doLog('[sr_getlastInsertedData][auto_weather] [sql: ' . $sql . ']');
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();

                    $loc_id_eve = $row['district'];
                    $date_eve = $row['date'];
                    $eve_min_temp = $row['min_temp'];
                    $eve_max_temp = $row['max_temp'];

                    $eve_today_id = $row['now_file_id'];
                    $eve_future_id = $row['future_file_id'];

                    $eve_today_condition_file = $row['now_file_name'];
                    $eve_future_condition_file = $row['future_file_name'];
                    $eve_sms_text = $row['sms_text'];

                }


                $sql = "select * from sms_parts";

                doLog('[sr_getlastInsertedData][Location] [sql: ' . $sql . ']');
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $max_file = '';
                    $min_file = '';
                    $intro = '';
                    $next_days_file = '';
                    $lowest_temp = '';
                    $most_temp = '';
                    $next_hours = '';
                    $eve_max_file = '';
                    $eve_min_file = '';

                    while ($row = $result->fetch_assoc()) {
                        if ($row['param'] == 'max_' . $eve_max_temp) {
                            $eve_max_file = $row['value'];
                        }
                        if ($row['param'] == 'min_' . $eve_min_temp) {
                            $eve_min_file = $row['value'];
                        }

                        if ($row['param'] == 'obd_intro') {
                            $intro = $row['value'];
                        }
//                        if ($row['param'] == 'obd_next_days') {
//                            $next_days_file = $row['value'];
//                        }
//                        if ($row['param'] == 'obd_next_hours') {
//                            $next_hours = $row['value'];
//                        }
                        if ($row['param'] == 'obd_lowest_temp') {
                            $lowest_temp = $row['value'];
                        }
                        if ($row['param'] == 'obd_maximum_temp') {
                            $most_temp = $row['value'];
                        }
                    }
                }

                $next_hours = 'autoweather_1.wav';


                $sql = "SELECT aw_file_name FROM district_lang_def WHERE district = '$loc_id' ";

                doLog('[sr_getlastInsertedData][Location] [sql: ' . $sql . ']');
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $response["location"] = $loc_id;
                    $loc_file = $row["aw_file_name"];


                    $sql = "SELECT title,file_name FROM aw_conditions WHERE id= $eve_today_id ";

                    doLog('[sr_getlastInsertedData][eve condition] [sql: ' . $sql . ']');
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $response["eve_condition"] = $row["title"];
                        $eve_today_condition_file = $row["file_name"];


                        $sql = "SELECT title,file_name FROM aw_conditions WHERE id= $eve_future_id ";

                        doLog('[sr_getlastInsertedData][future condition] [sql: ' . $sql . ']');
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $response["eve_future_condition"] = $row["title"];
                            $eve_future_condition_file = $row["file_name"];


                            $files_5[] = $path_kansas_eng . '/' . $intro;
                            $files_5[] = $path_kansas_eng . '/' . $loc_file;
                            $files_5[] = $path_kansas_eng . '/' . $eve_today_condition_file;
                            $files_5[] = $path_kansas_eng . '/' . $lowest_temp;
                            $files_5[] = $path_kansas_eng . '/' . $eve_min_file;
                            $files_5[] = $path_kansas_eng . '/' . $most_temp;
                            $files_5[] = $path_kansas_eng . '/' . $eve_max_file;
                            $files_5[] = $path_kansas_eng . '/' . $next_hours;
                            $files_5[] = $path_kansas_eng . '/' . $eve_future_condition_file;


                            $sms_text = utf8_encode($sms_text);

                            $response["msg"] = "Weather successfully added";

                            $response["eve_min_temp"] = $eve_min_temp;
                            $response["eve_max_temp"] = $eve_max_temp;
                            $response["eve_sms_text"] = $eve_sms_text;
                            $response["success"] = 100;
                            $response["files_5"] = $files_5;

                        } else {
                            $response["msg"] = "No results found for Conditions";
                        }

                    } else {
                        $response["msg"] = "No results found for Eve Conditions";
                    }

                } else {
                    $response["msg"] = "No results found for Location";
                }

            } else {
                $response["msg"] = "No results found for sms_parts";
            }


//        } else {
//            $response["msg"] = "No results found for Weather";
//        }
        } else if (!strcmp($state, 'missouri')){


            $loc_id = $row['district'];
            $date = $row['date'];
            $min_temp = $row['min_temp'];
            $max_temp = $row['max_temp'];
            $today_id = $row['now_file_id'];
            $future_id = $row['future_file_id'];
            $sms_text = $row['sms_text'];

            $sql = "select * from sms_parts";

            doLog('[sr_getlastInsertedData][Location] [sql: ' . $sql . ']');
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $max_file = '';
                $min_file = '';
                $intro = '';
                $next_days_file = '';
                $lowest_temp = '';
                $most_temp = '';

                while ($row = $result->fetch_assoc()) {
                    if ($row['param'] == 'max_' . $max_temp) {
                        $max_file = $row['value'];
                    }
                    if ($row['param'] == 'min_' . $min_temp) {
                        $min_file = $row['value'];
                    }
                    if ($row['param'] == 'obd_intro') {
                        $intro = $row['value'];
                    }
//                    if ($row['param'] == 'obd_next_days') {
//                        $next_days_file = $row['value'];
//                    }
                    if ($row['param'] == 'obd_lowest_temp') {
                        $lowest_temp = $row['value'];
                    }
                    if ($row['param'] == 'obd_maximum_temp') {
                        $most_temp = $row['value'];
                    }
                }

                $next_days_file = 'autoweather_0.wav';

                $sql = "SELECT aw_file_name FROM district_lang_def WHERE district = '$loc_id' ";

                doLog('[sr_getlastInsertedData][Location] [sql: ' . $sql . ']');
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $response["location"] = $loc_id;
                    $loc_file = $row["aw_file_name"];


                    $sql = "SELECT title,file_name FROM aw_conditions WHERE id= $today_id ";

                    doLog('[sr_getlastInsertedData][condition] [sql: ' . $sql . ']');
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $conditions['id'] = $today_id;
                        $response["condition"] = $row["title"];
                        $weather_file = $row["file_name"];


                        $sql = "SELECT title,file_name FROM aw_conditions WHERE id= $future_id ";

                        doLog('[sr_getlastInsertedData][future condition] [sql: ' . $sql . ']');
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            // $future_conditions['id'] = $future_id;
                            $response["future_condition"] = $row["title"];
                            $future_file = $row["file_name"];

                            $files_1[] = $path_missouri_eng . '/' . $intro;
                            $files_1[] = $path_missouri_eng . '/' . $loc_file;
                            $files_1[] = $path_missouri_eng . '/' . $weather_file;
                            $files_1[] = $path_missouri_eng . '/' . $lowest_temp;
                            $files_1[] = $path_missouri_eng . '/' . $min_file;
                            $files_1[] = $path_missouri_eng . '/' . $most_temp;
                            $files_1[] = $path_missouri_eng . '/' . $max_file;
                            $files_1[] = $path_missouri_eng . '/' . $next_days_file;
                            $files_1[] = $path_missouri_eng . '/' . $future_file;

                            $files_2[] = $path_missouri_french. '/' . $intro;
                            $files_2[] = $path_missouri_french. '/' . $loc_file;
                            $files_2[] = $path_missouri_french. '/' . $weather_file;
                            $files_2[] = $path_missouri_french. '/' . $lowest_temp;
                            $files_2[] = $path_missouri_french. '/' . $min_file;
                            $files_2[] = $path_missouri_french. '/' . $most_temp;
                            $files_2[] = $path_missouri_french. '/' . $max_file;
                            $files_2[] = $path_missouri_french. '/' . $next_days_file;
                            $files_2[] = $path_missouri_french. '/' . $future_file;

                            $files_3[] = $path_missouri_german . '/' . $intro;
                            $files_3[] = $path_missouri_german . '/' . $loc_file;
                            $files_3[] = $path_missouri_german . '/' . $weather_file;
                            $files_3[] = $path_missouri_german . '/' . $lowest_temp;
                            $files_3[] = $path_missouri_german . '/' . $min_file;
                            $files_3[] = $path_missouri_german . '/' . $most_temp;
                            $files_3[] = $path_missouri_german . '/' . $max_file;
                            $files_3[] = $path_missouri_german . '/' . $next_days_file;
                            $files_3[] = $path_missouri_german . '/' . $future_file;


                            $sms_text = utf8_encode($sms_text);

                            $response["msg"] = "Weather successfully added";
                            $response["min_temp"] = $min_temp;
                            $response["max_temp"] = $max_temp;
                            $response["date"] = $date;
                            $response["sms_text"] = $sms_text;
                            $response["success"] = 100;
                            $response["files_1"] = $files_1;
                            $response["files_2"] = $files_2;
                            $response["files_3"] = $files_3;
                        } else {
                            $response["msg"] = "No results found for Conditions";
                        }
                    } else {
                        $response["msg"] = "No results found for Conditions";
                    }

                } else {
                    $response["msg"] = "No results found for Location";
                }

            } else {
                $response["msg"] = "No results found for sms_parts";
            }

        }else if (!strcmp($state, 'florida')){


            $loc_id = $row['district'];
            $date = $row['date'];
            $min_temp = $row['min_temp'];
            $max_temp = $row['max_temp'];
            $today_id = $row['now_file_id'];
            $future_id = $row['future_file_id'];
            $sms_text = $row['sms_text'];

            $sql = "select * from sms_parts";

            doLog('[sr_getlastInsertedData][florida][Location] [sql: ' . $sql . ']');
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $max_file = '';
                $min_file = '';
                $intro = '';
                $next_days_file = '';
                $lowest_temp = '';
                $most_temp = '';

                while ($row = $result->fetch_assoc()) {
                    if ($row['param'] == 'max_' . $max_temp) {
                        $max_file = $row['value'];
                    }
                    if ($row['param'] == 'min_' . $min_temp) {
                        $min_file = $row['value'];
                    }
                    if ($row['param'] == 'obd_intro') {
                        $intro = $row['value'];
                    }
//                    if ($row['param'] == 'obd_next_days') {
//                        $next_days_file = $row['value'];
//                    }
                    if ($row['param'] == 'obd_lowest_temp') {
                        $lowest_temp = $row['value'];
                    }
                    if ($row['param'] == 'obd_maximum_temp') {
                        $most_temp = $row['value'];
                    }
                }

                $next_days_file = 'autoweather_0.wav';

                $sql = "SELECT aw_file_name FROM district_lang_def WHERE district = '$loc_id' ";

                doLog('[sr_getlastInsertedData][florida][Location] [sql: ' . $sql . ']');
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $response["location"] = $loc_id;
                    $loc_file = $row["aw_file_name"];


                    $sql = "SELECT title,file_name FROM aw_conditions WHERE id= $today_id ";

                    doLog('[sr_getlastInsertedData][florida][condition] [sql: ' . $sql . ']');
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $conditions['id'] = $today_id;
                        $response["condition"] = $row["title"];
                        $weather_file = $row["file_name"];


                        $sql = "SELECT title,file_name FROM aw_conditions WHERE id= $future_id ";

                        doLog('[sr_getlastInsertedData][florida][future condition] [sql: ' . $sql . ']');
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            // $future_conditions['id'] = $future_id;
                            $response["future_condition"] = $row["title"];
                            $future_file = $row["file_name"];

                            $files_10[] = $path_florida_eng . '/' . $intro;
                            $files_10[] = $path_florida_eng . '/' . $loc_file;
                            $files_10[] = $path_florida_eng . '/' . $weather_file;
                            $files_10[] = $path_florida_eng . '/' . $lowest_temp;
                            $files_10[] = $path_florida_eng . '/' . $min_file;
                            $files_10[] = $path_florida_eng . '/' . $most_temp;
                            $files_10[] = $path_florida_eng . '/' . $max_file;
                            $files_10[] = $path_florida_eng . '/' . $next_days_file;
                            $files_10[] = $path_florida_eng . '/' . $future_file;

//                            $files_2[] = $path_missouri_french. '/' . $intro;
//                            $files_2[] = $path_missouri_french. '/' . $loc_file;
//                            $files_2[] = $path_missouri_french. '/' . $weather_file;
//                            $files_2[] = $path_missouri_french. '/' . $lowest_temp;
//                            $files_2[] = $path_missouri_french. '/' . $min_file;
//                            $files_2[] = $path_missouri_french. '/' . $most_temp;
//                            $files_2[] = $path_missouri_french. '/' . $max_file;
//                            $files_2[] = $path_missouri_french. '/' . $next_days_file;
//                            $files_2[] = $path_missouri_french. '/' . $future_file;
//
//                            $files_3[] = $path_missouri_german . '/' . $intro;
//                            $files_3[] = $path_missouri_german . '/' . $loc_file;
//                            $files_3[] = $path_missouri_german . '/' . $weather_file;
//                            $files_3[] = $path_missouri_german . '/' . $lowest_temp;
//                            $files_3[] = $path_missouri_german . '/' . $min_file;
//                            $files_3[] = $path_missouri_german . '/' . $most_temp;
//                            $files_3[] = $path_missouri_german . '/' . $max_file;
//                            $files_3[] = $path_missouri_german . '/' . $next_days_file;
//                            $files_3[] = $path_missouri_german . '/' . $future_file;


                            $sms_text = utf8_encode($sms_text);

                            $response["msg"] = "Weather successfully added";
                            $response["min_temp"] = $min_temp;
                            $response["max_temp"] = $max_temp;
                            $response["date"] = $date;
                            $response["sms_text"] = $sms_text;
                            $response["success"] = 100;
                            $response["files_10"] = $files_10;
//                            $response["files_2"] = $files_2;
//                            $response["files_3"] = $files_3;
                        } else {
                            $response["msg"] = "No results found for Conditions";
                        }
                    } else {
                        $response["msg"] = "No results found for Conditions";
                    }

                } else {
                    $response["msg"] = "No results found for Location";
                }

            } else {
                $response["msg"] = "No results found for sms_parts";
            }

        }else if (!strcmp($state, 'hawaii')){


            $loc_id = $row['district'];
            $date = $row['date'];
            $min_temp = $row['min_temp'];
            $max_temp = $row['max_temp'];
            $today_id = $row['now_file_id'];
            $future_id = $row['future_file_id'];
            $sms_text = $row['sms_text'];

            $sql = "select * from sms_parts";

            doLog('[sr_getlastInsertedData][florida][Location] [sql: ' . $sql . ']');
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $max_file = '';
                $min_file = '';
                $intro = '';
                $next_days_file = '';
                $lowest_temp = '';
                $most_temp = '';

                while ($row = $result->fetch_assoc()) {
                    if ($row['param'] == 'max_' . $max_temp) {
                        $max_file = $row['value'];
                    }
                    if ($row['param'] == 'min_' . $min_temp) {
                        $min_file = $row['value'];
                    }
                    if ($row['param'] == 'obd_intro') {
                        $intro = $row['value'];
                    }
//                    if ($row['param'] == 'obd_next_days') {
//                        $next_days_file = $row['value'];
//                    }
                    if ($row['param'] == 'obd_lowest_temp') {
                        $lowest_temp = $row['value'];
                    }
                    if ($row['param'] == 'obd_maximum_temp') {
                        $most_temp = $row['value'];
                    }
                }

                $next_days_file = 'autoweather_0.wav';

                $sql = "SELECT aw_file_name FROM district_lang_def WHERE district = '$loc_id' ";

                doLog('[sr_getlastInsertedData][florida][Location] [sql: ' . $sql . ']');
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $response["location"] = $loc_id;
                    $loc_file = $row["aw_file_name"];


                    $sql = "SELECT title,file_name FROM aw_conditions WHERE id= $today_id ";

                    doLog('[sr_getlastInsertedData][florida][condition] [sql: ' . $sql . ']');
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $conditions['id'] = $today_id;
                        $response["condition"] = $row["title"];
                        $weather_file = $row["file_name"];


                        $sql = "SELECT title,file_name FROM aw_conditions WHERE id= $future_id ";

                        doLog('[sr_getlastInsertedData][florida][future condition] [sql: ' . $sql . ']');
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            // $future_conditions['id'] = $future_id;
                            $response["future_condition"] = $row["title"];
                            $future_file = $row["file_name"];

                            $files_20[] = $path_hawaii_eng . '/' . $intro;
                            $files_20[] = $path_hawaii_eng . '/' . $loc_file;
                            $files_20[] = $path_hawaii_eng . '/' . $weather_file;
                            $files_20[] = $path_hawaii_eng . '/' . $lowest_temp;
                            $files_20[] = $path_hawaii_eng . '/' . $min_file;
                            $files_20[] = $path_hawaii_eng . '/' . $most_temp;
                            $files_20[] = $path_hawaii_eng . '/' . $max_file;
                            $files_20[] = $path_hawaii_eng . '/' . $next_days_file;
                            $files_20[] = $path_hawaii_eng . '/' . $future_file;

//                            $files_2[] = $path_missouri_french. '/' . $intro;
//                            $files_2[] = $path_missouri_french. '/' . $loc_file;
//                            $files_2[] = $path_missouri_french. '/' . $weather_file;
//                            $files_2[] = $path_missouri_french. '/' . $lowest_temp;
//                            $files_2[] = $path_missouri_french. '/' . $min_file;
//                            $files_2[] = $path_missouri_french. '/' . $most_temp;
//                            $files_2[] = $path_missouri_french. '/' . $max_file;
//                            $files_2[] = $path_missouri_french. '/' . $next_days_file;
//                            $files_2[] = $path_missouri_french. '/' . $future_file;
//
//                            $files_3[] = $path_missouri_german . '/' . $intro;
//                            $files_3[] = $path_missouri_german . '/' . $loc_file;
//                            $files_3[] = $path_missouri_german . '/' . $weather_file;
//                            $files_3[] = $path_missouri_german . '/' . $lowest_temp;
//                            $files_3[] = $path_missouri_german . '/' . $min_file;
//                            $files_3[] = $path_missouri_german . '/' . $most_temp;
//                            $files_3[] = $path_missouri_german . '/' . $max_file;
//                            $files_3[] = $path_missouri_german . '/' . $next_days_file;
//                            $files_3[] = $path_missouri_german . '/' . $future_file;


                            $sms_text = utf8_encode($sms_text);

                            $response["msg"] = "Weather successfully added";
                            $response["min_temp"] = $min_temp;
                            $response["max_temp"] = $max_temp;
                            $response["date"] = $date;
                            $response["sms_text"] = $sms_text;
                            $response["success"] = 100;
                            $response["files_20"] = $files_20;
//                            $response["files_2"] = $files_2;
//                            $response["files_3"] = $files_3;
                        } else {
                            $response["msg"] = "No results found for Conditions";
                        }
                    } else {
                        $response["msg"] = "No results found for Conditions";
                    }

                } else {
                    $response["msg"] = "No results found for Location";
                }

            } else {
                $response["msg"] = "No results found for sms_parts";
            }

        }
    }

} else {
    header('Location: ../php/logout.php');
}


echo json_encode($response);
?>
