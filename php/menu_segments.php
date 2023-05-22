<html lang="en">
<?php
require_once('in_header.php');

if (!isset($_SESSION['username'])) {
    header("Location: logout.php");
}

if (!in_array(validateUserRole($conn, $_SESSION['username']), $admin)) {
    header("Location: logout.php");
}

userLogActivity($conn, 'MENU SEGMENTS');

$id = isset($_GET['id']) ? $_GET['id'] : '';
$result='';
$title = '';
$sql="SELECT title from menu_box WHERE id = $id";
$result = $conn->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    $title = $row['title'];
}
?>


<style>
    .selected {
        background-color: #4ad1ff;  /*#5fcf80*/
    }
</style>

<body ng-app="magriApp" ng-controller="magriCtrl" id="controler_id">
<div class="container-fluid">

    <div class=" row">
        <div class="" ng-init="getMenuSegments('<?php echo $id ?>')">
            <div class="col-sm-12">
                <div class="header-section text-center">
                    <h2><?php echo $title ?></h2>
                </div>
            </div>
        </div>
    </div>


    <div class=" vert-offset-top-2">
        <div class="checkbox pull-right myMargin">
<!--            <label>-->
<!--                <input type="checkbox" data-onstyle="bg" name="scroll" id="scroll" data-toggle="toggle"-->
<!--                       data-on="Scroll On" data-off="Scroll Off" data-size="small">-->
<!--            </label>-->
<!--            <a href="add_segment.php?menu_id=--><?php //echo $id ?><!--" id="saveBtn" class=" btn btn-success btn-sm pull-right mybtn"-->
<!--               name="Save"-->
<!--               style="margin-right: 15px">+ Add</a>-->
        </div>
    </div>

    <form id="frm_menu_seg" >
        <div class="vert-offset-top-2" >
            <div class="col-sm-12" style="margin-top: 10px">

                <div class="table-responsive myMargin">
                    <table id="data" class="table  table-bordered" ng-keydown="key($event)">
                        <tr>

                            <th width="0%">Title</th>

                            <th width="0%">Segment Type</th>
<!--                            <th width="0%">Segment Context</th>-->
                            <th width="0%">File 1</th>
                            <th width="0%">File 2</th>
                            <th width="0%">File 3</th>
                            <th width="0%">File 4</th>
                            <th width="0%">File 5</th>
                            <th width="0%">File 6</th>
                            <th width="0%">File 7</th>
                            <th width="0%">File 8</th>
                            <th width="0%">File 9</th>
                            <th width="0%" style="text-align: center">Action</th>

                        <tr ng-repeat="menuSeg in menuSegData" ng-class="{'selected':$index == selectedRow}"
                            ng-click="setClickedRow($index)" id="{{menuSeg.id}}">

                            <input type="hidden" id="hid_{{$index}}" value="{{menuSeg.seg_order}}"
                                   name="{{menuSeg.id}}">

                            <td>{{menuSeg.title}}</td>
                            <td>{{menuSeg.seg_type}}</td>
<!--                            <td>{{menuSeg.context}}</td>-->
                            <td>
                                <audio controls id="complain_{{recording.id}}" class="audio" style="width: 100%">
                                    <source src="{{menuSeg.seg_file_1}}" type="audio/ogg">
                                    <source src="{{menuSeg.seg_file_1}}" type="audio/mpeg">
                                    Your browser does not support the audio tag.
                                </audio>
                            </td>
                            <td>
                                <audio controls id="complain_{{recording.id}}" class="audio" style="width: 100%">
                                    <source src="{{menuSeg.seg_file_2}}" type="audio/ogg">
                                    <source src="{{menuSeg.seg_file_2}}" type="audio/mpeg">
                                    Your browser does not support the audio tag.
                                </audio>
                            </td>
                            <td>
                                <audio controls id="complain_{{recording.id}}" class="audio" style="width: 100%">
                                    <source src="{{menuSeg.seg_file_3}}" type="audio/ogg">
                                    <source src="{{menuSeg.seg_file_3}}" type="audio/mpeg">
                                    Your browser does not support the audio tag.
                                </audio>
                            </td>
                            <td>
                                <audio controls id="complain_{{recording.id}}" class="audio" style="width: 100%">
                                    <source src="{{menuSeg.seg_file_4}}" type="audio/ogg">
                                    <source src="{{menuSeg.seg_file_4}}" type="audio/mpeg">
                                    Your browser does not support the audio tag.
                                </audio>
                            </td>
                            <td>
                                <audio controls id="complain_{{recording.id}}" class="audio" style="width: 100%">
                                    <source src="{{menuSeg.seg_file_5}}" type="audio/ogg">
                                    <source src="{{menuSeg.seg_file_5}}" type="audio/mpeg">
                                    Your browser does not support the audio tag.
                                </audio>
                            </td>
                            <td>
                                <audio controls id="complain_{{recording.id}}" class="audio" style="width: 100%">
                                    <source src="{{menuSeg.seg_file_6}}" type="audio/ogg">
                                    <source src="{{menuSeg.seg_file_6}}" type="audio/mpeg">
                                    Your browser does not support the audio tag.
                                </audio>
                            </td>
                            <td>
                                <audio controls id="complain_{{recording.id}}" class="audio" style="width: 100%">
                                    <source src="{{menuSeg.seg_file_7}}" type="audio/ogg">
                                    <source src="{{menuSeg.seg_file_7}}" type="audio/mpeg">
                                    Your browser does not support the audio tag.
                                </audio>
                            </td>
                            <td>
                                <audio controls id="complain_{{recording.id}}" class="audio" style="width: 100%">
                                    <source src="{{menuSeg.seg_file_8}}" type="audio/ogg">
                                    <source src="{{menuSeg.seg_file_8}}" type="audio/mpeg">
                                    Your browser does not support the audio tag.
                                </audio>
                            </td>
                            <td>
                                <audio controls id="complain_{{recording.id}}" class="audio" style="width: 100%">
                                    <source src="{{menuSeg.seg_file_9}}" type="audio/ogg">
                                    <source src="{{menuSeg.seg_file_9}}" type="audio/mpeg">
                                    Your browser does not support the audio tag.
                                </audio>
                            </td>
                            <td align="center">

