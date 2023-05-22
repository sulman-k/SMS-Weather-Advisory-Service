<html lang="en">
<?php
require_once('in_header.php');

$seg_type = isset($_GET['seg_type']) ? $_GET['seg_type'] : '';


if (!in_array(validateUserRole($conn, $_SESSION['username']), $admin)) {
    header("Location: logout.php");
}

userLogActivity($conn, 'SEGMENTS');

?>

<body ng-app="magriApp" ng-controller="magriCtrl" id="controler_id">
<div class="container" ng-init="seg_type='<?php echo $seg_type ?>'">


    <div class=" row vert-offset-top-5">
        <div class="" ng-init="getContent(seg_type)">
            <div class="col-sm-12">
                <div class="header-section text-center">
                    <h2>Content</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row vert-offset-top-1">
        <div class="col-sm-11">
            <div class="checkbox pull-right myMargin">
                <a href="content_upload.php?seg_type={{seg_type}}" id="saveBtn"
                   class=" btn btn-success btn-sm pull-right mybtn"
                   name="add" style="margin-right: -20px">+ Add</a>
            </div>
        </div>
    </div>

    <div class="row vert-offset-top-1">

        <div class="col-sm-1"></div>

        <div class="col-sm-10" >
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <tr>

                        <th width="20%">Title</th>
                        <th width="40%">Content File</th>
                        <th width="20%">Date</th>
                        <th width="10%" style="text-align: center">Status</th>
                        <th width="10%" style="text-align: center">Edit</th>


                    <tr ng-repeat="content in contents">

                        <td>{{content.title}}</td>

                        <td style="text-align: center">
                            <audio controls id="file_wav" class="audio" style="width: 100%">
                                <source src="{{content.file_name}}" type="audio/ogg">
                                <source src="{{content.file_name}}" type="audio/mpeg">
                                Your browser does not support the audio tag.
                            </audio>

                        </td>
                        <td>{{content.dt}}</td>
                        <td style="text-align: center; vertical-align: middle">
                            <div ng-if="content.status == 100">
                                 <span class="glyphicon glyphicon-ok" style="font-size:1.3em; color: #5fcf80"
                                       title="Active"></span>
                            </div>
                            <div ng-if="content.status != 100">
                                <span class="glyphicon glyphicon-ok" style="font-size:1.3em; color: #e6e6e6"
                                      title="Disabled"></span>
                            </div>
                        </td>

                        <td style="text-align: center; vertical-align: middle">
                            <a href="content_update.php?seg_type={{seg_type}}&id={{content.id}}" ><span class="glyphicon glyphicon-edit" style="font-size:1.5em; color: #333"
                                                                                  title="Edit Record"></span></a>
                        </td>
                    </tr>
                </table>
            </div>
            <a href="<?php echo basename($_SERVER["HTTP_REFERER"]) ?>" class="btn btn-default btn-sm pull-right mybtn">Cancel</a>
        </div>

    </div>
</div>
<?php
require_once('in_footer.php');
?>
</body>

<script>
    $(document).ready(function () {
        $.validate({
            modules: 'security'//,disabledFormFilter: 'form.editForm'
        });
    });

</script>



</html>
