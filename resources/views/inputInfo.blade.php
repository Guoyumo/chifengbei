<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>挪呗</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/weui.css')}}">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }

        .margin-top-10{
            margin-top:10rem;
        }
    </style>
</head>
<body id="app-layout">
    <div  class="container">
        <div class="row">
            <div class="col-xs-2"></div>
            <div class="col-xs-8">
            <form action="{{url('inputCarOwnerInfo')}}" method="POST">
            {{ csrf_field() }}
                
                <h3 class="text-center col-xs-12 margin-top-10" >车主信息登记</h3>
                <div class="form-group">
                    <label for="exampleInputPassword1">车主电话</label>
                    <input type="tel" class="form-control" id="exampleInputPassword1" placeholder="车主电话" name="carOwnerPhone">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">自定义内容</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="自定义内容" name="carOwner">
                </div>
                    <input type="hidden" name="openid" id="openid">
                <input type="hidden" name="id" value={{$id}}>
                <button type="submit" class="weui-btn weui-btn_primary col-xs-12 zx-btn-default">立即登记</button>
            </form>
            </div>
            <div class="col-xs-2"></div>
        </div>
    </div>
    

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    <script>
    $(document).ready(function(){
        function getUrlParam(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
            var r = window.location.search.substr(1).match(reg);  //匹配目标参数
            if (r != null) return unescape(r[2]); return null; //返回参数值
        }
        var openid = getUrlParam("openid");
        $('#openid').val(openid);
    })
    </script>
</body>
</html>
