<?php
    require_once('in_dbConnection.php');
    require_once ('in_session.php');
    require_once ('in_common.php');
?>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KZS Portal</title>

    <!-- CSS -->
<!--    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400">-->
<!--    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Droid+Sans">-->
<!--    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lobster">-->
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">




    <link rel="stylesheet" href="../assets/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/animate.css">
    <link rel="stylesheet" href="../assets/css/OpenPad.css">
<!--    <link rel="stylesheet" href="../assets/css/magnific-popup.css">-->
<!--    <link rel="stylesheet" href="../assets/flexslider/flexslider.css">-->
    <link rel="stylesheet" href="../assets/css/form-elements.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <link rel="stylesheet" href="../assets/css/bootstrap-3-vert-offset-shim.css">
    <link rel="stylesheet" href="../assets/css/bootstrap-toggle.min.css">
    <link rel="stylesheet" href="../assets/css/daterangepicker.css">

    <link rel="stylesheet" href="../assets/css/media-queries.css">

    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="../assets/img/logo.png">
<!--    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">-->
<!--    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">-->
<!--    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">-->
<!--    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">-->

</head>


<?php
$role  = $_SESSION["role"];

?>
<!-- Top menu -->



<!--<script>-->
<!--    $(document).ready(function () {-->
<!--        $("#btn1").on("click", function () {-->
<!--            $('#btn2').removeClass('active');-->
<!--            $(this).addClass("active");-->
<!--        });-->
<!--        $("#btn2").on("click", function () {-->
<!--            $('#btn1').removeClass('active');-->
<!--            $(this).addClass("active");-->
<!--        });-->
<!--    });-->
<!--</script>-->
<script language="javascript" type="text/javascript">
    function countChars(a, m) {
        b = a.id + "_len";

        var re = new RegExp("\\n", "g");
        for (var c = 0; re.exec($(a).val()); ++c);
        maxlen = m;
        curlen = $(a).val().length + c;
        console.info(a.id+'_'+(m - curlen));
        if ((m - curlen) >= 0) {
            $('#' + b).html('Max Length: ' + maxlen + ', Remaining Characters are: ' + (maxlen - curlen));
        }
        if (curlen > maxlen)
            $(a).val($(a).val().substring(0, (maxlen - c)));
    }
</script>


<nav class="navbar" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#top-navbar-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href=""></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="top-navbar-1 ">
            <ul class="nav navbar-nav navbar-right">
