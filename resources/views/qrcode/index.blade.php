@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">二维码列表</h3>
              <a class="btn-sm btn-info" href="{{ url('admin/qRcodes/create') }}" role="button">新建二维码</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>名称</th>
                  <th>车主姓名</th>
                  <th>车主电话</th>
                  <th>微信id</th>
                  <th>操作</th>
                </tr>
                @foreach ($qrcodes as $index=>$qrcode)
                <tr>
                  <td>{{$qrcode->id}}.</td>
                  <td>{{$qrcode->name}}</td>
                  <td>{{$qrcode->type}}</td>
                  <td>{{$qrcode->media_id}}</td>
                  <td>{{$qrcode->openid}}</td>
                  <td>
                    <a href="{{url('admin/qRcodes/'.$qrcode->id)}}">
                        <i class="fa fa-book fa-2x"></i>
                    </a>
                    <a href="{{url('admin/qRcodes/'.$qrcode->id.'/edit')}}">
                        <i class="fa fa-edit  fa-2x"></i>
                    </a>
                    <a href="{{url('admin/qRcodes/'.$qrcode->id.'/download')}}">
                        <i class="fa fa-cloud-download fa-2x"></i>
                    </a>
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="col-md-12" style="text-align:center;">
              {{ $qrcodes->links() }}
            </div>
            
          </div>
          <!-- /.box -->
        </div>
    </div>
@endsection
