<?php



session_start();
$servername		= "dmast01";
$username		= "root";
$password		= "magriops";
$dbname			= "test_agri_v2";

$conn = new mysqli($servername, $username, $password, $dbname);

$wdc_servername		= "dmast01.t";
$wdc_username		= "root";
$wdc_password		= "magriops";
$wdc_dbname		= "web_doc";

$wdc_conn = new mysqli($wdc_servername, $wdc_username, $wdc_password, $wdc_dbname);

$biServername		= "dmast01.t";
$biUsername		= "root";
$biPassword		= "magriops";
$biDbname		= "magri_location_db";

$biConn = new mysqli($biServername, $biUsername, $biPassword, $biDbname);



// watson Aangan DATABASE
$ka_servername		= "dmast01";
$ka_username		= "root";
$ka_password		= "magriops";
$ka_dbname		= "magri_women";

$ka_conn = new mysqli($ka_servername, $ka_username, $ka_password, $ka_dbname);

$biServername           = "dmast01.t";
$biUsername             = "root";
$biPassword             = "magriops";
$biDbname               = "magri_location_db";

$biConn = new mysqli($biServername, $biUsername, $biPassword, $biDbname);
///
$wdc_servername		= "dmast01";
$wdc_username		= "root";
$wdc_password		= "magriops";
$wdc_dbname		= "web_doc";

$wdc_conn = new mysqli($wdc_servername, $wdc_username, $wdc_password, $wdc_dbname);



// watson Aangan DATABASE
$ka_servername          = "dmast01.t";
$ka_username            = "root";
$ka_password            = "magriops";
$ka_dbname              = "magri_women";

$ka_conn = new mysqli($ka_servername, $ka_username, $ka_password, $ka_dbname);







$wdc_servername         = "dmast01.t";
$wdc_username           = "root";
$wdc_password           = "magriops";
$wdc_dbname             = "web_doc";

$wdc_conn = new mysqli($wdc_servername, $wdc_username, $wdc_password, $wdc_dbname);

if ($wdc_conn->connect_error) {
    $servername   = "dmast01.t";
    $username     = "root";
    $password     = "magriops";
    $dbname       = "web_doc";
$wdc_conn = new mysqli($servername, $username, $password, $dbname);
}



$biServername   = "192.168.73.63";
$biUsername     = "root";
$biPassword     = "magriops";
$biDbname       = "magri_location_db";

$biConn = new mysqli($biServername, $biUsername, $biPassword, $biDbname);






// watson Aangan DATABASE
$ka_servername          = "dmast01.t";
$ka_username            = "root";
$ka_password            = "magriops";
$ka_dbname              = "magri_women";

$ka_conn = new mysqli($ka_servername, $ka_username, $ka_password, $ka_dbname);

if ($ka_conn->connect_error) {
    $servername   = "dmast01.t";
    $username     = "root";
    $password     = "magriops";
    $dbname       = "magri_women";
$ka_conn = new mysqli($servername, $username, $password, $dbname);
}

//watson rose
$km_servername          ="dmast01.t";
$km_username            ="root";
$km_password            ="magriops";
$km_dbname              ="watson_rose";

$km_conn = new mysqli($km_servername,$km_username,$km_password,$km_dbname);

if ($km_conn->connect_error) {
    $servername   = "dmast01.t";
    $username     = "root";
    $password     = "magriops";
    $dbname       = "watson_rose";
$km_conn = new mysqli($servername, $username, $password, $dbname);
}


//watson bimma
$kb_servername="dmast01.t";
$kb_username="root";
$kb_password="magriops";
$kb_dbname="watson_bima";
$kb_conn = new mysqli($kb_servername,$kb_username,$kb_password,$kb_dbname);

if ($kb_conn->connect_error) {
    $servername   = "dmast01.t";
    $username     = "root";
    $password     = "magriops";
    $dbname       = "watson_bima";
$kb_conn = new mysqli($servername, $username, $password, $dbname);
}


//watson william
$kk_servername="dmast01.t";
$kk_username="root";
$kk_password="magriops";
$kk_dbname="agri_expert";
$kk_conn = new mysqli($kk_servername,$kk_username,$kk_password,$kk_dbname);

if ($kk_conn->connect_error) {
    $servername   = "dmast01.t";
    $username     = "root";
    $password     = "magriops";
    $dbname       = "agri_expert";
$kk_conn = new mysqli($servername, $username, $password, $dbname);
}

//watson jeewman
$kj_servername="dmast01.t";
$kj_username="root";
$kj_password="magriops";
$kj_dbname="watson_guard";
$kj_conn = new mysqli($kj_servername,$kj_username,$kj_password,$kj_dbname);


//radio magan
$rm_servername="dmast01.t";
$rm_username="root";
$rm_password="magriops";
$rm_dbname="magri_rm";
$rm_conn = new mysqli($rm_servername,$rm_username,$rm_password,$rm_dbname);

//watson Nama
$rm_servername="dmast01.t";
$rm_username="root";
$rm_password="magriops";
$rm_dbname="watson_nama";
$kn_conn = new mysqli($rm_servername,$rm_username,$rm_password,$rm_dbname);




//crop_insurance
$rm_servername="dmast01.t";
$rm_username="root";
$rm_password="magriops";
$rm_dbname="watson_tahaffuz";
$ci_conn = new mysqli($rm_servername,$rm_username,$rm_password,$rm_dbname);

/*
//zarai directory
$zd_servername="damg10.t";
$zd_username="root";
$zd_password="root";
$zd_dbname="agri_mart";
$zd_conn = new mysqli($zd_servername,$zd_username,$zd_password,$zd_dbname);
*/


$zd_servername="dmast01.t";
$zd_username="root";
$zd_password="magriops";
$zd_dbname="agri_mart";
$zd_conn = new mysqli($zd_servername,$zd_username,$zd_password,$zd_dbname);


//bulk_unsub for paid walls
$bu_servername="dmast01.t";
$bu_username="root";
$bu_password="magriops";
$bu_dbname="bulk_sub_unsub";
$bu_conn = new mysqli($bu_servername,$bu_username,$bu_password,$bu_dbname);


$kad_servername="dmast01.t";
$kad_username="root";
$kad_password="magriops";
$kad_dbname="watson_amdani";
$kad_conn = new mysqli($kad_servername,$kad_username,$kad_password,$kad_dbname);


?>


