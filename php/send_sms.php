<html>
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
<body ng-app="magriApp"  id="controler_id">


<div ng-controller="newController as ctrl">
    <div class="container vert-offset-top-3" ng-init="ctrl.getSendSmsData()">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <form name="send_sms" id="send_sms" role="form" >
                    <h1 class="text-center">Send Sms</h1>
                    <div class="form-group vert-offset-top-2 ">
                        <div class="row">
                            <label for="cellno" class="col-sm-4">Cellno</label>
                            <div class="col-sm-8">
                                <input type="text" placeholder="Please enter cellno" name="cellno" id="cellno" class="form-control"  pattern= "\d{11}" maxlength="11" onblur="checkNumber()" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="cellno" class="col-sm-4">Text Sms</label>
                            <div class="col-sm-8">
                                <textarea  placeholder="Please enter message" id="text_box" name="msg" class="form-control" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="cellno" class="col-sm-4">Masking</label>
                            <div class="col-sm-8">
                                <select name="masking" id="mask" class="form-control" required>
                                    <option value="">Select a option for masking</option>
                                    <option ng-repeat="m in ctrl.masking_data" value="{{m.masking}}">{{m.masking}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-10"></div>
                            <div class="col-sm-2s">
                                <button type="submit" id="send_btn" class="btn btn-success float-rights">Send</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </div>
</div>
</body>
<?php require_once('in_footer.php') ?>
<script>

    function checkNumber() {
        var cellno=document.getElementById("cellno").value;
        //alert(cellno[0]);
        if(cellno[0]==0){
            document.getElementById("send_btn").disabled=false;
            return true
        }else{
            document.getElementById("send_btn").disabled=true;
            notifyError("Cellno should be start from 0","Warning","warning");
        }
    }

    $("#send_sms").submit(function (e) {
        e.preventDefault();
        var formData=new FormData(this);
        $.ajax({
            method:"POST",
            data:formData,
            url:'../service/sr_send_sms.php',
            dataType   : 'json',
            processData: false,
            contentType: false,
            cache      : false,
            success:function (data) {
            if(data.success > 0){
              notifyError(data.msg,"Success","success");
              window.location.reload();
            }else{
              notifyError(data.msg,"Warning","warning");
            }
            }
        });
    });
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
</script>
</html>
<?php
/**
 * Created by PhpStorm.
 * User: mm
 * Date: 1/16/2020
 * Time: 4:57 PM
 */