<!--                <li class="dropdown">-->
<!--                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000">-->
<!--                        <i class="fa fa-home"></i><br>Home <span class="caret"></span>-->
<!--                    </a>-->
<!--                    <ul class="dropdown-menu dropdown-menu-left" role="menu">-->
<!--                        <li><a href="index_2.html">Home</a></li>-->
<!--                        <li ><a href="index_2.html">Home 2</a></li>-->
<!--                    </ul>-->
<!--                </li>-->


                <li <?php if (isset($role) && in_array($role, $admin)) echo 'style="display: block"'; else echo 'style="display: none"'; ?>  <?php if (substr(basename($_SERVER['REQUEST_URI']) ,0 ,4) == 'menu' || substr(basename($_SERVER['REQUEST_URI']) ,0 ,14) == 'update_segment')  echo 'class="active"'; ?>>
                    <a href="menu.php"  ><i class="fa fa-home" ></i><br>Menu</a>
                </li>

                <li <?php if (isset($role) && in_array($role, $content)) echo 'style="display: block"'; else echo 'style="display: none"'; ?> <?php if (substr(basename($_SERVER['REQUEST_URI']) , 0, 15 )  == 'add_weather.php' || substr(basename($_SERVER['REQUEST_URI']) ,0 ,14) == 'verify_weather' || substr(basename($_SERVER['REQUEST_URI']) ,0 ,12) == 'edit_weather')  echo 'class="active"'; ?>>
                    <a href="add_weather.php"  ><i class="fa fa-bolt" ></i><br>Add Weather</a>
                </li>

                <li <?php if (isset($role) && in_array($role, $admin_content)) echo 'style="display: block"'; else echo 'style="display: none"'; ?> <?php if (basename($_SERVER['REQUEST_URI']) == 'view_weather.php')  echo 'class="active"'; ?>>
                    <a href="view_weather.php"  ><i class="fa fa-eye " ></i><br>View Weather</a>
                </li>

                <li <?php if (isset($role) && in_array($role, $content)) echo 'style="display: block"'; else echo 'style="display: none"'; ?> <?php if (basename($_SERVER['REQUEST_URI']) == 'report_weather.php')  echo 'class="active"'; ?>>
                    <a href="report_weather.php"  ><i class="fa fa-list-alt " ></i><br>Report</a>
                </li>

                <li <?php if (isset($role) && in_array($role, $ops)) echo 'style="display: block"'; else echo 'style="display: none"'; ?> <?php if (basename($_SERVER['REQUEST_URI']) == 'advisory.php')  echo 'class="active"'; ?>>
                    <a href="advisory.php"  ><i class="fa fa-bullhorn" ></i><br>Advisory</a>
                </li>


                <li <?php if (isset($role) && in_array($role, $ops)) echo 'style="display: block"'; else echo 'style="display: none"'; ?> <?php if (basename($_SERVER['REQUEST_URI']) == 'advisory_edit.php')  echo 'class="active"'; ?>>
                    <a href="advisory_edit.php"  ><i class="fa fa-cogs" ></i><br>Advisory Edit</a>
                </li>

                <!--<li <?php /*if (isset($role) && in_array($role, $ops)) echo 'style="display: block"'; else echo 'style="display: none"'; */?> <?php /*if (substr(basename($_SERVER['REQUEST_URI']) ,0,12) == 'advisory_sms')  {echo 'class="dropdown active"';}else {echo 'class="dropdown"';}  */?>>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000">
                        <i class="fa fa-comment"></i><br>Advisory SMS <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-left" role="menu">
                        <li><a href="advisory_sms_missouri.php">missouri</a></li>
                        <li><a href="kansas_sms.php">kansas/</a></li>
                    </ul>
                </li>-->

                <li <?php if (isset($role) && in_array($role, $ops)) echo 'style="display: block"'; else echo 'style="display: none"'; ?> <?php if (basename($_SERVER['REQUEST_URI']) == 'sms_advisory.php')  echo 'class="active"'; ?>>
                    <a href="sms_advisory.php"  ><i class="fa fa-envelope-o" ></i><br>KZ SMS Advisory </a>
                </li>
                <li <?php if (isset($role) && in_array($role, $ops)) echo 'style="display: block"'; else echo 'style="display: none"'; ?> <?php if (basename($_SERVER['REQUEST_URI']) == 'ka_sms_advisory.php')  echo 'class="active"'; ?>>
                    <a href="ka_sms_advisory.php"><i class="fa fa-envelope-o" ></i><br>KA SMS Advisory </a>
                </li>
                <li <?php if (isset($role) && in_array($role, $cro)) echo 'style="display: block"'; else echo 'style="display: none"'; ?> <?php if (basename($_SERVER['REQUEST_URI']) == 'subscribers.php')  echo 'class="active"'; ?>>
                    <a href="subscribers.php"><i class="fa fa-user"></i><br>Subscribers</a>
                </li>
                <li <?php if (isset($role) && in_array($role, $cro)) echo 'style="display: block"'; else echo 'style="display: none"'; ?> <?php if (basename($_SERVER['REQUEST_URI']) == 'Unsubscriber.php')  echo 'class="active"'; ?>>
                    <a href="Unsubscriber.php"><i class="fa fa-user-times"></i><br>UnSubscribers</a>
                </li>
                <li <?php if (isset($role) && in_array($role, $cro)) echo 'style="display: block"'; else echo 'style="display: none"'; ?> <?php if (basename($_SERVER['REQUEST_URI']) == 'help_requests.php')  echo 'class="active"'; ?>>
                    <a href="help_requests.php"><i class="fa fa-medkit"></i><br>Help Queue</a>
                </li>

                <li <?php if (isset($role) && in_array($role, $cro)) echo 'style="display: block"'; else echo 'style="display: none"'; ?> <?php if (basename($_SERVER['REQUEST_URI']) == 'help_response.php')  echo 'class="active"'; ?>>
                    <a href="help_response.php"><i class="fa fa-ambulance"></i><br>Help Response</a>
                </li>

                <li <?php if (isset($role) && in_array($role, $batch_user)) echo 'style="display: block"'; else echo 'style="display: none"'; ?> <?php if (basename($_SERVER['REQUEST_URI']) == 'batchRequest.php')  echo 'class="active"'; ?>>
                    <a href="batchRequest.php"><i class="fa fa-file" aria-hidden="true"></i><br>Add File  </a>
                </li>
                <li <?php if (isset($role) && in_array($role, $batch_user)) echo 'style="display: block"'; else echo 'style="display: none"'; ?> <?php if (basename($_SERVER['REQUEST_URI']) == 'uploadFileDetails.php')  echo 'class="active"'; ?>>
                    <a href="uploadFileDetails.php"><i class="fa fa-file" aria-hidden="true"></i><br>Files Detail  </a>
                </li>
                <li <?php if (isset($role) && in_array($role, $obdadmin)) echo 'style="display: block"'; else echo 'style="display: none"'; ?> <?php if (basename($_SERVER['REQUEST_URI']) == 'obd.php')  echo 'class="active"'; ?>>
                    <a href="obd.php"><i class="fa fa-file" aria-hidden="true"></i><br>Admin Role </a>
                </li>
                <li <?php if (isset($role) && in_array($role, $crop)) echo 'style="display: block"'; else echo 'style="display: none"'; ?> <?php if (basename($_SERVER['REQUEST_URI']) == 'send_sms.php')  echo 'class="active"'; ?>>
                    <a href="send_sms.php"><i class="fa fa-file" aria-hidden="true"></i><br>SEND SMS </a>
                </li>
                <li <?php if (isset($role) && in_array($role, $crop)) echo 'style="display: block"'; else echo 'style="display: none"'; ?> <?php if (basename($_SERVER['REQUEST_URI']) == 'sms_visibility.php')  echo 'class="active"'; ?>>
                    <a href="sms_visibility.php"><i class="fa fa-file" aria-hidden="true"></i><br>Sms Visibility </a>
                </li>
                <li <?php if (isset($role) && in_array($role, $bulk_unsub)) echo 'style="display: block"'; else echo 'style="display: none"'; ?> <?php if (basename($_SERVER['REQUEST_URI']) == 'bulk_unsub.php')  echo 'class="active"'; ?>>
                    <a href="bulk_unsub.php"><i class="fa fa-pencil" aria-hidden="true"></i><br>Create Job</a>
                </li>
                <li <?php if (isset($role) && in_array($role, $bulk_unsub)) echo 'style="display: block"'; else echo 'style="display: none"'; ?> <?php if (basename($_SERVER['REQUEST_URI']) == 'bulk_unsub_job_details.php')  echo 'class="active"'; ?>>
                    <a href="bulk_unsub_job_details.php"><i class="fa fa-eye" aria-hidden="true"></i><br>JOB DETAILS</a>
                </li>


                <li <?php if (isset($role) && in_array($role, $paid_wall_unsub)) echo 'style="display: block"'; else echo 'style="display: none"'; ?> <?php if (basename($_SERVER['REQUEST_URI']) == 'paidwall_msisdn_unsub.php')  echo 'class="active"'; ?>>
                    <a href="paidwall_msisdn_unsub.php"><i class="fa fa-eye" aria-hidden="true"></i><br>Unsub MSISDN</a>
                </li>


                <li>
                    <a href="logout.php"><i class="fa fa-sign-out"></i><br>Logout</a>
                </li>
<!--                <li class="dropdown">-->
<!--                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000">-->
<!--                        <i class="fa fa-paperclip"></i><br>Pages <span class="caret"></span>-->
<!--                    </a>-->
<!--                    <ul class="dropdown-menu" role="menu">-->
<!--                        <li><a href="logout.php">Logout</a></li>-->
<!--                    </ul>-->
<!--                </li>-->
            </ul>
        </div>
    </div>
</nav>


</html>