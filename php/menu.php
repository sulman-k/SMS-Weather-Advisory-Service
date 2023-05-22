<html lang="en">
<?php
require_once('in_header.php');


if (!isset($_SESSION['username'])) {
    header("Location: logout.php");
}

if (!in_array(validateUserRole($conn, $_SESSION['username']), $admin)) {
    header("Location: logout.php");
}
userLogActivity($conn, 'MENU BOX');
?>

<body ng-app="magriApp" ng-controller="magriCtrl" id="controler_id">
<div class="container">


    <div class=" row ">
        <div class="" ng-init="loadMenuBox()">
            <div class="col-sm-12">
                <div class="header-section text-center">
                    <h2>Main Menu</h2>
                </div>
            </div>
        </div>
    </div>

<!--    <div class="row vert-offset-top-1">-->
<!--        <div class="col-sm-11">-->
<!--            <div class="checkbox pull-right myMargin">-->
<!--                <a href="add_menu_box.php" id="saveBtn"-->
<!--                   class=" btn btn-success btn-sm pull-right mybtn"-->
<!--                   name="add">+ Add</a>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->

    <div class="row vert-offset-top-1">

        <div class="col-sm-1"></div>

        <div class="col-sm-10">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <tr>

                        <th width="50%">Title</th>
                        <th width="20%">Maximum Options</th>
                        <th width="30%" style="text-align: center">Action</th>

                    <tr ng-repeat="menuBox in menuBoxData">

                        <td>{{menuBox.title}}</td>
                        <td>{{menuBox.max_seg}}</td>
                        <td align="center" width="40%">

                            <span class="col-sm-4"></span>

                            <span class="col-sm-2">
                                <a href="">
                                    <span class="glyphicon glyphicon-eye-open"
                                          style="font-size:1.30em; color: #444; margin-left: 5px; margin-top: 5px"
                                          title="View Segments" ng-click="callMenuSegment(menuBox.id)"></span>
                                </a>
                            </span>

<!--                            <span class="col-sm-2">-->
<!--                                <a href="edit_menu_box.php?id={{menuBox.id}}">-->
<!--                                    <span class="glyphicon glyphicon-edit"-->
<!--                                          style="font-size:1.25em; color: #444;  margin-left: 5px; margin-top: 5px"-->
<!--                                          title="Edit">-->
<!--                                    </span>-->
<!--                                </a>-->
<!--                            </span>-->

                            <span ng-if="!menuBox.segment_available" class="col-sm-2">
                            <a href="">
                                    <span class="glyphicon glyphicon-remove"
                                          style="font-size:1.30em; color: #444; margin-left: 3px; margin-top: 4px"
                                          data-toggle="modal" data-target="#myModal" ng-click="deleteConfirm(menuBox.id)" title="Delete"></span>
                            </a>

                            </span>

                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <form id="menu_del_frm">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title" id="heading">Are You sure you want to delete ?</h4>
                        </div>
                        <input type="hidden" name="menu_del" id="menu_del" value="">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success btn-sm" id="save_vaccine">Confirm</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>

</body>

<?php require_once ('in_footer.php')?>


<script>
    $("#menu_del_frm").submit(function (e) {
        e.preventDefault();

        var formdata = new FormData(this);
        $.ajax({
            type       : "POST",
            url        : '../service/sr_deleteMenu.php',
            data       : formdata,
            dataType   : 'json',
            processData: false,
            contentType: false,
            cache      : false,
            success    : function (data) {
                if (data.success > 0) {
                    console.log('SUCESS: ' + JSON.stringify(data));
                    window.location = 'menu.php';

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
                            x: 15,
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

            },
            error      : function (data) {
                console.log('ERROR ERROR ERROR ERROR ERROR ERROR ' + JSON.stringify(data));
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
                        x: 15,
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

    });
</script>

</html>
