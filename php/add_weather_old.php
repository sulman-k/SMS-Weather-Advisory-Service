<html lang="en">
<?php
require_once('in_header.php');

$app_src = isset($_GET["src"]) ? $_GET["src"] : 'pu';
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

    userLogActivity($conn, 'ADD WEATHER');

    ?>


    <div id="loadingDiv" class="overlay">
        <div>
            <img src="../images/loading.svg" alt="Please wait ..." class="load_img"/>
            <input type="hidden" name="app_src" id="app_src" value="<?php echo $app_src ?>">
        </div>
    </div>
    <ul class="nav nav-tabs">
        <li id="pu_tab" class="active"><a data-toggle="tab" href="#missouri">missouri</a></li>
        <li id="kansas_tab" ><a data-toggle="tab" href="#kansas">kansas</a></li>
        <li id="florida_tab" ><a data-toggle="tab" href="#florida">florida</a></li>
        <li id="hawaii_tab" ><a data-toggle="tab" href="#hawaii">hawaii</a></li>
    </ul>

    <div class="tab-content" ng-init="loadDataAddWeather('1')">


        <div id="missouri" class="tab-pane fade in active">

            <div class="vert-offset-top-3" >

                <form id="weather_form" action="" enctype="multipart/form-data" class="form">

                    <div class="row" >
                        <div class="col-sm-4"></div>

                        <div class="col-sm-2 form-group">
<!--                            <label class="">Select Date</label>-->
                            <div class="">
                                <input type="text" id="datepicker_add" name="magri_date" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="col-sm-2 form-group">
<!--                            <label class="" for="pass">Location</label>-->
                            <div class="">
                                <select id="loc_id" name="location" class="form-control" data-validation="required"
                                        data-validation-error-msg="Select Location">
                                    <option value="">Select Location</option>
                                    <option value="{{loc.id}}" ng-repeat="loc in pu_locations ">{{loc.id | capitalizeWord}}
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
                            <select id="min_id" name="minTemp" class="form-control " data-validation="required"
                                    data-validation-error-msg="Select Minimum Temperature" style="line-height: 8px;">
                                <option value="">Select Min Temperature</option>

                                <option value="-5">-5°c</option>
                                <option value="-4">-4°c</option>
                                <option value="-3">-3°c</option>
                                <option value="-2">-2°c</option>
                                <option value="-1">-1°c</option>
                                <option value="0">0°c</option>
                                <option value="1">1°c</option>
                                <option value="2">2°c</option>
                                <option value="3">3°c</option>
                                <option value="4">4°c</option>
                                <option value="5">5°c</option>
                                <option value="6">6°c</option>
                                <option value="7">7°c</option>
                                <option value="8">8°c</option>
                                <option value="9">9°c</option>
                                <option value="10">10°c</option>
                                <option value="11">11°c</option>
                                <option value="12">12°c</option>
                                <option value="13">13°c</option>
                                <option value="14">14°c</option>
                                <option value="15">15°c</option>
                                <option value="16">16°c</option>
                                <option value="17">17°c</option>
                                <option value="18">18°c</option>
                                <option value="19">19°c</option>
                                <option value="20">20°c</option>
                                <option value="21">21°c</option>
                                <option value="22">22°c</option>
                                <option value="23">23°c</option>
                                <option value="24">24°c</option>
                                <option value="25">25°c</option>
                                <option value="26">26°c</option>
                                <option value="27">27°c</option>
                                <option value="28">28°c</option>
                                <option value="29">29°c</option>
                                <option value="30">30°c</option>
                                <option value="31">31°c</option>
                                <option value="32">32°c</option>
                                <option value="33">33°c</option>
                                <option value="34">34°c</option>
                                <option value="35">35°c</option>
                                <option value="36">36°c</option>
                                <option value="37">37°c</option>
                                <option value="38">38°c</option>
                                <option value="39">39°c</option>
                                <option value="40">40°c</option>
                                <option value="41">41°c</option>
                                <option value="42">42°c</option>
                                <option value="43">43°c</option>
                                <option value="44">44°c</option>
                                <option value="45">45°c</option>
                                <option value="46">46°c</option>
                                <option value="47">47°c</option>
                                <option value="48">48°c</option>
                                <option value="49">49°c</option>
                                <option value="50">50°c</option>
                                <option value="51">51°c</option>
                                <option value="52">52°c</option>
                                <option value="53">53°c</option>
                                <option value="54">54°c</option>
                                <option value="55">55°c</option>
                                <option value="56">56°c</option>
                                <option value="57">57°c</option>
                                <option value="58">58°c</option>
                                <option value="59">59°c</option>
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

                                <option value="-4">-4°c</option>
                                <option value="-3">-3°c</option>
                                <option value="-2">-2°c</option>
                                <option value="-1">-1°c</option>
                                <option value="0">0°c</option>
                                <option value="1">1°c</option>
                                <option value="2">2°c</option>
                                <option value="3">3°c</option>
                                <option value="4">4°c</option>
                                <option value="5">5°c</option>
                                <option value="6">6°c</option>
                                <option value="7">7°c</option>
                                <option value="8">8°c</option>
                                <option value="9">9°c</option>
                                <option value="10">10°c</option>
                                <option value="11">11°c</option>
                                <option value="12">12°c</option>
                                <option value="13">13°c</option>
                                <option value="14">14°c</option>
                                <option value="15">15°c</option>
                                <option value="16">16°c</option>
                                <option value="17">17°c</option>
                                <option value="18">18°c</option>
                                <option value="19">19°c</option>
                                <option value="20">20°c</option>
                                <option value="21">21°c</option>
                                <option value="22">22°c</option>
                                <option value="23">23°c</option>
                                <option value="24">24°c</option>
                                <option value="25">25°c</option>
                                <option value="26">26°c</option>
                                <option value="27">27°c</option>
                                <option value="28">28°c</option>
                                <option value="29">29°c</option>
                                <option value="30">30°c</option>
                                <option value="31">31°c</option>
                                <option value="32">32°c</option>
                                <option value="33">33°c</option>
                                <option value="34">34°c</option>
                                <option value="35">35°c</option>
                                <option value="36">36°c</option>
                                <option value="37">37°c</option>
                                <option value="38">38°c</option>
                                <option value="39">39°c</option>
                                <option value="40">40°c</option>
                                <option value="41">41°c</option>
                                <option value="42">42°c</option>
                                <option value="43">43°c</option>
                                <option value="44">44°c</option>
                                <option value="45">45°c</option>
                                <option value="46">46°c</option>
                                <option value="47">47°c</option>
                                <option value="48">48°c</option>
                                <option value="49">49°c</option>
                                <option value="50">50°c</option>
                                <option value="51">51°c</option>
                                <option value="52">52°c</option>
                                <option value="53">53°c</option>
                                <option value="54">54°c</option>
                                <option value="55">55°c</option>
                                <option value="56">56°c</option>
                                <option value="57">57°c</option>
                                <option value="58">58°c</option>
                                <option value="59">59°c</option>
                                <option value="60">60°c</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 form-group">
                            <label class="pull-right" for="pass">Weather Condition</label>
                        </div>
                        <div class="col-sm-4 form-group">
                            <div class="">
                                <select id="weather_id" name="weather" class="form-control"
                                        data-validation="required"
                                        data-validation-error-msg="Select Weather Condition">
                                    <option value="">Select Weather Condition</option>
                                    <option value={{c.id}} ng-repeat="c in pu_conditions">{{c.condition}}</option>
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
                                        data-validation="required"
                                        data-validation-error-msg="Select 3 Day Weather Condition">
                                    <option value="">Select 3 Day Weather Condition</option>
                                    <option value={{c.id}} ng-repeat="c in pu_future_conditions">
                                        {{c.future_condition}}
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

        <div id="gb" class="tab-pane fade">

            <form id="weather_form_gb">
                <div class="row vert-offset-top-3">

                    <div class="col-sm-4" ></div>
                    <div class="col-sm-2 form-group">
