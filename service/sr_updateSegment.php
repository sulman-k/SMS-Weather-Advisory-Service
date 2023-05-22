<?php
require_once('../php/in_common.php');
require_once('../php/in_dbConnection.php');

$userid = $_SESSION['username'];
$role = $_SESSION['role'];

$title = isset($_POST['title']) ? $_POST['title'] : '';

$seg_order = isset($_POST['seg_order']) ? $_POST['seg_order'] : '';
$menu_id = isset($_POST['menu_id']) ? $_POST['menu_id'] : '';
$id = isset($_POST['id']) ? $_POST['id'] : '';

$response = array("success" => -100, "msg" => "");
$file_names = array("file_1" => null, "file_2" => null, "file_3" => null, "file_4" => null, "file_5" => null, "file_6" => null, "file_7" => null, "file_8" => null, "file_9" => null);

$extensions = array("wav");

if (isset($userid) && in_array($role, $admin)) {

    $all_files_valid = true;

    for ($i = 1; $i <= sizeof($_FILES); $i++) {

        $file = (Object)$_FILES['file_' . $i];

        $file_name = $file->name;

        $file_size = $file->size;
        $file_tmp = $file->tmp_name;

        doLog('sr_updateSegment.php] [file_name: ' . $file_name . '][size: ' . $file_size . ' ]');

        if ($file_size == 0) {
            doLog('sr_addSegment.php] [file_name: ' . $file_name . '] ========================== Size: ' . $file_size);
            continue;
        }

        $file_type = $file->type;

        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $is_file_name_valid = (false === strpbrk($file_name, $illegal)) ? 1 : 0;

        if ($is_file_name_valid) {

            $tbl = '';
            $result = '';

            if (in_array($file_ext, $extensions) == true) {

                if (!is_dir($menu_path)) {
                    mkdir($menu_path, 0777, true);
                }
                if (!is_dir($temp_path)) {
                    mkdir($temp_path, 0777, true);
                }

                $timestamp = date("YmdHis");

                $temp_file = $timestamp . '_' . $file_name;
                $temp_file_path = $temp_path . '/' . $temp_file;

                $name = explode('.', $file_name);

                $new_file = $name[0] . '_' . $timestamp;
                $new_file_path = $menu_path . '/' . $new_file . '.wav';

                doLog('sr_updateSegment.php] [file_name: ' . $file_name . '] [new file: ' . $new_file . ']');

                move_uploaded_file($file_tmp, $temp_file_path);

                $res = shell_exec("file -b " . $temp_file_path);

                doLog('sr_updateSegment.php] [new file: ' . $new_file . '][shell_exec: res ' . $res . ']');

                $isValid = preg_match("/mono 8000 Hz/", $res) <= 0 ? false : true;

                doLog('sr_updateSegment.php] [new file: ' . $new_file . '] [ matching mono 8000 Hz: isValid: ' . $isValid . ']');

                if ($isValid) {
                    $isValid = preg_match("/16 bit/", $res) <= 0 ? false : true;
                }

                doLog('sr_updateSegment.php] [new file: ' . $new_file . '] [ matching 16 bit: isValid: ' . $isValid . ']' . strtoupper(substr(PHP_OS, 0, 3)));


                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    $isValid = true;
                }

                if ($isValid) {
                    $moveRes = @copy($temp_file_path, $new_file_path);
                    unlink($temp_file_path);

                    if ($moveRes) {

                        $file_names['file_' . $i] = $new_file;

                    } else {
                        $response["msg"] = $response["msg"] .' Unable to copy the file after uploading, Try Again<br>';
                        $all_files_valid = false;
                    }

                } else {
                    $all_files_valid = false;
                    $response["msg"] = $response["msg"] . " [ ".$file_name . " ] is not valid<br>";
                    doLog('sr_updateSegment.php] [msg: ' . $response['msg']);
                }
            } else {
                $all_files_valid = false;
                $response["msg"] = $response["msg"] . ' [ '. $file_name . ' ] has extension [ ' . $file_ext . " ]  which is not allowed, please choose a wav file.<br>";
            }

        } else {
            $all_files_valid = false;
            $response["msg"] = $response["msg"] ." [ ". $file_name . " ] is not valid please remove spaces or special characters<br>";
        }
    }

    $fl_nm = (Object)$file_names;

    if ($all_files_valid) {
        $sql = "UPDATE `menu_segment` SET
            `title` = '$title',
             `menu_id` = $menu_id,
             `seg_order`= $seg_order,
             `seg_file_1`= '$fl_nm->file_1',
             `seg_file_2`= '$fl_nm->file_2',
             `seg_file_3`= '$fl_nm->file_3',
             `seg_file_4`= '$fl_nm->file_4',
             `seg_file_5`= '$fl_nm->file_5',
             `seg_file_6`= '$fl_nm->file_6',
             `seg_file_7`= '$fl_nm->file_7',
             `seg_file_8`= '$fl_nm->file_8',
             `seg_file_9`= '$fl_nm->file_9' WHERE id = $id";

        doLog('[sr_updateSegment][sql: ' . $sql . ']');
        $result = $conn->query($sql);
        if ($result) {

            $response["success"] = 100;

        }

    } else {
        $response["msg"] = $response["msg"] . " and Unable to Update Segment";
    }


} else {
    header('Location: ../php/logout.php');
}

echo json_encode($response);
?>
