var app = angular.module('magriApp');
app.filter('capitalizeWordNew', function () {
    return function (text) {
        if(text.length <= 3){
            return text.toUpperCase();
        }else{
            return (!!text) ? text.charAt(0).toUpperCase() + text.substr(1).toLowerCase() : '';
        }
    }
});
app.controller('unSUB',function($http,$scope,$location,$interval) {
    $scope.dt_range='';
    $scope.jobs_details=[];
    $scope.total='';
    $scope.itemsPerPage='10';
    $scope.currentPage='0';
    $scope.page_num=1;
    $scope.unsubscribed='';
    $scope.not_active_subscriber='';
    $scope.not_un_subscribed='';
    $scope.total_unsub='';
    $scope.job_id='';
    $scope.services=[];
    $scope.timer=null;
    $scope.param='';
    $scope.dateParam=false;

    $scope.getServices=function () {
        url='../service/sr_getAllServices.php';
        $http.get(url).then(function (response) {
            if(response.data.success==100){
                $scope.services=response.data.services;
            }else{
                notifyError(response.data.msg,"Warning","warning");
            }
        })
    };


    $scope.getServicesAmount = function (payWallId, action) {
        url = "../service/sr_getAllServicesAmount.php?pwi=" + payWallId;
        console.log({ url: url });
        console.log("action",action)
        if (action == 100) {
          $http.get(url).then(function (response) {
            if (response.data.success == 100) {
              $scope.servicesAmounts = response.data.servicesAmounts;
            } else {
              notifyError(response.data.msg, "Warning", "warning");
              $scope.servicesAmounts = undefined;
            }
          });
        } else {
          $scope.servicesAmounts = [];
        }
      };
    // $scope.getServicesAmount=function (payWallId,action) {
    //     url='../service/sr_getAllServicesAmount.php?pwi='+payWallId;
    //     console.log({"url": url});
    //     $http.get(url).then(function (response) {
    //         if(response.data.success==100){
    //             $scope.servicesAmounts=response.data.servicesAmounts;
    //         }else{
    //             notifyError(response.data.msg,"Warning","warning");
    //             $scope.servicesAmounts=undefined;
    //         }
    //     })
    // };


    $scope.searchJobByDate = function(){
        if ($scope.dt_range == "") {
            var msg = "Date range is not defined";
                notifyError(msg,'Warning','danger');

        } else {
            $scope.dateParam=true;
            $interval.cancel($scope.timer);
            $scope.loadJobs('1','date');
        }
    };
    $scope.clearDate=function () {
        $scope.dt_range="";
        $scope.loadJobs('1','');
        $scope.dateParam=false;
    };
    $scope.loadJobs=function(offset,param){
        if($scope.dt_range != ""){

            var dtrnge = $scope.dt_range;
            var st =dtrnge.substr(0, 10);
            var end =dtrnge.substr(13, 22);
            console.log(st+'         '+end);
        }
        var url="../service/sr_getUnsubJobsDetails.php?offset="+offset+"&st="+st+"&end="+end;
        $http.get(url).then(function (response) {
           if(response.data.success===100){
                $scope.jobs_details=response.data.jobs_details;
                $scope.total=response.data.total;
                $scope.page_num=response.data.page_number;
                console.log($scope.jobs_details);
           }else{
                $scope.jobs_details=response.data.jobs_details;
                $scope.page_num=response.data.page_number;
                $scope.dt_range='';
                notifyError(response.data.msg,"Warning","warning");
                setTimeout(function () {
                    $scope.loadJobs($scope.page_num,"");
                },4000)
           }
        });
    };
    $scope.timer=$interval(function () {
        $scope.loadJobs($scope.page_num,'');
    },15000);
    $scope.updateJobStatus=function (status,id) {
      var url="../service/sr_updateJobStatus.php?status="+status+"&id="+id;
      $http.get(url).then(function (response) {
          if(response.data.success==100){
              $scope.loadJobs($scope.page_num,'');
              notifyError(response.data.msg,"Success","success");
          }else{
              notifyError(response.data.msg,"Warning","warning");
          }
      })
    };
    $scope.jobSummary=function (id) {
        $scope.job_id=id;
        url="../service/sr_unsubJobSummary.php?id="+id;
        $http.get(url).then(function (response) {
        if(response.data.success ==100){
            $("#myModal").modal('show');
            $scope.unsubscribed=response.data.unsubscribed;
            $scope.not_active_subscriber=response.data.not_active_subscriber;
            $scope.not_un_subscribed=response.data.not_un_subscribed;
            $scope.total_unsub=response.data.total;
        }else{
            notifyError(response.data.msg,"Warning","warning");
        }
        });
    };
    $scope.exportExcel=function (offset,id) {
        if(offset=='job'){
            window.location = '../service/export_excel_unsub_job_activity.php?id=' + id;
        }else {
            window.location = '../service/export_excel_unsub_job.php?id=' + id;
            $("#myModal").modal('hide');
        }
    }
    function notifyError(msg,title,type)
    {
        var zIndex = 1031;
        if (msg == "Please select crop !"){
            zIndex = 1051;
        }
        if (!$('#myModal').context.hidden){ //msg == "Please select crop !"
            zIndex = 1051;
        }
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
            z_index   : zIndex,
            delay     : 3000,
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