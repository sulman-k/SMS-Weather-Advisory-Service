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


<div ng-controller="newController as ctrl">
    <div id="loading" class="overlay" ng-show="ctrl.loader">
        <div>
            <img src="../images/loading.svg" alt="Please wait ..." class="load_img"/>
        </div>
    </div>

    <div class="container-fluid">


        <ul class="nav nav-tabs">
            <!--<li ng-class="{ active: ctrl.isSet('missouri') }">
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
                <a href ng-click="ctrl.setTab('kb')">watson Zindagi.</a>
            </li>
            <li ng-class="{ active: ctrl.isSet('kk') }">
                <a href ng-click="ctrl.setTab('kk')">watson william</a>
            </li>
            <li ng-class="{ active: ctrl.isSet('kj') }">
                <a href ng-click="ctrl.setTab('kj')">watson guard</a>
            </li>
            <li ng-class="{ active: ctrl.isSet('rm') }">
                <a href ng-click="ctrl.setTab('rm')">watson Radio </a>
            </li>
            <li ng-class="{ active: ctrl.isSet('kn') }">
                <a href ng-click="ctrl.setTab('kn')">watson Naama</a>
            </li>
            <li ng-class="{ active: ctrl.isSet('zd') }">
                <a href ng-click="ctrl.setTab('zd')">Zarai Directory
                </a>
            </li>
            <li ng-class="{ active: ctrl.isSet('kad') }">
                <a href ng-click="ctrl.setTab('kad')">watson Amdani
                </a>
            </li>
            <li ng-class="{ active: ctrl.isSet('kt') }">
                <a href ng-click="ctrl.setTab('kt')">watson Tahafuz
                </a>
            </li>
        </ul>
            <div class="tab-content" ng-init="ctrl.loadSubscribers(1,'')">

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
                                    ng-click="ctrl.searchSubscriberByDate()">
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
                            <button type="button" class="btn btn-success btn-sm pull-left" ng-click="ctrl.doSubscribe()"
                                    style="margin-left: -17px">Subscribe
                            </button>
                        </div>
                        <div class="col-sm-1 pull-right">
                            <button type="button" class="btn btn-success btn-sm"
                                    ng-click="ctrl.searchSubscriberByCellNo()"
                                    style="margin-left: -10px">Search
                            </button>
                        </div>

                        <div class="col-sm-2 pull-right" ng-if="ctrl.show">
                            <select class="form-control" ng-model="ctrl.serviceId">
                                <option value="" disabled>Select Service</option>
