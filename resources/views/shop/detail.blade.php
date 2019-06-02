@extends('layouts.chifengbei')

@section('css')
  <link rel="stylesheet" href="css/common/weui.min.css">
  <link rel="stylesheet" href="css/detail.css">
  <link rel="stylesheet" href="css/common/swiper.min.css">
  <link rel="stylesheet" href="css/common/weuix.css" />
@endsection
@section('content')
<div class="detailItem"></div>
@endsection

@section('script')
<script data-main="js/config" data-controller="detail/controller/detail" src="{{'js/libs/require.js'}}"></script>
@endsection