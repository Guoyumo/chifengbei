@extends('layouts.chifengbei')

@section('css')
  <link rel="stylesheet" href="css/common/weui.min.css">
  <link rel="stylesheet" href="css/storeList.css">
  <link rel="stylesheet" href="css/common/swiper.min.css">
  <link rel="stylesheet" href="css/common/weuix.css" />
@endsection
@section('content')
<div class="listCont"></div>
@endsection

@section('script')
<script data-main="js/config" data-controller="store/controller/storeList" src="{{'js/libs/require.js'}}"></script>
@endsection

