<!DOCTYPE html>
<html lang="en">
<?php
require_once('in_header.php');

$id = $_GET["id"];
$app_src = isset($_GET["src"]) ? $_GET["src"] : '';
?>
<head>

    <script type="text/javascript" src="../assets/js/moment.min.js"></script>
</head>

<body ng-app="magriApp" ng-controller="magriCtrl" id="controler_id">
<div class="container-fluid">

    <?php

    if (!in_array(validateUserRole($conn, $_SESSION['username']), $content)) {
        header("Location: logout.php");
    }
    userLogActivity($conn, 'VERIFY WEATHER');
    ?>

    <ul class="nav nav-tabs">
        <li id="pu_tab" class="active"><a data-toggle="tab" href="#missouri">missouri</a></li>
        <li id="kansas_tab"><a data-toggle="tab" href="#kansas">kansas</a></li>
        <li id="florida_tab"><a data-toggle="tab" href="#florida">florida</a></li>
        <li id="hawaii_tab"><a data-toggle="tab" href="#hawaii">hawaii</a></li>
    </ul>

    <div class="tab-content">

        <input type="hidden" name="app_src" id="app_src" value="<?php echo $app_src ?>">

        <div id="missouri" class="tab-pane fade in active">

            <div class="vert-offset-top-3" ng-init="getLastInsertedData('<?php echo $id ?>', '<?php echo $app_src ?>')">

                <form id="weather_form" action="" enctype="multipart/form-data" class="form">

                    <div class="row">
                        <div class="col-sm-4"></div>

                        <div class="col-sm-2 form-group">
                            <!--                            <label class="">Select Date</label>-->
                            <div class="">
                                <input type="text" id="datepicker" name="date" class="form-control" value={{date}}
                                       readonly/>
                            </div>
                        </div>
                        <div class="col-sm-2 form-group">
                            <!--                            <label class="" for="pass">Location</label>-->
                            <div class="">
                                <input type="text" id="loc_id" name="location" class="form-control" value="{{location | capitalizeWord}}"
                                       readonly/>
                            </div>
                        </div>

                    </div>

                    <div class="row vert-offset-top-1">

                        <div class="col-sm-4 form-group">
                            <label class="pull-right" for="pass">Minimum Temperature</label>
                        </div>
                        <div class="col-sm-4 form-group">
                            <input type="text" id="min_id" name="minTemp" class="form-control" value={{min_temp}}
                                   readonly/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 form-group">
                            <label class="pull-right" for="pass">Maximum Temperature</label>
                        </div>
                        <div class="col-sm-4 form-group">
                            <input type="text" id="max_id" name="maxTemp" class="form-control" value={{max_temp}}
                                   readonly/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 form-group">
                            <label class="pull-right" for="pass">Weather Condition</label>
                        </div>
                        <div class="col-sm-4 form-group">
                            <div class="">
                                <input type="text" id="weather_id" name="weather" class="form-control"
                                       value={{condition}}
                                       readonly/>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-sm-4 form-group">
                            <label class="pull-right" for="pass">3 Day Weather Condition</label>
                        </div>
                        <div class="col-sm-4 form-group">

                            <div class="">
                                <input type="text" id="weather_day_id" name="weather_3day" class="form-control"
                                       value={{future_condition}} readonly/>
                            </div>
                        </div>

                    </div>
                    <div class="row container-fluid">
                        <div class="col-sm-4 form-group">
                        </div>
                        <div class="col-sm-4 form-group">
                            <label class="" for="pass">SMS Text</label>
                            <div class="">
                                <div>
                            <textarea rows="6" class="form-control" id="textarea_id_pu" name="textarea" type="textarea"
                                      readonly></textarea>
                                    <input type="hidden" id="text_hide" value={{sms_text}} /input>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 form-group">
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
                    <div class="row container-fluid">
                        <div class="col-sm-4 form-group">
                        </div>

                        <div class="row no_display">
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

                    </div>
                    <div class="row">
                        <div class="col-sm-8">

                            <button type="button" class="btn pull-right" ng-click="getMainPage('pu')">Save</button>

                            <a href="" ng-click="editRecord('<?php echo $id ?>','missouri')" class="btn btn-default btn-sm pull-right " style="margin-right: 10px; width: 70px">Edit</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="gb" class="tab-pane fade ">

            <form id="weather_form_gb">
                <div class="row vert-offset-top-3">

                    <div class="col-sm-4"></div>
                    <div class="col-sm-2 form-group">
                        <!--                        <label class="">Select Date</label>-->
                        <div class="">
                            <input type="text" id="datepicker" name="date" class="form-control" value={{date}}
                                   readonly/>
                        </div>
                    </div>
                    <div class="col-sm-2 form-group">
                        <!--                        <label class="" for="pass">Location</label>-->
                        <div class="">
                            <input type="text" id="loc_id" name="location" class="form-control" value="{{location |capitalizeWord}}"
                                   readonly/>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-6 " style="text-align: right; border: thin">

                        <div class="">
                            <h2 style="text-align: center">Morning</h2><br>
                            <div class="col-sm-4 form-group">
                                <label class="" for="pass">Minimum Temperature</label>
                            </div>
                            <div class="col-sm-7 form-group">
                                <input type="text" id="min_id" name="minTemp" class="form-control" value={{min_temp}}
                                       readonly/>
                            </div>

                            <div class="col-sm-4 form-group">
                                <label class="" for="pass">Maximum Temperature</label>
                            </div>
                            <div class="col-sm-7 form-group">
                                <input type="text" id="min_id" name="minTemp" class="form-control" value={{max_temp}}
                                       readonly/>
                            </div>

                            <div class="col-sm-4 form-group">
                                <label class="" for="pass">Weather Condition</label>
                            </div>
                            <div class="col-sm-7 form-group">
                                <div class="">
                                    <input type="text" id="weather_id" name="weather" class="form-control"
                                           value={{condition}}
                                           readonly/>
                                </div>
                            </div>

                            <div class="col-sm-4 form-group">
                                <label class="" for="pass">3 Day Weather Condition</label>
                            </div>
                            <div class="col-sm-7 form-group">

                                <div class="">
                                    <input type="text" id="weather_id" name="weather" class="form-control"
                                           value={{future_condition}}
                                           readonly/>
                                </div>
                            </div>

                            <div class="col-sm-4 form-group">
                                <label class="" for="pass">Morning SMS Text</label>
                            </div>
                            <div class="col-sm-7 form-group">

                                <div class="">
                                <textarea rows="6" class="form-control area_rtl" id="textarea_id" name="textarea"
                                          type="textarea"
                                          readonly></textarea>
                                    <input type="hidden" id="text_hide" value={{sms_text}} /input>
                                </div>
                            </div>

                            <div class="col-sm-4 form-group">
                                <label class="" for="pass">OBD Files</label>
                            </div>
                            <div class="col-sm-7 form-group">

                                <div class="">
                                    <table class="table">
                                        <div>
                                            <tr>
                                                <td width="20%"></td>
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
                    </div>
                    <div class="row no_display">
                        <div id="audio_div_4" class="col-sm-2 ">
                            <audio controls id="audio_4" src="{{d}}">
                                <source type="audio/ogg">
                                Your browser does not support the audio element.
                            </audio>
                        </div>

                        <div id="audio_div_5" class="col-sm-2">
                            <audio controls id="audio_5" src="{{e}}">
                                <source type="audio/ogg">
                                Your browser does not support the audio element.
                            </audio>
                        </div>

                    </div>
                    <!--                #######################################################################################################################################-->
                    <div class="col-sm-6 " style="text-align: right;">
                        <div class="">
                            <h2 style="text-align: center">Evening</h2><br>
                            <div class="col-sm-4 form-group">
                                <label class="" for="pass">Minimum Temperature</label>
                            </div>
                            <div class="col-sm-7 form-group">
                                <input type="text" id="min_id" name="minTemp" class="form-control"
                                       value={{eve_min_temp}} readonly/>
                            </div>

                            <div class="col-sm-4 form-group">
                                <label class="" for="pass">Maximum Temperature</label>
                            </div>
                            <div class="col-sm-7 form-group">
                                <input type="text" id="min_id" name="minTemp" class="form-control"
                                       value={{eve_max_temp}} readonly/>
                            </div>

                            <div class="col-sm-4 form-group">
                                <label class="" for="pass">Weather Condition</label>
                            </div>
                            <div class="col-sm-7 form-group">
                                <div class="">
                                    <input type="text" id="weather_id" name="weather" class="form-control"
                                           value={{eve_condition}}
                                           readonly/>
                                </div>
                            </div>

                            <div class="col-sm-4 form-group">
                                <label class="" for="pass">Next Few Hours Weather</label>
                            </div>
                            <div class="col-sm-7 form-group">

                                <div class="">
                                    <input type="text" id="weather_id" name="weather" class="form-control"
                                           value={{eve_future_condition}}
                                           readonly/>
                                </div>
                            </div>

                            <div class="col-sm-4 form-group">
                                <label class="" for="pass">Evening SMS Text</label>
                            </div>
                            <div class="col-sm-7 form-group">

                                <div class="">
                                <textarea rows="6" class="form-control area_rtl" id="eve_textarea_id" name="textarea"
                                          type="textarea"
                                          readonly></textarea>
                                    <input type="hidden" id="eve_text_hide" value={{eve_sms_text}} /input>
                                </div>
                            </div>

                            <div class="col-sm-4 form-group">
                                <label class="" for="pass">OBD Files</label>
                            </div>
                            <div class="col-sm-7 form-group">

                                <div class="">
                                    <table class="table">
                                        <div>
                                            <tr>
                                                <td width="20%"></td>
                                                <td width="20"><a href="#">
                                                        <div class="audio_img player_play" id="play_5"></div>
                                                    </a></td>
                                                <td width="20"><a href="#">
                                                        <div class="audio_img player_stop" id="stop_5"></div>
                                                    </a></td>
                                            </tr>
                                        </div>

                                    </table>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="row col-sm-8">
                    <button type="button" class="btn pull-right mybtn" ng-click="getMainPage('gb')" style="margin-right: 30px">OK</button>

                    <a href="" ng-click="editRecord('<?php echo $id ?>', 'gb')" class="btn btn-default mybtn btn-sm pull-right" style="margin-right: 10px">Edit</a>

                </div>

            </form>
        </div>

        <div id="florida" class="tab-pane fade">

            <div class="vert-offset-top-3">

                <form id="weather_form" action="" enctype="multipart/form-data" class="form">

                    <div class="row">
                        <div class="col-sm-4"></div>

                        <div class="col-sm-2 form-group">
                            <!--                            <label class="">Select Date</label>-->
                            <div class="">
                                <input type="text" id="datepicker" name="date" class="form-control" value={{date}}
                                       readonly/>
                            </div>
                        </div>
                        <div class="col-sm-2 form-group">
                            <!--                            <label class="" for="pass">Location</label>-->
                            <div class="">
                                <input type="text" id="loc_id" name="location" class="form-control" value="{{location | capitalizeWord}}"
                                       readonly/>
                            </div>
                        </div>

                    </div>

                    <div class="row vert-offset-top-1">

                        <div class="col-sm-4 form-group">
                            <label class="pull-right" for="pass">Minimum Temperature</label>
                        </div>
                        <div class="col-sm-4 form-group">
                            <input type="text" id="min_id" name="minTemp" class="form-control" value={{min_temp}}
                                   readonly/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 form-group">
                            <label class="pull-right" for="pass">Maximum Temperature</label>
                        </div>
                        <div class="col-sm-4 form-group">
                            <input type="text" id="max_id" name="maxTemp" class="form-control" value={{max_temp}}
                                   readonly/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 form-group">
                            <label class="pull-right" for="pass">Weather Condition</label>
                        </div>
                        <div class="col-sm-4 form-group">
                            <div class="">
                                <input type="text" id="weather_id" name="weather" class="form-control"
                                       value={{condition}}
                                       readonly/>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-sm-4 form-group">
                            <label class="pull-right" for="pass">3 Day Weather Condition</label>
                        </div>
                        <div class="col-sm-4 form-group">

                            <div class="">
                                <input type="text" id="weather_day_id" name="weather_3day" class="form-control"
                                       value={{future_condition}} readonly/>
                            </div>
                        </div>

                    </div>
                    <div class="row container-fluid">
                        <div class="col-sm-4 form-group">
                        </div>
                        <div class="col-sm-4 form-group">
                            <label class="" for="pass">SMS Text</label>
                            <div class="">
                                <div>
                            <textarea rows="6" class="form-control" id="textarea_id_florida" name="textarea" type="textarea"
                                      readonly></textarea>
                                    <input type="hidden" id="text_hide_florida" value={{sms_text}} /input>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 form-group">
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
                    <div class="row container-fluid">
                        <div class="col-sm-4 form-group">
                        </div>

                        <div class="row no_display">
                            <div id="audio_div_10" class="col-sm-2 ">
                                <audio controls id="audio_10" src="{{s}}">
                                    <source type="audio/ogg">
                                    Your browser does not support the audio element.
                                </audio>
                            </div>

