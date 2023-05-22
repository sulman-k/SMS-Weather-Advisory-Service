<?php
/**
 * Created by PhpStorm.
 * User: mm
 * Date: 1/30/2020
 * Time: 4:46 PM
 */
require_once ('../php/in_dbConnection.php');
require_once ('../php/in_session.php');
require_once ('../php/in_common.php');
$username=$_SESSION['username'];
$role=$_SESSION['role'];
$response=array("success"=>-100);
$name=isset($_POST['job_name'])?$_POST['job_name']:'';
$action=isset($_POST['action'])?$_POST['action']:'';
$service=isset($_POST['service'])?$_POST['service']:'';
$selectedAmountCode=isset($_POST['service_amount'])?$_POST['service_amount']:'';
$file_name=$_FILES['cellno_file']["name"];
$files=$_FILES['cellno_file']["tmp_name"];
mysqli_options($bu_conn, MYSQLI_OPT_LOCAL_INFILE, true);
$size=$_FILES['cellno_file']['size'];
$target_path=$target_dir.'/'.$file_name.'_'.date('Y-m-d_hia');
if(isset($username)&&in_array($role,$bulk_unsub)){
     if($size>0){
          $sql="Insert into bulk_sub_unsub_job (`title`,`status`,`action`,`paid_wall_id`,`paid_wall_code`,`upload_dt`,`file_name`,`generated_by`) VALUES ('$name',-100,'$action','$service','$selectedAmountCode',NOW(),'$file_name','$username')";
          doLog('[sr_uploadUnsubFile.php][insert into job ] [sql: ' . $sql . ']');
          $result=$bu_conn->query($sql);
          if($result){
            $last_id=$bu_conn->insert_id;
            $table_name='list_'.$last_id;
            $sql="CREATE TABLE  IF NOT EXISTS $table_name (id int NOT NULL AUTO_INCREMENT,cellno VARCHAR(25),payplancode VARCHAR(25) DEFAULT '$selectedAmountCode',status int(11) not null DEFAULT -100,PRIMARY KEY(id)) ";
            doLog('[sr_uploadUnsubFile.php][create table ] [sql: ' . $sql . ']');
            $result=$bu_conn->query($sql);
            if($result){
                 if(!is_dir($target_dir)){
                     mkdir($target_dir,0777,true);
                 }
                 if(move_uploaded_file($files, $target_path)){
                     $sql="load data local infile '$target_path'  into table $table_name fields terminated by ','
                      optionally enclosed by '\"' lines terminated by '\r\n' IGNORE 0 LINES(cellno)";

                     doLog('[sr_uploadUnsubFile.php][load file data into table] [sql: ' . $sql . ']');
                     $result=$bu_conn->query($sql);
                     if($result){

                      $sql="Delete from $table_name where LENGTH (cellno)!= 11 OR NOT cellno REGEXP '^[0-9]+$' OR NOT cellno like '03%'";
                     doLog('[sr_uploadUnsubFile.php][load file data into table] [sql: ' . $sql . ']');
                     $result=$bu_conn->query($sql);
                     if($result){
                         $sql="Select count(*) as valid_cellno from $table_name";
                         doLog('[sr_uploadUnsubFile.php][count of list table] [sql: ' . $sql . ']');
                         $result=$bu_conn->query($sql);
                         if($result->num_rows>0){
                             $row=$result->fetch_assoc();
                             $total=$row['valid_cellno'];
                             $sql="Update  bulk_sub_unsub_job set `max_ptr`='$total' where `id`='$last_id'";
                             doLog('[sr_uploadUnsubFile.php][update bulk_sub_unsub table] [sql: ' . $sql . ']');
                             $result=$bu_conn->query($sql);
                             if($result){
                                 $response['success']=100;
                                 $response['msg']='Successfully upload '.''.$total.' valid cellno';
                             }else{
                                 $response['msg']='Sorry table not update';
                             }
                         }else{
                             $response['msg']='Failed to get the valid cellno count';
                         }
                     }
                     }else{
                         $response['msg']='Sorry data not load into table';
                     }
                 }else{
                         $response['msg']='Uploaded file not moved';
                 }
            }else{
                $response['msg']='Sorry new table not created';
            }
          }else{
            $response['msg']='Record not inserted';
          }

     }else{
          $response['msg']='File is empty';
     }

}else{
    header('Location: ../php/logout.php');
}
echo json_encode($response);


?>