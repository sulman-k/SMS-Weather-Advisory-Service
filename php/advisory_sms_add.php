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

<head>
    <script language="JavaScript" type="text/javascript">
        initengEditor();
    </script>
    <script language="JavaScript" type="text/javascript">
        //End Include Common JSFunctions

        //campaignButton_Insert_OnClick @11-60B6E2C9
        function campaignButton_Insert_OnClick(id) {
            var result = true;
//End campaignButton_Insert_OnClick

//Custom Code @39-2A29BDB7
            // -------------------------
            // Write your own code here.
            setMessages(id);
            //setHexaMessages(id);
            return false;
            // -------------------------
//End Custom Code

//Close campaignButton_Insert_OnClick @11-BC33A33A
            return result;
        }
        //End Close campaignButton_Insert_OnClick
        //End CCS script

        function toEntity(aa) {
            var bb = '';
            for (i = 0; i < aa.length; i++) {
                if (aa.charCodeAt(i) > 127) {
                    bb += '&#' + aa.charCodeAt(i) + ';';
                }
                else {
                    bb += aa.charAt(i);
                }
            }

            return bb;
        }


        function setMessages(id) {
            document.getElementById(id).value = toEntity(document.getElementById(id).value);
            //document.getElementById("ascii_txt").select();
            //return document.execCommand("copy");
        }
        function setHexaMessages(id) {

            var ascii = $("#" + id).val();

            var formdata = new FormData($('form')[0]);
            formdata.append('value', ascii);
            console.log(ascii);

            $.ajax({
                type       : "POST",
                url        : 'sr_convertASCII2Hexa.php',
                data       : formdata,
                dataType   : 'json',
                processData: false,
                contentType: false,
                cache      : false,
                success    : function (data) {

                    console.log('SUCCESS: ' + data.hexa_value);
                    document.getElementById(id).value = data.hexa_value;
                    //document.getElementById(id).select();

                },
                error      : function (data) {
                    console.log(data);
                }
            });
        }

    </script>
    <style>
        .eng {
            font-family: 'eng Naskh NorthAmericatype', Tahoma;
            font-size: 16;
            unicode-bidi: embed;
        }

        /*.style2 {*/
        /*color: #666666;*/
        /*font-weight: bold;*/
        /*}*/

        .style3 {
            color: #0000FF;
            font-weight: bold;
            font-size: 18px;
        }

        .Button {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -ms-touch-action: manipulation;
            touch-action: manipulation;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-image: none;
            border: 1px solid transparent;
            border-radius: 4px;
            color: #fff;
            background-color: #337ab7;
            border-color: #2e6da4;
            margin: 20px 0;
        }
    </style>


    <script>
        function myFunction(a) {
            alert(a.id);
        }
    </script>

</head>
<body ng-app="magriApp" ng-controller="magriCtrl" id="controler_id">

