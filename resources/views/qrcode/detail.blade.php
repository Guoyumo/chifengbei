@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">二维码详情</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <td>{{$qrcode->name}}</td>
                </tr>
                <tr>
                    <td>{{$qrcode->type == null ? "车主姓名" : $qrcode->type }}</td>
                </tr>
                <tr>
                    <td>{{$qrcode->media_id == null ? "车主电话" : $qrcode->media_id }}</td>
                </tr>
                <tr>
                    <td>{{$qrcode->created_at}}</td>
                </tr>
                <tr>
                    <td>
                    <img src="{{url('/qrCode/permanent_'.$qrcode->id.'.jpg')}}">
                    </td>
                </tr>
              </table>
              <button type="button" class="btn btn-default btn-block"><a href="{{url('admin/qRcodes/'.$qrcode->id.'/edit')}}">Edit</a></button>
            </div>
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-1"></div>
    </div>
@endsection
