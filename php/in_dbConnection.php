<?php

session_start();

$servername             = "wdb1";
$username               = "root";
$password               = "root";
$dbname                 = "alex11";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    $servername   = "wdb1";
    $username     = "root";
    $password     = "root";
    $dbname       = "alex11";
   $conn = new mysqli($servername, $username, $password, $dbname);
    echo "db error";
    die();
}

$wdc_servername         = "wdb1.t";
$wdc_username           = "root";
$wdc_password           = "root";
$wdc_dbname             = "watson_qms";

$wdc_conn = new mysqli($wdc_servername, $wdc_username, $wdc_password, $wdc_dbname);

if ($wdc_conn->connect_error) {
    $servername   = "wdb1.t";
     $username     = "root";
    $password     = "root";
    $dbname       = "watson_qms";
$wdc_conn = new mysqli($servername, $username, $password, $dbname);
}



// //$biServername   = "192.168.73.4";
// //$biUsername     = "root";
// //$biPassword     = "root";
// //$biDbname       = "magri_location_db";

// //$biConn = new mysqli($biServername, $biUsername, $biPassword, $biDbname);



// // watson Aangan DATABASE
// $ka_servername          = "damg7.t";
// $ka_username            = "root";
// $ka_password            = "root";
// $ka_dbname              = "magri_women";

// $ka_conn = new mysqli($ka_servername, $ka_username, $ka_password, $ka_dbname);

// if ($ka_conn->connect_error) {
//     $servername   = "damg7.t";
//     $username     = "root";
//     $password     = "root";
//     $dbname       = "magri_women";
// $ka_conn = new mysqli($servername, $username, $password, $dbname);
// }

// //watson rose
// $km_servername		="damg10.t";
// $km_username		="root";
// $km_password		="root";
// $km_dbname		="watson_rose";

// $km_conn = new mysqli($km_servername,$km_username,$km_password,$km_dbname);

// if ($km_conn->connect_error) {
//     $servername   = "damg10.t";
//     $username     = "root";
//     $password     = "root";
//     $dbname       = "watson_rose";
// $km_conn = new mysqli($servername, $username, $password, $dbname);
// }


// //watson bimma
// $kb_servername="damg10.t";
// $kb_username="root";
// $kb_password="root";
// $kb_dbname="watson_bima";
// $kb_conn = new mysqli($kb_servername,$kb_username,$kb_password,$kb_dbname);

// if ($kb_conn->connect_error) {
//     $servername   = "damg10.t";
//     $username     = "root";
//     $password     = "root";
//     $dbname       = "watson_bima";
// $kb_conn = new mysqli($servername, $username, $password, $dbname);
// }


//watson william
$kk_servername="wdb1.t";
$kk_username="root";
$kk_password="root";
$kk_dbname="watson_william";
$kk_conn = new mysqli($kk_servername,$kk_username,$kk_password,$kk_dbname);

if ($kk_conn->connect_error) {
    $servername   = "wdb1.t";
    $username     = "root";
    $password     = "root";
    $dbname       = "watson_william";
$kk_conn = new mysqli($servername, $username, $password, $dbname);
}

// //watson jeewan
// $kj_servername="damg10.t";
// $kj_username="root";
// $kj_password="root";
// $kj_dbname="watson_guard";
// $kj_conn = new mysqli($kj_servername,$kj_username,$kj_password,$kj_dbname);


// //radio magan
// $rm_servername="dmagrm1.t";
// $rm_username="root";
// $rm_password="root";
// $rm_dbname="magri_rm";
// $rm_conn = new mysqli($rm_servername,$rm_username,$rm_password,$rm_dbname);

// if ($kk_conn->connect_error) {
// 	$rm_servername="dmagrm1.t";
// 	$rm_username="root";
// 	$rm_password="root";
// 	$rm_dbname="magri_rm";
// $kk_conn = new mysqli($servername, $username, $password, $dbname);
// }

// //watson Nama
// $kn_servername="damg10.t";
// $kn_username="root";
// $kn_password="root";
// $kn_dbname="watson_nama";
// $kn_conn = new mysqli($kn_servername,$kn_username,$kn_password,$kn_dbname);

// if ($kn_conn->connect_error) {
//     $servername   = "damg10.t";
//     $username     = "root";
//     $password     = "root";
//     $dbname       = "watson_nama";
// $kn_conn = new mysqli($servername, $username, $password, $dbname);
// }




//watson  Tahaffuz
//$ci_servername          ="wdb1.t";
//$ci_username            ="root";
//$ci_password            ="root";
//$ci_dbname              ="watson_tahafuz";

//$ci_conn = new mysqli($ci_servername,$ci_username,$ci_password,$ci_dbname);

//if ($ci_conn->connect_error) {
  //  $servername   = "wdb1.t";
   // $username     = "root";
   // $password     = "root";
    //$dbname       = "watson_tahafuz";
//$ci_conn = new mysqli($servername, $username, $password, $dbname);
//}


// //Zarai Directory
// $zd_servername="damg10.t";
// $zd_username="root";
// $zd_password="root";
// $zd_dbname="agri_mart";
// $zd_conn = new mysqli($zd_servername,$zd_username,$zd_password,$zd_dbname);

// if ($zd_conn->connect_error) {
//     $servername   = "damg10.t";
//     $username     = "root";
//     $password     = "root";
//     $dbname       = "agri_mart";
// $zd_conn = new mysqli($servername, $username, $password, $dbname);
// }


//bulk_unsub for paid walls
$bu_servername="wdb1.t";
$bu_username="root";
$bu_password="root";
$bu_dbname="bulk_sub_unsub";
$bu_conn = new mysqli($bu_servername,$bu_username,$bu_password,$bu_dbname);

// //watson Amdani
// $kad_servername="damg10.t";
// $kad_username="root";
// $kad_password="root";
// $kad_dbname="watson_amdani";
// $kad_conn = new mysqli($kad_servername,$kad_username,$kad_password,$kad_dbname);

// if ($kad_conn->connect_error) {
//     $servername   = "damg10.t";
//     $username     = "root";
//     $password     = "root";
//     $dbname       = "watson_amdani";
// $kad_conn = new mysqli($servername, $username, $password, $dbname);
// }

// //watson Amdani
// $kt_servername="damg10.t";
// $kt_username="root";
// $kt_password="root";
// $kt_dbname="watson_tahaffuz";
// $kt_conn = new mysqli($kt_servername,$kt_username,$kt_password,$kt_dbname);




?>
