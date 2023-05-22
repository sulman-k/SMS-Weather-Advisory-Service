<?php
require_once('in_header.php');

require_once('../php/in_dbConnection.php');
require_once('../php/in_common.php');

$id = isset($_GET['id']) ? $_GET['id'] : '';
$seg_type = isset($_GET['seg_type']) ? $_GET['seg_type'] : '';

if (!in_array(validateUserRole($conn, $_SESSION['username']), $admin)) {
    header("Location: logout.php");
}

userLogActivity($conn, 'SEGMENT UPDATE');

$result = '';
$sql = "Select * from content where id = $id";
doLog('[content_update][] [username: ' . $username . '][sql: ' . $sql . ' ]');
$result = $conn->query($sql);
$row = '';
if (isset($result)) {
    $row = $result->fetch_assoc();
    $row['file_name'] = $path . '/' . $row['file_name']. '.wav';
} else {
    header("Location: logout.php");
}

?>
<html>
<body>


<div class="container">
    <div class="row vert-offset-top-4">

        <div class="col-sm-1"></div>
        <div id="warning" class="col-sm-9"></div>
    </div>

<!--    <div id="loadingDiv" class="overlay">-->
<!--        <div>-->
<!--            <img src="images/loading.svg" alt="Please wait ..." class="load_img"/>-->
<!--        </div>-->
<!--    </div>-->

    <div class="row vert-offset-top-8">

        <form class="form-horizontal" id="content_update_form">

            <div class="row">
                <div class="form-group">
                    <label class=" col-sm-2 col-sm-offset-2" style="margin-top: 10px">Title:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="title" name="title" autocomplete="off"
                               value="<?php echo $row['title'] ?>"
                               data-validation="required"
                               data-validation-error-msg="Title is required" autofocus>
                    </div>
                </div>

            </div>


            <div class="row">
                <div class="form-group">
                    <label class=" col-sm-2 col-sm-offset-2" style="margin-top: 12px">File:</label>
                    <div class="col-sm-4">
                        <!--                        <input type="file" class="filestyle" id="eng_file" name="eng_file" accept=".wav"-->
                        <!--                               data-validation="required" data-validation-error-msg="English File is required">-->

                        <audio controls id="file_wav" class="audio" style="width: 100%">
                            <source src="<?php echo $row['file_name'] ?>" type="audio/ogg">
                            <source src="<?php echo $row['file_name'] ?>" type="audio/mpeg">
                            Your browser does not support the audio tag.
                        </audio>
                    </div>


                </div>

            </div>

            <div class="row">
                <div class="form-group">
                    <label class=" col-sm-2 col-sm-offset-2" style="margin-top: 10px">Status:</label>
                    <div class="col-sm-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name= "manual_status" id="manual_status" data-toggle="toggle" data-on="Active" data-off="Disabled" data-width="90" data-size="small">
                            </label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <label class=" col-sm-2 col-sm-offset-2"></label>
                <div class="col-sm-5 pull-right">
                    <button type="submit" id="save" name="save"
                            class="btn btn-success btn-sm">Update
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>

</body>



<script>
    $(document).ready(function () {
        var manual_sts = <?php echo $row['status'] ?>;
        if (manual_sts == 100) {
            $('#manual_status').bootstrapToggle('on')
        } else {
            $('#manual_status').bootstrapToggle('off')
        }
    });
</script>



<script>

    var st = new Date("<?php echo $row['dt'] ?>");


    $("#dt").val("<?php echo $row['dt'] ?>");


    $('input[name="daterange"]').daterangepicker(
        {
            locale      : {
                format: 'YYYY-MM-DD'
            },

            "singleDatePicker": true,
            "showDropdowns"   : true,
            "timePicker": true
        },
        function (start, end, label) {

            $("#dt").val(start.format('YYYY-MM-DD HH:MM:SS'));

        });

</script>

<script>
    $('#daterange').on('show.daterangepicker', function (ev, picker) {
        $('input[name="daterangepicker_start"]').removeClass('active');
        $('input[name="daterangepicker_end"]').removeClass('active');
    });

    $('#daterange').on('showCalendar.daterangepicker', function (ev, picker) {

        $('input[name="daterangepicker_start"]').removeClass('active');
        $('input[name="daterangepicker_end"]').removeClass('active');
    });
</script>

<script>
    $.validate({
        modules: 'security'
    });
</script>

<script>
    $("#content_update_form").submit(function (e) {
        e.preventDefault();


        $('#loadingDiv').show();
        var sts = -100;

        if ($("#manual_status").prop('checked')) {
            sts = 100;
        }

        var formdata = new FormData(this);
        formdata.append("id",<?php echo $id ?>);
        formdata.append('status', sts);
        $.ajax({
            type       : "POST",
            url        : 'sr_update_content.php',
            data       : formdata,
            dataType   : 'json',
            processData: false,
            contentType: false,
            cache      : false,
            success    : function (data) {

                $('#loadingDiv').hide();
                if (data.success > 0) {
                    console.log('SUCESS: ' + JSON.stringify(data));

                    window.location = 'content.php?seg_type=<?php echo $seg_type ?>';

                } else {

                    $.notify({
                        title  : '<strong>Warning!</strong>',
                        message: data.msg
                    }, {
                        type: 'danger',

                        placement : {
                            from : "top",
                            align: "right"
                        },
                        offset    : 70,
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
                    offset    : 70,
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

    var loading = $('#loadingDiv').hide();
    $(document)
        .ajaxStart(function () {
            loading.show();
        })
        .ajaxStop(function () {
            loading.hide();
        });
</script>

</html>
