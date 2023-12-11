<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>login</title>

        <!-- 外掛 -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
        <script>
            login = function(){

                account  = $('#account').val();
                password = $('#password').val();
                
                if(account==''){
                    alert("請輸入帳號");
                }

                if(password==''){
                    alert("請輸入密碼");
                }

                $.ajax({
                    methods  :'get',
                    url      : "login_index",
                    dataType : 'json',
                    data:{
                        "account"  : account,
                        "password" : password
                    },
                    success:function(data){
                       alert(data);
                    }
                })
            }
        </script>
    </head>

    <body>
        @if(isset($create) && $create=='success'):
           <script> alert('<?php echo "帳號建立成功" ?>')</script>
        @endif
        <div id="wrap" >
            <div id="page_title" class="title">
                登入
            </div>

            <label id="account_label" for="account" class="label">
                帳號:
            </label>
            <input id="account" type="text" name="account" class="account_data">
            
            <br>

            <label id="password_label" for="password" class="label">
                密碼:
            </label>
            <input id="password" type="password" name="password" class="account_data">
            
            <br>

            <div>
                <a href="create_account" style="color:yellow">
                    建立帳號
                </a>
            </div>
            
            <button onclick="login()">
                登入
            </button>
        </div>
        
    </body>
</html>
