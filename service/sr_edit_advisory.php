<?php
require_once('../php/in_common.php');
require_once('../php/in_dbConnection.php');

$userid = $_SESSION['username'];
$role = $_SESSION['role'];

$src = isset($_POST['src']) ? $_POST['src'] : '';

$response = array("success" => -100, "msg" => "");

if (isset($userid) && in_array($role, $ops)) {
    $extensions = array("wav");

    if (strcmp($src, "gb")) {

        $dt = isset($_POST['dt']) ? $_POST['dt'] : '';
        $srvc_selected = isset($_POST['services']) ? $_POST['services'] : '';


        $sql = "SELECT * FROM srvc_content WHERE srvc_dt = '$dt' AND srvc_id = '$srvc_selected' AND tag_1 = '$src'";
        doLog('[sr_edit_advisory.php][advisory edit] [sql: ' . $sql . ']');
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {


            $date = implode('_', explode('-', $dt));
            $file_names = $_POST['file_names'];
            $file_names = explode(",", $file_names);



            $insert_sqls = array();

            $all_files_valid = true;


            foreach ($file_names as $fname) {


                $file = (Object)$_FILES[$fname];

                $fnames = explode("_", $fname);

                $state = $fnames[0];
                $srvc_id = $fnames[1];
                $lang = $fnames[2];

                $path = $base_path . '/advisory/' . $state;
                $path = $path . '/' . $lang;

                $title = ucfirst($state) . '_' . ucfirst($srvc_id) . '_' . ucfirst($lang) . '_' . 'Advisory_' . $date;

                $file_name = $file->name;

                $file_size = $file->size;
                $file_tmp = $file->tmp_name;

                doLog('sr_edit_advisory] [file_name: ' . $file_name . '][size: ' . $file_size . ' ]');

                if ($file_size == 0) {
                    doLog('sr_edit_advisory] [file_name: ' . $fname . '] ========== is Empty =========== Size: ' . $file_size);
                    $response["msg"] = $response["msg"] . $fname . '<br>';
                    $all_files_valid = false;
                    continue;
                }

                $file_type = $file->type;

                $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                $is_file_name_valid = (false === strpbrk($file_name, $illegal)) ? 1 : 0;

                if ($is_file_name_valid) {

                    $result = '';

                    if (in_array($file_ext, $extensions) == true) {

                        if (!is_dir($path)) {
                            mkdir($path, 0777, true);
                        }
                        if (!is_dir($temp_path)) {
                            mkdir($temp_path, 0777, true);
                        }

                        $timestamp = date("YmdHis");

                        $temp_file = $timestamp . '_' . $file_name;
                        $temp_file_path = $temp_path . '/' . $temp_file;

                        $name = explode('.', $file_name);

                        $new_file = $state . '_' . $srvc_id . '_advisory' . '_' . $date;
                        $new_file_path = $path . '/' . $new_file . '.wav';

                        doLog('sr_edit_advisory] [file_name: ' . $file_name . '] [new file: ' . $new_file . ']');

                        move_uploaded_file($file_tmp, $temp_file_path);

                        $res = shell_exec("file -b " . $temp_file_path);

                        doLog('sr_edit_advisory.php] [new file: ' . $new_file . '][shell_exec: res ' . $res . ']');

                        $isValid = preg_match("/mono 8000 Hz/", $res) <= 0 ? false : true;

                        doLog('sr_edit_advisory.php] [new file: ' . $new_file . '] [ matching mono 8000 Hz: isValid: ' . $isValid . ']');

                        if ($isValid) {
                            $isValid = preg_match("/16 bit/", $res) <= 0 ? false : true;
                        }

                        doLog('sr_edit_advisory.php] [new file: ' . $new_file . '] [ matching 16 bit: isValid: ' . $isValid . ']' . strtoupper(substr(PHP_OS, 0, 3)));


                        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                            $isValid = true;
                        }

                        if ($isValid) {
                            $moveRes = @copy($temp_file_path, $new_file_path);
                            unlink($temp_file_path);

                            if ($moveRes) {

                                //$insert_sqls[] = "INSERT INTO `srvc_content` (`title`, `srvc_id`, `tag_1`, `tag_2`, `dt`, `file_name`, `lang`, `status`) VALUES ('$title', '$srvc_id', '$state', 'Advisory', NOW(), '$new_file', '$lang', 100)";
                                $insert_sqls[] = "UPDATE srvc_content SET dt = NOW() WHERE srvc_dt = '$dt' AND srvc_id = '$srvc_id' AND lang = '$lang' AND tag_1 = '$state'";

                            } else {
                                $response['msg'] = $response["msg"] . 'Unable to copy the file after uploading, Try Again <br>';
                                $all_files_valid = false;
                            }

                        } else {
                            $all_files_valid = false;
                            $response['msg'] = $response["msg"] . "File is not valid <br>";
                            doLog('sr_edit_advisory.php] [msg: ' . $response['msg']);
                        }
                    } else {
                        $all_files_valid = false;
                        $response["msg"] = $response["msg"] . $file_name . ' has extension [ ' . $file_ext . " ]  which is not allowed, please choose a wav file. <br>";
                    }

                } else {
                    $all_files_valid = false;
                    $response["msg"] = $response["msg"] . $file_name . ' is not valid please remove spaces or special characters <br>';
                }
            }

            if ($all_files_valid) {

                foreach ($insert_sqls as $sql) {

                    doLog('[sr_edit_advisory][insert_sqls][sql: ' . $sql . ']');
                    $result = $conn->query($sql);
                    if ($result) {
                        $response["success"] = 100;
                    }
                }

            } else {
                $response["msg"] = $response["msg"] . " and Unable to add new Advisory";
            }
        } else {
            $response["msg"] = "No record found against these date and crop, Please add new Advisory first";
        }


        echo json_encode($response);

    } else {


        $dt_gb = isset($_POST['dt_gb']) ? $_POST['dt_gb'] : '';
        //$srvc_id = isset($_POST['services']) ? $_POST['services'] : '';
        $date = implode('_', explode('-', $dt_gb));

       // $srvc_selected = isset($_POST['services']) ? $_POST['services'] : '';


        $sql = "SELECT * FROM srvc_content WHERE srvc_dt = '$dt_gb'";
        doLog('[sr_edit_advisory.php][advisory edit] [sql: ' . $sql . ']');
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {


            if (sizeof($_FILES) > 0) {

                $file = (Object)$_FILES["advisory_file_gb"];

                $title = 'kansas_' . '_Advisory_' . $date;

                $file_name = $file->name;

                $file_size = $file->size;
                $file_tmp = $file->tmp_name;

                $path = $base_path . '/advisory/' . 'gb';
                $lang = 'eng';
                $path = $path . '/' . $lang;

                doLog('sr_edit_advisory] [file_name: ' . $file_name . '][size: ' . $file_size . ' ]');

                if ($file_size == 0) {
                    doLog('sr_edit_advisory] [file_name: advisory_file_gb] ========== is Empty =========== Size: ' . $file_size);
                    $response["msg"] = $response["msg"] . 'advisory_file_gb <br>';
                }

                $file_type = $file->type;

                $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                $is_file_name_valid = (false === strpbrk($file_name, $illegal)) ? 1 : 0;

                if ($is_file_name_valid) {

                    $result = '';

                    if (in_array($file_ext, $extensions) == true) {

                        if (!is_dir($path)) {
                            mkdir($path, 0777, true);
                        }
                        if (!is_dir($temp_path)) {
                            mkdir($temp_path, 0777, true);
                        }

                        $timestamp = date("YmdHis");

                        $temp_file = $timestamp . '_' . $file_name;
                        $temp_file_path = $temp_path . '/' . $temp_file;

                        $name = explode('.', $file_name);

                        $new_file = 'kansas_advisory_' . $date;
                        $new_file_path = $path . '/' . $new_file . '.wav';

                        doLog('sr_edit_advisory] [file_name: ' . $file_name . '] [new file: ' . $new_file . ']');

                        move_uploaded_file($file_tmp, $temp_file_path);

                        $res = shell_exec("file -b " . $temp_file_path);

                        doLog('sr_edit_advisory.php] [new file: ' . $new_file . '][shell_exec: res ' . $res . ']');

                        $isValid = preg_match("/mono 8000 Hz/", $res) <= 0 ? false : true;

                        doLog('sr_edit_advisory.php] [new file: ' . $new_file . '] [ matching mono 8000 Hz: isValid: ' . $isValid . ']');

                        if ($isValid) {
                            $isValid = preg_match("/16 bit/", $res) <= 0 ? false : true;
                        }

                        doLog('sr_edit_advisory.php] [new file: ' . $new_file . '] [ matching 16 bit: isValid: ' . $isValid . ']' . strtoupper(substr(PHP_OS, 0, 3)));


                        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                            $isValid = true;
                        }

                        if ($isValid) {
                            $moveRes = @copy($temp_file_path, $new_file_path);
                            unlink($temp_file_path);

                            if ($moveRes) {

                                //$sql = "INSERT INTO `srvc_content` (`title`, `srvc_id`, `tag_1`, `tag_2`, `dt`, `file_name`, `lang`, `status`) VALUES ('$title', '$srvc_id', 'gb', 'Advisory', NOW(), '$new_file', 'eng', 100)";
                                $sql = "UPDATE srvc_content SET dt = NOW() WHERE srvc_dt = '$dt_gb' AND lang = '$lang'";

                                doLog('[sr_edit_advisory][GB][sql: ' . $sql . ']');
                                $result = $conn->query($sql);
                                if ($result) {
                                    $response["success"] = 100;
                                }

                            } else {
                                $response['msg'] = $response["msg"] . 'Unable to copy the file after uploading, Try Again <br>';
                            }

                        } else {
                            $response['msg'] = $response["msg"] . "File is not valid <br>";
                            doLog('sr_edit_advisory.php][GB] [msg: ' . $response['msg']);
                        }
                    } else {
                        $response["msg"] = $response["msg"] . $file_name . ' has extension [ ' . $file_ext . " ]  which is not allowed, please choose a wav file. <br>";
                    }

                } else {
                    $response["msg"] = $response["msg"] . $file_name . ' is not valid please remove spaces or special characters <br>';
                }
            } else {
                $response["msg"] = "No file found to upload";
            }
        }else{
            $response["msg"] = "No record found to against date";
        }
        echo json_encode($response);
    }
} else {
    header('Location: ../php/logout.php');
}

?>