<!--                            <div id="audio_div_2" class="col-sm-2">-->
<!--                                <audio controls id="audio_2" src="{{b}}">-->
<!--                                    <source type="audio/ogg">-->
<!--                                    Your browser does not support the audio element.-->
<!--                                </audio>-->
<!--                            </div>-->
<!---->
<!--                            <div id="audio_div_3" class="col-sm-2">-->
<!--                                <audio controls id="audio_3" src="{{c}}">-->
<!--                                    <source type="audio/ogg">-->
<!--                                    Your browser does not support the audio element.-->
<!--                                </audio>-->
<!--                            </div>-->

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-8">

                            <button type="button" class="btn pull-right" ng-click="getMainPage('florida')">Save</button>

                            <a href="" ng-click="editRecord('<?php echo $id ?>','florida')" class="btn btn-default btn-sm pull-right " style="margin-right: 10px; width: 70px">Edit</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>




        <div id="hawaii" class="tab-pane fade">

            <div class="vert-offset-top-3">

                <form id="weather_form" action="" enctype="multipart/form-data" class="form">

                    <div class="row">
                        <div class="col-sm-4"></div>

                        <div class="col-sm-2 form-group">
                            <!--                            <label class="">Select Date</label>-->
                            <div class="">
                                <input type="text" id="datepicker" name="date" class="form-control" value={{date}}
                                       readonly/>
                            </div>
                        </div>
                        <div class="col-sm-2 form-group">
                            <!--                            <label class="" for="pass">Location</label>-->
                            <div class="">
                                <input type="text" id="loc_id" name="location" class="form-control" value="{{location | capitalizeWord}}"
                                       readonly/>
                            </div>
                        </div>

                    </div>

                    <div class="row vert-offset-top-1">

                        <div class="col-sm-4 form-group">
                            <label class="pull-right" for="pass">Minimum Temperature</label>
                        </div>
                        <div class="col-sm-4 form-group">
                            <input type="text" id="min_id" name="minTemp" class="form-control" value={{min_temp}}
                                   readonly/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 form-group">
                            <label class="pull-right" for="pass">Maximum Temperature</label>
                        </div>
                        <div class="col-sm-4 form-group">
                            <input type="text" id="max_id" name="maxTemp" class="form-control" value={{max_temp}}
                                   readonly/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 form-group">
                            <label class="pull-right" for="pass">Weather Condition</label>
                        </div>
                        <div class="col-sm-4 form-group">
                            <div class="">
                                <input type="text" id="weather_id" name="weather" class="form-control"
                                       value={{condition}}
                                       readonly/>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-sm-4 form-group">
                            <label class="pull-right" for="pass">3 Day Weather Condition</label>
                        </div>
                        <div class="col-sm-4 form-group">

                            <div class="">
                                <input type="text" id="weather_day_id" name="weather_3day" class="form-control"
                                       value={{future_condition}} readonly/>
                            </div>
                        </div>

                    </div>
                    <div class="row container-fluid">
                        <div class="col-sm-4 form-group">
                        </div>
                        <div class="col-sm-4 form-group">
                            <label class="" for="pass">SMS Text</label>
                            <div class="">
                                <div>
                            <textarea rows="6" class="form-control" id="textarea_id_hawaii" name="textarea" type="textarea"
                                      readonly></textarea>
                                    <input type="hidden" id="text_hide_hawaii" value={{sms_text}} /input>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 form-group">
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
                    <div class="row container-fluid">
                        <div class="col-sm-4 form-group">
                        </div>

                        <div class="row no_display">
                            <div id="audio_div_20" class="col-sm-2 ">
                                <audio controls id="audio_20" src="{{k}}">
                                    <source type="audio/ogg">
                                    Your browser does not support the audio element.
                                </audio>
                            </div>

                            <!--                            <div id="audio_div_2" class="col-sm-2">-->
                            <!--                                <audio controls id="audio_2" src="{{b}}">-->
                            <!--                                    <source type="audio/ogg">-->
                            <!--                                    Your browser does not support the audio element.-->
                            <!--                                </audio>-->
                            <!--                            </div>-->
                            <!---->
                            <!--                            <div id="audio_div_3" class="col-sm-2">-->
                            <!--                                <audio controls id="audio_3" src="{{c}}">-->
                            <!--                                    <source type="audio/ogg">-->
                            <!--                                    Your browser does not support the audio element.-->
                            <!--                                </audio>-->
                            <!--                            </div>-->

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-8">

                            <button type="button" class="btn pull-right" ng-click="getMainPage('hawaii')">Save</button>

                            <a href="" ng-click="editRecord('<?php echo $id ?>','hawaii')" class="btn btn-default btn-sm pull-right " style="margin-right: 10px; width: 70px">Edit</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
