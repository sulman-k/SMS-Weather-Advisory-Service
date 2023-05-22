var app = angular.module("magriApp");

app.directive('validFile',function(){
    return {
        require:'ngModel',
        link:function(scope,el,attrs,ngModel){
            el.bind('change',function(){
                scope.$apply(function(){
                    ngModel.$setViewValue(el.val());
                    ngModel.$render();
                });
            });
        }
    }
});
app.directive('fileModel', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;
            element.bind('change', function(){
                scope.$apply(function(){
                    modelSetter(scope, element[0].files[0]);
                });
            });
        }
    };
}]);
app.controller('batchRequestCTRL',function($http,$scope,$timeout,$window){

    ctrl = this;
    ctrl.actions = ['Subscribe','UnSubscribe'];
    ctrl.fileInfo = {};
    ctrl.loader = false;
    ctrl.showConfirmModal = false;
    ctrl.confirmed = false;
    ctrl.validNumbers = 0;
    ctrl.invalidNumbers = 0;
    ctrl.totalNumbers = 0;
    ctrl.uploadId = -1;
    ctrl.successRatio = 0;
    ctrl.failureRatio = 0;
    ctrl.filesData = [];
    ctrl.itemsPerPage  = 10;
    ctrl.currentPage = 1;
    ctrl.filename = "";
    ctrl.title = "";
    ctrl.dt_range = "";
    ctrl.tbl_name="";
    ctrl.subs_num='',

    ctrl.checkFileInfo = function(){
        ctrl.loader = true;

        var fd = new FormData();
        fd.append('file', ctrl.fileInfo.file);
        fd.append('title',ctrl.fileInfo.title);
        fd.append('action',ctrl.fileInfo.actionType);
        var config = {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined}
        };
        $http.post('../service/sr_uploadFile.php', fd, config).then(function(response){
            if (response.data.success > 0) {
                ctrl.totalNumbers = response.data.totalNumbers;
                ctrl.invalidNumbers = response.data.invalidNumbers;
                ctrl.validNumbers = response.data.validNumbers;
                ctrl.uploadId = response.data.uploadId;
                ctrl.tbl_name=response.data.tbl_name;
                ctrl.subs_num=response.data.sub_num;
                ctrl.showConfirmModal = true;

            } else {
                notifyError(response.data.msg,'Warning','danger');
            }

            ctrl.loader = false;
        },function(error){
            ctrl.loader = false;
            console.info("[App][doSubscribe][Error][Response] : " + JSON.stringify(error));
        });
    }
    ctrl.cancelUpload = function(){

        ctrl.showConfirmModal = false;
        window.location.href='uploadFileDetails.php';


    }
    ctrl.checkStatus=function (id) {
      ctrl.id=id;
      ctrl.loader=true;
      $http.get('../service/sr_statusOFUploadFile.php?id='+ctrl.id).then(function (response) {
          if(response.data.success>0){
              ctrl.count=response.data.count;
              notifyError(response.data.msg+' '+ctrl.count,'Success','success');

          }else{
              notifyError(response.data.msg,'Warning','danger');

          }
          ctrl.loader=false;

      },function(error){
          ctrl.loader = false;
          console.info("[App][doSubscribe][Error][Response] : " + JSON.stringify(error));
      });
    }
    ctrl.confirmUpload = function(){
     /*   var url    = '../service/sr_executeBulkAction.php';
        if(ctrl.fileInfo.actionType == 'UnSubscribe'){
            url    = '../service/sr_executeBulkActionUnSub.php';
        }
        ctrl.loader = true;
        var data =$.param ({
            'upload_id' : ctrl.uploadId,
            'tbl_name':ctrl.tbl_name
        });
        var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        $http.post(url,data,config).then(function (response) {
            if (response.data.success > 0) {
                ctrl.validNumbers = response.data.validNumbers;
                ctrl.successRatio = response.data.successRatio;
                ctrl.failureRatio = response.data.failureRatio;
                ctrl.showConfirmModal = false;
                ctrl.confirmed = true;

            } else {
                notifyError(response.data.msg,'Warning','danger');
            }

            ctrl.loader = false;
        },function(error){
            ctrl.loader = false;
            console.info("[App][doSubscribe][Error][Response] : " + JSON.stringify(error));
        });*/
        var url    = '../service/sr_deleteActiveSubscriber.php';
        ctrl.loader = true;
        var data =$.param ({
            'upload_id' : ctrl.uploadId,
            'tbl_name':ctrl.tbl_name
        });
        var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        $http.post(url,data,config).then(function (response) {
            if (response.data.success > 0) {
                notifyError(response.data.msg,'Success','success');
                angular.element(document.getElementById('save_vaccine'))[0].disabled = true;


            } else {
                notifyError(response.data.msg,'Warning','danger');
            }

            ctrl.loader = false;
        },function(error){
            ctrl.loader = false;
            console.info("[App][doSubscribe][Error][Response] : " + JSON.stringify(error));
        })

    }
    ctrl.uploadConfirmed = function () {
            $window.location.reload();
    }
    ctrl.getFileName = function(){
            var index = ctrl.fileInfo.file.name.lastIndexOf("\\");
            return ctrl.fileInfo.file.name.substring(index+1);
    }
    ctrl.getFilesData = function(offset){

        var st = "";
        var end = "";
       if (ctrl.dt_range != "" ) {
            var dtrnge = ctrl.dt_range;
            st = dtrnge.substr(0, 10);
            end = dtrnge.substr(13, 22);
        }

        var url        = '../service/sr_getFilesData.php?offset='+ offset +'&title='+ctrl.title+'&filename='+ctrl.filename+'&st='+st+'&end='+end;
        ctrl.loader = true;
        $http.get(url).then(function (response) {
            //console.info("[App][loadSubscribers][success][Response] : " + JSON.stringify(response));
            ctrl.loader = false;
            if (response.data.success > 0) {
                ctrl.filesData = response.data.filesData;
                ctrl.totalRecords = response.data.totalRecords;

            } else {
                ctrl.filesData = {};
                ctrl.totalRecords = 0;
                notifyError(response.data.msg,'Warning','danger');
            }


        },function (error) {
            console.info("[App][loadMenuBox][Error][Response] : " + JSON.stringify(error));
        });

    }
    function notifyError(msg,title,type)
    {
        var zIndex = 1031;

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

