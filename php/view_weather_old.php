<!DOCTYPE html>
<html lang="en">
<?php
require_once('in_header.php');

?>


<body ng-app="magriApp" ng-controller="magriCtrl" id="controler_id">
<div class="container-fluid">

    <?php

    if (!in_array(validateUserRole($conn, $_SESSION['username']), $admin_content)) {
        header("Location: logout.php");
    }
    userLogActivity($conn, 'VIEW WEATHER');
    ?>

    <ul class="nav nav-tabs" ng-init="loadLocations()">
        <li class="active"><a data-toggle="tab" href="#missouri" ng-click="reloadViewWeather()">missouri</a></li>
        <li><a data-toggle="tab" href="#kansas">kansas</a></li>
        <li><a data-toggle="tab" href="#florida">florida</a></li>
        <li><a data-toggle="tab" href="#hawaii">hawaii</a></li>
    </ul>

    <div class="tab-content vert-offset-top-4">

        <div id="missouri" class="tab-pane fade in active">
            <div class="row">

                <div class="row container-fluid">
                    <div class="col-sm-1 form-group">
                    </div>
                    <div class="col-sm-2 form-group">
                        <div class="">
                            <input type="text" id="datepicker" name="magri_date" class="form-control" value=""/>
                        </div>
                    </div>
                    <div class="col-sm-2 form-group">
                        <div class="">
                            <select id="loc_id_missouri" name="location" class="form-control" data-validation="required"
                                    ng-model="location"
                                    data-validation-error-msg="Select Location"
                                    ng-change="getViewEditWeather('missouri')">
                                <option value="">Select Location</option>
                                <option value="{{loc.id}}" ng-repeat="loc in pu_locations ">{{loc.id |
                                    capitalizeWord}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-1 form-group">
                        <div>
                            <button ng-click="getViewEditWeather('missouri')" class="btn pull-right">Submit</button>
                        </div>
                    </div>
                    <div class="col-sm-4 form-group no_display" id="sms_box_missouri">
                        <label class="" for="pass">SMS Text</label>
                        <div class="">
                            <div>
                            <textarea rows="6" class="form-control" id="textarea_id" name="textarea" type="textarea"
                                      readonly></textarea>
                                <input type="hidden" name="record" id="record_id" value=""> </input>
                                <input type="hidden" name="files" id="files_id" value=""> </input>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                    </div>
                    <div class="no_display">
                        <div id="audio_div_1" class="col-sm-2 ">
                            <audio controls id="audio_1" src="{{a}}">
                                <source type="audio/ogg">
                                Your browser does not support the audio element.
                            </audio>
                        </div>

                        <div id="audio_div_2" class="col-sm-2">
                            <audio controls id="audio_2" src="{{b}}">
                                <source type="audio/ogg">
                                Your browser does not support the audio element.
                            </audio>
                        </div>


                        <div id="audio_div_3" class="col-sm-2">
                            <audio controls id="audio_3" src="{{c}}">
                                <source type="audio/ogg">
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                    </div>
                    <div class="row container-fluid">
                        <div class="col-sm-4 form-group no_display" id="file_box_missouri">
                            <div id="tick" class="pull-right"></div>
                            <label class="" for="pass">OBD Files</label>
                            <table class="table">
                                <div>
                                    <tr>
                                        <td width="40%">eng Language</td>
                                        <td width="20"><a href="#">
                                                <div class="audio_img player_play" id="play_1"></div>
                                            </a></td>
                                        <td width="20"><a href="#">
                                                <div class="audio_img player_stop" id="stop_1"></div>
                                            </a></td>
                                    </tr>
                                </div>
                                <div>
                                    <tr>
                                        <td width="40%">frenchLanguage</td>
                                        <td width="20"><a href="#">
                                                <div class="audio_img player_play" id="play_2"></div>
                                            </a></td>
                                        <td width="20"><a href="#">
                                                <div class="audio_img player_stop" id="stop_2"></div>
                                            </a></td>
                                    </tr>
                                </div>
                                <div>
                                    <tr>
                                        <td width="40%">german Language</td>
                                        <td width="20"><a href="#">
                                                <div class="audio_img player_play" id="play_3"></div>
                                            </a></td>
                                        <td width="20"><a href="#">
                                                <div class="audio_img player_stop" id="stop_3"></div>
                                            </a></td>
                                    </tr>
                                </div>

                            </table>

                        </div>
                    </div>
                </div>
                <div class="row container-fluid no_display" id="edit_box_missouri">
                    <div class="col-sm-10 ">
                        <button ng-click="editRecord(view_record_id, 'missouri')" id="edit_btn_missouri"
                                class="btn pull-right">Edit
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="gb" class="tab-pane fade">
            <div class="row">


                <div class="row container-fluid">
                    <div class="col-sm-1 form-group">
                    </div>
                    <div class="col-sm-2 form-group">
                        <div class="">
                            <input type="text" id="datepicker_gb" name="magri_date_gb" class="form-control" value=""/>
                        </div>
                    </div>
                    <div class="col-sm-2 form-group">
                        <div class="">
                            <select id="loc_id_gb" name="location_gb" class="form-control" data-validation="required"
                                    data-validation-error-msg="Select Location" ng-model="location_gb"
                                    ng-change="getViewEditWeather('gb')">
                                <option value="">Select Location</option>
                                <option value="{{loc.id}}" ng-repeat="loc in kansas_locations">{{loc.id | capitalizeWord}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-1 form-group">
                        <div>
                            <button ng-click="getViewEditWeather('gb')" class="btn pull-right">Submit</button>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="no_display">
                            <div id="audio_div_4">
                                <audio controls id="audio_4" src="{{d}}">
                                    <source type="audio/ogg">
                                    Your browser does not support the audio element.
                                </audio>
                            </div>

                            <div id="audio_div_5">
                                <audio controls id="audio_5" src="{{e}}">
                                    <source type="audio/ogg">
                                    Your browser does not support the audio element.
                                </audio>
                            </div>
                        </div>
                        <div class="col-sm-1"></div>

                        <div class="col-sm-10 form-group no_display" id="sms_box_gb">
                            <h2>Morning</h2>
                            <div class="">
                                <div>
                            <textarea rows="6" class="form-control area_rtl" id="textarea_id_gb" name="textarea_gb"
                                      type="textarea"
                                      readonly></textarea>
                                    <input type="hidden" name="record" id="record_id_gb" value=""> </input>
                                    <input type="hidden" name="files" id="files_id_gb" value=""> </input>
                                </div>
                            </div>
                            <br>
                            <div class="form-group no_display" id="file_box_gb">
                                <div id="tick" class="pull-right"></div>

                                <table class="table">
                                    <div>
                                        <tr>
                                            <td width="40%">OBD Files</td>
                                            <td width="20"><a href="#">
                                                    <div class="audio_img player_play" id="play_4"></div>
                                                </a></td>
                                            <td width="20"><a href="#">
                                                    <div class="audio_img player_stop" id="stop_4"></div>
                                                </a></td>
                                        </tr>
                                    </div>

                                </table>

                            </div>
                        </div>

                    </div>
                    <div class="col-sm-6">

                        <div class="col-sm-1"></div>

                        <div class="col-sm-10 form-group no_display" id="eve_sms_box">
                            <h2>Evening </h2>
                            <div class="">
                                <div>
                            <textarea rows="6" class="form-control area_rtl" id="eve_textarea_id" name="textarea"
                                      type="textarea"
                                      readonly></textarea>
                                    <input type="hidden" name="record" id="record_id" value=""> </input>
                                    <input type="hidden" name="files" id="files_id" value=""> </input>
                                </div>
                            </div>
                            <br>
                            <div class="form-group no_display" id="eve_file_box">
                                <div id="tick" class="pull-right"></div>

                                <table class="table">
                                    <div>
                                        <tr>
                                            <td width="40%">OBD Files</td>
                                            <td width="20"><a href="#">
                                                    <div class="audio_img player_play" id="play_5"></div>
                                                </a></td>
                                            <td width="20"><a href="#">
                                                    <div class="audio_img player_stop" id="stop_5"></div>
                                                </a>
                                            </td>
                                        </tr>
                                    </div>

                                </table>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="row no_display" id="edit_box_gb">
                    <div class="col-sm-11 form-group ">
                        <button ng-click="editRecord(view_record_id, 'gb')" id="edit_btn_gb" class="btn pull-right">
                            Edit
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <div id="florida" class="tab-pane fade">
            <div class="row">

                <div class="row container-fluid">
                    <div class="col-sm-1 form-group">
                    </div>
                    <div class="col-sm-2 form-group">
                        <div class="">
                            <input type="text" id="datepicker_florida" name="magri_date_florida" class="form-control"
                                   value=""/>
                        </div>
                    </div>
                    <div class="col-sm-2 form-group">
                        <div class="">
                            <select id="loc_id_florida" name="location_florida" class="form-control"
                                    data-validation="required" ng-model="location_florida"
                                    data-validation-error-msg="Select Location" ng-change="getViewEditWeather('florida')">
                                <option value="">Select Location</option>
                                <option value="{{loc.id}}" ng-repeat="loc in florida_locations ">{{loc.id |
                                    capitalizeWord}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-1 form-group">
                        <div>
                            <button ng-click="getViewEditWeather('florida')" class="btn pull-right">Submit</button>
                        </div>
                    </div>
                    <div class="col-sm-4 form-group no_display" id="sms_box_florida">
                        <label class="" for="pass">SMS Text</label>
                        <div class="">
                            <div>
                            <textarea rows="6" class="form-control" id="textarea_id_florida" name="textarea"
                                      type="textarea"
                                      readonly></textarea>
                                <input type="hidden" name="record" id="record_id" value=""> </input>
                                <input type="hidden" name="files" id="files_id" value=""> </input>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                    </div>
                    <div class="no_display">
                        <div id="audio_div_10" class="col-sm-2 ">
                            <audio controls id="audio_10" src="{{s}}">
                                <source type="audio/ogg">
                                Your browser does not support the audio element.
                            </audio>
                        </div>

                        <!--                        <div id="audio_div_2" class="col-sm-2">-->
                        <!--                            <audio controls id="audio_2" src="{{b}}">-->
                        <!--                                <source type="audio/ogg">-->
                        <!--                                Your browser does not support the audio element.-->
                        <!--                            </audio>-->
                        <!--                        </div>-->
                        <!---->
                        <!---->
                        <!--                        <div id="audio_div_3" class="col-sm-2">-->
                        <!--                            <audio controls id="audio_3" src="{{c}}">-->
                        <!--                                <source type="audio/ogg">-->
                        <!--                                Your browser does not support the audio element.-->
                        <!--                            </audio>-->
                        <!--                        </div>-->
                    </div>
                    <div class="row container-fluid">
                        <div class="col-sm-4 form-group no_display" id="file_box_florida">
                            <div id="tick" class="pull-right"></div>
                            <label class="" for="pass">OBD Files</label>
                            <table class="table">
                                <div>
                                    <tr>
                                        <td width="40%">eng Language</td>
                                        <td width="20"><a href="#">
                                                <div class="audio_img player_play" id="play_10"></div>
                                            </a></td>
                                        <td width="20"><a href="#">
                                                <div class="audio_img player_stop" id="stop_10"></div>
                                            </a></td>
                                    </tr>
                                </div>

                                <!--                                <div>-->
                                <!--                                    <tr>-->
                                <!--                                        <td width="40%">frenchLanguage</td>-->
                                <!--                                        <td width="20"><a href="#">-->
                                <!--                                                <div class="audio_img player_play" id="play_2"></div>-->
                                <!--                                            </a></td>-->
                                <!--                                        <td width="20"><a href="#">-->
                                <!--                                                <div class="audio_img player_stop" id="stop_2"></div>-->
                                <!--                                            </a></td>-->
                                <!--                                    </tr>-->
                                <!--                                </div>-->
                                <!--                                <div>-->
                                <!--                                    <tr>-->
                                <!--                                        <td width="40%">german Language</td>-->
                                <!--                                        <td width="20"><a href="#">-->
                                <!--                                                <div class="audio_img player_play" id="play_3"></div>-->
                                <!--                                            </a></td>-->
                                <!--                                        <td width="20"><a href="#">-->
                                <!--                                                <div class="audio_img player_stop" id="stop_3"></div>-->
                                <!--                                            </a></td>-->
                                <!--                                    </tr>-->
                                <!--                                </div>-->

                            </table>

                        </div>
                    </div>
                </div>
                <div class="row container-fluid no_display" id="edit_box_florida">
                    <div class="col-sm-10 ">
                        <button ng-click="editRecord(view_record_id, 'florida')" id="edit_btn_florida"
                                class="btn pull-right">Edit
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="hawaii" class="tab-pane fade">
            <div class="row">

                <div class="row container-fluid">
                    <div class="col-sm-1 form-group">
                    </div>
                    <div class="col-sm-2 form-group">
                        <div class="">
                            <input type="text" id="datepicker_hawaii" name="magri_date_hawaii" class="form-control" value=""/>
                        </div>
                    </div>
                    <div class="col-sm-2 form-group">
                        <div class="">
                            <select id="loc_id_hawaii" name="location_hawaii" class="form-control" data-validation="required"
                                    ng-model="location_hawaii"
                                    data-validation-error-msg="Select Location" ng-change="getViewEditWeather('hawaii')">
                                <option value="">Select Location</option>
                                <option value="{{loc.id}}" ng-repeat="loc in hawaii_locations ">{{loc.id |
                                    capitalizeWord}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-1 form-group">
                        <div>
                            <button ng-click="getViewEditWeather('hawaii')" class="btn pull-right">Submit</button>
                        </div>
                    </div>
                    <div class="col-sm-4 form-group no_display" id="sms_box_hawaii">
                        <label class="" for="pass">SMS Text</label>
                        <div class="">
                            <div>
                            <textarea rows="6" class="form-control" id="textarea_id_hawaii" name="textarea" type="textarea"
                                      readonly></textarea>
                                <input type="hidden" name="record" id="record_id" value=""> </input>
                                <input type="hidden" name="files" id="files_id" value=""> </input>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                    </div>
                    <div class="no_display">
                        <div id="audio_div_20" class="col-sm-2 ">
                            <audio controls id="audio_20" src="{{k}}">
                                <source type="audio/ogg">
                                Your browser does not support the audio element.
                            </audio>
                        </div>

                        <!--                        <div id="audio_div_2" class="col-sm-2">-->
                        <!--                            <audio controls id="audio_2" src="{{b}}">-->
                        <!--                                <source type="audio/ogg">-->
                        <!--                                Your browser does not support the audio element.-->
                        <!--                            </audio>-->
                        <!--                        </div>-->
                        <!---->
                        <!---->
                        <!--                        <div id="audio_div_3" class="col-sm-2">-->
                        <!--                            <audio controls id="audio_3" src="{{c}}">-->
                        <!--                                <source type="audio/ogg">-->
                        <!--                                Your browser does not support the audio element.-->
                        <!--                            </audio>-->
                        <!--                        </div>-->
                    </div>
                    <div class="row container-fluid">
                        <div class="col-sm-4 form-group no_display" id="file_box_hawaii">
                            <div id="tick" class="pull-right"></div>
                            <label class="" for="pass">OBD Files</label>
                            <table class="table">
                                <div>
                                    <tr>
                                        <td width="40%">eng Language</td>
                                        <td width="20"><a href="#">
                                                <div class="audio_img player_play" id="play_20"></div>
                                            </a></td>
                                        <td width="20"><a href="#">
                                                <div class="audio_img player_stop" id="stop_20"></div>
                                            </a></td>
                                    </tr>
                                </div>

                                <!--                                <div>-->
                                <!--                                    <tr>-->
                                <!--                                        <td width="40%">frenchLanguage</td>-->
                                <!--                                        <td width="20"><a href="#">-->
                                <!--                                                <div class="audio_img player_play" id="play_2"></div>-->
                                <!--                                            </a></td>-->
                                <!--                                        <td width="20"><a href="#">-->
                                <!--                                                <div class="audio_img player_stop" id="stop_2"></div>-->
                                <!--                                            </a></td>-->
                                <!--                                    </tr>-->
                                <!--                                </div>-->
                                <!--                                <div>-->
                                <!--                                    <tr>-->
                                <!--                                        <td width="40%">german Language</td>-->
                                <!--                                        <td width="20"><a href="#">-->
                                <!--                                                <div class="audio_img player_play" id="play_3"></div>-->
                                <!--                                            </a></td>-->
                                <!--                                        <td width="20"><a href="#">-->
                                <!--                                                <div class="audio_img player_stop" id="stop_3"></div>-->
                                <!--                                            </a></td>-->
                                <!--                                    </tr>-->
                                <!--                                </div>-->

                            </table>

                        </div>
                    </div>
                </div>
                <div class="row container-fluid no_display" id="edit_box_hawaii">
                    <div class="col-sm-10 ">
                        <button ng-click="editRecord(view_record_id, 'hawaii')" id="edit_btn_hawaii" class="btn pull-right">
                            Edit
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php require_once('in_footer.php') ?>
</body>

<script type="text/javascript">
    $(function () {
        $('input[name="magri_date"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns   : true
        });
        $('input[name="magri_date_gb"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns   : true
        });
        $('input[name="magri_date_florida"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns   : true
        });
        $('input[name="magri_date_hawaii"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns   : true
        });
    });
