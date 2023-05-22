<html lang="en">
<?php
require_once('in_header.php');
require_once('in_common.php');
require_once('in_dbConnection.php');

$id = isset($_GET['id']) ? $_GET['id'] : '';
$menu_id = isset($_GET['menu_id']) ? $_GET['menu_id'] : '';



if (!in_array(validateUserRole($conn, $_SESSION['username']), $admin)) {
    header("Location: logout.php");
}

userLogActivity($conn, 'UPDATE SEGMENT');

$sql = "SELECT * FROM menu_segment WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$total_files = 0;
for($i=1; $i<10; $i++){

    if(strlen($row["seg_file_$i"]) > 0){
        $total_files++;
    }
}
?>




<body ng-app="magriApp" ng-controller="magriCtrl" id="controler_id">
<div class="container-fluid">

    <?php

    if ($conn->connect_error) {
        echo "Could not connect to database";
    }

    ?>
    <div class=" row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <h2 class="heading">Update Segment</h2>
        </div>
    </div>
    <div id="loadingDiv" class="overlay">
        <div>
            <img src="../assets/img/loading.svg" alt="Please wait ..." class="load_img"/>
        </div>
    </div>

    <div class="row vert-offset-top-2">
        <form class="form-horizontal" id="frm_add_seg">
            <div class="col-sm-6">

                <input type="hidden" name="menu_id" value="<?php echo $menu_id ?>">
                <input type="hidden" name="id" value="<?php echo $id ?>">

                <div class="form-group">
                    <label class="control-label col-sm-4" for="email">Title</label>
                    <div class="col-sm-6">
                        <input type="text" id="title" name="title" class="form-control"
                               value="<?php echo $row['title'] ?>"
                               placeholder="Enter Title"
                               data-validation="required custom" data-validation-regexp="^([:a-zA-Z0-9 _-]+)$"
                               data-validation-error-msg="Title is required">
                    </div>
                </div>

<!--                <div class="form-group">-->
<!--                    <label class="control-label col-sm-4" for="pwd">Segment Type</label>-->
<!--                    <div class="col-sm-6">-->
<!--                        <input type="text" class="form-control" name="seg_type" id="seg_type"-->
<!--                               value="--><?php //echo $row['seg_type'] ?><!--" readonly>-->
<!--                    </div>-->
<!--                </div>-->

