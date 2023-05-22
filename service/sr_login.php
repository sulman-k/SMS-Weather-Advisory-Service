<?php
require_once('../php/in_dbConnection.php');
require_once('../php/in_common.php');

$username = $_POST['username'];
$password = $_POST['password'];
$username = $conn->real_escape_string($username);
$password = $conn->real_escape_string($password);
$response = array("success" => -100);
$page = '';

if ($username) {
    $sql = "SELECT * FROM `users` where user_id='$username' AND password='$password'";
    $result = $conn->query($sql);
    doLog('[sr_login][Finding credentials] [username: ' . $username . '][sql: ' . $sql . ' ]');

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        doLog('[sr_login][Found user] [Username: ' . $username . ']');

        $response["msg"] = "Login data found";
        $response["success"] = 100;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $row['role'];

        if (in_array($row['role'], $admin)) {
            $page = 'menu.php';
        } else if (in_array($row['role'], $cro)) {
            $page = 'subscribers.php';
        } else if (in_array($row['role'], $ops)) {
            $page = 'advisory.php';
        } else if (in_array($row['role'], $content)) {
            $page = 'add_weather.php';
        }else if (in_array($row['role'], $batch_user)) {
            $page = 'batchRequest.php';
        }else if (in_array($row['role'],$obdadmin)){
            $page='obd.php';
        }else if(in_array($row['role'],$crop)){
            $page='send_sms.php';
        }else if(in_array($row['role'],$bulk_unsub)){
            $page='bulk_unsub.php';
        }else if(in_array($row['role'],$paid_wall_unsub)){
            $page='paidwall_msisdn_unsub.php';
        }

        $response["page"] = $page;

        doLog('[sr_login][Found Login credentials] [username: ' . $username . '] .....' . $_SESSION['username']);

        userLogActivity($conn, 'LOGIN_SUCCESSFUL');

    } else {
        $response["msg"] = "Wrong username or password";
        userLogActivity($conn, 'LOGIN_UN-SUCCESSFUL');
    }
}

echo json_encode($response);
?>