<!--                                <a target="_blank" href="">-->
<!--                                    <span class="glyphicon glyphicon-eye-open"-->
<!--                                          ng-click="loadViewPage(menuSeg.seg_type)"-->
<!--                                          style="font-size:1.5em; color: #444;" title="View/add Content">-->
<!---->
<!--                                    </span>-->
<!--                                </a>-->

                                <a target="_blank" href="">
                                    <span class="glyphicon glyphicon-edit"
                                          ng-click="loadEditPage(menuSeg.id, '<?php echo $id ?>')"
                                          style="font-size:1.5em; color: #444; margin-left: 10px" title="Edit Segment">

                                    </span>
                                </a>

<!--                                <a target="_blank" href="" >-->
<!--                                    <span class="glyphicon glyphicon-remove"-->
<!--                                          style="font-size:1.30em; color: #444; margin-left: 5px; margin-top: 5px"-->
<!--                                          data-btn-ok-class="btn-xs btn-success" data-toggle="confirmation" data-id="{{menuSeg.id}}" data-menu-id="--><?php //echo $id ?><!--" data-placement="top" title="Delete"></span>-->
<!--                                </a>-->

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

        </div>
        <div class=" vert-offset-top-1 myMargin">

            <div class="col-sm-12">
                <a href="#" ng-click="moveDown(selectedRow)" class="pull-left"> <span class="glyphicon glyphicon-chevron-down"
                                                                    style="font-size:1.5em; margin-left: 5px"></span></a>
                <a href="#" ng-click="moveUp(selectedRow)" class="pull-left"><span class="glyphicon glyphicon-chevron-up"
                                                                 style="font-size:1.5em;  margin-left: 5px"> </span></a>

                <button type="submit" class="btn pull-right">Save</button>

                <a href="menu.php" class="btn btn-default btn-sm pull-right " style="margin-right: 10px; width: 70px">Cancel</a>

            </div>
        </div>
    </form>
</div>

</body>

<?php require_once ('in_footer.php')?>

<script>

    function goDel(id){
        var scope = angular.element($("#controler_id")).scope();
        scope.deleteSegment(id, <?php echo $id ?>);
        scope.selectedRow = null;
    }
    document.addEventListener('play', function (e) {
        var audios = document.getElementsByTagName('audio');
        for (var i = 0, len = audios.length; i < len; i++) {
            if (audios[i] != e.target) {
                audios[i].pause();
            }
        }
    }, true);
</script>

<script>

    $("#scroll").change(function (e) {
        if ($(this).is(":checked")) {
            $(".audio").css({"width": ""});
        } else {
            $(".audio").css({"width": "100%"});
        }
    });

</script>

<script>

    $("#frm_menu_seg").submit(function (e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.

        var rows      = [];
        var new_order = [];
        $('#data tr').not(':first').each(function () {
            rows.push(this.id);
        });

        var id = 0;
        for (var i = 0; i < rows.length; i++) {
            id = rows[i];
            new_order.push(id + "_" + $('[name=' + rows[i] + ']').val());
        }

        var formdata = new FormData(this);
        formdata.append('new_order', new_order);

        $.ajax({
            type       : "POST",
            url        : '../service/sr_saveSegmentsOrder.php',
            data       : formdata,
            dataType   : 'json',
            processData: false,
            contentType: false,
            cache      : false,
            success    : function (data) {
                if (data.success > 0) {
                    console.log('SUCESS: ' + JSON.stringify(data));
                    // window.location = 'menu_segments.php?id=<?php echo $id ?>';

                    var scope = angular.element($("#controler_id")).scope();
                    scope.getMenuSegments(<?php echo $id ?>);
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
                } else {

                    $.notify({
                        title  : '<strong>Success!</strong>',
                        message: data.msg
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

            },
            error      : function (data) {
                console.log(data);
            }
        });

    });


</script>

</html>