<?php require_once('in_footer.php') ?>
</body>


<script>

    if ($("#app_src").val() == 'gb') {
        $("#pu_tab").removeClass("active");
        $("#missouri").removeClass("active");
        $("#missouri").removeClass("in");

        $("#kansas_tab").addClass("active");
        $("#kansas").addClass("active");
        $("#kansas").addClass("in");

        $("#pu_tab").css("display","none");
        $("#florida_tab").css("display","none");
        $("#hawaii_tab").css("display","none");

    }else if ($("#app_src").val() == 'florida') {
        $("#pu_tab").removeClass("active");
        $("#missouri").removeClass("active");
        $("#missouri").removeClass("in");

        $("#florida_tab").addClass("active");
        $("#florida").addClass("active");
        $("#florida").addClass("in");

        $("#pu_tab").css("display","none");
        $("#kansas_tab").css("display","none");
        $("#hawaii_tab").css("display","none");

    }else if ($("#app_src").val() == 'hawaii') {
        $("#pu_tab").removeClass("active");
        $("#missouri").removeClass("active");
        $("#missouri").removeClass("in");

        $("#hawaii_tab").addClass("active");
        $("#hawaii").addClass("active");
        $("#hawaii").addClass("in");

        $("#pu_tab").css("display","none");
        $("#kansas_tab").css("display","none");
        $("#florida_tab").css("display","none");

    }else{
        $("#kansas_tab").css("display","none");
        $("#florida_tab").css("display","none");
        $("#hawaii_tab").css("display","none");
    }
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

        //############## florida #############################
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


        //############## hawaii  #############################
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

    //######################## GB #############################################
    document.getElementById('audio_4').addEventListener("ended", function () {
        var scope = angular.element("#controler_id").scope();
        var files = scope.files_4;
        count++;

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

    //######################### florida ##########################
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


    //######################### hawaii ##########################
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

    $(document).ready(function () {

        setTimeout(func, 100);
        function func() {
            if ($("#text_hide").val()) {
                $("#textarea_id_pu").html($("#text_hide").val());
                $("#textarea_id").html($("#text_hide").val());
                $("#eve_textarea_id").html($("#eve_text_hide").val());

                $("#textarea_id_florida").html($("#text_hide").val());

            }else if ($("#text_hide_florida").val()) {
                $("#textarea_id_florida").html($("#text_hide_florida").val());
            }else {
                console.log(document.readyState);
                setTimeout(func, 100);
            }
        }

    });
</script>
</html>
