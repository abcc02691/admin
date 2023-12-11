<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>create account</title>

        <!-- 外掛 -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"></script>
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
        <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <link rel="stylesheet" href="http://jqueryui.com/resources/demos/style.css">

        <script>
            $().ready(function(){
                
                $( "#birthday" ).datepicker({
                    dateFormat: "yy-mm-dd",
                    duration: "fast"
                });
                $.datepicker.regional['zh-TW'] = {
                    clearText: '清除', clearStatus: '清除已選日期',
                    closeText: '關閉', closeStatus: '取消選擇',
                    prevText: '<上一月', prevStatus: '顯示上個月',
                    nextText: '下一月>', nextStatus: '顯示下個月',
                    currentText: '今天', currentStatus: '顯示本月',
                    monthNames: ['一月','二月','三月','四月','五月','六月',
                    '七月','八月','九月','十月','十一月','十二月'],
                    monthNamesShort: ['一','二','三','四','五','六',
                    '七','八','九','十','十一','十二'],
                    monthStatus: '選擇月份', yearStatus: '選擇年份',
                    weekHeader: '周', weekStatus: '',
                    dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
                    dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],
                    dayNamesMin: ['日','一','二','三','四','五','六'],
                    dayStatus: '設定每周第一天', dateStatus: '選擇 m月 d日, DD',
                    dateFormat: 'yy-mm-dd', firstDay: 1, 
                    initStatus: '請選擇日期', isRTL: false
                };
                $("#birthday").datepicker();
		        $.datepicker.setDefaults($.datepicker.regional['zh-TW']);

                $.validator.addMethod("valueNotEquals", function(value, element, arg){
                    return arg !== value;
                }, "Value must not equal arg.");
                
                $("#myform").validate({
                    rules: {
                        org_no: { 
                            valueNotEquals: "請選擇你的組織" 
                        },
                        account: {
                            required: true,
                            maxlength:25,
                        },
                        username: {
                            required: true,
                            maxlength:50,
                        },
                        password:{
                            required:true,
                            maxlength:25,
                        },
                        password_check:{
                            required:true,
                            maxlength:25,
                            equalTo:"#password",
                        },
                        file:{
                            required:true,
                        },
                        email: {
                            required: true,
                            maxlength:100,
                        }
                    },
                    messages:{
                        org_no: { 
                            valueNotEquals: "請選擇你的組織" 
                        },
                        account: {
                            required: "必填",
                            maxlength:"最多25碼",
                        },
                        username: {
                            required: "必填",
                            maxlength:"最多50碼",
                        },
                        password:{
                            required:"必填",
                            maxlength:"最多25碼",
                        },
                        password_check:{
                            required:"必填",
                            maxlength:"最多25碼",
                            equalTo:"請與密碼相同"
                        },
                        file:{
                            required:"必填",
                        },
                        email: {
                            required: "必填",
                            maxlength:"最多100碼",
                            email: "請輸入正確的信箱"
                        }
                    }
                });

                document.getElementById("org_no").addEventListener("change",function(){
                    if($("#org_no").val()=="建立新的組織"){
                        $("#org_page").show();
                        $("#wrap").hide();
                    }
                });
                
            });

            function create_org(){
                $.ajax({
                    method:'post',
                    url:"create_org",
                    dataType:'json',
                    data:{
                        _token  : $('meta[name="csrf-token"]').attr('content'),
                        "title" : $('#org_title').val(),
                        "org_no": $("#org_no_create").val(),
                    },
                    success:function(data){
                        alert( data );
                        if(data == '建立成功'){
                            location.reload();
                        }
                    }
                });
            }

            function cancel(){
                $("#org_no")[0].selectedIndex = 0;
                $("#wrap").show();
                $("#org_page").hide();
            }
        </script>

    </head>
    <body>
        @if(isset($create) && $create == 'error'):
           <script> alert('<?php echo "發生預期外錯誤" ?>')</script>
        @endif
        @if(isset($create) && $create == 'exist'):
           <script> alert('<?php echo "帳號已存在" ?>')</script>
        @endif
        <div id="wrap" >
            <div id="page_title" class="title">
                建立帳號
            </div>
            <?php $org=json_decode($org); ?>
            <form id="myform" action="create_user" method="POST" enctype="multipart/form-data">
                @csrf
                <div id="input_data">
                    <div id="org_no_label" for="org_no" class="label">
                        <select name="org_no" id="org_no">
                            <option>請選擇你的組織</option>
                            @foreach($org as $row):
                                <option><?php echo $row->title;?></option>
                            @endforeach
                            <option>建立新的組織</option>
                        </select>
                    </div>
                    
                    <div id="account_label" for="account" class="label">
                        <input id="account" type="text" name="account" class="account_data" placeholder="帳號">
                    </div>

                    <div id="password_label" for="password" class="label">
                        <input id="password" type="password" name="password" class="account_data"  placeholder="密碼">
                    </div>
                    <div id="password_check_label" for="password_check" class="label">
                        <input id="password_check" type="password" name="password_check" class="account_data"  placeholder="確認密碼">
                    </div>

                    <div id="username_label" for="username" class="label">
                        <input id="username" type="text" name="username" class="account_data"  placeholder="姓名">
                    </div>

                    <div id="birthday_label" for="birthday" class="label">
                        <input id="birthday" type="text" name="birthday" class="account_data"  placeholder="生日(YYYY-mm-dd)">
                    </div>

                    <div id="email_label" for="email" class="label">
                        <input id="email" type="text" name="email" class="account_data"  placeholder="email">
                    </div>
                    <div id="file_label" for="file" class="label">
                        附檔上傳:
                        <input id="file" type="file" name="file" style="color:#FFFFFF;">
                    </div>
                </div>
                
                <input type="submit" value="註冊">
            </form>
        </div>
        <div id="org_page" style="display:none">
            <div class="title">建立組織</div>
            <div class="label">
                <input id="org_title" type="text" name="org_title" class="account_data" placeholder="輸入名稱">
            </div>
            <div class="label">
                <input id="org_no_create" type="text" name="org_no_create" class="account_data" placeholder="輸入編號">
            </div>
            <br>
            <button onclick="create_org()">建立</button>
            <button onclick="cancel()">取消</button>
        </div>
    </body>
</html>
