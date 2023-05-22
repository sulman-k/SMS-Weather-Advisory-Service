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
app.controller('newController',function($http,$scope,$location, $timeout){

    var ctrl = this;
    ctrl.loader = false;
    ctrl.itemsPerPage  = 10;
    ctrl.currentPage = 1;
    ctrl.selectedstate = 'kz';
    ctrl.searchCellno = '';
    ctrl.dt_range = '';
    ctrl.paramType = "";
    ctrl.allstatesData = {};
    ctrl.star_class = 'star_red';
    ctrl.prevstate = "";
    ctrl.sub_profile_onloadtime = {};
    ctrl.modalOpen = false;
    ctrl.subscribers=[];
    ctrl.show=false;
    ctrl.serviceId='';
    ctrl.amount='';
    ctrl.sms_details=[];
    ctrl.total_sms='';
    ctrl.edit_msg='';
    ctrl.sms_cellno='';
    ctrl.masking_data=[];
    ctrl.sms_id='';
    ctrl.page_num='';
    ctrl.dateParam=false;
    ctrl.msisdn='';
    ctrl.active_services=[];
    ctrl.unsubModal=false;
    ctrl.dt_model='';
    ctrl.unsubCellno='';
    ctrl.first=0;
    ctrl.second=0;
    ctrl.total_charged='';
    ctrl.setTab = function(newTab){
        resetValuesOnTabChange();
        ctrl.selectedstate = newTab;
        ctrl.loadSubscribers('1','');

    };
/*    $scope.$on('loadSubscribers', function (event, data) {
        resetValuesOnTabChange();
        ctrl.loadSubscribers(1,'');
    });*/
    ctrl.isSet = function(tabString){
        return ctrl.selectedstate === tabString;
    };

    ctrl.searchSubscriberByCellNo = function(){
        if (ctrl.searchCellno.length < 6) {
            var msg = "Search cellno should contain at least 6 Characters"
            notifyError(msg,'Warning','danger');

        } else if(ctrl.searchCellno.length > 11 ){
            var msg = "Cell number is not valid"
            notifyError(msg,'Warning','danger');
        }else {
            ctrl.paramType = 'cellno';
            ctrl.loadSubscribers('1',ctrl.searchCellno);
        }
    };
    ctrl.searchSubscriberByDate = function(){
        if (ctrl.dt_range === "") {

            var msg = "Date range is not defined"
            notifyError(msg,'Warning','danger');

        } else {
            ctrl.dateParam=true;
            ctrl.paramType = 'date';
            ctrl.loadSubscribers('1','date');
        }
    };
    ctrl.clearDate=function () {
        ctrl.dt_range="";
        ctrl.loadSubscribers('1','');
        ctrl.dateParam=false;
    };
    ctrl.loadSubscribers = function (offset,param) {

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
        if(state=='kaw'){
            ctrl.show=false;
            url        = '../service/sr_ka_loadSubscribers.php?offset=' + offset + '&state=' + state + '&param=' + param + '&st=' + st + '&end=' + end;

        } else if(state=='wdc'){

            ctrl.show=false;
            url        = '../service/sr_wdc_loadSubscriber.php?offset=' + offset + '&state=' + state + '&param=' + param + '&st=' + st + '&end=' + end;

        } else if(state=='kam')

        {
            ctrl.show=false;
            url       ='../service/sr_kam_loadSubscriber.php?offset=' + offset + '&state=' + state + '&param=' + param + '&st=' + st + '&end=' + end;

        }else if(state=='kb'){
            this.serviceId='';
            ctrl.show=true;
            url       ='../service/sr_kb_loadSubscribers.php?offset=' + offset + '&state=' + state + '&param=' + param + '&st=' + st + '&end=' + end;

        }else if(state=='kk'){
            ctrl.show=false;

            url       ='../service/sr_kk_loadSubscribers.php?offset=' + offset + '&state=' + state + '&param=' + param + '&st=' + st + '&end=' + end;

        } else if(state =='kj'){
            ctrl.show=true;
            this.serviceId='';

            url       ='../service/sr_kj_loadSubscribers.php?offset=' + offset + '&state=' + state + '&param=' + param + '&st=' + st + '&end=' + end;

        } else if( state=='rm'){
            ctrl.show=false;
            url       ='../service/sr_rm_loadSubscribers.php?offset=' + offset + '&state=' + state + '&param=' + param + '&st=' + st + '&end=' + end;

        }
         else if( state=='kn'){
            ctrl.show=false;
            url       ='../service/sr_kn_loadSubscribers.php?offset=' + offset + '&state=' + state + '&param=' + param + '&st=' + st + '&end=' + end;

        }else if( state=='zd'){
             ctrl.show=false;
            url       ='../service/sr_zd_loadSubscribers.php?offset=' + offset + '&state=' + state + '&param=' + param + '&st=' + st + '&end=' + end;

        }
        else if( state=='kad'){
            ctrl.show=true;
            this.serviceId='';
            url       ='../service/sr_kad_loadSubscribers.php?offset=' + offset + '&state=' + state + '&param=' + param + '&st=' + st + '&end=' + end;

        }
        else if( state=='kt'){
            ctrl.show=true;
            this.serviceId='';
            url       ='../service/sr_kt_loadSubscribers.php?offset=' + offset + '&state=' + state + '&param=' + param + '&st=' + st + '&end=' + end;

        }

        else{
            ctrl.show=false;

            url        = '../service/sr_loadSubscribers.php?offset=' + offset + '&state=' + state + '&param=' + param + '&st=' + st + '&end=' + end;
        }

            console.log(url);
            ctrl.loader = true;
            $http.get(url).then(function (response) {
                //console.info("[App][loadSubscribers][success][Response] : " + JSON.stringify(response));
                ctrl.loader = false;
                if (response.data.success > 0) {
                    ctrl.subscribers = response.data.subscribers;
                    ctrl.total_subscriber = response.data.total_pages;
                    ctrl.page_num=response.data.page_num;

                } else {
                    resetValues();
                    notifyError(response.data.msg,'Warning','danger');
                }


            },function (error) {
                console.info("[App][loadMenuBox][Error][Response] : " + JSON.stringify(error));
            });
    }

    resetValues = function(){
        ctrl.subscribers = [];
        ctrl.total_subscriber = 0;
        ctrl.helpRequests = {};
    }
    resetValuesOnTabChange = function(){
        ctrl.currentPage = 1;
        ctrl.searchCellno = '';
        ctrl.dt_range = '';
    }
    ctrl.loadSubProfile = function ( user) {

        var state = ctrl.selectedstate;
        ctrl.user = user;
        var cellno = user.cellno;
        var pro=user.state;
        var url = '';
        if(state == 'kaw'){
            state = 'missouri';
            url    = '../service/sr_ka_getSubProfileNew.php?state=' + state + '&cellno=' + cellno;

            $http.get(url).then(function (response) {
                console.info("[App][loadSubscribers][success][Response] : " + JSON.stringify(response));

                if(response.data.success > 0){
                    ctrl.amount='';
                    ctrl.sub_profile = response.data.sub_profile[0];
                    $('#kaModal').modal('show');
                }


            },function (error) {
                console.info("[App][loadSubProfile][Error][Response] : " + JSON.stringify(error));
            });
        }else if(state=='wdc' ) {
            url = '../service/sr_wdc_getSubProfile.php?state=' + state + '&cellno=' + cellno;
            $http.get(url).then(function (response) {

                console.info("[App][wdc_loadSubscribers][success][Response] : " + JSON.stringify(response));
                if (response.data.success > 0) {
                    ctrl.wdc_profile = response.data.wdc_profile[0];
                    ctrl.amount='';
                    $('#wdcModal').modal('show');
                }
            },function (error) {
                console.info("[App][loadSubProfile][Error][Response] : " + JSON.stringify(error));

            });


        }else if(state=='kam'){
            url = '../service/sr_kam_getSubProfile.php?state=' + state + '&cellno=' + cellno;
            $http.get(url).then(function (response) {

                console.info("[App][km_loadSubscribers][success][Response] : " + JSON.stringify(response));
                if (response.data.success > 0) {
                    ctrl.wdc_profile = response.data.wdc_profile[0];
                    ctrl.amount='';
                    $('#wdcModal').modal('show');
                }
            },function (error) {
                console.info("[App][loadSubProfile][Error][Response] : " + JSON.stringify(error));

            });
        }else if(state == 'kb'){
            url = '../service/sr_kb_getSubProfile.php?state=' + state + '&cellno=' + cellno;
            $http.get(url).then(function (response) {

                console.info("[App][kb_loadSubscribers][success][Response] : " + JSON.stringify(response));
                if (response.data.success > 0) {
                    ctrl.wdc_profile = response.data.wdc_profile[0];
                    ctrl.amount=response.data.amount;
                     console.log(ctrl.amount);
                    $('#wdcModal').modal('show');
                }
            },function (error) {
                console.info("[App][loadSubProfile][Error][Response] : " + JSON.stringify(error));

            });
        } else if(state=='kk'){
            url = '../service/sr_kk_getSubProfile.php?state=' + state + '&cellno=' + cellno;
            $http.get(url).then(function (response) {

                console.info("[App][kk_loadSubscribers][success][Response] : " + JSON.stringify(response));
                if (response.data.success > 0) {
                    ctrl.wdc_profile = response.data.wdc_profile[0];
                    ctrl.amount='';
                    $('#wdcModal').modal('show');
                }
            },function (error) {
                console.info("[App][loadSubProfile][Error][Response] : " + JSON.stringify(error));

            });
        } else if(state=='kj'){
            url = '../service/sr_kj_getSubProfile.php?state=' + state + '&cellno=' + cellno;
            $http.get(url).then(function (response) {

                console.info("[App][kj_loadSubscribers][success][Response] : " + JSON.stringify(response));
                if (response.data.success > 0) {
                    ctrl.wdc_profile = response.data.wdc_profile[0];
                    ctrl.amount='';
                    $('#wdcModal').modal('show');
                }
            },function (error) {
                console.info("[App][loadSubProfile][Error][Response] : " + JSON.stringify(error));

            });
        }else if(state=='rm'){
            url = '../service/sr_rm_getSubProfile.php?state=' + state + '&cellno=' + cellno;
            $http.get(url).then(function (response) {

                console.info("[App][rm_loadSubscribers][success][Response] : " + JSON.stringify(response));
                if (response.data.success > 0) {
                    ctrl.wdc_profile = response.data.rm_profile[0];
                    ctrl.amount='';
                    $('#wdcModal').modal('show');
                }
            },function (error) {
                console.info("[App][loadSubProfile][Error][Response] : " + JSON.stringify(error));

            });
        }else if(state=='kn'){
            url = '../service/sr_kn_getSubProfile.php?state=' + state + '&cellno=' + cellno;
            $http.get(url).then(function (response) {

                console.info("[App][kn_loadSubscribers][success][Response] : " + JSON.stringify(response));
                if (response.data.success > 0) {
                    ctrl.wdc_profile = response.data.kn_profile[0];
                    ctrl.amount='';
                    $('#wdcModal').modal('show');
                }
            },function (error) {
                console.info("[App][loadSubProfile][Error][Response] : " + JSON.stringify(error));

            });
        }else if(state=='zd'){
            url = '../service/sr_zd_getSubProfile.php?state=' + state + '&cellno=' + cellno;
            $http.get(url).then(function (response) {

                console.info("[App][zd_loadSubscribers][success][Response] : " + JSON.stringify(response));
                if (response.data.success > 0) {
                    ctrl.wdc_profile = response.data.zd_profile[0];
                    ctrl.amount='';
                    $('#wdcModal').modal('show');
                }
            },function (error) {
                console.info("[App][loadSubProfile][Error][Response] : " + JSON.stringify(error));

            });
        }
        else if(state=='kad'){
            url = '../service/sr_kad_getSubProfile.php?state=' + state + '&cellno=' + cellno;
            $http.get(url).then(function (response) {

                console.info("[App][kad_loadSubscribers][success][Response] : " + JSON.stringify(response));
                if (response.data.success > 0) {
                    ctrl.wdc_profile = response.data.kd_profile[0];
                    ctrl.amount=response.data.amount;
                    $('#wdcModal').modal('show');
                }
            },function (error) {
                console.info("[App][loadSubProfile][Error][Response] : " + JSON.stringify(error));

            });
        }
        else if(state=='kt'){
            url = '../service/sr_kt_getSubProfile.php?state=' + state + '&cellno=' + cellno;
            $http.get(url).then(function (response) {

                console.info("[App][kt_loadSubscribers][success][Response] : " + JSON.stringify(response));
                if (response.data.success > 0) {
                    ctrl.wdc_profile = response.data.kt_profile[0];
                    ctrl.amount=response.data.amount;
                    $('#wdcModal').modal('show');
                }
            },function (error) {
                console.info("[App][loadSubProfile][Error][Response] : " + JSON.stringify(error));

            });
        }
        else
        {   //url    = '../service/sr_getSubProfileNew.php?state=' + state + '&cellno=' + cellno;
            url    = '../service/sr_getSubProfileNew.php?state=' + pro + '&cellno=' + cellno;
            $http.get(url).then(function (response) {
                console.info("[App][loadSubscribers][success][Response] : " + JSON.stringify(response));

                if(response.data.success > 0){
                    ctrl.sub_profile = response.data.sub_profile[0];
                    //ctrl.sub_profile.land_unit = 'Acre';
                    ctrl.sub_profile_onloadtime = angular.copy(ctrl.sub_profile);
                    ctrl.prevstate = ctrl.sub_profile.state;

                    ctrl.allstatesData = response.data.statesData;
                    //ctrl.stateData = response.data.statesData[ctrl.sub_profile.state];
                    //ctrl.states = response.data.states;
                    ctrl.sub_names = response.data.names;
                    ctrl.filterLocations(ctrl.sub_profile.state);

                    ctrl.filterTehsils(ctrl.sub_profile.district);
                    ctrl.amount='';
                    $('#myModal').modal('show');
                }


            },function (error) {
                console.info("[App][loadSubProfile][Error][Response] : " + JSON.stringify(error));
            });

        }

    }
    ctrl.filterLocations = function(state){
        ctrl.stateData = ctrl.allstatesData[state];

        if(ctrl.sub_profile_onloadtime.state == state){
            ctrl.sub_profile = angular.copy(ctrl.sub_profile_onloadtime);
        }
        if(ctrl.stateData.has_default_srvc > 0){
            ctrl.star_class = 'star_red' ;
        }else{
            ctrl.star_class = 'star_white';
            ctrl.stateData.services = [];
        }
    }
    ctrl.filterTehsils = function(district){

        if(ctrl.stateData.districts[district] != undefined){
            ctrl.tehsils = ctrl.stateData.districts[district].tehsils;
            //ctrl.sub_profile.tehsil = "";
            console.log("Tehsils - " + ctrl.tehsils);
        }else{
            console.log("Not valid district - "+ district) ;
            ctrl.tehsils = [];
        }


    }
    ctrl.saveSubProfile = function(){

        console.log("test -"  + ctrl.sub_profile);
        if (ctrl.sub_profile.state != 'gb' &&( ctrl.sub_profile.srvc_id == null || ctrl.sub_profile.srvc_id == '')) {
            notifyError('Please select crop !','Warning','danger');
            return;
        }
        if (!ctrl.stateData.langs.includes(ctrl.sub_profile.lang)) {
            notifyError('Please select Language !','Warning','danger');
            return;
        }
        /*if(!ctrl.stateData.srvc_id.includes(ctrl.sub_profile.srvc_id)){
            notifyError('Please select crop','Warning','danger');
            return;
        }*/

        var data = $.param({
            "cellno" :ctrl.sub_profile.cellno,
            "sub_name" : ctrl.sub_profile.sub_name,
            "occupation" :ctrl.sub_profile.occupation,
            "lang" : ctrl.sub_profile.lang,
            "state" : ctrl.sub_profile.state,
            "district" : ctrl.sub_profile.district,
            "village"  : ctrl.sub_profile.village,
            "srvc_id"  : ctrl.sub_profile.srvc_id,
            "land"  : ctrl.sub_profile.land_size,
            "land_unit"  : ctrl.sub_profile.land_unit,
            "alerts_type"  : ctrl.sub_profile.alert_type,
            "channel"  : ctrl.sub_profile.bc_mode,
            "comment"  : ctrl.sub_profile.comment,
            "tehsil"   : ctrl.sub_profile.tehsil,
            "has_selected_loc" : (ctrl.sub_profile.state != ctrl.sub_profile_onloadtime.state || ctrl.sub_profile.district != ctrl.sub_profile_onloadtime.district || ctrl.sub_profile.tehsil != ctrl.sub_profile_onloadtime.tehsil)?100:-100,
            "oldData" : JSON.stringify(ctrl.sub_profile_onloadtime)
        });
        var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        ctrl.loader = true;
       $http.post('../service/sr_updateSubProfile.php', data, config).then(angular.bind(this,function(response){
               if (response.data.success > 0) {
                  /* if(this.prevstate != this.sub_profile.state){
                       var index = this.subscribers.indexOf(this.user);
                       this.subscribers.splice(index,1);
                   }*/
                   setTimeout(function () {
                       ctrl.loadSubscribers(ctrl.page_num,"");

                   },3000);
                   notifyError(response.data.msg,'Success','success');
               } else {
                   notifyError(response.data.msg,'Warning','danger');
               }
               $('#deleteModal' ).modal('hide');
               $('#myModal').modal('hide');
               ctrl.loader = false;
           }),function(error){
               ctrl.loader = false;
               console.info("[App][doSubscribe][Error][Response] : " + JSON.stringify(error));
           });
    }
    ctrl.exportExcel = function (cellno,val) {
        var s_all=val;
        var is_dt = 0;
        if (ctrl.dt_range != "" && ctrl.paramType == "date") {
            is_dt = 1;
            var dtrnge = ctrl.dt_range;
            var st = dtrnge.substr(0, 10);
            var end = dtrnge.substr(13, 22);
        }else if(ctrl.searchCellno != "" && ctrl.paramType == "cellno"&&s_all ==""){

        }else if(ctrl.searchCellno != "" && ctrl.paramType == "cellno"&&s_all=="searchAll")
        {
            cellno = ctrl.searchCellno;
        }
        var state = ctrl.selectedstate;
if(state=='wdc'){
    console.log('../service/export_excle_wdc.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt);

    window.location = '../service/export_excle_wdc.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt;

}else if(state=='kam'){
    console.log('../service/export_excle_kam.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt);

    window.location = '../service/export_excle_kam.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt;
}
else if(state=='kb'){
    console.log('../service/export_excle_kb.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt);
    window.location = '../service/export_excle_kb.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt;

}else if(state=='kk'){
    console.log('../service/export_excle_kk.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt);
    window.location = '../service/export_excle_kk.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt;
} else if(state=='kj'){
    console.log('../service/export_excle_kj.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt);
    window.location = '../service/export_excle_kj.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt;

} else if(state=='rm'){
    console.log('../service/export_excle_rm.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt);
    window.location = '../service/export_excle_rm.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt;

}
else if(state=='kn'){
    console.log('../service/export_excle_kn.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt);
    window.location = '../service/export_excle_kn.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt;

}
else if(state=='zd'){
    console.log('../service/export_excle_zd.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt);
    window.location = '../service/export_excle_zd.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt;

}
else if(state=='kad'){
    console.log('../service/export_excle_kad.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt);
    window.location = '../service/export_excle_kad.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt;

}
else if(state=='kt'){
    console.log('../service/export_excel_kt.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt);
    window.location = '../service/export_excel_kt.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt;

}
else {
    //console.log('../service/export_excel.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt);

    console.log('../service/export_excel.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&is_dt=' + is_dt);

    window.location = '../service/export_excel.php?st=' + st + '&end=' + end + '&cellno=' + cellno +'&is_dt=' + is_dt;

    //window.location = '../service/export_excel.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt;
}

    };

    ctrl.doSubscribe = function () {
        var url = '';
        if(ctrl.selectedstate == 'kaw'){
            url    = '../service/sr_ka_addSubscriber.php?cellno=' + ctrl.searchCellno;
            ctrl.loader = true;
            $http.get(url).then(angular.bind(this,function (response) {
                console.info("[App][doSubscribe][success][Response] : " + JSON.stringify(response));
                ctrl.loader = false;
                if (response.data.success == 100) {
                    notifyError(response.data.msg,'Success','success');
                    //if(response.data.issub != "Y" && response.data.subscriber.state == this.selectedstate )
                    //    this.subscribers.push(response.data.subscriber);
                    ctrl.searchCellno = '';
                    ctrl.loadSubscribers(1,'');
                } else {
                    notifyError(response.data.msg,'Warning','danger');
                }

            }),function (error) {
                ctrl.loader = false;
                console.info("[App][doSubscribe][Error][Response] : " + JSON.stringify(error));
            });


        }else if(ctrl.selectedstate=='wdc'){
            url    = '../service/sr_wdc_addSubscriber.php?cellno=' + ctrl.searchCellno;
            ctrl.loader = true;
            this.subscribers = ctrl.subscribers;
            this.selectedstate = ctrl.selectedstate;
            $http.get(url).then(angular.bind(this,function (response) {
                console.info("[App][wdc_doSubscribe][success][Response] : " + JSON.stringify(response));
 		    ctrl.loader = false;

                if (response.data.success == 100) {
                    notifyError(response.data.msg,'Success','success');
                    ctrl.searchCellno = '';
                    ctrl.loadSubscribers(1,'');

                } else {
                    notifyError(response.data.msg,'Warning','danger');
                }
            }),function (error) {
                ctrl.loader = false;
                console.info("[App][wdc_doSubscribe][Error][Response] : " + JSON.stringify(error));
            });

        } else if(ctrl.selectedstate=='kam'){

            url    = '../service/sr_kam_addSubscriber.php?cellno=' + ctrl.searchCellno;
            ctrl.loader = true;
            this.subscribers = ctrl.subscribers;
            this.selectedstate = ctrl.selectedstate;
            $http.get(url).then(angular.bind(this,function (response) {
                console.info("[App][kam_doSubscribe][success][Response] : " + JSON.stringify(response));
                ctrl.loader = false;

                if (response.data.success == 100) {
                    notifyError(response.data.msg,'Success','success');
                    ctrl.searchCellno = '';
                    ctrl.loadSubscribers(1,'');

                } else {
                    notifyError(response.data.msg,'Warning','danger');
                }
            }),function (error) {
                ctrl.loader = false;
                console.info("[App][kam_doSubscribe][Error][Response] : " + JSON.stringify(error));
            });
        }else if(ctrl.selectedstate=='kb'){
            url    = '../service/sr_kb_addSubscriber.php?cellno=' + ctrl.searchCellno+'&serviceId='+ctrl.serviceId;
            ctrl.loader = true;
            this.subscribers = ctrl.subscribers;
            this.selectedstate = ctrl.selectedstate;
            $http.get(url).then(angular.bind(this,function (response) {
                console.info("[App][kb_doSubscribe][success][Response] : " + JSON.stringify(response));
                ctrl.loader = false;

                if (response.data.success == 100) {
                    notifyError(response.data.msg,'Success','success');
                    ctrl.searchCellno = '';
                    ctrl.loadSubscribers(1,'');

                } else {
                    notifyError(response.data.msg,'Warning','danger');
                }
            }),function (error) {
                ctrl.loader = false;
                console.info("[App][kb_doSubscribe][Error][Response] : " + JSON.stringify(error));
            });
        } else if(ctrl.selectedstate==='kk'){
            url    = '../service/sr_kk_addSubscriber.php?cellno=' + ctrl.searchCellno;
            ctrl.loader = true;
            this.subscribers = ctrl.subscribers;
            this.selectedstate = ctrl.selectedstate;
            $http.get(url).then(angular.bind(this,function (response) {
                console.info("[App][kk_doSubscribe][success][Response] : " + JSON.stringify(response));
                ctrl.loader = false;

                if (response.data.success == 100) {
                    notifyError(response.data.msg,'Success','success');
                    ctrl.searchCellno = '';
                    ctrl.loadSubscribers(1,'');

                } else {
                    notifyError(response.data.msg,'Warning','danger');
                }
            }),function (error) {
                ctrl.loader = false;
                console.info("[App][kk_doSubscribe][Error][Response] : " + JSON.stringify(error));
            });
        } else if(ctrl.selectedstate==='kj'){
            url    = '../service/sr_kj_addSubscriber.php?cellno=' + ctrl.searchCellno+'&serviceId='+ctrl.serviceId;
            ctrl.loader = true;
            this.subscribers = ctrl.subscribers;
            this.selectedstate = ctrl.selectedstate;
            $http.get(url).then(angular.bind(this,function (response) {
                console.info("[App][kj_doSubscribe][success][Response] : " + JSON.stringify(response));
                ctrl.loader = false;

                if (response.data.success == 100) {
                    notifyError(response.data.msg,'Success','success');
                    ctrl.searchCellno = '';
                    ctrl.loadSubscribers(1,'');

                } else {
                    notifyError(response.data.msg,'Warning','danger');
                }
            }),function (error) {
                ctrl.loader = false;
                console.info("[App][kj_doSubscribe][Error][Response] : " + JSON.stringify(error));
            });
        } else if(ctrl.selectedstate==='rm'){
            url    = '../service/sr_rm_addSubscriber.php?cellno=' + ctrl.searchCellno;
            ctrl.loader = true;
            this.subscribers = ctrl.subscribers;
            this.selectedstate = ctrl.selectedstate;
            $http.get(url).then(angular.bind(this,function (response) {
                console.info("[App][rm_doSubscribe][success][Response] : " + JSON.stringify(response));
                ctrl.loader = false;

                if (response.data.success == 100) {
                    ctrl.loader = false;

                    notifyError(response.data.msg,'Success','success');
                    ctrl.searchCellno = '';
                    ctrl.loadSubscribers(1,'');

                } else {
                    notifyError(response.data.msg,'Warning','danger');
                }
            }),function (error) {
                ctrl.loader = false;
                console.info("[App][rm_doSubscribe][Error][Response] : " + JSON.stringify(error));
            });
        }
        else if(ctrl.selectedstate==='kn'){
            url    = '../service/sr_kn_addSubscriber.php?cellno=' + ctrl.searchCellno;
            ctrl.loader = true;
            this.subscribers = ctrl.subscribers;
            this.selectedstate = ctrl.selectedstate;
            $http.get(url).then(angular.bind(this,function (response) {
                console.info("[App][kn_doSubscribe][success][Response] : " + JSON.stringify(response));
                ctrl.loader = false;

                if (response.data.success == 100) {
                    ctrl.loader = false;

                    notifyError(response.data.msg,'Success','success');
                    ctrl.searchCellno = '';
                    ctrl.loadSubscribers(1,'');

                } else {
                    notifyError(response.data.msg,'Warning','danger');
                }
            }),function (error) {
                ctrl.loader = false;
                console.info("[App][kn_doSubscribe][Error][Response] : " + JSON.stringify(error));
            });
        }
        else if(ctrl.selectedstate==='zd'){
            url    = '../service/sr_zd_addSubscriber.php?cellno=' + ctrl.searchCellno;
            ctrl.loader = true;
            this.subscribers = ctrl.subscribers;
            this.selectedstate = ctrl.selectedstate;
            $http.get(url).then(angular.bind(this,function (response) {
                console.info("[App][zd_doSubscribe][success][Response] : " + JSON.stringify(response));
                ctrl.loader = false;

                if (response.data.success == 100) {
                    ctrl.loader = false;

                    notifyError(response.data.msg,'Success','success');
                    ctrl.searchCellno = '';
                    ctrl.loadSubscribers(1,'');

                } else {
                    notifyError(response.data.msg,'Warning','danger');
                }
            }),function (error) {
                ctrl.loader = false;
                console.info("[App][zd_doSubscribe][Error][Response] : " + JSON.stringify(error));
            });
        }
        else if(ctrl.selectedstate==='kad'){
            url    = '../service/sr_kad_addSubscriber.php?cellno=' + ctrl.searchCellno+'&serviceId='+ctrl.serviceId;
            ctrl.loader = true;
            this.subscribers = ctrl.subscribers;
            this.selectedstate = ctrl.selectedstate;
            $http.get(url).then(angular.bind(this,function (response) {
                console.info("[App][kad_doSubscribe][success][Response] : " + JSON.stringify(response));
                ctrl.loader = false;

                if (response.data.success == 100) {
                    ctrl.loader = false;

                    notifyError(response.data.msg,'Success','success');
                    ctrl.searchCellno = '';
                    ctrl.loadSubscribers(1,'');

                } else {
                    notifyError(response.data.msg,'Warning','danger');
                }
            }),function (error) {
                ctrl.loader = false;
                console.info("[App][kad_doSubscribe][Error][Response] : " + JSON.stringify(error));
            });
        }
        else if(ctrl.selectedstate==='kt'){
            url    = '../service/sr_kt_addSubscriber.php?cellno=' + ctrl.searchCellno+'&serviceId='+ctrl.serviceId;
            ctrl.loader = true;
            this.subscribers = ctrl.subscribers;
            this.selectedstate = ctrl.selectedstate;
            $http.get(url).then(angular.bind(this,function (response) {
                console.info("[App][kt_doSubscribe][success][Response] : " + JSON.stringify(response));
                ctrl.loader = false;

                if (response.data.success == 100) {
                    ctrl.loader = false;

                    notifyError(response.data.msg,'Success','success');
                    ctrl.searchCellno = '';
                    ctrl.loadSubscribers(1,'');

                } else {
                    notifyError(response.data.msg,'Warning','danger');
                }
            }),function (error) {
                ctrl.loader = false;
                console.info("[App][kt_doSubscribe][Error][Response] : " + JSON.stringify(error));
            });
        }
        else{
            url    = '../service/sr_addSubscriber.php?cellno=' + ctrl.searchCellno;
            ctrl.loader = true;
            this.subscribers = ctrl.subscribers;
            this.selectedstate = ctrl.selectedstate;
            $http.get(url).then(angular.bind(this,function (response) {
                console.info("[App][doSubscribe][success][Response] : " + JSON.stringify(response));
                ctrl.loader = false;
                if (response.data.success == 100) {
                    notifyError(response.data.msg,'Success','success');
                    /*if(response.data.issub != "Y" && response.data.subscriber.state == this.selectedstate )
                        this.subscribers.push(response.data.subscriber);*/
                    ctrl.searchCellno = '';
                    ctrl.loadSubscribers(1,'');

                } else {
                    notifyError(response.data.msg,'Warning','danger');
                }

            }),function (error) {
                ctrl.loader = false;
                console.info("[App][doSubscribe][Error][Response] : " + JSON.stringify(error));
            });

        }
    }
    ctrl.doUnSubscribe = function (cellno) {

        var url = '';
        if(ctrl.selectedstate == 'kaw'){

            url          = '../service/sr_ka_doUnSubscribe.php?cellno=' + cellno;
            ctrl.loader      = true;
            this.subscribers = ctrl.subscribers;
            this.cellno      = cellno;
            $http.get(url).then(angular.bind(this, function (response) {

                if (response.data.success == 100) {
                    $('#deleteModal').modal('hide');
                    $('#kaModal').modal('hide');
                    $("#unsubModal").modal('hide');

                    notifyError(response.data.msg, 'Success', 'success');
                    ctrl.loadSubscribers(1,'');
                    ctrl.getActiveService(ctrl.msisdn);
                } else {
                    $('#deleteModal').modal('hide');
                    $("#unsubModal").modal('hide');

                    notifyError(response.data.msg, 'Warning', 'danger');
                }
                ctrl.loader = false;
            }), function (error) {
                ctrl.loader = false;
                console.info("[App][doUnSubscribe][Error][Response] : " + JSON.stringify(error));
            });


        }else if( ctrl.selectedstate=='wdc'){

            url          = '../service/sr_wdc_doUnSubscribe.php?cellno=' + cellno;
            ctrl.loader      = true;
            this.subscribers = ctrl.subscribers;
            this.cellno      = cellno;
            $http.get(url).then(angular.bind(this, function (response) {

                if (response.data.success == 100) {
                    $('#wdc_deleteModal').modal('hide');
                    $('#wdcModal').modal('hide');
                    $("#unsubModal").modal('hide');

                    notifyError(response.data.msg, 'Success', 'success');
                    ctrl.loadSubscribers(1,'');
                    ctrl.getActiveService(ctrl.msisdn);

                } else {
                    $('#deleteModal').modal('hide');
                    $("#unsubModal").modal('hide');

                    notifyError(response.data.msg, 'Warning', 'danger');
                }
                ctrl.loader = false;
            }), function (error) {
                ctrl.loader = false;
                console.info("[App][wdc_doUnSubscribe][Error][Response] : " + JSON.stringify(error));
            });

        }else if(ctrl.selectedstate=='kam'){

            url          = '../service/sr_kam_doUnSubscriber.php?cellno=' + cellno;
            ctrl.loader      = true;
            this.subscribers = ctrl.subscribers;
            this.cellno      = cellno;
            $http.get(url).then(angular.bind(this, function (response) {

                if (response.data.success == 100) {
                    $('#wdc_deleteModal').modal('hide');
                    $('#wdcModal').modal('hide');
                    $("#unsubModal").modal('hide');

                    notifyError(response.data.msg, 'Success', 'success');
                    ctrl.loadSubscribers(1,'');
                    ctrl.getActiveService(ctrl.msisdn);

                } else {
                    $('#deleteModal').modal('hide');
                    $("#unsubModal").modal('hide');

                    notifyError(response.data.msg, 'Warning', 'danger');
                }
                ctrl.loader = false;
            }), function (error) {
                ctrl.loader = false;
                console.info("[App][kam_doUnSubscribe][Error][Response] : " + JSON.stringify(error));
            });
        }
        else if(ctrl.selectedstate=='kb'){
            url          = '../service/sr_kb_doUnSubscriber.php?cellno=' + cellno;
            ctrl.loader      = true;
            this.subscribers = ctrl.subscribers;
            this.cellno      = cellno;
            $http.get(url).then(angular.bind(this, function (response) {

                if (response.data.success == 100) {
                    $('#wdc_deleteModal').modal('hide');
                    $('#wdcModal').modal('hide');
                    $("#unsubModal").modal('hide');

                    notifyError(response.data.msg, 'Success', 'success');
                    ctrl.loadSubscribers(1,'');
                    ctrl.getActiveService(ctrl.msisdn);

                } else {
                    $('#deleteModal').modal('hide');
                    $("#unsubModal").modal('hide');

                    notifyError(response.data.msg, 'Warning', 'danger');
                }
                ctrl.loader = false;
            }), function (error) {
                ctrl.loader = false;
                console.info("[App][kb_doUnSubscribe][Error][Response] : " + JSON.stringify(error));
            });
        }else if(ctrl.selectedstate=='kk'){
            url          = '../service/sr_kk_doUnSubscriber.php?cellno=' + cellno;
            ctrl.loader      = true;
            this.subscribers = ctrl.subscribers;
            this.cellno      = cellno;
            $http.get(url).then(angular.bind(this, function (response) {

                if (response.data.success == 100) {
                    $('#wdc_deleteModal').modal('hide');
                    $('#wdcModal').modal('hide');
                    $("#unsubModal").modal('hide');

                    notifyError(response.data.msg, 'Success', 'success');
                    ctrl.loadSubscribers(1,'');
                    ctrl.getActiveService(ctrl.msisdn);

                } else {
                    $('#deleteModal').modal('hide');
                    $("#unsubModal").modal('hide');

                    notifyError(response.data.msg, 'Warning', 'danger');
                }
                ctrl.loader = false;
            }), function (error) {
                ctrl.loader = false;
                console.info("[App][kk_doUnSubscribe][Error][Response] : " + JSON.stringify(error));
            });
        }else if(ctrl.selectedstate==='kj'){
            url          = '../service/sr_kj_doUnSubscriber.php?cellno=' + cellno;
            ctrl.loader      = true;
            this.subscribers = ctrl.subscribers;
            this.cellno      = cellno;
            $http.get(url).then(angular.bind(this, function (response) {

                if (response.data.success == 100) {
                    $('#wdc_deleteModal').modal('hide');
                    $('#wdcModal').modal('hide');
                    $("#unsubModal").modal('hide');

                    notifyError(response.data.msg, 'Success', 'success');
                    ctrl.loadSubscribers(1,'');
                    ctrl.getActiveService(ctrl.msisdn);

                } else {
                    $('#deleteModal').modal('hide');
                    $("#unsubModal").modal('hide');

                    notifyError(response.data.msg, 'Warning', 'danger');
                }
                ctrl.loader = false;
            }), function (error) {
                ctrl.loader = false;
                console.info("[App][kj_doUnSubscribe][Error][Response] : " + JSON.stringify(error));
            });
        }else if(ctrl.selectedstate==='rm' ){
            url          = '../service/sr_rm_doUnSubscriber.php?cellno=' + cellno;
            ctrl.loader      = true;
            this.subscribers = ctrl.subscribers;
            this.cellno      = cellno;
            $http.get(url).then(angular.bind(this, function (response) {

                if (response.data.success == 100) {
                    $('#wdc_deleteModal').modal('hide');
                    $('#wdcModal').modal('hide');
                    $("#unsubModal").modal('hide');

                    notifyError(response.data.msg, 'Success', 'success');
                    ctrl.loadSubscribers(1,'');
                    ctrl.getActiveService(ctrl.msisdn);

                } else {
                    $('#deleteModal').modal('hide');
                    $("#unsubModal").modal('hide');

                    notifyError(response.data.msg, 'Warning', 'danger');
                }
                ctrl.loader = false;
            }), function (error) {
                ctrl.loader = false;
                console.info("[App][rm_doUnSubscribe][Error][Response] : " + JSON.stringify(error));
            });
        }else if(ctrl.selectedstate==='kn'){
            url          = '../service/sr_kn_doUnSubscriber.php?cellno=' + cellno;
            ctrl.loader      = true;
            this.subscribers = ctrl.subscribers;
            this.cellno      = cellno;
            $http.get(url).then(angular.bind(this, function (response) {

                if (response.data.success == 100) {
                    $('#wdc_deleteModal').modal('hide');
                    $('#wdcModal').modal('hide');
                    $("#unsubModal").modal('hide');

                    notifyError(response.data.msg, 'Success', 'success');
                    ctrl.loadSubscribers(1,'');
                    ctrl.getActiveService(ctrl.msisdn);

                } else {
                    $('#deleteModal').modal('hide');
                    $("#unsubModal").modal('hide');

                    notifyError(response.data.msg, 'Warning', 'danger');
                }
                ctrl.loader = false;
            }), function (error) {
                ctrl.loader = false;
                console.info("[App][kn_doUnSubscribe][Error][Response] : " + JSON.stringify(error));
            });
        }else if(ctrl.selectedstate==='zd'){
            url          = '../service/sr_zd_doUnSubscriber.php?cellno=' + cellno;
            ctrl.loader      = true;
            this.subscribers = ctrl.subscribers;
            this.cellno      = cellno;
            $http.get(url).then(angular.bind(this, function (response) {

                if (response.data.success == 100) {
                    $('#wdc_deleteModal').modal('hide');
                    $('#wdcModal').modal('hide');
                    $("#unsubModal").modal('hide');


                    notifyError(response.data.msg, 'Success', 'success');
                    ctrl.loadSubscribers(1,'');
                    ctrl.getActiveService(ctrl.msisdn);

                } else {
                    $('#deleteModal').modal('hide');
                    $("#unsubModal").modal('hide');

                    notifyError(response.data.msg, 'Warning', 'danger');
                }
                ctrl.loader = false;
            }), function (error) {
                ctrl.loader = false;
                console.info("[App][zd_doUnSubscribe][Error][Response] : " + JSON.stringify(error));
            });
        }else if(ctrl.selectedstate==='kad'){
            url          = '../service/sr_kad_doUnSubscriber.php?cellno=' + cellno;
            ctrl.loader      = true;
            this.subscribers = ctrl.subscribers;
            this.cellno      = cellno;
            $http.get(url).then(angular.bind(this, function (response) {

                if (response.data.success == 100) {
                    $('#wdc_deleteModal').modal('hide');
                    $('#wdcModal').modal('hide');
                    $("#unsubModal").modal('hide');

                    notifyError(response.data.msg, 'Success', 'success');
                    ctrl.loadSubscribers(1,'');
                    ctrl.getActiveService(ctrl.msisdn);

                } else {
                    $('#deleteModal').modal('hide');
                    $("#unsubModal").modal('hide');

                    notifyError(response.data.msg, 'Warning', 'danger');
                }
                ctrl.loader = false;
            }), function (error) {
                ctrl.loader = false;
                console.info("[App][kad_doUnSubscribe][Error][Response] : " + JSON.stringify(error));
            });
        }
        else if(ctrl.selectedstate==='kt'){
            url          = '../service/sr_kt_doUnSubscriber.php?cellno=' + cellno;
            ctrl.loader      = true;
            this.subscribers = ctrl.subscribers;
            this.cellno      = cellno;
            $http.get(url).then(angular.bind(this, function (response) {

                if (response.data.success == 100) {
                    $('#wdc_deleteModal').modal('hide');
                    $('#wdcModal').modal('hide');
                    $("#unsubModal").modal('hide');

                    notifyError(response.data.msg, 'Success', 'success');
                    ctrl.loadSubscribers(1,'');
                    ctrl.getActiveService(ctrl.msisdn);

                } else {
                    $('#deleteModal').modal('hide');
                    $("#unsubModal").modal('hide');

                    notifyError(response.data.msg, 'Warning', 'danger');
                }
                ctrl.loader = false;
            }), function (error) {
                ctrl.loader = false;
                console.info("[App][kt_doUnSubscribe][Error][Response] : " + JSON.stringify(error));
            });
        }
        else{
            url          = '../service/sr_doUnSubscribe.php?cellno=' + cellno;
            ctrl.loader      = true;
            this.subscribers = ctrl.subscribers;
            this.cellno      = cellno;
            $http.get(url).then(angular.bind(this, function (response) {

                if (response.data.success == 100) {
                    $('#deleteModal').modal('hide');
                    $('#myModal').modal('hide');
                    $("#unsubModal").modal('hide');

                    ctrl.loadSubscribers(1,'');
                    ctrl.getActiveService(ctrl.msisdn);
                    notifyError(response.data.msg,'Success','success');
                    console.log('call subscriber file');
                    //    var index = this.subscribers.findIndex(x = > x.cellno == this.cellno
                //)
                //    ;
                //    this.subscribers.splice(index, 1);
                //    notifyError(response.data.msg, 'Success', 'success');
                } else {
                    $('#deleteModal').modal('hide');
                    $("#unsubModal").modal('hide');

                    notifyError(response.data.msg, 'Warning', 'danger');
                }
                ctrl.loader = false;
            }), function (error) {
                ctrl.loader = false;
                console.info("[App][doUnSubscribe][Error][Response] : " + JSON.stringify(error));
            });
        }

    }
    ctrl.changeAlertType = function (){
        if(ctrl.sub_profile.bc_mode == 'NONE'){
            ctrl.sub_profile.alert_type = -100;
        }else{
            if(ctrl.sub_profile.alert_type == -100)
                ctrl.sub_profile.alert_type = 500;
        }
    };

    //for crop insurance

    ctrl.searchByCellNo = function(){
        if (ctrl.searchCellno.length < 6) {
            var msg = "Search cellno should contain at least 6 Characters";
            notifyError(msg,'Warning','danger');

        } else if(ctrl.searchCellno.length > 11 ){
            var msg = "Cell number is not valid";
            notifyError(msg,'Warning','danger');
        }else {
            ctrl.paramType = 'cellno';
            ctrl.loadSms('1',ctrl.searchCellno);
        }
    };
    ctrl.searchByDate = function(){
        if (ctrl.dt_range === "") {

            var msg = "Date range is not defined";
            notifyError(msg,'Warning','danger');

        } else {
            ctrl.paramType = 'date';
            ctrl.loadSms('1','date');
        }
    };
    ctrl.resetSmsValue=function () {
        ctrl.sms_details=[];
        ctrl.total_sms=[];
        ctrl.masking_data=[];
    }
    ctrl.loadSms=function (offset,param) {
        ctrl.loader = true;
        if (ctrl.dt_range != "" && ctrl.paramType == "date") {
            param='date';
            var dtrnge = ctrl.dt_range;
            var st = dtrnge.substr(0, 10);
            var end = dtrnge.substr(13, 22);
        } else if(ctrl.searchCellno != "" && ctrl.paramType == "cellno"){
            param = ctrl.searchCellno;
        }

        var url='../service/sr_load_sms.php?offset=' + offset + '&param=' + param + '&st=' + st + '&end=' + end;
        $http.get(url).then(function (response) {
          if(response.data.success !== -100){
              ctrl.loader = false;
              ctrl.sms_details=response.data.sms_details;
              ctrl.total_sms=response.data.total_pages;
          }else{
              ctrl.loader=false;
              ctrl.resetSmsValue();
              notifyError(response.data.msg, 'Warning', 'warning');
          }
        });
    };
    ctrl.searchMsg=function (cellno,id) {
      for(var i=0;i<ctrl.sms_details.length;i++){
          if(ctrl.sms_details[i].to==cellno && ctrl.sms_details[i].id==id){
              ctrl.edit_msg=ctrl.sms_details[i].sms_text;
              ctrl.sms_cellno=ctrl.sms_details[i].to;
              ctrl.sms_id=ctrl.sms_details[i].id;
              console.log('cellno'+ctrl.sms_cellno);
          }
      }

    };
    ctrl.getSendSmsData=function () {
        var url='../service/sr_get_send_sms_masking.php';
        $http.get(url).then(function (response) {
            if(response.data.success != -100){
              ctrl.masking_data=response.data.masking;
            }else{
                notifyError(response.data.msg,"Warning","warning");
            }
        })
    };


    //for single unsub any number from a paid wall

    ctrl.getActiveService=function (cellno) {
        ctrl.loader=true;
        localStorage.setItem('cellno',cellno);
        ctrl.active_services=[];
        var url='../service/sr_getActiveServicesByCellno.php?cellno='+cellno;
        $http.get(url).then(function (response) {
            if(response.data.success == 100){
                    $timeout(function () {
                        $('input[name="dt_range"]').daterangepicker(
                            {
                                locale               : {
                                    format: 'YYYY-MM-DD'
                                },
                                "alwaysShowCalendars": true
                            }
                        );
                    }, 500);
                    ctrl.loader=false;
                    ctrl.active_services=response.data.active_service;
                    console.log(ctrl.active_services);

            }else{
                ctrl.loader=false;
                notifyError('Sorry no service active on this MSISDN',"Warning","warning");
            }
        })
    };


    ctrl.unsubFromService=function () {
        ctrl.doUnSubscribe(ctrl.unsubCellno);
    };


    ctrl.showUnsubModal=function (prov,cellno) {
        $("#unsubModal").modal('show');
        ctrl.selectedstate=prov;
        ctrl.unsubCellno=cellno;
    };
    ctrl.closeUnsubModal=function () {
        ctrl.unsubCellno='';
        ctrl.selectedstate='';
        $("#unsubModal").modal('hide');

    }
    ctrl.closeChargingModal=function () {
        $("#chargingDetails").modal('hide');

    }


    ctrl.callGetActiveService=function () {
        var cellno=localStorage.getItem('cellno');
        if(cellno==null){
            return false;
        }else{
            ctrl.msisdn=cellno;
            ctrl.getActiveService(ctrl.msisdn);
        }
    }
    ctrl.clearSearchValue=function () {
        if(ctrl.msisdn==''){
            localStorage.removeItem('cellno');
            ctrl.active_services=[];
        }
    }

    ctrl.getChargingDetails=function (service) {
        var dt=angular.element(document.getElementById(service)).val();

        var dates = dt.split(" - ");
        var st=dates[0];
        var end=dates[1];




        ctrl.loader=true;
        var url='../service/sr_chargingDetailsByCellno.php?cellno='+ctrl.msisdn+'&st='+st+'&end='+end+'&service='+service;
        $http.get(url).then(function (response) {
            if(response.data.success == 100){

                ctrl.dt_model='';
                ctrl.loader=false;
                 ctrl.first=response.data.first_charge;
                 ctrl.second=response.data.second_charge;
                ctrl.first=parseInt(ctrl.first);
                ctrl.second=parseInt(ctrl.second);
                ctrl.total_charged=ctrl.first+ctrl.second;
                $("#chargingDetails").modal('show');
            }else{
                ctrl.loader=false;
                notifyError('Sorry no details found',"Warning","warning");
            }
        })


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
