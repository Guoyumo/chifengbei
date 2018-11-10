@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">{{trans('admin.subscribe_reply_list')}}</h3>
              <a class="btn-sm btn-info"  style="display:{{$show_create}}" href="{{ url('admin/subscribeReplys/create') }}" role="button">{{trans('admin.create_subscribe_reply')}}</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <th>Name</th>
                  <th>Content</th>
                  <th>Updated Time</th>
                  <th>Action</th>
                </tr>
                @foreach ($subscribe_replys as $index=>$subscribe_reply)
                <tr>
                  <td>{{$subscribe_reply->title}}</td>
                  <td>{{$subscribe_reply->content}}</td>
                  <td>{{$subscribe_reply->updated_at}}</td>
                  <td>
                    <a href="{{url('admin/subscribeReplys/'.$subscribe_reply->id)}}">
                        <i class="fa fa-book fa-2x"></i>
                    </a>
                    <a href="{{url('admin/subscribeReplys/'.$subscribe_reply->id.'/edit')}}">
                        <i class="fa fa-edit  fa-2x"></i>
                    </a>
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
            
          </div>
          <!-- /.box -->
        </div>
    </div>
@endsection
