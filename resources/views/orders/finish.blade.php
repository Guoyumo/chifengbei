@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">已完成订单</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>收货人姓名</th>
                  <th>发件人电话</th>
                  <th>收货地址</th>
                  <th>发货地址</th>
                  <th>是否加急</th>
                  <th>车型</th>
                  <th>收件人电话</th>
                   <th>时间</th>
                </tr>
                @foreach ($orders as $index=>$order)
                <tr>
                  <td>{{$index + 1}}.</td>
                  <td>{{$order->name}}</td>
                  <td>{{$order->phone}}</td>
                  <td>{{$order->finishLocation}}</td>
                  <td>{{$order->startLocation}}</td>
                  <td>{{$order->isImprotant}}</td>
                  <td>{{$order->car}}</td>
                  <td>{{$order->remark}}</td>
                  <td>{{$order->time}}</td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="col-md-12" style="text-align:center;">
              {{ $orders->links() }}
            </div>
            
          </div>
          <!-- /.box -->
        </div>
    </div>
@endsection
