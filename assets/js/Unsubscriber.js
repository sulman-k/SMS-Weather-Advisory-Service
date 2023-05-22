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
app.controller('unSUBCTRL',function($http,$scope,$location){

    var ctrl = this;
    ctrl.defualtPro='kzp';
   ctrl.loader = false;
    ctrl.itemsPerPage  = 10;
    ctrl.currentPage = 1;
    ctrl.selectedstate ='kz';
    ctrl.searchCellno = '';
    ctrl.dt_range = '';
    ctrl.paramType = "";
    ctrl.allstatesData = {};
    ctrl.star_class = 'star_red';
    ctrl.prevstate = "";
    ctrl.sub_profile_onloadtime = {};
    ctrl.modalOpen = false;
    ctrl.unsubscribers=[];
    ctrl.dateParam=false;

    ctrl.setTab = function(newTab){
        resetValuesOnTabChange();
        ctrl.selectedstate = newTab;
        ctrl.loadunSubscribers('1','');

    };
    /*    $scope.$on('loadSubscribers', function (event, data) {
            resetValuesOnTabChange();
            ctrl.loadSubscribers(1,'');
        });*/
    ctrl.isSet = function(tabString){
        return ctrl.selectedstate === tabString;
    };

    ctrl.searchunSubscriberByCellNo = function(){
        if (ctrl.searchCellno.length < 6) {
            var msg = "Search cellno should contain at least 6 Characters"
            notifyError(msg,'Warning','danger');

        } else if(ctrl.searchCellno.length > 11 ){
            var msg = "Cell number is not valid"
            notifyError(msg,'Warning','danger');
        }else {
            ctrl.paramType = 'cellno';
            ctrl.loadunSubscribers('1',ctrl.searchCellno);
        }
    };
    ctrl.searchunSubscriberByDate = function(){
        if (ctrl.dt_range === "") {

            var msg = "Date range is not defined"
            notifyError(msg,'Warning','danger');

        } else {
            ctrl.dateParam=true;
            ctrl.paramType = 'date';
            ctrl.loadunSubscribers('1','date');
        }
    };
    ctrl.clearDate=function () {
        ctrl.dt_range="";
        ctrl.loadunSubscribers('1','');
        ctrl.dateParam=false;
    };
    ctrl.loadunSubscribers = function (offset,param) {

        var state = ctrl.selectedstate;

        var url = '';
        if (ctrl.dt_range != "" && ctrl.paramType == "date") {
            param='date';
            var dtrnge = ctrl.dt_range;
            var st = dtrnge.substr(0, 10);
            var end = dtrnge.substr(13, 22);
        } else if(ctrl.searchCellno != "" && ctrl.paramType == "cellno"){
            param = ctrl.searchCellno;
        }
        if(state==='kaw'){
            url        = '../UnSubServices/sr_ka_loadunSubscriber.php?offset=' + offset + '&state=' + state + '&param=' + param + '&st=' + st + '&end=' + end;
        }else if(state==='wdc'){
            url        = '../UnSubServices/sr_wdc_loadunSubscriber.php?offset=' + offset + '&state=' + state + '&param=' + param + '&st=' + st + '&end=' + end;
        }else if(state==='kam'){
            url        = '../UnSubServices/sr_kam_loadunSubscriber.php?offset=' + offset + '&state=' + state + '&param=' + param + '&st=' + st + '&end=' + end
        }
        else if(state ==='kb'){
            url        = '../UnSubServices/sr_kb_loadUnSubscriber.php?offset=' + offset + '&state=' + state + '&param=' + param + '&st=' + st + '&end=' + end

        }else if(state==='kk'){
            url        = '../UnSubServices/sr_kk_loadUnSubscriber.php?offset=' + offset + '&state=' + state + '&param=' + param + '&st=' + st + '&end=' + end

        } else if(state==='kj'){
            url        = '../UnSubServices/sr_kj_loadUnSubscriber.php?offset=' + offset + '&state=' + state + '&param=' + param + '&st=' + st + '&end=' + end

        } else if(state==='rm'){
            url        = '../UnSubServices/sr_rm_loadUnSubscriber.php?offset=' + offset + '&state=' + state + '&param=' + param + '&st=' + st + '&end=' + end

        }
        else if(state==='kn'){
            url        = '../UnSubServices/sr_kn_loadUnSubscriber.php?offset=' + offset + '&state=' + state + '&param=' + param + '&st=' + st + '&end=' + end

        } else if(state==='zd'){
            url        = '../UnSubServices/sr_zd_loadUnSubscriber.php?offset=' + offset + '&state=' + state + '&param=' + param + '&st=' + st + '&end=' + end

        }
        else if(state==='kad'){
            url        = '../UnSubServices/sr_kad_loadUnSubscriber.php?offset=' + offset + '&state=' + state + '&param=' + param + '&st=' + st + '&end=' + end

        }
        else if(state==='kt'){
            url        = '../UnSubServices/sr_kt_loadUnSubscriber.php?offset=' + offset + '&state=' + state + '&param=' + param + '&st=' + st + '&end=' + end

        }
        else  {
            url = '../UnSubServices/sr_loadunSubscribers.php?offset=' + offset + '&state=' + state + '&param=' + param + '&st=' + st + '&end=' + end;
        }

        console.log(url);
        ctrl.loader = true;
        $http.get(url).then(function (response) {
            //console.info("[App][loadSubscribers][success][Response] : " + JSON.stringify(response));
            ctrl.loader = false;
            if (response.data.success > 0) {
                ctrl.unsubscriber = response.data.unsubscriber;

                ctrl.total_unsubscriber = response.data.total_pages;

            } else {

                resetValues();
                notifyError(response.data.msg,'Warning','danger');
            }


        },function (error) {
            console.info("[App][loadMenuBox][Error][Response] : " + JSON.stringify(error));
        });
    }

    resetValues = function(){
        ctrl.unsubscriber = [];
        ctrl.total_unsubscriber = 0;
        ctrl.helpRequests = {};
    }
    resetValuesOnTabChange = function(){
        ctrl.currentPage = 1;
        ctrl.searchCellno = '';
        ctrl.dt_range = '';
    }
    ctrl.loadUnSubProfile = function ( user) {

        var state = ctrl.selectedstate;
        ctrl.user = user;
        var cellno = user.cellno;
        var url = '';
        if(state == 'kaw'){
            state = 'missouri';
            url    = '../UnSubServices/sr_ka_getUnSubProfile.php?state=' + state + '&cellno=' + cellno;

            $http.get(url).then(function (response) {
                console.info("[App][loadSubscribers][success][Response] : " + JSON.stringify(response));

                if(response.data.success > 0){
                    ctrl.sub_profile = response.data.sub_profile[0];
                    $('#kaModal').modal('show');
                }


            },function (error) {
                console.info("[App][loadSubProfile][Error][Response] : " + JSON.stringify(error));
            });
        }else if(state=='wdc' ) {
            url = '../UnSubServices/sr_wdc_getUnSubProfile.php?state=' + state + '&cellno=' + cellno;
            $http.get(url).then(function (response) {

                console.info("[App][wdc_loadSubscribers][success][Response] : " + JSON.stringify(response));
                if (response.data.success > 0) {
                    ctrl.wdc_profile = response.data.wdc_profile[0];
                    $('#wdcModal').modal('show');
                }
            },function (error) {
                console.info("[App][loadSubProfile][Error][Response] : " + JSON.stringify(error));

            });


        }else if(state=='kam'){
            url = '../UnSubServices/sr_kam_getUnSubProfile.php?state=' + state + '&cellno=' + cellno;
            $http.get(url).then(function (response) {

                console.info("[App][kam_loadSubscribers][success][Response] : " + JSON.stringify(response));
                if (response.data.success > 0) {
                    ctrl.wdc_profile = response.data.wdc_profile[0];
                    $('#wdcModal').modal('show');
                }
            },function (error) {
                console.info("[App][kam loadSubProfile][Error][Response] : " + JSON.stringify(error));

            })
        }else if(state==='kb'){
            url = '../UnSubServices/sr_kb_getUnSubProfile.php?state=' + state + '&cellno=' + cellno;
            $http.get(url).then(function (response) {

                console.info("[App][kb_loadUnSubscribers][success][Response] : " + JSON.stringify(response));
                if (response.data.success > 0) {
                    ctrl.wdc_profile = response.data.wdc_profile[0];
                    $('#wdcModal').modal('show');
                }
            },function (error) {
                console.info("[App][kam loadSubProfile][Error][Response] : " + JSON.stringify(error));

            })
        } else if(state==='kk'){
            url = '../UnSubServices/sr_kk_getUnSubProfile.php?state=' + state + '&cellno=' + cellno;
            $http.get(url).then(function (response) {

                console.info("[App][kk_loadUnSubscribers][success][Response] : " + JSON.stringify(response));
                if (response.data.success > 0) {
                    ctrl.wdc_profile = response.data.wdc_profile[0];
                    $('#wdcModal').modal('show');
                }
            },function (error) {
                console.info("[App][kk loadSubProfile][Error][Response] : " + JSON.stringify(error));

            })
        } else if(state=='kj'){
            url = '../UnSubServices/sr_kj_getUnSubProfile.php?state=' + state + '&cellno=' + cellno;
            $http.get(url).then(function (response) {

                console.info("[App][kj_loadUnSubscribers][success][Response] : " + JSON.stringify(response));
                if (response.data.success > 0) {
                    ctrl.wdc_profile = response.data.wdc_profile[0];
                    $('#wdcModal').modal('show');
                }
            },function (error) {
                console.info("[App][kj loadSubProfile][Error][Response] : " + JSON.stringify(error));

            })
        } else if(state=='rm'){
            url = '../UnSubServices/sr_rm_getUnSubProfile.php?state=' + state + '&cellno=' + cellno;
            $http.get(url).then(function (response) {

                console.info("[App][rm_loadUnSubscribers][success][Response] : " + JSON.stringify(response));
                if (response.data.success > 0) {
                    ctrl.wdc_profile = response.data.rm_profile[0];
                    $('#wdcModal').modal('show');
                }
            },function (error) {
                console.info("[App][rm loadSubProfile][Error][Response] : " + JSON.stringify(error));

            })
        }else if(state=='kn'){
            url = '../UnSubServices/sr_kn_getUnSubProfile.php?state=' + state + '&cellno=' + cellno;
            $http.get(url).then(function (response) {

                console.info("[App][kn_loadUnSubscribers][success][Response] : " + JSON.stringify(response));
                if (response.data.success > 0) {
                    ctrl.wdc_profile = response.data.kn_profile[0];
                    $('#wdcModal').modal('show');
                }
            },function (error) {
                console.info("[App][kn_loadSubProfile][Error][Response] : " + JSON.stringify(error));

            })
        }else if(state=='zd'){
            url = '../UnSubServices/sr_zd_getUnSubProfile.php?state=' + state + '&cellno=' + cellno;
            $http.get(url).then(function (response) {

                console.info("[App][zd_loadUnSubscribers][success][Response] : " + JSON.stringify(response));
                if (response.data.success > 0) {
                    ctrl.wdc_profile = response.data.zd_profile[0];
                    $('#wdcModal').modal('show');
                }
            },function (error) {
                console.info("[App][zd_loadSubProfile][Error][Response] : " + JSON.stringify(error));

            })
        }
        else if(state=='kad'){
            url = '../UnSubServices/sr_kad_getUnSubProfile.php?state=' + state + '&cellno=' + cellno;
            $http.get(url).then(function (response) {

                console.info("[App][kad_loadUnSubscribers][success][Response] : " + JSON.stringify(response));
                if (response.data.success > 0) {
                    ctrl.wdc_profile = response.data.kd_profile[0];
                    $('#wdcModal').modal('show');
                }
            },function (error) {
                console.info("[App][kad_loadSubProfile][Error][Response] : " + JSON.stringify(error));

            })
        }
        else if(state=='kt'){
            url = '../UnSubServices/sr_kt_getUnSubProfile.php?state=' + state + '&cellno=' + cellno;
            $http.get(url).then(function (response) {

                console.info("[App][kt_loadUnSubscribers][success][Response] : " + JSON.stringify(response));
                if (response.data.success > 0) {
                    ctrl.wdc_profile = response.data.kt_profile[0];
                    $('#wdcModal').modal('show');
                }
            },function (error) {
                console.info("[App][kt_loadSubProfile][Error][Response] : " + JSON.stringify(error));

            })
        }
        else {
            url    = '../UnSubServices/sr_getUnSubProfile.php?state=' + state + '&cellno=' + cellno;

            $http.get(url).then(function (response) {
                console.info("[App][loadSubscribers][success][Response] : " + JSON.stringify(response));

                if(response.data.success > 0){
                    ctrl.sub_profile = response.data.sub_profile[0];
                    $('#myModal').modal('show');
                }


            },function (error) {
                console.info("[App][loadSubProfile][Error][Response] : " + JSON.stringify(error));
            });

        }

    }
    ctrl.doSubscribe = function (cellno) {
        var url = '';
        ctrl.cellno=cellno;
        if(ctrl.selectedstate == 'kaw'){
            url    = '../service/sr_ka_addSubscriber.php?cellno=' + ctrl.cellno;
            ctrl.loader = true;
            $http.get(url).then(angular.bind(this,function (response) {
                console.info("[App][doSubscribe][success][Response] : " + JSON.stringify(response));
                ctrl.loader = false;
                if (response.data.success == 100) {
                    notifyError(response.data.msg,'Success','success');
                    //if(response.data.issub != "Y" && response.data.subscriber.state == this.selectedstate )
                    //    this.subscribers.push(response.data.subscriber);
                    ctrl.cellno = '';
                    $('#kaModal').modal('hide');
                    ctrl.loadunSubscribers(1,'');
                } else {
                    notifyError(response.data.msg,'Warning','danger');
                }

            }),function (error) {
                ctrl.loader = false;
                console.info("[App][doSubscribe][Error][Response] : " + JSON.stringify(error));
            });


        }else if(ctrl.selectedstate=='wdc'){
            url    = '../service/sr_wdc_addSubscriber.php?cellno=' + ctrl.cellno;
            ctrl.loader = true;
            this.subscribers = ctrl.subscribers;
            this.selectedstate = ctrl.selectedstate;
            $http.get(url).then(angular.bind(this,function (response) {
                console.info("[App][wdc_doSubscribe][success][Response] : " + JSON.stringify(response));
		 ctrl.loader = false;
                if (response.data.success == 100) {
                    notifyError(response.data.msg,'Success','success');
                    //if(response.data.issub != "Y" && response.data.subscriber.state == this.selectedstate )
                      //  this.subscribers.push(response.data.subscriber);
                    ctrl.cellno = '';
                    $('#wdcModal').modal('hide');
                    ctrl.loadunSubscribers(1,'');
                } else {
                    notifyError(response.data.msg,'Warning','danger');
                }
            }),function (error) {
                ctrl.loader = false;
                console.info("[App][wdc_doSubscribe][Error][Response] : " + JSON.stringify(error));
            });

        }else if(ctrl.selectedstate=='kam'){
            url    = '../service/sr_kam_addSubscriber.php?cellno=' + ctrl.cellno;
            ctrl.loader = true;
            this.subscribers = ctrl.subscribers;
            this.selectedstate = ctrl.selectedstate;
            $http.get(url).then(angular.bind(this,function (response) {
                console.info("[App][kam_doSubscribe][success][Response] : " + JSON.stringify(response));
                ctrl.loader = false;
                if (response.data.success == 100) {

                    notifyError(response.data.msg,'Success','success');
                    //if(response.data.issub != "Y" && response.data.subscriber.state == this.selectedstate )
                    //  this.subscribers.push(response.data.subscriber);
                    ctrl.cellno = '';
                    $('#wdcModal').modal('hide');
                    ctrl.loadunSubscribers(1,'');
                } else {
                    notifyError(response.data.msg,'Warning','danger');
                }
            }),function (error) {
                ctrl.loader = false;
                console.info("[App][kam_doSubscribe][Error][Response] : " + JSON.stringify(error));
            });

        }else if(ctrl.selectedstate==='kb'){
            url    = '../service/sr_kb_addSubscriber.php?cellno=' + ctrl.cellno;
            ctrl.loader = true;
            this.subscribers = ctrl.subscribers;
            this.selectedstate = ctrl.selectedstate;
            $http.get(url).then(angular.bind(this,function (response) {
                console.info("[App][kb_doSubscribe][success][Response] : " + JSON.stringify(response));
                ctrl.loader = false;
                if (response.data.success == 100) {

                    notifyError(response.data.msg,'Success','success');
                    //if(response.data.issub != "Y" && response.data.subscriber.state == this.selectedstate )
                    //  this.subscribers.push(response.data.subscriber);
                    ctrl.cellno = '';
                    $('#wdcModal').modal('hide');
                    ctrl.loadunSubscribers(1,'');
                } else {
                    notifyError(response.data.msg,'Warning','danger');
                }
            }),function (error) {
                ctrl.loader = false;
                console.info("[App][kb_doSubscribe][Error][Response] : " + JSON.stringify(error));
            });
        }else if(ctrl.selectedstate==='kk'){
            url    = '../service/sr_kk_addSubscriber.php?cellno=' + ctrl.cellno;
            ctrl.loader = true;
            this.subscribers = ctrl.subscribers;
            this.selectedstate = ctrl.selectedstate;
            $http.get(url).then(angular.bind(this,function (response) {
                console.info("[App][kk_doSubscribe][success][Response] : " + JSON.stringify(response));
                ctrl.loader = false;
                if (response.data.success == 100) {

                    notifyError(response.data.msg,'Success','success');
                    //if(response.data.issub != "Y" && response.data.subscriber.state == this.selectedstate )
                    //  this.subscribers.push(response.data.subscriber);
                    ctrl.cellno = '';
                    $('#wdcModal').modal('hide');
                    ctrl.loadunSubscribers(1,'');
                } else {
                    notifyError(response.data.msg,'Warning','danger');
                }
            }),function (error) {
                ctrl.loader = false;
                console.info("[App][kk_doSubscribe][Error][Response] : " + JSON.stringify(error));
            });
        } else if(ctrl.selectedstate==='kj'){
            url    = '../service/sr_kj_addSubscriber.php?cellno=' + ctrl.cellno;
            ctrl.loader = true;
            this.subscribers = ctrl.subscribers;
            this.selectedstate = ctrl.selectedstate;
            $http.get(url).then(angular.bind(this,function (response) {
                console.info("[App][kj_doSubscribe][success][Response] : " + JSON.stringify(response));
                ctrl.loader = false;
                if (response.data.success == 100) {

                    notifyError(response.data.msg,'Success','success');
                    //if(response.data.issub != "Y" && response.data.subscriber.state == this.selectedstate )
                    //  this.subscribers.push(response.data.subscriber);
                    ctrl.cellno = '';
                    $('#wdcModal').modal('hide');
                    ctrl.loadunSubscribers(1,'');
                } else {
                    notifyError(response.data.msg,'Warning','danger');
                }
            }),function (error) {
                ctrl.loader = false;
                console.info("[App][kj_doSubscribe][Error][Response] : " + JSON.stringify(error));
            });
        }else if(ctrl.selectedstate==='rm'){
            url    = '../service/sr_rm_addSubscriber.php?cellno=' + ctrl.cellno;
            ctrl.loader = true;
            this.subscribers = ctrl.subscribers;
            this.selectedstate = ctrl.selectedstate;
            $http.get(url).then(angular.bind(this,function (response) {
                console.info("[App][rm_doSubscribe][success][Response] : " + JSON.stringify(response));
                ctrl.loader = false;
                if (response.data.success == 100) {

                    notifyError(response.data.msg,'Success','success');
                    //if(response.data.issub != "Y" && response.data.subscriber.state == this.selectedstate )
                    //  this.subscribers.push(response.data.subscriber);
                    ctrl.cellno = '';
                    $('#wdcModal').modal('hide');
                    ctrl.loadunSubscribers(1,'');
                } else {
                    notifyError(response.data.msg,'Warning','danger');
                }
            }),function (error) {
                ctrl.loader = false;
                console.info("[App][rm_doSubscribe][Error][Response] : " + JSON.stringify(error));
            });
        }else if(ctrl.selectedstate==='kn'){
            url    = '../service/sr_kn_addSubscriber.php?cellno=' + ctrl.cellno;
            ctrl.loader = true;
            this.subscribers = ctrl.subscribers;
            this.selectedstate = ctrl.selectedstate;
            $http.get(url).then(angular.bind(this,function (response) {
                console.info("[App][kn_doSubscribe][success][Response] : " + JSON.stringify(response));
                ctrl.loader = false;
                if (response.data.success == 100) {

                    notifyError(response.data.msg,'Success','success');
                    //if(response.data.issub != "Y" && response.data.subscriber.state == this.selectedstate )
                    //  this.subscribers.push(response.data.subscriber);
                    ctrl.cellno = '';
                    $('#wdcModal').modal('hide');
                    ctrl.loadunSubscribers(1,'');
                } else {
                    notifyError(response.data.msg,'Warning','danger');
                }
            }),function (error) {
                ctrl.loader = false;
                console.info("[App][kn_doSubscribe][Error][Response] : " + JSON.stringify(error));
            });
        }else if(ctrl.selectedstate==='zd'){
            url    = '../service/sr_zd_addSubscriber.php?cellno=' + ctrl.cellno;
            ctrl.loader = true;
            this.subscribers = ctrl.subscribers;
            this.selectedstate = ctrl.selectedstate;
            $http.get(url).then(angular.bind(this,function (response) {
                console.info("[App][zd_doSubscribe][success][Response] : " + JSON.stringify(response));
                ctrl.loader = false;
                if (response.data.success == 100) {

                    notifyError(response.data.msg,'Success','success');
                    //if(response.data.issub != "Y" && response.data.subscriber.state == this.selectedstate )
                    //  this.subscribers.push(response.data.subscriber);
                    ctrl.cellno = '';
                    $('#wdcModal').modal('hide');
                    ctrl.loadunSubscribers(1,'');
                } else {
                    notifyError(response.data.msg,'Warning','danger');
                }
            }),function (error) {
                ctrl.loader = false;
                console.info("[App][zd_doSubscribe][Error][Response] : " + JSON.stringify(error));
            });
        }
        else if(ctrl.selectedstate==='kad'){
            url    = '../service/sr_kad_addSubscriber.php?cellno=' + ctrl.cellno;
            ctrl.loader = true;
            this.subscribers = ctrl.subscribers;
            this.selectedstate = ctrl.selectedstate;
            $http.get(url).then(angular.bind(this,function (response) {
                console.info("[App][kad_doSubscribe][success][Response] : " + JSON.stringify(response));
                ctrl.loader = false;
                if (response.data.success == 100) {

                    notifyError(response.data.msg,'Success','success');
                    //if(response.data.issub != "Y" && response.data.subscriber.state == this.selectedstate )
                    //  this.subscribers.push(response.data.subscriber);
                    ctrl.cellno = '';
                    $('#wdcModal').modal('hide');
                    ctrl.loadunSubscribers(1,'');
                } else {
                    notifyError(response.data.msg,'Warning','danger');
                }
            }),function (error) {
                ctrl.loader = false;
                console.info("[App][kad_doSubscribe][Error][Response] : " + JSON.stringify(error));
            });
        }

        else if(ctrl.selectedstate==='kt'){
            url    = '../service/sr_kt_addSubscriber.php?cellno=' + ctrl.cellno;
            ctrl.loader = true;
            this.subscribers = ctrl.subscribers;
            this.selectedstate = ctrl.selectedstate;
            $http.get(url).then(angular.bind(this,function (response) {
                console.info("[App][kt_doSubscribe][success][Response] : " + JSON.stringify(response));
                ctrl.loader = false;
                if (response.data.success == 100) {

                    notifyError(response.data.msg,'Success','success');
                    //if(response.data.issub != "Y" && response.data.subscriber.state == this.selectedstate )
                    //  this.subscribers.push(response.data.subscriber);
                    ctrl.cellno = '';
                    $('#wdcModal').modal('hide');
                    ctrl.loadunSubscribers(1,'');
                } else {
                    notifyError(response.data.msg,'Warning','danger');
                }
            }),function (error) {
                ctrl.loader = false;
                console.info("[App][kt_doSubscribe][Error][Response] : " + JSON.stringify(error));
            });
        }
        else{
            url    = '../service/sr_addSubscriber.php?cellno=' + ctrl.cellno;
            ctrl.loader = true;
            this.subscribers = ctrl.subscribers;
            this.selectedstate = ctrl.selectedstate;
            $http.get(url).then(angular.bind(this,function (response) {
                console.info("[App][doSubscribe][success][Response] : " + JSON.stringify(response));
		 ctrl.loader = false;
                if (response.data.success == 100) {
                    notifyError(response.data.msg,'Success','success');
                   // if(response.data.issub != "Y" && response.data.subscriber.state == this.selectedstate )
                       // this.subscribers.push(response.data.subscriber);
                    ctrl.searchCellno = '';
		    $('#myModal').modal('hide');
                    ctrl.loadunSubscribers(1,'');
                } else {
                    notifyError(response.data.msg,'Warning','danger');
                }
            }),function (error) {
                ctrl.loader = false;
                console.info("[App][doSubscribe][Error][Response] : " + JSON.stringify(error));
            });

        }
    }
    ctrl.exportExcel = function (cellno,val) {
        var s_all=val;
        var is_dt = 0;
        if (ctrl.dt_range != "" && ctrl.paramType == "date") {
            is_dt = 1;
            var dtrnge = ctrl.dt_range;
            var st = dtrnge.substr(0, 10);
            var end = dtrnge.substr(13, 22);
        }else if(ctrl.searchCellno != "" && ctrl.paramType == "cellno" &&s_all==""){
        }else if(ctrl.searchCellno != "" && ctrl.paramType == "cellno" && s_all=="searchAll"){
            cellno = ctrl.searchCellno;
        }

        var state = ctrl.selectedstate;
        if(state=='wdc'){
            console.log('../UnSubServices/export_excle_unsub_wdc.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt);

            window.location = '../UnSubServices/export_excle_unsub_wdc.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt;

        }else if(state=='kam'){
            console.log('../UnSubServices/export_excle_unsub_kam.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt);

            window.location = '../UnSubServices/export_excle_unsub_kam.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt;

        } else if(state==='kb'){
            console.log('../UnSubServices/export_excle_unsub_kb.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt);

            window.location = '../UnSubServices/export_excle_unsub_kb.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt;

        }else if(state==='kk'){
            console.log('../UnSubServices/export_excle_unsub_kk.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt);

            window.location = '../UnSubServices/export_excle_unsub_kk.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt;
        } else if(state==='kj'){
            console.log('../UnSubServices/export_excle_unsub_kj.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt);

            window.location = '../UnSubServices/export_excle_unsub_kj.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt;
        } else if(state==='rm'){
            console.log('../UnSubServices/export_excle_unsub_rm.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt);
            window.location = '../UnSubServices/export_excle_unsub_rm.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt;

        }
        else if(state==='kn'){
            console.log('../UnSubServices/export_excle_unsub_kn.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt);
            window.location = '../UnSubServices/export_excle_unsub_kn.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt;

        }
        else if(state==='zd'){
            console.log('../UnSubServices/export_excle_unsub_zd.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt);
            window.location = '../UnSubServices/export_excle_unsub_zd.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt;

        }
        else if(state==='kad'){
            console.log('../UnSubServices/export_excle_unsub_kad.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt);
            window.location = '../UnSubServices/export_excle_unsub_kad.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt;

        }
        else if(state==='kt'){
            console.log('../UnSubServices/export_excel_unsub_kt.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt);
            window.location = '../UnSubServices/export_excel_unsub_kt.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt;

        }

        else {
            console.log('../UnSubServices/export_excle_unsub.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt);

            window.location = '../UnSubServices/export_excle_unsub.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt;
        }

    }
    function notifyError(msg,title,type)
    {
        var zIndex = 1031;
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