<!--                <div class="form-group">-->
<!--                    <label class="control-label col-sm-4" for="pwd">SQL</label>-->
<!--                    <div class="col-sm-6">-->
<!--                        <textarea rows="6" class="form-control " id="sql" name="sql"-->
<!--                                  autofocus data-validation="required " data-validation-regexp="^([:A-Za-z _-]+)$"-->
<!--                                  data-validation-error-msg="SQL is required"-->
<!--                                  placeholder="Enter SQL"></textarea>-->
<!--                    </div>-->
<!--                </div>-->

                <div class="form-group">
                    <label class="control-label col-sm-4" for="pwd">Segment Order</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="seg_order" id="seg_order"
                               value="<?php echo $row['seg_order'] ?>" readonly>
                    </div>
                </div>

                <!--                <div class="form-group" >-->
                <!--                    <label class="control-label col-sm-4" for="email">File 1</label>-->
                <!--                    <div class="col-sm-6" id="a_file_1">-->
                <!--                        <input type="file" name="file_1" id="file_1" class="form-control"-->
                <!--                               data-validation="required" onfocusout="myFunction()"-->
                <!--                               data-validation-error-msg="File 1 is required">-->
                <!--                    </div>-->
                <!--                </div>-->

                <!--                <div class="form-group">-->
                <!--                    <label class="control-label col-sm-4" for="email">File 2</label>-->
                <!--                    <div class="col-sm-6">-->
                <!--                        <input type="file" name="file_2" id="file_2" class="form-control"-->
                <!--                               data-validation="required"-->
                <!--                               onfocusout="myFunction()"-->
                <!--                               data-validation-error-msg="File 2 is required">-->
                <!--                    </div>-->
                <!--                </div>-->

                <div class="form-group">
                    <label class=" col-sm-2 col-sm-offset-2" style="margin-top: 10px"></label>
                    <div class="col-sm-6">
                        <div class="alert alert-info ">
                            <h4 style="text-align: center">Note</h4>
                            <hr/>

                            <ul>
                                <li>If SQL is given then no need to upload files</li>
                                <li>Only .wav audio, Microsoft PCM, 16 bit, mono 8000 Hz. File name should not contain
                                    special character like [#@$%^&*()+=-[]';,/{}|:<>?~]
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>

            </div>
            <div class="col-sm-6">

                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">File 1 <sup id="sup_1" style="color: white">*</sup></label>
                    <div class="col-sm-6" id="a_file_1">
                        <input type="file" name="file_1" id="file_1" class="form-control"

                               data-validation-error-msg="File 1 is required">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">File 2 <sup id="sup_2" style="color: white">*</sup></label>
                    <div class="col-sm-6">
                        <input type="file" name="file_2" id="file_2" class="form-control"

                               data-validation-error-msg="File 2 is required">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">File 3 <sup id="sup_3" style="color: white">*</sup></label>
                    <div class="col-sm-6">
                        <input type="file" name="file_3" id="file_3" class="form-control"

                               data-validation-error-msg="File 3 is required">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">File 4 <sup id="sup_4" style="color: white">*</sup></label>
                    <div class="col-sm-6">
                        <input type="file" name="file_4" id="file_4" class="form-control"

                               data-validation-error-msg="File 4 is required">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">File 5 <sup id="sup_5" style="color: white">*</sup></label>
                    <div class="col-sm-6">
                        <input type="file" name="file_5" id="file_5" class="form-control"

                               data-validation-error-msg="File 5 is required">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">File 6 <sup id="sup_6" style="color: white">*</sup></label>
                    <div class="col-sm-6">
                        <input type="file" name="file_6" id="file_6" class="form-control"

                               data-validation-error-msg="File 6 is required">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">File 7 <sup id="sup_7" style="color: white">*</sup></label>
                    <div class="col-sm-6">
                        <input type="file" name="file_7" id="file_7" class="form-control"

                               data-validation-error-msg="File 7 is required">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">File 8 <sup id="sup_8" style="color: white">*</sup></label>
                    <div class="col-sm-6">
                        <input type="file" name="file_8" id="file_8" class="form-control"

                               data-validation-error-msg="File 8 is required">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">File 9 <sup id="sup_9" style="color: white">*</sup></label>
                    <div class="col-sm-6">
                        <input type="file" name="file_9" id="file_9" class="form-control"

                               data-validation-error-msg="File 9 is required">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="pwd"></label>
                    <div class="col-sm-6">
<!--                        <input id="saveBtn" class=" btn btn-success btn-sm pull-right" name="Save" value="Update"-->
<!--                               type="submit"/>-->
                        <button type="submit" class="btn pull-right">Update</button>
                        <a href="<?php echo basename($_SERVER["HTTP_REFERER"]) ?>"
                           class="btn btn-default btn-sm pull-right mybtn" style="margin-right: 10px">Cancel</a>
                    </div>
                </div>

            </div>
        </form>
    </div>

</div>
<?php require_once ('in_footer.php')?>
</body>

<script>
    $("#title").focus();

</script>
<script type="text/javascript">
    $(function () {
        $("input:file").change(function () {
            $("#"+this.id).blur();
        });
    });
</script>

<script type="text/javascript">
    $(function () {
        $('input[name="magri_date"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns   : true
        });
    });
</script>
<script>
    $(document).ready(function () {

        var total_files = '<?php echo $total_files ?>';

        for(var i=1; i<=total_files; i++){
            $("#file_"+i).attr("data-validation","required");
            $("#sup_"+i).css("color","red");
        }

        $.validate({
            modules: 'security'//,disabledFormFilter: 'form.editForm'

        });
    });

</script>

<script>

    $("#frm_add_seg").submit(function (e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var formdata = new FormData(this);

        $.ajax({
            type       : "POST",
            url        : '../service/sr_updateSegment.php',
            data       : formdata,
            dataType   : 'json',
            processData: false,
            contentType: false,
            cache      : false,
            success    : function (data) {
                if (data.success > 0) {
                    console.log('SUCESS: ' + JSON.stringify(data));
                    window.location = 'menu_segments.php?id=<?php echo $menu_id ?>';

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
                        offset    : {
                            x: 15,
                            y: 70
                        },
                        spacing   : 10,
                        z_index   : 1031,
                        delay     : 10000,
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
                console.log(data);
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
