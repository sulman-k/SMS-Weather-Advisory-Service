<html>

<?php
/**
 * Created by PhpStorm.
 * User: mm
 * Date: 1/22/2020
 * Time: 3:01 PM
 */

require_once('in_header.php');

if (!isset($_SESSION['username'])) {
    header("Location: logout.php");
}

if (!in_array(validateUserRole($conn, $_SESSION['username']), $bulk_unsub)) {
    header("Location: logout.php");
}

userLogActivity($conn, 'BULK UNSUB');
?>

<head></head>

<body ng-app="magriApp">

    <div class="container" ng-controller="unSUB as ctrl">
        <div class="row" ng-init="getServices();">
            <div class="col-sm-4">

            </div>
            <div class="col-sm-6">
                <form name="bulk_unsub" id="bulk_unsub" role="form" novalidate>
                    <h3>Create job for unsub </h3>
                    <div class="form-group vert-offset-top-2">
                        <div class="row" style="">
                            <label for="name" class="col-sm-1">Name</label>
                            <div class="col-sm-1"></div>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="job_name" id="job_name" data-validation="required" data-validation-error-msg="Please enter a valid name" onchange="checkValue()" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="action" class="col-sm-1">Action</label>
                            <div class="col-sm-1"></div>

                            <div class="col-sm-8">
                                <select ng-model="action" name="action" class="form-control" id="action" data-validation="required" data-validation-error-msg="Please select a option" onchange="checkValue()" required>
                                    <option value="">Please select a option </option>
                                    <option value="100">Sub</option>
                                    <option value="200">Unsub</option>
                                </select>
                                <span class="help-inline" ng-show="submitted && bulk_unsub.action.$error.required">Required</span>

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="service" class="col-sm-1">Services</label>
                            <div class="col-sm-1"></div>
                            <div class="col-sm-8">
                                <select name="service" ng-model="selectedService" ng-change="getServicesAmount(selectedService,action)" class="form-control" data-validation="required" data-validation-error-msg="Please select a service" id="service" onchange="checkValue()" required>
                                    <option value="">Please select a service</option>
                                    <option ng-repeat="s in services" value="{{s.paid_wall_id}}">{{s.paid_wall_name | capitalizeWord}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="specificId" ng-if="servicesAmounts.length > 0">
                        <div class="row">
                            <label for="service_amount" class="col-sm-1">Select Amount</label>
                            <div class="col-sm-1"></div>
                            <div class="col-sm-8">
                                <select name="service_amount" ng-options="option.paid_point_description for option in servicesAmounts track by option.paid_wall_code" ng-model="selectedAmount" class="form-control" data-validation="required" data-validation-error-msg="Choose an amount" id="service_amount" onchange="checkValue()" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="select file" class="col-sm-2">Select file</label>

                        <div class="col-sm-8">
                            <input type="file" name="cellno_file" accept="text/csv" id="cellno_file" class="filestyle form-control" pattern="^[a-zA-Z0-9_.-]*$" onchange="checkFileExt()">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-7">


                        </div>
                        <div class="col-sm-1">
                            <button type="submit" id="submit" class="btn btn-primary " ng-click="submitted=true" style="margin-left: 33px">Upload</button>
                        </div>
                        <div class="col-sm-2"></div>
                    </div>
                </form>

                <div class="vert-offset-top-4">
                    <h4 class="text-center text-warning">Instructions</h4>
                    <div class=" text-info">
                        <p class="text-justify">
                            <span>Note:</span> Upload button will be show when all fields are filled
                        </p>
                        <p class="text-justify ">
                            <span>1:</span> MSISDN should be in 03xxxxxxxxx format – In case MSISDNs are not in given format, application will consider them invalid numbers and will not process them.
                        </p>
                        <p class="text-justify ">
                            <span>2:</span> File must be in CSV format – Only acceptable file format is CSV, file with any other format will not be processed.
                        </p>
                        <p class="text-justify ">
                            <span>3:</span> Cell format for whole sheet should be selected as 'Text' – As in required format of valid MSISDN, number must start with digit ‘0’, excel can allow this if we keep cell format as ‘text.
                        </p>
                        <p class="text-justify">
                            <span>4:</span> Fill all required fields available at 'Create Job' tab before proceeding.
                        </p>
                    </div>
                </div>



            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>

</body>
<?php require_once('in_footer.php'); ?>
<script>
    document.getElementById("specificId").style.display = "none !important";
    document.getElementById("submit").style.display = "none";
    $(":file").filestyle({
        buttonName: "btn-primary"
    });

    function checkValue() {
        var action = $('#action').val();
        var service = $('#service').val();
        var job_name = $('#job_name').val();
        var file = $('#cellno_file').val();
        console.log("hello: ", action," service" ,service,"   condition: ", action == 100 && service>0)
       
        if (action == 100 && service>0) {

            document.getElementById("specificId").style.display = "block !important";
            document.getElementById("specificId").style.display = "block !important";
        } else {
            document.getElementById("specificId").style.display = "none !important";
            document.getElementById("specificId").style.display = "none !important";
            document.getElementById("specificId").style.display = "none !important";

        }
        if (action == '' || service == '' || job_name == '' || file == '') {

            document.getElementById("submit").style.display = "none";
        } else {
            //document.getElementById("warn").style.display="none";
            document.getElementById("submit").style.display = "";
        }
    }
</script>
<script>
    /*$.validate({
        modules: 'security'//,disabledFormFilter: 'form.editForm'
    });*/
</script>
<script type="text/javascript">
    var filename = '';

    function checkFileExt() {
        filename = $('#cellno_file').val();
        filename = filename.replace(/^.*\\/, "");
        console.log(filename);

        var ext = filename.split(".").pop();
        console.log(ext);
        if (ext !== 'csv') {
            notifyError("Please select csv file", "Warning", "warning");
            return false;
        } else {
            //document.getElementById("warn").style.display="none";
            document.getElementById("submit").style.display = "";

        }

    }

    $("#bulk_unsub").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        //regex 
        //filename=filename.replace(/[^a-z0-9]/gi,'');
        //formData.append("file",filename);
        $.ajax({
            type: 'POST',
            url: '../service/sr_uploadUnsubFile.php',
            data: formData,
            dataType: 'json',
            cache: false,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success === 100) {
                    notifyError(response.msg, "Success", "success");
                    setTimeout(function() {
                        window.location.href = 'bulk_unsub_job_details.php';
                    }, 5000);
                } else {
                    notifyError(response.msg, "Warning", "warning");
                }
            }
        })


    });

    function notifyError(msg, title, type) {
        var zIndex = 1031;
        if (msg == "Please select crop !") {
            zIndex = 1051;
        }
        if (!$('#myModal').context.hidden) { //msg == "Please select crop !"
            zIndex = 1051;
        }
        $.notify({
            title: '<strong>' + title + '!</strong>',
            message: msg
        }, {
            type: type,

            placement: {
                from: "top",
                align: "right"
            },
            offset: {
                x: 47,
                y: 70
            },
            spacing: 10,
            z_index: zIndex,
            delay: 5000,
            timer: 1000,
            url_target: '_blank',
            mouse_over: null,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            }
        });
    }
</script>

</html>