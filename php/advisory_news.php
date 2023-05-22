<html lang="en">

<?php
require_once('in_header.php');
require_once('in_footer.php');

if (!isset($_SESSION['username'])) {
    header("Location: logout.php");
}

if (!in_array(validateUserRole($conn, $_SESSION['username']), $ops)) {
    header("Location: logout.php");
}

userLogActivity($conn, 'ADD ADVISORY');

?>

<body ng-app="magriApp" ng-controller="magriCtrl" id="controler_id">

<div class="row vert-offset-top-3">

    <div class="col-sm-1"></div>
    <div class="col-sm-10" style="margin-left: -12px">
        <div class="col-sm-1">
            <button type="button" class="btn btn-success btn-sm pull-left" ng-click="openNewsPuSMS(2)">Advisory</button>
        </div>

        <div class="col-sm-1 pull-right">
            <button type="button" class="btn btn-success btn-sm pull-left" ng-click="openAdvisoryPuSMS()">+ Add New</button>
        </div>
    </div>
</div>
<div class="row vert-offset-top-1" >

<!--    --><?php
//    echo urldecode("%DB%8C%DA%AF%DA%AF%DA%AF%D8%AC%D8%AC%DB%8C%D8%AA%D8%B1%D8%B9%D8%B9%D8%AA%DB%81%D9%BE%D9%84");
//    ?>

    <div class="col-sm-1"></div>

    <div class="col-sm-10">


<!--        <div class="table-responsive">-->
<!--            <table class="table table-hover table-bordered" id="tbl">-->
<!--                <tr>-->
<!---->
<!--                    <th width="20%">Date</th>-->
<!--                    <th width="15%">Crops</th>-->
<!--                    <th width="65%">SMS Text</th>-->
<!---->
<!--                <tr ng-repeat="spa in sms_push_advisory">-->
<!---->
<!--                    <td>{{spa.dt_created}}</td>-->
<!--                    <td>{{spa.srvc_id | capitalizeWord}}</td>-->
<!--                    <td>-->
<!--                        <input type="hidden" name="ta" id="source_{{$index+1}}"-->
<!--                               value={{spa.sms_text}}>-->
<!--                        <textarea rows="3" class="form-control area_rtl" id="area_{{$index+1}}"-->
<!--                                  name="textarea"-->
<!--                                  readonly>-->
<!--                        </textarea>-->
<!--                    </td>-->
<!---->
<!--                </tr>-->
<!--            </table>-->
<!--        </div>-->
    </div>


</div>

</body>

<script>

    $(document).ready(function () {

        setTimeout(func, 100);
        var count = 1;

        function func() {
            count++;
            if ($("#source_1").val()) {

                var rowCount = $('#tbl tr').length;
                for (var i = 1; i < rowCount; i++) {
                    $("#area_" + i).html($("#source_" + i).val());
                }
            }
            else {
                if (count < 20) {
                    console.log(document.readyState);
                    setTimeout(func, 100);
                } else {
                   // window.location = 'report_weather.php';
                }
            }

        }
    }); //$("#loc_id").val()
</script>


</html>