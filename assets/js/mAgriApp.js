angular.module('mAgriApp', []).controller('mAgriCtrl', ['$scope', '$http', function ($scope, $http) {

    $scope.loadData = function (page) {

        var method = 'GET';
        var url = 'sr_loadData.php';
        $http.get(url).success(function (response) {
           // console.info("[App][loadData][][Response] : " + JSON.stringify(response));

            $scope.locations = response.locations;
            $scope.conditions = response.conditions;
            $scope.future_conditions = response.future_conditions;

            if (page == '3') {
                $scope.add = '';
                $scope.view = '';
                $scope.repo = 'active';
                $scope.adv = '';
            } else if (page == '2') {
                $scope.add = '';
                $scope.view = 'active';
                $scope.repo = '';
                $scope.adv = '';
            }

        }).error(function (error) {
            console.info("[App][getRecords][Error][Response] : " + JSON.stringify(error));
        });
    }
    $scope.getLastInsertedData = function (id) {

        $("#text_hide").val('');
        var method = 'GET';
        var url = 'sr_getLastInsertedData.php?id=' + id;
        console.log(url);
        $http.get(url).success(function (response) {

            $scope.location = response.location;

            $scope.eve_condition = response.eve_condition;
            $scope.eve_future_condition = response.eve_future_condition;
            $scope.condition = response.condition;
            $scope.future_condition = response.future_condition;

            $scope.min_temp = response.min_temp;
            $scope.max_temp = response.max_temp;
            $scope.eve_min_temp = response.eve_min_temp;
            $scope.eve_max_temp = response.eve_max_temp;
            $scope.date = response.date;
            $scope.sms_text = response.sms_text;
            $scope.eve_sms_text = response.eve_sms_text;
            $scope.files_1 = response.files_1;
            $scope.a = response.files_1[0];
            $scope.files_2 = response.files_2;
            $scope.b = response.files_2[0];


        }).error(function (error) {
            console.info("[App][getRecords][Error][Response] : " + JSON.stringify(error));
        });
    };
    $scope.editViewRecord = function () {

        var id = $('#record_id').val();

        var dateToday = new Date();
        dateToday.setHours(0);
        dateToday.setMinutes(0);
        dateToday.setSeconds(0);
        dateToday.setMilliseconds(0);

        var dt = $('#datepicker').val();
        dt = new Date(dt);


        if (dt.getTime() >= dateToday.getTime()) {
            $scope.editRecord(id);
        } else {
            var msg = '<div class="alert alert-danger " id="warning">' +
                '<a href="#" class="close" data-dismiss="alert">&times;</a>' +
                '<p id="para" class="bg-danger ">' + '<strong>Warning! </strong>' + 'You can not edit old record' + '</p>' +
                '</div>';
            $("#warning").html(msg);
            return;
        }
    }


    $scope.editRecord = function (id) {
        var method = 'GET';
        var url = 'edit_weather.php?id=' + id;
        console.log(url);
        window.location = url;
    }

    $scope.loadEditRecord = function (id) {

        var method = 'GET';
        var url = 'sr_loadEditRecord.php?id=' + id;
        $http.get(url).success(function (response) {
           // console.info("[App][loadEditRecord][][Response] : " + JSON.stringify(response.conditions));

            $scope.locations = response.locations;
            $scope.conditions = response.conditions;
            $scope.eve_conditions = response.eve_conditions;

            $scope.future_conditions = response.future_conditions;
            $scope.min_temp = response.min_temp;
            $scope.max_temp = response.max_temp;
            $scope.eve_min_temp = response.eve_min_temp;
            $scope.eve_max_temp = response.eve_max_temp;

            $scope.date = response.date;
            $scope.sms_text = response.sms_text;

            $scope.location_id = response.location_id;
            $scope.date = response.date;

            $scope.today_condition_id = response.today_condition_id;
            $scope.future_condition_id = response.future_condition_id;
            $scope.eve_today_condition_id = response.eve_today_condition_id;
            $scope.eve_future_condition_id = response.eve_future_condition_id;


        }).error(function (error) {
            console.info("[App][getRecords][Error][Response] : " + JSON.stringify(error));
        });
    }
    $scope.getMainPage = function () {
        window.location = 'add_weather.php';
    }

    $scope.getReportData = function () {

        $('#tbl').children('tr').remove();
        $("#source_1").val('');

        var id = $scope.location;
        if (!id) {
            return
        }

        var dateRange = $('#datepicker').val().split("-");
        var startdate = dateRange[0].replace('/', '-');
        var enddate = dateRange[1].replace('/', '-');
        startdate = startdate.replace('/', '-');
        enddate = enddate.replace('/', '-');

        $("#warning").html('');
        var url = 'sr_getReport.php';

        $http.get(url + '?stDate=' + startdate + '&endDate=' + enddate + '&loc_id=' + id)
            .success(function (data) {

                if (data.success > 0) {
                    //console.log('SUCESS: ' + data.sms_data[0].sms_text);
                    $scope.sms_data = data.sms_data;
                    $scope.sms_txt = data.sms_data[0].sms_text;
                    $scope.eve_sms_txt = data.sms_data[0].eve_sms_text;
                    //$scope.func();

                    $("#tbl").show();
                    $("#sBtn").focus();

                } else {
                    msg = '<div class="alert alert-danger " id="warning">' +
                        '<a href="#" class="close" data-dismiss="alert">&times;</a>' +
                        '<p id="para" class="bg-danger ">' + '<strong>Warning! </strong>' + data.msg + '</p>' +
                        '</div>';
                    $("#warning").html(msg);
                    $("#source_1").val('');
                    $("#tbl").hide();
                    $("#sBtn").focus();
                }
            }).error(function (error) {
            console.info("[App][getAdvertise][Error][Response] : " + JSON.stringify(error));
        });
    };

    $scope.getViewEditWeather = function () {

        var date = $('#datepicker').val().split("/");
        var newDate = date[2] + '-' + date[0] + '-' + date[1];

        var id = $('#loc_id').val();
        if (!id) {
            return
        }
        ;
        $("#textarea_id").html('');
        $("#warning").html('');
        $("#textarea_id").focus();

        var url = 'sr_getViewRecord.php';

        $http.get(url + '?date=' + newDate + '&loc_id=' + id)
            .success(function (data) {
                if (data.success > 0) {

                    $scope.sms_text = data.sms_text;
                    $scope.files_1 = data.files_1;
                    $scope.a = data.files_1[0];

                    $scope.files_2 = data.files_2;
                    $scope.b = data.files_2[0];


                    $("#textarea_id").html(data.sms_text);
                    $("#eve_textarea_id").html(data.eve_sms_text);

                    $("#record_id").val(data.id);
                    $("#edit_btn").prop("disabled", false);

                    $("#sms_box").css("display", "block");
                    $("#file_box").css("display", "block");
                    $("#edit_box").css("display", "block");

                    $("#eve_sms_box").css("display", "block");
                    $("#eve_file_box").css("display", "block");
                    $("#eve_edit_box").css("display", "block");


                    var dateToday = new Date();
                    dateToday.setHours(0);
                    dateToday.setMinutes(0);
                    dateToday.setSeconds(0);
                    dateToday.setMilliseconds(0);

                    var dt = $('#datepicker').val();
                    dt = new Date(dt);

                    if (dt.getTime() < dateToday.getTime()) {
                        $("#edit_btn").prop("disabled", true);
                    }
                    if (data.role == 'user') {
                        $("#edit_btn").css("display", 'none');
                    }


                } else {
                    msg = '<div class="alert alert-danger " id="warning">' +
                        '<a href="#" class="close" data-dismiss="alert">&times;</a>' +
                        '<p id="para" class="bg-danger ">' + '<strong>Warning! </strong>' + data.msg + '</p>' +
                        '</div>';
                    $("#warning").html(msg);
                    $("#edit_btn").prop("disabled", true);

                    $("#sms_box").css('display', 'none');
                    $("#file_box").css('display', 'none');
                    $("#edit_box").css('display', 'none');
                }
            }).error(function (error) {
            console.info("[App][getAdvertise][Error][Response] : " + JSON.stringify(error));
        });

    }
    $scope.loadDataAddWeather = function (dt) {

        window.alert('loadDataAddWeather');
        var newDate = 0;
        if (dt == '1') {
            var dateToday = new Date();
            newDate = dateToday.getFullYear() + '-' + (dateToday.getMonth() + 1) + '-' + dateToday.getDate();
        } else {
            newDate = dt;
        }

        var method = 'GET';
        var url = '../service/sr_loadDataForAddWeather.php';
        $http.get(url + '?dt=' + newDate).success(function (response) {
            console.info("[App][loadData][][Response] : " + JSON.stringify(response));

            $scope.locations = response.locations;
            $scope.conditions = response.conditions;
            $scope.eve_conditions = response.eve_conditions;
            $scope.future_conditions = response.future_conditions;

            $scope.add = 'active';
            $scope.view = '';
            $scope.repo = '';
            $scope.adv = '';

            //$(".no_view").css("display", "block");


        }).error(function (error) {
            console.info("[App][getRecords][Error][Response] : " + JSON.stringify(error));
        });
    }
    $scope.loadCrops = function () {

        var method = 'GET';
        var url = 'sr_loadCrops.php';
        $http.get(url).success(function (response) {
            //console.info("[App][loadCrops][][Response] : " + JSON.stringify(response));
            $scope.crops = response.crops;
            $scope.add = '';
            $scope.view = '';
            $scope.repo = '';
            $scope.adv = 'active';

        }).error(function (error) {
            console.info("[App][loadCrops][Error] : " + JSON.stringify(error));
        });
    }
    $scope.getViewAdvisory = function (crop_id) {

        var date = $('#datepicker').val().split("/");
        var newDate = date[2] + '-' + date[0] + '-' + date[1];

        //var crop_id = $('#crops_id').val();
        //var crop_name = $("#crops_id option:selected").text();

        console.info("[App][getViewAdvisory][][date] : " + date + ' New Date ' + newDate);

        var method = 'GET';
        var url = 'sr_getViewAdvisory.php';
        $http.get(url + '?dt=' + newDate).success(function (response) {

            if (response.success > 0) {
                $("#warning").html('');
                $scope.sms_data = response.sms_data;
                $("#crop_textarea_id").html($scope.sms_data);
                $("#sms_box").css("display", "block");
                $("#file_box").css("display", "block");

                $scope.file_1 = response.file_1;
                $scope.file_2 = response.file_2;
                $scope.file_3 = response.file_3;

                $("#audio_1").attr("src", $scope.file_1);
                //$("#audio_2").attr("src", $scope.file_2);
                //$("#audio_3").attr("src", $scope.file_3);
            } else {
                $("#sms_box").css("display", "none");
                $("#file_box").css("display", "none");
                msg = '<div class="alert alert-danger " id="warning">' +
                    '<a href="#" class="close" data-dismiss="alert">&times;</a>' +
                    '<p id="para" class="bg-danger ">' + '<strong>Warning! </strong>' + response.msg + '</p>' +
                    '</div>';
                $("#warning").html(msg);
            }

        }).error(function (error) {
            console.info("[App][getViewAdvisory][Error][Response] : " + JSON.stringify(error));
        });
    }


}]);



