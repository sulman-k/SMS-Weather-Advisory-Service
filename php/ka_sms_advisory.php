<html lang="en">
<?php
require_once ('in_header.php');
require_once ('in_footer.php');
if(!isset($_SESSION['username'])){
    header("Location :logout.php");
}
if(!in_array(validateUserRole($conn,$_SESSION['username']),$ops)){
    header("Location:logout.php");
}
userLogActivity($conn, 'ADD ADVISORY');
?>
<head>
    <script language="JavaScript" type="text/javascript">
        initengEditor();
    </script>
    <script language="JavaScript" type="text/javascript">
        function campaignButton_Insert_OnClick(id){
            var result =true;

            setMessages(id);
            return false;
            return result;
        }
        function toEntity(aa) {
            var bb='';
            for(i=0;i<aa.length;i++){
                if(aa.charCodeAt(i)>127){
                    bb +='&#'+aa.charCodeAt(i)+ ';';
                }
                else{
                    bb +=aa.charAt(i);
                }
            }
            return bb;
        }

        function setMessages(id){

            document.getElementById(id).value=toEntity(document.getElementById(id).value);
        }
        function setHexaMessages(id) {

            var ascii=$("#"+id).val();

            var formdata=new FormData($('form')[0]);
            formdata.append('value',ascii);
            console.log(ascii);

            $.ajax({
                type:"POST",
                url:' sr_convertASCII2Hexa.php',
                data:'formdata',
                datatype:'json',
                processData:false,
                contentType:false,
                cache:false,
                success: function (data) {

                    console.log('SUCCESS:'+data.hexa_value);
                    document.getElementById(id).value=data.hexa_value;
                },
                error: function(data){
                    console.log(data);
                }
            })

        }
    </script>
    <style>
        .eng{
            font-family:'eng Naskh NorthAmericatype',Tahoma;
            font-size:16px;
            unicode-bidi:embed;
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
    <form id="sms_add_frm" name="sms_add_frm">
        <div class="row ">

            <div class="col-sm-1"></div>
            <div class="col-lg-2">
                <label for="pass">Type Your SMS</label>
            </div>
            <div class="col-sm-7">
                        <textarea class="form-control sms eng" dir="rtl" id="1" style="FONT-FAMILY:eng Naskh NorthAmericatype"
                                  onkeydown="countChars(this,600)" onkeyup="countChars(this,600)"
                                  onfocus="setUR('1')"  onkeypress="processKeypresses()"maxlength="600" name="sms_adv" data-validation="required"
                                  data-validation-error-msg="Required" type="textarea" rows="4"> </textarea>
                <p id="1_len">Max Length:600 Remaining Characters are:600</p>
            </div>
            <div class="col-sm-2"></div>

        </div>
        <div class="col-sm-11">
            <button type="submit" name="sms_add_submit" id="sms_add_submit" class="btn pull-right" style="margin-right: 8.5%" >Save</button>
        </div>
        <div class="col-sm-1"></div>
    </form>
</div>
<div class="row">
    <div class="col-sm-4"></div>
    <table class="Record" cellspacing="0" cellpadding="0" id="kb_table" style="display: none">
        <tr class="Controls">
            <td colspan="4" width="30%">
                <div id="kbl">
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
            console.info('textarea'+$(this).val());
            $(this).val('');

        });

    });
</script>
<script >
    $(document).ready(function () {
        $.validate({
            modules:'security'
        });

    });
</script>
<script>
    $("#sms_add_frm").submit(function (e) {
        e.preventDefault();
        console.info('Calling submit now');
        var total_eng_elements=$('.eng').length;
        console.info('total_eng_elements'+total_eng_elements);


        var elements='';
        elements=document.getElementsByClassName('eng');

        var i=0;

        while(i<=total_eng_elements){
            if(elements[i]&& elements[i].id){
                //alert(elements[i].id);
                campaignButton_Insert_OnClick(elements[i].id);
            }
            i++;
        }

        var formdata =new FormData(this);
        $.ajax({
            type: "POST",
            url:'../service/sr_ka_save_sms_advisory.php',
            data:formdata,
            datatype:'json',
            processData:false,
            contentType:false,
            cache:false,
            success:function (data) {

                data = JSON.parse(data);

                if(data.success>0){

                    $.notify({
                            title  : '<strong>Success!</strong>',
                            message: data.msg
                        },
                        {
                            type: 'success',

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

                    //window.location='sms_advisory.php';

                    setTimeout(function(){ window.location='sms_advisory.php'; }, 1500);
                }else {
                    $.notify({
                            title  : '<strong>Warning!</strong>',
                            message: data.msg
                        },
                        {
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