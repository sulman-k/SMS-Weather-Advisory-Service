<html>

<?php
/**
 * Created by PhpStorm.
 * User: mm
 * Date: 1/31/2020
 * Time: 12:40 PM
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
<body ng-app="magriApp" ng-controller="unSUB as ctrl">
    <div class="container vert-offset-top-4" ng-init="loadJobs(1,'')">
        <div class="row ">
            <div class="col-sm-3">
                <input type="text" name="dt_range" ng-model="dt_range" class="form-control" id="dt_range" placeholder="Enter Date">
            </div>

            <div class="col-sm-1">
                <button type="button" class="btn btn-success btn-sm "
                        ng-click="searchJobByDate()">
                    Search
                </button>
            </div>
            <div class="col-sm-1 " style="margin-left: 3px" ng-if="dateParam" >
                <button type="button" class="btn btn-success btn-sm"
                        ng-click="clearDate()"
                        style="margin-left: -10px">Exit Search
                </button>
            </div>
            <div class="col-sm-5"></div>
            <div class="col-sm-2 pull-right">
<!--                <button type="button" class="btn btn-primary " style="margin-left: 69px;" ng-click="exportExcel('job','')">Export All</button>
-->            </div>
        </div>

        <div class="row vert-offset-top-1">
            <div class="col-sm-12">
                <table class="table table-bordered" >
                    <th >ID</th>
                    <th  >Title</th>
                    <th >Service</th>
                    <th>Action</th>
                    <th>Job Created Dt</th>
                    <th>Created By</th>
                    <th >Status</th>
                    <th >Total MSISDNS</th>
                    <th>MSISDNS Processed</th>
                    <th >Action</th>
                    <th>Export</th>
                    <tbody>
                    <tr dir-paginate="j in jobs_details|itemsPerPage:itemsPerPage " total-items="total" current-page="currentPage" >
                        <td ng-click="jobSummary(j.id)" id="unsub_job_id">{{j.id}}</td>
                        <td>{{j.title}}</td>
                        <td>{{j.paid_wall_name}}</td>
                        <td><span ng-if="j.action=='100'">Subscribe</span><span ng-if="j.action=='200'">UnSubscribe</span></td>
                        <td>{{j.upload_dt}}</td>
                        <td>{{j.generated_by}}</td>
                        <td>
                            <span ng-if="j.status==-100" class="text-info "><b>Created</b></span>
                            <span ng-if="j.status==0" class="text-info "><b>Ready</b></span>
                            <span ng-if="j.status==20" class="text-success"><b>Running</b></span>
                            <span ng-if="j.status==40" class="text-danger"><b>Pause</b></span>
                            <span ng-if="j.status==60"><b>Running</b></span>
                            <span ng-if="j.status==100" class="text-success"><b>Completed</b></span>


                        </td>
                        <td>{{j.max_ptr}}</td>
                        <td>
                            <span ng-if="j.last_ptr !=''" >{{j.last_ptr}}</span>
                            <span ng-if="!j.last_ptr">N/A</span>
                        </td>
                        <td>
                            <span ng-if="j.status==-100"><button type="button" class="btn btn-success" ng-click="updateJobStatus('0',j.id)">Process</button></span>
                            <span ng-if="j.status !=-100"><button type="button" class="btn btn-success" ng-click="updateJobStatus('0',j.id)" disabled>Process</button></span>

                            <!--      <span ng-if="j.status==20"><button type="button" class="btn btn-" ng-click="updateJobStatus('40',j.id)">Pause</button></span>
                                  <span ng-if="j.status==60"><button type="button" class="btn btn-primary" ng-click="updateJobStatus('40',j.id)">Pause</button></span>
                                  <span ng-if="j.status==40"><button type="button" class="btn btn-primary" ng-click="updateJobStatus('20',j.id)">Resume</button></span>
                                  <span ng-if="j.status==100">Completed</span>-->
                        </td>
                        <td>
                            <span style="font-size:1.5em; color: #444; margin-left: 10px;cursor: pointer" class="fa fa-1x fa-file-text" title="Export excel" ng-click="exportExcel('',j.id)"></span>

                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-right vert-offset-bottom-2" style="margin-right: 1.2rem">
                <dir-pagination-controls
                    max-size="10"
                    direction-links="true"
                    boundary-links="true"
                    on-page-change="loadJobs(newPageNumber,'')">
                </dir-pagination-controls>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Job Summary</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered" >
                        <thead>
                            <th>Total MSISDNs</th>
                            <th>Unsubscribed</th>
                            <th>Not Unsubscribed</th>
                            <th>Not active subscriber</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{total_unsub}}</td>
                            <td>{{unsubscribed}}</td>
                            <td>{{not_un_subscribed}}</td>
                            <td>{{not_active_subscriber}}</td>
                            <td>
                                <button type="button" class="btn btn-primary" ng-click="exportExcel('',job_id)">Export</button>
                            </td>

                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

<?php require_once('in_footer.php') ?>

</body>
<script type="text/javascript">
    $('input[name="dt_range"]').daterangepicker(
        {
            locale               : {
                format: 'YYYY-MM-DD'
            },
            "alwaysShowCalendars": true
        }
    );
</script>
</html>
