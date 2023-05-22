<?php

require_once('in_dbConnection.php');
require_once('in_common.php');
require_once ('in_session.php');


userLogActivity($conn, 'LOGOUT');

session_start();
if (isset($_SESSION['username'])) {
    session_destroy();
    unset($_SESSION['username']);
    header('Location: ../index.php');
}
header('Location: ../index.php');
?>