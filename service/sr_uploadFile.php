<?php

require_once('../php/in_dbConnection.php');
require_once('../php/in_common.php');

$userid = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$role = $_SESSION['role'];

if (isset($userid) && in_array($role, $batch_user )) {
    ini_set('memory_limit', '-1');
    set_time_limit(0);
    $title = $_POST['title'];


    $action = $_POST['action'];
    $cellno='';
    $terminator = ",";
    $is_active=array();


    $file_names = isset($_POST['file']) ? $_POST['file'] : '';

    $response = array("success"=>-100);
    $target_file = $target_dir.$path_parts['filename'].'_'.date('m-d-Y_hia').'.'.$path_parts['extension'];
    $fileName = $_FILES["file"]["name"];
    $path_parts = pathinfo($fileName);
    $target_file = $target_dir.$path_parts['filename'].'_'.date('m-d-Y_hia').'.'.$path_parts['extension'];


    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $numbers = array();
        $invalidNumbers = array();
        $validNumbers = array();
        if (($handle = fopen($target_file, "r")) !== FALSE) {
            ini_set('auto_detect_line_endings',TRUE);
            while($data = fgetcsv($handle, 1000, ",")) {

                $num = count($data);

                for ($c = 0; $c < $num; $c++) {
                    $cellno = trim($data[$c]);
                    if (!empty($cellno)) {
                        $numbers[] = $cellno;
                        if (strlen($cellno) == 11 && !strcmp(substr($cellno, 0, 2), '03')) {
                            array_push($validNumbers, $cellno);

                        } else {
                            array_push($invalidNumbers, $cellno);
                        }
                    }
                }
            }
            $totalNumbers  =count($numbers);
            $validNumCount = count($validNumbers);
            $invalidNumCount = count($invalidNumbers);
            $query = "INSERT INTO ba_uploads(title,file_name,action,dt,login_id,total_rec_cnt,valid_rec_cnt,invalid_rec_cnt,comments) VALUES 
            ('$title','$fileName','$action',now(),'$userid',$totalNumbers,$validNumCount,$invalidNumCount,'new upload')";
            $result=$conn->query($query);
            $last_id = $conn->insert_id;
            $list_table='list_'.$last_id;
            doLog("[Last insert id in ba_uploads table][upload_id][ '$list_table' ]");

            $create_query="CREATE TABLE `".$list_table."` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `upload_id` int(11) DEFAULT NULL,
              `cellno` varchar(15) DEFAULT NULL,
              `dt` datetime DEFAULT NULL,
              `status` int(100) DEFAULT NULL,
              `comments` varchar(255) DEFAULT NULL,
              `action` varchar(50) DEFAULT NULL,
              KEY `id` (`id`)
            ) ";
            doLog("[create table][List table][ '$create_query' ]");
            $result=$conn->query($create_query);
            if(!$result){
                $response['msg']='Table not created';
            }
            while (!feof($handle)) {

                $line = fgets($handle, 4096);
            }
            $number=$data[0];
            $sql = 'LOAD DATA LOCAL INFILE "' . $target_file . '" 
		                                INTO TABLE ' . $list_table . '
		                                FIELDS TERMINATED BY "' . $terminator . '" OPTIONALLY ENCLOSED BY "\""
		                                LINES TERMINATED BY "\r\n"
		                                (cellno)';
            doLog("[ba_lists][List Query][ '$sql' ]");

            $result=$conn->query($sql);
            if(!$result){
                $response['msg']='Not inserted data into '.$list_table.'';
            }
            $sql2="UPDATE $list_table SET upload_id='$last_id',STATUS='0',ACTION='$action',dt=NOW() WHERE comments IS NULL";
            doLog("[update ba_lists][update Query][ '$sql2' ]");

            $result=$conn->query($sql2);
            if(!$result){
                $response['msg']='table '.$list_table.' not update';
            }


            ini_set('auto_detect_line_endings',FALSE);
            fclose($handle);
        }
            $sql = "DELETE  FROM $list_table  WHERE LENGTH(cellno)!=11 OR NOT cellno REGEXP '^[0-9]+$' OR NOT cellno LIKE '03%'";
            doLog("['$list_table'][Delete wrong cellno][ '$sql' ]");

            $wrong_cellno=mysqli_query($conn,$sql);
            if(!$wrong_cellno){
                $response['msg']='Wrong format cell numbers are deleted';
            }
            if($action=='UnSubscribe') {
                $sql = "SELECT sb.cellno FROM subscriber AS sb JOIN $list_table ON sb.`cellno`=$list_table.cellno WHERE  DATE(last_call_dt) >= DATE(NOW()) - INTERVAL 30 DAY";
                doLog("['$list_table'][Select active subscriber][ '$sql' ]");
                $num='';
                $result = mysqli_query($conn, $sql);
                $is_active = mysqli_num_rows($result);
            }
            $response['totalNumbers']=$totalNumbers;
            $response['validNumbers']=$validNumCount;
            $response['invalidNumbers']=$invalidNumCount;
            $response['uploadId'] = $last_id;
            $response['tbl_name']=$list_table;
            $response['sub_num']=$is_active;

             $response['success']=100;

    }else {
        $response["msg"] = "Sorry, there was an error uploading your file.";
    }
    echo json_encode($response);
}else {
    header('Location: ../php/logout.php');
}