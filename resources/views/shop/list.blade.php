@extends('layouts.chifengbei')

@section('css')
  <link rel="stylesheet" href="css/common/weui.min.css">
  <link rel="stylesheet" href="css/shop.css">
  <link rel="stylesheet" href="css/common/swiper.min.css">
  <link rel="stylesheet" href="css/common/weuix.css" />
@endsection
@section('content')
<div class="shoplist"></div>
@endsection

@section('script')
<script data-main="js/config" data-controller="shop/controller/shop" src="{{'js/libs/require.js'}}"></script>
@endsection