</script>
<script>
    $(document).ready(function () {
        $.validate({
            modules: 'security'//,disabledFormFilter: 'form.editForm'
        });
    });

</script>


<script>

    var number = 0;
    var play_count = 0;

    $(document).ready(function () {

        $(".audio_img").on('click', function () {
            number = this.id.split("_");
            number = number[1];

            play_count++;

            if (play_count % 2 == 1) {
                $('#play_' + number).removeClass("player_play");
                $('#play_' + number).addClass("player_pause");
                document.getElementById('audio_' + number).play();
            } else {
                $('#play_' + number).removeClass("player_pause");
                $('#play_' + number).addClass("player_play");
                document.getElementById('audio_' + number).pause();
            }
        });


        $("#stop_1").on('click', function () {
            var scope  = angular.element("#controler_id").scope();
            var files  = scope.files_1;
            play_count = 0;
            $('#play_1').removeClass("player_pause");
            $('#play_1').addClass("player_play");
            document.getElementById('audio_1').pause();
            count = 0;
            $("#audio_1").attr("src", files[count]);
            document.getElementById('audio_1').pause();
        });

        $("#stop_2").on('click', function () {
            var scope  = angular.element("#controler_id").scope();
            var files  = scope.files_2;
            play_count = 0;
            $('#play_2').removeClass("player_pause");
            $('#play_2').addClass("player_play");
            document.getElementById('audio_2').pause();
            count = 0;
            $("#audio_2").attr("src", files[count]);
            document.getElementById('audio_2').pause();
        });

        $("#stop_3").on('click', function () {
            var scope  = angular.element("#controler_id").scope();
            var files  = scope.files_3;
            play_count = 0;
            $('#play_3').removeClass("player_pause");
            $('#play_3').addClass("player_play");
            document.getElementById('audio_3').pause();
            count = 0;
            $("#audio_3").attr("src", files[count]);
            document.getElementById('audio_3').pause();
        });

        // ############# GB ###########################

        $("#stop_4").on('click', function () {
            var scope  = angular.element("#controler_id").scope();
            var files  = scope.files_4;
            play_count = 0;
            $('#play_4').removeClass("player_pause");
            $('#play_4').addClass("player_play");
            document.getElementById('audio_4').pause();
            count = 0;
            $("#audio_4").attr("src", files[count]);
            document.getElementById('audio_4').pause();
        });

        $("#stop_5").on('click', function () {
            var scope  = angular.element("#controler_id").scope();
            var files  = scope.files_5;
            play_count = 0;
            $('#play_5').removeClass("player_pause");
            $('#play_5').addClass("player_play");
            document.getElementById('audio_5').pause();
            count = 0;
            $("#audio_5").attr("src", files[count]);
            document.getElementById('audio_5').pause();
        });

        //################# florida #########################

        $("#stop_10").on('click', function () {
            var scope  = angular.element("#controler_id").scope();
            var files  = scope.files_10;
            play_count = 0;
            $('#play_10').removeClass("player_pause");
            $('#play_10').addClass("player_play");
            document.getElementById('audio_10').pause();
            count = 0;
            $("#audio_10").attr("src", files[count]);
            document.getElementById('audio_10').pause();
        });

        //################# hawaii #########################

        $("#stop_20").on('click', function () {
            var scope  = angular.element("#controler_id").scope();
            var files  = scope.files_20;
            play_count = 0;
            $('#play_20').removeClass("player_pause");
            $('#play_20').addClass("player_play");
            document.getElementById('audio_20').pause();
            count = 0;
            $("#audio_20").attr("src", files[count]);
            document.getElementById('audio_20').pause();
        });

    });
