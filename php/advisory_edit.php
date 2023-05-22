<html lang="en">

<?php
require_once('in_header.php');

if (!isset($_SESSION['username'])) {
    header("Location: logout.php");
}

if (!in_array(validateUserRole($conn, $_SESSION['username']), $ops)) {
    header("Location: logout.php");
}

userLogActivity($conn, 'ADD ADVISORY');

?>
<body ng-app="magriApp" ng-controller="magriCtrl" id="controler_id">


<div class="tab-content">
    <div id="pending_feedback" class="tab-pane fade in active">


        <!-- Contact Us -->
        <div class="contact-us-container" ng-init="loadAdvisorymissouri('missouri')" style="min-height: 800px;">
            <div class="container">
                <div class="row">
                    <ul class="nav nav-tabs">
                        <li ng-click="loadAdvisorymissouri('missouri')" class="active"><a data-toggle="tab" href="#missouri">missouri</a></li>
                        <li><a data-toggle="tab" href="#kansas">kansas</a></li>

                        <li ng-click="loadAdvisorymissouri('florida')" ><a data-toggle="tab" href="#missouri">florida</a></li>
                        <li ng-click="loadAdvisorymissouri('hawaii')" ><a data-toggle="tab" href="#missouri">hawaii</a></li>

                    </ul>

                    <div class="tab-content">
                        <div id="missouri" class="tab-pane fade in active">

                            <div class="col-sm-1"></div>
                            <div class="col-sm-10 contact-form wow fadeInLeft">

                                <form role="form" id="advisory_frm">
                                    <div class="form-group row">
                                        <label for="contact-name" class="col-sm-3"></label>
                                        <span class="col-sm-3">
                                            <input type="text" name="dt" class="form-control contact-name">
                                        </span>
                                    </div>

                                    <div class="form-group row">
                                        <label for="contact-name" class="col-sm-3">Service</label>
                                        <span class="col-sm-3">
                                        <select name="services" class="contact-name" ng-model="srvc_pu" style="border-color: #ddd" ng-change="loadAdvisory(advisory_state,srvc_pu)">
                                            <option value="adv">Select Crop</option>
                                            <option ng-repeat="srvc in services_pu" value="{{srvc.srvc_id}}">{{srvc.srvc_id | capitalizeWord}}</option>
                                        </select>

                                        </span>
                                    </div>

                                    <div id="main_adv">

                                        <div id="srvc_head">

                                        </div>

                                        <div id="srvc_id">

                                        </div>

                                    </div>

                                    <button type="submit" class="btn pull-right">Upload</button>
                                </form>
                            </div>
                        </div>

                        <div id="gb" class="tab-pane fade">

                            <div class="col-sm-1"></div>
                            <div class="col-sm-10 contact-form wow fadeInLeft">

                                <form role="form" id="advisory_frm_gb">

                                    <div class="form-group row">
                                        <label for="contact-name" class="col-sm-3"></label>
                                        <span class="col-sm-3">
                                            <input type="text" name="dt_gb" class="form-control contact-name">
                                        </span>
                                    </div>

                                    <div id="srvc_id_gb">

                                        <div class="form-group row">
                                            <label for="contact-name" class="col-sm-3">Advisory</label>
                                            <span class="col-sm-3">
                                                <input type="file" name="advisory_file_gb" class="contact-name"
                                                       data-validation="required"
                                                       data-validation-error-msg="Advisory file is required">
                                            </span>
                                        </div>


                                    </div>
                                    <span class="col-sm-6">
                                        <button type="submit" class="btn pull-right">Upload</button>
                                    </span>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?php
        require_once('in_footer.php');
        ?>
</body>


<script type="text/javascript">
    $(function () {
        $("input:file").change(function () {
            $("#" + this.id).blur();
        });
    });
</script>

<script>

    $(":file").filestyle({buttonName: "btn-primary"});

    $.validate({
        modules: 'security'//,disabledFormFilter: 'form.editForm'
    });

    $('input[name="dt"]').daterangepicker(
        {
            locale               : {
                format: 'YYYY-MM-DD'
            },
            "alwaysShowCalendars": true,
            "singleDatePicker"   : true
        }
    )

    $('input[name="dt_gb"]').daterangepicker(
        {
            locale               : {
                format: 'YYYY-MM-DD'
            },
            "alwaysShowCalendars": true,
            "singleDatePicker"   : true
        }
    )


</script>

<script>
    $("#advisory_frm").submit(function (e) {
        e.preventDefault();

        var file_names = [];

        var items = $("form :input[type=file]").each(function (i, v) {
            if ("advisory_file_gb" != $(this).attr('name')) {
                file_names.push($(this).attr('name'));
            }
        });

        var scope = angular.element(document.getElementById('controler_id')).scope()

        var src = scope.advisory_state;


        var formdata = new FormData(this);
        formdata.append("file_names", file_names);
        formdata.append("src", src);
        $.ajax({
            type       : "POST",
            url        : '../service/sr_edit_advisory.php',
            data       : formdata,
            dataType   : 'json',
            processData: false,
            contentType: false,
            cache      : false,
            success    : function (data) {
                $('#loadingDiv').hide();
                //$('#content_upload_form').trigger('reset');
                if (data.success > 0) {

                    $.notify({
                        title  : '<strong>Success!</strong>',
                        message: "Advisory has been uploaded"
                    }, {
                        type: 'success',

                        placement : {
                            from : "top",
                            align: "right"
                        },
                        offset    : {
                            x: 50,
                            y: 116
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

                } else {
                    console.log(data.msg);

                    $.notify({
                        title  : '<strong>Warning!</strong>',
                        message: data.msg
                    }, {
                        type: 'danger',

                        placement : {
                            from : "top",
                            align: "right"
                        },
                        offset    : {
                            x: 50,
                            y: 116
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
            error      : function (data) {
                console.log('ERROR ERROR ERROR ERROR ERROR ERROR ' + JSON.stringify(data));
                $.notify({
                    title  : '<strong>Warning!</strong>',
                    message: data.msg
                }, {
                    type: 'danger',

                    placement : {
                        from : "top",
                        align: "right"
                    },
                    offset    : {
                        x: 50,
                        y: 116
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


<script>
    $("#advisory_frm_gb").submit(function (e) {
        e.preventDefault();

        var formdata = new FormData(this);
        formdata.append("src", "gb");
        $.ajax({
            type       : "POST",
            url        : '../service/sr_edit_advisory.php',
            data       : formdata,
            dataType   : 'json',
            processData: false,
            contentType: false,
            cache      : false,
            success    : function (data) {
                $('#loadingDiv').hide();
                //$('#content_upload_form').trigger('reset');
                if (data.success > 0) {
                    $.notify({
                        title  : '<strong>Success!</strong>',
                        message: "Advisory has been uploaded"
                    }, {
                        type: 'success',

                        placement : {
                            from : "top",
                            align: "right"
                        },
                        offset    : {
                            x: 50,
                            y: 116
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


                } else {
                    console.log(data.msg);

                    $.notify({
                        title  : '<strong>Warning!</strong>',
                        message: data.msg
                    }, {
                        type: 'danger',

                        placement : {
                            from : "top",
                            align: "right"
                        },
                        offset    : {
                            x: 50,
                            y: 116
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
            error      : function (data) {
                console.log('ERROR ERROR ERROR ERROR ERROR ERROR ' + JSON.stringify(data));
                $.notify({
                    title  : '<strong>Warning!</strong>',
                    message: data.msg
                }, {
                    type: 'danger',

                    placement : {
                        from : "top",
                        align: "right"
                    },
                    offset    : {
                        x: 50,
                        y: 116
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