@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">{{trans('admin.subscribe_reply_detail')}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <td>{{$subscribe_reply->title}}</td>
                </tr>
                <tr>
                    <td>{{$subscribe_reply->created_at}}</td>
                </tr>
                <tr>
                    <td>
                        {{$subscribe_reply->content}}
                    </td>
                </tr>
              </table>
              <button type="button" class="btn btn-default btn-block"><a href="{{url('admin/subscribeReplys/'.$subscribe_reply->id.'/edit')}}">Edit</a></button>
            </div>
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-1"></div>
    </div>
@endsection
