<!DOCTYPE html>
<html lang="en">
<?php
require_once('in_header.php');

?>


<body ng-app="magriApp" ng-controller="magriCtrl" id="controler_id">
<div class="container-fluid">

    <?php

    if (!in_array(validateUserRole($conn, $_SESSION['username']), $content)) {
        header("Location: logout.php");
    }
    userLogActivity($conn, 'WEATHER REPORT');

    ?>

    <ul class="nav nav-tabs" ng-init="loadLocations()">
        <li class="active"><a data-toggle="tab" href="#missouri" ng-click="reloadReportWeather()">missouri</a></li>
        <li><a data-toggle="tab" href="#kansas">kansas</a></li>
        <li><a data-toggle="tab" href="#florida">florida</a></li>
        <li><a data-toggle="tab" href="#hawaii">hawaii</a></li>
    </ul>

    <div class="tab-content vert-offset-top-4">

        <div id="missouri" class="tab-pane fade in active">
            <div class="row">

                <div class="row container-fluid">
                    <div class="col-sm-1 form-group">
                    </div>
                    <div class="col-sm-2 form-group">
                        <div class="">
                            <input type="text" id="datepicker" name="magri_date" class="form-control" value=""/>
                        </div>
                    </div>
                    <div class="col-sm-2 form-group">
                        <div class="">
                            <select id="loc_id_missouri" name="location" class="form-control" data-validation="required"
                                    ng-model="location"
                                    data-validation-error-msg="Select Location" ng-change="getReportData('missouri')">
                                <option value="">Select Location</option>
                                <option value="{{loc.id}}" ng-repeat="loc in pu_locations ">{{loc.id |
                                    capitalizeWord}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-1 form-group">
                        <div>
                            <button ng-click="getReportData('missouri')" class="btn pull-right">Submit</button>
                        </div>
                    </div>

                </div>
                <div class="row vert-offset-top-2">
                    <div class="col-sm-1">
                    </div>

                    <div class="col-sm-10">

                        <div class="table-responsive">
                            <table class="table table-hover no_display" id="tbl_missouri">
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>SMS Text</th>
                                </tr>
                                <tr ng-repeat="sms in sms_data">
                                    <td>{{$index+1}}</td>
                                    <td>{{sms.date}}</td>
                                    <td class="no_display">
                                        <input type="hidden" name="source" id="source_{{$index+1}}"
                                               value={{sms.sms_text}} ng-model="source">
                                    </td>
                                    <td><textarea rows="5" class="form-control area_rtl" id="area_{{$index+1}}"
                                                  name="textarea"
                                                  readonly></textarea></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="gb" class="tab-pane fade">
            <div class="row">


                <div class="row container-fluid">
                    <div class="col-sm-1 form-group">
                    </div>
                    <div class="col-sm-2 form-group">
                        <div class="">
                            <input type="text" id="datepicker_gb" name="magri_date_gb" class="form-control" value=""/>
                        </div>
                    </div>
                    <div class="col-sm-2 form-group">
                        <div class="">
                            <select id="loc_id_gb" name="location_gb" class="form-control" data-validation="required"
                                    data-validation-error-msg="Select Location" ng-model="location_gb"
                                    ng-change="getReportData('gb')">
                                <option value="">Select Location</option>
                                <option value="{{loc.id}}" ng-repeat="loc in kansas_locations">{{loc.id | capitalizeWord}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-1 form-group">
                        <div>
                            <button ng-click="getReportData('gb')" class="btn pull-right">Submit</button>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-1">
                    </div>

                    <div class="col-sm-10">
                        <div id="flash">
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover no_display" id="tbl_gb">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="11%">Date</th>
                                    <th width="42%" style="text-align: center">Morning</th>
                                    <th width="42%" style="text-align: center">Evening</th>
                                </tr>
                                <tr ng-repeat="sms in sms_data">
                                    <td>{{$index+1}}</td>
                                    <td>{{sms.date}}</td>
                                    <td class="no_display">
                                        <input type="hidden" name="kansas_source" id="kansas_source_{{$index+1}}"
                                               value={{sms.sms_text}} ng-model="kansas_source">
                                    </td>
                                    <td><textarea rows="5" class="form-control area_rtl" id="kansas_area_{{$index+1}}"
                                                  name="textarea"
                                                  readonly>
                            </textarea>
                                    </td>
                                    <td class="no_display"><input type="hidden" name="eve_kansas_source"
                                                                  id="eve_kansas_source_{{$index+1}}"
                                                                  value={{sms.eve_sms_text}} ng-model="eve_kansas_source">
                                    </td>
                                    <td><textarea rows="5" class="form-control area_rtl" id="eve_area_{{$index+1}}"
                                                  name="textarea"
                                                  readonly>
                            </textarea>
                                    </td>
                                </tr>
                            </table>

                        </div>


                    </div>
                </div>

            </div>
        </div>

        <div id="florida" class="tab-pane fade ">
            <div class="row">

                <div class="row container-fluid">
                    <div class="col-sm-1 form-group">
                    </div>
                    <div class="col-sm-2 form-group">
                        <div class="">
                            <input type="text" id="datepicker_florida" name="magri_date_florida" class="form-control" value=""/>
                        </div>
                    </div>
                    <div class="col-sm-2 form-group">
                        <div class="">
                            <select id="loc_id_florida" name="location_florida" class="form-control" data-validation="required"
                                    ng-model="location_florida"
                                    data-validation-error-msg="Select Location" ng-change="getReportData('florida')">
                                <option value="">Select Location</option>
                                <option value="{{loc.id}}" ng-repeat="loc in florida_locations ">{{loc.id |
                                    capitalizeWord}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-1 form-group">
                        <div>
                            <button ng-click="getReportData('florida')" class="btn pull-right">Submit</button>
                        </div>
                    </div>

                </div>
                <div class="row vert-offset-top-2">
                    <div class="col-sm-1">
                    </div>

                    <div class="col-sm-10">

                        <div class="table-responsive">
                            <table class="table table-hover no_display" id="tbl_florida">
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>SMS Text</th>
                                </tr>
                                <tr ng-repeat="sms in sms_data">
                                    <td>{{$index+1}}</td>
                                    <td>{{sms.date}}</td>
                                    <td class="no_display">
                                        <input type="hidden" name="source" id="florida_source_{{$index+1}}"
                                               value={{sms.sms_text}} ng-model="source">
                                    </td>
                                    <td><textarea rows="5" class="form-control area_rtl" id="area_florida_{{$index+1}}"
                                                  name="textarea"
                                                  readonly></textarea></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="hawaii" class="tab-pane fade ">
            <div class="row">

                <div class="row container-fluid">
                    <div class="col-sm-1 form-group">
                    </div>
                    <div class="col-sm-2 form-group">
                        <div class="">
                            <input type="text" id="datepicker_hawaii" name="magri_date_hawaii" class="form-control" value=""/>
                        </div>
                    </div>
                    <div class="col-sm-2 form-group">
                        <div class="">
                            <select id="loc_id_hawaii" name="location_hawaii" class="form-control" data-validation="required"
                                    ng-model="location_hawaii"
                                    data-validation-error-msg="Select Location" ng-change="getReportData('hawaii')">
                                <option value="">Select Location</option>
                                <option value="{{loc.id}}" ng-repeat="loc in hawaii_locations ">{{loc.id |
                                    capitalizeWord}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-1 form-group">
                        <div>
                            <button ng-click="getReportData('hawaii')" class="btn pull-right">Submit</button>
                        </div>
                    </div>

                </div>
                <div class="row vert-offset-top-2">
                    <div class="col-sm-1">
                    </div>

                    <div class="col-sm-10">

                        <div class="table-responsive">
                            <table class="table table-hover no_display" id="tbl_hawaii">
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>SMS Text</th>
                                </tr>
                                <tr ng-repeat="sms in sms_data">
                                    <td>{{$index+1}}</td>
                                    <td>{{sms.date}}</td>
                                    <td class="no_display">
                                        <input type="hidden" name="source" id="hawaii_source_{{$index+1}}"
                                               value={{sms.sms_text}} ng-model="source">
                                    </td>
                                    <td><textarea rows="5" class="form-control area_rtl" id="area_hawaii_{{$index+1}}"
                                                  name="textarea"
                                                  readonly></textarea></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <?php require_once('in_footer.php') ?>
</body>

<script type="text/javascript">
    $(function () {
        $('input[name="magri_date"]').daterangepicker({
            singleDatePicker: false,
            showDropdowns   : true,
            locale          : {
                format: 'YYYY/MM/DD'
            }
        });
        $('input[name="magri_date_gb"]').daterangepicker({
            singleDatePicker: false,
            showDropdowns   : true,
            locale          : {
                format: 'YYYY/MM/DD'
            }
        });

        $('input[name="magri_date_florida"]').daterangepicker({
            singleDatePicker: false,
            showDropdowns   : true,
            locale          : {
                format: 'YYYY/MM/DD'
            }
        });

        $('input[name="magri_date_hawaii"]').daterangepicker({
            singleDatePicker: false,
            showDropdowns   : true,
            locale          : {
                format: 'YYYY/MM/DD'
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        $.validate({
            modules: 'security'//,disabledFormFilter: 'form.editForm'
        });
    });

</script>


<script>

    $(document).ready(function () {

        $('select').on('change', function (e) {
            setTimeout(func, 100);
        });

        $('#sBtn').on('click', function (e) {
            setTimeout(func, 100);
        });


        $('#loc_id').on('change', function (e) {
            $('#tbl_missouri').focus();
        });

        var count = 1;

        function func() {
            count++;
            if ($("#source_1").val() || $("#kansas_source_1").val()) {

                var rowCount = $('#tbl_missouri tr').length;
                for (var i = 1; i < rowCount; i++) {
                    $("#area_" + i).html($("#source_" + i).val());
                }

                var rowCount = $('#tbl_gb tr').length;
                for (var i = 1; i < rowCount; i++) {
                    $("#kansas_area_" + i).html($("#kansas_source_" + i).val());
                    $("#eve_area_" + i).html($("#eve_kansas_source_" + i).val());
                }

                var rowCount = $('#tbl_florida tr').length;
                for (var i = 1; i < rowCount; i++) {
                    $("#area_florida_" + i).html($("#florida_source_" + i).val());
                }

                var rowCount = $('#tbl_hawaii tr').length;
                for (var i = 1; i < rowCount; i++) {
                    $("#area_hawaii_" + i).html($("#hawaii_source_" + i).val());
                }

            }
            else {
                if (count < 20) {
                    console.log(document.readyState);
                    setTimeout(func, 100);
                } else {
                    window.location = 'report_weather.php';
                }
            }

        }
    }); //$("#loc_id").val()
</script>

</html>