<option value="1" ng-if="ctrl.selectedstate !='kt'">2 rupees</option>
<option value="1" ng-if="ctrl.selectedstate=='kt'">3 rupees</option>
                                <option value="2">6 rupees</option>
                                <option value="3">12 rupees</option>

                            </select>
                        </div>

                        <div class="col-sm-3 pull-right"  >
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
                                    <th width="25%">Subscription Date</th>
                                    <th width="23%">Subscription Status</th>
                                    <th width="13%" ng-if="ctrl.selectedstate=='kz'">state</th>
                                    <th width="20%" style="text-align: center">Action</th>

                                <tr dir-paginate="sub in ctrl.subscribers|itemsPerPage:ctrl.itemsPerPage " total-items="ctrl.total_subscriber" current-page="ctrl.currentPage" id="{{sub.cellno}}">

                                    <td ><a href="" ng-click="ctrl.loadSubProfile(sub)" >{{sub.cellno}}</a></td>
                                    <td>{{sub.last_sub_dt}}</td>
                                    <td>{{sub.sub_status}}</td>
                                    <td ng-if="ctrl.selectedstate=='kz'">{{sub.state|capitalizeWord}}</td>
                                    <td align="center">

                                        <a target="_blank" href="">
                                    <span class="glyphicon glyphicon-edit" ng-click="ctrl.loadSubProfile(sub)"

                                          style="font-size:1.5em; color: #444;" title="Edit Subscriber">

                                    </span>
                                        </a>

                                        <a target="_blank" href="">
                                            <b><span class="fa fa-file-text"
                                                     ng-click="ctrl.exportExcel(sub.cellno,'')"
                                                     style="font-size:1.5em; color: #444; margin-left: 10px"
                                                     title="Export {{sub.cellno}}">

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
                                    on-page-change="ctrl.loadSubscribers(newPageNumber,'')">
                            </dir-pagination-controls>

                        </div>

                    </div>

                    <div class="modal fade " id="myModal" role="dialog">
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
                                                data-toggle="modal" data-target="#deleteModal"
                                                ng-click="deleteSubscriberConfirm(ctrl.sub_profile.cellno)">
                                            Unsubscribe
                                        </button>
                                        <div class="col-sm-6 vert-offset-top-2">
                                            <span class="col-sm-1"></span>

                                            <input type="hidden" name="cellno" ng-model ="ctrl.sub_profile.cellno">

                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="email"
                                                       style="text-align: right">Name</label>
                                                <div class="col-sm-6">
                                                    <select class="form-control" id="sub_name_missouri" name="name" ng-model="ctrl.sub_profile.sub_name" ng-options="name.sub_name as (name.sub_name | capitalizeWordNew) for name in ctrl.sub_names  ">
                                                        <option value="" >Select Name</option>
                                                    </select>
                                                </div>
                                            </div>


                                            <span class="col-sm-1"></span>
                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="Occupation" style="text-align: right">Occupation<sup style="color: red"> *</sup></label>
                                                <div class="col-sm-6">
                                                    <select class="form-control select_box" id="occupation" name="occupation"
                                                            required ng-model="ctrl.sub_profile.occupation">
                                                        <option value="">Select Occupation</option>
                                                        <option ng-selected="'Farmer' == ctrl.sub_profile.occupation"
                                                                value="Farmer">Farmer
                                                        </option>
                                                        <option ng-selected="'Middleman' == ctrl.sub_profile.occupation"
                                                                value="Middleman">Middleman
                                                        </option>
                                                        <option ng-selected="'NotFarmer' == ctrl.sub_profile.occupation"
                                                                value="NotFarmer">Not Farmer
                                                        </option>
                                                    </select>
                                                </div>
                                                <span class="required_error" ng-show="frm_sub_profile.occupation.$error.required">Required</span>
                                            </div>

                                            <span class="col-sm-1"></span>
                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="lang" style="text-align: right">
                                                    Language<sup style="color: red"> * </sup></label>
                                                <div class="col-sm-6">
                                                    <select class="form-control select_box"  id="lang" name="lang"
                                                            ng-model="ctrl.sub_profile.lang"  ng-options="(lang | capitalizeWordNew) for lang in ctrl.stateData.langs"  required >
                                                        <option value="">Select Language</option>
                                                    </select>

                                                </div>
                                                <span class="required_error" ng-show="frm_sub_profile.lang.$error.required">Required</span>
                                            </div>

                                            <span class="col-sm-1"></span>
                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="state"
                                                       style="text-align: right">state<sup style="color: red"> *</sup></label>
                                                <div class="col-sm-6">
                                                    <select class="form-control select_box" id="state" name="state" autofocus
                                                            ng-model="ctrl.sub_profile.state" ng-change="ctrl.filterLocations(ctrl.sub_profile.state)"
                                                            ng-options="key as (key | capitalizeWordNew) for (key,value) in ctrl.allstatesData" required>
                                                        <option value="">Select</option>
                                                    </select>
                                                </div>
                                                <span class="required_error" ng-show="frm_sub_profile.state.$error.required">Required</span>
                                            </div>

                                            <span class="col-sm-1"></span>
                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="district"
                                                       style="text-align: right">City<sup style="color: red"> *</sup></label>
                                                <div class="col-sm-6">
                                                    <select class="form-control select_box" id="district" name="district"  ng-change="ctrl.filterTehsils(ctrl.sub_profile.district )"
                                                            required ng-model="ctrl.sub_profile.district" ng-options="key as (key | capitalizeWordNew)   for (key,value) in ctrl.stateData.districts">
                                                        <option value="">Select</option>
                                                    </select>
                                                </div>
                                                <span class="required_error" ng-show="frm_sub_profile.district.$error.required">Required</span>
                                            </div>
                                            <span class="col-sm-1"></span>
                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="tehsil"
                                                       style="text-align: right">Tehsil<sup style="color: red"> *</sup></label>
                                                <div class="col-sm-6">
                                                    <select class="form-control select_box" id="tehsil" name="tehsil"
                                                            required ng-model="ctrl.sub_profile.tehsil" ng-options="(teh | capitalizeWordNew) for teh in ctrl.tehsils">
                                                        <option value="">Select</option>
                                                    </select>
                                                </div>
                                                <span class="required_error" ng-show="frm_sub_profile.tehsil.$error.required">Required</span>
                                            </div>

                                            <span class="col-sm-1"></span>
                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="village" style="text-align: right">Village</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" name="village" id="village"
                                                           ng-model="ctrl.sub_profile.village">
                                                </div>
                                            </div>
                                            <span class="col-sm-1"></span>
                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="last_charge_dt" style="text-align: right">Last Charge Date</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" name="last_charge_dt" id="last_charge_dt"
                                                           ng-model="ctrl.sub_profile.last_charge_dt" readonly>
                                                </div>
                                            </div>
                                            <span class="col-sm-1"></span>
                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="charge_attempt_dt" style="text-align: right">Charge Attempt Date</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" name="charge_attempt_dt" id="charge_attempt_dt"
                                                           ng-model="ctrl.sub_profile.charge_attempt_dt" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                           <div class="row form-group">
                                                <label class="control-label col-sm-3" for="next_charge_dt" style="text-align: right">Next_Charge_Date</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" name="next_charge_dt" id="next_charge_dt"
                                                           ng-model="ctrl.sub_profile.next_charge_dt" readonly>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <span><label class="control-label col-sm-3" for="grace_expire_dt" style="text-align: right">Grace_Expire_Date</label></span>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" name="grace_expire_dt" id="grace_expire_dt"
                                                           ng-model="ctrl.sub_profile.grace_expire_dt" readonly>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                              <span>  <label class="control-label col-sm-3" for="email"
                                                             style="text-align: right">Action Type</label></span>
                                                <div class="col-sm-6">
                                                    <select class="form-control" id="problem" name="problem" ng-model="ctrl.sub_profile.problem">
                                                        <option value="">Select</option>
                                                        <option value="100">Already Update</option>
                                                        <option value="110">Channel Change</option>
                                                        <option value="120">Focus Crop Change</option>
                                                        <option value="130">Location & Focus Crop Change</option>
                                                        <option value="140">Location Change</option>
                                                        <option value="150">Location/Crop/Channel Change</option>
                                                        <option value="160">Out Of Location</option>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="srvc"
                                                       style="text-align: right">Crops<sup id="srvc_star"  ng-class="ctrl.star_class"> *</sup></label>
                                                <div class="col-sm-6">
                                                    <select class="form-control" id="srvc_id" name="srvc"  ng-model="ctrl.sub_profile.srvc_id" ng-options="(srvc | capitalizeWordNew) for srvc in ctrl.stateData.services">
                                                        <option value="">Select</option>
                                                    </select>
                                                </div>
                                                 <!-- <span class="required_error" ng-show="frm_sub_profile.$error.srvc_id">Required</span>-->
                                            </div>


                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="land" style="text-align: right">Land
                                                    Size</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" id="land" name="land" ng-model="ctrl.sub_profile.land_size">
                                                        <option value="">Select</option>
                                                        <option ng-selected="'<2.5' == ctrl.sub_profile.land_size" value="<2.5">
                                                            Less than 2.5
                                                        </option>
                                                        <option ng-selected="'2.5-5' == ctrl.sub_profile.land_size"
                                                                value="2.5-5">Between 2.5-5
                                                        </option>
                                                        <option ng-selected="'6-12.5' == ctrl.sub_profile.land_size"
                                                                value="6-12.5">Between 6-12.5
                                                        </option>
                                                        <option ng-selected="'>12.5' == ctrl.sub_profile.land_size"
                                                                value=">12.5">More than 12.5
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    <select class="form-control" id="land_unit" name="land_unit" ng-model="ctrl.sub_profile.land_unit">
                                                        <option ng-selected="'Qilla' == ctrl.sub_profile.land_unit" value="Qilla">
                                                            Qilla
                                                        </option>
                                                        <option ng-selected="'Acre' == ctrl.sub_profile.land_unit" value="Acre">
                                                            Acre
                                                        </option>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="alerts_type" style="text-align: right">
                                                    Alerts Time<sup style="color: red"> *</sup></label>
                                                <div class="col-sm-6">
                                                    <select class="form-control" id="alerts_type" name="alerts_type" required ng-model="ctrl.sub_profile.alert_type" data-validation="required" data-validation-error-msg="Required">
                                                        <option value="">Select</option>
                                                        <option ng-selected="100 == ctrl.sub_profile.alert_type" value="100">
                                                            Morning
                                                        </option>
                                                        <option ng-selected="200 == ctrl.sub_profile.alert_type" value="200">
                                                            Evening
                                                        </option>
                                                        <option ng-selected="500 == ctrl.sub_profile.alert_type" value="500">
                                                            Both
                                                        </option>
                                                        <option ng-selected="-100 == ctrl.sub_profile.alert_type" value="-100">
                                                            None
                                                        </option>
                                                    </select>
                                                </div>
                                                <span class="required_error" ng-show="frm_sub_profile.alert_type.$error.required">Required</span>
                                            </div>


                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="channel" style="text-align: right">
                                                    Channel<sup style="color: red"> *</sup></label>
                                                <div class="col-sm-6">
                                                    <select class="form-control" id="channel" name="channel" required data-validation="required" data-validation-error-msg="Required" ng-model="ctrl.sub_profile.bc_mode" ng-change="ctrl.changeAlertType()">
                                                        <option value="">Select</option>
                                                        <option ng-selected="'VOICE' == ctrl.sub_profile.bc_mode" value="VOICE">
                                                            Voice
                                                        </option>
                                                        <option ng-selected="'SMS' == ctrl.sub_profile.bc_mode" value="SMS">SMS
                                                        </option>
                                                        <option ng-selected="'BOTH' == ctrl.sub_profile.bc_mode" value="BOTH">
                                                            Both
                                                        </option>
                                                        <option ng-selected="'NONE' == ctrl.sub_profile.bc_mode" value="NONE">
                                                            None
                                                        </option>
                                                    </select>
                                                    <span class="required_error" ng-show="frm_sub_profile.bc_mode.$error.required">Required</span>
                                                </div>

                                            </div>


                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="comment" style="text-align: right">Comments</label>
                                                <div class="col-sm-6">
                                                    <textarea class="form-control" rows="4" name="comment" ng-model="ctrl.sub_profile.comment"></textarea>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="modal-footer">

                                        <a href="#" class="btn btn-default btn-sm" data-dismiss="modal" style="width: 70px">Cancel</a>
                                        <button type="submit" ng-disabled="frm_sub_profile.$error.required" class="btn btn-success btn-sm" id="saveProfile" ng-click="ctrl.saveSubProfile()">Save</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>

                    <div class="modal fade " id="kaModal" role="dialog">
                        <div class="modal-dialog modal-lg" style="width: 90%">


                            <!-- Modal content-->
                            <div class="modal-content">
                                <form   name="frm_sub_profile_ka" novalidate id="frm_sub_profile_ka">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title" id="heading">{{ctrl.sub_profile.cellno}}</h4>
                                    </div>
                                    <div class=" col-sm-12 modal-body">
                                        <button type="button" class="btn btn-success btn-sm pull-right" id="save_mamta"
                                                data-toggle="modal" data-target="#deleteModal"
                                                ng-click="deleteSubscriberConfirm(ctrl.sub_profile.cellno)">
                                            Unsubscribe
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
                                                <span class="required_error" ng-show="frm_sub_profile_ka.occupation.$error.required">Required</span>
                                            </div>

                                            <span class="col-sm-1"></span>
                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="lang" style="text-align: right">
                                                    Language<sup style="color: red"> *</sup></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" readonly name="lang" id="lang"
                                                           ng-model="ctrl.sub_profile.lang">
                                                </div>
                                                <span class="required_error" ng-show="frm_sub_profile_ka.lang.$error.required">Required</span>
                                            </div>

                                            <span class="col-sm-1"></span>
                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="state"
                                                       style="text-align: right">state<sup style="color: red"> *</sup></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" readonly name="state" id="state"
                                                           ng-model="ctrl.sub_profile.state">
                                                </div>
                                                <span class="required_error" ng-show="frm_sub_profile_ka.state.$error.required">Required</span>
                                            </div>

                                            <span class="col-sm-1"></span>
                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="district"
                                                       style="text-align: right">City<sup style="color: red"> *</sup></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" readonly name="city" id="city"
                                                           ng-model="ctrl.sub_profile.location">
                                                </div>
                                                <span class="required_error" ng-show="frm_sub_profile_ka.district.$error.required">Required</span>
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




                                            <span class="col-sm-1"></span>
                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="village" style="text-align: right">Village</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" readonly name="village" id="village"
                                                           ng-model="ctrl.sub_profile.village">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-sm-6">

                                            <div class="row form-group">
                                                <label class="control-label col-sm-3" for="srvc"
                                                       style="text-align: right">Crops<sup id="srvc_star"  ng-class="ctrl.star_class"> *</sup></label>
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
<!--//wdc modal-->
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
                                                data-toggle="modal" data-target="#wdc_deleteModal"
                                                ng-click="deleteSubscriberConfirm(ctrl.wdc_profile.cellno)">
                                            Unsubscribe
                                        </button>
                                        <div class="col-sm-6 vert-offset-top-3">
                                            <span class="col-sm-1"></span>

                                            <input type="hidden" readonly name="cellno" ng-model ="ctrl.wdc_profile.cellno">

                                            <div class="row form-group" ng-show="ctrl.amount">
                                                <label class="control-label col-sm-3" for="email"
                                                       style="text-align: right">Selected Package</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" readonly name="name" id="name"
                                                           ng-model="ctrl.amount">
                                                </div>
                                            </div>
                                            <span class="col-sm-1" ng-show="ctrl.amount"></span>

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

    <!--                ////////
   -->              <div class="modal fade" id="deleteModal" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <form id="menu_del_frm">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title" id="subscribe_alert">Are You sure you want to Un-subscribe ?</h4>
                                        </div>
                                        <input type="hidden" name="dell_cellno" id="dell_cellno" value="">
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close
                                            </button>
                                            <button type="button" class="btn btn-success btn-sm" id="save_vaccine"
                                                    ng-click="ctrl.doUnSubscribe(ctrl.sub_profile.cellno)">Confirm
                                            </button>
                                        </div>
                                    </form>
                                </div>

                        </div>
                    </div>

                   <!-- /////-->
                    <div class="modal fade" id="wdc_deleteModal" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <form id="menu_del_frm">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title" id="subscribe_alert">Are You sure you want to Un-subscribe ?</h4>
                                    </div>
                                    <input type="hidden" name="dell_cellno" id="dell_cellno" value="">
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close
                                        </button>
                                        <button type="button" class="btn btn-success btn-sm" id="save_vaccine"
                                                ng-click="ctrl.doUnSubscribe(ctrl.wdc_profile.cellno)">Confirm
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>

<!--/////-->
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
