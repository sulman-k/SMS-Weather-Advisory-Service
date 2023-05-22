<!DOCTYPE html>
<html lang="en">
<?php
require_once('in_header.php');

$id = $_GET["id"];
$app_src = isset($_GET["src"])? $_GET["src"]: '';
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

    userLogActivity($conn, 'EDIT WEATHER');
    ?>

    <ul class="nav nav-tabs">
        <li id="pu_tab" class="active"><a data-toggle="tab" href="#missouri">missouri</a></li>
        <li id="kansas_tab"><a data-toggle="tab" href="#kansas">kansas</a></li>
        <li id="florida_tab"><a data-toggle="tab" href="#florida">florida</a></li>
        <li id="hawaii_tab"><a data-toggle="tab" href="#hawaii">hawaii</a></li>
    </ul>

    <input type="hidden" name="app_src" id="app_src" value="<?php echo $app_src ?>">

    <div class="tab-content" ng-init="loadEditRecord('<?php echo $id ?>')">

        <div id="missouri" class="tab-pane fade in active">

            <div class="vert-offset-top-3">

                <form id="weather_form" action="" enctype="multipart/form-data" class="form">

                    <div class="row" >
                        <div class="col-sm-4"></div>

                        <div class="col-sm-2 form-group">
<!--                            <label class="">Select Date</label>-->
                            <div class="">
                                <input type="text" id="datepicker_add" name="magri_date" class="form-control" ng-model="date"
                                       value={{date}}/>
                                <input type="hidden" id="id" name="id" value=<?php echo $id ?>>
                            </div>
                        </div>
                        <div class="col-sm-2 form-group">
<!--                            <label class="" for="pass">Location</label>-->
                            <div class="">

                                <select id="loc_id" name="location" class="form-control" data-validation="required"
                                        data-validation-error-msg="Select Location">
                                    <option value="">Select Location</option>
                                    <option value="{{loc.id}}" ng-repeat="loc in pu_locations"
                                            ng-selected="{{loc.id == location_id}}">{{loc.id | capitalizeWord}}
                                    </option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row vert-offset-top-1">

                        <div class="col-sm-4 form-group">
                            <label class="pull-right" for="pass">Minimum Temperature</label>
                        </div>
                        <div class="col-sm-4 form-group">
                            <select id="min_id" name="minTemp" class="form-control" data-validation="required"
                                    data-validation-error-msg="Select Minimum Temperature">
                                <option value="">Select Min Temperature</option>

<!--                                <option value="-30" ng-selected="-30 == min_temp">-30°c</option>-->
<!--                                <option value="-29" ng-selected="-29 == min_temp">-29°c</option>-->
<!--                                <option value="-28" ng-selected="-28 == min_temp">-28°c</option>-->
<!--                                <option value="-27" ng-selected="-27 == min_temp">-27°c</option>-->
<!--                                <option value="-26" ng-selected="-26 == min_temp">-26°c</option>-->
<!--                                <option value="-25" ng-selected="-25 == min_temp">-25°c</option>-->
<!--                                <option value="-24" ng-selected="-24 == min_temp">-24°c</option>-->
<!--                                <option value="-23" ng-selected="-23 == min_temp">-23°c</option>-->
<!--                                <option value="-22" ng-selected="-22 == min_temp">-22°c</option>-->
<!--                                <option value="-21" ng-selected="-21 == min_temp">-21°c</option>-->
<!--                                <option value="-20" ng-selected="-20 == min_temp">-20°c</option>-->
<!--                                <option value="-19" ng-selected="-19 == min_temp">-19°c</option>-->
<!--                                <option value="-18" ng-selected="-18 == min_temp">-18°c</option>-->
<!--                                <option value="-17" ng-selected="-17 == min_temp">-17°c</option>-->
<!--                                <option value="-16" ng-selected="-16 == min_temp">-16°c</option>-->
<!--                                <option value="-15" ng-selected="-15 == min_temp">-15°c</option>-->
<!--                                <option value="-14" ng-selected="-14 == min_temp">-14°c</option>-->
<!--                                <option value="-13" ng-selected="-13 == min_temp">-13°c</option>-->
<!--                                <option value="-12" ng-selected="-12 == min_temp">-12°c</option>-->
<!--                                <option value="-11" ng-selected="-11 == min_temp">-11°c</option>-->
<!--                                <option value="-10" ng-selected="-10 == min_temp">-10°c</option>-->
<!--                                <option value="-9" ng-selected="-9 == min_temp">-9°c</option>-->
<!--                                <option value="-8" ng-selected="-8 == min_temp">-8°c</option>-->
<!--                                <option value="-7" ng-selected="-7 == min_temp">-7°c</option>-->
<!--                                <option value="-6" ng-selected="-6 == min_temp">-6°c</option>-->

                                <option value="-5" ng-selected="-5 == min_temp">-5°c</option>
                                <option value="-4" ng-selected="-4 == min_temp">-4°c</option>
                                <option value="-3" ng-selected="-3 == min_temp">-3°c</option>
                                <option value="-2" ng-selected="-2 == min_temp">-2°c</option>
                                <option value="-1" ng-selected="-1 == min_temp">-1°c</option>
                                <option value="0" ng-selected="0 == min_temp">0°c</option>
                                <option value="1" ng-selected="1 == min_temp">1°c</option>
                                <option value="2" ng-selected="2 == min_temp">2°c</option>
                                <option value="3" ng-selected="3 == min_temp">3°c</option>
                                <option value="4" ng-selected="4 == min_temp">4°c</option>
                                <option value="5" ng-selected="5 == min_temp">5°c</option>
                                <option value="6" ng-selected="6 == min_temp">6°c</option>
                                <option value="7" ng-selected="7 == min_temp">7°c</option>
                                <option value="8" ng-selected="8 == min_temp">8°c</option>
                                <option value="9" ng-selected="9 == min_temp">9°c</option>
                                <option value="10" ng-selected="10 == min_temp">10°c</option>
                                <option value="11" ng-selected="11 == min_temp">11°c</option>
                                <option value="12" ng-selected="12 == min_temp">12°c</option>
                                <option value="13" ng-selected="13 == min_temp">13°c</option>
                                <option value="14" ng-selected="14 == min_temp">14°c</option>
                                <option value="15" ng-selected="15 == min_temp">15°c</option>
                                <option value="16" ng-selected="16 == min_temp">16°c</option>
                                <option value="17" ng-selected="17 == min_temp">17°c</option>
                                <option value="18" ng-selected="18 == min_temp">18°c</option>
                                <option value="19" ng-selected="19 == min_temp">19°c</option>
                                <option value="20" ng-selected="20 == min_temp">20°c</option>
                                <option value="21" ng-selected="21 == min_temp">21°c</option>
                                <option value="22" ng-selected="22 == min_temp">22°c</option>
                                <option value="23" ng-selected="23 == min_temp">23°c</option>
                                <option value="24" ng-selected="24 == min_temp">24°c</option>
                                <option value="25" ng-selected="25 == min_temp">25°c</option>
                                <option value="26" ng-selected="26 == min_temp">26°c</option>
                                <option value="27" ng-selected="27 == min_temp">27°c</option>
                                <option value="28" ng-selected="28 == min_temp">28°c</option>
                                <option value="29" ng-selected="29 == min_temp">29°c</option>
                                <option value="30" ng-selected="30 == min_temp">30°c</option>
                                <option value="31" ng-selected="31 == min_temp">31°c</option>
                                <option value="32" ng-selected="32 == min_temp">32°c</option>
                                <option value="33" ng-selected="33 == min_temp">33°c</option>
                                <option value="34" ng-selected="34 == min_temp">34°c</option>
                                <option value="35" ng-selected="35 == min_temp">35°c</option>
                                <option value="36" ng-selected="36 == min_temp">36°c</option>
                                <option value="37" ng-selected="37 == min_temp">37°c</option>
                                <option value="38" ng-selected="38 == min_temp">38°c</option>
                                <option value="39" ng-selected="39 == min_temp">39°c</option>
                                <option value="40" ng-selected="40 == min_temp">40°c</option>
                                <option value="41" ng-selected="41 == min_temp">41°c</option>
                                <option value="42" ng-selected="42 == min_temp">42°c</option>
                                <option value="43" ng-selected="43 == min_temp">43°c</option>
                                <option value="44" ng-selected="44 == min_temp">44°c</option>
                                <option value="45" ng-selected="45 == min_temp">45°c</option>
                                <option value="46" ng-selected="46 == min_temp">46°c</option>
                                <option value="47" ng-selected="47 == min_temp">47°c</option>
                                <option value="48" ng-selected="48 == min_temp">48°c</option>
                                <option value="49" ng-selected="49 == min_temp">49°c</option>
                                <option value="50" ng-selected="50 == min_temp">50°c</option>
                                <option value="51" ng-selected="51 == min_temp">51°c</option>
                                <option value="52" ng-selected="52 == min_temp">52°c</option>
                                <option value="53" ng-selected="53 == min_temp">53°c</option>
                                <option value="54" ng-selected="54 == min_temp">54°c</option>
                                <option value="55" ng-selected="55 == min_temp">55°c</option>
                                <option value="56" ng-selected="56 == min_temp">56°c</option>
                                <option value="57" ng-selected="57 == min_temp">57°c</option>
                                <option value="58" ng-selected="58 == min_temp">58°c</option>
                                <option value="59" ng-selected="59 == min_temp">59°c</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 form-group">
                            <label class="pull-right" for="pass">Maximum Temperature</label>
                        </div>
                        <div class="col-sm-4 form-group">
                            <select id="max_id" name="maxTemp" class="form-control" data-validation="required"
                                    data-validation-error-msg="Select Maximum Temperature">
                                <option value="">Select Max Temperature</option>

