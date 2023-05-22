<html lang="en">
<?php
require_once('in_header.php');

if (!isset($_SESSION['username'])) {
    header("Location: logout.php");
}

if (!in_array(validateUserRole($conn, $_SESSION['username']), $cro)) {
    header("Location: logout.php");
}

userLogActivity($conn, 'SUBSCRIBER');

?>


<body ng-app="magriApp"  id="controler_id">


<div ng-controller="unSUBCTRL as ctrl">
    <div id="loading" class="overlay" ng-show="ctrl.loader">
        <div>
            <img src="../images/loading.svg" alt="Please wait ..." class="load_img"/>
        </div>
    </div>

    <div class="container-fluid">


        <ul class="nav nav-tabs">
         <!--   <li ng-class="{ active: ctrl.isSet('missouri') }">
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
            <li ng-class="{ active: ctrl.isSet('wdc') }">
                <a href ng-click="ctrl.setTab('wdc')">watson Sehat</a>
            </li>
            <li ng-class="{ active: ctrl.isSet('kam') }">
                <a href ng-click="ctrl.setTab('kam')">watson rose</a>
            </li>
            <li ng-class="{ active: ctrl.isSet('kb') }">
                <a href ng-click="ctrl.setTab('kb')">watson Zindagi</a>
            </li>
            <li ng-class="{ active: ctrl.isSet('kk') }">
                <a href ng-click="ctrl.setTab('kk')">watson william</a>
            </li>
            <li ng-class="{ active: ctrl.isSet('kj') }">
                <a href ng-click="ctrl.setTab('kj')">watson guard</a>
            </li>
            <li ng-class="{ active: ctrl.isSet('rm') }">
                <a href ng-click="ctrl.setTab('rm')">watson Radio</a>
            </li>
            <li ng-class="{ active: ctrl.isSet('kn') }">
                <a href ng-click="ctrl.setTab('kn')">watson Naama</a>
            </li>
            <li ng-class="{ active: ctrl.isSet('zd') }">
                <a href ng-click="ctrl.setTab('zd')">Zarai Directory</a>
            </li>
            <li ng-class="{ active: ctrl.isSet('kad') }">
                <a href ng-click="ctrl.setTab('kad')">watson Amdani</a>
            </li>
            <li ng-class="{ active: ctrl.isSet('kt') }">
                <a href ng-click="ctrl.setTab('kt')">watson Tahafuz</a>
            </li>
        </ul>

        <div class="tab-content" ng-init="ctrl.loadunSubscribers(1,'')">

            <div id="missouri" class="tab-pane fade in active">

                <div class="row vert-offset-top-1">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-10">


                        <div class="col-sm-3">
                            <input type="hidden" value="0" name="is_dt_missouri" id="is_dt_missouri"/>
                        </div>

                        <div class="col-sm-1">

                        </div>

                        <div class="col-sm-1 pull-right">
                            <a href="#" class="btn btn-default btn-sm pull-left" ng-click="ctrl.exportExcel('','searchAll')"
                               style="margin-left: -17px; width: 99px"><span class="fa fa-file-excel-o"></span> Export
                                All</a>
                        </div>
                        <div class="col-sm-1 pull-right">

                        </div>

                        <div class="col-sm-3 pull-right">

                        </div>

                    </div>
                </div>

                <div class="row vert-offset-top-1">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-10">


                        <div class="col-sm-3">
                            <input type="text" name="dt_range" ng-model="ctrl.dt_range" class="form-control" id="dt_range" placeholder="Enter Date">
                        </div>

                        <div class="col-sm-1">
                            <button type="button" class="btn btn-success btn-sm "
                                    ng-click="ctrl.searchunSubscriberByDate()">
                                Submit
                            </button>
                        </div>
                        <div class="col-sm-1 " style="margin-left: 3px" ng-if="ctrl.dateParam" >
                            <button type="button" class="btn btn-success btn-sm"
                                    ng-click="ctrl.clearDate()"
                                    style="margin-left: -10px">Exit Search
                            </button>
                        </div>


                      <div class="col-sm-1 pull-right">
                            <button type="button" class="btn btn-default btn-sm pull-left" ng-click="ctrl.searchunSubscriberByCellNo()"
                                    style="margin-left: -17px;width: 99px">Search
                            </button>
                        </div>
                        <!--<div class="col-sm-1 pull-right">
                            <button type="button" class="btn btn-success  btn-md"
                                    ng-click="ctrl.searchunSubscriberByCellNo()"
                                    style="margin-left: -17px">Search
                            </button>
                        </div>-->

                        <div class="col-sm-3 pull-right">
                            <input type="text" id="srch_missouri" class="form-control" ng-model="ctrl.searchCellno"
                                   placeholder="Cellno [minimum 6 digits]">
                        </div>

                    </div>
                </div>

                <div class="vert-offset-top-1">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-10">
                        <input type="hidden" value="0" name="is_called" id="is_called"/>
                        <div class="table-responsive myMargin">
                            <table id="data" class="table  table-bordered" ng-keydown="key($event)">
                                <tr>

                                    <th width="20%">Cellno</th>
                                    <th width="23%">UnSubscription Date</th>
                                    <th width="22%">UnSubscription Mode</th>
                                    <th width="15%" ng-if="ctrl.selectedstate=='kz'">state</th>

                                    <th width="20%" style="text-align: center">Action</th>
                                <tr dir-paginate="unsubs in ctrl.unsubscriber|itemsPerPage:ctrl.itemsPerPage " total-items="ctrl.total_unsubscriber" current-page="ctrl.currentPage" id="{{unsubs.cellno}}">

                                    <td ><a href="" ng-click="ctrl.loadUnSubProfile(unsubs)" >{{unsubs.cellno}}</a></td>
                                    <td>{{unsubs.last_unsub_dt}}</td>
                                    <td>{{unsubs.unsub_mode}}</td>
                                    <td ng-if="ctrl.selectedstate=='kz'">{{unsubs.state|capitalizeWord }}</td>
                                    <td align="center">

                                        <a target="_blank" href="">
                                    <span class="glyphicon glyphicon-edit"
                                          ng-click="ctrl.loadUnSubProfile(unsubs)"
                                          style="font-size:1.5em; color: #444;" title="Edit UnSubscriber">

                                    </span>
                                        </a>

                                        <a target="_blank" href="">
                                            <b><span class="fa fa-file-text"
                                                     ng-click="ctrl.exportExcel(unsubs.cellno,'')"
                                                     style="font-size:1.5em; color: #444; margin-left: 10px"
                                                     title="Export {{unsubs.cellno}}">

                                    </span></b>
                                        </a>
                                    </td>

                                </tr>

                            </table>

                        </div>

                        <div class="text-center">
                            <dir-pagination-controls
                                max-size="10"
                                direction-links="true"
                                boundary-links="true"
                                on-page-change="ctrl.loadunSubscribers(newPageNumber,'')">
                            </dir-pagination-controls>

                        </div>

                    </div>
                </div>

                    <div class="modal fade " id="myModal" role="dialog">
                        <div class="modal-dialog modal-lg" style="width: 90%">



                            <div class="modal-content">
                                <form   name="frm_sub_profile" novalidate id="frm_sub_profile">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title" id="heading">{{ctrl.sub_profile.cellno}}</h4>
                                    </div>
                                    <div class=" col-sm-12 modal-body">
                                        <button type="button" class="btn btn-success btn-sm pull-right" id="save_mamta"
                                                ng-click=" ctrl.doSubscribe(ctrl.sub_profile.cellno)">
                                            Subscribe
                                        </button>
                                        <div class="col-sm-6 vert-offset-top-2">
                                            <span class="col-sm-1"></span>

                                            <input type="hidden" name="cellno" ng-model ="ctrl.sub_profile.cellno">

                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="email"
                                                       style="text-align: right">Name</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" readonly name="sub_name" id="sub_name"
                                                           ng-model="ctrl.sub_profile.sub_name">
                                                </div>
                                            </div>


                                            <span class="col-sm-1"></span>
                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="Occupation" style="text-align: right">Occupation<sup style="color: red"> *</sup></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" readonly name="occupation" id="occupation"
                                                           ng-model="ctrl.sub_profile.occupation">
                                                </div>
                                                <span class="required_error" ng-show="frm_sub_profile.occupation.$error.required">Required</span>
                                            </div>

                                            <span class="col-sm-1"></span>
                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="lang" style="text-align: right">
                                                    Language<sup style="color: red"> </sup></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control"readonly  name="lang" id="lang"
                                                           ng-model="ctrl.sub_profile.lang">
                                                </div>
                                                <span class="required_error" ng-show="frm_sub_profile.lang.$error.required">Required</span>
                                            </div>

                                            <span class="col-sm-1"></span>
                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="state"
                                                       style="text-align: right">state<sup style="color: red"> </sup></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" readonly name="state" id="state"
                                                           ng-model="ctrl.sub_profile.state">
                                                </div>
                                                <span class="required_error" ng-show="frm_sub_profile.state.$error.required">Required</span>
                                            </div>

                                            <span class="col-sm-1"></span>
                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="district"
                                                       style="text-align: right">City<sup style="color: red"> </sup></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" readonly name="district" id="district"
                                                           ng-model="ctrl.sub_profile.district">
                                                </div>
                                                <span class="required_error" ng-show="frm_sub_profile.district.$error.required">Required</span>
                                            </div>
                                            <span class="col-sm-1"></span>
                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="tehsil"
                                                       style="text-align: right">Tehsil<sup style="color: red"> </sup></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" readonly name="tehsil" id="tehsil"
                                                           ng-model="ctrl.sub_profile.tehsil">
                                                </div>
                                                <span class="required_error" ng-show="frm_sub_profile.tehsil.$error.required">Required</span>
                                            </div>
                                            <span class="col-sm-1"></span>
                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="tehsil"
                                                       style="text-align: right">First Subciption DT<sup style="color: red"> </sup></label>
                                                <div class="col-sm-6">
                                                    <input type="readonly" class="form-control" readonly name="first_sub_dt" id="first_sub_dt"
                                                           ng-model="ctrl.sub_profile.first_sub_dt">
                                                </div>
                                                <span class="required_error" ng-show="frm_sub_profile.first_sub_dt.$error.required">Required</span>
                                            </div>
                                            <span class="col-sm-1"></span>
                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="tehsil"
                                                       style="text-align: right">Last Subciption DT<sup style="color: red"> </sup></label>
                                                <div class="col-sm-6">
                                                    <input type="readonly" class="form-control" readonly name="last_sub_dt" id="last_sub_dt"
                                                           ng-model="ctrl.sub_profile.last_sub_dt">
                                                </div>
                                                <span class="required_error" ng-show="frm_sub_profile.last_sub_dt.$error.required">Required</span>
                                            </div>
                                            <span class="col-sm-1"></span>
                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="tehsil"
                                                       style="text-align: right">Last UnSubciption DT<sup style="color: red"> </sup></label>
                                                <div class="col-sm-6">
                                                    <input type="readonly" class="form-control" readonly name="last_unsub_dt	" id="last_unsub_dt	"
                                                           ng-model="ctrl.sub_profile.last_sub_dt">
                                                </div>
                                                <span class="required_error" ng-show="frm_sub_profile.last_unsub_dt	.$error.required">Required</span>
                                            </div>



                                        </div>

                                        <div class="col-sm-6">
                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="sub_mode" style="text-align: right">Subscriber Mode</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control"readonly  name="sub_mode" id="sub_mode"
                                                           ng-model="ctrl.sub_profile.sub_mode">
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="sub_mode" style="text-align: right">UnSubscriber Mode</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" readonly name="unsub_mode" id="unsub_mode"
                                                           ng-model="ctrl.sub_profile.unsub_mode">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="village" style="text-align: right">Village</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" readonly name="village" id="village"
                                                           ng-model="ctrl.sub_profile.village">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="srvc"
                                                       style="text-align: right">Crops<sup id="srvc_star"  ng-class="ctrl.star_class"> </sup></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" readonly name="srvc_id" id="srvc_id"
                                                           ng-model="ctrl.sub_profile.srvc_id">
                                                </div>
                                            </div>


                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="land" style="text-align: right">Land
                                                    Size</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" readonly name="land_size" id="land_size"
                                                           ng-model="ctrl.sub_profile.land_size">

                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" readonly name="land_unit" id="land_unit"
                                                           ng-model="ctrl.sub_profile.land_unit">
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="alerts_type" style="text-align: right">
                                                    Alerts Time<sup style="color: red"> </sup></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" readonly name="alert_type" id="alert_type"
                                                           ng-model="ctrl.sub_profile.alert_type">
                                                </div>
                                            </div>


                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="channel" style="text-align: right">
                                                    Channel<sup style="color: red"> </sup></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control"readonly name="bc_mode" id="bc_mode"
                                                           ng-model="ctrl.sub_profile.bc_mode">
                                                </div>
                                            </div>


                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="comment" style="text-align: right">Comments</label>
                                                <div class="col-sm-6">
                                                    <textarea class="form-control" rows="3"  readonly name="comment" ng-model="ctrl.sub_profile.comment"></textarea>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="modal-footer">


                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>

                <div class="modal fade " id="kaModal" role="dialog">
                    <div class="modal-dialog modal-lg" style="width: 90%">


                        <!-- Modal content-->
                        <div class="modal-content">
                            <form   name="frm_sub_profile" novalidate id="frm_sub_profile">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title" id="heading">{{ctrl.sub_profile.cellno}}</h4>
                                </div>
                                <div class=" col-sm-12 modal-body">
                                    <button type="button" class="btn btn-success btn-sm pull-right" id="save_mamta"
                                            ng-click="ctrl.doSubscribe(ctrl.sub_profile.cellno)">
                                        Subscribe
                                    </button>
                                    <div class="col-sm-6 vert-offset-top-2">
                                        <span class="col-sm-1"></span>

                                        <input type="hidden" readonly name="cellno" ng-model ="ctrl.sub_profile.cellno">

                                        <div class="row form-group">
                                            <label class="control-label col-sm-3" for="email"
                                                   style="text-align: right">Name</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" readonly name="name" id="name"
                                                       ng-model="ctrl.sub_profile.sub_name">
                                            </div>
                                        </div>


                                        <span class="col-sm-1"></span>
                                        <div class="row form-group">
                                            <label class="control-label col-sm-3" for="Occupation" style="text-align: right">Occupation<sup style="color: red"> *</sup></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" readonly name="occupation" id="occupation"
                                                       ng-model="ctrl.sub_profile.occupation">
                                            </div>
                                            <span class="required_error" ng-show="frm_sub_profile.occupation.$error.required">Required</span>
                                        </div>

                                        <span class="col-sm-1"></span>
                                        <div class="row form-group">
                                            <label class="control-label col-sm-3" for="lang" style="text-align: right">
                                                Language<sup style="color: red"> *</sup></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" readonly name="lang" id="lang"
                                                       ng-model="ctrl.sub_profile.lang">
                                            </div>
                                            <span class="required_error" ng-show="frm_sub_profile.lang.$error.required">Required</span>
                                        </div>
                                        <span class="col-sm-1"></span>
                                        <div class="row form-group">
                                            <label class="control-label col-sm-3" for="lang" style="text-align: right">
                                                First_Subscriber_Date<sup style="color: red"> </sup></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" readonly name="lang" id="lang"
                                                       ng-model="ctrl.sub_profile.first_sub_dt">
                                            </div>
                                            <span class="required_error" ng-show="frm_sub_profile.lang.$error.required">Required</span>
                                        </div>
                                        <span class="col-sm-1"></span>
                                        <div class="row form-group">
                                            <label class="control-label col-sm-3" for="lang" style="text-align: right">
                                                Last_Subscriber_Date<sup style="color: red"> </sup></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" readonly name="lang" id="lang"
                                                       ng-model="ctrl.sub_profile.last_sub_dt">
                                            </div>
                                            <span class="required_error" ng-show="frm_sub_profile.lang.$error.required">Required</span>
                                        </div>
                                        <span class="col-sm-1"></span>
                                        <div class="row form-group">
                                            <label class="control-label col-sm-3" for="lang" style="text-align: right">
                                                Last_UnSub_Date<sup style="color: red"> </sup></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" readonly name="lang" id="lang"
                                                       ng-model="ctrl.sub_profile.last_unsub_dt">
                                            </div>
                                            <span class="required_error" ng-show="frm_sub_profile.lang.$error.required">Required</span>
                                        </div>
                                        <span class="col-sm-1"></span>
                                        <div class="row form-group">
                                            <label class="control-label col-sm-3" for="lang" style="text-align: right">
                                                Subscriber Mode<sup style="color: red"> </sup></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" readonly name="lang" id="lang"
                                                       ng-model="ctrl.sub_profile.sub_mode">
                                            </div>
                                            <span class="required_error" ng-show="frm_sub_profile.lang.$error.required">Required</span>
                                        </div>
                                        <span class="col-sm-1"></span>
                                        <div class="row form-group">
                                            <label class="control-label col-sm-3" for="lang" style="text-align: right">
                                               UnSubscriber Mode<sup style="color: red"> </sup></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" readonly name="lang" id="lang"
                                                       ng-model="ctrl.sub_profile.unsub_mode">
                                            </div>
                                            <span class="required_error" ng-show="frm_sub_profile.lang.$error.required">Required</span>
                                        </div>





                                        <!--                                            <span class="col-sm-1"></span>-->
                                        <!--                                            <div class="row form-group">-->
                                        <!--                                                <label class="control-label col-sm-3" for="tehsil"-->
                                        <!--                                                       style="text-align: right">Tehsil<sup style="color: red"> *</sup></label>-->
                                        <!--                                                <div class="col-sm-6">-->
                                        <!--                                                    <input type="text" class="form-control" readonly name="tehsil" id="tehsil"-->
                                        <!--                                                           ng-model="ctrl.sub_profile.tehsil">-->
                                        <!--                                                </div>-->
                                        <!--                                            </div>-->






                                    </div>

                                    <div class="col-sm-6">
                                        <div class="row form-group">
                                            <label class="control-label col-sm-3" for="state"
                                                   style="text-align: right">state<sup style="color: red"> </sup></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" readonly name="state" id="state"
                                                       ng-model="ctrl.sub_profile.state">
                                            </div>
                                            <span class="required_error" ng-show="frm_sub_profile.state.$error.required">Required</span>
                                        </div>

                                        <div class="row form-group">
                                            <label class="control-label col-sm-3" for="district"
                                                   style="text-align: right">City<sup style="color: red"> </sup></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" readonly name="city" id="city"
                                                       ng-model="ctrl.sub_profile.location">
                                            </div>
                                            <span class="required_error" ng-show="frm_sub_profile.district.$error.required">Required</span>
                                        </div>
                                        <div class="row form-group">
                                            <label class="control-label col-sm-3" for="village" style="text-align: right">Village</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" readonly name="village" id="village"
                                                       ng-model="ctrl.sub_profile.village">
                                            </div>
                                        </div>

                                        <!--<div class="row form-group">
                                            <label class="control-label col-sm-3" for="srvc"
                                                   style="text-align: right">Crops<sup id="srvc_star"  ng-class="ctrl.star_class"> *</sup></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" readonly name="srvc_id" id="srvc_id"
                                                       ng-model="ctrl.sub_profile.srvc_id">
                                            </div>
                                        </div>-->


                                        <div class="row form-group">

                                            <label class="control-label col-sm-3" for="land" style="text-align: right">Land
                                                Size</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" readonly name="land_size" id="land_size"
                                                       ng-model="ctrl.sub_profile.land_size">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" readonly name="land_unit" id="land_unit"
                                                       ng-model="ctrl.sub_profile.land_unit">
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <label class="control-label col-sm-3" for="alerts_type" style="text-align: right">
                                                Alerts Time<sup style="color: red"> *</sup></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" readonly name="alert_type" id="alert_type"
                                                       ng-model="ctrl.sub_profile.alert_type">
                                            </div>
                                        </div>


                                        <div class="row form-group">
                                            <label class="control-label col-sm-3" for="channel" style="text-align: right">
                                                Channel<sup style="color: red"> *</sup></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" readonly name="bc_mode" id="bc_mode"
                                                       ng-model="ctrl.sub_profile.bc_mode">
                                            </div>
                                        </div>


                                        <div class="row form-group">
                                            <label class="control-label col-sm-3" for="comment" style="text-align: right">Comments</label>
                                            <div class="col-sm-6">
                                                <textarea class="form-control" rows="4" readonly name="comment" ng-model="ctrl.sub_profile.comment"></textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">


                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="modal fade " id="wdcModal" role="dialog">
                    <div class="modal-dialog modal-lg" style="width: 90%">


                        <!-- Modal content-->
                        <div class="modal-content">
                            <form   name="frm_wdc_profile" novalidate id="frm_wdc_profile">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title" id="heading">{{ctrl.wdc_profile.cellno}}</h4>
                                </div>
                                <div class=" col-sm-12 modal-body">
                                    <button type="button" class="btn btn-success btn-sm pull-right" id="save_mamta"
                                            ng-click="ctrl.doSubscribe(ctrl.wdc_profile.cellno)">
                                      Subscribe
                                    </button>
                                    <div class="col-sm-6 vert-offset-top-3">
                                        <span class="col-sm-1"></span>

                                        <input type="hidden" readonly name="cellno" ng-model ="ctrl.wdc_profile.cellno">

                                        <div class="row form-group">
                                            <label class="control-label col-sm-3" for="email"
                                                   style="text-align: right">Subscribtion Date</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" readonly name="name" id="name"
                                                       ng-model="ctrl.wdc_profile.sub_dt">
                                            </div>
                                        </div>


                                        <span class="col-sm-1"></span>
                                        <div class="row form-group">
                                            <label class="control-label col-sm-3" for="unsub_dt" style="text-align: right">UnSubscribtion Date<sup style="color: red"> </sup></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" readonly name="unsub_dt" id="unsub_dt"
                                                       ng-model="ctrl.wdc_profile.unsub_dt">
                                            </div>
                                            <!--<span class="required_error" ng-show="frm_sub_profile.occupation.$error.required">Required</span>-->
                                        </div>

                                        <span class="col-sm-1"></span>
                                        <div class="row form-group">
                                            <label class="control-label col-sm-3" for="sub_mode" style="text-align: right">
                                                Subscriber Mode<sup style="color: red"> </sup></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" readonly name="sub_mode" id="sub_mode"
                                                       ng-model="ctrl.wdc_profile.sub_mode">
                                            </div>
                                            <!--<span class="required_error" ng-show="frm_sub_profile.lang.$error.required">Required</span>-->
                                        </div>

                                        <span class="col-sm-1"></span>
                                        <div class="row form-group">
                                            <label class="control-label col-sm-3" for="unsub_mode"
                                                   style="text-align: right">UnSubscriber Mode<sup style="color: red"> </sup></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" readonly name="unsub_mode" id="unsub_mode"
                                                       ng-model="ctrl.wdc_profile.unsub_mode">
                                            </div>
                                            <!--<span class="required_error" ng-show="frm_sub_profile.state.$error.required">Required</span>-->
                                        </div>
                                        <!--
                                                                                    <span class="col-sm-1"></span>
                                                                                    <div class="row form-group">
                                                                                        <label class="control-label col-sm-3" for="charge_attempt_dt"
                                                                                               style="text-align: right">Charge Attempt Date<sup style="color: red"> </sup></label>
                                                                                        <div class="col-sm-6">
                                                                                            <input type="text" class="form-control" readonly name="charge_attempt_dt" id="charge_attempt_dt"
                                                                                                   ng-model="ctrl.wdc_profile.charge_attempt_dt">
                                                                                        </div>
                                                                                     <!--   <!--<span class="required_error" ng-show="frm_sub_profile.district.$error.required">Required</span>-->
                                        <!--</div>

                                        <span class="col-sm-1"></span>
                                        <div class="row form-group">
                                            <label class="control-label col-sm-3" for="last_charge_dt" style="text-align: right">Last Charge Date</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" readonly name="last_charge_dt" id="last_charge_dt"
                                                       ng-model="ctrl.wdc_profile.last_charge_dt">
                                            </div>
                                        </div>-->

                                    </div>

                                    <div class="col-sm-6 ">
                                        <span class="col-sm-1"></span>
                                        <div class="row form-group">
                                            <label class="control-label col-sm-3" for="charge_attempt_dt"
                                                   style="text-align: right">Charge Attempt Date<sup style="color: red"></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" readonly name="charge_attempt_dt" id="charge_attempt_dt"
                                                       ng-model="ctrl.wdc_profile.charge_attempt_dt">
                                            </div>
                                            <!--<span class="required_error" ng-show="frm_sub_profile.district.$error.required">Required</span>-->
                                        </div>

                                        <span class="col-sm-1"></span>
                                        <div class="row form-group">
                                            <label class="control-label col-sm-3" for="last_charge_dt" style="text-align: right">Last Charge Date</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" readonly name="last_charge_dt" id="last_charge_dt"
                                                       ng-model="ctrl.wdc_profile.last_charge_dt">
                                            </div>
                                        </div>
                                        <span class="col-sm-1"></span>
                                        <div class="row form-group">
                                            <label class="control-label col-sm-3" for="next_charge_dt"
                                                   style="text-align: right">Next Charge Date<sup id="next_charge_dt"  ng-class="ctrl.star_class"> </sup></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" readonly name="next_charge_dt" id="next_charge_dt"
                                                       ng-model="ctrl.wdc_profile.next_charge_dt">
                                            </div>
                                        </div>

                                        <span class="col-sm-1"></span>
                                        <div class="row form-group">
                                            <label class="control-label col-sm-3" for="land" style="text-align: right">
                                                Grace Expire Date</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" readonly name="grace_expire_dt" id="grace_expire_dt"
                                                       ng-model="ctrl.wdc_profile.grace_expire_dt">
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">



                                </div>

                            </form>
                        </div>
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