<div class="row vert-offset-top-4">

    <form id="sms_add_missouri_frm" name="sms_add_missouri_frm">
        <div class="row">
            <div class="col-sm-6">
                <div class="col-sm-1"></div>
                <div class="col-sm-2">
                    <label for="pass">Potato</label>
                </div>
                <div class="col-sm-8 ">
            <textarea class="form-control sms eng" dir="rtl" id="1" style="FONT-FAMILY: eng Naskh NorthAmericatype"
                      onfocus="setUR('1')" onkeydown="countChars(this, 200)" onkeyup="countChars(this, 200)"
                      onkeypress="processKeypresses()" maxlength="200" name="potato" data-validation="required"
                      data-validation-error-msg="Required" type="textarea" rows="4">
            </textarea>
                    <p id="1_len">Max Length: 200, Remaining Characters are: 200</p>
                </div>
            </div>
            <div class="col-sm-6">

                <div class="col-sm-2">
                    <label for="pass">Maize</label>
                </div>
                <div class="col-sm-8 ">
            <textarea class="form-control sms eng" dir="rtl" id="2" style="FONT-FAMILY: eng Naskh NorthAmericatype"
                      onfocus="setUR('2')" onkeydown="countChars(this, 200)" onkeyup="countChars(this, 200)"
                      onkeypress="processKeypresses()" maxlength="200" name="maize" data-validation="required"
                      data-validation-error-msg="Required" type="textarea"
                      rows="4"></textarea>
                    <p id="2_len">Max Length: 200, Remaining Characters are: 200</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="col-sm-1"></div>
                <div class="col-sm-2">
                    <label for="pass">Wheat</label>
                </div>
                <div class="col-sm-8 ">
            <textarea class="form-control sms eng" dir="rtl" id="3" style="FONT-FAMILY: eng Naskh NorthAmericatype"
                      onfocus="setUR('3')" onkeydown="countChars(this, 200)" onkeyup="countChars(this, 200)"
                      onkeypress="processKeypresses()" maxlength="200" name="wheat" data-validation="required"
                      data-validation-error-msg="Required" type="textarea"
                      rows="4"></textarea>
                    <p id="3_len">Max Length: 200, Remaining Characters are: 200</p>
                </div>
            </div>
            <div class="col-sm-6">

                <div class="col-sm-2">
                    <label for="pass">Sugarcane</label>
                </div>
                <div class="col-sm-8 ">
            <textarea class="form-control sms eng" dir="rtl" id="4" style="FONT-FAMILY: eng Naskh NorthAmericatype"
                      onfocus="setUR('4')" onkeydown="countChars(this, 200)" onkeyup="countChars(this, 200)"
                      onkeypress="processKeypresses()" maxlength="200" name="sugarcane" data-validation="required"
                      data-validation-error-msg="Required" type="textarea"
                      rows="4"></textarea>
                    <p id="4_len">Max Length: 200, Remaining Characters are: 200</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="col-sm-1"></div>
                <div class="col-sm-2">
                    <label for="pass">Cotton</label>
                </div>
                <div class="col-sm-8 ">
            <textarea class="form-control sms eng" dir="rtl" id="5" style="FONT-FAMILY: eng Naskh NorthAmericatype"
                      onfocus="setUR('5')" onkeydown="countChars(this, 200)" onkeyup="countChars(this, 200)"
                      onkeypress="processKeypresses()" maxlength="200" name="cotton" data-validation="required"
                      data-validation-error-msg="Required" type="textarea"
                      rows="4"></textarea>
                    <p id="5_len">Max Length: 200, Remaining Characters are: 200</p>
                </div>
            </div>
            <div class="col-sm-6">

                <div class="col-sm-2">
                    <label for="pass">Rice</label>
                </div>
                <div class="col-sm-8 ">
            <textarea class="form-control sms eng" dir="rtl" id="6" style="FONT-FAMILY: eng Naskh NorthAmericatype"
                      onfocus="setUR('6')" onkeydown="countChars(this, 200)" onkeyup="countChars(this, 200)"
                      onkeypress="processKeypresses()" maxlength="200" name="rice" data-validation="required"
                      data-validation-error-msg="Required" type="textarea"
                      rows="4"></textarea>
                    <p id="6_len">Max Length: 200, Remaining Characters are: 200</p>
                </div>
            </div>
        </div>

        <div class="row col-sm-11">
            <button type="submit" name="sms_missouri_submit" id="sms_missouri_submit" class="btn pull-right" style="margin-right: -18px">Save</button>
        </div>

    </form>

</div>

<div class="row">

    <div class="col-sm-4">

    </div>


    <table class="Record" cellspacing="0" cellpadding="0" id="kb_table" style="display: none">

        <tr class="Controls">
            <td colspan="4" width="30%">
                <div id="kb1">
                    <script language="JavaScript" type="text/javascript">
                        writeKeyboard();
                    </script>
                </div>

                <script language="JavaScript" type="text/javascript">
                    setKeymap("engPhonetic");
                </script>
            </td>
        </tr>
    </table>
</div>


</body>

<script>
    $(document).ready(function () {
        $('textarea').each(function () {
            console.info('textarea ' + $(this).val());
            $(this).val('');
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

    $("#sms_add_missouri_frm").submit(function (e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.

        console.info(' Calling submit now ');
        //var total_elements = $('.sms').length;
        var total_eng_elements = $('.eng').length;
        console.info(' total_eng_elements ' + total_eng_elements);


        var elements = '';
        elements     = document.getElementsByClassName('eng');
        console.info(' elements ' + elements);
        var i = 0;
        while (i <= total_eng_elements) {
            if (elements[i] && elements[i].id) {
                campaignButton_Insert_OnClick(elements[i].id);
            }

            i++;
        }

        var formdata = new FormData(this);

        $.ajax({
            type       : "POST",
            url        : '../service/sr_saveAdvisorySmsmissouri.php',
            data       : formdata,
            dataType   : 'json',
            processData: false,
            contentType: false,
            cache      : false,
            success    : function (data) {
                if (data.success > 0) {
                    console.log('SUCESS: ' + JSON.stringify(data));
                    window.location = 'advisory_sms_missouri.php';
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


    });
</script>

</html>