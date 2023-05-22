var app = angular.module('magriApp');
app.filter('capitalizeWordHelp', function () {
    return function (text) {
        if (text.length <= 3) {
            return text.toUpperCase();
        } else {
            return (!!text) ? text.charAt(0).toUpperCase() + text.substr(1).toLowerCase() : '';
        }
    }
});
app.controller('helpQueueCTRL', function ($http, $scope, $location) {

    var ctrl = this;
    ctrl.loader = false;
    ctrl.itemsPerPage = 10;
    ctrl.currentPage = 1;
    ctrl.selectedstate = 'kz';
    ctrl.searchCellno = '';
    ctrl.dt_range = '';
    ctrl.paramType = "";
    ctrl.allstatesData = {};
    ctrl.star_class = 'star_red';
    ctrl.help = [];
    ctrl.sub_profile_onloadtime = {};
    ctrl.setTab = function (newTab) {
        resetValuesOnTabChange();
        ctrl.selectedstate = newTab;
        ctrl.loadHelpRequests('1', '');
    };

    ctrl.isSet = function (tabString) {
        return ctrl.selectedstate === tabString;
    };
    /*    $scope.$on('loadHelpRequest', function (event, data) {
     resetValuesOnTabChange();
     ctrl.loadHelpRequests(1);
     });*/
    ctrl.searchSubscriberByCellNo = function () {
        if (ctrl.searchCellno.length < 6) {

            var msg = "Search cellno should contain at least 6 Characters"
            notifyError(msg, 'Warning', 'danger');

        } else if (ctrl.searchCellno.length > 11) {
            var msg = "Cell number is not valid";
            notifyError(msg, 'Warning', 'danger');
        } else {
            ctrl.paramType = 'cellno';
            ctrl.loadHelpRequests('1');
        }
    };
    ctrl.searchSubscriberByDate = function () {
        if (ctrl.dt_range === "") {

            var msg = "Date range is not defined"
            notifyError(msg, 'Warning', 'danger');

        } else {
            ctrl.paramType = 'date';
            ctrl.loadHelpRequests('1');
        }
    };
    ctrl.loadHelpRequests = function (offset) {

        var url = '';
        var state = ctrl.selectedstate;
        var param = '';
        if (ctrl.dt_range != "" && ctrl.paramType == "date") {
            param = 'date';
            var dtrnge = ctrl.dt_range;
            var st = dtrnge.substr(0, 10);
            var end = dtrnge.substr(13, 22);
        } else if (ctrl.searchCellno != "" && ctrl.paramType == "cellno") {
            param = ctrl.searchCellno;
        }

        if (state == 'kaw') {
            url = '../service/sr_loadHelpRequests.php?param=' + param + '&offset=' + offset + '&state=' + state + '&st=' + st + '&end=' + end;
        } else if (state == 'kr') {
            url = '../service/sr_KrloadHelpRequests.php?param=' + param + '&offset=' + offset + '&state=' + state + '&st=' + st + '&end=' + end;

        } else {
            url = '../service/sr_loadHelpRequests.php?param=' + param + '&offset=' + offset + '&state=' + state + '&st=' + st + '&end=' + end;
        }

        console.log(url);
        ctrl.loader = true;
        $http.get(url).then(function (response) {
            //console.info("[App][loadSubscribers][success][Response] : " + JSON.stringify(response));
            ctrl.loader = false;
            if (response.data.success > 0) {
                ctrl.helpRequests = response.data.helpRequests;
                ctrl.total_users = response.data.total_pages;

            } else {
                resetValues();
                notifyError(response.data.msg, 'Warning', 'danger');
            }


        }, function (error) {
            console.info("[App][loadMenuBox][Error][Response] : " + JSON.stringify(error));
        });
    };

    resetValues = function () {
        ctrl.subscribers = {};
        ctrl.total_users = 0;
        ctrl.helpRequests = {};
    }
    resetValuesOnTabChange = function () {
        ctrl.currentPage = 1;
        ctrl.searchCellno = '';
        ctrl.dt_range = '';
    }
    ctrl.loadHelpModal = function (help) {

        var state = ctrl.selectedstate;
        ctrl.help = help;
        var cellno = help.cellno;
        var prov = help.state;
        var url = '';

        if (state == 'kaw') {
            state = 'missouri';

            url = '../service/sr_ka_getSubProfileNew.php?state=' + state + '&cellno=' + cellno;

            $http.get(url).then(function (response) {
                console.info("[App][loadSubscribers][success][Response] : " + JSON.stringify(response));

                if (response.data.success > 0) {
                    ctrl.sub_profile = response.data.sub_profile[0];
                    $('#kaModal').modal('show');
                }


            }, function (error) {
                console.info("[App][loadSubProfile][Error][Response] : " + JSON.stringify(error));
            });
        } else if (state == 'kr') {
            state = 'missouri';

            url = '../service/sr_kr_getSubProfileNew.php?state=' + state + '&cellno=' + cellno;

            $http.get(url).then(function (response) {
                console.info("[App][loadSubscribers][success][Response] : " + JSON.stringify(response));

                if (response.data.success > 0) {
                    ctrl.sub_profile = response.data.sub_profile[0];
                    $('#kaModal').modal('show');
                }


            }, function (error) {
                console.info("[App][loadSubProfile][Error][Response] : " + JSON.stringify(error));
            });
        } else {
            url = '../service/sr_getSubProfileNew.php?state=' + prov + '&cellno=' + cellno;

            $http.get(url).then(function (response) {
                //console.info("[App][loadSubscribers][success][Response] : " + JSON.stringify(response));

                if (response.data.success > 0) {
                    ctrl.sub_profile = response.data.sub_profile[0];

                    //ctrl.sub_profile.land_unit = "Acre";
                    ctrl.sub_profile_onloadtime = angular.copy(ctrl.sub_profile);
                    ctrl.allstatesData = response.data.statesData;
                    //ctrl.stateData = response.data.statesData[ctrl.sub_profile.state];
                    //ctrl.states = response.data.states;
                    ctrl.sub_names = response.data.names;
                    ctrl.filterLocations(ctrl.sub_profile.state);
                    ctrl.filterTehsils(ctrl.sub_profile.district);

                    $('#myModal').modal('show');

                } else {
                    console.info("[App][loadSubProfile][Error][Response] : " + JSON.stringify(response));
                }

            }, function (error) {
                console.info("[App][loadSubProfile][Error][Response] : " + JSON.stringify(error));
            });
        }
    };
    ctrl.filterLocations = function (state) {
        ctrl.stateData = ctrl.allstatesData[state];

        if (ctrl.sub_profile_onloadtime.state == state) {
            ctrl.sub_profile = angular.copy(ctrl.sub_profile_onloadtime);
        }
        console.log(ctrl.stateData);
        if (ctrl.stateData.has_default_srvc > 0) {
            ctrl.star_class = 'star_red';
        } else {
            ctrl.star_class = 'star_white';
            ctrl.stateData.services = [];
        }
    }
    ctrl.filterTehsils = function (district) {

        if (ctrl.stateData.districts[district] != undefined) {
            ctrl.tehsils = ctrl.stateData.districts[district].tehsils;
            //ctrl.sub_profile.tehsil = "";
            console.log("Tehsils - " + ctrl.tehsils);
        } else {
            console.log("Not valid district - " + district);
            ctrl.tehsils = [];
        }


    }
    ctrl.saveSubProfile = function (help) {

        console.log("test -" + ctrl.sub_profile);
        if (ctrl.sub_profile.state != 'gb' && (ctrl.sub_profile.srvc_id == null || ctrl.sub_profile.srvc_id == '')) {
            notifyError('Please select crop !', 'Warning', 'danger');
            return;
        }
        if (!ctrl.stateData.langs.includes(ctrl.sub_profile.lang)) {
            notifyError('Please select Language !', 'Warning', 'danger');
            return;
        }

        var data = $.param({
            "cellno": ctrl.sub_profile.cellno,
            "sub_name": ctrl.sub_profile.sub_name,
            "occupation": ctrl.sub_profile.occupation,
            "lang": ctrl.sub_profile.lang,
            "state": ctrl.sub_profile.state,
            "district": ctrl.sub_profile.district,
            "village": ctrl.sub_profile.village,
            "srvc_id": ctrl.sub_profile.srvc_id,
            "land": ctrl.sub_profile.land_size,
            "land_unit": ctrl.sub_profile.land_unit,
            "alerts_type": ctrl.sub_profile.alert_type,
            "channel": ctrl.sub_profile.bc_mode,
            "comment": ctrl.sub_profile.comment,
            "problem": ctrl.sub_profile.problem,
            "user_query": ctrl.sub_profile.user_query,
            "support": ctrl.sub_profile.support,
            "help_id": ctrl.help.id,
            "tehsil": ctrl.sub_profile.tehsil,
            "has_selected_loc": (ctrl.sub_profile.state != ctrl.sub_profile_onloadtime.state || ctrl.sub_profile.district != ctrl.sub_profile_onloadtime.district || ctrl.sub_profile.tehsil != ctrl.sub_profile_onloadtime.tehsil) ? 100 : -100,
            "oldData": JSON.stringify(ctrl.sub_profile_onloadtime)
        });
        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        ctrl.loader = true;
        $http.post('../service/sr_updateSubProfile.php', data, config).then(angular.bind(this, function (response) {
            if (response.data.success == 100) {
                var index = this.helpRequests.indexOf(this.help);
                this.helpRequests.splice(index, 1);
                notifyError(response.data.msg, "Success", "success");
            } else {
                notifyError(response.data.msg, "Warning", "danger");
            }
            $('#deleteModal').modal('hide');
            $('#myModal').modal('hide');
            ctrl.loader = false;
        }), function (error) {
            ctrl.loader = false;
            console.info("[App][doSubscribe][Error][Response] : " + JSON.stringify(error));
        });
    }
    ctrl.exportExcel = function (prov) {

        var is_dt = 0;
        var cellno = '';
        if (ctrl.dt_range != "" && ctrl.paramType == "date") {
            is_dt = 1;
            var dtrnge = ctrl.dt_range;
            var st = dtrnge.substr(0, 10);
            var end = dtrnge.substr(13, 22);
        } else if (ctrl.searchCellno != "" && ctrl.paramType == "cellno") {
            cellno = ctrl.searchCellno;
        }



        var state = ctrl.selectedstate;

        console.log('../service/export_help_excel.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt);

        window.location = '../service/export_help_excel.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt;


    }
    ctrl.changeAlertType = function () {
        if (ctrl.sub_profile.bc_mode == 'NONE') {
            ctrl.sub_profile.alert_type = -100;
        } else {
            if (ctrl.sub_profile.alert_type == -100)
                ctrl.sub_profile.alert_type = 500;
        }
    }

    function notifyError(msg, title, type)
    {
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
    ctrl.doUnSubscribe = function (cellno) {

        var url = '';
        if (ctrl.selectedstate == 'kaw') {
            url = '../service/sr_ka_doUnSubscribe.php?cellno=' + cellno;
            ctrl.loader = true;
            this.subscribers = ctrl.subscribers;
            this.cellno = cellno;
            $http.get(url).then(angular.bind(this, function (response) {

                if (response.data.success == 100) {
                    $('#deleteModal').modal('hide');
                    $('#kaModal').modal('hide');
                    notifyError(response.data.msg, 'Success', 'success');
                } else {
                    $('#deleteModal').modal('hide');
                    notifyError(response.data.msg, 'Warning', 'danger');
                }
                ctrl.loader = false;
            }), function (error) {
                ctrl.loader = false;
                console.info("[App][doUnSubscribe][Error][Response] : " + JSON.stringify(error));
            });


        } else if (ctrl.selectedstate == 'wdc') {

            url = '../service/sr_wdc_doUnSubscribe.php?cellno=' + cellno;
            ctrl.loader = true;
            this.subscribers = ctrl.subscribers;
            this.cellno = cellno;
            $http.get(url).then(angular.bind(this, function (response) {

                if (response.data.success == 100) {
                    $('#wdc_deleteModal').modal('hide');
                    $('#wdcModal').modal('hide');
                    notifyError(response.data.msg, 'Success', 'success');
                } else {
                    $('#deleteModal').modal('hide');
                    notifyError(response.data.msg, 'Warning', 'danger');
                }
                ctrl.loader = false;
            }), function (error) {
                ctrl.loader = false;
                console.info("[App][wdc_doUnSubscribe][Error][Response] : " + JSON.stringify(error));
            });

        } else {

            url = '../service/sr_doUnSubscribe.php?cellno=' + cellno;
            ctrl.loader = true;
            this.subscribers = ctrl.subscribers;
            this.cellno = cellno;
            $http.get(url).then(angular.bind(this, function (response) {

                if (response.data.success == 100) {
                    $('#deleteModal').modal('hide');
                    $('#myModal').modal('hide');
                    //    var index = this.subscribers.findIndex(x = > x.cellno == this.cellno
                    //)
                    //    ;
                    //    this.subscribers.splice(index, 1);
                    //    notifyError(response.data.msg, 'Success', 'success');
                } else {
                    $('#deleteModal').modal('hide');
                    notifyError(response.data.msg, 'Warning', 'danger');
                }
                ctrl.loader = false;
            }), function (error) {
                ctrl.loader = false;
                console.info("[App][doUnSubscribe][Error][Response] : " + JSON.stringify(error));
            });
        }

    }


});