</script>
<script type="text/javascript">
    var count = 0;

    document.getElementById('audio_1').addEventListener("ended", function () {
        var scope = angular.element("#controler_id").scope();
        var files = scope.files_1;
        count++;

        if (count < files.length) {

            var url = files[count];
            console.log(url);
            $("#audio_1").attr("src", url);
            $("#audio_1").attr("autoplay", true);
            $("#audio_1").load();
            $("#audio_1").get(0).play();
        } else {
            count   = 0;
            var url = files[count];
            console.log(url);
            $("#audio_1").attr("src", url);
            $("#audio_1").attr("autoplay", false);
            $('#play_1').removeClass("player_pause");
            $('#play_1').addClass("player_play");
            play_count = 0;

        }
    });

    document.getElementById('audio_2').addEventListener("ended", function () {
        var scope = angular.element("#controler_id").scope();
        var files = scope.files_2;
        count++;

        if (count < files.length) {

            var url = files[count];
            console.log(url);
            $("#audio_2").attr("src", url);
            $("#audio_2").attr("autoplay", true);
            $("#audio_2").load();
            $("#audio_2").get(0).play();
        } else {
            count   = 0;
            var url = files[count];
            console.log(url);
            $("#audio_2").attr("src", url);
            $("#audio_2").attr("autoplay", false);
            $('#play_2').removeClass("player_pause");
            $('#play_2').addClass("player_play");
            play_count = 0;

        }
    });


    document.getElementById('audio_3').addEventListener("ended", function () {
        var scope = angular.element("#controler_id").scope();
        var files = scope.files_3;
        count++;

        if (count < files.length) {

            var url = files[count];
            console.log(url);
            $("#audio_3").attr("src", url);
            $("#audio_3").attr("autoplay", true);
            $("#audio_3").load();
            $("#audio_3").get(0).play();
        } else {
            count   = 0;
            var url = files[count];
            console.log(url);
            $("#audio_3").attr("src", url);
            $("#audio_3").attr("autoplay", false);
            $('#play_3').removeClass("player_pause");
            $('#play_3').addClass("player_play");
            play_count = 0;

        }
    });

    document.getElementById('audio_4').addEventListener("ended", function () {
        var scope = angular.element("#controler_id").scope();
        var files = scope.files_4;
        count++;

        //alert(count);
        if (count < files.length) {

            var url = files[count];
            console.log(url);
            $("#audio_4").attr("src", url);
            $("#audio_4").attr("autoplay", true);
            $("#audio_4").load();
            $("#audio_4").get(0).play();
        } else {
            count   = 0;
            var url = files[count];
            console.log(url);
            $("#audio_4").attr("src", url);
            $("#audio_4").attr("autoplay", false);
            $('#play_4').removeClass("player_pause");
            $('#play_4').addClass("player_play");
            play_count = 0;

        }
    });

    document.getElementById('audio_5').addEventListener("ended", function () {
        var scope = angular.element("#controler_id").scope();
        var files = scope.files_5;
        count++;

        if (count < files.length) {

            var url = files[count];
            console.log(url);
            $("#audio_5").attr("src", url);
            $("#audio_5").attr("autoplay", true);
            $("#audio_5").load();
            $("#audio_5").get(0).play();
        } else {
            count   = 0;
            var url = files[count];
            console.log(url);
            $("#audio_5").attr("src", url);
            $("#audio_5").attr("autoplay", false);
            $('#play_5').removeClass("player_pause");
            $('#play_5').addClass("player_play");
            play_count = 0;

        }
    });

    //################# florida #######################

    document.getElementById('audio_10').addEventListener("ended", function () {
        var scope = angular.element("#controler_id").scope();
        var files = scope.files_10;
        count++;

        if (count < files.length) {

            var url = files[count];
            console.log(url);
            $("#audio_10").attr("src", url);
            $("#audio_10").attr("autoplay", true);
            $("#audio_10").load();
            $("#audio_10").get(0).play();
        } else {
            count   = 0;
            var url = files[count];
            console.log(url);
            $("#audio_10").attr("src", url);
            $("#audio_10").attr("autoplay", false);
            $('#play_10').removeClass("player_pause");
            $('#play_10').addClass("player_play");
            play_count = 0;

        }
    });


    //################# hawaii #######################

    document.getElementById('audio_20').addEventListener("ended", function () {
        var scope = angular.element("#controler_id").scope();
        var files = scope.files_20;
        count++;

        if (count < files.length) {

            var url = files[count];
            console.log(url);
            $("#audio_20").attr("src", url);
            $("#audio_20").attr("autoplay", true);
            $("#audio_20").load();
            $("#audio_20").get(0).play();
        } else {
            count   = 0;
            var url = files[count];
            console.log(url);
            $("#audio_20").attr("src", url);
            $("#audio_20").attr("autoplay", false);
            $('#play_20').removeClass("player_pause");
            $('#play_20').addClass("player_play");
            play_count = 0;

        }
    });

</script>


<script>

    $("#edit_btn").prop("disabled", true);

</script>

</html>
