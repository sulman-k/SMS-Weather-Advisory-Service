<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KZS Portal</title>

    <!-- CSS -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Droid+Sans">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lobster">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/flexslider/flexslider.css">
    <link rel="stylesheet" href="assets/css/form-elements.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/media-queries.css">

    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="assets/img/logo.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">

</head>

<body>

<!-- Page Title -->
<div class="page-title-container">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 wow fadeIn logo">
                <img src="assets/img/logo.png">
            </div>
        </div>
    </div>
</div>

<!-- Pricing 1 -->
<div class="pricing-1-container">
    <div class="container">
        <!--	        	<div class="row">-->
        <!--		            <div class="col-sm-12 pricing-1-title wow fadeIn">-->
        <!--		                <h2>Login</h2>-->
        <!--		            </div>-->
        <!--	            </div>-->
        <div class="row">

            <div class="col-sm-4 pricing-1-box wow fadeInUp">

            </div>
            <div class="col-sm-4 pricing-1-box pricing-1-box-best wow fadeInDown">
                <div class="pricing-1-box-inner">
                    <div class="pricing-1-box-price">
<!--                        <span>$ </span><strong>35</strong><span> / month</span>-->
                    </div>
                    <h3>Login</h3>
                    <h4></h4>
                    <div class="pricing-1-box-features">

                        <form name="" id="loginForm" class=""><br><br>
                            <div class="form-group has-feedback">
                                <input class="form-control" placeholder="Username" id="loginid" type="text"
                                       name="username" autofocus
                                       autocomplete="off" style="border-radius: 0"/>
                                <span
                                    style="display:none;font-weight:bold; position:absolute;color: red;position: absolute;padding:4px;font-size: 11px;background-color:rgba(128, 128, 128, 0.26);z-index: 17;  right: 27px; top: 5px;"
                                    id="span_loginid"></span>
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <input class="form-control" placeholder="Password" id="loginpsw" type="password"
                                       name="password"
                                       autocomplete="off" style="border-radius: 0"/>
                                <span
                                    style="display:none;font-weight:bold; position:absolute;color: grey;position: absolute;padding:4px;font-size: 11px;background-color:rgba(128, 128, 128, 0.26);z-index: 17;  right: 27px; top: 5px;"
                                    id="span_loginpsw"></span>
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            </div>

                            <div class="pricing-1-box-sign-up">
                                <button type="submit" class="btn btn-green btn-block btn-flat " style="border-radius: 0">Sign In </button>
                            </div>

<!--                            <div class="pricing-1-box-sign-up">-->
<!--                                <a class="big-link-3" href="#">Buy now</a>-->
<!--                            </div>-->
                        </form>
                    </div>

                </div>
            </div>
            <div class="col-sm-4 pricing-1-box wow fadeInUp">

            </div>

        </div>
    </div>
</div>



<!-- Pricing 2 -->

<script src="assets/js/jquery-1.11.1.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<!--<script src="assets/js/bootstrap-hover-dropdown.min.js"></script>-->
<script src="assets/js/jquery.backstretch.min.js"></script>
<script src="assets/js/wow.min.js"></script>
<!--<script src="assets/js/retina-1.1.0.min.js"></script>-->
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<script src="assets/flexslider/jquery.flexslider-min.js"></script>
<script src="assets/js/jflickrfeed.min.js"></script>
<script src="assets/js/masonrygd.min.js"></script>
<!--<script src="http://maps.google.com/maps/api/js?sensor=true"></script>-->
<!--<script src="assets/js/jquery.ui.map.min.js"></script>-->
<script src="assets/js/scripts.js"></script>
<script src="assets/js/bootstrap-notify.js"></script>

</body>


<script>
    $("#loginForm").submit(function (e) {
        e.preventDefault();

        if($("#loginid").val() == '' || $("#loginpsw").val() == ''){
            $.notify({
                title  : '<strong>Warning! </strong>',
                message: 'Please enter login ID and Password'
            }, {
                type: 'danger',

                placement : {
                    from : "top",
                    align: "center"
                },
                offset    : {
                    x: 15,
                    y: 70
                },
                spacing   : 10,
                z_index   : 1031,
                delay     : 5000,
                timer     : 1000,
                url_target: '_blank',
                mouse_over: null,
                animate   : {
                    enter: 'animated fadeInDown',
                    exit : 'animated fadeOutUp'
                }
            });

            return ;
        }


        var formdata = new FormData(this);
        $.ajax({
            type: "POST",
            url: 'service/sr_login.php',
            data: formdata,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            success: function (data) {
                if (data.success > 0) {
                    localStorage.clear();
                    console.log('SUCESS: ' + JSON.stringify(data));
                    window.location = 'php/'+ data.page;

                } else {
                    console.log(data.msg);

                    $('#loginForm')[0].reset();

                    $.notify({
                        title  : '<strong>Sorry! </strong>',
                        message: data.msg
                    }, {
                        type: 'danger',

                        placement : {
                            from : "top",
                            align: "center"
                        },
                        offset    : {
                            x: 15,
                            y: 70
                        },
                        spacing   : 10,
                        z_index   : 1031,
                        delay     : 5000,
                        timer     : 1000,
                        url_target: '_blank',
                        mouse_over: null,
                        animate   : {
                            enter: 'animated fadeInDown',
                            exit : 'animated fadeOutUp'
                        }
                    });
                }

            },
            error: function (data) {

                $.notify({
                    title  : '<strong>Sorry! </strong>',
                    message: data.msg
                }, {
                    type: 'danger',

                    placement : {
                        from : "top",
                        align: "center"
                    },
                    offset    : {
                        x: 15,
                        y: 70
                    },
                    spacing   : 10,
                    z_index   : 1031,
                    delay     : 5000,
                    timer     : 1000,
                    url_target: '_blank',
                    mouse_over: null,
                    animate   : {
                        enter: 'animated fadeInDown',
                        exit : 'animated fadeOutUp'
                    }
                });
            }

        });


    });
</script>

</html>