<!--                        <label class="">Select Date</label>-->
                        <div class="">
                            <input type="text" id="datepicker_add_gb" name="magri_date" class="form-control" value=""/>
                        </div>
                    </div>
                    <div class="col-sm-2 form-group">
<!--                        <label class="" for="pass">Location</label>-->
                        <div class="">
                            <select id="loc_id_gb" name="location" class="form-control" data-validation="required"
                                    data-validation-error-msg="Select Location">
                                <option value="">Select Location</option>
                                <option value="{{loc.id}}" ng-repeat="loc in kansas_locations">{{loc.id | capitalizeWord}}
                                </option>
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
                                <select id="min_id_gb" name="minTemp" class="form-control " data-validation="required"
                                        data-validation-error-msg="Select Minimum Temperature"
                                        style="line-height: 8px;">
                                    <option value="">Select Min Temperature</option>

                                    <option value="-30">-30°c</option>
                                    <option value="-29">-29°c</option>
                                    <option value="-28">-28°c</option>
                                    <option value="-27">-27°c</option>
                                    <option value="-26">-26°c</option>
                                    <option value="-25">-25°c</option>
                                    <option value="-24">-24°c</option>
                                    <option value="-23">-23°c</option>
                                    <option value="-22">-22°c</option>
                                    <option value="-21">-21°c</option>
                                    <option value="-20">-20°c</option>
                                    <option value="-19">-19°c</option>
                                    <option value="-18">-18°c</option>
                                    <option value="-17">-17°c</option>
                                    <option value="-16">-16°c</option>
                                    <option value="-15">-15°c</option>
                                    <option value="-14">-14°c</option>
                                    <option value="-13">-13°c</option>
                                    <option value="-12">-12°c</option>
                                    <option value="-11">-11°c</option>
                                    <option value="-10">-10°c</option>
                                    <option value="-9">-9°c</option>
                                    <option value="-8">-8°c</option>
                                    <option value="-7">-7°c</option>
                                    <option value="-6">-6°c</option>
                                    <option value="-5">-5°c</option>

                                    <option value="-4">-4°c</option>
                                    <option value="-3">-3°c</option>
                                    <option value="-2">-2°c</option>
                                    <option value="-1">-1°c</option>
                                    <option value="0">0°c</option>
                                    <option value="1">1°c</option>
                                    <option value="2">2°c</option>
                                    <option value="3">3°c</option>
                                    <option value="4">4°c</option>
                                    <option value="5">5°c</option>
                                    <option value="6">6°c</option>
                                    <option value="7">7°c</option>
                                    <option value="8">8°c</option>
                                    <option value="9">9°c</option>
                                    <option value="10">10°c</option>
                                    <option value="11">11°c</option>
                                    <option value="12">12°c</option>
                                    <option value="13">13°c</option>
                                    <option value="14">14°c</option>
                                    <option value="15">15°c</option>
                                    <option value="16">16°c</option>
                                    <option value="17">17°c</option>
                                    <option value="18">18°c</option>
                                    <option value="19">19°c</option>
                                    <option value="20">20°c</option>
                                    <option value="21">21°c</option>
                                    <option value="22">22°c</option>
                                    <option value="23">23°c</option>
                                    <option value="24">24°c</option>
                                    <option value="25">25°c</option>
                                    <option value="26">26°c</option>
                                    <option value="27">27°c</option>
                                    <option value="28">28°c</option>
                                    <option value="29">29°c</option>
                                    <option value="30">30°c</option>
                                    <option value="31">31°c</option>
                                    <option value="32">32°c</option>
                                    <option value="33">33°c</option>
                                    <option value="34">34°c</option>
                                    <option value="35">35°c</option>
                                    <option value="36">36°c</option>
                                    <option value="37">37°c</option>
                                    <option value="38">38°c</option>
                                    <option value="39">39°c</option>
                                    <option value="40">40°c</option>
                                    <option value="41">41°c</option>
                                    <option value="42">42°c</option>
                                    <option value="43">43°c</option>
                                    <option value="44">44°c</option>
                                    <option value="45">45°c</option>
                                    <option value="46">46°c</option>
                                    <option value="47">47°c</option>
                                    <option value="48">48°c</option>
                                    <option value="49">49°c</option>
                                    <option value="50">50°c</option>
                                    <option value="51">51°c</option>
                                    <option value="52">52°c</option>
                                    <option value="53">53°c</option>
                                    <option value="54">54°c</option>
                                    <option value="55">55°c</option>
                                    <option value="56">56°c</option>
                                    <option value="57">57°c</option>
                                    <option value="58">58°c</option>
                                    <option value="59">59°c</option>
                                </select>
                            </div>

                            <div class="col-sm-4 form-group">
                                <label class="" for="pass">Maximum Temperature</label>
                            </div>
                            <div class="col-sm-7 form-group">
                                <select id="max_id_gb" name="maxTemp" class="form-control" data-validation="required"
                                        data-validation-error-msg="Select Maximum Temperature">
                                    <option value="">Select Max Temperature</option>

                                    <option value="-29">-29°c</option>
                                    <option value="-28">-28°c</option>
                                    <option value="-27">-27°c</option>
                                    <option value="-26">-26°c</option>
                                    <option value="-25">-25°c</option>
                                    <option value="-24">-24°c</option>
                                    <option value="-23">-23°c</option>
                                    <option value="-22">-22°c</option>
                                    <option value="-21">-21°c</option>
                                    <option value="-20">-20°c</option>
                                    <option value="-19">-19°c</option>
                                    <option value="-18">-18°c</option>
                                    <option value="-17">-17°c</option>
                                    <option value="-16">-16°c</option>
                                    <option value="-15">-15°c</option>
                                    <option value="-14">-14°c</option>
                                    <option value="-13">-13°c</option>
                                    <option value="-12">-12°c</option>
                                    <option value="-11">-11°c</option>
                                    <option value="-10">-10°c</option>
                                    <option value="-9">-9°c</option>
                                    <option value="-8">-8°c</option>
                                    <option value="-7">-7°c</option>
                                    <option value="-6">-6°c</option>
                                    <option value="-5">-5°c</option>

                                    <option value="-4">-4°c</option>
                                    <option value="-3">-3°c</option>
                                    <option value="-2">-2°c</option>
                                    <option value="-1">-1°c</option>
                                    <option value="0">0°c</option>
                                    <option value="1">1°c</option>
                                    <option value="2">2°c</option>
                                    <option value="3">3°c</option>
                                    <option value="4">4°c</option>
                                    <option value="5">5°c</option>
                                    <option value="6">6°c</option>
                                    <option value="7">7°c</option>
                                    <option value="8">8°c</option>
                                    <option value="9">9°c</option>
                                    <option value="10">10°c</option>
                                    <option value="11">11°c</option>
                                    <option value="12">12°c</option>
                                    <option value="13">13°c</option>
                                    <option value="14">14°c</option>
                                    <option value="15">15°c</option>
                                    <option value="16">16°c</option>
                                    <option value="17">17°c</option>
                                    <option value="18">18°c</option>
                                    <option value="19">19°c</option>
                                    <option value="20">20°c</option>
                                    <option value="21">21°c</option>
                                    <option value="22">22°c</option>
                                    <option value="23">23°c</option>
                                    <option value="24">24°c</option>
                                    <option value="25">25°c</option>
                                    <option value="26">26°c</option>
                                    <option value="27">27°c</option>
                                    <option value="28">28°c</option>
                                    <option value="29">29°c</option>
                                    <option value="30">30°c</option>
                                    <option value="31">31°c</option>
                                    <option value="32">32°c</option>
                                    <option value="33">33°c</option>
                                    <option value="34">34°c</option>
                                    <option value="35">35°c</option>
                                    <option value="36">36°c</option>
                                    <option value="37">37°c</option>
                                    <option value="38">38°c</option>
                                    <option value="39">39°c</option>
                                    <option value="40">40°c</option>
                                    <option value="41">41°c</option>
                                    <option value="42">42°c</option>
                                    <option value="43">43°c</option>
                                    <option value="44">44°c</option>
                                    <option value="45">45°c</option>
                                    <option value="46">46°c</option>
                                    <option value="47">47°c</option>
                                    <option value="48">48°c</option>
                                    <option value="49">49°c</option>
                                    <option value="50">50°c</option>
                                    <option value="51">51°c</option>
                                    <option value="52">52°c</option>
                                    <option value="53">53°c</option>
                                    <option value="54">54°c</option>
                                    <option value="55">55°c</option>
                                    <option value="56">56°c</option>
                                    <option value="57">57°c</option>
                                    <option value="58">58°c</option>
                                    <option value="59">59°c</option>
                                    <option value="60">60°c</option>
                                </select>
                            </div>

                            <div class="col-sm-4 form-group">
                                <label class="" for="pass">Weather Condition</label>
                            </div>
                            <div class="col-sm-7 form-group">
                                <div class="">
                                    <select id="weather_id_gb" name="weather" class="form-control"
                                            data-validation="required"
                                            data-validation-error-msg="Select Weather Condition">
                                        <option value="">Select Weather Condition</option>
                                        <option value={{c.id}} ng-repeat="c in kansas_conditions">{{c.condition}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4 form-group">
                                <label class="" for="pass">3 Day Weather Condition</label>
                            </div>
                            <div class="col-sm-7 form-group">

                                <div class="">
                                    <select id="weather_day_id_gb" name="weather_3day" class="form-control"
                                            data-validation="required"
                                            data-validation-error-msg="Select 3 Day Weather Condition">
                                        <option value="">Select 3 Day Weather Condition</option>
                                        <option value={{c.id}} ng-repeat="c in kansas_future_conditions">
                                            {{c.future_condition}}
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
                                <select id="eve_min_id" name="eve_minTemp" class="form-control"
                                        data-validation="required"
                                        data-validation-error-msg="Select Minimum Temperature">
                                    <option value="">Select Min Temperature</option>

                                    <option value="-30">-30°c</option>
                                    <option value="-29">-29°c</option>
                                    <option value="-28">-28°c</option>
                                    <option value="-27">-27°c</option>
                                    <option value="-26">-26°c</option>
                                    <option value="-25">-25°c</option>
                                    <option value="-24">-24°c</option>
                                    <option value="-23">-23°c</option>
                                    <option value="-22">-22°c</option>
                                    <option value="-21">-21°c</option>
                                    <option value="-20">-20°c</option>
                                    <option value="-19">-19°c</option>
                                    <option value="-18">-18°c</option>
                                    <option value="-17">-17°c</option>
                                    <option value="-16">-16°c</option>
                                    <option value="-15">-15°c</option>
                                    <option value="-14">-14°c</option>
                                    <option value="-13">-13°c</option>
                                    <option value="-12">-12°c</option>
                                    <option value="-11">-11°c</option>
                                    <option value="-10">-10°c</option>
                                    <option value="-9">-9°c</option>
                                    <option value="-8">-8°c</option>
                                    <option value="-7">-7°c</option>
                                    <option value="-6">-6°c</option>

                                    <option value="-5">-5°c</option>
                                    <option value="-4">-4°c</option>
                                    <option value="-3">-3°c</option>
                                    <option value="-2">-2°c</option>
                                    <option value="-1">-1°c</option>
                                    <option value="0">0°c</option>
                                    <option value="1">1°c</option>
                                    <option value="2">2°c</option>
                                    <option value="3">3°c</option>
                                    <option value="4">4°c</option>
                                    <option value="5">5°c</option>
                                    <option value="6">6°c</option>
                                    <option value="7">7°c</option>
                                    <option value="8">8°c</option>
                                    <option value="9">9°c</option>
                                    <option value="10">10°c</option>
                                    <option value="11">11°c</option>
                                    <option value="12">12°c</option>
                                    <option value="13">13°c</option>
                                    <option value="14">14°c</option>
                                    <option value="15">15°c</option>
                                    <option value="16">16°c</option>
                                    <option value="17">17°c</option>
                                    <option value="18">18°c</option>
                                    <option value="19">19°c</option>
                                    <option value="20">20°c</option>
                                    <option value="21">21°c</option>
                                    <option value="22">22°c</option>
                                    <option value="23">23°c</option>
                                    <option value="24">24°c</option>
                                    <option value="25">25°c</option>
                                    <option value="26">26°c</option>
                                    <option value="27">27°c</option>
                                    <option value="28">28°c</option>
                                    <option value="29">29°c</option>
                                    <option value="30">30°c</option>
                                    <option value="31">31°c</option>
                                    <option value="32">32°c</option>
                                    <option value="33">33°c</option>
                                    <option value="34">34°c</option>
                                    <option value="35">35°c</option>
                                    <option value="36">36°c</option>
                                    <option value="37">37°c</option>
                                    <option value="38">38°c</option>
                                    <option value="39">39°c</option>
                                    <option value="40">40°c</option>
                                    <option value="41">41°c</option>
                                    <option value="42">42°c</option>
                                    <option value="43">43°c</option>
                                    <option value="44">44°c</option>
                                    <option value="45">45°c</option>
                                    <option value="46">46°c</option>
                                    <option value="47">47°c</option>
                                    <option value="48">48°c</option>
                                    <option value="49">49°c</option>
                                    <option value="50">50°c</option>
                                    <option value="51">51°c</option>
                                    <option value="52">52°c</option>
                                    <option value="53">53°c</option>
                                    <option value="54">54°c</option>
                                    <option value="55">55°c</option>
                                    <option value="56">56°c</option>
                                    <option value="57">57°c</option>
                                    <option value="58">58°c</option>
                                    <option value="59">59°c</option>
                                </select>
                            </div>

                            <div class="col-sm-4 form-group">
                                <label class="" for="pass">Maximum Temperature</label>
                            </div>
                            <div class="col-sm-7 form-group">
                                <select id="eve_max_id" name="eve_maxTemp" class="form-control"
                                        data-validation="required"
                                        data-validation-error-msg="Select Maximum Temperature">
                                    <option value="">Select Max Temperature</option>

                                    <option value="-29">-29°c</option>
                                    <option value="-28">-28°c</option>
                                    <option value="-27">-27°c</option>
                                    <option value="-26">-26°c</option>
                                    <option value="-25">-25°c</option>
                                    <option value="-24">-24°c</option>
                                    <option value="-23">-23°c</option>
                                    <option value="-22">-22°c</option>
                                    <option value="-21">-21°c</option>
                                    <option value="-20">-20°c</option>
                                    <option value="-19">-19°c</option>
                                    <option value="-18">-18°c</option>
                                    <option value="-17">-17°c</option>
                                    <option value="-16">-16°c</option>
                                    <option value="-15">-15°c</option>
                                    <option value="-14">-14°c</option>
                                    <option value="-13">-13°c</option>
                                    <option value="-12">-12°c</option>
                                    <option value="-11">-11°c</option>
                                    <option value="-10">-10°c</option>
                                    <option value="-9">-9°c</option>
                                    <option value="-8">-8°c</option>
                                    <option value="-7">-7°c</option>
                                    <option value="-6">-6°c</option>
                                    <option value="-5">-5°c</option>

                                    <option value="-4">-4°c</option>
                                    <option value="-3">-3°c</option>
                                    <option value="-2">-2°c</option>
                                    <option value="-1">-1°c</option>
                                    <option value="0">0°c</option>
                                    <option value="1">1°c</option>
                                    <option value="2">2°c</option>
                                    <option value="3">3°c</option>
                                    <option value="4">4°c</option>
                                    <option value="5">5°c</option>
                                    <option value="6">6°c</option>
                                    <option value="7">7°c</option>
                                    <option value="8">8°c</option>
                                    <option value="9">9°c</option>
                                    <option value="10">10°c</option>
                                    <option value="11">11°c</option>
                                    <option value="12">12°c</option>
                                    <option value="13">13°c</option>
                                    <option value="14">14°c</option>
                                    <option value="15">15°c</option>
                                    <option value="16">16°c</option>
                                    <option value="17">17°c</option>
                                    <option value="18">18°c</option>
                                    <option value="19">19°c</option>
                                    <option value="20">20°c</option>
                                    <option value="21">21°c</option>
                                    <option value="22">22°c</option>
                                    <option value="23">23°c</option>
                                    <option value="24">24°c</option>
                                    <option value="25">25°c</option>
                                    <option value="26">26°c</option>
                                    <option value="27">27°c</option>
                                    <option value="28">28°c</option>
                                    <option value="29">29°c</option>
                                    <option value="30">30°c</option>
                                    <option value="31">31°c</option>
                                    <option value="32">32°c</option>
                                    <option value="33">33°c</option>
                                    <option value="34">34°c</option>
                                    <option value="35">35°c</option>
                                    <option value="36">36°c</option>
                                    <option value="37">37°c</option>
                                    <option value="38">38°c</option>
                                    <option value="39">39°c</option>
                                    <option value="40">40°c</option>
                                    <option value="41">41°c</option>
                                    <option value="42">42°c</option>
                                    <option value="43">43°c</option>
                                    <option value="44">44°c</option>
                                    <option value="45">45°c</option>
                                    <option value="46">46°c</option>
                                    <option value="47">47°c</option>
                                    <option value="48">48°c</option>
                                    <option value="49">49°c</option>
                                    <option value="50">50°c</option>
                                    <option value="51">51°c</option>
                                    <option value="52">52°c</option>
                                    <option value="53">53°c</option>
                                    <option value="54">54°c</option>
                                    <option value="55">55°c</option>
                                    <option value="56">56°c</option>
                                    <option value="57">57°c</option>
                                    <option value="58">58°c</option>
                                    <option value="59">59°c</option>
                                    <option value="60">60°c</option>
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
                                        <option value={{c.id}} ng-repeat="c in eve_conditions">{{c.eve_condition}}
                                        </option>
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
                                        <option value={{c.id}} ng-repeat="c in kansas_future_conditions">
                                            {{c.eve_future_condition}}
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

            <div class="vert-offset-top-3" >

                <form id="weather_form_florida" action="" enctype="multipart/form-data" class="form">

                    <div class="row" >
                        <div class="col-sm-4"></div>

                        <div class="col-sm-2 form-group">
                            <!--                            <label class="">Select Date</label>-->
                            <div class="">
                                <input type="text" id="datepicker_add_florida" name="magri_date" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="col-sm-2 form-group">
                            <!--                            <label class="" for="pass">Location</label>-->
                            <div class="">
                                <select id="loc_id_florida" name="location" class="form-control" data-validation="required"
                                        data-validation-error-msg="Select Location">
                                    <option value="">Select Location</option>
                                    <option value="{{loc.id}}" ng-repeat="loc in florida_locations ">{{loc.id | capitalizeWord}}
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
                            <select id="min_id_florida" name="minTemp" class="form-control " data-validation="required"
                                    data-validation-error-msg="Select Minimum Temperature" style="line-height: 8px;">
                                <option value="">Select Min Temperature</option>

                                <option value="-5">-5°c</option>
                                <option value="-4">-4°c</option>
                                <option value="-3">-3°c</option>
                                <option value="-2">-2°c</option>
                                <option value="-1">-1°c</option>
                                <option value="0">0°c</option>
                                <option value="1">1°c</option>
                                <option value="2">2°c</option>
                                <option value="3">3°c</option>
                                <option value="4">4°c</option>
                                <option value="5">5°c</option>
                                <option value="6">6°c</option>
                                <option value="7">7°c</option>
                                <option value="8">8°c</option>
                                <option value="9">9°c</option>
                                <option value="10">10°c</option>
                                <option value="11">11°c</option>
                                <option value="12">12°c</option>
                                <option value="13">13°c</option>
                                <option value="14">14°c</option>
                                <option value="15">15°c</option>
                                <option value="16">16°c</option>
                                <option value="17">17°c</option>
                                <option value="18">18°c</option>
                                <option value="19">19°c</option>
                                <option value="20">20°c</option>
                                <option value="21">21°c</option>
                                <option value="22">22°c</option>
                                <option value="23">23°c</option>
                                <option value="24">24°c</option>
                                <option value="25">25°c</option>
                                <option value="26">26°c</option>
                                <option value="27">27°c</option>
                                <option value="28">28°c</option>
                                <option value="29">29°c</option>
                                <option value="30">30°c</option>
                                <option value="31">31°c</option>
                                <option value="32">32°c</option>
                                <option value="33">33°c</option>
                                <option value="34">34°c</option>
                                <option value="35">35°c</option>
                                <option value="36">36°c</option>
                                <option value="37">37°c</option>
                                <option value="38">38°c</option>
                                <option value="39">39°c</option>
                                <option value="40">40°c</option>
                                <option value="41">41°c</option>
                                <option value="42">42°c</option>
                                <option value="43">43°c</option>
                                <option value="44">44°c</option>
                                <option value="45">45°c</option>
                                <option value="46">46°c</option>
                                <option value="47">47°c</option>
                                <option value="48">48°c</option>
                                <option value="49">49°c</option>
                                <option value="50">50°c</option>
                                <option value="51">51°c</option>
                                <option value="52">52°c</option>
                                <option value="53">53°c</option>
                                <option value="54">54°c</option>
                                <option value="55">55°c</option>
                                <option value="56">56°c</option>
                                <option value="57">57°c</option>
                                <option value="58">58°c</option>
                                <option value="59">59°c</option>
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

                                <option value="-4">-4°c</option>
                                <option value="-3">-3°c</option>
                                <option value="-2">-2°c</option>
                                <option value="-1">-1°c</option>
                                <option value="0">0°c</option>
                                <option value="1">1°c</option>
                                <option value="2">2°c</option>
                                <option value="3">3°c</option>
                                <option value="4">4°c</option>
                                <option value="5">5°c</option>
                                <option value="6">6°c</option>
                                <option value="7">7°c</option>
                                <option value="8">8°c</option>
                                <option value="9">9°c</option>
                                <option value="10">10°c</option>
                                <option value="11">11°c</option>
                                <option value="12">12°c</option>
                                <option value="13">13°c</option>
                                <option value="14">14°c</option>
                                <option value="15">15°c</option>
                                <option value="16">16°c</option>
                                <option value="17">17°c</option>
                                <option value="18">18°c</option>
                                <option value="19">19°c</option>
                                <option value="20">20°c</option>
                                <option value="21">21°c</option>
                                <option value="22">22°c</option>
                                <option value="23">23°c</option>
                                <option value="24">24°c</option>
                                <option value="25">25°c</option>
                                <option value="26">26°c</option>
                                <option value="27">27°c</option>
                                <option value="28">28°c</option>
                                <option value="29">29°c</option>
                                <option value="30">30°c</option>
                                <option value="31">31°c</option>
                                <option value="32">32°c</option>
                                <option value="33">33°c</option>
                                <option value="34">34°c</option>
                                <option value="35">35°c</option>
                                <option value="36">36°c</option>
                                <option value="37">37°c</option>
                                <option value="38">38°c</option>
                                <option value="39">39°c</option>
                                <option value="40">40°c</option>
                                <option value="41">41°c</option>
                                <option value="42">42°c</option>
                                <option value="43">43°c</option>
                                <option value="44">44°c</option>
                                <option value="45">45°c</option>
                                <option value="46">46°c</option>
                                <option value="47">47°c</option>
                                <option value="48">48°c</option>
                                <option value="49">49°c</option>
                                <option value="50">50°c</option>
                                <option value="51">51°c</option>
                                <option value="52">52°c</option>
                                <option value="53">53°c</option>
                                <option value="54">54°c</option>
                                <option value="55">55°c</option>
                                <option value="56">56°c</option>
                                <option value="57">57°c</option>
                                <option value="58">58°c</option>
                                <option value="59">59°c</option>
                                <option value="60">60°c</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 form-group">
                            <label class="pull-right" for="pass">Weather Condition</label>
                        </div>
                        <div class="col-sm-4 form-group">
                            <div class="">
                                <select id="weather_id_florida" name="weather" class="form-control"
                                        data-validation="required"
                                        data-validation-error-msg="Select Weather Condition">
                                    <option value="">Select Weather Condition</option>
                                    <option value={{c.id}} ng-repeat="c in florida_conditions">{{c.condition}}</option>
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
                                        data-validation="required"
                                        data-validation-error-msg="Select 3 Day Weather Condition">
                                    <option value="">Select 3 Day Weather Condition</option>
                                    <option value={{c.id}} ng-repeat="c in florida_future_conditions">
                                        {{c.future_condition}}
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

            <div class="vert-offset-top-3" >

                <form id="weather_form_hawaii" action="" enctype="multipart/form-data" class="form">

                    <div class="row" >
                        <div class="col-sm-4"></div>

                        <div class="col-sm-2 form-group">
                            <!--                            <label class="">Select Date</label>-->
                            <div class="">
                                <input type="text" id="datepicker_add_hawaii" name="magri_date" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="col-sm-2 form-group">
                            <!--                            <label class="" for="pass">Location</label>-->
                            <div class="">
                                <select id="loc_id_hawaii" name="location" class="form-control" data-validation="required"
                                        data-validation-error-msg="Select Location">
                                    <option value="">Select Location</option>
                                    <option value="{{loc.id}}" ng-repeat="loc in hawaii_locations ">{{loc.id | capitalizeWord}}
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
                            <select id="min_id_hawaii" name="minTemp" class="form-control " data-validation="required"
                                    data-validation-error-msg="Select Minimum Temperature" style="line-height: 8px;">
                                <option value="">Select Min Temperature</option>

                                <option value="-5">-5°c</option>
                                <option value="-4">-4°c</option>
                                <option value="-3">-3°c</option>
                                <option value="-2">-2°c</option>
                                <option value="-1">-1°c</option>
                                <option value="0">0°c</option>
                                <option value="1">1°c</option>
                                <option value="2">2°c</option>
                                <option value="3">3°c</option>
                                <option value="4">4°c</option>
                                <option value="5">5°c</option>
                                <option value="6">6°c</option>
                                <option value="7">7°c</option>
                                <option value="8">8°c</option>
                                <option value="9">9°c</option>
                                <option value="10">10°c</option>
                                <option value="11">11°c</option>
                                <option value="12">12°c</option>
                                <option value="13">13°c</option>
                                <option value="14">14°c</option>
                                <option value="15">15°c</option>
                                <option value="16">16°c</option>
                                <option value="17">17°c</option>
                                <option value="18">18°c</option>
                                <option value="19">19°c</option>
                                <option value="20">20°c</option>
                                <option value="21">21°c</option>
                                <option value="22">22°c</option>
                                <option value="23">23°c</option>
                                <option value="24">24°c</option>
                                <option value="25">25°c</option>
                                <option value="26">26°c</option>
                                <option value="27">27°c</option>
                                <option value="28">28°c</option>
                                <option value="29">29°c</option>
                                <option value="30">30°c</option>
                                <option value="31">31°c</option>
                                <option value="32">32°c</option>
                                <option value="33">33°c</option>
                                <option value="34">34°c</option>
                                <option value="35">35°c</option>
                                <option value="36">36°c</option>
                                <option value="37">37°c</option>
                                <option value="38">38°c</option>
                                <option value="39">39°c</option>
                                <option value="40">40°c</option>
                                <option value="41">41°c</option>
                                <option value="42">42°c</option>
                                <option value="43">43°c</option>
                                <option value="44">44°c</option>
                                <option value="45">45°c</option>
                                <option value="46">46°c</option>
                                <option value="47">47°c</option>
                                <option value="48">48°c</option>
                                <option value="49">49°c</option>
                                <option value="50">50°c</option>
                                <option value="51">51°c</option>
                                <option value="52">52°c</option>
                                <option value="53">53°c</option>
                                <option value="54">54°c</option>
                                <option value="55">55°c</option>
                                <option value="56">56°c</option>
                                <option value="57">57°c</option>
                                <option value="58">58°c</option>
                                <option value="59">59°c</option>
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

                                <option value="-4">-4°c</option>
                                <option value="-3">-3°c</option>
                                <option value="-2">-2°c</option>
                                <option value="-1">-1°c</option>
                                <option value="0">0°c</option>
                                <option value="1">1°c</option>
                                <option value="2">2°c</option>
                                <option value="3">3°c</option>
                                <option value="4">4°c</option>
                                <option value="5">5°c</option>
                                <option value="6">6°c</option>
                                <option value="7">7°c</option>
                                <option value="8">8°c</option>
                                <option value="9">9°c</option>
                                <option value="10">10°c</option>
                                <option value="11">11°c</option>
                                <option value="12">12°c</option>
                                <option value="13">13°c</option>
                                <option value="14">14°c</option>
                                <option value="15">15°c</option>
                                <option value="16">16°c</option>
                                <option value="17">17°c</option>
                                <option value="18">18°c</option>
                                <option value="19">19°c</option>
                                <option value="20">20°c</option>
                                <option value="21">21°c</option>
                                <option value="22">22°c</option>
                                <option value="23">23°c</option>
                                <option value="24">24°c</option>
                                <option value="25">25°c</option>
                                <option value="26">26°c</option>
                                <option value="27">27°c</option>
                                <option value="28">28°c</option>
                                <option value="29">29°c</option>
                                <option value="30">30°c</option>
                                <option value="31">31°c</option>
                                <option value="32">32°c</option>
                                <option value="33">33°c</option>
                                <option value="34">34°c</option>
                                <option value="35">35°c</option>
                                <option value="36">36°c</option>
                                <option value="37">37°c</option>
                                <option value="38">38°c</option>
                                <option value="39">39°c</option>
                                <option value="40">40°c</option>
                                <option value="41">41°c</option>
                                <option value="42">42°c</option>
                                <option value="43">43°c</option>
                                <option value="44">44°c</option>
                                <option value="45">45°c</option>
                                <option value="46">46°c</option>
                                <option value="47">47°c</option>
                                <option value="48">48°c</option>
                                <option value="49">49°c</option>
                                <option value="50">50°c</option>
                                <option value="51">51°c</option>
                                <option value="52">52°c</option>
                                <option value="53">53°c</option>
                                <option value="54">54°c</option>
                                <option value="55">55°c</option>
                                <option value="56">56°c</option>
                                <option value="57">57°c</option>
                                <option value="58">58°c</option>
                                <option value="59">59°c</option>
                                <option value="60">60°c</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 form-group">
                            <label class="pull-right" for="pass">Weather Condition</label>
                        </div>
                        <div class="col-sm-4 form-group">
                            <div class="">
                                <select id="weather_id_hawaii" name="weather" class="form-control"
                                        data-validation="required"
                                        data-validation-error-msg="Select Weather Condition">
                                    <option value="">Select Weather Condition</option>
                                    <option value={{c.id}} ng-repeat="c in hawaii_conditions">{{c.condition}}</option>
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
                                        data-validation="required"
                                        data-validation-error-msg="Select 3 Day Weather Condition">
                                    <option value="">Select 3 Day Weather Condition</option>
                                    <option value={{c.id}} ng-repeat="c in hawaii_future_conditions">
                                        {{c.future_condition}}
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

    }else  if ($("#app_src").val() == 'florida') {
        $("#pu_tab").removeClass("active");
        $("#missouri").removeClass("active");
        $("#missouri").removeClass("in");

        $("#florida_tab").addClass("active");
        $("#florida").addClass("active");
        $("#florida").addClass("in");

    }else  if ($("#app_src").val() == 'hawaii') {
        $("#pu_tab").removeClass("active");
        $("#missouri").removeClass("active");
        $("#missouri").removeClass("in");

        $("#hawaii_tab").addClass("active");
        $("#hawaii").addClass("active");
        $("#hawaii").addClass("in");

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

            var date    = $("#datepicker_add").val().split("/");

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

        $("#datepicker_add_hawaii").on('change', function (event) {

            var date    = $("#datepicker_add_hawaii").val().split("/");

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
                url        : '../service/sr_saveAWdata.php',
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

    $("#weather_form_gb").submit(function (e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.

        if (parseInt($('#min_id_gb').val()) < parseInt($('#max_id_gb').val()) && parseInt($('#eve_min_id').val()) < parseInt($('#eve_max_id').val())) {

            var date     = $('#datepicker_add_gb').val().split("/");

            var newDate  = date[2] + '-' + date[0] + '-' + date[1];
            var formdata = new FormData(this);
            formdata.append('newDate', newDate);
            formdata.append('state', 'gb');

            $.ajax({
                type       : "POST",
                url        : '../service/sr_saveAWdata.php',
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
                url        : '../service/sr_saveAWdata.php',
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
                url        : '../service/sr_saveAWdata.php',
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
