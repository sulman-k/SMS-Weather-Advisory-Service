
<html lang="en">

<?php
/**
 * Created by PhpStorm.
 * User: brad
 * Date: 6/14/2020
 * Time: 1:18 PM
 */


require_once('in_header.php');
if (!isset($_SESSION['username'])) {
    header("Location: logout.php");
}

if (!in_array(validateUserRole($conn, $_SESSION['username']), $paid_wall_unsub)) {
    header("Location: logout.php");
}

userLogActivity($conn, 'Single Unsub');
?>
<?php require_once ('in_footer.php');?>

<body>


<div class="container" ng-app="magriApp"  ng-controller="newController as ctrl" id="myController" ng-init="ctrl.callGetActiveService()">
    <div id="loading" class="overlay" ng-show="ctrl.loader">
        <div>
            <img src="../images/loading.svg" alt="Please wait ..." class="load_img"/>
        </div>
    </div>
    <div class="row" >
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
            <div class="form-group row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <label for="msisd">Search By MSISDN </label>
                    <input type="text" class="form-control" name="msisdn" id="msisdn" maxlength="11" placeholder="03xxxxxxxxx" ng-model="ctrl.msisdn" onkeypress="return checkNumber(event)" onkeyup="checkLen()" onkeydown="clearSearchedArray()"/>
                </div>
                <div class="col-sm-3"></div>
            </div>
            <div class="form-group row">
                <button  class="btn btn-success"  id="search_btn" ng-click="ctrl.getActiveService(ctrl.msisdn)" disabled >Search</button>
            </div>
            <div class="form-group row " id="result_div">
                <div class="col-sm-2 text-center">
                    <h4 >Active Services</h4>
                </div>
                <div class="col-sm-3">
                    <h4>Price Package</h4>
                </div>
                <div class="col-sm-5 text-left">
                    <h4>Total successful charging</h4>
                </div>
                <div class="col-sm-2">
                    <h4>Action</h4>
                </div>
                <div class="vert-offset-top-2" ng-repeat="srvc in ctrl.active_services">
                    <div >
                        <p class="col-sm-3 text-left " style="margin-top: 12px;">{{srvc.value}}</p>
                        <p class="col-sm-2 text-left" style="margin-top: 12px; " ng-if="srvc.key==='zd'">{{srvc.amount+' '}}Weekly</p>


                        <p class="col-sm-2 text-left" style="margin-top: 12px; " ng-if="srvc.key != 'zd'" >{{srvc.amount+' '}}<span ng-if="srvc.amount ===5||srvc.amount ===8">Weekly</span><span ng-if="srvc.amount != 5&& srvc.amount !=8">Daily</span></p>
                        <p class="col-sm-5">
                        <div class="col-sm-3" id="clndr_div" style="margin-top: 8px;">
                            <input type="text" name="dt_range"   class="clndr form-control"  id="{{srvc.key}}"  placeholder="Enter Date">
                        </div>
                        <div class="col-sm-2" style="margin-top: 12px;">
                            <button type="button" name="search" class=" btn btn-success" ng-click="ctrl.getChargingDetails(srvc.key)">Search</button>
                        </div>
                        </p>
                        <button type="button" class="vert-offset-top-2 btn btn-primary col-sm-2" ng-click="ctrl.showUnsubModal(srvc.key,ctrl.msisdn)" style="margin-top: 12px;">Unsub</button>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-sm-1"></div>

    </div>

    <div class="modal fade" tabindex="-1" id="unsubModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>-->
                </div>
                <div class="modal-body">
                    <h3>Are you sure you want to unsub from this service?</h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" ng-click="ctrl.unsubFromService()">Confirm</button>
                    <button type="button" class="btn btn-secondary" ng-click="ctrl.closeUnsubModal()">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="chargingDetails">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>-->
                </div>
                <div class="modal-body">
                    <h3>Charging Details</h3>
                    <h4>{{ctrl.msisdn}}</h4>
                    <p class="text-center">"The sum of total charged amount for this service is = <span>{{ctrl.total_charged}}</span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" ng-click="ctrl.closeChargingModal()">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>

</body>
<?php require_once('in_footer.php') ?>

<script type="text/javascript">

    $(document).ready(function () {

        setTimeout(function () {
            $('input[name="dt_range"]').daterangepicker(
                {
                    locale               : {
                        format: 'YYYY-MM-DD'
                    },
                    "alwaysShowCalendars": true
                }
            );
        }, 500);

    });

    window.onload = function() {
        setTimeout(function () {
            $('input[name="dt_range"]').daterangepicker(
                {
                    locale               : {
                        format: 'YYYY-MM-DD'
                    },
                    "alwaysShowCalendars": true
                }
            );
        }, 500);
    };

    function checkNumber(event) {

        var keyCode=event.keyCode;



        if(keyCode >= 48 && keyCode <= 57){
            return true;
        }
        return false;
    }

    function checkLen() {

        var msisdn=$('#msisdn').val();
        var len=msisdn.length;

        if(len === 11){
            document.getElementById("search_btn").disabled=false;
        }else{
            document.getElementById("search_btn").disabled=true;
        }
    }

    function clearSearchedArray() {
        var cellno=$('#msisdn').val();
        if(!cellno) {
            var ctrl=$('#myController').scope().ctrl.clearSearchValue();
        }
    }





</script>


</html>
