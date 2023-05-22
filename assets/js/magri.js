angular.module('magriApp', ['angularUtils.directives.dirPagination']).directive('onFinishRender', function () {
    return {
        restrict: 'A',
        link    : function (scope, element, attr) {
            if (scope.$last === true) {
                //$('[data-toggle=confirmation]').confirmation({
                //    onConfirm: function(event) {
                //        //deleteSegment($(this).attr('data-id'),$(this).attr('data-menu-id'));
                //        goDel($(this).attr('data-id'));
                //    }
                //});
                //
                //$('[data-toggle=menu_confirm]').confirmation({
                //    onConfirm: function(event) {
                //        alert($(this).attr('data-id'));
                //        //goDel($(this).attr('data-id'));
                //    }
                //});

            }
        }
    }
}).filter('capitalizeWord', function () {
    return function (text) {
        if (text.length <= 3) {
            return text.toUpperCase();
        } else {
            return (!!text) ? text.charAt(0).toUpperCase() + text.substr(1).toLowerCase() : '';
        }
    }
}).controller('magriCtrl', ['$scope', '$http', function ($scope, $http) {


    $scope.advisory_state = 'missouri';
    $scope.selectedRow = null;

    $scope.setClickedRow = function (index) {
        $scope.selectedRow = index;

        var selected = $(this).hasClass("selected");
        $("#data tr").removeClass("selected");
        //if(!selected)
        //    $(this).addClass("selected");
    }
    /*    $scope.callLoadSubscriber = function(){
     $scope.$broadcast('loadSubscribers', {});
     };
     $scope.callLoadHelpRequest = function(){
     $scope.$broadcast('loadHelpRequest', {});
     };
     $scope.callLoadHelpResponse = function(){
     $scope.$broadcast('loadHelpResponse', {});
     };*/
    $scope.moveUp   = function (num) {
        if (num > 0) {

            var num_min = num - 1;

            tmp       = $scope.menuSegData[num - 1];
            tmp_order = $('#hid_' + num_min).val();

            $scope.menuSegData[num - 1] = $scope.menuSegData[num];

            $('#hid_' + num_min).val($('#hid_' + num).val());
            $('#hid_' + num).val(tmp_order);
            $scope.menuSegData[num] = tmp;
            $scope.selectedRow--;
        }
    }
    $scope.moveDown = function (num) {

        if (num == null) return;

        if (num < $scope.menuSegData.length - 1) {

            var num_plus = num + 1;

            tmp_order = $('#hid_' + num_plus).val();
            tmp       = $scope.menuSegData[num + 1];

            $scope.menuSegData[num + 1] = $scope.menuSegData[num];
            $('#hid_' + num_plus).val($('#hid_' + num).val());

            $scope.menuSegData[num] = tmp;
            $('#hid_' + num).val(tmp_order);
            $scope.selectedRow++;
        }
    }
    $scope.check    = function (index) {
        //window.alert("index : "+ index);
        $scope.selectedRow = index;
        console.info("Selected Row : " + $scope.selectedRow)
        //window.alert("$scope.selectedRow : "+ $scope.selectedRow);
    }

    $scope.loadMenuBox = function (page) {

        var method = 'GET';
        var url    = '../service/sr_loadMenuBox.php';
        $http.get(url).success(function (response) {
            //console.info("[App][loadMenuBox][success][Response] : " + JSON.stringify(response));

            $scope.menuBoxData = response.menuBoxData;

        }).error(function (error) {
            console.info("[App][loadMenuBox][Error][Response] : " + JSON.stringify(error));
        });
    }

    $scope.callMenuSegment = function (id) {
        window.location = 'menu_segments.php?id=' + id;
    }

    $scope.checkTxtCase = function (str) {
        var f, s = '';
        for (var i = 0; i < str.length; i++) {
            if (i == 0) {
                f = str.charAt(0).toUpperCase();

            } else {
                s += str.charAt(i).toLowerCase();
            }
        }
        return (f + s).toString();
    }

    $scope.loadAdvisory = function (state, srvc_id) {

        $("#srvc_head").html('');
        $("#srvc_id").html('');

        var method = 'GET';
        var url    = '../service/sr_loadAdvisory.php?srvc_id=' + srvc_id+ '&state='+state;
        $http.get(url).success(function (response) {
            //console.info("[App][loadMenuBox][success][Response] : " + JSON.stringify(response));

            if (response.success > 0) {

                $scope.services = [];
                $scope.advisory = response.advisory;

                // [START] creating header first for available languages
                var counter     = 1;
                var header_lbl_size = 3;

                var header_html = ' <div class="form-group row"><label for="contact-name" class="col-sm-'+ header_lbl_size +'"><b>Service</b></label>';
                for (var srvc in $scope.advisory) {
                    if(($scope.advisory[srvc].length) == 2){
                        header_lbl_size = 4;
                    }
                    $scope.services.push(srvc);
                    if (counter == 1) {
                        for (var lang in $scope.advisory[srvc]) {
                            header_html += '<label for="contact-name" class="col-sm-'+  header_lbl_size +'"><b>' + $scope.checkTxtCase($scope.advisory[srvc][lang]) + '</b></label>';
                        }
                    }
                    counter++;
                }
                header_html += '</div>';
                $("#srvc_head").html(header_html);
                // [END] creating header first for available languages

                // [START] creating Files for available languages
                var missouri_html = '';
                var srvc_html   = '';


                for (srvc in $scope.advisory) {
                    var col_size = 3;
                    var col_lbl_size = 3;
                    if(($scope.advisory[srvc].length) == 2){
                        col_size = 4;
                        col_lbl_size = 4;
                    }else if(($scope.advisory[srvc].length) == 1){
                        col_size = 9;
                    }
                    srvc_html = '<div class="form-group row"> <label for="contact-name" class="col-sm-'+ col_lbl_size +'">' + $scope.checkTxtCase(srvc) + '</label>';
                    for (lang in $scope.advisory[srvc]) {
                        srvc_html += '<span class="col-sm-'+ col_size +'"><input type="file" name="'+state+'_' + srvc + '_' + $scope.advisory[srvc][lang] + '" class="contact-name" data-validation="required" data-validation-error-msg="File is required"></span>';

                    }
                    srvc_html += '</div>';
                    missouri_html += srvc_html;
                }

                $("#srvc_id").html(missouri_html);
                $.validate({
                    modules: 'security'
                });
                $(":file").filestyle({buttonName: "btn-primary"});


            } else {

                $.notify({
                    title  : '<strong>Warning!</strong>',
                    message: response.msg
                }, {
                    type: 'danger',

                    placement : {
                        from : "top",
                        align: "right"
                    },
                    offset    : {
                        x: 50,
                        y: 116
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

        }).error(function (error) {
            console.info("[App][loadMenuBox][Error][Response] : " + JSON.stringify(error));
        });
    }

    $scope.loadAdvisorymissouri = function (state) {

        $("#srvc_head").html('');
        $("#srvc_id").html('');

        $scope.advisory_state = state;
        $scope.services_pu = '';
        var method = 'GET';
        var url    = '../service/sr_loadAdvisorymissouri.php?state='+state;

        $http.get(url).success(function (response) {
            //console.info("[App][getMenuSegments][success][Response] : " + JSON.stringify(response));
            $scope.services_pu = response.services_pu;

        }).error(function (error) {
            console.info("[App][getRecords][Error][Response] : " + JSON.stringify(error));
        });
    }

    $scope.getMenuSegments = function (id) {

        var method = 'GET';
        var url    = '../service/sr_getMenuSegments.php?id=' + id;

        $http.get(url).success(function (response) {
            //console.info("[App][getMenuSegments][success][Response] : " + JSON.stringify(response));
            $scope.menuSegData = response.menuSegData;

        }).error(function (error) {
            console.info("[App][getRecords][Error][Response] : " + JSON.stringify(error));
        });
    };

    $scope.loadEditPage = function (id, menu_id) {

        window.location = 'update_segment.php?id=' + id + "&menu_id=" + menu_id;

    }
    $scope.loadViewPage = function (seg_type) {

        window.location = 'segment.php?seg_type=' + seg_type;

    }

    $scope.exportExcel = function (state, cellno) {

       var state=state;
        if (cellno == '') {
            cellno = $("#srch_" + state).val();
        }

        var dtrnge = $("#dt_range_" + state).val();
        var st     = dtrnge.substr(0, 10);
        var end    = dtrnge.substr(13, 22);

        var is_dt = $("#is_dt_" + state).val();



    console.log('../service/export_excel.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt);

    window.location = '../service/export_excel.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt;


    }

    $scope.exportHelpExcel = function (state) {

        var cellno = '';

        if ($("#srch_help_" + state).val()) {
            cellno = $("#srch_help_" + state).val();
        }


        var dtrnge = $("#dt_range_" + state).val();
        var st     = dtrnge.substr(0, 10);
        var end    = dtrnge.substr(13, 22);

        var is_dt = 0;
        is_dt     = $("#is_dt_" + state).val();

        console.log('../service/export_help_excel.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt);

        window.location = '../service/export_help_excel.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt;

    }

    $scope.exportHelpResponseExcel = function (state) {


        var cellno = '';

        if ($("#srch_help_" + state).val()) {
            cellno = $("#srch_help_" + state).val();
        }

        var dtrnge = $("#dt_range_" + state).val();
        var st     = dtrnge.substr(0, 10);
        var end    = dtrnge.substr(13, 22);

        var is_dt = 0;
        is_dt     = $("#is_dt_" + state).val();

        console.log('../service/export_help_response_excel.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt);

        window.location = '../service/export_help_response_excel.php?st=' + st + '&end=' + end + '&cellno=' + cellno + '&state=' + state + '&is_dt=' + is_dt;

    }

    $scope.loadSubscribers = function (state, param, offset) {

        if (param == 'cellno' && (!$scope.searchCellno || $scope.searchCellno.length < 6)) {

            $.notify({
                title  : '<strong>Warning!</strong>',
                message: "Search cellno should contain at least 6 Characters"
            }, {
                type: 'danger',

                placement : {
                    from : "top",
                    align: "right"
                },
                offset    : {
                    x: 47,
                    y: 90
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

        } else {

            if (param == 'cellno') {
                param = $scope.searchCellno;
            }

            $("#is_dt_" + state).val(0)
            if (param == 'date') {
                $("#is_dt_" + state).val(1);
            }

            $scope.load_sub_param = param;

            var dtrnge = $("#dt_range_" + state).val();
            var st     = dtrnge.substr(0, 10);
            var end    = dtrnge.substr(13, 22);

            var method     = 'GET';
            var url        = '../service/sr_loadSubscribers.php?offset=' + offset + '&state=' + state + '&param=' + param + '&st=' + st + '&end=' + end;
            var pagination = '';

            console.log(url);
            $('#loadingDiv').show();
            $http.get(url).success(function (response) {
                //console.info("[App][loadSubscribers][success][Response] : " + JSON.stringify(response));
                $('#loadingDiv').hide()
                if (response.success > 0) {


                    $scope.subscribers = response.subscribers;

                    $scope.total_rec   = response.total_pages;
                    $scope.page_num    = response.page_num;
                    $scope.total_pages = Math.ceil(response.total_pages / response.limit);
                    $scope.sr_offset   = response.sr_offset;
                    $scope.limit       = response.limit + response.sr_offset;

                    $scope.limit = $scope.total_rec < $scope.limit ? $scope.total_rec : $scope.limit;

                    if (state == 'missouri') {

                        pagination = $('#page-selection_missouri').bootpag({
                            total       : $scope.total_pages,
                            maxVisible  : 5,
                            page        : 1,
                            next        : '›',
                            prev        : '‹',
                            first       : '«',
                            last        : '»',
                            leaps       : true,
                            firstLastUse: true
                        })
                    } else {
                        pagination = $('#page-selection_gb').bootpag({
                            total       : $scope.total_pages,
                            maxVisible  : 5,
                            page        : 1,
                            next        : '›',
                            prev        : '‹',
                            first       : '«',
                            last        : '»',
                            leaps       : true,
                            firstLastUse: true
                        })
                    }

                    pagination.on("page", function (event, num) {
                        $scope.loadSubscribersByPage(state, $scope.load_sub_param, num);
                    });

                    if ($("#is_called").val() == 0) {
                        $("#is_called").val(1);
                    }
                } else {
                    $.notify({
                        title  : '<strong>Warning!</strong>',
                        message: response.msg
                    }, {
                        type: 'danger',

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


            }).error(function (error) {
                console.info("[App][loadMenuBox][Error][Response] : " + JSON.stringify(error));
            });
        }
    }

    $scope.loadSubscribersByPage = function (state, param, offset) {

        var dtrnge     = $("#dt_range_" + state).val();
        var st         = dtrnge.substr(0, 10);
        var end        = dtrnge.substr(13, 22);
        var method     = 'GET';
        var url        = '../service/sr_loadSubscribers.php?offset=' + offset + '&state=' + state + '&param=' + param + '&st=' + st + '&end=' + end;
        var pagination = '';

        console.log(url);
        $('#loadingDiv').show();
        $http.get(url).success(function (response) {
            //console.info("[App][loadSubscribers][success][Response] : " + JSON.stringify(response));
            $('#loadingDiv').hide()
            $scope.subscribers = response.subscribers;
            $scope.total_rec   = response.total_pages;
            $scope.page_num    = response.page_num;
            $scope.total_pages = Math.ceil(response.total_pages / response.limit);
            $scope.sr_offset   = response.sr_offset;
            $scope.limit       = response.limit + response.sr_offset;

            $scope.limit = $scope.total_rec < $scope.limit ? $scope.total_rec : $scope.limit;


        }).error(function (error) {
            console.info("[App][loadMenuBox][Error][Response] : " + JSON.stringify(error));
        });
    }

    $scope.filterLocations = function () {


        if ($scope.selected_state) {
            $scope.filtered_locations = [];
            $scope.filtered_services  = [];

            for (var i = 0; i < $scope.locations.length; i++) {
                if ($scope.locations[i].state == $scope.selected_state) {
                    $scope.filtered_locations.push($scope.locations[i]);
                }
            }

            if ($scope.selected_state == 'missouri') {
                for (var i = 0; i < $scope.services.length; i++) {
                    if ($scope.services[i].state == $scope.selected_state) {
                        $scope.filtered_services.push($scope.services[i]);
                    }
                }
                $scope.langs = $scope.langs_missouri;
                $("#srvc_star").attr('style', 'color:red;');
            } else {
                $scope.langs = $scope.langs_gb;
                $("#srvc_star").attr('style', 'color:white;');
            }


        } else {
            $scope.filtered_locations = $scope.locations;
            $scope.filtered_services  = $scope.services;
        }

    }

    $scope.filterLocations_gb = function () {


        if ($scope.selected_state_gb) {


            $scope.filtered_locations = [];
            $scope.filtered_services  = [];


            for (var i = 0; i < $scope.locations.length; i++) {
                if ($scope.locations[i].state == $scope.selected_state_gb) {
                    $scope.filtered_locations.push($scope.locations[i]);
                }
            }

            if ($scope.selected_state_gb == 'missouri') {

                for (var i = 0; i < $scope.services.length; i++) {
                    if ($scope.services[i].state == $scope.selected_state_gb) {
                        $scope.filtered_services.push($scope.services[i]);
                    }
                }
                $scope.langs = $scope.langs_missouri;
                $("#srvc_star_gb").attr('style', 'color:red;');
            } else {
                $scope.langs = $scope.langs_gb;
                $("#srvc_star_gb").attr('style', 'color:white;');
            }


        } else {
            $scope.filtered_locations = $scope.locations;
            $scope.filtered_services  = $scope.services;
        }

    }

    $scope.loadSubProfile = function (state, cellno) {


        var method = 'GET';
        var url    = '../service/sr_getSubProfile.php?state=' + state + '&cellno=' + cellno;

        $http.get(url).success(function (response) {
            console.info("[App][loadSubscribers][success][Response] : " + JSON.stringify(response));

            $scope.sub_profile = response.sub_profile[0];

            $scope.selected_state = $scope.sub_profile.state;
            $scope.sub_names         = response.names;

            $scope.langs_missouri = response.langs_missouri;
            $scope.langs_gb     = response.langs_gb;

            $scope.langs = response.langs_missouri;

            $scope.states          = response.states;
            $scope.locations          = response.locations;
            $scope.filtered_locations = response.locations;

            $scope.services = response.services;

            $scope.filterLocations();


        }).error(function (error) {
            console.info("[App][loadSubProfile][Error][Response] : " + JSON.stringify(error));
        });


    }

    $scope.doSubscribe = function () {


        var method = 'GET';
        var url    = '../service/sr_addSubscriber.php?cellno=' + $scope.searchCellno;
        $http.get(url).success(function (response) {
            console.info("[App][doSubscribe][success][Response] : " + JSON.stringify(response));

            if (response.success > 0) {
                $.notify({
                    title  : '<strong>Success!</strong>',
                    message: response.msg
                }, {
                    type: 'success',

                    placement : {
                        from : "top",
                        align: "right"
                    },
                    offset    : {
                        x: 47,
                        y: 90
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
                $scope.searchCellno = '';
            } else {
                $.notify({
                    title  : '<strong>Warning!</strong>',
                    message: response.msg
                }, {
                    type: 'danger',

                    placement : {
                        from : "top",
                        align: "right"
                    },
                    offset    : {
                        x: 47,
                        y: 90
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

        }).error(function (error) {
            $('#loadingDiv').hide();
            console.info("[App][doSubscribe][Error][Response] : " + JSON.stringify(error));
        });

    }

    $scope.doUnSubscribe = function (state) {


        var cellno = $('#dell_cellno').val();
        var method = 'GET';
        var url    = '../service/sr_doUnSubscribe.php?cellno=' + cellno;
        $http.get(url).success(function (response) {
            console.info("[App][doSubscribe][success][Response] : " + JSON.stringify(response));

            if (response.success > 0) {
                $('#dell_cellno').val('');
                $('#deleteModal_' + state).modal('hide');
                $('#myModal_' + state).modal('hide');

                $.notify({
                    title  : '<strong>Success!</strong>',
                    message: response.msg
                }, {
                    type: 'success',

                    placement : {
                        from : "top",
                        align: "right"
                    },
                    offset    : {
                        x: 47,
                        y: 90
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
                $scope.searchCellno = '';
                //window.location     = 'subscribers.php'
                //$scope.loadSubscribers(state,'',1);
            } else {
                $.notify({
                    title  : '<strong>Warning!</strong>',
                    message: response.msg
                }, {
                    type: 'danger',

                    placement : {
                        from : "top",
                        align: "right"
                    },
                    offset    : {
                        x: 47,
                        y: 70
                    },
                    spacing   : 10,
                    z_index   : 1131,
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

        }).error(function (error) {
            $('#loadingDiv').hide();
            console.info("[App][doSubscribe][Error][Response] : " + JSON.stringify(error));
        });

    }

  $scope.wdcDoUnSubscribe=function(state){

        var cellno = $('#dell_cellno').val();
          var method = 'GET';
          var url    = '../service/sr_wdc_doUnSubscribe.php?cellno=' + cellno;
          $http.get(url).success(function (response) {
              console.info("[App][doSubscribe][success][Response] : " + JSON.stringify(response));

              if (response.success > 0) {
                  $('#dell_cellno').val('');
                  $('#wdc_deleteModal_' + state).modal('hide');
                  $('#wdcModal' + state).modal('hide');

                  $.notify({
                      title  : '<strong>Success!</strong>',
                      message: response.msg
                  }, {
                      type: 'success',

                      placement : {
                          from : "top",
                          align: "right"
                      },
                      offset    : {
                          x: 47,
                          y: 90
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
                  $scope.searchCellno = '';
                  //window.location     = 'subscribers.php'
                  //$scope.loadSubscribers(state,'',1);
              } else {
                  $.notify({
                      title  : '<strong>Warning!</strong>',
                      message: response.msg
                  }, {
                      type: 'danger',

                      placement : {
                          from : "top",
                          align: "right"
                      },
                      offset    : {
                          x: 47,
                          y: 70
                      },
                      spacing   : 10,
                      z_index   : 1131,
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

          }).error(function (error) {
              $('#loadingDiv').hide();
              console.info("[App][doSubscribe][Error][Response] : " + JSON.stringify(error));
          });

      }


    $scope.loadHelpRequests = function (state, param, offset) {


        if (param == 'cellno' && (!$scope.searchHelpCellno || $scope.searchHelpCellno.length < 6)) {

            $.notify({
                title  : '<strong>Warning!</strong>',
                message: "Search cellno should contain at least 6 Characters"
            }, {
                type: 'danger',

                placement : {
                    from : "top",
                    align: "right"
                },
                offset    : {
                    x: 47,
                    y: 90
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

        } else {

            if (param == 'cellno') {
                param = $scope.searchHelpCellno;
            }

            $scope.helpRequests = '';
            $("#is_dt_" + state).val(0);
            var st, end = '';
            if (param == 'date') {
                var dtrnge = $("#dt_range_" + state).val();
                st         = dtrnge.substr(0, 10);
                end        = dtrnge.substr(13, 22);
                $("#is_dt_" + state).val(1);
            }
            var pagination = '';

            var method = 'GET';
            var url    = '../service/sr_loadHelpRequests.php?param=' + param + '&offset=' + offset + '&state=' + state + '&st=' + st + '&end=' + end;

            $('#loadingDiv').show();
            $http.get(url).success(function (response) {
                //console.info("[App][loadMenuBox][success][Response] : " + JSON.stringify(response));
                $('#loadingDiv').hide();
                if (response.success > 0) {


                    $scope.helpRequests = response.helpRequests;

                    $scope.total_rec   = response.total_pages;
                    $scope.page_num    = response.page_num;
                    $scope.total_pages = Math.ceil(response.total_pages / response.limit);
                    $scope.sr_offset   = response.sr_offset;
                    $scope.limit       = response.limit + response.sr_offset;

                    $scope.limit = $scope.total_rec < $scope.limit ? $scope.total_rec : $scope.limit;

                    pagination = $('#page-selection_' + state).bootpag({
                        total       : $scope.total_pages,
                        maxVisible  : 5,
                        page        : 1,
                        next        : '›',
                        prev        : '‹',
                        first       : '«',
                        last        : '»',
                        leaps       : true,
                        firstLastUse: true
                    })

                    pagination.on("page", function (event, num) {
                        $scope.loadHelpRequestsByPage(state, param, num);
                    });


                } else {
                    $.notify({
                        title  : '<strong>Warning!</strong>',
                        message: response.msg
                    }, {
                        type: 'danger',

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

            }).error(function (error) {
                $('#loadingDiv').hide();
                console.info("[App][loadMenuBox][Error][Response] : " + JSON.stringify(error));
            });
        }
    }

    $scope.loadHelpRequestsByPage = function (state, param, offset) {

        var st, end = '';
        $("#is_dt_" + state).val(0);
        if (param == 'date') {
            var dtrnge = $("#dt_range_" + state).val();
            st         = dtrnge.substr(0, 10);
            end        = dtrnge.substr(13, 22);
            $("#is_dt_" + state).val(1);
        }

        var pagination = '';
        var method     = 'GET';
        var url        = '../service/sr_loadHelpRequests.php?param=' + param + '&offset=' + offset + '&state=' + state + '&st=' + st + '&end=' + end;

        $('#loadingDiv').show();
        $http.get(url).success(function (response) {
            //console.info("[App][loadMenuBox][success][Response] : " + JSON.stringify(response));
            $('#loadingDiv').hide();
            if (response.success > 0) {


                $scope.helpRequests = response.helpRequests;
                $scope.total_rec    = response.total_pages;
                $scope.page_num     = response.page_num;
                $scope.total_pages  = Math.ceil(response.total_pages / response.limit);
                $scope.sr_offset    = response.sr_offset;
                $scope.limit        = response.limit + response.sr_offset;

                $scope.limit = $scope.total_rec < $scope.limit ? $scope.total_rec : $scope.limit;


            } else {
                $.notify({
                    title  : '<strong>Warning!</strong>',
                    message: response.msg
                }, {
                    type: 'danger',

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

        }).error(function (error) {
            $('#loadingDiv').hide();
            console.info("[App][loadMenuBox][Error][Response] : " + JSON.stringify(error));
        });
    }

    $scope.loadHelpResponse = function (state, param, offset) {


        if (param == 'cellno' && (!$scope.searchHelpCellno || $scope.searchHelpCellno.length < 6)) {

            $.notify({
                title  : '<strong>Warning!</strong>',
                message: "Search cellno should contain at least 6 Characters"
            }, {
                type: 'danger',

                placement : {
                    from : "top",
                    align: "right"
                },
                offset    : {
                    x: 47,
                    y: 90
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

        } else {

            if (param == 'cellno') {
                param = $scope.searchHelpCellno;
            }

            $scope.helpRequests = '';
            $("#is_dt_" + state).val(0);
            var st, end = '';
            if (param == 'date') {
                var dtrnge = $("#dt_range_" + state).val();
                st         = dtrnge.substr(0, 10);
                end        = dtrnge.substr(13, 22);
                $("#is_dt_" + state).val(1);
            }
            var pagination = '';

            var method = 'GET';
            var url    = '../service/sr_loadHelpResponse.php?param=' + param + '&offset=' + offset + '&state=' + state + '&st=' + st + '&end=' + end;

            $('#loadingDiv').show();
            $http.get(url).success(function (response) {
                //console.info("[App][loadMenuBox][success][Response] : " + JSON.stringify(response));
                $('#loadingDiv').hide();
                if (response.success > 0) {


                    $scope.helpRequests = response.helpRequests;

                    $scope.total_rec   = response.total_pages;
                    $scope.page_num    = response.page_num;
                    $scope.total_pages = Math.ceil(response.total_pages / response.limit);
                    $scope.sr_offset   = response.sr_offset;
                    $scope.limit       = response.limit + response.sr_offset;

                    $scope.limit = $scope.total_rec < $scope.limit ? $scope.total_rec : $scope.limit;

                    pagination = $('#page-selection_' + state).bootpag({
                        total       : $scope.total_pages,
                        maxVisible  : 5,
                        page        : 1,
                        next        : '›',
                        prev        : '‹',
                        first       : '«',
                        last        : '»',
                        leaps       : true,
                        firstLastUse: true
                    })

                    pagination.on("page", function (event, num) {
                        $scope.loadHelpResponseByPage(state, param, num);
                    });


                } else {
                    $.notify({
                        title  : '<strong>Warning!</strong>',
                        message: response.msg
                    }, {
                        type: 'danger',

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

            }).error(function (error) {
                $('#loadingDiv').hide();
                console.info("[App][loadMenuBox][Error][Response] : " + JSON.stringify(error));
            });
        }
    }

    $scope.loadHelpResponseByPage = function (state, param, offset) {

        var st, end = '';
        $("#is_dt_" + state).val(0);
        if (param == 'date') {
            var dtrnge = $("#dt_range_" + state).val();
            st         = dtrnge.substr(0, 10);
            end        = dtrnge.substr(13, 22);
            $("#is_dt_" + state).val(1);
        }

        var pagination = '';
        var method     = 'GET';
        var url        = '../service/sr_loadHelpResponse.php?param=' + param + '&offset=' + offset + '&state=' + state + '&st=' + st + '&end=' + end;

        $('#loadingDiv').show();
        $http.get(url).success(function (response) {
            //console.info("[App][loadMenuBox][success][Response] : " + JSON.stringify(response));
            $('#loadingDiv').hide();
            if (response.success > 0) {


                $scope.helpRequests = response.helpRequests;
                $scope.total_rec    = response.total_pages;
                $scope.page_num     = response.page_num;
                $scope.sr_offset    = response.sr_offset;
                $scope.limit        = response.limit + response.sr_offset;

                $scope.limit = $scope.total_rec < $scope.limit ? $scope.total_rec : $scope.limit;


            } else {
                $.notify({
                    title  : '<strong>Warning!</strong>',
                    message: response.msg
                }, {
                    type: 'danger',

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

        }).error(function (error) {
            $('#loadingDiv').hide();
            console.info("[App][loadMenuBox][Error][Response] : " + JSON.stringify(error));
        });
    }

    $scope.loadHelpModal = function (help) {
        $scope.helpModal = help;

        $("#help_id_" + $scope.helpModal.state).val($scope.helpModal.id);


        var method = 'GET';
        var url    = '../service/sr_getSubProfile.php?state=' + $scope.helpModal.state + '&cellno=' + $scope.helpModal.cellno;

        $http.get(url).success(function (response) {
            console.info("[App][loadSubscribers][success][Response] : " + JSON.stringify(response));

            $scope.sub_profile = response.sub_profile[0];

            $scope.selected_state = $scope.sub_profile.state;
            $scope.sub_names         = response.names;

            $scope.langs_missouri = response.langs_missouri;
            $scope.langs_gb     = response.langs_gb;

            $scope.langs = response.langs_missouri;

            $scope.states          = response.states;
            $scope.locations          = response.locations;
            $scope.filtered_locations = response.locations;

            $scope.services = response.services;

            $scope.filterLocations();


        }).error(function (error) {
            console.info("[App][loadSubProfile][Error][Response] : " + JSON.stringify(error));
        });

    }

    $scope.getContent = function (seg_type) {

        var method = 'GET';
        var url    = '../service/sr_getContent.php?seg_type=' + seg_type;
        $http.get(url).success(function (response) {
            console.info("[App][loadMenuBox][success][Response] : " + JSON.stringify(response));

        }).error(function (error) {
            console.info("[App][loadMenuBox][Error][Response] : " + JSON.stringify(error));
        });
    }

    $scope.deleteConfirm = function (id) {

        $('#menu_del').val(id);
    }

    $scope.deleteSubscriberConfirm = function (cellno) {
        $('#dell_cellno').val(cellno);
    }


    $scope.deleteSegment = function (id, menu_id) {

        var method = 'GET';
        var url    = 'sr_deleteSegment.php?id=' + id;

        $http.get(url).success(function (response) {
            $scope.getMenuSegments(menu_id);
            scope.selectedRow = null;
            $.notify({
                title  : '<strong>Success!</strong>',
                message: data.msg
            }, {
                type: 'success',

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

        }).error(function (error) {
            console.info("[App][getRecords][Error][Response] : " + JSON.stringify(error));
        });
    }


    $scope.editViewRecord = function () {

        var id = $('#record_id').val();

        var dateToday = new Date();
        dateToday.setHours(0);
        dateToday.setMinutes(0);
        dateToday.setSeconds(0);
        dateToday.setMilliseconds(0);

        var dt = $('#datepicker').val();
        dt     = new Date(dt);


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


    $scope.editRecord = function (id, src) {
        var method = 'GET';
        var url    = 'edit_weather.php?id=' + id + '&src=' + src;
        console.log(url);
        window.location = url;
    }

    $scope.loadEditRecord = function (id) {

        var method = 'GET';
        var url    = '../service/sr_loadEditRecord.php?id=' + id;
        $http.get(url).success(function (response) {
            console.info("[App][loadEditRecord][][Response] : " + JSON.stringify(response));

            $scope.pu_conditions    = response.pu_conditions;
            $scope.kansas_conditions    = response.kansas_conditions;
            $scope.florida_conditions = response.florida_conditions;
            $scope.hawaii_conditions = response.hawaii_conditions;

            $scope.pu_future_conditions    = response.pu_future_conditions;
            $scope.kansas_future_conditions    = response.kansas_future_conditions;
            $scope.florida_future_conditions = response.florida_future_conditions;
            $scope.hawaii_future_conditions = response.hawaii_future_conditions;

            $scope.pu_locations    = response.pu_locations;
            $scope.kansas_locations    = response.kansas_locations;
            $scope.florida_locations = response.florida_locations;
            $scope.hawaii_locations = response.hawaii_locations;

            // $scope.conditions           = response.conditions;
            $scope.eve_conditions       = response.eve_conditions;
            $scope.eve_future_condition = response.eve_future_condition;

            //$scope.future_conditions = response.future_conditions;
            $scope.min_temp     = response.min_temp;
            $scope.max_temp     = response.max_temp;
            $scope.eve_min_temp = response.eve_min_temp;
            $scope.eve_max_temp = response.eve_max_temp;

            $scope.date     = response.date;
            $scope.state = response.state;
            $scope.sms_text = response.sms_text;

            $scope.location_id = response.location_id;
            $scope.date        = response.date;

            $scope.today_condition_id      = response.today_condition_id;
            $scope.future_condition_id     = response.future_condition_id;
            $scope.eve_today_condition_id  = response.eve_today_condition_id;
            $scope.eve_future_condition_id = response.eve_future_condition_id;

            $("#app_src").val($scope.state);


        }).error(function (error) {
            console.info("[App][getRecords][Error][Response] : " + JSON.stringify(error));
        });
    }
    $scope.getMainPage    = function (src) {

        window.location = 'add_weather.php?src=' + src;

    }

    $scope.getReportData = function (src) {

        $('#tbl_' + src).children('tr').remove();
        $("#source_1").val('');

        var dt_selected, id = '';
        if (src == 'missouri') {
            dt_selected = $('#datepicker');
            id          = $('#loc_id_missouri').val();

        } else if (src == 'gb') {
            dt_selected = $('#datepicker_gb');
            id          = $('#loc_id_gb').val();
        } else if (src == 'florida') {
            dt_selected = $('#datepicker_florida');
            id          = $('#loc_id_florida').val();
        }else if (src == 'hawaii') {
            dt_selected = $('#datepicker_hawaii');
            id          = $('#loc_id_hawaii').val();
        }


        var dateRange = dt_selected.val().split("-");
        var startdate = dateRange[0].replace('/', '-');
        var enddate   = dateRange[1].replace('/', '-');
        startdate     = startdate.replace('/', '-');
        enddate       = enddate.replace('/', '-');


        $("#warning").html('');
        var url = '../service/sr_getReport.php';

        $http.get(url + '?stDate=' + startdate + '&endDate=' + enddate + '&loc_id=' + id + '&src=' + src)
            .success(function (data) {

                if (data.success > 0) {
                    console.log('SUCESS: ' + data.sms_data[0].sms_text);
                    $scope.sms_data     = data.sms_data;
                    $scope.eve_sms_data = data.eve_sms_data;

                    $scope.sms_txt = $scope.sms_data[0].sms_text;
                    if (data.eve_sms_data && data.eve_sms_data.length > 0) {
                        $scope.eve_sms_txt = $scope.eve_sms_data[0].eve_sms_text;
                    }

                    if (src == 'gb') {
                        $("#tbl_gb").show();
                    } else if (src == 'missouri' ){
                        $("#tbl_missouri").show();
                    } else if (src == 'florida') {
                        $("#tbl_florida").show();
                    }else if (src == 'hawaii') {
                        $("#tbl_hawaii").show();
                    }


                } else {

                    $.notify({
                        title  : '<strong>Warning!</strong>',
                        message: data.msg
                    }, {
                        type: 'danger',

                        placement : {
                            from : "top",
                            align: "right"
                        },
                        offset    : {
                            x: 47,
                            y: 90
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

                    $("#source_1").val('');
                    $("#tbl").hide();
                    $("#sBtn").focus();
                }
            }).error(function (error) {
            console.info("[App][getAdvertise][Error][Response] : " + JSON.stringify(error));
        });
    };

    $scope.reloadViewWeather   = function () {
        window.location = 'view_weather.php'
    }
    $scope.reloadReportWeather = function () {
        window.location = 'report_weather.php'
    }

    $scope.getViewEditWeather = function (src) {


        if (src == 'gb') {

            $("#sms_box_gb").css("display", "none");
            $("#file_box_gb").css("display", "none");
            $("#edit_box_gb").css("display", "none");

            $("#eve_sms_box").css("display", "none");
            $("#eve_file_box").css("display", "none");
            $("#eve_edit_box").css("display", "none");

            $("#textarea_id_gb").html('');
            $("#eve_textarea_id").html('');

        } else if (src == 'florida') {

            $("#sms_box_florida").css("display", "none");
            $("#file_box_florida").css("display", "none");
            $("#edit_box_florida").css("display", "none");

            $("#textarea_id_florida").html('');

        }else if (src == 'hawaii') {

            $("#sms_box_hawaii").css("display", "none");
            $("#file_box_hawaii").css("display", "none");
            $("#edit_box_hawaii").css("display", "none");

            $("#textarea_id_hawaii").html('');

        } else {

            $("#textarea_id").html('');

            $("#sms_box_missouri").css("display", "none");
            $("#file_box_missouri").css("display", "none");
            $("#edit_box_missouri").css("display", "none");
        }


        var dt_selected, id = '';
        if (src == 'missouri') {
            dt_selected = $('#datepicker');
            id          = $('#loc_id_missouri').val();
        } else if (src == 'gb') {
            dt_selected = $('#datepicker_gb');
            id          = $('#loc_id_gb').val();
        } else if (src == 'florida') {
            dt_selected = $('#datepicker_florida');
            id          = $('#loc_id_florida').val();
        }else if (src == 'hawaii') {
            dt_selected = $('#datepicker_hawaii');
            id          = $('#loc_id_hawaii').val();
        }

        var date    = dt_selected.val().split("/");
        var newDate = date[2] + '-' + date[0] + '-' + date[1];

        $("#textarea_id").html('');
        $("#warning").html('');
        $("#textarea_id").focus();

        var url = '../service/sr_getViewRecord.php';

        $http.get(url + '?date=' + newDate + '&loc_id=' + id + '&src=' + src)
            .success(function (response) {

                if (response.success > 0) {

                    console.log(JSON.stringify(response));

                    $scope.location = response.location;

                    $scope.eve_condition        = response.eve_condition;
                    $scope.eve_future_condition = response.eve_future_condition;
                    $scope.condition            = response.condition;
                    $scope.future_condition     = response.future_condition;

                    $scope.view_record_id = response.view_record_id;

                    $scope.min_temp     = response.min_temp;
                    $scope.max_temp     = response.max_temp;
                    $scope.eve_min_temp = response.eve_min_temp;
                    $scope.eve_max_temp = response.eve_max_temp;
                    $scope.date         = response.date;
                    $scope.sms_text     = response.sms_text;
                    $scope.sms_text     = response.sms_text;
                    $scope.eve_sms_text = response.eve_sms_text;

                    if (response.files_1 && response.files_1.length > 0) {
                        $scope.files_1 = response.files_1;
                        $scope.a       = response.files_1[0];
                        $scope.files_2 = response.files_2;
                        $scope.b       = response.files_2[0];
                        $scope.files_3 = response.files_3;
                        $scope.c       = response.files_3[0];
                    }

                    if (response.files_4 && response.files_4.length > 0) {
                        $scope.files_4 = response.files_4;
                        $scope.d       = response.files_4[0];
                    }
                    if (response.files_5 && response.files_5.length > 0) {
                        $scope.files_5 = response.files_5;
                        $scope.e       = response.files_5[0];
                    }

                    if (response.files_10 && response.files_10.length > 0) {
                        $scope.files_10 = response.files_10;
                        $scope.s        = response.files_10[0];
                    }

                    if (response.files_20 && response.files_20.length > 0) {
                        $scope.files_20 = response.files_20;
                        $scope.k        = response.files_20[0];
                    }


                    $("#record_id").val(response.id);
                    $("#edit_btn").prop("disabled", false);

                    if (src == 'gb') {

                        $("#sms_box_gb").css("display", "block");
                        $("#file_box_gb").css("display", "block");
                        $("#edit_box_gb").css("display", "block");

                        $("#eve_sms_box").css("display", "block");
                        $("#eve_file_box").css("display", "block");
                        $("#eve_edit_box").css("display", "block");

                        $("#textarea_id_gb").html(response.sms_text);
                        $("#eve_textarea_id").html(response.eve_sms_text);

                    } else if (src == 'florida') {

                        $("#sms_box_florida").css("display", "block");
                        $("#file_box_florida").css("display", "block");
                        $("#edit_box_florida").css("display", "block");

                        $("#textarea_id_florida").html(response.sms_text);

                    } else if (src == 'hawaii') {

                        $("#sms_box_hawaii").css("display", "block");
                        $("#file_box_hawaii").css("display", "block");
                        $("#edit_box_hawaii").css("display", "block");

                        $("#textarea_id_hawaii").html(response.sms_text);

                    }else {

                        $("#textarea_id").html(response.sms_text);

                        $("#sms_box_missouri").css("display", "block");
                        $("#file_box_missouri").css("display", "block");
                        $("#edit_box_missouri").css("display", "block");
                    }


                    var dateToday = new Date();
                    dateToday.setHours(0);
                    dateToday.setMinutes(0);
                    dateToday.setSeconds(0);
                    dateToday.setMilliseconds(0);

                    var dt = dt_selected.val();
                    dt     = new Date(dt);


                    if (dt.getTime() < dateToday.getTime()) {
                        //$("#edit_btn_"+src).prop("disabled", true);
                        $("#edit_btn_" + src).css("display", 'none');
                    }
                    //if (data.role == 'user') {
                    //    $("#edit_btn").css("display", 'none');
                    //}


                } else {

                    $.notify({
                        title  : '<strong>Warning!</strong>',
                        message: response.msg
                    }, {
                        type: 'danger',

                        placement : {
                            from : "top",
                            align: "right"
                        },
                        offset    : {
                            x: 47,
                            y: 90
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

                    $("#edit_btn").prop("disabled", true);
                    $("#sms_box").css('display', 'none');
                    $("#file_box").css('display', 'none');
                    $("#edit_box").css('display', 'none');
                }
            }).error(function (error) {
            console.info("[App][getAdvertise][Error][Response] : " + JSON.stringify(error));
        });

    }

    $scope.loadLocations = function () {

        $scope.pu_locations    = '';
        $scope.kansas_locations    = '';
        $scope.florida_locations = '';

        var method = 'GET';
        var url    = '../service/sr_loadLocations.php';
        $http.get(url).success(function (response) {
            // console.info("[App][loadData][][Response] : " + JSON.stringify(response));

            if (response.success > 0) {
                $scope.pu_locations    = response.pu_locations;
                $scope.kansas_locations    = response.kansas_locations;
                $scope.florida_locations = response.florida_locations;
                $scope.hawaii_locations = response.hawaii_locations;
            } else {

            }


        }).error(function (error) {
            console.info("[App][getRecords][Error][Response] : " + JSON.stringify(error));
        });
    }

    $scope.loadDataAddWeather = function (dt) {

        var newDate = 0;
        if (dt == '1') {
            var dateToday = new Date();
            newDate       = dateToday.getFullYear() + '-' + (dateToday.getMonth() + 1) + '-' + dateToday.getDate();
        } else {
            newDate = dt;
        }

        var method = 'GET';
        var url    = '../service/sr_loadDataForAddWeather.php';
        $http.get(url + '?dt=' + newDate).success(function (response) {
            //console.info("[App][loadData][][Response] : " + JSON.stringify(response));

            $scope.pu_locations    = response.pu_locations;
            $scope.kansas_locations    = response.kansas_locations;
            $scope.florida_locations = response.florida_locations;
            $scope.hawaii_locations   = response.hawaii_locations;

            $scope.pu_conditions    = response.pu_conditions;
            $scope.kansas_conditions    = response.kansas_conditions;
            $scope.florida_conditions = response.florida_conditions;
            $scope.hawaii_conditions   = response.hawaii_conditions;

            $scope.eve_conditions = response.eve_conditions;

            $scope.pu_future_conditions    = response.pu_future_conditions;
            $scope.kansas_future_conditions    = response.kansas_future_conditions;
            $scope.florida_future_conditions = response.florida_future_conditions;
            $scope.hawaii_future_conditions   = response.hawaii_future_conditions;


        }).error(function (error) {
            console.info("[App][getRecords][Error][Response] : " + JSON.stringify(error));
        });
    }


    $scope.getLastInsertedData = function (id, src) {

        $("#text_hide").val('');
        var method = 'GET';
        var url    = '../service/sr_getLastInsertedData.php?id=' + id + '&src=' + src;
        console.log(url);
        $http.get(url).success(function (response) {

            console.log(JSON.stringify(response));

            if (response.success > 0) {

                $scope.location = response.location;

                $scope.eve_condition        = response.eve_condition;
                $scope.eve_future_condition = response.eve_future_condition;
                $scope.condition            = response.condition;
                $scope.future_condition     = response.future_condition;

                $scope.min_temp     = response.min_temp;
                $scope.max_temp     = response.max_temp;
                $scope.eve_min_temp = response.eve_min_temp;
                $scope.eve_max_temp = response.eve_max_temp;
                $scope.date         = response.date;
                $scope.sms_text     = response.sms_text;
                $scope.eve_sms_text = response.eve_sms_text;

                if (response.files_1 && response.files_1.length > 0) {
                    $scope.files_1 = response.files_1;
                    $scope.a       = response.files_1[0];
                    $scope.files_2 = response.files_2;
                    $scope.b       = response.files_2[0];
                    $scope.files_3 = response.files_3;
                    $scope.c       = response.files_3[0];
                }

                if (response.files_4 && response.files_4.length > 0) {
                    $scope.files_4 = response.files_4;
                    $scope.d       = response.files_4[0];
                }
                if (response.files_5 && response.files_5.length > 0) {
                    $scope.files_5 = response.files_5;
                    $scope.e       = response.files_5[0];
                }

                if (response.files_10 && response.files_10.length > 0) {
                    $scope.files_10 = response.files_10;
                    $scope.s        = response.files_10[0];
                }

                if (response.files_20 && response.files_20.length > 0) {
                    $scope.files_20 = response.files_20;
                    $scope.k        = response.files_20[0];
                }

                if (src == 'hawaii') {
                    $("#textarea_id_hawaii").html(response.sms_text);
                }

                $.notify({
                    title  : '<strong>Success!</strong>',
                    message: response.msg
                }, {
                    type: 'success',

                    placement : {
                        from : "top",
                        align: "right"
                    },
                    offset    : {
                        x: 47,
                        y: 90
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

            } else {
                $.notify({
                    title  : '<strong>Warning!</strong>',
                    message: response.msg
                }, {
                    type: 'danger',

                    placement : {
                        from : "top",
                        align: "right"
                    },
                    offset    : {
                        x: 47,
                        y: 90
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


        }).error(function (error) {
            console.info("[App][getRecords][Error][Response] : " + JSON.stringify(error));
        });
    };


    $scope.loadCrops       = function () {

        var method = 'GET';
        var url    = 'sr_loadCrops.php';
        $http.get(url).success(function (response) {
            //console.info("[App][loadCrops][][Response] : " + JSON.stringify(response));
            $scope.crops = response.crops;
            $scope.add   = '';
            $scope.view  = '';
            $scope.repo  = '';
            $scope.adv   = 'active';

        }).error(function (error) {
            console.info("[App][loadCrops][Error] : " + JSON.stringify(error));
        });
    }
    $scope.getViewAdvisory = function (crop_id) {

        var date    = $('#datepicker').val().split("/");
        var newDate = date[2] + '-' + date[0] + '-' + date[1];

        //var crop_id = $('#crops_id').val();
        //var crop_name = $("#crops_id option:selected").text();

        console.info("[App][getViewAdvisory][][date] : " + date + ' New Date ' + newDate);

        var method = 'GET';
        var url    = 'sr_getViewAdvisory.php';
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


    $scope.loadSmsAdvisorymissouri = function () {

        var method = 'GET';
        var url    = '../service/sr_loadSmsAdvisorymissouri.php';
        $http.get(url).success(function (response) {

            if (response.success > 0) {
                $scope.sms_push_advisory = response.sms_push_advisory;
            } else {
                $.notify({
                    title  : '<strong>Warning!</strong>',
                    message: response.msg
                }, {
                    type: 'danger',

                    placement : {
                        from : "top",
                        align: "right"
                    },
                    offset    : {
                        x: 47,
                        y: 90
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

        }).error(function (error) {
            console.info("[App][getRecords][Error][Response] : " + JSON.stringify(error));
        });
    }

    $scope.openAdvisoryPuSMS = function () {
        window.location = 'advisory_sms_missouri_add.php';
    }

    $scope.changeAlertTypemissouri = function () {
        if ($scope.channel_pu == 'NONE') {
            $("#alerts_pu").val(-100);
        } else {
            $("#alerts_pu").val($scope.sub_profile.alert_type);
        }
    }
    $scope.changeAlertTypeGb     = function () {
        if ($scope.channel_gb == 'NONE') {
            $("#alerts_gb").val(-100);
        } else {
            $("#alerts_gb").val($scope.sub_profile.alert_type);
        }
    }

    $scope.openNewsPuSMS = function (param) {

        if (param == 1) {
            window.location = 'advisory_news_missouri.php';
        } else {
            window.location = 'advisory_sms_missouri.php';
        }

    }


}]);




