var app = angular.module('magriApp');
app.filter('capitalizeWord', function () {
    return function (text) {
        return (!!text) ? text.charAt(0).toUpperCase() + text.substr(1).toLowerCase() : '';
    }
});
app.controller('helpResponseCTRL',function($http,$scope,$location){

    var ctrl = this;
    ctrl.loader = false;
    ctrl.itemsPerPage  = 10;
    ctrl.currentPage = 1;
    ctrl.selectedstate = 'kz';
    ctrl.searchCellno = '';
    ctrl.dt_range = '';
    ctrl.paramType = "";
    ctrl.setTab = function(newTab){
        resetValuesOnTabChange();
        ctrl.selectedstate = newTab;
        ctrl.loadHelpResponse('1');
    };

    ctrl.isSet = function(tabString){
        return ctrl.selectedstate === tabString;
    };
/*    $scope.$on('loadHelpResponse', function (event, data) {
        resetValuesOnTabChange();
        ctrl.loadHelpResponse(1);
    });*/
    ctrl.searchSubscriberByCellNo = function(){
        if (ctrl.searchCellno.length < 6) {

            var msg = "Search cellno should contain at least 6 Characters"
            notifyError(msg,'Warning','danger');

        }else if(ctrl.searchCellno.length > 11 ){
            var msg = "Cell number is not valid"
            notifyError(msg,'Warning','danger');
        } else {
            ctrl.paramType = 'cellno';
            ctrl.loadHelpResponse('1');
        }
    };
    ctrl.searchSubscriberByDate = function(){
        if (ctrl.dt_range === "") {

            var msg = "Date range is not defined"
            notifyError(msg,'Warning','danger');

        } else {
            ctrl.paramType = 'date';
            ctrl.loadHelpResponse('1');
        }
    };

    resetValues = function(){
        ctrl.total_subscriber = 0;
        ctrl.helpRequests = {};
    }
    resetValuesOnTabChange = function(){
        ctrl.currentPage = 1;
        ctrl.searchCellno = '';
        ctrl.dt_range = '';
    }

    ctrl.exportExcel = function () {

        var is_dt = 0;
        var cellno = '';
        if (ctrl.dt_range != "" && ctrl.paramType == "date") {
            is_dt = 1;
            var dtrnge = ctrl.dt_range;
            var st = dtrnge.substr(0, 10);
            var end = dtrnge.substr(13, 22);
        }else if(ctrl.searchCellno != "" && ctrl.paramType == "cellno"){
            cellno= ctrl.searchCellno;
        }

        var state = ctrl.selectedstate;

        console.log('../service/export_help_response_excel.php?st=' + st + '&end=' + end + '&cellno=' + cellno+ '&state=' + state + '&is_dt=' + is_dt);

        window.location = '../service/export_help_response_excel.php?st=' + st + '&end=' + end + '&cellno=' + cellno+ '&state=' + state + '&is_dt=' + is_dt;


    }

    ctrl.loadHelpResponse = function (offset) {

        var state = ctrl.selectedstate;
        var param = "";
        if (ctrl.dt_range != "" && ctrl.paramType == "date") {
            param='date';
            var dtrnge = ctrl.dt_range;
            var st = dtrnge.substr(0, 10);
            var end = dtrnge.substr(13, 22);
        } else if(ctrl.searchCellno != "" && ctrl.paramType == "cellno"){
            param = ctrl.searchCellno;
        }
        var url        = '../service/sr_loadHelpResponse.php?offset=' + offset + '&state=' + state + '&param=' + param + '&st=' + st + '&end=' + end;
        var pagination = '';

        console.log(url);
        ctrl.loader = true;
        $http.get(url).then(function (response) {
            //console.info("[App][loadSubscribers][success][Response] : " + JSON.stringify(response));
            ctrl.loader = false;
            if (response.data.success > 0) {
                ctrl.helpRequests = response.data.helpRequests;
                ctrl.total_subscriber = response.data.total_pages;

            } else {
                resetValues();
                notifyError(response.data.msg,'Warning','danger');
            }


        },function (error) {
            console.info("[App][loadMenuBox][Error][Response] : " + JSON.stringify(error));
        });
    }
    function notifyError(msg,title,type)
    {
        $.notify({
            title  : '<strong>'+title+'!</strong>',
            message: msg
        }, {
            type: type,

            placement : {
                from : "top",
                align: "right"
            },
            offset    : {
                x: 47,
                y: 70
            },
            spacing   : 10,
            z_index   : 1031,
            delay     : 5000,
            timer     : 1000,
            url_target: '_blank',
            mouse_over: null,
            animate   : {
                enter: 'animated fadeInDown',
                exit : 'animated fadeOutUp'
            }
        });
    }


});