<!--                                <option value="-29" ng-selected="-29 == max_temp">-29°c</option>-->
<!--                                <option value="-28" ng-selected="-28 == max_temp">-28°c</option>-->
<!--                                <option value="-27" ng-selected="-27 == max_temp">-27°c</option>-->
<!--                                <option value="-26" ng-selected="-26 == max_temp">-26°c</option>-->
<!--                                <option value="-25" ng-selected="-25 == max_temp">-25°c</option>-->
<!--                                <option value="-24" ng-selected="-24 == max_temp">-24°c</option>-->
<!--                                <option value="-23" ng-selected="-23 == max_temp">-23°c</option>-->
<!--                                <option value="-22" ng-selected="-22 == max_temp">-22°c</option>-->
<!--                                <option value="-21" ng-selected="-21 == max_temp">-21°c</option>-->
<!--                                <option value="-20" ng-selected="-20 == max_temp">-20°c</option>-->
<!--                                <option value="-19" ng-selected="-19 == max_temp">-19°c</option>-->
<!--                                <option value="-18" ng-selected="-18 == max_temp">-18°c</option>-->
<!--                                <option value="-17" ng-selected="-17 == max_temp">-17°c</option>-->
<!--                                <option value="-16" ng-selected="-16 == max_temp">-16°c</option>-->
<!--                                <option value="-15" ng-selected="-15 == max_temp">-15°c</option>-->
<!--                                <option value="-14" ng-selected="-14 == max_temp">-14°c</option>-->
<!--                                <option value="-13" ng-selected="-13 == max_temp">-13°c</option>-->
<!--                                <option value="-12" ng-selected="-12 == max_temp">-12°c</option>-->
<!--                                <option value="-11" ng-selected="-11 == max_temp">-11°c</option>-->
<!--                                <option value="-10" ng-selected="-10 == max_temp">-10°c</option>-->
<!--                                <option value="-9" ng-selected="-9 == max_temp">-9°c</option>-->
<!--                                <option value="-8" ng-selected="-8 == max_temp">-8°c</option>-->
<!--                                <option value="-7" ng-selected="-7 == max_temp">-7°c</option>-->
<!--                                <option value="-6" ng-selected="-6 == max_temp">-6°c</option>-->
<!--                                <option value="-5" ng-selected="-5 == max_temp">-5°c</option>-->
                                <option value="-4" ng-selected="-4 == max_temp">-4°c</option>
                                <option value="-3" ng-selected="-3 == max_temp">-3°c</option>
                                <option value="-2" ng-selected="-2 == max_temp">-2°c</option>
                                <option value="-1" ng-selected="-1 == max_temp">-1°c</option>
                                <option value="0" ng-selected="0 == max_temp">0°c</option>
                                <option value="1" ng-selected="1 == max_temp">1°c</option>
                                <option value="2" ng-selected="2 == max_temp">2°c</option>
                                <option value="3" ng-selected="3 == max_temp">3°c</option>
                                <option value="4" ng-selected="4 == max_temp">4°c</option>
                                <option value="5" ng-selected="5 == max_temp">5°c</option>
                                <option value="6" ng-selected="6 == max_temp">6°c</option>
                                <option value="7" ng-selected="7 == max_temp">7°c</option>
                                <option value="8" ng-selected="8 == max_temp">8°c</option>
                                <option value="9" ng-selected="9 == max_temp">9°c</option>
                                <option value="10" ng-selected="10 == max_temp">10°c</option>
                                <option value="11" ng-selected="11 == max_temp">11°c</option>
                                <option value="12" ng-selected="12 == max_temp">12°c</option>
                                <option value="13" ng-selected="13 == max_temp">13°c</option>
                                <option value="14" ng-selected="14 == max_temp">14°c</option>
                                <option value="15" ng-selected="15 == max_temp">15°c</option>
                                <option value="16" ng-selected="16 == max_temp">16°c</option>
                                <option value="17" ng-selected="17 == max_temp">17°c</option>
                                <option value="18" ng-selected="18 == max_temp">18°c</option>
                                <option value="19" ng-selected="19 == max_temp">19°c</option>
                                <option value="20" ng-selected="20 == max_temp">20°c</option>
                                <option value="21" ng-selected="21 == max_temp">21°c</option>
                                <option value="22" ng-selected="22 == max_temp">22°c</option>
                                <option value="23" ng-selected="23 == max_temp">23°c</option>
                                <option value="24" ng-selected="24 == max_temp">24°c</option>
                                <option value="25" ng-selected="25 == max_temp">25°c</option>
                                <option value="26" ng-selected="26 == max_temp">26°c</option>
                                <option value="27" ng-selected="27 == max_temp">27°c</option>
                                <option value="28" ng-selected="28 == max_temp">28°c</option>
                                <option value="29" ng-selected="29 == max_temp">29°c</option>
                                <option value="30" ng-selected="30 == max_temp">30°c</option>
                                <option value="31" ng-selected="31 == max_temp">31°c</option>
                                <option value="32" ng-selected="32 == max_temp">32°c</option>
                                <option value="33" ng-selected="33 == max_temp">33°c</option>
                                <option value="34" ng-selected="34 == max_temp">34°c</option>
                                <option value="35" ng-selected="35 == max_temp">35°c</option>
                                <option value="36" ng-selected="36 == max_temp">36°c</option>
                                <option value="37" ng-selected="37 == max_temp">37°c</option>
                                <option value="38" ng-selected="38 == max_temp">38°c</option>
                                <option value="39" ng-selected="39 == max_temp">39°c</option>
                                <option value="40" ng-selected="40 == max_temp">40°c</option>
                                <option value="41" ng-selected="41 == max_temp">41°c</option>
                                <option value="42" ng-selected="42 == max_temp">42°c</option>
                                <option value="43" ng-selected="43 == max_temp">43°c</option>
                                <option value="44" ng-selected="44 == max_temp">44°c</option>
                                <option value="45" ng-selected="45 == max_temp">45°c</option>
                                <option value="46" ng-selected="46 == max_temp">46°c</option>
                                <option value="47" ng-selected="47 == max_temp">47°c</option>
                                <option value="48" ng-selected="48 == max_temp">48°c</option>
                                <option value="49" ng-selected="49 == max_temp">49°c</option>
                                <option value="50" ng-selected="50 == max_temp">50°c</option>
                                <option value="51" ng-selected="51 == max_temp">51°c</option>
                                <option value="52" ng-selected="52 == max_temp">52°c</option>
                                <option value="53" ng-selected="53 == max_temp">53°c</option>
                                <option value="54" ng-selected="54 == max_temp">54°c</option>
                                <option value="55" ng-selected="55 == max_temp">55°c</option>
                                <option value="56" ng-selected="56 == max_temp">56°c</option>
                                <option value="57" ng-selected="57 == max_temp">57°c</option>
                                <option value="58" ng-selected="58 == max_temp">58°c</option>
                                <option value="59" ng-selected="59 == max_temp">59°c</option>
                                <option value="60" ng-selected="60 == max_temp">60°c</option>

                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 form-group">
                            <label class="pull-right" for="pass">Weather Condition</label>
                        </div>
                        <div class="col-sm-4 form-group">
                            <div class="">
                                <select id="weather_id" name="weather" class="form-control" data-validation="required"
                                        data-validation-error-msg="Select Weather Condition">
                                    <option value="">Select Weather Condition</option>
                                    <option value={{c.id}} ng-repeat="c in pu_conditions"
                                            ng-selected="{{c.id == today_condition_id}}">{{c.condition}}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-sm-4 form-group">
                            <label class="pull-right" for="pass">3 Day Weather Condition</label>
                        </div>
                        <div class="col-sm-4 form-group">

                            <div class="">
                                <select id="weather_day_id" name="weather_3day" class="form-control"
                                        data-validation="required" autofocus
                                        data-validation-error-msg="Select 3 Day Weather Condition">
                                    <option value="">Select 3 Day Weather Condition</option>
                                    <option value={{f.id}} ng-repeat="f in pu_future_conditions"
                                            ng-selected="{{f.id == future_condition_id}}">{{f.future_condition}}
                                    </option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <button type="submit" class="btn pull-right">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="gb" class="tab-pane fade ">

            <form id="weather_form_gb">
                <div class="row vert-offset-top-3">

                    <div class="col-sm-4" ></div>
                    <div class="col-sm-2 form-group">
<!--                        <label class="">Select Date</label>-->
                        <div class="">
                            <input type="text" id="datepicker_add_gb" name="magri_date" class="form-control" ng-model="date"
                                   value={{date}}/>
                            <input type="hidden" id="id" name="id" value=<?php echo $id ?>>
                        </div>
                    </div>
                    <div class="col-sm-2 form-group">
