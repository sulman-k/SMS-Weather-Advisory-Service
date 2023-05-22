<html lang="en">
<?php
require_once('in_header.php');

if (!isset($_SESSION['username'])) {
    header("Location: logout.php");
}

if (!in_array(validateUserRole($conn, $_SESSION['username']), $cro)) {
    header("Location: logout.php");
}

userLogActivity($conn, 'HELP REQUESTS');
?>


<body ng-app="magriApp"  id="controler_id">
<div ng-controller="helpResponseCTRL as ctrl">
    <div id="loading" class="overlay" ng-show="ctrl.loader">
        <div>
            <img src="../images/loading.svg" alt="Please wait ..." class="load_img"/>
        </div>
    </div>

    <div class="container-fluid">


        <ul class="nav nav-tabs">
<!--
            <li ng-class="{ active: ctrl.isSet('missouri') }">
                <a href ng-click="ctrl.setTab('missouri')">missouri</a>
            </li>
            <li ng-class="{ active: ctrl.isSet('gb') }">
                <a href ng-click="ctrl.setTab('gb')">kansas</a>
            </li>
            <li ng-class="{ active: ctrl.isSet('florida') }">
                <a href ng-click="ctrl.setTab('florida')">florida</a>
            </li>

            <li ng-class="{ active: ctrl.isSet('hawaii') }">
                <a href ng-click="ctrl.setTab('hawaii')">hawaii</a>
            </li>-->

            <li ng-class="{ active: ctrl.isSet('kz') }">
                <a href ng-click="ctrl.setTab('kz')">KZ</a>
            </li>

            <li ng-class="{ active: ctrl.isSet('kaw') }">
                <a href ng-click="ctrl.setTab('kaw')">watson Aangan</a>
            </li>

        </ul>

        <div class="tab-content" ng-init="ctrl.loadHelpResponse(1)">

            <div id="missouri" class="tab-pane fade in active">


                <div class="row vert-offset-top-4">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-10">


                        <div class="col-sm-3">
                            <input type="text" name="dt_range" ng-model="ctrl.dt_range" class="form-control" id="dt_range" placeholder="Enter Date">
                        </div>

                        <div class="col-sm-1">
                            <button type="button" class="btn btn-success btn-sm "
                                    ng-click="ctrl.searchSubscriberByDate()">
                                Submit
                            </button>
                        </div>


                        <div class="col-sm-1 pull-right">
                            <a href="#" class="btn btn-default btn-sm pull-left" ng-click="ctrl.exportExcel()"
                               style="margin-left: -17px; width: 99px"><span class="fa fa-file-excel-o"></span> Export
                                All</a>
                        </div>
                        <div class="col-sm-1 pull-right">
                            <button type="button" class="btn btn-success btn-sm"
                                    ng-click="ctrl.searchSubscriberByCellNo()"
                                    style="margin-left: -10px">Search
                            </button>
                        </div>

                        <div class="col-sm-3 pull-right">
                            <input type="text" id="srch_missouri" class="form-control" ng-model="ctrl.searchCellno"
                                   placeholder="Cellno [minimum 6 digits]">
                        </div>

                    </div>
                </div>

                <div class="vert-offset-top-1">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-10">
                        <input type="hidden" value="0" name="is_dt_missouri" id="is_dt_missouri"/>
                        <div class="table-responsive myMargin">
                            <table id="data" class="table  table-bordered" ng-keydown="key($event)">
                                <tr>

                                    <th width="12%">Cellno</th>
                                    <th width="10%">state</th>
                                    <th width="15%">Response Date</th>
                                    <th width="13%">Problem Type</th>
                                    <th width="30%">User Query</th>
                                    <th width="30%">Support Provided</th>


                                <tr dir-paginate="help in ctrl.helpRequests |itemsPerPage:ctrl.itemsPerPage " total-items="ctrl.total_subscriber" current-page="ctrl.currentPage">

                                    <td>{{help.cellno}}</td>
                                    <td>{{help.state |capitalizeWord}}</td>
                                    <td>{{help.response_dt}}</td>
                                    <td>{{help.problem_type}}</td>
                                    <td>{{help.user_query}}</td>
                                    <td>{{help.support_provided}}</td>


                                </tr>

                            </table>

                        </div>
                        <!--------------Pagination------------------->
                        <div class="text-center">
                            <dir-pagination-controls
                                    max-size="10"
                                    direction-links="true"
                                    boundary-links="true"
                                    on-page-change="ctrl.loadHelpResponse(newPageNumber)">
                            </dir-pagination-controls>

                        </div>

                    </div>
                </div>
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
