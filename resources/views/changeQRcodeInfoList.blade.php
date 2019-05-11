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
        @if (count($qrcodes) > 0)
        <div class=" table-responsive">
            <!-- Default panel contents -->

            <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>车主电话</th>
                  <th>自定义信息</th>
                  <th>操作</th>
                </tr>
                @foreach ($qrcodes as $index=>$qrcode)
                <tr>
                  <td>{{$index + 1}}.</td>
                  <td>{{$qrcode->media_id}}</td>
                  <td>{{$qrcode->type}}</td>
                  <td>                 
                    <a href="{{url('inputInfo/'.$qrcode->id.'?openid='.$qrcode->openid)}}">
                       修改
                    </a>
                  </td>
                </tr>
                @endforeach
              </table>
        </div>
        @else
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">已领取二维码列表</div>

            <div class="panel-body">
                <p>您尚未领取二维码</p>
            </div>
        </div>
        @endif
        </div>
    </div>
    

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
  
</body>
</html>