<!--                        <label class="" for="pass">Location</label>-->
                        <input type="hidden" value="{{location_id}}" name="prev_location">
                        <div class="">
                            <select id="loc_id_gb" name="location" class="form-control" data-validation="required"
                                    data-validation-error-msg="Select Location">
                                <option value="">Select Location</option>
                                <option value="{{loc.id}}" ng-repeat="loc in kansas_locations" ng-selected="{{loc.id == location_id}}">{{loc.id | capitalizeWord}} </option>
                            </select>
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
                                <select id="min_id_gb" name="minTemp" class="form-control" data-validation="required"
                                        data-validation-error-msg="Select Minimum Temperature">
                                    <option value="">Select Min Temperature</option>

                                    <option value="-30" ng-selected="-30 == min_temp">-30°c</option>
                                    <option value="-29" ng-selected="-29 == min_temp">-29°c</option>
                                    <option value="-28" ng-selected="-28 == min_temp">-28°c</option>
                                    <option value="-27" ng-selected="-27 == min_temp">-27°c</option>
                                    <option value="-26" ng-selected="-26 == min_temp">-26°c</option>
                                    <option value="-25" ng-selected="-25 == min_temp">-25°c</option>
                                    <option value="-24" ng-selected="-24 == min_temp">-24°c</option>
                                    <option value="-23" ng-selected="-23 == min_temp">-23°c</option>
                                    <option value="-22" ng-selected="-22 == min_temp">-22°c</option>
                                    <option value="-21" ng-selected="-21 == min_temp">-21°c</option>
                                    <option value="-20" ng-selected="-20 == min_temp">-20°c</option>
                                    <option value="-19" ng-selected="-19 == min_temp">-19°c</option>
                                    <option value="-18" ng-selected="-18 == min_temp">-18°c</option>
                                    <option value="-17" ng-selected="-17 == min_temp">-17°c</option>
                                    <option value="-16" ng-selected="-16 == min_temp">-16°c</option>
                                    <option value="-15" ng-selected="-15 == min_temp">-15°c</option>
                                    <option value="-14" ng-selected="-14 == min_temp">-14°c</option>
                                    <option value="-13" ng-selected="-13 == min_temp">-13°c</option>
                                    <option value="-12" ng-selected="-12 == min_temp">-12°c</option>
                                    <option value="-11" ng-selected="-11 == min_temp">-11°c</option>
                                    <option value="-10" ng-selected="-10 == min_temp">-10°c</option>
                                    <option value="-9" ng-selected="-9 == min_temp">-9°c</option>
                                    <option value="-8" ng-selected="-8 == min_temp">-8°c</option>
                                    <option value="-7" ng-selected="-7 == min_temp">-7°c</option>
                                    <option value="-6" ng-selected="-6 == min_temp">-6°c</option>

                                    <option value="-5" ng-selected="-5 == min_temp">-5°c</option>
                                    <option value="-4" ng-selected="-4 == min_temp">-4°c</option>
                                    <option value="-3" ng-selected="-3 == min_temp">-3°c</option>
                                    <option value="-2" ng-selected="-2 == min_temp">-2°c</option>
                                    <option value="-1" ng-selected="-1 == min_temp">-1°c</option>
                                    <option value="0" ng-selected="0 == min_temp">0°c</option>
                                    <option value="1" ng-selected="1 == min_temp">1°c</option>
                                    <option value="2" ng-selected="2 == min_temp">2°c</option>
                                    <option value="3" ng-selected="3 == min_temp">3°c</option>
                                    <option value="4" ng-selected="4 == min_temp">4°c</option>
                                    <option value="5" ng-selected="5 == min_temp">5°c</option>
                                    <option value="6" ng-selected="6 == min_temp">6°c</option>
                                    <option value="7" ng-selected="7 == min_temp">7°c</option>
                                    <option value="8" ng-selected="8 == min_temp">8°c</option>
                                    <option value="9" ng-selected="9 == min_temp">9°c</option>
                                    <option value="10" ng-selected="10 == min_temp">10°c</option>
                                    <option value="11" ng-selected="11 == min_temp">11°c</option>
                                    <option value="12" ng-selected="12 == min_temp">12°c</option>
                                    <option value="13" ng-selected="13 == min_temp">13°c</option>
                                    <option value="14" ng-selected="14 == min_temp">14°c</option>
                                    <option value="15" ng-selected="15 == min_temp">15°c</option>
                                    <option value="16" ng-selected="16 == min_temp">16°c</option>
                                    <option value="17" ng-selected="17 == min_temp">17°c</option>
                                    <option value="18" ng-selected="18 == min_temp">18°c</option>
                                    <option value="19" ng-selected="19 == min_temp">19°c</option>
                                    <option value="20" ng-selected="20 == min_temp">20°c</option>
                                    <option value="21" ng-selected="21 == min_temp">21°c</option>
                                    <option value="22" ng-selected="22 == min_temp">22°c</option>
                                    <option value="23" ng-selected="23 == min_temp">23°c</option>
                                    <option value="24" ng-selected="24 == min_temp">24°c</option>
                                    <option value="25" ng-selected="25 == min_temp">25°c</option>
                                    <option value="26" ng-selected="26 == min_temp">26°c</option>
                                    <option value="27" ng-selected="27 == min_temp">27°c</option>
                                    <option value="28" ng-selected="28 == min_temp">28°c</option>
                                    <option value="29" ng-selected="29 == min_temp">29°c</option>
                                    <option value="30" ng-selected="30 == min_temp">30°c</option>
                                    <option value="31" ng-selected="31 == min_temp">31°c</option>
                                    <option value="32" ng-selected="32 == min_temp">32°c</option>
                                    <option value="33" ng-selected="33 == min_temp">33°c</option>
                                    <option value="34" ng-selected="34 == min_temp">34°c</option>
                                    <option value="35" ng-selected="35 == min_temp">35°c</option>
                                    <option value="36" ng-selected="36 == min_temp">36°c</option>
                                    <option value="37" ng-selected="37 == min_temp">37°c</option>
                                    <option value="38" ng-selected="38 == min_temp">38°c</option>
                                    <option value="39" ng-selected="39 == min_temp">39°c</option>
                                    <option value="40" ng-selected="40 == min_temp">40°c</option>
                                    <option value="41" ng-selected="41 == min_temp">41°c</option>
                                    <option value="42" ng-selected="42 == min_temp">42°c</option>
                                    <option value="43" ng-selected="43 == min_temp">43°c</option>
                                    <option value="44" ng-selected="44 == min_temp">44°c</option>
                                    <option value="45" ng-selected="45 == min_temp">45°c</option>
                                    <option value="46" ng-selected="46 == min_temp">46°c</option>
                                    <option value="47" ng-selected="47 == min_temp">47°c</option>
                                    <option value="48" ng-selected="48 == min_temp">48°c</option>
                                    <option value="49" ng-selected="49 == min_temp">49°c</option>
                                    <option value="50" ng-selected="50 == min_temp">50°c</option>
                                    <option value="51" ng-selected="51 == min_temp">51°c</option>
                                    <option value="52" ng-selected="52 == min_temp">52°c</option>
                                    <option value="53" ng-selected="53 == min_temp">53°c</option>
                                    <option value="54" ng-selected="54 == min_temp">54°c</option>
                                    <option value="55" ng-selected="55 == min_temp">55°c</option>
                                    <option value="56" ng-selected="56 == min_temp">56°c</option>
                                    <option value="57" ng-selected="57 == min_temp">57°c</option>
                                    <option value="58" ng-selected="58 == min_temp">58°c</option>
                                    <option value="59" ng-selected="59 == min_temp">59°c</option>
                                </select>
                            </div>

                            <div class="col-sm-4 form-group">
                                <label class="" for="pass">Maximum Temperature</label>
                            </div>
                            <div class="col-sm-7 form-group">
                                <select id="max_id_gb" name="maxTemp" class="form-control" data-validation="required"
                                        data-validation-error-msg="Select Maximum Temperature">
                                    <option value="">Select Max Temperature</option>

                                    <option value="-29" ng-selected="-29 == max_temp">-29°c</option>
                                    <option value="-28" ng-selected="-28 == max_temp">-28°c</option>
                                    <option value="-27" ng-selected="-27 == max_temp">-27°c</option>
                                    <option value="-26" ng-selected="-26 == max_temp">-26°c</option>
                                    <option value="-25" ng-selected="-25 == max_temp">-25°c</option>
                                    <option value="-24" ng-selected="-24 == max_temp">-24°c</option>
                                    <option value="-23" ng-selected="-23 == max_temp">-23°c</option>
                                    <option value="-22" ng-selected="-22 == max_temp">-22°c</option>
                                    <option value="-21" ng-selected="-21 == max_temp">-21°c</option>
                                    <option value="-20" ng-selected="-20 == max_temp">-20°c</option>
                                    <option value="-19" ng-selected="-19 == max_temp">-19°c</option>
                                    <option value="-18" ng-selected="-18 == max_temp">-18°c</option>
                                    <option value="-17" ng-selected="-17 == max_temp">-17°c</option>
                                    <option value="-16" ng-selected="-16 == max_temp">-16°c</option>
                                    <option value="-15" ng-selected="-15 == max_temp">-15°c</option>
                                    <option value="-14" ng-selected="-14 == max_temp">-14°c</option>
                                    <option value="-13" ng-selected="-13 == max_temp">-13°c</option>
                                    <option value="-12" ng-selected="-12 == max_temp">-12°c</option>
                                    <option value="-11" ng-selected="-11 == max_temp">-11°c</option>
                                    <option value="-10" ng-selected="-10 == max_temp">-10°c</option>
                                    <option value="-9" ng-selected="-9 == max_temp">-9°c</option>
                                    <option value="-8" ng-selected="-8 == max_temp">-8°c</option>
                                    <option value="-7" ng-selected="-7 == max_temp">-7°c</option>
                                    <option value="-6" ng-selected="-6 == max_temp">-6°c</option>
                                    <option value="-5" ng-selected="-5 == max_temp">-5°c</option>
                                    <option value="-4" ng-selected="-4 == max_temp">-4°c</option>
                                    <option value="-3" ng-selected="-3 == max_temp">-3°c</option>
                                    <option value="-2" ng-selected="-2 == max_temp">-2°c</option>
                                    <option value="-1" ng-selected="-1 == max_temp">-1°c</option>
                                    <option value="0" ng-selected="0 == max_temp">0°c</option>
                                    <option value="1" ng-selected="1 == max_temp">1°c</option>
                                    <option value="2" ng-selected="2 == max_temp">2°c</option>
                                    <option value="3" ng-selected="3 == max_temp">3°c</option>
                                    <option value="4" ng-selected="4 == max_temp">4°c</option>
                                    <option value="5" ng-selected="5 == max_temp">5°c</option>
                                    <option value="6" ng-selected="6 == max_temp">6°c</option>
                                    <option value="7" ng-selected="7 == max_temp">7°c</option>
                                    <option value="8" ng-selected="8 == max_temp">8°c</option>
                                    <option value="9" ng-selected="9 == max_temp">9°c</option>
                                    <option value="10" ng-selected="10 == max_temp">10°c</option>
                                    <option value="11" ng-selected="11 == max_temp">11°c</option>
                                    <option value="12" ng-selected="12 == max_temp">12°c</option>
                                    <option value="13" ng-selected="13 == max_temp">13°c</option>
                                    <option value="14" ng-selected="14 == max_temp">14°c</option>
                                    <option value="15" ng-selected="15 == max_temp">15°c</option>
                                    <option value="16" ng-selected="16 == max_temp">16°c</option>
                                    <option value="17" ng-selected="17 == max_temp">17°c</option>
                                    <option value="18" ng-selected="18 == max_temp">18°c</option>
                                    <option value="19" ng-selected="19 == max_temp">19°c</option>
                                    <option value="20" ng-selected="20 == max_temp">20°c</option>
                                    <option value="21" ng-selected="21 == max_temp">21°c</option>
                                    <option value="22" ng-selected="22 == max_temp">22°c</option>
                                    <option value="23" ng-selected="23 == max_temp">23°c</option>
                                    <option value="24" ng-selected="24 == max_temp">24°c</option>
                                    <option value="25" ng-selected="25 == max_temp">25°c</option>
                                    <option value="26" ng-selected="26 == max_temp">26°c</option>
                                    <option value="27" ng-selected="27 == max_temp">27°c</option>
                                    <option value="28" ng-selected="28 == max_temp">28°c</option>
                                    <option value="29" ng-selected="29 == max_temp">29°c</option>
                                    <option value="30" ng-selected="30 == max_temp">30°c</option>
                                    <option value="31" ng-selected="31 == max_temp">31°c</option>
                                    <option value="32" ng-selected="32 == max_temp">32°c</option>
                                    <option value="33" ng-selected="33 == max_temp">33°c</option>
                                    <option value="34" ng-selected="34 == max_temp">34°c</option>
                                    <option value="35" ng-selected="35 == max_temp">35°c</option>
                                    <option value="36" ng-selected="36 == max_temp">36°c</option>
                                    <option value="37" ng-selected="37 == max_temp">37°c</option>
                                    <option value="38" ng-selected="38 == max_temp">38°c</option>
                                    <option value="39" ng-selected="39 == max_temp">39°c</option>
                                    <option value="40" ng-selected="40 == max_temp">40°c</option>
                                    <option value="41" ng-selected="41 == max_temp">41°c</option>
                                    <option value="42" ng-selected="42 == max_temp">42°c</option>
                                    <option value="43" ng-selected="43 == max_temp">43°c</option>
                                    <option value="44" ng-selected="44 == max_temp">44°c</option>
                                    <option value="45" ng-selected="45 == max_temp">45°c</option>
                                    <option value="46" ng-selected="46 == max_temp">46°c</option>
                                    <option value="47" ng-selected="47 == max_temp">47°c</option>
                                    <option value="48" ng-selected="48 == max_temp">48°c</option>
                                    <option value="49" ng-selected="49 == max_temp">49°c</option>
                                    <option value="50" ng-selected="50 == max_temp">50°c</option>
                                    <option value="51" ng-selected="51 == max_temp">51°c</option>
                                    <option value="52" ng-selected="52 == max_temp">52°c</option>
                                    <option value="53" ng-selected="53 == max_temp">53°c</option>
                                    <option value="54" ng-selected="54 == max_temp">54°c</option>
                                    <option value="55" ng-selected="55 == max_temp">55°c</option>
                                    <option value="56" ng-selected="56 == max_temp">56°c</option>
                                    <option value="57" ng-selected="57 == max_temp">57°c</option>
                                    <option value="58" ng-selected="58 == max_temp">58°c</option>
                                    <option value="59" ng-selected="59 == max_temp">59°c</option>
                                    <option value="60" ng-selected="60 == max_temp">60°c</option>

                                </select>
                            </div>

                            <div class="col-sm-4 form-group">
                                <label class="" for="pass">Weather Condition</label>
                            </div>
                            <div class="col-sm-7 form-group">
                                <div class="">
                                    <select id="weather_id_gb" name="weather" class="form-control" data-validation="required"
                                            data-validation-error-msg="Select Weather Condition">
                                        <option value="">Select Weather Condition</option>
                                        <option value={{c.id}} ng-repeat="c in kansas_conditions"
                                                ng-selected="{{c.id == today_condition_id}}">{{c.condition}}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4 form-group">
                                <label class="" for="pass">3 Day Weather Condition</label>
                            </div>
                            <div class="col-sm-7 form-group">

                                <div class="">
                                    <select id="weather_day_id_gb" name="weather_3day" class="form-control"
                                            data-validation="required" autofocus
                                            data-validation-error-msg="Select 3 Day Weather Condition">
                                        <option value="">Select 3 Day Weather Condition</option>
                                        <option value={{f.id}} ng-repeat="f in kansas_future_conditions"
                                                ng-selected="{{f.id == future_condition_id}}">{{f.future_condition}}
                                        </option>
                                    </select>
                                </div>
                            </div>
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
                                <select id="eve_min_id" name="eve_minTemp" class="form-control" data-validation="required"
                                        data-validation-error-msg="Select Minimum Temperature">
                                    <option value="">Select Min Temperature</option>

                                    <option value="-30" ng-selected="-30 == eve_min_temp">-30°c</option>
                                    <option value="-29" ng-selected="-29 == eve_min_temp">-29°c</option>
                                    <option value="-28" ng-selected="-28 == eve_min_temp">-28°c</option>
                                    <option value="-27" ng-selected="-27 == eve_min_temp">-27°c</option>
                                    <option value="-26" ng-selected="-26 == eve_min_temp">-26°c</option>
                                    <option value="-25" ng-selected="-25 == eve_min_temp">-25°c</option>
                                    <option value="-24" ng-selected="-24 == eve_min_temp">-24°c</option>
                                    <option value="-23" ng-selected="-23 == eve_min_temp">-23°c</option>
                                    <option value="-22" ng-selected="-22 == eve_min_temp">-22°c</option>
                                    <option value="-21" ng-selected="-21 == eve_min_temp">-21°c</option>
                                    <option value="-20" ng-selected="-20 == eve_min_temp">-20°c</option>
                                    <option value="-19" ng-selected="-19 == eve_min_temp">-19°c</option>
                                    <option value="-18" ng-selected="-18 == eve_min_temp">-18°c</option>
                                    <option value="-17" ng-selected="-17 == eve_min_temp">-17°c</option>
                                    <option value="-16" ng-selected="-16 == eve_min_temp">-16°c</option>
                                    <option value="-15" ng-selected="-15 == eve_min_temp">-15°c</option>
                                    <option value="-14" ng-selected="-14 == eve_min_temp">-14°c</option>
                                    <option value="-13" ng-selected="-13 == eve_min_temp">-13°c</option>
                                    <option value="-12" ng-selected="-12 == eve_min_temp">-12°c</option>
                                    <option value="-11" ng-selected="-11 == eve_min_temp">-11°c</option>
                                    <option value="-10" ng-selected="-10 == eve_min_temp">-10°c</option>
                                    <option value="-9" ng-selected="-9 == eve_min_temp">-9°c</option>
                                    <option value="-8" ng-selected="-8 == eve_min_temp">-8°c</option>
                                    <option value="-7" ng-selected="-7 == eve_min_temp">-7°c</option>
                                    <option value="-6" ng-selected="-6 == eve_min_temp">-6°c</option>

                                    <option value="-5" ng-selected="-5 == eve_min_temp">-5°c</option>
                                    <option value="-4" ng-selected="-4 == eve_min_temp">-4°c</option>
                                    <option value="-3" ng-selected="-3 == eve_min_temp">-3°c</option>
                                    <option value="-2" ng-selected="-2 == eve_min_temp">-2°c</option>
                                    <option value="-1" ng-selected="-1 == eve_min_temp">-1°c</option>
                                    <option value="0" ng-selected="0 == eve_min_temp">0°c</option>
                                    <option value="1" ng-selected="1 == eve_min_temp">1°c</option>
                                    <option value="2" ng-selected="2 == eve_min_temp">2°c</option>
                                    <option value="3" ng-selected="3 == eve_min_temp">3°c</option>
                                    <option value="4" ng-selected="4 == eve_min_temp">4°c</option>
                                    <option value="5" ng-selected="5 == eve_min_temp">5°c</option>
                                    <option value="6" ng-selected="6 == eve_min_temp">6°c</option>
                                    <option value="7" ng-selected="7 == eve_min_temp">7°c</option>
                                    <option value="8" ng-selected="8 == eve_min_temp">8°c</option>
                                    <option value="9" ng-selected="9 == eve_min_temp">9°c</option>
                                    <option value="10" ng-selected="10 == eve_min_temp">10°c</option>
                                    <option value="11" ng-selected="11 == eve_min_temp">11°c</option>
                                    <option value="12" ng-selected="12 == eve_min_temp">12°c</option>
                                    <option value="13" ng-selected="13 == eve_min_temp">13°c</option>
                                    <option value="14" ng-selected="14 == eve_min_temp">14°c</option>
                                    <option value="15" ng-selected="15 == eve_min_temp">15°c</option>
                                    <option value="16" ng-selected="16 == eve_min_temp">16°c</option>
                                    <option value="17" ng-selected="17 == eve_min_temp">17°c</option>
                                    <option value="18" ng-selected="18 == eve_min_temp">18°c</option>
                                    <option value="19" ng-selected="19 == eve_min_temp">19°c</option>
                                    <option value="20" ng-selected="20 == eve_min_temp">20°c</option>
                                    <option value="21" ng-selected="21 == eve_min_temp">21°c</option>
                                    <option value="22" ng-selected="22 == eve_min_temp">22°c</option>
                                    <option value="23" ng-selected="23 == eve_min_temp">23°c</option>
                                    <option value="24" ng-selected="24 == eve_min_temp">24°c</option>
                                    <option value="25" ng-selected="25 == eve_min_temp">25°c</option>
                                    <option value="26" ng-selected="26 == eve_min_temp">26°c</option>
                                    <option value="27" ng-selected="27 == eve_min_temp">27°c</option>
                                    <option value="28" ng-selected="28 == eve_min_temp">28°c</option>
                                    <option value="29" ng-selected="29 == eve_min_temp">29°c</option>
                                    <option value="30" ng-selected="30 == eve_min_temp">30°c</option>
                                    <option value="31" ng-selected="31 == eve_min_temp">31°c</option>
                                    <option value="32" ng-selected="32 == eve_min_temp">32°c</option>
                                    <option value="33" ng-selected="33 == eve_min_temp">33°c</option>
                                    <option value="34" ng-selected="34 == eve_min_temp">34°c</option>
                                    <option value="35" ng-selected="35 == eve_min_temp">35°c</option>
                                    <option value="36" ng-selected="36 == eve_min_temp">36°c</option>
                                    <option value="37" ng-selected="37 == eve_min_temp">37°c</option>
                                    <option value="38" ng-selected="38 == eve_min_temp">38°c</option>
                                    <option value="39" ng-selected="39 == eve_min_temp">39°c</option>
                                    <option value="40" ng-selected="40 == eve_min_temp">40°c</option>
                                    <option value="41" ng-selected="41 == eve_min_temp">41°c</option>
                                    <option value="42" ng-selected="42 == eve_min_temp">42°c</option>
                                    <option value="43" ng-selected="43 == eve_min_temp">43°c</option>
                                    <option value="44" ng-selected="44 == eve_min_temp">44°c</option>
                                    <option value="45" ng-selected="45 == eve_min_temp">45°c</option>
                                    <option value="46" ng-selected="46 == eve_min_temp">46°c</option>
                                    <option value="47" ng-selected="47 == eve_min_temp">47°c</option>
                                    <option value="48" ng-selected="48 == eve_min_temp">48°c</option>
                                    <option value="49" ng-selected="49 == eve_min_temp">49°c</option>
                                    <option value="50" ng-selected="50 == eve_min_temp">50°c</option>
                                    <option value="51" ng-selected="51 == eve_min_temp">51°c</option>
                                    <option value="52" ng-selected="52 == eve_min_temp">52°c</option>
                                    <option value="53" ng-selected="53 == eve_min_temp">53°c</option>
                                    <option value="54" ng-selected="54 == eve_min_temp">54°c</option>
                                    <option value="55" ng-selected="55 == eve_min_temp">55°c</option>
                                    <option value="56" ng-selected="56 == eve_min_temp">56°c</option>
                                    <option value="57" ng-selected="57 == eve_min_temp">57°c</option>
                                    <option value="58" ng-selected="58 == eve_min_temp">58°c</option>
                                    <option value="59" ng-selected="59 == eve_min_temp">59°c</option>
                                </select>
                            </div>

                            <div class="col-sm-4 form-group">
                                <label class="" for="pass">Maximum Temperature</label>
                            </div>
                            <div class="col-sm-7 form-group">
                                <select id="eve_max_id" name="eve_maxTemp" class="form-control" data-validation="required"
                                        data-validation-error-msg="Select Maximum Temperature">
                                    <option value="">Select Max Temperature</option>

                                    <option value="-29" ng-selected="-29 == eve_max_temp">-29°c</option>
                                    <option value="-28" ng-selected="-28 == eve_max_temp">-28°c</option>
                                    <option value="-27" ng-selected="-27 == eve_max_temp">-27°c</option>
                                    <option value="-26" ng-selected="-26 == eve_max_temp">-26°c</option>
                                    <option value="-25" ng-selected="-25 == eve_max_temp">-25°c</option>
                                    <option value="-24" ng-selected="-24 == eve_max_temp">-24°c</option>
                                    <option value="-23" ng-selected="-23 == eve_max_temp">-23°c</option>
                                    <option value="-22" ng-selected="-22 == eve_max_temp">-22°c</option>
                                    <option value="-21" ng-selected="-21 == eve_max_temp">-21°c</option>
                                    <option value="-20" ng-selected="-20 == eve_max_temp">-20°c</option>
                                    <option value="-19" ng-selected="-19 == eve_max_temp">-19°c</option>
                                    <option value="-18" ng-selected="-18 == eve_max_temp">-18°c</option>
                                    <option value="-17" ng-selected="-17 == eve_max_temp">-17°c</option>
                                    <option value="-16" ng-selected="-16 == eve_max_temp">-16°c</option>
                                    <option value="-15" ng-selected="-15 == eve_max_temp">-15°c</option>
                                    <option value="-14" ng-selected="-14 == eve_max_temp">-14°c</option>
                                    <option value="-13" ng-selected="-13 == eve_max_temp">-13°c</option>
                                    <option value="-12" ng-selected="-12 == eve_max_temp">-12°c</option>
                                    <option value="-11" ng-selected="-11 == eve_max_temp">-11°c</option>
                                    <option value="-10" ng-selected="-10 == eve_max_temp">-10°c</option>
                                    <option value="-9" ng-selected="-9 == eve_max_temp">-9°c</option>
                                    <option value="-8" ng-selected="-8 == eve_max_temp">-8°c</option>
                                    <option value="-7" ng-selected="-7 == eve_max_temp">-7°c</option>
                                    <option value="-6" ng-selected="-6 == eve_max_temp">-6°c</option>
                                    <option value="-5" ng-selected="-5 == eve_max_temp">-5°c</option>
                                    <option value="-4" ng-selected="-4 == eve_max_temp">-4°c</option>
                                    <option value="-3" ng-selected="-3 == eve_max_temp">-3°c</option>
                                    <option value="-2" ng-selected="-2 == eve_max_temp">-2°c</option>
                                    <option value="-1" ng-selected="-1 == eve_max_temp">-1°c</option>
                                    <option value="0" ng-selected="0 == eve_max_temp">0°c</option>
                                    <option value="1" ng-selected="1 == eve_max_temp">1°c</option>
                                    <option value="2" ng-selected="2 == eve_max_temp">2°c</option>
                                    <option value="3" ng-selected="3 == eve_max_temp">3°c</option>
                                    <option value="4" ng-selected="4 == eve_max_temp">4°c</option>
                                    <option value="5" ng-selected="5 == eve_max_temp">5°c</option>
                                    <option value="6" ng-selected="6 == eve_max_temp">6°c</option>
                                    <option value="7" ng-selected="7 == eve_max_temp">7°c</option>
                                    <option value="8" ng-selected="8 == eve_max_temp">8°c</option>
                                    <option value="9" ng-selected="9 == eve_max_temp">9°c</option>
                                    <option value="10" ng-selected="10 == eve_max_temp">10°c</option>
                                    <option value="11" ng-selected="11 == eve_max_temp">11°c</option>
                                    <option value="12" ng-selected="12 == eve_max_temp">12°c</option>
                                    <option value="13" ng-selected="13 == eve_max_temp">13°c</option>
                                    <option value="14" ng-selected="14 == eve_max_temp">14°c</option>
                                    <option value="15" ng-selected="15 == eve_max_temp">15°c</option>
                                    <option value="16" ng-selected="16 == eve_max_temp">16°c</option>
                                    <option value="17" ng-selected="17 == eve_max_temp">17°c</option>
                                    <option value="18" ng-selected="18 == eve_max_temp">18°c</option>
                                    <option value="19" ng-selected="19 == eve_max_temp">19°c</option>
                                    <option value="20" ng-selected="20 == eve_max_temp">20°c</option>
                                    <option value="21" ng-selected="21 == eve_max_temp">21°c</option>
                                    <option value="22" ng-selected="22 == eve_max_temp">22°c</option>
                                    <option value="23" ng-selected="23 == eve_max_temp">23°c</option>
                                    <option value="24" ng-selected="24 == eve_max_temp">24°c</option>
                                    <option value="25" ng-selected="25 == eve_max_temp">25°c</option>
                                    <option value="26" ng-selected="26 == eve_max_temp">26°c</option>
                                    <option value="27" ng-selected="27 == eve_max_temp">27°c</option>
                                    <option value="28" ng-selected="28 == eve_max_temp">28°c</option>
                                    <option value="29" ng-selected="29 == eve_max_temp">29°c</option>
                                    <option value="30" ng-selected="30 == eve_max_temp">30°c</option>
                                    <option value="31" ng-selected="31 == eve_max_temp">31°c</option>
                                    <option value="32" ng-selected="32 == eve_max_temp">32°c</option>
                                    <option value="33" ng-selected="33 == eve_max_temp">33°c</option>
                                    <option value="34" ng-selected="34 == eve_max_temp">34°c</option>
                                    <option value="35" ng-selected="35 == eve_max_temp">35°c</option>
                                    <option value="36" ng-selected="36 == eve_max_temp">36°c</option>
                                    <option value="37" ng-selected="37 == eve_max_temp">37°c</option>
                                    <option value="38" ng-selected="38 == eve_max_temp">38°c</option>
                                    <option value="39" ng-selected="39 == eve_max_temp">39°c</option>
                                    <option value="40" ng-selected="40 == eve_max_temp">40°c</option>
                                    <option value="41" ng-selected="41 == eve_max_temp">41°c</option>
                                    <option value="42" ng-selected="42 == eve_max_temp">42°c</option>
                                    <option value="43" ng-selected="43 == eve_max_temp">43°c</option>
                                    <option value="44" ng-selected="44 == eve_max_temp">44°c</option>
                                    <option value="45" ng-selected="45 == eve_max_temp">45°c</option>
                                    <option value="46" ng-selected="46 == eve_max_temp">46°c</option>
                                    <option value="47" ng-selected="47 == eve_max_temp">47°c</option>
                                    <option value="48" ng-selected="48 == eve_max_temp">48°c</option>
                                    <option value="49" ng-selected="49 == eve_max_temp">49°c</option>
                                    <option value="50" ng-selected="50 == eve_max_temp">50°c</option>
                                    <option value="51" ng-selected="51 == eve_max_temp">51°c</option>
                                    <option value="52" ng-selected="52 == eve_max_temp">52°c</option>
                                    <option value="53" ng-selected="53 == eve_max_temp">53°c</option>
                                    <option value="54" ng-selected="54 == eve_max_temp">54°c</option>
                                    <option value="55" ng-selected="55 == eve_max_temp">55°c</option>
                                    <option value="56" ng-selected="56 == eve_max_temp">56°c</option>
                                    <option value="57" ng-selected="57 == eve_max_temp">57°c</option>
                                    <option value="58" ng-selected="58 == eve_max_temp">58°c</option>
                                    <option value="59" ng-selected="59 == eve_max_temp">59°c</option>
                                    <option value="60" ng-selected="60 == eve_max_temp">60°c</option>

                                </select>
                            </div>

                            <div class="col-sm-4 form-group">
                                <label class="" for="pass">Weather Condition</label>
                            </div>
                            <div class="col-sm-7 form-group">
                                <div class="">

                                    <select id="eve_weather_id" name="eve_weather" class="form-control"
                                            data-validation="required"
                                            data-validation-error-msg="Select Weather Condition">
                                        <option value="">Select Weather Condition</option>
                                        <option value={{c.id}} ng-repeat="c in eve_conditions"
                                                ng-selected="{{c.id == eve_today_condition_id}}">{{c.eve_condition}}
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4 form-group">
                                <label class="" for="pass">Next Few Hours Weather</label>
                            </div>
                            <div class="col-sm-7 form-group">

                                <div class="">

                                    <select id="eve_weather_day_id" name="eve_weather_3day" class="form-control"
                                            data-validation="required"
                                            data-validation-error-msg="Select Next Few Hours Weather">
                                        <option value="">Select Next Few Hours Weather</option>
                                        <option value={{f.id}} ng-repeat="f in kansas_future_conditions"
                                                ng-selected="{{f.id == eve_future_condition_id}}">{{f.eve_future_condition}}
                                        </option>
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
<!--                <div class="row col-sm-11">-->
<!--                    <input id="saveBtn" class=" btn btn-bg center-block pull-right mybtn" name="Save" value=" Save "-->
<!--                           type="submit" style="margin-right: -6%"/>-->
<!--                </div>-->
                <div class="row">
                    <div class="col-sm-11">
                        <button type="submit" class="btn pull-right" style="margin-right: -4%">Save</button>
                    </div>
                </div>
            </form>
        </div>

        <div id="florida" class="tab-pane fade">

            <div class="vert-offset-top-3">

                <form id="weather_form_florida" action="" enctype="multipart/form-data" class="form">

                    <div class="row" >
                        <div class="col-sm-4"></div>

                        <div class="col-sm-2 form-group">
                            <!--                            <label class="">Select Date</label>-->
                            <div class="">
                                <input type="text" id="datepicker_add_florida" name="magri_date" class="form-control" ng-model="date"
                                       value={{date}}/>
                                <input type="hidden" id="id" name="id" value=<?php echo $id ?>>
                            </div>
                        </div>
                        <div class="col-sm-2 form-group">
                            <!--                            <label class="" for="pass">Location</label>-->
                            <div class="">

                                <select id="loc_id_florida" name="location" class="form-control" data-validation="required"
                                        data-validation-error-msg="Select Location">
                                    <option value="">Select Location</option>
                                    <option value="{{loc.id}}" ng-repeat="loc in florida_locations" ng-selected="{{loc.id == location_id}}">{{loc.id | capitalizeWord}}</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row vert-offset-top-1">

                        <div class="col-sm-4 form-group">
                            <label class="pull-right" for="pass">Minimum Temperature</label>
                        </div>
                        <div class="col-sm-4 form-group">
                            <select id="min_id_florida" name="minTemp" class="form-control" data-validation="required"
                                    data-validation-error-msg="Select Minimum Temperature">
                                <option value="">Select Min Temperature</option>

                                <option value="-5" ng-selected="-5 == min_temp">-5°c</option>
                                <option value="-4" ng-selected="-4 == min_temp">-4°c</option>
                                <option value="-3" ng-selected="-3 == min_temp">-3°c</option>
                                <option value="-2" ng-selected="-2 == min_temp">-2°c</option>
                                <option value="-1" ng-selected="-1 == min_temp">-1°c</option>
                                <option value="0" ng-selected="0 == min_temp">0°c</option>
                                <option value="1" ng-selected="1 == min_temp">1°c</option>
                                <option value="2" ng-selected="2 == min_temp">2°c</option>
                                <option value="3" ng-selected="3 == min_temp">3°c</option>
                                <option value="4" ng-selected="4 == min_temp">4°c</option>
                                <option value="5" ng-selected="5 == min_temp">5°c</option>
                                <option value="6" ng-selected="6 == min_temp">6°c</option>
                                <option value="7" ng-selected="7 == min_temp">7°c</option>
                                <option value="8" ng-selected="8 == min_temp">8°c</option>
                                <option value="9" ng-selected="9 == min_temp">9°c</option>
                                <option value="10" ng-selected="10 == min_temp">10°c</option>
                                <option value="11" ng-selected="11 == min_temp">11°c</option>
                                <option value="12" ng-selected="12 == min_temp">12°c</option>
                                <option value="13" ng-selected="13 == min_temp">13°c</option>
                                <option value="14" ng-selected="14 == min_temp">14°c</option>
                                <option value="15" ng-selected="15 == min_temp">15°c</option>
                                <option value="16" ng-selected="16 == min_temp">16°c</option>
                                <option value="17" ng-selected="17 == min_temp">17°c</option>
                                <option value="18" ng-selected="18 == min_temp">18°c</option>
                                <option value="19" ng-selected="19 == min_temp">19°c</option>
                                <option value="20" ng-selected="20 == min_temp">20°c</option>
                                <option value="21" ng-selected="21 == min_temp">21°c</option>
                                <option value="22" ng-selected="22 == min_temp">22°c</option>
                                <option value="23" ng-selected="23 == min_temp">23°c</option>
                                <option value="24" ng-selected="24 == min_temp">24°c</option>
                                <option value="25" ng-selected="25 == min_temp">25°c</option>
                                <option value="26" ng-selected="26 == min_temp">26°c</option>
                                <option value="27" ng-selected="27 == min_temp">27°c</option>
                                <option value="28" ng-selected="28 == min_temp">28°c</option>
                                <option value="29" ng-selected="29 == min_temp">29°c</option>
                                <option value="30" ng-selected="30 == min_temp">30°c</option>
                                <option value="31" ng-selected="31 == min_temp">31°c</option>
                                <option value="32" ng-selected="32 == min_temp">32°c</option>
                                <option value="33" ng-selected="33 == min_temp">33°c</option>
                                <option value="34" ng-selected="34 == min_temp">34°c</option>
                                <option value="35" ng-selected="35 == min_temp">35°c</option>
                                <option value="36" ng-selected="36 == min_temp">36°c</option>
                                <option value="37" ng-selected="37 == min_temp">37°c</option>
                                <option value="38" ng-selected="38 == min_temp">38°c</option>
                                <option value="39" ng-selected="39 == min_temp">39°c</option>
                                <option value="40" ng-selected="40 == min_temp">40°c</option>
                                <option value="41" ng-selected="41 == min_temp">41°c</option>
                                <option value="42" ng-selected="42 == min_temp">42°c</option>
                                <option value="43" ng-selected="43 == min_temp">43°c</option>
                                <option value="44" ng-selected="44 == min_temp">44°c</option>
                                <option value="45" ng-selected="45 == min_temp">45°c</option>
                                <option value="46" ng-selected="46 == min_temp">46°c</option>
                                <option value="47" ng-selected="47 == min_temp">47°c</option>
                                <option value="48" ng-selected="48 == min_temp">48°c</option>
                                <option value="49" ng-selected="49 == min_temp">49°c</option>
                                <option value="50" ng-selected="50 == min_temp">50°c</option>
                                <option value="51" ng-selected="51 == min_temp">51°c</option>
                                <option value="52" ng-selected="52 == min_temp">52°c</option>
                                <option value="53" ng-selected="53 == min_temp">53°c</option>
                                <option value="54" ng-selected="54 == min_temp">54°c</option>
                                <option value="55" ng-selected="55 == min_temp">55°c</option>
                                <option value="56" ng-selected="56 == min_temp">56°c</option>
                                <option value="57" ng-selected="57 == min_temp">57°c</option>
                                <option value="58" ng-selected="58 == min_temp">58°c</option>
                                <option value="59" ng-selected="59 == min_temp">59°c</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 form-group">
                            <label class="pull-right" for="pass">Maximum Temperature</label>
                        </div>
                        <div class="col-sm-4 form-group">
                            <select id="max_id_florida" name="maxTemp" class="form-control" data-validation="required"
                                    data-validation-error-msg="Select Maximum Temperature">
                                <option value="">Select Max Temperature</option>

                                <option value="-4" ng-selected="-4 == max_temp">-4°c</option>
                                <option value="-3" ng-selected="-3 == max_temp">-3°c</option>
                                <option value="-2" ng-selected="-2 == max_temp">-2°c</option>
                                <option value="-1" ng-selected="-1 == max_temp">-1°c</option>
                                <option value="0" ng-selected="0 == max_temp">0°c</option>
                                <option value="1" ng-selected="1 == max_temp">1°c</option>
                                <option value="2" ng-selected="2 == max_temp">2°c</option>
                                <option value="3" ng-selected="3 == max_temp">3°c</option>
                                <option value="4" ng-selected="4 == max_temp">4°c</option>
                                <option value="5" ng-selected="5 == max_temp">5°c</option>
                                <option value="6" ng-selected="6 == max_temp">6°c</option>
                                <option value="7" ng-selected="7 == max_temp">7°c</option>
                                <option value="8" ng-selected="8 == max_temp">8°c</option>
                                <option value="9" ng-selected="9 == max_temp">9°c</option>
                                <option value="10" ng-selected="10 == max_temp">10°c</option>
                                <option value="11" ng-selected="11 == max_temp">11°c</option>
                                <option value="12" ng-selected="12 == max_temp">12°c</option>
                                <option value="13" ng-selected="13 == max_temp">13°c</option>
                                <option value="14" ng-selected="14 == max_temp">14°c</option>
                                <option value="15" ng-selected="15 == max_temp">15°c</option>
                                <option value="16" ng-selected="16 == max_temp">16°c</option>
                                <option value="17" ng-selected="17 == max_temp">17°c</option>
                                <option value="18" ng-selected="18 == max_temp">18°c</option>
                                <option value="19" ng-selected="19 == max_temp">19°c</option>
                                <option value="20" ng-selected="20 == max_temp">20°c</option>
                                <option value="21" ng-selected="21 == max_temp">21°c</option>
                                <option value="22" ng-selected="22 == max_temp">22°c</option>
                                <option value="23" ng-selected="23 == max_temp">23°c</option>
                                <option value="24" ng-selected="24 == max_temp">24°c</option>
                                <option value="25" ng-selected="25 == max_temp">25°c</option>
                                <option value="26" ng-selected="26 == max_temp">26°c</option>
                                <option value="27" ng-selected="27 == max_temp">27°c</option>
                                <option value="28" ng-selected="28 == max_temp">28°c</option>
                                <option value="29" ng-selected="29 == max_temp">29°c</option>
                                <option value="30" ng-selected="30 == max_temp">30°c</option>
                                <option value="31" ng-selected="31 == max_temp">31°c</option>
                                <option value="32" ng-selected="32 == max_temp">32°c</option>
                                <option value="33" ng-selected="33 == max_temp">33°c</option>
                                <option value="34" ng-selected="34 == max_temp">34°c</option>
                                <option value="35" ng-selected="35 == max_temp">35°c</option>
                                <option value="36" ng-selected="36 == max_temp">36°c</option>
                                <option value="37" ng-selected="37 == max_temp">37°c</option>
                                <option value="38" ng-selected="38 == max_temp">38°c</option>
                                <option value="39" ng-selected="39 == max_temp">39°c</option>
                                <option value="40" ng-selected="40 == max_temp">40°c</option>
                                <option value="41" ng-selected="41 == max_temp">41°c</option>
                                <option value="42" ng-selected="42 == max_temp">42°c</option>
                                <option value="43" ng-selected="43 == max_temp">43°c</option>
                                <option value="44" ng-selected="44 == max_temp">44°c</option>
                                <option value="45" ng-selected="45 == max_temp">45°c</option>
                                <option value="46" ng-selected="46 == max_temp">46°c</option>
                                <option value="47" ng-selected="47 == max_temp">47°c</option>
                                <option value="48" ng-selected="48 == max_temp">48°c</option>
                                <option value="49" ng-selected="49 == max_temp">49°c</option>
                                <option value="50" ng-selected="50 == max_temp">50°c</option>
                                <option value="51" ng-selected="51 == max_temp">51°c</option>
                                <option value="52" ng-selected="52 == max_temp">52°c</option>
                                <option value="53" ng-selected="53 == max_temp">53°c</option>
                                <option value="54" ng-selected="54 == max_temp">54°c</option>
                                <option value="55" ng-selected="55 == max_temp">55°c</option>
                                <option value="56" ng-selected="56 == max_temp">56°c</option>
                                <option value="57" ng-selected="57 == max_temp">57°c</option>
                                <option value="58" ng-selected="58 == max_temp">58°c</option>
                                <option value="59" ng-selected="59 == max_temp">59°c</option>
                                <option value="60" ng-selected="60 == max_temp">60°c</option>

                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 form-group">
                            <label class="pull-right" for="pass">Weather Condition</label>
                        </div>
                        <div class="col-sm-4 form-group">
                            <div class="">
                                <select id="weather_id_florida" name="weather" class="form-control" data-validation="required"
                                        data-validation-error-msg="Select Weather Condition">
                                    <option value="">Select Weather Condition</option>
                                    <option value={{c.id}} ng-repeat="c in pu_conditions"
                                            ng-selected="{{c.id == today_condition_id}}">{{c.condition}}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-sm-4 form-group">
                            <label class="pull-right" for="pass">3 Day Weather Condition</label>
                        </div>
                        <div class="col-sm-4 form-group">

                            <div class="">
                                <select id="weather_day_id_florida" name="weather_3day" class="form-control"
                                        data-validation="required" autofocus
                                        data-validation-error-msg="Select 3 Day Weather Condition">
                                    <option value="">Select 3 Day Weather Condition</option>
                                    <option value={{f.id}} ng-repeat="f in pu_future_conditions"
                                            ng-selected="{{f.id == future_condition_id}}">{{f.future_condition}}
                                    </option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <button type="submit" class="btn pull-right">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="hawaii" class="tab-pane fade">

            <div class="vert-offset-top-3">

                <form id="weather_form_hawaii" action="" enctype="multipart/form-data" class="form">

                    <div class="row" >
                        <div class="col-sm-4"></div>

                        <div class="col-sm-2 form-group">
                            <!--                            <label class="">Select Date</label>-->
                            <div class="">
                                <input type="text" id="datepicker_add_hawaii" name="magri_date" class="form-control" ng-model="date"
                                       value={{date}}/>
                                <input type="hidden" id="id" name="id" value=<?php echo $id ?>>
                            </div>
                        </div>
                        <div class="col-sm-2 form-group">
                            <!--                            <label class="" for="pass">Location</label>-->
                            <div class="">

                                <select id="loc_id_hawaii" name="location" class="form-control" data-validation="required"
                                        data-validation-error-msg="Select Location">
                                    <option value="">Select Location</option>
                                    <option value="{{loc.id}}" ng-repeat="loc in hawaii_locations" ng-selected="{{loc.id == location_id}}">{{loc.id | capitalizeWord}}</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row vert-offset-top-1">

                        <div class="col-sm-4 form-group">
                            <label class="pull-right" for="pass">Minimum Temperature</label>
                        </div>
                        <div class="col-sm-4 form-group">
                            <select id="min_id_hawaii" name="minTemp" class="form-control" data-validation="required"
                                    data-validation-error-msg="Select Minimum Temperature">
                                <option value="">Select Min Temperature</option>

                                <option value="-5" ng-selected="-5 == min_temp">-5°c</option>
                                <option value="-4" ng-selected="-4 == min_temp">-4°c</option>
                                <option value="-3" ng-selected="-3 == min_temp">-3°c</option>
                                <option value="-2" ng-selected="-2 == min_temp">-2°c</option>
                                <option value="-1" ng-selected="-1 == min_temp">-1°c</option>
                                <option value="0" ng-selected="0 == min_temp">0°c</option>
                                <option value="1" ng-selected="1 == min_temp">1°c</option>
                                <option value="2" ng-selected="2 == min_temp">2°c</option>
                                <option value="3" ng-selected="3 == min_temp">3°c</option>
                                <option value="4" ng-selected="4 == min_temp">4°c</option>
                                <option value="5" ng-selected="5 == min_temp">5°c</option>
                                <option value="6" ng-selected="6 == min_temp">6°c</option>
                                <option value="7" ng-selected="7 == min_temp">7°c</option>
                                <option value="8" ng-selected="8 == min_temp">8°c</option>
                                <option value="9" ng-selected="9 == min_temp">9°c</option>
                                <option value="10" ng-selected="10 == min_temp">10°c</option>
                                <option value="11" ng-selected="11 == min_temp">11°c</option>
                                <option value="12" ng-selected="12 == min_temp">12°c</option>
                                <option value="13" ng-selected="13 == min_temp">13°c</option>
                                <option value="14" ng-selected="14 == min_temp">14°c</option>
                                <option value="15" ng-selected="15 == min_temp">15°c</option>
                                <option value="16" ng-selected="16 == min_temp">16°c</option>
                                <option value="17" ng-selected="17 == min_temp">17°c</option>
                                <option value="18" ng-selected="18 == min_temp">18°c</option>
                                <option value="19" ng-selected="19 == min_temp">19°c</option>
                                <option value="20" ng-selected="20 == min_temp">20°c</option>
                                <option value="21" ng-selected="21 == min_temp">21°c</option>
                                <option value="22" ng-selected="22 == min_temp">22°c</option>
                                <option value="23" ng-selected="23 == min_temp">23°c</option>
                                <option value="24" ng-selected="24 == min_temp">24°c</option>
                                <option value="25" ng-selected="25 == min_temp">25°c</option>
                                <option value="26" ng-selected="26 == min_temp">26°c</option>
                                <option value="27" ng-selected="27 == min_temp">27°c</option>
                                <option value="28" ng-selected="28 == min_temp">28°c</option>
                                <option value="29" ng-selected="29 == min_temp">29°c</option>
                                <option value="30" ng-selected="30 == min_temp">30°c</option>
                                <option value="31" ng-selected="31 == min_temp">31°c</option>
                                <option value="32" ng-selected="32 == min_temp">32°c</option>
                                <option value="33" ng-selected="33 == min_temp">33°c</option>
                                <option value="34" ng-selected="34 == min_temp">34°c</option>
                                <option value="35" ng-selected="35 == min_temp">35°c</option>
                                <option value="36" ng-selected="36 == min_temp">36°c</option>
                                <option value="37" ng-selected="37 == min_temp">37°c</option>
                                <option value="38" ng-selected="38 == min_temp">38°c</option>
                                <option value="39" ng-selected="39 == min_temp">39°c</option>
                                <option value="40" ng-selected="40 == min_temp">40°c</option>
                                <option value="41" ng-selected="41 == min_temp">41°c</option>
                                <option value="42" ng-selected="42 == min_temp">42°c</option>
                                <option value="43" ng-selected="43 == min_temp">43°c</option>
                                <option value="44" ng-selected="44 == min_temp">44°c</option>
                                <option value="45" ng-selected="45 == min_temp">45°c</option>
                                <option value="46" ng-selected="46 == min_temp">46°c</option>
                                <option value="47" ng-selected="47 == min_temp">47°c</option>
                                <option value="48" ng-selected="48 == min_temp">48°c</option>
                                <option value="49" ng-selected="49 == min_temp">49°c</option>
                                <option value="50" ng-selected="50 == min_temp">50°c</option>
                                <option value="51" ng-selected="51 == min_temp">51°c</option>
                                <option value="52" ng-selected="52 == min_temp">52°c</option>
                                <option value="53" ng-selected="53 == min_temp">53°c</option>
                                <option value="54" ng-selected="54 == min_temp">54°c</option>
                                <option value="55" ng-selected="55 == min_temp">55°c</option>
                                <option value="56" ng-selected="56 == min_temp">56°c</option>
                                <option value="57" ng-selected="57 == min_temp">57°c</option>
                                <option value="58" ng-selected="58 == min_temp">58°c</option>
                                <option value="59" ng-selected="59 == min_temp">59°c</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 form-group">
                            <label class="pull-right" for="pass">Maximum Temperature</label>
                        </div>
                        <div class="col-sm-4 form-group">
                            <select id="max_id_hawaii" name="maxTemp" class="form-control" data-validation="required"
                                    data-validation-error-msg="Select Maximum Temperature">
                                <option value="">Select Max Temperature</option>

                                <option value="-4" ng-selected="-4 == max_temp">-4°c</option>
                                <option value="-3" ng-selected="-3 == max_temp">-3°c</option>
                                <option value="-2" ng-selected="-2 == max_temp">-2°c</option>
                                <option value="-1" ng-selected="-1 == max_temp">-1°c</option>
                                <option value="0" ng-selected="0 == max_temp">0°c</option>
                                <option value="1" ng-selected="1 == max_temp">1°c</option>
                                <option value="2" ng-selected="2 == max_temp">2°c</option>
                                <option value="3" ng-selected="3 == max_temp">3°c</option>
                                <option value="4" ng-selected="4 == max_temp">4°c</option>
                                <option value="5" ng-selected="5 == max_temp">5°c</option>
                                <option value="6" ng-selected="6 == max_temp">6°c</option>
                                <option value="7" ng-selected="7 == max_temp">7°c</option>
                                <option value="8" ng-selected="8 == max_temp">8°c</option>
                                <option value="9" ng-selected="9 == max_temp">9°c</option>
                                <option value="10" ng-selected="10 == max_temp">10°c</option>
                                <option value="11" ng-selected="11 == max_temp">11°c</option>
                                <option value="12" ng-selected="12 == max_temp">12°c</option>
                                <option value="13" ng-selected="13 == max_temp">13°c</option>
                                <option value="14" ng-selected="14 == max_temp">14°c</option>
                                <option value="15" ng-selected="15 == max_temp">15°c</option>
                                <option value="16" ng-selected="16 == max_temp">16°c</option>
                                <option value="17" ng-selected="17 == max_temp">17°c</option>
                                <option value="18" ng-selected="18 == max_temp">18°c</option>
                                <option value="19" ng-selected="19 == max_temp">19°c</option>
                                <option value="20" ng-selected="20 == max_temp">20°c</option>
                                <option value="21" ng-selected="21 == max_temp">21°c</option>
                                <option value="22" ng-selected="22 == max_temp">22°c</option>
                                <option value="23" ng-selected="23 == max_temp">23°c</option>
                                <option value="24" ng-selected="24 == max_temp">24°c</option>
                                <option value="25" ng-selected="25 == max_temp">25°c</option>
                                <option value="26" ng-selected="26 == max_temp">26°c</option>
                                <option value="27" ng-selected="27 == max_temp">27°c</option>
                                <option value="28" ng-selected="28 == max_temp">28°c</option>
                                <option value="29" ng-selected="29 == max_temp">29°c</option>
                                <option value="30" ng-selected="30 == max_temp">30°c</option>
                                <option value="31" ng-selected="31 == max_temp">31°c</option>
                                <option value="32" ng-selected="32 == max_temp">32°c</option>
                                <option value="33" ng-selected="33 == max_temp">33°c</option>
                                <option value="34" ng-selected="34 == max_temp">34°c</option>
                                <option value="35" ng-selected="35 == max_temp">35°c</option>
                                <option value="36" ng-selected="36 == max_temp">36°c</option>
                                <option value="37" ng-selected="37 == max_temp">37°c</option>
                                <option value="38" ng-selected="38 == max_temp">38°c</option>
                                <option value="39" ng-selected="39 == max_temp">39°c</option>
                                <option value="40" ng-selected="40 == max_temp">40°c</option>
                                <option value="41" ng-selected="41 == max_temp">41°c</option>
                                <option value="42" ng-selected="42 == max_temp">42°c</option>
                                <option value="43" ng-selected="43 == max_temp">43°c</option>
                                <option value="44" ng-selected="44 == max_temp">44°c</option>
                                <option value="45" ng-selected="45 == max_temp">45°c</option>
                                <option value="46" ng-selected="46 == max_temp">46°c</option>
                                <option value="47" ng-selected="47 == max_temp">47°c</option>
                                <option value="48" ng-selected="48 == max_temp">48°c</option>
                                <option value="49" ng-selected="49 == max_temp">49°c</option>
                                <option value="50" ng-selected="50 == max_temp">50°c</option>
                                <option value="51" ng-selected="51 == max_temp">51°c</option>
                                <option value="52" ng-selected="52 == max_temp">52°c</option>
                                <option value="53" ng-selected="53 == max_temp">53°c</option>
                                <option value="54" ng-selected="54 == max_temp">54°c</option>
                                <option value="55" ng-selected="55 == max_temp">55°c</option>
                                <option value="56" ng-selected="56 == max_temp">56°c</option>
                                <option value="57" ng-selected="57 == max_temp">57°c</option>
                                <option value="58" ng-selected="58 == max_temp">58°c</option>
                                <option value="59" ng-selected="59 == max_temp">59°c</option>
                                <option value="60" ng-selected="60 == max_temp">60°c</option>

                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 form-group">
                            <label class="pull-right" for="pass">Weather Condition</label>
                        </div>
                        <div class="col-sm-4 form-group">
                            <div class="">
                                <select id="weather_id_hawaii" name="weather" class="form-control" data-validation="required"
                                        data-validation-error-msg="Select Weather Condition">
                                    <option value="">Select Weather Condition</option>
                                    <option value={{c.id}} ng-repeat="c in pu_conditions"
                                            ng-selected="{{c.id == today_condition_id}}">{{c.condition}}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-sm-4 form-group">
                            <label class="pull-right" for="pass">3 Day Weather Condition</label>
                        </div>
                        <div class="col-sm-4 form-group">

                            <div class="">
                                <select id="weather_day_id_hawaii" name="weather_3day" class="form-control"
                                        data-validation="required" autofocus
                                        data-validation-error-msg="Select 3 Day Weather Condition">
                                    <option value="">Select 3 Day Weather Condition</option>
                                    <option value={{f.id}} ng-repeat="f in pu_future_conditions"
                                            ng-selected="{{f.id == future_condition_id}}">{{f.future_condition}}
                                    </option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <button type="submit" class="btn pull-right">Save</button>
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
    type = "text/javascript" >
        $(function () {
            var dateToday = new Date();
            $('input[name="magri_date"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns   : true,
                minDate         : dateToday
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
    $(document).ready(function () {
        $('#loc_id').on('change', function () {
            $("#min_id").focus();
        });
        $('#min_id').on('change', function () {
            $("#max_id").focus();
        });
        $('#max_id').on('change', function () {
            $("#weather_id").focus();
        });
        $('#weather_id').on('change', function () {
            $("#weather_day_id").focus();
        });
        $('#weather_day_id').on('change', function () {
            $("#loc_id").focus();
        });


        // ################# GB Start
        $('#loc_id_gb').on('change', function () {
            $("#min_id_gb").focus();
        });
        $('#min_id_gb').on('change', function () {
            $("#max_id_gb").focus();
        });
        $('#max_id_gb').on('change', function () {
            $("#weather_id_gb").focus();
        });
        $('#weather_id_gb').on('change', function () {
            $("#weather_day_id_gb").focus();
        });
        $('#weather_day_id_gb').on('change', function () {
            $("#eve_min_id").focus();
        });

        $('#eve_min_id').on('change', function () {
            $("#eve_max_id").focus();
        });
        $('#eve_max_id').on('change', function () {
            $("#eve_weather_id").focus();
        });
        $('#eve_weather_id').on('change', function () {
            $("#eve_weather_day_id").focus();
        });

        $('#eve_weather_day_id').on('change', function () {
            $("#loc_id_gb").focus();
        });

        // ################# florida start

        $('#loc_id_florida').on('change', function () {
            $("#min_id_florida").focus();
        });
        $('#min_id_florida').on('change', function () {
            $("#max_id_florida").focus();
        });
        $('#max_id_florida').on('change', function () {
            $("#weather_id_florida").focus();
        });
        $('#weather_id_florida').on('change', function () {
            $("#weather_day_id_florida").focus();
        });
        $('#weather_day_id_florida').on('change', function () {
            $("#loc_id_florida").focus();
        });

        // ################# hawaii start

        $('#loc_id_hawaii').on('change', function () {
            $("#min_id_hawaii").focus();
        });
        $('#min_id_hawaii').on('change', function () {
            $("#max_id_hawaii").focus();
        });
        $('#max_id_hawaii').on('change', function () {
            $("#weather_id_hawaii").focus();
        });
        $('#weather_id_hawaii').on('change', function () {
            $("#weather_day_id_hawaii").focus();
        });
        $('#weather_day_id_hawaii').on('change', function () {
            $("#loc_id_hawaii").focus();
        });



        $("#datepicker_add").on('change', function (event) {

            var date    = $('#datepicker_add').val().split("/");
            var newDate = date[2] + '-' + date[0] + '-' + date[1];
            var scope   = angular.element("#controler_id").scope();
            scope.loadDataAddWeather(newDate);
        });

        $("#datepicker_add_gb").on('change', function (event) {

            var date    = $("#datepicker_add_gb").val().split("/");
            var newDate = date[2] + '-' + date[0] + '-' + date[1];
            var scope   = angular.element("#controler_id").scope();
            scope.loadDataAddWeather(newDate);
        });

        $("#datepicker_add_florida").on('change', function (event) {

            var date    = $("#datepicker_add_florida").val().split("/");

            var newDate = date[2] + '-' + date[0] + '-' + date[1];
            var scope   = angular.element("#controler_id").scope();
            scope.loadDataAddWeather(newDate);
        });

    });

</script>
<script>
    var $loading = $('#loadingDiv').hide();
    $(document)
        .ajaxStart(function () {
            $loading.show();
        })
        .ajaxStop(function () {
            $loading.hide();
        });
</script>
<script>

    $("#weather_form").submit(function (e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.

        if (parseInt($('#min_id').val()) < parseInt($('#max_id').val())) {
            var date     = $('#datepicker_add').val().split("/");
            var newDate  = date[2] + '-' + date[0] + '-' + date[1];
            var formdata = new FormData(this);
            formdata.append('newDate', newDate);
            formdata.append('state', 'missouri');

            $.ajax({
                type       : "POST",
                url        : '../service/sr_saveEditedData.php',
                data       : formdata,
                dataType   : 'json',
                processData: false,
                contentType: false,
                cache      : false,
                success    : function (data) {
                    if (data.success > 0) {
                        console.log('SUCESS: ' + JSON.stringify(data));
                        window.location = 'verify_weather.php?id=' + data.last_id;
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

                },
                error      : function (data) {
                    console.log(data);
                }
            });
        }
        else {
            var error = "Maximum temperature should be greater than Minimum temperature";
            $.notify({
                title  : '<strong>Warning!</strong>',
                message: error
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

    });

</script>

<script>

    $("#weather_form_gb").submit(function (e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.

        //if (parseInt($('#min_id').val()) < parseInt($('#max_id').val()) && parseInt($('#eve_min_id').val()) < parseInt($('#eve_max_id').val())) {
        if (true) {

            var date     = $('#datepicker_add_gb').val().split("/");

            var newDate  = date[2] + '-' + date[0] + '-' + date[1];
            var formdata = new FormData(this);
            formdata.append('newDate', newDate);
            formdata.append('state', 'gb');

            $.ajax({
                type       : "POST",
                url        : '../service/sr_saveEditedData.php',
                data       : formdata,
                dataType   : 'json',
                processData: false,
                contentType: false,
                cache      : false,
                success    : function (data) {
                    if (data.success > 0) {
                        console.log('SUCESS: ' + JSON.stringify(data));
                        window.location = 'verify_weather.php?id=' + data.last_id+'&src='+data.src;
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

                },
                error      : function (data) {
                    console.log(data);
                }
            });
        }
        else {
            var error = "Maximum temperature should be greater than Minimum temperature";
            $.notify({
                title  : '<strong>Warning!</strong>',
                message: error
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

    });
</script>

<script>

    $("#weather_form_florida").submit(function (e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.

        if (parseInt($('#min_id_florida').val()) < parseInt($('#max_id_florida').val())) {
            var date     = $('#datepicker_add_florida').val().split("/");
            var newDate  = date[2] + '-' + date[0] + '-' + date[1];
            var formdata = new FormData(this);
            formdata.append('newDate', newDate);
            formdata.append('state', 'florida');

            $.ajax({
                type       : "POST",
                url        : '../service/sr_saveEditedData.php',
                data       : formdata,
                dataType   : 'json',
                processData: false,
                contentType: false,
                cache      : false,
                success    : function (data) {
                    if (data.success > 0) {
                        console.log('SUCESS: ' + JSON.stringify(data));
                        window.location = 'verify_weather.php?id=' + data.last_id+'&src='+data.src;
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

                },
                error      : function (data) {
                    console.log(data);
                }
            });
        }
        else {
            var error = "Maximum temperature should be greater than Minimum temperature";
            $.notify({
                title  : '<strong>Warning!</strong>',
                message: error
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

    });

</script>


<script>

    $("#weather_form_hawaii").submit(function (e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.

        if (parseInt($('#min_id_hawaii').val()) < parseInt($('#max_id_hawaii').val())) {
            var date     = $('#datepicker_add_hawaii').val().split("/");
            var newDate  = date[2] + '-' + date[0] + '-' + date[1];
            var formdata = new FormData(this);
            formdata.append('newDate', newDate);
            formdata.append('state', 'hawaii');

            $.ajax({
                type       : "POST",
                url        : '../service/sr_saveEditedData.php',
                data       : formdata,
                dataType   : 'json',
                processData: false,
                contentType: false,
                cache      : false,
                success    : function (data) {
                    if (data.success > 0) {
                        console.log('SUCESS: ' + JSON.stringify(data));
                        window.location = 'verify_weather.php?id=' + data.last_id+'&src='+data.src;
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

                },
                error      : function (data) {
                    console.log(data);
                }
            });
        }
        else {
            var error = "Maximum temperature should be greater than Minimum temperature";
            $.notify({
                title  : '<strong>Warning!</strong>',
                message: error
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

    });

</script>



</html>
