<html lang="en">
<?php
/**
 * Created by PhpStorm.
 * User: mm
 * Date: 1/15/2020
 * Time: 3:54 PM
 */

require_once('in_header.php');

if (!isset($_SESSION['username'])) {
    header("Location: logout.php");
}

if (!in_array(validateUserRole($conn, $_SESSION['username']), $crop)) {
    header("Location: logout.php");
}

userLogActivity($conn, 'SUBSCRIBER');

?>
<head>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/jquery-1.11.1.min.js"></script>
</head>
<body ng-app="magriApp"  id="controler_id" >
<div id="loading" class="overlay" ng-show="ctrl.loader">
    <div>
        <img src="../images/loading.svg" alt="Please wait ..." class="load_img"/>
    </div>
</div>

<div ng-controller="newController as ctrl" ng-init="ctrl.loadSms(1,'')">
    <div class="container vert-offset-top-4">
        <div class="row ">
            <div class="col-sm-3">
                <input type="text" name="dt_range" ng-model="ctrl.dt_range" class="form-control" id="dt_range" placeholder="Enter Date">
            </div>

            <div class="col-sm-1">
                <button type="button" class="btn btn-success btn-sm "
                        ng-click="ctrl.searchByDate()">
                    Submit
                </button>
            </div>

            <div class="col-sm-1 pull-right">
                <button type="button" class="btn btn-success btn-sm"
                        ng-click="ctrl.searchByCellNo()"
                        style="margin-left: -10px">Search
                </button>
            </div>
            <div class="col-sm-3 pull-right"  >
                <input type="text" id="srch_missouri" class="form-control" ng-model="ctrl.searchCellno"
                       placeholder="Cellno [minimum 6 digits]">
            </div>
        </div>
        <div class="row vert-offset-top-1">
            <div class="col-sm-12 table-responsive myMargin">
                <table class="table table-bordered">
                    <th>ID</th>
                    <th>Cellno</th>
                    <th>From</th>
                    <th width="50%">Message</th>
                    <th>Send Date</th>
                    <th>Status</th>
                    <tbody>
                    <tr dir-paginate="sms in ctrl.sms_details|itemsPerPage:ctrl.itemsPerPage " total-items="ctrl.total_sms" current-page="ctrl.currentPage" >
                        <td>{{sms.id}}</td>
                        <td>{{sms.to}}</td>
                        <td>{{sms.from}}</td>
                        <td width="50%" style="word-wrap: break-word;min-width: 160px;max-width: 160px;">{{sms.sms_text}}</td>
                        
                        <td><span ng-if="!sms.sent_dt">N/A</span><span ng-if="sms.sent_dt">{{sms.sent_dt}}</span></td>
                        <td><span ng-if="sms.status ==100" style="color: green"><b>Sent</b></span><span ng-if="sms.status !=100" style="color: red"><b>In progress</b></span></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-right vert-offset-bottom-2" style="margin-right: 1.2rem">
                <dir-pagination-controls
                        max-size="10"
                        direction-links="true"
                        boundary-links="true"
                        on-page-change="ctrl.loadSms(newPageNumber,'')">
                </dir-pagination-controls>

            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Message</h4>
                    <h4 class="modal-title">{{ctrl.sms_cellno}}</h4>

                </div>
                <div class="modal-body">
                <form id="edit_msg" name="edit_msg" role="edit_msg">
                        <div class="form-group">
                            <div class="row">
                                <input type="hidden" name="cellno" value="{{ctrl.sms_cellno}}">
                                <input type="hidden" name="id" value="{{ctrl.sms_id}}">
                                <label class="col-sm-2">Edit Msg</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="msg" style="width: 97.5% !important;">{{ctrl.edit_msg}}</textarea>
                                </div>
                            </div>
                        </div>
                    <div class="row vert-offset-top-1">
                        <div class="col-sm-9"></div>
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-close" style="background-color: red !important;" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </div>
                </form>
                </div>
                <!--<div class="modal-footer">
                </div>-->
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
    $("#edit_msg").submit(function (e) {
        e.preventDefault();
        var formData=new FormData(this);
        $.ajax({
            type:"Post",
            url:'../service/sr_update_sms.php',
            dataType:"json",
            data:formData,
            processData: false,
            contentType: false,
            cache      : false,
            success:function (data) {
                if(data.success > 0){
                    $("#myModal").hide();
                    notifyError(data.msg,"Success","success");
                    window.location.reload();
                }else{
                    notifyError(data.msg,"Warning","warning");
                }
            }
        })
    });
    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
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
    if (getParameterByName("a") !== null && getParameterByName("a").trim().length > 0 && getParameterByName("a").trim() === "2541d938b0a58946090d7abdde0d3890"){
	setTimeout(function(){ window.location.href="sms_visibility.php"; }, 10000);;
    }

</script>
</html>
