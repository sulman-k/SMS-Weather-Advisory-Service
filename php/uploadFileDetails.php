<html lang="en">
<?php
/**
 * Created by PhpStorm.
 * User: irfan
 * Date: 12/14/2017
 * Time: 3:49 PM
 */


require_once('in_header.php');

if (!isset($_SESSION['username'])) {
    header("Location: logout.php");
}

if (!in_array(validateUserRole($conn, $_SESSION['username']), $batch_user)) {
    header("Location: logout.php");
}

userLogActivity($conn, 'Files Detail');

?>


<body ng-app="magriApp" >

    <div class="container-fluid" ng-controller="batchRequestCTRL as ctrl" ng-init="ctrl.getFilesData(1)">
        <hr>
        <div id="loading" class="overlay" ng-show="ctrl.loader">
            <div>
                <img src="../images/loading.svg" alt="Please wait ..." class="load_img"/>
            </div>
        </div>
        <div class="">

            <!--<div class="pull-right">

                <a href="batchRequest.php"><button type="button" class="btn btn-info ">Add File  </button> </a>

            </div>-->
        </div>
        <br>


        <div class="row vert-offset-top-2 " id="second" >

            <div class="row">
                <div class="col-sm-10">

                    <div class="col-sm-3 ">
                        <input type="text" id="srch_filename" class="form-control" ng-model="ctrl.filename"
                               placeholder="File Name">
                    </div>
                    <div class="col-sm-3 ">
                        <input type="text" id="srch_filename" class="form-control" ng-model="ctrl.title"
                               placeholder="Title">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" name="dt_range" ng-model="ctrl.dt_range" class="form-control" id="dt_range" placeholder="Date">
                    </div>


                    <div class="col-sm-1 ">
                        <button type="button" class="btn btn-success btn-sm"
                                ng-click="ctrl.getFilesData(1)"
                                style="margin-left: -10px">Search
                        </button>
                    </div>


                </div>
            </div>

            <div class="col-sm-12 vert-offset-top-2">

                <table class="table table-hover table-bordered table-striped">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>File Name</th>
                        <th>Valid Numbers</th>
                        <th>Action</th>
                        <th>Skipped</th>
                        <th>Total</th>
                        <th>Date</th>
                        <th>Progress</th>

                    </tr>
                    <tr   dir-paginate="data in ctrl.filesData|itemsPerPage:ctrl.itemsPerPage " total-items="ctrl.totalRecords" current-page="ctrl.currentPage" >
                        <td>{{data.id}}</td>
                        <td>{{data.title}}</td>
                        <td>{{data.file_name}}</td>
                        <td>{{data.valid_rec_cnt}}</td>
                        <td>{{data.action}}</td>
                        <td>{{data.skipped_rec_cnt}}</td>
                        <td>{{data.total_rec_cnt}}</td>
                        <td>{{data.dt}}</td>
                        <td><button type="button" class="btn btn-primary " ng-click="ctrl.checkStatus(data.id)">Check Status</button></td>

                    </tr>
                </table>
                <div class="text-center">
                    <dir-pagination-controls
                        max-size="10"
                        direction-links="true"
                        boundary-links="true"
                        on-page-change="ctrl.getFilesData(newPageNumber)">
                    </dir-pagination-controls>

                </div>

            </div>

        </div>

    </div>
</body>
<?php require_once('in_footer.php') ?>
<script>

    $('input[name="dt_range"]').daterangepicker(
        {
            locale               : {
                format: 'YYYY-MM-DD'
            },
            "alwaysShowCalendars": true
        }
    )
</script>
</html>