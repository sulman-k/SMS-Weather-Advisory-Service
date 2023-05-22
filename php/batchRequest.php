<html lang="en" xmlns="http://www.w3.org/1999/html">
<?php
/**
 * Created by PhpStorm.
 * User: irfan
 * Date: 12/11/2017
 * Time: 5:44 PM
 */
require_once('in_header.php');

if (!isset($_SESSION['username'])) {
    header("Location: logout.php");
}

if (!in_array(validateUserRole($conn, $_SESSION['username']), $batch_user)) {
    header("Location: logout.php");
}

userLogActivity($conn, 'Batch Request');

?>


<body ng-app="magriApp" >

<div class="container-fluid" ng-controller="batchRequestCTRL as ctrl" >
    <hr>
    <div id="loading" class="overlay" ng-show="ctrl.loader">
        <div>
            <img src="../images/loading.svg" alt="Please wait ..." class="load_img"/>
        </div>
    </div>
    <div class="row" vert-offset-top-4>
        <div class="col-lg-12" ng-show="!ctrl.showConfirmModal && !ctrl.confirmed" id="form" method="post">

            <div>
                <h4>Batch Request</h4>
            </div>
            <form novalidate name="fileInfoForm" class="form-horizontal" id='fileInfoForm' method="post"  enctype="multipart/form-data">
                <div class="form-group">
                    <label  class="control-label col-lg-4">Title :</label>
                    <div class="col-lg-4">
                        <input type="text" id="title" class="form-control col-lg-4"  placeholder="Title" name="title" ng-model="ctrl.fileInfo.title"
                         required >
                    </div>
                    <span class="required_error require_show" ng-show="fileInfoForm.title.$touched && fileInfoForm.title.$error.required">Required</span>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-4">Select File:</label>
                    <div class="col-lg-4">
                        <input type="file"  accept=".csv" valid-file id='file' class="filestyle"  name='file' ng-model="ctrl.fileInfo.file" file-model="ctrl.fileInfo.file"
                               placeholder='Choose file'  ng-required="true" />
                    </div>
                    <span class="required_error require_show" ng-show="fileInfoForm.file.$touched && fileInfoForm.file.$error.required">Required</span>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-4">Operation :</label>
                    <div class="col-lg-4">
                        <select class="selectpicker form-control" id="action"  name="operation" ng-model="ctrl.fileInfo.actionType"  required ng-options="action for action in ctrl.actions">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <span class="required_error require_show" ng-show="fileInfoForm.operation.$touched && fileInfoForm.operation.$error.required">Required</span>
                </div>

                <div class="form-group">
                    <div class="col-lg-5 col-lg-offset-3 text-right">
                        <button type="submit" class='btn btn-primary' ng-disabled="fileInfoForm.$invalid"
                                ng-click="ctrl.checkFileInfo()"    >Start
                        </button><!--ng-disabled="fileInfoForm.$invalid"-->
                    </div>
                </div>
            </form>
        </div> <!-- @end:col-lg-12 -->
        <div class="col-lg-8" id="confirm"  ng-show="ctrl.showConfirmModal">
            <div class="col-lg-6 confirm">
                <div >
                    <h4 class="modal-title" id="subscribe_alert">File Summary </h4>
                </div>
                <div class="panel panel-info  " style="margin-top: 15px">
                    <table class="table  table-hover ">

                        <tbody>
                        <tr class="active">
                            <td></td>
                            <td ><strong>Total CellNo</strong></td>
                            <td class="text-center">{{ctrl.totalNumbers}}</td>
                        </tr>
                        <tr class="active">
                            <td></td>
                            <td ><strong>Active Subscriber</strong></td>
                            <td class="text-center">{{ctrl.subs_num}}</td>
                        </tr>
                        <tr >
                            <td></td>
                            <td ><strong>Correct CellNo</strong></td>
                            <td class="text-center">{{ctrl.validNumbers}}</td>
                        </tr>
                        <tr class="active">
                            <td></td>
                            <td ><strong>Incorrect CellNo</strong></td>
                            <td class="text-center">{{ctrl.invalidNumbers}}</td>
                        </tr>
                        <tr >
                            <td></td>
                            <td ><strong>Action</strong></td>
                            <td class="text-center">{{ctrl.fileInfo.actionType}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>


                <div class="confirm">
                    <button type="button" class="btn btn-default btn-sm" ng-click="ctrl.cancelUpload()">Close
                    </button>
                    <button type="button" class="btn btn-success btn-sm" id="save_vaccine" title="Click button to delete Active Subscriber" ng-show="ctrl.subs_num!=0"
                            ng-click="ctrl.confirmUpload()">Confirm
                    </button>
                </div>
            </div>

        </div>
        <div class="col-lg-8" id="Done"  ng-show="ctrl.confirmed">
            <div class="col-lg-6 confirm">
                <div >
                    <h4 class="modal-title" id="subscribe_alert"> Execution Summary </h4>
                </div>
                <div class="panel panel-info  " style="margin-top: 15px">
                    <table class="table  table-hover ">

                        <tbody>
                        <tr class="active">
                            <td></td>
                            <td ><strong>Total Valid CellNo</strong></td>
                            <td class="text-center">{{ctrl.validNumbers}}</td>
                        </tr>
                        <tr >
                            <td></td>
                            <td ><strong>Success</strong></td>
                            <td class="text-center">{{ctrl.successRatio}}</td>
                        </tr>
                        <tr class="active">
                            <td></td>
                            <td ><strong>Failure</strong></td>
                            <td class="text-center">{{ctrl.failureRatio}}</td>
                        </tr>

                        </tbody>
                    </table>
                </div>


                <div class="confirm">
                    <button type="button" class="btn btn-success btn-sm" id="save_vaccine"
                            ng-click="ctrl.uploadConfirmed()">Done
                    </button>
                </div>
            </div>

        </div>
    </div> <!-- @end:row -->

</div>


<div ng-view></div>

</body>

<?php require_once('in_footer.php') ?>
<script>
    $(":file").filestyle({buttonName: "btn-primary"});
</script>
<!--<script>
    $('#form').submit(function (e) {


        e.preventDefault();
        var file_names=[];

        var items = $("form :input[type=file]").each(function (i, v) {
            if("advisory_file_gb" != $(this).attr('name')){
                file_names.push($(this).attr('name'));
            }
        });
        var action=$("#action :selected").text();
        var title=$('#title ').val();
        var file=$("#file").val().split("\\").pop();
        var form=document.getElementById('fileInfoForm');
        var fd=new FormData(form);
        fd.append('title',title);
        fd.append('action',action);
        fd.append('file',file);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',

            url: '../service/sr_uploadFile.php',
            data: fd,
            dataType: "json",
            processData: false,
            contentType: false,
            cache: false,
            success: function (data) {
            }


        })
    });
</script>-->
</html>
